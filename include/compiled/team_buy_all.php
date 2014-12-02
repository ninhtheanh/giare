<?php include template("header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
  <div id="signup">
    <div class="subdashboard" id="dashboard">
      <ul>
        <li class="current"><a href="#">&nbsp;&nbsp;Giỏ hàng 
          <?php if($team['farefree']>0){?> 
          &nbsp;(<span class="currency"><?php echo $team['farefree']; ?></span>free of express fee) 
          <?php }?>&nbsp;</a><span></span></li>
      </ul>
    </div>
  </div>
  <div id="contentfontend" class="mainwide clear">
    <div id="deal-buy" class="box"> 
      <script type="text/javascript" language="javascript">
    	function checkform(){
			if(document.teambuy.is_true.checked == false){
				alert('Vui lòng chọn vào check box!!');
				return false;
			}else{
				return true;
			}
		}
    </script>
      <div class="subbox-content" >
        <div style="background-color:#FFFFFF; min-height:500px; _height:500px">
          <div style="padding:10px;">
            <div style="font-size:20px; padding-bottom:10px;"> </div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
                      <tr>
                        <td width="24"><img src="/static/css/images/faqbox_topleft.gif" width="24" height="20"></td>
                        <td style="background: url(&quot;/static/css/images/faqbox_topbg.gif&quot;) repeat-x scroll 0% 0% transparent;"></td>
                        <td width="23"><img src="/static/css/images/faqbox_topright.gif" width="23" height="20"></td>
                      </tr>
                      <tr>
                        <td style="background: url(&quot;/static/css/images/faqbox_leftbg.gif&quot;) repeat-y scroll right center transparent;">&nbsp;</td>
                        <td bgcolor="#f1f1f1"><form action="/team/buy.php?id=<?php echo $team['id']; ?>" method="post" class="validator" name="teambuy" onSubmit="return checkform()">
                            <input id="deal-per-number" value="<?php echo $team['per_number']; ?>" type="hidden" />
                            <table class="order-table">
                              <tr>
                                <th class="deal-buy-desc">Deal</th>
                                <th class="deal-buy-quantity">Số lượng</th>
                                <th class="deal-buy-multi"><?php if($condbuy=nanooption($team['condbuy'])){?>Size - Màu sắc<?php }?></th>
                                <th class="deal-buy-price">Đơn giá (<span class="money"><?php echo $currency; ?></span>)</th>
                                <th class="deal-buy-equal"></th>
                                <th class="deal-buy-total">Thành tiền (<span class="money"><?php echo $currency; ?></span>)</th>
                              </tr>
                              <tr>
                                <td class="deal-buy-desc"><?php echo $team['title']; ?></td>
                                <td class="deal-buy-quantity"><input type="text" class="input-text f-input" maxlength="4" name="quantity" value="<?php echo $qty; ?>" ff="<?php echo abs(intval($team['farefree'])); ?>" id="deal-buy-quantity-input" <?php echo $team['per_number']==1?'readonly':''; ?> />
                                  <br />
                                  <span style="font-size:10px;color:red;">trên tổng số lần mua. Bạn có thể chỉnh số lượng mua</td>
                                <td class="deal-buy-multi"><?php if($condbuy=nanooption($team['condbuy'])){?><select name="condbuy" class="f-input" style="width:auto;">
                <?php echo Utility::Option(array_combine($condbuy, $condbuy), 'condbuy'); ?>
            </select><?php } else { ?>x<?php }?></td>
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
                                <td class="deal-buy-price" colspan="3" style="BORDER-BOTTOM: #b1d1e6 1px solid; color:#ff6600; white-space:nowrap">Số dư tài khoản của bạn:</td>
                                <td class="deal-buy-total" style="BORDER-BOTTOM: #b1d1e6 1px solid;BORDER-RIGHT: #b1d1e6 1px solid; color:#ff6600"><span id="deal-balance-total"><?php echo print_price($login_user['money']); ?> </span></td>
                              </tr>
                              <?php }?>
                              <tr class="order-total" bgcolor="#FDFA9D">
                                <td class="deal-buy-desc" style="BORDER-LEFT: #b1d1e6 1px solid;BORDER-BOTTOM: #b1d1e6 1px solid;"></td>
                                <td class="deal-buy-quantity" style="BORDER-BOTTOM: #b1d1e6 1px solid;"></td>
                                <td class="deal-buy-multi" style="BORDER-BOTTOM: #b1d1e6 1px solid;"></td>
                                <td class="deal-buy-price" nowrap="nowrap" style="BORDER-BOTTOM: #b1d1e6 1px solid;"><strong>Tổng số tiền:</strong></td>
                                <td class="deal-buy-equal" style="BORDER-BOTTOM: #b1d1e6 1px solid;">=</td>
                                <td class="deal-buy-total" style="BORDER-BOTTOM: #b1d1e6 1px solid;BORDER-RIGHT: #b1d1e6 1px solid;"><strong id="deal-buy-total-t"><?php echo print_price($order['origin']); ?></strong>&nbsp;<span class="money"><?php echo $currency; ?></span></td>
                              </tr>
                            </table>
                            <?php if($order['id']>0){?>
                            <table width="100%">
                              <tr>
                                <td align="left" valign="top" style="padding-top:5px; padding-bottom:5px;"><strong style="color:#C40000; ">Lưu ý:</strong> Bạn đã mua deal này rồi. Nếu bạn muốn mua thêm/bớt thì vui lòng chỉnh sửa lại số lượng muốn mua trong giỏ hàng.</td>
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
                                <?php }?></tr>
                              <tr>
                                <td align="center" colspan="2" valign="top" style="padding:5px; color:#096ea1;font-size:16px; font-family:Arial, Helvetica, sans-serif">Bạn phải đem theo thẻ này đến <strong><?php echo $partner['title']; ?></strong> để sử dụng dịch vụ!</td>
                              </tr>
                              <tr align="left" colspan="2">
                                <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                              </tr>
                            </table>
                            <?php }?>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                              <tbody>
                                <?php if($team['delivery']=='express'){?>
                                <tr>
                                  <td align="left"><div class="expresstip"><?php echo nl2br(htmlspecialchars($team['express'])); ?></div>
                                    <div class="wholetip clear">
                                      <h3>Thông tin chuyển phát nhanh</h3>
                                    </div></td>
                                </tr>
                                <tr>
                                  <td align="left" height="35"><div class="field username">
                                      <label>Người nhận</label>
                                      <input type="text" size="30" name="realname" id="settings-realname" class="f-input" value="<?php echo $login_user['realname']; ?>" require="true" datatype="require" />
                                    </div></td>
                                </tr>
                                <tr align="left">
                                  <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                                </tr>
                                <tr>
                                  <td align="left" height="35"><div class="field mobile">
                                      <label>Mobile</label>
                                      <input type="text" size="30" name="mobile" id="settings-mobile" class="number" value="<?php echo $login_user['mobile']; ?>" require="true" datatype="mobile" maxLength="11" />
                                    </div></td>
                                </tr>
                                <tr align="left">
                                  <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                                </tr>
                                <tr>
                                  <td align="left" height="35"><div class="field mobile">
                                      <label>Địa chỉ</label>
                                      <input type="text" size="30" name="address" id="settings-address" class="f-input" value="<?php echo $login_user['address']; ?>" require="true" datatype="require" />
                                    </div></td>
                                </tr>
                                <?php } else if(!empty($login_user)) { ?>
                                <tr align="left">
                                  <td style="background: url('/static/css/images/faqbox_break.gif') repeat-x scroll 80% transparent;" height="20"></td>
                                </tr>
                                <tr>
                                  <td align="left"><strong>Ghi chú :</strong> <span style="color:#c40000">Hiện nay Dealsoc đã thực hiện giao hàng trên 64 tỉnh thành thông qua kênh thanh toán trực tuyến nganluong.vn hoặc bằng thẻ ATM</td>
                                </tr>
                                <tr align="left">
                                  <td style="background: url('/static/css/images/faqbox_break.gif') repeat-x scroll 80% transparent;" height="20"></td>
                                </tr>
                                <tr>
                                  <td valign="top"><link rel="stylesheet" type="text/css" href="/static/css/jquery.autocomplete.css" />
                                    <script type='text/javascript' src="/static/js/jquery.autocomplete.js"></script> 
                                    <!--<script src="/static/js/jchain.js" type="text/javascript"></script>-->
                                    <!--<script type="text/javascript" src="/static/js/jquery.selectboxes.pack.js" charset="utf-8"></script>-->
                                    <script type="text/javascript">
				/*var city_id; var dist_id; var ward_id;
				function getDistId(){
					return $("#dist_id").val();
				}
				function getWardId(){
					return $("#ward_id").val();
				}*/
				
			jQuery(document).ready(function() {	
				/*
				$("#dist_id").chained("#city_id"); 
				$("#ward_id").chained("#dist_id");				
				
				$("#bdist_id").chained("#bcity_id"); 
				$("#bward_id").chained("#bdist_id");
				*/
				
				/*
				// copy billing to shipping
				$('input#copyaddress').click(function() {
			
					// If checked
					if ($(this).is(":checked")) {
			
						//for each input field
						$('#shipping_fields input', ':visible', document.body).each(function(i) {
			
							//copy the values from the billing inputs
							//to the equiv inputs on the shipping inputs
							$(this).val($("#billing_fields input").eq(i).val());
						});
			
						//won't work on drop downs, so get those values						
						var bcity_id = $("#city_id").val();
						var bdist_id = $("#dist_id").val();
						var bward_id = $("#ward_id").val();
			
						// special for the select
						$('select#bcity_id option[value=' + bcity_id + ']').attr('selected', 'selected');
						$('select#bdist_id option[value=' + bdist_id + ']').attr('selected', 'selected');
						$('select#bward_id option[value=' + bward_id + ']').attr('selected', 'selected');
			
					}
					else {
			
						//for each input field
						$('fieldset#shipping_fields input', ':visible', document.body).each(function(i) {
			
							// put default values back
							$(this).val($(this)[0].defaultValue);
						});
			
						// special for the select
						$('select#bcity_id option[value=""]').attr('selected', 'selected');
						$('select#bdist_id option[value=""]').attr('selected', 'selected');
						$('select#bward_id option[value=""]').attr('selected', 'selected');
			
					} // end if else
			
				}); // end copy bill to ship function
				*/
				
				// cloning
				var opt = '<option value=0>--Chọn--</option>';
				//clone selectboxs on load		
				<?php if(!$order){?>										  
				$('#city_id option').clone().appendTo('#bcity_id');
				$('#bcity_id option[value=' + $("#city_id").val() + ']').attr('selected', 'selected');
				$('#dist_id option').clone().appendTo('#bdist_id');
				$('#bdist_id option[value=' + $("#dist_id").val() + ']').attr('selected', 'selected');
				$('#ward_id option').clone().appendTo('#bward_id');
				$('#bward_id option[value=' + $("#ward_id").val() + ']').attr('selected', 'selected');
				<?php }?>	  
				//ajax load cities, districts, wards				
				$('#city_id').change(function() {
					$.get('/ajax/city.php?city_id='+$("#city_id").val(), function(ret) {					 		 
					  $('#dist_id,#bdist_id').empty().append(opt+ret);
					  $('#bcity_id,#ward_id,#bward_id').empty();
					  $('#city_id option').clone().appendTo('#bcity_id');	
					  $('#bcity_id option[value=' + $("#city_id").val() + ']').attr('selected', 'selected');	
					});
				});
				$('#dist_id').change(function() {
					$.get('/ajax/city.php?dist_id='+$("#dist_id").val(), function(ret) {					 
					  $('#ward_id,#bward_id').empty().append(opt+ret);	
					  $('#bdist_id').empty();				 					 				  
					  $('#dist_id option').clone().appendTo('#bdist_id');
					  $('#bdist_id option[value=' + $("#dist_id").val() + ']').attr('selected', 'selected');
					});
				});
				$('#ward_id').change(function() {	
					  $('#bward_id').empty();				  			  				  
					  $('#ward_id option').clone().appendTo('#bward_id');
					  $('#bward_id option[value=' + $("#ward_id").val() + ']').attr('selected', 'selected');					
				});
				
				//ajax load cities, districts, wards 2				
				$('#bcity_id').change(function() {
					$.get('/ajax/city.php?city_id='+$("#bcity_id").val(), function(ret) {					 		 
					  $('#bdist_id').empty().append(opt+ret);
					  $('#bward_id').empty();					 
					});
				});
				$('#bdist_id').change(function() {
					$.get('/ajax/city.php?dist_id='+$("#bdist_id").val(), function(ret) {					 
					  $('#bward_id').empty().append(opt+ret);
					});
				});
				//text input clone				
				$('#billing_fields input', ':visible', document.body).each(function(i) {					
					$(this).keyup(function(){						
						$("#shipping_fields input").eq(i).val($(this).val());
					});							
				});
				/*
				//select all
				$('#shipping_fields input', ':visible', document.body).each(function(i) {
					$(this).focus(function(){
						$(this).select();
					});											
				});	
				*/			
				
			});		
			
			function searchSuggest(){
				$("#settings-street-name").autocomplete('search_address_list.php', {width: 308});	
			}
		</script> 
                                    <?php 
                	if($order['bcity_id']==0 || $order['bdist_id']==0 || $order['bward_id']==0){
                        //$checked = ' checked="checked"';
                    }else{$checked = '';}
                ; ?>
                                    
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td align="left" valign="top"><h1 style="font-size:14px; font-family:Arial, Helvetica, sans-serif; color:#C40000; text-transform:uppercase">Thông tin thanh toán</h1></td>
                                        <td width="4%">&nbsp;</td>
                                        <td width="48%" align="left" valign="top"><h1 style="font-size:14px; padding-bottom:5px; font-family:Arial, Helvetica, sans-serif; color:#C40000; text-transform:uppercase">Thông tin giao hàng
                                            <!--<input id="copyaddress" name="copyaddress" type="checkbox" <?php echo $checked; ?> />
                                            <span style="font-size:11px; color:#666666; text-transform:none">&nbsp;(Giống thông tin thanh toán)</span>--></h1></td>
                                      </tr>
                                      <tr>
                                        <td align="left" valign="top" width="48%"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="billing_fields">
                                            <tr>
                                              <td align="left" height="35"><div class="field username">
                                                  <label>Họ tên</label>
                                                  <input type="text" size="20" name="realname" id="settings-realname" class="f-input" value="<?php if($order['realname']!=''){?> <?php echo $order['realname']; ?><?php } else { ?> <?php echo $login_user['realname']; ?> <?php }?>" require="true" datatype="require"  />
                                                </div></td>
                                            </tr>
                                            <tr align="left">
                                              <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                                            </tr>
                                            <tr>
                                              <td align="left" height="35"><div class="field">
                                                  <label id="enter-address-city-label" for="signup-city">Tỉnh/thành</label>
                                                  <select name="city_id" id="city_id"  class="f-city" require="true" datatype="require" style="width:180px">
                                                    <option value="">---Chọn---</option>
                                                    <?php 
                                                    $city_id = ($order['city_id']) ? $order['city_id']: $login_user['city_id'];          
                                                      ; ?>
                                                      <?php echo Utility::Option(Utility::OptionArray($allcities,'id','name'),$city_id); ?>
        
                                                  </select>
                                                </div></td>
                                            </tr>
                                            <tr align="left">
                                              <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                                            </tr>
                                            <tr>
                                              <td align="left" height="35"><?php 
                                              $dist_id = ($order['dist_id']) ? $order['dist_id']: $login_user['dist_id'];  
                                              $ward_id = ($order['ward_id']) ? $order['ward_id']: $login_user['ward_id'];
                                    		 ; ?>
                                                
                                                <div class="field">
                                                  <label id="enter-address-city-label" for="signup-city">Quận/Huyện</label>
                                                  <select name="dist_id" id="dist_id"  class="f-city" require="true" datatype="require" style="width:180px">
                                                    <option value="">---Chọn---</option>
                                                    <?php echo optiondistrict($dist_id,$city_id); ?>
                                                  </select>
                                                </div></td>
                                            </tr>
                                            <tr align="left">
                                              <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                                            </tr>
                                            <tr>
                                              <td align="left" height="35"><div class="field">                                              
                                                  <label>Phường/Xã</label>
                                                  <select name="ward_id" id="ward_id"  class="f-city" style="width:180px">
                                                    <option value="">---Chọn---</option>
                                                    <?php echo optionward($ward_id,$dist_id); ?>
                                                  </select>
                                                </div></td>
                                            </tr>
                                            <tr align="left">
                                              <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                                            </tr>
                                            <tr>
                                              <td align="left" height="35"><?php 
                    if ($order['house_number']!='' || $order['street_name']!=''){
                        $house_number = $order['house_number'];
                        $street_name = $order['street_name'];
                    }else{
                        $expl = explode(" ",$login_user['address']);
                        $house_number = $expl[0];
                        $street_name = trim(str_replace($expl[0],"",$login_user['address']));
                    }
                ; ?>
                                                <div class="field">
                                                  <label>Số nhà</label>
                                                  <input type="text" name="house_number" autocomplete="off" id="settings-address" class="f-input" value="<?php echo $house_number; ?>" require="true" datatype="require" />
                                                </div></td>
                                            </tr>
                                            <tr align="left">
                                              <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                                            </tr>
                                            <tr>
                                              <td align="left" height="35"><div class="field mobile">
                                                  <label>Tên đường</label>
                                                  <input type="text" name="street_name" class="f-input" autocomplete="off" onFocus="searchSuggest()" id="settings-street-name" require="true" value="<?php echo $street_name; ?>" datatype="require" />
                                                </div></td>
                                            </tr>
                                            <tr align="left">
                                              <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                                            </tr>
                                            <tr>
                                              <td align="left" height="35"><div class="field">
                                                  <label>Phòng-lầu-tòa nhà</label>
                                                  <input type="text" size="30" name="note_address" id="settings-note-address" class="f-input" value="<?php if($order['note_address']!=''){?> <?php echo $order['note_address']; ?><?php } else { ?><?php echo $login_user['note_address']; ?><?php }?>" />
                                                  <div style="clear:both;margin-left:110px;" class="hint">Ví dụ: P101, Lầu 10, Cao Ốc Bitexco</div>
                                                </div></td>
                                            </tr>
                                            <tr align="left">
                                              <td height="4" style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;"></td>
                                            </tr>
                                            <tr>
                                              <td align="left" height="35"><div class="field mobile">
                                                  <label>Di động</label>
                                                  <input type="text" size="30" name="mobile" id="settings-mobile" require="true" class="f-input number" value="<?php if($order['mobile']!=''){?> <?php echo $order['mobile']; ?><?php } else { ?> <?php echo $login_user['mobile']; ?> <?php }?>"  datatype="mobile" maxLength="11" style="font-weight:bold; font-size:16px;width:250px;" />
                                                </div></td>
                                            </tr>
                                            <tr>
                                              <td align="left" style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                                            </tr>
                                          </table></td>
                                        <td width="4%">&nbsp;</td>
                                        <td align="left" valign="top" width="48%"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="shipping_fields">
                                            <tr>
                                              <td height="35" align="left"><div class="field2 username">
                                                  <label>Họ tên</label>
                                                  <input type="text" size="20" name="settings-realname" id="settings-realname2" class="f-input" require="true" datatype="require" value="<?php if($order['brealname']!=''){?> <?php echo $order['brealname']; ?><?php } else { ?> <?php echo $login_user['realname']; ?> <?php }?>" />
                                                </div></td>
                                            </tr>
                                            <tr align="left"> 
                                              <td height="4" style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;"></td>
                                            </tr>
                                            <tr>
                                              <td height="35" align="left"><div class="field2">                                              
                                                  <label id="enter-address-city-label" for="signup-city">Tỉnh/thành</label>
                                                  <select name="bcity_id" id="bcity_id"  class="f-city" require="true" datatype="require" style="width:180px">
                                                 
                                                  <?php $bcity = ($order['bcity_id']) ? $order['bcity_id'] : $login_user['city_id']; ?>	
                                                  <?php echo Utility::Option(Utility::OptionArray($allcities,'id','name'),$bcity); ?>
                                                 
                                                  </select>
                                                </div></td>
                                            </tr>
                                            <tr align="left">
                                              <td height="4" style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;"></td>
                                            </tr>
                                            <tr>
                                              <td height="35" align="left"><div class="field2">
                                                  <label id="enter-address-city-label" for="signup-city">Quận/Huyện</label>
                                                  <select name="bdist_id" id="bdist_id"  class="f-city" require="true" datatype="require" style="width:180px">
                                                 
                                                  <?php $bdist = ($order['bdist_id']) ? $order['bdist_id'] : $login_user['dist_id']; ?>	
                                                  <?php echo optiondistrict($bdist,$bcity); ?>
                                                 
                                                    
                                                  </select>
                                                </div></td>
                                            </tr>
                                            <tr align="left">
                                              <td height="4" style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;"></td>
                                            </tr>
                                            <tr>
                                              <td height="35" align="left"><div class="field2">
                                                  <label>Phường/Xã</label>
                                                  <select name="bward_id" id="bward_id"  class="f-city" style="width:180px">
                                                    
                                                  <?php $bward = ($order['bward_id']) ? $order['bward_id'] : $login_user['ward_id']; ?>
                                                   <?php echo optionward($bward,$bdist); ?>
                                                  
                                                  </select>
                                                </div></td>
                                            </tr>
                                            <tr align="left">
                                              <td height="4" style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;"></td>
                                            </tr>
                                            <tr>
                                              <td height="35" align="left"><div class="field2">
                                                  <label>Số nhà</label>
                                                  <?php 
                    if ($order['bhouse_number']!='' || $order['bstreet_name']!=''){
                        $bhouse_number = $order['bhouse_number'];
                        $bstreet_name = $order['bstreet_name'];
                    }else{
                        $expl = explode(" ",$login_user['address']);
                        $bhouse_number = $expl[0];
                        $bstreet_name = trim(str_replace($expl[0],"",$login_user['address']));
                    }
                ; ?>
                                                  <input type="text" name="bhouse_number" autocomplete="off" id="settings-address2" class="f-input" value="<?php echo $bhouse_number; ?>" require="true" datatype="require" />
                                                </div></td>
                                            </tr>
                                            <tr align="left">
                                              <td height="4" style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;"></td>
                                            </tr>
                                            <tr>
                                              <td height="35" align="left"><div class="field2 mobile">
                                                  <label>Tên đường</label>
                                                  <input type="text" name="bstreet_name" class="f-input" autocomplete="off" onFocus="searchSuggest()" id="settings-street-name2" require="true" value="<?php echo $bstreet_name; ?>" datatype="require" />
                                                </div></td>
                                            </tr>
                                            <tr align="left">
                                              <td height="4" style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;"></td>
                                            </tr>
                                            <tr>
                                              <td height="35" align="left"><div class="field2">
                                                  <label>Phòng-lầu-tòa nhà</label>
                                                  <input type="text" size="30" name="bnote_address" id="settings-note-address2" class="f-input" value="<?php if($order['bnote_address']!=''){?> <?php echo $order['bnote_address']; ?><?php } else { ?><?php echo $login_user['note_address']; ?><?php }?>" />
                                                  <span class="hint" style="white-space:nowrap">Ví dụ: P101, Lầu 10, Cao Ốc Bitexco</span> </div></td>
                                            </tr>
                                            <tr align="left">
                                              <td height="4" style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;"></td>
                                            </tr>
                                            <tr>
                                              <td height="35" align="left"><div class="field2 mobile">
                                                  <label>Di động</label>
                                                  <input type="text" size="20" name="bmobile" id="settings-mobile2" require="true" class="f-input number" value="<?php if($order['bmobile']!=''){?> <?php echo $order['bmobile']; ?><?php } else { ?> <?php echo $login_user['mobile']; ?> <?php }?>"  datatype="mobile" maxLength="11" style="font-weight:bold; font-size:16px;" />
                                                </div></td>
                                            </tr>
                                            <tr>
                                              <td height="4" align="left" style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;"></td>
                                            </tr>
                                          </table></td>
                                      </tr>
                                    </table></td>
                                  
                                  <?php }?>
                                <tr>
                                  <td align="center" height="35"><div class="form-submit">
                                      <input type="hidden" name="id" value="<?php echo $order['id']; ?>" />
                                      <input type="submit" class="formbutton" name="buy" value="Tiếp tục mua" style="padding:7px" />
                                    </div></td>
                                </tr>
                            </table>
                          </form></td>
                        <td style="background: url(&quot;/static/css/images/faqbox_rightbg.gif&quot;) repeat-y scroll right center transparent;"></td>
                      </tr>
                      <tr>
                        <td><img src="/static/css/images/faqbox_bottomleft.gif" alt="" width="24" border="0" height="21"></td>
                        <td style="background: url(&quot;/static/css/images/faqbox_bottombg.gif&quot;) repeat-x scroll 0% 0% transparent;">&nbsp;</td>
                        <td><img src="/static/css/images/faqbox_bottomright.gif" alt="" width="23" border="0" height="21"></td>
                      </tr>
                  </table></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- bd end --> 
</div>
<!-- bdw end --> 
<script type="text/javascript">
window.x_init_hook_dealbuy = function(){	
	X.team.dealbuy_farefree("<?php echo abs(intval($qty)); ?>");
	X.team.dealbuy_totalprice();
};
</script> 
<?php include template("footer");?>