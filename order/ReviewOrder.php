<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
require_once(dirname(__FILE__) . '/paybank.php');
$id = abs(intval($_GET['id']));
$order = Table::Fetch('order', $id);
if (!$order) { 
	Session::Set('error', 'Đơn hàng không tồn tại');
	redirect( WEB_ROOT . '/index.php' );
}
if ( $order['user_id'] != $login_user['id']) {
	redirect( WEB_ROOT . "/team.php?id={$order['team_id']}");
}
$team = Table::Fetch('team', $order['team_id']);
$team['state'] = team_state($team);
if ( $team['close_time'] ) {
	redirect( WEB_ROOT . "/team.php?id={$id}");
}
Session::Set('qty', 1);

$_config_payment_online = array(5);
$_config_receiver = "anhtranit@gmail.com";

if ( $order['state'] == 'unpay' ) {
	if(in_array($order['payment_id'],$_config_payment_online)){
		require_once(dirname(__FILE__) . '/nganluong/nganluong.php');
		/*require_once(dirname(__FILE__) . '/nganluong/config.php');
		require_once(dirname(__FILE__) . '/nganluong/include/lib/nusoap.php');
		require_once(dirname(__FILE__) . '/nganluong/include/nganluong.microcheckout.class.php');
		$return_url = "http://dev.dealsoc.vn/order/pay.php?id=".$order['id'];//địa chỉ trang nhận kết quả thanh toán thành công (VD: http://napthe.vn/nganluong_dg/payment_success.php)
		$cancel_url = "http://dev.dealsoc.vn/order/pay_error.php?id=".$order['id'];//địa chỉ trang nhận kết quả thanh toán thất bại (VD: http://napthe.vn/nganluong_dg/payment_cancel.php)
	
		if($order['origin']>$login_user['money']){
			$total = $order['origin']-$login_user['money']+$order['payment_cost']+$order['shipping_cost'];
		}else{
			$total = $order['origin']+$order['payment_cost']+$order['shipping_cost'];
		}
		$items = array();
		$items[0] = array(
			'item_name'		=> $team['short_title'],
			'item_quanty'	=> $order['quantity'],
			'item_amount'	=> $order['price']
		);
		$inputs = array(
			'receiver'					=> RECEIVER, // email chính tài khoản nhận tiền (tài khoản người bán)
			'order_code'				=> $order['id'].'-'.date('His-dmY'), // mã đơn hàng
			'amount'					=> $total, // tổng số tiền thanh toán đơn hàng (đã bao gồm: thuế + phí vận chuyển - số tiền giảm giá) 
			'currency_code'				=> 'vnd', // loại đơn vị tiền tệ (vnd hoặc usd)
			'tax_amount'				=> '0', // thuế đơn hàng
			'discount_amount'			=> '0', // số tiền giảm giá
			'fee_shipping'				=> '0', // phí vận chuyển
			'request_confirm_shipping'	=> '0', // giá trị mặc định luôn = 0
			'no_shipping'				=> '1', // giá trị mặc định luôn = 1
			'return_url'				=> $return_url, // địa chỉ trang nhận kết quả thanh toán thành công
			'cancel_url'				=> $cancel_url, // địa chỉ trang nhận kết quả thanh toán thất bại
			'language'					=> 'vn', // ngôn ngữ hiển thị trên trang
			'items'						=> $items // thông tin các sản phẩm
		);

		$link_checkout = '';
		$obj = new NL_MicroCheckout(MERCHANT_ID, MERCHANT_PASS, URL_WS);
		$result = $obj->setExpressCheckoutPayment($inputs);

		if ($result != false) {
			if ($result['result_code'] == '00') {
				$link_checkout = $result['link_checkout'];
			} else {
				die('Mã lỗi '.$result['result_code'].' ('.$result['result_description'].') ');
			}
		} else {
			die('Lỗi kết nối tới cổng thanh toán Ngân Lượng');
		}*/
		
		$nl = new NL_Checkout();
		$return_url = "http://www.cheapdeal.vn/order/pay.php?id=".$order['id'];
		$transaction_info = "";
		$receiver = $_config_receiver;
		if($order['origin']>$login_user['money']){
			$total = $order['origin']-$login_user['money']+$order['payment_cost']+$order['shipping_cost'];
		}else{
			$total = $order['origin']+$order['payment_cost']+$order['shipping_cost'];
		}
		$nl_url = $nl->buildCheckoutUrl($return_url, $receiver, $transaction_info, $order['id'], $total);

		//DB::Query("UPDATE order SET state = 11 WHERE order_id={$order_id} AND user_id = {$uid}");
		$button = "<input type=\"button\" value=\"Thanh toán qua ngân lượng\" style=\"padding:7px\" class=\"formbutton\" onclick=\"location.href='{$nl_url}'\" />";
		
		//$button = "<input type=\"button\" value=\"Thanh toán qua ngân lượng\" class=\"formbutton\" id=\"btn_payment\" />";
	}else{
		$button = "<input type=\"submit\" value=\"Xác nhận, đặt mua\" style=\"padding:7px\" class=\"formbutton\" />";
	}
	
	if(empty($order['service'])){
		$ordercheck['cashdelivery'] = 'checked';
	}else{
		$service = $order['service'];
		$ordercheck[$service] = 'checked';
	}
	$credityes = ($login_user['money'] >= $order['origin']);
	$creditonly = ($team['team_type'] == 'seconds' && option_yes('creditseconds'));
	/* generator unique pay_id */
	if (! ($order['pay_id'] && (preg_match('#-(\d+)-(\d+)-#', $order['pay_id'], $m) && ( $m[1] == $order['id'] && $m[2] == $order['quantity']) ))) {
		$randid = rand(1000,9999);
		$pay_id = "go-{$order['id']}-{$order['quantity']}-{$randid}";
		Table::UpdateCache('order', $order['id'], array(
			'pay_id' => $pay_id,
		));
	}
	
	die(include template('order_review'));
}


redirect( WEB_ROOT . "/order/index.php");