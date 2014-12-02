<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bảng kê nộp tiền giao hàng - Mã BG : <?php echo $rs[0]['out_id']; ?></title>
</head>
<body>
<div align="center">
    <h1 style="font-size:18px; font-family:Arial, Helvetica, sans-serif">Bảng kê nộp tiền giao hàng<?php if($rs[0]['city']!=11){?> (Các ĐH đi tỉnh)<?php }?></h1>
</div>
<div align="left" style=" font-size:13px; font-family:Arial, Helvetica, sans-serif">


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><strong>NV bàn giao:</strong> <?php echo $creators[$rs[0]['creator']]['realname']; ?></td>
    <td><strong>NV trả bàn giao:</strong> <?php echo $updaters[$rs[0]['updater']]['realname']; ?></td>
    <td align="right" style="padding-left:30px;"><strong>Ngày BG: <?php echo date("d/m/Y H:i:s",strtotime($rs[0]['created'])); ?></strong></td><td align="right" style="padding-left:30px;"><strong>Mã BG:</strong> <strong><?php echo $rs[0]['out_id']; ?></strong></td>
    
  </tr>
  <tr>
    <td><strong>NV giao hàng:</strong> <?php echo $shippers[$rs[0]['shipper']]['shipper_name']; ?></td>
    <td><strong>NV kế toán:</strong> <?php echo $approvers[$rs[0]['approver']]['realname']; ?></td>
    <td align="right"><strong>Ngày NT: <?php echo date("d/m/Y H:i:s",strtotime($rs[0]['approved'])); ?></strong></td><td align="right"><strong>Mã NT:</strong> <strong><?php echo $rs[0]['in_id']; ?></strong></td>
    
  </tr>
</table>
</div>

