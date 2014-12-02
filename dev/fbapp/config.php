<?php

$ip = 'https://graph.facebook.com';

$dbstring = array(
	'host' => 'localhost',
	'user' => 'dev',
	'pass' => 'mysqldevp@ssw0rdocaoc',
	'db' => 'ds_database_dev'
);

$dns = array(
    'api'       => 'https://api.facebook.com/',
    'api_video' => 'https://api-video.facebook.com/',
    'api_read'  => 'https://api-read.facebook.com/',
    //'graph'     => 'https://graph.facebook.com/',		
	'graph'     => $ip.'/',	
    'www'       => 'https://www.facebook.com/',
  );
  

$config['appId'] = '336241239763697';
$config['secret'] = '67523d1d25f4714700af7aae8ff68a6a';
$config['fileUpload'] = true;
$page_id = '431918866823536';

$scripturl = "http://dev.dealsoc.vn/dev/fbapp/"; // Must end in / full path to script not to a file
//$fanpage = "http://www.facebook.com/dealsochcm";
$passback = 'http://www.facebook.com/pages/I-love-movies/431918866823536?sk=app_340719212654997';
$fanpage = "http://www.facebook.com/pages/I-love-movies/431918866823536";
$finalurl = "http://www.facebook.com/dealsochcm";
$homeurl = "http://www.dealsoc.vn";

//ALBUM DETAILS 

$albumname = "Who will you marry?";
$albummessage = "Which Friend will you Marry? Find Out Here -> https://www.facebook.com/friendmarriage?sk=app_165747553532719";

?>