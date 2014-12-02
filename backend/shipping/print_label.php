<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('order');

$delivery_code = abs(intval($_GET['delivery_code']));
if(!$delivery_code || !(DB::Exist('ship_out', array('out_id='.$delivery_code)))) {
	die('Mã bàn giao không tồn tại');
}
//DB::$mDebug=true;
$sql = "SELECT * FROM `order` WHERE ship_id=".$delivery_code." ORDER BY street_name, dist_id, ward_id ASC, id DESC";

$rs = DB::GetQueryResult($sql,false);

$team_ids = Utility::GetColumn($rs, 'team_id');
$teams = Table::Fetch('team', $team_ids);
$dist = DB::GetQueryResult("SELECT dist_name FROM district WHERE dist_id=".$rs[0]['dist_id'],false);
$dist_name = $dist[0]['dist_name'];


$qcity = DB::GetQueryResult("SELECT name FROM countries_state WHERE id=".$rs[0]['city_id'],false);
$city_name = $qcity[0]['name'];

include template('manage_order_print');