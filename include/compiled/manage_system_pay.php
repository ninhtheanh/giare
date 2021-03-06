<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_system('pay'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top"><div class="subhead"><h2>Payment</h2></div></div>
            <div class="box-content">
                <div class="head"><h2>Payment</h2></div>
                <div class="sect">
                    <form method="post">
					<?php $index=0;; ?>
					<!-- Paypal -->
						<div class="wholetip clear"><h3><?php echo ++$index; ?>. Paypal</h3></div>
                        <div class="field">
                            <label>Account Email</label>
                            <input type="text" size="30" name="paypal[mid]" class="f-input" value="<?php echo $INI['paypal']['mid']; ?>" style="width:200px;" /><span class="inputtip">Email of paypal account.</span>
                        </div>
                        <div class="field">
                            <label>Location</label>
                            <input type="text" size="30" name="paypal[loc]" class="f-input" value="<?php echo $INI['paypal']['loc']; ?>" style="width:200px;"/><span class="inputtip">Location, such as: US,CA,UK</span>
                        </div>
					<!-- Paypal/End -->

					<!-- other -->
						<div class="wholetip clear"><h3><?php echo ++$index; ?>. Payment tips</h3></div>
                        <div class="field">
                            <label>Tips</label>
                            <div style="float:left;"><textarea cols="45" rows="5" name="other[pay]" class="f-textarea editor"><?php echo htmlspecialchars($INI['other']['pay']); ?></textarea></div>
                        </div>
                        <div class="act">
                            <input type="submit" value="Save" name="commit" class="formbutton"/>
                        </div>
					<!-- other/End -->
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
