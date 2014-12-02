<?php include template("header");?>
<?php  
$uri =  $_SERVER['REQUEST_URI'];

?>
<script type="text/javascript" src="/static/js/datepicker/WdatePicker.js"></script>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="settings">
<?php  	/*  <div class="subdashboard" id="dashboard">
		<ul><?php echo current_account('/account/settings.php'); ?></ul>
	</div>  */ ?>
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

.atbox-setting{margin-top: 0px;margin-left: 39px;}
.title_info_setting{font-size: 19px;color: #8bcf06;border-bottom: 1px solid #ccc;padding-bottom:10px;}
.boxsubinfo{border: 1px solid #9e9a9b;padding: 10px;}
.box_title_info_clear{margin-top: 10px;margin-bottom: 8px;}
.boxsubinfo label{text-align:left !important;}
</style>
    <div id="contentfontend" class="mainwide clear settings-box">
		<div class="box clear">
        <table width="100%" style="margin-top:8px;">
        	<tr>
            	<td valign="top" style="width:230px;">
                	 <?php include template("menutaikhoan");?>
                </td>
                <td valign="top">
                 	<div class="atbox-setting" style="width: 92%;margin-left: 20px;padding: 10px;border: 1px solid #ccc;box-shadow: 0px 0px 5px #ccc;">
                    	<h2 class="title_info_setting">Thông báo đặt hàng thành công</h2>
                       	<table>
                        	<tr>
                            	<td>
                                	<img src="static/img/order_success.png" />
                                </td>
                                <td>
                                	<ul>
                                    	<li>Cảm ơn bạn đã đặt hàng tại <strong>Cheapdeal</strong></li>
                                        <li>Mã số đơn hàng của bạn là <span style="color: #3bb34a;font-weight: bold;font-size: 20px;padding-left: 7px;"><?php echo Session::Get('idcarlog'); ?></span></li>
                                        <li>Để theo dõi trạng thái của đơn hang vui lòng vào <a href="/order/index.php">Quản lý đơn hàng</a></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="2">
                                	<!--<a href="http://cheapdeal.vn/" style="font-size: 16px;color: #FFFFFF;display: block;padding-left: 6px;width: 245px;margin: 0px auto;height: 45px;" class="ataddcart boxbuttoncss">-->
                                    <a href="/index.php" style="font-size: 16px;color: #FFFFFF;display: block;padding-left: 6px;width: 208px;margin: 0px auto;height: 50px;" >
                                        <div class="buttoncss" style="width: 237px;height: 35px;font-size: 19px;line-height: 34px;">Tiếp tục mua hàng</div>
                                        
                          </a>
                                </td>
                            </tr>
                        </table>
                     </div>
                </td>
            </tr>
        </table>
        
            
        </div>
    </div>
</div>

<!-- Google Code for Thanhcong Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 998479224;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "IkEUCPil4gkQ-KqO3AM";
var google_conversion_value = 1;
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/998479224/?value=1&amp;label=IkEUCPil4gkQ-KqO3AM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<!-- Facebook Code for thanhcong.php Conversion Page -->
<script type="text/javascript">
var fb_param = {};
fb_param.pixel_id = '6009591163871';
fb_param.value = '0.00';
fb_param.currency = 'VND';
(function(){
  var fpw = document.createElement('script');
  fpw.async = true;
  fpw.src = '//connect.facebook.net/en_US/fp.js';
  var ref = document.getElementsByTagName('script')[0];
  ref.parentNode.insertBefore(fpw, ref);
})();
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/offsite_event.php?id=6009591163871&amp;value=0&amp;currency=VND" /></noscript>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("footer");?>
