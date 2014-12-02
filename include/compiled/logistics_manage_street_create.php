<?php include template("manage_header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_shipper('null'); ?><li class="current"><a href="/backend/logistics/streets.php">QL Tên Đường</a><span></span></li></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
             <div class="subbox-top"> <div class="subhead"><h2>Add new street</h2></div></div>
            <div class="box-content">
              <div class="sect" style="padding-top:3px;">
                	<link rel="stylesheet" type="text/css" href="/static/css/jquery.autocomplete.css" />
					<script type='text/javascript' src="/static/js/jquery.autocomplete.js"></script>
                    <script src="/static/js/jchain.js" type="text/javascript"></script>
                    <script type='text/javascript'>						                
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
							$("#street-create-title").autocomplete('search_streets.php', {
								width: 310,
							});	
						}
                    </script>
                    <form method="post" action="<?php echo $action; ?>" enctype="multipart/form-data" class="validator" id="target">
                        <div class="field">
                            <label>TP</label>
                            <select name="city_id" id="city_id" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($allcities,'id','name'),$city_id); ?></select>
                        </div>
                        <div class="field">
                            <label>Quận/Huyện</label>
                            <select name="dist_id" id="dist_id"  class="f-input" datatype="require" require="true" onchange="getDistId();"><?php echo optiondistrict($dist_id,$city_id); ?></select>
						</div>
                        <div class="field">
                            <label>Phường/Xã</label>
                            <select name="ward_id" id="ward_id"  class="f-input" datatype="require" require="true" onchange="getWardId()"><option value="">---Chọn---</option><?php echo optionward($ward_id); ?></select>
                        </div>
                        <div class="field">
                            <label>Tên đường</label>
                            <input type="text" size="30" name="name" id="street-create-title" class="f-input" value="<?php echo $street['name']; ?>" require="true" datatype="require" autocomplete="off" onfocus="searchSuggest()" />
                        </div>
                        <div class="field">
                            <label>Status</label>
                            <select size="1" name="status" class="h-input" style="width:50">
                                <option value="A">Active</option>
                                <option value="D">Deactive</option>
                        	</select>
						</div>
                        
                        <div class="act">
                            <?php if(!isset($_GET['street_id'])){?><input type="submit" value="add" name="Addcommit" id="partner-submit" class="formbutton"/><?php } else { ?><input type="submit" value="Edit" name="Editcommit" id="partner-submit" class="formbutton"/><input type="hidden" name="street_id" value="<?php echo $street_id; ?>" /><?php }?>
                        </div>
                    </form>
                    <div align="center" style="padding-top:10px; font-size:16px;">Danh sách tên đường ở <strong><?php echo $city['name']; ?></strong></div>
                    <div align="center" style="padding-top:10px"><form method="get">
                    	<table width="900" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
                          <tr bgcolor="#cccccc">
                            <td style="padding:5px;" width="2%" align="center"><strong>STT</strong></td>
                            <td style="padding:5px;" align="left"><strong>TP</strong><select name="city_id" class="h-input" require="true" onchange="this.form.submit();"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($allcities,'id','name'),$city_id); ?></select></td>
                            <td style="padding:5px;" align="left"><strong>Quận</strong><?php if($city_id){?><select name="dist_id" onchange="this.form.submit();" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray(option_district('VN', $city_id, false, true),'dist_id','dist_name'),$dist_id); ?></select><?php }?></td>
                            <td style="padding:5px;" align="left"><strong>Phường</strong><?php if($dist_id){?><select name="ward_id" onchange="this.form.submit();" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo option_ward_1($dist_id, $ward_id); ?></select><?php }?></td>
                            <td style="padding:5px;" align="left"><strong>Đường</strong></td>
                            <td style="padding:5px;" align="left"><strong>Task</strong></td>
                          </tr>
                          <?php if(is_array($str)){foreach($str AS $index=>$one) { ?>
                  			<tr <?php echo $index%2?'':'class="alt"'; ?> >
                            <td style="padding:5px;" width="2%" align="center"><?php echo $index+1; ?></td>
                            <td style="padding:5px;" align="left"><?php echo $one['city_name']; ?></td>
                            <td style="padding:5px;" align="left"><?php echo $one['dist_name']; ?></td>
                            <td style="padding:5px;" align="left"><?php echo $one['ward_name']; ?></td>
                            <td style="padding:5px;" align="left"><?php echo $one['street_name']; ?></td>
                            <td style="padding:5px;" align="center"><a href="/backend/logistics/streets.php?city_id=<?php echo $one['city_id']; ?>&dist_id=<?php echo $one['dist_id']; ?>&ward_id=<?php echo $one['ward_id']; ?>&street_id=<?php echo $one['street_id']; ?>" title="Sửa"><img src="/static/img/edit.gif" border="0" /></a><?php if(in_array($login_user_id,$accept_id)){?>&nbsp;&nbsp;&nbsp;<a href="/backend/logistics/streets.php?city_id=<?php echo $one['city_id']; ?>&dist_id=<?php echo $one['dist_id']; ?>&ward_id=<?php echo $one['ward_id']; ?>&street_id=<?php echo $one['street_id']; ?>&del=true" title="Xóa"><img src="/static/img/delete.gif" border="0" /></a><?php }?></td>
                          </tr>
                         <?php }}?>
                        </table></form>
						<p align="center"><?php echo $pagestring; ?></p>
                    </div>
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
