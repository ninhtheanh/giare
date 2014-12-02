<?php include template("manage_header");?>

<div id="bdw" class="bdw">
  <div id="bd" class="cf">
    <div id="coupons">
      <div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_order('confirmed'); ?>
        </ul>
      </div>
      <div id="content" class="coupons-box clear mainwide">
        <div class="box clear">
          <div class="subbox-top"><div class="subhead">
              <h2>Đơn hàng đã xác nhận</h2>
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
                        
                      </select>                      </td></tr>
                      <tr><td align="left" nowrap="nowrap"><strong>Ngày đặt hàng</strong>&nbsp;&nbsp;<input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="cbday" value="<?php echo $cbday; ?>" /> - <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="ceday" value="<?php echo $ceday; ?>" /></td>
                  </tr>
                     <tr><td align="left" valign="top" style="padding-top:3px; padding-left:3px; padding-bottom:7px;">                    
                      <?php if($city_id){?>
                      <strong>Quận/Huyện </strong>
                      <select name="dist_id[]" class="h-input" require="true" multiple="multiple" style="height:100px; width:200px;">
                        <?php echo option_dist($dist_id,$city_id,$team_id,$is_home,$cbday,$ceday); ?>
                      </select>
                      <?php }?>
&nbsp;&nbsp;
                      <?php if($city_id){?>
                      <strong>Phường/Xã</strong> 
                     <select name="ward_id[]" class="h-input" require="true" multiple="multiple" style="height:100px; width:300px;">
                       <?php echo option_ward($ward_id,$dist_id, $city_id,$team_id,$is_home); ?>
                     </select>
                      <?php }?>
&nbsp;&nbsp;<strong>Đường</strong>
<select name="street_name[]" multiple="multiple" style="height:100px; width:250px;">
                        <?php echo option_street($street_name, $dist_id, $ward_id, $team_id,$is_home); ?>
