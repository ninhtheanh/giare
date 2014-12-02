<?php
/* import other */
import('configure');
import('current');
import('utility');
import('mailer');
import('sms');
import('upgrade');
import('uc');
import('cron');

function showColorSize($item)
{
	$str = "";
	if(isset($item['color']) && $item['color'] != "") 
		$str .= " Màu: " . '<span style="cursor:pointer;border:1px solid #999;width:10px; height:10px; display:inline-block;background:'.$item['color'].'"></span>';
		
    if(isset($item['size']) && $item['size'] != "") 
		$str .= " Size: " . $item['size'];
	return $str;
}
function convertVN_To_EN($str) {
// In thường
     $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
     $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
     $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
     $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
     $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
     $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
     $str = preg_replace("/(đ)/", 'd', $str);    
// In đậm
     $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
     $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
     $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
     $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
     $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
     $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
     $str = preg_replace("/(Đ)/", 'D', $str);
	 $str = str_replace(" – ", '-', $str);
	 //$str = str_replace(" ", '-', $str);
	 	 
	 $str = str_replace("-_-", '-', $str);
	 $str = str_replace("----", '-', $str);
	 $str = str_replace("---", '-', $str);
	 $str = str_replace("--", '-', $str);
	 
	 $str = str_replace(" ", '-', $str);
	 
	 $str = str_replace("-_-", '-', $str);
	 $str = str_replace("----", '-', $str);
	 $str = str_replace("---", '-', $str);
	 $str = str_replace("--", '-', $str);
	 
	 $str = strtolower($str);
     return $str; // Trả về chuỗi đã chuyển
} 
function getStaticPageGroupByID($pages, $page_id)
{
	$result = array();
	foreach($pages as $item)
	{
		if($item['id'] == $page_id)
			return $item;		
	}
	return $result;
}	
function getStaticPageGroup($pages, $page_type)
{
	$result = array();
	foreach($pages as $item)
	{
		if($item['page_type'] == $page_type)
			$result[] = $item;		
	}
	return $result;
}	
function processCategoryOption($categories)
{
	$result = array();
	foreach($categories as $item)
	{
		$result[] = $item;							
	}
	$categories_original = $result;
	$result = array();
	$categories = get_parent_cate_option($categories_original);
	foreach($categories_original as $item)
	{
		$result[] = array('id'=>$item['id'], 'name'=>$item['name']);
				
		$arrChild = get_children_cate_option($categories_original, $item['id']);		
		if(count($arrChild) > 0)
		{
			foreach($arrChild as $itemChild)
			{
				$result[] = array('id'=>$itemChild['id'], 'name'=>'&nbsp;&nbsp;&nbsp;'.$itemChild['name']);
			}
		}			
	}
	return $result;
}
function get_parent_cate_option($categories)
{
	$result = array();
	foreach($categories as $item)
	{
		if($item['parent'] == 0)
			$result[] = $item;		
	}
	return $result;
}
function get_children_cate_option($categories, $parent)
{
	$result = array();
	foreach($categories as $item)
	{	
		if($item['parent'] == $parent)
			$result[] = $item;		
	}
	return $result;
}
//[end]
function template($tFile) {
	global $INI;
	if ( 0===strpos($tFile, 'manage') ) {
		return __template($tFile);
	}
	if ($INI['skin']['template']) {
		$templatedir = DIR_TEMPLATE. '/' . $INI['skin']['template'];
		$checkfile = $templatedir . '/html_header.html';
		if ( file_exists($checkfile) ) {
			return __template($INI['skin']['template'].'/'.$tFile);
		}
	}	
	return __template($tFile);
}

function render($tFile, $vs=array()) {
    ob_start();
    foreach($GLOBALS AS $_k=>$_v) {
        ${$_k} = $_v;
    }
	foreach($vs AS $_k=>$_v) {
		${$_k} = $_v;
	}
	include template($tFile);
    return render_hook(ob_get_clean());
}

function render_hook($c) {
	global $INI;
	$c = preg_replace('#href="/#i', 'href="'.WEB_ROOT.'/', $c);
	$c = preg_replace('#src="/#i', 'src="'.WEB_ROOT.'/', $c);
	$c = preg_replace('#action="/#i', 'action="'.WEB_ROOT.'/', $c);

	/* theme */
	$page = strval($_SERVER['REQUEST_URI']);
	if($INI['skin']['theme'] && !preg_match('#/backend/#i',$page)) {
		$themedir = WWW_ROOT. '/static/theme/' . $INI['skin']['theme'];
		$checkfile = $themedir. '/css/index.css';
		if ( file_exists($checkfile) ) {
			$c = preg_replace('#/static/css/#', "/static/theme/{$INI['skin']['theme']}/css/", $c);
			$c = preg_replace('#/static/img/#', "/static/theme/{$INI['skin']['theme']}/img/", $c);
		}
	}
	if (strtolower(cookieget('locale','zh_cn'))=='zh_tw') {
		require_once(DIR_FUNCTION  . '/tradition.php');
		$c = str_replace(explode('|',$_charset_simple), explode('|',$_charset_tradition),$c);
	}
	/* encode id */
	$c = obscure_rep($c);
	return $c;
}

function output_hook($c) {
	global $INI;
	if ( 0==abs(intval($INI['system']['gzip'])))  die($c);
	$HTTP_ACCEPT_ENCODING = $_SERVER["HTTP_ACCEPT_ENCODING"]; 
	if( strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false ) 
		$encoding = 'x-gzip'; 
	else if( strpos($HTTP_ACCEPT_ENCODING,'gzip') !== false ) 
		$encoding = 'gzip'; 
	else $encoding == false;
	if (function_exists('gzencode')&&$encoding) {
		$c = gzencode($c);
		header("Content-Encoding: {$encoding}"); 
	}
	$length = strlen($c);
	header("Content-Length: {$length}");
	die($c);
}

$lang_properties = array();
function I($key) { 
    global $lang_properties, $LC;
    if (!$lang_properties) {
        $ini = DIR_ROOT . '/i18n/' . $LC. '/properties.ini';
        $lang_properties = Config::Instance($ini);
    }
    return isset($lang_properties[$key]) ?
        $lang_properties[$key] : $key;
}

function json($data, $type='eval') {
    $type = strtolower($type);
    $allow = array('eval','alert','updater','dialog','mix', 'refresh');
    if (false==in_array($type, $allow))
        return false;
    Output::Json(array( 'data' => $data, 'type' => $type,));
}

function redirect($url=null, $notice=null, $error=null) {
	$url = $url ? obscure_rep($url) : $_SERVER['HTTP_REFERER'];
	$url = $url ? $url : '/';
	if ($notice) Session::Set('notice', $notice);
	if ($error) Session::Set('error', $error);
    header("Location: {$url}");
    exit;
}
function write_php_file($array, $filename=null){
	$v = "<?php\r\n\$INI = ";
	$v .= var_export($array, true);
	$v .=";\r\n?>";
	return file_put_contents($filename, $v);
}

function write_ini_file($array, $filename=null){   
	$ok = null;   
	if ($filename) {
		$s =  ";;;;;;;;;;;;;;;;;;\r\n";
		$s .= ";; SYS_INIFILE\r\n";
		$s .= ";;;;;;;;;;;;;;;;;;\r\n";
	}
	foreach($array as $k=>$v) {   
		if(is_array($v))   { 
			if($k != $ok) {   
				$s  .=  "\r\n[{$k}]\r\n";
				$ok = $k;   
			} 
			$s .= write_ini_file($v);
		}else   {   
			if(trim($v) != $v || strstr($v,"["))
				$v = "\"{$v}\"";   
			$s .=  "$k = \"{$v}\"\r\n";
		} 
	}

	if(!$filename) return $s;   
	return file_put_contents($filename, $s);
}   

function save_config($type='ini') {
	return configure_save();
	global $INI; $q = ZSystem::GetSaveINI($INI);
	if ( strtoupper($type) == 'INI' ) {
		if (!is_writeable(SYS_INIFILE)) return false;
		return write_ini_file($q, SYS_INIFILE);
	} 
	if ( strtoupper($type) == 'PHP' ) {
		if (!is_writeable(SYS_PHPFILE)) return false;
		return write_php_file($q, SYS_PHPFILE);
	} 
	return false;
}

function save_system($ini) {
	$system = Table::Fetch('system', 1);
	$ini = ZSystem::GetUnsetINI($ini);
	$value = Utility::ExtraEncode($ini);
	$table = new Table('system', array('value'=>$value));
	if ( $system ) $table->SetPK('id', 1);
	return $table->update(array( 'value'));
}

/* user relative */
function need_login($wap=false) {
	if ( isset($_SESSION['user_id']) ) {
		if (is_post()) {
			unset($_SESSION['loginpage']);
			unset($_SESSION['loginpagepost']);
		}
		return $_SESSION['user_id'];
	}
	if ( is_get() ) {
		Session::Set('loginpage', $_SERVER['REQUEST_URI']);
	} else {
		Session::Set('loginpage', $_SERVER['HTTP_REFERER']);
		Session::Set('loginpagepost', json_encode($_POST));
	}
	if (true===$wap) {
		return redirect(WEB_ROOT . '/wap/login.php');	
	}
	return redirect(WEB_ROOT . '/account/loginup.php');	
}
function need_post() {
	return is_post() ? true : redirect(WEB_ROOT . '/index.php');
}
function need_manager($super=false) {
	if ( ! is_manager() ) {
		redirect( WEB_ROOT . '/backend/login.php' );
	}
	if ( ! $super ) return true;
	if ( abs(intval($_SESSION['user_id'])) == 1 ) return true;
	return redirect( WEB_ROOT . '/backend/misc/index.php');
}

function need_manager_cms($super=false) {
	if ( ! is_manager() ) {
		redirect( WEB_ROOT . '/cms/login.php' );
	}
	if ( ! $super ) return true;
	if ( abs(intval($_SESSION['user_id'])) == 1 || abs(intval($_SESSION['user_id'])) == 147) return true;
	return redirect( WEB_ROOT . '/cms/misc/index.php');
}

function need_partner() {
	return is_partner() ? true : redirect( WEB_ROOT . '/biz/login.php');
}

function need_open($b=true) {
	if (true===$b) {
		return true;
	}
	if ($AJAX) json('Discuss is not yet Open', 'alert');
	Session::Set('error', 'Discuss is Disabled! Please Contact admin');
	redirect( WEB_ROOT . '/index.php');
}

function need_auth($b=true) {
	global $AJAX, $INI, $login_user;
	if (is_string($b)) {		
		if($b=='order') $a = 'eorder';
		$auths = $INI['authorization'][$login_user['id']];
		$b = is_manager(true) || in_array($b, $auths) || in_array($a, $auths);
		//if($INI['authorization'][$login_user['id']]['order'])		
	}
	if (true===$b) {
		return true;
	}
	if ($AJAX) json('Authority to operate', 'alert');
	die(include template('manage_misc_noright'));
}

function is_manager($super=false, $weak=false) {
	global $login_user;
	if ( $weak===false && 
			( !$_SESSION['admin_id'] 
			  || $_SESSION['admin_id'] != $login_user['id']) ) {
		return false;
	}
	if ( ! $super ) return ($login_user['manager'] == 'Y');
	return $login_user['id'] == 1;
}
function is_partner() {
	return ($_SESSION['partner_id']>0);
}

