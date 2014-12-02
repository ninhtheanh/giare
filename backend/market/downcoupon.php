<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

if ( $_POST ) {
	$team_id = abs(intval($_POST['team_id']));
	$consume = $_POST['consume'];
	if (!$team_id || !$consume) die('-ERR ERR_NO_DATA');
	
	$condition = array(
		'team_id' => $team_id,
		'consume' => $consume,
	);

	$coupons = DB::LimitQuery('coupon', array(
		'condition' => $condition,
	));
	if (!$coupons) die('-ERR ERR_NO_DATA');

	$users = Table::Fetch('user',Utility::GetColumn($coupons,'user_id'));
	$orders = Table::Fetch('order',Utility::GetColumn($coupons,'order_id'));

	$team = Table::Fetch('team', $team_id);
	$name = 'coupon_'.date('Ymd');
	$kn = array(
		'id' => 'No.',
		'username' => 'username',
		'secret' => 'password',
		'condbuy' => 'option',
		'date' => 'due time',
		'remark' => 'notes',
		'consume' => 'state',
		);

	$consume = array(
		'Y' => 'used',
		'N' => 'usable',
	);
	$ecoupons = array();
	foreach( $coupons AS $one ) {
		$one['id'] = "#{$one['id']}";
		$one['username'] = $users[$one['user_id']]['username'];
		$one['consume'] = $consume[$one['consume']];
		$one['condbuy'] = $orders[$one['order_id']]['condbuy'];
		$one['remark'] = $orders[$one['order_id']]['remark'];
		$one['date'] = date('Y-m-d', $one['expire_time']);
		$ecoupons[] = $one;
	}
	down_xls($ecoupons, $kn, $name);
}

include template('manage_market_downcoupon');
