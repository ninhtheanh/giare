<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_manager();

$action = strval($_GET['action']);
$id = abs(intval($_GET['id']));
$transfer_id  = abs(intval($_GET['transferID']));
if ( 'orderrefund' == $action) {
	need_auth('admin');
	$order = Table::Fetch('order', $id);
	$rid = strtolower(strval($_GET['rid']));
	if ( $rid == 'credit' ) {
		ZFlow::CreateFromRefund($order);
	} else {
		Table::UpdateCache('order', $id, array(
			'service' => 'cash',
			'state' => 'unpay'
		));
	}
	/* team -- */
	$team = Table::Fetch('team', $order['team_id']);
	team_state($team);
	if ( $team['state'] != 'failure' ) {
		$minus = $team['conduser'] == 'Y' ? 1 : $order['quantity'];
		Table::UpdateCache('team', $team['id'], array(
					'now_number' => array( "now_number - {$minus}", ),
		));
	}
	/* card refund */
	if ( $order['card_id'] ) {
		Table::UpdateCache('card', $order['card_id'], array(
			'consume' => 'N',
			'team_id' => 0,
			'order_id' => 0,
		));
	}
	/* coupons */
	if ( in_array($team['delivery'], array('coupon', 'pickup') )) {
		$coupons = Table::Fetch('coupon', array($order['id']), 'order_id');
		foreach($coupons AS $one) Table::Delete('coupon', $one['id']);
	}

	/* order update */
	Table::UpdateCache('order', $id, array(
				'card' => 0, 
				'card_id' => '',
				'express_id' => 0,
				'express_no' => '',
				));
	Session::Set('notice', 'Đã hoàn trả thành công!');
	json(null, 'refresh');
}
elseif ( 'orderremove' == $action) {
	need_auth('order');
	$order = Table::Fetch('order', $id);
	if ( $order['state'] != 'unpay' ) {
		json('Không thể xóa đơn hàng', 'alert');
	}
	/* card refund */
	if ( $order['card_id'] ) {
		Table::UpdateCache('card', $order['card_id'], array(
			'consume' => 'N',
			'team_id' => 0,
			'order_id' => 0,
		));
	}
	Table::Delete('order', $order['id']);
	Session::Set('notice', "Đã xóa đơn hàng số {$order['id']} thành công");
	json(null, 'refresh');
}
else if ( 'ordercash' == $action ) {
	need_auth('order');
	$order = Table::Fetch('order', $id);
	ZOrder::CashIt($order);
	$user = Table::Fetch('user', $order['user_id']);
	Session::Set('notice', "Thanh toán tiền mặt thành công");
	json(null, 'refresh');
}
else if ( 'teamdetail' == $action) {
	$team = Table::Fetch('team', $id);
	$partner = Table::Fetch('partner', $team['partner_id']);

	$paycount = Table::Count('order', array(
		'state' => 'pay',
		'team_id' => $id,
	));
	$buycount = Table::Count('order', array(
		'state' => 'pay',
		'team_id' => $id,
	), 'quantity');
	$onlinepay = Table::Count('order', array(
		'state' => 'pay',
		'team_id' => $id,
	), 'money');
	$creditpay = Table::Count('order', array(
		'state' => 'pay',
		'team_id' => $id,
	), 'credit');
	$cardpay = Table::Count('order', array(
		'state' => 'pay',
		'team_id' => $id,
	), 'card');
	$couponcount = Table::Count('coupon', array(
		'team_id' => $id,
	));
	$team['state'] = team_state($team);
	$city_id = abs(intval($team['city_id']));
	$subcond = array(); if($city_id) $subcond['city_id'] = $city_id;
	$subcount = Table::Count('subscribe', $subcond);
	$subcond['enable'] = 'Y';
	$smssubcount = Table::Count('smssubscribe', $subcond);

	/* send team subscribe mail */	
	$team['noticesubscribe'] = ($team['close_time']==0&&is_manager());
	$team['noticesmssubscribe'] = ($team['close_time']==0&&is_manager());
	/* send success coupon */
	$team['noticesms'] = ($team['delivery']!='express')&&(in_array($team['state'], array('success', 'soldout')))&&is_manager();
	/* teamcoupon */
	$team['teamcoupon'] = ($team['noticesms']&&$buycount>$couponcount);
	$team['needline'] = ($team['noticesms']||$team['noticesubscribe']||$team['teamcoupon']);

	$html = render('manage_ajax_dialog_teamdetail');
	json($html, 'dialog');
}
else if ( 'teamremove' == $action) {
	need_auth('team');
	$team = Table::Fetch('team', $id);
	$order_count = Table::Count('order', array(
		'team_id' => $id,
		'state' => 'pay',
	));
	if ( $order_count > 0 ) {
		json('Bạn không thể xóa các đơn hàng đã thanh toán', 'alert');
	}
	ZTeam::DeleteTeam($id);

	/* remove coupon */
	$coupons = Table::Fetch('coupon', array($id), 'team_id');
	foreach($coupons AS $one) Table::Delete('coupon', $one['id']);
	/* remove order */
	$orders = Table::Fetch('order', array($id), 'team_id');
	foreach($orders AS $one) Table::Delete('order', $one['id']);
	/* end */

	Session::Set('notice', "Khách hàng có mã số {$id} đã xóa thành công!");
	json(null, 'refresh');
}
else if ( 'cardremove' == $action) {
	need_auth('market');
	$id = strval($_GET['id']);
	$card = Table::Fetch('card', $id);
	if (!$card) json('Không có chứng từ liên quan ', 'alert');
	if ($card['consume']=='Y') { json('Vouchers đã được sử dụng, Bạn Không thể Xóa', 'alert'); }
	Table::Delete('card', $id);
	Session::Set('notice', "Vouchers có mã số {$id} đã xóa thành công!");
	json(null, 'refresh');
}
else if ( 'userview' == $action) {
	$user = Table::Fetch('user', $id);
	$user['costcount'] = Table::Count('order', array(
		'state' => 'pay',
		'user_id' => $id,
	));
	$user['cost'] = Table::Count('flow', array(
		'direction' => 'expense',
		'user_id' => $id,
	), 'money');
	$html = render('manage_ajax_dialog_user');
	json($html, 'dialog');
}else if ( 'userviewhistory' == $action) {
	$user = Table::Fetch('user', $id);
	$user['costcount'] = Table::Count('order', array(
		'state' => 'pay',
		'user_id' => $id,
	));
	$user['post_topic'] = Table::Count('topic', array(
		'user_id' => $id,
	));
	$html = render('manage_ajax_dialog_user_history');
	json($html, 'dialog');
}

