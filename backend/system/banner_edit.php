<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('admin');

$id = $_REQUEST['id'];
$arrRows = Table::Fetch('banner', $id);

if ($_POST) { 
	//DB::$mDebug=true;
	$img = upload_image('upload_image',$arrRows['image'], 'banner');
	//echo "img:" . $img;
	$img = $img != "" ? $img : $_POST['hidden_img'];
	
	$activate = isset($_POST['activate']) ? 1 : 0;
	if(strlen($_POST['id']) > 0) //update
	{		
		$table = new Table('banner', $_POST);		
		$table->img = $img;
		$table->url = $_POST['url'];
		$table->banner_type = $_POST['banner_type'];
		$table->activate = $activate;
		$uarray = array( 'id',  'img', 'url', 'banner_type', 'activate');
		
		$flag = $table->update( $uarray );
		if ( $flag ) {
			Session::Set('notice', 'Banner has been updated successful');
			redirect( WEB_ROOT . 'banner.php');
		}		
	}
	else //insert
	{
		DB::Insert('banner',array(
				'id' => convertVN_To_EN($_POST['name']),
				'img' => $img,
				'url' =>  $_POST['url'],
				'activate' => $activate,
				'banner_type' =>  $_POST['banner_type'],
			));		
		//if(strlen($id) > 1)
		{
			Session::Set('notice', 'Banner has been added successful');
			redirect( WEB_ROOT . 'banner.php');
		}
	}
	$arrRows = $_POST;
}
include '../../include/compiled/manage_system_banner_edit.php';


