<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$pagetitle = 'Cảm nhận của khách hàng về dealsoc';
 $cond = array(
 	'status' => 'A',	
 );
$realname = $login_user['realname'];
$email = $login_user['email'];
$mobile = $login_user['mobile'];


if($_POST){
	if ($_POST['email']!='' && $_POST['mobile']!='' && $_POST['fullname']!='' && $_POST['content']) {
		if($_POST['captchacode']==$_SESSION['codeimg']){
			$table = new Table('comments', $_POST);
			$table->date_created = date('Y-m-d H:i:s',time());
			$table->user_id = $login_user_id;
			$table->status = (strtoupper($table->status)=='A') ? 'A' : 'D';
			$table->insert(array(
				'email', 'fullname', 'mobile', 'status', 'date_created', 'user_id', 'content',
			));
			Session::Set('notice', 'Đã gửi cảm nhận thành công. Cảm nhận của bạn sẽ được xét duyệt trước khi đăng. Cảm ơn bạn');
			redirect( WEB_ROOT . '/about/comment.php');
		}else{	
			$email = $_POST['email'];
			$realname = $_POST['fullname'];
			$mobile = $_POST['mobile'];
			$content = $_POST['content'];
			$err = 1;
		}
	}else{
		Session::Set('notice', 'Vui lòng nhập đầy đủ các thông tin yêu cầu');
		redirect( WEB_ROOT . '/about/comment.php');
	}
}else{

	$count = Table::Count('comments', $cond);
	list($pagesize, $offset, $pagestring) = pagestring($count,20);	
	$comment = DB::LimitQuery('comments', array(
		'condition' => $cond,
		'order' => 'ORDER BY `id` DESC',
		'size' => $pagesize,
		'offset' => $offset,
	));
	
}

include template('about_comment');