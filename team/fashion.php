<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$home_side_ns = 60;//abs(intval($INI['system']['sideteam']));
$home_city_id = abs(intval($city['id']));

$oc = array( 
		'city_id' => array($home_city_id, 0,556), 
		'team_type' => 'normal',
		"begin_time < UNIX_TIMESTAMP()",
		"end_time > UNIX_TIMESTAMP()",
		"(max_number>0 AND now_number < max_number) OR max_number=0",
		"group_id IN (49,47)",
	);	
$ckey = 'services'.$home_city_id;	


$count = Table::Count('team', $oc);
list($pagesize, $offset, $pagestring) = pagestring($count,$home_side_ns);	
$teams = DB::LimitQuery('team', array(
	'condition' => $oc,
	'order' => 'ORDER BY `sort_order` DESC, `id` DESC',
	'size' => $pagesize,
	'offset' => $offset,
));
	
$pagetitle = 'Deal thời trang mỹ phẩm';
include template('team_fashion');