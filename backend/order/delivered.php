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
	$team_id = strval($_GET['team_id']);
	$distid = abs(intval($_GET['dist_id']));
	$city_id = abs(intval($_GET['city_id']));
	$shipperid = abs(intval($_GET['shipper_id']));
	$delivery_time = abs(intval($_GET['delivery_time']));
}
$condition = array(
	'credit = 0',
	'shipper_id > 0',
	'state' => 'delivered',
	'id IN ('.$order_list_id.')',
);
if ($team_id) {
	$condition[] = "team_id IN ($team_id)";
} else {$team_id = null; }
if ($distid) {
	$condition['dist_id'] = $distid;
} else { $distid = null; }
if($cityid) {
	$condition['city_id'] = $city_id;
} else { $city_id = null;}

if($city_id==556){
	unset($condition['city_id']);
	$condition[] = 'city_id<>11';
}

if($shipperid) {
	$condition['shipper_id'] = $shipperid;
} else {$shipperid = null; }
if($delivery_time) {
	$condition['delivery_time'] = $delivery_time;
} else { $delivery_time = time(); }
$count = Table::Count('order', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 60);
$total_voucher = Table::Count('order', $condition, 'quantity');
$orders = DB::LimitQuery('order', array(
	'condition' => $condition,
	'order' => 'ORDER BY dist_id ASC, ward_id ASC, add_street ASC, id_address_list ASC, id DESC',
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

if($shipperid){
	$shipper_id = $shipperid;
	$shipper = ename_shipper($shipper_id);
}else{
	$shipper_id = $orders[0]['shipper_id'];
	$shipper = ename_shipper($orders[0]['shipper_id']);
}
$team_ids = Utility::GetColumn($orders, 'team_id');
$teams = Table::Fetch('team', $team_ids);
//$partner = Table::Fetch('partner', $team_ids);

/*$pid = $team_ids[0];

$partner = Table::Fetch('partner', $teams['partner_id']);*/

if(!empty($dist['dist_name']) && !empty($shipper['shipper_name'])){
	$title = "to ".$dist['dist_name']." - ".$city['name']." for ".$shipper['shipper_name'];
}
	
	include template('manage_order_delivery_shipper_export_word');
	/*@header("Content-type: application/x-msdownload; charset=utf-8");
	@header("Content-Disposition: attachment; filename=order_delivery_shipper_".date("YmdHis").".doc");
	@header("Pragma: no-cache");
	@header("Expires: 0");
	$data = str_replace("/var/www/hotdeal.vn/httpdocs/include/compiled/manage_order_delivery_shipper_export_word.php","",template('manage_order_delivery_shipper_export_word'));
	print($data);	*/
