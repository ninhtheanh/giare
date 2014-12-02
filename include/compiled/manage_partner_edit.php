<?php include template("manage_header");?>
<?php if($INI['system']['googlemap']){?>
 <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=<?php echo $INI['system']['googlemap']; ?>" type="text/javascript"></script> 

<?php  /* 
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> */ ?>
<script type="text/javascript">
window.x_init_hook_gm = function() {
	X.misc.setgooglemap = function(ll) {
		X.get(WEB_ROOT+'/ajax/system.php?action=googlemap&ll='+ll);
	};
	X.misc.setgooglemapclick = function(overlay, latlng) {
		jQuery('#inputlonglat').val(latlng.y+','+latlng.x);
	};
};
</script>
<?php }?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_partner(null); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top"><div class="subhead"><h2>Edit Business<b style="margin-left:20px;font-size:16px;color:#FFFF00">(<?php echo $partner['title']; ?>)</b></h2></div></div>
            <div class="box-content">
                <div class="sect">
                    <form id="login-user-form" method="post" action="/backend/partner/edit.php?id=<?php echo $partner['id']; ?>" enctype="multipart/form-data" class="validator">
					<input type="hidden" name="id" value="<?php echo $partner['id']; ?>" />
						<div class="wholetip clear"><h3>1. Login Info</h3></div>
                        <div class="field">
                            <label>Username</label>
                            <input type="text" size="30" name="username" id="partner-create-username" class="f-input" value="<?php echo $partner['username']; ?>" require="true" datatype="require" />
                        </div>
                        <div class="field password">
                            <label>Password</label>
                            <input type="text" size="30" name="password" id="settings-password" class="f-input" />
                            <span class="hint">If you do not want to change your password, please leave blank</span>
                        </div>
						<div class="wholetip clear"><h3>2. Tagging information</h3></div>
						<div class="field">
							<label>City and classification</label>
							<select name="city_id" class="f-input" style="width:160px;"><?php echo Utility::Option(option_category('city'), $partner['city_id'], '-Select City-'); ?></select><select name="group_id" class="f-input" style="width:160px;"><?php echo Utility::Option(option_category('partner'), $partner['group_id']); ?></select>
						</div>
                        <div class="field">
                            <label>Sort Field</label>
                            <input type="text" size="10" name="head" value="<?php echo abs(intval($partner['head'])); ?>" class="number"/><span class="inputtip">Large number of front row</span>
						</div>
						<div class="field">
							<label>Display</label>
							<input type="text" size="30" name="display" id="partner-edit-display" class="number" value="<?php echo $partner['display']; ?>" maxLength="1" require="true" datatype="english" style="text-transform:uppercase;" /><span class="inputtip">Y: Home Business Show N: do not participate in Home Business Show</span>
						</div>
						<div class="field">
							<label>Show Partner</label>
							<input type="text" size="30" name="open" id="partner-edit-open" class="number" value="<?php echo $partner['open']; ?>" maxLength="1" require="true" datatype="english" style="text-transform:uppercase;" /><span class="inputtip">Y: Front merchants display N: not involved in show Business prospects</span>
						</div>
						<div class="field">
							<label>Business Image</label>
							<input type="file" size="30" name="upload_image" id="team-create-image" class="f-input" />
							<?php if($partner['image']){?><span class="hint"><?php echo team_image($partner['image']); ?></span><?php }?>
						</div>
						<div class="field">
							<label>Business Image1</label>
							<input type="file" size="30" name="upload_image1" id="team-create-image1" class="f-input" />
							<?php if($partner['image1']){?><span class="hint"><?php echo team_image($partner['image1']); ?></span><?php }?>
						</div>
						<div class="field">
							<label>Business Image2</label>
							<input type="file" size="30" name="upload_image2" id="team-create-image2" class="f-input" />
							<?php if($partner['image2']){?><span class="hint"><?php echo team_image($partner['image2']); ?></span><?php }?>
						</div>
					<?php if($INI['system']['googlemap']){?>
                        <div class="field">
                            <label>Map coordinates</label>
                            <input type="text" size="30" name="longlat" style="width:300px;cursor:point;" class="f-input" id="inputlonglat" readonly value="<?php echo $partner['longlat']; ?>" onclick="X.misc.setgooglemap('<?php echo $partner['longlat']; ?>');" /><span class="inputtip"><a href="javascript:;" style="cursor:point;" onclick="jQuery('#inputlonglat').val('');">Cancels the GogleMap coordinate information</a></span>
						</div>
					<?php }?>
						<div class="wholetip clear"><h3>3. Basic Information</h3></div>
                        <div class="field">
                            <label>Partner Name</label>
                            <input type="text" size="30" name="title" id="partner-create-title" class="f-input" value="<?php echo $partner['title']; ?>" datatype="require" require="true" />
                        </div>
                        <div class="field">
                            <label>Website URL</label>
                            <input type="text" size="30" name="homepage" id="partner-create-homepage" class="f-input" value="<?php echo $partner['homepage']; ?>"/>
                        </div>
                        <div class="field">
                            <label>Contact</label>
                            <input type="text" size="30" name="contact" id="partner-create-contact" class="f-input" value="<?php echo $partner['contact']; ?>"/>
						</div>
                        <div class="field">
                            <label>Partner Adderess</label>
                            <input type="text" size="30" name="address" id="partner-create-address" class="f-input" value="<?php echo $partner['address']; ?>" datatype="require" require="true" />
						</div>
                        <div class="field">
                            <label>Contact</label>
                            <input type="text" size="30" name="phone" id="partner-create-phone" class="f-input" value="<?php echo $partner['phone']; ?>" maxLength="18" require="true" datatype="require" />
						</div>
                        <div class="field">
                            <label>Mobile</label>
                            <input type="text" size="30" name="mobile" id="partner-create-mobile" class="f-input" value="<?php echo $partner['mobile']; ?>" maxLength="11" />
						</div>
                        <div class="field">
                            <label>Location information</label>
                            <div style="float:left;"><textarea cols="45" rows="5" name="location" id="partner-create-location" class="f-textarea editor"><?php echo htmlspecialchars($partner['location']); ?></textarea></div>
						</div>
                        <div class="field">
                            <label>Addition Information</label>
                            <div style="float:left;"><textarea cols="45" rows="5" name="other" id="partner-create-other" class="f-textarea editor"><?php echo htmlspecialchars($partner['other']); ?></textarea></div>
						</div>
						<div class="wholetip clear"><h3>4. Bank Information</h3></div>
                        <div class="field">
                            <label>Bank</label>
                            <input type="text" size="30" name="bank_name" id="partner-create-bankname" class="f-input" value="<?php echo $partner['bank_name']; ?>"/>
                        </div>
                        <div class="field">
                            <label>Account Name</label>
                            <input type="text" size="30" name="bank_user" id="partner-create-bankuser" class="f-input" value="<?php echo $partner['bank_user']; ?>"/>
                        </div>
                        <div class="field">
                            <label>Bank account</label>
                            <input type="text" size="30" name="bank_no" id="partner-create-bankno" class="f-input" value="<?php echo $partner['bank_no']; ?>"/>
                        </div>
                        <div class="act">
                            <input type="submit" value="edit" name="commit" id="partner-submit" class="formbutton"/>
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
