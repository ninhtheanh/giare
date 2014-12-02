<?php include template("manage_header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_order('history'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"><div class="subhead">
                    <h2>Lịch sử đơn hàng</h2>
				</div></div>
            <div class="box-content">
                
					<form method="get" id="target">
       				<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="filter-table">
                          <tr>
                            <td align="right"><p>Số ĐH <input type="text" name="order_id" value="<?php echo $order_id; ?>" class="h-input"/></p>
                            <p style="padding-top:3px;">Trạng thái 
                            <select name="status_code" id="status_code" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($allstatus,'code','code'),$status_code); ?></select>
                            </p>                           </td>
                            <td align="right">
							
                             <p style="padding-top:3px;">Người xử lý 
                             <select name="user" id="user" class="h-input" require="true"><option value='0'>--Chon--</option> 
						<?php 
                      	$rs = DB::GetQueryResult("SELECT DISTINCT `user` FROM `order_history`",false);
                        foreach($rs as $k =>$v){
                        	$option .="<option value='".$v['user']."'>".$v['user']."</option>";
                        }
                      ; ?><?php echo $option; ?>


							<?php Utility::Option(Utility::OptionArray($alladmins,'email','username'),$user); ?></select>
							 
							 
							 
							 </p>
                            <p style="padding-top:3px;">Người tiếp nhận 
                            <select name="assign_to" id="shipper_id" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($allshipper,'shipper_name','shipper_name'),$assign_to); ?></select>
                            </p>
                            </td>
                            <td align="right">
                            <p>Ngày xử lý <input type="text" class="h-input" onfocus="WdatePicker({isShowClear:false,readOnly:true})" name="cbday" value="<?php echo $cbday; ?>" /></p><p style="padding-top:3px;">Ngày hết hạn <input type="text" class="h-input" onfocus="WdatePicker({isShowClear:false,readOnly:true})" name="ceday" value="<?php echo $ceday; ?>" /></p>
                            </td>                            
                            <td align="left" style="padding-left:10px;">
                            <p style="padding:5px"><input type="submit" value="Lọc dữ liệu" class="formbutton"  style="padding:3px 6px;"/>&nbsp;&nbsp;<input type="button" value="Bỏ lọc" class="formbutton"  style="padding:3px 6px;" onclick="location.href='/backend/order/history.php'"/></p>
                            </td>
                  </tr>
                        </table>
					</form>
                <style>
				.coupons-table tr,.coupons-table td
				{
					background:none;
				}
				</style>
                <div class="sect">
                <form method="post" action="">    
                   
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table" width="100%">
					<tr>
					<th width="50" nowrap="nowrap">Order Id</th>
                    <th width="70">Trạng thái</th>
					<th width="120">Người xử lý</th>
                    <th width="120" nowrap>Người tiếp nhận</th>
					<th width="120" nowrap>Ngày xử lý</th>
                    <th width="120" nowrap>Ngày hết hạn</th>	
                    <th nowrap="nowrap">Cảnh báo</th>	
                    <th>Ghi chú</th>					
					</tr> 
                            
					<?php if(is_array($orders)){foreach($orders AS $index=>$one) { ?>  
                    
					<tr style="background-color:#<?php echo getStatusColor($one['status_code']); ?>">	
                         <?php 
                            $condition['order_id'] = $one['order_id'];
                            $total_row = Table::Count('order_history', $condition);
                            $i = ++$index;
                            if ($i==25 && $total_row>1){
                            	$rowspan = $total_row-1;
                            }else{
                            	$rowspan = $total_row;
                            }
                            if ($one['head']==1){
                            	$bgcolor = "background-color:#a2d071;color:#ffffff";
                            }else{
                            	$bgcolor = "background-color:#ffffff";
                            }
                        ; ?>
                        <td style="<?php echo $bgcolor; ?>"><?php if($one['head']==1){?><h3><?php echo $one['order_id']; ?></h3><?php }?></td>
                        <td><?php echo $one['status_code']; ?></td>
						<td><?php echo $one['user']; ?></td>
						<td><?php echo $one['assign_to']; ?></td>
						<td><?php echo $one['date']; ?></td>
                       <td><?php echo $one['expires']; ?></td>
                       <td><?php echo $one['is_warning']; ?></td>
                       <td><?php echo $one['note']; ?></td>
					</tr>
					<?php }}?>
                   
                    
					<tr><td colspan="7"><?php echo $pagestring; ?></td></tr>
                    </table>
                    
                   
                    
                    </form>
				</div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("manage_footer");?>
