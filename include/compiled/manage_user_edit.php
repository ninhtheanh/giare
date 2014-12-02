<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="user">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_user(null); ?><li class="current"><a href="/backend/user/edit.php?id=<?php echo $user['id']; ?>">Edit users</a><span></span></li></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top"><div class="subhead"><h2>Edit users <b style="margin-left:20px;font-size:16px; color:#FFFF00">(<?php echo $enc->decrypt('@4!@#$%@', $user['email']); ?>)</b></h2></div></div>
            <div class="box-content">
                <div class="sect">
                    <form id="login-user-form" method="post" action="/backend/user/edit.php?id=<?php echo $user['id']; ?>">
					<input type="hidden" name="id" value="<?php echo $user['id']; ?>" />
						<div class="wholetip clear">
						  <h3>1. ID info</h3>
						</div>
                        <div class="field">
                            <label>user email</label>
                            <input type="text" size="30" name="email" id="user-edit-email" class="f-input" value="<?php if($login_user_id==1){?><?php echo $enc->decrypt('@4!@#$%@', $user['email']); ?><?php }?>" <?php if($login_user_id!=1){?>readonly<?php }?> />
						</div>
						<div class="field">
                            <label>username</label>
                            <input type="text" size="30" name="username" id="user-edit-username" class="f-input" value="<?php if($login_user_id==1){?><?php echo $enc->decrypt('@4!@#$%@', $user['username']); ?><?php }?>" <?php if($login_user_id!=1){?>readonly="readonly"<?php }?> />
                        </div>
						<div class="field">
                            <label>real name</label>
                            <input type="text" size="30" name="realname" id="user-edit-realname" class="f-input" value="<?php echo $user['realname']; ?>" readonly="readonly" />
                        </div>
						<div class="field">
                            <label>Enable.</label>
                            <input type="text" size="30" name="enable" id="user-edit-enable" class="number" value="<?php echo $user['enable']; ?>" maxLength="1" require="true" datatype="require" style="text-transform:uppercase;" /><span class="inputtip">Y:yes N:no</span>
                        </div>
                        <div class="field password">
                            <label>login password</label>
                            <input type="text" size="30" name="password" id="settings-password" class="f-input" />
                            <span class="hint">If you're not going to change your password, keep it blank</span>
                        </div>
						<div class="wholetip clear">
						  <h3>2. basic info</h3>
						</div>
                        <div class="field">
                        	<link rel="stylesheet" type="text/css" href="/static/css/jquery.autocomplete.css" />
					        <script type='text/javascript' src="/static/js/jquery.autocomplete.js"></script>
							<script src="/static/js/jchain.js" type="text/javascript"></script>
                        	<script type="text/javascript">
								var dist_id; var ward_id;
								function getDistId(){
									return $("#dist_id").val();
								}
								function getWardId(){
									return $("#ward_id").val();
								}
								jQuery(document).ready(function() {	
									$("#dist_id").chained("#city_id"); 
									$("#ward_id").chained("#dist_id");
								});		
								function searchSuggest(){
									dist_id = getDistId();
									ward_id = getWardId();
									$("#user-edit-address").autocomplete('/team/search_address_list.php?dist_id='+dist_id+'&ward_id='+ward_id, {
										width: 308,
									});	
								}
							</script>
                            <label>Tỉnh/Thành phố</label>
                            <select name="city_id" id="city_id" class="f-city"><?php echo Utility::Option(Utility::OptionArray($allcities, 'id', 'name'), $user['city_id']); ?><option value='0'>Others</option></select>&nbsp;Quận/Huyện&nbsp;<select name="dist_id" id="dist_id" class="f-city" require="true"><option value="">---Chọn---</option><?php echo optiondistrict($user['dist_id'],$city['id']); ?></select>&nbsp;Phường/Xã&nbsp;<select name="ward_id" id="ward_id"  class="f-city" require="true" datatype="require" style="width:100px" onchange="getWardId()"><option value="">---Chọn---</option><?php echo optionward($user['ward_id']); ?></select>
                        </div>
                        <div class="field">
                            <label>Số nhà - Tên đường</label>
                            <input type="text" size="30" name="address" autocomplete="off" onfocus="searchSuggest()" id="user-edit-address" class="f-input" value="<?php echo $user['address']; ?>"/>
						</div>
                        <div class="field">
                            <label>Phòng-lầu-tòa nhà</label>
                            <input type="text" size="30" name="note_address" id="settings-note-address" class="f-input" value="<?php echo $user['note_address']; ?>" /><span class="hint">Ví dụ: P907, Lau 9, Cao Oc Diamond Plaza</span>
                        </div>
                        <div class="field">
                            <label>mobile</label>
                            <input type="text" size="30" name="mobile" id="user-edit-mobile" class="number" value="<?php echo $user['mobile']; ?>" maxLength="11" />
						</div>
                        <div class="field">
                            <label>zipcode</label>
                            <input type="text" size="30" name="zipcode" id="user-edit-zipcode" class="f-input" value="<?php echo $user['zipcode']; ?>"/>
                        </div>
						<div class="wholetip clear">
						  <h3>3. additional info</h3>
						</div>
                        <div class="field">
                            <label>email verification</label>
                            <input type="text" size="30" name="secret" id="user-edit-secret" class="f-input" value="<?php echo $user['secret']; ?>"/>
                            <span class="hint">verified, please empty this field</span>
                        </div>
						<?php if($login_user_id==1&&$user['id']>1){?>
                        <div class="field">
                            <label>manager</label>
                            <input type="text" size="30" name="manager" id="user-edit-manager" class="number" value="<?php echo $user['manager']; ?>" maxLength="1" require="true" datatype="require" style="text-transform:uppercase;" <?php if($login_user_id>1){?>readonly<?php }?> /><span class="inputtip">Y:yes N:no</span>
						</div>
						<?php }?>
                        <div class="act">
                            <input type="submit" value="edit" name="commit" id="user-submit" class="formbutton"/>
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
