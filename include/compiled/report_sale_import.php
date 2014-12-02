<?php include template("manage_header");?>
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
                    <td><h2>Thống kê nhập hàng của deal <span style="color:#F00">"<?php echo $deal_id; ?> - <?php echo $team['short_title']; ?>"</span></h2></td>
                  </tr>
                </table>
            </div>
            <div class="sect">
            <table width="100%" border="0">
  <tr>
    <td align="left" valign="top">
    	 <table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
            <tr bgcolor="#F3C317" style="color:#FFFFFF"><td align="left" width="10%" nowrap style="padding:5px;font-size:95%;"><strong>Nhập</strong></td>
            <td align="left" width="70%" style="padding:5px;font-size:95%;"><strong>SL Merchant nhập</strong></td>
            <td align="left" width="20%" style="padding:5px;font-size:95%;" nowrap><strong>Ngày yêu cầu nhập</strong></td>
          </tr>
            <?php if(is_array($stock)){foreach($stock AS $index=>$one) { ?> 
             <tr <?php echo $index%2?'bgcolor="#C9CAAE"':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>" style="background:<?php echo $bg; ?>">
                <td align="center" style="padding:5px;font-size:95%;"><strong>Lần <?php echo $index+1; ?></strong></td>
                <td align="left" style="padding:5px;font-size:95%;"><strong><?php echo $one['merchant_quantity']; ?></strong></td>
                <td nowrap align="left" style="padding:5px;font-size:95%;"><?php echo date("d/m/Y",strtotime($one['date_create'])); ?></td>
              </tr>
            <?php }}?>
          </table>
    </td>
    <td align="left" valign="top" width="50%" style="padding-left:20px;">
    	<form id="sale-import-form" method="post" action="/backend/report/sale_report.php?view=<?php echo $deal_id; ?>&s=<?php echo $sale_id; ?>"  class="validator">
              <table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
              <tr>
                <td colspan="3" align="left" style="font-size:105%; color:#00F; font-weight:bold; font-family:Arial, Helvetica, sans-serif"><strong>Form nhập hàng</strong></td>
              </tr>
              
              <tr class="alt">
                <td align="right" nowrap>SL Merchant nhập</td>
                <td align="left"><input type="text" size="30" name="merchant_quantity" id="merchant_quantity" class="f-input" value="" /></td>
              
                <td align="left"><input type="submit" value="Cập nhật" name="commit" id="user-submit" class="formbutton"/></td>
              </tr>
            </table></form>
    </td>
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