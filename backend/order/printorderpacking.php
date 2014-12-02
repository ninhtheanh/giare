<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
need_manager();
need_auth('eorder');

$ds = DB::GetQueryResult("SELECT DISTINCT time_process FROM `order` WHERE time_process<>'0000-00-00 00:00:00' ORDER BY time_process DESC", false);

$count = 0;
if(isset($_POST['block'])){
	$time_processing = $_POST['block'];
	$condition = array(
		'time_process' => "{$time_processing}",
	);
	$count = Table::Count('order', $condition);
	list($pagesize, $offset, $pagestring) = pagestring($count, 100);
	$total_print = Table::Count('order', $condition, 'quantity');
	//DB::$mDebug = true;
	$orders = DB::LimitQuery('order', array(
		'condition' => $condition,
		'order' => 'ORDER BY id ASC',
		'size' => $pagesize,
		'offset' => $offset,
	));
	$team_ids = Utility::GetColumn($orders, 'team_id');
	$teams = Table::Fetch('team', $team_ids);
}


include template('manage_print_order_packing');
?>