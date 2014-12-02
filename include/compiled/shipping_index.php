<?php include template("manage_header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_shipping('index'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"><div class="subhead">
                    <h2>Xác nhận nộp tiền (<?php echo $total; ?>)</h2>
				</div></div>
            <div class="box-content">
                
				<div class="sect" style="padding:5px; background:#FFFFCC">
					<form method="get">
						<p style="margin:5px 0; text-align:right">Ngày <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="cbday" value="<?php echo $cbday; ?>" /> - 
                       <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="ceday" value="<?php echo $ceday; ?>" />
                        Mã bàn giao <input type="text" name="out_id" value="<?php echo $out_id; ?>" class="h-input"/> 
                        Mã nộp tiền <input type="text" name="in_id" value="<?php echo $in_id; ?>" class="h-input"/> 
                        <input type="submit" value="Lọc dữ liệu" class="formbutton"  style="padding:1px 6px;"/>
                        </p>
                        <p style="margin:5px 0;">
                        NV bàn giao <select name="creator" id="creator" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($alladmins,'id','username'),$creator); ?></select>
                        NV giao hàng <select name="shipper" id="shipper" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($allshipper,'id','shipper_name'),$shipper); ?></select>
                        NV trả BG <select name="updater" id="updater" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($alladmins,'id','username'),$updater); ?></select>
                        NV kế toán <select name="approver" id="approver" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($alladmins,'id','username'),$approver); ?></select>
                      
                       </p>                      
					<form>
				</div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
                    <tr>
                    <th width="50">Mã NT</th>
                    <th width="50">Mã BG</th>
                    <th>Ngày/NV BG</th>
                    <th>NV giao hàng</th>
                    <th>Ngày/NV trả BG</th>                   
                    <th>Ngày/NV xác nhận</th>
                    <th>Khóa?</th>
                    <th width="100">Task</th>
                    </tr>
					<?php if(is_array($rs)){foreach($rs AS $index=>$one) { ?>
	
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>">
                    	<td><?php echo $one['in_id']; ?></td>
						<td><?php echo $one['out_id']; ?></td>
                        <td><?php echo $one['created']; ?><br /><?php echo $enc->decrypt('@4!@#$%@', $creators[$one['creator']]['email'] ); ?></td>					
                        <td><?php echo $shippers[$one['shipper']]['shipper_name']; ?></td>
                        <td><?php echo $one['updated']; ?><br /><?php echo $updaters[$one['updater']]['username']; ?></td>
                        
                         <td><?php echo $one['approved']; ?><br /><?php echo $approvers[$one['approver']]['username']; ?></td>
                        
                           <td><?php echo $one['locked']; ?></td>
						<td><a href="/backend/shipping/ship_in_data.php?in_id=<?php echo $one['in_id']; ?>" target="_blank">in</a><?php if(in_array($login_user['id'],array(1,150825,161144))){?> | <a href="/backend/shipping/ship_in_history.php?in_id=<?php echo $one['in_id']; ?>" target="_blank">lịch sử</a><br />
                        <a href="/backend/shipping/?process=true&in_id=<?php echo $one['in_id']; ?>&out_id=<?php echo $one['out_id']; ?>" onclick="javascript: if (confirm('Xác nhận nộp tiền bảng kê nộp tiền số <?php echo $one['in_id']; ?>?')) { return true; } else { return false }; ">Xác nhận NT</a><?php }?>
                        </td>
					</tr>
					<?php }}?>
                    <tr><td colspan="9" align="right"><strong><?php echo $total; ?></strong></td></tr>
					<tr><td colspan="9"><?php echo $pagestring; ?></tr>
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
