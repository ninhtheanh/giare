<?php  
require_once(dirname(dirname(__FILE__)) . '/app.php');

$sql = "Select promotion_category.id, promotion_type, promotion_value From promotion_category, promotion_product Where promotion_category.id = promotion_product.id_promotion_category 
And promotion_category.activate = 1 And promotion_category.start_time <= CURDATE() And promotion_category.end_time >= CURDATE() LIMIT 0, 1;";
$promotion_category = DB::GetQueryResult($sql);
$id_promotion_category = $promotion_category['id'];
//echo "<br>$id_promotion_category";
if($id_promotion_category <= 0)
{
    redirect( "" );
}
else
{
    $promotion_type = $promotion_category['promotion_type'];
    $promotion_value = $promotion_category['promotion_value'];    
}
//echo '<br>promotion_type:' . $promotion_type . "," . $promotion_value;
$now = time();
$mark = $now - ($now % 60);
//DB::$mDebug=true;
$where = "WHERE `team_type` = 'normal' AND city_id IN(556,0,".abs(intval($city['id'])).") AND team.begin_time <= $mark AND team.end_time > $now 
AND ((max_number > 0 AND now_number < max_number) OR max_number = 0) AND `status` = 'Y'
AND promotion_product.id_promotion_category = $id_promotion_category AND team.id = promotion_product.id_product 
And promotion_category.id = promotion_product.id_promotion_category And promotion_category.start_time <= CURDATE() And promotion_category.end_time >= CURDATE()";
if (!option_yes('displayfailure')) {
		$condition['OR'] = array(
			"team.now_number >= 100",
			"team.end_time > $mark",
		);
    $where .= " AND (team.now_number >= 100 OR team.end_time > $mark)";
}
$sqlCount = "SELECT count(1) as count_item FROM `team`, promotion_category, promotion_product $where";
$count_item = DB::GetQueryResult($sqlCount); $count = $count_item["count_item"];
list($pagesize, $offset, $pagestring) = pagestring($count, 1000);
$sql = "SELECT team.* FROM `team`, promotion_category, promotion_product $where";
$teams = DB::GetQueryResult($sql . "  LIMIT $offset,$pagesize", 0);
//echo '<br>sqlCount:' . $sqlCount;
//

foreach($teams AS $id=>$one){
	team_state($one);
	if (!$one['close_time']) $one['picclass'] = 'isopen';
	if ($one['state']=='soldout') $one['picclass'] = 'soldout';
	if ($one['state']=='success' && $one['close_time']) $one['picclass'] = 'issuccess';
	$teams[$id] = $one;
}


$category = Table::Fetch('category', $group_id);
$pagetitle = 'Deal du lịch';
include( "../include/compiled/team_promotion.php");