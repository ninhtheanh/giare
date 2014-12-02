<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('misc');

$id = abs(intval($_REQUEST['id']));
$topic = Table::Fetch('topic', $id);
$table = new Table('topic', $_POST);
$uarray = array( 'content'); 
if(is_post() && isset($_POST['replytopicuser'])){
	need_login();
	$reply_topic_user = new Table('topic_reply', $_POST);
	$reply_topic_user->user_id_reply = $login_user_id;
	$reply_topic_user->create_time = time();
	$reply_topic_user->status = 'Y';
	$reply_topic_user->content = $_POST['content_reply'];
	$insert =  array(
			'user_id', 'topic_id', 'user_id_reply', 'content', 'create_time', 'status',
		);
	$reply_topic_user->insert($insert);
}else{
		if($_POST['content']=='') {
			Session::Set('error', 'Nội dung không được để trống.');
			redirect(null);
		}

	if ( $topic ) {
		if ( $flag = $table->update( $uarray ) ) {
			Session::Set('notice', 'Topic . '.$id.' editing succeeded');
		} else {
			Session::Set('error', 'Topic . '.$id.' editing failed');
		}
	}
}

redirect(null);