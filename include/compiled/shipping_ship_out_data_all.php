<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Phiếu xuất kho đi tỉnh - Ngày: <?php echo $rs[0]['created']; ?></title></head>
<body>
<div align="center" style="padding-bottom:10px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="15%" height="41" style="padding-left:10px; font-size:12px; font-family:Arial, Helvetica, sans-serif" valign="top" nowrap="nowrap"><img src="/static/css/images/LogoConfirmOrder.jpg" width="100" align="left" /><strong>CÔNG TY CP TM SONG THANH</strong><br />151 Nguyễn Đình Chiểu, P.6, Q.3<br />
      <strong>ĐT:</strong> 08.73024401</td>
    <td width="73%" align="center"><h2 style="font-size:25px;font-family:Arial, Helvetica, sans-serif; margin:0px">Phiếu xuất kho đi tỉnh</h2>Ngày: <?php echo date("d/m/Y H:i:s", strtotime($rs[0]['created'])); ?></td>
    <td width="15%" nowrap="nowrap" align="right"><span style="font-size:22px;font-family:Arial, Helvetica, sans-serif"><strong>Số: <?php echo $rs[0]['out_id']; ?></strong></span></td>
  </tr>
</table>
</div>
<div align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%" align="left" style="font-size:12px; font-family:Arial, Helvetica, sans-serif"><strong>Người nhận:</strong> <?php echo $shippers[$rs[0]['shipper']]['shipper_name']; ?></td>
    <td align="right" style="font-size:12px; font-family:Arial, Helvetica, sans-serif"><strong>Bộ phận: Chuyển Phát Nhanh</strong></td>
  </tr>
</table>
</div>
<div align="center">
    <table cellspacing="0" cellpadding="0" border="1" width="100%" style="border-collapse:collapse;">
    <tr><th width="10" style="padding-left:5px; padding-right:5px;font-size:12px; font-family:Arial;">Stt</th>
    <th width="140" style="font-size:12px; font-family:Arial;">Deal/MSĐH</th>
    <th width="100" style="font-size:12px; font-family:Arial;">Họ tên/ĐT người nhận</th>
    <th width="200" style="font-size:12px; font-family:Arial;">Địa chỉ người nhận</th>
    <th width="20" nowrap style="padding-left:5px; padding-right:5px;font-size:12px; font-family:Arial;">SL</th>
    <th width="50" nowrap="nowrap" style="font-size:12px; font-family:Arial;">TT</th>
    <th width="180" nowrap="nowrap" style="font-size:12px; font-family:Arial;">Ghi chú</th>
    <th width="100" nowrap style="padding-left:5px; padding-right:5px;font-size:12px; font-family:Arial;">PCN</th>
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
       <td align="center" <?php echo $rowspan; ?>><?php echo $index+1; ?><br /><?php DB::Query("UPDATE `order` SET stt_bbbg = ($index+1) WHERE id = ".$one['order_id']);$history_name = DB::GetQueryResult("SELECT status_code FROM order_history WHERE order_id='".$one['order_id']."' AND status_code='pending'");
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
                 <?php echo cut_string($partner['title'],30,"..."); ?> - <?php echo $teams[$one['deal_id']]['short_title']; ?></td>
              </tr>
              
            </table>
        </td>
        <td style="padding-left:5px; padding-right:5px;"><div align="left" style="font-size:12px; font-family:arial"><?php echo $one['cus_name']; ?></div><div align="left" style="font-size:12px; font-family:arial"><?php echo $one['cus_phone']; ?></div></td>
      	<td style="padding:5px;font-size:12px; font-family:arial" <?php echo $rowspan; ?>>
        <?php 
        	$order = DB::GetQueryResult("SELECT bnote_address,baddress,bward_id,bdist_id,bcity_id FROM `order` WHERE id=".$one['order_id']);
        	if($order['bnote_address']!=''){
        		$note_address = htmlspecialchars($order['bnote_address']).", ";
            }else{
            	$note_address = "";
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
        ; ?><?php echo $order['shipping_address']; ?></td>
        <td style="padding-left:5px; padding-right:5px;font-size:12px; font-family:arial" align="center" <?php echo $rowspan; ?>><?php echo $one['quantity']; ?></td>
        <td style="padding-left:5px; padding-right:5px;font-weight:bold;font-size:12px; font-family:arial" align="right" nowrap="nowrap" <?php echo $rowspan; ?>>
        	<?php $order_money = DB::GetQueryResult("SELECT money, notes, credit, shipping_cost, payment_cost FROM `order` WHERE id='".$one['order_id']."'", false);
                if ($order_money[0]['credit']>=$one['amount']){echo $add = "<br />Đã tt: <b>".print_price($order_money[0]['credit'])."</b>";}else{
                if($order_money[0]['money']>0){ echo $add = "<br />Đã tt: <b>".print_price($order_money[0]['money'])."</b><br />CL: <b><i>".print_price(moneyit($one['amount']-$order_money[0]['money']))."</b></i>";}}
            ; ?><?php echo print_price(moneyit($one['amount']+$order_money[0]['shipping_cost']+$order_money[0]['payment_cost'])); ?></td>
      	<td style="padding-left:5px; padding-right:5px;font-size:12px; font-family:arial" <?php echo $rowspan; ?>><?php if($one['cus_notes']!=''){?><?php echo cut_string($one['cus_notes'],100,"..."); ?><br /><?php }?><i><?php echo $order_money[0]['notes']; ?></i></td>
        <td <?php echo $rowspan; ?> align="center">&nbsp;</td>
      </tr>
        <?php echo $serial_number; ?>   
    <?php }}?>
    </table>
</div>
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
  
</div>
</body>
</html>