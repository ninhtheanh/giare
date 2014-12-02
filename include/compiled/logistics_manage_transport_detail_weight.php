<?php include template("manage_header");?>

<div id="bdw" class="bdw">
  <div id="bd" class="cf">
    <div id="partner">
      <div class="subdashboard" id="dashboard">
        <ul>
          <?php echo mcurrent_shipper('transport'); ?>          
        </ul>
      </div>
      <div id="content" class="clear mainwide">
        <div class="clear box">
          <div class="subbox-top">
            <div class="subhead">
              <h2>Quản lý phương thức vận chuyển  <font color="#FFFF00"><?php echo $shipping_name; ?></font></h2>
            </div>
          </div>
          <div class="box-content">
            <div class="sect" style="padding-top:3px;">
              <script language="javascript" type="text/javascript">
					function CheckAll(obj)
					{
						if(obj.checked) mycheck = true;
						else mycheck = false;
						for(i=1;i<document.frmshippingrate.shippingrateid.length;i++)
						{
							obj=document.getElementById(document.frmshippingrate.shippingrateid[i].value);
							obj.checked=mycheck;
						}
					}
					function GoDelete()
					{
						ischecked = false;
						for(i=1;i<document.frmshippingrate.shippingrateid.length;i++){
							obj=document.getElementById(document.frmshippingrate.shippingrateid[i].value);
							if(obj.checked==true){
								ischecked=true;
								break;
							}
						}
						if(document.frmshippingrate.act.value=="") return false;
						if(!ischecked){
							alert("No items selected! At least one checkbox must be ticked off to perform this action.");
							return false;
						}else{
							if(confirm("Are you sure to delete these item ???")){
								if(confirm("All data of these item will be deleted...")){
										document.frmshippingrate.act.value="dodelete";
										document.frmshippingrate.dodelect.disabled=true;
										document.frmshippingrate.update.disabled=true;
										document.frmshippingrate.submit();
								}
							}
							return false;
						}
					}
					</script>
              <table class="adminlist" cellpadding="0" cellspacing="0">
                <form name="frmshippingrate" method="POST">
                  <input type="hidden" name="act" value="update">
                  <input type="hidden" name="shippingrateid[0]" id="shippingrateid" value="nothing">
                  <tr>
                    <th align="left" width="2%" nowrap="nowrap"> <input type="checkbox" name="checkall" id="checkall" value="ON" onClick="CheckAll(this)">Stt</th>
                    <th align="left">Phí vận chuyển</th>
                    <th align="left" nowrap="nowrap">Khu vực</th>
                    <th align="left" width="10%" nowrap="nowrap">Điều kiện</th>
                    <th align="left" width="5%" nowrap="nowrap">T. t.lượng đh(từ)(gr)</th>
                    <th align="left" width="5%" nowrap="nowrap">T. t.lượng đh(đến)(gr)</th>
                    <th>&nbsp;</th>
                  </tr>
                  <?php if(is_array($vs)){foreach($vs AS $index=>$one) { ?>
                  <?php $bgcolor = (($index+1)%2)==0?"bgcolor=\"#f0f8ff\"":""; if($one['display']=='Y'){$status = 'checked';}else{$status='';}; ?>
                  <tr <?php echo $bgcolor; ?>>
                    <td align="left" nowrap="nowrap"><input type="hidden" name="shippingrateid[]" id="shippingrateid" value="<?php echo $one['rate_id']; ?>">
                      <input id="<?php echo $one['rate_id']; ?>" type="checkbox" name="shippingrate[<?php echo $one['rate_id']; ?>][rate_id]" value="<?php echo $one['rate_id']; ?>"><strong><?php echo $index+1; ?></strong></td>
                    <td align="left" nowrap="nowrap"><input type="text" name="shippingrate[<?php echo $one['rate_id']; ?>][rate_value]" value="<?php echo $one['rate_value']; ?>" onChange="DoubleCheck(<?php echo $one['rate_id']; ?>)"class="f-input" require="true" datatype="require" size="8" onkeypress="return check_num(this,10,event)">
                      <select name="shippingrate[<?php echo $one['rate_id']; ?>][rate_type]" id="ra<?php echo $one['rate_id']; ?>" onchange="DoubleCheck(<?php echo $one['id']; ?>)" class="f-input" require="true" datatype="require">
                        <option value="Money">vnd</option>
                        <option value="Percent">%</option>
                      </select>
                      <script>
					$("#ra<?php echo $one['rate_id']; ?>").val("<?php echo $one['rate_type']; ?>");
				</script></td>
                    <td align="left"><select name="shippingrate[<?php echo $one['rate_id']; ?>][destination]" id="shippingrate[<?php echo $one['rate_id']; ?>][destination]" onChange="DoubleCheck(<?php echo $one['rate_id']; ?>)" class="f-input" require="true" datatype="require" style="width:200px;"><?php echo LoadDestination($one['destination_id']);; ?>
            
                      </select>
                    </td>
                    <td align="left"><select name="shippingrate[<?php echo $one['rate_id']; ?>][condition_value]" id="sr<?php echo $shipping_id; ?>" onChange="DoubleCheck(<?php echo $one['rate_id']; ?>)" disabled class="f-input" require="true" datatype="require">
                        <?php echo $conditionlist; ?>
                      </select>
                      <script>
					$("#sr<?php echo $one['rate_id']; ?>").val("<?php echo $condition_value; ?>");
				</script></td>
                   <td nowrap="nowrap" align="center"><input type="text" name="shippingrate[<?php echo $one['rate_id']; ?>][total_weight_from]" value="<?php echo $one['total_weight_from']; ?>" onChange="DoubleCheck(<?php echo $one['rate_id']; ?>)"  class="f-input" require="true" datatype="require" size="8" onkeypress="return check_num(this,10,event)"></td>
            <td><input type="text" name="shippingrate[<?php echo $one['rate_id']; ?>][total_weight_to]" value="<?php echo $one['total_weight_to']; ?>"  onChange="DoubleCheck($one['rate_id'])" class="f-input" require="true" datatype="require" onkeypress="return check_num(this,10,event)" size="8"></td>
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
                      &nbsp;
                      <input type="button" value="Quay lại" name="dodelect" onClick="window.location.href='/backend/logistics/transport.php'" class="formbutton" >
                    </td>
                  </tr>
                </form>
                <form name="frmnew" method="POST">
                  <input type="hidden" name="act" value="add">
                  <tr valign="bottom" >
                    <td width="20" align="center">&nbsp;</td>
                    <td align="left"><input size="8" name="shippingrate[rate_value]" type="text" class="f-input" require="true" datatype="require" id="shippingrate[rate_value]" onkeypress="return check_num(this,10,event)">
                      <select name="shippingrate[rate_type]" class="f-input" require="true" datatype="require">
                        <option value="Money">vnd</option>
                        <option value="Percent">%</option>
                      </select>
                    </td>
                    <td align="left" ><select name="shippingrate[destination]" id="shippingrate[destination]" onChange="DoubleCheck(<?php echo $one['rate_id']; ?>)" class="f-input" require="true" datatype="require" style="width:200px;"><?php echo $destination_list; ?></select></td>
                    <td align="left"><select name="shippingrate[condition_value]" id="cr<?php echo $shipping_id; ?>" onChange="DoubleCheck(<?php echo $one['rate_id']; ?>)" disabled class="f-input" require="true" datatype="require">
                        <?php echo $conditionlist; ?>
                      </select>
                      <script>
					$("#cr<?php echo $shipping_id; ?>").val("<?php echo $condition_value; ?>");
				</script></td>
                    <td align="center"><input type="text" name="shippingrate[total_weight_from]" class="f-input" require="true" datatype="require" onkeypress="return check_num(this,10,event)" size="8"></td>
            <td align="center"><input type="text" name="shippingrate[total_weight_to]" class="f-input" require="true" datatype="require" onkeypress="return check_num(this,10,event)" size="8"></td>
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
    <div id="sidebar"> </div>
  </div>
</div>
<!-- bd end -->
</div>
<!-- bdw end -->
<?php include template("manage_footer");?>
