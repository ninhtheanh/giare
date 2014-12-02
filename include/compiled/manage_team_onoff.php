<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_team('OnOff'); ?></ul>
        
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="box-top"></div>
            <div class="box-content">
               <div class="head">
                    <h2>On/Off deal</h2>
                    <table width="100%" border="0">
  <tr>
    <td><ul class="filter" style="padding:0px; margin:0px;">
						<li><form method="get">Deal<input type="text" name="key" class="h-input" value="<?php echo htmlspecialchars($key); ?>" ></form></li>
						<li><form method="get">ID<input type="text"name="id" id="team_id" class="f-input" value="" style="height:14px;" />&nbsp;Sale<select name="sale" id="sale" style="width:160px;" datatype="require" require="require" onchange="this.form.submit()"><option value="0">---Chọn---</option><?php echo option_business_staff($team['sale']); ?></select></form>
                        <script type="text/javascript" language="javascript">$("#team_id").val("<?php echo $team_id; ?>");$("#sale").val("<?php echo $sale; ?>");</script></li>
						
					</ul></td>
    <td><ul><li style="padding-left:20px;">- On/Off deal được sử dụng cho những deal chưa có voucher, đã hết hạn giao hàng, ....</li><li style="padding-left:20px;">- Deal đã Off sẻ không có ĐH trong danh sách đã xác nhận</li></ul></td>
  </tr>
</table>

                    
					
				</div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="40">ID</th>
					<th width="400">Deal name</th>
					<th width="80" nowrap>Category</th>
					<th width="100">Date</th>
					<th width="50">Deal tipped</th>
					<th width="60" nowrap>Price (<span class="money"><?php echo $currency; ?></span>)</th>
					<th width="100">Operation</th></tr>
					<?php if(is_array($teams)){foreach($teams AS $index=>$one) { ?>
					<?php $oldstate = $one['state']; ?>
					<?php $one['state'] = team_state($one); ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>">
						<td><?php echo $one['id']; ?></a></td>
						<td>
							<?php echo $one['team_type']=='normal' ? '[Deal]' : ''; ?>
							<?php echo $one['team_type']=='seconds' ? '[Deal]' : ''; ?>
							<?php echo $one['team_type']=='goods' ? '[Goods]' : ''; ?>
							<a class="deal-title" href="/team.php?id=<?php echo $one['id']; ?>" target="_blank"><?php echo $one['masp']; ?>: <?php echo $one['product']; ?></a>
						</td>
						<td nowrap><strong><?php if($cities[$one['city_id']]['name']){?><?php echo $cities[$one['city_id']]['name']; ?><?php } else { ?>Toàn Quốc<?php }?></strong><br/><?php echo $groups[$one['group_id']]['name']; ?></td>
						<td nowrap><?php echo date('Y-m-d',$one['begin_time']); ?><br/><?php echo date('Y-m-d',$one['end_time']); ?></td>
						<td nowrap>
                        <?php 
                        	$total_qty = DB::GetQueryResult("SELECT sum(quantity) as totalQty FROM `order` WHERE team_id=".$one['id']);
                            $total_qty_confirm = DB::GetQueryResult("SELECT sum(quantity) as totalQty_confirm FROM `order` WHERE team_id=".$one['id']." AND state IN ('confirmed', 'pending')");
                            $total_qty_pay = DB::GetQueryResult("SELECT sum(quantity_successful) as totalQty_pay FROM `order` WHERE team_id=".$one['id']." AND state='pay'");
                            $total_qty_delivered = DB::GetQueryResult("SELECT sum(quantity) as totalQty_delivered FROM `order` WHERE team_id=".$one['id']." AND state='delivered'");
                            
                            $total_qty_cancel = DB::GetQueryResult("SELECT sum(quantity) as totalQty_cancel FROM `order` WHERE team_id=".$one['id']." AND state IN ('canceled', 'dealsoc_cancel')");
                            $total_qty_unpay = DB::GetQueryResult("SELECT sum(quantity) as totalQty_unpay FROM `order` WHERE team_id=".$one['id']." AND state='unpay'");
                        ; ?>
                        <?php echo $one['now_number']; ?>/<?php echo $one['min_number']; ?><br /><strong><?php echo $total_qty['totalqty']; ?>/<?php echo intval($total_qty_pay['totalqty_pay']); ?>/<?php echo intval($total_qty_confirm['totalqty_confirm']); ?>/<?php echo intval($total_qty_delivered['totalqty_delivered']); ?>/<?php echo intval($total_qty_cancel['totalqty_cancel']); ?>/<?php echo intval($total_qty_unpay['totalqty_unpay']); ?></strong></td>
					  <td nowrap align="right"><?php echo print_price(moneyit($one['team_price'])); ?><br/><?php echo print_price(moneyit($one['market_price'])); ?></td>
						<td class="op" align="center"><?php if($one['status']=='Y'){?><a href="/ajax/manage.php?action=teamoff&id=<?php echo $one['id']; ?>" class="ajaxlink"><img src="/static/css/images/on.gif" alt="ON" title="ON" border="0" /></a><?php } else { ?><a href="/ajax/manage.php?action=teamon&id=<?php echo $one['id']; ?>" class="ajaxlink"><img src="/static/css/images/off.gif" alt="OFF" title="OFF" border="0" /></a><?php }?></td>
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
