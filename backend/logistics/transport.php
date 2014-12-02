<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
need_manager();
need_auth('admin');
if(isset($_GET['shippingid'])){
	$shipping_id = (int)$_GET['shippingid'];
	$sql = "SELECT condition_value, shipping_name FROM shippings WHERE shipping_id={$shipping_id}";
	$as = DB::GetQueryResult($sql);
	$condition_value = $as['condition_value'];
	$shipping_name = $as['shipping_name'];
	$conditionlist = ShippingCondition($condition_value);
	$destination_list = LoadDestination(0);
	$sql = "SELECT * FROM shipping_rates WHERE shipping_id={$shipping_id}";
	$vs = DB::GetQueryResult($sql,false);
	if($condition_value=="subtotal"){
		include template('logistics/manage_transport_detail');
	}else{
		include template('logistics/manage_transport_detail_weight');
	}
	
	if(isset($_POST['shippingrate'])){
		$shippingrate = $_POST['shippingrate'];
		if(@$_POST['act']=='add' && $shippingrate['rate_value']!=""){
			$sql = "INSERT INTO shipping_rates(rate_value, destination_id, subtotal, total_weight_from, total_weight_to, shipping_id, rate_type) VALUES('".(float)($shippingrate['rate_value'])."','".(int)($shippingrate['destination'])."','".(float)($shippingrate['subtotal'])."','".(float)($shippingrate['total_weight_from'])."', '".(float)($shippingrate['total_weight_to'])."', ".(int)$shipping_id.",'".$shippingrate['rate_type']."')";
			DB::Query($sql);
			redirect( WEB_ROOT . '/backend/logistics/transport.php?shippingid='.$shipping_id);
		}elseif(@$_POST['act']=="update"){			
			foreach($shippingrate as $key => $val){
				if(@$val['rate_id']==$key){
					DB::Query("UPDATE {$_config['tblprefix']}shipping_rates SET rate_value='".(float)($val['rate_value'])."', destination_id='".(int)($val['destination'])."', subtotal='".(float)$val['subtotal']."', total_weight_from = '".(float)@$val['total_weight_from']."', total_weight_to = '".(float)@$val['total_weight_to']."', rate_type='".$val['rate_type']."' WHERE rate_id = $key");
				}
			}
			redirect( WEB_ROOT . '/backend/logistics/transport.php?shippingid='.$shipping_id);
		}elseif(@$_POST['act']=="dodelete"){
			foreach($shippingrate as $key => $val){				
				if($val['rate_id']==$key){
					DB::Query("DELETE FROM {$_config['tblprefix']}shipping_rates WHERE rate_id = $key");
				}				
			}
			redirect( WEB_ROOT . '/backend/logistics/transport.php?shippingid='.$shipping_id);
		}
	}
	
	
}else{
	if(isset($_POST['shippinglist'])){
		$shippinglist = $_POST['shippinglist'];
		if(@$_POST['act']=='add' && $shippinglist['shipping_name']!=""){
			DB::Query("INSERT INTO shippings(shipping_name, delivery_time, condition_value, position, status) VALUES('".add_input($shippinglist['shipping_name'])."','".add_input($shippinglist['delivery_time'])."','".@$shippinglist['condition_value']."','".(int)$shippinglist['position']."','".$shippinglist['status']."')");
			redirect( WEB_ROOT . '/backend/logistics/transport.php');
		}elseif(@$_POST['act']=="update"){			
			foreach($shippinglist as $key => $val){
				if($val['shipping_id']==$key){
					DB::Query("UPDATE shippings SET shipping_name='".add_input($val['shipping_name'])."', delivery_time='".add_input($val['delivery_time'])."', condition_value='".@$val['condition_value']."', position = '".(int)@$val['position']."', status='".@$val['status']."' WHERE shipping_id = $key");
				}
			}
			redirect( WEB_ROOT . '/backend/logistics/transport.php');
		}elseif(@$_POST['act']=="dodelete"){
			foreach($shippinglist as $key => $val){				
				if($val['shipping_id']==$key){
					DB::Query("DELETE FROM shippings WHERE shipping_id = {$key}");
					DB::Query("DELETE FROM shipping_rate WHERE shipping_id = {$key}");
				}				
			}
			redirect( WEB_ROOT . '/backend/logistics/transport.php');
		}
	}

	$condition_list = ShippingCondition();
	$str = DB::LimitQuery('shippings', array(
		'order' => 'ORDER BY position ASC',
		'size' => $pagesize,
		'offset' => $offset,
	));
	include template('logistics/manage_transport_list');
}