<?php

require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
need_manager();
need_auth('order');
//DB::$mDebug = true;
//dont show locked delivery
if($_GET['delivery_code']>0 && $login_user['id']!=1)
{
	$locked = Table::Count('ship_in', array('out_id'=>$_GET['delivery_code'],'locked'=>'Y'));
	if($locked>0){
		die('<font color=red>Mã bàn giao ' . $_GET['delivery_code'] . ' đã đóng. không thể trả bàn giao.</font><a href="./delivery.php">Quay về</a>');
	}
}

if($_GET['delivery_code']>0){
	$condition = array(
		'shipper_id > 0',
		/*"state IN ('confirmed', 'pending', 'delivered')",
		'credit = 0',*/
		'team_id > 0',
	);
}else{
	$condition = array(
		'shipper_id > 0',
		'state' => 'delivered',
		/*'credit = 0',*/
		'team_id > 0',
	);
}

/* filter */
$uemail = strval($_GET['uemail']);
if ($uemail) {
	$field = strpos($uemail, '@') ? 'email' : 'username';
	$field = is_numeric($uemail) ? 'id' : $field;
	$uuser = Table::Fetch('user', $uemail, $field);
	if($uuser) $condition['user_id'] = $uuser['id'];
	else $uemail = null;
}
$id = abs(intval($_GET['id'])); if ($id) $condition['id'] = $id;

$team_id = abs(intval($_GET['team_id']));
if ($team_id) {
	$condition['team_id'] = $team_id;
} else { $team_id = null; }

$dist_id = abs(intval($_GET['dist_id']));
if ($dist_id) {
	$condition['dist_id'] = $dist_id;
} else { $dist_id = null; }

$city_id = abs(intval($_GET['city_id']));
if($city_id) {
	$condition['city_id'] = $city_id;
} else { $city_id = $city['id'];$condition['city_id'] = $city_id; }

$shipper_id = abs(intval($_GET['shipper_id']));
if($shipper_id) {
	$condition['shipper_id'] = $shipper_id;
} else { $shipper_id = null; }

$delivery_time = abs(intval($_GET['delivery_time']));
if($delivery_time) {
	$condition['delivery_time'] = $delivery_time;
} else { $delivery_time = 0; }

$cbday = strval($_GET['cbday']);
$ceday = strval($_GET['ceday']);
$pbday = strval($_GET['pbday']);
$peday = strval($_GET['peday']);
if ($cbday) { 
	$cbtime = strtotime($cbday);
	$condition[] = "create_time >= '{$cbtime}'";
}
if ($ceday) { 
	$cetime = strtotime($ceday);
	$condition[] = "create_time <= '{$cetime}'";
}
if ($pbday) { 
	$pbtime = strtotime($pbday);
	$condition[] = "pay_time >= '{$pbtime}'";
}
if ($peday) { 
	$petime = strtotime($peday);
	$condition[] = "pay_time <= '{$petime}'";
}
$mobile = strval($_GET['mobile']);
if ($mobile) { 
	$condition['mobile'] = $mobile;
}

$delivery_code = intval($_GET['delivery_code']);
if($delivery_code>0) {
	$sql = "SELECT order_id FROM ship_out_data WHERE out_id=".$delivery_code." ORDER BY dist_id,ward_id,street ASC, order_id DESC";
	$rs = DB::GetQueryResult($sql,false);
	for($i=0; $i<count($rs);$i++){
		$list_oid .= $rs[$i]['order_id'].", ";
	}	
	$listOid = rtrim($list_oid,", ");
	
	/*$sql_0 = "SELECT in_id FROM ship_in WHERE out_id=".$delivery_code;
	$rs_0 = DB::GetQueryResult($sql_0);
	if($rs_0['in_id']>0){
		$disable = "disabled=\"disabled\"";
	}else{
		$disable = "";
	}*/
}
/*echo $listOid;*/
if ($listOid) { 
	$condition[] = "id IN (".$listOid.")";
}
$request_uri = $_SERVER['REQUEST_URI'];
$sortby = strval($_GET['sortid']);
if ($sortby) { 
	$order_by = "ORDER BY id DESC";
}else{
	$order_by = "ORDER BY street_name, dist_id, ward_id ASC, id DESC";
	//$order_by = "ORDER BY dist_id,ward_id,street_name ASC, id DESC";
}

