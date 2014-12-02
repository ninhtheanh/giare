<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="user">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_shipper(null); ?><li class="current"><a href="/backend/logistics/edit.php?id=<?php echo $shipper['id']; ?>">Sửa thông tin NV GH</a><span></span></li></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top"><div class="subhead"><h2><b style="margin-left:20px;font-size:16px;"><?php echo $shipper['shipper_name']; ?></b></h2>
            </div>
            </div>
            <div class="box-content">
                
                <div class="sect">
                    <form id="login-user-form" method="post" action="/backend/logistics/edit.php?id=<?php echo $shipper['id']; ?>"  class="validator">
					<input type="hidden" name="id" value="<?php echo $shipper['id']; ?>" />
                        <div class="field">
                            <label>Full name</label>
                            <input type="text" size="30" name="shipper_name" id="shipper-edit-name" class="f-input" value="<?php echo $shipper['shipper_name']; ?>" require="true" datatype="require" />
						</div>
						<div class="field">
                            <label>Address</label>
                            <input type="text" size="30" name="shipper_address" id="shipper-edit-address" class="f-input" value="<?php echo $shipper['shipper_address']; ?>" />
                        </div>
						<div class="field">
                            <label>Tel</label>
                            <input type="text" size="30" name="shipper_tel" id="shipper-edit-tel" class="f-input" value="<?php echo $shipper['shipper_tel']; ?>" />
                        </div>
						<div class="field">
                            <label>Status</label>
                            <select size="1" name="shipper_status" id="shipper-edit-status"  class="h-input" style="width:50">
                                <option value="A">Active</option>
                                <option value="D">Deactive</option>
                        	</select>&nbsp;TP:<select name="city_id" id="city_id" class="h-input" require="true" onchange="this.form.submit();"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($allcities,'id','name'),$city_id); ?></select>
                            <script>jQuery('#shipper-edit-status').val("<?php echo $shipper['shipper_status']; ?>");jQuery('#city_id').val("<?php echo $shipper['city_id']; ?>");</script>
                        </div>
                        
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