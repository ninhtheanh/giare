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
          <?php echo mcurrent_report('sale_report'); ?>
        </ul>
      </div>
      <div id="content" class="coupons-box clear mainwide">
        <div class="box clear">
          <div class="box-top"></div>
          <div class="box-content">
            <div class="head"><table width="100%" border="0">
                  <tr>
                    <td><h2>Report by Deals for sale <?php echo SaleName($sale); ?></h2></td>
                    <td align="right"><form method="get"><label>Filter</label>
						<select name="sale" class="f-input" id="sale"  onchange="this.form.submit()" style="width:160px; font-size:85%" datatype="require" require="require"><option value="0">---Chọn---</option><?php echo option_business_staff($team['sale']); ?></select>
                        <script type="text/javascript" language="javascript">$("#sale").val("<?php echo $sale; ?>");</script></form></td>
                  </tr>
                </table>
            </div>
            <div class="sect">
              <table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
                <tr><td align="left" width="1%" nowrap style="padding:5px;font-size:95%;"><strong>STT</strong></td>
                <td align="left" width="1%" nowrap style="padding:5px;font-size:95%;"><strong>Mã</strong></td>
                <td align="left" width="25%" style="padding:5px;font-size:95%;"><strong>Tên</strong></td>
                <td align="left" width="16%" style="padding:5px;font-size:95%;"><strong>NV Sale</strong></td>
                <td align="left" width="5%" nowrap style="padding:5px;font-size:95%;"><strong>Ngày lên deal/hết hạn</strong></td>
                <td align="left" width="8%" nowrap style="padding:5px;font-size:95%;"><strong>web bán</strong></td>
                <td align="left" width="8%" nowrap style="padding:5px;font-size:95%;"><strong>Đã giao</strong></td>
                <td align="left" width="8%" nowrap style="padding:5px;font-size:95%;"><strong>Đang giao</strong></td>
                <td align="left" width="8%" nowrap style="padding:5px;font-size:95%;"><strong>Chờ giao</strong></td>
                <td align="left" width="8%" nowrap style="padding:5px;font-size:95%;"><strong>Đã hủy</strong></td>
                <td align="left" width="5%" nowrap style="padding:5px;font-size:95%;"><strong>Tổng nhập</strong></td>
                <td align="left" width="8%" nowrap style="padding:5px;font-size:95%;"><strong>Trạng thái</strong></td>
                <td align="left" width="8%" nowrap style="padding:5px;font-size:95%;"><strong>Phương thức GH</strong></td>
              </tr>
                <?php if(is_array($rs)){foreach($rs AS $index=>$one) { ?> 
                 <tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>">
                    <td align="center" style="padding:5px;font-size:95%;"><strong><?php echo $index+1; ?></strong></td>
                    <td align="center" style="padding:5px;font-size:95%;"><strong><?php echo $one['team_id']; ?></strong></td>
                    <td align="left" style="padding:5px;font-size:90%;"><strong style="color:<?php echo $clr; ?>"><?php echo cut_string($one['team_name'],44,'...'); ?> </strong></td>
                    <td align="left" style="padding:5px;font-size:95%;"><?php echo $one['sale_name']; ?></td>
                    <td nowrap align="left" style="padding:5px;font-size:95%;"><?php echo $one['begin_time']; ?><br /><?php echo $one['deal_close']; ?></td>
                    
                    <td align="center" style="padding:5px;font-size:95%;"><?php echo $one['total']; ?></td>
                    <td align="center" style="padding:5px;font-size:95%;"><?php echo $one['pay']; ?></td>
                    <td align="center" style="padding:5px;font-size:95%;"><?php echo $one['delivery']; ?></td>
                    <td align="center" style="padding:5px;font-size:95%;"><?php echo $one['confirm']; ?></td>
                    <td align="center" style="padding:5px;font-size:95%;"><?php echo $one['cancel']; ?></td>
                    <td nowrap align="center" style="padding:5px;font-size:95%; color:#00F; font-weight:bold"><?php 
                    	$stock = DB::GetQueryResult("SELECT SUM(merchant_quantity) as total FROM `products_in_stock` WHERE deal_id=".$one['team_id']);
                    ; ?><?php echo $stock['total']; ?></td>
                    <td align="center" style="padding:5px;font-size:95%;"><?php echo $one['team_status']; ?></td>
                    <td align="center" style="padding:5px;font-size:95%;"><?php echo $one['delivery_properties']; ?><?php if($one['confirm']>0 && ($one['total']>($one['cancel']+$stock['total']))){?><br /><a href="/backend/report/sale_report.php?view=<?php echo $one['team_id']; ?>&s=<?php echo $one['sale_id']; ?>"><strong>Nhập hàng</strong></a><?php }?></td>
                  </tr>
                <?php }}?>
                <tr>
                  <td colspan="10"><?php echo $pagestring; ?></td>
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