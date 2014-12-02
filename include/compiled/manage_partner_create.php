<?php include template("manage_header");?>
<?php if($INI['system']['googlemap']){?>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=<?php echo $INI['system']['googlemap']; ?>" type="text/javascript"></script>
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
		<ul><?php echo mcurrent_partner('create'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top"><div class="subhead"><h2>Add anew biz</h2></div></div>
            <div class="box-content">
                <div class="sect">
                    <form id="login-user-form" method="post" action="/backend/partner/create.php" enctype="multipart/form-data" class="validator">
						<div class="wholetip clear"><h3>1. Login info</h3></div>
                        <div class="field">
                            <label>username</label>
                            <input type="text" size="30" name="username" id="partner-create-username" class="f-input" value="<?php echo $partner['username']; ?>" require="true" datatype="require" />
                        </div>
                        <div class="field password">
                            <label>password</label>
                            <input type="text" size="30" name="password" id="settings-password" class="f-input" require="true" datatype="require" />
                        </div>

						<div class="wholetip clear"><h3>2. Label info</h3></div>
						<div class="field">
							<label>city & category</label>
							<select name="city_id" class="f-input" style="width:160px;"><?php echo Utility::Option(option_category('city'), $partner['city_id'], '-select a city-'); ?></select><select name="group_id" class="f-input" style="width:160px;"><?php echo Utility::Option(option_category('partner'), $partner['group_id']); ?></select>
						</div>
                        <div class="field">
                            <label>sort field</label>
                            <input type="text" size="10" name="head" value="<?php echo abs(intval($partner['head'])); ?>" class="number"/><span class="inputtip">the biggest figure tops</span>
						</div>
						<div class="field">
							<label>homepage display</label>
							<input type="text" size="30" name="display" id="partner-edit-display" class="number" value="<?php echo $partner['display']; ?>" maxLength="1" require="true" datatype="english" style="text-transform:uppercase;" /><span class="inputtip">Y:homepage shows the biz N:homepage doesn't show the biz</span>
						</div>
						<div class="field">
							<label>biz display</label>
							<input type="text" size="30" name="open" id="partner-edit-open" class="number" value="<?php echo $partner['open']; ?>" maxLength="1" require="true" datatype="english" style="text-transform:uppercase;" /><span class="inputtip">Y: frontend shows the biz  N: frontend doesn't show the biz</span>
						</div>
						<div class="field">
							<label>biz pictures</label>
							<input type="file" size="30" name="upload_image" id="partner-create-image" class="f-input" />
							<span class="hint">upload at least one picture of the biz</span>
						</div>
						<div class="field">
							<label>biz picture 1</label>
							<input type="file" size="30" name="upload_image1" id="partner-create-image1" class="f-input" />
						</div>
						<div class="field">
							<label>biz picture 2</label>
							<input type="file" size="30" name="upload_image2" id="partner-create-image2" class="f-input" />
						</div>
					<?php if($INI['system']['googlemap']){?>
                        <div class="field">
                            <label>map</label>
                            <input type="text" size="30" name="longlat" style="width:300px;cursor:point;" class="f-input" id="inputlonglat" readonly value="<?php echo $partner['longlat']; ?>" onclick="X.misc.setgooglemap('<?php echo $partner['longlat']; ?>');" /><span class="inputtip"><a href="javascript:;" style="cursor:point;" onclick="jQuery('#inputlonglat').val('');">GoogleMap positioning </a></span>
						</div>
					<?php }?>
						<div class="wholetip clear"><h3>3. Basic info</h3></div>
                        <div class="field">
                            <label>biz name</label>
                            <input type="text" size="30" name="title" id="partner-create-title" class="f-input" value="<?php echo $partner['title']; ?>" require="true" datatype="require" />
                        </div>
                        <div class="field">
                            <label>website</label>
                            <input type="text" size="30" name="homepage" id="partner-create-homepage" class="f-input" value="<?php echo $partner['homepage']; ?>"/>
                        </div>
                        <div class="field">
                            <label>person to contact</label>
                            <input type="text" size="30" name="contact" id="partner-create-contact" class="f-input" value="<?php echo $partner['contact']; ?>" />
						</div>
                        <div class="field">
                            <label>telephone</label>
                            <input type="text" size="30" name="phone" id="partner-create-phone" class="f-input" value="<?php echo $partner['phone']; ?>" maxLength="18" datatype="require" require="ture" />
						</div>
                        <div class="field">
                            <label>address</label>
                            <input type="text" size="30" name="address" id="partner-create-address" class="f-input" value="<?php echo $partner['address']; ?>" datatype="require" require="true" />
						</div>
                        <div class="field">
                            <label>mobile number</label>
                            <input type="text" size="30" name="mobile" id="partner-create-mobile" class="f-input" value="<?php echo $partner['mobile']; ?>" maxLength="11" />
						</div>
                        <div class="field">
                            <label>location</label>
                            <div style="float:left;"><textarea cols="45" rows="5" name="location" id="partner-create-location" class="f-textarea editor"></textarea></div>
						</div>
                        <div class="field">
                            <label>Other info</label>
                            <div style="float:left;"><textarea cols="45" rows="5" name="other" id="partner-create-other" class="f-textarea editor"></textarea></div>
						</div>
						<div class="wholetip clear"><h3>4. Bank info</h3></div>
                        <div class="field">
                            <label>account bank</label>
                            <input type="text" size="30" name="bank_name" id="partner-create-bankname" class="f-input" value="<?php echo $partner['bank_name']; ?>"/>
                        </div>
                        <div class="field">
                            <label>acount name</label>
                            <input type="text" size="30" name="bank_user" id="partner-create-bankuser" class="f-input" value="<?php echo $partner['bank_user']; ?>"/>
                        </div>
                        <div class="field">
                            <label>account</label>
                            <input type="text" size="30" name="bank_no" id="partner-create-bankno" class="f-input" value="<?php echo $partner['bank_no']; ?>"/>
                        </div>
                        <div class="act">
                            <input type="submit" value="add" name="commit" id="partner-submit" class="formbutton"/>
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
