<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_system('banner'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top"><div class="subhead"><h2>Banner Edit</h2></div></div>
            <div class="box-content">
                <div class="sect">
                     <form method="post" class="validator" action="" enctype="multipart/form-data" class="validator">
						<div class="field">
							<label>ID:</label>
                            <div style="float:left; padding-top:6px">
								<?php echo $arrRows['id']; ?>
                            </div>
						</div>
						<div class="field">
							<label>URL:</label>
							<input type="text" name="url" class="f-input" value="<?php echo $arrRows['url']; ?>" datatype="require" require="true"/>							
						</div>
                        <div class="field">
							<label>Activate:</label>
							<div style="float:left;">
                            	<input type="checkbox" name="activate" <?php echo $arrRows['activate'] == 1 ? 'checked="checked"' : ''; ?> />
                            </div>
						</div>  
                        <div class="field">
							<label>Banner Type:</label>							
                            <select name="banner_type" id="banner_type" onchange="change_banner_type(this.value)">
                                <?php
								$selectedItem = $arrRows['banner_type'];
								$arrBannerType = array('top'=>'Top', 'left'=>'Left');
                                while (list($key, $value) = each($arrBannerType))
                                {
                                  $checked = (string)$selectedItem == (string)$key ||  (string)$selectedItem == (string)$value ? " selected=\"selected\"" : "";
                                  echo "<option title='". $value ."' value=\"" . $key . "\"" . $checked . ">" . $value . "</option>";
                                }									
                                ?>
                            </select>					
						</div>
                        <?php 
							$size_required = "";
							$arrBannerSize = array("top"=>"872x389", "left"=>"102x405");
							if($arrRows['banner_type'] == 'left')
								$size_required = $arrBannerSize['left'];
							else
								$size_required = $arrBannerSize['top'];
						?>
                        <script>
							function change_banner_type(banner_type)
							{
								var result = "";
								if(banner_type == "left")
									result = "<?php echo $arrBannerSize['left']; ?>";
								else
									result = "<?php echo $arrBannerSize['top']; ?>";
								$("#size_required").html(result);
							}
						</script>                        
						<div class="field">
							<label>Image:</label>
							<input type="file" size="30" name="upload_image" id="team-create-image" class="f-input" />
                            (<span id="size_required"><?php echo $size_required; ?></span>)
							<?php if($arrRows['img']){?><span class="hint"><?php echo banner_image($arrRows['img']); ?></span><?php }?>
                            <?php if($arrRows['img'] != ""){ ?>
                            	<img align="right" src="<?php echo $arrRows['img']; ?>" alt="slideshow"/>	
                            <?php } ?>
                            <input type="hidden" name="hidden_img" value="<?php echo $arrRows['img']; ?>" />						
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

