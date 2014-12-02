<?php include template("header");?>
<style>
.atbreadcrum a{color:#64a64e;}
.atbreadcrum a:hover{color:#000;}
.atfiled{width: 344px;height: 40px;border: 1px solid #b5b5b5;border-radius: 6px;box-shadow: 0px 0px 1px;font-size: 20px;color: #5b5b5b;padding-left: 10px;}
.atboxlogin label{font-weight: bold;padding-top: 6px !important;text-align: left !important;color: #757374 !important;display: inline-block;}

.hint{
font-style: italic; 
font-size:90%;
}
.atsingupbox  label{text-align:left !important;}
.atsingupbox .field{width:100% !important;}
.atsingupbox .hint{display:block;padding-left: 124px; clear:both;}
#deal-buy-login-form p{ padding-bottom:10px;}
</style>
<div id="atbreadcrum">
	 <div class="atbreadcrum" style="margin-left: 260px;margin-top: -22px; color:#64a64e;" >
     	<a href="/<?php  echo $city['slug']; ?>">Khuyến mãi </a>
        > <a style="color:#000;">Đăng nhập - Đăng kí</a>
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
          <div class="subbox-content" style="background:none; border: 1px solid #5f6058;margin: 10px 0px;">
            <div class="sect" style="background-color:#FFFFFF">
              <div align="left" style="padding:20px; padding-top:10px;"><div style="font-size:17px;padding-bottom:10px">
               <h2 style="border-bottom: 2px solid #bebebe;color: #000;padding-bottom: 11px;font-size: 20px;">Vui lòng đăng nhập hoặc đăng ký</h2>
            </div>
               
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:50px;">
                    <tr>
                      <td align="left" valign="top" width="50%" style="width: 630px;border-right: 1px solid #cdcdcd;">
                      	<div class="atsingupbox">
                            <form action="/account/signup.php" method="post" id="deal-buy-form-signup" class="validator" onsubmit="return check_submit();">
                            	<div class="atsingupbox" style="border: 1px solid #9d999a;padding: 12px;width: 93%;">
                                <table class="" width="100%">
                                    <tbody>
                                    	<tr>
                              <td align="left" height="35"><div class="field email" style="width:420px;">
                                        <label for="signup-email-address">Email</label>
                                        <input type="text" class="f-input"  name="email" id="signup-email-address" require="true" datatype="email|ajax" msg="|" url="<?php echo WEB_ROOT; ?>/ajax/validator.php" vname="signupemail" style="width:300px;" /><span class="hint">Để đăng nhập và tìm lại mật khẩu.</span>
                                    </div></td>
                            </tr>
                            <tr>
                              <td align="left" height="35"><div class="field password" style="width:420px;">
                                        <label for="signup-password">Mật khẩu</label>
                                        <input type="password" size="20" name="password" id="signup-password" class="f-input" datatype="require" require="true" style="width:300px;" /> 
                                        <span class="hint">Mật khẩu ít nhất 6 ký tự</span>
                                    </div></td>
                            </tr>
                            <tr>
                              <td align="left" height="35"><div class="field password" style="width:420px;">
                                        <label for="signup-password-confirm">Xác nhận MK</label> 
                                        <input type="password" size="20" name="password2" id="signup-password-confirm" class="f-input" require="true" datatype="compare" compare="signup-password" style="width:300px;" />
                                    </div></td>
                            </tr>
                            <tr>
                              <td align="left" height="35"><div class="field password">
                                            <label>Ngày sinh</label>
                                            <table cellspacing="0" cellpadding="0"><tr><td style="padding-top:7px;"><script language="javascript">document.write(SetDay(1,31,0,'dob_d'));</script></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td style="padding-top:7px"><script language="javascript">document.write(SetMonth(1,12,0,'dob_m'));</script></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td style="padding-top:7px"><?php $current_year = date("Y");$begin = $current_year-80;$end = $current_year-1;; ?><script language="javascript">document.write(SetYear(<?php echo $begin; ?>,<?php echo $end; ?>,0,'dob_y'));</script></td><td><span style="color:#C40000">*</span></td></tr></table>	
                                        </div></td>
                            </tr>
                            <tr>
                              <td align="left" height="35"><div class="field password" style="width:100%">
                                            <label>Giới tính</label>
                                            <select name="gender" class="f-input" require="true" datatype="require"><option value="">---Chọn---</option><?php echo Utility::Option($option_gender, ''); ?></select>
                                        </div></td>
                            </tr>
                                    </tbody>
                                </table>
                                </div>
                                
                                <div class="atsingupbox" style="border: 1px solid #9d999a;padding: 12px;width: 93%;margin-top:15px;">
                         	<h3 style="font-size: 16px;color: #666666;">Thông tin giao hàng</h3>
                            	 <table class="" width="100%">
                                    <tbody>
                                    	 <tr>
                                            <td align="left" height="35"><div class="field">
                                                    <label>Họ tên</label>
                                                    <input type="text" size="20" name="realname" id="settings-realname" class="f-input" require="true" datatype="require" style="width:300px;" />                      
                                                </div></td>
                                          </tr>
                                          <tr>
    <td align="left" height="35">
    <link rel="stylesheet" type="text/css" href="/static/css/jquery.autocomplete.css" />
	<script type='text/javascript' src="/static/js/jquery.autocomplete.js"></script>
    <!--<script src="/static/js/jchain.js" type="text/javascript"></script>-->
    <script type="text/javascript">
            var dist_id; var ward_id;
            function getDistId(){
                return $("#dist_id").val();
            }
            function getWardId(){
                return $("#ward_id").val();
            }
            jQuery(document).ready(function() {	
				var opt = '<option value=0>--Chọn--</option>';
				$('#city_id').change(function() {	
									
					$.get('/ajax/city.php?city_id='+$("#city_id").val(), function(ret) {					 		 
					  $('#dist_id').empty().append(opt+ret);
					  $('#ward_id').empty();
					});
				});
				$('#dist_id').change(function() {
					$.get('/ajax/city.php?dist_id='+$("#dist_id").val(), function(ret) {					 
					  $('#ward_id').empty().append(opt+ret);	
					});
				});
            });		     
            function searchSuggest(){
                dist_id = getDistId();
                ward_id = getWardId();
                $("#settings-address").autocomplete('/team/search_address_list.php',{width: 308});
            }
        </script>
    
    <div class="field">
        <label id="enter-address-city-label" for="signup-city">Tỉnh/thành</label>
        <select name="city_id" id="city_id"  class="f-city" require="true" datatype="require" style="width:180px">
          <option value="">---Chọn---</option>         
          <?php echo Utility::Option(Utility::OptionArray($allcities,'id','name'),$city['id']); ?>
        </select>
      </div></td>
    </tr>
    <tr>
      <td align="left" height="35"><div class="field">                                    
          <label id="enter-address-dist-label" for="signup-dist">Quận/Huyện</label>
          <select name="dist_id" id="dist_id" class="f-city" require="true" datatype="require">
            <option value="">---Chọn---</option>
              <?php echo optiondistrict(1, $city['id']); ?>
          </select>
        </div></td>
    </tr>
     <tr>
        <td align="left" height="35"><div class="field">
            <label  id="enter-address-ward-label" for="ward-dist">Phường/Xã</label>
            <select name="ward_id" id="ward_id" class="f-city" require="false" datatype="require">
              <option value="">---Chọn---</option>		                                 
            </select>
          </div></td>
      </tr>
      <tr>
                                <td align="left" height="35"><div class="field">
                                        <label>Số nhà</label>
                                        <input type="text" name="house_number" autocomplete="off" id="settings-house-number" class="f-input" style="width:100px" require="true" value="" datatype="require" /></div>
                                 </td></tr>
                                 <tr>
                                <td align="left" height="35">
                                 
                                 <div class="field"><label>Tên đường</label><input type="text" name="street_name" class="f-input" autocomplete="off" onfocus="searchSuggest()" id="settings-street-name" require="true" value="" datatype="require" style="width:300px;" />
                                    </div></td>
                              </tr>
                               <tr>
                                <td align="left" height="35"><div class="field" style="width:420px;">
                                        <label>Phòng-toà nhà</label>
                                        <input type="text" name="note_address" id="settings-note-address" class="f-input" style="width:300px;" /><br />

                                        <span class="hint" style="clear:both">Ví dụ: P207, Lầu 3, Cao Ốc Diamond Plaza</span>
                                    </div></td>
                              </tr>
                               <tr>
                                <td align="left" height="35"><div class="field" style="width:440px;">
                                        <label for="signup-password-confirm">Di động</label>
                                        <input type="text" class="f-input number" size="20" name="mobile" id="signup-mobile" require="<?php echo option_yes('needmobile')?'true':'require'; ?>" datatype="mobile"  style="width:300px;" /><br />
<span class="hint" style="clear:both">Số ĐTDĐ được dùng để liên lạc khi giao hàng.</span>
                                    </div></td>
                              </tr>
    
                                    	
                                    </tbody>
                                 </table>
                            	
                            </div>
                            
                            <div class="boxbuttoncss" align="center" style="margin-top:28px;margin-left: 120px;">
                                        <button class="buttoncss">Đăng Ký</button>
                         </div>
                            
                            </form>
                        </div>
                      </td>
                      <td width="40%" style="text-align:center; padding-top:6%;" valign="top">
                        
                        <?php   /*  <div id="signup" style="display:none;">
                            <div id="deal-buy-login2">
                                <h3 style="margin-bottom: 15px;">Đã có tài khoản trên <?php echo $INI['system']['abbreviation']; ?></h3>
                                        <script type="text/javascript" language="javascript">
                                            function check_submit(){
                                                var year = document.getElementById("dob_y").value;
                                                if(year==""){
                                                    alert("Vui lòng nhập đầy đủ các thông tin yêu cầu");
                                                    return false;
                                                }
                                                return true;
                                            }
                                        </script>
                                <form action="/account/login.php" method="post" id="deal-buy-form-login" class="validator">
                                <div id="deal-buy-login-form">
                                    <p><span>Email</span><input type="text" class="f-input" id="deal-buy-email" name="email" style="width:200px" size="30" require="true" datatype="require|limit" min="2" /></p>
                                    <p><span>Mật khẩu</span><input type="password" class="f-input" name="password" size="30" style="width:200px" datatype="require" require="true" /></p>
                                    <p><span>&nbsp;</span><input type="checkbox" value="1" name="auto-login" id="autologin" class="f-check" checked />&nbsp;<label for="autologin">Tự động đăng nhập</label></p>
                                    <p class="act"><input type="submit"  class="formbutton" name="login" value="Đăng nhập"/></p>
                                </div>
                                </form>
                            </div>
                        </div>  */ ?>
                         <h2 style="font-size:15px; margin-bottom:17px;">Bạn đã là thành viên?</h2>
                         
                          
                           <a href="/account/login.php" style="font-size: 16px;color: #FFFFFF;display: block;padding-left: 6px;width: 170px;margin: 0px auto;" class="boxbuttoncss">
                                        <div class="buttoncss" style="line-height: 2.5;">Đăng Nhập</div>
                          </a>
                        </td>
                    </tr>
                  </table>
               
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
