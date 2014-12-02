<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_credit('settings'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top"><div class="subhead"><h2>Credit rules</h2></div></div>
            <div class="box-content">
                
                <div class="sect">
                    <form method="post">
						<div class="wholetip clear"><h3>1. Basic rules</h3></div>
						<input type="hidden" name="action" value="settings" />
                        <div class="field">
                            <label>Registration</label>
                            <input type="text" size="30" name="credit[register]" class="number" value="<?php echo $INI['credit']['register']; ?>"/>
                            <label>User login</label>
                            <input type="text" size="30" name="credit[login]" class="number" value="<?php echo $INI['credit']['login']; ?>"/>
						</div>
                        <div class="field">
                            <label>Invitation</label>
                            <input type="text" size="30" name="credit[invite]" class="number" value="<?php echo $INI['credit']['invite']; ?>"/>
                            <label>Buy goods</label>
                            <input type="text" size="30" name="credit[buy]" class="number" value="<?php echo $INI['credit']['buy']; ?>"/>
                        </div>
                        <div class="field">
                            <label>Pay & credit</label>
                            <input type="text" size="30" name="credit[pay]" class="number" value="<?php echo $INI['credit']['pay']; ?>"/>
                            <label>topup & credit</label>
                            <input type="text" size="30" name="credit[charge]" class="number" value="<?php echo $INI['credit']['charge']; ?>"/>
							<span class="hint">When buying or topuping online, you'll get credit according to the sum of your payment</span>
                        </div>
                        
                        <div class="field">
                            <label>Affiliate</label>
                            <input type="text" size="30" name="credit[aff]" class="number" value="<?php echo $INI['credit']['aff']; ?>"/>                          
							<span class="hint">% Rebate for Affiliate</span>
                        </div>
                        
                        
						<div class="act">
                            <input type="submit" value="Save" name="commit" class="formbutton" />
                        </div>
                    </form>

                    <form method="post">
						<div class="wholetip clear"><h3>1. User credit topup</h3></div>
						<input type="hidden" name="action" value="charge" />
                        <div class="field">
                            <label>username</label>
                            <input type="text" size="30" name="username" class="number" value="0"/>
                            <label>topup credits</label>
                            <input type="text" size="30" name="credit" class="number" value="0"/>
                            <input type="submit" value="Topup" name="commit" class="formbutton" />
                        </div>
                        <br />
                          <br />                           
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
