<?php include template("header");?>

<style>
.infotitle{background: #f8f8f8;
  background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#f4f4f4), to(#fcfcfc));
  background: -webkit-linear-gradient(top, #fcfcfc, #f4f4f4);
  background: -moz-linear-gradient(top, #fcfcfc, #f4f4f4);
  background: -ms-linear-gradient(top, #fcfcfc, #f4f4f4);
  background: -o-linear-gradient(top, #fcfcfc, #f4f4f4);
height: 43px;
color: #000;
font-weight: bold;
padding-left: 14px;
line-height: 38px;}

.atbox-setting{margin-top: 0px;margin-left: 39px;width: 84%;}
.title_info_setting{font-size: 19px;color: #8bcf06;border-bottom: 1px solid #ccc;padding-bottom:10px;}
.boxsubinfo{border: 1px solid #9e9a9b;padding: 10px;}
.box_title_info_clear{margin-top: 10px;margin-bottom: 8px;}
.boxsubinfo label{text-align:left !important;}

</style>
<div id="bdw" class="bdw">
  <div id="bd" class="cf">
    <div id="learn">
      <div class="subdashboard" id="dashboard">
        <ul>
        
        </ul>
      </div>
      <div id="content" class="mainwide">
        <div class="box">
        <table width="100%" style="margin-top:8px; margin-bottom:20px;">
        	<tr>
            	<td valign="top" style="width:230px;">
                	
                     <?php include template("thongtinhuuich");?>
                    <?php include template("menu-gioithieu");?>
                </td>
                <td valign="top">
                	<div class="atbox-setting">
                    	<h2 class="title_info_setting">Bạn đã đăng ký thành công.</h2>
                        <div class="box_form_setting boxsubinfo" style="margin-top: 13px;">
                        <div class="sect">
                            <h3 class="notice-title">Vui lòng xác nhận Email của bạn</h3>
                            <div class="notice-content">
                                <p>Hệ thống đã gởi mail xác nhận đến địa chỉ email <strong><?php echo $email; ?></strong>.
                                <br />Vui lòng kiểm tra mail và nhấn vào liên kết xác nhận email.</p>
                            <?php if($wwwlink){?>
                                <p class="signup-gotoverify"><a href="<?php echo $wwwlink; ?>" target="_blank"><img src="/static/img/signup-email-link.gif" align="absmiddle">Kiểm tra email và kích hoạt tài khoản</a></p>
                            <?php }?>
                                </div>
                            <div class="help-tip">
                                <h3 class="help-title">Bạn chưa nhận được mail?</h3>
                                <ul class="help-list">
                                    <li>Thử kiểm tra trong thư mục Spam mail xem.</li>
                                    <li><a href="/account/verify.php?email=<?php echo urlEncode($email); ?>">Nhấn vào đây</a> để gởi lại mail xác nhận.</li>
                                </ul>
                            </div>
                        </div>
            </div>
                    </div>
           		</td>
            </tr>
            </table>    
        
          
          <div class="box-bottom"></div>
        </div>
      </div>
    </div>
  </div>
  <!-- bd end -->
</div>
<!-- bdw end -->
<?php include template("footer");?>