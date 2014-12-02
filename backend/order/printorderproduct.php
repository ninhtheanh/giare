<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
need_manager();
need_auth('eorder');
//DB::$mDebug = true;
$t_con = array(
	/*'begin_time < '.time(),
	'end_time > '.time(),*/
	"`status`='Y'"
	
);
$teams = DB::LimitQuery('team', array('condition'=>$t_con));
$t_id = Utility::GetColumn($teams, 'id');

$condition = array(
	'team_id' => $t_id,
	'team_id > 0',
	"state IN ('printeditem')",
	"service NOT IN ('cashoffice')",
);
/* filter --------------------------------------------*/
//echo strtotime("2011-01-01 00:00:00");
$uemail = strval($_GET['uemail']);
if ($uemail) {
	$field = strpos($uemail, '@') ? 'email' : 'username';
	$field = is_numeric($uemail) ? 'id' : $field;
	$uuser = Table::Fetch('user', $uemail, $field);
	if($uuser) $condition['user_id'] = $uuser['id'];
	else $uemail = null;
}
//$id = abs(intval($_GET['id'])); if ($id) $condition['id'] = $id;
$id = strval($_GET['id']); if($id)	$condition[] = "id IN ($id)";
$team_id = strval($_GET['team_id']);
$delivery_properties = $_GET['delivery_properties'];
if ($team_id) {
	$condition[] = "team_id IN ($team_id)";
}elseif($delivery_properties!='all' && isset($_GET['delivery_properties'])) {
	$cond = array(
		'id' => $t_id,
		'delivery_properties' => $delivery_properties,
	);
	$t = DB::LimitQuery('team', array('condition'=>$cond));
	$tid = Utility::GetColumn($t, 'id');
	$list_tid = implode(",",$tid);
	$condition[] = "team_id IN ($list_tid)";
}else{ $team_id = null; }
$slbg = (int)$_GET['slbg'];
if($slbg){
	$slbg_filter = $slbg;
}else{$slbg_filter = 100;}

if ($mobile) { 
	$condition['mobile']=$mobile;
}

$payment_id = abs(intval($_GET['payment_id']));
if ($payment_id) {
	$condition['payment_id'] = $payment_id;
} else { $payment_id = null;}


$city_id = abs(intval($_GET['city_id']));
if($city_id) {
	$condition['city_id'] = $city_id;
} else { $city_id = null; }

if($city_id==556){
	unset($condition['city_id']);
	$condition[] = 'city_id<>11';
}

$payment_id = abs(intval($_GET['payment_id']));
if ($payment_id) {
	$condition['payment_id'] = $payment_id;
} else {  $payment_id = null;//$condition[] = 'payment_id!=3';
}


$dist_id = $_GET['dist_id'];
if(!empty($dist_id)){
	foreach($dist_id as $value){
		$list_dist_id .= $value.",";
	}
	$list_dist_id = trim($list_dist_id,",");
	$condition[] = "dist_id IN (".$list_dist_id.")";
}else{
	$dist_id = null;
	//$condition[] = "isnull(street_name)";
}
$ward_id = $_GET['ward_id'];
if(!empty($ward_id)){
	foreach($ward_id as $value){
		$list_ward_id .= $value.",";
	}
	$list_ward_id = trim($list_ward_id,",");
	$condition[] = "ward_id IN (".$list_ward_id.")";
}else{
	$ward_id = null;
	//$condition[] = "isnull(street_name)";
}

$street_name = $_GET['street_name'];
if(!empty($street_name)){
	foreach($street_name as $value){
		$list_add_street .= "'".$value."'".",";
	}
	$list_add_street = trim($list_add_street,",");
	$condition[] = "street_name IN (".$list_add_street.")";
}else{
	$street_name = null;
	//$condition[] = "isnull(street_name)";
}
$is_home = abs(intval($_GET['is_home']));
if($is_home) {
	$condition['is_home'] = 'yes';
	$checked = "checked";
} else { $is_home = ''; $checked='';}

$state = $_GET['state'];
if(!empty($state) && $state!='all'){	
	$condition['state'] = $state;
}

$cbday = strval($_GET['cbday']);
$ceday = strval($_GET['ceday']);

