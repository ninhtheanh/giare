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
                 <script type="text/javascript" language="javascript">
					function checkform(){
						if(document.teambuy.is_true.checked == false){
							alert('Vui lòng chọn vào check box!!');
							return false;
						}else{
							return true;
						}
					}
					$(document).ready(function(){
						$("#deal-buy-quantity-input").focus();
						$("#deal-buy-quantity-input").removeClass("input-text f-input").addClass("focusField f-input");
					});
				</script>
                <style type="text/css"> 
.focusField{  
        border:solid 1px #73A6FF;  
        background:#F0D722; width:50px; font-size:15px; font-weight:bold; font-family:Arial, Helvetica, sans-serif;color:#333333; text-align:center; padding:5px;
    }
</style>
                	<div class="atbox-setting" style="width: 92%;margin-left: 20px;padding: 10px;border: 1px solid #ccc;box-shadow: 0px 0px 5px #ccc;">
                    	<h2 class="title_info_setting">Giỏ hàng</h2>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                   
                    <tr>
                     
                      <td><div align="left">
                          <form action="/team/buy.php?id=<?php echo $team['id']; ?>" method="post" class="validator" name="teambuy" onSubmit="return checkform()">
                            <input id="deal-per-number" value="<?php echo $team['per_number']; ?>" type="hidden" />
                            <table class="order-table">
                              <tr>
                                <th class="deal-buy-desc">Tên sản phẩm</th>
                                <th class="deal-buy-quantity">Số lượng</th>
                                <th class="deal-buy-multi"></th>
                                <th class="deal-buy-price">Đơn giá (<span class="money"><?php echo $currency; ?></span>)</th>
                                <th class="deal-buy-equal"></th>
                                <th class="deal-buy-total">Thành tiền (<span class="money"><?php echo $currency; ?></span>)</th>
                              </tr>
                              <tr>
                                <td class="deal-buy-desc"><?php echo $team['product']; ?></td>
                                <td class="deal-buy-quantity"><input type="text" class="input-text f-input" maxlength="4" name="quantity" value="<?php echo $qty; ?>" ff="<?php echo abs(intval($team['farefree'])); ?>" id="deal-buy-quantity-input" <?php echo $team['per_number']==1?'readonly':''; ?> />
                                  <br />
                                  <span style="font-size:10px;color:red;">trên tổng số lần mua. Bạn có thể chỉnh số lượng mua</span> 
                                  <!--<br /><span style="font-size:12px;color:gray;"><?php if($team['per_number']==0){?> 
                                  at most 9999 pieces 
                                  <?php } else { ?> 
                                  at most <?php echo $team['per_number']; ?> pieces 
                                  <?php }?> 
                                  </span>--></td>
                                <td class="deal-buy-multi">x</td>
                                <td class="deal-buy-price"><span id="deal-buy-price"><?php echo print_price($team['team_price']); ?>
                                  <input id="deal-buy-price-hidden" value="<?php echo (int)($team['team_price']); ?>" type="hidden" />
                                  </span></td>
                                <td class="deal-buy-equal">=</td>
                                <td class="deal-buy-total" style="BORDER-RIGHT: #b1d1e6 1px solid;"><span id="deal-buy-total"><?php echo print_price($qty*$team['team_price']); ?></span>
                                  <input id="deal-buy-total-hidden" value="<?php echo (int)($qty*$team['team_price']); ?>" type="hidden" /></td>
                              </tr>
                              <?php if($team['delivery']=='express'){?>
                              <tr>
                                <td class="deal-buy-desc">Chuyển phát nhanh</td>
                                <td class="deal-buy-quantity"></td>
                                <td class="deal-buy-multi"></td>
                                <td class="deal-buy-price"><span id="deal-express-price" v="<?php echo $team['fare']; ?>"><?php echo $team['fare']; ?></span></td>
                                <td class="deal-buy-equal">=</td>
                                <td class="deal-buy-total" style="BORDER-RIGHT: #b1d1e6 1px solid;"><span id="deal-express-total" v="<?php echo $team['fare']; ?>"><?php echo $team['fare']; ?></span>
                                  <input id="deal-express-total-hidden" value="{(int)($team['fare'])}" type="hidden" /></td>
                              </tr>
                              <?php }?> 
                              <?php if($login_user['money']>0){?>
                              <tr class="order-total" bgcolor="#FDFA9D">
                                <td class="deal-buy-desc" style="BORDER-LEFT: #b1d1e6 1px solid;BORDER-BOTTOM: #b1d1e6 1px solid;"></td>
                                <td class="deal-buy-quantity" style="BORDER-BOTTOM: #b1d1e6 1px solid;"></td>
                                <td class="deal-buy-price" colspan="3" style="BORDER-BOTTOM: #b1d1e6 1px solid; color:#ff6600">Số dư tài khoản của bạn:</td>
                                <td class="deal-buy-total" style="BORDER-BOTTOM: #b1d1e6 1px solid;BORDER-RIGHT: #b1d1e6 1px solid; color:#ff6600"><span id="deal-balance-total"><?php echo print_price($login_user['money']); ?> <?php echo $currency; ?>
                                  <input id="deal-balance-total-hidden" value="<?php echo (int)($login_user['money']); ?>" type="hidden" />
                                  </span></td>
                              </tr>
                              <?php }?>
                              <tr class="order-total" bgcolor="#FDFA9D">
                                <td class="deal-buy-desc" style="BORDER-LEFT: #b1d1e6 1px solid;BORDER-BOTTOM: #b1d1e6 1px solid;"></td>
                                <td class="deal-buy-quantity" style="BORDER-BOTTOM: #b1d1e6 1px solid;"></td>
                                <td class="deal-buy-multi" style="BORDER-BOTTOM: #b1d1e6 1px solid;"></td>
                                <td class="deal-buy-price" nowrap="nowrap" style="BORDER-BOTTOM: #b1d1e6 1px solid; white-space:nowrap"><strong>Tổng số tiền:</strong></td>
                                <td class="deal-buy-equal" style="BORDER-BOTTOM: #b1d1e6 1px solid;">=</td>
                                <td class="deal-buy-total" style="BORDER-BOTTOM: #b1d1e6 1px solid;BORDER-RIGHT: #b1d1e6 1px solid;"><?php $total = $qty*$team['team_price'];; ?> 
                                  <strong id="deal-buy-total-t"><?php echo print_price($total); ?></strong>&nbsp;<span class="money"><?php echo $currency; ?></span></td>
                              </tr>
                            </table>
                            <?php if($order['id']>0){?>
                            <table width="100%">
                              <tr>
                                <td align="left" valign="top" style="padding-top:5px; padding-bottom:5px;"><strong style="color:#ff6600; ">Lưu ý:</strong> Bạn đã mua deal này rồi. Nếu bạn muốn mua thêm/bớt thì vui lòng chỉnh sửa lại số lượng muốn mua trong giỏ hàng.</td>
                              </tr>
                            </table>
                            <?php }?> 
                            <?php if($team['image6']!=''){?>
                            <table width="0%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td align="center" colspan="2" valign="top" style="padding:5px;font-size:14px; font-family:Arial, Helvetica, sans-serif">Bạn sẽ nhận được thẻ do <?php echo $INI['system']['sitename']; ?> cung cấp sau khi thanh toán</td>
                              </tr>
                              <tr><?php if($team['image6']!=''){?>
                                <td align="center" valign="top"><img src="<?php echo team_image($team['image6']); ?>" /></td>
                                <?php }?><?php if($team['image7']!=''){?>
                                <td align="center" valign="top"><img src="<?php echo team_image($team['image7']); ?>" /></td>
                                <?php }?></tr>
                              <tr>
                                <td align="center" colspan="2" valign="top" style="padding:5px; color:#096ea1;font-size:16px; font-family:Arial, Helvetica, sans-serif">Bạn phải đem theo thẻ này đến <strong><?php echo $partner['title']; ?></strong> để sử dụng dịch vụ!</td>
                              </tr>
                              <tr align="left" colspan="2">
                                
                              </tr>
                            </table>
                            <?php }?>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                              <tbody>
                                <?php if($team['delivery']=='express'){?>
                                <tr>
                                  <td align="left"><div class="expresstip"><?php echo nl2br(htmlspecialchars($team['express'])); ?></div>
                                    <div class="wholetip clear"></br>
                                      <h3>Thông tin giao hàng</h3>
                                    </div></td>
                                </tr>
                                <tr>
                                  <td align="left" height="35"><div class="field username">
                                      <label>Người nhận</label>
                                      <input type="text" size="30" name="realname" id="settings-realname" class="f-input" value="<?php echo $login_user['realname']; ?>" require="true" datatype="require" />
                                    </div></td>
                                </tr>
                               
                                <tr>
                                  <td align="left" height="35"><div class="field mobile">
                                      <label>Mobile</label>
                                      <input type="text" size="30" name="mobile" id="settings-mobile" class="number" value="<?php echo $login_user['mobile']; ?>" require="true" datatype="mobile" maxLength="11" />
                                    </div></td>
                                </tr>
                               
                                <tr>
                                  <td align="left" height="35"><div class="field mobile">
                                      <label>Địa chỉ</label>
                                      <input type="text" size="30" name="address" id="settings-address" class="f-input" value="<?php echo $login_user['address']; ?>" require="true" datatype="require" />
                                    </div></td>
                                </tr>
                                <?php } else if(!empty($login_user)) { ?>
                                <tr>
                                  <td align="left"><div class="wholetip clear" style="font-size:16px;">
                                      <h3>Thông tin giao hàng</h3>
                                    </div></td>
                                </tr>
                                <tr>
                                  <td align="left" style="padding-top:5px; padding-bottom:5px; padding-left:10px;"><strong>Ghi chú : </strong><span style="color:#c40000">Hiện nay Cheapdeal đã thực hiện giao hàng trên 64 tỉnh thành thông qua kênh thanh toán trực tuyến nganluong.vn hoặc bằng thẻ ATM</span></td>
                                </tr>
                                <tr>
                                  <td align="left" height="35"><div class="field username">
                                      <label>Người nhận</label>
                                      <input type="text" name="realname" id="settings-realname" class="f-input" value="<?php if($order['realname']!=''){?> <?php echo $order['realname']; ?><?php } else { ?> <?php echo $login_user['realname']; ?> <?php }?>" require="true" datatype="require" />
                                    </div></td>
                                </tr>
                              
                              <link rel="stylesheet" type="text/css" href="/static/css/jquery.autocomplete.css" />
                              <script type='text/javascript' src="/static/js/jquery.autocomplete.js"></script> 
                              <script src="/static/js/jchain.js" type="text/javascript"></script> 
                              <script type="text/javascript">				               
				jQuery(document).ready(function() {	
					var opt = '<option value=0>--Chọn--</option>';
					/*
					$('#city_id').change(function() {											
						$.get('/ajax/city.php?city_id='+$("#city_id").val(), function(ret) {					 		 
						  $('#dist_id').empty().append(opt+ret);
						  $('#ward_id').empty();
						});
					});
					*/
					$('#dist_id').change(function() {
						$.get('/ajax/city.php?dist_id='+$("#dist_id").val(), function(ret) {					 
						  $('#ward_id').empty().append(opt+ret);	
						});
					});
				});		
				function searchSuggest(){
					$("#settings-street-name").autocomplete('search_address_list.php', {width: 308});	
				}
			</script> 
                              <?php 
$dist_id = ($order['dist_id']) ? $order['dist_id']: $login_user['dist_id'];  
$ward_id = ($order['ward_id']) ? $order['ward_id']: $login_user['ward_id'];
; ?>
                              
                              <tr>
                                <td align="left" height="35"><div class="field">
                                    <label id="enter-address-city-label" for="signup-city">Quận/Huyện</label>
                                    <select name="dist_id" id="dist_id"  class="f-city" require="true" datatype="require" style="width:180px" onChange="getDistId()">
                                      <option value="">---Chọn---</option>
                                      
                     <?php echo optiondistrict($dist_id,$city['id']); ?>
            
                                    </select>
                                  </div></td>
                              </tr>
                            
                              <tr>
                                <td align="left" height="35"><div class="field">
                                    <label>Phường/Xã</label>
                                    <select name="ward_id" id="ward_id"  class="f-city" require="true" datatype="require" style="width:180px" onChange="getWardId()">
                                      <option value="">---Chọn---</option>
                                         
              <?php echo optionward($ward_id,$dist_id); ?>                
            
                                    </select>
                                  </div></td>
                              </tr>
                             
                              <tr>
                                <td align="left" height="35"><div class="field">
                                    <label>Số nhà</label>
                                    <?php 
                    if ($order['house_number']!='' || $order['street_name']!=''){
                        $house_number = $order['house_number'];
                        $street_name = $order['street_name'];
                    }else{
                        $expl = explode(" ",$login_user['address']);
                        $house_number = $expl[0];
                        $street_name = trim(str_replace($expl[0],"",$login_user['address']));
                    }
                ; ?>
                                    <input type="text" name="house_number" autocomplete="off" id="settings-address" class="f-input" value="<?php echo $house_number; ?>" require="true" datatype="require" />
                                  </div></td>
                              </tr>
                            
                              <tr>
                                <td align="left" height="35"><div class="field mobile">
                                    <label>Tên đường</label>
                                    <input type="text" name="street_name" class="f-input" autocomplete="off" onFocus="searchSuggest()" id="settings-street-name" require="true" value="<?php echo $street_name; ?>" datatype="require" />
                                  </div></td>
                              </tr>
                           
                              <tr>
                                <td align="left" height="35"><div class="field">
                                    <label>Phòng-tòa nhà</label>
                                    <input type="text" size="30" name="note_address" id="settings-note-address" class="f-input" value="<?php if($order['note_address']!=''){?> <?php echo $order['note_address']; ?><?php } else { ?><?php echo $login_user['note_address']; ?><?php }?>" />
                                    <span class="hint" style="white-space:nowrap"><i>Ví dụ: P101, Lầu 10, Cao Ốc Bitexco</i></span></div></td>
                              </tr>
                            
                              <tr>
                                <td align="left" height="35"><div class="field mobile">
                                    <label>Di động</label>
                                    <input type="text" size="30" name="mobile" id="settings-mobile" require="true" class="f-input number" value="<?php if($order['mobile']!=''){?> <?php echo $order['mobile']; ?><?php } else { ?> <?php echo $login_user['mobile']; ?> <?php }?>"  datatype="mobile" maxLength="11" style="font-weight:bold; font-size:16px; width:250px;" />
                                    <span class="hint" style="white-space:nowrap"><i>Số ĐTDĐ dùng để liên lạc khi giao hàng.</i></span> </div></td>
                              </tr>
                            
                              <tr>
                                <td align="left"><div class="wholetip clear" style="font-size:16px;">
                                    <h3>Thông tin thêm</h3>
                                  </div>
                                  
                                  <?php if($condbuy=nanooption($team['condbuy'])){?>
                                  
                                  <div class="field mobile">
                                    <label>Màu sắc</label>
                                    <select name="condbuy" class="f-input" style="width:auto;">
                                      
                <?php echo Utility::Option(array_combine($condbuy, $condbuy), 'condbuy'); ?>
            
                                    </select>
                                  </div>
                                  
                                  <?php }?></td>
                              </tr>
                              <tr>
                                <td align="left" height="35"><div class="field mobile" style="width:600px">
                                    <label>Ghi chú</label>
                                    <textarea name="remark" style="width:400px;height:80px;padding:2px; border:#1B94C1 1px solid"><?php echo htmlspecialchars($order['remark']); ?></textarea>
                                  </div></td>
                              </tr>
                             
                              <?php }?>
                              <tr>
                                <td align="left" height="35"><div class="form-submit">
                                    <input type="hidden" name="id" value="<?php echo $order['id']; ?>" />
                                    <input type="submit" class="formbutton" name="buy" value="Đồng ý mua" style="padding:7px;"/>
                                  </div></td>
                              </tr>
                                </tbody>
                              
                            </table>
                          </form>
                        </div>
                        
                        </td>
                    
                    </tr>
                    
                   
                      </tbody>
                    
                  </table>
                    </div>
                </td>
            </tr>
        </table>
        
            
        </div>
    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->
<script>
window.x_init_hook_dealbuy = function(){
	X.team.dealbuy_farefree("<?php echo abs(intval($qty)); ?>");
	X.team.dealbuy_totalprice();
};
</script> 
<?php include template("footer");?>
