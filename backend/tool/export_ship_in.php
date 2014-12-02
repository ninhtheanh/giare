<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('shipping');

$condition = array("city={$city['id']}");
// filter ------------------------------------------

$out_id = abs(intval($_GET['out_id'])); if ($out_id) $condition['out_id'] = $out_id;
$in_id = abs(intval($_GET['in_id'])); if ($in_id) $condition['in_id'] = $in_id;
$creator = abs(intval($_GET['creator'])); if ($creator) $condition['creator'] = $creator;
$shipper = abs(intval($_GET['shipper'])); if ($shipper) $condition['shipper'] = $shipper;
$updater = abs(intval($_GET['updater'])); if ($updater) $condition['updater'] = $updater;
$approver = abs(intval($_GET['approver'])); if ($approver) $condition['approver'] = $approver;

$cbday = ($_GET['cbday']) ? ($_GET['cbday']) : date('Y-m-d',time());
$ceday = ($_GET['ceday']) ? ($_GET['ceday']) : date('Y-m-d',time());
if ($cbday) { 	
	$condition[] = "approved >= '{$cbday}'";
}
if ($ceday) { 	
	$condition[] = "approved < '".date('Y-m-d',strtotime($ceday)+86400)."'";
}
/* end fiter */

/*$condition = DB::BuildCondition( $condition );
echo $condition;
$condition = (null==$condition) ? null : "WHERE $condition";*/
//DB::$mDebug = true;
$condition['locked'] = 'Y';
$count = Table::Count('ship_in', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 100);
$total = Table::Count('ship_in', $condition);
$rs = DB::LimitQuery('ship_in', array(
	'condition' => $condition,
	'order' => 'ORDER BY in_id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));

$ids_0 = Utility::GetColumn($rs, 'creator');
$creators = Table::Fetch('user',$ids_0);

$ids_1 = Utility::GetColumn($rs, 'shipper');
$shippers = Table::Fetch('shipper',$ids_1);

$ids_2 = Utility::GetColumn($rs, 'updater');
$updaters = Table::Fetch('user',$ids_2);

$ids_3 = Utility::GetColumn($rs, 'approver');
$approvers = Table::Fetch('user',$ids_3);

include template('shipping/export_ship_in');