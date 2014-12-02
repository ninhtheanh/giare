<?php include template("manage_header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_order('canceled'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"> <div class="subhead">
                    <h2>Đơn hàng đã hủy </h2>
				</div></div>
            <div class="box-content">
               <form method="get" id="target">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="filter-table">
                  <tr>
                    <td align="left" colspan="2" style="padding-top:3px; padding-left:3px;"><strong>Số HĐ</strong>
                      <input type="text" name="id" value="<?php echo $id; ?>" class="h-input"/>
                      &nbsp;&nbsp;<strong>Số Deal</strong>
                      <input type="text" name="team_id" class="h-input number" value="<?php echo $team_id; ?>" />
                      &nbsp;&nbsp;<strong>User</strong>
                      <input type="text" name="uemail" class="h-input" value="<?php echo htmlspecialchars($uemail); ?>" />
                      &nbsp;&nbsp;<strong>ĐTDĐ</strong>
                      <input type="text" class="h-input" name="mobile" value="<?php echo $mobile; ?>" />
                      &nbsp;&nbsp;<strong>TP</strong>                      <select name="city_id" class="h-input" require="true" onchange="$('#target').submit();">
                        <option value='0'>--Chon--</option>
                          <?php echo Utility::Option(Utility::OptionArray($allcities,'id','name'),$city_id); ?>
                        
                      </select>                   </td>
                  </tr>
                     <tr><td align="left" valign="top" style="padding-top:3px; padding-left:3px; padding-bottom:7px;">
                      <strong>Order time:</strong><input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="cbday" value="<?php echo $cbday; ?>" /> - <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="ceday" value="<?php echo $ceday; ?>" />&nbsp;Mobile<input type="text" class="h-input" name="mobile" value="<?php echo $mobile; ?>" />&nbsp;&nbsp;<?php if($login_user_id==1){?>NV Dealsoc<select name="duser" class="h-input" require="true" onchange="$('#target').submit();" id="duser"><option value='0'>--Chon--</option>
                      <?php 
                      	$rs = DB::GetQueryResult("SELECT DISTINCT `user` FROM `order_history`",false);
                        foreach($rs as $k =>$v){
                        	$option .="<option value='".$v['user']."'>".$v['user']."</option>";
                        }
                      ; ?><?php echo $option; ?><script type="text/javascript">$("#duser").val("<?php echo $demail; ?>")</script></select>&nbsp;&nbsp;<?php }?><input type="submit" value=" Lọc dữ liệu " class="formbutton"  style="padding:3px 6px;"/></td></tr>
                </table>
              </form>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="20">ID</th><th width="400">deal</th><th width="340">user</th><th width="20" nowrap>Q.ty</th><th width="60" nowrap>Total (<span class="money"><?php echo $currency; ?></span>)</th><th width="80" nowrap>State</th><th width="50">Operation</th></tr>
					<?php if(is_array($orders)){foreach($orders AS $index=>$one) { ?>
					<tr style="background-color:#<?php echo getStatusColor($one['state']); ?>" id="order-list-id-<?php echo $one['id']; ?>">
						<td><?php echo $one['id']; ?></td>
						<td><?php echo $one['team_id']; ?>&nbsp;(<a class="deal-title" href="/team.php?id=<?php echo $one['team_id']; ?>" target="_blank"><?php echo $teams[$one['team_id']]['product']; ?></a>
                        <?php echo showColorSize($one); ?>
                        )</td>
						<td><!--<a href="/ajax/manage.php?action=userview&id=<?php echo $one['user_id']; ?>" class="ajaxlink">--><?php echo $one['realname']; ?><br /><!--<?php echo $one['mobile']; ?></a><br/>--><b style="color:#FA6D18"><?php echo $one['address']; ?>, <?php if(ename_dist($one['dist_id'])){?><?php $dists = ename_dist($one['dist_id']); ?><?php echo $dists['dist_name']; ?><?php }?></b><?php 
                	$ds = DB::GetQueryResult("SELECT `date` FROM order_history WHERE order_id=".$one['id'])  ;     
                ; ?>
                	<?php if($ds){?><br /><strong><?php echo $ds['date']; ?></strong><?php }?>        
                        <?php if(Utility::IsMobile($users[$one['user_id']]['mobile'])){?>&nbsp;&raquo;&nbsp;<a href="/ajax/misc.php?action=sms&v=<?php echo $users[$one['user_id']]['mobile']; ?>" class="ajaxlink">SMS</a><?php }?></td>
						<td><?php echo $one['quantity']; ?></td>
						<td><?php echo print_price(moneyit($one['origin'])); ?></td>
                        <td><strong><?php echo getStatusName($one['state']); ?></strong></td>
						<td class="op"><a href="/ajax/manage.php?action=orderview&id=<?php echo $one['id']; ?>" class="ajaxlink">detail</a> | <a href="/ajax/manage.php?action=orderconfirm&id=<?php echo $one['id']; ?>" class="ajaxlink">confirm</a> | <a href="/ajax/manage.php?action=orderoffice&id=<?php echo $one['id']; ?>" class="ajaxlink">Office</td>
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