function is_newbie(){ return (cookieget('newbie')!='N'); }
function is_get() { return ! is_post(); }
function is_post() {
	return strtoupper($_SERVER['REQUEST_METHOD']) == 'POST';
}

function is_login() {
	return isset($_SESSION['user_id']);
}

function get_loginpage($default=null) {
	$loginpage = Session::Get('loginpage', true);
	if ($loginpage)  return $loginpage;
	if ($default) return $default;
	return WEB_ROOT . '/index.php';
}

function cookie_city($city,&$ct) {
	/*
		global $hotcities;
		if($city) { 
			cookieset('city', $city['id']);
			return $city;
		} 
		$city_id = cookieget('city'); 
		$city = Table::Fetch('category', $city_id);
		if (!$city) $city = get_city();
		if (!$city) $city = array_shift($hotcities);
		if ($city) return cookie_city($city);
		return $city;
	*/
	global $hotcities;
	if($city){ 
		cookieset('city', $city['id']);
		return $city;
	} 
	$city_id = cookieget('city'); 
	$city = Table::Fetch('countries_state', $city_id);

	if (!$city){
		$ct=0;
		//$city = get_city();
	}else{	
		$ct=1;
    }
	if (!$city) $city = array_shift($hotcities);
	//if ($city) return cookie_city($city);
	return $city;
}
/*
function ename_city($ename=null) {
	return DB::LimitQuery('category', array(
		'condition' => array(
			'zone' => 'city',
			'ename' => $ename,
		),
		'one' => true,
	));
}
*/
//Thay doi truy van enam bang truy van id
function id_city($id=null) {
	return DB::LimitQuery('countries_state', array(
		'condition' => array(
			'id' => $id,
		),
		'one' => true,
	));
}
//
function ename_dist($dist_id=0) {

	return DB::LimitQuery('countries_district', array(
		'condition' => array(
			'country_code' => 'VN',
			'dist_id' => $dist_id,
		),
		'one' => true,
	));
}

function ename_shipper($shipper_id=0) {
	return DB::LimitQuery('shipper', array(
		'condition' => array(
			'shipper_status' => 'A',
			'id' => $shipper_id,
		),
		'one' => true,
	));
}

function cookieset($k, $v, $expire=0) {
	$pre = substr(md5($_SERVER['HTTP_HOST']),0,4);
	$k = "{$pre}_{$k}";
	if ($expire==0) {
		$expire = time() + 365 * 86400;
	} else {
		$expire += time();
	}
	setCookie($k, $v, $expire, '/');
}

function cookieget($k, $default='') {
	$pre = substr(md5($_SERVER['HTTP_HOST']),0,4);
	$k = "{$pre}_{$k}";
	return isset($_COOKIE[$k]) ? strval($_COOKIE[$k]) : $default;
}

function moneyit($k) {
	return rtrim(rtrim(sprintf('%.2f',$k), '0'), '.');
}

function debug($v, $e=false) {
	global $login_user_id;
	if ($login_user_id==100000) {
		echo "<pre>";
		var_dump( $v);
		if($e) exit;
	}
}

function getparam($index=0, $default=0) {
	if (is_numeric($default)) {
		$v = abs(intval($_GET['param'][$index]));
	} else $v = strval($_GET['param'][$index]);
	return $v ? $v : $default;
}
function getpage() {
	$c = abs(intval($_GET['page']));
	return $c ? $c : 1;
}
function pagestring($count, $pagesize, $wap=false) {
	$p = new Pager($count, $pagesize, 'page');
	if ($wap) {
		return array($pagesize, $p->offset, $p->genWap());
	}
	return array($pagesize, $p->offset, $p->genBasic());
}


function uencode($u) {
	return base64_encode(urlEncode($u));
}
function udecode($u) {
	return urlDecode(base64_decode($u));
}
function share_facebook($team) {
	global $login_user_id;
	global $INI,$url_suffix,$city;
	if ($team)  {
		$query = array(
				'u' => $INI['system']['wwwprefix']."/".$city['slug']."/".seo_url($team['short_title'],$team['id'],$url_suffix)/*."&r={$login_user_id}"*/,
				't' => $team['title'],
				);
	}
	else {
		$query = array(
				'u' => $INI['system']['wwwprefix']."/r.php?r={$login_user_id}",
				't' => $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
				);
	}

	$query = http_build_query($query);
	return 'http://www.facebook.com/sharer.php?'.$query;
}

/* twitter @Harry */
function share_twitter($team) {
	global $login_user_id;
	global $INI,$url_suffix,$city;
	if ($team)  {
		$query = array(
				'status' => $INI['system']['wwwprefix']."/".$city['slug']."/".seo_url($team['short_title'],$team['id'],$url_suffix)./*"&r={$login_user_id}".*/ ' ' . $team['title'],
				);
	}
	else {
		$query = array(
				'status' => $INI['system']['wwwprefix'] . "/r.php?r={$login_user_id}" . ' ' . $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
				);
	}

	$query = http_build_query($query);
	return 'http://twitter.com/?'.$query;
}

/* share link */
function share_renren($team) {
	global $login_user_id;
	global $INI;
	if ($team)  {
		$query = array(
				'link' => $INI['system']['wwwprefix'] . "/team.php?id={$team['id']}&r={$login_user_id}",
				'title' => $team['title'],
				);
	}
	else {
		$query = array(
				'link' => $INI['system']['wwwprefix'] . "/r.php?r={$login_user_id}",
				'title' => $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
				);
	}

	$query = http_build_query($query);
	return 'http://share.renren.com/share/buttonshare.do?'.$query;
}

function share_kaixin($team) {
	global $login_user_id;
	global $INI;
	if ($team)  {
		$query = array(
				'rurl' => $INI['system']['wwwprefix'] . "/team.php?id={$team['id']}&r={$login_user_id}",
				'rtitle' => $team['title'],
				'rcontent' => strip_tags($team['summary']),
				);
	}
	else {
		$query = array(
				'rurl' => $INI['system']['wwwprefix'] . "/r.php?r={$login_user_id}",
				'rtitle' => $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
				'rcontent' => $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
				);
	}
	$query = http_build_query($query);
	return 'http://www.kaixin001.com/repaste/share.php?'.$query;
}

function share_douban($team) {
	global $login_user_id;
	global $INI;
	if ($team)  {
		$query = array(
				'url' => $INI['system']['wwwprefix'] . "/team.php?id={$team['id']}&r={$login_user_id}",
				'title' => $team['title'],
				);
	}
	else {
		$query = array(
				'url' => $INI['system']['wwwprefix'] . "/r.php?r={$login_user_id}",
				'title' => $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
				);
	}
	$query = http_build_query($query);
	return 'http://www.douban.com/recommend/?'.$query;
}

function share_sina($team) {
	global $login_user_id;
	global $INI;
	if ($team)  {
		$query = array(
				'url' => $INI['system']['wwwprefix'] . "/team.php?id={$team['id']}&r={$login_user_id}",
				'title' => $team['title'],
				);
	}
	else {
		$query = array(
				'url' => $INI['system']['wwwprefix'] . "/r.php?r={$login_user_id}",
				'title' => $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
				);
	}
	$query = http_build_query($query);
	return 'http://v.t.sina.com.cn/share/share.php?'.$query;
}

function share_mail($team) {
	global $login_user_id;
	global $INI,$url_suffix,$city;
	if (!$team) {
		$team = array(
				'title' => $INI['system']['sitename'] . '(' . $INI['system']['wwwprefix'] . ')',
				);
	}
	$pre[] = "Tìm thấy một trang web tốt: {$INI['system']['sitename']} - Mỗi ngày là một dealn mới! ";
	if ( $team['id'] ) {
		$pre[] = "Deal hôm nay :{$team['title']}";
		$pre[] = "Tôi nghĩ rằng bạn sẽ quan tâm: ";
		$pre[] = $INI['system']['wwwprefix']."/".$city['slug']."/".seo_url($team['short_title'],$team['id'],$url_suffix)/*."&r={$login_user_id}"*/;
		//$pre = mb_convert_encoding(join("\n\n", $pre), 'GBK', 'UTF-8');
		$pre = join("\n\n", $pre);
		$sub = "Bạn đang quan tâm đến: {$team['title']}";
	} else {
		$sub = $pre[] = $team['title'];
	}
	//$sub = mb_convert_encoding($sub, 'GBK', 'UTF-8');
	//$query = array( 'subject' => $sub, 'body' => $pre, );
	//$query = http_build_query($query);
	return 'mailto:?subject='.$sub.'&body='.$pre;
}

function domainit($url) {
	if(strpos($url,'//')) { preg_match('#[//]([^/]+)#', $url, $m);
} else { preg_match('#[//]?([^/]+)#', $url, $m); }
return $m[1];
}

// that the recursive feature on mkdir() is broken with PHP 5.0.4 for
function RecursiveMkdir($path) {
	if (!file_exists($path)) {
		RecursiveMkdir(dirname($path));
		@mkdir($path, 0777);
	}
}

function upload_image($input, $image=null, $type='team', $scale=false) {
	$year = date('Y'); $day = date('md'); $n = time().rand(1000,9999).'.jpg';
	$z = $_FILES[$input];
	//echo "type: $type";
	if ($z && strpos($z['type'], 'image')===0 && $z['error']==0) {
		// create dir
		if (!$image && $type !=' banner') { 
			RecursiveMkdir( IMG_ROOT . '/' . "{$type}/{$year}/{$day}" );
			$image = "{$type}/{$year}/{$day}/{$n}";
			$path = IMG_ROOT . '/' . $image;
		} else {
			RecursiveMkdir( dirname(IMG_ROOT .'/' .$image) );
			$path = IMG_ROOT . '/' .$image;
		}
		
		// process image
		if ($type=='user') {
			Image::Convert($z['tmp_name'], $path, 48, 48, Image::MODE_CUT);
		} 
		else if($type=='team') {
			move_uploaded_file($z['tmp_name'], $path);
			$npath = preg_replace('#(\d+)\.(\w+)$#', "\\1_index.\\2", $path); 
			$lpath = preg_replace('#(\d+)\.(\w+)$#', "\\1_Lindex.\\2", $path); 
			//remove old files
			@unlink($npath);
			@unlink($lpath);			
			Image::Convert($path, $npath, 240, 348, Image::MODE_CUT);
			Image::Convert($path, $lpath, 500, 380, Image::MODE_CUT);
			
		}
		else if($type=='banner') {	
			$image = "{$type}/" . basename($_FILES[$input]['name']);;
			$path = IMG_ROOT . '/' . $image;
			//echo $path;
			move_uploaded_file($z['tmp_name'], $path);		
			$image = "/static/" . $image;	
		}
		
		if($type=='team' && $scale) {			
			$npath = preg_replace('#(\d+)\.(\w+)$#', "\\1_index.\\2", $path); 
			$lpath = preg_replace('#(\d+)\.(\w+)$#', "\\1_Lindex.\\2", $path); 
			//remove old files
			@unlink($npath);
			@unlink($lpath);			
			Image::Convert($path, $npath, 240, 348, Image::MODE_CUT);
			Image::Convert($path, $lpath, 500, 380, Image::MODE_CUT);
		}
		return $image;
	} 
	return $image;
}
function upload_image_news($input, $type, $id, $image=null, $scale=false) {	
	$z = $_FILES[$input];
	//echo "type: $type $id";
	if ($z && strpos($z['type'], 'image')===0 && $z['error']==0) {
		// create dir		
		$uploadDir = IMG_ROOT . "/$type/" . "{$id}";
		RecursiveMkdir( $uploadDir );
		$image = $id . ".jpg";
		$path = $uploadDir . "/" . $image;
		$image = "/static/$type/$id/" . $image;
		//echo "<br>path:$path";
		
		// process image
		move_uploaded_file($z['tmp_name'], $path);
		$npath = preg_replace('#(\d+)\.(\w+)$#', "\\1_thumb.\\2", $path); 
		$lpath = preg_replace('#(\d+)\.(\w+)$#', "\\1_large.\\2", $path); 
		//remove old files
		@unlink($npath);
		@unlink($lpath);		
		Image::Convert($path, $npath, 200, 160, Image::MODE_CUT);
		Image::Convert($path, $lpath, 370, 275, Image::MODE_CUT);
		//echo $path;
		return $image;
	} 
	return "";
}
function user_image($image=null) {
	global $INI;
	if (!$image) { 
		//return $INI['system']['imgprefix'] . '/static/img/user-no-avatar.gif';
		return $INI['system']['imgprefix'] . '/static/avatar/' . rand(1,24) . '.jpg';
	}
	return $INI['system']['imgprefix'] . '/static/' .$image;
}

