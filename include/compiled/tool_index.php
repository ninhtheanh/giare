<?php include template("manage_header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_tool('index'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"><div class="subhead">
                    <h2>Xuất Email Template</h2>
				</div></div>
            <div class="box-content">
                <form method="post" enctype="multipart/form-data" target="_blank">
				<div class="sect" style="padding:5px; background:#FFFFCC"><table width="100%" border="0" cellpadding="5" cellspacing="5">
  <tr>
    <td width="66%" align="left" valign="top" style="padding-bottom:7px">Xuất cho: <input type="radio" name="service" value="mimi" checked="checked" /> Mimi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="service" value="interspire" /> Interspire</td>
    <td width="34%" rowspan="2"> Chọn deal cần nhúng vào nội dung email rồi <input name="process" type="submit" value="Generate" class="formbutton"  style="padding:6px 6px;"/></td>
  </tr>
  <tr>
    <td align="left" valign="top" style="padding-bottom:7px">Template: <input type="radio" name="template"  checked="checked" value="col" />Cột&nbsp;&nbsp;&nbsp;<input type="radio" name="template" value="line" />Hàng nhỏ&nbsp;&nbsp;&nbsp;<input type="radio" name="template" value="row" />Hàng lớn&nbsp;&nbsp;&nbsp;<input type="radio" name="template" value="one" />Đơn </td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-bottom:7px">Banner : nhập mô tả, link, hình - tất cả bắt buộc - Hình kích thước: 780x100</td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-bottom:7px">Banner Top: 
      <input type="text" name="bannerTdesc" size="40" />&nbsp;<input type="text" name="bannerTlink" size="30" />&nbsp;<input type="file" name="bannerTfile" /></td>
    </tr>
  <tr>
    <td colspan="2">Banner Bottom: <input type="text" name="bannerBdesc" size="40" />&nbsp;<input type="text" name="bannerBlink" size="30" />&nbsp;<input type="file" name="bannerBfile" /></td>
    </tr>
</table>
				</div>
               <div align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr><td>&nbsp;</td></tr>
			   <tr>
                <td align="left" valign="top"><strong>Số Deal Cần Hiển Thị </strong><input type="text" name="no_resort" size="40" /></br></td>
                 <td align="left" valign="top"><strong>Số Deal Bán Chạy Cần Hiển Thị </strong><input type="text" name="no_bestseller" size="40" /></td>
              </tr>
			  <tr><td>&nbsp;</td></tr>
            </table>
            </div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
                  <tr>
                    <th width="30" align="center">
                      <input type="checkbox" name="checkall" id="checkall" onclick="jqCheckAll( this.id, 'ids' )" /></th>
                      
                    <th width="50">DealID</th>
                    <th width="50">Head</th>
                    <th>DealName</th>  
                    <th>EndTime</th>
                    <th>Purchased</th>      
                    <th width="50">SortOrder</th>                  
                  </tr>
                  <?php if(is_array($rs)){foreach($rs AS $index=>$one) { ?>
                      <?php 
                       $left = array();
                       $now = time();
                       $diff_time = $left_time = $one['end_time']-$now;
                       $left_day = floor($diff_time/86400);
                       $left_time = $left_time % 86400;
                       $left_hour = floor($left_time/3600);
                       ; ?>
                  <tr style="background-color:#<?php echo ($index%2==0)?'ffffff':'eeeeee';; ?>" id="order-list-id-<?php echo $one['id']; ?>">
                    <td align="center"><input type="hidden" name="id[]" id="id" value="<?php echo $one['id']; ?>"><?php echo $index+1; ?><input name="ids[]" id="<?php echo $one['id']; ?>" value="<?php echo $one['id']; ?>" type="checkbox">
                      </td>  
                      <td><?php echo $one['id']; ?></td> 
                      <td align="center"><input type="hidden" name="id[]" id="id" value="<?php echo $one['id']; ?>">
                      <input type="radio" name="head" value="<?php echo $one['id']; ?>">
                      </td>                 
                     
                    <td><?php echo $one['short_title']; ?></td>  
                    <td align="right"><?php echo $left_hour+(24*$left_day); ?> h</td>     
                    <td align="right"><?php echo $one['now_number']; ?></td>     
                    <td style="padding-right:20px; text-align:right"><?php echo $one['sort_order']; ?></td>                  
                  </tr>
                  <?php }}?>                                  
                </table>
				</div>
			<form>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("manage_footer");?>