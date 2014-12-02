<?php
function get_city($ip=null) {
	$cities = option_category('city', false, true);
	$ip = ($ip) ? $ip : Utility::GetRemoteIP();
	$url = "http://open.baidu.com/ipsearch/s?wd={$ip}&tn=baiduip";
	$res = mb_convert_encoding(Utility::HttpRequest($url), 'UTF-8', 'GBK');
	if ( preg_match('#From：<b>(.+)</b>#Ui', $res, $m) ) {
		foreach( $cities AS $one) {
			if ( FALSE !== strpos($m[1], $one['name']) ) {
				return $one;
			}
		}
	}
	return array();
}

function mail_zd($email) {
	global $option_mail;
	if ( ! Utility::ValidEmail($email) ) return false;
	preg_match('#@(.+)$#', $email, $m);
	$suffix = strtolower($m[1]);
	return $option_mail[$suffix];
}

function nanooption($string) {
	if ( preg_match_all('#{(.+)}#U', $string, $m) ){
		return $m[1];
	}
	return array();
}

global $striped_field;
$striped_field = array(
	'username',
	'realname',
	'name',
	'tilte',
	'email',
	'address',
	'mobile',
	'url',
	'logo',
	'contact',
);

global $option_gender;
$option_gender = array(
		'F' => 'Nữ',
		'M' => 'Nam',
		);
global $option_pay;
$option_pay = array(
		'pay' => 'paid',
		'unpay' => 'to be paid',
		);
global $option_service;
$option_service = array(
		'alipay' => 'alipay',
		'tenpay' => 'tenpay',
		'chinabank' => 'ChinaBank',
		'cash' => 'pay in cach',
		'credit' => 'pay with balance',
		'other' => 'other',
		'cashdelivery'	=>	'Tiền mặt<br />Giao hàng tận nơi',
		'cashoffice'	=>	'Tiền mặt<br />Nhận tại văn phòng',
		);
global $option_state;
$option_state = array(
		'pay' => 'Đã thanh toán',
		'unpay' => 'Mới đặt',
		'canceled' => 'Đã hủy',
		'confirmed' => 'Đã xác nhận',
		'pending' => 'Giao hàng không thành công',
		'delivered' => 'Đang giao hàng',
		'hanging' => 'Tạm hoãn',
		'pay' => 'Đã giao',
		);
global $option_delivery;
$option_delivery = array(
		'express' => 'express',
		'coupon' => 'coupon',
		'pickup' => 'self delivery',
		);
global $option_flow;
$option_flow = array(
		'buy' => 'buy',
		'invite' => 'invite',
		'store' => 'topup',
		'withdraw' => 'withdraw',
		'coupon' => 'rebate',
		'refund' => 'refund',
		'register' => 'register',
		'charge' => 'topup',
		);
global $option_mail;
$option_mail = array(
		'gmail.com' => 'https://mail.google.com/',
		'163.com' => 'http://mail.hotmail.com/',
		'yahoo.com' => 'http://mail.yahoo.com/',
		);
global $option_cond;
$option_cond = array(
		'Y' => ' successful deal decided by the number of buyers',
		'N' => ' successful deal decided by the quantity of products purchased',
		);
global $option_open;
$option_open = array(
		'Y' => 'display',
		'N' => 'display closed',
		);
global $option_buyonce;
$option_buyonce = array(
		'Y' => 'buy once',
		'N' => 'repeated buying',
		);
global $option_teamtype;
$option_teamtype = array(
		'normal' => 'Deal',
		'seconds' => 'Seconds',
		'goods' => 'Goods',
		);
global $option_yn;
$option_yn = array(
		'Y' => 'yes',
		'N' => 'no',
		);
global $option_alipayitbpay;
$option_alipayitbpay= array(
		'1h' => '1 hour',
		'2h' => '2 hours',
		'3h' => '3 hours',
		'1d' => '1 day',
		'3d' => '3 days',
		'7d' => '7 days',
		'15d' => '15 days',
		);