</select>
                      </strong></td>
                  </tr>
                  <tr><td align="left" valign="top" style="padding-top:5px; padding-bottom:10px;padding-left:10px;"><strong>Trạng thái </strong><select name="state" id="state" class="h-input" require="true">
                    <option value='all'>--Any state--</option>
                    <option value='confirmed'>Confirmed</option>
                    <option value='pending'>Pending</option>
                  </select>
                  <script type="text/javascript">$("#state").val("<?php echo $state; ?>");</script>
                  <select name="delivery_properties" id="delivery_properties" class="h-input" require="true">
                    <option value='all'>--All--</option>
                    <option value='0'>Giao voucher</option>
                    <option value='1'>Giao sản phẩm</option>
                  </select>
                  <script type="text/javascript">$("#delivery_properties").val("<?php echo $delivery_properties; ?>");</script><strong>Payment</strong>
                            <select name="payment_id" id="payment_id" class="h-input" require="true">
                            <option value='0'>--Chon--</option>
                            <?php echo LoadPaymentMethod(); ?>
                            </select> 
                            <script type="text/javascript">document.getElementById('payment_id').value = '<?php echo $payment_id; ?>'</script><strong>SL ĐH bàn giao: </strong><select name="slbg" id="slbg" class="h-input" require="true" onchange="$('#target').submit();">
                    <option value='160'>160</option>
                    <option value='140'>140</option>
                    <option value='120'>120</option>
                    <option value='100'>100</option>
                    <option value='80'>80</option>
                    <option value='60'>60</option>
                    <option value='40'>40</option>
                  </select><script type="text/javascript">$("#slbg").val(<?php echo $slbg_filter; ?>)</script>
                  &nbsp;<input type="checkbox" id="is_home" name="is_home" value="1" <?php echo $checked; ?> />Nhà riêng&nbsp;<input type="submit" value=" Lọc dữ liệu " class="formbutton"  style="padding:3px 6px;"/></td></tr>
				  <tr bgcolor="#ffffff"><td><table><tr><td><strong>Chú thích mã màu:</strong></td><td valign="middle"><div style="width:13px;height:13px;background-color:#E0D6FF;float:left;border:1px solid #cccccc"></div>&nbsp;Đã xác nhận</td><td valign="middle"><div style="width:13px;height:13px;background-color:#FACDD9;float:left;border:1px solid #cccccc"></div>&nbsp;Đã chuyển tiếp</td><td><strong>Sort by: </strong><select name="sortby" id="sortby" class="h-input" require="true" onchange="$('#target').submit();">
                    <option value='0'>Theo tuyến đường</option>
                    <option value='1'>Cũ --> Mới</option>
                  </select><script type="text/javascript">$("#sortby").val(<?php echo $sort; ?>)</script></td></tr></table>
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
              <form id="fde" name="f_delivery" method="post" action="./confirmed.php" onsubmit="return checkForm()" target="_blank">
                <input type="hidden" name="team_id" value="<?php echo $team_id; ?>" >
                <input type="hidden" name="ward_id" value="<?php echo $list_ward_id; ?>" >
                <input type="hidden" name="dist_id" value="<?php echo $list_dist_id; ?>" >
                <input type="hidden" name="city_id" value="<?php echo $city_id; ?>" >
                <input type="hidden" name="id" value="<?php echo $id; ?>" >
                <input type="hidden" name="uemail" value="<?php echo $uemail; ?>" >
                <input type="hidden" name="orderid[0]" id="orderid" value="nothing">
                <?php if($city_id!=11 || ($city_id==11 && $dist_id)){?>
                <div style="margin:10px;padding:10px;background:#FFFFCC">Chọn đơn hàng cần bàn giao, rồi chọn NV giao hàng:
                  <select name="shipper_id" id="shipper_id" class="h-input" require="true">
                    <option value='0'>--Chon--</option>
                    <?php echo Utility::Option(Utility::OptionArray($shippers,'id','shipper_name'),$shipper_id); ?>
                  </select>
                  
                  &nbsp;<input type="submit" value=" Bàn giao " class="formbutton" name="delivery" style="padding:3px 6px;" />
                  <i>NV chưa quyết toán sẽ không có tên trong danh sách</i>
                  
                </div>
                <?php }?>
                <table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
                  <tr>
                    <th width="20">&nbsp;&nbsp;
                      <input type="checkbox" name="checkall" id="checkall" onclick="jqCheckAll( this.id, 'myinput' )" /></th>
                    <th width="400">Deal</th>
                    <th width="340">User</th>
                    <th width="20" nowrap>Q.ty</th>
                    <th width="60" nowrap>Total (<span class="money"><?php echo $currency; ?></span>)</th>
                    <th width="120" nowrap>Ghi chú</th>
                    <!--<th width="160" nowrap>express</th>-->
                    <th width="50" nowrap>Task</th>
                  </tr>
                  <?php if(is_array($orders)){foreach($orders AS $index=>$one) { ?>
                  <tr style="background-color:#<?php echo getStatusColor($one['state']); ?>" id="order-list-id-<?php echo $one['id']; ?>">
                    <td align="center"><input type="hidden" name="orderid[]" id="orderid" value="<?php echo $one['id']; ?>">
                      <input name="myinput[]" id="<?php echo $one['id']; ?>" value="<?php echo $one['id']; ?>" type="checkbox">
                      <?php echo $one['id']; ?></td>
                    <td><?php echo $one['team_id']; ?>&nbsp;(<a class="deal-title" href="/<?php echo $city['slug']; ?>/<?php echo seo_url($teams[$one['team_id']]['short_title'],$one['team_id'],$url_suffix); ?>" target="_blank"><?php echo $teams[$one['team_id']]['short_title']; ?></a>
                    <?php echo showColorSize($one); ?>
                    )
                    <br /> <?php if($one['payment_id']==5 && (int)$one['transaction_id_nl']>0){?>
      Mã GD NL: <span style="color:#c40000"><strong><?php echo $one['transaction_id_nl']; ?></strong></span>
     <?php }?><br /><?php if($teams[$one['team_id']]['delivery_properties']==1){?><img src="/static/img/icon_product.gif" /><?php } else { ?><img src="/static/img/icon_voucher.gif" /><?php }?></td>
                    <td>
                   <a href="/backend/order/search.php?mobile=<?php echo $one['mobile']; ?>&city_id=11" target="_blank" ><?php echo $one['realname']; ?></a><br />
                      <!--<?php echo $one['mobile']; ?></a><br/> -->
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
                            	$total_money += $one['origin'];
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
                    <td align="right"><strong><?php echo print_price(moneyit($one['origin']+$one['shipping_cost']+$one['payment_cost'])); ?><?php if($one['money']>0 || $one['credit']>0){?><br />Đã TT: <?php echo print_price(moneyit($one['money'])); ?><?php echo print_price(moneyit($one['credit'])); ?><br />Còn lại: <?php echo print_price(moneyit($one['origin']+$one['shipping_cost']+$one['payment_cost']-$one['money']-$one['credit'])); ?><?php }?></strong></td>
                    <td align="left"><?php echo cut_string($one['remark'],50,'...'); ?><br /><i><?php echo $one['notes']; ?></i></td>
                    <!--<td><?php echo $option_service[$one['service']]; ?></td>-->
                    <td class="op"> <!--<a href="/ajax/manage.php?action=orderedit&id=<?php echo $one['id']; ?>" class="ajaxlink">edit</a> | --><a href="/ajax/manage.php?action=orderview&id=<?php echo $one['id']; ?>" class="ajaxlink">detail</a> | <a href="/ajax/manage.php?action=ordercancel&id=<?php echo $one['id']; ?>" class="ajaxlink">cancel</a>| <a href="/ajax/manage.php?action=orderedit&id=<?php echo $one['id']; ?>" class="ajaxlink">edit</a></td>
                  </tr>
                  <?php }}?>
                  <tr>
                    <td colspan="9" align="right"><strong><?php echo $total_voucher; ?> voucher - <?php echo print_price(moneyit($total_money)); ?> <?php echo $currency; ?></strong></td>
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
