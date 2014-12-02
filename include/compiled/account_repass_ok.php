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
                		<h2 class="title_info_setting">Khôi phục mật khẩu</h2>
                        <div class="box_form_setting" style="border: 1px solid #ccc;margin: 12px 0px;padding: 0px 15px 21px;">
                        	<p class="notice"><strong> <?php echo $INI['system']['abbreviation']; ?></strong> đã gởi link đổi mật khẩu mới vào email của bạn, xin vui lòng kiểm tra mail <strong><?php echo $_SESSION['reemail']; ?></strong> và click vào liên kết trong email để thiết lập lại mật khẩu của bạn.</p>
                                    <p class="notice" style="color:#c40000">Nếu trong hộp thư <strong>Inbox</strong> không có email, bạn vui lòng kiển tra trong <strong>Spam</strong> hoặc <strong>Bulk</strong>.</p>
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