<div align="left" style="padding-top:10px; font-size:14px; font-family:Arial, Helvetica, sans-serif">
<table width="100%" border="1" style="border-collapse:collapse; font-size:14px; font-family:Arial, Helvetica, sans-serif" cellspacing="0" cellpadding="0">
 <tr><td width="2%"><strong>STT</strong></td>
 <td align="left" style="padding:3px"><strong>Deal</strong></td>
 <td align="left" valign="top" style="padding:3px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>SL bàn giao</strong></td>
 <td align="left" valign="top" style="padding:3px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>Giao TC</strong></td>
 <td align="left" valign="top" style="padding:3px; font-size:14px; font-family:Arial, Helvetica, sans-serif" width="100" nowrap="nowrap"><strong>Thành tiền (VNĐ)</strong></td>
 <td align="left" valign="top" style="padding:3px; font-size:14px; font-family:Arial, Helvetica, sans-serif" width="100"><strong>Đã TT (VNĐ)</strong></td>
 <td align="left" valign="top" style="padding:3px; font-size:14px; font-family:Arial, Helvetica, sans-serif" width="100"><strong>C.Lại (VNĐ)</strong></td>
 <td align="left" valign="top" style="padding:3px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>Phiếu phải trả</strong></td>
 </tr>
 
 
 <?php if(is_array($rs)){foreach($rs AS $index=>$one) { ?>
 
    <tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>">
        <td align="center"><?php echo $index+1; ?></td>
        <td style="padding:5px; font-size:14px; font-family:Arial, Helvetica, sans-serif" nowrap="nowrap"><strong>(<?php echo $one['deal_id']; ?>) </strong><?php echo $teams[$one['deal_id']]['short_title']; ?> - 
     <?php 
     	$partner = Table::Fetch('partner', $teams[$one['deal_id']]['partner_id']);
        $sum_qty += $one['quantity'];
        if($one['pays']>0) $sum_amt += $one['price']*$one['pays'];
        $sum_pays += $one['pays'];
        $sum_pendings += $one['pendings'];
       
        $sum_credit = DB::GetQueryResult("SELECT sum(credit) as sum_credit FROM `order` WHERE id IN ($list_order_id) AND team_id='".$one['deal_id']."'");
        $sum_paid_credit = $sum_credit['sum_credit'];
        if($one['pays']>0){
       		$total_paid_credit += $sum_paid_credit;
        }
        
        $sum_money = DB::GetQueryResult("SELECT sum(money) as sum_money FROM `order` WHERE id IN ($list_order_id) AND team_id='".$one['deal_id']."'");
        $sum_paid = $sum_money['sum_money'];
        
        $paid_atm = DB::GetQueryResult("SELECT sum(origin) as sum_atm FROM `order` WHERE id IN ($list_order_id) AND payment_id=3 AND paid_atm=1 AND team_id='".$one['deal_id']."'");
        $sum_paid_atm = $paid_atm['sum_atm'];
        
        $paid_nl = DB::GetQueryResult("SELECT sum(origin) as sum_nl FROM `order` WHERE id IN ($list_order_id) AND payment_id=5 AND transaction_id_nl>0 AND team_id='".$one['deal_id']."'");
        $sum_paid_nl = $paid_nl['sum_nl'];
        
        $dtt = ($sum_paid+$sum_paid_credit+$sum_paid_atm+$sum_paid_nl);
        
        if($one['pays']>0){
	        $total_paid += $sum_paid;
        }
        
        if($one['pays']>0){
	        $total_paid_atm += $sum_paid_atm;
        }
        
        if($one['pays']>0){
	        $total_paid_nl += $sum_paid_nl;
        }
        
        if($one['pays']>0){
       		$sum_cl += ($one['price']*$one['pays']-($sum_paid+$sum_paid_credit+$sum_paid_atm+$sum_paid_nl));
        }else{
        	$sum_cl += ($one['price']*$one['pays']);
        }
        $total_dtt = $total_paid+$total_paid_credit+$total_paid_atm+$total_paid_nl;
     ; ?>
     <b><?php echo cut_string($partner['title'],40,"..."); ?></b></td>     
        <td style="padding:5px; font-size:14px; font-family:Arial, Helvetica, sans-serif" align="right"><?php echo $one['quantity']; ?></td>
        <td style="padding:5px; font-size:14px; font-family:Arial, Helvetica, sans-serif" align="right"><?php echo $one['pays']; ?></td>
        <td style="padding:5px; font-size:14px; font-family:Arial, Helvetica, sans-serif;font-weight:bold" align="right"><?php if($one['pays']>0){?><?php echo print_price(moneyit($one['price']*$one['pays'])); ?><?php } else { ?>0<?php }?></td>
        <td style="padding:5px; font-size:14px; font-family:Arial, Helvetica, sans-serif" align="right"><?php if($one['pays']>0){?><?php echo print_price(moneyit($dtt)); ?><?php } else { ?>0<?php }?></td>
        <td style="padding:5px; font-size:14px; font-family:Arial, Helvetica, sans-serif" align="right"><?php if(($one['price']*$one['pays']-($sum_paid+$sum_paid_credit+$sum_paid_atm+$sum_paid_nl))>=0){?><?php echo print_price(moneyit($one['price']*$one['pays']-($sum_paid+$sum_paid_credit+$sum_paid_atm+$sum_paid_nl))); ?><?php } else { ?>0<?php }?></td>
        <td style="padding:5px; font-size:14px; font-family:Arial, Helvetica, sans-serif" align="right"><?php echo $one['pendings']; ?></td>
    </tr>
   
    <?php }}?>
 

  <tr><td></td>
  <td align="left" valign="top" style="padding:3px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong>Tổng cộng</strong></td>
  <td align="right" valign="top" style="padding:3px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong><?php echo $sum_qty; ?></strong></td>
  <td align="right" valign="top" style="padding:3px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong><?php echo $sum_pays; ?></strong></td>
  <td align="right" valign="top" style="padding:3px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong><?php echo number_format($sum_amt,0,",","."); ?></strong></td>
  <td style="padding:5px; font-size:14px; font-family:Arial, Helvetica, sans-serif" align="right"><strong><?php echo number_format($total_dtt,0,",","."); ?></strong></td>
  <td style="padding:5px; font-size:14px; font-family:Arial, Helvetica, sans-serif" align="right"><strong><?php echo number_format($sum_cl,0,",","."); ?></strong></td>
  <td align="right" valign="top" style="padding:3px; font-size:14px; font-family:Arial, Helvetica, sans-serif"><strong><?php echo $sum_pendings; ?></strong></td>
  </tr>
  </table>
  
<div align="right" style="padding-bottom:5px; padding-top:5px; font-size:12px; font-family:Arial, Helvetica, sans-serif">ĐH giao thành công: <?php $TOPay = DB::GetQueryResult("SELECT count(*) as total_order_pay FROM `ship_out_data` WHERE out_id='".$rs[0]['out_id']."' AND state='pay' ");; ?><strong><?php echo $TOPay['total_order_pay']; ?></strong></div>
  
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">
      <tr>
       <td align="center" valign="top" width="30%">NV Sales Online<br />(Ký, ghi rõ họ tên)<br /><br />
         <br />
        <strong><?php echo $updaters[$rs[0]['updater']]['realname']; ?></strong></td>
        <td>&nbsp;</td>
        <td align="center" valign="top" width="30%">NV giao hàng<br />(Ký, ghi rõ họ tên)<br /><br />
          <br />
        <strong><?php echo $shippers[$rs[0]['shipper']]['shipper_name']; ?></strong></td>
        <td>&nbsp;</td>
        <td align="center" valign="top" width="30%">NV kiểm phiếu<br />(Ký, ghi rõ họ tên)</td>
        <td>&nbsp;</td>
        <td align="center" valign="top" width="30%">NV kế toán<br />(Ký, ghi rõ họ tên)</td>
      </tr>
    </table>
