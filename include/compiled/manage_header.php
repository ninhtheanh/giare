<?php include template("manage_html_header");?>
<script type="text/javascript" src="/static/js/xheditor/xheditor.js"></script> 

<div id="hdw" style="height:120px;">
	<div id="hd">
		<div id="logo" align="left"><a href="/" class="link" target="_blank"><img src="/static/css/images/logo.jpg" height="80" /></a></div>
		<div class="guides">
			<div class="city" style="margin-top:-20px;">
				<h2>Backend - <?php echo $city['name']; ?></h2>
			</div>
			<!--<div id="guides-city-change" class="change">&nbsp;</div>-->     </br>      
            <?php if(is_manager()){?><div align="right"><?php echo $login_user['realname']; ?>&nbsp;&raquo;&nbsp;<a href="/backend/logout.php" style="color:#000000"><strong>Manager Logout</strong></a></div><?php }?>
		</div>
		<ul class="nav2 cf"><?php echo current_backend('super'); ?></ul>
	</div>
</div>
<!--sidebar-->
    <div style="padding: 7px; background-image: -moz-linear-gradient(center top , rgb(220, 22, 18), rgb(187, 19, 15)); background-color: rgb(187, 19, 15);background-repeat: repeat-x; color: white;width: 86%;">
	<span><strong>Quy trình điều phối đối với đơn hàng tỉnh và đơn hàng thành phố đã được cập nhật tại đây</strong> <a href="http://bit.ly/16T9tNR" style="color: #FFFFFF;"><strong> ► Click here ◄</strong></a>
	 </span>
	</div>
<!--sidebar
    <div style="padding: 7px; background-image: -moz-linear-gradient(center top , rgb(220, 22, 18), rgb(187, 19, 15)); background-color: rgb(187, 19, 15);background-repeat: repeat-x; color: white;width: 86%;">
	<span><strong>Tham gia trả lời khách hàng thông qua Live Support tại góc trái, bên dưới website cheapdeal.vn. Đã có hướng dẫn sử dụng </strong> <a href="https://docs.google.com/spreadsheet/ccc?key=0AnMnAYl1VvuOdFIwcXhGZHZGcUduOVdqSVZVMnRhZWc&usp=sharing" style="color: #FFFFFF;"><strong> ► Click để xem ◄</strong></a>
	 </span>
	</div>-->
	</br>
<?php if($session_notice=Session::Get('notice',true)){?>
<div class="sysmsgw" id="sysmsg-success"><div class="sysmsg"><p><?php echo $session_notice; ?><span class="close">close</span></p></div></div> 
<?php }?>
<?php if($session_notice=Session::Get('error',true)){?>
<div class="sysmsgw" id="sysmsg-error"><div class="sysmsg"><p><?php echo $session_notice; ?><span class="close">close</span></p></div></div> 
<?php }?>
<script language="javascript" src="/static/js/jquery.tooltip.min.js"></script>


<!--!in_array($login_user['id'],array(1,33921,61,18,35379,35122,58094,2185,14,31265,103739))-->
<!--{if $login_user && (strpos($_SERVER['REQUEST_URI'],'/backend/team/')===false || strpos($_SERVER['REQUEST_URI'],'/backend/order/')===false)}-->    
	<!--<script type="text/javascript">                                          
        jQuery(document).ready(function() {	
            $("select[name=city_id]").attr("disabled", 'disabled');
        });                           
    </script>    
{/if}-->
<style type="text/css">#tooltip {
	position: absolute;
	z-index: 3000;
	border: 1px solid #111;
	background-color: #eee;
	padding: 5px;
	opacity: 0.85;
}
#tooltip h3, #tooltip div { margin: 0; }</style>