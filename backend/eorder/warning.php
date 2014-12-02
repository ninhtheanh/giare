<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('order');


//update order_history set warning

$wo = DB::Query("UPDATE order_history SET is_warning=1 WHERE is_warning=0 AND expires>date AND expires<NOW()");

$cond = "WHERE state NOT IN('pay','canceled')";

$id = abs(intval($_GET['id'])); if ($id) $cond .= ' AND id='.$id;

$uemail = strval($_GET['uemail']);
if ($uemail) {
	$field = strpos($uemail, '@') ? 'email' : 'username';
	$field = is_numeric($uemail) ? 'id' : $field;
	$uuser = Table::Fetch('user', $uemail, $field);
	if($uuser) $cond .= ' AND user_id='.$uuser['id'];
	else $uemail = null;
}

$team_id = abs(intval($_GET['team_id']));
if ($team_id) {
	$cond .= ' AND team_id='.$team_id;
} else { $team_id = null; }

$city_id = abs(intval($_GET['city_id']));
if($city_id) {
	$cond .= ' AND city_id='.$city_id;
} else { $city_id = $city['id'];$cond .= ' AND city_id='.$city_id; }

$dist_id = abs(intval($_GET['dist_id']));
if ($dist_id) {
	$cond .= ' AND dist_id='.$dist_id;
} else { $dist_id = null; }

$cbday = strval($_GET['cbday']);
$ceday = strval($_GET['ceday']);

$mobile = strval($_GET['mobile']);
if ($cbday) { 
	$cbtime = strtotime($cbday);
	$cond  .= " AND create_time >= '{$cbtime}'";
}
if ($ceday) { 
	$cetime = strtotime($ceday);
	$cond .= " AND create_time <= '{$cetime}'";
}
if ($mobile) { 
	$cond .= ' AND mobile='.$mobile;
}
/* end fiter */


$scount = "SELECT count(*) as count FROM `order` AS o JOIN order_history AS h ON o.id=h.order_id AND `state`=`status_code` AND is_warning=1 $cond";

$rc = DB::GetQueryResult($scount);
$count = $rc['count'];

list($pagesize, $offset, $pagestring) = pagestring($count, 25);
//$total_voucher = Table::Count('order', $condition, 'quantity');

$squery = "SELECT o.* FROM `order` AS o JOIN order_history AS h ON o.id=h.order_id AND `state`=`status_code` AND is_warning=1 $cond ORDER BY create_time LIMIT  $offset,$pagesize";
$orders = DB::GetQueryResult($squery,false);

//echo "SELECT o.* FROM order AS o JOIN order_history AS h ON o.id=h.order_id AND state=status_code AND is_warning=1 $cond";

$pay_ids = Utility::GetColumn($orders, 'pay_id');
$pays = Table::Fetch('pay', $pay_ids);

$user_ids = Utility::GetColumn($orders, 'user_id');
$users = Table::Fetch('user', $user_ids);


$team_ids = Utility::GetColumn($orders, 'team_id');
$teams = Table::Fetch('team', $team_ids);

$order_ids = Utility::GetColumn($orders, 'id');
$order_id_list = implode(",",$order_ids);

include template('manage_order_warning');
