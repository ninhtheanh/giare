<?php
session_start();
include 'config.php';
require_once 'src/facebook.php';
$app_id = $app_id;
$app_secret = $app_secret;
$redirect_uri ="".$scripturl."/main.php";
$facebook = new Facebook(array(
        'appId' => $app_id,
        'secret' => $app_secret,
        'cookie' => true
));
$user = $facebook->getUser();
$user_profile = $facebook->api('/me');

$coded = $_REQUEST['code'];

$access_token = $facebook->getAccessToken();
$name = "".$user_profile['name']."";
$fbid = "".$user_profile['id']."";


$fql = 'https://graph.facebook.com/fql?q=SELECT+uid2+FROM+friend+WHERE+uid1='.$fbid.'+ORDER+BY+rand()+LIMIT+1&access_token='.$access_token.'';
$fqlresult = file_get_contents($fql); 
$f = json_decode($fqlresult, true);

$friends = $f['data']['0']['uid2'];

$fql2 = 'https://graph.facebook.com/'.$friends.'';
$fqlresult2 = file_get_contents($fql2); 
$f2 = json_decode($fqlresult2, true);

$friend = $f2['name'];  

$canvas = imagecreatefromjpeg ("bg.jpg");                                   // background image file
$black = imagecolorallocate( $canvas, 61, 61, 61 );                         // The second colour - to be used for the text
$font = "font.ttf";                                                         // Path to the font you are going to use                                                         // font size

imagettftext( $canvas, 15, -1, 51, 60, $black, $font, $name );
imagettftext( $canvas, 15, -1, 51, 200, $black, $font, $friend );

imagejpeg( $canvas, "img/".$fbid.".jpg", 50 );

ImageDestroy( $canvas );

header("Location: ".$scripturl."upload.php?id=".$fbid."&friends=".$friends."")
?>
