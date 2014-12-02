<?php include template("header");?>
<?php  
$uri =  $_SERVER['REQUEST_URI'];

?>
<script type="text/javascript" src="/static/js/datepicker/WdatePicker.js"></script>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="settings">
<?php  	/*  <div class="subdashboard" id="dashboard">
		<ul><?php echo current_account('/account/settings.php'); ?></ul>
	</div>  */ ?>
<style>
.infotitle{background: #f8f8f8;
  background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#f4f4f4), to(#fcfcfc));
  background: -webkit-linear-gradient(top, #fcfcfc, #f4f4f4);
  background: -moz-linear-gradient(top, #fcfcfc, #f4f4f4);
  background: -ms-linear-gradient(top, #fcfcfc, #f4f4f4);
  background: -o-linear-gradient(top, #fcfcfc, #f4f4f4);
height: 43px;
color: #000;
font-weight: bold;
padding-left: 14px;
line-height: 38px;}

.atbox-setting{margin-top: 0px;margin-left: 39px;}
.title_info_setting{font-size: 19px;color: #8bcf06;border-bottom: 1px solid #ccc;padding-bottom:10px;}
.boxsubinfo{border: 1px solid #9e9a9b;padding: 10px;}
.box_title_info_clear{margin-top: 10px;margin-bottom: 8px;}
.boxsubinfo label{text-align:left !important;}
</style>
    <div id="contentfontend" class="mainwide clear settings-box">
		<div class="box clear">
        <table width="100%" style="margin-top:8px;">
        	<tr>
            	<td valign="top" style="width:230px;">
                	<?php // include template("thongtinhuuich");?>
                	 <?php include template("menutaikhoan");?>
                    
                </td>
                <td valign="top">
                 	<div class="atbox-setting" style="width: 92%;margin-left: 20px;padding: 10px;border: 1px solid #ccc;box-shadow: 0px 0px 5px #ccc;">
                    	<h2 class="title_info_setting">Chi tiết đơn hàng số <?php echo $order['id']; ?>
                        <span style="float:right"><a href="javascript:void(0)" onclick="PrintOrder()"><img src="/static/img/print.png" align="absmiddle" /> In đơn hàng</a></span>
                        </h2>
                         <div class="sect">
				<script type="text/javascript" language="javascript">
					function PrintOrder(){
						var settings = 'toolbar=yes,scrollbars=yes,location=no,directories=yes,menubar=yes,fullscreen=yes';
						var content = document.getElementById('ordercontent').innerHTML;
						var docprint=window.open('','',settings);
						docprint.document.open();
						docprint.document.write('<html><head><title>dealsoc.vn</title>');
						docprint.document.write('</head><body onLoad="self.print()"><center>');
						docprint.document.write(content);
						docprint.document.write('</center></body></html>');
						docprint.document.close();
						docprint.focus();
					}
				</script>
                <div class="myaccount-box" id="ordercontent" align="center">
                 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #999999;border-top:1px solid #999999;border-left:1px solid #999999;border-right:1px solid #999999;">
    <tr bgcolor="#FFFFFF">
      <td align="left" valign="top" style="padding-top:3px; padding-bottom:10px;"><img src="/static/css/images/LogoConfirmOrder.jpg" border="0" width="200px" height="85px" /></td>
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
      <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="top" style="background-color:#FDFA9D;border-right:solid 1px #999999; border-bottom:solid 1px #999999; border-left:none;color:#07519a;font-family:Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;line-height:16px;padding:8px;text-align:left;white-space:nowrap;">Mã</td>
            <td align="left" valign="top" style="background-color:#FDFA9D;border-right:solid 1px #999999; border-bottom:solid 1px #999999; border-left:none;color:#07519a;font-family:Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;line-height:16px;padding:8px;text-align:left;white-space:nowrap;">Tên Deal</td>
            <td align="left" valign="top" style="background-color:#FDFA9D;border-right:solid 1px #999999; border-bottom:solid 1px #999999; border-left:none;color:#07519a;font-family:Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;line-height:16px;padding:8px;text-align:left;white-space:nowrap;">Số lượng</td>
            <td align="left" valign="top" style="background-color:#FDFA9D;border-right:solid 1px #999999; border-bottom:solid 1px #999999; border-left:none;color:#07519a;font-family:Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;line-height:16px;padding:8px;text-align:left;white-space:nowrap;">Trọng lượng (gr)</td>
            <td align="left" valign="top" style="background-color:#FDFA9D;border-right:solid 1px #999999; border-bottom:solid 1px #999999; border-left:none;color:#07519a;font-family:Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;line-height:16px;padding:8px;text-align:left;white-space:nowrap;">Đơn giá (VNĐ)</td>
            <td align="left" valign="top" style="background-color:#FDFA9D;color:#07519a; border-bottom:solid 1px #999999;font-family:Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;line-height:16px;padding:8px;text-align:left;white-space:nowrap;">Thành tiền (VNĐ)</td>
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
            <td colspan="5" align="right" valign="top" style="padding:3px;">Phí vận chuyển</td>
            <td align="right" valign="top" style="padding:3px;" colspan="2"><?php echo $content_order['billing_cost']; ?> VNĐ</td>
          </tr>
 <!--         <tr bgcolor="#f6fcff">
            <td colspan="5" align="right" valign="top" style="padding:3px;">Phí thanh toán</td>
            <td align="right" valign="top" style="padding:3px;" colspan="2"><?php echo $content_order['shipping_cost']; ?> VNĐ</td>
          </tr>-->
          <tr bgcolor="#f6fcff">
            <td colspan="5" align="right" valign="top" style="padding:3px;">Tổng tiền</td>
            <td align="right" valign="top" style="padding:3px;" nowrap="nowrap" colspan="2"><font size="+1"><strong><?php echo $content_order['total_amount']; ?> VNĐ</strong></font></td>
          </tr>
          <tr bgcolor="#f6fcff">
            <td colspan="5" align="right" valign="top" style="padding:3px;">Số dư tài khoản:</td>
            <td align="right" valign="top" style="padding:3px;" nowrap="nowrap" colspan="2"><font size="+1"><strong>
            <?php if($login_user['money']>0){?><?php echo print_price(moneyit($login_user['money'])); ?><?php } else { ?>0<?php }?>&nbsp;VNĐ</strong></font></td>
          </tr>
      </table></td>
    </tr>
    <tr bgcolor="#f6fcff">
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr bgcolor="#f6fcff">
    <td colspan="2" align="left" style="padding:0px 0px 5px 5px; "><strong>&nbsp;Ghi ch&uacute;:</strong><?php echo $order['notes']; ?></td>
  </tr>
  </table></div><?php 
                   $his = DB::GetQueryResult("SELECT * FROM order_history WHERE order_id=".$order_id." AND status_code NOT IN ('changed') GROUP BY status_code ORDER BY date DESC, order_id",false);
                ; ?>       
              <?php if($team['delivery']=='normal'){?>
              <?php if(!empty($his)){?><table cellspacing="0" cellpadding="0" border="0" class="order-table" width="98%">
                                  <tr>
                                    <th width="15%" style="background-color:#f1f3f5">Trạng thái</th>
                                    <th width="20%" nowrap style="background-color:#f1f3f5">Ngày xử lý</th>
                                    <th width="40%" nowrap style="background-color:#f1f3f5">Ghi chú</th>
                                    <th width="23%" nowrap style="background-color:#f1f3f5">NV giao hàng</th>
                                  </tr>
                                  
                                  <?php if(is_array($his)){foreach($his AS $index=>$ones) { ?> 
                                  <?php if($ones['head']==1){?>
                                  <tr>
                                    <td colspan="7"><h3><?php echo $ones['order_id']; ?></h3></td>
                                  </tr>
                                  <?php }?>
                                  <tr style="background-color:#ffffff">
                                    <td nowrap="nowrap"><?php echo getStatusName($ones['status_code']); ?></td>
                                    <td><?php echo $ones['date']; ?></td>
                                    <td><?php echo $ones['note']; ?></td>
                                    <td><?php echo $ones['assign_to']; ?><?php if($ones['assign_to']){?><br />
                                      <strong>Tel: </strong><?php echo getMobileShipper($ones['assign_to']); ?><?php }?></td>
                                  </tr>
                                  <?php }}?>
                                </table>
                            <?php }?> 
              <table cellspacing="0" cellpadding="0" border="0" class="data-table">
                
                <?php 
                	
                    $maso = DB::GetQueryResult("SELECT maso FROM masoduthuong WHERE order_id=".$order_id." AND team_id=".$order['team_id']." AND user_id=".$login_user['id'])
                ; ?>
                <?php if($maso['maso']>0){?>
                <tr><td nowrap="nowrap" style="padding-top:12px"><strong>Mã số dự thưởng</strong></td><td align="left" valign="top" style="font-size:20px; font-family:Arial; color:#c40000; font-weight:bold">&nbsp;<?php echo $maso['maso']; ?></td></tr><?php }?>
                <tr>
                  <td nowrap="nowrap"></br>Cách thức sử dụng:</td>
                  <td style="padding-left:5px;" align="left"></br>Bạn cần đem theo phiếu (voucher) của <strong>Cheapdeal</strong> đến nơi cung cấp sản phẩm/dịch vụ để  nhận được sản phẩm/dịch vụ giảm giá.</td>
                </tr>
              </table>
              <?php } else if($team['delivery']=='express') { ?>
              <table cellspacing="0" cellpadding="0" border="0" class="data-table">
                <tr>
                  <th></br>Chuyển phát nhanh:</th>
                  <?php if($order['express_id']){?>
                  <td><?php echo $option_express[$order['express_id']]; ?>:<?php echo $order['express_no']; ?></td>
                  <?php } else { ?>
                  <td class="other-coupon"></br>&nbsp;Vui lòng đợi thông tin từ BP Giao hàng</td>
                  <?php }?>
                </tr>
                <tr>
                  <th>Người nhận：</th>
                  <td><?php echo $order['realname']; ?></td>
                </tr>
                <tr>
                  <th>Địa chỉ：</th>
                  <td><?php echo $order['address']; ?></td>
                </tr>
                <tr>
                  <th>Số điện thoại：</th>
                  <td><?php echo $order['mobile']; ?></td>
                </tr>
              </table>
              <?php } else if($team['delivery']=='pickup') { ?>
              <table cellspacing="0" cellpadding="0" border="0" class="data-table">
                <tr>
                  <th>Self delivery：</th>
                  <td class="other-coupon"></td>
                </tr>
                <tr>
                  <th>Location：</th>
                  <td><?php echo $team['address']; ?></td>
                </tr>
                <tr>
                  <th>Telephone：</th>
                  <td><?php echo $team['mobile']; ?></td>
                </tr>
              </table>
              <?php }?>
            </div>
                     </div>
                </td>
            </tr>
        </table>
        
            
        </div>
    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("footer");?>
