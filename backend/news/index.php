<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();

//delete
$action = strval($_GET['action']);
$id = strval($_GET['id']);

if($_POST)
{
	
}
else
{
	if($action == 'delete' && $id != "")
	{
		Table::Delete('news', $id);
		Session::Set('notice', "Đã xóa thành công");
	}
}

$condition = array();
$count = Table::Count('news', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$categories = DB::LimitQuery('news', array(
	'order' => 'ORDER BY date_created DESC',
	'size' => $pagesize,
	'offset' => $offset,
));
include '../../include/compiled/manage_news_index.php';
