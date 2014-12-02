<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

$id = abs(intval($_REQUEST['id']));
$goods = Table::Fetch('goods', $id);

$table = new Table('goods', $_POST);
$table->letter = strtoupper($table->letter);
$uarray = array('title','number','image','score','display','sort_order','time'); 
$table->display = strtoupper($table->display)=='Y' ? 'Y' : 'N';
$table->image = upload_image('upload_image', $goods['image'], 'team');
$table->time = time();

if (!$_POST['title'] || !$_POST['score'] ) {
	Session::Set('error', 'title and credit must not be empty');
	redirect(null);
}

if ( $goods ) {
	if ( $flag = $table->update( $uarray ) ) {
		Session::Set('notice', 'goods editing succeeded');
	} else {
		Session::Set('error', 'goods editing failed');
	}
} else {
	if ( $flag = $table->insert( $uarray ) ) {
		Session::Set('notice', 'goods creation succeeded');
	} else {
		Session::Set('error', 'goods creation failed');
	}
}

redirect(null);
