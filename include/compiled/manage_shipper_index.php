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
                    <h2>Shipper list</h2>
                    <ul class="filter">
						<li><form action="/backend/shipper/index.php" method="get">Full name：<input type="text" name="fname" class="h-input" value="<?php echo htmlspecialchars($fname); ?>" >&nbsp;Tel：<input type="text" name="like" class="h-input" value="<?php echo htmlspecialchars($like); ?>" >&nbsp;<input type="submit" value="select" class="formbutton"  style="padding:1px 6px;"/><form></li>
					</ul>
				</div></div>
            <div class="box-content">
                
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="20">ID</th><th width="200">Full name</th><th width="400" nowrap>Address</th><th width="100">Tel</th></th><th width="100">Date create</th><th width="80">Status</th><th width="100">operation</th></tr>
					<?php if(is_array($shippers)){foreach($shippers AS $index=>$one) { ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>">
						<td><?php echo $one['id']; ?></td>
						<td><?php echo $one['shipper_name']; ?></td>
						<td><?php echo $one['shipper_address']?$one['shipper_address']:'----'; ?></td>
						<td><?php echo $one['shipper_tel']; ?></td>
                        <td><?php echo date("d/m/Y",$one['create_time']); ?></td>
						<td><?php echo $one['shipper_status']=='A'?'Active':'Deactive'; ?></td>
						<td class="op"><a href="/backend/shipper/edit.php?id=<?php echo $one['id']; ?>">edit</a></td>
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