</div>

<br>
<br>
<br>
<br>
<br>
<br>
<br>



<div style="page-break-after:always"></div>

<div align="center">
    <h1 style="font-size:18px; font-family:Arial, Helvetica, sans-serif">Danh Sách Đơn Hàng Giao Không Thành Công<?php if($rs[0]['city']!=11){?> (Các ĐH đi tỉnh)<?php }?><br>Nhân Viên Giám Sát:____________________</h1>
<br> 
	</div>
<div align="left" style=" font-size:13px; font-family:Arial, Helvetica, sans-serif">


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><strong>NV bàn giao:</strong> <?php echo $creators[$rs[0]['creator']]['realname']; ?></td>
    <td><strong>NV trả bàn giao:</strong> <?php echo $updaters[$rs[0]['updater']]['realname']; ?></td>
    <td align="right" style="padding-left:30px;"><strong>Ngày BG: <?php echo date("d/m/Y H:i:s",strtotime($rs[0]['created'])); ?></strong></td><td align="right" style="padding-left:30px;"><strong>Mã BG:</strong> <strong><?php echo $rs[0]['out_id']; ?></strong></td>
    
  </tr>
  <tr>
    <td><strong>NV giao hàng:</strong> <?php echo $shippers[$rs[0]['shipper']]['shipper_name']; ?></td>
    <td><strong>NV kế toán:</strong> <?php echo $approvers[$rs[0]['approver']]['realname']; ?></td>
    <td align="right"><strong>Ngày NT: <?php echo date("d/m/Y H:i:s",strtotime($rs[0]['approved'])); ?></strong></td><td align="right"><strong>Mã NT:</strong> <strong><?php echo $rs[0]['in_id']; ?></strong></td>
    
  </tr>
</table>
</div>




<table width="100%" border="1" style="border-collapse:collapse; font-size:14px; font-family:Arial, Helvetica, sans-serif" cellspacing="0" cellpadding="0">
 <tr>
 <td align="center"width="2%"><strong>STT</strong></td>
 <td align="center"  width= "25%"><strong>Tên Sản Phẩm</strong></td>
 <td align="center"  width= "30%"><strong>Địa Chỉ Giao Hàng</strong></td>
 <td align="center"  width= "3%"><strong>SL</strong></td>
 <td align="center"  width= "20%"><strong>Lý Do Giao Không Thành Công</strong></td>
 <td align="center"  width= "15%"><strong>Xác Nhận Của CSKH</strong></td>
 </tr>
<?php 
						$sql = "select * from ship_out_data, team where out_id =". $rs[0]['out_id'] ." and ship_out_data.state not in('pay') and team.id = deal_id  order by ship_out_data.state, ship_out_data.id asc";
                      	$rs = DB::GetQueryResult($sql,false);
						if (!$rs){
							exit();
						}
                       
; ?>
 
 
 <?php if(is_array($rs)){foreach($rs AS $index=>$one) { ?>
 
    <tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>">
	 <td align="center" width="2%"><?php echo $index+1; ?></td>
 <td align="left"  width= "25%"><?php echo $one['order_id']; ?>--<?php echo $one['deal_id']; ?>--<?php echo $one['short_title']; ?><br>
 <?php if($one['delivery_properties']==1){?><strong>Giao sản phẩm</strong><?php } else { ?><strong>Giao Voucher</strong><?php }?>
 
 
 </td>
 <td align="center"  width= "30%"><?php echo $one['cus_name']; ?> <br><?php echo $one['cus_address']; ?><br><strong><?php echo $one['cus_phone']; ?></strong></td>
 <td align="center"  width= "3%"><?php echo $one['quantity']; ?></td>
 <td align="left"  width= "25%"><?php echo $one['notes']; ?></td>
 <td align="left"  width= "15%"><strong></strong></td>
	
	
	
   </tr>
   
 <?php }}?>
  
  
  </table>
  


</body>
</html>