<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
require_once(dirname(__FILE__) . '/paybank.php');

need_login();

$_config_payment_online = array(5);


if (is_post()) {
	$order_id = abs(intval($_POST['order_id']));
} else {
	/*if ( $_GET['id'] == 'charge' ) {
		redirect( WEB_ROOT. '/credit/index.php');
	}*/
	$order_id = $id = abs(intval($_GET['id']));
}
if(!$order_id || !($order = Table::Fetch('order', $order_id))) {
	redirect( WEB_ROOT. '/index.php');
}

if ( $order['user_id'] != $login_user['id']) {
	redirect( WEB_ROOT . "/team.php?id={$order['team_id']}");
}

$team = Table::Fetch('team', $order['team_id']);
team_state($team);

if (is_post() && $_POST['paytype'] ) {
	$uarray = array( 'service' => pay_getservice($_POST['paytype']) );
	Table::UpdateCache('order', $order_id, $uarray);
	$order = Table::Fetch('order', $order_id);
	$order['service'] = pay_getservice($_POST['paytype']);
}

if ( $_POST['paytype']!='credit' 
		&& $_POST['service']!='credit' 
		&& $team['team_type']=='seconds' 
		&& ($order['origin']>$login_user['money'])
		&& option_yes('creditseconds')
   ) {
	$need_money = ceil($order['origin'] - $login_user['money']);
	/*Session::Set('error', "秒杀项目仅可以使用余额付款，您的余额不足，还需要充值{$need_money}元才可以完成秒杀");*/
	Session::Set('error', "Spike can only use the balance of payments item, your credit, also need to recharge {$need_money} element to complete spike");
	redirect(WEB_ROOT . "/credit/charge.php?money={$need_money}");
}

//peruser buy count
if ($_POST && $team['per_number']>0) {
	$now_count = Table::Count('order', array(
		'user_id' => $login_user_id,
		'team_id' => $team['id'],
		'state' => 'pay',
	), 'quantity');
	$leftnum = ($team['per_number'] - $now_count);
	if ($leftnum <= 0) {
		Session::Set('error', 'your purchase of this deal has met the upper limit，have a look at other deals！');
		redirect( WEB_ROOT . "/team.php?id={$id}"); 
	}
}
$tabel_maso = "masoduthuong_".$id_promotion;
$checkcode = DB::GetQueryResult("SELECT maso FROM {$tabel_maso} WHERE team_id='".$order['team_id']."' AND order_id='".$order['id']."' AND user_id = '".$order['user_id']."'");
$v = checkVerified($order['user_id'],$order['team_id']);
//payed order
if ( $order['state'] == 'pay' ) { 
	if ( is_get() ) {
		if($order['team_id']==$id_promotion && $v['verified']=='Y'){
			if((int)$checkcode['maso']>0){
				$order['maso'] = $checkcode['maso'];
			}else{
				DB::Insert($tabel_maso,array(
					'order_id' => $order['id'],
					'fullname' => $order['realname'],
					'address' => $order['address'],
					'telephone' => $order['mobile'],
					'team_id' => $order['team_id'],
					'user_id' => $order['user_id'],
				));
				$invite =  DB::GetQueryResult("SELECT user_id FROM invite WHERE other_user_id=".$order['user_id']." AND team_id=".$id_promotion);
			
				if((int)$invite['user_id']>0){
					$check_orderid =  DB::GetQueryResult("SELECT order_id FROM {$tabel_maso} WHERE user_id=".$invite['user_id']. "AND team_id=".$id_promotion." AND status='donation'");
					if((int)$check_orderid['order_id']==0){
						DB::Insert($tabel_maso,array(
							'order_id' => $order['id'],
							'fullname' => $order['realname'],
							'address' => $order['address'],
							'telephone' => $order['mobile'],
							'team_id' => $order['team_id'],
							'user_id' => $order['user_id'],
							'status' => 'donation',
						));
					}
				}
				$maso = DB::GetQueryResult("SELECT maso FROM {$tabel_maso} WHERE team_id='".$order['team_id']."' AND order_id='".$order['id']."' AND user_id = '".$order['user_id']."'");
				if($maso['maso']>0){
					$order['maso'] = $maso['maso'];
				}else{
					$order['maso'] = $checkcode['maso'];
				}
			}
			die(include template('order_promotion_success'));
		}elseif($order['team_id']==$id_promotion && $v['verified']=='N'){
			$tid = $order['team_id'];
			echo "<script> alert('Vui lòng kiểm tra mail và bấm vào liên kết xác nhận để nhận mã dự thưởng');window.location.href='/team/buy.php?id={$tid}';</script>";
		}else{	
			if($order['shipping_id']==2 || $order['shipping_id']==5){					
				die(include template('order_pay_success_allcity'));
			}else{
				die(include template('order_pay_success'));
			}
		}
		
	}else {
		redirect(WEB_ROOT  . "/order/pay.php?id={$order_id}");
	}
}
$subtotal = $order['origin'] + $order['shipping_cost'] + $order['payment_cost'];
$total_money = moneyit($subtotal - $login_user['money']);
if ($total_money<0) { $total_money = 0; $order['service'] = 'credit'; }

