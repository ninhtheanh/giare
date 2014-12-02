<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_credit('index'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"><div class="subhead">
                    <h2>Credit record</h2>
                    <ul class="filter">
						<li><form action="/backend/credit/index.php" method="get">username：<input type="text" name="uname" class="h-input" value="<?php echo htmlspecialchars($uname); ?>" >&nbsp;Email：<input type="text" name="like" class="h-input" value="<?php echo htmlspecialchars($like); ?>" >&nbsp;<select name="action" style="width:120px;"><?php echo Utility::Option($option_action, $action, 'all operation'); ?></select>&nbsp;<input type="submit" value="Submit" class="formbutton"  style="padding:1px 6px;"/><form></li>
					</ul>
				</div></div>
            <div class="box-content">
                
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="50">ID</th><th width="200">Email/username</th><th width="100" nowrap>name/city</th><th width="40">credit</th><th width="400">detail</th><th width="100">operation</th></tr>
					<?php if(is_array($credits)){foreach($credits AS $index=>$one) { ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>">
						<td><?php echo $one['id']; ?></td>
						<td><?php echo $users[$one['user_id']]['email']; ?><br/><?php echo $users[$one['user_id']]['username']; ?><?php if(Utility::IsMobile($users[$one['user_id']]['mobile'])){?>&nbsp;&raquo;&nbsp;<a href="/ajax/misc.php?action=sms&v=<?php echo $users[$one['user_id']]['mobile']; ?>" class="ajaxlink">SMS</a><?php }?></td>
						<td><?php echo $users[$one['user_id']]['realname']?$users[$one['user_id']]['realname']:'----';; ?><br/><?php if($users[$one['user_id']]['city_id']){?><?php echo $allcities[$users[$one['user_id']]['city_id']]['name']; ?><?php } else { ?>other<?php }?></td>
						<td><span class="currency"></span><?php echo moneyit($one['score']); ?></td>
						<td><?php echo ZCredit::Explain($one); ?></td>
						<td>operation</td>
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
