<?php include template("manage_header");?>
<script language="javascript" type="text/javascript">
jQuery(document).ready(function() {	
	$('#fr').hide(); $('#to').hide();
	if($('#period').val()=='C'){ $('#fr').show(); $('#to').show(); }
	$('#period').change(function() {
  		if($(this).val()=='C'){ $('#fr').show(); $('#to').show(); }else{$('#fr').hide();$('#to').hide();}
	});
});	
</script>

<div id="bdw" class="bdw">
  <div id="bd" class="cf">
    <div id="coupons">
      <div class="subdashboard" id="dashboard">
        <ul>
          <?php echo mcurrent_report('deals'); ?>
        </ul>
      </div>
      <div id="content" class="coupons-box clear mainwide">
        <div class="box clear">
          <div class="box-top"></div>
          <div class="box-content">
            <div class="head">
              <h2>Report by Deals (<?php echo $total; ?>)</h2>
            </div>
            <div class="sect" style="padding:5px; background:#FFFFCC"><form method="get">
<p style="margin:5px 0;"> City
  <select name="creator" id="creator" class="h-input" require="true">
    <option value='0'>--Chon--</option>
    <?php echo Utility::Option(Utility::OptionArray($allcities,'id','name'), $city['id']); ?>
  </select>
  District
  <select name="shipper" id="shipper" class="h-input" require="true">
    <option value='0'>--Chon--</option>
  </select>
  Payment
  <select name="shipper" id="shipper" class="h-input" require="true">
    <option value='0'>--Chon--</option>
  </select>
  Shipping
  <select name="shipper" id="shipper" class="h-input" require="true">
    <option value='0'>--Chon--</option>
  </select>
</p>
<p style="margin:5px 0;">
  <select name="period" id="period" class="h-input" require="true">
    
                        <?php echo Utility::Option(array('A'=>'All Time','D'=>'Today','W'=>'This week','M'=>'This month','Y'=>'This year','C'=>'Custom'), $period); ?>
                        
  </select>
  <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="fr" id="fr" value="<?php echo date('Y-m-d',$fr); ?>" />
  -
  <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="to" id="to" value="<?php echo date('Y-m-d',$to); ?>" />
  <input name="submit" type="submit" value="Lọc dữ liệu" class="formbutton"  style="padding:6px 6px;"/>
