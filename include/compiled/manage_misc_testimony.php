<?php include template("manage_header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul>
		<?php echo mcurrent_misc('testimony'); ?>
		</ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"><div class="subhead"><h2>Testimony Management</h2></div></div>
            <div class="box-content">
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table" width="100%">
					<tr><th width="20">ID</th><th width="400">Content</th><th width="100">User</th><th width="20">Time</th><th width="50">Action</th></tr>
					<?php if(is_array($orders)){foreach($orders AS $index=>$one) { ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>">
						<td><?php echo $one['id']; ?></td>
						<td><?php echo cut_string($one['content'],300,'...'); ?></td>
						<td><strong><?php echo $users[$one['user_id']]['realname']; ?></strong></td>						
                        <td><?php echo Utility::HumanTime($one['date_created']); ?></td>                        
						<td nowrap="nowrap">
                        <?php if($one['status']=='A'){?><a href="/ajax/topic.php?action=testimonyhidden&tid=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to hidden the comment？"><strong>Ẩn</strong></a><?php } else { ?><a href="/ajax/topic.php?action=testimonyshow&tid=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to show the comment？"><strong>Hiển thị</strong></a><?php }?><br />                   
                         <a href="/ajax/topic.php?action=testimonyremove&tid=<?php echo $one['id']; ?>"  class="ajaxlink" ask="sure to delete this comment?">Delete</a></td>
					</tr>
					<?php }}?>
					<tr><td colspan="9"><?php echo $pagestring; ?></tr>
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
