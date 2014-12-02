<?php include template("header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="forum">
	<div class="dashboard" id="dashboard">
		<ul><?php echo current_forum('index'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear">
		<div class="box clear">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head">
                    <h2>Tất cả chủ đề</h2>
					<ul class="filter">
					  <li><a href="/forum/new.php">＋Thêm chủ đề mới</a></li>
					</ul>
				</div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
						<tr>
						  <th width="360">Chủ đề</th>
						  <th width="80" nowrap>Nhóm</th>
						  <th width="80" nowrap>Trả lời/ đọc</th>
						  <th width="100" nowrap>Trả lời mới nhất</th>
						</tr>
					<?php if(is_array($topics)){foreach($topics AS $index=>$one) { ?>
						<tr <?php echo $index%2?'':'class="alt"'; ?>><td style="text-align:left;"><a class="deal-title" href="/forum/topic.php?id=<?php echo $one['id']; ?>" style="<?php echo $one['head']?'color:#F00;':''; ?>"><?php echo htmlspecialchars($one['title']); ?></a></td><td nowrap><?php if($one['public_id']){?>Thảo luận chung<?php } else if($one['team_id']) { ?>Thảo luận Deal<?php } else { ?><?php echo $city['name']; ?><?php }?></td><td align="center" nowrap><?php echo $one['reply_number']; ?>/<?php echo $one['view_number']; ?></td><td class="author" nowrap><?php echo $users[$one['last_user_id']]['realname']; ?><br/><?php echo Utility::HumanTime($one['last_time']); ?></td></tr>
					<?php }}?>
						<tr><td colspan="4"><?php echo $pagestring; ?></td></tr>
                    </table>
				</div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
    <div id="sidebar">
    	<?php include template("block_side_support");?>
		<?php include template("block_side_subscribe");?>
        <?php include template("block_side_ads");?>
    </div>
</div>

</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("footer");?>