else if ( 'usermoney' == $action) {
	need_auth('admin');
	$user = Table::Fetch('user', $id);
	$money = moneyit($_GET['money']);
	if ( $money < 0 && $user['money'] + $money < 0) {
		json('Failed to mention is - insufficient funds', 'alert');
	}
	if ( ZFlow::CreateFromStore($id, $money) ) {
		$action = ($money>0) ? 'Top-Line' : 'Users are provided';
		$money = abs($money);
		json(array(
					array('data' => "{$action}{$money}Per successful", 'type'=>'alert'),
					array('data' => null, 'type'=>'refresh'),
				  ), 'mix');
	}
	json('Lỗi nạp tiền', 'alert'); 
}
else if ( 'orderexpress' == $action ) {
	need_auth('order');
	$express_id = abs(intval($_GET['eid']));
	$express_no = strval($_GET['nid']);
	if (!$express_id) $express_no = null;
	Table::UpdateCache('order', $id, array(
		'express_id' => $express_id,
		'express_no' => $express_no,
	));
	json(array(
		array('data' => "Successful delivery of information to modify", 'type'=>'alert'),
		array('data' => null, 'type'=>'refresh'),
	  ), 'mix');
}else if ( 'orderpaid' == $action ) {
	need_auth('order');
	$order = Table::Fetch('order', $id);
	Table::UpdateCache('order', $id, array(
		'state' => 'pay',
		'admin_id'=>$login_user_id,
	));
	save_order_history($order['id'],'pay');
	
	Session::Set('notice', "Đơn hàng số. ".$id." đã thanh toán thành công");
	json(null, 'refresh');
}else if ( 'orderconfirm' == $action ) {
	need_auth('order');
	$order = Table::Fetch('order', $id);

	$group_id = DB::GetQueryResult("SELECT group_id FROM `team` WHERE id='".$order['team_id']."'");
	$seri = DB::GetQueryResult("SELECT serial FROM `voucher_code` WHERE team_id='".$order['team_id']."' AND order_id='".$order['id']."'");
	if($group_id['group_id']==23 && $order['team_id']>=5 && (int)$seri['serial']==0){
		$create_time = date("Y-m-d H:i:s");
		for($i=0;$i<$order['quantity'];$i++){
			$vid = Utility::GenSecret(6, Utility::CHAR_NUM);
			$vouchercode = Utility::VerifyCode($vid);
			$voucher_code = array(
				'order_id' => $order['id'],
				'team_id' => $order['team_id'],
				'user_id' => $order['user_id'],
				'realname' => $order['realname'],
				'code' => $vouchercode,
				'create_time' => $create_time,
			);
			DB::Insert('voucher_code', $voucher_code);
		}
	}
	Table::UpdateCache('order', $id, array(
		'state' => 'confirmed',
		'service' => 'cashdelivery',
		'admin_id'=>$login_user_id,
	));

	save_order_history($order['id'],'confirmed');
	
	Session::Set('notice', "Confirmed order No. ".$id." was successful");
	json(null, 'refresh');
	
}else if ( 'ordercopy' == $action ) {
	need_auth('order');
	$order = Table::Fetch('order', $id);
	//DB::$mDebug = true;
	$insert = array(
		'user_id' => $login_user_id, 'team_id' => $order['team_id'], 'city_id' => $login_user['city_id'], 'dist_id' => $login_user['dist_id'], 'ward_id' => $login_user['ward_id'], 'house_number' => $login_user['house_number'], 'street_name' => $login_user['street_name'], 'bcity_id' => $login_user['city_id'], 'bdist_id' => $login_user['dist_id'], 'bward_id' => $login_user['ward_id'], 'bhouse_number' => $login_user['house_number'], 'bstreet_name' => $login_user['street_name'], 'baddress' => $order['address'], 'bnote_address' => $order['note_address'], 	 'state' => 'unpay', 'fare' => 0, 'express' => 'N', 'origin' => $order['origin'], 'price' => $order['price'], 'address' => $order['address'], 'note_address' => $order['note_address'], 'zipcode' => '', 'realname' => $login_user['realname'], 'mobile' => $login_user['mobile'], 'quantity' => $order['quantity'], 'create_time' => time(), 'remark' => '', 'condbuy' => '',
	);	
	DB::Insert('order', $insert);

	$order_id_copy = mysql_insert_id();
	Session::Set('notice', "Đơn hàng số ".$id." đã copy thành công. Mã số đơn hàng copy: ".$order_id_copy);
	json(null, 'refresh');
	
}else if ( 'ordercancel' == $action ) {
	need_auth('order');
	$order = Table::Fetch('order', $id);
	Table::UpdateCache('order', $id, array(
		'state' => 'dealsoc_cancel',
		'admin_id'=>$login_user_id,
	));
	if($order['money']>0){
		Table::UpdateCache('user', $order['user_id'], array(
			'money' => $order['money'],
		));
	}
	save_order_history($order['id'],'canceled');	
	
	Session::Set('notice', "Cancel order No. ".$id." was successful");
	json(null, 'refresh');
	
}else if ( 'orderpay' == $action ) {
	need_auth('order');
	$order = Table::Fetch('order', $id);
	Table::UpdateCache('order', $id, array(
		'state' => 'pay',
		'admin_id'=>$login_user_id,
	));
	if($order['money']>0){
		Table::UpdateCache('user', $order['user_id'], array(
			'money' => $order['money'],
		));
	}
	save_order_history($order['id'],'pay');	
	
	Session::Set('notice', "Pay order No. ".$id." was successful");
	json(null, 'refresh');
	
}else if ( 'orderdatratien' == $action ) {
	need_auth('order');
	$order = Table::Fetch('order', $id);
	Table::UpdateCache('order', $id, array(
		'state' => 'datratien',
		'admin_id'=>$login_user_id,
	));
	if($order['money']>0){
		Table::UpdateCache('user', $order['user_id'], array(
			'money' => $order['money'],
		));
	}
	save_order_history($order['id'],'datratien');	
	
	Session::Set('notice', "datratien order No. ".$id." was successful");
	json(null, 'refresh');
	
}else if ( 'orderoffice' == $action ) {
	need_auth('order');
	$order = Table::Fetch('order', $id);
	if($city['id']==11){
		Table::UpdateCache('order', $id, array(
			/*'city_id' => 11,
			'dist_id' => 16,
			'ward_id' => 46,
			'note_address' => '',
			'house_number' => '51',
			'street_name' => 'Nhiêu Tứ',
			'address' => '151 Nhiêu Tứ',
			'bcity_id' => 11,
			'bdist_id' => 16,
			'bward_id' => 46,
			'bnote_address' => '',
			'bhouse_number' => '151',
			'bstreet_name' => 'Nhiêu Tứ',
			'baddress' => '151 Nhiêu Tứ',*/
			'state' => 'confirmed',
			'service' => 'cashoffice',
			'admin_id'=>$login_user_id,
		));
	}
	$group_id = DB::GetQueryResult("SELECT group_id FROM `team` WHERE id='".$order['team_id']."'");
	$seri = DB::GetQueryResult("SELECT serial FROM `voucher_code` WHERE team_id='".$order['team_id']."' AND order_id='".$order['id']."'");
	if($group_id['group_id']==23 && $order['team_id']>=5 && (int)$seri['serial']==0){
		$create_time = date("Y-m-d H:i:s");
		for($i=0;$i<$order['quantity'];$i++){
			$vid = Utility::GenSecret(6, Utility::CHAR_NUM);
			$vouchercode = Utility::VerifyCode($vid);
			$voucher_code = array(
				'order_id' => $order['id'],
				'team_id' => $order['team_id'],
				'user_id' => $order['user_id'],
				'realname' => $order['realname'],
				'code' => $vouchercode,
				'create_time' => $create_time,
			);
			DB::Insert('voucher_code', $voucher_code);
		}
	}
	
	//save order history	
	save_order_history($order['id'],'confirmed',NULL,'Nhận tại VP');	
	
	Session::Set('notice', "Order No. ".$id." has been confirmed and transferred successfully received at the office");
	json(null, 'refresh');
	
}else if ( 'ordertransition' == $action ) {
	need_auth('order');
	$order = Table::Fetch('order', $id);
	Table::UpdateCache('order', $id, array(
		'state' => 'pending',
		'admin_id'=>$login_user_id,
	));

	save_order_history($order['id'],'pending');	
	
	Session::Set('notice', "Pending order No. ".$id." was successful");
	json(null, 'refresh');
	
}elseif ( 'orderedit' == $action ) {
	need_auth('order');
	if ($id) {
		$order = Table::Fetch('order', $id);
		$team = Table::Fetch('team', $order['team_id']);
		if (!$order) json('No data', 'alert');
	}
	$dest = GetDestID($order['city_id'],$order['dist_id']);
	$b_dest = @$dest[2];
	if((int)@$dest[0]==0){
		$whereand = " ";
	}else	$whereand = " AND destination LIKE ('%".(int)@$dest[0]."%')";
	
	$ds = DB::GetQueryResult("SELECT DISTINCT state_id FROM payment_cost", false);
	foreach($ds as $k => $v){
		$cod .= $v['state_id'].",";	
	}
	$accept_cod = explode(",", rtrim ($cod, ","));
	if(($dest[0]!=1 && !in_array($order['ward_id'],array(313,316))) || ($dest[0]==1 && in_array($order['ward_id'],array(125,126)))  || ($dest[0]!=1 && in_array($order['ward_id'],$accept_cod))){
		$q3 = DB::GetQueryResult("SELECT state_id, adding_type, adding_cost FROM payment_cost WHERE state_id=".$order['city_id']." AND subtotal_to<=".$order['origin']." AND subtotal_from>=".$order['origin']);
		if(!empty($q3)){
			if($q3['adding_type']=='Money'){
				$adding = (int)$q3['adding_cost'];
			}else{
				$adding = (int)($order['origin']*$q3['adding_cost']/100);
			}
		}
		
	}else{
		$adding = 0;	
	}
	
	$q2 = DB::GetQueryResult("SELECT payment_id, adding_cost, adding_type, payment, description FROM payment_descriptions WHERE status='A' {$whereand} ORDER BY position", false);
	if(is_array($q2)){
		$payment_lst = "";
		if($order['city_id']!=11 && in_array($order['city_id'], $accept_cod)){
            $payment_lst = "<option value=\"1-{$adding}\">Thanh toán bằng tiền mặt</option>";
        }
		foreach($q2 as $key=>$value){
			$payment_id = $value['payment_id'];
			if($payment_id==1){
				$payment_cost = $adding;
			}else{
				$payment_cost = 0;	
			}
			$payment_name = strip_input($value['payment']);
			$payment_lst .="<option value=\"{$payment_id}-{$payment_cost}\">{$payment_name}</option>";
		}
	}else{
		$payment_lst = "";
	}
	$payment_id = $order["payment_id"];
	$dests = GetDestID($order['bcity_id'],$order['bdist_id']);
	$s_dest = @$dests[2];
	
	if((int)@$dests[0]==0){
		$whereand = " ";
	}elseif(in_array( $order['bward_id'], array(125,126))){
		$whereand = 5;	
	}else $whereand = (int)@$dests[0];
	$q3 = DB::GetQueryResult("SELECT s.shipping_id, s.shipping_name, sr.destination_id FROM shippings as s, shipping_rates as sr WHERE s.shipping_id = sr.shipping_id AND s.status='A' AND destination_id IN ($whereand) GROUP BY s.shipping_id ORDER BY s.position", false);

	if(is_array($q3)){
		$shipping_name = "";
		$shipping_lst = "";
		foreach($q3 as $key=>$value){
			$shipping_id = $value['shipping_id'];
			$shipping_name = strip_input($value['shipping_name']);
			$shipping_cost = (int)GetShippingCost($shipping_id, $value['destination_id'], $order['origin'], $order['total_weight']);
			$shipping_lst .="<option value=\"{$shipping_id}-{$shipping_cost}\">{$shipping_name}</option>";
		}
	}else{
		$shipping_lst = "";
	}

	$shipping_id = $order["shipping_id"];
	$html = render('manage_ajax_dialog_orderedit');
	json($html, 'dialog');
}elseif ( 'ordertransfer' == $action ) {
	need_auth('order');
	if ($id) {
		$transfer = Table::Fetch('order_wait_call', $id);
		$order = Table::Fetch('order', $id);
		$user = Table::Fetch('user', $order['user_id']);
		$team = Table::Fetch('team', $order['team_id']);
		if (!$order) json('No data', 'alert');
	}
	$order['transferID'] = $transfer_id;
	$paystate = array(
		'unpay' => '<font color="green">Chưa thanh toán</font>',
		'canceled' => '<font color="green">Chưa thanh toán</font>',
		'confirmed' => '<font color="green">Chưa thanh toán</font>', 'pending' => '<font color="green">Chưa thanh toán</font>',
		'delivered' => '<font color="green">Chưa thanh toán</font>',
		'pay' => '<font color="red">Đã thanh toán</font>',
	);
	//load history
	$his = DB::LimitQuery('order_history', array(
		'condition' => 'order_id='.$id,
		'order' => 'ORDER BY date DESC,order_id',
	));
	//render
	$html = render('manage_ajax_dialog_ordertransfer');
	json($html, 'dialog');
}else if ( 'orderview' == $action) {
	
	//view detail team
	$order['disabled'] = 'disabled="disabled"';
	$order = Table::Fetch('order', $id);
	$user = Table::Fetch('user', $order['user_id']);
	$team = Table::Fetch('team', $order['team_id']);
	if ($team['delivery'] == 'express') {
		$option_express = option_category('express');
	}
	$payservice = array(
		'alipay' => 'Alipay',
		'tenpay' => 'tenpay',
		'chinabank' => 'chinabank',
		'credit' => 'credit',
		'cash' => 'cash',
	);
	$paystate = array(
		'unpay' => '<font color="green">Chưa thanh toán</font>',
		'canceled' => '<font color="green">Chưa thanh toán</font>',
		'confirmed' => '<font color="green">Chưa thanh toán</font>', 'pending' => '<font color="green">Chưa thanh toán</font>',
		'delivered' => '<font color="green">Chưa thanh toán</font>',
		'pay' => '<font color="red">Đã thanh toán</font>',
	);
	$option_refund = array(
		'credit' => 'Hoàn trả cho số dư tài khoản',
		'online' => 'Other means have been refunded',
	);
	//load history
	$his = DB::LimitQuery('order_history', array(
		'condition' => 'order_id='.$id,
		'order' => 'ORDER BY date DESC,order_id',
	));
	//render
	$html = render('manage_ajax_dialog_orderview');
	json($html, 'dialog');
	
	//end view order
}else if ( 'orderhanging' == $action) {
	$order = Table::Fetch('order', $id);
	$user = Table::Fetch('user', $order['user_id']);
	$team = Table::Fetch('team', $order['team_id']);
	if ($team['delivery'] == 'express') {
		$option_express = option_category('express');
	}
	$payservice = array(
		'alipay' => 'Alipay',
		'tenpay' => 'tenpay',
		'chinabank' => 'chinabank',
		'credit' => 'credit',
		'cash' => 'cash',
	);
	$paystate = array(
		'unpay' => '<font color="green">Chưa thanh toán</font>',
		'canceled' => '<font color="green">Chưa thanh toán</font>',
		'confirmed' => '<font color="green">Chưa thanh toán</font>', 'pending' => '<font color="green">Chưa thanh toán</font>',
		'delivered' => '<font color="green">Chưa thanh toán</font>',
		'pay' => '<font color="red">Đã thanh toán</font>',
	);
	$option_refund = array(
		'credit' => 'Refund to the account balance',
		'online' => 'Other means have been refunded',
	);
	//load history
	$his = DB::LimitQuery('order_history', array(
		'condition' => 'order_id='.$id,
		'order' => 'ORDER BY date DESC,order_id',
	));
	//render
	$html = render('manage_ajax_dialog_orderhanging');
	json($html, 'dialog');
}
else if ( 'inviteok' == $action ) {
	need_auth('admin');
	$express_id = abs(intval($_GET['eid']));
	$invite = Table::Fetch('invite', $id);
	if (!$invite || $invite['pay']!='N') {
		json('Illegal Operation', 'alert');
	}
	if(!$invite['team_id']) {
		json('No Purchase，Rebate can not be performed', 'alert');
	}
	$team = Table::Fetch('team', $invite['team_id']);
	$team_state = team_state($team);
	if (!in_array($team_state, array('success', 'soldout'))) {
		json('Customers can only execute successfully invited rebates', 'alert');
	}
	Table::UpdateCache('invite', $id, array(
				'pay' => 'Y', 
				'admin_id'=>$login_user_id,
				));
	$invite = Table::FetchForce('invite', $id);
	ZFlow::CreateFromInvite($invite);
	Session::Set('notice', 'Operating successfully invited rebate');
	json(null, 'refresh');
}
else if ( 'inviteremove' == $action ) {
	need_auth('admin');
	Table::UpdateCache('invite', $id, array(
		'pay' => 'C',
		'admin_id' => $login_user_id,
	));
	Session::Set('notice', 'Cancel the invitation to record a successful unlawful！');
	json(null, 'refresh');
}

