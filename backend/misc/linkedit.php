<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('admin');

$id = abs(intval($_REQUEST['id']));
$friendlink = Table::Fetch('friendlink', $id);
$table = new Table('friendlink', $_POST);
$table->letter = strtoupper($table->letter);
$table->display = strtoupper($table->display)=='Y' ? 'Y' : 'N';
$uarray = array( 'title','url','logo','sort_order', 'display'); 

if (!$_POST['title'] || !$_POST['url'] ) {
	Session::Set('error', 'Site name, Web site address can not be empty');
	redirect(null);
}

if ( $friendlink ) {
	if ( $flag = $table->update( $uarray ) ) {
		Session::Set('notice', 'Edit Link successfully');
	} else {
		Session::Set('error', 'Edit link failure');
	}
} else {
	if ( $flag = $table->insert( $uarray ) ) {
		Session::Set('notice', 'New link successfully Added');
	} else {
		Session::Set('error', 'New link failure');
	}
}

redirect(null);
