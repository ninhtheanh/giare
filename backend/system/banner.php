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
			$order = intval($_POST['order_' . $id]);
			$activate = isset($_POST['activate_' . $id]) ? 1 : 0;			
			$table = new Table('banner', array('order'=>$order, 'activate'=>$activate));
		 	$table->SetPK('id', $id);
			$flag = $table->update(array( 'id', 'order', 'activate'));
		}
	}	
}
else
{
	if($action == 'delete' && $id != "")
	{
		Table::Delete('banner', $id);
		Session::Set('notice', "Đã xóa thành công");
	}
}
//list
$count = Table::Count('banner', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);
//DB::$mDebug=true;
$categories = DB::LimitQuery('banner', array(
	'order' => 'ORDER BY banner_type DESC, activate DESC, `order` ASC',
	'size' => $pagesize,
	'offset' => $offset,
));
include template('manage_banner_page');
