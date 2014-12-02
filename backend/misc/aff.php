<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('admin');

//do confirm payment
if($_GET['fdeSubmit'] && $_GET['myinput'])
{
	foreach($_GET['myinput'] as $v)
	{
		$s .= $v . '-';
		Table::UpdateCache('click', $v, array(
		'pay' => 1, 
		'admin_id'=>$login_user_id,
		));		
		//save log
		save_log('paid','click',$v);
	}
	Session::Set('notice', 'Confirmed IDs:'.rtrim($s,'-'));
	redirect(null);
}


$iuser = strval($_GET['iuser']);
$puser = strval($_GET['puser']);
$iday = strval($_GET['iday']);
$pday = strval($_GET['pday']);

($s = strtolower(strval($_GET['s']))) || ($s = 'index');
if(!$s||!in_array($s, array('index', 'pending', 'record', 'cancel', 'faul'))) $s = 'index';

$cond = " WHERE click.credit>0 AND buy_time>0";

//if('index'==$s) $cond .= " AND pay=0 AND order.state='pay'";
if('pending'==$s) $cond .= " AND pay=0 AND order.state='pay'";
if('record'==$s) $cond .= " AND pay=1 AND order.state='pay'";
if('cancel'==$s) $cond .= " AND pay=2";
if('faul'==$s) $cond .= " AND order.state<>'pay'";

if ($iuser) $cond .= " AND pid=".$iuser;

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

/* filter end */

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

//affiliates
$uaffs = DB::GetQueryResult("SELECT id,email FROM user WHERE is_aff=1",false);

include template('manage_misc_aff');
