<div id="order-pay-dialog" class="order-pay-dialog-c" style="width:780px;"><h3><span id="order-pay-dialog-close" class="close" onclick="return X.boxClose();">Close</span>Chi tiết đơn hàng <?php echo $order['id']; ?><?php if($order['delivery_code'] !=""){?> - Mã số BG: <?php echo $order['ship_id']; ?><?php }?></h3>
    <div align="left" style="padding-left:10px; color:#C40000">
	<?php $notes = DB::GetQueryResult("SELECT notes FROM `credit_gift` WHERE user_id='".$order['user_id']."' AND deal_id='".$order['team_id']."'"); ?><?php echo $notes['notes']; ?></div>
	<div style="overflow-x:hidden;padding:5px;" id="dialog-order-id" oid="<?php echo $order['id']; ?>">
    <table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table" width="98%">                   
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
                    <tr style="background-color:#<?php echo getStatusColor($one['status_code']); ?>"><td colspan="5"><?php echo $one['note']; ?></td></tr>
                    <?php }?>
					<?php }}?>
					<tr><td colspan="7"><?php echo $pagestring; ?></td></tr>
                    </table>
   <?php 
           
         
           
            $vcode = DB::GetQueryResult("SELECT serial, code FROM `voucher_code` WHERE order_id='".$order['id']."' AND team_id='".$order['team_id']."'", false);
            $group_id = DB::GetQueryResult("SELECT group_id FROM `team` WHERE id='".$order['team_id']."'");
            if((count($vcode)<$order['quantity'] || count($vcode)>$order['quantity']) && $group_id['group_id']==23){
                DB::Delete('voucher_code',array(
                    'order_id' => $order['id'],
                    'team_id'=>$order['team_id'],));
                $create_time = date("Y-m-d H:i:s");
                for($i=0;$i<$order['quantity'];$i++){
                    $vid = Utility::GenSecret(6, Utility::CHAR_NUM);
                    $vouchercode = Utility::VerifyCode($vid);
                    $voucher_code = array(
                        'order_id' => $order['id'],
                        'team_id' => $order['team_id'],
                        'user_id' => $order['user_id'],
                        'realname' => $order['realname'],
                        'code' => $vouchercode,
                        'create_time' => $create_time,
                    );
                    DB::Insert('voucher_code', $voucher_code);
                }
            }else{
                if(empty($vcode) && $group_id['group_id']==23){
                    $seri = DB::GetQueryResult("SELECT serial FROM `voucher_code` WHERE team_id='".$order['team_id']."' AND order_id='".$order['id']."'");
                    if($group_id['group_id']==23 && $order['team_id']>=94 && (int)$seri['serial']==0){
                        $create_time = date("Y-m-d H:i:s");
                        for($i=0;$i<$order['quantity'];$i++){
                            $vid = Utility::GenSecret(6, Utility::CHAR_NUM);
                            $vouchercode = Utility::VerifyCode($vid);
                            $voucher_code = array(
                                'order_id' => $order['id'],
                                'team_id' => $order['team_id'],
                                'user_id' => $order['user_id'],
                                'realname' => $order['realname'],
                                'code' => $vouchercode,
                                'create_time' => $create_time,
                            );
                            DB::Insert('voucher_code', $voucher_code);
                        }
                    }
                }
            }
            $se_vou = "";
            for($j=0;$j<count($vcode);$j++){
                $se_vou .= $vcode[$j]['serial']." - ".$vcode[$j]['code'].", ";
            }
        ; ?>
        <?php if($vcode){?><div align="left" style="color:#C40000"><b>Serial - Voucher Code:</b>&nbsp;<span style="color:#0033CC"><?php echo trim($se_vou,", "); ?></span></div><?php }?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #999999;border-top:1px solid #999999;border-left:1px solid #999999;border-right:1px solid #999999;">
    <tr bgcolor="#FFFFFF">
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999;border-left:none">Mã đơn hàng</td>
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-left:none; border-right:none"><strong><?php echo $order['id']; ?></strong></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none;border-left:none">Ngày đặt hàng</td>
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none; border-left:none; border-right:none"><strong><?php echo date('d-m-Y H:i:s', $order['create_time']); ?></strong></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none;border-left:none;">Trạng thái</td>
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none; border-left:none; border-right:none"><strong><?php echo getStatusName($order['state']); ?></strong></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none;border-left:none">Phương thức thanh toán</td>
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border-bottom:1px solid #999999;"><strong><?php echo GetPaymentName($order['payment_id']); ?></strong></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none;border-left:none">Phương thức vận chuyển</td>
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border-bottom:1px solid #999999;"><strong><?php echo GetShippingName($order['shipping_id']); ?></strong></td>
    </tr>
   
    <tr bgcolor="#53BBF0">
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px;border-right:1px solid #999999;border-bottom:1px solid #999999; color:#FFFFFF"><strong>Thông tin thanh toán</strong></td>
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px;border-bottom:1px solid #999999; color:#FFFFFF"><strong>Thông tin vận chuyển</strong></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td style="padding-left:10px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none;border-left:none">Họ tên: <?php echo $order['realname']; ?></td>
      <td style="padding-left:10px; padding-right:5px; padding-bottom:3px; padding-top:3px; border-bottom:1px solid #999999;">Họ tên: <?php if($order['shipping_fullname']!=''){?><?php echo $order['brealname']; ?><?php } else { ?><?php echo $order['realname']; ?><?php }?></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td style="padding-left:10px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none; border-left:none">
      <?php 

          $s = DB::GetQueryResult("SELECT money FROM `user` WHERE id=".$order['user_id']);
      
      	if($order['note_address']!=''){
        	$note_address = htmlspecialchars($order['note_address']).", ";
        }
        $order['billing_address'] = $note_address.htmlspecialchars($order['address']);
        if(ward_name($order['dist_id'],$order['ward_id'])){
			$wardname = ward_name($order['dist_id'],$order['ward_id']);
			$order['billing_address'] .=", ".strip_input($wardname['ward_name']);
		}
		if(ename_dist($order['dist_id'])){
			$dists = ename_dist($order['dist_id']);
			$order['billing_address'] .=", ".strip_input($dists['dist_name']);		
		}
		if(id_city($order['city_id'])){
			$citys = id_city($order['city_id']);
			$order['billing_address'] .=", ".strip_input($citys['name']);		
		}
        
        
        if($order['bnote_address']!=''){
        	$note_address = htmlspecialchars($order['bnote_address']).", ";
        }
        $order['shipping_address'] = $note_address.htmlspecialchars($order['baddress']);
        if(ward_name($order['bdist_id'],$order['bward_id'])){
			$wardname = ward_name($order['bdist_id'],$order['bward_id']);
			$order['shipping_address'] .=", ".strip_input($wardname['ward_name']);
		}
		if(ename_dist($order['bdist_id'])){
			$dists = ename_dist($order['bdist_id']);
			$order['shipping_address'] .=", ".strip_input($dists['dist_name']);		
		}
		if(id_city($order['bcity_id'])){
			$citys = id_city($order['bcity_id']);
			$order['shipping_address'] .=", ".strip_input($citys['name']);		
		}
        
      ; ?>
      Địa chỉ: <?php echo $order['billing_address']; ?><?php if($order['is_home']=='yes'){?><span style="color:#c40000"><strong>&nbsp;(Nhà riêng)</strong></span><?php }?></td>
      <td style="padding-left:10px; padding-right:5px; padding-bottom:3px; padding-top:3px; border-bottom:1px solid #999999;">Địa chỉ: <?php if($order['shipping_address']!=''){?><?php echo $order['shipping_address']; ?><?php } else { ?><?php echo $order['billing_address']; ?><?php }?></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td style="padding-left:10px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none; border-left:none">Điện thoại: <?php echo $order['mobile']; ?></td>
      <td style="padding-left:10px; padding-right:5px; padding-bottom:3px; padding-top:3px; border-bottom:1px solid #999999;">Điện thoại: <?php if($order['bmobile']!=''){?><?php echo $order['bmobile']; ?><?php } else { ?><?php echo $order['mobile']; ?><?php }?></td>
    </tr>
    <tr>
      <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="top" style="background-color:#FDFA9D;border-right:solid 1px #999999; border-bottom:solid 1px #999999; border-left:none;color:#07519a;font-family:Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;line-height:16px;padding:8px;text-align:left;white-space:nowrap;">Mã</td>
            <td align="left" valign="top" style="background-color:#FDFA9D;border-right:solid 1px #999999; border-bottom:solid 1px #999999; border-left:none;color:#07519a;font-family:Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;line-height:16px;padding:8px;text-align:left;white-space:nowrap;">Tên Deal</td>
            <td align="left" valign="top" style="background-color:#FDFA9D;border-right:solid 1px #999999; border-bottom:solid 1px #999999; border-left:none;color:#07519a;font-family:Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;line-height:16px;padding:8px;text-align:left;white-space:nowrap;">Số lượng</td>
            <td align="left" valign="top" style="background-color:#FDFA9D;border-right:solid 1px #999999; border-bottom:solid 1px #999999; border-left:none;color:#07519a;font-family:Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;line-height:16px;padding:8px;text-align:left;white-space:nowrap;">Trọng lượng (gr)</td>
            <td align="left" valign="top" style="background-color:#FDFA9D;border-right:solid 1px #999999; border-bottom:solid 1px #999999; border-left:none;color:#07519a;font-family:Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;line-height:16px;padding:8px;text-align:left;white-space:nowrap;">Đơn giá (VNĐ)</td>
            <td align="left" valign="top" style="background-color:#FDFA9D;color:#07519a; border-bottom:solid 1px #999999;font-family:Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;line-height:16px;padding:8px;text-align:left;white-space:nowrap;">Thành tiền (VNĐ)</td>
          </tr>

 <tr bgcolor="#FFFFFF"><td align="left" valign="top" style="padding:5px;border-bottom:solid 1px #999999;border-right:solid 1px #999999;"><?php echo $order['id']; ?></td>
			  <td align="left" valign="top" style="padding:5px;border-bottom:solid 1px #999999;border-right:solid 1px #999999;">
			  	<?php echo $team['short_title']; ?>
                <?php echo showColorSize($order); ?>                
              </td>
			  <td align="center" valign="top" style="padding:5px;border-bottom:solid 1px #999999;border-right:solid 1px #999999;"><?php echo $order['quantity']; ?></td>
			  <td align="center" valign="top" style="padding:5px;border-bottom:solid 1px #999999;border-right:solid 1px #999999;"><?php if($team['weight']>0){?><?php echo $team['weight']; ?><?php } else { ?>100<?php }?></td>
			  <td align="right" valign="top" style="padding:5px;border-bottom:solid 1px #999999;border-right:solid 1px #999999;"><?php echo print_price(moneyit($order['price'])); ?></td>
			  <td align="right" valign="top" style="padding:5px;border-bottom:solid 1px #999999;"><?php echo print_price(moneyit($order['origin'])); ?></td>
			</tr> 
          <?php  /*  list team  */ ?>
