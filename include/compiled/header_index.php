<?php include template("html_header");?>

<div id="hdw">
  <div id="hd">  	
    <div id="logo" align="left"><a href="/<?php echo $city['slug']; ?>/" class="link"><img src="/static/css/images/logo.jpg" alt="<?php echo $INI['system']['sitename']; ?>: Mua hàng theo nhóm, cùng mua chung để có giá ưu đãi" /></a></div>
    <div class="guides">

      <div class="city" id="city-change" style="cursor:pointer; margin-top:-3px;">
       <?php if($city){?> 
        <h2><?php echo $city['name']; ?>&nbsp;<span id="guides-city-change"><img align="absmiddle" src="/static/css/images/btn_nextnum.gif" alt="Chọn thành phố" width="17" height="17" /></span></h2>
        <?php }?>
        <h4>Giá cả mang bạn đến, chất lượng giữ chân bạn</h4>
      </div>
      <?php if(count($j_hotcities)>1){?>     
      <div id="guides-city-list" class="city-list">
        <ul>
          <?php echo current_city($city['name'], $j_hotcities); ?>
        </ul>
      </div>      
      <?php }?>
      <div class="clear"></div>
    </div>
    <div class="logins">
      <?php if($login_user){?>
      <ul class="links">
        <li class="username">
          <table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td rowspan="3" align="left" valign="top" nowrap="nowrap"><?php if($login_user['avatar']!=""){?>
                <div style="margin-right:10px; border:1px #ccc solid;background:#fff;padding:2px; width:28px;height:28px"><img src="<?php echo user_image($login_user['avatar']); ?>" width="28" height="28" /></div>
                <?php } else { ?>
                <?php if($login_user['fb_userid']){?>
                <div style="margin-right:10px; border:1px #ccc solid;background:#fff;padding:2px; width:28px;height:28px"><img src="https://graph.facebook.com/<?php echo $login_user['fb_userid']; ?>/picture" width="28" height="28" />
                  <div style="position:absolute; left:56px; bottom:15px;"><img src="/static/css/images/f16.jpg" width="12" height="12" /></div>
                </div>
                <?php } else { ?>
                <div style="margin-right:10px; border:1px #ccc solid;background:#fff;padding:2px; width:28px;height:28px"><img src="/static/css/images/noavatar.jpg" width="28" height="28" /></div>
                <?php }?>
                <?php }?></td>
              <td align="left" valign="top" colspan="2" style="padding-bottom:5px;padding-top:7px;font-weight:bold"> Chào, 
                <?php if($login_user['realname']){?>
                <?php echo $login_user['realname']; ?>！
                <?php } else { ?>
                <?php echo $login_user['email']; ?>
                <?php }?>
              <td align="left" valign="top" class="account" ><ul id="myaccount"><li><a href="/order/index.php" class="account" style="padding:5px;">My <?php echo $INI['system']['abbreviation']; ?></a>
              <ul id="myaccount-menu">
      <?php echo current_account(null); ?>
    </ul></li></ul>
</td>
              <td align="left" valign="top" class="logout" style="padding-top:5px"><a style="padding:5px;" href="/account/logout.php">Đăng xuất</a></td>
            </tr>
          </table>
        </li>
      </ul>
      <?php } else { ?>
      <ul class="links">
        <li class="login">
          <script type="text/javascript" language="javascript">
			var SITE_ROOT_URL = "http://<?php echo $INI['system']['sitename']; ?>";
			function google_login() {
				var top = (screen.height - 400) / 2;
				var left = (screen.width - 570) / 2;
				var googlewindow = window.open(SITE_ROOT_URL + '/plugin_login/googlelogin.php?login&returnUrl=' +  window.location, "google_account", "status=0,toolbar=0,width=570,height=400,top=" + top + ",left=" + left);
			}
			
			function yahoo_login() {
				var top = (screen.height - 500) / 2;
				var left = (screen.width - 570) / 2;
				var yahoowindow = window.open(SITE_ROOT_URL + '/plugin_login/yahoologin.php?login&returnUrl=' + window.location, "yahoo_account", "status=0,toolbar=0,width=570,height=500,top=" + top + ",left=" + left);
			}
          </script>
          <a href="/account/signup.php">Đăng ký</a>&nbsp;&nbsp;<img src="/static/css/images/menu_spacer.gif" align="absmiddle" />&nbsp;&nbsp;<a href="/account/login.php">Đăng nhập</a>&nbsp;&nbsp;<img src="/static/css/images/menu_spacer.gif" align="absmiddle" />&nbsp;&nbsp;
          <span  style="font-size:13px; font-family:Arial; font-weight:bold">Đăng nhập bằng</span>&nbsp;<a href="javascript:void(0)" title="Yahoo"><img src="/static/css/images/yahoo_connect.gif" title="Yahoo" onclick="yahoo_login();" border="0" align="absmiddle"></a>&nbsp;<a href="javascript:void(0)" title="Gmail"> <img src="/static/css/images/google_connect.gif" onclick="google_login();" title="Gmail" border="0" align="absmiddle"></a>
        </li>
      </ul>
      <?php }?>
    </div>
    <div class="subscribe" align="center">
        <form action="/subscribe.php" method="post" id="header-subscribe-form"  class="validator">
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="top" nowrap="nowrap" class="label-big-subscription" colspan="3" style="padding-left:10px;">Nhập email để nhận deal tốt mỗi ngày</td></tr><tr>
            <td align="left" style="padding-left:10px;"><input id="header-subscribe-email" type="text" xtip="Your Email Address" value="" class="f-text-top" name="email" require="true" datatype="require" /></td>
            <td align="left"><select name="city_id" class="f-input-top"><?php echo Utility::Option(Utility::OptionArray($allcities,'id','name'), $city['id']); ?></select></td>
            <td align="left"><input value="Gửi" type="submit" class="submit"></td>
          </tr>
        </table>
        </form>
    </div>
    <ul class="nav cf">
        <?php echo current_top(); ?>
    </ul>
  </div>
</div>
<?php if($session_notice=Session::Get('notice',true)){?>
<div class="sysmsgw" id="sysmsg-success">
  <div class="sysmsg">
    <p><?php echo $session_notice; ?><span class="close">Đóng</span></p>
  </div>
</div>
<?php }?>
<?php if($session_notice=Session::Get('error',true)){?>
<div class="sysmsgw" id="sysmsg-error">
  <div class="sysmsg">
    <p><?php echo $session_notice; ?><span class="close">Đóng</span></p>
  </div>
</div>
<?php }?>