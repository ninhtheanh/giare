<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

//DB::Debug();
DB::$mDebug = false;

need_manager();
need_auth('shipping');

$condition = array(	
);
// filter ------------------------------------------
$in_id = abs(intval($_GET['in_id'])); if ($in_id) $condition['i.in_id'] = $in_id;
$out_id = abs(intval($_GET['out_id'])); if ($out_id) $condition['o.out_id'] = $out_id;
$creator = abs(intval($_GET['creator'])); if ($creator) $condition['o.creator'] = $creator;
$shipper = abs(intval($_GET['shipper'])); if ($shipper) $condition['o.shipper'] = $shipper;
$updater = abs(intval($_GET['updater'])); if ($updater) $condition['o.updater'] = $updater;
$approver = abs(intval($_GET['approver'])); if ($approver) $condition['i.approver'] = $approver;

$locked = strval($_GET['locked']); if ($locked) $condition['i.locked'] = "'$locked'";

$cbday = ($_GET['cbday']) ? ($_GET['cbday']) : date('Y-m-d',time());
$ceday = ($_GET['ceday']) ? ($_GET['ceday']) : date('Y-m-d',time());
if ($cbday) { 	
	$condition[] = "i.approved >= '{$cbday}'";
}
if ($ceday) { 	
	$condition[] = "i.approved < '".date('Y-m-d',strtotime($ceday)+86400)."'";
}
/* end fiter */

if($condition)
{
	$cond = ' WHERE ';
	foreach($condition as $k=>$v)
	{	
		$cond .= (!is_numeric($k)) ? $k.'='.$v : $v;	
		$cond .= ' AND ';
	}
	$cond = rtrim($cond, ' AND ');
}

//$cond = (empty($cond)) ? " WHERE o.created like '%".date('Y-m-d',time())."%'" : $cond;

$sel = 'out_id,o.creator,o.created,updater,updated,o.shipper,in_id,approver,approved,locked';
$tbs = 'ship_out AS o LEFT JOIN ship_in AS i USING(out_id)';
//$gtb = 'LEFT JOIN ship_out_data AS od USING (out_id) LEFT JOIN ship_in_data AS id USING (in_id)';

$qcount = DB::GetQueryResult("SELECT count(*) as count FROM $tbs $cond");
$count = $total = $qcount['count'];
list($pagesize, $offset, $pagestring) = pagestring($count, 100);

$sql = "SELECT $sel FROM $tbs $cond GROUP BY out_id ORDER BY o.out_id DESC LIMIT $offset,$pagesize";

$rs = DB::GetQueryResult($sql,false);

foreach($rs as $k=>$v)
{
	$q = DB::GetQueryResult("SELECT count(*) as count FROM ship_out_data WHERE out_id=".$v['out_id']);
	$rs[$k]['orders'] = ($q['count']) ? ($q['count']) : 0;
	
	$q = DB::GetQueryResult("SELECT count(*) as count FROM ship_out_data WHERE state='pay' AND out_id=".$v['out_id']);
	$rs[$k]['paid_orders'] = ($q['count']) ? ($q['count']) : 0;
	
	$q = DB::GetQueryResult("SELECT sum(quantity) as count FROM ship_out_data WHERE out_id=".$v['out_id']);
	$rs[$k]['vouchers'] = ($q['count']) ? ($q['count']) : 0;
	
	$q = DB::GetQueryResult("SELECT sum(pays) as count FROM ship_in_data WHERE in_id=".$v['in_id']);
	$rs[$k]['paid_vouchers'] = ($q['count']) ? ($q['count']) : 0;
	
	$q = DB::GetQueryResult("SELECT sum(price*pays) as count FROM ship_in_data WHERE in_id=".$v['in_id']);
	$rs[$k]['topay'] = ($q['count']) ? ($q['count']) : 0;

}

$ids = Utility::GetColumn($rs, 'creator');
$creators = Table::Fetch('user',$ids);

$ids = Utility::GetColumn($rs, 'shipper');
$shippers = Table::Fetch('shipper',$ids);

$ids = Utility::GetColumn($rs, 'updater');
$updaters = Table::Fetch('user',$ids);

$ids = Utility::GetColumn($rs, 'approver');
$approvers = Table::Fetch('user',$ids);

include template('shipping/report');