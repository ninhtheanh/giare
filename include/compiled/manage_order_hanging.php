<?php include template("manage_header");?>

<div id="bdw" class="bdw">
  <div id="bd" class="cf">
    <div id="coupons">
      <div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_order('office'); ?>
        </ul>
      </div>
      <div id="content" class="coupons-box clear mainwide">
        <div class="box clear">
          <div class="subbox-top"><div class="subhead">
              <h2>Đơn hàng tạm hoản nhận Voucher</h2>
              <ul class="filter"><?php echo current_manageorder_confirm('hanging', 0); ?></ul>
            </div></div>
          <div class="box-content">
              <form method="get" id="target">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="filter-table">
                  <tr>
                    <td align="left" colspan="2" style="padding-top:3px; padding-left:3px;"><p>Số HĐ<input type="text" name="id" value="<?php echo $id; ?>" class="h-input"/>&nbsp;&nbsp;Số Deal<input type="text" name="team_id" class="h-input number" value="<?php echo $team_id; ?>" />&nbsp;&nbsp;User<input type="text" name="uemail" class="h-input" value="<?php echo htmlspecialchars($uemail); ?>" />&nbsp;&nbsp;ĐTDĐ<input type="text" class="h-input" name="mobile" value="<?php echo $mobile; ?>" />&nbsp;&nbsp;TP
                        <select name="city_id" class="h-input" require="true" onchange="$('#target').submit();">
                          <option value='0'>--Chon--</option>
                          <?php echo Utility::Option(Utility::OptionArray($allcities,'id','name'),$city_id); ?>
                        </select>
                      </p>
                     </td><td align="left" valign="top" style="padding-top:5px; padding-bottom:10px;"><input type="submit" value="Lọc dữ liệu" class="formbutton"  style="padding:3px 6px;"/></td></tr>
                </table>
              </form>
            <script language="javascript">
				function checkForm()
				{					
					if(document.getElementById('shipper_id').value==0){
						alert('Chưa chọn nhân viên giao hàng!');
						return false;
					}
					ischecked = false;
					for(i=1;i<document.f_delivery.orderid.length;i++){
						obj=document.getElementById(document.f_delivery.orderid[i].value);
						if(obj.checked==true){
							ischecked=true;
							break;
						}
					}		
					if(!ischecked){
						alert("Select one or more items...");
						return false;
					}
					if(!confirm('Are you want delivery??')){			
						return false;
					}
					return true;
				}
				</script>
            <div class="sect">
              <form id="fde" name="f_delivery" method="post" action="./office.php" onsubmit="return checkForm()" target="_blank">
                <input type="hidden" name="team_id" value="<?php echo $team_id; ?>" >
                <input type="hidden" name="ward_id" value="<?php echo $list_ward_id; ?>" >
                <input type="hidden" name="dist_id" value="<?php echo $list_dist_id; ?>" >
                <input type="hidden" name="city_id" value="<?php echo $city_id; ?>" >
                <input type="hidden" name="id" value="<?php echo $id; ?>" >
                <input type="hidden" name="uemail" value="<?php echo $uemail; ?>" >
                <input type="hidden" name="orderid[0]" id="orderid" value="nothing">
                <div style="background:#FFFFCC; padding-bottom:10px; padding-top:10px; padding-left:10px;"> Chọn đơn hàng cần bàn giao, rồi chọn NV giao hàng :
                  <select name="shipper_id" id="shipper_id" class="h-input" require="true">
                    <option value='0'>--Chon--</option>
                    <?php echo Utility::Option(Utility::OptionArray($shippers,'id','shipper_name'),$shipper_id); ?>
                  </select>
                  &nbsp;
                  <input type="submit" value="Bàn giao" class="formbutton" name="delivery" style="padding:3px 6px;" />
                  &nbsp;
                  <i>NV chưa quyết toán sẽ không có tên trong danh sách</i>
                </div>
                <table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
                  <tr>
                    <th width="20">&nbsp;&nbsp;
                      <input type="checkbox" name="checkall" id="checkall" onclick="jqCheckAll( this.id, 'myinput' )" /></th>
                    <th width="250">Deal</th>
                    <th width="340">User</th>
                    <th width="20" nowrap>Q.ty</th>
                    <th width="60" nowrap>Total (<span class="money"><?php echo $currency; ?></span>)</th>
                   <!-- <th width="60" nowrap>Paid (<span class="money"><?php echo $currency; ?></span>)</th>--><th width="60" nowrap>Unpaid (<span class="money"><?php echo $currency; ?></span>)</th>
                    <!--<th width="160" nowrap>express</th>-->
                    <th width="100" nowrap>Task</th>
                    <th width="80" nowrap>Ngày giao</th>
                  </tr>
                  <?php if(is_array($orders)){foreach($orders AS $index=>$one) { ?>
                  <tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>">
                    <td align="center"><input type="hidden" name="orderid[]" id="orderid" value="<?php echo $one['id']; ?>">
                      <input name="myinput[]" id="<?php echo $one['id']; ?>" value="<?php echo $one['id']; ?>" type="checkbox">
                      <?php echo $one['id']; ?></td>
                    <td><?php echo $one['team_id']; ?>&nbsp;(<a class="deal-title" href="/team.php?id=<?php echo $one['team_id']; ?>" target="_blank"><?php echo $teams[$one['team_id']]['short_title']; ?></a>)</td>
                    <td><!--<a href="/ajax/manage.php?action=userview&id=<?php echo $one['user_id']; ?>" class="ajaxlink">--><a href="/backend/order/search.php?mobile=<?php echo $one['mobile']; ?>&city_id=11" target="_blank" ><?php echo $one['realname']; ?></a> <!-- <?php echo $one['mobile']; ?></a>--><br/>
                      <b style="color:#FA6D18">
                      <?php if ($one['note_address']!=''){$note_address = $one['note_address'].", ";}else{$note_address="";}; ?>
                      <?php echo $note_address; ?><?php echo $one['address']; ?>,
                      <?php if(wardname($one['dist_id'],$one['ward_id'])){?>
                      <?php $wardname = wardname($one['dist_id'],$one['ward_id']); ?>
                      <?php echo $wardname['ward_name']; ?>,
                      <?php }?>
                      <?php if(ename_dist($one['dist_id'])){?>
                      <?php $dists = ename_dist($one['dist_id']); ?>
                      <?php echo $dists['dist_name']; ?>
                      <?php }?>
                      </b>&nbsp;
                      <?php 
                            	$list = check_address_list($one['dist_id'], $one['ward_id'], $one['address']);
                                if($list['id']>0){
                                	$img="<img src=\"/static/css/images/tick.png\" alt=\"Địa chỉ đã được duyệt\" align=\"absmiddle\" />";
                                 }else{$img="<img src=\"/static/css/images/no.png\" alt=\"Địa chỉ chưa duyệt\" />";}; ?>
                      <?php echo $img; ?><br />
					  <?php echo date('Y-m-d H:i:s',$one['create_time']);; ?>
                      <?php if(Utility::IsMobile($users[$one['user_id']]['mobile'])){?>
                      &nbsp;&raquo;&nbsp;<a href="/ajax/misc.php?action=sms&v=<?php echo $users[$one['user_id']]['mobile']; ?>" class="ajaxlink">SMS</a>
                      <?php }?></td>
                    <td><?php echo $one['quantity']; ?></td>
                    <td align="right"><strong><?php echo print_price(moneyit($one['origin'])); ?></strong></td>
                    <!--<td align="right"><?php echo print_price(moneyit($one['money'])); ?></td>-->
					<td align="right"><?php echo print_price(moneyit($one['origin']-$one['money'])); ?></td>
                    <!--<td><?php echo $option_service[$one['service']]; ?></td>-->
                     <td class="op"> <!--<a href="/ajax/manage.php?action=orderedit&id=<?php echo $one['id']; ?>" class="ajaxlink">edit</a> |--> <a href="/ajax/manage.php?action=orderedit&id=<?php echo $one['id']; ?>" class="ajaxlink">edit</a> | <a href="/ajax/manage.php?action=orderview&id=<?php echo $one['id']; ?>" class="ajaxlink">detail</a> | <a href="/ajax/manage.php?action=orderconfirm&id=<?php echo $one['id']; ?>" class="ajaxlink">confirm</a> | <a href="/ajax/manage.php?action=ordercancel&id=<?php echo $one['id']; ?>" class="ajaxlink">cancel</a></td>
                    <td width="80" nowrap>
                    	<?php $date = DB::GetQueryResult("SELECT date_received FROM order_hanging WHERE order_id=".$one['id']); ?>
                        <strong><?php echo $date['date_received']; ?></strong>
                    </td>
                  </tr>
                  <?php }}?>
                  <tr>
                    <td colspan="9" align="right"><strong><?php echo $total_voucher; ?> voucher</strong></td>
                  </tr>
                  <tr>
                    <td colspan="9"><?php echo $pagestring; ?>
                  </tr>
                </table>
              </form>
            </div>
          </div>
          <div class="box-bottom"></div>
        </div>
      </div>
    </div>
  </div>
  <!-- bd end -->
</div>
<!-- bdw end -->
<?php include template("manage_footer");?>
