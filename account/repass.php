<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

if (is_post()) {
	
	$email = $enc->encrypt(ZUser::SECRET_KEY, strval($_POST['email']));
	
	$user = Table::Fetch('user', $email, 'email');
	if ( $user ) {
		$user['email'] = $enc->decrypt(ZUser::SECRET_KEY, $user['email']);
		$user['recode'] = $user['recode'] ? $user['recode'] : md5(json_encode($user));
		Table::UpdateCache('user', $user['id'], array(
			'recode' => $user['recode'],
		));
		
		mail_repass($user);
		Session::Set('reemail', $user['email']);
		redirect( WEB_ROOT .'/account/repass.php?action=ok');
	}
	Session::Set('error', 'Email này chưa được đăng ký tài khoản trên '.$INI['system']['sitename']);
	redirect( WEB_ROOT . '/account/repass.php');
}

$action = strval($_GET['action']);
if ( $action == 'ok') {
	die(include template('account_repass_ok'));
}
$pagetitle = 'Quên mật khẩu';
include template('account_repass');
