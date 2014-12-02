<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('order');

$condition = array(
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
} else { $city_id = null; }

$mobile = strval($_GET['mobile']);
if ($mobile) { 
	$condition['mobile'] = $mobile;
}
/* end fiter */

if($_GET){
	$count = Table::Count('order', $condition);
	list($pagesize, $offset, $pagestring) = pagestring($count, 25);
	
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
}

include template('manage_order_search');
