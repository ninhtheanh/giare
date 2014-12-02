<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_market('down'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top"><div class="subhead">
					<h2>Detail download</h2>
					<ul class="filter" style="padding-top:3px;"><?php echo mcurrent_market_down('downorder'); ?></ul>
				</div></div>
            <div class="box-content">
                
                <div class="sect">
                    <form method="post" target="_blank" class="validator">
                        <div class="field">
                            <label>Deal name</label>
							<input type="text" name="team_id" require="true" datatype="number" class="number" /><span class="inputtip">Please type the deal ID</span>
						</div>

                        <div class="field">
                            <label>State</label>
							<div style="padding-top:8px;"><input type="checkbox" name="state[]" value="pay" checked />&nbsp;paid&nbsp;&nbsp;<input type="checkbox" name="state[]" value="unpay" checked>&nbsp;to be paid</div>
						</div>

                        <div class="field">
                            <label>Gateway</label>
							<div style="padding-top:8px;"><input type="checkbox" name="service[]" value="alipay" checked />&nbsp;AliPay&nbsp;&nbsp;<input type="checkbox" name="service[]" value="tenpay" checked />&nbsp;Tenpay&nbsp;&nbsp;<input type="checkbox" name="service[]" value="chinabank" checked />&nbsp;China Bank&nbsp;&nbsp;<input type="checkbox" name="service[]" value="bill" checked />&nbsp;Quick MOney&nbsp;&nbsp;<input type="checkbox" name="service[]" value="cashdelivery" checked />&nbsp;Pay in cash&nbsp;&nbsp;<input type="checkbox" name="service[]" value="credit" checked>&nbsp;Pay with balance</div>
						</div>

                        <div class="act">
                            <input type="submit" value="download" name="commit" class="formbutton"/>
                        </div>
                    </form>
                </div>
            </div>
            <div class="box-bottom"></div>
        </div>
	</div>
<!--
<div id="sidebar">
</div>
-->
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("manage_footer");?>
