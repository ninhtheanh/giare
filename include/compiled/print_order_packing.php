<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dealsoc.com - Giá sốc mỗi ngày</title>
<style type="text/css">
			table{
				font-family:Arial; font-size:11px; margin:0px;
			}
			@media print{
				table {page-break-after:always}
			}
			</style>
</head>
<body onLoad="alert('Press Ctr+P to print');">
<center>
    	<?php if(is_array($order)){foreach($order AS $index=>$val) { ?>
        <?php 
        	$content_order = PrintInvoice((int)$val);
        	$order = Table::Fetch('order', $val);
            $team = Table::FetchForce('team', $order['team_id']);
        ; ?>
          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-top:1px solid #999999;border-bottom:1px solid #999999;border-left:1px solid #999999;border-right:1px solid #999999;">
            <tr bgcolor="#FFFFFF">
              <td align="left" valign="top" style="padding-top:3px; padding-bottom:10px;"><img src="/static/css/images/LogoConfirmOrder.jpg" border="0" height="50" /></td>
              <td align="right" valign="top"><img src="/barcode/?barcode=<?php echo $val; ?>" border="0" alt="" height="50" /></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td align="center" valign="top" colspan="2" style="margin: 10px 0px 5px 5px; text-align: center; font-weight: bold; font-size: 18px; font-family:Arial, Helvetica, sans-serif">HÓA ĐƠN</td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999;border-left:none">Mã đơn hàng</td>
              <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-left:none; border-right:none"><strong><?php echo $val; ?></strong></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none;border-left:none">Ngày đặt hàng</td>
              <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none; border-left:none; border-right:none"><strong><?php echo $content_order['order_date']; ?></strong></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none;border-left:none;">Trạng thái</td>
              <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none; border-left:none; border-right:none"><strong><?php echo $content_order['order_status']; ?></strong></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none;border-left:none">Phương thức thanh toán</td>
              <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border-bottom:1px solid #999999;"><strong><?php echo $content_order['billing_method']; ?></strong></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none;border-left:none">Phương thức vận chuyển</td>
              <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border-bottom:1px solid #999999;"><strong><?php echo $content_order['shipping_method']; ?></strong></td>
            </tr>
            <tr bgcolor="#53BBF0">
              <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px;border-right:1px solid #999999;border-bottom:1px solid #999999; color:#FFFFFF"><strong>Thông tin thanh toán</strong></td>
              <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px;border-bottom:1px solid #999999; color:#FFFFFF"><strong>Thông tin vận chuyển</strong></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td style="padding-left:10px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none;border-left:none">Họ tên: <?php echo $content_order['billing_fullname']; ?></td>
              <td style="padding-left:10px; padding-right:5px; padding-bottom:3px; padding-top:3px; border-bottom:1px solid #999999;">Họ tên: <?php if($content_order['shipping_fullname']!=''){?><?php echo $content_order['shipping_fullname']; ?><?php } else { ?><?php echo $content_order['billing_fullname']; ?><?php }?></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td style="padding-left:10px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none; border-left:none">Địa chỉ: <?php echo $content_order['billing_address']; ?></td>
              <td style="padding-left:10px; padding-right:5px; padding-bottom:3px; padding-top:3px; border-bottom:1px solid #999999;">Địa chỉ: <?php if($content_order['shipping_address']!=''){?><?php echo $content_order['shipping_address']; ?><?php } else { ?><?php echo $content_order['billing_address']; ?><?php }?></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td style="padding-left:10px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none; border-left:none">Điện thoại: <?php echo $content_order['billing_phone']; ?></td>
              <td style="padding-left:10px; padding-right:5px; padding-bottom:3px; padding-top:3px; border-bottom:1px solid #999999;">Điện thoại: <?php if($content_order['shipping_phone']!=''){?><?php echo $content_order['shipping_phone']; ?><?php } else { ?><?php echo $content_order['billing_phone']; ?><?php }?></td>
            </tr>
            <tr>
              <td colspan="2" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="left" valign="top" style="background-color:#FDFA9D;border-right:solid 1px #999999; border-bottom:solid 1px #999999; border-left:none;color:#07519a;font-family:Arial, Helvetica, sans-serif;font-size:11px;font-weight:bold;line-height:12px;padding:3px;text-align:left;white-space:nowrap;">Mã</td>
                    <td align="left" valign="top" style="background-color:#FDFA9D;border-right:solid 1px #999999; border-bottom:solid 1px #999999; border-left:none;color:#07519a;font-family:Arial, Helvetica, sans-serif;font-size:11px;font-weight:bold;line-height:12px;padding:3px;text-align:left;white-space:nowrap;">Tên Deal</td>
                    <td align="left" valign="top" style="background-color:#FDFA9D;border-right:solid 1px #999999; border-bottom:solid 1px #999999; border-left:none;color:#07519a;font-family:Arial, Helvetica, sans-serif;font-size:11px;font-weight:bold;line-height:12px;padding:3px;text-align:left;white-space:nowrap;">Số lượng</td>
                    <td align="left" valign="top" style="background-color:#FDFA9D;border-right:solid 1px #999999; border-bottom:solid 1px #999999; border-left:none;color:#07519a;font-family:Arial, Helvetica, sans-serif;font-size:11px;font-weight:bold;line-height:12px;padding:3px;text-align:left;white-space:nowrap;">Trọng lượng (gr)</td>
                    <td align="left" valign="top" style="background-color:#FDFA9D;border-right:solid 1px #999999; border-bottom:solid 1px #999999; border-left:none;color:#07519a;font-family:Arial, Helvetica, sans-serif;font-size:11px;font-weight:bold;line-height:12px;padding:3px;text-align:left;white-space:nowrap;">Đơn giá (VNĐ)</td>
                    <td align="left" valign="top" style="background-color:#FDFA9D;color:#07519a; border-bottom:solid 1px #999999;font-family:Arial, Helvetica, sans-serif;font-size:11px;font-weight:bold;line-height:12px;padding:3px;text-align:left;white-space:nowrap;">Thành tiền (VNĐ)</td>
                  </tr>
                  <?php echo $content_order['product_list_of_order']; ?>
                  <tr bgcolor="#f6fcff">
                    <td align="right" valign="top" style="padding:3px;">&nbsp;</td>
                    <td align="right" valign="top" style="padding:3px;">&nbsp;</td>
                    <td align="right" valign="top" style="padding:3px;">&nbsp;</td>
                    <td align="left" valign="top" style="padding:3px;"><strong>Tổng TL:</strong> <?php if($content_order['total_weight']>0){?><?php echo $content_order['total_weight']; ?><?php } else { ?><?php if($team['weight']>0){?><?php echo $order['quantity']*$team['weight']; ?><?php } else { ?><?php echo $order['quantity']*100; ?><?php }?><?php }?> gr</td>
                    <td align="right" valign="top" style="padding:3px;" colspan="2">&nbsp;</td>
                  </tr>
                  <tr bgcolor="#f6fcff">
                    <td colspan="5" align="right" valign="top" style="padding:3px;">Phí thanh toán</td>
                    <td align="right" valign="top" style="padding:3px;" colspan="2"><?php echo $content_order['billing_cost']; ?> VNĐ</td>
                  </tr>
                  <tr bgcolor="#f6fcff">
                    <td colspan="5" align="right" valign="top" style="padding:3px;">Phí vận chuyển</td>
                    <td align="right" valign="top" style="padding:3px;" colspan="2"><?php echo $content_order['shipping_cost']; ?> VNĐ</td>
                  </tr>
                  <tr bgcolor="#f6fcff">
                    <td colspan="5" align="right" valign="top" style="padding:3px;">Tổng tiền</td>
                    <td align="right" valign="top" style="padding:3px;" nowrap="nowrap" colspan="2"><font style="font-size:13px" ><strong><?php echo $content_order['total_amount']; ?> VNĐ</strong></font></td>
                  </tr>
                  <tr bgcolor="#f6fcff">
                    <td colspan="5" align="right" valign="top" style="padding:3px;">Số dư tài khoản:</td>
                    <td align="right" valign="top" style="padding:3px;" nowrap="nowrap" colspan="2"><font style="font-size:13px" ><strong> 
                      <?php if($login_user['money']>0){?><?php echo print_price(moneyit($login_user['money'])); ?><?php } else { ?>0<?php }?>&nbsp;VNĐ</strong></font></td>
                  </tr>
                  <?php if($login_user['money']>0){?>
                  <tr bgcolor="#f6fcff">
                    <td  colspan="5" align="right" valign="top" style="padding:3px;">Đã thanh toán:</td>
                    <td align="right" valign="top" style="padding:3px;" nowrap="nowrap" colspan="2"><font style="font-size:13px" ><strong> 
                      <?php if($order['credit']>0){?><?php echo print_price(moneyit($order['credit'])); ?><?php } else if($order['money']>0) { ?><?php echo print_price(moneyit($order['money'])); ?> 
                      <?php } else { ?>0<?php }?>&nbsp;VNĐ</strong></font></td>
                  </tr>
                  <?php }?>
                  
                </table></td>
            </tr><tr bgcolor="#f6fcff">
              <td colspan="2" align="left" style="padding-left:5px;"><strong>Ghi ch&uacute;:</strong><?php echo $order_notes; ?></td>
            </tr>
          </table><?php }}?>
			
</center>
</body>
</html>
