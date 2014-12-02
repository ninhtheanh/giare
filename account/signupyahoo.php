<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
if (isset($_POST['registeryahoo'])) {
	$user_details = array();
	$user_details = $_SESSION['YAHOO_USER_LOGIN'];
	unset($_SESSION['YAHOO_USER_LOGIN']);
	$au = Table::Fetch('user',  $enc->encrypt(ZUser::SECRET_KEY, $_POST['email']), 'email');
	if(!Utility::ValidEmail($_POST['email'], true)){
		Session::Set('error','Địa chỉ email không hợp lệ');
		Utility::Redirect( WEB_ROOT . '/account/signupemail.php');
	}
	if ($_POST['password2']!=$_POST['password']){
		Session::Set('error', 'Mật khẩu không hợp lệ');
		Utility::Redirect( WEB_ROOT . '/account/signupemail.php');
	}
	if($au){
		Session::Set('error', 'Email này đã được đăng ký tài khoản trên '.$INI['system']['sitename'].'. Nếu bạn quên mật khẩu vui lòng click <a href="/account/repass.php">vào đây</a> để lấy lại mật khẩu');
		Utility::Redirect( WEB_ROOT . '/account/signupemail.php');
	}
	if($user_details) {
		$user_details['email'] = $_POST['email'];
		$user_details['username'] = $_POST['email'];
		$user_details['realname'] = strval($_POST['realname']);
		$user_details['gender'] = strval($_POST['gender']);
		$user_details['dob'] = checkdate((int)@$_POST['dob_m'],(int)@$_POST['dob_d'],(int)@$_POST['dob_y']) ? (int)@$_POST['dob_y']."-".(int)@$_POST['dob_m']."-".(int)@$_POST['dob_d'] : "";
		$user_details['password'] = $_POST['password'];
		$user_details['is_yahoo'] = 'yes';
		if($user_id = ZUser::Create($user_details)){
			ZLogin::Login($user_id);
			redirect(get_loginpage(WEB_ROOT . '/account/settings.php'));
		}else{
			$user_row = Table::Fetch('user', $enc->encrypt(ZUser::SECRET_KEY, $_POST['email']), 'email');
			ZLogin::Login($user_row['id']);
			redirect(get_loginpage(WEB_ROOT . '/account/settings.php'));
		}
	}	
}

include template('signupyahoo');

?>

