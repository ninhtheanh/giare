<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Phiếu xuất kho <?php echo rtrim($dist_name,", "); ?> - Ngày: <?php echo $rs[0]['created']; ?></title></head>
<body>
<div align="center" style="padding-bottom:10px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="15%" height="41" style="padding-left:10px; font-size:12px; font-family:Arial, Helvetica, sans-serif" valign="top" nowrap="nowrap"><img src="/static/css/images/LogoConfirmOrder.jpg" width="100" align="left" /><strong>CHEAPDEAL TP.HỒ CHÍ MINH</strong><br />137/5A Lê Văn Sỹ, P.13, Q.Phú Nhuận, Tp. HCM<br />
      <strong>ĐT:</strong> 0909.68.2311 </td>
    <td width="73%" align="center"><h2 style="font-size:25px;font-family:Arial, Helvetica, sans-serif; margin:0px">Đơn hàng <?php echo rtrim($dist_name,", "); ?></h2>Ngày: <?php echo date("d/m/Y H:i:s", strtotime($rs[0]['created'])); ?></td>
    <td width="15%" nowrap="nowrap" align="right"><span style="font-size:22px;font-family:Georgia, "Times New Roman", Times, serif"><strong>Số: <?php echo $rs[0]['out_id']; ?></strong></span></td>
  </tr>
</table>
</div>
<div align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%" align="left" style="font-size:12px; font-family:Arial, Helvetica, sans-serif"><strong>Người nhận:</strong> <?php echo $shippers[$rs[0]['shipper']]['shipper_name']; ?></td>
    <td align="right" style="font-size:12px; font-family:Arial, Helvetica, sans-serif"><strong>Bộ phận: Giao hàng</strong></td>
  </tr>
