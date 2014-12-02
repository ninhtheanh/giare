<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
need_manager();
need_auth('admin');
if(isset($_POST['paymentlist'])){
	$paymentlist = $_POST['paymentlist'];
	if(@$_POST['act']=='add' && $paymentlist['payment_name']!=""){
		DB::Query("INSERT INTO payment_descriptions(payment, description, payment_type, adding_cost, adding_type, position, status) VALUES('".add_input($paymentlist['payment_name'])."','".add_input($paymentlist['description'])."','".@$paymentlist['payment_type']."','".(float)$paymentlist['adding_cost']."','".@$paymentlist['adding_type']."','".(int)$paymentlist['position']."','".$paymentlist['status']."')");
		redirect( WEB_ROOT . '/backend/logistics/payment.php');
	}elseif(@$_POST['act']=="update"){
	
		foreach($paymentlist as $key => $val){
			if($val['payment_id']==$key){
				if(@$val['destination']!=""){
					$destination = "'".@implode(",",@$val['destination'])."'";
					$dest = ",destination = $destination";
				}else $dest = "";
				
				DB::Query("UPDATE payment_descriptions SET payment='".add_input($val['payment_name'])."', description='".add_input($val['description'])."', payment_type='".@$val['payment_type']."', position = '".(int)@$val['position']."',adding_cost='".(float)@$val['adding_cost']."', adding_type='".@$val['adding_type']."', status='".@$val['status']."' {$dest} WHERE payment_id = $key");
			}
		}
		redirect( WEB_ROOT . '/backend/logistics/payment.php');
	}elseif(@$_POST['act']=="dodelete"){
		
	//	print_r($paymentlist );
		
	//	exit();
		foreach($paymentlist as $key => $val){
		
			if($val['payment_id']==$key){
				
			//	$_conn->query("DELETE FROM payment_descriptions WHERE payment_id = $key");
				DB::Query("DELETE FROM payment_descriptions WHERE payment_id = $key");
			}				
		}
		redirect( WEB_ROOT . '/backend/logistics/payment.php');
	}
}else{
	$condition_list = ShippingCondition();
	$str = DB::LimitQuery('payment_descriptions', array(
		'order' => 'ORDER BY position ASC',
		'size' => $pagesize,
		'offset' => $offset,
	));
	include template('logistics/manage_payment_list');
}