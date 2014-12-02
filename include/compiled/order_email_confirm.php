<table border="0" cellpadding="0" cellspacing="0" width="600" style="border-bottom:5px solid #50bde8;border-left:5px solid #50bde8;border-right:5px solid #50bde8;border-top:5px solid #50bde8; width:600px; background-color: rgb(255, 255, 255,255);-moz-border-radius: 8px  8px  8px  8px; border-top-left-radius: 8px; padding: 0; border-top-right-radius: 8px; border-bottom-right-radius: 8px; border-bottom-left-radius: 8px; border-width: 5px;">
  <tr>
    <td align="left" valign="top" style=" padding:10px; margin:10px;"><table width="590" border="0" cellspacing="0" cellpadding="0">
        
              <tr>
                <td width="50%" align="left" style="border-bottom:#CCC 1px solid"><a href="http://<?php echo $INI['system']['sitename']; ?>" target="_blank"><img src="http://116.193.73.85/static/css/images/LogoConfirmOrder.jpg" border="0" width="145" height="60" /></a></td><td width="72%" align="right" valign="top" style="border-bottom:#CCC 1px solid"><div  style="color:#1d94bf; font-size:15px; font-family:Arial, Helvetica, sans-serif;font-weight:bold; padding-right:10px; padding-top:5px; padding-bottom:5px">&nbsp;</div><div  style="padding-right:10px;font-size:12px; font-family:Arial, Helvetica, sans-serif;padding-bottom:5px; white-space:nowrap">137/5A Lê Văn Sỹ, P.13, Q.Phú Nhuận, Tp.Hồ Chí Minh</div><div style="padding-right:10px;font-size:12px; font-family:Arial, Helvetica, sans-serif;padding-bottom:5px;"><strong>Tel:</strong> 08 3991 4018&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Hotline:</strong> 0934 024 124</div></td>
        </tr>
      </table>
      <table width="590" border="0" cellspacing="4" cellpadding="0">
           <tr>
                <td colspan="2" align="center" valign="top" style="color:#1d94bf; font-size:15px; font-family:Arial, Helvetica, sans-serif;font-weight:bold; padding-left:15px; padding-top:5px; padding-bottom:5px">Cheapdeal xác nhận đơn hàng</td></tr><tr>
                <td colspan="2" align="left" style="padding-left:10px;font-size:12px; font-family:Arial, Helvetica, sans-serif;padding-bottom:5px; padding-top:5px;">Kính chào Qúy khách! Cám ơn Quý khách đã đặt hàng tại website của chúng tôi</td>
              </tr><tr>
                <td align="left" colspan="2"  style="padding-left:10px;font-size:12px; font-family:Arial, Helvetica, sans-serif; line-height:18px;padding-bottom:3px;padding-top:3px;"><strong>Người nhận:</strong> <?php echo $order['realname']; ?></td>
        </tr>
         <tr>
                <td width="319" align="left" valign="top"  style="padding-left:10px;font-size:12px; font-family:Arial, Helvetica, sans-serif; line-height:18px;padding-bottom:3px;padding-top:3px;"><strong>Địa chỉ:</strong> <?php echo $order['address']; ?></td><td width="259" align="left" valign="top" style="padding-left:10px;font-size:12px; font-family:Arial, Helvetica, sans-serif; line-height:18px;padding-bottom:3px;padding-top:3px;"><strong>Điện thoại:</strong> <?php echo $order['mobile']; ?> </td>
              </tr>
        <tr>
          <td align="left" nowrap="nowrap" colspan="2" style="padding-left:10px;font-size:12px; font-family:Arial, Helvetica, sans-serif; line-height:18px;padding-bottom:3px;padding-top:3px;"><strong>PT thanh toán:</strong> <?php echo GetPaymentName($order['payment_id']); ?></td></tr><tr>
            <td align="left" nowrap="nowrap" colspan="2" style="padding-left:10px;font-size:12px; font-family:Arial, Helvetica, sans-serif; line-height:18px;padding-bottom:3px;padding-top:3px;"><strong>PT vận chuyển: </strong><?php echo GetShippingName($order['shipping_id']); ?></td></tr>
            
      </table>
      <table border="0" cellpadding="0" cellspacing="0" width="590" style="BORDER-RIGHT: #b1d1e6 1px solid; BORDER-TOP: #b1d1e6 1px solid; TEXT-DECORATION: none; background-color:#FDFA9D; width:100%; font-family:Arial, Helvetica, sans-serif; width:590px">
        <tbody>
          <tr>
            <th align="center" width="20" style="PADDING-RIGHT: 6px; PADDING-LEFT: 6px; PADDING-BOTTOM: 6px; PADDING-TOP: 6px; font-weight:bold; font-size:12px;BORDER-BOTTOM: #b1d1e6 1px solid; BORDER-LEFT: #b1d1e6 1px solid; color:#07519a">Mã ĐH</th>
            <th align="center" width="120" style="PADDING-RIGHT: 6px; PADDING-LEFT: 6px; PADDING-BOTTOM: 6px; PADDING-TOP: 6px; font-weight:bold; font-size:12px;BORDER-BOTTOM: #b1d1e6 1px solid; BORDER-LEFT: #b1d1e6 1px solid; color:#07519a">Tên Deal</th>
            <th align="center" width="100" style="PADDING-RIGHT: 6px; PADDING-LEFT: 6px; PADDING-BOTTOM: 6px; PADDING-TOP: 6px; font-weight:bold; font-size:12px;BORDER-BOTTOM: #b1d1e6 1px solid; BORDER-LEFT: #b1d1e6 1px solid; color:#07519a">Ngày Mua</th>
            <th align="center" width="20" style="PADDING-RIGHT: 6px; PADDING-LEFT: 6px; PADDING-BOTTOM: 6px; PADDING-TOP: 6px; font-weight:bold; font-size:12px;BORDER-BOTTOM: #b1d1e6 1px solid; BORDER-LEFT: #b1d1e6 1px solid; color:#07519a">SL</th>
            <th align="center" width="90" style="PADDING-RIGHT: 6px; PADDING-LEFT: 6px; PADDING-BOTTOM: 6px; PADDING-TOP: 6px; font-weight:bold; font-size:12px;BORDER-BOTTOM: #b1d1e6 1px solid; BORDER-LEFT: #b1d1e6 1px solid; color:#07519a" nowrap="nowrap">Đơn Giá</th>
            <th align="center" width="90" style="PADDING-RIGHT: 6px; PADDING-LEFT: 6px; PADDING-BOTTOM: 6px; PADDING-TOP: 6px; font-weight:bold; font-size:12px;BORDER-BOTTOM: #b1d1e6 1px solid; BORDER-LEFT: #b1d1e6 1px solid; color:#07519a" nowrap="nowrap">Thành Tiền</th>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td align="center" style="PADDING-RIGHT: 6px; PADDING-LEFT: 6px; PADDING-BOTTOM: 6px; PADDING-TOP: 6px; BORDER-BOTTOM: #b1d1e6 1px solid;BORDER-LEFT: #b1d1e6 1px solid;"><?php echo $order['id']; ?></td>
            <td align="left" style="PADDING-RIGHT: 6px; PADDING-LEFT: 6px; PADDING-BOTTOM: 6px; PADDING-TOP: 6px; BORDER-BOTTOM: #b1d1e6 1px solid;BORDER-LEFT: #b1d1e6 1px solid;font-family:Arial; font-size:12px;"><?php echo $team['short_title']; ?></td>
            <td align="center" style="PADDING-RIGHT: 6px; PADDING-LEFT: 6px; PADDING-BOTTOM: 6px; PADDING-TOP: 6px; BORDER-BOTTOM: #b1d1e6 1px solid;BORDER-LEFT: #b1d1e6 1px solid;font-family:Arial; font-size:12px;"><?php echo date('Y-m-d H:i',$order['create_time']); ?></td>
            <td align="center" style="PADDING-RIGHT: 6px; PADDING-LEFT: 6px; PADDING-BOTTOM: 6px; PADDING-TOP: 6px; BORDER-BOTTOM: #b1d1e6 1px solid;BORDER-LEFT: #b1d1e6 1px solid;font-family:Arial; font-size:12px;"><?php echo $order['quantity']; ?></td>
            <td align="center" style="PADDING-RIGHT: 6px; PADDING-LEFT: 6px; PADDING-BOTTOM: 6px; PADDING-TOP: 6px; BORDER-BOTTOM: #b1d1e6 1px solid;BORDER-LEFT: #b1d1e6 1px solid;font-family:Arial; font-size:12px;"><?php echo print_price(moneyit($order['price'])); ?></td>
            <td align="center" style="PADDING-RIGHT: 6px; PADDING-LEFT: 6px; PADDING-BOTTOM: 6px; PADDING-TOP: 6px; BORDER-BOTTOM: #b1d1e6 1px solid;BORDER-LEFT: #b1d1e6 1px solid;font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:bold"><?php echo print_price(moneyit($order['origin'])); ?></td>
          </tr>
          <tr>
            <td colspan="6" style="PADDING-RIGHT: 6px; PADDING-LEFT: 6px; PADDING-BOTTOM: 6px; PADDING-TOP: 6px; BORDER-BOTTOM: #b1d1e6 1px solid;BORDER-LEFT: #b1d1e6 1px solid;" align="right">
            <table align="right" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="right" style="padding-top:5px;padding-bottom:5px; font-size:12px">Số  tiền:</td>
                    <td align="right" style="font-family:Georgia, 'Times New Roman', Times, serif; font-weight:bold; font-size:15px;color:#c40000;padding-left:5px;padding-right:5px;"><?php echo print_price(moneyit($order['origin'])); ?></td>
                  </tr>
                  <tr>
                    <td align="right" style="padding-top:5px;padding-bottom:5px; font-size:12px">Số dư tài khoản:</td>
                    <td align="right" style="font-family:Georgia, 'Times New Roman', Times, serif; font-weight:bold; font-size:15px;padding-left:5px;padding-right:5px;">
                    <?php if($login_user['money']>0){?>
                    	<?php echo print_price(moneyit($login_user['money'])); ?>
                    <?php } else { ?>0<?php }?></td>
                  </tr>
                  <tr>
                    <td align="right" style="padding-top:5px;padding-bottom:5px; font-size:12px">Đã thanh toán:</td>
                    <td align="right" style="font-family:Georgia, 'Times New Roman', Times, serif; font-weight:bold; font-size:15px;padding-left:5px; padding-right:5px;padding-right:5px;">
                    <?php if($order['credit']>0){?>
                    	<?php echo print_price(moneyit($order['credit'])); ?>	
                    <?php } else if($order['money']>0) { ?>
                    	<?php echo print_price(moneyit($order['money'])); ?>
                   <?php } else { ?>0<?php }?></td>
                  </tr>
                  <tr>
                    <td align="right" style="padding-top:5px;padding-bottom:5px; font-size:12px">Tổng số tiền:</td>
                    <td align="right" style="font-family:Georgia, 'Times New Roman', Times, serif; font-weight:bold; font-size:15px;color:#c40000; padding-left:5px;padding-right:5px;"><?php echo print_price(moneyit($order['origin']-$order['money']-$order['credit'])); ?></td>
                  </tr>
                </table>
           </td>
          </tr>
          <?php if($order['remark']!=''){?>
          <tr bgcolor="#FFFFFF">
            <td align="left" colspan="6" style="PADDING-RIGHT: 6px; PADDING-LEFT: 6px; PADDING-BOTTOM: 6px; PADDING-TOP: 6px; BORDER-BOTTOM: #b1d1e6 1px solid;BORDER-LEFT: #b1d1e6 1px solid; font-size:12px" >Ghi chú: <?php echo $order['remark']; ?></td>
          </tr>
          <?php }?>
        </tbody>
      </table>
	  
	  
	  
	  <div align="left" style="padding-left:10px;">
      <div align="left" style="color:#c40000"><strong>Thanh toán qua ATM, quý khách vui lòng chuyển khoản bằng ATM cho Cheapdeal theo thông tin sau:</strong></div>
      <table width="100%" border="0">
		<tbody>
			<tr>
				<td align="left" valign="top" width="50%">
					<strong>NGÂN HÀNG VIETCOMBANK</strong><br />
					      Số tài khoản:&nbsp;<strong>0071001417145</strong><br />
					    Chủ TK:&nbsp;<strong>Trịnh Quốc Cường</strong>
				</td>
			<td align="left" valign="top" width="50%" style="padding-top:5px">
					<strong>NGÂN HÀNG VIETINBANK</strong><br />
					      Số tài khoản:&nbsp;<strong>711A11871463</strong><br />
					    Chủ TK:&nbsp;<strong>Trịnh Quốc Cường</strong>
				</td>
			</tr>
			<tr>
				<td align="left" valign="top" width="50%" style="padding-top:5px">
					<strong>NGÂN HÀNG ĐÔNG Á</strong><br />
					      Số tài khoản:&nbsp;<strong>0101493309</strong><br />
					    Chủ TK:&nbsp;<strong>Trịnh Quốc Cường</strong>
				</td>
			
				</td>
			</tr>
		</tbody>
	</table></div>
	  
	  
      <table width="590" border="0" cellspacing="4" cellpadding="0">
        <tr>
          <td align="left" valign="top" bgcolor="#FFFFFF"><div style="margin-top:10px; color: rgb(102, 102, 102); font-weight: normal; line-height: 22px; font-size:13px;" align="left"> - Bạn cần đem theo phiếu (voucher) của <strong>Cheapdeal</strong> đến nơi cung cấp sản phẩm/dịch vụ để  nhận được sản phẩm/dịch vụ giảm giá.<br />
- Thời gian giao hàng dự kiến: Từ 3- 5 ngày không tính thứ 7 & CN.<br />- Quyền lợi của khách hàng là trách nhiệm của <strong>Cheapdeal</strong>. Khi nhận phiếu/hàng vui lòng ký vào biên bản xác nhận của nhận viên giao hàng. <strong>Cheapdeal</strong> sẽ không chịu trách nhiệm bất cứ khiếu nại nào nếu không có chữ ký của khách hàng trong biên bản xác nhận.</div>
                       </td>
        </tr>
      </table></td>
  </tr>
</table>
