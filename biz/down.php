<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_partner();
$id = abs(intval($_GET['id']));

$partner_id = abs(intval($_SESSION['partner_id']));
$login_partner = Table::Fetch('partner', $partner_id);

$team = Table::Fetch('team', $id);
if($team['partner_id'] != $partner_id) {
	Session::Set('error', 'no access to the data');
	redirect( WEB_ROOT  . '/biz/index.php');
}

$condition = array(
		'state' => 'pay',
		'team_id' => $id,
		);
$orders = DB::LimitQuery('order', array(
			'condition' => $condition,
			'order' => 'ORDER BY id DESC',
			));

if (!$orders) die('-ERR ERR_NO_DATA');

if ($team['delivery'] == 'coupon') {
	$name = 'coupon_'.date('Ymd');
	$condition = array( 'team_id' => $id,);
	$coupons = DB::LimitQuery('coupon', array( 'condition' => $condition,));
	$kn = array(
			'id' => 'No.',
			'username' => 'username',
			'secret' => 'password',
			'condbuy' => 'options',
			'date' => 'due date',
			'consume' => 'status',
			);
	if (!$INI['system']['partnerdown']) unset($kn['secret']);

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
		$one['date'] = date('Y-m-d', $one['expire_time']);
		$ecoupons[] = $one;
	}
	down_xls($ecoupons, $kn, $name);
}

//delivery
$name = 'order_'.date('Ymd');
$kn = array(
		'id' => 'order No.',
		'pay_id' => 'pay id',
		'service' => 'payment',
		'price' => 'price',
		'quantity' => 'quantity',
		'fare' => 'fare',
		'origin' => 'total',
		'money' => 'money to be paid',
		'credit' => 'pay with the money in your account',
		'state' => 'payment state',
		'condbuy' => 'options',
		'remark' => 'note',
		'express' => 'express info',
		'username' => 'username',
		'useremail' => 'useremail',
		'usermobile' => 'usermobile',
		'realname' => 'realname',
		'mobile' => 'mobile',
		'zipcode' => 'zipcode',
		'address' => 'address',
		);

if (option_yes('userprivacy')) {
	unset($kn['username']);
	unset($kn['useremail']);
	unset($kn['usermobile']);
	unset($kn['money']);
	unset($kn['credit']);
}

$pay = array(
		'alipay' => 'alipay',
		'tenpay' => 'tenpay',
		'chinabank' => 'chinabank',
		'credit' => 'pay with the money in your account',
		'cash' => 'pay in cash',
		'' => 'other',
		);

$state = array(
		'unpay' => 'to be paid',
		'pay' => 'paid',
		);
$eorders = array();

$expresses = option_category('express');
$users = Table::Fetch('user', Utility::GetColumn($orders, 'user_id'));

foreach( $orders AS $one ) {
	$oneuser = $users[$one['user_id']];
	$one['username'] = $oneuser['username'];
	$one['useremail'] = $oneuser['email'];
	$one['usermobile'] = $oneuser['mobile'];
	$one['fare'] = ($one['delivery'] == 'express') ? $one['fare'] : 0;
	$one['service'] = $pay[$one['service']];
	$one['price'] = $team['market_price'];
	$one['state'] = $state[$one['state']];
	$one['express'] = ($one['express_id'] && $one['express_no']) ? 
		$expresses[$one['express_id']] . ":" . $one['express_no']
		: "";
	$eorders[] = $one;
}
down_xls($eorders, $kn, $name);
