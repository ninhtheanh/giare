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
                		<div align="left" style="padding:20px; padding-top:10px;">
                        
                        <div style="font-size:17px;padding-bottom:10px">
                               <h2 style="border-bottom: 2px solid #bebebe;color: #000;padding-bottom: 11px;font-size: 20px; text-transform:uppercase">&nbsp;Đăng ký nhận mail</h2>
                            </div>
            
                        <div style="padding-bottom:10px;">Email <strong><?php echo $_POST['email']; ?></strong> sẽ nhận được những deal mới hàng ngày của Cheapdeal ở <strong><?php echo $city['name']; ?></strong></div>
                      <div class="side-tip-help" style="padding-left:15px; padding-right:15px;">
                        <p style="padding-top:15px; line-height:18px;">
                            <span><strong>A.</strong> Có deal chất lượng mỗi ngày.</span>
                        </p>
                        <p style="padding-bottom:15px; padding-top:15px;">
                            <span><strong>B.</strong> Bạn sẽ có mức giảm giá chưa từng thấy trước đây.</span>
                        </p>
                        <p>
                            <span><strong>C.</strong> Hãy quay lại <?php echo $INI['system']['abbreviation']; ?> mỗi ngày để nhận những ưu đãi bất ngờ.</span>
                        </p>
                    	</div>
                    
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