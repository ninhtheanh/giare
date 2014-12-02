<?php include template("header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="about">
	<div id="content" class="about">
		<div class="box clear"> 
            <div class="box-top"></div>
            <div class="box-content">

            <div style="width:500px; margin:0 auto; border: solid 1px #ccc;">
            
                <div class="head"><h2>Chọn tỉnh / thành phố của bạn:</h2></div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<!--{loop $cities $letter $ones}-->	
					<tr><!--<td valign="top"><b><?php echo $letter; ?></b></td>-->
					<td valign="top"><h1 class="city_list" style="margin:0; font-size:200%">
                    &raquo;&nbsp;<a href="/tp-ho-chi-minh/?r=<?php echo $currefer; ?>">Thành Phố Hồ Chí Minh</a>
                    <br />
                    &raquo;&nbsp;<a href="/tinh-thanh/?r=<?php echo $currefer; ?>">Các Tỉnh Khác</a>
                   </h1></td></tr>					
					</table>
                </div>
             </div>   
            </div>
            <div class="box-bottom"></div>
        </div>
	</div>
	<div id="sidebar">
		<?php include template("block_side_business");?>
	</div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("footer");?>