</table>
</div>
<div align="center">
    <table cellspacing="0" cellpadding="0" border="1" width="100%" style="border-collapse:collapse;">
    <tr><th width="10" style="padding-left:5px; padding-right:5px;font-size:12px; font-family:Arial;">Stt</th>
    <th width="160" style="font-size:12px; font-family:Arial;">Deal/MSĐH</th>
    <th width="130" style="font-size:12px; font-family:Arial;">Họ tên/ĐT</th>
    <th width="220" style="font-size:12px; font-family:Arial;">Địa chỉ</th>
    <th width="20" nowrap style="padding-left:5px; padding-right:5px;font-size:12px; font-family:Arial;">SL</th>
    <th width="50" nowrap="nowrap" style="font-size:12px; font-family:Arial;">TT</th>
    <th width="180" nowrap="nowrap" style="font-size:12px; font-family:Arial;">Ghi chú</th>
    <th width="30" nowrap style="padding-left:5px; padding-right:5px;font-size:12px; font-family:Arial;">KH ký nhận</th>
    <th width="20" nowrap style="padding-left:2px; padding-right:2px;font-size:12px; font-family:Arial;" bgcolor="#CCCCCC">TC</th>
    <th width="20" nowrap style="padding-left:2px; padding-right:2px;font-size:12px; font-family:Arial;" bgcolor="#CCCCCC">H</th><th width="20" nowrap style="padding-left:2px; padding-right:2px;font-size:12px; font-family:Arial;" bgcolor="#CCCCCC">CT</th><th width="20" nowrap style="padding-left:2px; padding-right:2px;font-size:12px; font-family:Arial;" bgcolor="#CCCCCC">TH</th>
    </tr>
    <?php if(is_array($rs)){foreach($rs AS $index=>$one) { ?>
    <tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>">
        <?php 
            $vcode = DB::GetQueryResult("SELECT `serial`, `code` FROM `voucher_code` WHERE order_id='".$one['order_id']."' AND team_id='".$one['deal_id']."'",false);
            if(!empty($vcode)){
                $serial_number = "<tr><td align='left' valign='top' colspan='2' style='padding:2px'><table width=100% style='border-collapse:collapse; border:1px solid #CCCCCC; font-size:12px;font-family:Arial'><tr bgcolor='#f1f3f5'><td style='padding-left:3px; border-right:1px solid #CCCCCC; border-bottom:1px solid #CCCCCC'><i><strong>Số Seri</strong></i></td><td style='padding-left:3px; border-bottom:1px solid #CCCCCC'><i><strong>Mã Voucher</strong></i></td></tr>";
                for($i=0;$i<count($vcode);$i++){
                    $serial_number .= "<tr><td style='padding-left:3px; border-right:1px solid #CCCCCC; border-bottom:1px solid #CCCCCC; font-size:13px;font-family:Arial'>".$vcode[$i]['serial']."</td><td style='padding-left:3px; border-bottom:1px solid #CCCCCC; font-size:13px;font-family:Arial'>".$vcode[$i]['code']."</td></tr>";
                }
                $serial_number .= "</table></td></tr>";
                $rowspan="rowspan=2";
             }else{
                $serial_number="";$rowspan="";
             }
        ; ?>
       <td align="center" <?php echo $rowspan; ?>><?php echo $index+1; ?><br />
       
       <?php 
       		
            DB::Query("UPDATE `order` SET stt_bbbg = ($index+1) WHERE id = ".$one['order_id']);
       		$history_name = DB::GetQueryResult("SELECT status_code FROM order_history WHERE order_id='".$one['order_id']."' AND status_code='pending'");
        	if(!empty($history_name['status_code'])) echo "<span style=\"padding:5px; font-size:18px; font-weight:bold; color:#ff0000\">(x)</span>";
        ; ?></td>
        <td style="font-size:12px; font-family:arial; padding-left:3px;" align="left" valign="top">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td style="font-size:22px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; padding-right:3px;" align="left" width="5%"><?php echo $one['deal_id']; ?></td>
                <td align="left" valign="top" width="95%"><?php echo $one['order_id']; ?><br />
                 <?php 
                    $partner = Table::Fetch('partner', $teams[$one['deal_id']]['partner_id']);
                    $dp = DB::GetQueryResult("SELECT delivery_properties FROM team WHERE id =".$one['deal_id']);
                 ; ?>
                 <!--<?php echo cut_string($partner['title'],30,"..."); ?> - --><?php echo cut_string($teams[$one['deal_id']]['short_title'],90,""); ?></td>
				 
              </tr>
              
            </table>
        </td>
        <td style="padding-left:5px; padding-right:5px;"><div align="left" style="font-size:12px; font-family:arial"><?php echo $one['cus_name']; ?></div><div align="left" style="font-size:12px; font-family:arial"><?php echo $one['cus_phone']; ?><br /><?php if($dp['delivery_properties']==1){?><!--(Giao sản phẩm)--><?php } else { ?><!--(Giao Voucher)--><?php }?></div></td>
      	<td style="padding:5px;font-size:12px; font-family:arial" <?php echo $rowspan; ?>><?php if ($one['note_address']!=''){$note_address = $one['note_address'].", ";}else{$note_address="";}; ?><?php echo $note_address; ?><?php echo $one['cus_address']; ?></td>
        <td style="padding-left:5px; padding-right:5px;font-size:12px; font-family:arial" align="center" <?php echo $rowspan; ?>><?php echo $one['quantity']; ?></td>
        <td style="padding-left:5px; padding-right:5px;font-weight:bold;font-size:12px; font-family:arial" align="right" nowrap="nowrap" <?php echo $rowspan; ?>><?php echo print_price(moneyit($one['amount']+$order_money[0]['shipping_cost']+$order_money[0]['payment_cost'])); ?>
        	<?php 
            	$order_money = DB::GetQueryResult("SELECT money, notes, credit, payment_id, transaction_id_nl, shipping_cost, payment_cost FROM `order` WHERE id='".$one['order_id']."'", false);
                if ($order_money[0]['credit']>=$one['amount']){
                	echo $add = "<br />Đã tt: <b>".print_price($order_money[0]['credit'])."</b>";
                }else{
                	if($order_money[0]['money']>0){ 
                    	echo $add = "<br />Đã tt: <b>".print_price($order_money[0]['money'])."</b><br />CL: <b><i>".print_price(moneyit($one['amount']+$order_money[0]['shipping_cost']+$order_money[0]['payment_cost']-$order_money[0]['money']))."</b></i>";
                    }
               }
               if($order_money[0]['payment_id']==5 && (int)$order_money[0]['transaction_id_nl']>0){
               		echo $add_nl = "<br />Đã tt qua NganLuong.vn<b>";
               }
               if($order_money[0]['payment_id']==3 && (int)$order_money[0]['paid_atm']>0){
               		echo $add_atm = "<br />Đã tt qua ATM<b>";
               }
            ; ?>   </td>
      	<td style="padding-left:5px; padding-right:5px;font-size:12px; font-family:arial" <?php echo $rowspan; ?>><?php if($one['cus_notes']!=''){?><?php echo cut_string($one['cus_notes'],100,"..."); ?><br /><?php }?><i><?php echo $order_money[0]['notes']; ?></i></td>
        <td <?php echo $rowspan; ?>>&nbsp;</td>
        <td <?php echo $rowspan; ?>>&nbsp;</td>
        <td <?php echo $rowspan; ?>>&nbsp;</td>
        <td <?php echo $rowspan; ?>>&nbsp;</td>
        <td <?php echo $rowspan; ?>>&nbsp;</td>
        
    </tr>
        <?php echo $serial_number; ?>   
    <?php }}?>
    </table>
