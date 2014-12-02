<?php
error_reporting(0);
session_start();
//tao chuoi so ngau nhien de dat vao hinh ma bao ve
$str_arr = array("0","1","2","3","4","5","6","7","8","9","0","1","2","3","4","5","6","7","8","9");
//lay ngau nhien 4 ptu trong mang
$keys = array_rand($str_arr, 6);
//ghep các phan tu trong mang lai
$str='';
foreach($keys as $n=>$i)
{
	$str.= $str_arr[$i];
}
$_SESSION['codeimg']=$str;
//mang ký tu
$bgimage = "codeimg.gif";
$ic=imagecreatefromgif($bgimage);
$font = 'arial.ttf';
$angle=0;
$top=16;
$left=2;
$size=13;
$color=5;
$red = imagecolorallocate($ic,255,0,0);

//Dat text len hinh
imagettftext($ic, $size, $angle, $left, $top,$red, $font, $_SESSION['codeimg']);
header('Content-Type: image/gif');
imagegif($ic);
imagedestroy ($ic);
?>

