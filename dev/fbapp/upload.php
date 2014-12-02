<?php

require_once('init.php');

$redirect_uri ="".$scripturl."main.php";
$coded = $_REQUEST['code'];

try {
	$user = $facebook->getUser();
	$user_profile = $facebook->api('/me');
} catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
}

if (!$user) {
  $loginUrl = $facebook->getLoginUrl(array('scope' => 'status_update,publish_stream,user_photos,email', 'redirect_uri' => ''.$scripturl.'main.php', 'response_type' => 'code'));
  return header("location: $loginUrl");
}

$fbid = $user_profile['id'];
$name = $user_profile['name'];
$access_token = $facebook->getAccessToken();

//var_dump($user_profile);
if ($_GET['action'] == "publish") 
{
	//$friends = $_REQUEST['friends'];
	
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
	
	//insert db
	if($album_uid)
	{
		$data = array(
			'posted' => 1
		);
		$result = $db->update('fbuser',$data,'fbid='.$fbid);
		
	}
	
	header("Location: $finalurl");
};
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Publish To Wall?</title>
<style>
body {  color: #3B5998; font-weight:bold; font-family:"lucida grande", tahoma, verdana, arial, sans-serif; font-size: 19px; }
.main { padding-top: 0px; width: 500px; height: 210px; margin: 0 auto; }
.pic { width: 100px; height: 100px; float: left; position:relative; }
.name { float: top left; padding-left: 110px; margin-bottom: 4px; color: #3B5998; font-weight:bold; font-family:"lucida grande", tahoma, verdana, arial, sans-serif; font-size: 14px;}
</style>
<script>
 $(document).ready(function() {  
	$("#upbtn").click(function(){
		$(".main").fadeTo("fast", 0.3);
	});
 });
 </script>
</head>
<body>
<div class="main"> 	
	<p align="center"><a href="./main.php">Chọn hình khác</a> &nbsp; <a id="upbtn" href="upload.php?action=publish&friends=<?php echo $friends ?>"><img src="publish.png" width="294" height="64" border="0" align="absmiddle" /></a></p>
  <div class="uploaded"><img src="<?php echo $scripturl?>img/<?php echo $fbid ?>.jpg" /></div> 

</div>

</body>
</html>