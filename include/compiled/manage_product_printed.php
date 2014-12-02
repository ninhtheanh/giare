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
    <h2>Sản phẩm đã in để lấy hàng</h2>
  </div>
</div>
<div class="box-content">
<div align="left" style="padding:5px;">
  <table border="0" cellspacing="4">
    <form name="frmsearch" method="POST">
      <tr>
        <td align="right"><strong>Lượt in:</strong></td>
        <td align="left"><select name="block" id="block" onChange="document.frmsearch.submit()" class="h-input" style="width:200px">
            <option value=""> - Select - </option>
           <?php echo $list; ?>
          </select>
          <script type="text/javascript">$("#block").val("<?php echo $print_time; ?>");</script>
        </td>
      </tr>
    </form>
  </table>
  </div>
  <div id="product_printed">
  	<table width="100%" border="1" cellpadding="2" cellspacing="0" style="border:#000000 1px #000000; border-collapse:collapse">
    <tr bgcolor="#c0c0c0" height="25">
      <td align="center" width="20"><b>Stt</b></td>
      <td align="center" width="50"><b>Mã SP</b></td>
      <td align="center" width="250"><b>Tên SP</b></td>
      <td align="center" width="25"><b>Số Lượng</b></td>
      <td align="center" width="25"><b>Loại</b></td>
      <td align="center" width="100"><b>Ngày in</b></td>
      <td align="center" width="100"><b>User đã in</b></td>
    </tr>
    <?php if(is_array($products)){foreach($products AS $index=>$one) { ?>
    <tr height="25">
      <td align="center"><?php echo $index+1; ?></td>
      <td align="center" width="25"><?php echo $one['team_id']; ?></td>
      <td><?php echo $one['short_title']; ?></td>
      <td align="center" width="25"><?php echo $one['quantity']; ?></td><td align="center"><?php if($one['delivery_properties']==0){?>Voucher<?php } else { ?>Sản phẩm<?php }?></td>
      <td valign="top" align="center" width="100"><?php echo $one['date_modified']; ?></td>
       <td valign="top" align="center" width="100"><?php echo $one['modified_by']; ?></td>
    </tr>
     <?php }}?>
    <tr>
    <td align="left" colspan="3"><form name="print" action="/backend/re_printed_product_in_orders.php" method="post" target="_blank">
				<input name="date_print" type="hidden" value="<?php echo $print_time; ?>">
				<input name="re_print" type="submit" class="button_login" value="In lại danh sách lấy hàng" <?php echo $disabled; ?>>
			</form></td>
      <td colspan="6" height="30"><p align="right">Tổng cộng có&nbsp; <strong><?php echo $total_print; ?></strong> sản phẩm</p></td>
    </tr>
  </table>
  </div>
</div></div> <!-- bd end -->
</div> <!-- bdw end -->
<?php include template("manage_footer");?>