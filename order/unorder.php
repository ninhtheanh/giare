<?php 
require_once(dirname(dirname(__FILE__)) . '/app.php');

$id = abs(intval($_GET['id']));

need_login();

$order = Table::Fetch('order', $id);
Table::UpdateCache('order', $id, array(
	'state' => 'customer_cancel',
	'admin_id'=>$login_user_id,
));
if($order['money']>0){
	Table::UpdateCache('user', $order['user_id'], array(
		'money' => $order['money'],
	));
}
save_order_history($order['id'],'customer_cancel');	

Session::Set('notice', "Cancel order No. ".$id." was successful");

redirect(WEB_ROOT  . "/order/index.php");

?>