else if ( 'affok' == $action ) {
	need_auth('admin');
	$express_id = abs(intval($_GET['eid']));
	
	$aff = Table::Fetch('click', $id);
	if (!$aff || $aff['pay']>0) {
		json('Illegal Operation', 'alert');
	}
	if(!$aff['buy_tid']) {
		json('No Purchase，Rebate can not be performed', 'alert');
	}
	$team = Table::Fetch('team', $aff['buy_tid']);
	$team_state = team_state($team);
	if (!in_array($team_state, array('success', 'soldout'))) {
		json('Customers can only execute successfully invited rebates', 'alert');
	}
	Table::UpdateCache('click', $id, array(
				'pay' => 1, 
				'admin_id'=>$login_user_id,
				));
	$aff = Table::FetchForce('click', $id);
	ZFlow::CreateFromAff($aff);
	//save log
	save_log('paid','click',$id);
	Session::Set('notice', 'Operating successfully rebate');
	json(null, 'refresh');
}
else if ( 'affdel' == $action ) {
	need_auth('admin');
	Table::UpdateCache('click', $id, array(
		'pay' => 2,
		'admin_id' => $login_user_id,
	));
	//save log
	save_log('cancel','click',$id);
	Session::Set('notice', 'Cancel the invitation to record a successful unlawful！');
	json(null, 'refresh');
}

