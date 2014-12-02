<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_order('delivery'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"> <div class="subhead">
                    <h2>Trả đơn hàng đã bàn giao</h2>
				</div></div>
            <div class="box-content">
                    	<form method="get"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="filter-table">
                        <input type="hidden" name="action" id="action" value="list" />
                          <tr>
                            <td width="20%" align="right">
						<p style="margin:5px 0;"><strong>Order No.</strong>
						  <input type="text" name="id" value="<?php echo htmlspecialchars($id); ?>" class="h-input"/></p>
						<p style="margin:5px 0;"><strong>User </strong>
						  <input type="text" name="uemail" class="h-input" value="<?php echo htmlspecialchars($uemail); ?>" ></p>
						<p><strong>Deal No.</strong>
						  <input type="text" name="team_id" class="h-input number" value="<?php echo $team_id; ?>" ></p></td><td width="26%" align="right"><p style="margin:5px 0;"><strong>Mobile</strong>
						    <input type="text" class="h-input" name="mobile" value="<?php echo $mobile; ?>" /></p>
						  <p style="margin:5px 0;"><strong>TP</strong>
<select name="city_id" class="h-input" require="true" onchange="this.form.submit();"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($allcities,'id','name'),$city_id); ?></select><?php if($city_id){?></p>
						  <p style="margin:5px 0;"><strong>Quận/Huyện </strong>
						    <select name="dist_id" onchange="this.form.submit();" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray(option_district('VN', $city_id, false, true),'dist_id','dist_name'),$dist_id); ?></select><?php }?></p></td><td width="24%" align="right"><p style="margin:5px 0;"><strong>Shipper
    </strong>
  <select name="shipper_id" onchange="this.form.submit();" id="shipper_id" class="h-input" require="true"><option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($allshipper,'id','shipper_name'),$shipper_id); ?></select></p>
<p style="margin:5px 0;"><strong>Delivery time </strong>
  <select name="delivery_time" onchange="this.form.submit();" id="delivery_time" class="h-input" require="true"><option value='0'>--Chon--</option><?php if($shipper_id){?><?php echo option_delivered_time($delivery_time, $shipper_id); ?><?php }?></select></p><p style="margin:5px 0;"><strong>Mã bàn giao</strong>
    <input type="text" class="h-input" name="delivery_code" value="<?php echo $delivery_code; ?>" /></p></td><td width="30%" rowspan="3" style="padding-left:10px;">
