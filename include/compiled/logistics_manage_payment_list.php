<?php include template("manage_header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_shipper('payment'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
             <div class="subbox-top"> <div class="subhead"><h2>Quản lý phương thức thanh toán</h2></div></div>
            <div class="box-content">
              <div class="sect" style="padding-top:3px;">
                	<script language="javascript" type="text/javascript">
						function CheckAll(obj)
						{
							if(obj.checked) mycheck = true;
							else mycheck = false;
							for(i=1;i<document.frmpaymentlist.paymentlistid.length;i++)
							{
								obj=document.getElementById(document.frmpaymentlist.paymentlistid[i].value);
								obj.checked=mycheck;
							}
						}
						function GoDelete()
						{
							ischecked = false;
							for(i=1;i<document.frmpaymentlist.paymentlistid.length;i++){
								obj=document.getElementById(document.frmpaymentlist.paymentlistid[i].value);
								if(obj.checked==true){
									ischecked=true;
									break;
								}
							}
							if(document.frmpaymentlist.act.value=="") return false;
							if(!ischecked){
								alert("No items selected! At least one checkbox must be ticked off to perform this action.");
								return false;
							}else{
								if(confirm("Are you sure to delete these item ???")){
									if(confirm("All data of these item will be deleted...")){
											document.frmpaymentlist.act.value="dodelete";
											document.frmpaymentlist.dodelect.disabled=true;
											document.frmpaymentlist.update.disabled=true;
											document.frmpaymentlist.submit();
									}
								}
								return false;
							}
						}
					</script><table class="adminlist" cellpadding="0" cellspacing="0">
                    <form name="frmpaymentlist" method="POST">
          <input type="hidden" name="act" value="update">
          <input type="hidden" name="paymentlistid[0]" id="paymentlistid" value="nothing">
          <tr>
            <th align="left" width="2%" nowrap="nowrap"> <input type="checkbox" name="checkall" id="checkall" value="ON" onClick="CheckAll(this)">
              <strong>Stt</strong> </th>
            <th align="left" nowrap="nowrap"><strong>Payment name</strong></th>
            <th align="left" width="7%" nowrap="nowrap"><strong>Description</strong></th>
            <th align="left" width="7%" nowrap="nowrap"><strong>Destination allow</strong></th>
            <th align="left" width="5%" nowrap="nowrap">Position</th>
            <th align="left" width="8%">Adding Cost</th>
            <th align="left" width="5%" nowrap="nowrap">Payment type</th>
            <th align="left" width="5%" nowrap="nowrap"><strong>Status</strong></th>
            <th>&nbsp;</th>
          </tr>
          <?php if(is_array($str)){foreach($str AS $index=>$one) { ?>
          <?php $bgcolor = (($index+1)%2)==0?"bgcolor=\"#f0f8ff\"":"";
          	if($one['status']=='A'){
            	$status = 'checked';
            }else{
            	$status = '';}; ?>
          <tr <?php echo $bgcolor; ?>>
            <td align="left" nowrap="nowrap"><input type="hidden" name="paymentlistid[]" id="paymentlistid" value="<?php echo $one['payment_id']; ?>">
              <input id="<?php echo $one['payment_id']; ?>" type="checkbox" name="paymentlist[<?php echo $one['payment_id']; ?>][payment_id]" value="<?php echo $one['payment_id']; ?>">
              <strong><?php echo $index+1; ?></strong></td>
            <td align="left" ><input type="text" name="paymentlist[<?php echo $one['payment_id']; ?>][payment_name]" value="<?php echo $one['payment']; ?>" onChange="DoubleCheck(<?php echo $one['payment_id']; ?>)" class="f-input" require="true" datatype="require"></td>
            <td align="left" ><textarea type="text" name="paymentlist[<?php echo $one['payment_id']; ?>][description]" onChange="DoubleCheck(<?php echo $one['payment_id']; ?>)" style="width:150px;"><?php echo $one['description']; ?></textarea></td>
            <td align="left" >
            <?php 
            	$destination = @explode(",",$one['destination']);
            	$sql = DB::GetQueryResult("SELECT destination_id, destination_name FROM destination WHERE status='A' ORDER BY destination_name ASC", false);
                $destination_select = '<select name="paymentlist['.$one['payment_id'].'][destination][]" multiple style="width:150px;height:50px">';
                if(is_array($sql)){
                	foreach($sql AS $key=>$value) {
                    	$destid = $value['destination_id'];
                    	$destname = $value['destination_name'];
                    	if(@in_array($destid,$destination)){
                        	$selected="selected";
                    	}else{
                        	$selected="";
                    	}
                    	$destination_select .= "<option value='".$destid."' ".$selected.">".$destname."</option>";
                	}
                }
                $destination_select .= "</select>";
            
            ; ?>
            <?php echo $destination_select; ?></td>
            <td align="left" ><input type="text" name="paymentlist[<?php echo $one['payment_id']; ?>][position]" value="<?php echo $one['position']; ?>" onChange="DoubleCheck(<?php echo $one['payment_id']; ?>)" size="1" class="f-input" require="true" datatype="require"></td>
            <td align="left" nowrap="nowrap">
            	<input name="paymentlist[<?php echo $one['payment_id']; ?>][adding_cost]" value="<?php echo $one['adding_cost']; ?>" size="8" class="f-input" require="true" datatype="require" onkeypress="return check_num(this,10,event)" onchange="DoubleCheck(<?php echo $one['payment_id']; ?>)" type="text">&nbsp;<select name="paymentlist[<?php echo $one['payment_id']; ?>][adding_type]" id="a<?php echo $one['payment_id']; ?>" onchange="DoubleCheck(<?php echo $one['payment_id']; ?>)"  class="f-input" require="true" datatype="require" style="width:50px">
                	<option value="Money">vnd</option>
                    <option value="Percent">%</option>
                </select>
				<script>
					$("#a<?php echo $one['payment_id']; ?>").val("<?php echo $one['adding_type']; ?>");
				</script>
              </td>
             <td align="left"><select name="paymentlist[<?php echo $one['payment_id']; ?>][payment_type]" id="p<?php echo $one['payment_id']; ?>" onchange="DoubleCheck(<?php echo $one['payment_id']; ?>)" class="f-input" require="true" datatype="require" style="width:100px">
                	<option value="C">Tiền mặt</option>
                    <option value="O">Trực tuyến/Khác</option>
                </select>
				<script>
					$("#p<?php echo $one['payment_id']; ?>").val("<?php echo $one['payment_type']; ?>");
				</script></td>
            <td nowrap="nowrap" align="center"  ><input type="checkbox" name="paymentlist[<?php echo $one['payment_id']; ?>][status]" value="A" <?php echo $status; ?> onChange="DoubleCheck(<?php echo $one['payment_id']; ?>)"></td>
            <td>&nbsp;</td>
          </tr>
          <?php }}?>
          <tr>
            <th colspan="9" valign="top"><?php echo $pagestring; ?></th>
          </tr>
          <tr>
            <td></td>
            <td colspan="8" align="left"><input type="submit" value="Cập nhật" name="update" class="formbutton" >
              &nbsp;
              <input type="button" value="Xóa" name="dodelect" onClick="GoDelete()" class="formbutton" >
          </tr>
        </form>
        <form name="frmnew" method="POST">
          <input type="hidden" name="act" value="add">
          <tr valign="bottom" >
            <td width="20" align="center">&nbsp;</td>
            <td align="left"><input name="paymentlist[payment_name]" type="text" class="f-input" require="true" datatype="require" id="paymentlist[payment_name]"></td>
            <td align="left" ><textarea type="text" name="paymentlist[description]" onChange="DoubleCheck(<?php echo $one['id']; ?>)" style="width:150px;"></textarea></td>
            <td align="left" >&nbsp;</td>
            <td align="left" ><input type="text" name="paymentlist[position]" id="paymentlist[position]" class="f-input" require="true" datatype="require" size="1"></td>
            <td align="left" nowrap="nowrap"><input name="paymentlist[adding_cost]" value="" size="8" class="f-input" require="true" datatype="require" onkeypress="return check_num(this,10,event)" type="text">
              <select size="1" name="paymentlist[adding_type]" id="a{<?php echo $one['id']; ?>}" onchange="DoubleCheck(<?php echo $one['id']; ?>)"  class="f-input" require="true" datatype="require" style="width:50px">
                <option value="Money">vnd</option>
                <option value="Percent">%</option>
              </select></td>
            <td align="left"><select name="paymentlist[payment_type]" onchange="DoubleCheck(<?php echo $one['id']; ?>)" class="f-input" require="true" datatype="require" style="width:100px">
                	<option value="C">Tiền mặt</option>
                    <option value="O">Trực tuyến/Khác</option>
                </select>
				</td>
            <td align="center"><input type="checkbox" name="paymentlist[status]" value="A"></td>
            <td><input type="submit" value="Thêm" name="insert" class="formbutton"></td>
          </tr>
        </form>
                </table>
                    </div>
                </div>
            </div>
            <div class="box-bottom"></div>
        </div>
	</div>

<div id="sidebar">
</div>

</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("manage_footer");?>
