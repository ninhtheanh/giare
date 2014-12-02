<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_team($selector); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"><div class="subhead">
				<?php if($selector=='failure'){?>
                    <h2>Deal failed</h2>
				<?php } else if($selector=='success') { ?>
                    <h2>Deal tipped</h2>
				<?php } else { ?>
                    <h2>Current deal</h2>
				<?php }?>
                <ul class="filter" style="padding:0px; margin:0px;">
						<li><form method="get">Tên Deal :<input type="text" name="key" style="width:200px;"  class="h-input" value="<?php echo htmlspecialchars($key); ?>" >&nbsp;&nbsp;Sale<select name="sale" id="sale" style="width:160px;" datatype="require" require="require" onchange="this.form.submit()"><option value="0">---Chọn---</option><?php echo option_business_staff($team['sale']); ?></select></form>
                        <script type="text/javascript" language="javascript">$("#team_id").val("<?php echo $team_id; ?>");$("#sale").val("<?php echo $sale; ?>");</script></li>
						<!--ID<input type="text"name="id" id="team_id" class="f-input" value="" style="height:14px;" />&nbsp;-->
					</ul>
				</div></div>
            <div class="box-content">
                
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="40">ID</th><th width="400">deal name</th><th width="80" nowrap>category</th><th width="100">date</th><th width="50">deal tipped</th><th width="60" nowrap>price (<span class="money"><?php echo $currency; ?></span>)</th><th width="100">operation</th></tr>
					<?php if(is_array($teams)){foreach($teams AS $index=>$one) { ?>
					<?php $oldstate = $one['state']; ?>
					<?php $one['state'] = team_state($one); ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>">
						<td><?php echo $one['id']; ?></td>
						<td>
							<?php echo $one['team_type']=='normal' ? '[Deal]' : ''; ?>
							<?php echo $one['team_type']=='seconds' ? '[Deal]' : ''; ?>
							<?php echo $one['team_type']=='goods' ? '[Goods]' : ''; ?>
							<a class="deal-title" href="/team.php?id=<?php echo $one['id']; ?>" target="_blank"><strong><?php echo $one['masp']; ?>: </strong><?php echo $one['product']; ?></strong></a>
						</td>
						<td nowrap><?php echo $cities[$one['city_id']]['name']; ?><br/><?php echo $groups[$one['group_id']]['name']; ?><br /><strong>Số HĐ: <?php echo $one['number_of_contracts']; ?></strong><br /><strong>NV Sale:</strong> <?php echo SaleName($one['sale']); ?><br /><?php if($one['delivery_properties']==1){?>Giao sản phẩm<?php } else { ?>Giao Voucher<?php }?></td>
						<td nowrap><?php echo date('Y-m-d',$one['begin_time']); ?><br/><?php echo date('Y-m-d',$one['end_time']); ?></td>
						<td nowrap><?php $total_qty = DB::GetQueryResult("SELECT sum(quantity) as qty FROM `order` WHERE team_id=".$one['id']); ?><?php echo $total_qty['qty']; ?>/<strong><?php echo $one['now_number']; ?></strong>/<?php echo $one['min_number']; ?></td>
						<td nowrap align="right"><?php echo print_price(moneyit($one['team_price'])); ?><br/><?php echo print_price(moneyit($one['market_price'])); ?></td>
						<td class="op">
                        <a href="/ajax/manage.php?action=teamdetail&id=<?php echo $one['id']; ?>" class="ajaxlink">Detail</a>｜
                        <a href="/backend/team/edit.php?id=<?php echo $one['id']; ?>">Edit</a> | 
                        <a href="/ajax/manage.php?action=teamremove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="Bạn có chắc muốn xóa không?" >Delete</a>
                        </td>
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
