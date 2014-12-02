<?php include template("header");?>
<style>
.atbreadcrum a{color:#64a64e;}
.atbreadcrum a:hover{color:#000;}

</style>
<div id="atbreadcrum">
	 <div class="atbreadcrum" style="margin-left: 260px;margin-top: -22px; color:#64a64e;" >
     	<a href="/<?php  echo $city['slug']; ?>">Khuyến mãi </a>
        > <a style="color:#000;">Đăng ký</a>
     </div>

</div>
<style>
.hint{
font-style: italic; 
font-size:90%;
}
.atsingupbox  label{text-align:left !important;}
</style>
<div id="bdw" class="bdw">
  <div id="bd" class="cf">
    <div id="signup">
    <?php  	/*  <div class="dashboard" id="dashboard">
        <ul>
          <?php echo current_frontend(); ?>
        </ul>
      </div>  */ ?>
	</div>
      <div id="contentfontend" class="mainwide">
        <div class="box clear">
          <div class="subbox-content" style="background: none;border: 1px solid #e3e3e3;margin: 10px 0px;box-shadow: 1px 1px 2px;">
            <div style="background-color:#FFFFFF;">
              <script type="text/javascript" language="javascript">
							function CheckSubmit(){
								var year = document.getElementById("dob_y").value;
								if(year==''){
									alert("Vui lòng nhập đầy đủ và chính xác các thông tin yêu cầu\r\nvào các ô nhập bị viền đỏ");
									return false;
								}
								return true;
							}</script>
                            
              <div align="left" style="padding:20px;padding-top:10px"><div style="font-size:17px;padding-bottom:10px">
              <h2 style="border-bottom: 2px solid #bebebe;color: #000;padding-bottom: 11px;font-size: 20px;">ĐĂNG KÝ TÀI KHOẢN</h2>
              <?php  /*  <h2 style="margin-left:5px;">Đăng ký tài khoản <?php echo $INI['system']['abbreviation']; ?><span>&nbsp;hoặc <a href="/account/login.php">Đăng nhập</a></span></h2>  */ ?>
            </div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="left" valign="top" style="width: 630px;border-right: 1px solid #cdcdcd;">
                    	<form id="signup-user-form" name="signup-user-form" method="post" action="/account/signup.php" class="validator" onsubmit="return CheckSubmit();">
                        <div class="atsingupbox" style="border: 1px solid #9d999a;padding: 12px;width: 93%;">
                        	<table>
                            <tbody>
                              <tr>
                                <td align="left" height="35"><div class="field email">
                                    <label for="signup-email-address">Email</label>
                                    <input type="text" size="30" name="email" id="signup-email-address" class="f-input" value="<?php echo $_POST['email']; ?>" require="true" datatype="email|ajax" url="<?php echo WEB_ROOT; ?>/ajax/validator.php" vname="signupemail" msg="Email incorrect format | Email has already been registered" />
                                  
                                    <div class="hint">Dùng để gửi mail xác nhận đăng kí.</div></div></td>
                              </tr>
                        
                              <tr>
                                <td align="left" height="35"><div class="field password">
                                    <label for="signup-password">Mật khẩu</label>
                                    <input type="password" size="30" name="password" id="signup-password" class="f-input" require="true" datatype="require" />
                                    <div class="hint">Mật khẩu bao gồm ít nhất 6 ký tự</div> </div></td>
                              </tr>
                         
                              <tr>
                                <td><div class="field password">
                                    <label for="signup-password-confirm">Xác nhận MK</label>
                                    <input type="password" size="30" name="password2" id="signup-password-confirm" class="f-input" require="true" datatype="compare" compare="signup-password" />
                                  </div></td>
                              </tr>
                           
                              <tr>
                                <td align="left" height="35"><div class="field password">
                                    
                                    <table cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td><label>Ngày sinh</label>
                                    <?php 
                                    	$current_year = date("Y");
                                        $begin = $current_year-80;
                                        $end = $current_year-1;
                                    ; ?></td>
                                        <td style="padding-top:6px;"><script language="javascript">document.write(SetDay(1,31,0,'dob_d'));</script></td>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td style="padding-top:6px;"><script language="javascript">document.write(SetMonth(1,12,0,'dob_m'));</script></td>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td style="padding-top:6px;"><script language="javascript">document.write(SetYear(<?php echo $begin; ?>,<?php echo $end; ?>,0,'dob_y'));</script>
                                        
                                        </td>
                                      </tr>
                                    </table>
                                    <div class="hint">dd/mm/yyyy - ngày / tháng / năm</div>                                    
                                </div></td>
                              </tr>
                         
                              <tr>
                                <td align="left" height="35"><div class="field password">
                                    <label>Giới tính</label>
                                    <select name="gender" class="f-input" require="true" datatype="require">
                                      <option value="">---Chọn---</option>
                                    <?php echo Utility::Option($option_gender, ''); ?>
                                    </select>
                                  </div></td>
                              </tr>
                            </tbody>
                            </table>
                        </div>
                        
                         <div class="atsingupbox" style="border: 1px solid #9d999a;padding: 12px;width: 93%;margin-top:15px;">
                         	<h3 style="font-size: 16px;color: #666666;">Thông tin giao hàng</h3>
                         	<table>
                            <tbody>
                              <tr>
                                <td align="left" height="35"><div class="field">
                                        <label>Họ tên</label>
                                        <input type="text" size="20" name="realname" id="settings-realname" class="f-input" require="true" datatype="require" />                      
                                    </div></td>
                              </tr>
                               <tr>
    <td align="left" height="35">
    <link rel="stylesheet" type="text/css" href="/static/css/jquery.autocomplete.css" />
	<script type='text/javascript' src="/static/js/jquery.autocomplete.js"></script>
   <!-- <script src="/static/js/jchain.js" type="text/javascript"></script>-->
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
                                    <input type="text" name="house_number" autocomplete="off" id="settings-house-number" class="f-input" style="width:100px" require="true" value="" datatype="require" />
                                  </div></td>
                              </tr>
                              <tr>
                                <td height="45" align="left"><div class="field">
                                    <label>Tên đường </label>
                                    <input type="text" name="street_name" autocomplete="off" class="f-input" id="settings-street-name" require="true" value="" datatype="require" />
                                    <div class="hint">Vui lòng ghi rõ ràng tên đường có dấu</span> </div></td>
                              </tr>
                              <tr>
                                <td height="45"><div class="field">
                                    <label>Phòng-toà nhà</label>
                                    <input type="text" name="note_address" id="settings-note-address" class="f-input" size="30" />
                                    <div class="hint">Ví dụ: P907, Lầu 9, Cao Ốc Diamond Plaza</div></div></td>
                              </tr>
                              <tr>
                                <td height="45"><div class="field">
                                    <label>Di động</label>
                                    <input type="text" class="f-input" size="30" name="mobile" id="signup-mobile" require="true" datatype="require" />
                                    <div class="hint">Số ĐTDĐ dùng để liên lạc khi giao hàng, vui lòng nhập chữ số viết liền</div> </div></td>
                              </tr>
                              <tr>
                                <td height="45"><div class="field subscribe" style="margin-left:125px;width:200px"><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"><input tabindex="3" type="checkbox" value="1" name="subscribe" id="subscribe" class="f-check" checked="checked" /></td>
    <td align="left"><label for="subscribe">Đăng ký nhận deal hàng ngày</label></td>
  </tr>
</table></div></td>
                              </tr>
                            </tbody>
                            </table>
                         </div>
         
                        <div class="boxbuttoncss" align="center" style="margin-top:28px;margin-left: 162px;">
                                        <button class="buttoncss">Đăng Ký</button>
                         </div>
                        </form>
                    </td>
                    <td align="center" valign="top" style="text-align:center;padding-top: 16%;">

                          <?php //include template("block_side_support");?>
                          <h2 style="font-size:15px; margin-bottom:17px;">Bạn đã là thành viên?</h2>
						  <div></div>
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