</div>
<div style="padding-top:10px;padding-bottom:10px;font-size:12px; font-family:Arial, Helvetica, sans-serif"><strong>Chú Thích:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>TT</strong>: Thành tiền&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>TC</strong>: thành công &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>H</strong>: Hủy &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>CT</strong>: Chuyển tiếp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>TH</strong>: Tạm hoãn nhận Voucher</div>
<h2> </h2>
<div align="left" style="padding-top:10px; font-size:12px; font-family:Arial, Helvetica, sans-serif">
<table width="100%" border="1" style="border-collapse:collapse" cellspacing="0" cellpadding="0">
 <tr><td style="padding:3px;"><strong>Stt</strong></td><td align="left" valign="top" style="padding:3px"><strong>Deal</strong></td><td align="right" valign="top" style="padding:3px" width="80"><strong>SL giao</strong></td>
 <td align="right" valign="top" style="padding:3px" width="80"><strong>SL  Nhận</strong></td><td align="right" valign="top" style="padding:3px" width="80"><strong>SL Trả</strong></td>
 <td align="left" valign="top" style="padding:3px"><strong>Thành tiền (VNĐ)</strong></td></tr>
 <?php if(is_array($r)){foreach($r AS $index=>$one) { ?>
    <tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>">
        <td align="center"><?php echo $index+1; ?></td>
        <td style="padding-left:5px; padding-right:5px;font-size:12px; font-family:arial"><strong>(<?php echo $one['deal_id']; ?>)</strong>&nbsp;<?php echo $teams[$one['deal_id']]['short_title']; ?>
     <?php 
     	$sum_qty = "";
        $partner = Table::Fetch('partner', $teams[$one['deal_id']]['partner_id']);$sum_qty += $one['qty'];
        $sum_amt += $one['amt'];
        $dp = DB::GetQueryResult("SELECT delivery_properties FROM team WHERE id =".$one['deal_id']);
        ; ?>
     <b><?php echo $partner['title']; ?> - <span style="font-style:italic"><?php if($dp['delivery_properties']==1){?><!--(Giao sản phẩm)--><?php } else { ?><!--(Giao Voucher)--></span><?php }?></b></td>     
        <td style="padding-left:5px; padding-right:5px;font-size:12px; font-family:arial; padding:3px;" align="right"><?php echo $one['qty']; ?></td>
        <td style="padding-left:5px; padding-right:5px;font-weight:bold" align="right">&nbsp;</td>
		<td style="padding-left:5px; padding-right:5px;font-weight:bold" align="right">&nbsp;</td>
        <td style="padding-left:5px; padding-right:5px;font-weight:bold;font-size:12px; font-family:arial" align="right" nowrap="nowrap"><?php echo print_price(moneyit($one['amt'])); ?></td>
    </tr>
    <?php }}?>
  <tr><td></td><td align="left" valign="top" style="padding:3px"><strong>Tổng cộng</strong></td><td align="right" valign="top" style="padding:3px"><strong><?php echo $sum_qty; ?></strong></td><td style="padding-left:5px; padding-right:5px;font-weight:bold" align="right">&nbsp;</td>
		<td style="padding-left:5px; padding-right:5px;font-weight:bold" align="right">&nbsp;</td><td align="right" valign="top" style="padding:3px"><strong><?php echo number_format($sum_amt,0,",","."); ?></strong></td></tr>
  </table>

	<br />
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px; font-family:Arial, Helvetica, sans-serif">
      <tr>
       <td align="center" valign="top" width="30%">Người lập phiếu<br />
        (Ký, ghi rõ họ tên)<br /><br /><br /><br /><strong><?php echo $creators[$rs[0]['creator']]['realname']; ?></strong></td>
        <td>&nbsp;</td>
        <td align="center" valign="top" width="30%">Người nhận<br />
        (Ký, ghi rõ họ tên)<br /><br /><br /><br /><strong><?php echo $shippers[$rs[0]['shipper']]['shipper_name']; ?></strong></td>
        <td>&nbsp;</td>
        
        <td align="center" valign="top" width="30%">Thủ kho<br />
        (Ký, ghi rõ họ tên)</td>
    </tr>
    </table><br />
  <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;font-size:12px; font-family:Arial, Helvetica, sans-serif">
    <tr>
      <td colspan=4 align=left style="padding:5px" bgcolor="#CCCCCC"><strong>Người nhận thống Kê - Mã số <?php echo $rs[0]['out_id']; ?></strong></td>
    </tr>
	<tr>
       <td align="center" valign="top" width="25%" style="padding:3px;"><strong>Thành công</strong></td>    
       <td align="center" valign="top" width="25%" style="padding:3px;"><strong>Hủy</strong></td>
       <td align="center" valign="top" width="25%" style="padding:3px;"><strong>Chuyển tiếp</strong></td>
       <td align="center" valign="top" width="25%" style="padding:3px;"><strong>Tạm hoãn</strong></td>
    </tr>
	<tr><td style="padding-top:5px;padding-bottom:5px">&nbsp;</td><td style="padding-top:5px;padding-bottom:5px">&nbsp;</td><td style="padding-top:5px;padding-bottom:5px">&nbsp;</td><td style="padding-top:5px;padding-bottom:5px">&nbsp;</td></tr>
    </table>
