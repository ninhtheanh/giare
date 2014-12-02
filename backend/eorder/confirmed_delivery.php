<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
need_manager();
need_auth('order');
if(isset($_POST['delivery'])){
	$team_id = abs(intval($_POST['team_id']));
	$distid = abs(intval($_POST['dist_id']));
	$city_id = abs(intval($_POST['city_id']));
	$shipperid = abs(intval($_POST['shipper_id']));
	$delivery_time = abs(intval($_POST['delivery_time']));
	$order_list_id = implode(",",$_POST['myinput']);
}else{
	$order_list_id = $_GET['order_id_list'];
	$team_id = abs(intval($_GET['team_id']));
	$distid = abs(intval($_GET['dist_id']));
	$city_id = abs(intval($_GET['city_id']));
	$shipperid = abs(intval($_GET['shipper_id']));
	$delivery_time = abs(intval($_GET['delivery_time']));
}
$condition = array(
	'credit = 0',
	'team_id > 0',
	'shipper_id > 0',
	"state IN ('pending','canceled','pay')",
	'id IN ('.$order_list_id.')',
);
if ($team_id) {
	$condition['team_id'] = $team_id;
} else {$team_id = null; }
if ($distid) {
	$condition['dist_id'] = $distid;
} else { $distid = null; }
if($cityid) {
	$condition['city_id'] = $city_id;
} else { $city_id = null;}

if($shipperid) {
	$condition['shipper_id'] = $shipperid;
} else {$shipperid = null; }
if($delivery_time) {
	$condition['delivery_time'] = $delivery_time;
} else { $delivery_time = time(); }
$delivery_code = strval($_GET['delivery_code']);
if ($delivery_code) { 
	$condition['delivery_code'] = $delivery_code;
}
$count = Table::Count('order', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 25);
$total_voucher = Table::Count('order', $condition, 'quantity');
$orders = DB::LimitQuery('order', array(
	'condition' => $condition,
	'order' => 'ORDER BY delivery_time DESC, id DESC',
	/*'size' => $pagesize,
	'offset' => $offset,*/
));

if($distid){
	$dist = ename_dist($distid);
	$dist_id = $distid;
}else{
	$dist = ename_dist($orders[0]['dist_id']);
	$dist_id = $orders[0]['dist_id'];
}
$shipper = ename_shipper($orders[0]['shipper_id']);
$team_ids = Utility::GetColumn($orders, 'team_id');
$teams = Table::Fetch('team', $team_ids);
//$partner = Table::Fetch('partner', $team_ids);

//$pid = $team_ids[0];

//$partner = Table::Fetch('partner', $teams['partner_id']);

if(!empty($dist['dist_name']) && !empty($shipper['shipper_name'])){
	$title = "to ".$dist['dist_name']." - ".$city['name']." for ".$shipper['shipper_name'];
}

// create payment table and save log ---------------------------------------------------------------------------------
$r = DB::LimitQuery('ship_out', array('condition' => array('out_id'=>$delivery_code),));

//$in_code = 'I'.$login_user_id.$shipperid.date("His",time());
$in_code = 'I'.$r[0]['out_id'];
$rs = array(	
	'in_code' => $in_code,
	'out_id' => $delivery_code,
	'creator' => $r[0]['creator'],
	'created' => $r[0]['created'],
	//'approver' => $login_user_id,
	//'approved' => date('Y-m-d H:i:s',time()),
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
		case 'pay': $orders[$k]['pays'] = $v['quantity']; break;
		case 'canceled': $orders[$k]['cancels'] = $v['quantity']; break;
		case 'pending': $orders[$k]['pendings'] = $v['quantity']; break;
	}
	
}

$sql = "SELECT deal_id,sum(quantity) as quantity ,amount/quantity as price, sum(amount) as amount,SUM(IF(state='pay',quantity,0)) AS pays,SUM(IF(state='canceled',quantity,0)) + SUM(IF(state='pending',quantity,0)) AS pendings FROM `ship_out_data` WHERE out_id=".$delivery_code." GROUP BY deal_id ;";

$iorders = DB::GetQueryResult($sql,false);

for($i=0;$i<count($iorders);$i++){
	//ship_in_data
	$rs = array(	
	'in_id' => $ship_in_id,	
	'deal_id' => $iorders[$i]['deal_id'],
	'quantity' => $iorders[$i]['quantity'],	
	'price' => $iorders[$i]['price'],			
	'amount' => $iorders[$i]['amount'],	
	'pays' =>  $iorders[$i]['pays'],	
	'pendings' => $iorders[$i]['pendings'],
	);
	
	DB::Insert('ship_in_data', $rs);	
}
	
//include template('manage_order_confirmed_delivery');
include template('manage_order_delivery_payment');
/*@header("Content-type: application/x-msdownload; charset=utf-8");
@header("Content-Disposition: attachment; filename=order_delivery_shipper_".date("YmdHis").".doc");
@header("Pragma: no-cache");
@header("Expires: 0");
$data = str_replace("/var/www/hotdeal.vn/httpdocs/include/compiled/manage_order_delivery_shipper_export_word.php","",template('manage_order_delivery_shipper_export_word'));
print($data);	*/
