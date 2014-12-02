<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('order');

$id = abs(intval($_REQUEST['id']));
$order = Table::Fetch('order', $id);
$table = new Table('order', $_POST);
$uarray = array( 'realname', 'address', 'mobile', 'quantity', 'city_id', 'dist_id', 'ward_id', 'note_address', 'notes', 'house_number', 'street_name'); 
/*if(!empty($_POST['note_address'])){
	$address = $_POST['note_address'].", ".$_POST['house_number']." ".$_POST['street_name'];
}else{
*/	$address = $_POST['house_number']." ".$_POST['street_name'];
//}


if($_POST['date_received']!='' && $_POST['date_received'] >= date("Y-m-d", time())){
	$rs = array(
		'order_id' => $order['id'],
		'date_received' => $_POST['date_received'],
	);		
	DB::Insert('order_hanging', $rs);
	Table::UpdateCache('order', $order['id'], array(
		'state' => 'hanging',
	));
	Session::Set('notice', 'Order Hanging Successful');
	save_order_history($order['id'],'hanging','',"KH hẹn ngày: ".$_POST['date_received']);
	redirect(null);
	exit();
}
if(!$_POST['realname'] || !$address || !$_POST['quantity']) {
	Session::Set('error', 'Real name, Address, Quantity must be typed');
	redirect(null);
}
if($_POST['quantity']==0){
	Session::Set('error', 'The quantity must be greater than 0');
	redirect(null);
}


//update
if ( $order ) {
	
	if($_POST['quantity']<>$order['quantity']){
		$origin = $_POST['quantity']*$order['price'];
		$vcode = DB::GetQueryResult("SELECT serial_number, voucher_code FROM `voucher_code` WHERE order_id='".$order['id']."' AND team_id='".$order['team_id']."'", false);
		$group_id = DB::GetQueryResult("SELECT group_id FROM `team` WHERE id='".$order['team_id']."'");
		if((count($vcode)<$_POST['quantity'] || count($vcode)>$_POST['quantity']) && $group_id['group_id']==23 && $order['team_id']>=5){
			DB::Delete('voucher_code',array(
				'order_id' => $order['id'],
				'team_id'=>$order['team_id'],));
			$create_time = date("Y-m-d H:i:s");
			for($i=0;$i<$_POST['quantity'];$i++){
				$vid = Utility::GenSecret(6, Utility::CHAR_NUM);
				$vouchercode = Utility::VerifyCode($vid);
				$voucher_code = array(
					'order_id' => $order['id'],
					'team_id' => $order['team_id'],
					'user_id' => $order['user_id'],
					'realname' => $order['realname'],
					'voucher_code' => $vouchercode,
					'create_time' => $create_time,
				);
				DB::Insert('voucher_code', $voucher_code);
			}
		}
	}else{
		$origin = $order['origin'];
	}
	if ( $flag = $table->Update( $uarray ) ){
		$id_address_list = 0;
		if($_POST['is_update_address']==1){
			$list = check_address_list($_POST['dist_id'], $_POST['ward_id'], $_POST['address']);
			$street = check_street($_POST['street_name']);
			if($list['id']>0){
				Table::UpdateCache('address_list', $list['id'], array(
					'address' => $address,
					'dist_id' => $_POST['dist_id'],
					'ward_id' => $_POST['ward_id'],
				));
				$id_address_list = $list['id'];
			}else{
				DB::Insert('address_list',array(
					'address' => $address,
					'dist_id' => $_POST['dist_id'],
					'ward_id' => $_POST['ward_id'],
				));
				$id_address_list  = mysql_insert_id();
			}
			if($street['id']>0){
				Table::UpdateCache('street', $street['id'], array(
					'street_name' => $_POST['street_name'],
					'street_name_unsigned' => make_keyword($_POST['street_name']),
				));
			}else{
				DB::Insert('street',array(
					'street_name' => $_POST['street_name'],
					'street_name_unsigned' => make_keyword($_POST['street_name']),
				));
			}
			Table::UpdateCache('user', $order['user_id'], array(
				'address' => $address,
				'note_address' => $_POST['note_address'],
				'house_number' => $_POST['house_number'],
				'street_name' => $_POST['street_name'],
				'dist_id' => $_POST['dist_id'],
				'ward_id' => $_POST['ward_id'],
				'id_address_list' => $id_address_list,
			));
			/*$condition = array(
				'team_id' => $order['team_id'],
			);
			$total_voucher = Table::Count('order', $condition, 'quantity');
			Table::UpdateCache('team', $order['team_id'], array(
				'now_number' => $total_voucher,
			));*/
		}
		if($_POST['is_home_address']==1){
			Table::UpdateCache('order', $order['id'], array(
				'is_home' => 'yes',
			));
		}
		if($_POST['house_number'] || $_POST['street_name']){
			Table::UpdateCache('order', $order['id'], array(
				'origin' => $origin,
				'address' => $address,
				'note_address' => $_POST['note_address'],
				'house_number' => $_POST['house_number'],
				'street_name' => $_POST['street_name'],
				'id_address_list' => $id_address_list,
			));
		}else{
			Table::UpdateCache('order', $order['id'], array(
				'origin' => $origin,
				'note_address' => $_POST['note_address'],
				'house_number' => $_POST['house_number'],
				'street_name' => $_POST['street_name'],
				'id_address_list' => $id_address_list,
			));
		}
		Session::Set('notice', 'Order No. '.$id.' editing succeeded');
	} else {
		Session::Set('error', 'Order No. '.$id.' editing failed');
	}
	
	//save order history
	$note = $_POST['notes'];
	if($_POST['quantity']<>$order['quantity']) $note .= '. Qty change '.$order['quantity'].'-'.$_POST['quantity'];
	save_order_history($order['id'],'changed','',$note);
	//build add_street
	ZOrder::BuildAddStreet($order);
	
}
redirect(null);