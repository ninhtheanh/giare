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
              <h2>Quản lý khu vực giao hàng - <font color="#FFFF00"><?php echo $destination_name; ?></font></h2>
            </div>
          </div>
          <div class="box-content">
            <div class="sect" style="padding-top:3px;">
              <script type="text/javascript">  
					$().ready(function() {  
						$('#addcountry').click(function() {  
							return !$('#country1 option:selected').remove().appendTo('#country2');  
						});  
						$('#removecountry').click(function() {  
							return !$('#country2 option:selected').remove().appendTo('#country1');  
						});  
						
						$('#addstate').click(function() {  
							return !$('#state1 option:selected').remove().appendTo('#state2');  
						});  
						$('#removestate').click(function() {  
							return !$('#state2 option:selected').remove().appendTo('#state1');  
						}); 
						
						$('#adddist').click(function() {  
							return !$('#dist1 option:selected').remove().appendTo('#dist2');  
						});  
						$('#removedist').click(function() {  
							return !$('#dist2 option:selected').remove().appendTo('#dist1');  
						});  
					}); 
					function check_submit(){
						obj = document.getElementById('country');
						for(i=0;i<obj.length;i++)
							obj[i].selected=true;
						
						obj = document.getElementById('state');
						for(i=0;i<obj.length;i++)
							obj[i].selected=true;
							
						obj = document.getElementById('dist');
						for(i=0;i<obj.length;i++)
							obj[i].selected=true;
				
						return true;
					}
				</script>  
				<style type="text/css">  
				TABLE.adminlistdest {
					BORDER-RIGHT: #ddd 1px solid; PADDING-RIGHT: 0px; BORDER-TOP: #ddd 1px solid; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; BORDER-LEFT: #ddd 1px solid; PADDING-TOP: 0px; BORDER-BOTTOM: #ddd 1px solid; BORDER-COLLAPSE: collapse; BACKGROUND-COLOR: #ffffff; border-spacing: 0px; width:100%;
				}
				TABLE.adminlistdest th {
					PADDING-RIGHT: 4px; PADDING-LEFT: 4px; FONT-SIZE: 12px; BACKGROUND-COLOR:#F0F0F0; MARING-BOTTOM: 4px; MARGIN: 0px; COLOR: #910000;  HEIGHT: 24px; text-align:left;
				}
				TABLE.adminlistdest th.title {
					TEXT-ALIGN: left
				}
				TABLE.adminlistdest th A:link {
					COLOR: #c64934; TEXT-DECORATION: none
				}
				TABLE.adminlistdest th A:visited {
					COLOR: #c64934; TEXT-DECORATION: none
				}
				TABLE.adminlistdest th A:hover {
					TEXT-DECORATION: underline
				}
				TABLE.adminlistdest td {
					PADDING-RIGHT: 4px; PADDING-LEFT: 4px; PADDING-BOTTOM: 4px; PADDING-TOP: 4px; BORDER-BOTTOM: #e5e5e5 1px solid
				}
				
				TABLE.adminlistdest TD.options {
					FONT-SIZE: 8px; BACKGROUND-COLOR: #ffffff
				}
				.selectmulti{  
					width: 300px;  
					height: 150px;  
				}
				</style>
              <table class="adminlistdest" cellpadding="0" cellspacing="0">
                <form name="frmdestinationlist" method="POST" onSubmit="return check_submit();">
                  <input type=hidden name="dest_id" value='<?php echo $dest_id; ?>'>
                  <tr>
                    <th align="left" nowrap="nowrap" colspan="3"><strong>Country</strong> </th>
                  </tr>
                  <tr>
                    <td align="right" nowrap="nowrap" style="padding-left:30px" width="30%"><select name="country" multiple class="selectmulti" id="country1">
                      <?php echo $option_country_1st; ?>
                    </select></td>
                    <td align="center" style="width:20px"><img id="addcountry" src="/static/css/images/to_right_icon.gif" border="0" title="Add Country &gt;&gt;" class="hand" /><br />
                      <br />
                    <img id="removecountry" src="/static/css/images/to_left_icon.gif" border="0" title="&lt;&lt; Remove Country" class="hand" /></p></td>
                    <td width="598" align="left" nowrap="nowrap">
                      <select multiple id="country2" name="destination[country][]" class="selectmulti">
                            <?php echo $country_curr; ?>
                      </select>  			</td>
                  </tr>
                    <tr><th align="left" colspan="3"><strong>State</strong></th></tr>
                    <tr><td align="right" style="padding-left:30px">  
                       <select multiple id="state1" class="selectmulti">  
                         <?php echo $option_state_1st; ?> 
                       </select>  
                     </td>
                     <td style="width:20px;" align="center"><p><img id="addstate" src="/static/css/images/to_right_icon.gif" border="0" title="Add State &gt;&gt;" class="hand" /><br />
                         <br />
                        <img id="removestate" src="/static/css/images/to_left_icon.gif" border="0" title="&lt;&lt; Remove State" class="hand" /></p>
                     </td>
                     <td align="left">
                    <select multiple id="state2" name="destination[state][]" class="selectmulti">
                       <?php echo $state_curr; ?>
                    </select>            </td>
                    </tr>
                    <tr><th align="left" colspan="3"><strong>Dist</strong></th></tr>
                    <tr>
                     <td align="right"  style="padding-left:30px">
                       <select multiple id="dist1" class="selectmulti">  
                        <?php echo $dist_1st; ?>
                       </select> 			 </td>
                     <td style="width:20px;" align="center"><p><img id="adddist" src="/static/css/images/to_right_icon.gif" border="0" title="Add Dist &gt;&gt;" class="hand" /><br />
                         <br />
                        <img id="removedist" src="/static/css/images/to_left_icon.gif" border="0" title="&lt;&lt; Remove Dist" class="hand" /></p>
                     </td>
                     <td align="left"> 
                    <select multiple id="dist2" name="destination[dist][]" class="selectmulti">
                        <?php echo $dist_curr; ?>
                    </select>            </td>
                  </tr>
                  <tr>
                    <td colspan="7" align="left"><input type="submit" value="Cập nhật" name="update" class="formbutton" >&nbsp;
                      <input type="button" value="Quay lại" name="dodelect" onClick="window.location.href='<?php echo $_config['index.php']; ?>?<?php echo $_config['target']; ?>=countrydestination'" class="formbutton" ></td>
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
