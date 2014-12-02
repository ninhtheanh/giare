<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

//DB::$mDebug=true;
$request_uri = 'index';	
$now = time();
$mark = $now - ($now % 60);
$cid = ($city['id']) ? $city['id'] : 11; 
$condition_home = array( 
			'city_id' => array($cid, 0,556), 
			'team_type' => 'normal',
			"begin_time < $mark",
			"end_time > $mark",
			"(max_number>0 AND now_number < max_number) OR max_number=0",
			);

$ckey = 'hcount'.$cid;

	
//DB::$mDebug=true;	
$count = Table::Count('team', $condition_home);
//$count = caches($ckey,$cval);
$pre = substr(md5($_SERVER['HTTP_HOST']),0,4);
if( isset($_GET['ct_id']) && !$_COOKIE["{$pre}_city"] )
{	
	$ct_id = strval($_GET['ct_id']);
	
	//($currefer = strval($_GET['refer'])) || ($currefer = strval($_GET['r']));
	if ($ct_id) {
		$city = id_city($ct_id);
		if ($city){ 
			if(isset($_GET['s'])){
				$s = strval($_GET['s']);
				switch($s)
				{
					case 'nm' : $cname = "nhommua"; break;
					case 'cm' : $cname = "cungmua"; break;
					case 'mc' : $cname = "muachung"; break;
					case 'km' : $cname = "Khuyenmai"; break;
					case 'gr' : $cname = "giare"; break;
					case 'gg' : $cname = "giamgia"; break;
					case 'ds' : $cname = "deals"; break;
					default : $cname = "hotdeal"; break;
				}
			}
			$ct = 1;
			//$city = cookie_city($city,$ct);	
			cookieset('city', $city['id']);		
			return redirect( WEB_ROOT . '/' . $cname . '/');
			//return redirect( WEB_ROOT . '/');
		}
	}
}

$a = cookieget('city');
$r = $_SERVER['REQUEST_URI'];
if(preg_match("#/#", $r) && !preg_match("#/index.php#", $r) && cookieget('city')){
	$cname = ($a==11) ? 'tp-ho-chi-minh' : 'tinh-thanh';
	redirect( WEB_ROOT . '/'.$cname.'/');
	exit();
}

if($count>1){	
	if(isset($_GET['s'])){
		$s = strval($_GET['s']);
		switch($s)
		{
			case 'nm' : require_once(dirname(__FILE__) . '/nhommua.php'); break;
			case 'cm' : require_once(dirname(__FILE__) . '/cungmua.php'); break;
			case 'mc' : require_once(dirname(__FILE__) . '/muachung.php'); break;
			case 'km' : require_once(dirname(__FILE__) . '/khuyenmai.php'); break;
			case 'gr' : require_once(dirname(__FILE__) . '/giare.php'); break;
			case 'gg' : require_once(dirname(__FILE__) . '/giamgia.php'); break;
			case 'ds' : require_once(dirname(__FILE__) . '/deals.php'); break;
			default : require_once(dirname(__FILE__) . '/hotdeal.php'); break;
		}
	}
	
}else{	
	$team = current_team($cid);
	if ($team) {
		$_GET['id'] = abs(intval($team['id']));
		require_once( dirname(__FILE__) . '/team.php');
	}else{
		include template('subscribe');
	}
}