// load data--------------------------------------------------------------------------------------------------------------------------------------------------
$count = Table::Count('order', $condition);
$total_voucher = Table::Count('order', $condition, 'quantity');
$accept_id_pay = array(18,1,35379);
//12 tieng = 43200
if($_GET['delivery_code']>0){
	$ship_out_time = DB::GetQueryResult("SELECT DISTINCT delivery_time FROM `order` WHERE ship_id=".$_GET['delivery_code']);
	$accept_ship_in_time = $ship_out_time['delivery_time']+3600;
	if((time()<$accept_ship_in_time) && (!in_array($login_user['id'],$accept_id_pay))){
			Session::Set('notice', 'Biên bản bàn giao <b style="font-size:18px;font-family:Georgia, Arial, Times, serif">'.$_GET['delivery_code'].'</b> chưa được phép trả bàn giao');
			DB::Query("INSERT INTO log_ship_in(out_id,user_name,date_ship_in) VALUES('".$_GET['delivery_code']."', '".$login_user['username']."', '".date('Y-m-d H:i:s',time())."')");
			redirect( WEB_ROOT."/backend/order/delivery.php");
	}else{
		list($pagesize, $offset, $pagestring) = pagestring($count, 150);
		$orders = DB::LimitQuery('order', array(
			'condition' => $condition,
			'order' => $order_by,
			'size' => $pagesize,
			'offset' => $offset,
		));	
		$team_ids = Utility::GetColumn($orders, 'team_id');
		$teams = Table::Fetch('team', $team_ids);
		$orders_all = DB::LimitQuery('order', array(
			'condition' => $condition,
			'order' => 'ORDER BY delivery_time DESC, id DESC',
		));
		$order_ids = Utility::GetColumn($orders_all, 'id');
		$order_id_list = implode(",",$order_ids);
	}
}

