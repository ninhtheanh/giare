<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
<div class="subdashboard" id="dashboard">
  <ul>
    <?php echo mcurrent_order('prepaid'); ?>
  </ul>
</div>
<div id="content" class="coupons-box clear mainwide">
<div class="box clear">
<div class="subbox-top">
  <div class="subhead">
    <h2>Đơn hàng trả tiền trước</h2>
  </div>
</div>
<div class="box-content">
<form method="get">
<table width="100%" border="0" cellspacing="2" cellpadding="0" class="filter-table">
  <tr>
    <td width="9%" align="right"><p style="margin:5px 0;"><strong>Order No.:</strong></p></td>
    <td width="12%"><input type="text" name="id" value="<?php echo htmlspecialchars($id); ?>" class="h-input"/></td>
    <td width="2%" align="right" style="padding-left:3px;"><strong>User:</strong></td>
    <td width="10%"><input type="text" name="uemail" class="h-input" value="<?php echo htmlspecialchars($uemail); ?>" ></td>
    <td width="4%" align="right" nowrap="nowrap"><strong>Deal No.</strong></td>
    <td width="10%"><input type="text" name="team_id" class="h-input number" value="<?php echo $team_id; ?>" ></td>
    <td width="2%" align="right" style="padding-left:3px;"><strong>TP:</strong></td>
    <td width="10%"><select name="city_id" class="h-input" require="true" onchange="this.form.submit();">
        <option value='0'>--Chon--</option>
        <?php echo Utility::Option(Utility::OptionArray($allcities,'id','name'),$city_id); ?>
      </select></td>
    <td width="7%" align="right"><?php if($city_id){?><strong>Quận/Huyện:</strong></td>
    <td width="34%"><select name="dist_id" onchange="this.form.submit();" class="h-input" require="true">
        <option value='0'>--Chon--</option>
        <?php echo Utility::Option(Utility::OptionArray(option_district('VN', $city_id, false, true),'dist_id','dist_name'),$dist_id); ?>
      </select>
      <?php }?></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><p style="margin:5px 0;"><strong>Order time:</strong></p></td>
    <td><input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="cbday" value="<?php echo $cbday; ?>" /></td>
    <td align="center">-</td>
    <td><input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="ceday" value="<?php echo $ceday; ?>" /></td>
    <td align="right" nowrap="nowrap" style="padding-left:3px;"><strong>Mobile:</strong></td>
    <td><input type="text" class="h-input" name="mobile" value="<?php echo $mobile; ?>" /></td>
    <td style="padding-left:10px;" colspan="4"><p style="margin:5px 0;"> Payment
        <select name="payment_id" id="payment_id" class="h-input" require="true">
                            <option value='0'>--Chon--</option>
                            <?php echo LoadPaymentMethod(); ?>
                            </select> 
                            <script type="text/javascript">document.getElementById('payment_id').value = '<?php echo $payment_id; ?>'</script>
        <input type="submit" value="Lọc dữ liệu" class="formbutton"  style="padding:3px 6px;"/>
      </p></td>
  </tr>