else if ( 'subscriberemove' == $action ) {
	need_auth('admin');
	$subscribe = Table::Fetch('subscribe', $id);
	if ($subscribe) {
		ZSubscribe::Unsubscribe($subscribe);
		Session::Set('notice', "Email address：{$subscribe['email']}Unsubscribe successful");
	}
	json(null, 'refresh');
}
else if ( 'smssubscriberemove' == $action ) {
	need_auth('admin');
	$subscribe = Table::Fetch('smssubscribe', $id);
	if ($subscribe) {
		ZSMSSubscribe::Unsubscribe($subscribe['mobile']);
		Session::Set('notice', "Phone number:{$subscribe['mobile']} Unsubscribe successful");
	}
	json(null, 'refresh');
}
else if ( 'partnerremove' == $action ) {
	need_auth('market');
	$partner = Table::Fetch('partner', $id);
	$count = Table::Count('team', array('partner_id' => $id) );
	if ($partner && $count==0) {
		Table::Delete('partner', $id);
		Session::Set('notice', "Business:{$id} Deleted successfully");
		json(null, 'refresh');
	}
	if ( $count > 0 ) {
		json('Business has Items, Delete Failed', 'alert'); 
	}
	json('Business Delete failed', 'alert'); 
}
else if ( 'noticesms' == $action ) {
	need_auth('team');
	$nid = abs(intval($_GET['nid']));
	$now = time();
	$team = Table::Fetch('team', $id);
	$condition = array( 'team_id' => $id, );
	$coups = DB::LimitQuery('coupon', array(
		'condition' => $condition,
		'order' => 'ORDER BY id ASC',
		'offset' => $nid,
		'size' => 1,
	));
	if ( $coups ) {
		foreach($coups AS $one) {
			$nid++;
			sms_coupon($one);
		}
		json("X.misc.noticesms({$id},{$nid});", 'eval');
	} else {
		json($INI['system']['couponname'].'Send completed', 'alert');
	}
}
else if ( 'noticesmssubscribe' == $action ) {
	need_auth('team');
	$nid = abs(intval($_GET['nid']));
	$team = Table::Fetch('team', $id);
	$condition = array( 'enable' => 'Y' );
	if(abs(intval($team['city_id']))) {
		$condition['city_id'] = abs(intval($team['city_id']));
	}
	$subs = DB::LimitQuery('smssubscribe', array(
		'condition' => $condition,
		'order' => 'ORDER BY id ASC',
		'offset' => $nid,
		'size' => 10,
	));
	$content = render('manage_tpl_smssubscribe');
	if ( $subs ) {
		$mobiles = Utility::GetColumn($subs, 'mobile');
		$nid += count($mobiles);
		$mobiles = implode(',', $mobiles);
		$smsr = sms_send($mobiles, $content);
		if ( true === $smsr ) {
			usleep(500000);
			json("X.misc.noticenextsms({$id},{$nid});", 'eval');
		} else {
			json("Send failed, error code：{$smsr}", 'alert');
		}
	} else {
		json('Subscribe to SMS Send completed', 'alert');
	}
}
else if ( 'noticesubscribe' == $action ) {
	need_auth('team');
	$nid = abs(intval($_GET['nid']));
	$now = time();
	$interval = abs(intval($INI['mail']['interval']));
	$team = Table::Fetch('team', $id);
	$partner = Table::Fetch('partner', $team['partner_id']);
	$city = Table::Fetch('city', $team['city_id']);

	$condition = array();
	if(abs(intval($team['city_id']))) {
		$condition['city_id'] = abs(intval($team['city_id']));
	}
	$subs = DB::LimitQuery('subscribe', array(
				'condition' => $condition,
				'order' => 'ORDER BY id ASC',
				'offset' => $nid,
				'size' => 1,
				));
	if ( $subs ) {
		foreach($subs AS $one) {
			$nid++;
			try{
				ob_start();
				mail_subscribe($city, $team, $partner, $one);
				ob_get_clean();
			}catch(Exception $e){}
			$cost = time() - $now;
			if ( $cost >= 20 ) {
				json("X.misc.noticenext({$id},{$nid});", 'eval');
			}
		}
		$cost = time() - $now;
		if ($interval && $cost < $interval) { sleep($interval - $cost); }
		json("X.misc.noticenext({$id},{$nid});", 'eval');
	} else {
		json('Subscribe to e-mail completed', 'alert');
	}
}
elseif ( 'categoryedit' == $action ) {
	need_auth('admin');
	if ($id) {
		$category = Table::Fetch('category', $id);
		if (!$category) json('No data', 'alert');
		$zone = $category['zone'];
	} else {
		$zone = strval($_GET['zone']);
	}
	if ( !$zone ) json('Make sure the classification', 'alert');
	$zone = get_zones($zone);

	$html = render('manage_ajax_dialog_categoryedit');
	json($html, 'dialog');
}
elseif ( 'categoryremove' == $action ) {
	need_auth('admin');
	$category = Table::Fetch('category', $id);
	if (!$category) json('No such category', 'alert');
	if ($category['zone'] == 'city') {
		$tcount = Table::Count('team', array('city_id' => $id));
		if ($tcount ) json('Item already exists in this category', 'alert');
	}
	elseif ($category['zone'] == 'group') {
		$tcount = Table::Count('team', array('group_id' => $id));
		if ($tcount ) json('Item already exists in this category', 'alert');
	}
	elseif ($category['zone'] == 'express') {
		$tcount = Table::Count('order', array('express_id' => $id));
		if ($tcount ) json('Order items exist in this category', 'alert');
	}
	elseif ($category['zone'] == 'public') {
		$tcount = Table::Count('topic', array('public_id' => $id));
		if ($tcount ) json('Topic already Exists', 'alert');
	}
	Table::Delete('category', $id);
	option_category($category['zone']);
	Session::Set('notice', 'Category Removed!');
	json(null, 'refresh');
}
else if ( 'teamcoupon' == $action ) {
	need_auth('team');
	$team = Table::Fetch('team', $id);
	team_state($team);
	if ($team['now_number']<$team['min_number']) {
		json('Buy or not is not the end of the minimum number of people into the group', 'alert');
	}

	/* all orders */
	$all_orders = DB::LimitQuery('order', array(
		'condition' => array(
			'team_id' => $id,		
			'state' => 'pay',
		),
	));
	$all_orders = Utility::AssColumn($all_orders, 'id');
	$all_order_ids = Utility::GetColumn($all_orders, 'id');
	$all_order_ids = array_unique($all_order_ids);

	/* all coupon id */
	$coupon_sql = "SELECT order_id, count(1) AS count FROM coupon WHERE team_id = '{$id}' GROUP BY order_id";
	$coupon_res = DB::GetQueryResult($coupon_sql, false);
	$coupon_order_ids = Utility::GetColumn($coupon_res, 'order_id');
	$coupon_order_ids = array_unique($coupon_order_ids);

	/* miss id */
	$miss_ids = array_diff($all_order_ids, $coupon_order_ids);
	foreach($coupon_res AS $one) {
		if ($one['count'] < $all_orders[$one['order_id']]['quantity']) {
			$miss_ids[] = $one['order_id'];
		}
	}
	$orders = Table::Fetch('order', $miss_ids);

	/*foreach($orders AS $order) {
		ZCoupon::Create($order);
	}*/
	json('Successfully issued securities',  'alert');
}else if ( 'teamon' == $action ) {
	need_auth('team');
	Table::UpdateCache('team', $id, array(
		'status' => 'Y',
		'user_id' => $login_user_id,
	));
	Session::Set('notice', 'Deal On successful!');
	json(null, 'refresh');
}else if ( 'teamoff' == $action ) {
	need_auth('team');
	Table::UpdateCache('team', $id, array(
		'status' => 'N',
		'user_id' => $login_user_id,
	));
	DB::GetQueryResult("UPDATE `order` SET state='dealsoc_cancel' WHERE team_id={$id} AND state IN ('confirmed','pending', 'oncredit')");
	Session::Set('notice', 'Deal Off successful!');
	json(null, 'refresh');
}elseif ( $action == 'partnerhead' ) {
	$partner = Table::Fetch('partner', $id);
	$head = ($partner['head']==0) ? time() : 0;
	Table::UpdateCache('partner', $id, array( 'head' => $head,));
	$tip = $head ? 'Set Top Business Success' : 'Top Business success Cancel';
	Session::Set('notice', $tip);
	json(null, 'refresh');
}
elseif ( 'cacheclear' == $action ) {
	need_auth('admin');
	$root = DIR_COMPILED;
	$handle = opendir($root);
	$templatelist = array( 'default'=> 'default',);
	$clear = $unclear = 0;
	while($one = readdir($handle)) {
		if ( strpos($one,'.') === 0 ) continue;
		$onefile = $root . '/' . $one;
		if ( is_dir($onefile) ) continue;
		if(@unlink($onefile)) { $clear ++; }
		else { $unclear ++; }
	}
	json("Successful, clear the cache files {$clear}，Not Clear {$unclear}", 'alert');
}