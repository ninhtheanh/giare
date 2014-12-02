<?php include template("header");?>
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
.atbox-setting{margin-top: 0px;margin-left: 39px;width: 84%;}
.title_info_setting{font-size: 19px;color: #8bcf06;border-bottom: 1px solid #ccc;padding-bottom:10px;}
.boxsubinfo{border: 1px solid #9e9a9b;padding: 10px;}
.box_title_info_clear{margin-top: 10px;margin-bottom: 8px;}
.boxsubinfo label{text-align:left !important;}
</style>
<div id="bdw" class="bdw">
  <div id="bd" class="cf">
    <div id="learn">
      <div class="subdashboard" id="dashboard">
        <ul>
        
        </ul>
      </div>
      <div id="content" class="mainwide">
        <div class="box">
        <table width="100%" style="margin-top:8px; margin-bottom:20px;">
        	<tr>
            	<td valign="top" style="width:230px;">
                	
                     <?php include template("menutaikhoan");?>
                </td>
                <td valign="top">
                	<div class="atbox-setting">
                		<div class="atbox-setting">
                            <h2 class="title_info_setting"><img src="/static/css/images/bg-pay-return-success.jpg" align="absmiddle" />&nbsp;Đơn hàng của bạn đặt mua thành công</h2>
                            <div class="box_form_setting">
                            	<div id="divOrderMess">
                                  <div align="left">Cám ơn bạn đã đặt hàng. Sẽ có nhân viên của <?php echo $INI['system']['abbreviation']; ?> liên hệ và giao sản phẩm tận nơi cho bạn trong vòng 24 đến 72 giờ sau khi chương trình kết thúc.<br />
                                  <strong>Lưu ý:</strong> Nếu bạn đã từng mua ít nhất 1 lần tại <?php echo $INI['system']['abbreviation']; ?> và giao voucher thành công, bạn đã trở thành khách hàng quen thuộc, chúng tôi xin bỏ qua bước xác nhận đơn hàng qua điện thoại và sẽ tiến hành giao voucher luôn cho bạn.</div>
                                  <div>Bạn cần đem theo voucher của <?php echo $INI['system']['abbreviation']; ?> đến nơi cung cấp sản phẩm/dịch vụ để được nhận sản phẩm/dịch vụ giảm giá.</div>
                                </div>
                              <div id="deal-buy" style="padding-top:15px;">
                               <h1 style="font-size:14px; font-family:Arial, Helvetica, sans-serif; color:#C40000; text-transform:uppercase">Đơn hàng của bạn</h1><br />
                                <table class="order-table">
                                    <tr>
                                        <th class="deal-buy-desc">Deal</th>
                                        <th class="deal-buy-quantity">Số lượng</th>
                                        <th class="deal-buy-multi"></th>
                                        <th class="deal-buy-price">Đơn giá (<span class="money"><?php echo $currency; ?></span>)</th>
                                        <th class="deal-buy-equal"></th>
                                        <th class="deal-buy-total">Thành tiền (<span class="money"><?php echo $currency; ?></span>)</th>
                                    </tr>
                                    <tr>
                                        <td class="deal-buy-desc"><?php echo $team['title']; ?></td>
                                        <td class="deal-buy-quantity"><?php echo $order['quantity']; ?></td>
                                        <td class="deal-buy-multi">x</td>
                                        <td class="deal-buy-price" id="deal-buy-price"><?php echo print_price(moneyit($order['price'])); ?></td>
                                        <td class="deal-buy-equal">=</td>
                                        <td class="deal-buy-total" id="deal-buy-total" style="BORDER-RIGHT: #b1d1e6 1px solid;"><?php echo print_price(moneyit($order['price']*$order['quantity'])); ?></td>
                                    </tr>
                                    <?php if($team['delivery']=='express'){?>
                                    <tr>
                                        <td class="deal-buy-desc">express</td>
                                        <td class="deal-buy-quantity"></td>
                                        <td class="deal-buy-multi"></td>
                                        <td class="deal-buy-price"><span class="money"><?php echo $currency; ?></span><span id="deal-express-price"><?php echo $team['fare']; ?></span></td>
                                        <td class="deal-buy-equal">=</td>
                                        <td class="deal-buy-total"><span class="money"><?php echo $currency; ?></span><span id="deal-express-total"><?php echo ($team['farefree']==0||$order['quantity']); ?></span></td>
                                    </tr>
                                    <?php }?>
                                    <?php if($login_user['money']>0){?>
                                    <tr class="order-total" bgcolor="#FDFA9D">
                                      <td class="deal-buy-desc" style="BORDER-LEFT: #b1d1e6 1px solid;BORDER-BOTTOM: #b1d1e6 1px solid;"></td>
                                      <td class="deal-buy-price" colspan="3" align="right" style="BORDER-BOTTOM: #b1d1e6 1px solid;">Số dư tài khoản:</td>
                                      <td class="deal-buy-equal" style="BORDER-BOTTOM: #b1d1e6 1px solid;">=</td>
                                      <td class="deal-buy-total" style="BORDER-BOTTOM: #b1d1e6 1px solid;BORDER-RIGHT: #b1d1e6 1px solid;"><span id="deal-balance-total"><?php echo print_price($login_user['money']); ?></span></td>
                                    </tr>
                                    <?php }?>
                                    <?php if($order['card']>0){?>
                                       <tr id="cardcode-row">
                                            <td class="deal-buy-desc">card：<span id="cardcode-row-n"><?php echo $order['card_id']; ?></span></td>
                                            <td class="deal-buy-quantity"></td>
                                            <td class="deal-buy-multi"></td>
                    
                                            <td class="deal-buy-price"><span class="money"><?php echo $currency; ?></span><?php echo print_price(moneyit($order['card'])); ?></td>
                                            <td class="deal-buy-equal">=</td>
                                            <td class="deal-buy-total">-<span class="money"><?php echo $currency; ?></span><span id="cardcode-row-t"><?php echo $order['card']; ?></span></td>
                                        </tr>
                                    <?php }?>
                
                                    <tr class="order-total" bgcolor="#FDFA9D">
                                    <td class="deal-buy-desc" style="BORDER-LEFT: #b1d1e6 1px solid;BORDER-BOTTOM: #b1d1e6 1px solid;"></td>
                                    <td colspan="3" class="deal-buy-quantity" style="BORDER-BOTTOM: #b1d1e6 1px solid;">
                                    <?php if(CheckCityDeal($team['city_id'])){?>
                                    <?php if($order['shipping_cost']>0){?><div style="padding-bottom:5px;" align="right"><strong>Phí vận chuyển:</strong></div><?php }?>
                                    <div align="right"><strong><?php if($order['origin']>$login_user['money']){?>Tổng tiền:<?php } else { ?>Đã thanh toán:<?php }?></strong></div><?php } else { ?><div align="right"><strong><?php if($order['credit']==0){?>Tổng số tiền:<?php } else { ?>Đã thanh toán:<?php }?></strong></div><?php }?></td>
                                    <td class="deal-buy-equal" style="BORDER-BOTTOM: #b1d1e6 1px solid;">&nbsp;</td>
                                    <td class="deal-buy-total" nowrap="nowrap" style="BORDER-RIGHT: #b1d1e6 1px solid;;BORDER-BOTTOM: #b1d1e6 1px solid;">
                                    <?php if(CheckCityDeal($team['city_id'])){?><?php if($order['shipping_cost']>0){?><div style="padding-bottom:5px;" align="right"><?php echo $order['shipping_cost']; ?></div><?php }?><div align="right"><?php if($order['origin']>$login_user['money']){?><?php echo print_price($order['origin']-$login_user['money']+$order['payment_cost']+$order['shipping_cost']); ?><?php } else { ?><?php echo print_price($order['origin']+$order['payment_cost']+$order['shipping_cost']); ?><?php }?>&nbsp;<span class="money"><?php echo $currency; ?></span></div><?php } else { ?>
                                    <?php if($order['money']>0){?><?php echo print_price($order['origin']-$order['money']); ?><?php } else { ?><?php echo print_price($order['origin']); ?><?php }?><span class="money"><?php echo $currency; ?></span><?php }?></td>
                                </tr>
                                </table>   
                        </div>
            				<p class="error-tip">Cảm ơn bạn đã sử dụng dịch vụ tại <?php echo $INI['system']['abbreviation']; ?></p>
                            </div>
                        </div>
                    </div>
           		</td>
            </tr>
            </table>    
        
          
          <div class="box-bottom"></div>
        </div>
      </div>
    </div>
  </div>
  <!-- bd end -->
</div>
<!-- bdw end -->
<?php include template("footer");?>