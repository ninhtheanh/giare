<?php include template("manage_header");?>
<script language="javascript" type="text/javascript">
jQuery(document).ready(function() {	
	$('#fr').hide(); $('#to').hide();
	if($('#period').val()=='C'){ $('#fr').show(); $('#to').show(); }
	$('#period').change(function() {
  		if($(this).val()=='C'){ $('#fr').show(); $('#to').show(); }else{$('#fr').hide();$('#to').hide();}
	});
});	
</script>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_report('orders'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head">
                    <h2>Report by Orders (<?php echo $total; ?>)</h2>
				</div>
				<div class="sect" style="padding:5px; background:#FFFFCC">
					<form method="get">
                    	<p style="margin:5px 0;">
                        City <select name="creator" id="creator" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($allcities,'id','name'), $city['id']); ?></select>
                        District <select name="shipper" id="shipper" class="h-input" require="true"><option value='0'>--Chon--</option></select>       
                         Payment <select name="shipper" id="shipper" class="h-input" require="true"><option value='0'>--Chon--</option></select>       
                         Shipping <select name="shipper" id="shipper" class="h-input" require="true"><option value='0'>--Chon--</option></select>                       
                       </p>
                    	 <p style="margin:5px 0;">
                         <select name="period" id="period" class="h-input" require="true">
                        <?php echo Utility::Option(array('D'=>'Today','W'=>'This week','M'=>'This month','Y'=>'This year','C'=>'Custom'), $period); ?>
                        </select>                       
                       <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="fr" id="fr" value="<?php echo date('Y-m-d',$fr); ?>" /> - 
                       <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="to" id="to" value="<?php echo date('Y-m-d',$to); ?>" />
                       <input name="submit" type="submit" value="Lọc dữ liệu" class="formbutton"  style="padding:6px 6px;"/> <span style="color:#c40000">(SL Hủy bao gồm KH hủy và Cheapdeal đóng deal hủy)</span>
                       </p>                                              
					<form>
				</div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
                    <th valign="top" align="center">Date</th>                                   
                    <th valign="top" align="center">Pay</th>
                    <th valign="top" align="center">Unpay</th>
                    <th valign="top" align="center">Canceled</th>
                    <th valign="top" align="center">Comfirmed</th> 
                    <th valign="top" align="center">Delivered</th>                                   
                    <th valign="top" align="center">Pending</th>
                    <th valign="top" align="center">Hanging</th>
                    <th valign="top" align="center">Office</th>
                    <th valign="top" align="center">Total</th>
                    </tr>
					<?php if(is_array($rs)){foreach($rs AS $index=>$one) { ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>">
                        <?php 
                         	$from = strtotime($one['date']." 00:00:00");$cancel['total']=0;$confirm['total']=0;$delivery['total']=0;$pending['total']=0;$hanging['total']=0;$office['total']=0;$sum['total']=0;$end = strtotime($one['date']." 23:59:59");
                            $pay = DB::GetQueryResult("SELECT COUNT(1) AS total FROM `order` WHERE (team_id > 0)AND (state IN ('pay'))  AND (create_time >= '".$from."')AND (create_time <= '".$end."')");
                            $unpay = DB::GetQueryResult("SELECT COUNT(1) AS total FROM `order` WHERE (team_id > 0)AND (state IN ('unpay'))  AND (create_time >= '".$from."')AND (create_time <= '".$end."')");
                            
                            $cancel = DB::GetQueryResult("SELECT COUNT(1) AS total FROM `order` WHERE (team_id > 0)AND (state IN ('canceled', 'dealsoc_cancel'))  AND (create_time >= '".$from."')AND (create_time <= '".$end."')");
                            
                            $confirm = DB::GetQueryResult("SELECT COUNT(1) AS total FROM `order` WHERE (team_id > 0) AND service NOT IN ('cashoffice') AND (state IN ('confirmed'))  AND (create_time >= '".$from."')AND (create_time <= '".$end."')");
                            
                            $delivery = DB::GetQueryResult("SELECT COUNT(1) AS total FROM `order` WHERE (team_id > 0) AND service NOT IN ('cashoffice') AND (state IN ('delivered'))  AND (create_time >= '".$from."')AND (create_time <= '".$end."')");
                             $pending = DB::GetQueryResult("SELECT COUNT(1) AS total FROM `order` WHERE (team_id > 0) AND service NOT IN ('cashoffice') AND (state IN ('pending'))  AND (create_time >= '".$from."')AND (create_time <= '".$end."')");
                              $pending = DB::GetQueryResult("SELECT COUNT(1) AS total FROM `order` WHERE (team_id > 0) AND service NOT IN ('cashoffice') AND (state IN ('pending'))  AND (create_time >= '".$from."')AND (create_time <= '".$end."')");
                               $hanging = DB::GetQueryResult("SELECT COUNT(1) AS total FROM `order` WHERE (team_id > 0) AND service NOT IN ('cashoffice') AND (state IN ('pending'))  AND (create_time >= '".$from."')AND (create_time <= '".$end."')");
                               $office = DB::GetQueryResult("SELECT COUNT(1) AS total FROM `order` WHERE (team_id > 0) AND service = 'cashoffice' AND (state IN ('confirmed', 'pending'))  AND (create_time >= '".$from."')AND (create_time <= '".$end."')");
                                $sum = DB::GetQueryResult("SELECT COUNT(1) AS total FROM `order` WHERE (team_id > 0) AND (create_time >= '".$from."')AND (create_time <= '".$end."')");
                            ; ?>
                         <td><strong><?php echo $one['date']; ?></strong></td>
                         <td style="text-align:right; padding-right: 5px;"><?php echo $pay['total']; ?></td> 
                         <td style="text-align:right; padding-right: 5px;"><?php echo $unpay['total']; ?></td> 
                         <td style="text-align:right; padding-right: 5px;">
                         
                            <a href="http://cheapdeal.vn/backend/order/canceled.php?cbday=<?php echo $one['date']; ?>&ceday=<?php echo $one['date']; ?>" target="_blank"><?php echo $cancel['total']; ?></a></td>
                         <td style="text-align:right; padding-right: 5px;"><a href="http://cheapdeal.vn/backend/order/confirmed.php?cbday=<?php echo $one['date']; ?>&ceday=<?php echo $one['date']; ?>&state=confirmed" target="_blank" style="color:red"><?php echo $confirm['total']; ?></a></td>     
                          <td style="text-align:right; padding-right: 5px;"><?php echo $delivery['total']; ?></td> 
                         <td style="text-align:right; padding-right: 5px;"><a href="http://cheapdeal.vn/backend/order/confirmed.php?cbday=<?php echo $one['date']; ?>&ceday=<?php echo $one['date']; ?>&state=pending" target="_blank" style="color:red"><?php echo $pending['total']; ?></td> 
                         <td style="text-align:right; padding-right: 5px;"><?php echo $hanging['total']; ?></td></td>
                         <td style="text-align:right; padding-right: 5px;"><?php echo $office['total']; ?></td> 
                         <td style="text-align:right; padding-right: 5px;"><?php echo $sum['total']; ?></td>                         
                        
                        <?php $tpay +=$pay['total'];$tunpay +=$unpay['total'];$tcancel +=$cancel['total'];$tconfirm +=$confirm['total'];$tdelivery +=$delivery['total']; $tpending +=$pending['total'];$thanging +=$hanging['total'];$toffice +=$office['total'];$ttotal +=$sum['total'];; ?>						
					</tr>
					<?php }}?>
                    <tr style="color:#c40000">
                        <td align="right"><strong>Tổng</strong></td>
                         <td style="text-align:right; padding-right: 5px;"><strong><?php echo $tpay; ?></strong></td> 
                         <td style="text-align:right; padding-right: 5px;"><strong><?php echo $tunpay; ?></strong></td> 
                          <td style="text-align:right; padding-right: 5px;"><strong><?php echo $tcancel; ?></strong></td> 
                         <td style="text-align:right; padding-right: 5px;"><strong><?php echo $tconfirm; ?></strong></td> 
                          <td style="text-align:right; padding-right: 5px;"><strong><?php echo $tdelivery; ?></strong></td> 
                         <td style="text-align:right; padding-right: 5px;"><strong><?php echo $tpending; ?></strong></td> 
                          <td style="text-align:right; padding-right: 5px;"><strong><?php echo $thanging; ?></strong></td> 
                          <td style="text-align:right; padding-right: 5px;"><strong><?php echo $toffice; ?></strong></td>
                         <td style="text-align:right; padding-right: 5px;"><strong><?php echo $ttotal; ?></strong></td> 
                         
                       				
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