</table>
<form>
<div class="sect">
  <table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
    <tr>
      <th width="100">ID</th>
      <th width="350">Thông tin thanh toán</th>
      <th width="350">Thông tin vận chuyển</th>
      <th width="60" nowrap>Thành tiền</th>
      <th width="40" nowrap>&nbsp;</th>
    </tr>
    <?php if(is_array($orders)){foreach($orders AS $index=>$one) { ?>
    <tr  style="background-color:#<?php echo getStatusColor($one['state']); ?>" id="order-list-id-<?php echo $one['id']; ?>">
      <td>Deal: <strong><?php echo $one['team_id']; ?>&nbsp;
      (
      <a class="deal-title" href="/<?php echo $city['slug']; ?>/<?php echo seo_url($teams[$one['team_id']]['short_title'],$one['team_id'],$url_suffix); ?>" target="_blank"><?php echo $teams[$one['team_id']]['short_title']; ?>
      <?php echo showColorSize($one); ?>
      )
      </a></strong><br />Số đ.hàng: <a href="/backend/order/orderedit.php?id=<?php echo $one['id']; ?>&redirect=<?php echo $_SERVER['REQUEST_URI']; ?>" title="Sửa thông tin đơn hàng"><strong><?php echo $one['id']; ?></strong></a><br />
        <span style="white-space:nowrap">Ngày đặt: <?php echo date('Y-m-d H:i:s',$one['create_time']);; ?></span><br /><span style="white-space:nowrap">Trạng thái: <?php echo getStatusName($one['state']); ?></span></td>
      <td>Họ tên: <a href="/ajax/manage.php?action=userview&id=<?php echo $one['user_id']; ?>" class="ajaxlink"><strong><?php echo $one['realname']; ?></strong></a><br />
      
		<?php 
        	$note_address = "";$note_baddress="";
            if($one['note_address']!=''){
                $note_address = htmlspecialchars($one['note_address']).", ";
            }
            $one['billing_address'] = $note_address.htmlspecialchars($one['address']);
            if(ward_name($one['dist_id'],$one['ward_id'])){
                $wardname = ward_name($one['dist_id'],$one['ward_id']);
                $one['billing_address'] .=", ".strip_input($wardname['ward_name']);
            }
            if(ename_dist($one['dist_id'])){
                $dists = ename_dist($one['dist_id']);
                $one['billing_address'] .=", ".strip_input($dists['dist_name']);		
            }
            if(id_city($one['city_id'])){
                $citys = id_city($one['city_id']);
                $one['billing_address'] .=", ".strip_input($citys['name']);		
            }
            
            
            if($one['bnote_address']!=''){
                $note_address = htmlspecialchars($one['bnote_address']).", ";
            }
            $one['shipping_address'] = $note_address.htmlspecialchars($one['baddress']);
            if(ward_name($one['bdist_id'],$one['bward_id'])){
                $bwardname = ward_name($one['bdist_id'],$one['bward_id']);
                $one['shipping_address'] .=", ".strip_input($bwardname['ward_name']);
            }
            if(ename_dist($one['bdist_id'])){
                $bdists = ename_dist($one['bdist_id']);
                $one['shipping_address'] .=", ".strip_input($bdists['dist_name']);		
            }
            if(id_city($one['bcity_id'])){
                $bcitys = id_city($one['bcity_id']);
                $one['shipping_address'] .=", ".strip_input($bcitys['name']);		
            }
        
      ; ?>      
      
        Địa chỉ: <?php echo $one['billing_address']; ?><br />ĐT: <?php echo $one['mobile']; ?><br /><span style="color:#c40000"><strong><?php echo GetPaymentName($one['payment_id']); ?></strong></span></td>
      <td>Họ tên: <a href="/ajax/manage.php?action=userview&id=<?php echo $one['user_id']; ?>" class="ajaxlink"><strong><?php echo $one['brealname']; ?></strong></a><br />
        Địa chỉ: <?php echo $one['shipping_address']; ?><br />Điện thoại: <?php echo $one['bmobile']; ?><br /><span style="color:#c40000"><strong><?php echo GetShippingName($one['shipping_id']); ?></strong></span></td>
      <td align="right" style="color:#FF0000"><strong><?php echo print_price(moneyit(TotalOrder($one['id']))); ?></strong></td>
      <td align="center"><a href="/ajax/manage.php?action=orderview&id=<?php echo $one['id']; ?>" class="ajaxlink"><strong>Detail</strong></a><br /><a href="/ajax/manage.php?action=orderconfirm&id=<?php echo $one['id']; ?>" class="ajaxlink"><strong>Confirm</strong></a><br /><a href="/ajax/manage.php?action=ordercancel&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to cancel it?"><strong>Cancel</strong></a></td>
    </tr>
    <?php }}?>
    <tr>
      <td colspan="9" align="right"><strong><?php echo $total_voucher; ?> voucher</strong></td>
    </tr>
    <tr>
      <td colspan="9"><?php echo $pagestring; ?>
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
