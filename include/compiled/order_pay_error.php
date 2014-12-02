<?php include template("header");?>
<?php if(is_get()){?><div class="sysmsgw" id="sysmsg-error"><div class="sysmsg"><p>Đơn hàng này chưa thanh toán, vui lòng thanh toán. </p><span class="close">Đóng</span></div></div><?php }?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="order-pay">
    <div id="content">
        <div id="deal-buy" class="box">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head">
                    <h2>Tổng tiền thanh toán:<strong class="total-money"><?php echo print_price($v_amount); ?></strong> <?php echo $currency; ?></h2>
                </div>
                <div class="sect">
                    <div style="text-align:left;">
                        <?php if($order['service']=='cashoffice' || $order['service']=='cashdelivery'){?>
                            <form id="order-pay-cash-form" method="post" sid="<?php echo $order_id; ?>">
                                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
                                <input type="hidden" name="service" value="cashoffice" />
                                <input type="submit" class="formbutton gotopay" value="Đặt mua" />
                            </form>
                        <?php } else if($order['service']=='credit') { ?>
                            <form id="order-pay-credit-form" method="post" sid="<?php echo $order_id; ?>">
                                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
                                <input type="hidden" name="service" value="credit" />
                                <input type="submit" class="formbutton gotopay" value="Thanh toán với số dư tài khoản" />
                            </form>
                        <?php } else if($order['service']=='paypal') { ?>
                        <form id="order-pay-form" method="post" action="<?php echo $post_url; ?>" target="_blank" sid="<?php echo $order['id']; ?>">
                            <!-- PayPal Configuration -->
                            <input type="hidden" name="business" value="<?php echo $Business; ?>">
                            <input type="hidden" name="cmd" value="<?php echo $cmd; ?>">
                            <input type="hidden" name="return" value="<?php echo $return_url; ?>">
                            <input type="hidden" name="cancel_return" value="<?php echo $cancel_url; ?>">
                            <input type="hidden" name="notify_url" value="<?php echo $notify_url; ?>">
                            <input type="hidden" name="rm" value="2">
                            <input type="hidden" name="currency_code" value="<?php echo $currency_code; ?>">
                            <input type="hidden" name="lc" value="<?php echo $location; ?>">
                            <input type="hidden" name="charset" value="utf-8" />
                        
                            <!-- Payment Page Information -->
                            <input type="hidden" name="no_shipping" value="1">
                            <input type="hidden" name="no_note" value="1">
                        
                            <!-- Product Information -->
                            <input type="hidden" name="item_name" value="<?php echo $item_name; ?>">
                            <input type="hidden" name="amount" value="<?php echo $amount; ?>">
                            <input type="hidden" name="quantity" value="<?php echo $quantity; ?>">
                            <input type="hidden" name="item_number" value="<?php echo $item_number; ?>">
                        
                            <!-- Customer Information -->
                            <input type="hidden" name="first_name" value="<?php echo $login_user['realname']; ?>">
                            <input type="hidden" name="last_name" value="">
                            <input type="hidden" name="address1" value="<?php echo $login_user['address']; ?>">
                            <input type="hidden" name="address2" value="">
                        
                            <input type="hidden" name="zip" value="<?php echo $login_user['zipcode']; ?>">
                            <input type="hidden" name="email" value="<?php echo $login_user['email']; ?>">
                            <img src="/static/css/images/paypal.png" /><br/><input type="submit" class="formbutton gotopay" value="Go to PayPal" style="vertical-align:middle;"/>
                        </form>
                        <?php }?>
                                        <!--<div class="back-to-check"><a href="/order/check.php?id=<?php echo $order_id; ?>">&raquo; Chọn phương thức thanh toán khác</a></div>-->
                                    </div>
                </div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("footer");?>
