<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$id = abs(intval($_GET['id']));
if (!$id || !$team = Table::FetchForce('team', $id) ) {
	redirect( WEB_ROOT . '/team/index.php');
}

$city = Table::Fetch('category', $team['city_id']);
$subscribe = array(
		'email' => 'admin@wroupon.com',
		'secret' => md5($id),
		);
$partner = Table::Fetch('partner', $team['partner_id']);

$week = array('Sunday','Monday','Tuesday','Wednsday','Thursday','Friday','Saturday');
$today = date('Y year n month j date day') . $week[date('w')];
$vars = array(
		'today' => $today,
		'team' => $team,
		'city' => $city,
		'subscribe' => $subscribe,
		'partner' => $partner,
		'help_email' => $INI['subscribe']['helpemail'],
		'help_mobile' => $INI['subscribe']['helpphone'],
		'notice_email' => $INI['mail']['reply'],
		);

include template('mail_subscribe_team');
