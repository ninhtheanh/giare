<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');
//delete
$action = strval($_GET['action']);
$id = strval($_GET['id']);

if($_POST)
{
	$hidden_str_id = strval($_POST['hidden_str_id']);
	$arrID = split(",", $hidden_str_id);
	foreach($arrID as $id)
	{
		if($id != "")
		{	
			//DB::$mDebug=true;
			$show_on_footer = isset($_POST['show_on_footer_' . $id]) ? 1 : 0;
			$order = intval($_POST['order_' . $id]);			
			$table = new Table('page', array('order'=>$order, 'show_on_footer'=>$show_on_footer));
		 	$table->SetPK('id', $id);
			$flag = $table->update(array( 'id', 'order', 'show_on_footer'));
		}
	}	
}
else
{
	if($action == 'delete' && $id != "")
	{
		Table::Delete('page', $id);
		Session::Set('notice', "Đã xóa thành công");
	}
}
//list
$count = Table::Count('page', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);
//DB::$mDebug=true;
$categories = DB::LimitQuery('page', array(
	'order' => 'ORDER BY page_type, `order`',
	'size' => $pagesize,
	'offset' => $offset,
));
$arrPageType = array("about"=>"Về CheapDeal", "support"=>"Hỗ trợ", "useful_info"=>"Thông Tin Hữu Ích", "other"=>"Khác");
function getPageTypeName($arrPageType, $page_type)
{
	while (list($key, $value) = each($arrPageType))
	{
	 if($page_type == $key)
	 	return $value;
	}		
}
include template('manage_system_page');
