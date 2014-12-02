<?php
require_once(dirname(__FILE__) . '/app.php');


if ($_POST['email']) 
{
	if($_POST['captchacode']==$_SESSION['codeimg'])
	{
		$subscribe['email'] = $_POST['email'];
		ZSubscribe::Unsubscribe($subscribe);	
		Session::Set('notice', 'Đã hủy đăng ký nhận Email, Vui lòng đăng ký nhận Email nếu bạn muốn tiếp tục nhận Email từ hotdeal.vn.');
		redirect( WEB_ROOT  . '/subscribe.php');
	}
	else
	{	
		$email = $_POST['email'];
		$err = 1;
	}
}

$pagetitle = 'Hủy đăng ký nhận mail';//'Mail subscription';
include template('unsubscribe_form');