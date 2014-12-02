<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

if ( $_POST ) {
	$phones = preg_split('/[\s,]+/', $_POST['phones'], -1, PREG_SPLIT_NO_EMPTY);
	$content = trim(strval($_POST['content']));
	$phone_count = count($phones);
	$phones = implode(',', $phones);
	$ret = sms_send($phones, $content);
	if ( $ret===true ) {
		Session::Set('notice', "Successfully send text messages, Number of Messages Sent：{$phone_count}");
		redirect( WEB_ROOT + '/backend/market/sms.php' );
	}
	Session::Set('notice', "Send SMS failed with error code：{$ret}");
}

include template('manage_market_sms');
