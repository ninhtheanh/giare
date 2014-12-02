<?php include template("manage_header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_report('sales_amount'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"><div class="subhead">
                    <h2>Sales Amount Report (<?php echo $count; ?>)</h2>
				</div></div>
            <div class="box-content">
                
				<div class="sect" style="padding:5px; background:#FFFFCC">
					<form method="get">
						<p style="margin:5px 0; text-align:right">
                        <input type="submit" value="Lọc dữ liệu" class="formbutton"  style="padding:5px 6px;"/>
                        </p>
                        <p style="margin:5px 0;">
                        Today <input type="radio" name="period" checked="checked" value="today" />
                        This week <input type="radio" name="period" value="thisweek" />
                        This month <input type="radio" name="period" value="thismonth" />
                        This year <input type="radio" name="period" value="thisyear" />                       
                       From <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="cbday" value="<?php echo $cbday; ?>" /> - 
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
						<td><?php echo $creators[$one['creator']]['username']; ?></td>
                        <td><?php echo $shippers[$one['shipper']]['shipper_name']; ?></td>
                        <td><?php echo $updaters[$one['updater']]['username']; ?></td>
                        <td><?php echo $one['updated']; ?></td>
                        <td width="50" align="center"><?php $total_order = DB::GetQueryResult("SELECT count(order_id) as total_order FROM `ship_out_data` WHERE out_id=".$one['out_id']); $total_order['total_order'];$total +=$total_order['total_order'];; ?></td>
						<td><a href="/backend/shipping/ship_out_data.php?out_id=<?php echo $one['out_id']; ?>" target="_blank">in</a> | <a href="/backend/shipping/ship_out_history.php?out_id=<?php echo $one['out_id']; ?>" target="_blank">lịch sử</a><?php 
                        	$q = DB::GetQueryResult("SELECT id FROM ship_out_data WHERE out_id=".$one['out_id']." AND deal_id>=305");
                        ; ?>
                        <?php if(($q['id']>0)){?>
                        <br><a href="/backend/shipping/export_ship_out_xml.php?out_id=<?php echo $one['out_id']; ?>" target="_blank"><img src="/static/css/images/export_xml.gif" border="0" /></a><?php if(($one['exported']=='Y')){?>&nbsp;<img src="/static/css/images/tick.png" border="0" /><?php }?><?php }?></td>
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
