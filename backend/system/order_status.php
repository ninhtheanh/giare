<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager(true);

//$arr = DB::LimitQuery('order_status',array('select'=>'period','condition'=>"code='confirmed'"));
//$arr = DB::GetQueryResult("SELECT period FROM order_status WHERE code='confirmed'");
//var_dump($arr);

$status = DB::GetQueryResult("SELECT * FROM order_status",false);

if ($_POST['data']) {
	unset($_POST['commit']);
	
	foreach($_POST['data'] as $k=>$v)
	{
		Table::UpdateCache('order_status', $k, array(
			'name' => $v['name'],
			'color' => $v['color'],
			'period' => $v['period'],
		));
		
	}
	
	Session::Set('notice', 'Information Successfully updated!');
	redirect( WEB_ROOT . '/backend/system/order_status.php');	
}

include template('manage_system_order_status');
