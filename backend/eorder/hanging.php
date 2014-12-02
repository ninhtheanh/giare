<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
require_once(dirname(__FILE__) . '/current.php');
need_manager();
need_auth('order');

$t_con = array(
	'begin_time < '.time(),
	'end_time > '.time(),
	
);
$teams = DB::LimitQuery('team', array('condition'=>$t_con));
$t_id = Utility::GetColumn($teams, 'id');

$condition = array(
	/*'team_id' => $t_id,*/
	'team_id > 0',
	"state='hanging'",
);
/* filter --------------------------------------------*/
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
if ($team_id) {
	$condition[] = "team_id IN ($team_id)";
} else { $team_id = null; }

if ($mobile) { 
	$condition['mobile']=$mobile;
}

$city_id = abs(intval($_GET['city_id']));
if($city_id) {
	$condition['city_id'] = $city_id;
} else { $city_id = $city['id'];$condition['city_id']=$city['id']; }

$dist_id = $_GET['dist_id'];
if(!empty($dist_id)){
	foreach($dist_id as $value){
		$list_dist_id .= $value.",";
	}
	$list_dist_id = trim($list_dist_id,",");
	$condition[] = "dist_id IN (".$list_dist_id.")";
}else{
	$dist_id = null;
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
}

$street_name = $_GET['add_street'];
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
	//create shipping invoice------------------------------------------------------------------
	/*$city_name = DB::GetQueryResult("SELECT name FROM category WHERE id='".$city_id."' AND zone='city'");	
	$dist_name = DB::GetQueryResult("SELECT dist_name FROM district WHERE dist_id='".$dist_id."'");	
	ship_out - insert ship_out, ship_out_detail and save ship log*/
	
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
				$dist = ename_dist($orders[$i]['dist_id']);
				$wardname = wardname($orders[$i]['dist_id'],$orders[$i]['ward_id']);
				$cus_address = rtrim($orders[$i]['address'],",").", ".$wardname['ward_name'].", ".$dist['dist_name'];
				//ship_out_data
				$rs = array(
					'out_id' => $ship_out_id,
					'order_id' => $orders[$i]['id'],
					'deal_id' => $orders[$i]['team_id'],
					'quantity' => $orders[$i]['quantity'],			
					'amount' => $orders[$i]['origin'],	
					'state' => 'delivered',
					'cus_name' => $orders[$i]['realname'],
					'cus_address' => rtrim($cus_address,","),
					'street' => $orders[$i]['street_name'],	
					'cus_phone' => $orders[$i]['mobile'],	
					'cus_notes' => $orders[$i]['remark'],	
					'notes' => $orders[$i]['notes'],
					'dist_id' => (int)$orders[$i]['dist_id'],
					'ward_id' => (int)$orders[$i]['ward_id'],
					'city_id' => (int)$orders[$i]['city_id'],	
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

$count = Table::Count('order', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 60);
$total_voucher = Table::Count('order', $condition, 'quantity');
$orders = DB::LimitQuery('order', array(
	'condition' => $condition,
	'order' => 'ORDER BY id ASC, dist_id ASC, ward_id ASC, street_name ASC, id_address_list ASC',
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

//shippers with valid delivery
//hai nhan vien DB (128,129) duoc phep quet bien ban ban giao khi chua tra ban giao
$q = DB::GetQueryResult("SELECT DISTINCT(shipper) as id FROM ship_in WHERE locked='N' AND shipper NOT IN (128,129,130)",false);
$q = Utility::AssColumn($q, 'id');
$shippers = array_diff_key($allshipper,$q);
include template('manage_order_hanging');