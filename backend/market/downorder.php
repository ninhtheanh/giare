<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

if ( $_POST ) {
	$team_id = abs(intval($_POST['team_id']));
	$service = $_POST['service'];
	$state = $_POST['state'];
	if (!$team_id || !$service || !$state) die('-ERR ERR_NO_DATA');

	$condition = array(
			'service' => $service,
			'state' => $state,
			'team_id' => $team_id,
			);
	$orders = DB::LimitQuery('order', array(
				'condition' => $condition,
				'order' => 'ORDER BY pay_time DESC, id DESC',
				));

	if (!$orders) die('-ERR ERR_NO_DATA');
	$team = Table::Fetch('team', $team_id);
	$name = 'order_'.date('Ymd');
	$kn = array(
			'id' => 'order No.',
			'pay_id' => 'payment id',
			'service' => 'payment gateway',
			'price' => 'price',
			'quantity' => 'quantity',
			'condbuy' => 'option',
			'fare' => 'fare',
			'origin' => 'total',
			'money' => 'money paid',
			'credit' => 'pay with balance',
			'state' => 'state',
			'remark' => 'notes',
			'express' => 'express',
			'username' => 'uername',
			'useremail' => 'Email',
			'usermobile' => 'mobile',
			);

	if ( $team['delivery'] == 'express' ) {
		$kn = array_merge($kn, array(
					'realname' => 'receiver',
					'mobile' => 'mobile',
					'zipcode' => 'zipcode',
					'address' => 'address',
					));
	}
	$pay = array(
			'alipay' => 'alipay',
			'tenpay' => 'TenPay',
			'chinabank' => 'ChinaBank',
			'credit' => 'Credit',
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
}

include template('manage_market_downorder');
