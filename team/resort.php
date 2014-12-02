<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$now = time();
$mark = $now - ($now % 60);

$condition = array(
	'team_type' => 'normal',
	'city_id' => array(556, 0, abs(intval($city['id']))),
	"id NOT IN (1493)",
	"begin_time <= $mark",
);

if (!option_yes('displayfailure')) {
	$condition['OR'] = array(
		"now_number >= 100",
		"end_time > $mark",
	);
}
$home_side_ns = 30;
$group_id = 23;/*abs(intval($_GET['gid']));
if ($group_id) */$condition['group_id'] = $group_id;

$count = Table::Count('team', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count,$home_side_ns);

$ckey = 'past'.$_GET['page'];
 //DB::$mDebug=true;
$teams = DB::LimitQuery('team', array(
		'condition' => $condition,
		'order' => 'ORDER BY sort_order DESC, id DESC',
		'size' => $pagesize,
		'offset' => $offset,
	));
//$teams = caches($ckey,$cval);

/*
$mkey = 'past'.$_GET['page'];
if(CACHE==true && $m->get($mkey))
{	
	$teams = $m->get($mkey);		
}
else
{	
	$teams = DB::LimitQuery('team', array(
		'condition' => $condition,
		'order' => 'ORDER BY begin_time DESC, sort_order DESC, id DESC',
		'size' => $pagesize,
		'offset' => $offset,
	));
	$m->set($mkey,$teams,0,60);//*60*24*4		
}
*/

foreach($teams AS $id=>$one){
	team_state($one);
	if (!$one['close_time']) $one['picclass'] = 'isopen';
	if ($one['state']=='soldout') $one['picclass'] = 'soldout';
	if ($one['state']=='success' && $one['close_time']) $one['picclass'] = 'issuccess';
	$teams[$id] = $one;
}


$category = Table::Fetch('category', $group_id);
$pagetitle = 'Deal du lịch';
include template('team_resort');