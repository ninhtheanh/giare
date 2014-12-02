<?php include template("header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="maillist">
	<div class="subdashboard" id="dashboard">
		<ul><li class="current"><a href="#">&nbsp;&nbsp;Google Connect </a><span></span></li></ul>
	</div>
    <div class="box clear">
	<div id="contentfontend" class="mainwide">
    	<div class="subbox-content welcome"><div style="background-color:#FFFFFF;min-height:450px;_height:450px">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="top" width="70%" style="padding:20px"><div  align="left" style="font-size:20px;"><h4>Đăng ký để nhận thông tin khuyến mãi tại <?php echo $city['name']; ?> - lên đến 90% giảm giá!</h4></div><table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr>
              <td width="24"><img src="/static/css/images/faqbox_topleft.gif" width="24" height="20"></td>
              <td style="background: url(&quot;/static/css/images/faqbox_topbg.gif&quot;) repeat-x scroll 0% 0% transparent;"></td>
              <td width="23"><img src="/static/css/images/faqbox_topright.gif" width="23" height="20"></td>
            </tr>
            <tr>
              <td style="background: url(&quot;/static/css/images/faqbox_leftbg.gif&quot;) repeat-y scroll right center transparent;">&nbsp;</td>
              <td bgcolor="#f1f1f1"><form id="enter-address-form" action="/account/signupgoogle.php" method="post" class="validator">
              	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tbody>
                    <tr>
                      <td align="left" height="35"><div class="field email">
							<label>Email: </label>
							<input id="enter-address-mail" name="email" class="f-input" type="text" value="<?php echo $_SESSION['GOOGLE_USER_LOGIN']['email']; ?>" size="30" require="true" datatype="email" />
							<span class="hint">Để đăng nhập và tìm lại mật khẩu, không công khai</span>
						</div></td>
                    </tr>
                    <tr align="left">
                      <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                    </tr>
                    <tr>
                      <td align="left" height="35"><div class="field password">
                            <label for="signup-password">Mật khẩu </label>
                            <input type="password" size="30" min="6" max="16" maxLength="16"  name="password" id="signup-password" class="f-input" require="true" datatype="require" />
                            <span class="hint">Mật khẩu ít nhất 6 ký tự</span>

                        </div></td>
                    </tr>
                    <tr align="left">
                      <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                    </tr>
                    <tr>
                      <td align="left" height="35"><div class="field password">
                            <label for="signup-password-confirm">Xác nhận mật khẩu</label>
                            <input type="password" size="30" name="password2" id="signup-password-confirm" class="f-input" require="true" datatype="compare" compare="signup-password" />
                        </div></td>
                    </tr>
                    <tr align="left">
                      <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                    </tr>
                    <tr>
                      <td align="left" height="35"><div class="field">
                        <label>Họ tên</label>
                        <input type="text" size="30" name="realname" id="settings-realname" class="f-input" require="true" datatype="require" value="<?php echo $_SESSION['GOOGLE_USER_LOGIN']['realname']; ?>" >                     
                        </div></td>
                    </tr>
                    <tr align="left">
                      <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                    </tr>
                    <tr>
                      <td align="left" height="35"><div class="field password">
                            <label>Ngày sinh</label><?php 
                                    	$current_year = date("Y");
                                        $begin = $current_year-80;
                                        $end = $current_year-1;
                                    ; ?>
							<table cellspacing="0" cellpadding="0"><tr><td><script language="javascript">document.write(SetDay(1,31,0,'dob_d'));</script></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td><script language="javascript">document.write(SetMonth(1,12,0,'dob_m'));</script></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td><script language="javascript">document.write(SetYear(<?php echo $begin; ?>,<?php echo $end; ?>,0,'dob_y'));</script></td></tr></table>	
                        </div></td>
                    </tr>
                    <tr align="right">
                      <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                    </tr>
                    <tr>
                      <td align="left" height="35"><div class="field password">
                            <label>Giới tính</label>
							<select id="gender" name="gender" class="f-input" require="true" datatype="require"><option value="">---Chọn---</option><?php echo Utility::Option($option_gender, ''); ?></select><script type="text/javascript">$("#gender").val("<?php echo $_SESSION['GOOGLE_USER_LOGIN']['gender']; ?>")</script>
                        </div></td>
                    </tr>
                    <tr align="right">
                      <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                    </tr>
                    <tr>
                      <td align="left" height="35" style="padding-left:40px;"><div class="city">
							<label>&nbsp;</label>
							<input id="enter-address-commit" type="submit" class="formbutton" name="registergoogle" value="Submit" />
						</div></td>
                    </tr>
                  </tbody>
                </table></form>
              </td>
              <td style="background: url(&quot;/static/css/images/faqbox_rightbg.gif&quot;) repeat-y scroll right center transparent;">&nbsp;</td>
            </tr>
            <tr>
              <td><img src="/static/css/images/faqbox_bottomleft.gif" alt="" width="24" border="0" height="21"></td>
              <td style="background: url(&quot;/static/css/images/faqbox_bottombg.gif&quot;) repeat-x scroll 0% 0% transparent;"></td>
              <td><img src="/static/css/images/faqbox_bottomright.gif" alt="" width="23" border="0" height="21"></td>
            </tr>
          </tbody>
        </table></td><td width="30%" align="left" valign="top" style="padding-left:7px;padding-top:20px;"><div id="sidebar">
                          <?php include template("block_side_support");?>
                        </div></td></tr></table></div></div></div>
	</div>
</div>

</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("footer");?>
