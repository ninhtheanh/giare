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
			$itemselected = isset($_POST['itemselected_' . $id]) ? 1 : 0;
			if($itemselected == 1)
			{
				$sql = "Delete From promotion_product Where id_product = $id And id_promotion_category = " . $_GET['id'];
				//echo "<br>$sql";
				DB::GetQueryResult($sql);
			}
		}
	}	
}
if( isset($_GET['id_product']) )
{
    $sql = "Delete From promotion_product Where id_product = " . $_GET['id_product'];
	//echo "<br>$sql";
	DB::GetQueryResult($sql);
	Session::Set('notice', "Ðã xóa thành công");
}

$now = time();
$id = intval($_GET['id']);
$keyword = strval($_GET['key']);
//DB::$mDebug=true;
$where = "WHERE `system` = 'Y' AND end_time > $now And promotion_product.id_promotion_category = $id";
if ($keyword)
{
	$where .= " AND (masp like '%".mysql_escape_string($keyword)."%' or product like '%".mysql_escape_string($keyword)."%')";
}
$sqlCount = "SELECT count(1) as count_item FROM `team` RIGHT JOIN promotion_product On team.id = promotion_product.id_product $where";
$count_item = DB::GetQueryResult($sqlCount); $count = $count_item["count_item"];
list($pagesize, $offset, $pagestring) = pagestring($count, 20);
$sql = "SELECT team.* FROM `team` RIGHT JOIN promotion_product On team.id = promotion_product.id_product $where";
$teams = DB::GetQueryResult($sql . "  LIMIT $offset,$pagesize", 0);
//echo "<br>$sql";
//print_r($teams);
foreach($teams as $key => $value){
	$total = DB::GetQueryResult("SELECT sum(quantity) as qty FROM `order` WHERE team_id=".$value['id']);	
	if ($total['qty']>$value['now_number']){
		 DB::Query("UPDATE `team` SET now_number=".$total['qty']." WHERE id=".$value['id']);
    }
}
$cities = Table::Fetch('category', Utility::GetColumn($teams, 'city_id'));
$groups = Table::Fetch('category', Utility::GetColumn($teams, 'group_id'));

$selector = 'promotion_category';
include( "../../include/compiled/manage_team_promotion_product.php");
