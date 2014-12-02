
<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
//DB::$mDebug=true;
$now = time();
$mark = $now - ($now % 60);

$condition = array(
	'team_type' => 'normal',
	'city_id' => array(556, 0, abs(intval($city['id']))),
	"begin_time <= $mark",
	"end_time < $now",
);

if (!option_yes('displayfailure')) {
	$condition['OR'] = array(
		"now_number >= min_number",
		"end_time > $mark",
	);
}
$home_side_ns = 30;
$group_id = abs(intval($_GET['gid']));
if ($group_id) $condition['group_id'] = $group_id;

$count = Table::Count('team', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, $home_side_ns);
$ckey = 'past'.$_GET['page'];
$teams = DB::LimitQuery('team', array(
		'condition' => $condition,
		'order' => 'ORDER BY end_time DESC, sort_order DESC, id DESC',
		'size' => $pagesize,
		'offset' => $offset,
	));

foreach($teams AS $id=>$one){
	team_state($one);
	if (!$one['close_time']) $one['picclass'] = 'isopen';
	if ($one['state']=='soldout') $one['picclass'] = 'soldout';
	if ($one['state']=='expired') $one['picclass'] = 'isexpired';
	if ($one['state']=='success' && $one['close_time']) $one['picclass'] = 'issuccess';
	$teams[$id] = $one;
}


$category = Table::Fetch('category', $group_id);
$pagetitle = 'Deal gần đây';
include template('team_index_N');
?>