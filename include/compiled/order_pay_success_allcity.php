<?php include template("header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="content" class="mainwide">
    <div id="order-pay-return" class="box clear">
        <div class="subbox-content">
 				<div style="background-color:#FFFFFF">
 				  <div align="left" style="padding:10px;"><div align="left" style="font-size:18px;"><h2><img src="/static/css/images/bg-pay-return-success.jpg" align="absmiddle" />&nbsp;Đơn hàng của bạn đặt mua thành công</h2></div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top">
                        	<table border="0" cellpadding="0" cellspacing="0" width="100%">
                          <tbody>
                            <tr>
                              <td width="24"><img src="/static/css/images/faqbox_topleft.gif" width="24" height="20"></td>
                              <td style="background: url(&quot;/static/css/images/faqbox_topbg.gif&quot;) repeat-x scroll 0% 0% transparent;"></td>
                              <td width="23"><img src="/static/css/images/faqbox_topright.gif" width="23" height="20"></td>
                            </tr>
                            <tr>
                              <td style="background: url(&quot;/static/css/images/faqbox_leftbg.gif&quot;) repeat-y scroll right center transparent;">&nbsp;</td>
                              <td bgcolor="#f1f1f1">
                              	<div id="divOrderMess">
                                  <div align="left">Cám ơn bạn đã đặt hàng. 
                                  <br />
                                  Dealsoc sẽ sớm xác nhận thanh toán và ship hàng cho bạn.
                                  <br />
                                  <span style="color:#c40000"><strong>Lưu ý:</strong> Nếu bạn đã từng mua ít nhất 1 lần tại <?php echo $INI['system']['abbreviation']; ?> và giao voucher thành công, bạn đã trở thành khách hàng quen thuộc, chúng tôi xin bỏ qua bước xác nhận đơn hàng tiếp theo của bạn qua điện thoại và sẽ tiến hành giao voucher luôn cho bạn.</span></div>
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
                                    <td colspan="3" class="deal-buy-quantity" style="BORDER-BOTTOM: #b1d1e6 1px solid;"><?php if(CheckCityDeal($team['city_id'])){?><div style="padding-bottom:5px;" align="right"><strong>Phí thanh toán:</strong></div><div align="right" style="padding-bottom:5px;"><strong>Phí vận chuyển:</strong></div><div align="right"><strong><?php if($order['origin']>$login_user['money']){?>Tổng tiền:<?php } else { ?>Đã thanh toán:<?php }?></strong></div><?php } else { ?><div align="right"><strong><?php if($order['credit']==0){?>Tổng số tiền:<?php } else { ?>Đã thanh toán:<?php }?></strong></div><?php }?></td>
                                    <td class="deal-buy-equal" style="BORDER-BOTTOM: #b1d1e6 1px solid;">&nbsp;</td>
                                    <td class="deal-buy-total" nowrap="nowrap" style="BORDER-RIGHT: #b1d1e6 1px solid;;BORDER-BOTTOM: #b1d1e6 1px solid;">
                                    <?php if(CheckCityDeal($team['city_id'])){?><div style="padding-bottom:5px; font-size:13px;"><?php echo print_price($order['payment_cost']); ?>&nbsp;<span class="money"><?php echo $currency; ?></span></div><div style="padding-bottom:5px; font-size:13px;"><?php echo print_price($order['shipping_cost']); ?>&nbsp;<span class="money"><?php echo $currency; ?></span></div><div><?php if($order['origin']>$login_user['money']){?><?php echo print_price($order['origin']-$login_user['money']+$order['payment_cost']+$order['shipping_cost']); ?><?php } else { ?><?php echo print_price($order['origin']+$order['payment_cost']+$order['shipping_cost']); ?><?php }?>&nbsp;<span class="money"><?php echo $currency; ?></span></div><?php } else { ?>
                                    <?php if($order['money']>0){?><?php echo print_price($order['origin']-$order['money']); ?><?php } else { ?><?php echo print_price($order['origin']); ?><?php }?><span class="money"><?php echo $currency; ?></span><?php }?></td>
                                </tr>
                                </table>   
                        </div>
            				<div class="error-tip">Cảm ơn bạn đã sử dụng dịch vụ tại <?php echo $INI['system']['abbreviation']; ?></div></td>
                              <td style="background: url(&quot;/static/css/images/faqbox_rightbg.gif&quot;) repeat-y scroll right center transparent;">&nbsp;</td>
                            </tr>                              
                            <tr>
                              <td><img src="/static/css/images/faqbox_bottomleft.gif" alt="" width="24" border="0" height="21"></td>
                              <td style="background: url(&quot;/static/css/images/faqbox_bottombg.gif&quot;) repeat-x scroll 0% 0% transparent;"></td>
                              <td><img src="/static/css/images/faqbox_bottomright.gif" alt="" width="23" border="0" height="21"></td>
                            </tr>
                          </tbody>
                        </table>
                        </td>
                        <td align="left" valign="top" style="padding-left:7px;">
                        	<div id="sidebar">
              					<?php include template("block_side_support");?></div>
                        </td>
                      </tr>
                    </table>
</div>
                </div>
	</div>
</div>
<div id="side">
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("footer");?>
