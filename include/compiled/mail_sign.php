<table border="0" cellpadding="0" cellspacing="0" width="600" style="border-bottom:5px solid #50bde8;border-left:5px solid #50bde8;border-right:5px solid #50bde8;border-top:5px solid #50bde8; width:600px; background-color: rgb(255, 255, 255,255);-moz-border-radius: 8px  8px  8px  8px; border-top-left-radius: 8px; padding: 0; border-top-right-radius: 8px; border-bottom-right-radius: 8px; border-bottom-left-radius: 8px; border-width: 5px;">
  <tr>
    <td align="left" valign="top" style=" padding:10px; margin:10px;"><table width="590" border="0" cellspacing="0" cellpadding="0">
        
              <tr>
                <td width="50%" align="left" style="border-bottom:#CCC 1px solid"><a href="http://<?php echo $INI['system']['sitename']; ?>" target="_blank"><img src="http://www.dealsoc.vn/static/css/images/LogoConfirmOrder.jpg" border="0" width="145" height="60" /></a></td><td width="72%" align="right" valign="top" style="border-bottom:#CCC 1px solid"><div  style="color:#1d94bf; font-size:15px; font-family:Arial, Helvetica, sans-serif;font-weight:bold; padding-right:10px; padding-top:5px; padding-bottom:5px">&nbsp;</div><div  style="padding-right:10px;font-size:12px; font-family:Arial, Helvetica, sans-serif;padding-bottom:5px; white-space:nowrap">51 Nhiêu Tứ (Hoa Sứ Nối Dài), P.7, Q.Phú Nhuận. TPHCM</div><div style="padding-right:10px;font-size:12px; font-family:Arial, Helvetica, sans-serif;padding-bottom:5px;"><strong>Tel:</strong> 84-873024401&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Fax:</strong> 08.39300394</div></td>
        </tr>
      </table>
      <table width="590" border="0" cellspacing="4" cellpadding="0">
           <tr>
                <td colspan="2" align="center" valign="top" style="color:#1d94bf; font-size:15px; font-family:Arial, Helvetica, sans-serif;font-weight:bold; padding-left:15px; padding-top:5px; padding-bottom:5px">Dealsoc xác nhận đơn hàng</td></tr><tr>
                <td colspan="2" align="left" style="padding-left:10px;font-size:12px; font-family:Arial, Helvetica, sans-serif;padding-bottom:5px; padding-top:5px;"><strong><?php echo $INI['system']['sitetitle']; ?></strong> Kính chào Qúy khách! Cám ơn Quý khách đã đặt hàng tại website của chúng tôi</td>
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
                    <td align="right" style="padding-top:5px;padding-bottom:5px">Số  tiền:</td>
                    <td align="right" style="font-family:Georgia, 'Times New Roman', Times, serif; font-weight:bold; font-size:15px;color:#c40000;padding-left:5px;padding-right:5px;"><?php echo print_price(moneyit($order['origin'])); ?></td>
                  </tr>
                  <tr>
                    <td align="right" style="padding-top:5px;padding-bottom:5px">Số dư tài khoản:</td>
                    <td align="right" style="font-family:Georgia, 'Times New Roman', Times, serif; font-weight:bold; font-size:15px;padding-left:5px;padding-right:5px;">
                    <?php if($login_user['money']>0){?>
                    	<?php echo print_price(moneyit($login_user['money'])); ?>
                    <?php } else { ?>0<?php }?></td>
                  </tr>
                  <tr>
                    <td align="right" style="padding-top:5px;padding-bottom:5px">Đã thanh toán:</td>
                    <td align="right" style="font-family:Georgia, 'Times New Roman', Times, serif; font-weight:bold; font-size:15px;padding-left:5px; padding-right:5px;padding-right:5px;">
                    <?php if($order['credit']>0){?>
                    	<?php echo print_price(moneyit($order['credit'])); ?>	
                    <?php } else if($order['money']>0) { ?>
                    	<?php echo print_price(moneyit($order['money'])); ?>
                   <?php } else { ?>0<?php }?></td>
                  </tr>
                  <tr>
                    <td align="right" style="padding-top:5px;padding-bottom:5px">Tổng số tiền:</td>
                    <td align="right" style="font-family:Georgia, 'Times New Roman', Times, serif; font-weight:bold; font-size:15px;color:#c40000; padding-left:5px;padding-right:5px;"><?php echo print_price(moneyit($order['origin']-$order['money']-$order['credit'])); ?></td>
                  </tr>
                </table>
           </td>
          </tr>
          <?php if($order['remark']!=''){?>
          <tr bgcolor="#FFFFFF">
            <td align="left" colspan="6" style="PADDING-RIGHT: 6px; PADDING-LEFT: 6px; PADDING-BOTTOM: 6px; PADDING-TOP: 6px; BORDER-BOTTOM: #b1d1e6 1px solid;BORDER-LEFT: #b1d1e6 1px solid;" >Ghi chú: <?php echo $order['remark']; ?></td>
          </tr>
          <?php }?>
        </tbody>
      </table>
	  
	  
	  
	  <div align="left" style="padding-left:10px;">
      <div align="left" style="color:#c40000"><strong>Thanh toán qua ATM, quý khách vui lòng chuyển khoản bằng ATM cho Dealsoc theo thông tin sau:</strong></div>
      <table width="100%" border="0">
		<tbody>
			<tr>
				<td align="left" valign="top" width="50%">
					<strong>NGÂN HÀNG SACOMBANK</strong><br />
					      Số tài khoản:&nbsp;<strong>060053 445 449</strong><br />
					Chi nhánh:&nbsp;<strong>PGD TÂN ĐỊNH</strong><br />
					    Chủ TK:&nbsp;<strong>CTY CP TM ALL IN ONE</strong>
				</td>
			<td align="left" valign="top" width="50%" style="padding-top:5px">
					<strong>NGÂN HÀNG AGRIBANK</strong><br />
					      Số tài khoản:&nbsp;<strong>1604201023396</strong><br />
					      Chi nhánh:&nbsp;<strong>PGD PHÚ NHUẬN</strong><br />
					    Chủ TK:&nbsp;<strong>CTY CP TM ALL IN ONE</strong>
				</td>
			</tr>
			<tr>
				<td align="left" valign="top" width="50%" style="padding-top:5px">
					<strong>NGÂN HÀNG VIETCOMBANK</strong><br />
					      Số tài khoản:&nbsp;<strong>0371000407798</strong><br />
					      Chi nhánh:&nbsp;<strong>PGD PHÚ NHUẬN</strong><br />
					    Chủ TK:&nbsp;<strong>CTY CP TM ALL IN ONE</strong>
				</td>
			<td align="left" valign="top" width="50%" style="padding-top:5px">
					<strong>NGÂN HÀNG VIETIN BANK</strong><br />
					      Số tài khoản:&nbsp;<strong>102010001575004</strong><br />
					      Chi nhánh:&nbsp;<strong>PGD TÂN ĐỊNH</strong><br />
					    Chủ TK:&nbsp;<strong>CTY CP TM ALL IN ONE</strong>
				</td>
			</tr>
			<tr>
				<td align="left" valign="top" width="50%" style="padding-top:5px">
					<strong>NGÂN HÀNG ACB</strong><br />
					      Số tài khoản:&nbsp;<strong>142398269</strong><br />
					      Chi nhánh:&nbsp;<strong>PGD TÂN ĐỊNH</strong><br />
					    Chủ TK:&nbsp;<strong>CTY CP TM ALL IN ONE</strong>
				</td>
			<td align="left" valign="top" width="50%" style="padding-top:5px">
					<strong>NGÂN HÀNG ĐÔNG Á</strong><br />
					      Số tài khoản:&nbsp;<strong>009549490001</strong><br />
					      Chi nhánh:&nbsp;<strong>PGD PHÚ NHUẬN</strong><br />
					    Chủ TK:&nbsp;<strong>CTY CP TM ALL IN ONE</strong>
				</td>
			</tr>
		</tbody>
	</table></div>
	  
	  
      <table width="590" border="0" cellspacing="4" cellpadding="0">
        <tr>
          <td align="left" valign="top" bgcolor="#FFFFFF"><div style="margin-top:10px; color: rgb(102, 102, 102); font-weight: normal; line-height: 22px; font-size:13px;" align="left"> - Bạn cần đem theo phiếu (voucher) của <strong>Dealsoc</strong> đến nơi cung cấp sản phẩm/dịch vụ để  nhận được sản phẩm/dịch vụ giảm giá.<br />
- Thời gian giao hàng dự kiến: Từ 3- 5 ngày không tính thứ 7 & CN.<br />- Quyền lợi của khách hàng là trách nhiệm của <strong>Dealsoc</strong>. Khi nhận phiếu/hàng vui lòng ký vào biên bản xác nhận của nhận viên giao hàng. <strong>Dealsoc</strong> sẽ không chịu trách nhiệm bất cứ khiếu nại nào nếu không có chữ ký của khách hàng trong biên bản xác nhận.</div>
                       </td>
        </tr>
      </table></td>
  </tr>
</table>
