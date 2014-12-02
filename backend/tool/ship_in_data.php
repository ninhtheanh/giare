<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('order');

$in_id = abs(intval($_GET['in_id']));

$sql = "SELECT updater,updated,s.*, d.* FROM ship_in AS s LEFT JOIN ship_in_data AS d USING(in_id) LEFT JOIN ship_out As so USING(out_id) WHERE in_id=".$in_id;
$rs = DB::GetQueryResult($sql,false);

$team_ids = Utility::GetColumn($rs, 'deal_id');
$teams = Table::Fetch('team', $team_ids);

$ids = Utility::GetColumn($rs, 'creator');
$creators = Table::Fetch('user',$ids);

$order_ids =DB::GetQueryResult("SELECT order_id FROM `ship_out_data` WHERE  out_id = ".$rs[0]['out_id'], false);
for($i=0; $i<count($order_ids);$i++){
	$orderid .= $order_ids[$i]['order_id'].", ";
}
$list_order_id = rtrim($orderid,", ");

$ids = Utility::GetColumn($rs, 'shipper');
$shippers = Table::Fetch('shipper',$ids);

$ids = Utility::GetColumn($rs, 'updater');
$updaters = Table::Fetch('user',$ids);

$ids = Utility::GetColumn($rs, 'approver');
$approvers = Table::Fetch('user',$ids);

//sumary
//$sql = "SELECT deal_id,sum(quantity) as qty,sum(amount) as amt FROM ship_out_data WHERE out_id=$out_id GROUP BY deal_id ORDER BY deal_id";
//r = DB::GetQueryResult($sql,false);

include template('shipping/ship_in_data');
