<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('team');

$masp = strval($_GET['ma_sp']);
$id = intval($_GET['id']);
if($id > 0)
{
	$condition = array("id != '$id'");
	$condition['masp'] = $masp;
	//$condition = array( 'pid='.$login_user['id'], 'credit >= 0', 'pay' => '0', 'buy_time > 0');
	
}
else
{
	$condition = array('masp' => $masp);
}
//DB::$mDebug=true;
$teams = DB::LimitQuery('team', array(
	'condition' => $condition,
));
$result = 0;
if(count($teams) > 0)
{
	$result = 1;
}
echo $result;
