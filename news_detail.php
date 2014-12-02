<?php
require_once(dirname(__FILE__) . '/app.php');

$id = $_GET['id'];
//DB::$mDebug=true;
$news = DB::GetQueryResult("Select * From news Where id = '$id' LIMIT 1", false);
$hotNews = $news[0];
$id_hot_news = $hotNews['id'];


$other_news = DB::GetQueryResult("Select * From news Where id <> '".$id_hot_news."' ORDER BY date_created DESC LIMIT 500", false);
//print_r($other_news);

//Right products.
$other_deal = DB::GetQueryResult("SELECT id, short_title, begin_time, now_number, team_price, market_price, image FROM `team` WHERE begin_time < UNIX_TIMESTAMP() AND end_time > UNIX_TIMESTAMP() ORDER BY begin_time DESC LIMIT 0,7",false);

include template('news_detail_view');