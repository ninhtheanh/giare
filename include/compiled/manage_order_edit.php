<?php include template("manage_header");?>

<div id="bdw" class="bdw">
  <div id="bd" class="cf">
    <div id="coupons">
      <div class="subdashboard" id="dashboard">
        <ul>
          <?php echo mcurrent_order('index'); ?>
        </ul>
      </div>
      <div id="content" class="coupons-box clear mainwide">
        <div class="box clear">
          <div class="subbox-top">
            <div class="subhead">
              <h2>Sửa thông tin đơn hàng số <?php echo $order['id']; ?> - Deal:<?php echo $team['short_title']; ?></h2>
            </div>
          </div>
          <div class="box-content">
            <div style="padding:10px; margin:0px;">
              <link rel="stylesheet" type="text/css" href="/static/css/jquery.autocomplete.css" />
              <script type='text/javascript' src="/static/js/jquery.autocomplete.js"></script> 
            
              <script type='text/javascript'>						                
				jQuery(document).ready(function() {	
				
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
					//select all
					$('#shipping_fields input', ':visible', document.body).each(function(i) {
						$(this).focus(function(){
							$(this).select();
						});											
					});				
					
				});	
				
				
				function searchSuggest(){
					$("#street_name").autocomplete('/team/search_address_list.php', {width: 308});	
				}
				function searchbSuggest(){
					$("#bstreet_name").autocomplete('/team/search_address_list.php', {width: 308});	
				}
				function checkSubmit(){
					var max_qty = <?php echo $team['per_number']; ?>;
					var qty = $("#quantity").val();
					if(max_qty>0){
						if(qty>max_qty){
							alert("Số lượng không được lớn hơn "+max_qty);
							$("#quantity").val("<?php echo $order['quantity']; ?>");
							return false;
						}
					}
					return true;
				}	
		</script>
              <form id="main" method="post" action="/backend/order/orderedit.php?id=<?php echo $order['id']; ?>&redirect=<?php echo $_SERVER['REQUEST_URI']; ?>" class="validator" onsubmit="return checkSubmit();">
                <input type="hidden" name="id" value="<?php echo $order['id']; ?>" /><input type="hidden" name="weight" value="<?php echo $team['weight']; ?>" />
                <table width="100%" border="0">
                  <tr>
                    
                    <td colspan="3" align="left" nowrap="nowrap" style="padding:5px"><strong>Số lượng</strong> <input <?php if($team['per_number']>0){?>maxlength="3"<?php }?> type="text" name="quantity" id="quantity" value="<?php echo $order['quantity']; ?>" require="true" datatype="require" class="f-input" /><?php if($team['per_number']>0){?>&nbsp;<font color="red" style="font-size:11px;"><strong>Số lượng tối đa: <?php echo $team['per_number']; ?></strong></font><?php }?></td>
                  </tr>
                  <tr>
                    <td style="color:#c40000; padding:5px;"><strong>Thông tin thanh toán</strong></td>
                    <td width="1%">&nbsp;</td>
                    <td width="32%" style="color:#c40000; padding:5px;"><strong>Thông tin giao hàng</strong></td>
                  </tr>
                  <tr>
                    <td align="left" width="49%"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="billing_fields">
                        <tr> <td align="right" nowrap="nowrap"><b>Họ tên</b></td>
                    <td align="left" style="padding:5px"><input type="text" name="realname" value="<?php echo $order['realname']; ?>" require="true" datatype="require" class="f-input" style="width:200px" /></td></tr>
                        <tr>
                          <td width="10%" align="right"><strong>Tỉnh/TP</strong></td>
                          <td width="90%" align="left" style="padding:5px"><select name="city_id" id="city_id" class="f-input">
                              
                              
                              
              <?php echo Utility::Option(Utility::OptionArray($allcities, 'id', 'name'), $order['city_id']); ?>
            
                            
                            
                            </select></td>
                        </tr>
                        <tr>
                          <td align="right"><strong>Quận/Huyện</strong></td>
                          <td align="left" style="padding:5px;"><select name="dist_id" id="dist_id"  class="f-input" datatype="require" require="true">
                              
                              
                              
              <?php echo optiondistrict($order['dist_id'],$order['city_id']); ?>
            
                            
                            
                            </select></td>
                        </tr>
                        <tr>
                        <tr>
                          <td><div align="right"><strong>Phường/Xã</strong></div></td>
                          <td align="left" style="padding:5px;"><select name="ward_id" id="ward_id"  class="f-input">
                              <option value="">---Chọn---</option>
                              
                              
                              
              <?php echo optionward($order['ward_id'],$order['dist_id']); ?>
            
                            
                            
                            </select></td>
                        </tr>
                        <tr>
                          <td><div align="right"><strong>Tên đường</strong></div></td>
                          <td align="left" style="padding:5px;"><input type="text" name="street_name" autocomplete="off" onfocus="searchSuggest()" id="street_name" value="<?php echo $order['street_name']; ?>"  class="f-input" style="width:250px" /></td>
                        </tr>
                        <tr>
                          <td><div align="right"><strong>Số nhà</strong></div></td>
                          <td align="left" style="padding:5px;"><input type="text" name="house_number" id="house_number" value="<?php echo $order['house_number']; ?>"  class="f-input" style="width:100px" /></td>
                        </tr>
                        <tr>
                          <td><div align="right"><strong>Phòng-lầu-tòa nhà</strong></div></td>
                          <td align="left" style="padding:5px;"><input type="text" name="note_address" value="<?php echo $order['note_address']; ?>" class="f-input" style="width:250px" /></td>
                        </tr>
                        <tr>
                          <td><div align="right"><strong>Điện thoại</strong></div></td>
                          <td align="left" style="padding:5px;"><input type="text" name="mobile" value="<?php echo $order['mobile']; ?>" require="true" datatype="mobile" class="f-input number" style="width:250px" /></td>
                        </tr>
                        <tr>
                          <td><div align="right" style="white-space:nowrap"><strong>Phương thức </strong></div></td>
                          <td align="left" style="padding:5px;"><select name="payment_id" id="payment_id" class="f-input" >
                              <option value='' selected>---Select---</option>
                <?php echo $payment_lst; ?>
                            </select> <?php $shipping_cost = (int)$order['shipping_cost'];$payment_cost = (int)$order['payment_cost'];; ?>
                            <script type="text/javascript" language="javascript">$("#payment_id").val("<?php echo $payment_id; ?>-<?php echo $payment_cost; ?>");</script></td>
                        </tr>
                      </table></td>
                    <td width="2%">&nbsp;</td>
                    <td colspan="2" width="49%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="shipping_fields">
                        <tr> <td width="18%" align="right" nowrap="nowrap"><b>Họ tên</b></td>
                    <td width="82%" align="left" style="padding:5px"><input type="text" name="brealname" value="<?php echo $order['brealname']; ?>" require="true" datatype="require" class="f-input" style="width:200px" /></td></tr><tr>
                          <td align="right"><strong>Tỉnh/TP</strong></td>
                          <td align="left" style="padding:5px"><select name="bcity_id" id="bcity_id"  class="f-city" require="true" datatype="require" style="width:180px">
                              <?php if($order){?>	
                                                  <?php echo Utility::Option(Utility::OptionArray($allcities,'id','name'),$order['bcity_id']); ?>
                                                  <?php }?>
                            </select></td>
                        </tr>
                        <tr>
                          <td align="right"><strong>Quận/Huyện</strong></td>
                          <td align="left" style="padding:5px;"><select name="bdist_id" id="bdist_id"  class="f-input" datatype="require" require="true">
                              
                              <?php if($order){?>	
                                                  <?php echo optiondistrict($order['bdist_id'],$order['bcity_id']); ?>
                                                  <?php }?>
                              
                            </select></td>
                        </tr>
                        <tr>
                          <td><div align="right"><strong>Phường/Xã</strong></div></td>
                          <td align="left" style="padding:5px;"><select name="bward_id" id="bward_id"  class="f-input" >
                              
                              <?php if($order){?>	
                                                   <?php echo optionward($order['bward_id'],$order['bdist_id']); ?>
                                                  <?php }?>
                              
                            </select></td>
                        </tr>
                        <tr>
                          <td><div align="right"><strong>Tên đường</strong></div></td>
                          <td align="left" style="padding:5px;"><input type="text" name="bstreet_name" autocomplete="off" onfocus="searchbSuggest()" id="bstreet_name" value="<?php echo $order['bstreet_name']; ?>" class="f-input" style="width:250px" /></td>
                        </tr>
                        <tr>
                          <td><div align="right"><strong>Số nhà</strong></div></td>
                          <td align="left" style="padding:5px;"><input type="text" name="bhouse_number" id="bhouse_number" value="<?php echo $order['bhouse_number']; ?>" class="f-input" style="width:100px" /></td>
                        </tr>
                        <tr>
                          <td><div align="right"><strong>Phòng-lầu-tòa nhà</strong></div></td>
                          <td align="left" style="padding:5px;"><input type="text" name="bnote_address" value="<?php echo $order['bnote_address']; ?>"  class="f-input" style="width:250px" /></td>
                        </tr>
                        <tr>
                          <td><div align="right"><strong>Điện thoại</strong></div></td>
                          <td align="left" style="padding:5px;"><input type="text" name="bmobile" value="<?php echo $order['bmobile']; ?>" require="true" datatype="mobile" class="f-input number" style="width:250px" /></td>
                        </tr>
                        <tr>
                          <td align="right" valign="top"><strong>Phương thức</strong></td>
                          <td align="left" style="padding:5px;"><div id="shippingmethod">
                              <select name="shipping_id" id="shipping_id" class="f-input" >
                                <option value=''>---Select---</option>
                                <?php if(in_array($order['bward_id'],array(313,316))){?>
                                <option value="1-0">Giao hàng tận nơi trong nội thành (Hồ Chí Minh)</option>
                                <?php }?>
								<?php echo $shipping_lst; ?>
                              </select>
                              <script type="text/javascript" language="javascript">$("#shipping_id").val("<?php echo $order['shipping_id']; ?>-<?php echo $shipping_cost; ?>");</script> 
                            </div></td>
                        </tr>
                      </table></td>
                  </tr>
                  <tr>
                    <td align="left" colspan="3" style="padding-left:35px;"><strong>Ghi chú</strong> <textarea name="notes" class="f-textarea" style="width:500px;"><?php echo $order['notes']; ?></textarea></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left" style="padding:5px; padding-left:85px;"><input type="checkbox" name="is_update_address" value="1" />
                      Cập nhật lại địa chỉ&nbsp;&nbsp;&nbsp;
                      
                      <input type="checkbox" name="paid" value="1" <?php echo $checked; ?> />
                      Đã thanh toán&nbsp;&nbsp;&nbsp;<?php if($order['payment_id']==5){?><span id="id_nl">Mã GD Ngân lượng<input type="text" name="transaction_id_nl" value="<?php echo $order['transaction_id_nl']; ?>" class="f-input" require="true" datatype="require" /></span><?php }?></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="left" style="padding-left:85px;"><input type="submit" value="Update" class="formbutton" /></td>
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

<?php include template("manage_footer");?> 