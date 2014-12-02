<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_manager();

$action = strval($_GET['action']);
$id = $topic_id = abs(intval($_GET['id']));
$reply_id = abs(intval($_GET['reply_id']));
$topic = Table::Fetch('topic', $id);
$pid = abs(intval($topic['parent_id']));

$tid = abs(intval($_GET['tid']));
if($tid>0){
	if ( $action == 'testimonyremove') {
		Table::UpdateCache('comments', $tid, array(
			'status' => 'D',
		));
		Session::Set('notice', 'Comment Deleted');
		json(null, 'refresh');
	}elseif ( $action == 'testimonyhidden') {
		Table::UpdateCache('comments', $tid, array(
			'status' => 'D',
		));
		Session::Set('notice', 'Comment Hidden');
		json(null, 'refresh');
	}elseif ( $action == 'testimonyshow') {
		Table::UpdateCache('comments', $tid, array(
			'status' => 'A',
		));
		Session::Set('notice', 'Comment Show');
		json(null, 'refresh');
	}
}else{
	if (!$topic || !$id) {
		json('Topic does not exist', 'alert');
	}elseif ( $action == 'topicremove') {
	
		if ( $pid==0 ) {
			Table::Delete('topic', $id);
			Table::Delete('topic', $id, 'parent_id');
		} else {
			
			Table::Delete('topic', $id);
		Table::UpdateCache('topic', $id, array(
				'status' => 'D',
			));
			Table::UpdateCache('topic', $pid, array(
				'reply_number' => Table::Count('topic', array('parent_id' => $pid) ),
			));
			
		}
		Session::Set('notice', 'Post Deleted');
		json(null, 'refresh');
	}elseif ( $action == 'topichidden') {
		Table::UpdateCache('topic', $id, array(
			'status' => 'N',
		));
		Session::Set('notice', 'Topic Hidden');
		json(null, 'refresh');
	}elseif ( $action == 'topicshow') {
		Table::UpdateCache('topic', $id, array(
			'status' => 'Y',
		));
		Session::Set('notice', 'Topic Show');
		json(null, 'refresh');
	}elseif ( $action == 'topicreplyremove') {
		//Table::Delete('topic_reply', $reply_id);
		Table::UpdateCache('topic_reply', $reply_id, array(
			'status' => 'D',
		));
		Session::Set('notice', 'Post Deleted');
		json(null, 'refresh');
	}elseif ( $action == 'topicreplyhidden') {
		Table::UpdateCache('topic_reply', $reply_id, array(
			'status' => 'N',
		));
		Session::Set('notice', 'Topic Reply Hidden');
		json(null, 'refresh');
	}elseif ( $action == 'topicreplyshow') {
		Table::UpdateCache('topic_reply', $reply_id, array(
			'status' => 'Y',
		));
		Session::Set('notice', 'Topic Reply Show');
		json(null, 'refresh');
	}elseif ( $action == 'topichead' ) {
		if ( $topic['parent_id']>0 ) {
			json('Only the main topic to top...', 'alert');
		}
		$head = ($topic['head']==0) ? time() : 0;
		Table::UpdateCache('topic', $id, array( 'head' => $head,));
		$tip = $head ? 'Set topic sticky success' : 'Cancel Topics Top success';
		Session::Set('notice', $tip);
		json(null, 'refresh');
	}
	elseif ( 'topicedit' == $action ) {
		need_auth('misc');
		if ($id) {
			$topic = Table::Fetch('topic', $id);
			if (!$topic) json('No data', 'alert');
		}
		$html = render('manage_ajax_dialog_topicedit');
		json($html, 'dialog');
	}
}