<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$pagetitle = 'Mời bạn bè cùng tham gia để được thưởng';

if (! is_login() ) {
	die(include template('account_invite_signup'));
}

if($_POST['recipients'] && $_POST['invitation_content']) {
	$emails = $_POST['recipients'];
	($name = $_POST['real_name']) || ($name = $login_user['username']);
	$content = $_POST['invitation_content'];
	mail_invitation($emails, $content, $name);
	Session::Set('notice', 'Gửi lời mời thành công');
	redirect( WEB_ROOT . '/account/invite.php' );
}


$condition = array( 
		'user_id' => $login_user_id, 
		'credit > 0',
		'pay' => 'Y',
		);
$money = Table::Count('invite', $condition, 'credit');
$count = Table::Count('invite', $condition);

$team = current_team($city['id']);
die(include template('account_invite'));
