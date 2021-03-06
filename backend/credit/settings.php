<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

if (is_post()){
	$action = strval($_POST['action']);

	if ( 'charge' == $action ) {
		$username = strval($_POST['username']);
		$credit = intval($_POST['credit']);
		if (is_numeric($username)) $u = Table::Fetch('user', $username);
		elseif (strpos($username, '@')) $u = Table::Fetch('user', $username, 'email');
		else $u = Table::Fetch('user', $username, 'username');
		if ($u && $credit) {
			ZCredit::Create($credit, $u['id'], 'charge', 0);
			redirect(null, 'user credti recharging succeede！');
		}
	}
	else if ( 'settings' == $action ) {
		$INI['credit']['register'] = abs(intval($_POST['credit']['register']));
		$INI['credit']['login'] = abs(intval($_POST['credit']['login']));
		$INI['credit']['invite'] = abs(intval($_POST['credit']['invite']));
		$INI['credit']['buy'] = abs(intval($_POST['credit']['buy']));
		$INI['credit']['pay'] = 0 + ($_POST['credit']['pay']);
		$INI['credit']['charge'] = 0 + ($_POST['credit']['charge']);
		$INI['credit']['aff'] = 0 + ($_POST['credit']['aff']);
		configure_save('credit');
		redirect(null, 'credit rules setting succeeded！');
	}
}

$INI['credit']['register'] = abs(intval($INI['credit']['register']));
$INI['credit']['login'] = abs(intval($INI['credit']['login']));
$INI['credit']['invite'] = abs(intval($INI['credit']['invite']));
$INI['credit']['buy'] = abs(intval($INI['credit']['buy']));
$INI['credit']['pay'] = 0 + ($INI['credit']['pay']);
$INI['credit']['charge'] = 0 + ($INI['credit']['charge']);
$INI['credit']['aff'] = 0 + ($INI['credit']['aff']);

include template('manage_credit_settings');