// xu ly tra ban giao -----------------------------------------------------------------------------------
if(isset($_POST['process']))
{		
	unset($_POST['process']);
	$delivery_code = $_POST['delivery_code'];	
	//update ship_out set updater
	DB::Update('ship_out', $delivery_code, array('updater'=>$login_user_id,'updated'=>date('Y-m-d H:i:s',time())),'out_id');
	//ship_log		
	save_ship_log($delivery_code,0,'TRABA');
			
	$list_order_id_pay = implode(",",$_POST['orderid']);
	$id = explode(",",$list_order_id_pay);
	for($i=0;$i<count($id);$i++){
		$row = $_POST["row{$id[$i]}"];
		$note = $_POST["note{$id[$i]}"];
		$money = $_POST["money{$id[$i]}"];
		$date_received = $_POST["date_received_{$id[$i]}"];
		$qty_successful = $_POST["qty{$id[$i]}"];
		$quantity = $_POST["quantity{$id[$i]}"];
		$user = $_POST["user{$id[$i]}"];
		/*echo $id[$i]."--row value: ".$row."--note: ".$note."<br>";*/
		$qty_success = 0;
		if($row!=''){
			/*if($row=='canceled' && $money>0){
				Table::UpdateCache('user', $user, array(
					'money' => $money,
				));
				Table::UpdateCache('order', $oid, array(
					'money' => 0,
				));
			}else{
				if($row=='canceled' || $row=='pending'){
					$qty_success = 0;
				}else{
					if($qty_successful>0){
						$qty_success = $qty_successful;
					}else{
						$qty_success = $quantity;
					}	
				}
				Table::UpdateCache('order', $id[$i], array(
					'state' => $row,
					'notes' => $note,
					'quantity_successful' => $qty_success,
					'admin_id'=>$login_user_id,
				));
			}*/
			if($row=='canceled' || $row=='pending' || $row=='hanging'){
				$qty_success = 0;
			}else{				
				$qty_success = ($qty_successful>0) ? $qty_successful : $quantity;				
			}
			
			save_order_history($id[$i],$row,'',$note);
			//update ship_out.notes
			DB::Query("UPDATE ship_out_data SET state='".$row."', notes='".$note."', qty_successful='".$qty_success."', date_received='".$date_received."' WHERE order_id='".$id[$i]."' AND out_id='".$delivery_code."'");
			//payed orders will be pended for final confirm, other states will be sync with order table
			if($row!='pay')
			{
				DB::Update('order', $id[$i], array('state'=>$row));
			}
			//DB::Update('ship_out_data', $id[$i], array('state'=>$row,'notes'=>$note),'order_id');
		}
	}
	$vcode_post = $_POST['vcode'];
	for($i=0;$i<count($vcode_post);$i++){
		DB::Query("UPDATE voucher_code SET `status`='A' WHERE serial = ".(int)$vcode_post[$i]);
		/*Table::UpdateCache('voucher_code', $vcode_post[$i], array(
			'status' => 'A',
		));*/
	}
	/*URL Balance*/
	/*$url_open_balance = WEB_ROOT."./confirmed_delivery.php?shipper_id={$shipper_id}&team_id={$team_id}&dist_id={$dist_id}&city_id={$city_id}&order_id_list={$list_order_id_pay}&delivery_time={$delivery_time}&delivery_code={$delivery_code}&export=word";*/
	
	//check payment table - not existed insert - else update	
	
	$existed = Table::Count('ship_in', array('out_id'=>$delivery_code,'locked'=>'Y'));
	if($existed==0)
	{
		DB::Query('DELETE FROM ship_in WHERE out_id='.$delivery_code);		
		// create payment table and save log ---------------------------------------------------------------------------------
		$r = DB::LimitQuery('ship_out', array('condition' => array('out_id'=>$delivery_code)));
		
		//$in_code = 'I'.$login_user_id.$shipperid.date("His",time());
		$in_code = 'I'.$r[0]['out_id'];
		$rs = array(	
			'in_code' => $in_code,
			'out_id' => $delivery_code,
			'creator' => $r[0]['creator'],
			'created' => $r[0]['created'],
			/*'approver' => $login_user_id,
			approved' => date('Y-m-d H:i:s',time()),*/
			'city' => $city_id,
			'shipper' => $r[0]['shipper'],			
			'locked' => 'N',
		);	
	
		if(DB::Insert('ship_in', $rs)){
			$ship_in_id = mysql_insert_id();	
			//ship_log	
			save_ship_log($delivery_code,$ship_in_id,'NOPTI');
		}
		
		/*foreach($orders as $k=>$v){
			switch($v['state']){
				case 'pay': $orders[$k]['pays'] = $v['quantity_successful']; break;
				case 'canceled': $orders[$k]['cancels'] = $v['quantity']; break;
				case 'pending': $orders[$k]['pendings'] = $v['quantity']; break;
			}
			
		}*/
		$sql = "SELECT deal_id,sum(sod.quantity) as quantity ,amount/sod.quantity as price, sum(amount) as amount, SUM(IF(sod.state='pay',sod.qty_successful,0)) AS pays FROM `ship_out_data` sod WHERE out_id=".$delivery_code." GROUP BY deal_id;";
		$iorders = DB::GetQueryResult($sql,false);
		
		/*var_dump($iorders);
		exit();*/
		for($i=0;$i<count($iorders);$i++){
			//ship_in_data
			$pendings = $iorders[$i]['quantity'] - $iorders[$i]['pays'];
			$rs = array(	
				'in_id' => $ship_in_id,	
				'deal_id' => $iorders[$i]['deal_id'],
				'quantity' => $iorders[$i]['quantity'],	
				'price' => $iorders[$i]['price'],			
				'amount' => $iorders[$i]['amount'],	
				'pays' =>  $iorders[$i]['pays'],	
				'pendings' => $pendings,
			);
			DB::Insert('ship_in_data', $rs);	
		}
	}	
	
	$url_open_balance = WEB_ROOT."/backend/shipping/ship_in_data.php?in_id=".$ship_in_id;
	
	Session::Set('notice', 'Xác nhận trả bàn giao thành công. <a href="'.$url_open_balance.'"  style="color:#ff6600; font-weight:bold; font-size:16px;" target="_blank">Xuất bảng kê nộp tiền</a>');
	redirect( WEB_ROOT . $_SERVER['REQUEST_URI']);
}
/* end filter */
include template('manage_order_delivery');