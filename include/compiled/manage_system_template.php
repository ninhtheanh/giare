<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_system('template'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head"><h2>Template editing</h2></div>
                <div class="sect">
                    <form method="post">
						<div class="wholetip clear"><h3>include/template/only writabe files under this directory can be edited</h3></div>
						<div class="field">
							<label>template selecting</label>
							<select name="template_id" id="manage_system_template_id" class="f-input" onchange="X.manage.loadtemplate(this.options[this.selectedIndex].value);"><?php echo Utility::Option($may, $template_id, '-'); ?></select>
						</div>
					<?php if($content||$template_id){?>
						<div class="field">
							<label>content editing</label>
							<div style="float:left;"><textarea cols="90" rows="25" name="content"><?php echo htmlspecialchars($content); ?></textarea></div>
						</div>
					<?php }?>
                        <div class="act">
                            <input type="submit" value="save" name="commit" class="formbutton"/>
                        </div>
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