if ($cbday) { 
	$cbtime = strtotime($cbday." 00:00:00");
	$condition[] = "create_time >= '{$cbtime}'";
}
if ($ceday) { 
	$cetime = strtotime($ceday." 23:59:59");
	$condition[] = "create_time <= '{$cetime}'";
}

/* end fiter */
//data posted - do delivery ------------------------------------------------------------------------------
if(isset($_POST['delivery']))
{	
	$team_id = abs(intval($_POST['team_id']));
	/*$ward_id = strval($_POST['ward_id']);
	$dist_id = strval($_POST['dist_id']);*/
	$city_id = abs(intval($_POST['city_id']));
	$shipper_id = abs(intval($_POST['shipper_id']));
	$order_list_id = implode(",",$_POST['myinput']);
	$order_state = DB::GetQueryResult("SELECT state FROM `order` WHERE id IN ('".$order_list_id."') AND state='delivered'");
	if(!empty($order_state)){
		die('<font color=red>Danh sách đơn hàng đã chọn có đơn hàng đã bàn giao rồi. Vui lòng chọn lại danh sách để bàn giao.</font><a href="./confirmed.php">Quay về</a>');
		//redirect( WEB_ROOT .$_SERVER['REQUEST_URI']);	
	}
	$id = explode(",",$order_list_id);
	if($login_user_id<10){
		$loginuserid = "0".$login_user_id;
	}else{
		$loginuserid = $login_user_id;	
	}
	if($shipper_id<10){
		$shipperid = "0".$shipper_id;
	}else{
		$shipperid = $shipper_id;
	}	
	
	$delivery_code = 'O'.$loginuserid.$shipperid.date("His",time());
	$delivery_time = time();	
	//create shipping invoice	------------------------------------------------------------------
	//$city_name = DB::GetQueryResult("SELECT name FROM category WHERE id='".$city_id."' AND zone='city'");	
	//$dist_name = DB::GetQueryResult("SELECT dist_name FROM district WHERE dist_id='".$dist_id."'");	
	//ship_out - insert ship_out, ship_out_detail and save ship log
	$rs = array(
		'out_code' => $delivery_code,
		'creator' => $login_user_id,
		'created' => date('Y-m-d H:i:s',time()),
		'city' => $city_id,			
		'shipper' => $shipper_id,	
	);		
	
	if(DB::Insert('ship_out', $rs))
	{
		$ship_out_id = mysql_insert_id();
		//ship_log
		if(save_ship_log($ship_out_id,0,'BANGI'))
		{			
			//orders				
			$orders = DB::LimitQuery('order', array(
				'condition' => array("id IN ($order_list_id)"),		
			));
			
			for($i=0;$i<count($orders);$i++){	
	
				Table::UpdateCache('order', $orders[$i]['id'], array(
					'state' => 'delivered',
					'delivery_time' => $delivery_time,
					'shipper_id' => $shipper_id,
					'admin_id'=>$login_user_id,
					'delivery_code' => $ship_out_id,
					'ship_id' => $ship_out_id,
				));	
				if((int)$orders[$i]['bdist_id']>0){	
					$dist = ename_dist($orders[$i]['bdist_id']);
				}else{
					$dist = ename_dist($orders[$i]['dist_id']);
				}
				$wardname = wardname($orders[$i]['bdist_id'],$orders[$i]['bward_id']);
				if(empty($wardname)){
					$wardname = wardname($orders[$i]['dist_id'],$orders[$i]['ward_id']);
				}
				$note_address = "";
				if($orders[$i]['bnote_address']!=''){
					$note_address = $orders[$i]['bnote_address'].",";	
				}else{
					$note_address = $orders[$i]['note_address'].",";
				}
				if($orders[$i]['baddress']!=''){
					$address = $orders[$i]['baddress'].",";	
				}else{
					$address = $orders[$i]['address'].",";
				}
				$realname = ($orders[$i]['brealname']) ? $orders[$i]['brealname'] : $orders[$i]['realname'];
				
				$mobile = ($orders[$i]['bmobile']) ? $orders[$i]['bmobile'] : $orders[$i]['mobile'];
				
				$cus_address = rtrim($note_address.$address,",").", ".$wardname['ward_name'].", ".$dist['dist_name'];
				//ship_out_data
				$rs = array(
					'out_id' => $ship_out_id,
					'order_id' => $orders[$i]['id'],
					'deal_id' => $orders[$i]['team_id'],
					'quantity' => $orders[$i]['quantity'],			
					'amount' => $orders[$i]['origin'],	
					'state' => 'delivered',
					'cus_name' => $realname,
					'cus_address' => rtrim($cus_address,","),
					'street' => $orders[$i]['bstreet_name'],	
					'cus_phone' => $mobile,	
					'cus_notes' => trim($orders[$i]['remark']." ".$orders[$i]['remark2']),	
					'notes' => $orders[$i]['notes'],
					'dist_id' => (int)$orders[$i]['bdist_id'],
					'ward_id' => (int)$orders[$i]['bward_id'],
					'city_id' => (int)$orders[$i]['bcity_id'],	
				);
				
				DB::Insert('ship_out_data', $rs);
	
				//save order history
				$ship_name = DB::GetQueryResult("SELECT shipper_name FROM shipper WHERE id='".$shipper_id."'");		
				save_order_history($orders[$i]['id'],'delivered',$ship_name['shipper_name']);
			}			
		
		}	
	}	
	
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
		'shipper' => $r[0]['shipper'],			
		'locked' => 'N',
	);	

	if(DB::Insert('ship_in', $rs))
	{
		$ship_in_id = mysql_insert_id();	
		//ship_log	
		save_ship_log($delivery_code,$ship_in_id,'NOPTI');
	}
	
	foreach($orders as $k=>$v)
	{
		switch($v['state'])
		{
			case 'pay': $orders[$k]['pays'] = $v['quantity_successful']; break;
			case 'canceled': $orders[$k]['cancels'] = $v['quantity']; break;
			case 'pending': $orders[$k]['pendings'] = $v['quantity']; break;
		}
		
	}
	$sql = "SELECT deal_id,sum(sod.quantity) as quantity ,amount/sod.quantity as price, sum(amount) as amount, SUM(IF(o.state='pay',quantity_successful,0)) AS pays FROM `ship_out_data` sod LEFT JOIN `order` o ON (sod.order_id=o.id)  WHERE out_id=".$delivery_code." GROUP BY deal_id ;";
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
	
	//insert order_delivery_shipper
	if(!empty($order_list_id) && $shipper_id>0){
	
		$ods = array(
			'shipper_id' => $shipper_id,
			'delivery_code' => $ship_out_id,
			'delivery_time' => date('Y-m-d H:i:s',time()),
			'list_order_id' => $order_list_id,			
		);		
		DB::Insert('order_delivery_shipper', $ods);
	}
	// self redirect ---------------------------------------------
	/*redirect( WEB_ROOT . "./delivered.php?city_id={$city_id}&dist_id={$dist_id}&delivery_time={$delivery_time}&delivery_code={$delivery_code}&order_id_list={$order_list_id}&shipper_id={$shipper_id}");*/
	
	redirect( WEB_ROOT . "/backend/shipping/ship_out_data.php?out_id={$ship_out_id}");
}
//option_street();


// init data----------------------------------------------------------------

$count = Table::Count('order', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, $slbg_filter);
$total_voucher = Table::Count('order', $condition, 'quantity');
//DB::$mDebug=true;
$orders = DB::LimitQuery('order', array(
	'condition' => $condition,
	//'order' => 'ORDER BY id ASC, dist_id ASC, ward_id ASC, street_name ASC, id_address_list ASC',
	'order' => ' ORDER BY street_name, house_number, MONTH(FROM_UNIXTIME(create_time)),DAY(FROM_UNIXTIME(create_time)), dist_id, ward_id, id_address_list',
	'size' => $pagesize,
	'offset' => $offset,
));



$pay_ids = Utility::GetColumn($orders, 'pay_id');
$pays = Table::Fetch('pay', $pay_ids);

$user_ids = Utility::GetColumn($orders, 'user_id');
$users = Table::Fetch('user', $user_ids);

$team_ids = Utility::GetColumn($orders, 'team_id');
$teams = Table::Fetch('team', $team_ids);

$order_ids = Utility::GetColumn($orders, 'id');
$order_id_list = implode(",",$order_ids);
//DB::$mDebug = true;



	include template('manage_eorder_product');

