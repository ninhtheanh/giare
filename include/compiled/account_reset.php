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
.tablereset tr td{padding: 9px;}
.athit{font-size: 12px;color: #989898;font-style: italic;margin-top: 2px;display: block;}
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
                        	<form method="post" action="/account/reset.php?code=<?php echo $code; ?>">
                            	<table width="100%" class="tablereset" style="margin-top: 17px;">
                                	<tr>
                                    	<td width="150px"><label class="f-label" for="reset-password">Mật khẩu mới</label></td>
                                        <td><input type="password" name="password" value="" id="reset-password" class="f-input" maxlength="32" /><br />
<span class="athit">Ít nhất 6 ký tự</span></td>
                                    </tr>
                                    <tr>
                                    	<td><label class="f-label" for="reset-password2">Nhập lại mật khẩu</label></td>
                                        <td><input type="password" name="password2" value="" id="reset-password2" class="f-input" maxlength="32" /><br />
<span class="athit">Nhập lại mật khẩu mới bạn vừa nhập bên trên</span></td>
                                    </tr>
                                    <tr>
                                    	<td></td>
                                        <td>
                                        <input type="hidden" name="code" value="<?php echo $code; ?>" />
                                <input type="submit" class="formbutton" value="Đổi mật khẩu" />
                                        </td>
                                    </tr>
                                </table>
                            </form>
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