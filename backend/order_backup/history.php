<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('order');

$order_id = abs(intval($_GET['order_id'])); 
if ($order_id) $condition['order_id'] = $order_id;

$status_code = strval($_GET['status_code']); 
if ($status_code) $condition['status_code'] = $status_code;

$user = strval($_GET['user']);
if ($user)
$condition['user'] = $user;
else $user = null;

$assign_to = strval($_GET['assign_to']);
if ($assign_to)
$condition['assign_to'] = $assign_to;
else $assign_to = null;


$cbday = strval($_GET['cbday']);
$ceday = strval($_GET['ceday']);

if ($cbday) { 
	$cbtime = ($cbday);
	$condition[] = "date like '%{$cbtime}%'";
}
if ($ceday) { 
	$cetime = ($ceday);
	$condition[] = "expires like '%{$cetime}%'";
}

/* end fiter */

//$count = DB::GetQueryResult("SELECT count(*) FROM order AS o LEFT JOIN order_history AS h ON o.id=h.order_id WHERE = 'confirmed'");
	$cond['order_id'] = $v['order_id'];
    $totalrow += Table::Count('order_history', $cond);

$count = Table::Count('order_history', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 25);
//$total_voucher = Table::Count('order_history', $condition, 'quantity');
$orders = DB::LimitQuery('order_history', array(
	'condition' => $condition,
	'order' => 'ORDER BY order_id DESC, date DESC',
	'size' => $pagesize,
	'offset' => $offset,
));
foreach($orders as $k=>$v)
{
	if($v['order_id']!=$prev){
		//$orders[$k]['color'] = getStatusColor($v['status_code']);
		$orders[$k]['head'] = 1;
	}else{
		//$orders[$k]['color'] = $prev_color;
		$orders[$k]['head'] = 0;
	}
	$prev = $v['order_id'];	
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

include template('manage_order_history');
