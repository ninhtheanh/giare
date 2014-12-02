<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_credit('goods'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head">
                    <h2>Goods exchange</h2>
					<ul class="filter">
						<li><a href="/backend/credit/ajax.php?action=edit" class="ajaxlink">Add goods for exchange</a></li>
					</ul>
				</div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="50">ID</th><th width="350">name</th><th width="150">credit exchange</th><th width="40" nowrap>quantity</th><th width="40" nowrap>sort</th><th width="40" nowrap>display</th><th width="140">operation</th></tr>
					<?php if(is_array($goods)){foreach($goods AS $index=>$one) { ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?>>
						<td><?php echo $one['id']; ?></td>
						<td><?php echo $one['title']; ?></td>
						<td><?php echo $one['score']; ?></td>
						<td><?php echo $one['consume']; ?>/<?php echo $one['number']; ?></td>
						<td><?php echo $one['display']; ?></td>
						<td><?php echo $one['sort_order']; ?></td>
						<td class="op"><a href="/backend/credit/ajax.php?action=disable&id=<?php echo $one['id']; ?>" class="ajaxlink"><?php echo $one['enable']=='Y'?'forbid':'start'; ?></a>｜<a href="/backend/credit/ajax.php?action=edit&id=<?php echo $one['id']; ?>" class="ajaxlink">edit</a>｜<a href="/backend/credit/ajax.php?action=remove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="Sure to delete this ?">delete</a></td>
					</tr>
					<?php }}?>
					<tr><td colspan="8"><?php echo $pagestring; ?></td></tr>
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
