<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$now = time();
$mark = $now - ($now % 60);
$q = strtolower($_GET["s"]);
$condition = array(
	'team_type' => 'normal',
	'id NOT IN (53,768,311,1502)',
	'city_id' => array(556, 0, abs(intval($city['id']))),
	"(product LIKE '%$q%' OR masp LIKE '%$q%')",
	"end_time >= $now",
	//"max_number >= $now_number",
	
);


$home_side_ns = 130;
$group_id = abs(intval($_GET['gid']));
if ($group_id)$condition['group_id'] = $group_id;

$count = Table::Count('team', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count,$home_side_ns);

$ckey = 'past'.$_GET['page'];
//DB::$mDebug=true;
$teams = DB::LimitQuery('team', array(
	'condition' => $condition,
	'order' => 'ORDER BY sort_order DESC, end_time DESC, id DESC',
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
$pagetitle = "{$q} - Tìm deal với ";
include template('team_search');