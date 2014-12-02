<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="help">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_misc('index'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"><div class="subhead"><h2>Home Dashboard</h2></div></div>
            <div class="box-content">
                
                <div class="sect">
                	<div style="width:50%;float:left">
                        <div class="wholetip clear"><h3>Today's data</h3></div>
                        <div style="margin:0 20px;">
                            <p>New users: <?php echo $user_today_count; ?></p>
                            <p>Number of orders：<?php echo $order_today_count; ?>，orders paid：<?php echo $order_today_pay_count; ?>，orders to be paid：<?php echo $order_today_unpay_count; ?></p>
                            <p>Online payment：<?php echo $income_pay; ?></p>
                            <p>Online topup：<?php echo $income_charge; ?></p>
                            <p>Offline topup：<?php echo $income_store; ?></p>
                            <p>Users' withdraw：<?php echo $income_withdraw; ?></p>
                        </div>
                    </div>
                    <div style="width:50%;float:right">
                        <div class="wholetip clear"><h3>Statistics</h3></div>
                        <div style="margin:0 20px;">
                            <p>Number of deals：<?php echo $team_count; ?></p>
                            <p>Registrations：<?php echo $user_count; ?></p>
                            <p>Orders：<?php echo $order_count; ?></p>
                            <p>Email subscriptions：<?php echo $subscribe_count; ?></p>
                        </div>
                    </div>
				</div>
                <div>&nbsp;</div>
			</div>
            <div class="box-bottom"></div>
        </div>
    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("manage_footer");?>
