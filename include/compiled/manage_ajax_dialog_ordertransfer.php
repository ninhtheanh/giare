<div id="order-pay-dialog" class="order-pay-dialog-c" style="width:700px;">
	<h3>Chi tiết đơn hàng <?php echo $order['id']; ?><?php if($order['delivery_code']>0){?> - Mã số: <?php echo $order['delivery_code']; ?><?php }?> <span id="order-pay-dialog-close" class="close" onclick="return X.boxClose();">close</span></h3>
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
                    <tr>			
						<td colspan="5"><?php echo $one['note']; ?></td>						                 
					</tr>
                    <?php }?>
					<?php }}?>
                   
                    
					<tr><td colspan="7"><?php echo $pagestring; ?></td></tr>
                    </table>
<form method="post" action="/backend/order/transfer.php" class="validator" onsubmit="return checkSubmit();">
	<input type="hidden" name="id" value="<?php echo $order['id']; ?>" /><input type="hidden" name="transferid" value="<?php echo $order['transferID']; ?>" />	<table width="100%" align="center" class="coupons-table">
		<tr><td width="80"><b>Khách hàng:</b></td>
		<td><?php echo $user['realname']; ?> / <?php echo $user['email']; ?></td>
		</tr>
		<tr><td><b>Deal:</b></td><td><?php echo $team['title']; ?></td></tr>
		<tr><td><b>Số lượng:</b></td><td><font color="red"><?php echo $order['quantity']; ?></font></td></tr>
	<?php if($order['condbuy']){?>
		<tr><td><b>Option:</b></td><td><?php echo $order['condbuy']; ?></td></tr>
	<?php }?>
		<tr><td><b>Trạng thái</b></td><td><?php echo $paystate[$order['state']]; ?></td></tr>
		<!--<tr><td><b>Payment No.：</b></td><td><?php echo $order['pay_id']; ?></td></tr>-->
		<tr><td><b>Thanh toán:</b></td><td><?php if($order['service']=='cashdelivery' && $order['money']==0 && $order['credit']==0){?>Tiền mặt <b><?php echo print_price(moneyit($order['origin'])); ?></b> <?php echo $currency; ?> <?php }?>&nbsp;<?php if($order['credit']>0){?>Paid <b><?php echo print_price(moneyit($order['credit'])); ?></b> <?php echo $currency; ?> with balance <?php }?>&nbsp;<?php if($order['service']!='credit' && $order['money']>0){?><?php echo $payservice[$order['service']]; ?>Payment <b><?php echo print_price(moneyit($order['money'])); ?></b> <?php echo $currency; ?><?php }?><?php if($order['card_id']){?>&nbsp;Vouchers:<b><?php echo print_price(moneyit($order['card'])); ?></b> Points<?php }?></td></tr>
		<tr><td><b>Thời gian:</b></td><td><?php echo date('Y-m-d H:i', $order['create_time']); ?><?php if($order['pay_time']){?>/ <?php echo date('Y-m-d H:i', $order['pay_time']); ?><?php }?></td></tr>
	<?php if($order['address']){?>
		<tr><td width="80"><b>Địa chỉ:</b></td><td><?php if($order['note_address']!=''){?><?php echo htmlspecialchars($order['note_address']); ?>, <?php }?><?php echo htmlspecialchars($order['address']); ?>, <?php if($order['dist_id']){?><?php echo $alldist[$order['dist_id']]['dist_name']; ?><?php } else { ?>other<?php }?>, <?php if($order['city_id']){?><?php echo $allcities[$order['city_id']]['name']; ?><?php } else { ?>other<?php }?></td></tr>
	<?php }?>
    <?php if($order['realname']){?>
    <tr><td width="80"><b>Người nhận:</b></td><td><?php echo $order['realname']; ?></td></tr>
	<!--{if $order['mobile']}-->
		<tr><td><b>Mobile:</b></td><td><?php echo $user['mobile']; ?></td></tr>
	<?php }?>
	<?php if($user['qq']){?>
		<tr><td><b>QQ：</b></td><td><?php echo $user['qq']; ?></td></tr>
	<?php }?>
	<?php if($user['msn']){?>
		<tr><td><b>MSN：</b></td><td><?php echo $user['msn']; ?></td></tr>
	<?php }?>
	<?php if($order['remark']){?>
		<tr><td width="80"><b>Ghi chú:</b></td><td><?php echo htmlspecialchars($order['remark']); ?></td></tr>
	<?php }?>
    <?php if($order['notes']){?>
		<tr><td width="80"><b>order notes：</b></td><td><?php echo htmlspecialchars($order['notes']); ?></td></tr>
	<?php }?>
    <tr><td width="80" nowrap="nowrap"><b>Transfer notes：</b></td><td><textarea name="note_times_1" style="width:300px; height:100px"></textarea></td></tr>
    <tr><td></td><td>
    	<input type="submit" value="   Transfer Order   " />
    </td></tr>
	</table></form>
	</div>
</div>
