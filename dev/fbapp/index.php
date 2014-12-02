<?php

require_once('init.php');

//ob_start("ob_gzhandler");
/*
if($signed_request = parsePageSignedRequest()) {
 	
	if($signed_request->page->liked) {	
		return header("Location: index.php");	  
	} else {		
		return header("Location: like.php");
	}
}
*/
// Get User ID
try {
	$user = $facebook->getUser();	
} catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
}

//var_dump($debuger->__toString());
//var_dump($user_profile);exit;

if ($user) {
  try {
    $user_profile = $facebook->api('/me');
	
	$likes = $facebook->api("/me/likes/$page_id");
    if( !empty($likes['data']) )
	{
        return header("Location: main.php");	  
	}else{
        return header("Location: like.php");	  
	}	
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

if ($user) {
  //$logoutUrl = $facebook->getLogoutUrl();
  return header("location: main.php");
} else {
  //$loginUrl = $facebook->getLoginUrl(array('scope' => 'status_update,publish_stream,user_photos,email', 'redirect_uri' => ''.$scripturl.'main.php', 'response_type' => 'code'));
   $loginUrl = $facebook->getLoginUrl(array('scope' => 'status_update,publish_stream,user_photos,email', 'redirect_uri' => 'main.php', 'response_type' => 'code'));  
   die('<script>window.top.location="'.$loginUrl.'"</script>');
  //return header("location: $loginUrl");
}

function parsePageSignedRequest() {
    if (isset($_REQUEST['signed_request'])) {
      $encoded_sig = null;
      $payload = null;
      list($encoded_sig, $payload) = explode('.', $_REQUEST['signed_request'], 2);
      $sig = base64_decode(strtr($encoded_sig, '-_', '+/'));
      $data = json_decode(base64_decode(strtr($payload, '-_', '+/')));      
	  return $data;
    }
    return false;
}