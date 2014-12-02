<?php
//echo 'Hệ thống đang bảo trì trong vòng 30p. Mong bạn thông cảm'; exit;
require_once(dirname(dirname(__FILE__)) . '/app.php');

$ref = $_GET['ref'];
if ( $_POST ) {
	$u = array();
	$u['username'] = strval($_POST['email']);
	$u['password'] = strval($_POST['password']);
	$u['email'] = strval($_POST['email']);
	$u['realname'] = strval($_POST['realname']);
	$u['gender'] = strval($_POST['gender']);
	$u['dob'] = checkdate((int)@$_POST['dob_m'],(int)@$_POST['dob_d'],(int)@$_POST['dob_y']) ? (int)@$_POST['dob_y']."-".(int)@$_POST['dob_m']."-".(int)@$_POST['dob_d'] : "";
	$u['house_number'] = $_POST['house_number'];
	$u['street_name'] = $_POST['street_name'];
	$u['address'] = $_POST['house_number']." ".$_POST['street_name'];
	$u['note_address'] = strval($_POST['note_address']);
	$u['dist_id'] = isset($_POST['dist_id']) ? abs(intval($_POST['dist_id'])) : abs(intval($dist['dist_id']));
	$u['ward_id'] = isset($_POST['ward_id']) ? abs(intval($_POST['ward_id'])) : abs(intval($dist['ward_id']));
	$u['city_id'] = isset($_POST['city_id']) ? abs(intval($_POST['city_id'])) : abs(intval($city['id']));
	$u['mobile'] = strval($_POST['mobile']);

	if ( $_POST['subscribe'] ) { 
		ZSubscribe::Create($u['email'], abs(intval($u['city_id']))); 
	}
	if ( ! Utility::ValidEmail($u['email'], true) ) {
		Session::Set('error', 'Địa chỉ email không hợp lệ');
		redirect( WEB_ROOT . '/account/signup.php?ref='.$ref);
	}
	if ($_POST['password2']==$_POST['password'] && $_POST['password']) {
		if ( option_yes('emailverify') ) { 
			$u['enable'] = 'Y'; 
		}
		
		if ( $user_id = ZUser::Create($u) ) {
			if ( option_yes('emailverify') ) {
				mail_sign_id($user_id);
				Session::Set('unemail', $_POST['email']);
				redirect( WEB_ROOT . '/account/signuped.php?ref='.$ref);
			} else {
				ZLogin::Login($user_id);
				// sign up email
				$content = render('account_email_signup', $u);			
				mail_custom($u['email'], 'Cheapdeal - Xác nhận đăng ký tài khoản', $content); // maybe you will get some delay here
				redirect(get_loginpage(WEB_ROOT . '/index.php'));
			}
		
		} else {			
			$au = Table::Fetch('user', $enc->encrypt(ZUser::SECRET_KEY, $_POST['email']), 'email');			
			if ($au) {
				Session::Set('error', 'Email này đã được đăng ký tài khoản trên '.$INI['system']['sitename'].'. Nếu bạn quên mật khẩu vui lòng click <a href="/account/repass.php">vào đây</a> để lấy lại mật khẩu');
			} else {
				Session::Set('error', 'Tên đăng nhập đã được đăng ký.');
			}
		}
	} else {
		Session::Set('error', 'Mật khẩu không hợp lệ');
	}
}

$pagetitle = 'Đăng ký tài khoản trên'.$INI['system']['abbreviation'];
include template('account_signup');
