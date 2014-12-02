<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

if ( $_POST ) {
	$login_partner = ZPartner::GetLogin($_POST['username'], $_POST['password']);
	if ( !$login_partner ) {
		//Session::Set('error', 'username and password dont match！');
		Session::Set('error','Tên đăng nhập hoặc mật khẩu không đúng!');
		redirect( WEB_ROOT . '/biz/login.php');
	} else {
		Session::Set('partner_id', $login_partner['id']);
		redirect( WEB_ROOT . '/biz/index.php');
	}
}

include template('biz_login');
