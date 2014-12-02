<?php include template("manage_header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_shipper('transport'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
             <div class="subbox-top"> <div class="subhead"><h2>Quản lý phương thức vận chuyển</h2></div></div>
            <div class="box-content">
              <div class="sect" style="padding-top:3px;">
                	<script language="javascript" type="text/javascript">
					function CheckAll(obj)
					{
						if(obj.checked) mycheck = true;
						else mycheck = false;
						for(i=1;i<document.frmshippinglist.shippinglistid.length;i++)
						{
							obj=document.getElementById(document.frmshippinglist.shippinglistid[i].value);
							obj.checked=mycheck;
						}
					}
					function GoDelete()
					{
						ischecked = false;
						for(i=1;i<document.frmshippinglist.shippinglistid.length;i++){
							obj=document.getElementById(document.frmshippinglist.shippinglistid[i].value);
							if(obj.checked==true){
								ischecked=true;
								break;
							}
						}
						if(document.frmshippinglist.act.value=="") return false;
						if(!ischecked){
							alert("No items selected! At least one checkbox must be ticked off to perform this action.");
							return false;
						}else{
							if(confirm("Are you sure to delete these item ???")){
								if(confirm("All data of these item will be deleted...")){
										document.frmshippinglist.act.value="dodelete";
										document.frmshippinglist.dodelect.disabled=true;
										document.frmshippinglist.update.disabled=true;
										document.frmshippinglist.submit();
								}
							}
							return false;
						}
					}
					</script><table class="adminlist" cellpadding="0" cellspacing="0">
                    <form name="frmshippinglist" method="POST" class="validator">
                      <input type="hidden" name="act" value="update">
                      <input type="hidden" name="shippinglistid[0]" id="shippinglistid" value="nothing">
                      <tr>
                        <th align="left" width="2%" nowrap="nowrap"> <input type="checkbox" name="checkall" id="checkall" value="ON" onClick="CheckAll(this)">Stt</th>
                        <th align="left">Tên phương thức vận chuyển</th>
                        <th align="left" nowrap="nowrap">Thời gian giao hàng</th>
                       
                        <th align="left" width="5%" nowrap="nowrap">Điều kiện</th>
                        <th align="left" width="5%" nowrap="nowrap">Vị trí hiển thị</th>
                        <th align="left" width="5%" nowrap="nowrap">Trạng thái</th>
                        <th>&nbsp;</th>
                      </tr>
                      <?php if(is_array($str)){foreach($str AS $index=>$one) { ?>
                      <?php $bgcolor = (($index+1)%2)==0?"bgcolor=\"#f0f8ff\"":"";; ?>
                      <tr <?php echo $bgcolor; ?>>
                        <td align="left" nowrap="nowrap"><input type="hidden" name="shippinglistid[]" id="shippinglistid" value="<?php echo $one['shipping_id']; ?>">
                          <input id="<?php echo $one['shipping_id']; ?>" type="checkbox" name="shippinglist[<?php echo $one['shipping_id']; ?>][shipping_id]" value="<?php echo $one['shipping_id']; ?>">
                          <strong><?php echo $index+1; ?></strong></td>
                        <td align="left" ><input type="text" name="shippinglist[<?php echo $one['shipping_id']; ?>][shipping_name]" id="shipping_name" value="<?php echo $one['shipping_name']; ?>" onChange="DoubleCheck(<?php echo $one['shipping_id']; ?>)" class="f-input" require="true" datatype="require" size="30"></td>
                        <td align="left" ><input type="text" name="shippinglist[<?php echo $one['shipping_id']; ?>][delivery_time]" id="delivery_time" onChange="DoubleCheck(<?php echo $one['shipping_id']; ?>)" value="<?php echo $one['delivery_time']; ?>" class="f-input" require="true" datatype="require" size="30"></td>
                        <?php $conditionlist = ShippingCondition($one['condition_value']);$status = $one['status']?'checked':'';; ?>
                        <td align="left"><select class="f-input" name="shippinglist[<?php echo $one['shipping_id']; ?>][condition_value]" id="s<?php echo $one['shipping_id']; ?>" onchange="DoubleCheck(<?php echo $one['shipping_id']; ?>)"><?php echo $conditionlist; ?></select>
                           <script>
                                $("#s<?php echo $one['shipping_id']; ?>").val("<?php echo $one['condition_value']; ?>");
                            </script></td>
                        <td align="left" ><input type="text" name="shippinglist[<?php echo $one['shipping_id']; ?>][position]" value="<?php echo $one['position']; ?>" id="position" onChange="DoubleCheck(<?php echo $one['shipping_id']; ?>)" style="width:50px;"  class="f-input" require="true" datatype="require"></td>
                        <td nowrap="nowrap" align="center"  ><input type="checkbox" name="shippinglist[<?php echo $one['shipping_id']; ?>][status]" value="A" <?php echo $status; ?> onChange="DoubleCheck(<?php echo $one['shipping_id']; ?>)"></td>
                        <td><a href="/backend/logistics/transport.php?shippingid=<?php echo $one['shipping_id']; ?>" class="propath"><strong>&#9658; Chi tiết</strong></a></td>
                      </tr>
                      <?php }}?>
                      <tr>
                        <th colspan="9" valign="top"><p align="center"><?php echo $pagestring; ?></p></th>
                      </tr>
                      <tr>
                        <td></td>
                        <td colspan="8" align="left"><input type="submit" value="Cập nhật" name="update" class="formbutton" >
                          &nbsp;<input type="button" value="Xóa" name="dodelect" onClick="GoDelete()" class="formbutton" ></td> </tr>
                    </form>
                    <form name="frmnew" method="POST" class="validator">
                      <input type="hidden" name="act" value="add">
                      <tr valign="bottom" >
                        <td width="20" align="center">&nbsp;</td>
                        <td align="left"><input name="shippinglist[shipping_name]" type="text" class="f-input" id="shippinglist[shipping_name]" require="true" datatype="require" size="30"></td>
                        <td align="left" ><input type="text" name="shippinglist[delivery_time]" onChange="DoubleCheck($id)" class="f-input" require="true" datatype="require" size="30"></td>
                       
                        <td align="left"><select name="shippinglist[condition_value]" onchange="DoubleCheck(<?php echo $id; ?>)" class="f-input">
                                <?php echo $condition_list; ?>
                            </select>
                            </td>
                         <td align="left" ><input type="text" name="shippinglist[position]" id="shippinglist[position]" class="f-input" require="true" datatype="require" style="width:50px;"></td>
                        <td align="center"><input type="checkbox" name="shippinglist[status]" value="A"></td>
                        <td><input type="submit" value="Thêm mới" name="insert" class="formbutton"></td>
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
