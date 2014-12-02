<?php include template("header");?>
<div id="checkout_box">
    <div class="atcheckout_box">
        <div class="checkout_title">
            <h2>Giỏ hàng</h2>
        </div>
        <div class="boxcart-checkout">
        	<table class="order-table">
              <tbody><tr>
                <th class="deal-buy-desc">No</th>
                <th class="deal-buy-desc">Deal</th>
                <th class="deal-buy-quantity">Số lượng</th>
                <th class="deal-buy-price">Đơn giá (<span class="money">đ</span>)</th>
                <th class="deal-buy-total">Thành tiền (<span class="money">đ</span>)</th>
              </tr>
              
            
             <?php   foreach($carts as $cart){ ?>
                <tr>
                <td align="right" class="deal-buy-desc">1</td>
                <td class="deal-buy-desc">
				<?php echo $cart['short_title']; ?>
                
				<?php echo showColorSize($cart); ?>
                </td>
                <td class="deal-buy-quantity" align="right">
                <?php  echo $cart['quantity']; ?>
                </td>
                <td class="deal-buy-price" align="right"><span id="deal-buy-price"><?php echo $cart['team_price']; ?></span></td>
                <td class="deal-buy-total" align="right" style="BORDER-RIGHT: #b1d1e6 1px solid;"><span id="deal-buy-total"><?php  echo $cart['quantity']*$cart['team_price']; ?></span>
                  </td>
              </tr>
            <?php   } ?>
              
            </tbody>
            </table>
        </div></br>
    	<div class="checkout_title">
            <h2>Thông tin mua hàng</h2>
        </div>
        <div class="atcheckbox_info">
