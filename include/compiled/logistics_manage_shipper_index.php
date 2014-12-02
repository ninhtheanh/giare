<?php include template("manage_header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_shipper('index'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"><div class="subhead">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="10%" nowrap="nowrap"><a href="/backend/logistics/create.php" style="color:#FFFFFF; font-size:13px; font-family:Arial, Helvetica, sans-serif"><strong>Thêm mới NV GH</strong></a></td><td width="10%" nowrap="nowrap" style="padding-left:10px;"><a href="/backend/logistics/streets.php" style="color:#FFFFFF; font-size:13px; font-family:Arial, Helvetica, sans-serif"><strong>Quản lý tên đường</strong></a></td><td width="10%" nowrap="nowrap" style="padding-left:10px;"><a href="/backend/logistics/province-city.php" style="color:#FFFFFF; font-size:13px; font-family:Arial, Helvetica, sans-serif"><strong>Tỉnh - TP</strong></a></td><td width="10%" nowrap="nowrap" style="padding-left:10px;"><a href="/backend/logistics/district.php" style="color:#FFFFFF; font-size:13px; font-family:Arial, Helvetica, sans-serif"><strong>Quận - Huyện</strong></a></td><td width="10%" nowrap="nowrap" style="padding-left:10px;"><a href="/backend/logistics/ward.php" style="color:#FFFFFF; font-size:13px; font-family:Arial, Helvetica, sans-serif"><strong>Phường - Xã</strong></a></td><td width="10%" nowrap="nowrap" style="padding-left:10px;"><a href="/backend/logistics/destination.php" style="color:#FFFFFF; font-size:13px; font-family:Arial, Helvetica, sans-serif"><strong>Khu vực</strong></a></td><td width="10%" nowrap="nowrap" style="padding-left:10px;"><a href="/backend/logistics/transport.php" style="color:#FFFFFF; font-size:13px; font-family:Arial, Helvetica, sans-serif"><strong>Phương thức vận chuyển</strong></a></td>
                      </tr>
                    </table>

				</div></div>
            <div class="box-content">
                
                <div class="sect" style="padding-top:3px; padding-bottom:5px"><form action="/backend/shipper/index.php" method="get"><table><tr><td><strong>Full name</strong></td><td style="padding-left:2px"><input type="text" name="fname" class="h-input" value="<?php echo htmlspecialchars($uname); ?>" ></td><td style="padding-left:10px"><strong>Tel</strong></td><td style="padding-left:2px"><input type="text" name="like" class="h-input" value="<?php echo htmlspecialchars($like); ?>" ></td><td style="padding-left:10px"><input type="submit" value="Search" class="formbutton"  style="padding:1px 6px;"/></td></tr></table><form>
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="20">ID</th><th width="200">Full name</th><th width="400" nowrap>Address</th><th width="100">Tel</th></th><th width="100">Date create</th><th width="80">Status</th><th width="100">Operation</th></tr>
					<?php if(is_array($shippers)){foreach($shippers AS $index=>$one) { ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>">
						<td><?php echo $one['id']; ?></td>
						<td><?php echo $one['shipper_name']; ?></td>
						<td><?php echo $one['shipper_address']?$one['shipper_address']:'----'; ?></td>
						<td><?php echo $one['shipper_tel']; ?></td>
                        <td><?php echo date("d/m/Y",$one['create_time']); ?></td>
						<td><?php echo $one['shipper_status']=='A'?'Active':'Deactive'; ?></td>
						<td class="op"><a href="/backend/logistics/edit.php?id=<?php echo $one['id']; ?>">edit</a></td>
					</tr>
					<?php }}?>
					<tr><td colspan="8"><?php echo $pagestring; ?></tr>
                    </table>
				</div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("manage_footer");?>