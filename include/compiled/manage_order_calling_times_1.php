<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_order('unpay'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"><div class="subhead">
                    <h2>Đơn hàng đang đã ĐT lần 2</h2>
                    <ul class="filter"><?php echo current_manageorder('calling_times_1', 0); ?></ul>
				</div></div>
            <div class="box-content">
					<form method="get">
                    	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="filter-table">
                          <tr>
                            <td width="9%" align="right"><p style="margin:5px 0;"><strong>Order No.</strong></p></td><td width="12%"><input type="text" name="id" value="<?php echo htmlspecialchars($id); ?>" class="h-input"/></td><td width="2%" align="right" style="padding-left:3px;"><strong>User</strong></td>
                            <td width="10%"><input type="text" name="uemail" class="h-input" value="<?php echo htmlspecialchars($uemail); ?>" ></td>
                            <td width="4%" align="right" nowrap="nowrap"><strong>Deal No.</strong></td>
                            <td width="10%"><input type="text" name="team_id" class="h-input number" value="<?php echo $team_id; ?>" ></td>
                            <td width="2%" align="right" style="padding-left:3px;"><strong>TP</strong></td>
                            <td width="10%"><select name="city_id" class="h-input" require="true" onchange="this.form.submit();"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($allcities,'id','name'),$city_id); ?></select></td>
                            <td width="7%" align="right"><?php if($city_id){?><strong>Quận/Huyện</strong></td>
                            <td width="34%"><select name="dist_id" onchange="this.form.submit();" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray(option_district('VN', $city_id, false, true),'dist_id','dist_name'),$dist_id); ?></select><?php }?></td>
                          </tr>
                          <tr>
                            <td align="right" nowrap="nowrap"><p style="margin:5px 0;"><strong>Ordering time:</strong></p></td><td><input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="cbday" value="<?php echo $cbday; ?>" /></td><td align="center">-</td><td><input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="ceday" value="<?php echo $ceday; ?>" /></td>
                            <td align="right" nowrap="nowrap" style="padding-left:3px;"><strong>Mobile:</strong></td><td><input type="text" class="h-input" name="mobile" value="<?php echo $mobile; ?>" /></td><td style="padding-left:10px;" colspan="4"><p style="margin:5px 0;"><input type="submit" value=" Lọc dữ liệu " class="formbutton"  style="padding:3px 6px;"/></p></td>
                          </tr>
                        </table>
					<form>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="20">ID</th><th width="400">Deal</th><th width="300">User</th><th width="20" nowrap>Q.ty</th><th width="60" nowrap>Total (<span class="money"><?php echo $currency; ?></span>)</th><th width="110" nowrap>Operation</th></tr>
					<?php if(is_array($orders)){foreach($orders AS $index=>$one) { ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>">
						<td><?php echo $one['id']; ?></td>
						<td><?php echo $one['team_id']; ?>&nbsp;(<a class="deal-title" href="/team.php?id=<?php echo $one['team_id']; ?>" target="_blank"><?php echo $teams[$one['team_id']]['title']; ?></a>)</td>
						<td><a href="/ajax/manage.php?action=userview&id=<?php echo $one['user_id']; ?>" class="ajaxlink"><?php echo $one['realname']; ?><br /><?php echo $one['mobile']; ?></a><br/><b style="color:#FA6D18"><?php if ($one['note_address']!=''){$note_address = $one['note_address'].", ";}else{$note_address="";}; ?><?php echo $note_address; ?><?php echo $one['address']; ?>, <?php if(wardname($one['dist_id'],$one['ward_id'])){?><?php $wardname = wardname($one['dist_id'],$one['ward_id']); ?><?php echo $wardname['ward_name']; ?>,<?php }?> <?php if(ename_dist($one['dist_id'])){?><?php $dists = ename_dist($one['dist_id']); ?><?php echo $dists['dist_name']; ?><?php }?></b>&nbsp;
                        	<?php 
                            	$list = check_address_list($one['dist_id'], $one['ward_id'], $one['address']);
                                if($list['id']>0){
                                	$img="<img src=\"/static/css/images/tick.png\" alt=\"Địa chỉ đã được duyệt\" align=\"absmiddle\" />";
                                 }else{$img="<img src=\"/static/css/images/no.png\" alt=\"Địa chỉ chưa duyệt\" />";}; ?><?php echo $img; ?><br /><?php if(total_order_user($users[$one['user_id']]['id'])>0){?><b style="color:#FA6D18"><?php echo $old_cus='Khách hàng cũ'; ?></b><?php } else { ?><b style="color:#C40000"><?php echo $old_cus='Khách hàng mới'; ?></b><?php }?><?php if(Utility::IsMobile($users[$one['user_id']]['mobile'])){?>&nbsp;&raquo;&nbsp;<a href="/ajax/misc.php?action=sms&v=<?php echo $users[$one['user_id']]['mobile']; ?>" class="ajaxlink">SMS</a><?php }?></td>
						<td><?php echo $one['quantity']; ?></td>
						<td align="right"><strong><?php echo print_price(moneyit($one['origin'])); ?></strong></td>
                        <?php 
                        	$call_id = DB::GetQueryResult("SELECT id FROM order_wait_call WHERE order_id=".$one['id']);
                        ; ?>
						<td align="center"><a href="/ajax/manage.php?action=orderedit&id=<?php echo $one['id']; ?>" class="ajaxlink">Edit</a> | <a href="/ajax/manage.php?action=orderview&id=<?php echo $one['id']; ?>" class="ajaxlink">Detail</a> | <a href="/ajax/manage.php?action=orderconfirm&id=<?php echo $one['id']; ?>" class="ajaxlink">Confirm</a> | <a href="/ajax/manage.php?action=ordercancel&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to cancel it?">Cancel</a> | <a href="/ajax/manage.php?action=ordertransfer&id=<?php echo $one['id']; ?>&transferID=<?php echo $call_id['id']; ?>" class="ajaxlink">Transfer</a> | <a href="/ajax/manage.php?action=orderhanging&id=<?php echo $one['id']; ?>" class="ajaxlink">Tạm hoãn</a></td>
					</tr>
					<?php }}?>
                    <tr><td colspan="9" align="right"><strong><?php echo $total_voucher; ?> voucher</strong></td></tr>
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