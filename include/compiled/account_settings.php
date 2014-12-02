<?php include template("header");?>
<?php  
$uri =  $_SERVER['REQUEST_URI'];

?>
<script type="text/javascript" src="/static/js/datepicker/WdatePicker.js"></script>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="settings">
<?php  	/*  <div class="subdashboard" id="dashboard">
		<ul><?php echo current_account('/account/settings.php'); ?></ul>
	</div>  */ ?>
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
    <div id="contentfontend" class="mainwide clear settings-box">
		<div class="box clear">
        <table width="100%" style="margin-top:8px;">
        	<tr>
            	<td valign="top" style="width:230px;">
                	<?php // include template("thongtinhuuich");?>
                	 <?php include template("menutaikhoan");?>
                    
                </td>
                <td valign="top">
                	<div class="atbox-setting">
                    	<h2 class="title_info_setting">Thông tin cá nhân</h2>
                        <div class="box_form_setting">
                        	<form id="settings-form" method="post" action="/account/settings.php" enctype="multipart/form-data" class="validator">
                            <div class="box_title_info_clear">
                             <h3>1. Thông tin cơ bản</h3>
                             </div>
                             <div class="boxsubinfo">
                             	<table width="100%">
                                 <tr>
                                      <td align="left" height="35"><div class="field email">
                                        <label>Email</label>
                                        <input type="text" size="30" name="email" id="settings-email-address" class="f-input <?php echo $readonly['email']; ?>" <?php echo $readonly['email']; ?> value="<?php echo $login_user['email']; ?>" />
                                    </div>
                                    </td>
                                    </tr>
                                  <tr>
                                      <td align="left" height="35"><div class="field password">
                                        <label>Đổi mật khẩu</label>
                                        <input type="password" size="30" name="password" id="settings-password" class="f-input" />
                                        <div style="clear:both; margin-left:110px;" class="hint">Để trống nếu không muốn thay đổi.</div>
                                    </div>
                                    </td>
                                    </tr>
                                 
                                    <tr>
                                      <td align="left" height="35"><div class="field password">
                                        <label>Xác nhận MK</label>
                                        <input type="password" size="30" name="password2" id="settings-password-confirm" class="f-input" />
                                    </div></td>
                                    </tr>
                                   
                                    <tr>
                                      <td align="left" height="35"><div class="field password">
                            <label>Ngày sinh</label><?php $current_year = date("Y");
                                            $begin = $current_year-80;
                                            $end = $current_year-1;list($year, $month, $day) = split('[-]', $login_user['dob']);; ?>
							<table cellspacing="0" cellpadding="0"><tr><td><script language="javascript">document.write(SetDay(1,31,<?php echo $day; ?>,'dob_d'));</script></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td><script language="javascript">document.write(SetMonth(1,12,<?php echo $month; ?>,'dob_m'));</script></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td><script language="javascript">document.write(SetYear(<?php echo $begin; ?>,<?php echo $end; ?>,<?php echo $year; ?>,'dob_y'));</script></td></tr></table>	
                        </div>
                        </td>
                                    </tr>
                                   
                                    <tr>
                                      <td align="left" height="35"><div class="field password">
                            <label>Giới tính</label>
							<select name="gender" class="f-input" require="true" datatype="require"><option value="">---Chọn---</option><?php echo Utility::Option($option_gender, $login_user['gender']); ?></select>
                        </div>
                        </td>
                                    </tr>
                                    <tr><td align="left" height="35"><div class="field"><label>Hình (Avatar)</label><input type="file" size="40" name="upload_image" id="settings-avatar" class="f-input" />&nbsp;<div style="clear:both; margin-left:110px; white-space:nowrap" class="hint"><?php if($login_user['avatar']){?><img align="left" src="<?php echo user_image($login_user['avatar']); ?>" style="float:left;margin-top:0px;margin-right:10px;"/><?php }?>Vui lòng upload tập tin hình ảnh có dung lượng < 512kb </div></div></td></tr>
                                </table>
                             </div>
                             
                             <div class="box_title_info_clear">
                             <h3>2. Thông tin giao hàng</h3>
                             </div>
                             <div class="boxsubinfo">
                             <table width="100%">
                             	<tr>
                                      <td align="left" height="35">
                                      	<div class="field username">
                                            <label>Họ tên</label>
                                            <input type="text" size="30" name="realname" id="settings-realname" class="f-input" value="<?php echo $login_user['realname']; ?>" />
                                        </div>
                        			</td></tr>
                                    <tr>
                                      <td align="left" height="35">
                                        <!--<script src="/static/js/jchain.js" type="text/javascript"></script>-->
                                         <script>						                
                                            jQuery(document).ready(function() {	
                                                //$("#dist_id").chained("#city_id"); 
                                                //$("#ward_id").chained("#dist_id");
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
												
												
												$("#settings-street-name").autocomplete('/team/search_address_list.php',{width: 350});	

                                            });                                            
                                        </script>

                                        <div class="field city">
                                            <label>Thành phố</label>
                                            <select name="city_id" id="city_id" class="f-input"><?php echo Utility::Option(Utility::OptionArray($allcities, 'id', 'name'), $login_user['city_id']); ?></select>
                                        </div>
                        			</td></tr>
                                    <tr>
                                      <td align="left" height="35">
                                      	<div class="field">
                                        <label id="enter-address-dist-label" for="signup-dist">Quận/Huyện</label>
                                            <select name="dist_id" id="dist_id" class="f-input" style="width:100px" require="true" datatype="require">
                                            <option value="">---Chọn---</option>
                                            <?php echo optiondistrict($login_user['dist_id'],$login_user['city_id']); ?></select>
                                        </div>
                        			</td></tr>
                                    
                                    <tr>
                                      <td align="left" height="35">
                                      	<div class="field">
                                        <label id="enter-address-ward-label" for="ward-dist">Phường/Xã</label>
                                        <select name="ward_id" id="ward_id"  class="f-input" style="width:150px" require="false" datatype="require"><option value="">---Chọn---</option><?php echo optionward($login_user['ward_id'],$login_user['dist_id']); ?></select></div> 
                        			</td></tr>
                                    
                                    <tr><td align="left" height="35">
                                      	<div class="field">
                                            <label>Địa chỉ</label>
                                            <input type="text" name="address" id="settings-address" readonly="readonly" class="f-input" value="<?php echo $login_user['address']; ?>" />
                                        </div>
                        			</td></tr>
                                    <tr><td align="left" height="35">
                                      	<div class="field username">
                                            <label>Số nhà</label>
                                            <input type="text" style="width:100px" name="house_number" id="settings-house-number" class="f-input" value="<?php echo $login_user['house_number']; ?>" />
                                        </div>
                        			</td></tr>
                                    <tr><td align="left" height="35">
                                      	<div class="field username">
                                            <label>Tên đường</label>
                                            <input type="text" style="width:200px"  autocomplete="off" name="street_name" id="settings-street-name" class="f-input" value="<?php echo $login_user['street_name']; ?>" />
                                        </div>
                        			</td></tr>
                                    <tr><td align="left" height="35">
                                      	<div class="field">
                                        <label>Phòng-tòa nhà</label>
                                        <input type="text" name="note_address" value="<?php echo $login_user['note_address']; ?>" id="settings-note-address" class="f-input" />
                                            <div style="clear:both; margin-left:110px;" class="hint">Ví dụ: P907, Lầu 9, Cao ốc Diamond Plaza</span>
                                        </div>
                        			</td></tr>
                                    <tr><td align="left" height="35">
                                        <div class="field mobile">
                                            <label>Di động</label>
                                            <input type="text" size="30" name="mobile" id="settings-mobile" class="number" value="<?php echo $login_user['mobile']; ?>" datatype="mobile|ajax" url="<?php echo $WEB_ROOT; ?>/ajax/validator.php" vname="signupmobile"  msg="Incorrect mobile number|The number has been registered" style="width:250px; font-size:16px; font-weight:bold" />
                                        </div>
                        			</td>
                             </table>
                             </div>
                                 <div style="margin-top: 25px;margin-bottom: 50px;padding-left: 226px;">
                                 	<input type="image" src="/static/img/btn-capnhat.png" alt="cap nhat" />
                                 </div>
                             </form>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        
            
        </div>
    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("footer");?>
