<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('team');

if($_POST)
{
	$hidden_str_id = strval($_POST['hidden_str_id']);
	$arrID = split(",", $hidden_str_id);
	foreach($arrID as $id)
	{
		if($id != "")
		{	
			//DB::$mDebug=true;
			$show_homepage = isset($_POST['show_homepage_' . $id]) ? 1 : 0;

			$table = new Table('team', array('show_homepage'=>$show_homepage));
		 	$table->SetPK('id', $id);
			$flag = $table->update(array( 'id', 'show_homepage'));
		}
	}	
}

$now = time();
$condition = array(
	'system' => 'Y',
	"end_time > {$now}",
	//"city_id IN (0,{$city['id']})",
);

/* filter start */
$team_type = strval($_GET['team_type']);
if ($team_type) { $condition['team_type'] = $team_type; }
/* filter end */
$keyword = strval($_GET['key']);
if ($keyword)
{
$condition[] = "masp like '%".mysql_escape_string($keyword)."%' or product like '%".mysql_escape_string($keyword)."%'";
}

$team_id=abs(intval($_GET['team_id']));

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
//DB::$mDebug=true;
$teams = DB::LimitQuery('team', array(
	'condition' => $condition,
	'order' => 'ORDER BY show_homepage DESC, id DESC',
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
$groups = Table::Fetch('category', Utility::GetColumn($teams, 'group_id'));

$selector = 'show_homepage';
include template('manage_team_show_homepage');
