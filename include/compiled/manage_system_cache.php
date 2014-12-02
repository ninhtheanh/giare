<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_system('cache'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top"><div class="subhead"><h2>Cache setting(only supports Memcache)</h2></div></div>
            <div class="box-content">
                <div class="head">
					<ul class="filter">
						<li><a href="/ajax/manage.php?action=cacheclear" class="ajaxlink">Clear template cache</a></li>
					</ul>
				</div>
                <div class="sect">
                    <form method="post">
						<div class="wholetip clear">
							<h3>Format 127.0.0.1:11211:100; if Memcache is not installed, keep the following blank.</h3>
						</div>
						<div style="margin:0 20px;">
							<p>127.0.0.1 is the server IP of Memcache.</p>
							<p>11211 is the port number of Memcache.</p>
							<p>100 is the weight，which is any integer bigger than 0.</p>
						</div>
						<div class="wholetip clear"><h3>1. Cache server</h3></div>
                        <div class="field">
                            <label>Server 1</label>
                            <input type="text" size="30" name="memcache[]" class="f-input" value="<?php echo $INI['memcache'][0]; ?>"/>
                        </div>
                        <div class="field">
                            <label>Server 2</label>
                            <input type="text" size="30" name="memcache[]" class="f-input" value="<?php echo $INI['memcache'][1]; ?>"/>
                        </div>
                        <div class="field">
                            <label>Server 3</label>
                            <input type="text" size="30" name="memcache[]" class="f-input" value="<?php echo $INI['memcache'][2]; ?>"/>
                        </div>
                        <div class="field">
                            <label>Server 4</label>
                            <input type="text" size="30" name="memcache[]" class="f-input" value="<?php echo $INI['memcache'][3]; ?>"/>
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
