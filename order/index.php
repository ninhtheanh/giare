<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
//DB::$mDebug=true;
need_login();
$condition = array( 'user_id' => $login_user_id, 'team_id > 0', );
$selector = strval($_GET['s']);

if ( $selector == 'index' ) {
	$pagetitle = 'Đơn hàng của tôi';
}
else if ( $selector == 'unpay' ) {
	$pagetitle = 'Đơn hàng chưa thanh toán';
	$condition['state'] = 'unpay';
}
else if ( $selector == 'pay' ) {
	$pagetitle = 'Đơn hàng đã thanh toán';
	$condition['state'] = 'pay';
}

$count = Table::Count('order', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 30);
$orders = DB::LimitQuery('order', array(
	'condition' => $condition,
	'order' => 'ORDER BY id DESC, team_id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));

$team_ids = Utility::GetColumn($orders, 'team_id');
$teams = Table::Fetch('team', $team_ids);
foreach($teams AS $tid=>$one){
	team_state($one);
	$teams[$tid] = $one;
}
include template('order_index');
