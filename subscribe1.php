<?php
require_once(dirname(__FILE__) . '/app.php');

$tip = strval($_GET['tip']);

if ( $_POST ) {
	$city_id = abs(intval($_POST['city_id']));
	if($city_id==0){
		$city_id = $city['id'];
	}
	ZSubscribe::Create($_POST['email'], $city_id);
	cookie_city( $city = Table::Fetch('category', $city_id));
	die(include template('subscribe_success'));
}

$pagetitle = 'Đăng ký nhận mail';//'Mail subscription';
include template('subscribe');
