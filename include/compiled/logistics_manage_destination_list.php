<?php include template("manage_header");?>

<div id="bdw" class="bdw">
  <div id="bd" class="cf">
    <div id="partner">
      <div class="subdashboard" id="dashboard">
        <ul>
          <?php echo mcurrent_shipper('null'); ?>
          <li class="current"><a href="/backend/logistics/destination.php">Khu vực GH</a><span></span></li>
        </ul>
      </div>
      <div id="content" class="clear mainwide">
        <div class="clear box">
          <div class="subbox-top">
            <div class="subhead">
              <h2>Quản lý khu vực giao hàng</h2>
            </div>
          </div>
          <div class="box-content">
            <div class="sect" style="padding-top:3px;">
              <script language="javascript" type="text/javascript">
						function CheckAll(obj)
						{
							if(obj.checked) mycheck = true;
							else mycheck = false;
							for(i=1;i<document.frmdestination.destinationid.length;i++)
							{
								obj=document.getElementById(document.frmdestination.destinationid[i].value);
								obj.checked=mycheck;
							}
						}
						function GoDelete()
						{
							ischecked = false;
							for(i=1;i<document.frmdestination.destinationid.length;i++)
							{
								obj=document.getElementById(document.frmdestination.destinationid[i].value);
								if(obj.checked==true){
									ischecked=true;
									break;
								}
							}
							if(document.frmdestination.act.value=="") return false;
							if(!ischecked){
								alert("No items selected! At least one checkbox must be ticked off to perform this action.");
								return false;
							}else{
								if(confirm("Are you sure to delete these item ???")){
									if(confirm("All data of these item will be deleted...")){
										document.frmdestination.act.value="delete";
										document.frmdestination.dodelect.disabled=true;
										document.frmdestination.update.disabled=true;
										document.frmdestination.submit();
									}
								}
								return false;
							}
						}
						</script>
              <table class="adminlist" cellpadding="0" cellspacing="0">
                <form name="frmdestination" method="POST">
                  <input type="hidden" name="act" value="update">
                  <input type="hidden" name="destinationid[0]" id="destinationid" value="nothing">
                  <tr>
                    <th align="left" width="5%" nowrap="nowrap"> <input type="checkbox" name="checkall" id="checkall" value="ON" onClick="CheckAll(this)">Stt</th>
                    <th align="left" >Destination name</th>
                    <th align="left" width="7%" nowrap="nowrap">Status</th>
                    <th align="left" width="12%">&nbsp;</th>
                  </tr>
                  <?php if(is_array($str)){foreach($str AS $index=>$one) { ?>
                  <?php $bgcolor = (($index+1)%2)==0?"bgcolor=\"#f0f8ff\"":"";$status = $one['status']?'checked':'';; ?>
                  <tr <?php echo $bgcolor; ?>>
                    <td align="left" nowrap="nowrap"><input type="hidden" name="destinationid[]" id="destinationid" value="<?php echo $one['destination_id']; ?>">
                      <input id="<?php echo $one['destination_id']; ?>" type="checkbox" name="destination[<?php echo $one['destination_id']; ?>][destination_id]" value="<?php echo $one['destination_id']; ?>">
                      <strong><?php echo $index+1; ?></strong></td>
                    <td align="left" ><input type="text" name="destination[<?php echo $one['destination_id']; ?>][destination_name]" value="<?php echo $one['destination_name']; ?>" onChange="DoubleCheck(<?php echo $one['destination_id']; ?>)" class="f-input" require="true" datatype="require" size="60"></td>
                    <td nowrap="nowrap" align="center"><input type="checkbox" name="destination[<?php echo $one['destination_id']; ?>][active]" value="A" <?php echo $status; ?> onChange="DoubleCheck(<?php echo $one['destination_id']; ?>)"></td>
                    <td align="left" width="12%"><a href="/backend/logistics/destination.php?destid=<?php echo $one['destination_id']; ?>" class="propath"><strong>&#9658; Chi tiết</strong></a></td>
                  </tr>
                  <?php }}?>
                  <tr>
                    <th colspan="7" valign="top"><p align="center"><?php echo $pagestring; ?></p></th>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="7" align="left"><input type="submit" value="Cập nhật" name="update" class="formbutton" >
                      &nbsp;
                      <input type="button" value="Xóa" name="dodelect" onClick="GoDelete()" class="formbutton" ></td>
                  </tr>
                </form>
                <form name="frmnew" method="POST">
                  <input type="hidden" name="act" value="add">
                  <tr valign="bottom" >
                    <td width="20" align="center">&nbsp;</td>
                    <td align="left"><input name="destination[destination_name]" type="text" class="f-input" require="true" datatype="require" size="60" id="destination[destination_name]"></td>
                    <td align="center"><input type="checkbox" name="destination[active]" value="A"></td>
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