function team_image($image=null, $index=false, $width=240, $height=0) {//$width=225
	global $INI;
	if (!$image) return null;
	if ($index) {
		$path = WWW_ROOT . '/static/' . $image;
		if($width>240){//if($width>=225){
			$image = preg_replace('#(\d+)\.(\w+)$#', "\\1_Lindex.\\2", $image); 
		}else{
			$image = preg_replace('#(\d+)\.(\w+)$#', "\\1_index.\\2", $image); 
		}
		
		$dest = WWW_ROOT . '/static/' . $image;
		if (!file_exists($dest) && file_exists($path) ) {
			Image::Convert($path, $dest, $width, $height, Image::MODE_SCALE);
		}
	}
	return $INI['system']['imgprefix'] . '/static/' .$image;
}

function banner_image($image=null, $index=false, $width=240, $height=0) {//$width=225
	global $INI;
	if (!$image) return null;
	if ($index) {
		$path = WWW_ROOT . '/static/' . $image;
		if($width>240){//if($width>=225){
			$image = preg_replace('#(\d+)\.(\w+)$#', "\\1_Lindex.\\2", $image); 
		}else{
			$image = preg_replace('#(\d+)\.(\w+)$#', "\\1_index.\\2", $image); 
		}
		
		$dest = WWW_ROOT . '/static/' . $image;
		if (!file_exists($dest) && file_exists($path) ) {
			Image::Convert($path, $dest, $width, $height, Image::MODE_SCALE);
		}
	}
	return $INI['system']['imgprefix'] . '/static/' .$image;
}

function userreview($content) {
	$line = preg_split("/[\n\r]+/", $content, -1, PREG_SPLIT_NO_EMPTY);
	$r = '<ul>';
	foreach($line AS $one) {
		$c = explode('|', htmlspecialchars($one));
		$c[2] = $c[2] ? $c[2] : '/';
		$r .= "<li>{$c[0]}<span>－－<a href=\"{$c[2]}\" target=\"_blank\">{$c[1]}</a>";
		$r .= ($c[3] ? "（{$c[3]}）":'') . "</span></li>\n";
	}
	return $r.'</ul>';
}

function invite_state($invite) {
	if ('Y' == $invite['pay']) return 'Rebate paid';
	if ('C' == $invite['pay']) return 'Unapproved';
	if ('N' == $invite['pay'] && $invite['buy_time']) return 'Rebate to be paid';
	if (time()-$invite['create_time']>7*86400) return 'Expired';
	return 'Not bought';
}

function team_state(&$team) {
	if ( $team['now_number'] >= $team['min_number'] ) {
		if ($team['max_number']>0 || ($team['end_time'] <= time() && $team['now_number']>1000)) {
			if ( $team['now_number']>=$team['max_number']  || ($team['end_time'] <= time() && $team['now_number']>1000)){
				if ($team['close_time']==0) {
					$team['close_time'] = $team['end_time'];
				}
				return $team['state'] = 'soldout';
			}
		}
		if ( $team['end_time'] <= time() ) {
			$team['close_time'] = $team['end_time'];
		}
		if($team['end_time'] < time()){
			return $team['state'] = 'expired';
		}
		return $team['state'] = 'success';
	}else{
		if ( $team['end_time'] <= time() ) {
			$team['close_time'] = $team['end_time'];
			return $team['state'] = 'failure';
		}
	}
	return $team['state'] = 'none';
}

function current_team($city_id=0) {
	$today = strtotime(date('Y-m-d H:i:s'));
	$cond = array(
			'city_id' => array(0, abs(intval($city_id))),
			'team_type' => 'normal',
			"begin_time <= {$today}",
			"end_time > {$today}",
			);
	$order = 'ORDER BY sort_order DESC, begin_time DESC, id DESC';

	/* normal team */
	$team = DB::LimitQuery('team', array(
				'condition' => $cond,
				'one' => true,
				'order' => $order,
				));
	if ($team) return $team;

	/* seconds team */
	$cond['team_type'] = 'seconds';
	unset($cond['begin_time']);	
	$order = 'ORDER BY sort_order DESC, begin_time ASC, id DESC';
	$team = DB::LimitQuery('team', array(
				'condition' => $cond,
				'one' => true,
				'order' => $order,
				));

	return $team;
}

function state_explain($team, $error='false') {
	$state = team_state($team);
	$state = strtolower($state);
	switch($state) {
		case 'none': return 'Ongoing';
		case 'soldout': return 'Sold out';
		case 'failure': if($error) return 'Deal failed';
		case 'success': return 'Deal secceeded';
		default: return 'Ended';
	}
}

function get_zones($zone=null) {
	$zones = array(
			'city' => 'City',
			/*'district' => 'District',*/
			'group' => 'Deal Category',
			'public' => 'Forum Category',
			'grade' => 'User Grade',
			'express' => 'Express',
			'partner' => 'Biz Category',
			);
	if ( !$zone ) return $zones;
	if (!in_array($zone, array_keys($zones))) {
		$zone = 'city';
	}
	return array($zone, $zones[$zone]);
}

function down_xls($data, $keynames, $name='dataxls') {
	$xls[] = "<html><meta http-equiv=content-type content=\"text/html; charset=UTF-8\"><body><table border='1'>";
	$xls[] = "<tr><td>ID</td><td>" . implode("</td><td>", array_values($keynames)) . '</td></tr>';
	foreach($data As $o) {
		$line = array(++$index);
		foreach($keynames AS $k=>$v) {
			$line[] = $o[$k];
		}
		$xls[] = '<tr><td>'. implode("</td><td>", $line) . '</td></tr>';
	}
	$xls[] = '</table></body></html>';
	$xls = join("\r\n", $xls);
	header('Content-Disposition: attachment; filename="'.$name.'.xls"');
	die(mb_convert_encoding($xls,'UTF-8','UTF-8'));
}

function option_hotcategory($zone='city', $force=false, $all=false) {
	$cates = option_category($zone, $force, true);
	$r = array();
	foreach($cates as $id=>$one) {
		if ('Y'==strtoupper($one['display'])) $r[$id] = $one;
	}
	return $all ? $r: Utility::OptionArray($r, 'id', 'name');	
}

function option_category($zone='city', $force=false, $all=false) {
	$cache = $force ? 0 : 86400*30;
	$cates = DB::LimitQuery('countries_state', array(
		//'condition' => array('display' => 'Y',),
		'order' => 'ORDER BY position ASC, name',
		'cache' => $cache,
	));
	$cates = Utility::AssColumn($cates, 'id');
	
	return $all ? $cates : Utility::OptionArray($cates, 'id', 'name');
}
function optiondistrict($dist_id=0,$city_id=11) {
	/*$cache = $force ? 0 : 86400*30;
	
	if($city_id>0){
		$condition	= array('active' => 'Y','id' => $city_id);
	}else{
		$condition	= array('active' => 'Y');	
	}
	$dist = DB::LimitQuery('district', array(
		'condition' => $condition,
		'order' => 'ORDER BY dist_name ASC',
		'cache' => $cache,
	));
	$option = "";
	foreach( $dist as $key=>$value ){
		if (is_array($value)) { 
			$key = strval($value['dist_id']);
			$val = strval($value['dist_name']); 
			$state = strval($value['id']);
		}
		$selected = ($dist_id==$key) ? 'selected' : null;
		$option .= "<option value='{$key}' {$selected} class='{$state}'>".strip_tags($val)."</option>";
	}
	return $option;*/
	
	$cache = $force ? 0 : 86400*30;
	
	if($city_id>0){
		$condition	= array('status' => 'A','state_id' => $city_id);
	}else{
		$condition	= array('status' => 'A');	
	}
	$dist = DB::LimitQuery('countries_district', array(
		'condition' => $condition,
		'order' => 'ORDER BY dist_name ASC',
		'cache' => $cache,
	));
	$option = "";
	foreach( $dist as $key=>$value ){
		if (is_array($value)) { 
			$key = strval($value['dist_id']);
			$val = strval($value['dist_name']); 
			$state = strval($value['state_id']);
		}
		$selected = ($dist_id==$key) ? 'selected' : null;
		$option .= "<option value='{$key}' {$selected} class='{$state}'>".strip_tags($val)."</option>";
	}
	return $option;
}
function optionward($id=0,$dist_id=0) {
	$cache = $force ? 0 : 86400*30;
	/*$ward = DB::LimitQuery('ward', array(
		//'condition' => array( 'id' => $city_id,),
		'condition' => array('active' => 'Y'),
		'order' => 'ORDER BY ward_name ASC',
		'cache' => $cache,
	));
	$optionward = "";
	foreach( $ward as $key=>$value ){
		if (is_array($value)) { 
			$key = strval($value['id']);
			$val = strval($value['ward_name']); 
			$dist = strval($value['dist_id']);
		}
		$selected = ($id==$key) ? 'selected' : null;
		$optionward .= "<option value='{$key}' {$selected} class='{$dist}'  title='{$val}'>".strip_tags($val)."</option>";
	}
	return $optionward;*/
	
	if($dist_id>0){
		$condition	= array('active' => 'Y','dist_id' => $dist_id);
	}else{
		$condition	= array('active' => 'Y');	
	}
	
	$ward = DB::LimitQuery('countries_ward', array(
		'condition' => $condition,
		'order' => 'ORDER BY ward_name ASC',
		'cache' => $cache,
	));
	$optionward = "";
	foreach( $ward as $key=>$value ){
		if (is_array($value)) { 
			$key = strval($value['id']);
			$val = strval($value['ward_name']); 
			$dist = strval($value['dist_id']);
		}
		$selected = ($id==$key) ? 'selected' : null;
		$optionward .= "<option value='{$key}' {$selected} class='{$dist}'  title='{$val}'>".strip_tags($val)."</option>";
	}
	return $optionward;
	
}
function option_district($country_code='VN', $city_id=11, $force=false, $all=false) {
	$cache = $force ? 0 : 86400*30;	
	//DB::$mDebug=true;
	$dist = DB::LimitQuery('countries_district', array(
		'condition' => array( 'country_code' => $country_code, 'state_id' => $city_id, 'status' => 'A', ),
		'order' => 'ORDER BY dist_name ASC',
		'cache' => $cache,
	));
	
	$dist = Utility::AssColumn($dist, 'dist_id');
	return $all ? $dist : Utility::OptionArray($dist, 'dist_id', 'dist_name');
}
function distname($id,$dist_id){
	$dist = DB::GetQueryResult("SELECT dist_id, dist_name FROM countries_district WHERE dist_id='".$dist_id."' AND state_id='".$id."'");	
	return $dist;
}
function wardname($dist_id,$ward_id){
	$ward = DB::GetQueryResult("SELECT id, ward_name FROM countries_ward WHERE dist_id='".$dist_id."' AND id='".$ward_id."'");	
	return $ward;
}

