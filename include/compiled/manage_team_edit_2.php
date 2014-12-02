<?php include template("manage_header");?>
<!--<script src="/ckeditor/ckeditor.js"></script> -->
<script src="/editor/ckeditor/ckeditor.js"></script>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="leader">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_team('team'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top"><div class="subhead">
				<?php if($team['id']){?>
					<h2>Edit deals</h2>
					<ul class="filter" style="margin-top:3px;"><?php echo current_manageteam('edit', $team['id']); ?></ul>
				<?php } else { ?>
					<h2>Creat deals</h2>
				<?php }?>
				</div></div>
            <div class="box-content">
                
                <div class="sect">
				<form id="-user-form" method="post" action="/backend/team/edit.php?id=<?php echo $team['id']; ?>" enctype="multipart/form-data" class="validator">
					<input type="hidden" name="id" value="<?php echo $team['id']; ?>" /><input type="hidden" name="now_number" value="<?php echo $team['now_number']; ?>" />
					<div class="wholetip clear">
					  <h3>1. Thông tin cơ bản</h3>
					</div>
					<div class="field">
						<label>Deal type <span style="color:#ff0000;">*</span></label>
						<select name="team_type" class="f-input" style="width:160px;" onchange="X.team.changetype(this.options[this.options.selectedIndex].value);"><?php echo Utility::Option($option_teamtype, $team['team_type']); ?></select>
                        <?php $team['city_id'] = ($team['city_id']>0)?$team['city_id']:11;; ?>
                        <select name="city_id" class="f-input" style="width:150px;"><?php echo Utility::Option(Utility::OptionArray($allcities, 'id','name'), $team['city_id'], 'Toàn Quốc'); ?></select>
						<select name="group_id" class="f-input" style="width:170px;"><?php echo Utility::Option($groups, $team['group_id']); ?></select>
					</div>
					<div class="field" id="field_limit">
						<label>Limitations<span style="color:#ff0000;">*</span></label>
						<select name="conduser" class="f-input" style="width:450px;"><?php echo Utility::Option($option_cond, $team['conduser']); ?></select>
						<select name="buyonce" class="f-input" style="width:160px;"><?php echo Utility::Option($option_buyonce, $team['buyonce']); ?></select>
					</div>
                    <div class="field">
						<label>Mã SP<span style="color:#ff0000;">*</span></label>
						<input type="text" size="30" name="masp" id="team-create-masp" class="f-input" value="<?php echo $team['masp']; ?>" datatype="require" require="true" />
					</div>
  <div class="field">
						<label>Tên SP<span style="color:#ff0000;">*</span></label>
						<input type="text" size="30" name="product" id="team-create-product" class="f-input" value="<?php echo $team['product']; ?>" datatype="require" require="true" />
					</div>
					<span class="hint">Mã code: product / <span style="color:#ff0000;font-style=bold">Vui lòng ghi chú màu sắc vào phần "Điểm nổi bât", <strong>KHÔNG</strong> ghi chú vào Deal - Mã SP</span></span>
					<div class="field">
						<label>Mô tả ngắn<span style="color:#ff0000;">*</span></label>
						<input type="text" size="25" name="title" id="team-create-title" class="f-input" value="<?php echo htmlspecialchars($team['title']); ?>" datatype="require" require="true" style="width:700px" />
					<span class="hint"><i>Chuẩn: 150 kí tự / 25 từ</i></span></div>
                    <div class="field">
						<label><strong>Tên deal (URL)</strong><span style="color:#ff0000;">*</span></label>
						<input type="text" size="50" maxlength="50" name="short_title" id="team-create-short-title" class="f-input" value="<?php echo htmlspecialchars($team['short_title']); ?>" style="width:400px" datatype="require" require="true" />
					<span class="hint"><i>Mã code: short_title / Tên SP bằng chữ thường, không kèm mã SP <span style="color:#ff0000;font-style=bold">/ Vui lòng <strong>KHÔNG</strong> ghi chú màu sắc vào Tên deal (URL)</span></i></span></div>
					<div class="field">
						<label>Market price</label>
						<input type="text" size="10" name="market_price" id="team-create-market-price" class="number" value="<?php echo moneyit($team['market_price']); ?>" datatype="money" require="true" />
						<label>Web price</label>
						<input type="text" size="10" name="team_price" id="team-create-team-price" class="number" value="<?php echo moneyit($team['team_price']); ?>" datatype="double" require="true" />
						<label>Virtual buyers</label>
						<input type="text" size="10" name="pre_number" id="team-create-pre_number" class="number" value="<?php echo moneyit($team['pre_number']); ?>" datatype="number" require="true" />
					</div>
					<div class="field">
						<label>Lower limit</label>
						<input type="text" size="10" name="min_number" id="team-create-min-number" class="number" value="<?php echo intval($team['min_number']); ?>" maxLength="6" datatype="number" require="true" />
						<label>Upper limit</label>
						<input type="text" size="10" name="max_number" id="team-create-max-number" class="number" value="<?php echo intval($team['max_number']); ?>" maxLength="6" datatype="number" require="true" />
                        <label>now_number</label>
						<input type="text" size="10" name="now_number" id="team-create-max-number" class="number" value="<?php echo intval($team['now_number']); ?>" maxLength="6" datatype="number" require="true" />
						
				    <label>Limit for one user</label>
						<input type="text" size="10" name="per_number" id="team-create-per-number" class="number" value="<?php echo intval($team['per_number']); ?>" maxLength="6" datatype="number" require="true" />
						<span class="hint">The lower limit must be bigger than 0, the biggest quantity/every user's limit of buying：0 means no upper limit (quantity of goods|numbers of buyers which are determined by the conditions of a successful deal)</span></div>
					<div class="field">
					
					<input type="submit" value="Save" name="commit" id="leader-submit" class="formbutton" style="margin:0px 0px 0px 200px;"/>
				
						<label>Start time</label>
						<input type="text" size="30" name="begin_time" id="" class="number" style="width:160px;" xd="<?php echo date('Y-m-d', $team['begin_time']); ?>" xt="<?php echo date('H:i:s', $team['begin_time']); ?>" value="<?php echo date('Y-m-d H:i:s', $team['begin_time']); ?>" maxlength="30" /></div>
<div class="field">
						<label>End time</label>                       
						<input type="text" size="30" name="end_time" id="" class="number" style="width:160px;" xd="<?php echo date('Y-m-d', $team['end_time']); ?>" xt="23:59:59" value="<?php echo date('Y-m-d H:i:s', $team['end_time']); ?>" maxlength="30" /></div>
<div class="field">
						<label><?php echo $INI['system']['couponname']; ?> Due Time</label>
						<input type="text" size="30" name="expire_time" id="" class="number" style="width:160px;" value="<?php echo date('Y-m-d', $team['expire_time']); ?>" maxLength="30" />
						<span class="hint">Date/time format：YYYY-MM-DD HH:MM:SS （example：2010-06-10 23:12:09）</span>
					</div>
                    <div class="field" id="field_limit">
						<label>Giao hàng</label>
						<select name="delivery_properties" class="f-input" id="delivery_properties" style="width:160px;"><option value="1">Giao Sản phẩm</option><option value="0">Giao Voucher</option><!--<option value="2">Giao Voucher - Nhận SP tại VP Cheapdeal</option>--></select>
                        <script type="text/javascript" language="javascript">$("#delivery_properties").val("<?php echo $team['delivery_properties']; ?>");</script>
					<!--<label>Số Hợp đồng<span style="color:#ff0000;">*</span></label>
						<input type="text" style="width:120px; height:20px;" name="number_of_contracts" id="number_of_contracts" class="number" value="<?php echo $team['number_of_contracts']; ?>" datatype="require" require="true" />
                    -->
					<label>Tên NV Sale</label>
						<select name="sale" class="f-input" id="sale" style="width:160px;" datatype="require" require="require"><option value="0">---Chọn---</option><?php echo option_business_staff($team['sale']); ?></select>
                        <script type="text/javascript" language="javascript">$("#sale").val("<?php echo $team['sale']; ?>");</script>
					</div>
					<div class="field">
						<label>Điểm nổi bật</label>
                        <div style="float:left;"><textarea cols="45" rows="5" name="summary" id="system-create-location1" class="elm1" style="width:740px;height:150px;" datatype="require" require="true"><?php echo htmlspecialchars_decode($team['summary']); ?></textarea></div>
					</div>
					<div class="field">
						<label>Điều kiện</label>
						<div style="float:left;"><textarea cols="45" rows="5" name="notice"  id="system-create-location" class="elm1" style="width:740px;height:150px;"><?php echo htmlspecialchars_decode($team['notice']); ?></textarea></div>
						<span class="hint">due time and descriptions of this deal</span>
					</div>
					<!--kxx  -->
					<div class="field">
						<label><strong>Hiện Dealhot<span style="color:#ff0000;">*</span></strong></label>
						<input type="text" size="10" name="sort_order" id="team-create-sort_order" class="number" value="<?php echo $team['sort_order'] ? $team['sort_order'] : 0; ?>" datatype="number"/><span class="inputtip">Please fill out with figures which are ranked from big to small, and set a bigger one for the main deal</span>
					</div>
                    <div class="field">
						<label>Khối lượng</label>
						<input type="text" size="10" name="weight" id="team-create-weight" class="number" value="<?php echo $team['weight'] ? $team['weight'] : 0; ?>" datatype="number"/> gram
					</div>
					<!--xxk-->
					<input type="hidden" name="guarantee" value="Y" />
					<input type="hidden" name="system" value="Y" />
					<input type="submit" value="Save" name="commit" id="leader-submit" class="formbutton" style="margin:0px 0px 0px 1000px;"/>
					<div class="wholetip clear"><h3>2. Thông tin deal</h3></div>
					<div class="field">
						<label>Partner</label>
						<select name="partner_id" datatype="require" require="require" class="f-input" style="width:200px;"><?php echo Utility::Option($partners, $team['partner_id']); ?></select><span class="inputtip">Partner is optional</span>
					</div>
					<div class="field" id="field_card">
						<label>card use</label>
						<input type="text" size="10" name="card" id="team-create-card" class="number" value="<?php echo moneyit($team['card']); ?>" require="true" datatype="money" />
						<span class="inputtip">The biggest card value can be used</span>
					</div>
					<div class="field" id="field_card">
						<label>invitation rebate</label>
						<input type="text" size="10" name="bonus" id="team-create-bonus" class="number" value="<?php echo moneyit($team['bonus']); ?>" require="true" datatype="money" />
						<span class="inputtip">the amount of rebate which you get from your invited friend's buying</span>
					</div>
                    
                    <div class="field" id="field_card">
						<label>Affiliate rebate</label>
						<input type="text" size="10" name="aff_rebate" id="aff-create-bonus" class="number" value="<?php echo moneyit($team['aff_rebate']); ?>" require="true" datatype="money" />
						<span class="inputtip">% Rebate for Affiliates</span>
					</div>
                    
					<div class="field">
						<label>Màu sắc</label>
						<input type="text" size="30" name="condbuy" id="team-create-condbuy" class="f-input" value="<?php echo $team['condbuy']; ?>" />
						<span class="hint">Định dạng màu：{yellow}{green}{red}{black}{white}{gray}->xám {blue}{pink}{magenta}->hồng đậm/{orange}{cyan}->xanh da trời /{violet}->tím nhạt {purple}->tím </br>{brown}->nâu {khaki}->màu kaki {bisque}->màu be</span>
					</div>
					<div class="field">
						<label>Ảnh đại diện</label>
						<input type="file" size="30" name="upload_image" id="team-create-image" class="f-input" />
						<?php if($team['image']){?><span class="hint"><?php echo team_image($team['image']); ?></span><?php }?>
					</div>
					<div class="field">
						<label>goods picture 1</label>
						<input type="file" size="30" name="upload_image1" id="team-create-image1" class="f-input" />
						<?php if($team['image1']){?><span class="hint" id="team_image_1"><?php echo team_image($team['image1']); ?>&nbsp;&nbsp;<a href="javascript:;" onclick="X.team.imageremove(<?php echo $team['id']; ?>, 1);">delete</a></span><?php }?>
						
					</div>
					<div class="field">
						<label>goods picture 2</label>
						<input type="file" size="30" name="upload_image2" id="team-create-image2" class="f-input" />
						<?php if($team['image2']){?><span class="hint" id="team_image_2"><?php echo team_image($team['image2']); ?>&nbsp;&nbsp;<a href="javascript:;" onclick="X.team.imageremove(<?php echo $team['id']; ?>, 2);">delete</a></span><?php }?>
					</div>
                    <div class="field">
						<label>goods picture 3</label>
						<input type="file" size="30" name="upload_image3" id="team-create-image3" class="f-input" />
						<?php if($team['image3']){?><span class="hint" id="team_image_3"><?php echo team_image($team['image3']); ?>&nbsp;&nbsp;<a href="javascript:;" onclick="X.team.imageremove(<?php echo $team['id']; ?>, 3);">delete</a></span><?php }?>
					</div>
					<div class="field">
						<label>goods picture 4</label>
						<input type="file" size="30" name="upload_image4" id="team-create-image4" class="f-input" />
						<?php if($team['image4']){?><span class="hint" id="team_image_4"><?php echo team_image($team['image4']); ?>&nbsp;&nbsp;<a href="javascript:;" onclick="X.team.imageremove(<?php echo $team['id']; ?>, 4);">delete</a></span><?php }?>
					</div>
					<div class="field">
						<label>goods picture 5</label>
						<input type="file" size="30" name="upload_image5" id="team-create-image5" class="f-input" />
						<?php if($team['image5']){?><span class="hint" id="team_image_5"><?php echo team_image($team['image5']); ?>&nbsp;&nbsp;<a href="javascript:;" onclick="X.team.imageremove(<?php echo $team['id']; ?>, 5);">delete</a></span><?php }?>
					</div>
                    <div class="field">
						<label>goods picture 6</label>
						<input type="file" size="30" name="upload_image7" id="team-create-image7" class="f-input" />
						<?php if($team['image7']){?><span class="hint" id="team_image_7"><?php echo team_image($team['image7']); ?>&nbsp;&nbsp;<a href="javascript:;" onclick="X.team.imageremove(<?php echo $team['id']; ?>, 7);">delete</a></span><?php }?>
					</div>
                    <div class="field">
						<label>Picture Voucher</label>
						<input type="file" size="30" name="upload_image6" id="team-create-image6" class="f-input" />
						<?php if($team['image6']){?><span class="hint" id="team_image_6"><?php echo team_image($team['image6']); ?>&nbsp;&nbsp;<a href="javascript:;" onclick="X.team.imageremove(<?php echo $team['id']; ?>, 6);">delete</a></span><?php }?>
					</div>
                    
					<div class="field">
						<label>FLV.sw</label>
						<input type="text" size="30" name="flv" id="team-create-flv" class="f-input" value="<?php echo $team['flv']; ?>" />
						<span class="hint">format is as：http://.../video.flv</span>
					</div>
					<div class="field">
						<label>Chi tiết <span style="color:#ff0000;">*</span></label>
						<div style="float:left;"><textarea cols="45" rows="5" name="detail" id="system-create-location2" class="elm1" style="width:740px;height:150px;"><?php echo htmlspecialchars_decode($team['detail']); ?></textarea></div>
					</div>
<!--					<div class="field" id="field_userreview">
						<label>User Reviews</label>
						<div style="float:left;"><textarea cols="45" rows="5" name="userreview" id="team-create-userreview" class="f-textarea editor"><?php echo htmlspecialchars_decode($team['userreview']); ?></textarea></div>
						<span class="hint">Format:“Good with | Rita|http://ww....|XXX Network”，Write a comment per line</span>
					</div>
					<div class="field">
						<label><?php echo $INI['system']['abbreviation']; ?> Says</label>
						<div style="float:left;"><textarea cols="45" rows="5" name="systemreview" id="team-create-systemreview" class="f-textarea editor" style="width:710px;height:150px;"><?php echo htmlspecialchars_decode($team['systemreview']); ?></textarea></div>
					</div>
					<div class="wholetip clear"><h3>3. Phương thức vận chuyển</h3></div>
					<div class="field">
						<label>Mode of delivery</label>
						<div style="margin-top:5px;" id="express-zone-div"><input type="radio" name="delivery" value="normal" <?php echo $team['delivery']=='normal'?'checked':''; ?> />&nbsp;Normal delivery&nbsp;<input type="radio" name="delivery" value="coupon" <?php echo $team['delivery']=='coupon'?'checked':''; ?> />&nbsp;<?php echo $INI['system']['couponname']; ?>&nbsp;<input type="radio" name="delivery" value='express' <?php echo $team['delivery']=='express'?'checked':''; ?> />&nbsp;Express delivery</div>
					</div>
                    <?php if($login_user_id==1){?><div class="field">
						<label><strong>Hiển thị số người mua ảo:</strong></label><input type="text" style="width:120px; height:20px;" name="virtual_buy" id="virtual_buy" class="number" value="<?php echo $team['virtual_buy']; ?>" datatype="require" require="true" /><span style="font-size:18px"><strong>%</strong></span></div><?php }?>
					<div id="express-zone-coupon" style="display:<?php echo $team['delivery']=='coupon'?'block':'none'; ?>;">
						<div class="field">
							<label>Consumer rebates</label>
							<input type="text" size="10" name="credit" id="team-create-credit" class="number" value="<?php echo moneyit($team['credit']); ?>" datatype="money" require="true" />
							<span class="inputtip">Consumer<?php echo $INI['system']['couponname']; ?>Obtained when the account balance rebate, unit USD</span>
						</div>
					</div>
					<div id="express-zone-pickup" style="display:<?php echo $team['delivery']=='pickup'?'block':'none'; ?>;">
						<div class="field">
							<label>Contact</label>
							<input type="text" size="10" name="mobile" id="team-create-mobile" class="f-input" value="<?php echo $team['mobile']; ?>" />
						</div>
						<div class="field">
							<label>Self-created address</label>
							<input type="text" size="10" name="address" id="team-create-address" class="f-input" value="<?php echo $team['address']; ?>" />
						</div>
					</div>
					<div id="express-zone-express" style="display:<?php echo $team['delivery']=='express'?'block':'none'; ?>;">
						<div class="field">
							<label>Delivery costs</label>
							<input type="text" size="10" name="fare" id="team-create-fare" class="number" value="<?php echo intval($team['fare']); ?>" maxLength="6" datatype="money" require="true" />
							<label>Fare</label>
							<input type="text" size="10" name="farefree" id="team-create-farefree" class="number" value="<?php echo intval($team['farefree']); ?>" maxLength="6" datatype="money" require="true" />
							<span class="hint">Courier costs, free single number: 0 can not help but freight, 2 said the purchase of two free shipping</span>
						</div>
						<div class="field">
							<label>Delivery Help</label>
							<div style="float:left;"><textarea cols="45" rows="5" name="express" id="team-create-express" class="f-textarea editor2"><?php echo $team['express']; ?></textarea></div>
						</div>
					</div> -->
					<input type="submit" value="Save" name="commit" id="leader-submit" class="formbutton" style="margin:0px 0px 0px 1000px;"/>
				</form>
                </div>
            </div>
            <div class="box-bottom"></div>
        </div>
	</div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<script type="text/javascript">
window.x_init_hook_teamchangetype = function(){
	X.team.changetype("<?php echo $team['team_type']; ?>");
};
window.x_init_hook_page = function() {
	X.team.imageremovecall = function(v) {
		jQuery('#team_image_'+v).remove();
	};
	X.team.imageremove = function(id, v) {
		return !X.get(WEB_ROOT + '/ajax/misc.php?action=imageremove&id='+id+'&v='+v);
	};
};


	<!--CKEDITOR.replace( 'myeditor',
	{
		filebrowserBrowseUrl : '/ckfinder/ckfinder.html',
		filebrowserImageBrowseUrl : '/ckfinder/ckfinder.html?type=Images',
		filebrowserFlashBrowseUrl : '/ckfinder/ckfinder.html?type=Flash',
		filebrowserUploadUrl : 
		   '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&currentFolder=/archive/',
		filebrowserImageUploadUrl : 
		   '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&currentFolder=/cars/',
		filebrowserFlashUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
	});-->

</script>
</script>
<script type="text/javascript">//<![CDATA[
CKEDITOR.replace('system-create-location1', {"filebrowserBrowseUrl":"\/manage\/team\/..\/..\/editor\/ckfinder\/ckfinder.html","filebrowserImageBrowseUrl":"\/manage\/team\/..\/..\/editor\/ckfinder\/ckfinder.html?type=Images","filebrowserFlashBrowseUrl":"\/manage\/team\/..\/..\/editor\/ckfinder\/ckfinder.html?type=Flash","filebrowserUploadUrl":"\/manage\/team\/..\/..\/editor\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Files","filebrowserImageUploadUrl":"\/manage\/team\/..\/..\/editor\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Images","filebrowserFlashUploadUrl":"\/manage\/team\/..\/..\/editor\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Flash"});
//]]></script>
<script type="text/javascript">//<![CDATA[
CKEDITOR.replace('system-create-location2', {"filebrowserBrowseUrl":"\/manage\/team\/..\/..\/editor\/ckfinder\/ckfinder.html","filebrowserImageBrowseUrl":"\/manage\/team\/..\/..\/editor\/ckfinder\/ckfinder.html?type=Images","filebrowserFlashBrowseUrl":"\/manage\/team\/..\/..\/editor\/ckfinder\/ckfinder.html?type=Flash","filebrowserUploadUrl":"\/manage\/team\/..\/..\/editor\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Files","filebrowserImageUploadUrl":"\/manage\/team\/..\/..\/editor\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Images","filebrowserFlashUploadUrl":"\/manage\/team\/..\/..\/editor\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Flash"});
//]]></script>
<script type="text/javascript">//<![CDATA[
CKEDITOR.replace('system-create-location', {"filebrowserBrowseUrl":"\/manage\/team\/..\/..\/editor\/ckfinder\/ckfinder.html","filebrowserImageBrowseUrl":"\/manage\/team\/..\/..\/editor\/ckfinder\/ckfinder.html?type=Images","filebrowserFlashBrowseUrl":"\/manage\/team\/..\/..\/editor\/ckfinder\/ckfinder.html?type=Flash","filebrowserUploadUrl":"\/manage\/team\/..\/..\/editor\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Files","filebrowserImageUploadUrl":"\/manage\/team\/..\/..\/editor\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Images","filebrowserFlashUploadUrl":"\/manage\/team\/..\/..\/editor\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Flash"});
//]]></script>
<?php include template("manage_footer");?>
