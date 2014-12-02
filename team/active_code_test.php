<?php

require_once(dirname(dirname(__FILE__)) . '/app.php');

$id = abs(intval($_GET['did']));

$verifycode = base64_decode( trim( $_GET['code'] ) );
$code = explode("-",$verifycode);

$team = Table::Fetch('team', $id);
if ( !$team || $team['begin_time']>time() ) {
	/*Session::Set('error', 'Buy item does not exist');*/
	Session::Set('error', 'Deal bạn mua không tồn tại');
	redirect( WEB_ROOT . '/index.php' );
}
$ex_con = array(
	'mobile' => trim($_GET['mobile']),
	'team_id' => $team['id'],
	'state' => 'unpay',
);
$sess_post = $_SESSION["{$login_user_id}_{$team['id']}_POST"];
$order = DB::LimitQuery('order', array(
	'condition' => $ex_con,
	'one' => true,
));
//buyonce
if (strtoupper($team['buyonce'])=='Y') {
	$ex_con['state'] = 'pay';
	if ( Table::Count('order', $ex_con) ) {
		//Session::Set('error', 'you have bought this product，have a look at other products！');
		Session::Set('error', 'Bạn đã mua deal này, vui lòng xem deal khác![1]');
		redirect( WEB_ROOT . "/team.php?id={$id}"); 
	}
}

//peruser buy count
if ($team['per_number']>0) {
	$now_count = Table::Count('order', array(
		'mobile' => trim($_GET['mobile']),
		'team_id' => $id,
		//'state' => 'pay',
	), 'quantity');
	$team['per_number'] -= $now_count;
	if ($team['per_number']<=0){
		Session::Set('error', 'Bạn đã mua deal này rồi, vui lòng chọn mua deal khác![2]');
		redirect( WEB_ROOT . "/team.php?id={$id}"); 
	}
}
if(!$sess_post){
	$quantity = 1;
}else{
	$quantity = $order['quantity'];
}
//post buy
if($_GET){
	need_login();
	$verifycode = base64_decode( trim( $_GET['code'] ) );
	$code = explode("-",$verifycode);
	
	/*echo $verifycode;
	var_dump($code);
	exit();*/
	$vcode = checkVerifyCode($login_user_id,$id,$code[0]);
	var_dump($vcode);exit;
	if(!$vcode){
		echo "<script> alert('Mã xác nhận không đúng. Vui lòng kiểm tra lại');window.location.href='/team/buy.php?id={$id}';</script>";
	}else{
		Table::UpdateCache('verify_code', $vcode['id'], array(
			'verified' => 'Y',
		));
		if(isset($sess_post)){
			$table = new Table('order', $sess_post);
		}else{
			$table = new Table('order', $_GET);
		}
		$table->quantity = abs(intval($table->quantity));
		if ( $table->quantity == 0 ) {
			/*Session::Set('error', 'quantity is no less than 1');*/
			Session::Set('error', 'Số lượng không nhỏ hơn 1');
			redirect( WEB_ROOT . "/team/buy.php?id={$team['id']}");
		} 
		elseif ( $team['per_number']>0 && $table->quantity > $team['per_number'] ) {
			Session::Set('error', 'Bạn đã mua quá giới hạn！');
			redirect( WEB_ROOT . "/team.php?id={$id}"); 
		}
	
		if ($order && $order['state']=='unpay') {
			$table->SetPk('id', $order['id']);
		}
		
		$table->user_id = $login_user_id;
		$table->realname = $login_user['realname'];
		$table->state = 'unpay';
		$table->team_id = $team['id'];
		$table->city_id = $team['city_id'];
		$table->express = ($team['delivery']=='express') ? 'Y' : 'N';
		$table->fare = $table->express=='Y' ? $team['fare'] : 0;
		$table->price = $team['team_price'];
		$table->credit = 0;
	
		if ($table->id) {
			$eorder = Table::Fetch('order', $table->id);
			if ($eorder['state']=='unpay' 
					&& $eorder['team_id'] == $id
					&& $eorder['user_id'] == $login_user_id
			   ) {
				$table->origin = team_origin($team, $table->quantity);
				$table->origin -= $eorder['card'];
			} else {
				$eorder = null;
			}
		} 
		if (!$eorder){
			$table->SetPk('id', null);
			$table->create_time = time();
			$table->origin = team_origin($team, $table->quantity);
		}
		$table->address = $table->house_number." ".$table->street_name;
		$insert = array(
				'user_id', 'team_id', 'city_id', 'dist_id', 'ward_id', 'house_number', 'street_name', 'state', 
				'fare', 'express', 'origin', 'price',
				'address', 'note_address', 'zipcode', 'realname', 'mobile', 
				'quantity', 'create_time', 'remark', 'condbuy',
			);	
		
		if ($flag = $table->update($insert)) {
			$order_id = abs(intval($table->id));
			$order = Table::Fetch('order', $order_id);
			if (! ($order['pay_id'] && (preg_match('#-(\d+)-(\d+)-#', $order['pay_id'], $m) && ( $m[1] == $order['id'] && $m[2] == $order['quantity']) ))) {
				$randid = rand(1000,9999);
				$pay_id = "go-{$order['id']}-{$order['quantity']}-{$randid}";
				Table::UpdateCache('order', $order['id'], array(
					'pay_id' => $pay_id,
				));
			}
			redirect(WEB_ROOT  . "/order/pay.php?id={$order_id}");
		}
	}	
}
include template('team_activecode');