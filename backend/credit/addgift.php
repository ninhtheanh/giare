<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
require_once(dirname(__FILE__) . '/current.php');
need_manager();
need_auth('admin');
$sql = "SELECT id, short_title FROM team WHERE group_id=569";
$ds = DB::GetQueryResult($sql,false);
var_dump($ds);
$option_promotion = array(
	'buy' => 'buy goods',
	'login' => 'daily login',
	'pay' => 'pay to get credit',
	'exchange' => 'exchange goods',
	'register' => 'register account',
	'invite' => 'invite friends',
);