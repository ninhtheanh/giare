<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

//at set city id
/*  if($_GET['city_id'] == '')
{
	echo '4432';
}  */

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
//DB::$mDebug=true;

$t_con = array(
	'begin_time < '.time(),
	//'end_time > '.time(),
);
$teams = DB::LimitQuery('team', array('condition'=>$t_con));
$t_id = Utility::GetColumn($teams, 'id');

if($_GET['city_id']==556){
	$condition = array(
//		'team_id' => $t_id,
		'team_id > 0',
		"state IN ('unpay','calling')",
	);
}else{
	$condition = array(
//		'team_id' => $t_id,
		'team_id > 0',
		'state' => 'unpay',
	);	
}


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
if ($team_id && in_array($team_id, $t_id)) {
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
} else {  $payment_id = null;//$condition[] = 'payment_id!=3';
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
$mobile = strval($_GET['mobile']);
if ($mobile) { 
	$condition['mobile'] = $mobile;
}
/* end fiter */

//print_r($condition);
 
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

$pay_ids = Utility::GetColumn($orders, 'pay_id');
$pays = Table::Fetch('pay', $pay_ids);

$user_ids = Utility::GetColumn($orders, 'user_id');
$users = Table::Fetch('user', $user_ids);

$team_ids = Utility::GetColumn($orders, 'team_id');
$teams = Table::Fetch('team', $team_ids);
//van.do=35379,lam.nguyen=87332,tuong.lam=58094,khuong.lu=162385
 //$login_user_id = ZLogin::GetLoginId();

 
if($city['id']==11){
	include template('manage_order_index');
}else{
	include template('manage_eorder_index');
}