<style>
.user_info_transfer{margin-bottom:28px;}
.attbform{margin: 10px 0px;}
.attbform tr td{}
.attbform tr td label{width: 119px;display: inline-block;text-align: right;padding-right: 12px;}
.attbform .hint{margin-left: 132px;padding: 5px;font-style: italic;color: rgb(184, 0, 0);font-size: 11px;}
.order_content_edit{display:none;}
.content_active .order_content_origin{display:none;}
.content_active .order_content_edit{display:block;}
.content_active .box_order_action{display:none;}
.content_hide .order_content_origin{display:none;}
.content_hide .order_content_edit{display:none;}
.content_hide .box_order_action{display:none;}
.line_info_user{margin-bottom: 7px;}
.line_info_user label{}
.line_info_user span{font-weight: bold;padding-left: 10px;}
</style>
		
        <?php if(!empty($login_user)): ?>
        	<div class="box_order">
            	<div class="box_information  order_step1">
                	<div class="title_step">1. Tài Khoản</div>
                    <div class="box_order_content">
                    	<div class="order_content_origin">
                        	<?php  echo $login_user['email']; ?>
                        </div>
                        <div class="order_content_edit">
                        	<div class="box_user_login" style="background:#FFF;">
                                <div class="box-user-form-login">
                                <form id="login-user-form" method="post" action="/account/login.php" class="validator">
                                    <table class="attbform">
                                        <tbody>
                                            <tr>
                                              <td align="left" height="35">
                                                <div class="field email" style="">
                                                  <label for="login-email-address">Email</label>
                                                  <input type="text" size="30" name="email" id="login-email-address" class="f-input" value="" require="true" datatype="require|limit" min="2" />
                                                </div></td>
                                            </tr>
                                            <tr>
                                              <td align="left" height="35"><div class="field password" style="">
                                                  <label for="login-password">Mật khẩu</label>
                                                  <input type="password" size="30" name="password" id="login-password" class="f-input" require="true" datatype="require" /></div></td>
                                            </tr>
                                            <tr>
                                              <td align="left" height="35" style="padding-left:80px;"><div class="field autologin" style="width:145px; white-space:nowrap"><table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><input style="margin-left:45px" type="checkbox" value="1" name="auto-login" id="autologin" class="f-check" checked /></td>
            <td><label for="autologin">Tự động đăng nhập</label></td>
          </tr>
        </table></div></td>
                                            </tr>
                                            <tr>
                                              <td align="left" height="35">
                                              <div class="act">
                                                  <input style="margin-left:130px" type="submit" value="Đăng nhập" name="commit" id="login-submit" class="formbutton"/>
                                                  <input style="margin-left:15px" type="button" value="Hủy"  id="cancle_changeuser" class="formbutton"/>
                                               </div>
                                                </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                        </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box_order_action">
                    	<a class="cur btn_changeact" id="change_user">Thay đổi</a>
                    </div>
                </div>
                	
                 <?php  /*  Begin Step 2  */ ?>   
                 <div class="box_information  order_step2">
                 <?php  
				 $uinfo = Session::Get('customerinfo');
				  ?>
                    <div class="title_step">2. Địa chỉ giao hàng</div>
                    <div class="box_order_content">
                        <div class="order_content_origin">
                            <div class="line_info_user">
                            	<label>Họ tên: </label> <span class="" id="atusernamerec"><?php  echo $uinfo['realname']; ?></span>
                            </div>
                            <div class="line_info_user">
                            	<label>Địa chỉ: </label> <span class="" id="atuseraddress">
								<?php  echo rtrim($uinfo['house_number'].','.$uinfo['street_name'].','.$uinfo['ward_name'].','.$uinfo['dist_name'].','.$uinfo['city_name']); ; ?></span>
                            </div>
                            <div class="line_info_user">
                            	<label>Điện thoại: </label> <span class="" id="atuserphone"><?php  echo $uinfo['mobile']; ?></span>
                            </div>
                        </div>
                        <div class="order_content_edit">
                                <div class="user_info_transfer">
                                	 <form id="fstep2" name="fstep2" action="/ajax/checkout.php" method="post" class="">
                                    <table width="100%" class="attbform">
                                    	 <tr>
                                            <td align="left" height="35"><div class="field">
                                                    <label>Họ tên</label>
                                                    <input type="text" size="20"  name="realname" value="<?php  echo isset($_POST['realname'])?$_POST['realname']:$login_user['realname']; ?>" id="settings-realname" class="f-input" required="true" />                      
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
														//
														$.get('/ajax/city.php?dist_id='+$("#dist_id").val() + '&ward_id=<?php echo $wardname['id']?>' , function(ret) {					 
                                                              $('#ward_id').empty().append(opt+ret);	
                                                            });
														//
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
                                                <?php echo optiondistrict( $dist['dist_id'], $city['id']); ?>
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
                                            <input type="text" name="house_number" autocomplete="off" id="settings-house-number" class="f-input" style="width:100px" require="true" value="<?php  echo isset($_POST['house_number'])?$_POST['house_number']:$login_user['house_number']; ?>" datatype="require" />
                                          </div></td>
                                      </tr>
                                      <tr>
                                        <td height="45" align="left"><div class="field">
                                            <label>Tên đường </label>
                                            <input type="text" name="street_name" autocomplete="off" class="f-input" id="settings-street-name" require="true" value="<?php  echo isset($_POST['street_name'])?$_POST['street_name']:$login_user['street_name']; ?>" datatype="require" />
                                           </div></td>
                                      </tr>
                                      <tr>
                                        <td height="45"><div class="field">
                                            <label>Phòng-lầu-tòa nhà</label>
                                            <input type="text" name="note_address" value="<?php  echo isset($_POST['note_address'])?$_POST['note_address']:$login_user['note_address']; ?>" id="settings-note-address" class="f-input" size="30" />
                                            </div></td>
                                      </tr>
                                      <tr>
                                        <td height="45"><div class="field">
                                            <label>Di động</label>
                                            <input type="text" class="f-input" size="30" value="<?php  echo isset($_POST['mobile'])?$_POST['mobile']:$login_user['mobile']; ?>" name="mobile" id="signup-mobile" require="true" datatype="require" />
                                            </div></td>
                                      </tr>
                                      <tr>
                                        <td align="left">
                                            <div style="margin-left:130px" class="act">
                                            <input  type="buttn" value=" Lưu và tiếp tục " id="step2-submit" class="formbutton"/>
                                            <input style="margin-left: 13px;" type="button" value=" Hủy " id="cancel_transfer" class="formbutton"/>
                                          </div>
                                         </td>
                                      </tr>
                                    </table>
	                                    <input type="hidden" name="atact" value="inforec" />
                                    </form>
                                    <script type="text/javascript">
										$('#step2-submit').live('click',function(){
											
											$('#fstep2').ajaxSubmit({
												'dataType':'json',
												'success': function (ret) {	
													if(ret['error']==0){
														$('#atusernamerec').html(ret['name']);
														$('#atuseraddress').html(ret['address']);
														$('#atuserphone').html(ret['phone']);
														$('#responser_step3').html(ret['html']);
														
														$('.order_step2').removeClass('content_active').removeClass('content_hide');
														$('.order_step3').addClass('content_active').removeClass('content_hide');
														
													}else{
														alert('Lỗi đường truyền vui lòng thử lại');
													}
													
												}
											});
										
										});
									</script>
                                </div>
                        </div>
                    </div>
                    <div class="box_order_action">
                        <a class="cur btn_changeact" id="change_info_transfer">Thay đổi</a>
                    </div>
                </div>   
                    
                   <?php  /*  End Step 2  */ ?> 
                    
                    <?php  /*  Begin Step 3  */ ?>
                    <div class="box_information  order_step3 content_active">
                        <div class="title_step">3.Thanh toán và vận chuyển</div>
                        <div class="box_order_content">
                            <div class="order_content_origin" id="responserst3content">
                                
                                
                                
                            </div>
                            <div class="order_content_edit" id="responser_step3">
                            
                               <?php  
                               
                          /*       if($uinfo['city_id'] == 11){
                                    //HCM city
                                    echo render('atajax_transfer_hcm');
                                     
                                }else{
                                    //Another
                                      */
                                    echo  render('atajax_transfer');
                           //     }
                               
                                ?>
                                
                            </div>
                        </div>
                        <div class="box_order_action">
                            <a class="cur btn_changeact" id="payment_transfer">Thay đổi</a>
                        </div>
                    </div>
                    <?php  /*  End Step 3  */ ?>
                    
                    <?php  /*  Begin Kiem tra va dat hang  */ ?>
                    <div class="box_information  order_step4 content_hide">
                            <div class="title_step">4. Kiểm tra và đặt hàng</div>
                            <div class="box_order_content">
                                <div class="order_content_edit" id="responser_content_step4">
                                    
                                </div>
                            </div>
                        </div>
                    <?php  /*  End kiem tra va dat hang  */ ?>
            </div>
            <?php  else: ?>
            <div class="box_order">
            	
               <div class="box_order">