<p><p><a class="btn" href="/backend/shipping/print_label.php?delivery_code=<?php echo $delivery_code; ?>" target="_blank">In nhãn</a></p></p>
<p style="margin-top:8px"><a class="btn" href="/backend/shipping/scan.php?delivery_code=<?php echo $delivery_code; ?>" target="_blank">Quét đơn hàng</a></p>
    <p style="margin-top:8px">
    <input type="submit" name="list" value="Trả bàn giao" class="formbutton"  style="padding:3px 6px;" onclick="$('#action').val('list')"/></p>
    
    </td></table><p><span style="padding-top:5px; float:right">Đã bàn giao: <strong style="color:#ff0000"><?php echo $total_voucher; ?> voucher</strong></span></p>
					</form>                      
                <div class="sect">&nbsp;<?php if($_GET['delivery_code']>0){?> 
                <script type="text/javascript" language="javascript">
					$(document).ready(function(){
						$("input.#AllRC1").click(function() {
							if($(this).is(':checked')){
								$("input:radio[class*='RC1']").attr("checked","checked"); 
							}else{
								$("input:radio[class*='RC1']").removeAttr("checked"); 
							}
						});
					});
					function RadioCancel(id){
						$("#qty"+id).val(0);
						$("#order_notes"+id).val(1);
						$("#date_received_"+id).val("0000-00-00");
						$("#input_date_hanging_"+id).hide();
						for(i=0;i<n;i++){
							$("#vcode"+id+"_"+i).removeAttr("checked");
							$("#vcode"+id+"_"+i).attr("disabled","disabled"); 
						}
							
					}
					function RadioPending(id){
						$("#qty"+id).val(0);
						$("#order_notes"+id).val(0);
						$("#date_received_"+id).val("0000-00-00");
						$("#input_date_hanging_"+id).hide();		
						for(i=0;i<n;i++){
							$("#vcode"+id+"_"+i).removeAttr("checked");
							$("#vcode"+id+"_"+i).attr("disabled","disabled"); 
						}
						$("#order_notes"+id).val(0);
					}
					function RadioHanging(id){
						$("#qty"+id).val(0);
						$("#date_received_"+id).val("0000-00-00");
						$("#input_date_hanging_"+id).show();
						$("#order_notes"+id).val(0);
						if( $("#"+id+"_th").is(':checked')){
							$("#input_date_hanging_"+id).show();
						}else{
							$("#input_date_hanging_"+id).hide();	
						}
					}
					function RadioPay(id, quantity){
						$("#qty"+id).val(quantity);
						$("#date_received_"+id).val("0000-00-00");
						$("#input_date_hanging_"+id).hide();
						for(i=0;i<n;i++){
							$("#vcode"+id+"_"+i).removeAttr("disabled");
							$("#vcode"+id+"_"+i).attr("checked","checked");
							$("#divvcode"+id+"_"+i).show();
						}
						$("#order_notes"+id).val(0);
						var qty = $("#qty"+id).val();
						 $("#qty"+id).bind("keyup", function () {
							var max_qty = quantity;
							var qty = $("#qty"+id).val();
							if(max_qty>0){
								if(qty>max_qty){
									alert("Số lượng thành công không được lớn hơn "+max_qty);
									$("#qty"+id).val(quantity);
								}
								if(qty==0 && $("#"+id).is(':checked')){	
									alert("Số lượng thành công không thể bằng "+qty);
									$("#qty"+id).val(quantity);
								}
							}
							if(qty<n && qty>0){
								for(i=qty;i<n;i++){
									if(qty>0){
										var a = qty-1;
										$("#divvcode"+id+"_"+a).show();
										$("#vcode"+id+"_"+a).attr("checked","checked");
									}
									$("#divvcode"+id+"_"+i).hide();
									$("#vcode"+id+"_"+i).removeAttr("checked"); 													
								}
							}else{
								for(i=0;i<n;i++){
									$("#divvcode"+id+"_"+i).show(); 
									$("#vcode"+id+"_"+i).attr("checked","checked");
								}	
							}
						});	
					}
					</script>
                <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" name="f_paid">
                	<input type="hidden" name="team_id" value="<?php echo $team_id; ?>" >
                    <input type="hidden" name="dist_id" value="<?php echo $dist_id; ?>" >
                    <input type="hidden" name="city_id" value="<?php echo $city_id; ?>" >
                    <input type="hidden" name="shipper_id" value="<?php echo $shipper_id; ?>" >
                    <input type="hidden" name="delivery_code" value="<?php echo $delivery_code; ?>" >
                    <input type="hidden" name="id" value="<?php echo $id; ?>" >
                    <input type="hidden" name="uemail" value="<?php echo $uemail; ?>" >
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table" width="100%">
					<tr>
                    <?php if($total_voucher>0){?>
                    <th width="20" colspan="3">
                    <input type="submit" value="Xác nhận trả bàn giao" class="formbutton" name="process" style="padding:4px 6px;" onclick="return confirm('Xác nhận trả BG?');" />                    </th>
					  <th width="10" rowspan="2">SL</th>
					  <th width="60" rowspan="2" nowrap>Thành tiền</th>
					  <th colspan="4" nowrap>Trạng thái</th>
                       <th rowspan="2" nowrap>SL TC</th>
					  <th width="260" rowspan="2" nowrap>Ghi chú</th>
                      <?php }?>
					</tr>
					<tr>
                   	 <th width="20">STT</th>
					  <th width="40"><a href="<?php echo $request_uri; ?>&sortid=desc">MSĐH</a></th>
					  <th>Voucher</th>
					  <th width="4" nowrap>TC</th>
					  <th width="6" nowrap>H</th>
					  <th width="14" nowrap>CT</th>
                      <th width="14" nowrap align="center">Tạm Hoãn</th>
					  </tr>
					<?php if(is_array($orders)){foreach($orders AS $index=>$one) { ?>
					<tr <?php echo $index%2?'class="alts"':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>">
						<td rowspan="2"><?php echo $index+1; ?></td>
						<td rowspan="2">
                        <a href="/ajax/manage.php?action=orderview&id=<?php echo $one['id']; ?>" class="ajaxlink"><?php echo $one['id']; ?></a>
                        </td>
						<td>&nbsp;
					    <?php echo $one['team_id']; ?>&nbsp;(<a class="deal-title" href="/team.php?id=<?php echo $one['team_id']; ?>" target="_blank"><?php echo $teams[$one['team_id']]['short_title']; ?></a>
                        <?php echo showColorSize($one); ?>
                        )</td>
						<td> <?php echo $one['quantity']; ?></td>
						<td align="right"><?php echo print_price(moneyit($one['origin'])); ?></td>
						<td onmouseover="this.style.backgroundColor='#09F'" onmouseout="this.style.backgroundColor=''"><input type="hidden" name="orderid[]" id="orderid2" value="<?php echo $one['id']; ?>" />
                        <script type="text/javascript" language="javascript">
							$(document).ready(function(){
								var n = $("div #se_num<?php echo $one['id']; ?>").length;
								for(i=0;i<n;i++){
									$("#vcode<?php echo $one['id']; ?>_"+i).attr("checked","checked");
								}
								$("#input_date_hanging_<?php echo $one['id']; ?>").hide();
							});
                        </script>
                        <?php 
                        	$checked_pay = "";$checked_cancel = "";$checked_pending = "";$checked_hanging = "";
                        	$o = DB::GetQueryResult("SELECT state FROM `ship_out_data` WHERE out_id=".$delivery_code." AND order_id=".$one['id']);
                            if($o['state']=='pay'){
                            	$checked_pay = "checked=\"checked\"";
                            }elseif($o['state']=='canceled'){
                            	$checked_cancel = "checked=\"checked\"";
                            }elseif($o['state']=='pending'){
                            	$checked_pending = "checked=\"checked\"";
                            }elseif($o['state']=='hanging'){
                            	$checked_hanging = "checked=\"checked\"";
                            }else{
                            	$checked_pay = "checked=\"checked\"";
                            }
                        ; ?>
						<input name="row<?php echo $one[id]; ?>" id="<?php echo $one['id']; ?>" value="pay" type="radio" onclick="RadioPay(<?php echo $one['id']; ?>,<?php echo $one['quantity']; ?>)" class="RC1" <?php echo $checked_pay; ?> /></td>							

						<td onmouseover="this.style.backgroundColor='#09F'" onmouseout="this.style.backgroundColor=''">                       
						  <input name="row<?php echo $one[id]; ?>" id="<?php echo $one['id']; ?>_h" value="canceled" onclick="RadioCancel(<?php echo $one['id']; ?>)" type="radio" class="RC2" <?php echo $checked_cancel; ?> /></td>
                          
						<td onmouseover="this.style.backgroundColor='#09F'" onmouseout="this.style.backgroundColor=''">                       
						  <input name="row<?php echo $one[id]; ?>" id="<?php echo $one['id']; ?>_c" value="pending" onclick="RadioPending(<?php echo $one['id']; ?>)" type="radio" class="RC3" <?php echo $checked_pending; ?>/> </td><td align="center" onmouseover="this.style.backgroundColor='#09F'" onmouseout="this.style.backgroundColor=''" nowrap="nowrap">                       
						  <input name="row<?php echo $one[id]; ?>" id="<?php echo $one['id']; ?>_th" value="hanging" onclick="RadioHanging(<?php echo $one['id']; ?>)" type="radio" class="RC4" <?php echo $checked_hanging; ?> /><span id="input_date_hanging_<?php echo $one[id]; ?>"> <?php                           	
                            $sdate = DB::GetQueryResult("SELECT date_received FROM `ship_out_data` WHERE out_id=".$delivery_code." AND order_id=".$one['id']);
                            if($one['date_received']!=''){
                            	$sdate['date_received'] = $one['date_received'];
                            }
                          ; ?>&nbsp;<input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="date_received_<?php echo $one['id']; ?>" id="date_received_<?php echo $one['id']; ?>" value="<?php echo $sdate['date_received']; ?>" style="width:63px" /></span></td>
                          <td>
                          <?php                           	
                            $sqty = DB::GetQueryResult("SELECT qty_successful, notes FROM `ship_out_data` WHERE out_id=".$delivery_code." AND order_id=".$one['id']);
                            if($sqty['qty_successful']==0){
                            	$sqty['qty_successful'] = $one['quantity'];
                            }

                          ; ?>
                          <input type="text" id="qty<?php echo $one['id']; ?>" name="qty<?php echo $one['id']; ?>" class="h-input" value="<?php echo $sqty['qty_successful']; ?>" style="width:20px;" <?php echo $disable; ?> />
                          </td>
                          
						<td>
                        <input type="hidden" name="money<?php echo $one['id']; ?>" value="<?php echo $one['money']; ?>" />
                        <input type="hidden" name="user<?php echo $one['id']; ?>" value="<?php echo $one['user_id']; ?>" />
                        <input type="hidden" name="quantity<?php echo $one['id']; ?>" value="<?php echo $one['quantity']; ?>" />
                        <?php 
                        	$nn = checkOrderNotes($one[id], $delivery_code);
                            $v = DB::GetQueryResult("SELECT notes_id FROM order_notes WHERE order_id=".$one[$i]." AND out_id=".$delivery_code);
                        ; ?>
                        <select name="order_notes<?php echo $one['id']; ?>" id="order_notes<?php echo $one['id']; ?>" style="width:160px;" datatype="require" require="require"><option value="0">---Chọn---</option><?php echo option_order_notes($nn['notes_id']); ?></select><script type="text/javascript">$("#order_notes<?php echo $one['id']; ?>".val("<?php echo $v['notes_id']; ?>"))</script><input name="note<?php echo $one[id]; ?>" value="<?php echo $sqty['notes']; ?>" type="text" style="width:100%" />
                        
                        </td>
					  </tr>
                      <?php 
                        $vcode = DB::GetQueryResult("SELECT `serial`, `code`, `status` FROM `voucher_code` WHERE order_id='".$one['id']."' AND team_id='".$one['team_id']."'",false);
                        $serial = "";$j=0;
                        for($i=0;$i<count($vcode);$i++){
                            $j+=1;
		                    $checked = "";
                            if($vcode[$i]['status']=='A'){
                            	$checked = "checked";
                            }
                            if($j%5==0){
                            	$br = "<br />";
                            }else{
                            	$br="";
                            }
                            $serial .= "<div id=\"se_num".$one['id']."\"><span id=\"divvcode".$one['id']."_".$i."\"><input ".$checked." id=\"vcode".$one['id']."_".$i."\" name=\"vcode[]\" value=\"".$vcode[$i]['serial']."\" type=\"checkbox\">&nbsp;<b>".$vcode[$i]['serial']." - ".$vcode[$i]['code']."</b></span></div>";
                        }
                    ; ?>
                      <tr <?php echo $index%2?'class="alts"':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>">
						  <td colspan="9" align="left" style="line-height:18px;"><style type="text/css">  div #se_num<?php echo $one['id']; ?>{ width:130px; margin:2px; float:left; white-space:nowrap;}</style>              
<?php if($serial){?><div align="left" style="width:65px; float:left; font-size:11px; font-family:Arial"><em><strong>Serial No.&nbsp;</strong></em></div><?php echo $serial; ?><?php }?></td>
						 
					  </tr>
					<?php }}?>                  
                    </table>
				  <p align="center"><?php echo $pagestring; ?></p>
                </form><?php }?>
				</div>
            </div>
        </div><div class="box-bottom"></div>

    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("manage_footer");?>