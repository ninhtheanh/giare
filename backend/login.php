<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');


unset($_SESSION['user_id']); //oct21 wroupon ultrav3 admin fix
unset($_SESSION['FB_LOGOUT_URL']); //oct21 wroupon ultrav3 admin fix
unset($_SESSION['access_token']); //oct21 wroupon ultrav3 admin fix



if ($_POST) {	
	$login_admin = ZUser::GetLogin($_POST['username'], $_POST['password']);
	
	

	if ( !$login_admin || $login_admin['manager'] != 'Y' ) {
		Session::Set('error', 'Username and password don\'t match！');	
		redirect( WEB_ROOT . '/backend/login.php');
	} else {
		Session::Set('admin_id', $login_admin['id']);
		ZLogin::Remember($login_admin);//Oct 18 fix Wroupon
		ZUser::SynLogin($login_admin['username'], $_POST['password']);//Oct 18 fix Wroupon
		ZCredit::Login($login_admin['admin_id']);//Oct 18 fix Wroupon
		redirect( WEB_ROOT . '/backend/index.php');
	}
}
include template('manage_login');
