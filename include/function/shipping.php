<?php
/* import other */
import('configure');
import('current');
import('utility');
import('mailer');
import('sms');
import('upgrade');
import('uc');
import('cron');
/*Begin order functions----------------------------------------------------------------------------------------------------*/
function save_ship_out($id,$state,$asign_to=NULL,$note=NULL) {
	global $login_user;	
	if(is_null($id) || is_null($state)) return;
	$arr = DB::GetQueryResult("SELECT period FROM order_status WHERE code='".$state."'");
	$status_expires = $arr['period'];	
	$now = time();
	$expires = ($status_expires>0) ? date('Y-m-d H:i:s',$now + $status_expires * 3600) : NULL;
	$rs = array(
		'order_id' => $id,
		'status_code' =>  $state,	
		'date' => date('Y-m-d H:i:s',$now),		
		'expires' => $expires,
		'assign_to' => $asign_to,			
		'note' => $note,	
		'user' => $login_user['username'],
	);
	//var_dump($rs);exit;
	return DB::Insert('order_history', $rs);	
}

/*End order functions----------------------------------------------------------------------------------------------------*/
set_error_handler('error_handler');
