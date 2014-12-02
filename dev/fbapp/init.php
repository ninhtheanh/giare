<?php

include 'config.php';
require_once 'src/mysql.php';
require_once 'src/facebook.php';

$db = new mysql($dbstring);

$facebook = new Facebook($config);

BaseFacebook::$DOMAIN_MAP['graph'] = $ip.'/';

BaseFacebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
BaseFacebook::$CURL_OPTS[CURLOPT_SSL_VERIFYHOST] = 2;

//$debuger = new FacebookApiException();

//$user = $facebook->getUser();

//$user_profile = $facebook->api('/me');

//$access_token = $facebook->getAccessToken();

?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>