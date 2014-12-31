<?php include template("manage_header");?>

<link href="jquery.datepick.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="jquery.plugin.js"></script>
<script src="jquery.datepick.js"></script>
<script>
$(function() {
	$('#start_time').datepick({
        inline: true,
        showOtherMonths: true,
        dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        dateFormat: 'yyyy-mm-dd'
    });	
    $('#end_time').datepick({
        inline: true,
        showOtherMonths: true,
        dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        dateFormat: 'yyyy-mm-dd'
    });	
});
function showDate(date) {
	alert('The date chosen is ' + date);
}
</script>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="subdashboard" id="dashboard">
		<?php echo mcurrent_team($selector); ?>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top"><div class="subhead"><h2>Promotion category: Edit</h2></div></div>
            <div class="box-content">
                <div class="sect" style="padding-top:5px;">
                    <form method="post" class="validator" action="" enctype="multipart/form-data" class="validator">
						<table width="900" border="0" cellpadding="5" cellspacing="5" align="center">							
							<tr>
                                <td width="120">Tên:</td>
                                <td>
                                    <input style="width:300px" type="text" size="10" name="promotion_name" id="promotion_name" value="<?php echo $promotion['promotion_name']; ?>" require="true" />
                                </td>
                            </tr>
                            <tr><td colspan="10" height="10"></td></tr>
                            <tr>
								<td>
                                    Kiểu:
                                </td>
                                <td>
									<input type="radio" name="promotion_type" value="0" <?=$promotion['promotion_type'] == 0 ? "checked" : "";?> />
									Giảm theo phần %
									<input type="radio" name="promotion_type" value="1" <?=$promotion['promotion_type'] == 1 ? "checked" : "";?> />
									Giảm theo số tiền
                                    <input type="radio" name="promotion_type" value="2" <?=$promotion['promotion_type'] == 2 ? "checked" : "";?> />
									Sản phẩm đồng giá 
								</td>
                            </tr>
                            <tr><td colspan="10" height="10"></td></tr>
                            <tr>
								<td>Giá trị:</td>
								<td>
									<input style="width:100px" type="text" size="10" name="promotion_value" id="promotion_value" class="number" value="<?php echo moneyit($promotion['promotion_value']); ?>" datatype="double" require="true" />
                                    Không vượt quá 70% giá trỉ sản phẩm
								</td>
                            </tr>  
                            <tr><td colspan="10" height="10"></td></tr>                          
                            <tr>
								<td>
									Thời gian áp dụng:
                                </td>
                                <td>
									<input type="text" size="30" name="start_time" id="start_time" class="number" style="width:160px;" xd="<?php echo $promotion['start_time']; ?>" xt="<?php echo $promotion['start_time']; ?>" value="<?php echo $promotion['start_time']; ?>" maxlength="30" />
                                    <input type="text" size="30" name="end_time" id="end_time" class="number" style="width:160px;" xd="<?php echo $promotion['end_time']; ?>" xt="<?php echo $promotion['end_time']; ?>" value="<?php echo $promotion['end_time']; ?>" maxlength="30" />

								</td>
                            </tr>
                            <tr><td colspan="10" height="10"></td></tr>
                            <tr>
								<td>
									Hiệu lực:
                                </td>
                                <td>
									<input type="checkbox" name="activate" <?php echo $promotion['activate'] == 1 ? 'checked="checked"' : ''; ?>/>		
								</td>
                            </tr>
                            <tr><td colspan="10" height="10"></td></tr>							
                            <tr>
								<td></td>
								<td>	
                                    <div class="">
                                        <input type="submit" value="Submit" name="commit" class="formbutton"/>
                                        <input type="hidden" name="id" value="<?php echo $promotion['id']; ?>" />
                                    </div>
								</td>
                            </tr>							
						</table>                                             
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
