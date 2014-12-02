<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

if (is_post()){
	$card = $_POST;

	$card['quantity'] = abs(intval($card['quantity']));
	$card['money'] = abs(intval($card['money']));
	$card['partner_id'] = abs(intval($card['partner_id']));
	$card['begin_time'] = strtotime($card['begin_time']);
	$card['end_time'] = strtotime($card['end_time']);

	$error = array();
	if ( $card['money'] < 1 ) {
		$error[] = "the coupon value is no less than 1";
	}
	if ( $card['quantity'] < 1 || $card['quantity'] > 1000 ) {
		$error[] = "the quantity of coupon produced once should be between 1-1000 piece";
	}
	$today = strtotime(date('Y-m-d'));
	if ( $card['begin_time'] < $today ) {
		$error[] = "beginning time is no earlier than today";
	}
	elseif ( $card['end_time'] < $card['begin_time'] ) {
		$error[] = "end time is no earlier than beginning time";
	}
	if ( !$error && ZCard::CardCreate($card) ) {
		Session::Set('notice', "{$card['quantity']}pieces of coupon produced successfully");
		redirect(WEB_ROOT . '/backend/coupon/cardcreate.php');
	}
	$error = join("<br />", $error);
	Session::Set('error', $error);
}
else {
	$card = array(
		'begin_time' => time(),
		'end_time' => strtotime('+3 months'),
		'quantity' => 10,
		'money' => 10,
		'code' => date('Ymd').'_WR',
	);
}

include template('manage_coupon_cardcreate');