function ward_name($dist_id,$ward_id){
	$wards = DB::GetQueryResult("SELECT id, ward_name FROM countries_ward WHERE dist_id='".$dist_id."' AND id='".$ward_id."'");	
	return $wards;
}

function check_address_list($dist_id=0,$ward_id=0, $address=''){
	$check = DB::GetQueryResult("SELECT id FROM address_list WHERE dist_id='".$dist_id."' AND ward_id='".$ward_id."' AND address='".$address."'");	
	return $check;
}
function check_street($street_name=''){
	$street = DB::GetQueryResult("SELECT id FROM street WHERE street_name='".$street_name."'");	
	return $street;
}

function option_shipper($status='A', $city_id=11, $force=false, $all=false) {
	$cache = $force ? 0 : 86400*30;
	$shipper = DB::LimitQuery('shipper', array(
		'condition' => array( 'shipper_status' => $status, 'city_id' => $city_id,),
		'order' => 'ORDER BY shipper_name ASC',
		'cache' => $cache,
	));
	$shipper = Utility::AssColumn($shipper, 'id');
	return $all ? $shipper : Utility::OptionArray($shipper, 'id', 'shipper_name');	
}

function option_shipper_approved($status='A', $city_id=11, $force=false, $all=false) {
	$cache = $force ? 0 : 86400*30;
	$shipper = DB::LimitQuery('shipper', array(
		'condition' => array( 'shipper_status' => $status, 'city_id' => $city_id,),
		'order' => 'ORDER BY shipper_name ASC',
		'cache' => $cache,
	));
	$shipper = Utility::AssColumn($shipper, 'id');
	return $all ? $shipper : Utility::OptionArray($shipper, 'id', 'shipper_name');
}

function option_admin($status='A', $force=false, $all=false) {
	$cache = $force ? 0 : 86400*30;
	$admins = DB::LimitQuery('user', array(
		'condition' => array( 'manager' => 'Y','enable' => 'Y'),
		'order' => 'ORDER BY username ASC',
		'cache' => $cache,
	));
	$admins = Utility::AssColumn($admins, 'id');
	return $all ? $admins : Utility::OptionArray($admins, 'id', 'email');
}

function option_status($status='A', $force=false, $all=false) {
	$cache = $force ? 0 : 86400*30;
	$rs = DB::LimitQuery('order_status', array(
		//'condition' => array( 'manager' => 'Y','enable' => 'Y'),
		'order' => 'ORDER BY name ASC',
		'cache' => $cache,
	));
	$rs = Utility::AssColumn($rs, 'id');
	return $all ? $rs : Utility::OptionArray($rs, 'id', 'name');
}

function option_delivered_time($v = 0, $shipper_id){
	$cache = $force ? 0 : 86400*30;
	$select = "distinct delivery_time";
	$delivered_time = DB::LimitQuery('order', array(
		'select'	=> $select,
		'condition' => array( 'delivery_time > 0','shipper_id'=>$shipper_id,),
		'order' => 'ORDER BY delivery_time DESC',
		'cache' => $cache,
	));
	foreach($delivered_time as $key=>$value )
	{
		if (is_array($value)) { 
			$key = strval($value['delivery_time']);
			$value = date("d-m-Y H:i:s",$value['delivery_time']); 
		}
		$selected = $key==$v ? 'selected' : null;
		$option .= "<option value='{$key}' {$selected}>".strip_tags($value)."</option>";
	}
	return $option;
}



function option_dist($v=null, $city_id=0, $team_id=0, $is_home=0, $cbday=0, $ceday=0){
	$cache = $force ? 0 : 86400*30;
	$select = "dist_id, city_id, count(*) as num";
	echo $cbtime = strtotime($cbday." 00:00:00");
	$cetime = strtotime($ceday." 23:59:59");
	if(!empty($team_id) && $is_home>0 & $cbday>0 & $ceday>0){
		$condition = array("state IN ('confirmed', 'pending')", "service NOT IN ('cashoffice')", 'city_id' => $city_id, 'is_home' => 'yes', "team_id IN ($team_id)", "create_time BETWEEN {$cbtime} AND {$cetime}");	
	}elseif(!empty($team_id) & $cbday>0 & $ceday>0){
		$condition = array("state IN ('confirmed', 'pending')", "service NOT IN ('cashoffice')", 'city_id' => $city_id, "team_id IN ($team_id)", "create_time BETWEEN {$cbtime} AND {$cetime}");	
	}elseif(!empty($team_id)){
		$condition = array("state IN ('confirmed', 'pending')", "service NOT IN ('cashoffice')", 'city_id' => $city_id, "team_id IN ($team_id)");	
	}elseif($is_home>0 & $cbday>0 & $ceday>0){
		$condition = array("state IN ('confirmed', 'pending')", "service NOT IN ('cashoffice')", 'city_id' => $city_id, 'is_home' => 'yes', "create_time BETWEEN {$cbtime} AND {$cetime}");	
	}elseif($cbday>0 & $ceday>0){
		$condition = array("state IN ('confirmed', 'pending')", "service NOT IN ('cashoffice')", 'city_id' => $city_id, "create_time BETWEEN {$cbtime} AND {$cetime}");	
	}elseif($is_home>0){
		$condition = array("state IN ('confirmed', 'pending')", "service NOT IN ('cashoffice')", 'city_id' => $city_id, 'is_home' => 'yes');	
	}else{
		$condition = array("state IN ('confirmed', 'pending')", "service NOT IN ('cashoffice')", 'city_id' => $city_id);
	}
	$teams = DB::LimitQuery('team', array('condition' => "`status`='Y'"));
	$t_id = Utility::GetColumn($teams, 'id');
	$condition['team_id'] = $t_id;
	//DB::$mDebug=true;
	$dist = DB::LimitQuery('order', array(
		'select'	=> $select,
		'condition' => $condition,
		'order' => 'GROUP BY dist_id ORDER BY dist_id ASC',
		'cache' => $cache,
	));
	
	foreach($dist as $key=>$value){
		if (is_array($value)){
			$key = strval($value['dist_id']);
			if(in_array($key,$v)){
				$selected = 'selected';
			}else{
				$selected = null;
			}
			if($value['dist_id']!=''){
				$val = distname($value['city_id'],$value['dist_id']);
				$option .= "<option value='{$key}' {$selected}>".strip_tags($val['dist_name']). ' (' .$value['num']. ")</option>";
			}
		}
		
		
	}
	return $option;
}

function option_ward($v=array(), $dist_id=array(), $city_id=0, $team_id=0, $is_home=0){
	$cache = $force ? 0 : 86400*30;
	$list_dist_id = implode(",",$dist_id);
	$select = "ward_id, dist_id, city_id, count(*) as num";
	if(!empty($team_id) && $is_home>0){
		$condition = array("state IN ('confirmed', 'pending')",'dist_id IN ('.$list_dist_id.')', 'service' => 'cashdelivery', 'city_id' => $city_id, 'is_home' => 'yes', 'ward_id>0', "team_id IN ($team_id)");	
	}elseif(!empty($team_id)){
		$condition = array("state IN ('confirmed', 'pending')",'dist_id IN ('.$list_dist_id.')', 'service' => 'cashdelivery', 'city_id' => $city_id, 'ward_id>0', "team_id IN ($team_id)");	
	}elseif(!empty($is_home)){
		$condition = array("state IN ('confirmed', 'pending')",'dist_id IN ('.$list_dist_id.')', 'service' => 'cashdelivery', 'city_id' => $city_id, 'is_home' => 'yes', 'ward_id>0');	
	}else{
		$condition = array("state IN ('confirmed', 'pending')",'dist_id IN ('.$list_dist_id.')', 'service' => 'cashdelivery', 'city_id' => $city_id, 'ward_id>0');
	}
	$teams = DB::LimitQuery('team', array('condition' => "`status`='Y'"));
	$t_id = Utility::GetColumn($teams, 'id');
	$condition['team_id'] = $t_id;
	
	$ward = DB::LimitQuery('order', array(
		'select'	=> $select,
		'condition' => $condition,
		'order' => 'GROUP BY ward_id ORDER BY ward_id ASC',
		'cache' => $cache,
	));
	foreach($ward as $key=>$value){
		if (is_array($value)){
			$key = strval($value['ward_id']);
			if(in_array($key,$v)){
				$selected = 'selected';
			}else{
				$selected = null;
			}
			if($value['ward_id']!=''){
				$val = distname($value['city_id'],$value['dist_id']);
				$valu = wardname($value['dist_id'],$value['ward_id']);
				$option .= "<option value='{$key}' {$selected}>".strip_tags($valu['ward_name']).' - '.strip_tags($val['dist_name']). ' (' .$value['num']. ")</option>";
			}
		}
		
		
	}
	return $option;
}

function option_ward_1($dist_id=0, $ward_id=0){
	$cache = $force ? 0 : 86400*30;
	$select = "*";
	if(($dist_id>0 && $ward_id==0) || ($dist_id>0 && $ward_id>0)){
		$condition = array('dist_id' => $dist_id, 'active' => 'Y');
	}else{
		$condition = array('dist_id' => $dist_id, 'id' => $ward_id, 'active' => 'Y');
	}
	$ward = DB::LimitQuery('ward', array(
		'select'	=> $select,
		'condition' => $condition,
		'order' => 'ORDER BY ward_name ASC',
		'cache' => $cache,
	));
	foreach($ward as $key=>$value){
		if (is_array($value)){
			$key = strval($value['id']);
			if($key==$ward_id){
				$selected = 'selected';
			}else{
				$selected = null;
			}
			if($value['id']!=''){
				$valu = wardname($value['dist_id'],$value['id']);
				$option .= "<option value='{$key}' {$selected}>".strip_tags($valu['ward_name']). "</option>";
			}
		}
	}

	return $option;
}



