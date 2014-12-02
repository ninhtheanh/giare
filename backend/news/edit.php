<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('admin');

$id = $_REQUEST['id'];
$arrRows = Table::Fetch('news', $id);
//print_r($arrRows);
//DB::$mDebug=true;
$redirectPage = FALSE;
if ($_POST) 
{
	$activate = isset($_POST['activate']) ? 1 : 0;	
	if(strlen($_POST['id']) > 0) //update
	{		
		$table = new Table('news', $_POST);		
		$table->title = $_POST['title'];
		$table->subject = $_POST['subject'];
		$table->description = $_POST['description'];		
		$table->activate = $activate;
		$table->date_modified = date('Y-m-d H:i:s');
		
		$uarray = array( 'id',  'title', 'subject', 'description', 'activate', 'date_modified');
		
		$flag = $table->update( $uarray );
		if ( $flag ) {
			Session::Set('notice', '"' . $_POST['title'] . '"' . ' has been updated successful');			
			$redirectPage = TRUE;
		}		
	}
	else //insert
	{
		$id = DB::Insert('news',array(
				'id' => $_POST['id'],
				'title' => $_POST['title'],
				'subject' =>  $_POST['subject'],
				'description' => $_POST['description'],				
				'activate' => $activate,
				'date_modified' => date('Y-m-d H:i:s')
			));		
		if(strlen($id) > 0)
		{
			Session::Set('notice', '"' . $_POST['title'] . '"' . ' has been added successful');
			$redirectPage = TRUE;
		}
		//echo "<br>id:$id";
	}
	//Upload & update intro Database.
	$img = upload_image_news('upload_image', "news", $id, $arrRows['image']);	
	if($img != "")
	{		
		$_POST['id'] = $id;
		if($img[0] != "/")
			$img = "/" . $img;
		$thumb = str_replace('.jpg', "_thumb.jpg", $img);
		$image = str_replace('.jpg', "_large.jpg", $img);
		//echo "<br>thumb:".$thumb . "<br> image:".$image;
		$table = new Table('news', $_POST);			
		$table->thumb = $thumb;
		$table->image = $image;		
		$uarray = array( 'id',  'thumb', 'image');		
		$flag = $table->update( $uarray );
		
		$arrRows = Table::Fetch('news', $id);
	}
	if($redirectPage)
		redirect( WEB_ROOT . 'index.php');
	//$arrRows = $_POST;
	//print_r($arrRows);
}
include '../../include/compiled/manage_news_edit.php';
