<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
//need_auth('team');

//DB::$mDebug = true;


// vars
$stamp = strtotime(date('Y-m-d 00:00:00'));
// running deals
$now = time();
$dcount_cond = array( 
			'city_id' => array($city['id'], 0), 
			'team_type' => 'normal',
			"begin_time < $now",
			"end_time > $now",
			"(max_number>0 AND now_number < max_number) OR max_number=0",
			);
$dcount = Table::Count('team', $dcount_cond);

// new users
$ucount_cond = array('create_time>='.$stamp);
$ucount = Table::Count('user', $ucount_cond);

// new users
$mcount_cond = array("shipper_status='A'");
$mcount = Table::Count('shipper', $mcount_cond);

// today's new order by deal
$sql = "SELECT o.id as order_id, o.user_id, t.id,short_title,sum(quantity) as qty FROM `order` as o left join team as t on o.team_id=t.id where create_time>=UNIX_TIMESTAMP(CURDATE()) group by t.id ORDER BY t.id desc;";
$rs = DB::GetQueryResult($sql,false);
$ocount = sizeof($rs);

/*$sql_ordersbystatedate = "select date,sum(pay) as pay,sum(unpay) as unpay,sum(cancel) as cancel,sum(confirm) as confirm,sum(delivered) as delivery,sum(pending) as pending,sum(hanging) as hanging,sum(total) as total from
(SELECT DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y-%m-%d') as date,count(1) as total,
if(state='pay',count(*),0) as pay 
,if(state='unpay',count(*),0) as unpay 
,if(state='canceled',count(*),0) as cancel 
,if(state='confirmed',count(*),0) as confirm 
,if(state='delivered',count(*),0) as delivered 
,if(state='pending',count(*),0) as pending 
,if(state='hanging',count(*),0) as hanging
FROM `order` group by DATE(FROM_UNIXTIME(create_time)),state) as t1
group by DATE(date) desc";

$sql_ordersbystatemonth = "select date,sum(pay) as pay,sum(unpay) as unpay,sum(cancel) as cancel,sum(confirm) as confirm,sum(delivered) as delivery,sum(pending) as pending,sum(hanging) as hanging,sum(total) as total from 
(SELECT DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y-%m') as date,count(1) as total,
if(state='pay',count(*),0) as pay 
,if(state='unpay',count(*),0) as unpay 
,if(state='canceled',count(*),0) as cancel 
,if(state='confirmed',count(*),0) as confirm 
,if(state='delivered',count(*),0) as delivered 
,if(state='pending',count(*),0) as pending 
,if(state='hanging',count(*),0) as hanging
FROM `order` group by MONTH(FROM_UNIXTIME(create_time)),state) as t1
group by date desc";

$sql_salesbyday = "SELECT DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y-%m-%d') as date, FORMAT(sum(quantity*price),0) as amount
FROM `order` group by DATE(FROM_UNIXTIME(create_time))";

$sql_salesbymonth = "SELECT DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y-%m') as date, FORMAT(sum(quantity*price),0) as amount
FROM `order` group by month(FROM_UNIXTIME(create_time))";

$sql_deals = "SELECT t.id,short_title,sum(quantity) as qty,sum(quantity_successful) as sqty FROM `order` as o left join team as t on o.team_id=t.id group by t.id ORDER BY t.id desc;";

// load deals ------------------------------------------------------------------
$cond = array("close_time=0 AND end_time>".time());

$rs = DB::LimitQuery('team', array(
	'condition' => $cond,
	'order' => 'ORDER BY sort_order DESC,id DESC',	
));*/

include template('report/index');