<?php
require_once(dirname(__FILE__) . '/app.php');

$home_side_ns = 60;//abs(intval($INI['system']['sideteam']));
$home_city_id = abs(intval($city['id']));
//6 deal ban nhieu nhat
//DB::$mDebug=true;
$sql = DB::LimitQuery('team', array('condition' => 'city_id IN ('.$home_city_id.', 0,556) AND begin_time < UNIX_TIMESTAMP() AND end_time > UNIX_TIMESTAMP() AND ((max_number>0 AND now_number < max_number) OR max_number=0) AND now_number>=200','order' => 'ORDER BY RAND(), sort_order DESC,id DESC'));

//$rand_keys = array_rand($sql, 3);

$team_ids = Utility::GetColumn($sql, 'id');
$ids = implode(",",$team_ids);



$pagetitle = 'Đặt hàng trên cheapdeal.vn';
include template('xac-nhan-chuyen-khoan');
