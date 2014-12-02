<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

if ( $_POST ) {
	$city_id = $_POST['city_id'];
	$users = DB::LimitQuery('user', array(
				'condition' => array(
					'city_id' => $city_id,
					'mobile > 0',
					),
				'select' => 'email, realname, mobile',
				));
	if ( $users ) {
		$kn = array(
				'email' => 'User Email',
				'realname' => 'Real Name',
				'mobile' => 'Phone Number',
				);
		$name = "mobile_".date('Ymd');
		$eusers = array();
		foreach($users as $one){
			$one['email'] = $enc->decrypt(ZUser::SECRET_KEY,$one['email']);
			$eusers[] = $one;
		}
		down_xls($eusers, $kn, $name);
	}
	die('-ERR ERR_NO_DATA');
}

include template('manage_market_downsms');
