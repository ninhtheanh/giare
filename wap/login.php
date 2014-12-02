<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

if ( $login_user_id ) { 
	redirect('index.php'); 
}

if ( $_POST ) {
	$login_user = ZUser::GetLogin($_POST['email'], $_POST['password']);
	if ( !$login_user ) {
		Session::Set('error', 'login failed');
		redirect('login.php');
	} else if (option_yes('emailverify')
			&& $login_user['enable']=='N'
			&& $login_user['secret']
			) {
		Session::Set('error', "Your eamil address{$login_user['email']}hasn't been verified");
		redirect('login.php');
	} else {
		Session::Set('user_id', $login_user['id']);
		ZLogin::Remember($login_user);
		redirect(get_loginpage('index.php'));
	}
}

$currefer = strval($_GET['r']);
if ($currefer) { Session::Set('loginpage', udecode($currefer)); }
$pagetitle = 'Login';
include template('wap_login');
