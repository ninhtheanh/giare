<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$home_side_ns = 27;//abs(intval($INI['system']['sideteam']));
$home_city_id = abs(intval($city['id']));

if ( abs(intval($INI['system']['sideteam'])) ) {
	$oc = array( 
			'city_id' => array($home_city_id, 0,556), 
			'team_type' => 'normal',
			"begin_time < UNIX_TIMESTAMP()",
			"end_time > UNIX_TIMESTAMP()",
			"(max_number>0 AND now_number < max_number) OR max_number=0",
			);	
	$ckey = 'home'.$home_city_id;	
	
	$group_id = abs(intval($_GET['gid']));
	if ($group_id) $oc['group_id'] = $group_id;
	
	$count = Table::Count('team', $oc);
	list($pagesize, $offset, $pagestring) = pagestring($count,$home_side_ns);	
	$teams = DB::LimitQuery('team', array(
		'condition' => $oc,
		'order' => 'ORDER BY `sort_order` DESC, `id` DESC',
		'size' => $pagesize,
		'offset' => $offset,
	));
	
}
/* refer */

if ($_rid = abs(intval($_GET['r']))) { 
	if($_rid) cookieset('_rid', abs(intval($_GET['r'])));
	//redirect( WEB_ROOT . "/team.php?id={$id}");
}
//affiliate
if ($_aff = abs(intval($_GET['utm_campaign']))) { 
	if($_aff) cookieset( '_aff', abs(intval($_aff)) . '|' . $id . '|' . $_SERVER['REMOTE_ADDR'] . '|' . $_SERVER['HTTP_REFERER'] . '|' . time(), 86400 * 3 );
	//ZAffiliate::Rec( $_aff , $id );
	//redirect( WEB_ROOT . "/team.php?id={$id}");
}
include template('group/cungmua');