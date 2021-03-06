<div id="order-pay-dialog" class="order-pay-dialog-c" style="width:800px;">
  <h3><span id="order-pay-dialog-close" class="close" onclick="return X.boxClose();">Close</span>Edit order No. <?php echo $order['id']; ?></h3>
  <div style="color:#c40000"><strong>Deal:</strong> <?php echo $team['short_title']; ?></div>
  <div style="overflow-x:hidden;padding:10px;">
    <link rel="stylesheet" type="text/css" href="/static/css/jquery.autocomplete.css" />
    <script type='text/javascript' src="/static/js/jquery.autocomplete.js"></script> 
    <script src="/static/js/jchain.js" type="text/javascript"></script> 
    <script type="text/javascript" src="/static/js/jquery.selectboxes.pack.js" charset="utf-8"></script>
    <script type='text/javascript'>						                
				/*var dist_id; var ward_id;
				function getDistId(){
					return $("#dist_id").val();
				}
				function getWardId(){
					return $("#ward_id").val();
				}*/
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
							$("#quantity").val(<?php echo $order['quantity']; ?>);
							return false;
						}
					}
					return true;
				}	
		</script>
    <form method="post" action="/backend/order/edit.php" class="validator" onsubmit="return checkSubmit();">
      <input type="hidden" name="id" value="<?php echo $order['id']; ?>" /><input type="hidden" name="weight" value="<?php echo $team['weight']; ?>" />
      <table width="100%" border="0">
          <tr>
          <td colspan="3" align="left" nowrap="nowrap" style="padding:5px"><strong>Số lượng</strong><input <?php if($team['per_number']>0){?>maxlength="3"<?php }?> type="text" name="quantity" id="quantity" value="<?php echo $order['quantity']; ?>" require="true" datatype="require" class="f-input" /><?php if($team['per_number']>0){?>&nbsp;<font color="red" style="font-size:11px;"><strong>Số lượng tối đa: <?php echo $team['per_number']; ?></strong></font><?php }?></td>
          </tr>
          <tr>
          <td style="color:#c40000; padding:5px;"><strong>Thông tin thanh toán</strong></td>
          <td >&nbsp;</td>
          <td align="left" valign="top" style="color:#c40000; padding:5px;"><strong>Thông tin giao hàng</strong></td>
        </tr>
          <tr>
            <td align="left" valign="top">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="billing_fields"><tr><td align="right" nowrap="nowrap"><b>Họ tên</b></td>
          <td align="left" style="padding:5px"><input type="text" name="realname" value="<?php echo $order['realname']; ?>" require="true" datatype="require" class="f-input" style="width:200px" /></td></tr>
            	<tr>
          <td width="10%" align="right"><strong>Tỉnh/TP</strong></td>
          <td width="90%" align="left" style="padding:5px"><select name="city_id" id="city_id" class="f-input"><?php 
                                                    $city_id = ($order['city_id']) ? $order['city_id']: $login_user['city_id'];          
                                                      ; ?>
              <?php echo Utility::Option(Utility::OptionArray($allcities, 'id', 'name'), $city_id); ?>
            </select></td></tr>
             <tr>
          <td align="right"><strong>Quận/Huyện</strong></td>
          <td align="left" style="padding:5px;">
          <?php 
              $dist_id = ($order['dist_id']) ? $order['dist_id']: $login_user['dist_id'];  
              $ward_id = ($order['ward_id']) ? $order['ward_id']: $login_user['ward_id'];
             ; ?>
          <select name="dist_id" id="dist_id"  class="f-input" datatype="require" require="true">
              <?php echo optiondistrict($dist_id,$city_id); ?>
            </select></td></tr>
            <tr><tr>
          <td><div align="right"><strong>Phường/Xã</strong></div></td>
          <td align="left" style="padding:5px;"><select name="ward_id" id="ward_id"  class="f-input" datatype="require" require="true">
              <option value="">---Chọn---</option>
              <?php echo optionward($ward_id,$dist_id); ?>
            </select></td></tr>
            <tr><td><div align="right"><strong>Tên đường</strong></div></td>
          <td align="left" style="padding:5px;"><input type="text" name="street_name" autocomplete="off" onfocus="searchSuggest()" id="street_name" value="<?php echo $order['street_name']; ?>" require="true" datatype="require" class="f-input" style="width:250px" /></td></tr>
          <tr><td><div align="right"><strong>Số nhà</strong></div></td>
          <td align="left" style="padding:5px;"><input type="text" name="house_number" id="house_number" value="<?php echo $order['house_number']; ?>" require="true" datatype="require" class="f-input" style="width:100px" /></td></tr>
          <tr><td><div align="right"><strong>Phòng-lầu-tòa nhà</strong></div></td>
          <td align="left" style="padding:5px;"><input type="text" name="note_address" value="<?php echo $order['note_address']; ?>" require="true" datatype="require" class="f-input" style="width:250px" /></td></tr>
          <tr><td><div align="right"><strong>Điện thoại</strong></div></td>
          <td align="left" style="padding:5px;"><input type="text" name="mobile" value="<?php echo $order['mobile']; ?>" require="true" datatype="mobile" class="f-input number" style="width:250px" /></td></tr>
          <tr><td><div align="right" style="white-space:nowrap"><strong>Phương thức </strong></div></td>
          <td align="left" style="padding:5px;"><?php $shipping_cost = (int)$order['shipping_cost'];$payment_cost = (int)$order['payment_cost'];; ?><select name="payment_id" id="payment_id" class="f-input">
              <option value='' selected>---Select---</option>
               <?php if(in_array($order['ward_id'],array(313,316))){?>
              <option value="1-<?php echo $payment_cost; ?>">Thanh toán bằng tiền mặt</option>
              <?php }?>
                <?php echo $payment_lst; ?>
            </select>
            <script type="text/javascript" language="javascript">$("#payment_id").val("<?php echo $payment_id; ?>-<?php echo $payment_cost; ?>");</script></td></tr>
            </table>
            </td>
            <td>&nbsp;</td>
            <td align="left" valign="top" style="padding-left:15px;">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="shipping_fields"><tr><td align="right" nowrap="nowrap"><b>Họ tên</b></td>
          <td align="left" style="padding:5px"><input type="text" name="brealname" value="<?php if($order['brealname']!=''){?><?php echo $order['brealname']; ?><?php } else { ?><?php echo $order['realname']; ?><?php }?>" require="true" datatype="require" class="f-input" style="width:200px" /></td></tr><tr><td align="right"><strong>Tỉnh/TP</strong></td>
          <td align="left" style="padding:5px"><?php $bcity = ($order['bcity_id']) ? $order['bcity_id'] : $login_user['city_id']; ?>	<select name="bcity_id" id="bcity_id" class="f-input"><?php echo Utility::Option(Utility::OptionArray($allcities, 'id', 'name'), $bcity); ?></select></td></tr>
          <tr><td align="right"><strong>Quận/Huyện</strong></td>
          <td align="left" style="padding:5px;">
          <?php $bdist = ($order['bdist_id']) ? $order['bdist_id'] : $login_user['dist_id']; ?>	<select name="bdist_id" id="bdist_id"  class="f-input" datatype="require" require="true"><?php echo optiondistrict($bdist,$bcity); ?>
            </select></td></tr>
          <tr><td><div align="right"><strong>Phường/Xã</strong></div></td>
          <td align="left" style="padding:5px;"> <?php $bward = ($order['bward_id']) ? $order['bward_id'] : $login_user['ward_id']; ?><select name="bward_id" id="bward_id"  class="f-input" datatype="require" require="true">
              <?php echo optionward($bward,$bdist); ?>
            </select></td></tr>
            <tr><td><div align="right"><strong>Tên đường</strong></div></td>
          <td align="left" style="padding:5px;"><input type="text" name="bstreet_name" autocomplete="off" onfocus="searchbSuggest()" id="bstreet_name" value="<?php echo $order['bstreet_name']; ?>" require="true" datatype="require" class="f-input" style="width:250px" /></td></tr>
          <tr><td><div align="right"><strong>Số nhà</strong></div></td>
          <td align="left" style="padding:5px;"><input type="text" name="bhouse_number" id="bhouse_number" value="<?php echo $order['bhouse_number']; ?>" require="true" datatype="require" class="f-input" style="width:100px" /></td></tr>
          <tr><td><div align="right"><strong>Phòng-lầu-tòa nhà</strong></div></td>
          <td align="left" style="padding:5px;"><input type="text" name="bnote_address" value="<?php echo $order['bnote_address']; ?>" require="true" datatype="require" class="f-input" style="width:250px" /></td></tr>
          <tr><td><div align="right"><strong>Điện thoại</strong></div></td>
          <td align="left" style="padding:5px;"><input type="text" name="bmobile" value="<?php echo $order['bmobile']; ?>" require="true" datatype="mobile" class="f-input number" style="width:250px" /></td></tr>
          <tr><td align="right" valign="top" nowrap="nowrap"><strong>Phương thức</strong></td>
          <td align="left" style="padding:5px;"><div id="shippingmethod">
              <select name="shipping_id" id="shipping_id" class="f-input" style="width:250px">
                <option value=''>---Select---</option>
               
                <?php if(in_array($order['bward_id'],array(313,316))){?>
              <option value="1-<?php echo $shipping_cost; ?>">Giao hàng tận nơi trong nội thành (Hồ Chí Minh)</option>
              <?php }?>
              
					<?php echo $shipping_lst; ?>
              </select><script type="text/javascript" language="javascript">$("#shipping_id").val("<?php echo $order['shipping_id']; ?>-<?php echo $shipping_cost; ?>");</script>
            </div>
        </td></tr>
          </table>
            </td>
          </tr>
          <tr>
            <td align="left" colspan="3" style="padding-top:5px;"><strong>Ghi chú</strong><textarea name="notes" class="f-textarea" style="width:500px;"><?php echo $order['notes']; ?></textarea></td>
          </tr>
          <tr>
            <td colspan="3" align="left" style="padding:5px; padding-left:50px"><input type="checkbox" name="is_update_address" value="1" />
            Cập nhật lại địa chỉ&nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="is_home_address" value="1" />
            Nhà riêng&nbsp;&nbsp;&nbsp;<input type="checkbox" name="paid" value="1" /> 
            Đã thanh toán&nbsp;&nbsp;&nbsp;<?php if($order['payment_id']==5){?><span id="id_nl">Mã GD Ngân lượng<input type="text" name="transaction_id_nl" value="<?php echo $order['transaction_id_nl']; ?>" class="f-input" require="true" datatype="require" /></span><?php }?></td>
          </tr>
          <tr>
            <td colspan="3" align="left" style="padding-left:50px"><input type="submit" value="Update" class="formbutton" /></td>
          </tr>
        </table>

    </form>
  </div>
</div>
