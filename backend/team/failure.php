<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('team');

$now = time();
$condition = array(
	'system' => 'Y',
	"now_number < min_number",
	"end_time < $now",
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
$cities = Table::Fetch('category', Utility::GetColumn($teams, 'city_id'));

$selector = 'failure';
include template('manage_team_index');
