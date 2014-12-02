<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="leader">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_team('team'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top"><div class="subhead">
				<?php if($team['id']){?>
					<h2>Edit deals</h2>
					<ul class="filter" style="margin-top:3px;"><?php echo current_manageteam('editzz', $team['id']); ?></ul>
				<?php } else { ?>
					<h2>Create deals</h2>
				<?php }?>
				</div></div>
            <div class="box-content">
                
                <div class="sect">
				<form id="-user-form" method="post" action="/backend/team/editzz.php?id=<?php echo $team['id']; ?>" enctype="multipart/form-data" class="validator">
					<input type="hidden" name="id" value="<?php echo $team['id']; ?>" />
					<div class="wholetip clear"><h3>Hiển thị deal hot</h3></div>
					<div class="field">
						<label>Sắp xếp deal</label>
						<input type="text" size="10" name="sort_order" id="team-create-sort_order" class="number" value="<?php echo $team['sort_order'] ? $team['sort_order'] : 0; ?>" datatype="number"/><span class="inputtip">Điền số thứ tự từ 1 trở đi để sắp xếp deal hot. Nếu 2 deal trùng số thứ tự, deal có ID lớn hơn sẽ nằm bên trái trong trang chủ</span>
					</div>
					<div class="field">
						<label>card use</label>
						<input type="text" size="10" name="card" id="team-create-card" class="number" value="<?php echo moneyit($team['card']); ?>" require="true" datatype="money" />
						<span class="inputtip">The biggest card value may be used</span>
					</div>
					<div class="field">
						<label>invitation rebate</label>
						<input type="text" size="10" name="bonus" id="team-create-bonus" class="number" value="<?php echo moneyit($team['bonus']); ?>" require="true" datatype="money" />
						<span class="inputtip">the amount of rebate which you get from your invited friend's buying</span>
					</div>
					<div class="field">
						<label>consumption rebate</label>
						<input type="text" size="10" name="credit" id="team-create-credit" class="number" value="<?php echo moneyit($team['credit']); ?>" datatype="money" require="true" />
						<span class="inputtip">When consuming<?php echo $INI['system']['couponname']; ?>，you will get rebate to your account balance,<?php echo $currency; ?></span>
					</div>
					<div class="field">
						<label>number of goods free of express fee</label>
						<input type="text" size="10" name="farefree" id="team-create-farefree" class="number" value="<?php echo intval($team['farefree']); ?>" maxLength="6" datatype="money" require="true" />
						<span class="inputtip">express fee, number of goods free of express fees:0 meaning express fee needed, 2 meaning express fee exempted with two items bought together</span>
					</div>
					<input type="submit" value="Ok，submit" name="commit" id="leader-submit" class="formbutton" style="margin:10px 0 0 120px;"/>
				</form>
                </div>
            </div>
            <div class="box-bottom"></div>
        </div>
	</div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("manage_footer");?>
