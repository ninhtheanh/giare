<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('order');

$condition = array("city={$city['id']}"
);
// filter ------------------------------------------
$out_id = abs(intval($_GET['out_id'])); if ($out_id) $condition['out_id'] = $out_id;
$creator = abs(intval($_GET['creator'])); if ($creator) $condition['creator'] = $creator;
$shipper = abs(intval($_GET['shipper'])); if ($shipper) $condition['shipper'] = $shipper;
$updater = abs(intval($_GET['updater'])); if ($updater) $condition['updater'] = $updater;

$cbday = ($_GET['cbday']) ? ($_GET['cbday']) : date('Y-m-d',time());
$ceday = ($_GET['ceday']) ? ($_GET['ceday']) : date('Y-m-d',time());
if ($cbday) { 	
	$condition[] = "created >= '{$cbday}'";
}
if ($ceday) { 	
	$condition[] = "created < '".date('Y-m-d',strtotime($ceday)+86400)."'";
}
/* end fiter */
//DB::$mDebug = true;
$count = Table::Count('ship_out', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 100);
//$total = Table::Count('ship_out', $condition);
$rs = DB::LimitQuery('ship_out', array(
	'condition' => $condition,
	'order' => 'ORDER BY out_id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));

$ids = Utility::GetColumn($rs, 'creator');
$creators = Table::Fetch('user',$ids);

$ids = Utility::GetColumn($rs, 'shipper');
$shippers = Table::Fetch('shipper',$ids);

$ids = Utility::GetColumn($rs, 'updater');
$updaters = Table::Fetch('user',$ids);

include template('shipping/ship_out');