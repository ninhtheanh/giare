<?php
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="vn">
<head>

<title>Cheapdeal.vn: Xoá cookies thành công</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="vn" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
<meta name="robots" content="noindex" />
<link href="http://cheapdeal.vn/static/icon/favicon.ico" rel="shortcut icon" />
<style type="text/css">
#container {
	padding:0;
	margin:0 auto;
	background: url(/static/css/images/logo_cheapdeal-mo.png) top center no-repeat #015383;
	background-position:50% 0px; font-size:18px; font-family:Arial, Helvetica, sans-serif
}
.exception-content p{font-size:14px}.exception-logo{margin-left:-12px}
</style>
<script type="text/javascript" src="/static/js/jquery/jquery.min.js"></script>
<script type="text/javascript">
	var url='http://cheapdeal.vn/';var time_auto=5;
	function auto_return_homepage(){
		var clock_auto_return=document.getElementById('clock_auto_return');
		if(time_auto==5){
			window.location.href=url;
		}else{
			clock_auto_return.innerHTML=time_auto;
			time_auto--;
		}
	}
	setInterval('auto_return_homepage()',1000)
</script>
</head>
<body id="container">
<center>
  <div style="margin:150px 0 0 100px;">
    <div style="width:850px; text-align:center">
      <div style="color:#FFFFFF;font-size:40px;padding-bottom:4px; white-space:nowrap; font-weight:bold; padding-bottom:30px">Đang chuyển trang</div>
      <div style="font-size:25px; color:#ffffff; padding-bottom:30px">Tự động về trang chủ trong <span id="clock_auto_return" style="font-size:40px; color:#ff9900; font-weight:bold; font-family:Georgia, 'Times New Roman', Times, serif"></span> giây hoặc bấm vào đường dẫn </br><a href="http://cheapdeal.vn/" style="color:#FFFFFF; text-decoration:none; font-size:25px; font-weight:bold; color:#ff9900; line-height:70px">"Cheapdeal.vn ® | Cùng trải nghiệm phong cách mua hàng online"</a> </br>để trở về trang chủ</div>
    </div>
  </div>
</center>
<script type="text/javascript">
		window.onload = auto_return_homepage;
	</script>
</body>
</html>