/* generate unique pay_id */
if (!($pay_id = $order['pay_id'])) {
	$randid = rand(1000,9999);
	$pay_id = "go-{$order['id']}-{$order['quantity']}-{$randid}";
	Table::UpdateCache('order', $order['id'], array(
		'pay_id' => $pay_id,
	));
}
/* noneed pay where goods soldout or end */
if ($team['close_time']) {
	Session::Set('notice', 'The deal is closed, you can\'t pay now');
	redirect(WEB_ROOT  . "/team.php?id={$order['team_id']}");
}
/* end */

/* payment -------------------- */
if ( $_POST['action'] == 'redirect' ) {
	
	redirect($_POST['reqUrl']);
}
// credit
elseif ( $_POST['service'] == 'credit' ) {

	if ($subtotal > $login_user['money'] ){
		Table::Delete('order', $order_id);
		redirect( WEB_ROOT . '/order/index.php');
	}
	Table::UpdateCache('order', $order_id, array(
		'service' => 'credit',
		'money' => 0,
		/*'state' => 'pay',*/
		'state' => 'confirmed',
		'credit' => $subtotal,
		'pay_time' => time(),
	));
	$order = Table::FetchForce('order', $order_id);
	ZTeam::BuyOne($order);
	redirect( WEB_ROOT . "/order/pay.php?id={$order_id}");
//cash - current payment method
}elseif ($_POST['service'] == 'cashdelivery' || $_POST['service'] == 'cashoffice' ) {
	$service = $_POST['service'];

	Table::UpdateCache('order', $order_id, array(
		'service' => $service,
		'money' => 0,
		'state' => 'unpay',
		'credit' => 0,
		'pay_time' => time(),
	));
	$order = Table::FetchForce('order', $order_id);	
	ZTeam::BuyOne($order);
	redirect( WEB_ROOT . "/order/pay.php?id={$order_id}");
}
/* Credit */
else if($order['service'] == 'credit'){

	if($order['credit']==0){
		$total_money = $order['origin'] + $order['shipping_cost'] + $order['payment_cost'];
		die(include template('order_pay'));
	}else{
		$order['email'] = $login_user['email'];
		$email[] = $login_user['email'];
		$subject = 'Dealsoc - Xác nhận đơn hàng';
		//$content = render('order_email_confirm', $order);
		if($order['shipping_id']==2 || $order['shipping_id']==5)	
		{					
			$content = render('order_email_confirm_allcity', $order);
		}else{
			$content = render('order_email_confirm', $order);
		}
		
		try{
			
		//	mail_custom($email, $subject, $content);
		mail_custom('anhtranit@gmail.com', 'Test 1', $content);
			Session::Set('notice', "Email xác nhận đơn hàng đã được gởi. Vui lòng check mail của bạn.");
			
		}catch(Exception $e) {
			Session::Set('error', 'Gởi email xác nhận đơn hàng thất bại. Vui lòng thử lại sau:'. $e->getMessage());
		}
		
		die(include template('order_pay_success'));
	}
// cash - ngan luong
}else if ($order['service'] == 'cashoffice' || $order['service'] == 'cashdelivery') {

	//email to confirm order
	$order['email'] = $login_user['email'];
	$email[] = $login_user['email'];
	$subject = "{$INI['system']['abbreviation']} - Xác nhận đơn hàng";
	//$content = render('order_email_confirm', $order);
	
	if($order['shipping_id']==2 || $order['shipping_id']==5)	
	{					
		$content = render('order_email_confirm_allcity', $order);
	}else{
		$content = render('order_email_confirm', $order);
	}
	if(in_array($order['payment_id'],$_config_payment_online)){		
		$transactionID_nl = @$_GET['payment_id'];
		$secure_code_nl = @$_GET['secure_code'];
		/*require_once(dirname(__FILE__) . '/nganluong/nganluong.php');
		$nl = new NL_Checkout();
		$transaction_info = @$_GET['transaction_info'];
		$payment_id = @$_GET['payment_id'];
		$payment_type = @$_GET['payment_type'];
		$transaction_info = @$_GET['transaction_info'];
		$order_code = @$_GET['order_code'];
		$price = @$_GET['price'];
		$error_text = @$_GET['error_text'];
		$secure_code = @$_GET['secure_code'];
		$check_nl = $nl->verifyPaymentUrl($transaction_info, $order_code, $price, $payment_id, $payment_type, $error_text, $secure_code);
		if($check_nl){
			$subject = "{$INI['system']['abbreviation']} - Xác nhận đơn hàng";
			//$content = render('order_email_confirm', $order);
			if($order['shipping_id']==2 || $order['shipping_id']==5)	
			{					
				$content = render('order_email_confirm_allcity', $order);
			}else{
				$content = render('order_email_confirm', $order);
			}
			try{
				mail_custom($email, $subject, $content);
				Session::Set('notice', "Email xác nhận đơn hàng đã được gởi. Vui lòng check mail của bạn.");
			}catch(Exception $e) {
				Session::Set('error', 'Gởi email xác nhận đơn hàng thất bại. Vui lòng thử lại sau:'. $e->getMessage());
			}
			die(include template('order_pay_success_allcity'));
		}else{
			die(include template('order_pay_error'));
		}*/
		$subject = "{$INI['system']['abbreviation']} - Xác nhận đơn hàng";
		//$content = render('order_email_confirm', $order);
		if($order['shipping_id']==2 || $order['shipping_id']==5)	
		{					
			$content = render('order_email_confirm_allcity', $order);
		}else{
			$content = render('order_email_confirm', $order);
		}
		try{
			
		//	mail_custom($email, $subject, $content);
		mail_custom('anhtranit@gmail.com', 'Test 2', $content);
			
			Session::Set('notice', "Email xác nhận đơn hàng đã được gởi. Vui lòng check mail của bạn.");
		}catch(Exception $e) {
			Session::Set('error', 'Gởi email xác nhận đơn hàng thất bại. Vui lòng thử lại sau:'. $e->getMessage());
		}
		Table::UpdateCache('order', $order['id'], array(
			'state' => 'confirmed',
			'transaction_id_nl' => $transactionID_nl,
			'secure_code_nl' => $secure_code_nl, 
		));
		die(include template('order_pay_success_allcity'));
	}elseif($order['team_id']==$id_promotion){
		
		Table::UpdateCache('order', $order['id'], array(
			'money' => 0,
			'state' => 'pay',
			'credit' => 0,
			'pay_time' => time(),
		));
		/*Table::UpdateCache('user', $order['user_id'], array(
			'money' => '10000',
		));*/		
		ZTeam::BuyOne($order);
		if($checkcode['maso']==''){
			DB::Insert($tabel_maso,array(
				'order_id' => $order['id'],
				'fullname' => $order['realname'],
				'address' => $order['address'],
				'telephone' => $order['mobile'],
				'team_id' => $order['team_id'],
				'user_id' => $order['user_id'],
			));
			$invite =  DB::GetQueryResult("SELECT user_id FROM invite WHERE other_user_id=".$order['user_id']." AND team_id=".$id_promotion);
			
			if((int)$invite['user_id']>0){
				$check_orderid =  DB::GetQueryResult("SELECT order_id FROM {$tabel_maso} WHERE user_id=".$invite['user_id']. "AND team_id=".$id_promotion." AND status='donation'");
				if((int)$check_orderid['order_id']==0){
					DB::Insert($tabel_maso,array(
						'order_id' => $order['id'],
						'fullname' => '',
						'address' => '',
						'telephone' => '',
						'team_id' => $order['team_id'],
						'user_id' => $invite['user_id'],
						'status' => 'donation',
					));
				}
				$maso = DB::GetQueryResult("SELECT maso FROM {$tabel_maso} WHERE team_id=".$id_promotion." AND user_id=".$invite['user_id']." AND status='donation'");
			}else{
				$maso = DB::GetQueryResult("SELECT maso FROM {$tabel_maso} WHERE team_id=".$id_promotion." AND user_id=".$order['user_id']." AND status='granted'");
			}
			
		}
		$order['maso'] = $maso['maso'];
		$subject = 'Dealsoc.vn - Bạn đã tham gia thành công chương trình "Miễn phí 01 năm mua sắm trên web: www.dealsoc.vn"';
		//$content = render('order_email_promotion_confirm', $order);
		if($order['shipping_id']==2 || $order['shipping_id']==5)	
		{					
			$content = render('order_email_promotion_confirm', $order);
		}else{
			$content = render('order_email_promotion_confirm', $order);
		}
	}else{

		if ($login_user['money']>=$subtotal){
			Table::UpdateCache('order', $order_id, array(
				'money' => 0,
				'state' => 'confirmed',
				'credit' => $subtotal,
				'pay_time' => time(),
			));
		}elseif($login_user['money']<$subtotal){
			Table::UpdateCache('order', $order_id, array(
				'money' => $login_user['money'],
			));
			Table::UpdateCache('user', $order['user_id'], array(
				'money' => '0',
			));
		}
		
	}
	
	try{
		
	//		mail_custom($email, $subject, $content);
	mail_custom('anhtranit@gmail.com', 'Test 3', $content);
	
			Session::Set('notice', "Email xác nhận đơn hàng đã được gởi. Vui lòng check mail của bạn.");
	}catch(Exception $e) {
		Session::Set('error', 'Gởi email xác nhận đơn hàng thất bại. Vui lòng thử lại sau:'. $e->getMessage());
	}
	unset($_SESSION["{$login_user['id']}_{$order['team_id']}_POST"]);
	unset($_SESSION["qty"]);
	
	if($order['team_id']==$id_promotion){
		die(include template('order_promotion_success'));
	}else{	
	
		if($order['shipping_id']==2 || $order['shipping_id']==5)	
		{					
			die(include template('order_pay_success_allcity'));
		}else{
			die(include template('order_pay_success'));
		}
	}
}  
else {
	Session::Set('error', 'No suitable method of payment or credit');
	redirect( WEB_ROOT. "/team.php?id={$order_id}");
}


//功能函数。将变量值不为空的参数组成字符串
Function appendParam($returnStr,$paramId,$paramValue){
	if($returnStr!=""){			
		if($paramValue!=""){					
			$returnStr.="&".$paramId."=".$paramValue;
		}			
	}else{		
		If($paramValue!=""){
			$returnStr=$paramId."=".$paramValue;
		}
	}		
	return $returnStr;
}
//功能函数。将变量值不为空的参数组成字符串。结束
