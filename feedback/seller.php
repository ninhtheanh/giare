<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

if ($_POST) {
	if (!$_POST['content'] || !$_POST['title'] || !$_POST['contact']) {
		Session::Set('error', 'please fill out the order and submit it');
		redirect( WEB_ROOT . '/feedback/seller.php');
	}
	$table = new Table('feedback', $_POST);
	$table->city_id = abs(intval($city['id']));
	$table->create_time = time();
	$table->category = 'seller';
	$table->title = htmlspecialchars($table->title);
	$table->content = htmlspecialchars($table->content);
	$table->contact = htmlspecialchars($table->contact);
	$table->Insert(array(
		'city_id', 'title', 'contact', 'content', 'create_time',
		'category',
	));

	redirect( WEB_ROOT . '/feedback/success.php');
}

$pagetitle = 'Đối tác hợp tác';
include template("feedback_seller");
