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
                            <p style="margin:5px 0;"><strong>Mã bàn giao </strong><input type="text" class="h-input" name="delivery_code" value="<?php echo $delivery_code; ?>" /></p>                            </td>
                            <td align="right" style="padding-left:3px;">
<p style="padding-top:3px;">



<script src="/static/js/jchain.js" type="text/javascript"></script><script type="text/javascript">				               
							jQuery(document).ready(function() {	
								$("#dist_id").chained("#city_id"); 
							});						
						</script>
                       <p><label id="enter-address-city-label" for="signup-city">Thành phố</label>
						<select name="city_id" id="city_id" class="f-city"><option value="">---Chọn---</option><?php echo Utility::Option(Utility::OptionArray($allcities,'id','name'), $city['id']); ?></select></p>
                        <p style="padding:3px;">
                       <label  id="enter-address-dist-label" for="signup-dist">Quận/Huyện</label>
							<select name="dist_id" id="dist_id" class="f-city" require="true" datatype="require"><option value="">---Chọn---</option><?php echo optiondistrict($dist_id); ?></select>
                            </p>                                               </td>
                  </tr>
				  <tr> <td align="right" nowrap="nowrap"><p style="margin:5px 0;"><strong>Order time:</strong></p></td><td><input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="cbday" value="<?php echo $cbday; ?>" /></td><td align="center">-</td><td><input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="ceday" value="<?php echo $ceday; ?>" /></td></tr>
                  <tr><td colspan="4" align="left" style="padding-left:10px;"><strong>Payment </strong>
                            <select name="payment_id" id="payment_id" class="h-input" require="true">
                            <option value='0' selected="selected">--Chon--</option>
                            <?php echo LoadPaymentMethod(); ?>
            </select> 
                            <script type="text/javascript">document.getElementById('payment_id').value = '<?php echo $payment_id; ?>'</script>
                            &nbsp;Tình trạng giao hàng
                            <select name="status_code" id="status_code" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($allstatus,'code','name'),$status_code); ?></select>
                            </span>  
                    <input type="text" class="h-input" name="state" value="<?php echo $state; ?>" /><input type="submit" value="Lọc dữ liệu" class="formbutton"  style="padding:5px 6px;"/></td>
                  </tr>
                  <tr>
                            <td align="right" nowrap="nowrap" colspan="8">
                            <p>ID Giỏ Hàng <input type="text" name="order_group" value="<?php echo $order_group; ?>" class="h-input"/></p>                            </td>
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
                    <th width="40">Gio Hang</th>
                    <th width="20">ID DH</th>
					<th width="350">Deal</th>
					<th width="300">User</th><th width="20" nowrap>Q.ty</th>
					<th width="60" nowrap>Total (<span class="money"><?php echo $currency; ?></span>)</th><!--<th width="160" nowrap>express</th>-->
					<th width="140" nowrap>State</th>
					<th width="130" nowrap>Operation</th></tr>
					<?php if(is_array($orders)){foreach($orders AS $index=>$one) { ?>
                   
					<tr style="background-color:#<?php echo getStatusColor($one['state']); ?>" id="order-list-id-<?php echo $one['id']; ?>">
					<td style="color:#fff;background:<?php echo toColor($one['create_time']+$one['user_id']); ?>"><strong><?php echo  $one['order_group']; ?></strong><br /></h></td>
						<td><?php echo $one['id']; ?></td>
						<td><?php echo $one['team_id']; ?>&nbsp;(<a class="deal-title" href="/team.php?id=<?php echo $one['team_id']; ?>" target="_blank"><?php echo $teams[$one['team_id']]['short_title']; ?></a>
                        <?php echo showColorSize($one); ?>
                        )</td>
						<td><!--<a href="/ajax/manage.php?action=userview&id=<?php echo $one['user_id']; ?>" class="ajaxlink"> --><?php echo $one['realname']; ?><!--<br /><?php echo $one['mobile']; ?></a>--><br/> 
                        <?php 
                        	if ($one['note_address']!=''){
                            	$note_address = $one['note_address'].", ";
                            }else{
                            	$note_address="";
                            }; ?>
                            <?php if($one['address']!=''){?><b style="color:#FA6D18"><?php echo $note_address; ?><?php echo $one['address']; ?> <?php }?>
                            <?php if(wardname($one['dist_id'],$one['ward_id'])){?><?php $wardname = wardname($one['dist_id'],$one['ward_id']); ?>,<?php echo $wardname['ward_name']; ?>,<?php }?>
                            <?php if(ename_dist($one['dist_id'])){?><?php $dists = ename_dist($one['dist_id']); ?><?php echo $dists['dist_name']; ?><br /></b><?php }?>
                            <?php if(total_order_user($users[$one['user_id']]['id'])>0){?><b style="color:#FA6D18"><?php echo $old_cus='Khách hàng cũ'; ?></b><?php } else { ?><b style="color:#C40000"><?php echo $old_cus='Khách hàng mới'; ?></b><?php }?>
                       
						<?php 
                            	$list = check_address_list($one['dist_id'], $one['ward_id'], $one['address']);
                                if($list['id']>0){
                                	$img="<img src=\"/static/css/images/tick.png\" alt=\"Địa chỉ đã được duyệt\" align=\"absmiddle\" />";
                                 }else{$img="<img src=\"/static/css/images/no.png\" alt=\"Địa chỉ chưa duyệt\" />";}; ?>
                      <?php echo $img; ?>
					   <br><?php echo date('Y-m-d H:i:s',$one['create_time']);; ?>
                         <?php if(Utility::IsMobile($users[$one['user_id']]['mobile'])){?>&nbsp;&raquo;&nbsp;<a href="/ajax/misc.php?action=sms&v=<?php echo $users[$one['user_id']]['mobile']; ?>" class="ajaxlink">SMS</a><?php }?></td>
						<td nowrap="nowrap"><?php echo $one['quantity']; ?><?php if($one['quantity_successful']>0){?><br />Thực giao: <?php echo $one['quantity_successful']; ?><?php }?></td>
						<td align="right"><strong><?php echo print_price(moneyit($one['origin']+$one['shipping_cost']+$one['payment_cost'])); ?></strong><?php if($one['money']>0){?><br />Đã trừ: <?php echo print_price(moneyit($one['money'])); ?><?php }?><?php if($one['credit']>0){?><br />Đã thanh toán: <?php echo print_price(moneyit($one['credit'])); ?><?php }?><?php if($one['state']=='pay'){?><br />NVGH thu: <?php echo print_price(moneyit($one['quantity_successful']*$one['price'] - $one['credit'] - $one['money']) ); ?><?php }?><?php if($one['payment_id']==5){?><br /><?php if((int)$one['transaction_id_nl']>0){?>Đã thanh toán:<?php } else { ?>Chưa thanh toán:<?php }?>  <?php echo print_price(moneyit($one['origin']+$one['shipping_cost']+$one['payment_cost'])); ?><br /><span style="color:#C40000">(<?php echo GetPaymentName($one['payment_id']); ?>)</span><?php }?></td>
                        <!--<td><?php echo $option_service[$one['service']]; ?></td>-->
                        <td><strong><?php echo getStatusName($one['state']); ?></strong><?php if($one['notes']){?><br /><i><?php echo $one['notes']; ?></i><?php }?><?php if($one['service']=='cashoffice'){?><strong><br />Nhận tại VP</strong><?php }?></td>
						<td align="center"><?php if(($one['state'] != 'pay') && ($one['state'] !='refund') &&  ($one['state'] !='delivered') ){?><a href="/ajax/manage.php?action=orderedit&id=<?php echo $one['id']; ?>" class="ajaxlink">Edit</a> | <?php }?><a href="/ajax/manage.php?action=orderview&id=<?php echo $one['id']; ?>" class="ajaxlink">Detail</a>
                        <?php if(( ($one['state']=='unpay' || $one['state']=='calling') && (in_array($login_user_id ,$restrictarray) == 0))){?> | <a href="/ajax/manage.php?action=orderconfirm&id=<?php echo $one['id']; ?>" class="ajaxlink">Confirm</a> | <a href="/ajax/manage.php?action=ordercancel&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to cancel it?">Cancel</a> | <a href="/ajax/manage.php?action=ordertransfer&id=<?php echo $one['id']; ?>" class="ajaxlink">Transfer</a><?php } else if((($one['state']=='canceled') && (in_array($login_user_id ,$restrictarray) == 0))) { ?> | <a href="/ajax/manage.php?action=orderconfirm&id=<?php echo $one['id']; ?>" class="ajaxlink">Confirm</a> <?php } else if(($one['state']=='confirmed' || $one['state']=='pending') && (in_array($login_user_id ,$restrictarray) == 0)) { ?>| <a href="/ajax/manage.php?action=ordercancel&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to cancel it?">Cancel</a><?php }?><?php if(($one['state']!='refund' && $one['service']!='cashoffice' && !in_array($one['state'], array('delivered','pay')) && ((in_array($login_user_id ,$restrictarray) == 0) || $login_user_id == 31266 ))){?> | <a href="/ajax/manage.php?action=orderoffice&id=<?php echo $one['id']; ?>" class="ajaxlink">Office<?php }?> | <a href="/ajax/manage.php?action=ordercopy&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to copy it?" title="Copy Order" style="color:#FF0000"><strong>Copy</strong></a><?php if(($one['state']!='pay') && ($one['state']!='refund') && ($one['state'] !='delivered') && (in_array($login_user_id ,$restrictarray) == 0) ){?> | <a href="/ajax/manage.php?action=orderhanging&id=<?php echo $one['id']; ?>" class="ajaxlink">Tạm hoãn</a><?php }?>
                       </td>
					</tr>
					<?php }}?>
                    <tr><td colspan="9" align="right"><strong><?php echo $total_voucher; ?> voucher</strong></td></tr>
					<tr><td colspan="9"><?php echo $pagestring; ?></tr>
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