</p>
<form></div>
            <div class="sect">
              <table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
                <tr>
                  <th valign="top" align="center">ID</th>
                  <th valign="top" align="center">DealName</th>
                  <th valign="top" align="center">Ngày lên deal</th>
                  <?php if($login_user_id==1 || $login_user_id==78530 || $login_user_id==58094 || $login_user_id==122155){?><th valign="top" align="center">Đã TT</th><?php }?>
                  <th valign="top" align="center">Mới đặt</th>
                  <th valign="top" align="center">Đang ĐT</th>
                  <th valign="top" align="center">Hủy</th>
                  <th valign="top" align="center">DS Hủy</th>
                  <th valign="top" align="center">Đã XN</th>
                  <th valign="top" align="center">Nhan tai VP</th>
                  <th valign="top" align="center">Chờ XNTT</th>
                  <th valign="top" align="center">Đang GH</th>
                  <th valign="top" align="center">BG Tỉnh</th>
                  <th valign="top" align="center">Tạm hoãn</th>
                  <th valign="top" align="center">TT GH</th>
                  <th valign="top" align="center">Ngày hết hạn</th>
                  <th valign="top" align="center">Tổng cộng</th>
                </tr>
                <?php if(is_array($rs)){foreach($rs AS $index=>$one) { ?> 
                <?php 
                    	$w2 = time() - 86400*7*2; $w3 = time() - 86400*7*3; $w4 = time() - 86400*7*4; $w5 = time() - 86400*7*5;
                        if(strtotime($one['begin_time'])<=$w5){
                        	$clr = '#FF0000';
                            if((int)$one['confirm']/(int)$one['total']>0.1){
                            	$bg = '#FF9';
                            }else{
                            	$bg = 'white';
                            }
                        }elseif(strtotime($one['begin_time'])<=$w4){
                        	$clr = '#F90';
                            if((int)$one['confirm']/(int)$one['total']>0.2){
                            	$bg = '#FF9';
                            }else{
                            	$bg = 'white';
                            }
                        }elseif(strtotime($one['begin_time'])<=$w3){
                        	$clr = '#00F';
                            if((int)$one['confirm']/(int)$one['total']>0.3){
                            	$bg = '#FF9';
                            }else{
                            	$bg = 'white';
                            }
                        }elseif(strtotime($one['begin_time'])<=$w2){                        	
                        	$clr = 'green';
                            if((int)$one['confirm']/(int)$one['total']>0.4){
                            	$bg = '#FF9';
                            }else{
                            	$bg = 'white';
                            }
                        }else{
                        	$clr = '#666';
                        }
                    ; ?>
                <tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>" style="background:<?php echo $bg; ?>">
                  <td><strong><?php echo $one['team_id']; ?></strong></td>
                  <td><strong style="font-size:85%;color:<?php echo $clr; ?>"><?php echo cut_string($one['team_name'],44,'...'); ?> </strong> <?php if($one['team_status']=='Hết GH'){?><strong style="font-size:85%;color:#FF0066">(OFF)</strong><?php } else { ?><strong style="font-size:85%;color:#0000FF">(ON)</strong><?php }?></td>
                  <td nowrap="nowrap"><?php echo $one['begin_time']; ?></td>
                  <?php if($login_user_id==1 || $login_user_id==78530 || $login_user_id==58094 || $login_user_id==122155){?><td style="text-align:right; padding-right: 5px; color: red"><a href="http://cheapdeal.vn/backend/order/pay.php?team_id=<?php echo $one['team_id']; ?>" target="_blank" style="color:red"><?php echo $one['pay']; ?></a></td><?php }?>
                  <td style="text-align:right; padding-right: 5px;"><a href="http://cheapdeal.vn/backend/order/index.php?team_id=<?php echo $one['team_id']; ?>" target="_blank"><?php echo $one['unpay']; ?></a></td>
                  <td style="text-align:right; padding-right: 5px;"><?php echo $one['calling']; ?></td>
                  <td style="text-align:right; padding-right: 5px;"><a href="http://cheapdeal.vn/backend/order/canceled.php?team_id=<?php echo $one['team_id']; ?>" target="_blank"><?php echo $one['cancel']; ?></a></td>
                  <td style="text-align:right; padding-right: 5px;"><?php echo $one['dscancel']; ?></td>
                  <td style="text-align:right; padding-right: 5px; color:red"><a href="http://cheapdeal.vn/backend/order/confirmed.php?team_id=<?php echo $one['team_id']; ?>" target="_blank" style="color:red"><?php echo $one['confirm']; ?></a></td>
                  <td style="text-align:right; padding-right: 5px; color:red"><a href="http://cheapdeal.vn/backend/order/office.php?team_id=<?php echo $one['team_id']; ?>" target="_blank" style="color:red"><?php echo $one['confirm_vp']; ?></a></td>
                  <td style="text-align:right; padding-right: 5px; color:red"><a href="http://cheapdeal.vn/backend/order/prepaid.php?team_id=<?php echo $one['team_id']; ?>" target="_blank" style="color:red"><?php echo $one['oncredit']; ?></a></td>
                  <td style="text-align:right; padding-right: 5px;"><?php echo $one['delivery']; ?></td>
                  <td style="text-align:right; padding-right: 5px;"><?php echo $one['transported']; ?></td>
                  <td style="text-align:right; padding-right: 5px;"><a href="http://cheapdeal.vn/backend/order/hanging.php?team_id=<?php echo $one['team_id']; ?>" target="_blank"><?php echo $one['hanging']; ?></a></td><td style="text-align:right; padding-right: 5px;" nowrap="nowrap"><b><?php echo $one['team_status']; ?></b></td><td style="text-align:right; padding-right: 5px;" nowrap="nowrap"><b><?php echo $one['deal_close']; ?></b></td>
                  <td style="text-align:right; padding-right: 5px; color:red"><b><?php echo $one['total']; ?></b></td>
                  
                  <?php $tpay +=$one['pay']; $tunpay +=$one['unpay'];$tcancel +=$one['cancel'];$tdscancel +=$one['dscancel'];$tconfirm +=$one['confirm'];$tconfirm_vp +=$one['confirm_vp'];$tdelivery +=$one['delivery'];$toncredit +=$one['oncredit'];$ttransported +=$one['transported'];$thanging +=$one['hanging'];$ttotal +=$one['total'];; ?> 
                </tr>
                <?php }}?>
                <tr style="color:#c40000">
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><strong>Tổng</strong></td>
                  <td style="text-align:right; padding-right: 5px;"><strong><?php echo $tpay; ?></strong></td>
                  <td style="text-align:right; padding-right: 5px;"><strong><?php echo $tunpay; ?></strong></td>
                  <td style="text-align:right; padding-right: 5px;"><strong></strong></td>
                  <td style="text-align:right; padding-right: 5px;"><strong><?php echo $tcancel; ?></strong></td>
                  <td style="text-align:right; padding-right: 5px;"><strong><?php echo $tdscancel; ?></strong></td>
                  <td style="text-align:right; padding-right: 5px;"><strong><?php echo $tconfirm; ?></strong></td>
                  <td style="text-align:right; padding-right: 5px;"><strong><?php echo $tconfirm_vp; ?></strong></td>
                  <td style="text-align:right; padding-right: 5px;"><strong><?php echo $toncredit; ?></strong></td>
                  <td style="text-align:right; padding-right: 5px;"><strong><?php echo $tdelivery; ?></strong></td>
                  <td style="text-align:right; padding-right: 5px;"><strong><?php echo $ttransported; ?></strong></td>
                  <td style="text-align:right; padding-right: 5px;"><strong><?php echo $thanging; ?></strong></td>
                  <td style="text-align:right; padding-right: 5px;"><strong></strong></td>
                  <td style="text-align:right; padding-right: 5px;"><strong></strong></td>
                  <td style="text-align:right; padding-right: 5px;"><strong><?php echo $ttotal; ?></strong></td>
                </tr>
                <tr>
                  <td colspan="10" align="right"><strong><?php echo $total; ?></strong></td>
                </tr>
                <tr>
                  <td colspan="10"><?php echo $pagestring; ?>
                </tr>
              </table>
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