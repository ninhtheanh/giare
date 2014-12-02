<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('logistics');

$id = abs(intval($_GET['id']));
$shipper = Table::Fetch('shipper', $id);

if ( $_POST && $id==$_POST['id'] && $shipper) {
	$table = new Table('shipper', $_POST);
	$table->user_id = $login_user_id;
	$table->shipper_status = (strtoupper($table->shipper_status)=='A') ? 'A' : 'D';
	$up_array = array(
			'shipper_id', 'shipper_name', 'shipper_address', 'shipper_status', 'user_id','shipper_tel','city_id',
			);

	$flag = $table->update( $up_array );
	if ( $flag ) {
		Session::Set('notice', 'Modify Shipper Information Success');
		redirect( WEB_ROOT . "/backend/logistics/edit.php?id={$id}");
	}
	Session::Set('error', 'Shipper information failed to modify');
	$partner = $_POST;
}

include template('logistics/manage_shipper_edit');