<?php  /*  begin step 1  */ ?>
            	<div class="box_information  order_step1 content_active">
                	<div class="title_step">1. Tài Khoản</div>
                    <div class="box_order_content">
                    	<div class="order_content_origin">
                        	
                        </div>
                        <div class="order_content_edit">
                        	<table width="100%" border="0" cellpadding="0" cellspacing="0">
            	<tr>
                	<td width="60%" valign="top">
                    <form id="fcuser" action="/ajax/checkout.php" method="post" name="createuser">
                    	<input type="hidden" name="atstate" value="new" />
                    	<div class="user-infor-new">
                        	<h3>Thông tin khách hàng</h3>
                            <div class="info-custom-form">
                            	<table width="100%" class="attbform">
                                <tr>
                                <td align="left" height="35"><div class="field">
                                        <label>Họ tên</label>
                                        <input type="text" size="20"  name="realname" value="<?php echo $_POST['realname']; ?>" id="settings-realname" class="f-input" require="true" datatype="require" />                      
                                    </div></td>
                              </tr>
                              
                                	<tr>
                                <td align="left" height="35"><div class="field email">
                                    <label for="signup-email-address">Email</label>
                                    <input type="text" size="30" name="email" id="settings-email-address" class="f-input" value="<?php echo $_POST['email']; ?>" require="true" datatype="email|ajax" url="<?php echo WEB_ROOT; ?>/ajax/validator.php" vname="signupemail" msg="Email incorrect format | Email has already been registered" />
                                  
                                    <div class="hint">Dùng để đăng nhập và tìm lại mật khẩu, không công khai.</div></div></td>
                              </tr>
                              <tr>
                                <td align="left" height="35">
                                	<div class="field password">
                                    <label for="signup-password">Mật khẩu</label>
                                    <input type="password" size="30" name="password" id="settingcr_password" class="f-input" require="true" datatype="require" />
                                    <div class="hint">Mật khẩu bao gồm ít nhất 6 ký tự</div>
                                    </div></td>
                              </tr>
                                </table>
                            </div>
                            <h3>Thông tin giao hàng</h3>
                            <div class="user_info_transfer">
                            	<table width="100%" class="attbform">
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
                                        <input type="text" name="house_number" autocomplete="off" id="settings-house-number" class="f-input" style="width:100px" require="true" value="<?php echo $_POST['house_number']; ?>" datatype="require" />
                                      </div></td>
                                  </tr>
                                  <tr>
                                    <td height="45" align="left"><div class="field">
                                        <label>Tên đường </label>
                                        <input type="text" name="street_name" autocomplete="off" class="f-input" id="settings-street-name" require="true" value="<?php echo $_POST['street_name']; ?>" datatype="require" />
                                        <div class="hint">Vui lòng ghi rõ ràng tên đường có dấu</span> </div></td>
                                  </tr>
                                  <tr>
                                    <td height="45"><div class="field">
                                        <label>Phòng-lầu-tòa nhà</label>
                                        <input type="text" name="note_address" value="<?php echo $_POST['note_address']; ?>" id="settings-note-address" class="f-input" size="30" />
                                        <div class="hint">Ví dụ: P907, Lầu 9, Cao Ốc Diamond Plaza</div></div></td>
                                  </tr>
                                  <tr>
                                    <td height="45"><div class="field">
                                        <label>Di động</label>
                                        <input type="text" class="f-input" size="30" value="<?php echo $_POST['mobile']; ?>" name="mobile" id="signup-mobile" require="true" datatype="require" />
                                        <div class="hint">Số ĐTDĐ dùng để liên lạc khi giao hàng, vui lòng nhập chữ số viết liền</div> </div></td>
                                  </tr>
                                  <tr>
                                    <td height="45">
                                    <div class="field subscribe" style="margin-left:125px;width:200px">
                                    	<table border="0" cellspacing="0" cellpadding="0">
                                        	<tr>
                                            	<td align="left"><input tabindex="3" type="checkbox" value="1" name="subscribe" id="subscribe" class="f-check" checked="checked" /></td>
                                                <td align="left"><label for="subscribe" style="width: 200px;text-align: left;padding-left: 10px;">Đăng ký nhận deal hàng ngày</label></td></tr>
                                   </table>
                                  </div>
                                  </td>
                                  </tr>
                                  <tr>
                                    <td align="left">
                                    	<div style="margin-left:130px" class="act">
                                        <input type="submit" value=" Lưu và tiếp tục "  id="create_user_submit" class="formbutton"/>
                                      </div>
                                     </td>
                                  </tr>
                                </table>
                            </div>
                        </div>
                        <input type="hidden" name="atact" value="cretaeuser" />
                        </form>
                    </td>
                    <td width="40%" valign="top">
                    <div class="box_user_login">
                    	<div class="at-info-uexist">
                        	Bạn đã có tài khoản tại Cheapdeal.vn
                        </div>
	                    <h2 style="font-size:14px;">Đăng nhập</h2>
                        <div class="box-user-form-login">
                        <form id="login-user-form" method="post" action="/account/login.php" class="validator">
                        		<table class="attbform">
                                <tbody>
                                    <tr>
                                      <td align="left" height="35">
                                      	<div class="field email" style="">
                                          <label for="login-email-address">Email</label>
                                          <input type="text" size="30" name="email" id="login-email-address" class="f-input" value="" require="true" datatype="require|limit" min="2" />
                                        </div></td>
                                    </tr>
                                    <tr>
                                      <td align="left" height="35"><div class="field password" style="">
                                          <label for="login-password">Mật khẩu</label>
                                          <input type="password" size="30" name="password" id="login-password" class="f-input" require="true" datatype="require" />
                                          <span class="lostpassword" style="margin-left: 138px;display: block;margin-top: 10px;"><a href="/account/repass.php">Quên mật khẩu?</a></span> </div></td>
                                    </tr>
                                    <tr>
                                      <td align="left" height="35" style="padding-left:80px;"><div class="field autologin" style="width:145px; white-space:nowrap"><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><input style="margin-left:45px" type="checkbox" value="1" name="auto-login" id="autologin" class="f-check" checked /></td>
    <td><label for="autologin">Tự động đăng nhập</label></td>
  </tr>
