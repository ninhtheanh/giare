<?php include template("header");?>

<style>
.infotitle{background: #f8f8f8;
  background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#f4f4f4), to(#fcfcfc));
  background: -webkit-linear-gradient(top, #fcfcfc, #f4f4f4);
  background: -moz-linear-gradient(top, #fcfcfc, #f4f4f4);
  background: -ms-linear-gradient(top, #fcfcfc, #f4f4f4);
  background: -o-linear-gradient(top, #fcfcfc, #f4f4f4);
height: 43px;
color: #000;
font-weight: bold;
padding-left: 14px;
line-height: 38px;}
.atbox-setting{margin-top: 0px;margin-left: 39px;width: 84%;}
.title_info_setting{font-size: 19px;color: #8bcf06;border-bottom: 1px solid #ccc;padding-bottom:10px;}
</style>
<div id="bdw" class="bdw">
  <div id="bd" class="cf">
    <div id="learn">
      <div class="subdashboard" id="dashboard">
        <ul>
        
        </ul>
      </div>
      <div id="content" class="mainwide">
        <div class="box">
        <table width="100%" style="margin-top:8px; margin-bottom:20px;">
        	<tr>
            	<td valign="top" style="width:230px;">                	
                    <?php include template("thongtinhuuich");?>
                    <?php include template("menu-gioithieu");?>
                </td>
                <td valign="top">
                	<div class="atbox-setting">
                		<h2 class="title_info_setting">Lấy lại mật khẩu</h2>
                        <div class="box_form_setting" style="border: 1px solid #ccc;margin: 12px 0px;padding: 0px 15px 21px;">
                        	<?php if($_POST){?>
                                <?php } else { ?>
                                    <form method="post" action="/account/repass.php">
                                    <div style="font-style:italic;padding:10px 0px;margin-left:0px; clear:both; width:100%">Nhập Email của bạn và nhấn nút Gửi.</div></br>

                                    <div class=" email">
                                        <label class="f-label" for="reset-email" style="clear:both; display:block; "><strong>Email đăng nhập trên <?php echo $INI['system']['abbreviation']; ?></strong></label><br />

                                        <input type="text" name="email" class="f-input" id="reset-email" value="" style="clear:both; display:block;margin-bottom:10px;" /><br />
<input type="submit" class="formbutton" value="   Gửi   " style="clear:both; display:block;" />
                                    </div>
                                    </form>
                                <?php }?>
                        </div>
                    </div>
           		</td>
            </tr>
            </table>    
        
          
          <div class="box-bottom"></div>
        </div>
      </div>
    </div>
  </div>
  <!-- bd end -->
</div>
<!-- bdw end -->
<?php include template("footer");?>