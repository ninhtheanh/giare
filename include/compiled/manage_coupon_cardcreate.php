<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_coupon('cardcreate'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head">
					<h2>New coupon</h2>
				</div>
                <div class="sect">
                    <form id="login-user-form" method="post" class="validator">
					<input type="hidden" name="id" value="<?php echo $card['id']; ?>" />
                        <div class="field">
                            <label>biz ID</label>
                            <input type="text" size="30" name="partner_id" id="card-create-partner" class="number" value="<?php echo abs(intval($card['partner_id'])); ?>" require="true" datatype="number" /><span class="inputtip">Biz ID could be copied from the biz manu.</span>
							<span class="hint">0 meaning voucher applicable to all bizes here.</span>
                        </div>
                        <div class="field">
                            <label>coupon value</label>
                            <input type="text" size="30" name="money" id="card-create-money" class="number" value="<?php echo $card['money']; ?>" datatype="number" require="true" /><span class="inputtip">value is <?php echo $currency; ?></span>
                        </div>
                        <div class="field">
                            <label>quantity</label>
                            <input type="text" size="30" name="quantity" id="card-create-quantity" class="number" value="<?php echo abs(intval($card['quantity'])); ?>" datatype="number" require="true" /><span class="inputtip"> maximum: 1000 vouchers. This operation is repeatable.</span>
                        </div>
                        <div class="field">
                            <label>begin</label>
                            <input type="text" size="30" name="begin_time" id="card-create-begintine" class="number" value="<?php echo date('Y-m-d', $card['begin_time']); ?>" datatype="date" require="true" />
						</div>
                        <div class="field">
                            <label>expire</label>
                            <input type="text" size="30" name="end_time" id="card-create-endtime" class="number" value="<?php echo date('Y-m-d', $card['end_time']); ?>" datatype="date" require="true" />
						</div>
                        <div class="field">
                            <label>symbol</label>
                            <input type="text" size="30" name="code" id="card-create-code" class="number" value="<?php echo $card['code']; ?>" datatype="require" require="true" /><span class="inputtip">For the convenience of recording, counting and checking vouchers.</span>
                        </div>
                        <div class="act">
                            <input type="submit" value="Edit" name="commit" id="partner-submit" class="formbutton"/>
                        </div>
					</form>
                </div>
            </div>
            <div class="box-bottom"></div>
        </div>
	</div>

<div id="sidebar">
</div>

</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("manage_footer");?>