</table></div></td>
                                    </tr>
                                    <tr>
                                      <td align="left" height="35"><div class="act">
                                          <input style="margin-left:130px" type="submit" value="Đăng nhập" name="commit" id="login-submit" class="formbutton"/>
                                        </div></td>
                                    </tr>
                                  </tbody>
                                </table>
                                </form>
                        </div>
                    </div>
                    </td>
                </tr>
            </table>
                        </div>
                    </div>
                    <div class="box_order_action">
                    	<a class="cur btn_changeact" id="change_user">Thay đổi</a>
                    </div>
                </div>
                <?php  /*  end step 1  */ ?>
                 <?php  /*  Begin Step 2  */ ?>   
                 <div class="box_information  order_step2 content_hide">
                    <div class="title_step">2. Địa chỉ giao hàng</div>
                    <div class="box_order_content">
                        <div class="order_content_origin">
                           
                        </div>
                        <div class="order_content_edit">
                              
                        </div>
                    </div>
                    <div class="box_order_action">
                        <a class="cur btn_changeact" id="change_info_transfer">Thay đổi</a>
                    </div>
                </div>   
                    
                   <?php  /*  End Step 2  */ ?> 
                    
                    <?php  /*  Begin Step 3  */ ?>
                    <div class="box_information  order_step3 content_hide">
                        <div class="title_step">3.Thanh toán và vận chuyển</div>
                        <div class="box_order_content">
                            <div class="order_content_origin" id="responserst3content">
                                
                                
                                
                            </div>
                            <div class="order_content_edit" id="responser_step3">
                            
                     
                                
                            </div>
                        </div>
                        <div class="box_order_action">
                            <a class="cur btn_changeact" id="payment_transfer">Thay đổi</a>
                        </div>
                    </div>
                    <?php  /*  End Step 3  */ ?>
                    
                    <?php  /*  Begin Kiem tra va dat hang  */ ?>
                    <div class="box_information  order_step4 content_hide">
                            <div class="title_step">4. Kiểm tra và đặt hàng</div>
                            <div class="box_order_content">
                                <div class="order_content_edit" id="responser_content_step4">
                                    
                                </div>
                            </div>
                        </div>
                    <?php  /*  End kiem tra va dat hang  */ ?>
            </div>
                
                
             </div>

            
            <?php  endif; ?>
        </div>
    </div>
