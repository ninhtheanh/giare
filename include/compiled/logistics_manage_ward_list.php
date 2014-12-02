<?php include template("manage_header");?>

<div id="bdw" class="bdw">
  <div id="bd" class="cf">
    <div id="partner">
      <div class="subdashboard" id="dashboard">
        <ul>
          <?php echo mcurrent_shipper('null'); ?>
          <li class="current"><a href="/backend/logistics/ward.php">Phường - Xã</a><span></span></li>
        </ul>
      </div>
      <div id="content" class="clear mainwide">
        <div class="clear box">
          <div class="subbox-top">
            <div class="subhead">
              <h2>Quản lý Phường - Xã</h2>
            </div>
          </div>
          <div class="box-content">
            <div class="sect" style="padding-top:3px;">
              <script language="javascript" type="text/javascript">
					function CheckAll(obj)
					{
						if(obj.checked) mycheck = true;
						else mycheck = false;
						for(i=1;i<document.frmcountryward.countrywardid.length;i++)
						{
							obj=document.getElementById(document.frmcountryward.countrywardid[i].value);
							obj.checked=mycheck;
						}
					}
					function GoDelete()
					{
						ischecked = false;
						for(i=1;i<document.frmcountryward.countrywardid.length;i++)
						{
							obj=document.getElementById(document.frmcountryward.countrywardid[i].value);
							if(obj.checked==true){
								ischecked=true;
								break;
							}
						}
						if(document.frmcountryward.act.value=="") return false;
						if(!ischecked){
							alert("No items selected! At least one checkbox must be ticked off to perform this action.");
							return false;
						}else{
							if(confirm("Are you sure to delete these item ???")){
								if(confirm("All data of these item will be deleted...")){
									document.frmcountryward.act.value="delete";
									document.frmcountryward.dodelect.disabled=true;
									document.frmcountryward.update.disabled=true;
									document.frmcountryward.submit();
								}
							}
							return false;
						}
					}
				</script>
              <tr>
                <td align="left" style="padding:5px;"><table border="0" cellspacing="1">
                    <form name="frmsearch" method="GET">
                      <input type="hidden" name="page">
                      <tr>
                        <td><strong>Country Name</strong></td>
                        <td><select size="1" name="search[country_code]" id="country_code" onChange="document.frmsearch.submit();" class="f-input" require="true" datatype="require"><option value="">All</option><?php echo $listcountry; ?></select></td>
                        <td><strong>State Name</strong></td>
                        <td><select size="1" name="search[state_id]" id="state_id" onChange="document.frmsearch.submit();" class="f-input" require="true" datatype="require">
                            <option value="">All</option>
                            <?php echo $liststate; ?>
                          </select></td>
                          <td><strong>Ward Name</strong></td>
                        <td><select size="1" name="search[dist_id]" id="dist_id" onChange="document.frmsearch.submit();" class="f-input" require="true" datatype="require">
                            <option value="">All</option>
                            <?php echo $listdist; ?>
                          </select></td>
                        <script>$("#country_code").attr("value")="<?php echo $country_code; ?>";$("#state_id").attr("value")="<?php echo $state_id; ?>";$("#dist_id").attr("value")="<?php echo $dist_id; ?>";</script>
                      </tr>
                    </form>
                  </table></td>
              </tr>
              <table class="adminlist" cellpadding="0" cellspacing="0">
                <form name="frmcountryward" method="POST">
                  <input type="hidden" name="act" value="update">
                  <input type="hidden" name="countrywardid[0]" id="countrywardid" value="nothing">
                  <tr>
                    <th align="left" width="5%" nowrap="nowrap"> <input type="checkbox" name="checkall" id="checkall" value="ON" onClick="CheckAll(this)">Stt</th>
                    <th width="60" align="center" nowrap="nowrap"> Ward Name</th>
                    <th align="left" >Dist Name</th>
                    <th>Status</th>
                    <th>&nbsp; </th>
                  </tr>
                  <?php if(is_array($str)){foreach($str AS $index=>$one) { ?>
                  <?php $bgcolor = (($index+1)%2)==0?"bgcolor=\"#f0f8ff\"":"";$status = $one['active']?'checked':'';; ?>
                  <tr <?php echo $bgcolor; ?>>
                    <td align="left" nowrap="nowrap"><input type="hidden" name="countrywardid[]" id="countrywardid" value="<?php echo $one['id']; ?>">
                      <input id="<?php echo $one['id']; ?>" type="checkbox" name="countryward[<?php echo $one['id']; ?>][id]" value="<?php echo $one['id']; ?>">
                      <strong><?php echo $index+1; ?></strong> </td>
                    <td align="left" width="50%"><input name="countryward[<?php echo $one['id']; ?>][ward_name]" value="<?php echo $one['ward_name']; ?>" size="60" class="f-input" require="true" datatype="require" onkeypress="return check_length(this,4,event)" onchange="DoubleCheck($one['country_code'])" type="text">
                    </td>
                    <td align="left" ><select name="countryward[<?php echo $one['id']; ?>][dist_id]" class="f-input" require="true" datatype="require"><?php echo LoadDist($one['dist_id'],$state,$s_country); ?></select>
                    </td>
                    <td nowrap="nowrap" align="left"  ><input type="checkbox" name="countryward[<?php echo $one['id']; ?>][active]" value="Y" <?php echo $status; ?> onChange="DoubleCheck(<?php echo $one['id']; ?>)"></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php }}?>
                  <tr>
                    <th colspan="8" valign="top"><?php echo $pagestring; ?></th>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="7" align="left"><input type="submit" value="Cập nhật" name="update" class="formbutton" >
                      &nbsp;
                      <input type="button" value="Xóa" name="dodelect" onClick="GoDelete()" class="formbutton" >
                    </td>
                  </tr>
                </form>
                <form name="frmnew" method="POST">
                  <input type="hidden" name="act" value="add">
                  <tr valign="bottom" >
                    <td width="20" align="center">&nbsp;</td>
                    <td align="left"><input name="countryward[ward_name]" type="text" size="60" class="f-input" require="true" datatype="require" id="countryward[ward_name]"></td>
                    <td align="left"><select name="countryward[dist_id]" class="f-input" require="true" datatype="require">
                        <option value=""></option>
                        <?php echo $listdist; ?>
                      </select></td>
                    <td align="left"><input type="checkbox" name="countryward[active]" value="Y" checked="checked"></td>
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
