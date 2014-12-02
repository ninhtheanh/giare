<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

$_input_charset = 'utf-8';
$partner = $INI['alipay']['mid'];
$security_code = $INI['alipay']['sec'];
$sign_type = 'MD5';
$transport = 'http';

/* very import, this value is add by my phpframewrok */
unset($_GET['param']);  
/* end */

$alipay = new AlipayNotify($partner, $security_code, $sign_type, $_input_charset, $transport);
$verify_result = $alipay->return_verify();

$out_trade_no = $_GET['out_trade_no'];   //get the oder no.
$total_fee  = $_GET['total_fee'];      //get the total   
@list($_, $order_id, $city_id, $_) = explode('-', $out_trade_no, 4);

if ( $_ == 'charge' ) {
	if ( $verify_result ) {
		if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
			@list($_, $user_id, $create_time, $_) = explode('-', $out_trade_no, 4);
			if(ZFlow::CreateFromCharge($total_fee, $user_id, $create_time, 'alipay')){
				Session::Set('notice', "alipay recharging succeeded{$total_fee}！");
			}
		}
	}
	redirect(WEB_ROOT . '/credit/index.php');
}

if($verify_result) {
	if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
		$currency = 'CNY';
		$service =  'alipay';
		$bank = 'alipay';
		ZOrder::OnlineIt($order_id, $out_trade_no, $total_fee, $currency, $service, $bank);
		redirect( WEB_ROOT . "/order/pay.php?id={$order_id}");
	}
}

redirect( WEB_ROOT . "/order/pay.php?id={$order_id}");
