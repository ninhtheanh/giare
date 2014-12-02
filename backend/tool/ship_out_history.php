<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('shipping');

$out_id = abs(intval($_GET['out_id'])); 
if ($out_id) $condition['out_id'] = $out_id;

$in_id = abs(intval($_GET['in_id'])); 
if ($in_id) $condition['in_id'] = $in_id;

$user = strval($_GET['user']); if ($user) $condition['user'] = $user;
$creator = abs(intval($_GET['creator'])); if ($creator) $condition['creator'] = $creator;
$shipper = abs(intval($_GET['shipper'])); if ($shipper) $condition['shipper'] = $shipper;
$updater = abs(intval($_GET['updater'])); if ($updater) $condition['updater'] = $updater;

$cbday = ($_GET['cbday']) ? ($_GET['cbday']) : date('Y-m-d',time());
$ceday = ($_GET['ceday']) ? ($_GET['ceday']) : date('Y-m-d',time());
if ($cbday) { 	
	$condition[] = "date >= '{$cbday}'";
}
if ($ceday) { 	
	$condition[] = "date < '".date('Y-m-d',strtotime($ceday)+86400)."'";
}
/* end fiter */

//$count = DB::GetQueryResult("SELECT count(*) FROM order AS o LEFT JOIN order_history AS h ON o.id=h.order_id WHERE = 'confirmed'");
//$cond['order_id'] = $v['order_id'];
//$totalrow += Table::Count('order_history', $cond);
//DB::$mDebug=true;
$count = Table::Count('ship_log', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 100);
//$total_voucher = Table::Count('order_history', $condition, 'quantity');
$rs = DB::LimitQuery('ship_log', array(
	'condition' => $condition,
	'order' => 'ORDER BY out_id DESC, date DESC',
	'size' => $pagesize,
	'offset' => $offset,
));
foreach($rs as $k=>$v)
{
	if($v['out_id']!=$prev){
		//$orders[$k]['color'] = getStatusColor($v['status_code']);
		$rs[$k]['head'] = 1;
	}else{
		//$orders[$k]['color'] = $prev_color;
		$rs[$k]['head'] = 0;
	}
	$prev = $v['out_id'];
	//$prev_color = $orders[$k]['color'];	
}
//$states = DB::GetQueryResult("SELECT code,name FROM order_status",false);

//var_dump($orders);

/*$pay_ids = Utility::GetColumn($orders, 'pay_id');
$pays = Table::Fetch('pay', $pay_ids);

$user_ids = Utility::GetColumn($orders, 'user_id');
$users = Table::Fetch('user', $user_ids);


$team_ids = Utility::GetColumn($orders, 'team_id');
$teams = Table::Fetch('team', $team_ids);

$order_ids = Utility::GetColumn($orders, 'id');
$order_id_list = implode(",",$order_ids);*/


//$status = Utility::GetColumn($orders, 'status_code');
//$colors = Table::Fetch('order_status', $status, 'status_code');

include template('shipping/ship_out_history');
