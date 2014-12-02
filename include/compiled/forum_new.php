<?php include template("header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="forum">
	<div class="dashboard" id="dashboard">
		<ul><?php echo current_forum(null); ?></ul>
	</div>
    <div id="content" class="coupons-box clear">
		<div class="box clear">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head">
                    <h2>Th&ecirc;m ch&#7911; &#273;&#7873; m&#7899;i</h2>
				</div>
                <div class="sect">
                    <form id="forum-new-form" method="post" class="validator">
                        <div class="field">
                            <label>Di&#7877;n &#273;&agrave;n</label>
							<select name='category' style="margin-top:3px;">
							<optgroup label="Theo khu vực">
								<option value="city">Khu vực <?php echo $city['name']; ?></option>
							</optgroup>
							<optgroup label="Thảo luận chung">
								<?php echo Utility::Option($publics, $id); ?>
							</optgroup>
							</select>
                        </div>
						<div class="field">
							<label>T&ecirc;n ch&#7911; &#273;&#7873;</label>
							<input type="text" size="10" name="title" id="team-create-style" class="f-input" value="<?php echo htmlspecialchars($topic['title']); ?>" datatype="require" require="true" />
						</div>
						<div class="field">
							<label>N&#7897;i dung</label>
							<textarea style="width:480px;height:240px;" name="content" id="forum-new-content" class="f-textarea" datatype="require" require="true"><?php echo htmlspecialchars($topic['content']); ?></textarea>
						</div>
						<div class="act">
                            <input type="submit" value="Gởi" name="commit" id="leader-submit" class="formbutton"/>
                        </div>
                    </form>
				</div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
    <div id="sidebar">
		<?php include template("block_side_subscribe");?>
    </div>
</div>

</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("footer");?>