</div>


<script type="text/javascript">
$(document).ready(function(){
	$('#change_user').click(function(){
		$('.order_step1').addClass('content_active');
		$('.order_step2').removeClass('content_active');
		$('.order_step2, .order_step3, .order_step4').removeClass('content_active').addClass('content_hide');
	});
	$('#cancle_changeuser').click(function(){
		$('.order_step1').removeClass('content_active');
		$('.order_step2').removeClass('content_hide').addClass('content_active');
	});
	$('#change_info_transfer').click(function(){
		$('.order_step2').addClass('content_active');
		$('.order_step3, .order_step4').removeClass('content_active').addClass('content_hide');
	});
	$('#cancel_transfer').click(function(){
		$('.order_step2').removeClass('content_active').removeClass('content_hide');
		$('.order_step3').addClass('content_active').removeClass('content_hide');
	});
	
	$('#payment_transfer').click(function(){
		$('.order_step3').addClass('content_active').removeClass('content_hide');
		$('.order_step4').removeClass('content_active').addClass('content_hide');
	});
	
	$('#btn_paymentnext').click(function(){
		$('.order_step3').removeClass('content_active').removeClass('content_hide');
		$('.order_step4').addClass('content_active').removeClass('content_hide');
	});
	$('#create_user_submit').click(function(){
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		$name = $('#settings-realname');
		$email = $('#settings-email-address');
		$pass = $('#settingcr_password');
		$dist_id = $('#dist_id');
		$mobile = $('#signup-mobile');
		if($name.val() == ''){
			alert('Bạn chưa nhập họ tên');
			$name.focus();
			return false;
		}else if(filter.test($email.val()) == false){
			alert('Địa chỉ Email không hợp lệ');
			$email.focus();
			return false;
		}else if($pass.val() == ''){
			alert('Bạn chưa nhập mật khẩu tài khoản');
			$pass.focus();
			return false;
		}else if($dist_id.val() == ''){
			alert('Vui lòng chọn địa chỉ thông tin giao hàng');
			$dist_id.focus();
			return false;
		}else if($mobile.val() == ''){
			alert("Bạn chưa nhập số điện thoại liên hệ xác nhận đặt hàng");
			$mobile.focus();
			return false;
		}else{
			$('#fcuser').ajaxSubmit({
				'dataType':'json',
				'success': function (ret) {
					if(ret['error']==0){
						window.location = '/team/checkout.php';
					}else{
						alert(ret['msg']);
					}
				}
			});
		}
		return false;
	});
});
</script>
<?php include template("footer");?> 
