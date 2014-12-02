<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
need_manager();
if($city['id']==11){
	need_auth('order');
}else{
	need_auth('eorder');
}
 if (in_array($login_user_id , $restrictarray)){
	include template('manage_order_search');
	exit();
	
 }


if (in_array($login_user_id , array($restrict ))){
	include template('manage_order_search');
	}
$t_con = array(
	'begin_time < '.time(),
	'end_time > '.time(),
);
$teams = DB::LimitQuery('team', array('condition'=>$t_con));
$t_id = Utility::GetColumn($teams, 'id');
$condition = array(
	'team_id > 0',
	"payment_id IN (3,4,5,6)",
	"state IN ('oncredit')",
);


$uemail = strval($_GET['uemail']);
if ($uemail) {
	$field = strpos($uemail, '@') ? 'email' : 'username';
	$field = is_numeric($uemail) ? 'id' : $field;
	$uuser = Table::Fetch('user', $uemail, $field);
	if($uuser) $condition['user_id'] = $uuser['id'];
	else $uemail = null;
}
$id = strval($_GET['id']); if($id)	$condition[] = "id IN ($id)";
$team_id = strval($_GET['team_id']);
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
} else { $city_id = $city['id'];$condition['city_id']=$city['id']; }


if($city_id==556){
	unset($condition['city_id']);
	$condition[] = 'city_id<>11';
}

$payment_id = abs(intval($_GET['payment_id']));
if ($payment_id) {
	$condition['payment_id'] = $payment_id;
} else { $payment_id = null;}

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
$mobile = strval($_GET['mobile']);
if ($mobile) { 
	$condition['mobile'] = $mobile;
}
/* end fiter */


$count = Table::Count('order', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 25);
$total_voucher = Table::Count('order', $condition, 'quantity');
//DB::$mDebug = true;
$orders = DB::LimitQuery('order', array(
	'condition' => $condition,
	'order' => 'ORDER BY id ASC',
	'size' => $pagesize,
	'offset' => $offset,
));

$team_ids = Utility::GetColumn($orders, 'team_id');
$teams = Table::Fetch('team', $team_ids);
//van.do=35379,lam.nguyen=87332,tuong.lam=58094,khuong.lu=162385 restrict view orders from logistic
if($city['id']==11){
	include template('manage_order_prepaid');
}else{
	include template('manage_eorder_prepaid');
} 


?>