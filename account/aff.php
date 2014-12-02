<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_login();

$pid = intval($_GET['pid']);
$puser = strval($_GET['puser']);
$iday = strval($_GET['iday']);
$pday = strval($_GET['pday']);

($s = strtolower(strval($_GET['s']))) || ($s = 'index');
if(!$s||!in_array($s, array('index', 'pending', 'record', 'cancel', 'faul'))) $s = 'index';

$cond = " WHERE pid=".$login_user['id']." AND click.credit>0 AND buy_time>0";

//if('index'==$s) $cond .= " AND pay=0 AND order.state='pay'";
if('pending'==$s) $cond .= " AND pay=0 AND order.state='pay'";
if('record'==$s) $cond .= " AND pay=1 AND order.state='pay'";
if('cancel'==$s) $cond .= " AND pay=2";
if('faul'==$s) $cond .= " AND order.state<>'pay'";

if ($pid) $cond .= " AND pid=".$pid;

if ($puser) {
	$field = strpos($puser, '@') ? 'email' : 'username';
	$field = is_numeric($puser) ? 'id' : $field;
	$puser_u = Table::Fetch('user', $puser, $field);
	if($puser_u) $cond .= " AND buy_uid=".$puser_u['id'];
	else $puser= null;
}
if ($iday) { 
	$cond .= " AND click_time LIKE '%".mysql_escape_string($iday)."%'"; 
}
if ($pday) { 
	$cond .= " AND buy_time LIKE '%".mysql_escape_string($pday)."%'"; 
}

//$condition = array( 'pid='.$login_user['id'], 'credit >= 0', 'pay' => '0', 'buy_time > 0');
//if('record'==$s) $condition['pay'] = '1';
//if('cancel'==$s) $condition['pay'] = '2';

/* filter */
//if ($pid) {
//	$condition['buy_tid'] = $pid;	
//}


/*if ($puser) {
	$field = strpos($puser, '@') ? 'email' : 'username';
	$field = is_numeric($puser) ? 'id' : $field;
	$puser_u = Table::Fetch('user', $puser, $field);
	if($puser_u) $condition['buy_uid'] = $puser_u['id'];
	else $puser= null;
}
if ($iday) { 
	$condition[] = "left(click_time,10) = '".mysql_escape_string($iday)."'"; 
}
if ($pday) { 
	$condition[] = "left(buy_time,10) = '".mysql_escape_string($pday)."'"; 
}*/

/* filter end */

/*$count = Table::Count('click', $condition);
$summary = Table::Count('click', $condition, 'credit');

list($pagesize, $offset, $pagestring) = pagestring($count, 20);
//'select' => $select,
$affs = DB::LimitQuery('click', array(	
	'condition' => $condition,
	'order' => 'ORDER BY buy_time DESC, buy_tid DESC',
	'size' => $pagesize,
	'offset' => $offset,
));*/

$sqlc = "SELECT count(*) as count FROM `click` JOIN `order` ON click.buy_oid=order.id $cond";
$rc = DB::GetQueryResult($sqlc);
$count = $rc['count'];
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$sqls = "SELECT sum(click.credit) as sum FROM `click` JOIN `order` ON click.buy_oid=order.id $cond";
$rs = DB::GetQueryResult($sqls);
$summary = $rs['sum'];

$sql = "SELECT click.* FROM `click` JOIN `order` ON click.buy_oid=order.id $cond ORDER BY buy_time DESC, buy_tid DESC LIMIT $offset,$pagesize";
//echo $sql;
$affs = DB::GetQueryResult($sql,false);

$team_ids = Utility::GetColumn($affs, 'buy_tid');
$teams = Table::Fetch('team', $team_ids);

$user_ids = Utility::GetColumn($affs, 'pid');
$user_ido = Utility::GetColumn($affs, 'buy_uid');
$admin_ids = Utility::GetColumn($affs, 'admin_id');
$user_ids = array_merge($user_ids, $user_ido, $admin_ids);
$users = Table::Fetch('user', $user_ids);

include template('account_aff');