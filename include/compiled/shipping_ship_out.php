<?php include template("manage_header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_shipping('ship_out'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"><div class="subhead">
                    <h2>Quản lý biên bản bàn giao (<?php echo $count; ?>)</h2>
				</div></div>
            <div class="box-content">
                
				<div class="sect" style="padding:5px; background:#FFFFCC">
					<form method="get">
						<p style="margin:5px 0; text-align:right">Mã bàn giao <input type="text" name="out_id" value="<?php echo htmlspecialchars($out_id); ?>" class="h-input"/> 
                        <input type="submit" value="Lọc dữ liệu" class="formbutton"  style="padding:5px 6px;"/>
                        </p>
                        <p style="margin:5px 0;">
                        NV bàn giao <select name="creator" id="creator" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($alladmins,'id','username'),$creator); ?></select>
                        NV giao hàng <select name="shipper" id="shipper" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($allshipper,'id','shipper_name'),$shipper); ?></select>
                        NV trả BG <select name="updater" id="updater" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($alladmins,'id','username'),$updater); ?></select>
                       Ngày BG <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="cbday" value="<?php echo $cbday; ?>" /> - 
                       <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="ceday" value="<?php echo $ceday; ?>" />
                       </p>                      
					<form>
				</div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="50">Mã BG</th>
                    <th>Ngày bàn giao</th>
                    <th>NV bàn giao</th>
                    <th>NV giao hàng</th>                   
                    <th>NV trả BG</th>
                    <th>Ngày trả BG</th>
                    <th width="50" nowrap>ĐH</th>
                    <th width="70" nowrap>Task</th>
                    </tr>
					<?php if(is_array($rs)){foreach($rs AS $index=>$one) { ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>">
						<td><?php echo $one['out_id']; ?></td>
                        <td><?php echo $one['created']; ?></td>
						<td><?php echo $enc->decrypt('@4!@#$%@', $creators[$one['creator']]['email'] ); ?></td>
                        <td><?php echo $shippers[$one['shipper']]['shipper_name']; ?></td>
                        <td><?php echo $updaters[$one['updater']]['username']; ?></td>
                        <td><?php echo $one['updated']; ?></td>
                        <td width="50" align="center"><?php $total_order = DB::GetQueryResult("SELECT count(order_id) as total_order FROM `ship_out_data` WHERE out_id=".$one['out_id']); $total_order['total_order'];$total +=$total_order['total_order'];; ?></td>
						<td><a href="/backend/shipping/ship_out_data.php?out_id=<?php echo $one['out_id']; ?>" target="_blank">in</a> | <a href="/backend/shipping/ship_out_history.php?out_id=<?php echo $one['out_id']; ?>" target="_blank">lịch sử</a><?php 
                        	$q = DB::GetQueryResult("SELECT id FROM ship_out_data WHERE out_id=".$one['out_id']." AND deal_id>=305");
                        ; ?>
                        <?php if(($q['id']>0)){?>
                                 <br><a href="/backend/shipping/export_ship_out_excel.php?out_id=<?php echo $one['out_id']; ?>" target="_blank"><img src="/static/img/excel_icon.gif" border="0" /></a><?php if(($one['exported']=='Y')){?>&nbsp;<img src="/static/css/images/tick.png" border="0" /><?php }?><?php }?></td>
					</tr>
					<?php }}?>
                    <tr><td colspan="9" align="right">Tổng ĐH: <strong><?php echo $total; ?></strong></td></tr>
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
