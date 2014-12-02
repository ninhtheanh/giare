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
		"state = 'printeditem'",
	);
	$count = Table::Count('order', $condition);
	list($pagesize, $offset, $pagestring) = pagestring($count, 100);
	$total_print = Table::Count('order', $condition, 'quantity');
	if($count==0){
		$condition1 = array(
			"id IN ({$orderid_list})",
			"state = 'packaged'",
		);
		$count1 = Table::Count('order', $condition1);
		list($pagesize, $offset, $pagestring) = pagestring($count1, 25);
		$total_print = Table::Count('order', $condition1, 'quantity');
		$orders = DB::LimitQuery('order', array(
			'condition' => $condition1,
			'order' => 'ORDER BY id ASC',
			'size' => $pagesize,
			'offset' => $offset,
		));
		if($count1==0){
			$message = "<img src=\"/static/img/icon-warning.gif\" align=\"absmiddle\"> Đơn hàng <font style=\"color:#0000ff; font-size:13px\"><b>{$orderid_list}</b></font> không thể đóng gói hoặc đã được đóng gói. Vui lòng kiểm tra lại trạng thái...";	
		}
	}else{
		
		$orders = DB::LimitQuery('order', array(
			'condition' => $condition,
			'order' => 'ORDER BY id ASC',
			'size' => $pagesize,
			'offset' => $offset,
		));
	}
	$OrderIDList = $_POST["OrderID"];
	$team_ids = Utility::GetColumn($orders, 'team_id');
	$teams = Table::Fetch('team', $team_ids);
}
if(isset($_POST['act']) && $_POST['act']=="package"){
	$order = @$_POST['myinput'];
	$listorderid = array();
	$j=0;
	foreach($order as $key => $val){
		DB::Query("UPDATE `order` SET state='packaged' WHERE id=".(int)$val);
		$listorderid[]=(int)$val;
		if(($j%5)==0){
			sleep(5);
		}
		$j++;
	}
	$list_id = implode(", ",$listorderid);
	$OrderIDList = implode("\r\n",$listorderid);
	if(!empty($list_id)){
		$condition2 = array(
			"id IN ({$list_id})",
			"state = 'packaged'",
		);
		$count = Table::Count('order', $condition2);
		list($pagesize, $offset, $pagestring) = pagestring($count, 25);
		$total_print = Table::Count('order', $condition2, 'quantity');
		$orders = DB::LimitQuery('order', array(
			'condition' => $condition2,
			'order' => 'ORDER BY id ASC',
			'size' => $pagesize,
			'offset' => $offset,
		));
		$list_order_id = array();
	}
	$team_ids = Utility::GetColumn($orders, 'team_id');
	$teams = Table::Fetch('team', $team_ids);
}

include template('manage_scan_package');
?>