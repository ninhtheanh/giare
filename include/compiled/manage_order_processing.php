<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
<div class="subdashboard" id="dashboard">
  <ul>
    <?php echo mcurrent_order('printorderconfirmed'); ?>
  </ul>
</div>
<div id="content" class="coupons-box clear mainwide">
<div class="box clear">
<div class="subbox-top">
  <div class="subhead">
    <h2>Đơn hàng đang xử lý</h2>
  </div>
</div>
<div class="box-content">
<div class="sect">
  <table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
    <tr>
      <th width="100">ID</th>
      <th width="350">Thông tin thanh toán</th>
      <th width="350">Thông tin vận chuyển</th>
      <th width="60" nowrap>Thành tiền</th>
    </tr>
    <?php $list_order_id = array();; ?>
    <?php if(is_array($orders)){foreach($orders AS $index=>$one) { ?>
    <tr  style="background-color:#<?php echo getStatusColor($one['state']); ?>" id="order-list-id-<?php echo $one['id']; ?>">
      <td>Deal: <strong><?php echo $one['team_id']; ?>&nbsp;(<a class="deal-title" href="/<?php echo $city['slug']; ?>/<?php echo seo_url($teams[$one['team_id']]['short_title'],$one['team_id'],$url_suffix); ?>" target="_blank"><?php echo $teams[$one['team_id']]['short_title']; ?>)</a></strong><br />Số đ.hàng: <a href="/ajax/manage.php?action=orderview&id=<?php echo $one['id']; ?>" class="ajaxlink" title="Xem chi tiết"><strong><?php echo $one['id']; ?></strong><?php DB::Query("UPDATE `order` SET time_process='0000-00-00 00:00:00' WHERE id=".$one['id']); ?></a><br />
        <span style="white-space:nowrap">Ngày đặt: <?php echo date('Y-m-d H:i:s',$one['create_time']);; ?></span><br /><span style="white-space:nowrap">Trạng thái: <?php echo getStatusName($one['state']); ?></span></td>
      <td>Họ tên: <a href="/ajax/manage.php?action=userview&id=<?php echo $one['user_id']; ?>" class="ajaxlink"><strong><?php echo $one['realname']; ?></strong></a><br />
      
		<?php 
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
    
    </tr>
    <?php $list_order_id []= $one['id'];; ?>
    <?php }}?>
    <?php $list_order_id = implode(",",$list_order_id);; ?>
    <tr>
      <td colspan="9" nowrap="nowrap" style="padding-bottom:5px;"><form name="print" action="/backend/print_product_in_orders_confirmed.php" target="_blank" method="post">
          <input name="list_order_id" type="hidden" value="<?php echo $list_order_id; ?>">
          <input name="print" id="submit" type="submit" class="formbutton" value="In danh sách sản phẩm để lấy hàng" />
        </form></td>
    </tr>
    <tr>
      <td colspan="9"><?php echo $pagestring; ?></td>
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
