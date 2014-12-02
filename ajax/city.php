<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$city_id = abs(intval($_GET['city_id']));
$dist_id = abs(intval($_GET['dist_id']));
$ward_id = abs(intval($_GET['ward_id']));
if($city_id)
{
	die(optiondistrict(0,$city_id));
}

if($dist_id)
{
	die(optionward($ward_id,$dist_id));
}


//json('Order records do not exist', 'alert');
//$html = render('ajax_dialog_order');
//json($html, 'dialog');

