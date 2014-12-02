<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('order');

if(isset($_POST['delivery'])){
	$team_id = abs(intval($_POST['team_id']));
	$dist_id = abs(intval($_POST['dist_id']));
	$city_id = abs(intval($_POST['city_id']));
	$shipper_id = abs(intval($_POST['shipper_id']));
	$order_list_id = implode(",",$_POST['myinput']);
	$condition = array(
		'state' => 'delivered',
		'credit = 0',
		'team_id > 0',
		'id IN ('.$order_list_id.')',
	);
	if ($dist_id) {
		$condition['dist_id'] = $dist_id;
	} else { $dist_id = null; }
	
	if($city_id) {
		$condition['city_id'] = $city_id;
	} else { $city_id = null; }
	
	/*if($shipper_id) {
		$condition['shipper_id'] = $shipper_id;
	} else { $shipper_id = null; }*/
	
	
	if($dist_id<=0 || $shipper_id<=0){
		Session::Set('error', 'Vui long chon TP - Quan/huyen - Shipper de ban giao！');
		redirect("./confirmed.php"); 
	}else{
		$dist = ename_dist($dist_id);
		$shipper = ename_shipper($shipper_id);
		$count = Table::Count('order', $condition);
		list($pagesize, $offset, $pagestring) = pagestring($count, 25);
		
		$orders = DB::LimitQuery('order', array(
			'condition' => $condition,
			'order' => 'ORDER BY pay_time DESC, id DESC',
			'size' => $pagesize,
			'offset' => $offset,
		));
		$team_ids = Utility::GetColumn($orders, 'team_id');
		$teams = Table::Fetch('team', $team_ids);
		$partner = Table::Fetch('partner', $team_ids);
		//$total_voucher = Table::Count('order', $condition, 'quantity');
		$id = explode(",",$order_list_id);
		if($login_user_id<10){
			$login_user_id = "0".$login_user_id;
		}if($shipper_id<10){
			$shipper_id = "0".$shipper_id;
		}
		$delivery_code = $login_user_id.$shipper_id.date("Hi",time());
		for($i=0;$i<count($id);$i++){
			Table::UpdateCache('order', $id[$i], array(
				'state' => 'delivered',
				'delivery_time' => time(),
				'shipper_id' => $shipper_id,
				'admin_id'=>$login_user_id,
				'delivery_code' => $delivery_code,
			));
			//save order history
			$ship_name = DB::GetQueryResult("SELECT shipper_name FROM shipper WHERE id='".$shipper_id."'");		
			save_order_history($id[$i],'delivered',$ship_name['shipper_name']);
		}
	}
	include template('manage_order_delivery_shipper');

}