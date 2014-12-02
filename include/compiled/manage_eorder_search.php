<?php include template("manage_header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_order('search'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"><div class="subhead">
                    <h2>Tất cả đơn hàng</h2></div></div>
            <div class="box-content">
					<form method="get">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="filter-table">
                          <tr>
                            <td align="right" nowrap="nowrap"><p>Số HĐ <input type="text" name="id" value="<?php echo $id; ?>" class="h-input"/></p>
                            <p style="padding-top:3px;">Số Deal <input type="text" name="team_id" class="h-input number" value="<?php echo $team_id; ?>" /></p>                           </td>
                            <td align="right" nowrap="nowrap" style="padding-left:3px;">
                             <p style="padding-top:3px;">User <input type="text" name="uemail" class="h-input" value="<?php echo htmlspecialchars($uemail); ?>" /></p>
                            <p style="padding-top:3px;">ĐTDĐ <input type="text" class="h-input" name="mobile" value="<?php echo $mobile; ?>" /></p>                            </td>
                            <td align="right" nowrap="nowrap" style="padding-left:3px; padding-top:3px;">
                            <p><p style="margin:5px 0;">Shipper:<select name="shipper_id" onchange="this.form.submit();" id="shipper_id" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($allshipper,'id','shipper_name'),$shipper_id); ?></select></p>
                            <p style="margin:5px 0;"><strong>Mã bàn giao </strong><input type="text" class="h-input" name="delivery_code" value="<?php echo $delivery_code; ?>" /></p>
                            </td>
                            <td align="right" style="padding-left:3px;">
<p style="padding-top:3px;">



