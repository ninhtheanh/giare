<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

$action = strval($_GET['action']);
$id = abs(intval($_GET['id']));

if ( 'edit' == $action ) {
	if ($id) {
		$goods = Table::Fetch('goods', $id);
		if (!$goods) json('Does not have the data', 'alert');
	}
	$html = render('manage_ajax_dialog_goodsedit');
	json($html, 'dialog');
}
elseif ( 'remove' == $action ) {
	$goods = Table::Fetch('goods', $id);
	if (!$goods) json('Does not have the data', 'alert');
	Table::Delete('goods', $id);
	Session::Set('notice', 'The deletion of goods is successful');
	json(null, 'refresh');
}
elseif ( 'disable' == $action ) {
	$goods = Table::Fetch('goods', $id);
	if (!$goods) json('Does not have the data', 'alert');
	$enable = ($goods['enable'] == 'Y') ? 'N' : 'Y';
	$enablestring = ($goods['enable']=='Y') ? 'Disable' : 'Invocation';
	Table::UpdateCache('goods', $id, array(
		'enable' => $enable,
	));
	Session::Set('notice', "{$enablestring} The exchange of goods is successful");
	json(null, 'refresh');
}
