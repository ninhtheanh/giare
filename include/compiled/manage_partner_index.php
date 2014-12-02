<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_partner('index'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"><div class="subhead"><h2>Partner List</h2></div></div>
            <div class="box-content">
                <div class="head">
					<ul class="filter"><li><form method="get">biz name：<input type="text" name="ptitle" class="h-input" value="<?php echo htmlspecialchars($ptitle); ?>" >&nbsp;<select name="open" class="h-input"><?php echo Utility::Option($option_open, $open, 'display'); ?></select>&nbsp;<select name="city_id" class="h-input"><?php echo Utility::Option(option_category('city'), $city_id, 'all cities'); ?></select>&nbsp;<select name="group_id" class="h-input"><?php echo Utility::Option(option_category('partner'), $group_id, 'all categories'); ?></select>&nbsp;<input type="submit" value="select" class="formbutton"  style="padding:1px 6px;"/><form></li></ul>
				</div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="40">ID</th><th width="320">name</th><th width="60">category</th><th width="120">person to contact</th><th width="130">telephone</th><th width="60">display</th><th width="40">sort</th><th width="100">operation</th></tr>
					<?php if(is_array($partners)){foreach($partners AS $index=>$one) { ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>">
						<td><?php echo $one['id']; ?></td>
						<td style="text-align:left;"><a class="deal-title" href="/backend/partner/edit.php?id=<?php echo $one['id']; ?>"><?php echo $one['title']; ?></a></td>
						<td nowrap><?php echo $groups[$one['group_id']]; ?><br/><?php echo $cities[$one['city_id']]; ?></td>
						<td nowrap><?php echo $one['contact']; ?></td>
						<td nowrap><?php echo $one['phone']; ?><br/><?php echo $one['mobile']; ?></td>
						<td nowrap><?php echo $one['open']; ?></td>
						<td nowrap><?php echo $one['head']; ?></td>
						<td class="op" nowrap><a href="/backend/partner/edit.php?id=<?php echo $one['id']; ?>">edit</a>｜<a href="/ajax/manage.php?action=partnerremove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to delete this biz?">delete</a></td>
					</tr>
					<?php }}?>
					<tr><td colspan="7"><?php echo $pagestring; ?></td></tr>
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
