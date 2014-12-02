<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('admin');
//echo strtotime('2011-01-01 00:00:00');
$id = abs(intval($_GET['id']));
$user = Table::Fetch('user', $id);

if ( $_POST && $id==$_POST['id'] ) {
	$table = new Table('user', $_POST);
	$up_array = array(
			'username', 'realname', 
			'mobile', 'zipcode', 'address','city_id','dist_id','ward_id',
			'secret', 'enable', 'note_address'
			);
	$in_array = array( 'address', 'dist_id', 'ward_id'); 
	// unique email per user
	if (strpos($email, '@')) {
		$eu = Table::Fetch('user', $email, 'email');
		if ($eu && $eu['id'] != $id ) {
			Session::Set('notice', 'Email address already exists, can not be modified');
			redirect( WEB_ROOT . "/backend/user/index.php");
		}
	}
	$table->username = $enc->encrypt('@4!@#$%@', $_POST['username']);
	
	if ( $login_user_id == 1 && $id > 1 ) { $up_array[] = 'manager'; }
	if ( $id == 1 && $login_user_id > 1 ) {
		Session::Set('notice', 'You have no right to modify the information super administrator');
		redirect( WEB_ROOT . "/backend/user/index.php");
	}
	$table->manager = (strtoupper($table->manager)=='Y') ? 'Y' : 'N';
	if ($table->password ) {
		$table->password = ZUser::GenPassword($table->password);
		$up_array[] = 'password';
	}
	$flag = $table->update( $up_array );
	if ( $flag ) {
		$list = check_address_list($_POST['dist_id'], $_POST['ward_id'], $_POST['address']);
		if($list['id']>0){
			Table::UpdateCache('address_list', $list['id'], array(
				'address' => $_POST['address'],
				'dist_id' => $_POST['dist_id'],
				'ward_id' => $_POST['ward_id'],
			));
			$id_address_list = $list['id'];
		}else{
			DB::Insert('address_list',array(
				'address' => $_POST['address'],
				'dist_id' => $_POST['dist_id'],
				'ward_id' => $_POST['ward_id'],
			));
			$id_address_list  = mysql_insert_id();
		}
		Table::UpdateCache('user', $id, array(
			'id_address_list' => $id_address_list,
		));
		Session::Set('notice', 'Modify user information successfully');
		redirect( WEB_ROOT . "/backend/user/edit.php?id={$id}");
	}
	Session::Set('error', 'Failed to modify user information');
	$user = $_POST;
}

include template('manage_user_edit');
