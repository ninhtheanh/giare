<?php

require_once('init.php');

$coded = $_REQUEST['code'];

$access_token = $facebook->getAccessToken();

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

$name = $user_profile['name'];
$fbid = $user_profile['id'];

/*
$fql = $dns['graph'].'fql?q=SELECT+uid2+FROM+friend+WHERE+uid1='.$fbid.'+ORDER+BY+rand()+LIMIT+1&access_token='.$access_token;
$fqlresult = file_get_contents($fql); 
$f = json_decode($fqlresult, true);

$friends = $f['data']['0']['uid2'];

$fql2 = $dns['graph'].$friends;
$fqlresult2 = file_get_contents($fql2); 
$f2 = json_decode($fqlresult2, true);

$friend = $f2['name'];  
*/

// user posted
$posted = $db->get('fbuser','posted','fbid='.$fbid);

if($posted==1)
{
?>
<h3>Bạn đã đăng ký chương trình, mã số dự thưởng của bạn là : <?php	echo str_pad($db->get('fbuser','id','fbid='.$fbid),5,0,STR_PAD_LEFT);	?></h3>
<a href="<?php echo $homeurl?>><img src="<?php echo $scripturl?>img/<?php echo $fbid ?>.jpg" /></a>
<h3><a href="<?php echo $homeurl?>">www.dealsoc.vn</a></h3>
<?php
return;
}

//insert db
if($fbid && $posted!=1)
{
	$data = array(
			'name' => $name,	
			'email' => $user_profile['email'],
			'fbid' => $fbid,
			'posted' => 0,
	);
	$result = $db->insert('fbuser',$data);
}

//gen image
if($_GET['choice'])
{	
	$code = $db->get('fbuser','id','fbid='.$fbid);
	$code = str_pad($code,5,0,STR_PAD_LEFT);
	
	$src = 'images/'.$_GET['choice'].'.jpg';
	$dst = 'img/'.$fbid.'.jpg';
	//$wm = 'http://www.dealsoc.vn/static/css/images/logo.jpg';
	
	$wm = 'http://graph.facebook.com/'.$fbid.'/picture';
	//$wm = '41705_100003689140071_330249740_q.jpg';
	
	$cmd = "convert '$src' '$wm' -geometry +10+10 -composite  \-font arial -pointsize 15 -fill red -density 100 \-stroke white -strokewidth 3 -draw \"text 170,80 '$name'\" \-stroke none -draw \"text 170,80 '$name'\" \-font arial -pointsize 12 -fill red -density 100 \-stroke white -strokewidth 3 -draw \"text 294,123 '$code'\" \-stroke none -draw \"text 294,123 '$code'\" $dst";
	
	exec($cmd);	
	
	// redirect
	return header("Location: ./upload.php?id=".$fbid."&friends=".$friends);

}
// not posted - show images
?>
<script>
 $(document).ready(function() {
   $("#thumb img").hover(function(){
		$(this).fadeTo("fast", 0.7);
		//$(this).fadeTo("fast", 1); // This should set the opacity to 100% on hover		
		},function(){
		$(this).fadeTo("fast", 1); // This should set the opacity back to 60% on mouseout		
		//$(this).fadeTo("fast", 0.8);
	});
	$("#thumb a").click(function(){
		$("#thumb").fadeTo("fast", 0.3);
	});
 });
 </script>
<h3>Chọn 1 hình bạn yêu thích để đăng lên tường Facebook:</h3>
<ul id="thumb" style="margin:0;padding:0">
<?php
for($i=1;$i<=25;$i++)
{	
?>
<li style="margin:5px; background:#ccc; float:left;<?php if(($i-1)%7==0) echo 'clear:both'; ?>">
<a href="./main.php?choice=<?php echo $i; ?>"><img src="thumb/<?php echo $i.'.jpg'; ?>" width="100" height="100" /></a></li>
<?php 
} 
?>
</ul>