<?php  
/* $rows = DB::LimitQuery('order_detail', array(
        'condition' => array('order_id'=>$order['id']),
    )); */
	
	/*  */
//$phithanhtoan = 0;
 ?>
 <?php  /* foreach($rows as $row): ?>
         <tr bgcolor="#FFFFFF"><td align="left" valign="top" style="padding:5px;border-bottom:solid 1px #999999;border-right:solid 1px #999999;"><?php echo $row['id']; ?></td>
			  <td align="left" valign="top" style="padding:5px;border-bottom:solid 1px #999999;border-right:solid 1px #999999;">C<?php echo $row['team_id']; ?> - <?php echo $row['short_title']; ?></td>
			  <td align="center" valign="top" style="padding:5px;border-bottom:solid 1px #999999;border-right:solid 1px #999999;"><?php echo $row['quantity']; ?></td>
			  <td align="center" valign="top" style="padding:5px;border-bottom:solid 1px #999999;border-right:solid 1px #999999;">0</td>
			  <td align="right" valign="top" style="padding:5px;border-bottom:solid 1px #999999;border-right:solid 1px #999999;"><?php echo print_price(moneyit($row['team_price'])); ?></td>
			  <td align="right" valign="top" style="padding:5px;border-bottom:solid 1px #999999;"><?php
			  $tt = $row['team_price']*$row['quantity'];
			  $phithanhtoan = $phithanhtoan + $tt;
			   echo print_price(moneyit($tt)); ?></td>
			</tr>
<?php  endforeach;  */?>     
            <?php  /*  end list team  */ ?>
          <tr bgcolor="#f6fcff">
            
            <td align="right" valign="top" style="padding:3px;">&nbsp;</td>
            <td align="right" valign="top" style="padding:3px;">&nbsp;</td>
            <td align="right" valign="top" style="padding:3px;">&nbsp;</td>
            <td align="left" valign="top" style="padding:3px;"><strong>Tổng TL:</strong> 0 gr</td>
            <td align="right" valign="top" style="padding:3px;" colspan="2">&nbsp;</td>
          </tr>
          <tr bgcolor="#f6fcff">
            <td colspan="5" align="right" valign="top" style="padding:3px;">Phí vận chuyển</td>
            <td align="right" valign="top" style="padding:3px;" colspan="2"><?php echo print_price(moneyit($order['payment_cost'])); ?> VNĐ</td>
          </tr>
 <!--         <tr bgcolor="#f6fcff">
            <td colspan="5" align="right" valign="top" style="padding:3px;">Phí thanh toán</td>
            <td align="right" valign="top" style="padding:3px;" colspan="2"><?php echo print_price(moneyit($order['shipping_cost'])); ?> VNĐ</td>
          </tr>-->
          <tr bgcolor="#f6fcff">
            <td colspan="5" align="right" valign="top" style="padding:3px;">Tổng tiền</td>
            <td align="right" valign="top" style="padding:3px;" nowrap="nowrap" colspan="2"><font size="+1"><strong><?php echo print_price(moneyit(TotalOrder($order['id']))); ?> VNĐ</strong></font></td>
          </tr>
          <?php if($order['credit']>0 || $order['money']>0){?>
          <tr bgcolor="#f6fcff">
            <td  colspan="5" align="right" valign="top" style="padding:3px;">Đã thanh toán:</td>
            <td align="right" valign="top" style="padding:3px;" nowrap="nowrap" colspan="2"><font size="+1"><strong>
            <?php if($order['credit']>0){?><?php echo print_price(moneyit($order['credit'])); ?><?php } else if($order['money']>0) { ?><?php echo print_price(moneyit($order['money'])); ?>
           <?php } else { ?>0<?php }?>&nbsp;VNĐ</strong></font></td>
          </tr><?php }?>
          <tr bgcolor="#f6fcff">
            <td colspan="5" align="right" valign="top" style="padding:3px;">Số dư tài khoản còn lại:</td>
            <td align="right" valign="top" style="padding:3px;" nowrap="nowrap" colspan="2"><font size="+1"><strong>
            <?php if($s['money']>0){?><?php echo print_price(moneyit($s['money'])); ?><?php } else { ?>0<?php }?>&nbsp;VNĐ</strong></font></td>
          </tr>
          
      </table></td>
    </tr>
    <tr bgcolor="#f6fcff">
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr bgcolor="#f6fcff">
    <td colspan="2" align="left" style="padding-left:5px;"><strong>Ghi ch&uacute;:</strong><?php echo htmlspecialchars($order['remark']); ?> - <?php echo htmlspecialchars($order['remark2']); ?> - <?php echo htmlspecialchars($order['notes']); ?></td>
  </tr>
  </table>
<div style="padding-top:10px; padding-bottom:10px;"><?php if($order['state']=='unpay'){?><input type="submit" value="   Confirm Order   " onclick="return X.manage.orderconfirm();"/>
    	<!--&nbsp;<input type="button" value="   Cancel Order   " onclick="return X.manage.ordercancel();"/>-->
    	<?php } else if($order['state']=='canceled') { ?><input type="submit" value="   Confirm Order   " onclick="return X.manage.orderconfirm();"/>
    	<?php } else if($order['state']=='confirmed') { ?><!--<input type="button" value="   Cancel Order   " onclick="return X.manage.ordercancel();"/>--><?php }?></div>
	</div>
</div>
