<?php include template("manage_header");?>

<div id="bdw" class="bdw">
  <div id="bd" class="cf">
    <div id="partner">
      <div class="subdashboard" id="dashboard">
        <ul>
          <?php echo mcurrent_shipper('null'); ?>
          <li class="current"><a href="/backend/logistics/province-city.php">Tỉnh - TP</a><span></span></li>
        </ul>
      </div>
      <div id="content" class="clear mainwide">
        <div class="clear box">
          <div class="subbox-top">
            <div class="subhead">
              <h2>Quản lý Tỉnh - Thành Phố</h2>
            </div>
          </div>
          <div class="box-content">
            <div class="sect" style="padding-top:3px;">
              <script language="javascript" type="text/javascript">
				function CheckAll(obj)
				{
					if(obj.checked) mycheck = true;
					else mycheck = false;
					for(i=1;i<document.frmcountrystate.countrystateid.length;i++)
					{
						obj=document.getElementById(document.frmcountrystate.countrystateid[i].value);
						obj.checked=mycheck;
					}
				}
				function GoDelete()
				{
					ischecked = false;
					for(i=1;i<document.frmcountrystate.countrystateid.length;i++)
					{
						obj=document.getElementById(document.frmcountrystate.countrystateid[i].value);
						if(obj.checked==true){
							ischecked=true;
							break;
						}
					}
					if(document.frmcountrystate.act.value=="") return false;
					if(!ischecked){
						alert("No items selected! At least one checkbox must be ticked off to perform this action.");
						return false;
					}else{
						if(confirm("Are you sure to delete these item ???")){
							if(confirm("All data of these item will be deleted...")){
								document.frmcountrystate.act.value="delete";
								document.frmcountrystate.dodelect.disabled=true;
								document.frmcountrystate.update.disabled=true;
								document.frmcountrystate.submit();
							}
						}
						return false;
					}
				}
				</script>
              <table class="adminlist" cellpadding="0" cellspacing="0">
                <form name="frmcountrystate" method="POST">
                  <input type="hidden" name="act" value="update">
                  <input type="hidden" name="countrystateid[0]" id="countrystateid" value="nothing">
                  <tr>
                    <th align="left" width="5%" nowrap="nowrap"> <input type="checkbox" name="checkall" id="checkall" value="ON" onClick="CheckAll(this)">Stt</th>
                    <th align="left" >Name</th>
                    <th align="left" width="7%" nowrap="nowrap">Country</th>
                    <th>States</th>
                    <th>&nbsp; </th>
                  </tr>
                  <?php if(is_array($str)){foreach($str AS $index=>$one) { ?>
                  <?php $bgcolor = (($index+1)%2)==0?"bgcolor=\"#f0f8ff\"":""; if($one['display']=='Y'){$status = 'checked';}else{$status='';}; ?>
                  <tr  <?php echo $bgcolor; ?>>
                    <td align="left" nowrap="nowrap"><input type="hidden" name="countrystateid[]" id="countrystateid" value="<?php echo $one['id']; ?>">
                      <input id="<?php echo $one['id']; ?>" type="checkbox" name="countrystate[<?php echo $one['id']; ?>][id]" value="<?php echo $one['id']; ?>">
                      <strong><?php echo $index+1; ?></strong> </td>
                    <td align="left" ><input type="text" name="countrystate[<?php echo $one['id']; ?>][name]" value="<?php echo $one['name']; ?>" onChange="DoubleCheck(<?php echo $one['id']; ?>)" class="f-input" require="true" datatype="require" size="60">
                    </td>
                    <td align="left" nowrap="nowrap"><select name="countrystate[<?php echo $one['id']; ?>][country_code]" onChange="DoubleCheck(<?php echo $one['id']; ?>)" class="f-input" require="true" datatype="require">
                        <option value="VN" selected>Việt Nam</option>
                      </select>
                    </td>
                    <td nowrap="nowrap" align="left"  ><input type="checkbox" name="countrystate[<?php echo $one['id']; ?>][active]" value="Y" <?php echo $status; ?> onChange="DoubleCheck(<?php echo $one['id']; ?>)"></td>
                    <td>
                    <?php 
                        $dist = DB::GetQueryResult("SELECT COUNT(*) as total_dist FROM countries_district WHERE state_id=".$one['id']);
                    ; ?>
                    <!--{if(!empty($dist))}-->
                        	<a href="/backend/logistics/district.php?search[country_code]=VN&search[state_id]=<?php echo $one['id']; ?>" class="propath"><strong>Xem <font color="#000000" style="font-size:13px;font-family:Arial"><?php echo $dist['total_dist']; ?></font> quận - huyện thuộc<font color="#000000" style="font-size:13px;font-family:Arial"> <?php echo $one['name']; ?></font></strong></a>
                   <!--{/if}--></td>
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
                  <tr height="40" valign="bottom" >
                    <td width="20" align="center">&nbsp;</td>
                    <td align="left"><input name="countrystate[name]" type="text"  class="f-input" require="true" datatype="require" size="60" id="countrystate[name]"></td>
                    <td width="100" align="left" nowrap="nowrap"><select name="countrystate[country_code]" class="f-input" require="true" datatype="require">
                        <option value="VN" selected>Việt Nam</option></select></td>
                    <td align="left"><input type="checkbox" name="countrystate[active]" value="Y"></td>
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
