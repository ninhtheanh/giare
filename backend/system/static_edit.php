<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('admin');

$id = $_REQUEST['id'];
$arrRows = Table::Fetch('page', $id);
//DB::$mDebug=true;
if ($_POST) { 
	$show_on_footer = isset($_POST['show_on_footer']) ? 1 : 0;
	if(strlen($_POST['id']) > 0) //update
	{		
		$table = new Table('page', $_POST);		
		$table->name = $_POST['name'];
		$table->value = $_POST['value'];
		$table->page_type = $_POST['page_type'];	
		$table->show_on_footer = $show_on_footer;	
		$uarray = array( 'id',  'name', 'value', 'page_type', 'show_on_footer');
		
		$flag = $table->update( $uarray );
		if ( $flag ) {
			Session::Set('notice', '"' . $_POST['name'] . '"' . ' has been updated successful');
			redirect( WEB_ROOT . 'page.php');
		}		
	}
	else //insert
	{
		DB::Insert('page',array(
				'id' => convertVN_To_EN($_POST['name']),
				'name' => $_POST['name'],
				'value' =>  $_POST['value'],
				'page_type' => $_POST['page_type'],
				'show_on_footer' => $show_on_footer,
			));		
		//if(strlen($id) > 1)
		{
			Session::Set('notice', '"' . $_POST['name'] . '"' . ' has been added successful');
			redirect( WEB_ROOT . 'page.php');
		}
	}
	$arrRows = $_POST;
}
$arrPageType = array("about"=>"Về CheapDeal", "support"=>"Hỗ trợ", "useful_info"=>"Thông Tin Hữu Ích", "other"=>"Khác");
include '../../include/compiled/manage_system_page_edit.php';