function option_street($v=array(), $dist_id=0, $ward_id=0, $team_id=0, $is_home=0){
	$cache = $force ? 0 : 86400*30;
	$select = "street_name, count(*) as num";
	if(($ward_id>0 || !empty($ward_id)) && ($team_id>0 || !empty($team_id)) && ($is_home>0 || !empty($is_home))){
		$condition = array("state IN ('confirmed', 'pending')", 'service' => 'cashdelivery', 'dist_id' => $dist_id, 'ward_id' => $ward_id, 'team_id' => $team_id, 'is_home' => 'yes');
	}elseif(($ward_id>0 || !empty($ward_id)) && ($team_id>0 || !empty($team_id))){
		$condition = array("state IN ('confirmed', 'pending')", 'service' => 'cashdelivery', 'dist_id' => $dist_id, 'ward_id' => $ward_id, 'team_id' => $team_id);
	}elseif(($ward_id>0 || !empty($ward_id)) && ($is_home>0 || !empty($is_home))){
		$condition = array("state IN ('confirmed', 'pending')", 'service' => 'cashdelivery', 'dist_id' => $dist_id, 'ward_id' => $ward_id, 'is_home' => 'yes');
	}elseif(($team_id>0 || !empty($team_id)) && ($is_home>0 || !empty($is_home))){
		$condition = array("state IN ('confirmed', 'pending')", 'service' => 'cashdelivery', 'dist_id' => $dist_id, 'team_id' => $team_id, 'is_home' => 'yes');
	}elseif($ward_id>0 || !empty($ward_id)){
		$condition = array("state IN ('confirmed', 'pending')", 'service' => 'cashdelivery', 'dist_id' => $dist_id, 'ward_id' => $ward_id);
	}elseif($team_id>0 || !empty($team_id)){
		$condition = array("state IN ('confirmed', 'pending')", 'service' => 'cashdelivery', 'dist_id' => $dist_id, 'team_id' => $team_id);
	}elseif($is_home>0 || !empty($is_home)){
		$condition = array("state IN ('confirmed', 'pending')", 'service' => 'cashdelivery', 'dist_id' => $dist_id, 'is_home' => 'yes');
	}else{
		$condition = array("state IN ('confirmed', 'pending')", 'service' => 'cashdelivery', 'dist_id' => $dist_id);
	}	
	$ateams = activeDeals();
	$condition['team_id'] = $ateams;
	$street = DB::LimitQuery('order', array(
		'select'	=> $select,
		'condition' => $condition,
		'order' => 'GROUP BY street_name ORDER BY street_name ASC',
		'cache' => $cache,
	));
	foreach($street as $key=>$value){
		if (is_array($value)){
			$key = strval($value['street_name']);
			if(in_array($key,$v)){
				$selected = 'selected';
			}else{
				$selected = null;
			}
			if($value['street_name']!=''){
				$val = strval($value['street_name']);
				$option .= "<option value='{$key}' {$selected}>".strip_tags($val). ' (' .$value['num']. ")</option>";
			}
		}
	}
	return $option;
}

function option_yes($n, $default=false) {
	global $INI;
	if (false==isset($INI['option'][$n])) return $default;
	$flag = trim(strval($INI['option'][$n]));
	return abs(intval($flag)) || strtoupper($flag) == 'Y';
}

function option_yesv($n, $default='N') {
	return option_yes($n, $default=='Y') ? 'Y' : 'N';
}
function magic_gpc($string) {
	if(SYS_MAGICGPC) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = magic_gpc($val);
			}
		} else {
			$string = stripslashes($string);
		}
	}
	return $string;
}
function total_order_user($user_id){
	$condition = array(
		'user_id' => $user_id,
		'team_id > 0',
		'team_id <> 39',
		'state' => 'pay',
	);
	$total_order_user = Table::Count('order', $condition);
	return $total_order_user;
}
function team_discount($team, $save=false) {
	if ($team['market_price']<0 || $team['team_price']<0 ) {
		return '?';
	}
	//return moneyit((10*$team['team_price']/$team['market_price']));
	return ceil(moneyit(100*($team['market_price'] - $team['team_price'])/$team['market_price']));
}

function team_origin($team, $quantity=0) {
	$team['team_price'];
	$origin = $quantity * $team['team_price'];
	if ($team['delivery'] == 'express'
			&& ($team['farefree']==0 || $quantity < $team['farefree'])
		) {
			$origin += $team['fare'];
		}
	return $origin;
}

function error_handler($errno, $errstr, $errfile, $errline) {
	switch ($errno) {
		case E_PARSE:
		case E_ERROR:
			echo "<b>Fatal ERROR</b> [$errno] $errstr<br />\n";
			echo "Fatal error on line $errline in file $errfile";
			echo "PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
			exit(1);
			break;
		default: break;
	}
	return true;
}
/* for obscureid */
function obscure_rep($u) {
	if(!option_yes('encodeid')) return $u;
	if(preg_match('#/backend/#', $_SERVER['REQUEST_URI'])) return $u;
	return preg_replace_callback('#(\?|&)id=(\d+)(\b)#i', obscure_cb, $u);
}
function obscure_did() {
	$gid = strval($_GET['id']);
	if ($gid && strpos($gid, 'WR')===0) {
		$_GET['id'] = base64_decode(substr($gid,2))>>2;
	}
}
function obscure_cb($m) {
	$eid = obscure_eid($m[2]);
	return "{$m[1]}id={$eid}{$m[3]}";
}
function obscure_eid($id) {
	return 'WR'.base64_encode($id<<2);
}
obscure_did();
/* end */

/* for post trim */
function trimarray($o) {
	if (!is_array($o)) return trim($o);
	foreach($o AS $k=>$v) { $o[$k] = trimarray($v); }
	return $o;
}
$_POST = trimarray($_POST);
/* end */

/*Format Price*/
function print_price($price){
	return number_format($price,0,"",".");
}	
/*End*/

/*Cut String*/
function cut_string($str,$len,$more){
	if ($str=="" || $str==NULL) return $str;
	if (is_array($str)) return $str;
	$str = trim($str);
	if (strlen($str) <= $len) return $str;
	$str = substr($str,0,$len);
	if ($str != "") {
		if (!substr_count($str," ")) {
			if ($more) $str .= " ...";
			return $str;
		}
		while(strlen($str) && ($str[strlen($str)-1] != " ")) {
			$str = substr($str,0,-1);
		}
		$str = substr($str,0,-1);
		if ($more) $str .= " ...";
	}
	return $str;
} 
/*Begin logging functions----------------------------------------------------------------------------------------------------*/
function save_log($act,$obj,$id=0) {	
	global $login_user;
	$rs = array(
		'time' => date('Y-m-d H:i:s',time()),
		'user_name' => $login_user['username'],
		'action' => $act,
		'object' => $obj,
		'object_id' => $id,
		'ip' => $_SERVER['REMOTE_ADDR'],		
	);
	//var_dump($rs);exit;
	return DB::Insert('alog', $rs);	
}

function save_ship_log($out_id,$in_id=0,$act=NULL,$state=NULL,$note=NULL) {
	global $login_user;	
	if(is_null($out_id)) return;
	$rs = array(
			'date' => date('Y-m-d H:i:s',time()),
			'user' => $login_user['username'],
			'out_id' => $out_id,
			'in_id' => $in_id,			
			'act' => $act,		
			'state' => $state,		
			'note' => $note				
		);
			
	return DB::Insert('ship_log', $rs);	
}

/*End logging functions----------------------------------------------------------------------------------------------------*/
/*Begin order functions----------------------------------------------------------------------------------------------------*/
function save_order_history($id,$state,$asign_to=NULL,$note=NULL) {
	global $login_user;	
	if(is_null($id) || is_null($state)) return;
	$arr = DB::GetQueryResult("SELECT period FROM order_status WHERE code='".$state."'");
	$status_expires = $arr['period'];	
	$now = time();
	$expires = ($status_expires>0) ? date('Y-m-d H:i:s',$now + $status_expires * 3600) : NULL;
	$rs = array(
		'order_id' => $id,
		'status_code' =>  $state,	
		'date' => date('Y-m-d H:i:s',$now),		
		'expires' => $expires,
		'assign_to' => $asign_to,			
		'note' => $note,	
		'user' => $login_user['username'],
	);
	return DB::Insert('order_history', $rs);	
}

function getStatusColor($status_code)
{
	$rs = DB::GetQueryResult("SELECT color FROM order_status WHERE code='".$status_code."'");	
	return $rs['color'];
}

function getStatusName($status_code)
{
	$rs = DB::GetQueryResult("SELECT name FROM order_status WHERE code='".$status_code."'");	
	return $rs['name'];
}
function getMobileShipper($shipper_name)
{
	$rs = DB::GetQueryResult("SELECT shipper_tel FROM shipper WHERE shipper_name='".$shipper_name."'");	
	return $rs['shipper_tel'];
}

function make_keyword($string,$keepcase=false)
{
	if ($string == '')	return '';	
	//--Start processing ---/
	$arr_search  = array(
							"á","à","ả","ã","ạ"   ,"â","ấ","ầ","ẩ","ậ","ẫ"   ,"ă","ắ","ằ","ẵ","ặ","ẳ"
						   ,"Á","À","Ả","Ã","Ạ"   ,"Â","Ấ","Ầ","Ẩ","Ậ","Ẫ"   ,"Ă","Ắ","Ằ","Ẵ","Ặ","Ẳ"   
						   ,"é","è","ẻ","ẽ","ẹ"   ,"ê","ế","ề","ể","ệ","ễ"	
						   ,"É","È","Ẻ","Ẽ","Ẹ"   ,"Ê","Ế","Ề","Ể","Ệ","Ễ"   
						   ,"ó","ò","ỏ","õ","ọ"   ,"ơ","ớ","ờ","ở","ỡ"   ,"ợ","ô","ố","ồ","ổ","ỗ","ộ"  
						   ,"Ó","Ò","Ỏ","Õ","Ọ"   ,"Ơ","Ớ","Ờ","Ở","Ỡ"   ,"Ợ","Ô","Ố","Ồ","Ổ","Ỗ","Ộ"   
						   ,"ú","ù","ủ","ũ","ụ"   ,"ư","ứ","ừ","ử","ữ","ự"
						   ,"Ú","Ù","Ủ","Ũ","Ụ"   ,"Ư","Ứ","Ừ","Ử","Ữ","Ự"
						   ,"í","ì","ỉ","ĩ","ị"   ,"ý","ỳ","ỷ","ỹ","ỵ"
						   ,"Í","Ì","Ỉ","Ĩ","Ị"   ,"Ý","Ỳ","Ỷ","Ỹ","Ỵ"
						   ,"đ","Đ"									  
						);

	$arr_replace = array(
							"a","a","a","a","a"   ,"a","a","a","a","a","a"   ,"a","a","a","a","a","a" 
						   ,"A","A","A","A","A"   ,"A","A","A","A","A","A"   ,"A","A","A","A","A","A" 
						   ,"e","e","e","e","e"   ,"e","e","e","e","e","e" 
						   ,"E","E","E","E","E"   ,"E","E","E","E","E","E"  
						   ,"o","o","o","o","o"   ,"o","o","o","o","o"   ,"o","o","o","o","o","o","o"  
						   ,"O","O","O","O","O"   ,"O","O","O","O","O"   ,"O","O","O","O","O","O","O"  
						   ,"u","u","u","u","u"   ,"u","u","u","u","u","u"
						   ,"U","U","U","U","U"   ,"U","U","U","U","U","U"
						   ,"i","i","i","i","i"   ,"y","y","y","y","y"
						   ,"I","I","I","I","I"   ,"Y","Y","Y","Y","Y"
						   ,"d","D"
						);	

	$string = trim($string);
	$string = str_replace($arr_search, $arr_replace, $string);	
	$string = preg_replace("/%/i","-phan-tram",$string);
	//$string = preg_replace("/[^a-z0-9\\040]/i","",$string);
	//$string = preg_replace("/([ ]{1,9})/", '-', $string);	
	$string = preg_replace('/\s+/', '-', $string);
	$string = str_replace(',', '', $string);
	if($keepcase==false){
		$string = strtolower(trim($string));
	}
	return $string;

}
/*Show Dialog*/
	function showDialog($msg="",$tit="",$url=""){
		$dialog = "<div id=\"boxes\"><div id=\"dialogs\" class=\"window\"><table width=\"100%\"><tr bgcolor=\"#cccccc\"><td align=\"left\" style=\"padding:5px\"><b>".$tit."</b></td><td align=\"right\" style=\"padding:5px\"><a href=\"#\" class=\"close\"/><b>Đóng</b></a></td></tr><tr><td colspan=2 style=\"padding:10px; padding-top:15px\">".$msg."</td></tr></table></div><div id=\"mask\"></div></div><script type=\"text/javascript\">
		jQuery(document).ready(function() {
			var id = $('#dialogs');
			var maskHeight = $(document).height();
			var maskWidth = $(window).width();
			$('#mask').css({'width':maskWidth,'height':maskHeight});
			$('#mask').fadeIn(600);	
			$('#mask').fadeTo('normal',0.5);	
			var winH = $(window).height();
			var winW = $(window).width();
			$(id).css('top',  winH/2-$(id).height()/2);
			$(id).css('left', winW/2-$(id).width()/2);
			$(id).fadeIn(500); 
			$('.window .close').click(function (e) {
				e.preventDefault();
				$('#mask').hide();
				$('.window').hide();
			});		
			$('#mask').click(function () {
				$(this).hide();
				$('.window').hide();
				/*window.location = '".$url."';*/
			});
		});</script>";
		return $dialog;
	}
