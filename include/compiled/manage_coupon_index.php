<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_coupon('index'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head">
                    <h2>Consumable</h2>
					<ul class="filter">
						<li><form method="get"> deal ID：<input type="text" class="h-input" name="tid" value="<?php echo htmlspecialchars($tid); ?>" >&nbsp;user：<input type="text" class="h-input" name="uname" value="<?php echo htmlspecialchars($uname); ?>" >&nbsp; coupon No.：<input type="text" class="h-input" name="coupon" value="<?php echo htmlspecialchars($coupon); ?>" >&nbsp;<input type="submit" value="select" class="formbutton"  style="padding:1px 6px;"/><form></li>
					</ul>
				</div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="100"> No.</th><th width="420"> deal</th><th width="180"> user</th><th width="80" nowrap> due time</th><th width="40" nowrap> SMS </th><th width="40" nowrap> operation</th></tr>
					<?php if(is_array($coupons)){foreach($coupons AS $index=>$one) { ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>">
						<td><?php echo $one['id']; ?></td>
						<td><?php echo $one['team_id']; ?>&nbsp;(<a class="deal-title" href="/team.php?id=<?php echo $one['team_id']; ?>" target="_blank"><?php echo $teams[$one['team_id']]['title']; ?></a>)</td>
						<td nowrap><?php echo $users[$one['user_id']]['email']; ?><br/><?php echo $users[$one['user_id']]['username']; ?></td>
						<td nowrap><?php echo date('Y-m-d',$one['expire_time']); ?></td>
						<td><?php echo $one['sms']; ?></td>
						<td class="op"><a href="/ajax/coupon.php?action=sms&id=<?php echo $one['id']; ?>" class="ajaxlink"> SMS </a></td>
					</tr>
					<?php }}?>
					<tr><td colspan="7"><?php echo $pagestring; ?></tr>
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
