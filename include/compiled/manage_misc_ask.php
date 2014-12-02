<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_misc('ask'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"><div class="subhead"><h2>Questions on deal</h2></div></div>
            <div class="box-content">
                <div class="head">
                    <ul class="filter">
						<li><form action="/backend/misc/ask.php" method="get">deal：<input type="text" class="h-input" name="title" value="<?php echo htmlspecialchars($title); ?>" >&nbsp;<select name="type"><?php echo Utility::Option($option_ask, $type, 'category'); ?></select>&nbsp;<input type="submit" value="select" class="formbutton"  style="padding:1px 6px;"/><form></li>
					</ul>
				</div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="260">deal name</th><th width="60">user</th><th width="200">question</th><th width="200">reply</th><th width="120">operation</th></tr>
					<?php if(is_array($asks)){foreach($asks AS $index=>$one) { ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>">
						<td><a class="deal-title" href="/team.php?id=<?php echo $one['team_id']; ?>"><?php echo $teams[$one['team_id']]['title']; ?></a></td>
						<td nowrap><?php echo $users[$one['user_id']]['username']; ?></td>
						<td><?php echo htmlspecialchars($one['content']); ?></td>
						<td><?php echo htmlspecialchars($one['comment']); ?></td>
						<td class="op" nowrap><a href="/backend/misc/askedit.php?id=<?php echo $one['id']; ?>&r=<?php echo $currefer; ?>">reply</a>｜<a href="/backend/misc/askremove.php?id=<?php echo $one['id']; ?>&r=<?php echo $currefer; ?>" class="remove-record">delete</a></td>
					</tr>
					<?php }}?>
					<tr><td colspan="6"><?php echo $pagestring; ?></tr>
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
