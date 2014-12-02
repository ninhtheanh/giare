<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

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
	"state IN ('confirmed', 'pending')",
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
$id = abs(intval($_GET['id'])); if ($id) $condition['id'] = $id;
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
} else { $city_id = $city['id']; }

$dist_id = $_GET['dist_id'];
if(!empty($dist_id)){
	foreach($dist_id as $value){
		$list_dist_id .= "'".$value."'".",";
	}
	$list_dist_id = trim($list_dist_id,",");
	$condition[] = "dist_id IN (".$list_dist_id.")";
}else{
	$dist_id = null;
	//$condition[] = "isnull(add_street)";
}

$ward_id = $_GET['ward_id'];
if(!empty($ward_id)){
	foreach($ward_id as $value){
		$list_ward_id .= "'".$value."'".",";
	}
	$list_ward_id = trim($list_ward_id,",");
	$condition[] = "ward_id IN (".$list_ward_id.")";
}else{
	$ward_id = null;
	//$condition[] = "isnull(add_street)";
}

$add_street = $_GET['add_street'];
if(!empty($add_street)){
	foreach($add_street as $value){
		$list_add_street .= "'".$value."'".",";
	}
	$list_add_street = trim($list_add_street,",");
	$condition[] = "add_street IN (".$list_add_street.")";
}else{
	$add_street = null;
	//$condition[] = "isnull(add_street)";
}
/* end fiter */
//data posted ------------------------------------------------------------------------------
if(isset($_POST['delivery']))
{
	
	$team_id = abs(intval($_POST['team_id']));
	$dist_id = abs(intval($_POST['dist_id']));
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
	
	//create shipping invoice	------------------------------------------------------------------
	//$city_name = DB::GetQueryResult("SELECT name FROM category WHERE id='".$city_id."' AND zone='city'");	
	//$dist_name = DB::GetQueryResult("SELECT dist_name FROM district WHERE dist_id='".$dist_id."'");	
	//ship_out - insert ship_out, ship_out_detail and save ship log
	$rs = array(
	'out_code' => $delivery_code,
	'creator' => $login_user_id,
	'created' => date('Y-m-d H:i:s',time()),
	'city' => $city_id,			
	'dist' => $list_dist_id,	
	'ward' => $list_ward_id,
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
				
				//ship_out_data
				$rs = array(
				'out_id' => $ship_out_id,
				'order_id' => $orders[$i]['id'],
				'deal_id' => $orders[$i]['team_id'],
				'quantity' => $orders[$i]['quantity'],			
				'amount' => $orders[$i]['origin'],	
				'state' => 'delivered',
				'cus_name' => $orders[$i]['realname'],
				'cus_address' => $orders[$i]['address'],	
				'cus_phone' => $orders[$i]['mobile'],	
				'cus_notes' => $orders[$i]['remark'],	
				'notes' => $orders[$i]['notes'],	
				);
				
				DB::Insert('ship_out_data', $rs);
	
				//save order history
				$ship_name = DB::GetQueryResult("SELECT shipper_name FROM shipper WHERE id='".$shipper_id."'");		
				save_order_history($orders[$i]['id'],'delivered',$ship_name['shipper_name']);
			}			
		
		}	
	}	
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
	redirect( WEB_ROOT . "./delivered.php?city_id={$city_id}&dist_id={$dist_id}&delivery_time={$delivery_time}&delivery_code={$delivery_code}&order_id_list={$order_list_id}&shipper_id={$shipper_id}");
}
//option_street();

$count = Table::Count('order', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 60);
$total_voucher = Table::Count('order', $condition, 'quantity');
$orders = DB::LimitQuery('order', array(
	'condition' => $condition,
	'order' => 'ORDER BY dist_id ASC, ward_id ASC, add_street ASC, id_address_list ASC, id DESC',
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

include template('manage_order_confirmed');