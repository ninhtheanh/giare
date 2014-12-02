<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

//DB::$mDebug = true;

need_manager();
need_auth('system');

$condition = array();
$fr = $to = time();		
// data posted
if($_REQUEST['submit'])
{	
	$city = (intval($_REQUEST['city'])); if ($city) $condition['city'] = $city;	
	$period = $_REQUEST['period'];
	if($period=='C')
	{
		$fr = ($_REQUEST['fr']) ? strtotime($_REQUEST['fr']." 00:00:00") : time();
		$to = ($_REQUEST['to']) ? strtotime($_REQUEST['to']." 23:59:59") : time();
	}else{
		$t = fn_create_periods($period); $fr = $t[0]; $to = $t[1];		
	}	
	
	$condition[] = "create_time >= '".$fr."'";
	
	$condition[] = "create_time < '".$to."'";
	
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
	/*$sql = "
		select team_id, date,sum(pay) as pay,sum(unpay) as unpay,sum(cancel) as cancel,sum(confirm) as confirm,sum(delivered) as delivery,sum(pending) as pending,sum(hanging) as hanging,sum(total) as total from
	
	(SELECT FROM_UNIXTIME(create_time,'%Y-%m-%d') as date, team_id, count(1) as total,
	if(state='pay',count(*),0) as pay 
	,if(state='unpay',count(*),0) as unpay 
	,(if(state='canceled',count(*),0) + if(state='dealsoc_cancel',count(*),0)) as cancel 
	,if(state='confirmed',count(*),0) as confirm 
	,if(state='delivered',count(*),0) as delivered 
	,if(state='pending',count(*),0) as pending 
	,if(state='hanging',count(*),0) as hanging
	FROM `order` $cond group by date,state) as t1
	group by date order by date desc
	";*/
	$sql = "SELECT FROM_UNIXTIME(create_time,'%Y-%m-%d') as date FROM `order` $cond group by date ORDER BY date DESC";
	
	$rs = DB::GetQueryResult($sql,false);
	
}

//$qcount = DB::GetQueryResult("SELECT count(*) as count FROM $tbs $cond");
//$count = $total = $qcount['count'];
//list($pagesize, $offset, $pagestring) = pagestring($count, 100);

include template('report/orders');

function fn_create_periods($period='D')
{
	$today = getdate();
	// Current dates
	if ($period == 'D') {
		$time_from = mktime(0, 0, 0, $today['mon'], $today['mday'], $today['year']);
		$time_to = time();

	} elseif ($period == 'W') {
		$wday = empty($today['wday']) ? "6" : (($today['wday'] == 1) ? "0" : $today['wday'] - 1);
		$wstart = getdate(strtotime("-$wday day"));
		$time_from = mktime(0, 0, 0, $wstart['mon'], $wstart['mday'], $wstart['year']);
		$time_to = time();

	} elseif ($period == 'M') {
		$time_from = mktime(0, 0, 0, $today['mon'], 1, $today['year']);
		$time_to = time();

	} elseif ($period == 'Y') {
		$time_from = mktime(0, 0, 0, 1, 1, $today['year']);
		$time_to = time();

	// Last dates
	} elseif ($period == 'LD') {
		$today = getdate(strtotime("-1 day"));
		$time_from = mktime(0, 0, 0, $today['mon'], $today['mday'], $today['year']);
		$time_to = mktime(23, 59, 59, $today['mon'], $today['mday'], $today['year']);

	} elseif ($period == 'LW') {
		$today = getdate(strtotime("-1 week"));
		$wday = empty($today['wday']) ? 6 : (($today['wday'] == 1) ? 0 : $today['wday'] - 1);
		$wstart = getdate(strtotime("-$wday day", mktime(0, 0, 0, $today['mon'], $today['mday'], $today['year'])));
		$time_from = mktime(0, 0, 0, $wstart['mon'], $wstart['mday'], $wstart['year']);

		$wend = getdate(strtotime("+6 day", $time_from));
		$time_to = mktime(23, 59, 59, $wend['mon'], $wend['mday'], $wend['year']);

	} elseif ($period == 'LM') {
		$today = getdate(strtotime("-1 month"));
		$time_from = mktime(0, 0, 0, $today['mon'], 1, $today['year']);
		$time_to = mktime(23, 59, 59, $today['mon'], date('t', strtotime("-1 month")), $today['year']);

	} elseif ($period == 'LY') {
		$today = getdate(strtotime("-1 year"));
		$time_from = mktime(0, 0, 0, 1, 1, $today['year']);
		$time_to = mktime(0, 0, 0, 12, 31, $today['year']);

	// Last dates
	} elseif ($period == 'HH') {
		$today = getdate(strtotime("-23 hours"));
		$time_from = mktime($today['hours'], $today['minutes'], $today['seconds'], $today['mon'], $today['mday'], $today['year']);
		$time_to = time();

	} elseif ($period == 'HW') {
		$today = getdate(strtotime("-6 day"));
		$time_from = mktime($today['hours'], $today['minutes'], $today['seconds'], $today['mon'], $today['mday'], $today['year']);
		$time_to = time();

	} elseif ($period == 'HM') {
		$today = getdate(strtotime("-29 day"));
		$time_from = mktime($today['hours'], $today['minutes'], $today['seconds'], $today['mon'], $today['mday'], $today['year']);
		$time_to = time();

	} elseif ($period == 'HC') {
		$today = getdate(strtotime('-' . $params['last_days'] . ' day'));
		$time_from = mktime($today['hours'], $today['minutes'], $today['seconds'], $today['mon'], $today['mday'], $today['year']);
		$time_to = time();		
	}	

	return array($time_from, $time_to);
}