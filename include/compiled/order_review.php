<?php include template("header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="content" class="mainwide">
    <div id="deal-buy" class="box">
        <div class="subbox-content" style="min-height:470px;_height:470px"><div style="background-color:#FFFFFF; min-height:470px;_height:470px"><div align="left" style="padding:10px;"><div align="left" style="font-size:20px; padding-bottom:10px;">
          <h2>Thông tin Đơn Hàng</h2></div>
        	
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
                          <td bgcolor="#f1f1f1" style="padding-top:5px;">
                          
                          <div class="paytype">
            	<style type="text/css">.text_bold{
					font-weight:bold;
					color: #002cf0;
					font-size:13px;
					font-family: arial, helvetica, sans-serif; 
				}</style>
                <table width="100%" border="0" cellspacing="4" cellpadding="0">
                  <tr>
                    <td align="left" valign="top" style="font-size:14px; font-family:Arial, Helvetica, sans-serif; color:#C40000; text-transform:uppercase"><h4>Thông TIN thanh toÁn</h4></td>
                    <td width="4%"></td>
                    <td align="left" valign="top" style="font-size:14px; font-family:Arial, Helvetica, sans-serif; color:#C40000; text-transform:uppercase"><h4>THÔNG TIN vẬn chuyỂn</h4></td>
                  </tr>
                  
                  <tr>
                    <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                    <td width="2%"></td>
                    <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" style="padding-left:10px; padding-bottom:7px;" width="49%">
                    	<table cellspacing="5" cellpadding="0">
                            <tr>
                              <td width="9%" align="right" valign="top"><strong>Họ tên:</strong></td>
                              <td width="91%" style="padding-left:5px;"><?php echo $order['realname']; ?></td>
                            </tr>
                            <tr>
                              <td width="9%" align="right" valign="top"><strong>Địa chỉ:</strong></td>
                              <td width="91%" style="padding-left:5px;">
                              <?php if ($order['note_address']!=''){$note_address = $order['note_address'].", ";}else{$note_address="";}; ?><?php echo $note_address; ?><?php echo $order['address']; ?>, <?php if(ward_name($order['dist_id'],$order['ward_id'])){?><?php $wardname = ward_name($order['dist_id'],$order['ward_id']);; ?><?php echo $wardname['ward_name']; ?>, <?php }?> <?php if(ename_dist($order['dist_id'])){?><?php $dists = ename_dist($order['dist_id']); ?><?php echo $dists['dist_name']; ?>, <?php }?><?php if(id_city($order['city_id'])){?><?php $citys = id_city($order['city_id']); ?><?php echo $citys['name']; ?><?php }?>
                              </td>
                            </tr>
                            <tr>
                              <td align="right" valign="top"><strong>Điện thoại:</strong></td>
                              <td align="left" style="padding-left:5px;"><?php echo $order['mobile']; ?></td>
                            </tr>
                            <tr>
                              <td align="right" valign="top" nowrap="nowrap"><strong>Phương thức thanh toán:</strong></td>
                              <td align="left" style="padding-left:5px;"><?php echo GetPaymentName($order['payment_id']); ?></td>
                            </tr>
                          </table>
                    
                    </td>
                    <td width="4%"></td>
                    <td align="left" valign="top" style="padding-left:10px; padding-bottom:7px;" width="49%">
                    	<table cellspacing="5" cellpadding="0">
                            <tr>
                              <td width="9%" align="right" valign="top"><strong>Họ tên:</strong></td>
                              <td width="91%" style="padding-left:5px;"><?php echo $order['brealname']; ?></td>
                            </tr>
                            <tr>
                              <td width="9%" align="right" valign="top"><strong>Địa chỉ:</strong></td>
                              <td width="91%" style="padding-left:5px;">
                              <?php if ($order['bnote_address']!=''){$note_address = $order['bnote_address'].", ";}else{$note_address="";}; ?><?php echo $note_address; ?><?php echo $order['baddress']; ?>, <?php if(ward_name($order['bdist_id'],$order['bward_id'])){?><?php $wardname = ward_name($order['bdist_id'],$order['bward_id']);; ?><?php echo $wardname['ward_name']; ?>, <?php }?> <?php if(ename_dist($order['bdist_id'])){?><?php $dists = ename_dist($order['bdist_id']); ?><?php echo $dists['dist_name']; ?>, <?php }?><?php if(id_city($order['bcity_id'])){?><?php $citys = id_city($order['bcity_id']); ?><?php echo $citys['name']; ?><?php }?>
                              
                              </td>
                            </tr>
                            <tr>
                              <td align="right" valign="top"><strong>Điện thoại:</strong></td>
                              <td align="left" style="padding-left:5px;"><?php echo $order['bmobile']; ?></td>
                            </tr>
                            <tr>
                              <td align="right" valign="top" nowrap="nowrap"><strong>Phương thức giao hàng:</strong></td>
                              <td align="left" style="padding-left:5px;"><?php echo GetShippingName($order['shipping_id']); ?></td>
                            </tr>
                          </table>
                    </td>
                  </tr>
                  </table>
				</div>
                <table class="order-table">
                    <tr>
                        <th>Mã ĐH</th>
                        <th class="deal-buy-desc">Deal</th>
                        <th class="deal-buy-quantity">Trọng lượng (gr)</th>
                        <th class="deal-buy-quantity">Số lượng</th>
                        <th class="deal-buy-multi"></th>
                        <th class="deal-buy-price">Đơn giá (<span class="money"><?php echo $currency; ?></span>)</th>
                        <th class="deal-buy-equal"></th>
                        <th class="deal-buy-total">Thành tiền (<span class="money"><?php echo $currency; ?></span>)</th>
                    </tr>
                    <tr>
                        <td width="2%" nowrap="nowrap"><?php echo $order['id']; ?></td>
                        <td class="deal-buy-desc"><?php echo $team['title']; ?></td>
                        <td class="deal-buy-quantity"><?php echo FormatWeight($order['total_weight']/$order['quantity']); ?></td>
                        <td class="deal-buy-quantity"><?php echo $order['quantity']; ?><br />trên tổng số lần mua</td>
                        <td class="deal-buy-multi">x</td>
                        <td class="deal-buy-price" id="deal-buy-price"><?php echo print_price(moneyit($order['price'])); ?></td>
                        <td class="deal-buy-equal">=</td>
                        <td class="deal-buy-total" id="deal-buy-total" style="BORDER-RIGHT: #b1d1e6 1px solid;"><?php echo print_price(moneyit($order['price']*$order['quantity'])); ?></td>
                    </tr>
					<?php if($team['delivery']=='express'){?>
					<tr>
						<td></td>
                        <td class="deal-buy-desc"></td>
                        <td class="deal-buy-quantity"></td>
						<td class="deal-buy-quantity">express</td>
						<td class="deal-buy-multi"></td>
						<td class="deal-buy-price"><span class="money"><?php echo $currency; ?></span><span id="deal-express-price"><?php echo $team['fare']; ?></span></td>
						<td class="deal-buy-equal">=</td>
						<td class="deal-buy-total"><span class="money"><?php echo $currency; ?></span><span id="deal-express-total"><?php echo ($team['farefree']==0||$order['quantity']); ?></span></td>
					</tr>
					<?php }?>
                    
					<?php if($order['card']>0){?>
				   <tr id="cardcode-row">
						 <td></td><td class="deal-buy-desc">card：<span id="cardcode-row-n"><?php echo $order['card_id']; ?></span></td>
                        <td class="deal-buy-quantity"></td>
						<td class="deal-buy-quantity"></td>
						<td class="deal-buy-multi"></td>

						<td class="deal-buy-price"><span class="money"><?php echo $currency; ?></span><?php echo print_price(moneyit($order['card'])); ?></td>
						<td class="deal-buy-equal">=</td>
						<td class="deal-buy-total">-<span class="money"><?php echo $currency; ?></span><span id="cardcode-row-t"><?php echo $order['card']; ?></span></td>
					</tr>
					<?php }?>
					<tr class="order-total" bgcolor="#FDFA9D">
                        <td style="BORDER-LEFT: #b1d1e6 1px solid;BORDER-BOTTOM: #b1d1e6 1px solid;"></td><td class="deal-buy-desc" style="BORDER-BOTTOM: #b1d1e6 1px solid;"></td>
                        <td class="deal-buy-quantity" style="BORDER-BOTTOM: #b1d1e6 1px solid; text-align:left" colspan="2"><strong>Tổng trọng lượng</strong>: <?php echo FormatWeight($order['total_weight']); ?> gr</td>
                        <td class="deal-buy-multi" style="BORDER-BOTTOM: #b1d1e6 1px solid;"></td>
                        <td class="deal-buy-price" nowrap="nowrap" style="BORDER-BOTTOM: #b1d1e6 1px solid;"></td>
                        <td class="deal-buy-equal" style="BORDER-BOTTOM: #b1d1e6 1px solid;">&nbsp;</td>
                        <td class="deal-buy-total" nowrap="nowrap" style="BORDER-BOTTOM: #b1d1e6 1px solid;BORDER-RIGHT: #b1d1e6 1px solid;">&nbsp;</td>
                    </tr>
                    <?php $subtotal = $order['origin']+$order['payment_cost']+$order['shipping_cost']; ?>
					<tr class="order-total" bgcolor="#FDFA9D">
                        <td style="border-left:none;BORDER-BOTTOM: #b1d1e6 1px solid;BORDER-LEFT: #b1d1e6 1px solid;"></td>
                        <td class="deal-buy-desc" style="border-left:none;BORDER-BOTTOM: #b1d1e6 1px solid;"></td><td class="deal-buy-quantity" style="border-left:none;BORDER-BOTTOM: #b1d1e6 1px solid;"></td>
                        <td colspan="3" class="deal-buy-quantity" style="border:none;BORDER-BOTTOM: #b1d1e6 1px solid;" valign="top"><div style="padding-bottom:5px; white-space:nowrap" align="right"><strong>Phí thanh toán:</strong></div><div align="right" style="padding-bottom:5px; white-space:nowrap"><strong>Phí vận chuyển:</strong></div><div align="right" style="padding-bottom:5px; white-space:nowrap; padding-top:5px;"><strong>Tổng tiền:</strong></div>
                        <?php if($login_user['money']>0){?><div style="padding-bottom:5px; padding-top:25px; white-space:nowrap" align="right"><strong>Số dư tài khoản:</strong></div><div align="right" style="padding-bottom:5px; white-space:nowrap"><strong>Đã thanh toán:</strong></div><?php }?>
                        <?php if(($login_user['money']- $subtotal)>=0){?><div style="padding-bottom:5px; white-space:nowrap" align="right"><strong>Số dư tài khoản còn lại:</strong></div><?php }?>
                        <?php if($login_user['money']>0 && ($subtotal - $login_user['money'])>0){?><div style="padding-bottom:5px; white-space:nowrap" align="right"><strong>Còn lại:</strong></div><?php }?></td>
                        <td class="deal-buy-equal" style="border:none;BORDER-BOTTOM: #b1d1e6 1px solid;"></td>
                        <td class="deal-buy-total" valign="top" nowrap="nowrap" style="BORDER-RIGHT: #b1d1e6 1px solid;BORDER-BOTTOM: #b1d1e6 1px solid;"><div style="padding-bottom:5px; font-size:13px;"><?php echo print_price($order['payment_cost']); ?>&nbsp;<span class="money"><?php echo $currency; ?></span></div><div style="padding-bottom:5px; font-size:13px;"><?php echo print_price($order['shipping_cost']); ?>&nbsp;<span class="money"><?php echo $currency; ?></span></div><div style="padding-bottom:5px; font-size:20px; color:#c40000; font-family:Arial, Helvetica, sans-serif"><?php echo print_price($subtotal); ?>&nbsp;<span class="money"><?php echo $currency; ?></span></div>
                       <?php if($login_user['money']>0){?><div style="padding-bottom:5px; padding-top:20px; white-space:nowrap;font-size:13px;"><span id="deal-balance-total"><strong><?php echo print_price($login_user['money']); ?></strong></span><strong>&nbsp;<span class="money"><?php echo $currency; ?></span></strong></div><?php }?>
                       <?php if($login_user['money']>0 && ($subtotal < $login_user['money'])){?><div style="padding-bottom:5px; white-space:nowrap;font-size:15px; color:#c40000; font-family:Arial, Helvetica, sans-serif"><?php echo print_price($subtotal); ?>&nbsp;<span class="money"><?php echo $currency; ?></span></div><?php } else if($login_user['money']>0) { ?><div style="padding-bottom:5px; white-space:nowrap;font-size:15px; color:#F09F18; font-family:Arial, Helvetica, sans-serif"><?php echo print_price($login_user['money']); ?>&nbsp;<span class="money"><?php echo $currency; ?></span></div><?php }?>
                       
                       <?php if(($login_user['money']-$subtotal)>=0){?><div style="padding-bottom:5px; white-space:nowrap;font-size:13px;"><span id="deal-balance-total"><strong><?php echo print_price($login_user['money']-$subtotal); ?></strong></span><strong>&nbsp;<span class="money"><?php echo $currency; ?></span></strong></div><?php }?><?php if($login_user['money']>0 && ($subtotal - $login_user['money'])>0){?><div style="padding-bottom:5px; white-space:nowrap;font-size:15px; color:#c40000; font-family:Arial, Helvetica, sans-serif" align="right"><span id="deal-balance-total"><strong><?php echo print_price($subtotal-$login_user['money']); ?></strong></span><strong>&nbsp;<span class="money"><?php echo $currency; ?></span></strong></div><?php }?>
                        </td>
                    </tr>
                </table>
                <div style="padding-top:15px; padding-bottom:15px;">
                <form action="/order/pay.php" method="post" class="validator">
					<?php if($credityes || false==$creditonly){?>
					<div class="clear"></div>
					<div class="check-act" align="center">
					<input type="hidden" name="order_id" value="<?php echo $order['id']; ?>" />
                    <input type="hidden" name="service" value="<?php echo $order['service']; ?>" />
					<input type="hidden" name="team_id" value="<?php echo $order['team_id']; ?>" />
					<input type="hidden" name="cardcode" value="" />
					<input type="hidden" name="quantity" value="<?php echo $order['quantity']; ?>" />
					<input type="hidden" name="address" value="<?php echo $order['address']; ?>" />
					<input type="hidden" name="express" value="<?php echo $order['express']; ?>" />
					<input type="hidden" name="remark" value="<?php echo $order['remark']; ?>" />
                    <?php echo $button; ?>
					
					&nbsp;&nbsp;&nbsp;<input type="button" value="Sửa đơn đặt hàng" class="formbutton" style="padding:7px;" onclick="location.href='/team/buy.php?id=<?php echo $order['team_id']; ?>&edit=true';" /></div>
                    <?php }?>
                </form></div></td>
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
          
              </tr>
            </table></div></div>
		</div>
	</div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->
<script language="javascript" src="/order/nganluong/include/nganluong.apps.mcflow.js"></script>
<script language="javascript">
var mc_flow = new NGANLUONG.apps.MCFlow({trigger:'btn_payment',url:'<?php echo $link_checkout; ?>'});
</script>
<?php include template("footer");?>
