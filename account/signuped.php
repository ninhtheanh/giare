<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

($email = Session::Get('unemail')) || ($email = $login_user['email']);
$wwwlink = mail_zd($email);
$pagetitle = 'Đăng ký tài khoản trên '.$INI['system']['sitename'].' thành công';
include template('account_signuped');
