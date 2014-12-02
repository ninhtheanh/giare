<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
if ( $_POST ) {
	$user_details = array();
	$user_details = $_SESSION['FB_USER_LOGIN'];
	unset($_SESSION['FB_USER_LOGIN']);
	if ( ! Utility::ValidEmail($_POST['email'], true) ) {
		Session::Set('error','Địa chỉ email không hợp lệ');
		Utility::Redirect( WEB_ROOT . '/account/signupemail.php');
	}
	if($user_details) {
		$user_details['email'] = $_POST['email'];
		$user_details['username'] = $_POST['email'];
		$user_details['password'] = $_POST['password'];
		$user_details['realname'] = $_SESSION['FB_USER_LOGIN']['first_name']." ".$_SESSION['FB_USER_LOGIN']['last_name'];
		$user_details['fb_userid'] = $_SESSION['FB_USER_LOGIN']['id'];
		$user_details['fl_facebook'] = 'new';
		$user_details['dob'] = date("Y-m-d",strtotime($_SESSION['FB_USER_LOGIN']['birthday']));
		if($user_id = ZUser::Create($user_details)) {
			ZLogin::Login($user_id);
			Utility::Redirect( WEB_ROOT . '/index.php');
		}
	}	
}
include template('signupemail');
?>