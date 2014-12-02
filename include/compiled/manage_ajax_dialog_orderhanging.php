<div id="order-pay-dialog" class="order-pay-dialog-c" style="width:700px;"><h3>Chi tiết đơn hàng <?php echo $order['id']; ?><?php if($order['delivery_code']>0){?> - Mã số BG: <?php echo $order['delivery_code']; ?><?php }?> <span id="order-pay-dialog-close" class="close" onclick="return X.boxClose();">close</span></h3>
    <div align="left" style="padding-left:10px; color:#F00"><?php 
            $notes = DB::GetQueryResult("SELECT notes FROM `credit_gift` WHERE user_id='".$order['user_id']."' AND deal_id='".$order['team_id']."'"); ?><?php echo $notes['notes']; ?></div>
	<div style="overflow-x:hidden;padding:5px;" id="dialog-order-id" oid="<?php echo $order['id']; ?>">
    <table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table" width="98%" style="background:#FFFFCC">                   
					<th width="70">Trạng thái</th>
					<th width="120">Người xử lý</th>                    
					<th width="120" nowrap>Ngày xử lý</th>
                    <th width="120" nowrap>Ngày hết hạn</th>	
                    <th width="120" nowrap>Người tiếp nhận</th>                   					
					</tr> 
					<?php if(is_array($his)){foreach($his AS $index=>$one) { ?>  
                    <?php if($one['head']==1){?><tr><td colspan="7"><h3><?php echo $one['order_id']; ?></h3></td></tr><?php }?>
                  
					<tr style="background-color:#<?php echo getStatusColor($one['status_code']); ?>">	
                    				
						<td><?php echo $one['status_code']; ?></td>
						<td><?php echo $one['user']; ?></td>						
						<td><?php echo $one['date']; ?></td>
                       <td><?php echo $one['expires']; ?></td> 
                       <td><?php echo $one['assign_to']; ?></td>                     
					</tr>
                    <?php if($one['note']){?>
                    <tr><td colspan="5"><?php echo $one['note']; ?></td></tr>
                    <?php }?>
					<?php }}?>
					<tr><td colspan="7"><?php echo $pagestring; ?></td></tr>
                    </table>
   
    <form method="post" action="/backend/order/edit.php" class="validator" onsubmit="return checkSubmit();">
	<table width="100%" align="center" class="coupons-table">
		<tr><td width="80" align="right"><b>Khách hàng:</b></td><td><?php echo $user['username']; ?> / <?php echo $user['email']; ?></td></tr>
		<tr><td align="right"><b>Deal:</b></td><td style="padding-right:3px;"><?php echo $team['title']; ?></td></tr>
		<tr><td align="right"><b>Số lượng:</b></td><td><font color="red"><strong><?php echo $order['quantity']; ?></strong></font></td></tr>
		<?php if($order['condbuy']){?>
		<tr><td align="right"><b>Option:</b></td><td><?php echo $order['condbuy']; ?></td></tr>
		<?php }?>
		<tr><td align="right"><b>Trạng thái</b></td><td><?php echo $paystate[$order['state']]; ?></td></tr>
		<!--<tr><td><b>Payment No.：</b></td><td><?php echo $order['pay_id']; ?></td></tr>-->
		<tr><td align="right"><b>Thanh toán:</b></td><td><?php if($order['service']=='cashdelivery' && $order['money']==0 && $order['credit']==0){?>Tiền mặt <b><?php echo print_price(moneyit($order['origin'])); ?></b> <?php echo $currency; ?> <?php }?>&nbsp;<?php if($order['credit']>0){?>Paid <b><?php echo print_price(moneyit($order['credit'])); ?></b> <?php echo $currency; ?> with balance <?php }?>&nbsp;<?php if($order['service']!='credit' && $order['money']>0){?><?php echo $payservice[$order['service']]; ?>Payment <b><?php echo print_price(moneyit($order['money'])); ?></b> <?php echo $currency; ?><?php }?><?php if($order['card_id']){?>&nbsp;Vouchers:<b><?php echo print_price(moneyit($order['card'])); ?></b> Points<?php }?></td></tr>
		<tr><td align="right"><b>Thời gian:</b></td><td><?php echo date('Y-m-d H:i', $order['create_time']); ?> / <?php echo date('Y-m-d H:i', $order['pay_time']); ?></td></tr>
		<?php if($order['address']){?>
		<tr><td width="80" align="right"><b>Địa chỉ:</b></td><td><?php if($order['note_address']!=''){?><?php echo htmlspecialchars($order['note_address']); ?>, <?php }?><?php echo htmlspecialchars($order['address']); ?>, <?php if($order['dist_id']){?><?php echo $alldist[$order['dist_id']]['dist_name']; ?><?php } else { ?>other<?php }?>, <?php if($order['city_id']){?><?php echo $allcities[$order['city_id']]['name']; ?><?php } else { ?>other<?php }?></td></tr>
	<?php }?>
    <?php if($order['realname']){?>
    <tr><td width="80" align="right"><b>Người nhận:</b></td><td><?php echo $order['realname']; ?></td></tr>
	<!--{if $order['mobile']}-->
	<tr><td align="right"><b>Mobile:</b></td><td><?php echo $user['mobile']; ?></td></tr>
	<?php }?>
	<?php if($user['qq']){?>
		<tr><td><b>QQ：</b></td><td><?php echo $user['qq']; ?></td></tr>
	<?php }?>
	<?php if($user['msn']){?>
		<tr><td><b>MSN：</b></td><td><?php echo $user['msn']; ?></td></tr>
	<?php }?>
	<?php if($order['remark']){?>
		<tr><td width="80" align="right"><b>Ghi chú:</b></td><td><?php echo htmlspecialchars($order['remark']); ?></td></tr>
	<?php }?>
    <?php if($order['notes']){?>
		<tr><td width="80" align="right" nowrap><b>Order notes:</b></td><td><?php echo htmlspecialchars($order['notes']); ?></td></tr>
	<?php }?>
    <?php $date = DB::GetQueryResult("SELECT date_received FROM order_hanging WHERE order_id=".$one['id']); ?>
    
    <tr><td width="80" align="right" nowrap><b>Ngày nhận voucher:</b></td><td>
	<input type="hidden" name="id" value="<?php echo $order['id']; ?>" /><input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="date_received" value="<?php echo $date['date_received']; ?>" style="width:100px" /></td></tr>
    <tr><td></td><td>
    	<input type="submit" value="   Tạm Hoãn   " />
    </td></tr>
    
	<?php if($team['delivery']=='express'){?>
		<tr><th colspan="2"><hr/></th></td>
		<tr>
		  <td width="80"><b>Receiver:</b></td><td><?php echo $order['realname']; ?></td></tr>
		<tr>
		  <td><b>Mobile number:</b></td><td><?php echo $order['mobile']; ?></td></tr>
		<tr>
		  <td><b>Address:</b></td><td><?php echo $order['address']; ?></td></tr>
		<tr><th colspan="2"><hr/></th></td>
		<tr>
		  <td><b>Express info:</b></td><td><select name="express_id" id="order-dialog-select-id"><?php echo Utility::Option($option_express, $order['express_id'], 'please select express'); ?></select>&nbsp;<input type="text" name="in" id="order-dialog-input-id" value="<?php echo $order['express_no']; ?>" style="width:150px;" maxLength="32" />&nbsp;&nbsp;<input type="submit" value="Submit" onclick="return X.manage.orderexpress();"/></td></tr>
	<?php }?>

	<?php if($order['state']=='pay'){?>
		<!--<tr><th colspan="2"><hr/></th></td>
		<tr><td><b>refund policy：</b></td><td><select name="refund" id="order-dialog-refund-id"><?php echo Utility::Option($option_refund, '', 'please select a way of refunding'); ?></select>&nbsp;<input type="submit" value="yes" onclick="return X.manage.orderrefund();"/></td></tr>-->
	<?php }?>

	</table></form>
	</div>
</div>
