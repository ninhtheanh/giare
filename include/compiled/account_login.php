<?php include template("header");?>
<style>
.atbreadcrum a{color:#64a64e;}
.atbreadcrum a:hover{color:#000;}
.atfiled{width: 344px;height: 40px;border: 1px solid #b5b5b5;border-radius: 6px;box-shadow: 0px 0px 1px;font-size: 20px;color: #5b5b5b;padding-left: 10px;}
.atboxlogin label{font-weight: bold;padding-top: 6px !important;text-align: left !important;color: #757374 !important;display: inline-block;}
</style>
<div id="atbreadcrum">
	 <div class="atbreadcrum" style="margin-left: 260px;margin-top: -22px; color:#64a64e;" >
     	<a href="/<?php  echo $city['slug']; ?>">Khuyến mãi </a>
        > <a style="color:#000;">Đăng nhập</a>
     </div>

</div>

<div id="bdw" class="bdw">
  <div id="bd" class="cf">
    <div id="login">
    	<div id="signup">
    <?php  	/*  <div class="dashboard" id="dashboard">
        <ul>
          <?php echo current_frontend(); ?>
        </ul>
      </div>  */ ?></div>
	</div>
      <div id="contentfontend" class="login-box">
        <div class="box clear">
          <div class="subbox-content" style="background:none; border: 1px solid #ccc;margin: 10px 0px;">
            <div class="sect" style="background-color:#FFFFFF">
              <div align="left" style="padding:20px; padding-top:10px;"><div style="font-size:17px;padding-bottom:10px">
               <h2 style="border-bottom: 2px solid #bebebe;color: #000;padding-bottom: 11px;font-size: 20px;">ĐĂNG NHẬP</h2>
           <?php     /*  <h2>Đăng nhập bằng tài khoản <?php echo $INI['system']['abbreviation']; ?><span>&nbsp;hoặc <a href="/account/signup.php">Đăng ký</a></span></h2>  */ ?>
            </div>
                <form id="login-user-form" method="post" action="/account/login.php" class="validator">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:50px;">
                    <tr>
                      <td align="left" valign="top" width="50%" style="width: 630px;border-right: 1px solid #cdcdcd;">
                      	<div class="atboxlogin">
                        		<table>
                                <tbody>
                                    <tr>
                                      <td align="left" height="35"><div class="field email" style="width:550px; margin-bottom: 10px;">
                                          <label for="login-email-address">Email</label>
                                          <input type="text" size="30" name="email" id="login-email-address" class="f-input1 atfiled" value="" require="true" datatype="require|limit" min="2" />
                                        </div></td>
                                    </tr>
                                    <tr>
                                      <td align="left" height="35"><div class="field password" style="width:600px">
                                          <label for="login-password">Mật khẩu</label>
                                          <input type="password" size="30" name="password" id="login-password" class="f-input1 atfiled" require="true" datatype="require" />
                                        </div></td>
                                    </tr>
                                    <tr>
                                    	<td>
                                        <div class="field password" style="width:600px">
                                        	<span class="lostpassword" style="margin-left: 368px;margin-top: 6px;display: block;"><a href="/account/repass.php">Quên mật khẩu?</a></span></div>
                                        </td>
                                    </tr>
                                    <tr>
                                      <td align="left" height="35" style="padding-left:80px;"><div class="field autologin" style="width:145px; white-space:nowrap"><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><input style="margin-left:45px" type="checkbox" value="1" name="auto-login" id="autologin" class="f-check" checked /></td>
    <td><label for="autologin">Ghi nhớ</label></td>
  </tr>
</table></div></td>
                                    </tr>
                                    <tr>
                                      <td align="left" height="35">
                                      
                                   <?php     /*  <div class="act">
                                          <input style="margin-left:130px" type="submit" value="Đăng nhập" name="commit" id="login-submit" class="formbutton"/>
                                        </div>  
<div align="center" style="margin-top:28px;">
                         <input type="image" src="/static/img/btn-dangnhap.png" alt="Submit">
                        </div>*/ ?>
                                        <div class="boxbuttoncss" align="center" style="margin-top:28px;margin-left: 162px;">
                                        <button class="buttoncss">Đăng Nhập</button>
                                        </div>
                                        </td>
                                    </tr>
                                  </tbody>
                                </table>
                        </div>
                      </td>
                      <td width="40%" style="text-align:center; padding-top:6%;" valign="top">
                          <h2 style="font-size:15px; margin-bottom:17px;">Bạn chưa là thành viên?</h2>
                          <a href="/account/signup.php" style="font-size: 16px;color: #FFFFFF;display: block;padding-left: 6px;width: 170px;margin: 0px auto;" class="boxbuttoncss">
                                        <div class="buttoncss" style="line-height: 2.5;">Đăng Ký</div>
                          </a>
                        
                        </td>
                    </tr>
                  </table>
                </form>
              </div>
            </div>
          </div>
          <div class="box-bottom"></div>
        </div>
      </div>
    </div>
  </div>
  <!-- bd end -->
</div>
<!-- bdw end -->
<div align="center">
<?php include template("footer");?></div>
