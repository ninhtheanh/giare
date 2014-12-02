<div class="myaccount-box" id="ordercontent" align="center">
  <table width="780" border="0" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #999999;border-top:1px solid #999999;border-left:1px solid #999999;border-right:1px solid #999999;">
    <tr bgcolor="#FFFFFF">
      <td align="left" valign="top" style="padding-top:3px;"><img src="http://www.dealsoc.vn/static/css/images/LogoConfirmOrder.jpg" border="0" width="145" height="60" /></td>
      <td align="right" valign="top"><img src="/barcode/?barcode=<?php echo $order_id; ?>" border="0" alt="" /></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td align="center" valign="top" colspan="2" style="margin: 10px 0px 5px 5px; text-align: center; font-weight: bold; font-size: 30px;">HÓA ĐƠN</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999;border-left:none">Mã đơn hàng</td>
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-left:none; border-right:none"><strong><?php echo $order_id; ?></strong></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none;border-left:none">Ngày đặt hàng</td>
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none; border-left:none; border-right:none"><strong><?php echo $order_date; ?></strong></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none;border-left:none;">Trạng thái</td>
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none; border-left:none; border-right:none"><strong><?php echo $order_status; ?></strong></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none;border-left:none">Phương thức thanh toán</td>
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border-bottom:1px solid #999999;"><strong><?php echo $billing_method; ?></strong></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none;border-left:none">Phương thức vận chuyển</td>
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px; border-bottom:1px solid #999999;"><strong><?php echo $shipping_method; ?></strong></td>
    </tr>
   
    <tr bgcolor="#53BBF0">
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px;border-right:1px solid #999999;border-bottom:1px solid #999999; color:#FFFFFF"><strong>Thông tin thanh toán</strong></td>
      <td style="padding-left:5px; padding-right:5px; padding-bottom:3px; padding-top:3px;border-bottom:1px solid #999999; color:#FFFFFF"><strong>Thông tin vận chuyển</strong></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td style="padding-left:10px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none;border-left:none">Họ tên: <?php echo $billing_fullname; ?></td>
      <td style="padding-left:10px; padding-right:5px; padding-bottom:3px; padding-top:3px; border-bottom:1px solid #999999;">Họ tên: <?php echo $shipping_fullname; ?></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td style="padding-left:10px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none; border-left:none">Địa chỉ: <?php echo $billing_address; ?></td>
      <td style="padding-left:10px; padding-right:5px; padding-bottom:3px; padding-top:3px; border-bottom:1px solid #999999;">Địa chỉ: <?php echo $shipping_address; ?></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td style="padding-left:10px; padding-right:5px; padding-bottom:3px; padding-top:3px; border:1px solid #999999; border-top:none; border-left:none">Điện thoại: <?php echo $billing_phone; ?></td>
      <td style="padding-left:10px; padding-right:5px; padding-bottom:3px; padding-top:3px; border-bottom:1px solid #999999;">Điện thoại: <?php echo $shipping_phone; ?></td>
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
          <?php echo $product_list_of_order; ?>
          <tr bgcolor="#f6fcff">
            
            <td align="right" valign="top" style="padding:3px;">&nbsp;</td>
            <td align="right" valign="top" style="padding:3px;">&nbsp;</td>
            <td align="right" valign="top" style="padding:3px;">&nbsp;</td>
            <td align="left" valign="top" style="padding:3px;"><strong>Tổng TL:</strong> <?php echo $total_weight; ?></td>
            <td align="right" valign="top" style="padding:3px;" colspan="2">&nbsp;</td>
          </tr>
          <tr bgcolor="#f6fcff">
            <td colspan="5" align="right" valign="top" style="padding:3px;">Phí thanh toán</td>
            <td align="right" valign="top" style="padding:3px;" colspan="2"><?php echo $shipping_cost; ?> VNĐ</td>
          </tr>
          <tr bgcolor="#f6fcff">
            <td colspan="5" align="right" valign="top" style="padding:3px;">Phí vận chuyển</td>
            <td align="right" valign="top" style="padding:3px;" colspan="2"><?php echo $billing_cost; ?> VNĐ</td>
          </tr>
          <tr bgcolor="#f6fcff">
            <td colspan="5" align="right" valign="top" style="padding:3px;">Tổng tiền</td>
            <td align="right" valign="top" style="padding:3px;" nowrap="nowrap" colspan="2"><font size="+1"><strong><?php echo $total_amount; ?> VNĐ</strong></font></td>
          </tr>
          <tr bgcolor="#f6fcff">
            <td colspan="5" align="right" valign="top" style="padding:3px;">Số dư tài khoản:</td>
            <td align="right" valign="top" style="padding:3px;" nowrap="nowrap" colspan="2"><font size="+1"><strong>
            <?php if($login_user['money']>0){?><?php echo print_price(moneyit($login_user['money'])); ?><?php } else { ?>0<?php }?>&nbsp;VNĐ</strong></font></td>
          </tr>
          <?php if($login_user['money']>0){?>
          <tr bgcolor="#f6fcff">
            <td  colspan="5" align="right" valign="top" style="padding:3px;">Đã thanh toán:</td>
            <td align="right" valign="top" style="padding:3px;" nowrap="nowrap" colspan="2"><font size="+1"><strong>
            <?php if($order['credit']>0){?><?php echo print_price(moneyit($order['credit'])); ?><?php } else if($order['money']>0) { ?><?php echo print_price(moneyit($order['money'])); ?>
           <?php } else { ?>0<?php }?>&nbsp;VNĐ</strong></font></td>
          </tr><?php }?>
      </table></td>
    </tr>
    <tr bgcolor="#f6fcff">
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr bgcolor="#f6fcff">
    <td colspan="2" align="left" style="padding-left:5px;"><strong>Ghi ch&uacute;:</strong><?php echo $order_notes; ?></td>
  </tr>
  </table>
</div>
