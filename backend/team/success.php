<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('team');

$now = time();
$condition = array(
	'system' => 'Y',
	"end_time < $now",
	"now_number >= min_number"
);

/* filter start */
$team_type = strval($_GET['team_type']);
if ($team_type) { $condition['team_type'] = $team_type; }
/* filter end */
$key = strval($_GET['key']);
if ($key)
{
$condition[] = "masp like '%".mysql_escape_string($key)."%' or product like '%".mysql_escape_string($key)."%'";
}
$sale = intval($_GET['sale']);
if ($sale>0) {
	$condition['sale'] = $sale;
}
$team_id = intval($_GET['id']);
if ($team_id>0) {
	$condition['id'] = $team_id;
}
$count = Table::Count('team', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$teams = DB::LimitQuery('team', array(
	'condition' => $condition,
	'order' => 'ORDER BY id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));
foreach($teams as $key => $value){
	$total = DB::GetQueryResult("SELECT sum(quantity) as qty FROM `order` WHERE team_id=".$value['id']);	
	if ($total['qty']>$value['now_number']){
		 DB::Query("UPDATE `team` SET now_number=".$total['qty']." WHERE id=".$value['id']);
    }
}
$cities = Table::Fetch('category', Utility::GetColumn($teams, 'city_id'));

$selector = 'success';
include template('manage_team_index');
