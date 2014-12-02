<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
if ( $_POST ) {	
	

	$login_user = ZUser::GetLogin($_POST['email'], $_POST['password']);
	
	if ( !$login_user ) {			
		Session::Set('error', 'Đăng nhập không thành công. Vui lòng kiểm tra lại tên đăng nhập hoặc mật khẩu!');		
		redirect(WEB_ROOT . '/account/login.php');
	} else if (option_yes('emailverify')
			&& $login_user['enable']=='N'
			&& $login_user['secret']
			) {
		Session::Set('unemail', $_POST['email']);
		redirect(WEB_ROOT .'/account/verify.php');
	} else {
		Session::Set('user_id', $login_user['id']);
		ZLogin::Remember($login_user);
		ZUser::SynLogin($login_user['username'], $_POST['password']);
		ZCredit::Login($login_user['id']);
		//api key
		$have = Table::Fetch('user', $login_user['id']);
		if(!$have['api_key']){	
			$k = md5(microtime());
			Table::UpdateCache('user', $login_user['id'], array(
			'api_key' => $k,			
			));
		}
		redirect(get_loginpage(WEB_ROOT . '/index.php'));
	}
}
$currefer = strval($_GET['r']);
if ($currefer) { Session::Set('loginpage', udecode($currefer)); }
$pagetitle = 'Đăng nhập bằng tài khoản '.$INI['system']['abbreviation'];
include template('account_login');
