<?php include template("manage_header");?>

<div id="bdw" class="bdw">
  <div id="bd" class="cf">
    <div id="coupons">
      <div class="subdashboard" id="dashboard">
        <ul>
          <?php echo mcurrent_order('printtranferreport'); ?>
        </ul>
      </div>
      <div id="content" class="coupons-box clear mainwide">
        <div class="box clear">
          <div class="subbox-top">
            <div class="subhead">
              <h2>Bàn giao các đơn hàng đã đóng gói</h2>
            </div>
          </div>
          <div class="box-content"> 
            <script type="text/javascript" language="javascript">
				function CheckSubmit(){
					ischecked = false;
					for(i=1;i<document.frmprintorderpackage.orderid.length;i++){
						obj=document.getElementById(document.frmprintorderpackage.orderid[i].value);
						if(obj.checked==true){
							ischecked=true;break;
						}
					}
					if(!ischecked){
						alert("Vui lòng chọn một hoặc nhiều hóa đơn...");
						return false;
					}
					return true;
				}
				function OnSubmit(){
					if($("#OrderID").val()== ""){
						alert("Vui lòng nhập mã hóa đơn");
						$("#OrderID").focus();
						return false;
					}
					return true;
				}
				function DoGo(task){
					var thefrm = $("#frmprintorderpackage");
					var val_trans= $("#shipper_id").val();
					var listid="";
					for(i=1;i<document.frmprintorderpackage.orderid.length;i++) {
						obj = document.frmprintorderpackage.orderid[i].value;
						listid += (obj + ",");
					}
					listid = listid.substring(0,listid.length-1);
					if(!CheckSubmit()){
						return false;
					}else{
						if(task=="transfer"){
							if(val_trans==0){
								alert("Bạn chưa chọn đơn vị vận chuyển");
								$("#shipper_id").focus();
								return false;
							}else if(confirm("Bạn muốn bàn giao các hóa đơn đã chọn?")){
								var url ="/backend/order/printtranferreport.php?city_id=<?php echo $city['id']; ?>&listorderid="+encodeURIComponent(listid)+"&act=transfer&shipper_id="+$("#shipper_id").val();
								window.open(url,"_self" );
								/*$("#act").val(task);
								thefrm.attr("target","_self"); 
								thefrm.attr("action","<?php echo $_config['index.php']; ?>?<?php echo $_config['target']; ?>=printtransferreport"); 
								$("#transfer").attr("disabled",true);
								thefrm.submit();*/
							}
						}
						if(task=="exportbbbgtoexcel"){
							if(val_trans==0){
								alert("Bạn chưa chọn đơn vị vận chuyển");
								$("#shipper_id").focus();
								return false;
							}else if(confirm("Bạn muốn xuất biên bản bàn giao của các hóa đơn đã chọn ra excel?")){
								var url ="export_excel_transfer_report.php?listorderid="+encodeURIComponent(listid)+"&act=exportbbbgtoexcel&shipper_id="+$("#shipper_id").val()+"&user_delivery="+$("#user_delivery").val();
								window.open(url,"_blank" );
								/*$("#act").val(task);
								thefrm.attr("target","_blank"); 
								thefrm.attr("action","print_transfer_report.php"); 
								$("#exportbbbgtoexcel").attr("disabled",true);
								thefrm.submit();*/
							}
						}
						if(task=="printbbbg"){
							if(confirm("Bạn muốn in biên bản bàn giao?")){
								$("#act").val(task);
								thefrm.attr("target","_blank"); 
								thefrm.attr("action","/backend/shipping/ship_out_data.php?out_id=<?php echo $out_id; ?>");
								$("#printorder").attr("disabled",true);
								thefrm.submit();
							}			
						}
					}
				}
				/*$(function(){
					$("#shipper_id").change(ShowDeliveryUser);
				});
				function ShowDeliveryUser(){
					var selected = $("#shipper_id option:selected");		
					if(selected.val() == 10){
						$("#user_delivery").show();
					}else{
						$("#user_delivery").hide();
					}
				}*/
				</script>
            <div align="left" style="padding:5px;">
              <div align="center">
                  <table border="0" cellspacing="4">
                    <form name="frmsearch" method="POST" onsubmit="return OnSubmit()">
                      <tr>
                        <td align="right"><b>M&atilde; h&oacute;a &#273;&#417;n</b></td>
                        <td align="left"><textarea name="OrderID" id="OrderID" style="width:350px;height:100px;padding:2px; border:#1B94C1 1px solid"><?php echo $OrderIDList; ?></textarea></td>
                        <td style="padding-left:5px"><input type="submit" name="onsubmit" class="formbutton" value="  Submit  " /></td>
                      </tr>
                    </form>
                  </table>
                </div>
                <div align="center" style="color:#FF0000; padding-top:3px;"><?php echo $message; ?></div>
            </div>
            <form name="frmprintorderpackage" id="frmprintorderpackage" method="POST">
              <input type="hidden" name="act" id="act" value="">
              <input type="hidden" name="orderid[0]" id="orderid" value="nothing">
              <div>
                <table border="0" cellspacing="0" cellpadding="0" id="orders-list" class="coupons-table" style="color:#000;">
                  <tr>
                    <th align="left"><input type="checkbox" name="checkall" id="checkall" onclick="jqCheckAll( this.id, 'myinput' )" /></th>
                    <th width="100">ID</th>
                      <th width="350">Thông tin thanh toán</th>
                      <th width="350">Thông tin vận chuyển</th>
                      <th width="60" nowrap="nowrap">Thành tiền</th>
                  </tr>
    				<?php if(is_array($orders)){foreach($orders AS $index=>$one) { ?>
                  <tr style="background-color:#<?php echo getStatusColor($one['state']); ?>" id="order-list-id-<?php echo $one['id']; ?>">
                    <td align="center" width="1%"><input type="hidden" name="orderid[]" id="orderid" value="<?php echo $one['id']; ?>">
                      <input name="myinput[]" id="<?php echo $one['id']; ?>" value="<?php echo $one['id']; ?>" type="checkbox"></td>
                    <td>Deal: <strong><?php echo $one['team_id']; ?>&nbsp;(<a class="deal-title" href="/<?php echo $city['slug']; ?>/<?php echo seo_url($teams[$one['team_id']]['short_title'],$one['team_id'],$url_suffix); ?>" target="_blank" style="color:#0000FF"><?php echo $teams[$one['team_id']]['short_title']; ?>)</a></strong><br />Số đ.hàng: <a href="/ajax/manage.php?action=orderview&id=<?php echo $one['id']; ?>" class="ajaxlink" title="Xem chi tiết" style="color:#0000FF"><strong><?php echo $one['id']; ?></strong></a><br />
        <span style="white-space:nowrap">Ngày đặt: <?php echo date('Y-m-d H:i:s',$one['create_time']);; ?></span><br /><span style="white-space:nowrap">Trạng thái: <?php echo getStatusName($one['state']); ?></span></td>
                    <td>Họ tên: <a href="/ajax/manage.php?action=userview&id=<?php echo $one['user_id']; ?>" class="ajaxlink" style="color:#0000FF"><strong><?php echo $one['realname']; ?></strong></a><br />
      
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
                    <td>Họ tên: <a href="/ajax/manage.php?action=userview&id=<?php echo $one['user_id']; ?>" class="ajaxlink" style="color:#0000FF"><strong><?php if($one['brealname']!=''){?><?php echo $one['brealname']; ?><?php } else { ?><?php echo $one['realname']; ?><?php }?></strong></a><br />
        Địa chỉ: <?php echo $one['shipping_address']; ?><br />Điện thoại: <?php echo $one['bmobile']; ?><br /><span style="color:#c40000"><strong><?php echo GetShippingName($one['shipping_id']); ?></strong></span></td>
                    <td align="right" style="color:#FF0000"><strong><?php echo print_price(moneyit(TotalOrder($one['id']))); ?></strong></td>
                  </tr>
                  <?php $ship_out_id = $one['ship_id']; ?>
                  <?php }}?>
                  <tr>
                  
                  <?php if($OrderIDList){?>
                  <tr>
                    <th colspan="2">Tổng cộng: <b><?php echo $count; ?></b>&nbsp;gói hàng</th>
                    <th colspan="3" nowrap="nowrap" style="padding-bottom:5px; padding-top:5px;" align="left">
                        <select name="shipper_id" id="shipper_id" class="h-input" require="true">
                            <option value='0'>--Chon--</option>
                   			<?php echo Utility::Option(Utility::OptionArray($allshipper,'id','shipper_name'),$shipper_id); ?>
                         </select>
                        <?php if(empty($list)){?>&nbsp;&nbsp;<input type="button" name="transfer" onclick="DoGo('transfer')" id="transfer" value="Bàn giao" class="formbutton" /><?php }?>&nbsp;&nbsp;<?php if(!empty($list) || $ship_out_id>0){?><input type="button" name="transfer" onclick="DoGo('printbbbg')" id="printbbbg" value="In biên bản bàn giao" class="formbutton" /><!--&nbsp;&nbsp;<input type="button" name="transfer" onclick="DoGo('exportbbbgtoexcel')" id="exportbbbgtoexcel" value="Xuất biên bản bàn giao ra excel" class="formbutton" />--><?php }?>&nbsp;&nbsp;<input type="button" onclick="DoGo('print')" name="printorder" value="In đơn hàng" id="printorder" class="formbutton" /><?php echo $showscript; ?></th>
                  </tr>
                  <?php }?>
                
                </table>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- bd end --> 
</div>
<!-- bdw end --> 
<?php include template("manage_footer");?>