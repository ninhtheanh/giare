<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('team');

//delete
$action = strval($_GET['action']);
$id = strval($_GET['id']);

if($_GET)
{
	if($action == 'delete' && $id != "")
	{
		Table::Delete('promotion_category', $id);
		Session::Set('notice', "Đã xóa thành công");
        $sql = "Delete From promotion_product Where id_promotion_category = " . $id;
    	//echo "<br>$sql";
    	DB::GetQueryResult($sql);
	}
}

$condition = array();
$count = Table::Count('promotion_category', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$categories = DB::LimitQuery('promotion_category', array(
	'order' => 'ORDER BY date_created DESC',
	'size' => $pagesize,
	'offset' => $offset,
));

$selector = 'promotion_category';
include( "../../include/compiled/manage_team_promotion_category.php");
