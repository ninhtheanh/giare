<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_login();

$action = strval($_GET['action']);
$id = $order_id = abs(intval($_GET['id']));
$charge = strval($_GET['id'])=='charge';
$id = $order_id = ( $charge ? 'charge' : $id );

if (!$order_id && !$charge ) {
	json('Order records do not exist', 'alert');
}

if ( $action == 'dialog' ) {
	$html = render('ajax_dialog_order');
	json($html, 'dialog');
}
elseif ( $action == 'cardcode') {
	$cid = strval($_GET['cid']);
	$order = Table::Fetch('order', $order_id);
	if ( !$order ) json('Order records do not exist', 'alert');
	$ret = ZCard::UseCard($order, $cid);
	if ( true === $ret ) {
		json(array(
					array('data' => "Successful use of vouchers", 'type'=>'alert'),
					array('data' => null, 'type'=>'refresh'),
				  ), 'mix');
	}
	$error = ZCard::Explain($ret);
	json($error, 'alert');
}
