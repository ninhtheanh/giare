<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_system('sms'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top"><div class="subhead"><h2>SMS configuration</h2></div></div>
            <div class="box-content">
                
                <div class="sect">
                    <form method="post">
						<div class="wholetip clear"><h3>Basic</h3></div>
                        <div class="field">
                            <label>SMS user</label>
                            <input type="text" size="30" name="sms[user]" class="f-input" value="<?php echo $INI['sms']['user']; ?>" style="width:200px;" /><span class="inputtip">username&nbsp;[<font color="red"> A must for online upgrade</font>]</span>
                        </div>
                        <div class="field">
                            <label>SMS password</label>
                            <input type="password" size="30" name="sms[pass]" class="f-input" value="<?php echo $INI['sms']['pass']; ?>" style="width:200px;" /><span class="inputtip"> password </span>
                        </div>
                        <div class="field">
                            <label>Interval</label>
                            <input type="text" size="30" name="sms[interval]" class="number" value="<?php echo abs(intval($INI['sms']['interval'])); ?>"/>
                            <span class="inputtip">Users click for SMS sending in consecution at this interval, but manager don't follow this.  E.g.：60-300s</span>
                        </div>

                        <div class="act">
                            <input type="submit" value="Save" name="commit" class="formbutton"/>
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
