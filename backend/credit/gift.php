<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
require_once(dirname(__FILE__) . '/current.php');
need_manager();
need_auth('admin');

$condition = array();
/* filter */
$like = strval($_GET['like']);
if ($like) { 
	$condition[] = "email like '%".mysql_escape_string($like)."%'";
}
$uname = strval($_GET['uphone']);
if ($uname) {
	$condition[] = "username like '%".mysql_escape_string($uname)."%'";
}
$action = strval($_GET['action']);
if ($action) {
	$condition['action'] = $action;
}
/* end */

$count = Table::Count('credit_gif', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$credits = DB::LimitQuery('credit_gift', array(
	'condition' => $condition,
	'order' => 'ORDER BY id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));

$user_ids = Utility::GetColumn($credits, 'user_id');
$users = Table::Fetch('user', $user_ids);

$option_action = array(
	'buy' => 'buy goods',
	'login' => 'daily login',
	'pay' => 'pay to get credit',
	'exchange' => 'exchange goods',
	'register' => 'register account',
	'invite' => 'invite friends',
);

include template('manage_credit_gift');