/*End*/
/*End order functions----------------------------------------------------------------------------------------------------*/
function caches($key,$val='NULL')
{	
	global $m;		
	switch(CACHER)
	{
		case 'X' :				
			$ret = xcache_get($key);					
			if(sizeof($ret)>0 && $ret!='NULL') 
				return $ret;			
			if(sizeof($val)>0 && $val!='NULL')
			{
				xcache_set($key,$val,TTL);
				return xcache_get($key);
			}
		break;
		
		case 'M' :
			$ret = $m->get($key);
			if(sizeof($ret)>0 && $ret!='NULL') 
				return $ret;
			if(sizeof($val)>0 && $val!='NULL')
			{
				$m->set($key,$val,0,TTL);//*60*24*4	
				return $m->get($key);
			}		
		break;
		
		default :			
			return $val;
		break;	
	}
}

//set_error_handler('error_handler');

function process_uri($uri)
{
    $uri = str_replace("/", " ", $uri);
    $uri = trim($uri);
    $uri = explode(" ", $uri);
    return $uri[1];
}

function get_id_from_gid($gid)
{
    $gid = explode("_", $gid);
    //remove .html
    return $gid = str_replace('.html', '', end($gid));
}

function seo_url($str,$id,$url_suffix, $separate_char = "-") {
	$url = make_keyword($str) . $separate_char . $id . $url_suffix;
    return strtolower(trim($url));
}

function ShippingCondition($condition_value=""){
	$ship = DB::LimitQuery('shipping_condition', array(
		'order' => 'ORDER BY condition_name ASC',
		'cache' => $cache,
	));
	foreach($ship as $key=>$value){
		if (is_array($value)){
			if($value['condition_value']==$condition_value){
				$selected = 'selected';
			}else{
				$selected = null;
			}
			$option .= "<option value=\"{$value['condition_value']}\" {$selected}>".strip_tags($value['condition_name']). "</option>";
		}
	}
	return $option;
}
function LoadCountry($curr_lang="VN"){
	$country = DB::LimitQuery('countries', array(
		'order' => 'ORDER BY country_name ASC',
		'cache' => $cache,
	));
	foreach($country as $key=>$value){
		if (is_array($value)){
			if($curr_lang==$value['country_code']){
				$selected = 'selected';
			}else{
				$selected = null;
			}
			$option .= "<option value=\"{$value['country_code']}\" {$selected}>".strip_tags($value['country_name']). "</option>";
		}
	}
	return $option;
}
function LoadState($stateid=0,$country_code='VN'){
	$country = DB::LimitQuery('countries_state', array(
		'order' => 'ORDER BY position ASC,name ASC',
		'cache' => $cache,
	));
	foreach($country as $key=>$value){
		if (is_array($value)){
			if($stateid==$value['id']){
				$selected = 'selected';
			}else{
				$selected = null;
			}
			$option .= "<option value=\"{$value['id']}\" {$selected}>".strip_tags($value['name']). "</option>";
		}
	}
	return $option;
}
function LoadDist($distid=0,$stateid=0,$country_code='VN'){
	if($stateid>0){
		$condition = array('state_id' => $stateid, 'country_code' => $country_code);
	}
	
	
	$country = DB::LimitQuery('countries_district', array(
		'order' => 'ORDER BY dist_name ASC',
		'condition' => $condition,
		'cache' => $cache,
	));
	foreach($country as $key=>$value){
		if (is_array($value)){
			if($distid==$value['dist_id']){
				$selected = 'selected';
			}else{
				$selected = null;
			}
			$option .= "<option value=\"{$value['dist_id']}\" {$selected}>".strip_tags($value['dist_name']). "</option>";
		}
	}
	return $option;
}
function add_input($str,$add_br=false,$len=0){
	if($add_br) $str = nl2br($str);
	if($len>0) $str=substr($str,0,$len);		
	if(!@get_magic_quotes_gpc()) $str=addslashes($str);
	$str=htmlspecialchars($str);		
	return $str;
}

