<?php include template("header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
  <div id="feedback">
    <div class="subdashboard" id="dashboard">
      <ul>
        <li class="current">&nbsp;<a href="#">Cảm nhận về Dealsoc</a><span></span></li>
      </ul>
    </div>
    <div id="contentfontend" class="mainwide clear">
      <div class="box">
        <div class="subbox-content">
          <div style="background-color:#FFFFFF">
            <div align="left" style="padding:10px; min-height:530px;_min-height:530px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td width="24"><img src="/static/css/images/faqbox_topleft.gif" width="24" height="20"></td>
                    <td style="background: url(&quot;/static/css/images/faqbox_topbg.gif&quot;) repeat-x scroll 0% 0% transparent;"></td>
                    <td width="23"><img src="/static/css/images/faqbox_topright.gif" width="23" height="20"></td>
                  </tr>
                  <tr>
                    <td style="background: url(&quot;/static/css/images/faqbox_leftbg.gif&quot;) repeat-y scroll right center transparent;">&nbsp;</td>
                    <td bgcolor="#f1f1f1"><div align="left">
                        <p class="notice">Các trường có dấu <span style="color:#F00">*</span> là bắt buộc</p>
                        <form id="comment-user-form" method="post" action="/about/comment.php" class="validator">
                          <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                              <tr>
                                <td align="left" height="35"><div class="field fullname">
                                    <label for="feedback-fullname">Họ Tên</label>
                                    <input type="text" size="30" name="fullname" id="commnet-fullname" class="f-input" value="<?php echo $realname; ?>" require="true" datatype="require" />
                                    <span class="hint" style="color:#FF0000">*</span></div></td>
                              </tr>
                              <tr align="left">
                                <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                              </tr>
                              <tr>
                                <td align="left" height="35"><div class="field email">
                                    <label for="feedback-email-address">Email</label>
                                    <input type="text" size="30" name="email" id="comment-email" class="f-input" value="<?php echo $email; ?>" require="true" datatype="require" />
                                    <span class="hint" style="color:#FF0000">*</span> </div></td>
                              </tr>
                              <tr align="left">
                                <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                              </tr>
                              <tr>
                                <td align="left" height="35"><div class="field email">
                                    <label for="feedback-email-address">Số ĐT</label>
                                    <input type="text" size="30" name="mobile" id="comment-mobile" class="f-input" value="<?php echo $mobile; ?>" require="true" datatype="require" />
                                    <span class="hint" style="color:#FF0000">*</span></div></td>
                              </tr>
                              <tr align="left">
                                <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                              </tr>
                              <tr>
                                <td align="left" height="35"><div class="field suggest" style="width:600px">
                                    <label for="feedback-suggest">Nội dung </label>
                                    <textarea cols="30" rows="5" name="content" id="feedback-suggest" class="f-textarea" style="width:400px" require="true" datatype="require"><?php echo $content; ?></textarea>
                                    <span class="hint" style="color:#FF0000">*</span></div></td>
                              </tr>
                              <tr align="left">
                                <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                              </tr>
                              <tr>
                                <td align="left" height="35"><div class="field suggest" style="width:600px">
                                    <label for="feedback-suggest">Mã xác nhận</label>
                                    <input id="smssub-dialog-input-verifycode" type="text" name="captchacode" style="text-transform:uppercase;" class="f-input" maxLength="6" require="true" datatype="require" /><span style="margin-top:7px;">&nbsp;<img id="img-captcha-id" src="/captcha/codeimg.php" align="absmiddle" /></span><span class="hint" style="color:#FF0000">*</span> <?php if($err){?>
                        <div style="color:red; clear:both; padding-left:120px;">Mã xác nhận bạn nhập không đúng</div>
                        <?php }?></div></td>
                              </tr>
                              <tr>
                                <td align="left" height="35"><div class="act" style="padding-left:110px; padding-top:10px; padding-bottom:10px">
                                    <input type="submit" value="  Gửi  " name="commit" id="feedback-submit" style="padding:7px;" class="formbutton"/>
                                  </div></td>
                              </tr>
                              <tr align="left">
                                <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                              </tr>
                            </tbody>
                          </table>
                        </form>
                      </div>
                      <div align="left">
                      <?php if(count($comment)==0){?>
                      Hiện tại chưa có cảm nhận nào. Hãy là người đầu tiên viết cảm nhận cho công ty này.
					  <?php } else { ?>	
                      <table width="100%" border="0">
                          <?php if(is_array($comment)){foreach($comment AS $index=>$one) { ?>
                                 <tr>
                                    <td width="2%" align="left" valign="top" style="padding-bottom:10px; padding-top:10px"><div align="left" style="border:#666666 1 px solid; padding:2px; background-color:#FFFFFF"><img width='50' height='50' src="<?php echo user_image($users[$one['user_id']]['avatar']); ?>" /></div></td>
                                    <td width="98%" align="left" valign="top" style="padding-left:10px; padding-bottom:10px; padding-top:10px;">
                                        <div align="left" style="float:left; width:300px; color:#000099; font-size:120%"><strong><?php echo $one['fullname']; ?></strong></div><div align="right" style="font-size:11px; color:#999999"><?php echo date('d-m-Y H:i:s', strtotime($one['date_created'])); ?></div>
                                        <div align="justify" style="clear:both"><?php echo $one['content']; ?></div>
                                    </td>
                                  </tr><tr align="left">
                                <td colspan="2" style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                              </tr>
                          <?php }}?>
                      </table><?php }?>
                      </div></td>
                    <td style="background: url(&quot;/static/css/images/faqbox_rightbg.gif&quot;) repeat-y scroll right center transparent;">&nbsp;</td>
                  </tr>
                  <tr>
                    <td><img src="/static/css/images/faqbox_bottomleft.gif" alt="" width="24" border="0" height="21"></td>
                    <td style="background: url(&quot;/static/css/images/faqbox_bottombg.gif&quot;) repeat-x scroll 0% 0% transparent;"></td>
                    <td><img src="/static/css/images/faqbox_bottomright.gif" alt="" width="23" border="0" height="21"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- bd end --> 
</div>
<!-- bdw end --> 
<?php include template("footer");?>