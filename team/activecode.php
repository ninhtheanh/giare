<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$id = abs(intval($_GET['did']));
$order_id = abs(intval($_GET['id']));
$user_id = abs(intval($_GET['uid']));
$team = Table::Fetch('team', $id);
if ( !$team || $team['begin_time']>time() ) {
	/*Session::Set('error', 'Buy item does not exist');*/
	Session::Set('error', 'Deal bạn mua không tồn tại');
	redirect( WEB_ROOT . '/index.php' );
}
$ex_con = array(
	'user_id' => $user_id,
	'team_id' => $team['id'],
	'state' => 'unpay',
);
$v = checkVerified($user_id,$id);
$oid = checkOrderId($user_id,$id);
$order = DB::LimitQuery('order', array(
	'condition' => $ex_con,
	'one' => true,
));

//buyonce
if (strtoupper($team['buyonce'])=='Y') {
	$ex_con['state'] = '';
	if ( Table::Count('order', $ex_con) ) {
		if($id==$id_promotion && $v['verified']=='Y'){
			redirect(WEB_ROOT."/order/active_successful.php?id={$oid['id']}&uid={$user_id}");
			exit();
		}else{
			//post buy
			if((int)$order_id>0 && (int)$user_id>0){
				//need_login();
				//$verifycode = base64_decode($_GET['code']);
				//$code = explode("-",$verifycode);
				
				/*echo $verifycode;
				var_dump($code);
				exit();*/
				$verifycode = $_GET['code'];
				$vcode = checkVerifyCode($id,$verifycode);
				if(!$vcode){
					echo "<script> alert('Mã xác nhận không đúng. Vui lòng kiểm tra lại');window.location.href='/team/buy.php?id={$id}';</script>";
				}else{
			
					Table::UpdateCache('verify_code', $vcode['id'], array(
						'verified' => 'Y',
					));
					redirect(WEB_ROOT  . "/order/active_successful.php?id={$order_id}&uid={$user_id}");
				}	
			}else{
				echo "<script> alert('Liên kết xác nhận không đúng. Vui lòng kiểm tra lại');window.location.href='/team/buy.php?id={$id}';</script>";
			}
		}
	}
}

include template('team_activecode');