<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_login();
$id = abs(intval($_GET['id']));
$action = strval($_GET['action']);

if ( $action == 'exchange') {
	$goods = Table::Fetch('goods', $id);
	if ( $goods['consume'] >= $goods['number'] ) {
		json('no goods available for exchange', 'alert');
	}
	if ( $goods['score'] > $login_user['score'] ) {
		json('your credit isnt enough，exchange failed', 'alert');
	}
	if ( ZCredit::Create((0-$goods['score']), $login_user_id, 'exchange', $id) ) {

		Table::UpdateCache('goods', $id, array(
					'consume' => array( '`consume` + 1' ),
					));
		$v = "exchange[{$goods['title']}]succeeded，credit used{$goods['score']}";
		json( array(
					array( 'data' => $v, 'type' => 'alert'),
					array( 'data' => null,  'type' => 'refresh'),
				   ), 
				'mix');
	}
	json('exchange failed', 'alert');
}
