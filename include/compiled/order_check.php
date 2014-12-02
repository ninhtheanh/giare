<?php include template("header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="content" class="mainwide">
    <div id="deal-buy" class="box">
        <div class="subbox-content" style="min-height:470px;_height:470px"><div style="background-color:#FFFFFF; min-height:470px;_height:470px"><div align="left" style="padding:20px;padding-top:10px; padding-bottom:10px;"><div align="left" style="font-size:20px; padding-bottom:10px;"><h2>Đơn hàng của bạn</h2></div>
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
                          <td bgcolor="#f1f1f1" style="padding-top:5px;"><table class="order-table">
                    <tr>
                        <th class="deal-buy-desc">Deal</th>
                        <th class="deal-buy-quantity">Số lượng <!--quantity--></th>
                        <th class="deal-buy-multi"></th>
                        <th class="deal-buy-price">Đơn giá (<span class="money"><?php echo $currency; ?></span>)<!--price--></th>
                        <th class="deal-buy-equal"></th>
                        <th class="deal-buy-total">Thành tiền (<span class="money"><?php echo $currency; ?></span>)<!--total--></th>
                    </tr>
                    <tr>
                        <td class="deal-buy-desc"><?php echo $team['title']; ?></td>
                        <td class="deal-buy-quantity"><?php echo $order['quantity']; ?><br />trên tổng số lần mua</td>
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
                    <tr>
                      <td class="deal-buy-desc" style="BORDER-LEFT: #b1d1e6 1px solid;BORDER-BOTTOM: #b1d1e6 1px solid;"></td>
                      <td class="deal-buy-price" colspan="3" align="right" style="BORDER-BOTTOM: #b1d1e6 1px solid;">Số dư tài khoản của bạn:</td>
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
                        <td class="deal-buy-quantity" style="BORDER-BOTTOM: #b1d1e6 1px solid;"></td>
                        <td class="deal-buy-multi" style="BORDER-BOTTOM: #b1d1e6 1px solid;"></td>
                        <td class="deal-buy-price" nowrap="nowrap" style="BORDER-BOTTOM: #b1d1e6 1px solid;"><strong><?php if($order['origin']>$login_user['money']){?>Tổng số tiền:<?php } else { ?>Đã thanh toán:<?php }?></strong></td>
                        <td class="deal-buy-equal" style="BORDER-BOTTOM: #b1d1e6 1px solid;">=</td>
                        <td class="deal-buy-total" nowrap="nowrap" style="BORDER-BOTTOM: #b1d1e6 1px solid;BORDER-RIGHT: #b1d1e6 1px solid;"><?php if($order['origin']>$login_user['money']){?><?php echo print_price($order['origin']-$login_user['money']); ?><?php } else { ?><?php echo print_price($order['origin']); ?><?php }?>&nbsp;<span class="money"><?php echo $currency; ?></span></td>
                    </tr>
                </table>
				<div class="paytype">
                <form action="/order/pay.php" method="post" class="validator">
					<?php if($credityes || false==$creditonly){?>
					<div class="clear"></div>
					<div class="check-act">
					<input type="hidden" name="order_id" value="<?php echo $order['id']; ?>" />
                    <input type="hidden" name="service" value="<?php echo $order['service']; ?>" />
					<input type="hidden" name="team_id" value="<?php echo $order['team_id']; ?>" />
					<input type="hidden" name="cardcode" value="" />
					<input type="hidden" name="quantity" value="<?php echo $order['quantity']; ?>" />
					<input type="hidden" name="address" value="<?php echo $order['address']; ?>" />
					<input type="hidden" name="express" value="<?php echo $order['express']; ?>" />
					<input type="hidden" name="remark" value="<?php echo $order['remark']; ?>" />
					<input type="submit" value="Xác nhận đơn hàng, đặt mua" class="formbutton" />
					<?php if(false==$credityes){?>
					&nbsp;&nbsp;&nbsp;<input type="button" value="Quay về" class="formbutton" onclick="location.href='index.php';" />
					<?php }?>
					<a href="/team/buy.php?id=<?php echo $order['team_id']; ?>" style="margin-left:1em;">Sửa đơn đặt hàng</a></div>
                    <?php }?>
                </form>
				</div></td>
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
                <td align="left" valign="top" style="padding-left:7px"><div id="sidebar">
<?php if(!$order['card_id']){?>
	<!--{*include block_side_card*}-->
<?php }?>
<?php include template("block_side_support");?>
</div></td>
              </tr>
            </table></div></div>
		</div>
	</div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("footer");?>
