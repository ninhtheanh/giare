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
					<h2>Email address</h2>
					<ul class="filter" style="padding-top:3px;"><?php echo mcurrent_market_down('downemail'); ?></ul>
				</div></div>
            <div class="box-content">
                
                <div class="sect">
                    <form method="post" target="_blank">
                        <div class="field">
                            <label>City scope</label>
							<div style="padding-top:8px;"><?php if(is_array($allcities)){foreach($allcities AS $one) { ?><input type="checkbox" name="city_id[]" value="<?php echo $one['id']; ?>" checked />&nbsp;<?php echo $one['name']; ?>&nbsp;&nbsp;<?php }}?><input type="checkbox" name="city_id[]" value="0" checked>&nbsp;Other</div>
						</div>

                        <div class="field">
                            <label>Email from</label>
							<div style="padding-top:8px;"><input type="checkbox" name="source[]" value="user" checked />&nbsp;user&nbsp;&nbsp;<input type="checkbox" name="source[]" value="subscribe" checked>&nbsp;Email subscription</div>
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
