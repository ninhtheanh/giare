<?php

require_once(dirname(dirname(__FILE__)) . '/app.php');

$id = abs(intval($_GET['id']));

$team = Table::Fetch('team', $id);
if ( !$team || $team['begin_time']>time() ) {
	/*Session::Set('error', 'Buy item does not exist');*/
	Session::Set('error', 'Deal bạn mua không tồn tại');
	redirect( WEB_ROOT . '/index.php' );
}
$ex_con = array(
	'user_id' => $login_user_id,
	'team_id' => $team['id'],
	'state' => 'pay',
);

$order = DB::LimitQuery('order', array(
	'condition' => $ex_con,
	'one' => true,
));
$v = checkVerified($login_user_id,$id);
$oid = checkOrderId($login_user_id,$id);
if((int)$oid['id']==0){
	redirect(WEB_ROOT."/{$city['slug']}/".seo_url($team['short_title'],$team['id'],$url_suffix));
	exit();
}
if((int)$oid['id']>0 && $id==$id_promotion  && $v['verified']=='Y'){
	redirect(WEB_ROOT."/order/pay.php?id={$oid['id']}");
	exit();
}

//buyonce
if (strtoupper($team['buyonce'])=='Y' && $id!=$id_promotion) {
	$ex_con['state'] = 'pay';
	if ( Table::Count('order', $ex_con) ) {
		if($id==$id_promotion){
			redirect(WEB_ROOT."/order/pay.php?id={$oid['id']}");
			exit();
		}else{
			Session::Set('error', 'Deal này bạn đã mua rồi, vui lòng xem và mua deal khác!!');
			redirect( WEB_ROOT . "/team.php?id={$id}"); 
		} 
	}
}

//peruser buy count
if ($team['per_number']>0) {
	$now_count = Table::Count('order', array(
		'user_id' => $login_user_id,
		'team_id' => $id,
		//'state' => 'pay',
	), 'quantity');
	$team['per_number'] -= $now_count;
	if ($team['per_number']<=0){
		if($id==$id_promotion  && $v['verified']=='Y'){
			redirect(WEB_ROOT."/order/pay.php?id={$oid['id']}");
			exit();
		}
		if($id!=$id_promotion){
			Session::Set('error', 'Deal này bạn đã mua rồi, vui lòng xem và mua deal khác!!!');
			redirect( WEB_ROOT . "/team.php?id={$id}"); 
		} 
	}
}

include template('team_activecode');