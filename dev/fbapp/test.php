<?php

require_once('init.php');

// Get User ID
try {
	$user = $facebook->getUser();
	$user_profile = $facebook->api('/me');
} catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
}

//var_dump($debuger->__toString());
//var_dump($user_profile);exit;

if (!$user) {  
  $loginUrl = $facebook->getLoginUrl(array('scope' => 'status_update,publish_stream,user_photos,email', 'redirect_uri' => ''.$scripturl.'main.php', 'response_type' => 'code'));
  return header("location: $loginUrl");
}else{
	try {
		$user_profile = $facebook->api('/me');
	  } catch (FacebookApiException $e) {
		error_log($e);
		$user = null;
	  }
}

$fbid = $user_profile['id'];
$name = $user_profile['name'];
$access_token = $facebook->getAccessToken();

$facebook->setFileUploadSupport(true);
$album_details = array(
		'message'=> $albumname,
		'name'=> $albumname
);
$create_album = $facebook->api('/me/albums', 'post', $album_details);	
$album_uid = $create_album['id'];

$file='img/'.$fbid.'.jpg'; 
/*
$data = array(array('tag_uid' => $friends, 'x' => rand() % 100, 'y' => rand() % 100 ));
$data = json_encode($data);
*/
$photo_details = array( 'message'=> $albummessage, 'tags' => $data, 'image' => '@' . realpath($file) );

$upload_photo = $facebook->api('/'.$album_uid.'/photos', 'post', $photo_details);
$upphoto = $upload_photo['id'];

$code = $db->get('fbuser','id','fbid='.$fbid);
$code = str_pad($code,5,0,STR_PAD_LEFT);

$src = 'can-tho.jpg';
$dst = 'img/'.$fbid.'.jpg';
//$wm = 'http://www.dealsoc.vn/static/css/images/logo.jpg';

$wm = 'http://graph.facebook.com/'.$fbid.'/picture';
//$wm = '41705_100003689140071_330249740_q.jpg';

$cmd = "convert '$src' '$wm' -geometry +10+10 -composite  \-font arial -pointsize 15 -fill red -density 100 \-stroke white -strokewidth 3 -draw \"text 170,80 '$name'\" \-stroke none -draw \"text 170,80 '$name'\" \-font arial -pointsize 12 -fill red -density 100 \-stroke white -strokewidth 3 -draw \"text 294,123 '$code'\" \-stroke none -draw \"text 294,123 '$code'\" $dst";

exec($cmd);

?>

<img src="<?php echo $dst; ?>" />
