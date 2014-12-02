<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

//DB::$mDebug = true;

need_manager();
need_auth('team');

$condition = array();
$fr = $to = time();		
// data posted
if($_REQUEST['submit'])
{	
	$city = (intval($_REQUEST['city'])); if ($city) $condition['city'] = $city;	

	$period = $_REQUEST['period'];
	if($period=='C')
	{
		$fr = ($_REQUEST['fr']) ? strtotime($_REQUEST['fr']) : time();
		$to = ($_REQUEST['to']) ? strtotime($_REQUEST['to']) : time();
	}elseif($period=='A'){
		$fr = 0; $to = 99999999999;
	}else{
		$t = fn_create_periods($period); $fr = $t[0]; $to = $t[1];		
	}	
	
	$condition[] = "o.create_time >= '".$fr."'";
	
	$condition[] = "o.create_time < '".$to."'";
	
	
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
	
	/*$sql = "select team_id,team_name,team_status,begin_time,sum(pay) as pay,sum(unpay) as unpay,sum(cancel) as cancel,sum(confirm) as confirm,sum(delivered) as delivery,sum(pending) as pending,sum(hanging) as hanging,sum(dscancel) as dscancel, sum(total) as total from
(SELECT team_id, t.short_title as team_name, t.status as team_status, FROM_UNIXTIME(t.begin_time,'%Y-%m-%d') as begin_time
,sum(quantity) as total 
,if(o.state='pay',sum(quantity_successful),0) as pay 
,if(o.state='unpay',sum(quantity),0) as unpay 
,if(o.state='canceled',sum(quantity),0) as cancel 
,if(o.state='confirmed',sum(quantity),0) as confirm 
,if(o.state='delivered',sum(quantity),0) as delivered 
,if(o.state='pending',sum(quantity),0) as pending 
,if(o.state='hanging',sum(quantity),0) as hanging
,if(o.state='dealsoc_cancel',sum(quantity),0) as dscancel
FROM `order` as o left join team as t on o.team_id=t.id $cond group by team_id,o.state order by team_id desc) as t1
group by team_id desc";*/
	$sql = "SELECT
o.team_id AS team_id,
team.short_title AS team_name, FROM_UNIXTIME(team.begin_time,'%Y-%m-%d') AS begin_time,
Sum(o.quantity) AS total, Sum(IF(o.state='unpay',quantity,0)) AS unpay, Sum(IF(o.state='calling',quantity,0)) AS calling,
(SUM(IF((o.service!='cashoffice' AND o.state='confirmed'),quantity,0)) + SUM(IF((o.service!='cashoffice' AND o.state='pending'),quantity,0))) AS confirm,
Sum(IF((o.service='cashoffice' AND o.state='confirmed'),quantity,0)) AS confirm_vp,
Sum(IF(o.state='oncredit',quantity,0)) AS oncredit,
Sum(IF(o.state='hanging',quantity,0)) AS hanging,
Sum(IF(o.state='delivered',quantity,0)) AS delivery,
Sum(IF(o.state='transported',quantity,0)) AS transported,
Sum(IF(o.state='canceled',quantity,0)) AS cancel,
Sum(IF(o.state='dealsoc_cancel',quantity,0)) AS dscancel,
Sum(IF(o.state='pay',quantity_successful,0)) AS pay,
IF(team.`status`='Y','Đang GH','Hết GH') AS team_status,
FROM_UNIXTIME(team.end_time,'%Y-%m-%d') AS deal_close, IF(team.`delivery_properties`='1','Giao SP','Giao Voucher') AS delivery_properties
FROM
`order` AS o
INNER JOIN team ON o.team_id = team.id GROUP BY team_id ORDER BY team_id DESC";
	$rs = DB::GetQueryResult($sql,false);
	
}
//var_dump($rs);
//$qcount = DB::GetQueryResult("SELECT count(*) as count FROM $tbs $cond");
//$count = $total = $qcount['count'];
//list($pagesize, $offset, $pagestring) = pagestring($count, 100);

include template('report/deals');

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