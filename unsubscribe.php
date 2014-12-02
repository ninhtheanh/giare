<?php
require_once(dirname(__FILE__) . '/app.php');

$code = strval($_GET['code']);
$subscribe = Table::Fetch('subscribe', $code, 'secret');
if ($subscribe) {
	ZSubscribe::Unsubscribe($subscribe);
	Session::Set('notice', 'Unsubscribe successful，You will not receive information on a daily buy');
}
redirect( WEB_ROOT  . '/subscribe.php');

