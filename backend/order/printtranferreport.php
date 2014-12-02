<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
need_manager();
need_auth('eorder');

$count = 0;$count1 = 0;
//DB::$mDebug = true;

if(isset($_POST["OrderID"])){
	$time_processing = $_POST['block'];
	$order_id_array = explode("\r\n",$_POST["OrderID"]);
	for($i=0;$i<count($order_id_array);$i++){
		$order_id[] = $order_id_array[$i];
	}
	$orderid_list = implode(", ",$order_id);
	$condition = array(
		"id IN ({$orderid_list})",
		"state IN ('packaged','transported')",
	);
	$count = Table::Count('order', $condition);
	list($pagesize, $offset, $pagestring) = pagestring($count, 100);
	$total_print = Table::Count('order', $condition, 'quantity');
	$orders = DB::LimitQuery('order', array(
		'condition' => $condition,
		'order' => 'ORDER BY id ASC',
		'size' => $pagesize,
		'offset' => $offset,
	));
	$out_id = $orders[0]['ship_id'];
	$OrderIDList = $_POST["OrderID"];
	$team_ids = Utility::GetColumn($orders, 'team_id');
	$teams = Table::Fetch('team', $team_ids);
}
if(isset($_GET['act']) && $_GET['act']=="transfer"){
	
	//$order = @$_POST['order'];
	if(isset($_GET['shipper_id'])){
		$shipper_id = (int)$_GET['shipper_id'];
	}
	$showscript = "<script type=\"text/javascript\" language=\"javascript\">$(\"#shipper_id\").val(".$shipper_id.");</script>";
	if(isset($_GET['listorderid'])){
		$list = urldecode($_GET['listorderid']);
		$order = explode(",",$list);
	}
	$order_state = DB::GetQueryResult("SELECT state FROM `order` WHERE id IN ('".$list."') AND state='transported'");
	if(!empty($order_state)){
		die('<font color=red>Danh sách đơn hàng đã chọn có đơn hàng đã bàn giao rồi. Vui lòng chọn lại danh sách để bàn giao.</font><a href="./printtranferreport.php?city_id=556">Quay về</a>');
	}
	$date_print = date("Y-m-d H:i:s",time());
	$sql = "SELECT team_id, SUM(quantity) as itemqty FROM `order` WHERE id IN (".$list.") GROUP BY team_id";
	$as = DB::GetQueryResult($sql, false);
	//Update Queue
	foreach($as as $key => $val){
		$product_id = $val['team_id'];
		$quantity = $val['itemqty'];
		$updateQty = GetQtyInQueue($product_id) - $quantity;
		if($updateQty>0){
			$sql_update = "UPDATE product_queue SET quantity = ".$updateQty.", date_modified = '".$date_print."', modified_by = '".$login_user['username']."' WHERE product_id = ".$product_id;
		}else{
			$sql_update = "DELETE FROM product_queue WHERE product_id = ".$product_id;
		}
		DB::Query($sql_update);		
	}	
	$j = 0;
	$delivery_code = 'BBT'.$loginuserid.$shipperid.date("His",time());
	$rs = array(
		'out_code' => $delivery_code,
		'creator' => $login_user_id,
		'created' => date('Y-m-d H:i:s',time()),
		'city' => $city['id'],			
		'shipper' => $shipper_id,	
	);		
	
	if(DB::Insert('ship_out', $rs)){
		$ship_out_id = mysql_insert_id();
		for($i = 0; $i<sizeof($order);$i++){
			$order_id = $order[$i];
			DB::Query("UPDATE `order` SET state='transported', delivery_time='".time()."', shipper_id='".$shipper_id ."', ship_id='".$ship_out_id."', delivery_code='".$delivery_code."',admin_id='".$login_user_id."' WHERE id=".(int)$order_id);
			
			$ship_name = DB::GetQueryResult("SELECT shipper_name FROM shipper WHERE id='".$shipper_id."'");		
			save_order_history($order_id ,'transported',$ship_name['shipper_name']);
			if(($j%5)==0){
				sleep(5);
			}
			$j++;	
		}
	}
	$OrderIDList = str_replace(",","\r\n",$list);
	if(!empty($list)){
		$condition2 = array(
			"id IN ({$list})",
			"state = 'transported'",
		);
		$count = Table::Count('order', $condition2);
		list($pagesize, $offset, $pagestring) = pagestring($count, 100);
		$total_print = Table::Count('order', $condition2, 'quantity');
		$orders = DB::LimitQuery('order', array(
			'condition' => $condition2,
			'order' => 'ORDER BY id ASC',
			'size' => $pagesize,
			'offset' => $offset,
		));
		for($i=0;$i<count($orders);$i++){	
				
			$dist = ename_dist($orders[$i]['dist_id']);
			$wardname = wardname($orders[$i]['dist_id'],$orders[$i]['ward_id']);
			$note_address = "";
			if($orders[$i]['note_address']!=''){
				$note_address = $orders[$i]['note_address'].",";	
			}
			$cus_address = rtrim($note_address.$orders[$i]['address'],",").", ".$wardname['ward_name'].", ".$dist['dist_name'];
			//ship_out_data
			$rs = array(
				'out_id' => $ship_out_id,
				'order_id' => $orders[$i]['id'],
				'deal_id' => $orders[$i]['team_id'],
				'quantity' => $orders[$i]['quantity'],			
				'amount' => $orders[$i]['origin'],	
				'state' => 'transported',
				'cus_name' => $orders[$i]['realname'],
				'cus_address' => rtrim($cus_address,","),
				'street' => $orders[$i]['street_name'],	
				'cus_phone' => $orders[$i]['mobile'],	
				'cus_notes' => trim(" ",$orders[$i]['remark']." ".$orders[$i]['remark2']),	
				'notes' => $orders[$i]['notes'],
				'dist_id' => (int)$orders[$i]['dist_id'],
				'ward_id' => (int)$orders[$i]['ward_id'],
				'city_id' => (int)$orders[$i]['city_id'],	
			);
			DB::Insert('ship_out_data', $rs);
		}	
	}
	/*// create payment table and save log ---------------------------------------------------------------------------------
	$r = DB::LimitQuery('ship_out', array('condition' => array('out_id'=>$ship_out_id)));
	//$in_code = 'I'.$login_user_id.$shipperid.date("His",time());
	$in_code = 'I'.$r[0]['out_id'];
	$rs = array(	
		'in_code' => $in_code,
		'out_id' => $ship_out_id,
		'creator' => $r[0]['creator'],
		'created' => $r[0]['created'],
		'city' => $city['id'],
		//'approver' => $login_user_id,
		//approved' => date('Y-m-d H:i:s',time()),
		'shipper' => $r[0]['shipper'],			
		'locked' => 'N',
	);	

	if(DB::Insert('ship_in', $rs))
	{
		$ship_in_id = mysql_insert_id();	
		//ship_log	
		save_ship_log($ship_out_id,$ship_in_id,'NOPTIBBT');
	}
	
	foreach($orders as $k=>$v)
	{
		switch($v['state'])
		{
			case 'pay': $orders[$k]['pays'] = $v['quantity_successful']; break;
			case 'canceled': $orders[$k]['cancels'] = $v['quantity']; break;
			case 'pending': $orders[$k]['pendings'] = $v['quantity']; break;
		}
		
	}
	$sql = "SELECT deal_id,sum(sod.quantity) as quantity ,amount/sod.quantity as price, sum(amount) as amount, SUM(IF(o.state='pay',quantity_successful,0)) AS pays FROM `ship_out_data` sod LEFT JOIN `order` o ON (sod.order_id=o.id)  WHERE out_id=".$ship_out_id." GROUP BY deal_id ;";
	$iorders = DB::GetQueryResult($sql,false);
	
	
	for($i=0;$i<count($iorders);$i++){
		//ship_in_data
		$pendings = $iorders[$i]['quantity'] - $iorders[$i]['pays'];
		$rs = array(	
			'in_id' => $ship_in_id,	
			'deal_id' => $iorders[$i]['deal_id'],
			'quantity' => $iorders[$i]['quantity'],	
			'price' => $iorders[$i]['price'],			
			'amount' => $iorders[$i]['amount'],	
			'pays' =>  $iorders[$i]['pays'],	
			'pendings' => $pendings,
		);
		DB::Insert('ship_in_data', $rs);	
	}*/
	$team_ids = Utility::GetColumn($orders, 'team_id');
	$teams = Table::Fetch('team', $team_ids);
}
function GetQtyInQueue($id){	
	$sql = "SELECT quantity FROM product_queue WHERE product_id = ".$id;
	$bs = DB::GetQueryResult($sql);
	$qty = 0;
	if(is_array($bs)){
		$qty = $bs["quantity"];
	}
	return $qty;
}
include template('manage_transfer_shipping');
?>