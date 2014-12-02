<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$_config_payment_online = array(5);
$order_id = $id = abs(intval($_GET['id']));
$user_id = abs(intval($_GET['uid']));
if(!$order_id || !($order = Table::Fetch('order', $order_id))) {
	redirect( WEB_ROOT. '/index.php');
}

if ($order['user_id'] != $user_id) {
	redirect( WEB_ROOT . "/team.php?id={$order['team_id']}");
}

$team = Table::Fetch('team', $order['team_id']);
team_state($team);
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
		}elseif($v['verified']=='N'){
			$tid = $order['team_id'];
			echo "<script> alert('Vui lòng kiểm tra mail và bấm vào liên kết xác nhận để nhận mã dự thưởng');window.location.href='/team/verifyurl.php?id={$tid}';</script>";
		}
	}
}else{
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
	Table::UpdateCache('order', $order['id'], array(
		'money' => 0,
		'state' => 'pay',
		'credit' => 0,
		'pay_time' => time(),
	));

	ZTeam::BuyOne($order);
	
	$em =  DB::GetQueryResult("SELECT email FROM `user` WHERE id=".$user_id);
	$order['email'] = $enc->decrypt('@4!@#$%@', $em['email']);
	$email[] = $enc->decrypt('@4!@#$%@', $em['email']);
	$subject = 'Dealsoc.vn - Bạn đã tham gia thành công chương trình "Miễn phí 01 năm mua sắm trên web: www.dealsoc.vn"';
	//$content = render('order_email_promotion_confirm', $order);
	$content = render('order_email_promotion_confirm', $order);
	try{
		mail_custom($email, $subject, $content);
		Session::Set('notice', "Email xác nhận đơn hàng đã được gởi. Vui lòng check mail của bạn.");
	}catch(Exception $e) {
		Session::Set('error', 'Gởi email xác nhận đơn hàng thất bại. Vui lòng thử lại sau:'. $e->getMessage());
	}
	unset($_SESSION["qty"]);
	die(include template('order_promotion_success'));
}