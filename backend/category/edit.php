<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('admin');

$id = abs(intval($_REQUEST['id']));
$category = Table::Fetch('category', $id);
$table = new Table('category', $_POST);
$uarray = array( 'zone', 'ename', 'letter', 'name', 'czone', 'display', 'sort_order', 'id_name', 'parent', 'icon_category'); 
$table->display = strtoupper($table->display)=='Y' ? 'Y' : 'N';
$table->letter = strtoupper($table->letter);
$table->id_name = convertVN_To_EN($_POST['name']);
$table->parent = $_POST['parent'];
$table->icon_category = $_POST['icon_category'];

print_r($_POST);
if (!$_POST['name'] || !$_POST['ename'] || !$_POST['letter']) {
	Session::Set('error', 'English name,English name Repeat,the initial letter must be typed');
	redirect(null);
}

if ( $category ) {
	if ( $flag = $table->update( $uarray ) ) {
		Session::Set('notice', 'category editing succeeded');
	} else {
		Session::Set('error', 'category editing failed');
	}
	option_category($category['zone'], true);
} else {
	if ( $flag = $table->insert( $uarray ) ) {
		Session::Set('notice', 'new category creation succeeded');
	} else {
		Session::Set('error', 'new category creation failed');
	}
}

option_category($table->zone, true);
redirect(null);
