<?php  $ishome = 1; ?>
<?php 

include template("header");?>


<div id="bdw" class="bdw">
  <div id="bd" class="cf">
    <div id="topwrapper" > 
      <?php if($order && $order['service']!='cashdelivery' && $order['service']!='cashoffice' ){?>
      <div id="sysmsg-tip" >
        <div class="sysmsg-tip-top"></div>
        <div class="sysmsg-tip-content">Bạn đã đặt mua deal này rồi. Vui lòng <a href="/order/check.php?id=<?php echo $order['id']; ?>">Kiểm tra đơn hàng và thanh toán</a><span id="sysmsg-tip-close" class="sysmsg-tip-close">Đóng</span></div>
        <div class="sysmsg-tip-bottom"></div>
      </div>
      <?php }?>
     <?php   /*  
     //old display
    	<div align="left" style="background-color:#EE840c; height:133px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr bgcolor="#FFFFFF">
            <td align="left" valign="top" nowrap="nowrap" width="720"><div class="dashboard" id="dashboard">
                <ul style="white-space:nowrap">
                  <?php echo current_frontend(); ?>
                </ul>
              </div></td>
            <td align="left" valign="top" width="255" style="width:255px"><div class="searchcontent_box">
                </td>
          </tr>
          <tr>
            <td align="left" valign="top" colspan="2" style="padding-top:10px; padding-left:1px;"><div class="slider-wrapper theme-default">
                <div class="ribbon"></div>


                <div id="slider" class="nivoSlider">


<?php include template("flashbanner");?>
</div>


              </div></td>
          </tr>
        </table>
      </div>  
      */ ?>
    </div>
    <div style="width:100%; height:5px;"></div>
    <div id="recent-deals">
    <?php  
	
 $condition = array( 
//  'city_id' => array($home_city_id, 0,556), 
  'team_type' => 'normal',
  "begin_time < UNIX_TIMESTAMP()",
  "end_time > UNIX_TIMESTAMP()",
  "(max_number>0 AND now_number < max_number) OR max_number=0",
  'status' => 'Y',
//  "id NOT IN ($ids)",
);
// where begin_time < UNIX_TIMESTAMP() and   end_time > UNIX_TIMESTAMP() and    (max_number>0 AND now_number < max_number) OR max_number=0 and status = 'Y'                        
									
   /*   $condition = array(
        'system' => 'Y',
        "end_time < $now",
        "now_number >= min_number"
    );  */

//	$count = Table::Count('team', array()); 
    
    $rows = DB::LimitQuery('team', array(
        'condition' => $condition,
        'order' => 'ORDER BY show_homepage DESC, `sort_order` DESC, `id` DESC',
        'size' => 500,
		'offset' => 0,
    ));
    
