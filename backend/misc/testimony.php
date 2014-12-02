<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('misc');



$count = Table::Count('comments', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$orders = DB::LimitQuery('comments', array(
	'order' => 'ORDER BY id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));


$user_ids = Utility::GetColumn($orders, 'user_id');
$users = Table::Fetch('user', $user_ids);

$team_ids = Utility::GetColumn($orders, 'team_id');
$teams = Table::Fetch('team', $team_ids);

$city_ids = Utility::GetColumn($orders, 'city_id');
$cities = Table::Fetch('category', $city_ids);

include template('manage_misc_testimony');
