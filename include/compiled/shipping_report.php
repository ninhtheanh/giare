<?php include template("manage_header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_shipping('report'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head">
                    <h2>Tổng hợp giao nhận (<?php echo $total; ?>)</h2>
				</div>
				<div class="sect" style="padding:5px; background:#FFFFCC">
					<form method="get">
						<p style="margin:5px 0; text-align:right">
                         Từ ngày <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="cbday" value="<?php echo $cbday; ?>" /> 
                         đến ngày  
                       <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="ceday" value="<?php echo $ceday; ?>" />
                        Mã bàn giao <input type="text" name="out_id" value="<?php echo $out_id; ?>" class="h-input"/> 
                        Mã nộp tiền <input type="text" name="in_id" value="<?php echo $in_id; ?>" class="h-input"/> 
                        <input type="submit" value="Lọc dữ liệu" class="formbutton"  style="padding:6px 6px;"/>
                        </p>
                        <p style="margin:5px 0;">
                        NV b.giao <select name="creator" id="creator" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($alladmins,'id','username'),$creator); ?></select>
                        NV g.hàng <select name="shipper" id="shipper" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($allshipper,'id','shipper_name'),$shipper); ?></select>
                        NV trả BG <select name="updater" id="updater" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($alladmins,'id','username'),$updater); ?></select>
                        NV k.toán <select name="approver" id="approver" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($alladmins,'id','username'),$approver); ?></select>
                        
                          <select name="locked" id="locked" class="h-input" require="true">
                         <option value='0'>--tình trạng--</option>
                         <option value='Y'>đã quyết toán</option>
                         <option value='N'>chờ quyết toán</option>
                         </select>
                      
                       </p>                      
					<form>
				</div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
                    <tr>
                    <th valign="top">Mã BG/NT</th>                                   
                    <th valign="top">NVGH</th>
                    <th valign="top">Bàn giao</th>
                    <th valign="top">Trả bàn giao</th>                    
                    <th valign="top">Nộp tiền</th> 
                    <th  valign="top" width="30">Tổng ĐH</th> 
                    <th  valign="top"  width="30">Tổng phiếu</th> 
                    <th valign="top"  width="30">ĐH đã giao</th> 
                    <th valign="top"  width="30">Phiếu đã giao</th>
                    <th valign="top"  width="30">Phải thu</th>
                    <th valign="top"  width="30">Q.toán</th>
                    
                    </tr>
					<?php if(is_array($rs)){foreach($rs AS $index=>$one) { ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>">
                    	<td><strong><?php echo $one['out_id']; ?></strong>
                        <br />
                        <strong><?php echo $one['in_id']; ?></strong>
                        </td>                       
                        <td><?php echo $shippers[$one['shipper']]['shipper_name']; ?></td>
                        <td> <?php echo $one['created']; ?><br /><?php echo $enc->decrypt('@4!@#$%@', $creators[$one['creator']]['email'] ); ?>  </td>                        
                        <td><?php echo $one['updated']; ?><br /><?php echo $enc->decrypt('@4!@#$%@', $updaters[$one['updater']]['username'] ); ?> </td>
                        <td><?php echo $one['approved']; ?><br /><?php echo $enc->decrypt('@4!@#$%@', $approvers[$one['approver']]['username'] ); ?>  </td>
                         <td style="text-align:right; padding-right: 5px;"><?php echo $one['orders']; ?></td> 
                         <td style="text-align:right; padding-right: 5px;"><?php echo $one['vouchers']; ?></td> 
                         <td style="text-align:right; padding-right: 5px;"><?php echo $one['paid_orders']; ?></td> 
                         <td style="text-align:right; padding-right: 5px;"><?php echo $one['paid_vouchers']; ?></td>                         
                        <td style="text-align:right; padding-right: 5px;"><?php echo print_price($one['topay']); ?></td> 
                        <td align="center"><?php echo $one['locked']; ?></td>
                        <?php 
                        	$total_order +=$one['orders'];$total_vouchers +=$one['vouchers'];$total_paid +=$one['paid_orders'];$total_paid_vouchers +=$one['paid_vouchers'];$total_topay +=$one['topay'];
                        ; ?>						
					</tr>
					<?php }}?>
                    <tr style="color:#c40000">
                    	<td></td>                       
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>                        
                        <td>&nbsp;</td>
                        <td align="right"><strong>Tổng</strong></td>
                         <td style="text-align:right; padding-right: 5px;"><strong><?php echo $total_order; ?></strong></td> 
                         <td style="text-align:right; padding-right: 5px;"><strong><?php echo $total_vouchers; ?></strong></td> 
                         <td style="text-align:right; padding-right: 5px; color:#3399cc"><?php 
                 /*if(in_array($shipper,array(15,24,54,42))){
                     $plus = 250;
                     $total_paid_orders = $total_paid+$plus;
                  }else*/{
                  	$total_paid_orders = $total_paid;	
                 }
              ; ?><strong><?php echo $total_paid_orders; ?></strong></td> 
                         <td style="text-align:right; padding-right: 5px;"><strong><?php echo $total_paid_vouchers; ?></strong></td>                         
                        <td style="text-align:right; padding-right: 5px;"><strong><?php echo print_price($total_topay); ?></strong></td> 
                        <td align="center"><?php echo $one['locked']; ?></td>						
					</tr>
                    <tr><td colspan="10" align="right"><strong><?php echo $total; ?></strong></td></tr>
					<tr><td colspan="10"><?php echo $pagestring; ?></tr>
                    </table>
</div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("manage_footer");?>