//   
//   echo $count;
   
   $count_total =  count($rows);
   $_cols = 4;
   $_rows = ceil($count_total/$_cols);
   $per = 25;
  ?>
  <table width="100%">
    <?php  for($i=0;$i<$_rows;$i++): ?>
    <tr>
    	<?php  for($j=0;$j<$_cols;$j++): ?>
        <td width="<?php  echo $per; ?>">
        	<?php  $k = $i*$_cols+$j; ?>
            <?php  if(isset($rows[$k])): $team = $rows[$k];?>
            	<div class="box_deal_home team_column_<?php  echo $k%4; ?>">
				
                	<div class="box_img_home">
                	 <a href="/<?php echo seo_url($team['short_title'],$team['id'],$url_suffix); ?>" style="width: 240px;height: 348px;display: block;">
                     <?php  
					 $imgload = '/static/img/grey.gif';
					 if($k<8)
					 	$imgload =  team_image($team['image'],true,240);
					  ?>
                     <img src="<?php  echo $imgload; ?>" data-original="<?php echo team_image($team['image'],true,240); ?>" alt="<?php echo $team['short_title']; ?>" class="loadlazy img_deal_home" />
                     <span class="hovershow">
                     	<?php if($team['delivery_properties']==1 || ($city['id']==556 && $team['group_id']!=23)){?> Giao sản phẩm <img src="/static/img/icon_product.png" align="absmiddle" alt="Giao sản phẩm" /><?php } else { ?>Giao Voucher <img src="/static/img/icon_voucher.png" align="absmiddle" alt="Giao voucher" /><?php }?>
                     </span>
                     </a>
                	</div>
                <div class="box-title-home">
                	<a href="/<?php echo seo_url($team['short_title'],$team['id'],$url_suffix); ?>"><?php echo $team['masp']; ?>: <?php echo $team['product']; ?></a>
                </div>
                <div class="box-price-sale">
                <div class="team_price"><?php echo print_price(moneyit($team['team_price'])); ?> đ</div>
                 <div class="market_price"><?php echo print_price(moneyit($team['market_price'])); ?> đ</div>
                 <div class="saleper">Giảm <?php echo ceil(moneyit((100*($team['market_price'] - $team['team_price'])/$team['market_price']))); ?>%</div>
                </div>
               </div> 
            <?php  endif; ?>
        </td>
        <?php  endfor; ?>
    </tr>
    <?php  endfor; ?>
   </table> 
    </div>
    <div style="vertical-align:central; float:inherit; margin-top:50px">
    	<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fcheapdeal.HCM&amp;width=1100&amp;height=220&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:1100px; height:220px;" allowTransparency="true"></iframe> 
    </div>
    <?php
	$arrBanner = DB::LimitQuery('banner', array(
		'order' => 'ORDER BY `order`',
		'condition' => "banner_type = 'left' And activate = 1"
	));
	$banner = $arrBanner[0];
	?>
	<!--sidebar-
    <div style='position:fixed;right:0;bottom:280px;z-index:1000;'>
	<a href='https://docs.google.com/spreadsheet/viewform?pli=1&formkey=dHN2NWZUVElzdFNmZ0E5SGdJREZId1E6MQ#gid=0' target='_blank'>
		<img alt='Góp ý với Cheapdeal' border='0'src='/static/img/gopy.png' title='Góp ý với Cheapdeal'/> </a>
	</div>-->
	<!--
	<div style='position:fixed;left:0;bottom:29px;z-index:1000;'>
	<a href='http://cheapdeal.vn/co-hoi-nghe-nghiep.html' target='_blank'>
	<img alt='Add-on Cheapdeal' border='0'src='/static/img/giaonhan.jpg' title='Tuyển nhân viên giao nhận'/> </a>
	</div> 
	-->
	<?php if( $banner['img'] != ""){ ?>
	<div style='position:fixed;left:0;bottom:49px;z-index:1000;'>
	<a href='<?php echo $banner['url']; ?>' target='_blank'>
	<img alt='Add-on Cheapdeal' border='0' src='<?php echo $banner['img']; ?>' title=''/> </a>
	</div> 
	<?php } ?>	
	<!--<div style='position:fixed;right:0;bottom:380px;z-index:1000;'>
	<a href='http://cheapdeal.vn/huong-dan.html' target='_blank'>
	<img alt='Hướng dẫn Cheapdeal' border='0'src='/static/img/huongdan.png' title='Hướng dẫn'/> </a>
	</div> 
	  
  <!-- bd end --> 
  <!--Feedback-->
  <script type="text/javascript">
var _urq = _urq || [];
_urq.push(['initSite', '7e8bfbaf-5918-48b8-ac68-10f72fc1f578']);
(function() {
var ur = document.createElement('script'); ur.type = 'text/javascript'; ur.async = true;
ur.src = ('https:' == document.location.protocol ? 'https://cdn.userreport.com/userreport.js' : 'http://cdn.userreport.com/userreport.js');
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ur, s);
})();
</script> 
<script type="text/javascript" src="địa chỉ file .js"></script>
</div>
<!-- bdw end --> 
<!--Start of Zopim Live Chat Script--
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//v2.zopim.com/?1UOFhir8vlFw0AJO0QccpK5lOjm3Abif';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>
<!--End of Zopim Live Chat Script-->
<?php include template("footer");?>