<script src="/static/js/jchain.js" type="text/javascript"></script><script type="text/javascript">				               
							jQuery(document).ready(function() {	
								$("#dist_id").chained("#city_id"); 
							});						
						</script>
                       <p><label id="enter-address-city-label" for="signup-city">Thành phố</label>
						<select name="city_id" id="city_id" class="f-city"><option value="">---Chọn---</option><?php echo Utility::Option(Utility::OptionArray($allcities,'id','name'), $city_id); ?></select></p>
                        <p style="padding:3px;">
                       <label  id="enter-address-dist-label" for="signup-dist">Quận/Huyện</label>
							<select name="dist_id" id="dist_id" class="f-city" require="true" datatype="require"><option value="">---Chọn---</option><?php echo optiondistrict($dist_id); ?></select>
                            </p>                                               </td>
                  </tr>
                  <tr><td colspan="4" align="left" style="padding-left:10px;"><strong>Payment </strong>
                            <select name="payment_id" id="payment_id" class="h-input" require="true">
                            <option value='0'>--Chon--</option>
                            <?php echo LoadPaymentMethod(); ?>
                            </select> 
                            <script type="text/javascript">document.getElementById('payment_id').value = '<?php echo $payment_id; ?>'</script>&nbsp;<input type="submit" value="Lọc dữ liệu" class="formbutton"  style="padding:5px 6px;"/></td>
                  </tr>
                   <tr>
                            <td align="right" nowrap="nowrap" colspan="8">
                            <p>ID Giỏ Hàng <input type="text" name="order_group" value="<?php echo $order_group; ?>" class="h-input"/></p>
                            </td>
                   </tr>
                        </table>
                        
					<form>
				
                
                <style>
				.coupons-table tr,.coupons-table td{
					background:none
				}
				</style>
                
                <div class="sect">
  <table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
    <tr>
    <th width="30">ID</th>
      <th width="100">ID</th>
      <th width="350">Thông tin thanh toán</th>
      <th width="350">Thông tin vận chuyển</th>
      <th width="60" nowrap>Thành tiền</th>
      <th width="40" nowrap>&nbsp;</th>
    </tr>
    <?php if(is_array($orders)){foreach($orders AS $index=>$one) { ?>
    <tr  style="background-color:#<?php echo getStatusColor($one['state']); ?>" id="order-list-id-<?php echo $one['id']; ?>">
      <td style="color:#fff;background:<?php echo toColor($one['create_time']+$one['user_id']); ?>"><strong><?php echo  $one['order_group']; ?></strong><br />
						<?php echo $one['id']; ?></td>
      <td>Deal: <strong><?php echo $one['team_id']; ?>&nbsp;(<a class="deal-title" href="/<?php echo $city['slug']; ?>/<?php echo seo_url($teams[$one['team_id']]['short_title'],$one['team_id'],$url_suffix); ?>" target="_blank"><?php echo $teams[$one['team_id']]['short_title']; ?></a>
      <?php echo showColorSize($one); ?>
      )</strong><br />Số đ.hàng: <a href="<?php if($one['state']!='transported'){?>/backend/order/orderedit.php?id=<?php echo $one['id']; ?>&redirect=<?php echo $_SERVER['REQUEST_URI']; ?><?php } else { ?>#<?php }?>" title="Sửa thông tin đơn hàng"><strong><?php echo $one['id']; ?></strong></a><br /><?php if($one['payment_id']==5 && (int)$one['transaction_id_nl']>0){?>
      Mã GD NL: <span style="color:#c40000"><strong><?php echo $one['transaction_id_nl']; ?></strong></span><br />
     <?php }?>
        <span style="white-space:nowrap">Ngày đặt: <?php echo date('Y-m-d H:i:s',$one['create_time']);; ?></span><br /><span style="white-space:nowrap">Trạng thái: <span style="color:#0000FF"><?php echo getStatusName($one['state']); ?></span></span></td>
      <td>Họ tên: <a href="/ajax/manage.php?action=userview&id=<?php echo $one['user_id']; ?>" class="ajaxlink"><strong><?php echo $one['realname']; ?></strong></a><br />
      
		<?php 
        	$note_address = "";$note_baddress="";
            if($one['note_address']!=''){
                $note_address = htmlspecialchars($one['note_address']).", ";
            }
            $one['billing_address'] = $note_address.htmlspecialchars($one['address']);
            if(ward_name($one['dist_id'],$one['ward_id'])){
                $wardname = ward_name($one['dist_id'],$one['ward_id']);
                $one['billing_address'] .=", ".strip_input($wardname['ward_name']);
            }
            if(ename_dist($one['dist_id'])){
                $dists = ename_dist($one['dist_id']);
                $one['billing_address'] .=", ".strip_input($dists['dist_name']);		
            }
            if(id_city($one['city_id'])){
                $citys = id_city($one['city_id']);
                $one['billing_address'] .=", ".strip_input($citys['name']);		
            }
            
            
            if($one['bnote_address']!=''){
                $note_address = htmlspecialchars($one['bnote_address']).", ";
            }
            $one['shipping_address'] = $note_address.htmlspecialchars($one['baddress']);
            if(ward_name($one['bdist_id'],$one['bward_id'])){
                $bwardname = ward_name($one['bdist_id'],$one['bward_id']);
                $one['shipping_address'] .=", ".strip_input($bwardname['ward_name']);
            }
            if(ename_dist($one['bdist_id'])){
                $bdists = ename_dist($one['bdist_id']);
                $one['shipping_address'] .=", ".strip_input($bdists['dist_name']);		
            }
            if(id_city($one['bcity_id'])){
                $bcitys = id_city($one['bcity_id']);
                $one['shipping_address'] .=", ".strip_input($bcitys['name']);		
            }
        
      ; ?>      
      
        Địa chỉ: <?php echo $one['billing_address']; ?><br />ĐT: <?php echo $one['mobile']; ?><br /><span style="color:#c40000"><strong><?php echo GetPaymentName($one['payment_id']); ?></strong></span></td>
      <td>Họ tên: <a href="/ajax/manage.php?action=userview&id=<?php echo $one['user_id']; ?>" class="ajaxlink"><strong><?php echo $one['brealname']; ?></strong></a><br />
        Địa chỉ: <?php echo $one['shipping_address']; ?><br />Điện thoại: <?php echo $one['bmobile']; ?><br /><span style="color:#c40000"><strong><?php echo GetShippingName($one['shipping_id']); ?></strong></span></td>
      <td align="right" style="color:#FF0000"><strong><?php echo print_price(moneyit(TotalOrder($one['id']))); ?></strong></td>
      <td align="center"><a href="/ajax/manage.php?action=orderview&id=<?php echo $one['id']; ?>" class="ajaxlink"><strong>Detail</strong></a><?php if(($one['state']!='transported') && ($one['state']!='pay') && ($one['state']!='refund') && (in_array($login_user_id ,$restrictarray) == 0) ){?><br /><a href="/ajax/manage.php?action=orderconfirm&id=<?php echo $one['id']; ?>" class="ajaxlink"><strong>Confirm</strong></a><br /><a href="/ajax/manage.php?action=ordercancel&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to cancel it?"><strong>Cancel</strong></a><?php }?></td>
    </tr>
    <?php }}?>
    <tr>
      <td colspan="9" align="right"><strong><?php echo $total_voucher; ?> voucher</strong></td>
    </tr>
    <tr>
      <td colspan="9"><?php echo $pagestring; ?>
    </tr>
  </table>
</div></div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("manage_footer");?>
