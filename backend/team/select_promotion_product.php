<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('team');
$id_promotion_category = $_GET['id'];
if($_POST)
{
	$hidden_str_id = strval($_POST['hidden_str_id']);
	$arrID = split(",", $hidden_str_id);
	foreach($arrID as $id)
	{
		if($id != "")
		{	
			//DB::$mDebug=true;
			$is_promotion = isset($_POST['is_promotion_' . $id]) ? 1 : 0;
			if($is_promotion == 1)
			{
				$sqlCount = "SELECT count(1) as count_item FROM promotion_product WHERE id_promotion_category = $id_promotion_category AND id_product = '$id'";
				//echo "<br>$sqlCount";
				$count_item = DB::GetQueryResult($sqlCount);
				if($count_item["count_item"] <= 0)
				{
					$sql = "Insert Into promotion_product(id_product, id_promotion_category, date_created)
                     value($id, $id_promotion_category, NOW())";
					//echo "<br>$sql";
					DB::GetQueryResult($sql);
				}
			}
		}        
	}
    redirect( WEB_ROOT . 'promotion_product.php?id=' . $id_promotion_category);
}

$now = time();
//DB::$mDebug=true;

$where = "WHERE `system` = 'Y' AND end_time > $now And team.id NOT IN (Select id_product From promotion_product Where id_promotion_category = $id_promotion_category)";
$keyword = strval($_GET['key']);
if ($keyword)
{
	$where .= " AND (masp like '%".mysql_escape_string($keyword)."%' or product like '%".mysql_escape_string($keyword)."%')";
}
$sqlCount = "SELECT count(1) as count_item FROM `team` $where";
$count_item = DB::GetQueryResult($sqlCount); $count = $count_item["count_item"];
list($pagesize, $offset, $pagestring) = pagestring($count, 20);
$sql = "SELECT * FROM `team` $where";
$teams = DB::GetQueryResult($sql . "  LIMIT $offset,$pagesize", 0);
//echo "<br>$sql";

foreach($teams as $key => $value){
	$total = DB::GetQueryResult("SELECT sum(quantity) as qty FROM `order` WHERE team_id=".$value['id']);	
	if ($total['qty']>$value['now_number']){
		 DB::Query("UPDATE `team` SET now_number=".$total['qty']." WHERE id=".$value['id']);
    }
}
$cities = Table::Fetch('category', Utility::GetColumn($teams, 'city_id'));
$groups = Table::Fetch('category', Utility::GetColumn($teams, 'group_id'));

$selector = 'promotion_category';
include( "../../include/compiled/manage_team_select_promotion_product.php");
