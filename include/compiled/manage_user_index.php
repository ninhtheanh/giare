<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_user('index'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"><div class="subhead"><h2>Users list</h2></div></div>
            <div class="box-content">
                <div class="head">
                    <ul class="filter">
						<li><form action="/backend/user/index.php" method="get">username：<input type="text" name="uname" class="h-input" value="<?php echo htmlspecialchars($uname); ?>" >&nbsp;email：<input type="text" name="like" class="h-input" value="<?php echo htmlspecialchars($like); ?>" >&nbsp;<select name="ucity" style="width:120px;"><?php echo Utility::Option(option_category('city'), $ucity, 'all cities'); ?></select>&nbsp;<input type="submit" value="select" class="formbutton"  style="padding:1px 6px;"/><form></li>
					</ul>
				</div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="20">ID</th><th width="200">Email/username</th><th width="200" nowrap>name/city</th><th width="40">account balance (<span class="currency"><?php echo $currency; ?></span>)</th><!--<th width="40">zipcode</th>--><th width="140">registration IP/registration time</th></th><th width="100">telephone</th><th width="100">operation</th></tr>
					<?php if(is_array($users)){foreach($users AS $index=>$one) { ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>">
						<td><?php echo $one['id']; ?></td>
						<td><?php echo $enc->decrypt('@4!@#$%@', $one['email']); ?><br/><?php echo $enc->decrypt('@4!@#$%@', $one['username']); ?><?php if(Utility::IsMobile($one['mobile'])){?>&nbsp;&raquo;&nbsp;<a href="/ajax/misc.php?action=sms&v=<?php echo $one['mobile']; ?>" class="ajaxlink">SMS</a><?php }?></td>
						<td><?php echo $one['realname']?$one['realname']:'----';; ?><br/><?php if ($one['note_address']!=''){$note_address = $one['note_address'].", ";}else{$note_address="";}; ?><?php echo $note_address; ?><?php echo $one['address']?$one['address'].', ':'----';; ?><?php if(wardname($one['dist_id'],$one['ward_id'])){?><?php $wardname = wardname($one['dist_id'],$one['ward_id']); ?><?php echo $wardname['ward_name']; ?>,<?php }?> <?php if($one['dist_id']){?><?php echo $alldist[$one['dist_id']]['dist_name']; ?><?php } else { ?>other<?php }?>, <?php if($one['city_id']){?><?php echo $allcities[$one['city_id']]['name']; ?><?php } else { ?>other<?php }?></td>
						<td><?php echo print_price(moneyit($one['money'])); ?></td>
						<!--<td><?php echo $one['zipcode']; ?></td>-->
						<td><?php echo $one['ip']; ?><br/><?php echo date('Y-m-d H:i', $one['create_time']); ?></td>
						<td><?php echo $one['mobile']; ?></td>
						<td class="op"><a href="/ajax/manage.php?action=userview&id=<?php echo $one['id']; ?>" class="ajaxlink">detail</a>｜<a href="/backend/user/edit.php?id=<?php echo $one['id']; ?>">edit</a></td>
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
