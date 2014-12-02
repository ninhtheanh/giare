<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_coupon('card'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head">
					<h2> Coupon </h2>
					<ul class="filter">
						<li><form method="get">deal ID:<input type="text" name="tid" value="<?php echo htmlspecialchars($tid); ?>" class="h-input" />&nbsp;biz ID：<input type="text" name="pid" value="<?php echo htmlspecialchars($pid); ?>" class="h-input" />&nbsp;symbol:<input type="text" name="code" value="<?php echo htmlspecialchars($code); ?>" class="h-input" />&nbsp;state：<select name="state"><?php echo Utility::Option($usage, $state, 'all'); ?></select>&nbsp;<input type="submit" value="select" class="formbutton"  style="padding:1px 6px;"/>&nbsp;<input type="submit" name="download" value="download" class="formbutton"  style="padding:1px 6px;"/><form></li>
					</ul>
				</div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="120">ID</th><th width="40">value</th><th width="120">code</th><th width="80">due time</th><th width="100">state</th><th width="380">biz name</th><th width="40">operation</th></tr>
					<?php if(is_array($cards)){foreach($cards AS $index=>$one) { ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>">
						<td><?php echo $one['id']; ?></td>
						<td nowrap><?php echo moneyit($one['credit']); ?></td>
						<td nowrap><?php echo $one['code']; ?></td>
						<td nowrap><?php echo date('Y-m-d',$one['begin_time']); ?><br/><?php echo date('Y-m-d',$one['end_time']); ?></td>
						<td nowrap><?php echo $one['consume']=='Y' ? 'used':'usable'; ?><?php if($one['consume']=='Y'){?>&nbsp;(<?php echo $one['team_id']; ?>)<?php }?></td>
						<td><?php echo $one['partner_id']; ?><?php if($one['partner_id']){?>&nbsp;(<?php echo $partners[$one['partner_id']]['title']; ?>)<?php }?></td>
						<td class="op" nowrap><a href="/ajax/manage.php?action=cardremove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to delete the voucher？">delete</a></td>
					</tr>
					<?php }}?>
					<tr><td colspan="7"><?php echo $pagestring; ?></td></tr>
                    </table>
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
