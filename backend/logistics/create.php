<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('logistics');
$city_id = $city['id'];
if ( $_POST ) {
	$table = new Table('shipper', $_POST);
	$table->create_time = time();
	$table->user_id = $login_user_id;
	$table->shipper_status = (strtoupper($table->shipper_status)=='A') ? 'A' : 'D';
	$table->insert(array(
		'shipper_name', 'shipper_address', 'shipper_tel', 'shipper_status', 'create_time',
		'user_id', 'city_id',
	));
	redirect( WEB_ROOT . '/backend/logistics/index.php');
}

include template('logistics/manage_shipper_create');
