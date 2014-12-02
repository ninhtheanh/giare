<?php
	require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

	need_manager();
	need_auth('order');
	$id = abs(intval($_GET['id']));
	$order = Table::Fetch('order', $id);
	if ( $_POST ){
		$table = new Table('order', $_POST);
		$uarray = array( 'realname', 'address', 'mobile', 'quantity', 'city_id', 'dist_id', 'ward_id', 'note_address', 'house_number', 'street_name','bcity_id', 'bdist_id', 'bward_id', 'bnote_address', 'notes', 'bhouse_number', 'bstreet_name', 'baddress','bmobile' ,'payment_id', 'shipping_id','shipping_cost','state');		$address = $_POST['house_number']." ".$_POST['street_name'];$baddress = $_POST['bhouse_number']." ".$_POST['bstreet_name'];
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
		$shipp = explode("-",$_POST['shipping_id']);
		$table->shipping_id = $shipp[0];
		$table->shipping_cost = $shipp[1];
		if(in_array($_POST['payment_id'],array(3))){
			$table->state = "oncredit";
		}else{
			$table->state = "unpay";	
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
			if($_POST['house_number'] || $_POST['street_name'] || $_POST['bhouse_number'] || $_POST['bstreet_name']){
				Table::UpdateCache('order', $order['id'], array(
					'origin' => $origin,
					'address' => $address,
					'baddress' => $baddress,
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
		redirect($_REQUEST['redirect']);
	}
	

	$user = Table::Fetch('user', $order['user_id']);
	$team = Table::Fetch('team', $order['team_id']);
	$dest = GetDestID($order['city_id'],$order['dist_id']);
	$b_dest = @$dest[2];
	if((int)@$dest[0]==0){
		$whereand = " ";
	}else	$whereand = " AND destination LIKE ('%".(int)@$dest[0]."%')";
	$q2 = DB::GetQueryResult("SELECT payment_id, adding_cost, adding_type, payment, description FROM payment_descriptions WHERE status='A' {$whereand} ORDER BY position", false);
	if(is_array($q2)){
		$payment_lst = "";
		foreach($q2 as $key=>$value){
			$payment_id = $value['payment_id'];
			$payment_name = strip_input($value['payment']);
			$payment_lst .="<option value=\"{$payment_id}\">{$payment_name}</option>";
		}
	}else{
		$payment_lst = "";
	}
	$payment_id = $order["payment_id"];
	$dests = GetDestID($order['bcity_id'],$order['bdist_id']);
	$s_dest = @$dests[2];
	if((int)@$dests[0]==0){
		$whereand = " ";
	}else $whereand = (int)@$dests[0];
	$q3 = DB::GetQueryResult("SELECT s.shipping_id, s.shipping_name, sr.destination_id FROM shippings as s, shipping_rates as sr WHERE s.shipping_id = sr.shipping_id AND s.status='A' AND destination_id IN ($whereand) GROUP BY s.shipping_id ORDER BY s.position", false);

	if(is_array($q3)){
		$shipping_name = "";
		$shipping_lst = "";
		foreach($q3 as $key=>$value){
			$shipping_id = $value['shipping_id'];
			$shipping_name = strip_input($value['shipping_name']);
			$shipping_cost = GetShippingCost($shipping_id, $value['destination_id'], $order['origin'], $order['total_weight']);
			$shipping_lst .="<option value=\"{$shipping_id}-{$shipping_cost}\">{$shipping_name}</option>";
		}
	}else{
		$shipping_lst = "";
	}

	include template('manage_order_edit');

?>