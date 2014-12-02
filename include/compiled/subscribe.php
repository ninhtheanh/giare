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
.atbox_module{border: 1px solid #eaeaea; margin-bottom:10px;}
.atbox_module ul{}
.atbox_module ul li{height: 37px;border-bottom: 1px solid #e3e3e3;padding-left: 30px;}
.atbox_module ul li a{color: #646965;line-height: 40px;}
.atbox_module ul li a:hover{color:#5a9829; text-shadow:0px 0px 1px;}
.atbox-setting{margin-top: 0px;margin-left: 39px;width: 84%;}

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
                	<div class="atbox_module">
                    	<div class="infotitle">THÔNG TIN HỮU ÍCH</div>
                        <ul>
                            <li><a>Hỏi đáp</a></li>
                            <li><a>Giao hàng qua bưu điện</a></li>
                            <li><a>Trả hàng & hoàn tiền</a></li>
                            <li><a>Sử dụng Phiếu Cheapdeal</a></li>
                            <li><a>Cách thức mua hàng</a></li>
                            <li><a>Hình thức thanh toán</a></li>
                            <li><a>Tài khoản và đơn hàng</a></li>
                            <li><a>Điều khoản sử dụng</a></li>
	                    </ul>
                    </div>
                    
                    
                	<div class="atbox_module">
                    	<div class="infotitle">GIỚI THIỆU</div>
                        <ul>
                            <li><a title="cheapdeal.vn"  href="/ve-cheapdeal.html">Về Cheap Deal</a></li>
                            <li><a>Hợp tác với Cheapdeal</a></li>
                            <li><a>Cơ hội nghề nghiệp</a></li>
                            <li><a>Cơ hội nghề nghiệp</a></li>
                            <li><a>Quy chế sàn giao dịch</a></li>
                            <li><a>Thông báo</a></li>
	                    </ul>
                    </div>
                </td>
                <td valign="top">
                	<div class="atbox-setting">
                		
                        <div  align="left" style="font-size:20px;">
                  <h4>Đăng ký để nhận thông tin khuyến mãi tại <?php echo $city['name']; ?> - lên đến 90% giảm giá!</h4>
                </div>
                            
                        <div align="left" style="margin:5px 0px;">Deal hấp dẫn mỗi ngày về các dịch vụ ăn uống, giải trí, du lịch... và bạn đừng bỏ lỡ!</div>
                        <div class="enter-address">
                        <div class="enter-address-c">
                          <form id="enter-address-form" action="/subscribe.php" method="post" class="validator">
                            <table border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td align="left" valign="top"><div class="mail">
                                    <label><strong>Email của bạn</strong></label>
                                    <input id="enter-address-mail" name="email" class="f-input f-mail" type="text" value="<?php echo $login_user['email']; ?>" size="20" require="true" datatype="email" />
                                  </div></td>
                                <td valign="top" align="left"><div class="city">
                                    <label><strong>Tỉnh/TP</strong></label>
                                    <select name="city_id" class="f-city">
                                      <?php echo Utility::Option(Utility::OptionArray($hotcities, 'id', 'name'), $city['id']); ?>
                                    </select>
                                  </div></td>
                                <td align="left" valign="bottom"><input id="enter-address-commit" type="submit" class="formbutton" value="Đăng ký" /></td>
                              </tr>
                            </table>
                          </form>
                        </div>
                        <div class="clear"></div>
                        <div class="intro" style="margin: 10px 0px;">
                          <p>Deal hàng ngày của chúng tôi bao gồm: Dịch vụ ăn uống, giải trí, du lịch, thư giản, nghỉ dưỡng, đào tạo, ...</p>
                        </div></div>
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