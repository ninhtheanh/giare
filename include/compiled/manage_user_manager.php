<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_user('manager'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"> <div class="subhead">
                    <h2>List of managers</h2>
				</div></div>
            <div class="box-content">
               
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="20">ID</th><th width="200">email</th><th width="100" nowrap>username</th><th width="130" nowrap>name</th><th width="200">registration time</th></th><th width="100">mobile</th><th width="80">operation</th></tr>
					<?php if(is_array($users)){foreach($users AS $index=>$one) { ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>">
						<td><?php echo $one['id']; ?></td>
						<td><?php if($login_user_id==1){?><?php echo $enc->decrypt('@4!@#$%@', $one['email']); ?><?php }?></td>
						<td><?php if($login_user_id==1){?><?php echo $enc->decrypt('@4!@#$%@', $one['username']); ?><?php }?></td>
						<td><?php echo $one['realname']; ?></td>
						<td><?php echo date('Y-m-d H:i', $one['create_time']); ?></td>
						<td><?php echo $one['mobile']; ?></td>
						<td class="op" nowrap><a href="/backend/user/edit.php?id=<?php echo $one['id']; ?>">edit</a><?php if(is_manager(true)){?>｜<a href="/ajax/system.php?action=authorization&id=<?php echo $one['id']; ?>" class="ajaxlink">authorization</a><?php }?></td>
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
