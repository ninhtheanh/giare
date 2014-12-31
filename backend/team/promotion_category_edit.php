<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('team');

//delete
$action = strval($_GET['action']);
$id = strval($_GET['id']);
//DB::$mDebug=true;
if($_POST)
{
	$activate = isset($_POST['activate']) ? 1 : 0;	
    $promotion_value = $_POST['promotion_value'];
    $promotion_value = str_replace(".", "", $promotion_value);
    $promotion_value = is_numeric($promotion_value) ? $promotion_value : 0;
	if(strlen($_POST['id']) > 0) //update
	{		
		$table = new Table('promotion_category', $_POST);		
		$table->promotion_name = $_POST['promotion_name'];
		$table->promotion_type = $_POST['promotion_type'];
		$table->promotion_value = $promotion_value;	
        $table->start_time = $_POST['start_time'];
        $table->end_time = $_POST['end_time'];
        $table->activate = $activate;        	
		$table->date_modified = date('Y-m-d H:i:s');
		
		$uarray = array( 'id',  'promotion_name', 'promotion_type', 'promotion_value', 'start_time', 'end_time', 'activate', 'date_modified');
		
		$flag = $table->update( $uarray );
		if ( $flag ) {
			Session::Set('notice', '"' . $_POST['promotion_name'] . '"' . ' has been updated successful');			
			$redirectPage = TRUE;
		}		
	}
	else //insert
	{
		$id = DB::Insert('promotion_category',array(
				'id' => $_POST['id'],
				'promotion_name' => $_POST['promotion_name'],
				'promotion_type' =>  $_POST['promotion_type'],
				'promotion_value' => $promotion_value,
                'start_time' => $_POST['start_time'],
                'end_time' => $_POST['end_time'],            			
				'activate' => $activate,
                'date_created' => date('Y-m-d H:i:s'),
				'date_modified' => date('Y-m-d H:i:s')
			));	
		if(strlen($id) > 0)
		{
			Session::Set('notice', '"' . $_POST['promotion_name'] . '"' . ' has been added successful');
			$redirectPage = TRUE;
		}
		//echo "<br>id:$id";
	}
    if($activate == 1)
    {
        $sql = "Update promotion_category Set activate = 0 Where id <> $id";
        DB::GetQueryResult($sql);
    }
	if($redirectPage)
	   redirect( WEB_ROOT . 'promotion_category.php');
}
else
{
	if($action == 'delete' && $id != "")
	{
		Table::Delete('promotion_category', $id);
		Session::Set('notice', "Đã xóa thành công");
	}
}
$promotion = Table::Fetch('promotion_category', $id);
$selector = 'promotion_category';
include( "../../include/compiled/manage_promotion_category_edit.php");
                                   
