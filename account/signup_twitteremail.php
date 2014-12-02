<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
if ( isset($_POST['email'])) {
	$user_details=array();
	$user_details = $_SESSION['TWITTER_USER_LOGIN'];
	$user_details['email'] = $_POST['email'];
	$user_details['username'] = $_POST['username'];
	$user_details['password'] = $_POST['password'];
	$user_details['twitter_userid'] = $_SESSION['TWITTER_USER_LOGIN']['twitter_userid'];
	if ( ! Utility::ValidEmail($_POST['email'], true) ) {
		Session::Set('error', 'Email is not a valid email address');
		Utility::Redirect( WEB_ROOT . '/account/signup_twitteremail.php');
	}
	if($user_id = ZUser::Create($user_details)){
		ZLogin::Login($user_id);
		Utility::Redirect( WEB_ROOT . '/index.php');
	}
}	
$pagetitle = 'Registration';	
include template('signup_twitteremail');
?>