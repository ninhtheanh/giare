<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_system('page'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top"><div class="subhead"><h2>Pape List</h2></div></div>
            <div class="box-content">
                <div class="sect">
                     <form method="post" class="validator" action="">
						<div class="field">
							<label>ID:</label>
                            <div style="float:left; padding-top:6px">
								<?php echo $arrRows['id']; ?>
                            </div>
						</div>
                        <div class="field">
							<label>Page type:</label>
							<div style="float:left;">
                            	<?php 									
									$selectedItem = $arrRows['page_type'];
								?>
                            	<select name="page_type" id="page_type">
                                	<option value="">---Select---</option>
                                    <?php
									while (list($key, $value) = each($arrPageType))
									{
									  $checked = (string)$selectedItem == (string)$key ||  (string)$selectedItem == (string)$value ? " selected=\"selected\"" : "";
									  echo "<option title='". $value ."' value=\"" . $key . "\"" . $checked . ">" . $value . "</option>";
									}									
									?>
                                </select>
                            </div>
						</div>
						<div class="field">
							<label>Name:</label>
							<input type="text" name="name" class="f-input" value="<?php echo $arrRows['name']; ?>" datatype="require" require="true"/>							
						</div>
						<div class="field">
							<label>Content:</label>
							<div style="float:left;"><textarea style="width:900px;height:450px;" class="editor text" name="value"><?php echo htmlspecialchars($arrRows['value']); ?></textarea></div>
						</div>  
                        <div class="field">
							<label>Show in Footer:</label>
							<div style="float:left;">
                            	<input type="checkbox" name="show_on_footer" <?php echo $arrRows['show_on_footer'] == 1 ? 'checked="checked"' : ''; ?> />
                            </div>
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

