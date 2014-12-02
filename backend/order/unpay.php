<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
require_once(dirname(__FILE__) . '/current.php');
need_manager();
need_auth('order');
 if (in_array($login_user_id , $restrictarray)){
	include template('manage_order_search');
	exit();
	
 }

	
$t_con = array(	
	'end_time < '.time(),
);
$teams = DB::LimitQuery('team', array('condition'=>$t_con));
$t_id = Utility::GetColumn($teams, 'id');

$condition = array(
	'team_id' => $t_id,
	'state' => 'unpay',
	'team_id > 0',
);

/* filter */
$uemail = strval($_GET['uemail']);
if ($uemail) {
	$field = strpos($uemail, '@') ? 'email' : 'username';
	$field = is_numeric($uemail) ? 'id' : $field;
	$uuser = Table::Fetch('user', $uemail, $field);
	if($uuser) $condition['user_id'] = $uuser['id'];
	else $uemail = null;
}
$id = abs(intval($_GET['id'])); if ($id) $condition['id'] = $id;
$team_id = abs(intval($_GET['team_id']));
if ($team_id) {
	$condition['team_id'] = $team_id;
} else { $team_id = null; }

$dist_id = abs(intval($_GET['dist_id']));
if ($dist_id) {
	$condition['dist_id'] = $dist_id;
} else { $dist_id = null; }

$city_id = abs(intval($_GET['city_id']));
if($city_id) {
	$condition['city_id'] = $city_id;
} else { $city_id = $city['id'];$condition[]="city_id IN (0,{$city['id']}"; }

if($city_id==556){
	unset($condition['city_id']);
	$condition[] = 'city_id<>11';
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
/* end filter */

$count = Table::Count('order', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);
$total_voucher = Table::Count('order', $condition, 'quantity');
$orders = DB::LimitQuery('order', array(
	'condition' => $condition,
	'order' => 'ORDER BY id ASC',
	'size' => $pagesize,
	'offset' => $offset,
));

$pay_ids = Utility::GetColumn($orders, 'pay_id');
$pays = Table::Fetch('pay', $pay_ids);

$user_ids = Utility::GetColumn($orders, 'user_id');
$users = Table::Fetch('user', $user_ids);

//define

$service=array("cashdelivery"=>"Tiền mặt<br />Giao hàng tận nơi","cashoffice"=>"Tiền mặt<br />Nhận tại văn phòng");

$team_ids = Utility::GetColumn($orders, 'team_id');
$teams = Table::Fetch('team', $team_ids);

include template('manage_order_unpay');
 
?>