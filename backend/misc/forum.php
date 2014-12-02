<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('misc');

/*$t_con = array(
	'begin_time < '.time(),
	'end_time > '.time(),
);
$teams = DB::LimitQuery('topic', array('condition'=>$t_con));
$t_id = Utility::GetColumn($teams, 'id');*/


/* filter */
$uemail = strval($_GET['uemail']);
if ($uemail) {
	$field = strpos($uemail, '@') ? 'email' : 'username';
	$field = is_numeric($uemail) ? 'id' : $field;
	$uuser = Table::Fetch('user', $uemail, $field);
	if($uuser) $condition['user_id'] = $uuser['id'];
	else $uemail = null;
}

$content = $_GET['content'];
if ($content) {
	$condition['content'] = array("LIKE"=>"%$content%");	
}

$id = abs(intval($_GET['id'])); if ($id) $condition['id'] = $id;

$team_id = abs(intval($_GET['team_id']));
if ($team_id) {
	$condition['team_id'] = $team_id;
} else { $team_id = null; }


$city_id = abs(intval($_GET['city_id']));
if($city_id) {
	$condition['city_id'] = $city_id;
} else { $city_id = null; }

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
/* end fiter */
$condition['city_id'] = $login_user['city_id'];
$count = Table::Count('topic', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 100);

$orders = DB::LimitQuery('topic', array(
	//'condition' => $condition,
	'order' => 'ORDER BY create_time DESC',
	'size' => $pagesize,
	'offset' => $offset,
));


$user_ids = Utility::GetColumn($orders, 'user_id');
$users = Table::Fetch('user', $user_ids);

$team_ids = Utility::GetColumn($orders, 'team_id');
$teams = Table::Fetch('team', $team_ids);

$city_ids = Utility::GetColumn($orders, 'city_id');
$cities = Table::Fetch('category', $city_ids);

include template('manage_misc_forum');
