<?php include template("manage_header");?>
<script src="/static/js/jscolor.js" type="text/javascript"></script>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_system('order_status'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top"><div class="subhead"><h2>Trạng thái đơn hàng</h2></div></div>
            <div class="box-content">
                
                <div class="sect">
                    <form method="post">
                          
                          <table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="20">ID</th><th width="80">Mã</th><th width="250" nowrap>Tên</th><th width="80">Mã màu</th><th width="120">Hạn xử lý (giờ)</th></th><th width="80">Kích hoạt</th><th width="80">Frontend</th></tr>
					<?php if(is_array($status)){foreach($status AS $index=>$one) { ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>">
						<td><?php echo $one['id']; ?></td>
						<td><?php echo $one['code']; ?></td>
						<td><input type="text" name="data[<?php echo $one['id']; ?>][name]" value="<?php echo $one['name']; ?>" size="40" /></td>					
						<td>
                        
                         <input name="data[<?php echo $one['id']; ?>][color]" style="background-color: #<?php echo $one['color']; ?>;border:1px solid #ccc" autocomplete="off" class="color" id="color" value="<?php echo $one['color']; ?>" type="text" size="6">                           
                              <div id="colorpicker"></div>
                        </td>
						<td><input type="text" name="data[<?php echo $one['id']; ?>][period]" value="<?php echo $one['period']; ?>" size="3" /></td>
						<td><?php echo $one['active']; ?></td>
                        <td><?php echo $one['front']; ?></td>
					</tr>                 
					<?php }}?>
                    
                    	</table>
                     
                       
                        <div class="act">
                            <input type="submit" value="Save" name="commit" class="formbutton"/>
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
