<?php
//die($_SERVER['REQUEST_URI']);
require_once(dirname(__FILE__) . '/app.php');
header('Content-Type: application/rss+xml; charset=UTF-8');

$ename = strval($_GET['ename']);
if ($ename!='none') {
	$city = DB::LimitQuery('category', array(
		'condition' => array(
			'zone' => 'city',
			'ename' => $ename,
		),
		'one' => true,
	));
}
$team = current_team($city['id']);

$rss = new UniversalFeedCreator();
$rss->useCached();
$rss->title = "{$INI['system']['sitename']} : RSS";
$rss->description = "{$INI['system']['sitename']} giới thiệu";
$rss->link = "{$INI['system']['wwwprefix']}";
$rss->syndicationURL = $INI['system']['wwwprefix'] . '/' . $PHP_SELF;

$image = new FeedImage();
$image->title = $INI['system']['sitename'];
$image->url = "{$INI['system']['imgprefix']}/static/css/i/logo.png";
$image->link = "{$INI['system']['sitename']}";
$image->description = "Feed provided by " . $INI['system']['wwwprefix'];
$rss->image = $image;

if ( $team ) {
	$item = new FeedItem();
	$item->title = $team['title'];
	//$item->link = $INI['system']['wwwprefix'].'/team.php?id='.$team['id'];
	$item->link = $INI['system']['wwwprefix']."/".seo_url($team['short_title'],$team['id'],$url_suffix);
	
	$item->description = htmlspecialchars_decode($team['title'])  . "<br /><img src='".team_image($team['image'])."'/>" . htmlspecialchars_decode($team['systemreview']);
	$item->date = $team['create_time'];
	$item->source = $INI['system']['wwwprefix'];
	$item->author = $city['name'];
	$rss->addItem($item);
}

$rss->outputFeed("ATOM2.0");
?> 
