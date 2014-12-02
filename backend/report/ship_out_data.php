<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('order');


$out_id = abs(intval($_GET['out_id']));

$sql = "SELECT so.*, sd.* FROM ship_out AS so LEFT JOIN ship_out_data AS sd USING(out_id) WHERE so.out_id=".$out_id." ORDER BY street, dist_id, ward_id ASC, order_id DESC";

$rs = DB::GetQueryResult($sql,false);

$team_ids = Utility::GetColumn($rs, 'deal_id');
$teams = Table::Fetch('team', $team_ids);
$dist = DB::GetQueryResult("SELECT dist_name FROM district WHERE dist_id IN (".$rs[0]['dist_id'].")",false);
for($i=0; $i<count($dist);$i++){
	$dist_name .= $dist[$i]['dist_name'].", ";
}
$ids = Utility::GetColumn($rs, 'creator');
$creators = Table::Fetch('user',$ids);

$ids = Utility::GetColumn($rs, 'shipper');
$shippers = Table::Fetch('shipper',$ids);

$ids = Utility::GetColumn($rs, 'updater');
$updaters = Table::Fetch('user',$ids);

//sumary
$sql = "SELECT deal_id,sum(quantity) as qty,sum(amount) as amt FROM ship_out_data WHERE out_id=$out_id GROUP BY deal_id ORDER BY deal_id";
$r = DB::GetQueryResult($sql,false);

include template('shipping/ship_out_data');
