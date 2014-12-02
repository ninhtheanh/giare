<?php
	require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

	need_manager();
	need_auth('order');
	$id = abs(intval($_GET['id']));
	$order = Table::Fetch('order', $id);
	if($order['paid_atm']==1 || (int)$order['transaction_id_nl']>0){
		$checked = "checked";	
	}else{
		$checked="";	
	}

	if ( $_POST ){
		$table = new Table('order', $_POST);
		$uarray = array( 'realname', 'address', 'mobile', 'quantity', 'city_id', 'dist_id', 'ward_id', 'note_address', 'house_number', 'street_name','bcity_id', 'bdist_id', 'bward_id', 'bnote_address', 'notes', 'bhouse_number', 'bstreet_name', 'baddress','bmobile' ,'payment_id', 'payment_cost', 'shipping_id','shipping_cost','state');
		$address = $_POST['house_number']." ".$_POST['street_name'];
		$baddress = $_POST['bhouse_number']." ".$_POST['bstreet_name'];
		if(isset($_POST['transaction_id_nl']) && (int)$_POST['transaction_id_nl']==0 && (int)$_POST['paid']==1){
			Session::Set('error', 'Vui lòng nhập mã giao dịch ngân lượng');
			redirect(null);
		}
		if(!$_POST['realname'] || !$address || !$_POST['quantity']) {
			Session::Set('error', 'Real name, Address, Quantity must be typed');
			redirect(null);
		}
		if($_POST['quantity']==0){
			Session::Set('error', 'The quantity must be greater than 0');
			redirect(null);
		}
		if($_POST['quantity']<>$order['quantity']){
			$origin = $_POST['quantity']*$order['price'];
			$total_weight = $_POST['quantity']*$_POST['weight'];
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
			$total_weight = $order['total_weight'];
		}
		$dests = GetDestID($_POST['bcity_id'],$_POST['bdist_id']);
		$s_dest = @$dests[2];
		if((int)@$dests[0]==0){
			$whereand = " ";
		}else $whereand = (int)@$dests[0];

		$ds = DB::GetQueryResult("SELECT s.shipping_id, sr.destination_id FROM shippings as s, shipping_rates as sr WHERE s.shipping_id = sr.shipping_id AND s.status='A' AND destination_id IN ($whereand) GROUP BY s.shipping_id ORDER BY s.position");

		if(is_array($ds)){
			$shipping_id = $ds['shipping_id'];
			$shipping_cost = GetShippingCost($shipping_id, $ds['destination_id'], $origin, $total_weight);
		}

		/*$shipp = explode("-",$_POST['shipping_id']);
		$table->shipping_id = $shipp[0];
		$table->shipping_cost = $shipp[1];*/
		
		$table->shipping_id = $shipping_id;
		$table->shipping_cost = $shipping_cost;
		if(in_array($_POST['payment_id'],array(3,5))){
			$table->state = "oncredit";
		}else{
			$table->state = $order['state'];	
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
			if($_POST['paid']==1 && !isset($_POST['transaction_id_nl'])){
				Table::UpdateCache('order', $order['id'], array(
					'state' => 'confirmed',
					'paid_atm' => 1,
				));
			}elseif($_POST['paid']==1 && isset($_POST['transaction_id_nl']) && (int)$_POST['transaction_id_nl']>0 ){
				Table::UpdateCache('order', $order['id'], array(
					'state' => 'confirmed',
					'transaction_id_nl' => (int)$_POST['transaction_id_nl'],
				));
			}
			if($_POST['house_number'] || $_POST['street_name'] || $_POST['bhouse_number'] || $_POST['bstreet_name']){
				Table::UpdateCache('order', $order['id'], array(
					'origin' => $origin,
					'total_weight' => $total_weight,
					'address' => $address,
					'baddress' => $baddress,
					'note_address' => $_POST['note_address'],
					'house_number' => $_POST['house_number'],
					'street_name' => $_POST['street_name'],
					'bhouse_number' => $_POST['bhouse_number'],
					'bstreet_name' => $_POST['bstreet_name'],
					'id_address_list' => $id_address_list,
				));
			}else{
				Table::UpdateCache('order', $order['id'], array(
					'origin' => $origin,
					'total_weight' => $total_weight,
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
		//if(in_array($order['ward_id'],array(313,316))){
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

	include template('manage_order_edit');

?>