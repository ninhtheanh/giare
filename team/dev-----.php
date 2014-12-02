<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$verify = DB::GetQueryResult("SELECT * FROM verify_code WHERE `verified` = 'N' AND team_id=".$id_promotion." ORDER BY cus_id ASC", false);

foreach($verify as $key => $value){
	$code = base64_encode($value['verify_code']."-".$value['cus_id']);
	$user = DB::GetQueryResult("SELECT * FROM user WHERE id=".$value['cus_id']);
	Table::UpdateCache('verify_code', $value['id'], array(
		'verified' => 'Y',
	));
	$create_time = time();
	$order = DB::GetQueryResult("SELECT * FROM `order` WHERE `user_id` = '".$user['id']."' AND team_id=".$id_promotion);
	if(!$order){
		$sql = "INSERT INTO `order` (`user_id`, `team_id`, `city_id`, `dist_id`, `ward_id`, `id_address_list`, `house_number`, `street_name`, `address`, `realname`, `mobile`, quantity, create_time, pay_time, state, express) VALUES ('".$user['id']."', '287', '".$user['city_id']."', '".$user['dist_id']."', '".$user['ward_id']."', '0', '".$user['house_number']."', '".$user['street_name']."', '".$user['address']."', '".$user['realname']."', '".$user['mobile']."', 1, '".$create_time."', '".$create_time."', 'pay', 'N')";
		DB::Query($sql);
	}

	$checkcode = DB::GetQueryResult("SELECT maso FROM masoduthuong WHERE team_id='".$order['team_id']."' AND order_id='".$order['id']."' AND user_id = '".$order['user_id']."'");
	if($checkcode['maso']==''){
		DB::Insert('masoduthuong',array(
			'order_id' => $order['id'],
			'fullname' => $order['realname'],
			'address' => $order['address'],
			'telephone' => $order['mobile'],
			'team_id' => $order['team_id'],
			'user_id' => $order['user_id'],
		));
		$invite =  DB::GetQueryResult("SELECT user_id FROM invite WHERE other_user_id=".$order['user_id']." AND team_id=".$id_promotion);
		
		if((int)$invite['user_id']>0){
			$check_orderid =  DB::GetQueryResult("SELECT order_id FROM masoduthuong WHERE user_id=".$invite['user_id']. "AND team_id=".$id_promotion." AND status='donation'");
			if((int)$check_orderid['order_id']==0){
				DB::Insert('masoduthuong',array(
					'order_id' => $order['id'],
					'fullname' => '',
					'address' => '',
					'telephone' => '',
					'team_id' => $order['team_id'],
					'user_id' => $invite['user_id'],
					'status' => 'donation',
				));
			}
			$maso = DB::GetQueryResult("SELECT maso FROM masoduthuong WHERE team_id=".$id_promotion." AND user_id=".$invite['user_id']." AND status='donation'");
		}else{
			$maso = DB::GetQueryResult("SELECT maso FROM masoduthuong WHERE team_id=".$id_promotion." AND user_id=".$order['user_id']." AND status='granted'");
		}
		
	}
	$order['maso'] = $maso['maso'];
	
}

?>