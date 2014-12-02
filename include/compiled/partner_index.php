<?php include template("header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="recent-deals">
<?php if(option_yes('catepartner')){?>
	<div class="dashboard" id="dashboard">
		<ul><?php echo current_partner($group_id); ?></ul>
	</div>
<?php }?>
    <div id="content">
        <div class="box">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head"><h2><?php echo $category['name']; ?> Premium Biz</h2></div>
				<div class="sect">
					<ul class="deals-list">
					<?php if(is_array($partners)){foreach($partners AS $index=>$one) { ?>
						<li class="<?php echo $index++%2?'alt':''; ?> <?php echo $index<=2?'first':''; ?>">
							<h4><a href="/partner.php?id=<?php echo $one['id']; ?>" title="<?php echo $one['title']; ?>" target="_blank"><?php echo mb_strimwidth($one['title'],0,86,'...'); ?></a><br/>
							Tel: <?php echo $one['phone']; ?></h4>
							<div class="pic">
								<a href="/partner.php?id=<?php echo $one['id']; ?>" title="<?php echo $one['title']; ?>" target="_blank"><img alt="<?php echo $one['title']; ?>" src="<?php echo team_image($one['image'], false); ?>" /></a>
							</div>
							<div class="info"><?php echo htmlspecialchars_decode(mb_strimwidth(strip_tags($one['other']),0,110,'...')); ?></div>
						</li>
					<?php }}?>
					</ul>
					<div class="clear"></div>
					<div><?php echo $pagestring; ?></div>
				</div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
	<div id="sidebar">
		<?php include template("block_side_subscribe");?>
	</div>
</div>
    </div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("footer");?>
