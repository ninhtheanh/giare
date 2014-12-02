<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_order('pay'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"><div class="subhead">
                    <h2>Đơn hàng đã thanh toán</h2>
				</div></div>
            <div class="box-content">
            <table border="0" cellspacing="0" cellpadding="0" class="filter-table">
              <form method="get"><tr>
                <td><strong>Order No.</strong></td>
                <td><input type="text" name="id" value="<?php echo htmlspecialchars($id); ?>" class="h-input"/></td>
                <td><strong>User</strong></td>
                <td><input type="text" name="uemail" class="h-input" value="<?php echo htmlspecialchars($uemail); ?>" ></td>
                <td nowrap="nowrap"><strong>Deal No.</strong></td>
                <td><input type="text" name="team_id" class="h-input number" value="<?php echo $team_id; ?>" ></td>
                <td><strong>TP</strong></td>
                <td><select name="city_id" class="h-input" require="true" onchange="this.form.submit();"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($allcities,'id','name'),$city_id); ?></select></td>
                <td><?php if($city_id){?>&nbsp;Quận/Huyện</td>
                <td><select name="dist_id" onchange="this.form.submit();" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray(option_district('VN', $city_id, false, true),'dist_id','dist_name'),$dist_id); ?></select><?php }?></td>
              </tr>
              <tr>
                <td nowrap="nowrap"><strong>Ordering time</strong></td>
                <td><input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="cbday" value="<?php echo $cbday; ?>" /></td>
                <td>-</td>
                <td><input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="ceday" value="<?php echo $ceday; ?>" /></td>
                <td nowrap="nowrap"><strong>Delivery time</strong></td>
                <td><input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="pbday" value="<?php echo $pbday; ?>" /></td>
                <td>-</td>
                <td><input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="peday" value="<?php echo $peday; ?>" /></td>
                <td nowrap="nowrap">NV giao hàng</td>
                <td><select name="shipper_id" onchange="this.form.submit();" id="shipper_id" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($allshipper,'id','shipper_name'),$shipper_id); ?></select></td>
              </tr>
              <tr><td colspan="10" style="padding-bottom:10px"><input type="submit" value=" Lọc dữ liệu " class="formbutton"  style="padding:3px 6px;"/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Total: <?php echo $count; ?> ĐH</strong></td></tr><form>
            </table>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="20">ID</th><th width="300">deal</th><th width="300">user</th><th width="20" nowrap>q.ty</th><th width="60" nowrap>total (<span class="money"><?php echo $currency; ?></span>)</th><!--<th width="60" nowrap>UnPaid (<span class="money"><?php echo $currency; ?></span>)</th>--><th width="60" nowrap>pay (<span class="money"><?php echo $currency; ?></span>)</th><!--<th width="50" nowrap>express</th>--><th width="50" nowrap>operation</th></tr>
					<?php if(is_array($orders)){foreach($orders AS $index=>$one) { ?>
					<tr style="background-color:#<?php echo getStatusColor($one['state']); ?>" id="order-list-id-<?php echo $one['id']; ?>">
						<td style="color:#fff;background:<?php echo toColor($one['create_time']+$one['user_id']); ?>"><?php echo $one['id']; ?></td>
						<td><?php echo $one['team_id']; ?>&nbsp;(<a class="deal-title" href="/team.php?id=<?php echo $one['team_id']; ?>" target="_blank"><?php echo $teams[$one['team_id']]['short_title']; ?></a>
                        <?php echo showColorSize($one); ?>
                        )</td>
						<td><a href="/backend/order/search.php?mobile=<?php echo $one['mobile']; ?>&city_id=11" target="_blank" ><?php echo $one['realname']; ?></a><br /><b style="color:#FA6D18"><?php if ($one['note_address']!=''){$note_address = $one['note_address'].", ";}else{$note_address="";}; ?><?php echo $note_address; ?><?php echo $one['address']; ?>, <?php if(wardname($one['dist_id'],$one['ward_id'])){?><?php $wardname = wardname($one['dist_id'],$one['ward_id']); ?><?php echo $wardname['ward_name']; ?>,<?php }?><?php if(ename_dist($one['dist_id'])){?><?php $dists = ename_dist($one['dist_id']); ?><?php echo $dists['dist_name']; ?><?php }?></b><br /><?php if(total_order_user($users[$one['user_id']]['id'])>0){?><b style="color:#FA6D18"><?php echo $old_cus='Khách hàng cũ'; ?></b><?php } else { ?><b style="color:#C40000"><?php echo $old_cus='Khách hàng mới'; ?></b><?php }?><?php if(Utility::IsMobile($users[$one['user_id']]['mobile'])){?>&nbsp;&raquo;&nbsp;<a href="/ajax/misc.php?action=sms&v=<?php echo $users[$one['user_id']]['mobile']; ?>" class="ajaxlink">SMS</a><?php }?></td>
						<td align="center"><?php echo $one['quantity']; ?>/<strong><?php echo $one['quantity_successful']; ?></strong></td>
						<td align="right"><?php echo print_price(moneyit($one['origin'])); ?></td>
						<!--<td><?php echo print_price(moneyit($one['credit'])); ?></td>-->
						  <br /><a href="/ajax/manage.php?action=orderpay&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to cancel it?"><strong>Pay</strong></a>
						  <td align="right"><?php if($one['state']=='pay' && $order['money']==0 && $order['credit']==0){?><?php echo print_price(moneyit($one['origin'])); ?> <?php } else { ?><?php echo print_price(moneyit($one['money'])); ?><?php }?></td>
						<!--<td><?php echo $option_delivery[$teams[$one['team_id']]['delivery']]; ?><?php echo $one['express_id']?'Y':''; ?><?php echo $option_service[$one['service']]; ?></td>-->
						<td class="op" nowrap> <!--<a href="/ajax/manage.php?action=orderedit&id=<?php echo $one['id']; ?>" class="ajaxlink">edit</a> |--> <a href="/ajax/manage.php?action=orderview&id=<?php echo $one['id']; ?>" class="ajaxlink">detail</a></td>
					</tr>
					<?php }}?>

                    <tr><td colspan="9" align="right"><strong>SL thực đặt: <?php echo $total_voucher; ?> voucher ------ SL thực giao: <?php echo $total_voucher_successful; ?></strong></td></tr><!--{/if}-->
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
