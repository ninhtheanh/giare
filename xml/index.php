<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
include('class.xml.php');
$xml=new XML();
$daytime = strtotime(date('Y-m-d H:i:s'));
$condition = array(
	"end_time   >= '{$daytime}'",
	"begin_time <= '{$daytime}'",
);
$teams = DB::LimitQuery('team', array(
	'condition' => $condition,
	'order' =>' ORDER BY begin_time DESC, sort_order DESC, id DESC'
));
foreach($teams AS $index=>$team)
{
	$discount_price = $team['market_price'] - $team['team_price'];
	$discount_rate = round(100 - $team['team_price']/$team['market_price']*100);
	$url=$INI['system']['wwwprefix']."/".ThietKeTrangChu_SEO($city['name'])."/".ThietKeTrangChu_SEO($team['product'])."_".$team['id'].".html";
	$t=$team['end_time']-time();
	$data=array(
		'deal_id'=>$team['id'],
		'deal_title'=>$team['product'],
		'deal_review'=>strip_tags($team['summary']),
		'deal_total_buyers'=>$team['now_number'],
		'deal_category_id'=>$team['group_id'],
		'deal_images_cover_url'=>$INI['system']['wwwprefix']."/static/".$team['image'],
		'deal_url'=>$url,
		'deal_value_original'=>rtrim(rtrim(sprintf('%.1f',$team['market_price']), '0'), '.'),
		'deal_value_after_discount'=>rtrim(rtrim(sprintf('%.1f',$team['team_price']), '0'), '.'),
		'deal_value_discount'=>$discount_price,
		'deal_percent_discount'=>$discount_rate,
		'deal_time_left'=>$t,
		'deal_time_now'=>strtotime('now')
	);
	$xml->createBody($data);
}
$xml->createXml();
?>