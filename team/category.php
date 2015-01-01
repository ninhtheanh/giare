<?php  
require_once(dirname(dirname(__FILE__)) . '/app.php');

$id_name = strval($_GET['id_name']);// echo $id_name;

$arrRows = DB::LimitQuery('category', array(		
		'condition' => "id_name = '$id_name'",
	));
	
$group_id = $arrRows[0]['id'];
$category_name = $arrRows[0]['name'];
//echo "id_name:" . $id_name . ", group_id:" . $group_id . ", category_name:" . $category_name;
function get_products($id_name, $group_id, $city)
{
	$now = time();
	$mark = $now - ($now % 60);
	
	$condition = array(
		'team_type' => 'normal',
		'city_id' => array(556, 0, abs(intval($city))),
	//	"id NOT IN (1493)",
		"begin_time <= $mark",
		"end_time > $now",
		"(max_number>0 AND now_number < max_number) OR max_number=0",
		'status' => 'Y',
	);
	
	if ($group_id && $group_id != "")
	{ 
		if(is_numeric($group_id))
			$condition['group_id'] = $group_id;
		else
		{
			$condition = array(
				'team_type' => 'normal',
				'city_id' => array(556, 0, abs(intval($city))),
			//	"id NOT IN (1493)",
				"begin_time <= $mark",
				"end_time > $now",
				"(max_number>0 AND now_number < max_number) OR max_number=0",
				'status' => 'Y',
				'group_id = ' . $group_id,				
			);	
		}
	}
	
	if (!option_yes('displayfailure')) {
		$condition['OR'] = array(
			"now_number >= 100",
			"end_time > $mark",
		);
	}
	//$condition['select'] = "id";
	//$condition = array();
	
	$home_side_ns = 1000;
			
	$count = Table::Count('team', $condition);
	list($pagesize, $offset, $pagestring) = pagestring($count,$home_side_ns);
	
	$ckey = 'past'.$_GET['page'];
	$sql_sub = "(Select CONCAT(id_promotion_category, ';' ,promotion_type, ';' ,promotion_value) From promotion_category, promotion_product 
                Where promotion_category.id = promotion_product.id_promotion_category And promotion_category.start_time <= CURDATE() And promotion_category.end_time >= CURDATE() 
                And promotion_category.activate = 1 And promotion_product.id_product = team.id) as promotion";
	$teams = DB::LimitQuery('team', array(
			'condition' => $condition,
			'order' => 'ORDER BY sort_order DESC, id DESC',
			'size' => $pagesize,
			'offset' => $offset,
            'select' => "team.*, $sql_sub",
		));
	return $teams;	
}
//
//DB::$mDebug=true;
$teams = get_products($id_name, $group_id, $city['id']);	
//echo '<br>count 1:' . count($teams);	
if(count($teams) == 0)
{
	$child_cate = DB::LimitQuery('category', array(
		'condition' => "display = 'Y' And zone = 'group' And parent = '$group_id'",
		'order' => 'ORDER BY sort_order DESC, id DESC',
	));
	$strID = "";
	if(count($child_cate) > 0)
	{
		foreach($child_cate as $item)
		{
			if($strID != "") $strID .= " OR group_id = ";
			$strID .= $item['id'];
		}
		$teams = get_products($id_name, $strID, $city['id']);	
		//echo '<br>count 2:' . count($teams);		
	}
}
//echo '<br>strID:' . $strID;	
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
include template('team_category');

