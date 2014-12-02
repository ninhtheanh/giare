<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="subdashboard" id="dashboard">
		
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top"><div class="subhead"><h2>News: Edit</h2></div></div>
            <div class="box-content">
                <div class="sect" style="padding-top:5px;">
                    <form method="post" class="validator" action="" enctype="multipart/form-data" class="validator">
						<div class="field">
							<label>ID</label>
							<?php echo $arrRows['id']; ?>
						</div>
                        <div class="field">
							<label>Title</label>
							<input type="text" name="title" class="f-input" value="<?php echo $arrRows['title']; ?>" datatype="require" require="true"/>							
						</div>
                        <div class="field">
							<label>Photo</label>
							<input type="file" size="30" name="upload_image" id="team-create-image" class="f-input" />
							<?php if($arrRows['image']){?><span class="hint"><?php echo banner_image($arrRows['image']); ?></span><?php }?>
                            <br />
                            <img align="left" src="<?php echo $arrRows['thumb']; ?>" width="160"/>								
						</div>
                        <div class="field">
							<label>Subject</label>
							<div style="float:left;"><textarea style="width:800px;height:160px;" class="editor text" name="subject"><?php echo htmlspecialchars($arrRows['subject']); ?></textarea></div>
						</div>						
						<div class="field">
							<label>Description</label>
							<div style="float:left;"><textarea style="width:800px;height:450px;" class="editor text" name="description"><?php echo htmlspecialchars($arrRows['description']); ?></textarea></div>
						</div> 
                        <div class="field">
							<label>Activate</label>
							<input type="checkbox" name="activate" <?php echo $arrRows['activate'] == 1 ? 'checked="checked"' : ''; ?>/>						
						</div>                       
                        <div class="act">
                            <input type="submit" value="Submit" name="commit" class="formbutton"/>
                            <input type="hidden" name="id" value="<?php echo $arrRows['id']; ?>" />
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
