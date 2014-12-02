<?php include template("manage_header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_shipping('ship_out_history'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"><div class="subhead">
                    <h2>Lịch sử bàn giao</h2>
				</div></div>
            <div class="box-content">
                
				<div class="sect" style="padding:5px; background:#AADFF1">
					<form method="get">
                        Mã bàn giao <input type="text" name="out_id" value="<?php echo htmlspecialchars($out_id); ?>" class="h-input"/>                        
                        &nbsp;&nbsp;Người xử lý <select name="user" id="user" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($alladmins,'username','username'),$user); ?></select>&nbsp;&nbsp;Ngày xử lý <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="cbday" value="<?php echo $cbday; ?>" /> - 
                       <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="ceday" value="<?php echo $ceday; ?>" />&nbsp;&nbsp;<input type="submit" value="Lọc dữ liệu" class="formbutton"  style="padding:1px 6px;"/>                 
					<form>
				</div>
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
					<th width="50">Mã BG</th>
                    <th width="120">Ngày xử lý</th>
					<th width="120">Người xử lý</th>
                    <th width="120">Tác vụ</th>					
                    <th>Ghi chú</th>					
					</tr> 
                            
					<?php if(is_array($rs)){foreach($rs AS $index=>$one) { ?>  
                    
                    <?php 
                        switch($one['act']){
                        	case 'BANGI' : $act = 'Bàn giao'; break;
                            case 'TRABA' : $act = 'Trả bàn giao'; break;
                            case 'NOPTI' : $act = 'Nộp tiền'; break;                           
                        }
                    ; ?>
                    <?php 
                            $condition['out_id'] = $one['out_id'];
                            $total_row = Table::Count('ship_log', $condition);
                            $i = ++$index;
                            if ($i==25 && $total_row>1){
                            	$rowspan = $total_row-1;
                            }else{
                            	$rowspan = $total_row;
                            }
                            if ($one['head']==1){
                            	$bgcolor = "background-color:#51bce8;color:#ffffff;";
                            }else{
                            	$bgcolor = "background-color:#fff;";
                            }
                        ; ?>                    
			                         
                        <tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['out_id']; ?>" <?php if($one['head']==1){?>style="border-top:solid 1px #000;"<?php }?>>	                         
                        <td style="<?php echo $bgcolor; ?> font-size:16px" align="center"><?php if($one['head']==1){?><h3><?php echo $one['out_id']; ?></h3><?php }?></td>
                        <td><?php echo $one['date']; ?></td>
						<td><?php echo $one['user']; ?></td>
						<td><?php echo $act; ?></td>
                       <td><?php echo $one['note']; ?></td>
					</tr>
					<?php }}?>
					
                    </table>
                    
                   <?php echo $pagestring; ?>
                    
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
