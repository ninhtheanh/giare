<?php
require_once(dirname(__FILE__) . '/app.php');

$ct_id = strval($_GET['id']);

($currefer = strval($_GET['refer'])) || ($currefer = strval($_GET['r']));
if ($ct_id!='none' && $ct_id) {
	$city = id_city($ct_id);
	
	if ($city) { 
		
		cookie_city($city);
		redirect(WEB_ROOT ."/{$city['slug']}/"); //2010-06-27
		$currefer = udecode($currefer);
		if ($currefer) {
			redirect($currefer);
		} else if ( $_SERVER['HTTP_REFERER'] ) {
			if (!preg_match('#'.$_SERVER['HTTP_HOST'].'#', $_SERVER['HTTP_REFERER'])) {
				redirect( WEB_ROOT . "/{$city['slug']}/");
			}
			if (preg_match('#/city#', $_SERVER['HTTP_REFERER'])) {
				redirect(WEB_ROOT ."/{$city['slug']}/");
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
		redirect(WEB_ROOT ."/{$city['slug']}/");
	}
}

$cities = DB::LimitQuery('countries_state', array(
	'condition' => array( 'display' => 'Y') ,
));
$cities = Utility::AssColumn($cities, 'id', 'name');
include template('city');
