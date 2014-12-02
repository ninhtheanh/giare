<?php

require_once(dirname(__FILE__). '/include/application.php');
/* magic_quota_gpc */
$_GET = magic_gpc($_GET);
$_POST = magic_gpc($_POST);
$_COOKIE = magic_gpc($_COOKIE);

require_once(dirname(__FILE__).'/include/library/Crypt.php');
$enc = new Encryption;
/*sahadeal(so 2) ,CouponHot - CungMua - DiaDiemVang - IP Deal VIP - Hotdeal - */
// dealvip
$ip_arr = array('113.161.84.55','123.20.172.58','222.253.72.176','1.53.225.197','101.99.43.21','115.78.230.76','1.54.98.244','115.78.231.215','118.68.156.129','1.54.157.27','1.54.82.129','113.172.94.46','1.54.108.98','27.75.143.176','113.162.172.236','1.53.27.151','115.72.38.73');



if (!empty($_SERVER['HTTP_CLIENT_IP']))
  //check ip from share internet
  {
    $ip=$_SERVER['HTTP_CLIENT_IP'];
  }
  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
  //to check ip is pass from proxy
  {
    $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
  }
  else
  {
    $ip=$_SERVER['REMOTE_ADDR'];
  }
  

 if(in_array($ip, $ip_arr)){
	 header( 'Location: http://www.cheapdeal.vn/index.html' ) ;
	}
	

/* process currefer*/
$currefer = uencode(strval($_SERVER['REQUEST_URI']));

$pre = substr(md5($_SERVER['HTTP_HOST']),0,4);

/* session,cache,configure,webroot register */
Session::Init();
$INI = ZSystem::GetINI();

if( $_SERVER['REQUEST_URI']!='/' && $_COOKIE["{$pre}_city"]==11 && strpos($_SERVER['REQUEST_URI'],'city.php')===false)
{
	//return redirect('/');
}

/* end */
$arr_id_promotion = array(287,753);
$id_promotion = 753;
$begin_date_promotion = strtotime('2012-07-25 09:00:00');
$end_date_promotion = strtotime('2012-08-24 23:59:59');
/*CouponHot - CungMua - DiaDiemVang - IP Deal VIP - Hotdeal*/
$ip = Utility::GetRemoteIp();
//$ip_arr = array('1.53.225.197','101.99.43.21','115.78.230.76','113.161.84.55');
//van.do=35379,lam.nguyen=87332,tuong.lam=58094,khuong.lu=162385 restrict view orders from logistic
$restrict ="35379,87332,58094,162385";
$restrictarray =array(35379,87332,58094,162385,164675,31266);

/* biz logic */
$currency = $INI['system']['currency'];
$login_user_id = ZLogin::GetLoginId();

if($login_user_id){	
	$login_user = Table::Fetch('user', $login_user_id);	
	$login_user['email'] = $login_user['username'] = $enc->decrypt(ZUser::SECRET_KEY, $login_user['email']);
}

// cities
$hotcities = $j_hotcities = option_hotcategory('city', false, true);

$allcities = option_category('city', false, true);

//$city = cookie_city(null);
$ct=0;
//lay uri hien tai (deal-du-lich hoac deal-gan-day)
$cat_current = process_uri($_SERVER["REQUEST_URI"]);
$url_suffix = '.html';
//
//$alldist = option_district('VN', $city['id'], false, true);	

//$city = cookie_city(null,$ct);
$city_id = ($_GET['ct_id']) ? $_GET['ct_id'] : cookieget('city');

// tran anh edit
if($city_id == 0)
	$city_id = 11;
// end edit

$city = Table::Fetch('countries_state', $city_id);


// admin data ---------------------------------------------------------
if(strpos($_SERVER['REQUEST_URI'],'/backend/')!==false)
{
	$auths = $INI['authorization'][$login_user['id']];
	
	if(!in_array($login_user['id'], array(1,35379,58094,31265,162385,164675)))
  // if(!in_array($login_user['id'], array(1)))
	{
		if(in_array('order', $auths)){
			$city = Table::Fetch('countries_state', 11);
		}else{
			$city = Table::Fetch('countries_state', 556);
		}		
	}
	else
	{
		if($_GET['city_id']) $city = Table::Fetch('countries_state', $_GET['city_id']);
	}
	
	if(!$_GET['city_id']) $_GET['city_id'] = $city['id'];
	 
	$allshipper = option_shipper('A', $city['id'], false, true);
	$alladmins = option_admin('A', false, true);
	$allstatus = option_status('A', false, true);
	//$auths = $INI['authorization'][$login_user['id']];
	
}

/*Facebook*/
$facebook_domain = "http://www.facebook.com";
if($city['id']==11){
	$facebook_page = "http://www.facebook.com/dealsochcm";
}elseif($city['id']==12){
	$facebook_page = "http://www.facebook.com/dealsochanoi";
}

/* not allow access app.php */
if($_SERVER['SCRIPT_FILENAME']==__FILE__){
	redirect( WEB_ROOT . '/index.php');
}
/* end */
$AJAX = ('XMLHttpRequest' == @$_SERVER['HTTP_X_REQUESTED_WITH']);
if (false==$AJAX) { 
	header('Content-Type: text/html; charset=UTF-8'); 
	run_cron();
} else {
	header("Cache-Control: no-store, no-cache, must-revalidate");
}
//echo $_SERVER['REQUEST_URI'];