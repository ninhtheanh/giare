<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="system">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_system('bulletin'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top"><div class="subhead"><h2>System bulletin</h2></div></div>
            <div class="box-content">
                
                <div class="sect">
                    <form id="login-user-form" method="post" action="/backend/system/bulletin.php">
					<input type="hidden" name="id" value="<?php echo $system['id']; ?>" />
						<div class="wholetip clear"><h3>1. Website bulletin</h3></div>
                        <div class="field">
                            <label>website bulletin</label>
                            <div style="float:left;"><textarea cols="45" rows="5" name="bulletin[0]" id="system-create-location" class="f-textarea editor"><?php echo htmlspecialchars($INI['bulletin'][0]); ?></textarea></div>
                        </div>
						<div class="wholetip clear"><h3>2. City bulletin</h3></div>
					<?php if(is_array($hotcities)){foreach($hotcities AS $one) { ?>
                        <div class="field">
                            <label><?php echo $one['name']; ?></label>
                            <div style="float:left;"><textarea cols="45" rows="5" name="bulletin[<?php echo $one['id']; ?>]" id="system-create-location" class="f-textarea editor"><?php echo htmlspecialchars($INI['bulletin'][$one['id']]); ?></textarea></div>
						</div>
					<?php }}?>
                        <div class="act">
                            <input type="submit" value="Save" name="commit" id="system-submit" class="formbutton"/>
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