</div>
<div style="page-break-after:always"></div>
<div align="center" style="padding-top:10px;">
    <h2 style="font-family:Arial, Helvetica, sans-serif; font-size:22px; margin:0x; padding:0px">Phiếu xuất kho <?php if($rs[0]['city']!=11){?>đi tỉnh<?php } else { ?><?php echo rtrim($dist_name,", "); ?><?php }?><br />
    <?php echo date("d/m/Y H:i:s", strtotime($rs[0]['created'])); ?></h2>
</div>
<div align="left" style="font-family:Arial, Helvetica, sans-serif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" style="font-size:12px">Người nhận: <span  style="font-size:18px"> <strong><?php echo $shippers[$rs[0]['shipper']]['shipper_name']; ?></strong></td>
    <td align="right" style="font-size:12px;"><strong>Mã số:</strong><span  style="font-size:18px"> <strong><?php echo $rs[0]['out_id']; ?></strong></span></td>
  </tr>
</table>
</div>
<div align="left" style="padding-top:5px; font-size:12px; font-family:Arial, Helvetica, sans-serif">
<table width="100%" border="1" style="border-collapse:collapse; border-color:#999999" cellspacing="0" cellpadding="0">
 <tr bgcolor="#CCCCCC">
   <td style="padding:3px;" align="center"><strong>Stt</strong></td>
   <td align="left" valign="top" style="padding:3px" width="40" nowrap="nowrap"><strong>Mã Deal</strong></td>
   
  <!-- <td align="left" valign="top" style="padding:3px" width="200" nowrap="nowrap"><strong>Partner</strong></td>-->
   <td align="left" valign="top" style="padding:3px" ><strong>Tên Deal</strong></td>
   <td align="right" valign="top" style="padding:3px" width="40" nowrap="nowrap"><strong>SL giao</strong></td>
   <td align="right" valign="top" style="padding:3px" width="40" nowrap="nowrap"><strong>SL nhận</strong></td>
      <td align="right" valign="top" style="padding:3px" width="40" nowrap="nowrap"><strong>SL trả</strong></td>
	  <td align="right" valign="top" style="padding:3px" width="40" nowrap="nowrap"><strong>SL lần 1</strong></td>
	  <td align="right" valign="top" style="padding:3px" width="50"><strong>SL lần 2</strong></td>
	  <td align="right" valign="top" style="padding:3px" width="470"><strong>Ghi Chú</strong></td></tr>
 
 
 <?php if(is_array($r)){foreach($r AS $index=>$one) { ?>
 
    <tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>">
        <td align="center"><?php echo $index+1; ?></td>
        <td style="padding-left:5px; padding-right:5px;" align="center"><strong><?php echo $one['deal_id']; ?></strong></td>
		<!--<td style="padding:5px;font-size:12px; font-family:Arial"><?php 
     	$partner = Table::Fetch('partner', $teams[$one['deal_id']]['partner_id']);
        $dp = DB::GetQueryResult("SELECT delivery_properties FROM team WHERE id =".$one['deal_id']);
     ; ?><?php echo $partner['title']; ?></td> -->
     	<td style="padding-left:5px; padding-right:5px; font-size:12px; font-family:Arial, Helvetica, sans-serif"><b><?php echo $teams[$one['deal_id']]['short_title']; ?></b><br /><span style="font-style:italic"><?php if($dp['delivery_properties']==1){?>(Giao SP)<?php } else { ?>(Giao Voucher)</span><?php }?></td>     
        <td style="padding-left:5px; padding-right:5px;" align="right"><?php echo $one['qty']; ?></td>
		<td style="padding-left:5px; padding-right:5px;font-weight:bold" align="right">&nbsp;</td>
		<td style="padding-left:5px; padding-right:5px;font-weight:bold" align="right">&nbsp;</td>
		<td style="padding-left:5px; padding-right:5px;font-weight:bold" align="right">&nbsp;</td>
				<td style="padding-left:5px; padding-right:5px;font-weight:bold" align="right">&nbsp;</td>
		<td style="padding-left:5px; padding-right:5px;font-weight:bold" align="right">&nbsp;</td>
    </tr>
   
    <?php }}?>
 

  <tr><td></td><td></td><td colspan="2" align="center"><span style="padding:3px"><strong>Tổng cộng</strong></span>&nbsp;</td><td align="right" valign="top" style="padding:3px"><strong><?php echo $sum_qty_1; ?></strong></td><!--<td align="right" valign="top" style="padding:3px"><strong><?php echo number_format($sum_amt_1,0,",","."); ?></strong></td>--><td align="right" valign="top" style="padding:3px">&nbsp;</td><td align="right" valign="top" style="padding:3px">&nbsp;</td></tr>
  </table>
  
<br />
  
  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px; font-family:Arial, Helvetica, sans-serif">
      <tr>
       <td align="center" valign="top" width="30%">Người lập phiếu<br />
        (Ký, ghi rõ họ tên)<br /><br /><br /><br /><strong><?php echo $creators[$rs[0]['creator']]['realname']; ?></strong></td>
        <td>&nbsp;</td>
        <td align="center" valign="top" width="30%">Người nhận<br />
        (Ký, ghi rõ họ tên)<br /><br /><br /><br /><strong><?php echo $shippers[$rs[0]['shipper']]['shipper_name']; ?></strong></td>
        <td>&nbsp;</td>
        
        <td align="center" valign="top" width="30%">Thủ kho<br />
        (Ký, ghi rõ họ tên)</td>
    </tr>
    </table>
</div>
</body>
</html>