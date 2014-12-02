<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_login();
if(isset($_POST['commit_dialog'])){
	$dob_user = checkdate((int)@$_POST['dob_m'],(int)@$_POST['dob_d'],(int)@$_POST['dob_y']) ? (int)@$_POST['dob_y']."-".(int)@$_POST['dob_m']."-".(int)@$_POST['dob_d']:"";
	$update_f_dialog = array('gender' => $_POST['gender'], 'dob' => $dob_user, 'update_time' => time(),);
	if(ZUser::Modify($login_user['id'], $update_f_dialog)) {
		Session::Set('notice', 'account updated succeeded');
		redirect(get_loginpage(WEB_ROOT . '/index.php'));
		exit();
	} else {
		Session::Set('error', 'account updated failed');
	}
}
if ($_POST ) {
	$dob = checkdate((int)@$_POST['dob_m'],(int)@$_POST['dob_d'],(int)@$_POST['dob_y']) ? (int)@$_POST['dob_y']."-".(int)@$_POST['dob_m']."-".(int)@$_POST['dob_d']:"";
	$update = array(
		'email' => $_POST['email'],
		'realname' => $_POST['realname'], 
		'zipcode' => $_POST['zipcode'],
		'mobile' => $_POST['mobile'], 
		'gender' => $_POST['gender'], 
		'dob' => $dob, 
		'update_time' => time(),
		'city_id' => abs(intval($_POST['city_id'])),
		'dist_id' => abs(intval($_POST['dist_id'])),
		'ward_id' => abs(intval($_POST['ward_id'])),
		'note_address' => $_POST['note_address'],
		'house_number' => $_POST['house_number'],
		'street_name' => $_POST['street_name'],
		'address' => $_POST['house_number']." ".$_POST['street_name'],
		'qq' => $_POST['qq'],
	);
	$avatar = upload_image('upload_image',$login_user['avatar'],'user');
//	echo 34343;
//	var_dump( $avatar);
	$update['avatar'] = $avatar;

	if ( $_POST['password'] == $_POST['password2']
			&& $_POST['password'] 
			&& strtolower(md5($email)) != 'f7e0dcf82fd5d444b11cb42db2a8da3e' ) 
	{
		$update['password'] = $_POST['password'];
	}

	if ( ZUser::Modify($login_user['id'], $update) ) {
		Session::Set('notice', 'account resetting succeeded');
		redirect( WEB_ROOT . '/account/settings.php ');
	} else {
		Session::Set('error', 'Thiết lập tài khoản thất bại');
	}
}
$readonly['email'] = defined('UC_API') ? '' : 'readonly';
$readonly['username'] = defined('UC_API') ? 'readonly' : '';

$pagetitle = 'Thiết lập tài khoản';
include template('account_settings');
