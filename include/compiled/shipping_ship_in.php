<?php include template("manage_header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_shipping('ship_in'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"><div class="subhead">
                    <h2>Quản lý bảng kê chưa nộp tiền (<?php echo $total; ?>)</h2>
				</div></div>
            <div class="box-content">
                
				<div class="sect" style="padding:5px; background:#FFFFCC">
					<form method="get">
						<p style="margin:5px 0; text-align:right">
                         Ngày <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="cbday" value="<?php echo $cbday; ?>" /> - 
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
                    <th>Mã BG</th>
                    <th>NVGH</th>
                    <th>Bàn giao</th>
                    <th>Trả bàn giao</th>                    
                    <th>Xác nhận nộp tiền</th>                                      
                    <th>Khóa?</th>
                    <th width="100">Task</th>
                    </tr>
					<?php if(is_array($rs)){foreach($rs AS $index=>$one) { ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>">
                    	<td><?php echo $one['in_id']; ?></td>
                        <td><a href="/backend/shipping/ship_out_data.php?out_id=<?php echo $one['out_id']; ?>" target="_blank"><strong><?php echo $one['out_id']; ?></strong></a></td>
                        <td><?php echo $shippers[$one['shipper']]['shipper_name']; ?></td>
                        <td> <?php echo $one['created']; ?><br /><?php echo $enc->decrypt('@4!@#$%@', $creators[$one['creator']]['email'] ); ?></td>
                        
                        <td><?php 
                        	$q = DB::GetQueryResult("SELECT updater, updated FROM ship_out WHERE out_id=".$one['out_id']);
                            $qa = DB::GetQueryResult("SELECT username FROM user WHERE id=".$q['updater']);
                        ; ?>
                        <?php echo $q['updated']; ?><br /><?php echo $enc->decrypt('@4!@#$%@', $qa['username'] ); ?> </td>
                        <td><?php echo $one['approved']; ?><br /><?php echo $approvers[$one['approver']]['username']; ?></td>
						
                          
                           <td><?php echo $one['locked']; ?></td>
						<td><a href="/backend/shipping/ship_in_data.php?in_id=<?php echo $one['in_id']; ?>" target="_blank">in</a> | <a href="/backend/shipping/ship_in_history.php?in_id=<?php echo $one['in_id']; ?>" target="_blank">lịch sử</a>
                        <?php 
                        	$q = DB::GetQueryResult("SELECT id FROM ship_in_data WHERE in_id=".$one['in_id']." AND deal_id>=305");
                        ; ?>
                        <?php if(($q['id']>0)){?>
                        <br><a href="/backend/shipping/export_ship_in_xml.php?in_id=<?php echo $one['in_id']; ?>" target="_blank"><img src="/static/css/images/export_xml.gif" border="0" /></a><?php if(($one['exported']=='Y')){?>&nbsp;<img src="/static/css/images/tick.png" border="0" /><?php }?><?php }?></td>
					</tr>
					<?php }}?>
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
