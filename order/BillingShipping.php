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
$payment_list = PaymentMethod($order['user_id'], $order['id']);
$shipping_list = ShippingMethod($order['user_id'], $order['id']);
if(isset($_POST['methods'])){		
	$methods = @$_POST['methods'];
	if((int)@$methods['payment']==0 || (int)@$methods['shipping']==0){
		Session::Set('notice', 'Vui long kiem tra lai phuong thuc thanh toan va van chuyen hoac bao voi nguoi quan tri ve loi nay!');
		redirect(WEB_ROOT."/order/BillingShipping.php?id={$id}");
	}else{
		$methods_payment = explode("-",$methods['payment']);
		$methods_shipping = explode("-",$methods['shipping']);
		//var_dump($methods_shipping);exit;
		if($methods_shipping[0]==3){
			$service = "cashoffice";	
		}else{
			$service = "cashdelivery";
		}
		$sql = "UPDATE `order` SET payment_id=".$methods_payment[0].", shipping_id=".$methods_shipping[0].", payment_cost='".$methods_payment[1]."', shipping_cost='".$methods_shipping[1]."', remark='".add_input($methods['remark'])."', remark2='".add_input($methods['remark2'])."', service='".$service."' WHERE id='".$id."' AND user_id='".$order['user_id']."'";

		DB::Query($sql);
		redirect( WEB_ROOT . "/order/ReviewOrder.php?id={$id}");
		exit();
	}
}
if ( $order['state'] == 'unpay' ) {
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
	die(include template('order_billing_shipping'));
}


redirect( WEB_ROOT . "/order/index.php");