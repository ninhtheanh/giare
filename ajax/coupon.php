<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$action = strval($_GET['action']);
$cid = strval($_GET['id']);
$sec = strval($_GET['secret']);

if ($action == 'dialog') {
	$html = render('ajax_dialog_coupon');
	json($html, 'dialog');
}
else if($action == 'query') {
	$coupon = Table::FetchForce('coupon', $cid);
	$partner = Table::Fetch('partner', $coupon['partner_id']);
	$team = Table::Fetch('team', $coupon['team_id']);
	$e = date('Y-m-d', $team['expire_time']);

	if (!$coupon) { 
		$v[] = "#{$cid}&nbsp;Invalid";
	} else if ( $coupon['consume'] == 'Y' ) {
		$v[] = $INI['system']['couponname'] . 'Invalid';
		$v[] = 'Consumption on:' . date('Y-m-d H:i:s', $coupon['consume_time']);
	} else if ( $coupon['expire_time'] < strtotime(date('Y-m-d')) ) {
		$v[] = "#{$cid}&nbsp;Expired";
		$v[] = 'Expiration Date:' . date('Y-m-d', $coupon['expire_time']);
	} else {
		$v[] = "#{$cid}&nbsp;Effective";
		$v[] = "{$team['title']}";
		$v[] = "Valid until&nbsp;{$e}";
	}
	$v = join('<br/>', $v);
	$d = array(
			'html' => $v,
			'id' => 'coupon-dialog-display-id',
			);
	json($d, 'updater');
}

else if($action == 'consume') {
	$coupon = Table::FetchForce('coupon', $cid);
	$partner = Table::Fetch('partner', $coupon['partner_id']);
	$team = Table::Fetch('team', $coupon['team_id']);

	if (!$coupon) {
		$v[] = "#{$cid}&nbsp;Invalid";
		$v[] = 'Consumption Failed!';
	}
	else if ($coupon['secret']!=$sec) {
		$v[] = $INI['system']['couponname'] . 'Password is Incorrect';
		$v[] = 'Consumption Failed!';
	} else if ( $coupon['expire_time'] < strtotime(date('Y-m-d')) ) {
		$v[] = "#{$cid}&nbsp;Expired";
		$v[] = 'Expiration：' . date('Y-m-d', $coupon['consume_time']);
		$v[] = 'Consumption Failed!';
	} else if ( $coupon['consume'] == 'Y' ) {
		$v[] = "#{$cid}&nbsp;Already Consumed!";
		$v[] = 'Consumption on:' . date('Y-m-d H:i:s', $coupon['consume_time']);
		$v[] = 'Consumption Failed!';
	} else {
		ZCoupon::Consume($coupon);
		//credit to user'money'
		$tip = ($coupon['credit']>0) ? " Rebate:{$coupon['credit']}$" : '';
		$v[] = $INI['system']['couponname'] . 'Effective';
		$v[] = 'Coupon Life:' . date('Y-m-d H:i:s', time());
		$v[] = 'Coupon Consumed' . $tip;
	}
	$v = join('<br/>', $v);
	$d = array(
			'html' => $v,
			'id' => 'coupon-dialog-display-id',
			);
	json($d, 'updater');
}
else if ($action == 'sms') {
	$coupon = Table::Fetch('coupon', $cid);
	if ( $coupon['sms']>=5 && !is_manager() ) { 
		json('SMS Coupon up to 5 times', 'alert'); 
	}
	$interval = abs(intval($INI['sms']['interval']));
	$lefttime = $interval + $coupon['sms_time'] - time();
	if ( !is_manager() && $lefttime>0 ) {
		json("Hello,{$lefttime} Seconds Left, try again to send SMS coupons", 'alert');
	}
	if (!$coupon||!is_login()||($coupon['user_id']!= ZLogin::GetLoginId()&&!is_manager())) {
		json('Illegal downloading', 'alert');
	}
	$flag = sms_coupon($coupon);
	if ( $flag === true ) {
		json('SMS Successfully Sent, Please check!', 'alert');
	} else if ( is_string($flag) ) {
		json($flag, 'alert');
	}
	json("SMS Sending Failed, Error code：{$code}", 'alert');
}
