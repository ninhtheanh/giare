<?php

require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
if($city['id']==11){
	need_auth('order');
}else{
	need_auth('eorder');
}

$condition = array(
	'team_id > 0',
);

//echo $enc->encrypt('@4!@#$%@', 'duyenisc@gmail.com');

/* filter */
$uemail = strval($_GET['uemail']);
if ($uemail) {
	$field = strpos($uemail, '@') ? 'email' : 'username';
	$u_email = $enc->encrypt('@4!@#$%@', $uemail);
	$field = is_numeric($uemail) ? 'id' : $field;
	$uuser = Table::Fetch('user', $u_email, $field);
	if($uuser) $condition['user_id'] = $uuser['id'];
	else $uemail = null;
}
$id = abs(intval($_GET['id'])); if ($id) $condition['id'] = $id;

$team_id = abs(intval($_GET['team_id']));
//if (in_array($login_user_id , $restrictarray)){
	//$team_id ="";
//}				
if ($team_id) {
	$condition['team_id'] = $team_id;
} else { $team_id = null; }



$dist_id = abs(intval($_GET['dist_id']));
if ($dist_id) {
	$condition['dist_id'] = $dist_id;
} else { $dist_id = null; }

$city_id = abs(intval($_GET['city_id']));
if($city_id) {
	$condition['bcity_id'] = $city_id;
} else { $city_id = $city['id'];$condition['bcity_id']=$city['id']; }

if($city_id==556){
	unset($condition['bcity_id']);
	$condition[] = 'bcity_id<>11';
}


$mobile = strval($_GET['mobile']);
if ($mobile) { 
	$condition['mobile'] = $mobile;
}
$order_group = strval($_GET['order_group']);
if ($order_group) { 
	$condition['order_group'] = $order_group;
}



$shipper_id = abs(intval($_GET['shipper_id']));
if($shipper_id) {
	$condition['shipper_id'] = $shipper_id;
} else { $shipper_id = null; }

//$state = abs(intval($_GET['state']));
//if($state) {
//	$condition['state'] = $state;
//} else { $state = null; }

//$status_code = strval($_GET['status_code']); 
//if ($status_code) $condition['status_code'] = $status_code;

$order_id = abs(intval($_GET['order_id'])); 
if ($order_id) $condition['order_id'] = $order_id;

$status_code = strval($_GET['status_code']); 
if ($status_code) $condition['status_code'] = $status_code;
else {$assign_to = null;}

$user = strval($_GET['user']);
if ($user)
$condition['user'] = $user;
else $user = null;

$state = strval($_GET['state']);
if ($state)
$condition['state'] = $state;
else $state = null;

$payment_id = abs(intval($_GET['payment_id']));
if ($payment_id) {
	$condition['payment_id'] = $payment_id;
} 
$cbday = strval($_GET['cbday']);
$ceday = strval($_GET['ceday']);
$pbday = strval($_GET['pbday']);
$peday = strval($_GET['peday']);
if ($cbday) { 
	$cbtime = strtotime($cbday);
	$condition[] = "create_time >= '{$cbtime}'";
}
if ($ceday) { 
	$cetime = strtotime($ceday);
	$condition[] = "create_time <= '{$cetime}'";
}
if ($pbday) { 
	$pbtime = strtotime($pbday);
	$condition[] = "pay_time >= '{$pbtime}'";
}
if ($peday) { 
	$petime = strtotime($peday);
	$condition[] = "pay_time <= '{$petime}'";
}
$delivery_code = strval($_GET['delivery_code']);
if ($delivery_code) { 
	$condition['ship_id'] = $delivery_code;
}
$in_id =DB::GetQueryResult("SELECT in_id FROM `ship_in` WHERE  out_id = ".$delivery_code);
/* end fiter */
//if($_GET){
	$count = Table::Count('order', $condition);
	list($pagesize, $offset, $pagestring) = pagestring($count, 60);
	$total_voucher = Table::Count('order', $condition, 'quantity');
	$orders = DB::LimitQuery('order', array(
		'condition' => $condition,
		'order' => 'ORDER BY id DESC',
		'size' => $pagesize,
		'offset' => $offset,
	));
	
	$pay_ids = Utility::GetColumn($orders, 'pay_id');
	$pays = Table::Fetch('pay', $pay_ids);
	
	$user_ids = Utility::GetColumn($orders, 'user_id');
	$users = Table::Fetch('user', $user_ids);
	
	$team_ids = Utility::GetColumn($orders, 'team_id');
	$teams = Table::Fetch('team', $team_ids);
	
	/*$orders_all = DB::LimitQuery('order', array(
		'condition' => $condition,
		'order' => 'ORDER BY delivery_time DESC, id DESC',
	));*/
	//var_dump($orders_all);
	$order_ids = Utility::GetColumn($orders, 'id');
	$order_id_list = implode(",",$order_ids);
//}
if($city['id']==11){
	include template('manage_order_search');
}else{
	include template('manage_eorder_search');
}
