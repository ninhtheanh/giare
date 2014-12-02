<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_market('down'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top"> <div class="subhead">
					<h2><?php echo $INI['system']['couponname']; ?> download</h2>
					<ul class="filter" style="padding-top:3px;"><?php echo mcurrent_market_down('downcoupon'); ?></ul>
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
							<div style="padding-top:8px;"><input type="checkbox" name="consume[]" value="Y" checked />&nbsp; consumed&nbsp;&nbsp;<input type="checkbox" name="consume[]" value="N" checked>&nbsp;consumable</div>
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