function strip_input($str,$strip_br=false){	
	$str=html_entity_decode($str);
	$str=stripslashes($str);		
	if($strip_br){
		$pat = array("/<br \/>/","/&amp;gt;&lt;br \/&gt;/","/&lt;br \/&gt;/","/\%/");
		$rep = array("","","");
		$str=preg_replace($pat,$rep,$str);
	}
	return $str;
}
function LoadDestination($destination_id=0){
	if($destination_id==0){
		$sql = "SELECT * FROM destination ORDER BY destination_name ASC";
	}else{
		$sql = "SELECT * FROM destination WHERE destination_id={$destination_id} ORDER BY destination_name ASC";
	}
	$ds = DB::GetQueryResult($sql,false);
	$str = "";
	foreach($ds as $key => $value){
		if($destination_id==$key){
			$selected = "selected";
		}else{
			$selected = "";
		}
		$str.="<option value=\"{$value['destination_id']}\" {$selected}>{$value['destination_name']}</option>";
	}
	return $str;
}
function CheckCityDeal($city_id=556){
	if($city_id!=11){
		return true;
	}else{
		return false;
	}
}
//Function Shopping Cart
function GetDestID($city_id=0, $dist_id=0){
	$result = array();	
	//echo "SELECT d.destination_id, dd.type, d.destination_name FROM destination as d, destination_detail dd WHERE d.destination_id = dd.destination_id AND d.status='A' AND ((value='$city_id' AND type='S') OR (value='$dist_id' AND type='D')) GROUP BY destination_id ORDER BY type DESC"."<br>"; 
	$db = DB::GetQueryResult("SELECT d.destination_id, dd.type, d.destination_name FROM destination as d, destination_detail dd
		WHERE d.destination_id = dd.destination_id AND d.status='A' AND ((value='$city_id' AND type='S') OR (value='$dist_id' AND type='D') OR (value='$dist_id' AND type='T'))			
		GROUP BY destination_id ORDER BY type DESC");
	if(is_array($db)){
		$result[0] = $db["destination_id"];
		$result[1] = @$db["type"];
		$result[2] = @$db["destination_name"];
	}
	return $result;
}
function PaymentMethod($user_id, $order_id){
	global $login_user;
	$q1 = "SELECT city_id, dist_id, ward_id, total_weight, origin, payment_id, shipping_id, shipping_cost FROM `order` WHERE user_id='".$user_id."' AND id=".$order_id;
	$order = DB::GetQueryResult($q1);
	
	$dest = GetDestID($order['city_id'],$order['dist_id']);
	//var_dump($dest);exit();
	$ds = DB::GetQueryResult("SELECT DISTINCT state_id FROM payment_cost", false);
	foreach($ds as $k => $v){
		$cod .= $v['state_id'].",";	
	}
	$accept_cod = explode(",", rtrim ($cod, ","));
	if((int)@$dest[0]==0){
		$whereand = " ";
	}else{
		$subtotal = $order['origin']+$order['shipping_cost'];
		if($login_user['money'] > $subtotal){
			$whereand = " AND payment_id = 6 AND destination LIKE('%".(int)@$dest[0]."%')";
		}/*elseif(in_array($order['ward_id'], $accept_cod)){
			$whereand = " AND payment_id NOT IN (6,1) AND destination LIKE('%".(int)@$dest[0]."%')";	
		}*/else{
			$whereand = " AND payment_id <> 6 AND destination LIKE('%".(int)@$dest[0]."%')";	
		}
	}
	
	//echo "SELECT payment_id, adding_cost, adding_type, payment, description FROM payment_descriptions WHERE status='A' {$whereand} ORDER BY position";
	/*if($login_user['money'] > $order['origin']){
		$list ="<tr><td align=\"right\" valign=\"top\"><input type=\"radio\" name=\"methods[payment]\" id=\"payment\" value='6-0' checked='checked' /></td><td align=\"left\" valign=\"top\" class=\"text_bold\" style=\"padding-left:3px\">Thanh toán qua số dư tài khoản</td></tr>";
	}else*/{

		$q2 = DB::GetQueryResult("SELECT payment_id, adding_cost, adding_type, payment, description FROM payment_descriptions WHERE status='A' {$whereand} ORDER BY position", false);

		if($order['city_id']=11 && in_array($order['ward_id'], array(313,316))){
			$q2 = DB::GetQueryResult("SELECT payment_id, adding_cost, adding_type, payment, description FROM payment_descriptions WHERE status='A' AND payment_id <> 6 AND destination LIKE('%1%') ORDER BY position", false);
		}
		
		//echo "SELECT payment_id, adding_cost, adding_type, payment, description FROM payment_descriptions WHERE status='A'". $whereand. " ORDER BY position";


		// default payment
		if(empty($q2)){
			$ids = '3,5';		
			$q2 = DB::GetQueryResult("SELECT payment_id, adding_cost, adding_type, payment, description FROM payment_descriptions WHERE status='A' AND payment_id <> 6 and payment_id in ($ids) ORDER BY position", false);
		}
		if(($dest[0]!=1 && !in_array($order['ward_id'],array(313,316))) || ($dest[0]==1 && in_array($order['ward_id'],array(125,126)))  || ($dest[0]!=1 && in_array($order['ward_id'],$accept_cod))){
			$q3 = DB::GetQueryResult("SELECT state_id, adding_type, adding_cost FROM payment_cost WHERE state_id=".$order['city_id']." AND subtotal_to<=".$order['origin']." AND subtotal_from>=".$order['origin']);
			if(!empty($q3)){
				if($q3['adding_type']=='Money'){
					$adding = $q3['adding_cost'];
				}else{
					$adding = $order['origin']*$q3['adding_cost']/100;
				}
			}
			
		}else{
			$adding = 0;	
		}
		
		
		if($order['city_id']!=11 && in_array($order['ward_id'], $accept_cod)){
			if($order['payment_id']==1){
				$checked = " checked='checked' ";
			}else{
				$checked = "";
			}
			$list ="<tr><td align=\"right\" valign=\"top\"><input type=\"radio\" name=\"methods[payment]\" id=\"payment\" value=\"1-{$adding}\" {$checked} /></td><td align=\"left\" valign=\"top\" class=\"text_bold\" style=\"padding-left:3px\">Thanh toán bằng tiền mặt</td></tr><tr><td></td><td align=\"left\" valign=\"top\" style=\"color:#000000; padding-left:10px;padding-bottom:10px;\">Nhân viên sẽ giao hàng và thu tiền trực tiếp. ĐT hỗ trợ: 08 7302 4401<br><span style=\"color:#c40000\">Đối với các khách hàng ở các Tỉnh, Quận, Huyện ngoại thành Thành Phố Hồ Chí Minh <b style=\"color:#060\">(Q.9, Bình Chánh, Cần Giờ, Củ Chi, Hóc Môn, Nhà Bè, P.15 và P.16 của Q.8, Thủ Đức trừ hai phường Hiệp Bình Chánh và Linh Đông)</b> sẽ cộng thêm phí thanh toán</span></td></tr>";
		}else{
			$list ="";
		}	
		
		
		
		if(!empty($q2)){
			foreach($q2 as $key => $value){
				$payment_checked = "";
				$payment_id = $value['payment_id'];
				/*if($value['adding_type']=="Percent") {
					$adding = $order['origin']*$value['adding_cost']/100;
				}else{ 
					$adding = $value['adding_cost'];
				}*/
				if ($payment_id == $order['payment_id'] || $payment_id==6){
					$payment_checked = " checked='checked' ";
				}
				if($payment_id==1){
					$payment_cost = $adding;
				}else{
					$payment_cost = 0;	
				}
				$payment_name = strip_input($value['payment']);
				$payment_description = strip_input($value['description']);
				$list .="<tr><td align=\"right\" valign=\"top\"><input type=\"radio\" name=\"methods[payment]\" id=\"payment\" value='".$payment_id."-".$payment_cost."' {$payment_checked} /></td><td align=\"left\" valign=\"top\" class=\"text_bold\" style=\"padding-left:3px\">".$payment_name."</td></tr><tr><td></td><td align=\"left\" valign=\"top\" style=\"color:#000000; padding-left:10px;padding-bottom:10px;\">".$payment_description."</td></tr>";
			}
		}
	}
	
	return $list;
}

function GetShippingCost($shipping_id, $destination_id, $subtotal, $total_weight){	
	if($subtotal==0) $subtotal = 1;
	if($total_weight==0) $total_weight = 1;
	if ($shipping_id>0 && $destination_id>0){
		$shipping_cost=0;
		$sql = "SELECT rate_type, rate_value, total_weight_to, total_weight_from, subtotal FROM shipping_rates WHERE shipping_id=".$shipping_id." AND destination_id=".$destination_id." ORDER BY rate_value ASC";
		$shipping_cost = 0;
		$ds = DB::GetQueryResult($sql, false);
		if(is_array($ds)){
			foreach($ds as $key => $value){
				$amount = $value["subtotal"];
				$total_weight_from = $value["total_weight_from"];
				$total_weight_to = $value["total_weight_to"];
				if($amount<=0 && $shipping_id>3){
					if($total_weight>=$total_weight_from && $total_weight<=$total_weight_to){
						if($value["rate_type"]=="Money"){
							$shipping_cost = $value["rate_value"];
						}else{
							$shipping_cost = $subtotal*($value["rate_value"])/100;
						}
					}
				}else{
					if($shipping_id == 1){
						if($subtotal>=$amount){
							$shipping_cost = 0;
						}else{
							if($value["rate_type"]=="Money"){
								$shipping_cost = $value["rate_value"];
							}else{
								$shipping_cost = $subtotal*($value["rate_value"])/100;
							}
						}
					}elseif($shipping_id == 2){
						$amount = 10000000;
						if($subtotal>=$amount){
							$shipping_cost = 0;
						}else{
							if($total_weight>=$total_weight_from && $total_weight<=$total_weight_to){
								if($value["rate_type"]=="Money"){
									$shipping_cost = $value["rate_value"];
								}else{
									$shipping_cost = $subtotal*($value["rate_value"])/100;
								}
							}
						}
					}
				}
			}
		}
	}
	return $shipping_cost;		
}

function ShippingMethod($user_id, $order_id){
	//Show Shipping Method
	$q1 = "SELECT bcity_id, bdist_id, bward_id,  total_weight, origin, payment_id, shipping_id FROM `order` WHERE user_id='".$user_id."' AND id=".$order_id;

	$order = DB::GetQueryResult($q1);

	$dests = GetDestID($order['bcity_id'],$order['bdist_id']);
	if(in_array( $order['bward_id'], array(125,126))){
		$andwhere = " AND destination_id IN (5)";	
	}else{
		$andwhere = "AND destination_id IN (".(int)@$dests[0].")";
	}
	if(in_array($order['bward_id'],array(313,316))){
	$query = "SELECT s.shipping_id, s.shipping_name, s.delivery_time, sr.destination_id FROM shippings as s, shipping_rates as sr WHERE s.shipping_id = sr.shipping_id AND s.status='A' AND destination_id IN (0) GROUP BY s.shipping_id ORDER BY s.position";
	
	}
	$query = "SELECT s.shipping_id, s.shipping_name, s.delivery_time, sr.destination_id FROM shippings as s, shipping_rates as sr WHERE s.shipping_id = sr.shipping_id AND s.status='A' {$andwhere} GROUP BY s.shipping_id ORDER BY s.position";
	$q3 = DB::GetQueryResult($query, false);
	$shipping_cost = 0;
	if(in_array($order['bward_id'],array(313,316))){
		if($order['shipping_id']==1){
			$checked = " checked='checked' ";
		}else{
			$checked = "";
		}
		$list1 ="<tr><td align=\"right\" valign=\"top\"><input type=\"radio\" name=\"methods[shipping]\" id=\"shipping\" value=\"1-0\" {$checked}/></td><td align=\"left\" valign=\"top\" class=\"text_bold\" style=\"padding-left:3px\">Giao hàng tận nơi trong nội thành (Hồ Chí Minh)</td></tr><tr><td></td><td align=\"left\" valign=\"top\" style=\"color:#000000; padding-left:10px;padding-bottom:10px;\">Từ 3 - 5 ngày làm việc</td></tr>";
	}else{
		$list1 = "";
	}
	if(is_array($q3) && !in_array($order['bward_id'],array(313,316)) ){
		foreach($q3 as $key => $value){
			$shipping_checked = "";
			$shipping_id = $value['shipping_id'];
			$shipping_name = $value['shipping_name'];
			$delivery_time = $value['delivery_time'];
			$destination_id = $value['destination_id'];
			$shipping_cost = GetShippingCost($shipping_id, $destination_id, $order['origin'], $order['total_weight']);
			if ($shipping_id == $order['shipping_id']){
				$shipping_checked = " checked='checked' ";	
			}
			
			$list1 .= "<tr><td align=\"right\" valign=\"top\"><input type=\"radio\" name=\"methods[shipping]\" id=\"shipping\" value=\"{$shipping_id}-{$shipping_cost}\" {$shipping_checked}/></td><td align=\"left\" valign=\"top\" class=\"text_bold\" style=\"padding-left:3px\">{$shipping_name}</td></tr><tr><td></td><td align=\"left\" valign=\"top\" style=\"color:#000000; padding-left:10px;padding-bottom:10px;\">{$delivery_time}</td></tr>";
		}
	}
	return $list1;
}
function GetPaymentName($payment_id){	
	$payment = DB::GetQueryResult("SELECT payment FROM payment_descriptions WHERE payment_id = ".$payment_id);
	return $payment['payment'];
}
function GetShippingName($shipping_id){	
	$shipping = DB::GetQueryResult("SELECT shipping_name FROM shippings WHERE shipping_id = ".$shipping_id);
	return $shipping['shipping_name'];
}
function FormatWeight($val){
	return number_format($val, 0, ',', '');
}

//convert in to color HEX
function toColor($n)
{
	return("#".substr("000000".dechex($n),-6));
}

/*Verify Code On Mobile*/
	function checkVerified($cus_id,$team_id){
		$verified = DB::GetQueryResult("SELECT verified FROM verify_code WHERE cus_id='".$cus_id."' AND team_id='".$team_id."'");	
		return $verified;
	}
	//function checkVerifyCode($cus_id,$team_id,$code){
	function checkVerifyCode($team_id,$code){
		//$vcode = DB::GetQueryResult("SELECT id FROM verify_code WHERE cus_id='".$cus_id."' AND team_id='".$team_id."' AND verify_code='".$code."'");
		$vcode = DB::GetQueryResult("SELECT id FROM verify_code WHERE team_id='".$team_id."' AND verify_code='".$code."'");	
		return $vcode;
	}
	function checkOrderId($cus_id,$team_id){
		$order_id = DB::GetQueryResult("SELECT id FROM `order` WHERE user_id='".$cus_id."' AND team_id='".$team_id."'");	
		return $order_id;
	}
	function checkSendedCode($mobile=0, $team_id=0){
		$verify = DB::GetQueryResult("SELECT verify_code, verified FROM verify_code WHERE cus_mobile='".$mobile."' AND team_id='".$team_id."'");	
		return $verify;
	}
	function checkBuyDealPromotion($user_id=0, $team_id=''){
		$ds = DB::GetQueryResult("SELECT user_id FROM `order` WHERE user_id='".$user_id."' AND team_id IN (".$team_id.") GROUP BY user_id");	
		return (int)$ds['user_id'];
	}
	function countPrizeCodes($team_id){
		$count = DB::GetQueryResult("SELECT count(maso) as total_maso FROM masoduthuong_{$team_id} WHERE team_id=".$team_id);
		return (int)$count['total_maso'];
	}
	function option_business_staff($id=0){
		$cache = $force ? 0 : 86400*30;
		$select = "*";
		/*if($id>0){
			$condition = array('id' => $id, 'status' => 'A');
		}else*/{
			$condition = array('status' => 'A');
		}
		$ward = DB::LimitQuery('sales', array(
			'select'	=> $select,
			'condition' => $condition,
			'order' => 'ORDER BY name ASC',
			'cache' => $cache,
		));
		foreach($ward as $key=>$value){
			if (is_array($value)){
				$key = strval($value['id']);
				if($key==$id){
					$selected = 'selected';
				}else{
					$selected = null;
				}
				if($value['id']!=''){
					$option .= "<option value='{$key}' {$selected}>".strip_tags($value['name']). "</option>";
				}
			}
		}
	
		return $option;
	}
	function SaleName($id=0){
		$name = DB::GetQueryResult("SELECT `name` FROM sales WHERE id=".$id);
		return $name['name'];
	}
	function option_order_notes($id=0){
		$cache = $force ? 0 : 86400*30;
		$select = "*";
		/*if($id>0){
			$condition = array('id' => $id, 'status' => 'A');
		}else*/{
			$condition = array('status' => 'A');
		}
		$ward = DB::LimitQuery('notes', array(
			'select'	=> $select,
			'condition' => $condition,
			'order' => 'ORDER BY title ASC',
			'cache' => $cache,
		));
		foreach($ward as $key=>$value){
			if (is_array($value)){
				$key = strval($value['id']);
				if($key==$id){
					$selected = 'selected';
				}else{
					$selected = null;
				}
				if($value['id']!=''){
					$option .= "<option value='{$key}' {$selected}>".strip_tags($value['title']). "</option>";
				}
			}
		}
	
		return $option;
	}
	function checkOrderNotes($order_id=0, $out_id=0){
		$n = DB::GetQueryResult("SELECT notes_id FROM order_notes WHERE order_id=".$order_id." AND out_id=".$out_id);
		return $n['notes_id'];	
	}
	function activeDeals()
	{
		$teams = DB::LimitQuery('team', array('condition'=>"status='Y'"));
		return Utility::GetColumn($teams, 'id');
	}
	function TotalOrder($order_id){
		$ds = DB::GetQueryResult("SELECT origin, shipping_cost, payment_cost FROM `order` WHERE id=".$order_id);
		return $ds['origin']+$ds['shipping_cost']+$ds['payment_cost'];
	}
	function PrintInvoice($order_id)
	{	
		$result = array();
		$ds = DB::GetQueryResult("SELECT * FROM `order` WHERE id = {$order_id}");
		if(empty($ds)) die("Can not found order {$order_id} to send email..");
		$result['order_date'] = date("d/m/Y H:i:s", $ds['create_time']);
		$result['billing_fullname'] = strip_input($ds['realname']);
		if ($ds['note_address']!=''){
			$note_address = $ds['note_address'].", ";
		}else{
			$note_address="";
		}
		//Thong tin thanh toan
		$result['billing_address'] = $note_address.strip_input($ds['address'],true);
		if(ward_name($ds['dist_id'],$ds['ward_id'])){
			$wardname = ward_name($ds['dist_id'],$ds['ward_id']);
			$result['billing_address'] .=", ".strip_input($wardname['ward_name']);
		}
		if(ename_dist($ds['dist_id'])){
			$dists = ename_dist($ds['dist_id']);
			$result['billing_address'] .=", ".strip_input($dists['dist_name']);		
		}
		if(id_city($ds['city_id'])){
			$citys = id_city($ds['city_id']);
			$result['billing_address'] .=", ".strip_input($citys['name']);		
		}
		$result['billing_phone'] = $ds['mobile'];
		$result['billing_method'] = GetPaymentName($ds['payment_id']);
		$result['total_weight'] = FormatWeight($ds['total_weight']);
		
		//Thong tin van chuyen
		$result['shipping_fullname'] = strip_input($ds['brealname']);
		if ($order['bnote_address']!=''){
			$note_address = $order['bnote_address'].", ";
		}else{
			$note_address="";
		}
		$result['shipping_address'] = $note_address.strip_input($ds['baddress'],true);
		if(ward_name($ds['bdist_id'],$ds['bward_id'])){
			$wardname = ward_name($ds['bdist_id'],$ds['bward_id']);
			$result['shipping_address'] .=", ".strip_input($wardname['ward_name']);
		}
		if(ename_dist($ds['bdist_id'])){
			$dists = ename_dist($ds['bdist_id']);
			$result['shipping_address'] .=", ".strip_input($dists['dist_name']);		
		}
		if(id_city($ds['bcity_id'])){
			$citys = id_city($ds['bcity_id']);
			$result['shipping_address'] .=", ".strip_input($citys['name']);		
		}
		$result['shipping_phone'] = $ds['bmobile'];
		$result['shipping_method'] = GetShippingName($ds['shipping_id']);
		
		
		//Begin Product List Of Order
		$result['product_list_of_order'] = "";
		$sql1 = "SELECT op.quantity, op.price, op.origin, p.short_title, p.id, p.weight FROM `order` op Inner Join team p ON p.id = op.team_id WHERE op.id={$order_id}";
		
		$cs = DB::GetQueryResult($sql1, false);
		if(empty($cs)) 	die("Invalid Order Detail...");
		$list_cart_review = array();
		
		foreach($cs AS $key =>$val){
			$quantity = $val["quantity"];
			$weight = $val["weight"]==""?$val["weight"]:100;
			$price = $val["price"];
			$product_name = $val["short_title"];
			$subtotal = $val["origin"];
			$result['product_list_of_order'] .= '<tr bgcolor="#FFFFFF"><td align="left" valign="top" style="padding:5px;border-bottom:solid 1px #999999;border-right:solid 1px #999999;">'.$order_id.'</td>
			  <td align="left" valign="top" style="padding:5px;border-bottom:solid 1px #999999;border-right:solid 1px #999999;">'.$product_name.'</td>
			  <td align="center" valign="top" style="padding:5px;border-bottom:solid 1px #999999;border-right:solid 1px #999999;">'.$quantity.'</td>
			  <td align="center" valign="top" style="padding:5px;border-bottom:solid 1px #999999;border-right:solid 1px #999999;">'.$weight.'</td>
			  <td align="right" valign="top" style="padding:5px;border-bottom:solid 1px #999999;border-right:solid 1px #999999;">'.print_price(moneyit($price)).'</td>
			  <td align="right" valign="top" style="padding:5px;border-bottom:solid 1px #999999;">'.print_price(moneyit($subtotal)).'</td>
			</tr>';
		}
		//End delivery_note, order_notes, delivery_wish,
		if(!empty($ds['remark'])){
			$order_notes = $ds['remark'];
		}
		if(!empty($ds['remark2'])){
			$order_notes .= $ds['remark2'];
		}
		$result['order_status'] = getStatusName($ds['state']);

		$result['billing_cost'] = print_price(moneyit($ds['payment_cost']));
		$result['shipping_cost'] = print_price(moneyit($ds['shipping_cost']));
		$result['origin'] = $ds['origin'];
		$result['total_amount'] = print_price(moneyit(TotalOrder($order_id)));

		return $result;
	}
	function PrintLabel($order_id){
		$order = DB::GetQueryResult("SELECT brealname, bmobile, bnote_address, baddress, bcity_id, bdist_id, bward_id, team_id, shipping_cost, payment_cost, payment_id, origin FROM `order` WHERE id={$order_id}");
		$s_fullname = "<font style=\"text-transform:uppercase; font-weight:bold\">".$order['brealname']."</font>";
		if($order['bnote_address']!=''){
			$note_address = htmlspecialchars($order['bnote_address']).", ";
		}else{
			$note_address = "";
		}
		$shipping_address = $note_address.htmlspecialchars($order['baddress']);
		if(ward_name($order['bdist_id'],$order['bward_id'])){
			$wardname = ward_name($order['bdist_id'],$order['bward_id']);
			$shipping_address .=", ".strip_input($wardname['ward_name']);
		}
		if(ename_dist($order['bdist_id'])){
			$dists = ename_dist($order['bdist_id']);
			$shipping_address .=", ".strip_input($dists['dist_name']);		
		}
		if(id_city($order['bcity_id'])){
			$citys = id_city($order['bcity_id']);
			$shipping_address .=", ".strip_input($citys['name']);		
		}
		 $subtotal = print_price(moneyit($order['origin']+$order['shipping_cost']+$order['payment_cost']));
		if($order['payment_id']==1){
			$cod = "COD<br />".$subtotal."&nbsp;<span style='font-size:60%; text-transform:none'>VNĐ</span>";	
			$html = '<tr>
              <td align="center" height="60" colspan="2" style="font-size:16px; font-family:Arial;border-bottom:none;border-top:none;">Vui lòng giao hàng khi người nhà đồng ý nhận và thanh toán tiền thay. Chân thành cảm ơn nhân viên PCN</td>
            </tr>';
		}else{
			$cod = "&nbsp;";	
		}
		$s_tel = $order['bmobile'];
		$team_title = DB::GetQueryResult("SELECT short_title FROM team WHERE id=".$order['team_id']);
		$createtime = date("Y-m-d H:i:s",time());		
		$content = '<table border="0" cellspacing="3" cellpadding="1" width="650" height="450" style="margin:0px">
  <tbody>
    <tr>
      <td width="50%" height="54" align="left" valign="top"><img class="logo" src="/static/css/images/LogoConfirmOrder.jpg" alt="" /></td>
      <td width="50%" align="right" valign="top"><img src="/barcode/?barcode='.$order_id.'" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="2" valign="top"><table width="100%" cellpadding="5" cellspacing="0" style="border-left:#000000 1px solid;border-right:#000000 1px solid;border-top:#000000 1px solid;border-bottom:#000000 1px solid;">
          <tbody>
            <tr>
              <td width="85%" height="79" style="font-size:16px; font-family:Arial;border-bottom:none;"><u>FROM</u>: <strong>CTY CP TM ALL IN ONE</strong><br> Lầu 8, Alpha Tower, 151 Nguyễn Đình Chiểu, P.6, Q. 3, TP.HCM<br>Tel: 08-73024401&nbsp;&nbsp;&nbsp;&nbsp;Fax: 08-39300394</td>
              <td width="15%" align="center" valign="top" style="font-size:22px; font-family:Georgia, \'Times New Roman\', Times, serif;border-bottom:none;"><b>'.$cod.'</b></td>
            </tr>
            <tr>
              <td height="60" style="border-bottom:none;border-top:none" colspan="2" align="center"><span style="font-size:130%"><strong>Sản phẩm: </strong></span><span style="font-size:160%"><b>'.$team_title['short_title'].'</b></span></td>
            </tr>
            <tr>
              <td valign="bottom" style="border-bottom:none;border-top:none;" colspan="2"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                  <tbody>
                    <tr>
                      <td width="50%" align="left" valign="bottom"></td>
                      <td width="50%" align="left" valign="top"><span style="text-decoration:underline; font-size:22px; font-family:Arial">TO:</span> <span style="font-size:22px; font-family:Arial"><strong>'.$order['brealname'].'</strong></span><br />
                      <span style="font-size:20px; font-family:Arial; font-weight:normal">'.$shipping_address.'<br />
                      Tel: '.$s_tel.'<br /></span></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>'.$html.'			
            <tr>
              <td colspan="2" align="left" valign="bottom" style="border-top:#000000 0.5px solid; font-size:11px; font-family:Arial">Print at: '.$createtime.' </td>
            </tr>
          </tbody>
        </table></td>
    </tr>
  </tbody>
</table>';
		return $content;
	}
	function LoadPaymentMethod(){
		$q2 = DB::GetQueryResult("SELECT payment_id, payment FROM payment_descriptions WHERE status='A' ORDER BY position", false);
		if(is_array($q2)){
			$payment_lst = "";
			foreach($q2 as $key=>$value){
				$payment_id = $value['payment_id'];
				$payment_name = strip_input($value['payment']);
				$payment_lst .="<option value=\"{$payment_id}\">{$payment_name}</option>";
			}
		}else{
			$payment_lst = "";
		}
		return $payment_lst;
	}
	function RandomBuy($now_number,$constant){
		if((int)$constant>0){
			$output = ($now_number*$constant)/100;	
		}elseif($now_number>100 && $now_number<=150){
			$output = ($now_number*80)/100;
		}elseif($now_number>150 && $now_number<=200){
			$output = ($now_number*70)/100;
		}elseif($now_number>200 && $now_number<=300){
			$output = ($now_number*50)/100;
		}elseif($now_number>300){
			$output = ($now_number*10)/100;
		}else{
			$output = $now_number;
		}
		return ceil($output);
	}
/*End*/