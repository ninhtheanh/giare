<?php include template("header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="about">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo current_about('ve-chung-toi'); ?></ul>
	</div>
	<div id="content" class="about clear">
        <div class="clear box">
            <div class="subbox-top"><div class="subhead"><h2>Về <?php echo $INI['system']['abbreviation']; ?></h2></div></div>
            <div class="box-content">
                <div class="sect"><?php echo $page['value']; ?></div>
            </div>
            <div class="box-bottom"></div>
        </div>
	</div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->
<?php include template("footer");?>