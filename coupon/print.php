<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_login();

$id = strval($_GET['id']);
$coupon = Table::Fetch('coupon', $id);

if (!$coupon) {
	Session::Set('error', "{$INI['system']['couponname']} doesnt exist.");
	redirect(WEB_ROOT . '/coupon/index.php');
}

if ($coupon['user_id'] != $login_user_id) { 
	Session::Set('error', "This order{$INI['system']['couponname']} is not yours");
	redirect(WEB_ROOT . '/coupon/index.php');
}

$partner = Table::Fetch('partner', $coupon['partner_id']);
$team = Table::Fetch('team', $coupon['team_id']);

$pagetitle = 'Print Coupon';
include template('coupon_print');
