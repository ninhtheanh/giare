<?php include template("header");?>
<style>
.atbreadcrum a {
	color:#64a64e;
}
.atbreadcrum a:hover {
	color:#000;
}
</style>
<?php 

$slug =  $city['slug'];
$gid = $team['group_id'];
$arrcatid = array(
	55=>array("/$slug/ao-ao-khoac-nu",'Áo – Áo khoác nữ'),
	56=>array("/$slug/hang-cao-cap",'Hàng cao cấp'),
	57=>array("/$slug/gia-dung-cong-nghe",'Gia dụng – công nghệ'),
	58=>array("/$slug/suc-khoe-lam-dep",'Sức khỏe làm đẹp'),
	59=>array("/$slug/tui-xach-phu-kien",'Túi xách – Phụ Kiện'),
	60=>array("/$slug/me-be",'Mẹ Bé'),
	61=>array("/$slug/thoi-trang-nam",'Thời trang nam'),
	62=>array("/$slug/do-the-thao-nam-nu",'Đồ thể thao nam nữ'),
	63=>array("/$slug/vay-dam-nu",'Váy – Đầm nữ'),
);
 ?>
<div id="atbreadcrum">
  <div class="atbreadcrum" style="margin-left: 260px;margin-top: -22px; color:#64a64e;" > <a href="/<?php  echo $city['slug']; ?>">Khuyến mãi </a>
    <?php  if(isset($arrcatid[$gid])): ?>
    > <a href="<?php  echo $arrcatid[$gid][0]; ?>">
    <?php  echo $arrcatid[$gid][1]; ?>
    </a>
    <?php  endif; ?>
    > <a style="color:#000;"><strong>
    <?php  echo $team['short_title']; ?>
    </strong></a>
    <g:plusone size="small"></g:plusone>
  </div>
  <?php  /*  <div class="atbreadcrum">
	<a href="">Khuyến mãi </a> > <a href="#">Thời trang</a> > <span>Product</span>
</div>  */
//echo $team['group_id'];//
 ?>
</div>
<div class="atcontainer">
  <table width="100%" class="detailtablebox">
    <tr>
      <td valign="top"><div class="detail_info_content_top">
          <div id="atdetail_slider">
            <div id="at_slider" class="at_nivoSlider" style="width:450px; height:380px; z-index:1">
              <?php  if($team['image1']): ?>
              <img src="<?php echo team_image($team['image1'],true,450); ?>" width="450px" alt="<?php echo $team['short_title']; ?> - ảnh 1" title="<?php echo $team['short_title']; ?> - ảnh 1" />
              <?php  endif; ?>
              <?php  if($team['image2']): ?>
              <img src="<?php echo team_image($team['image2'],true,450); ?>" width="450px" alt="<?php echo $team['short_title']; ?> - ảnh 2" title="<?php echo $team['short_title']; ?> - ảnh 2" />
              <?php  endif; ?>
              <?php  if($team['image3']): ?>
              <img src="<?php echo team_image($team['image3'],true,450); ?>" width="450px" alt="<?php echo $team['short_title']; ?> - ảnh 3" title="<?php echo $team['short_title']; ?> - ảnh 3" />
              <?php  endif; ?>
              <?php  if($team['image4']): ?>
              <img src="<?php echo team_image($team['image4'],true,450); ?>" width="450px" alt="<?php echo $team['short_title']; ?> - ảnh 4" title="<?php echo $team['short_title']; ?> - ảnh 4" />
              <?php  endif; ?>
              <?php  if($team['image5']): ?>
              <img src="<?php echo team_image($team['image5'],true,450); ?>" width="450px" alt="<?php echo $team['short_title']; ?> - ảnh 5" title="<?php echo $team['short_title']; ?> - ảnh 5" />
              <?php  endif; ?>
            </div>
          </div>
          <div id="atdetail_info">
            <div class="atinfo_productat"> <span class="atinfopatt">
              <?php if($team['delivery_properties']==1 || ($city['id']==556 && $team['group_id']!=23)){?>
              <strong>Giao sản phẩm</strong> <img src="/static/img/icon_product.png" align="absmiddle" alt="Giao sản phẩm" />
              <?php } else { ?>
              <strong>Giao Voucher </strong><img src="/static/img/icon_voucher.png" align="absmiddle" alt="Giao voucher" />
              <?php }?>
              </span> <span class="atinfonumview"><strong>Số người xem: </strong>
              <?php  echo $team['viewed']; ?>
              </span> </div>
            <div class="atdetail_title">
              <h1><?php echo $team['masp']; ?>: <?php echo $team['product']; ?></h1>
            </div>
            <div class="deal_summary" style="height: 120px;overflow: hidden;line-height: 2;"> <?php echo $team['title']; ?> </div>
            <div class="box_color_price" style="clear: both;float: left;width: 91%;padding: 3px 14px;margin-bottom: 7px;">
              <?php  if(isset($team['condbuy']) && $team['condbuy'] !=''): 
                  $condbuy = nanooption($team['condbuy']);
                 ?>
              <div class="color" style="margin: 10px 0px;">
                <label style="font-weight: bold;margin-right: 7px;">Màu sắc: </label>
                <?php  
				 $cls = (array)Session::Get('colorteam');
				 
				 $activateColor = $condbuy[0]; 
				 foreach($condbuy as $color)
				 {
					if( isset($_SESSION['color_'.$team['id']]) && $_SESSION['color_'.$team['id']] == $color )
						$activateColor = $color;	 
				 }				 
				 //echo 'activateColor:' . $activateColor;
				 
				 foreach($condbuy as $color): 
				 	$clsactive = $activateColor == $color ? 'activecolor' : "";
				 ?>
                	<a id="color_<?php  echo $team['id']; ?>" class="setcolor <?php  echo $clsactive; ?>" onclick="setColorTeam(<?php  echo $team['id']; ?>,'<?php  echo $color ?>');"><span style="cursor:pointer;border:1px solid #999;width:16px; height:16px; display:inline-block;background:<?php  echo $color; ?>"></span></a>
                <?php  endforeach; ?>
              </div>
              <style>
			   .setcolor{ display: inline-block;padding: 3px;}
			   .activecolor{background: #75C70D;}
			   </style>              
              <?php  endif; ?>
              <?php if($team['size'] != ""){?>
              <div class="color" style="margin: 10px 0px;">
                <label style="font-weight: bold;margin-right: 7px;">Size: </label>
                <?php 
				//echo 'W:'.'size_'.$team['id'];
				
				 	$size = $team['size'];
					$size = str_replace("}{", ", ", $size);
					$size = str_replace("{", "", $size);
					$size = str_replace("}", "", $size);
				 	//echo $size; 
					$arrSize = split(",", $size);
					
					 $activateSize = $arrSize[0]; 
					 foreach($arrSize as $size)
					 {
						if( isset($_SESSION['size_'.$team['id']]) && $_SESSION['size_'.$team['id']] == $size )
							$activateSize = $size;	 
					 }	
					 
					foreach($arrSize as $size)
					{						
				 ?>
                 	<input type="radio" name="radio_size" value="<?php echo $size;?>" onchange="setSize(<?php  echo $team['id']; ?>,'<?php  echo $size ?>');" <?php if( $activateSize == $size ) echo 'checked="checked"'?>/> <?php echo $size;?> &nbsp;
              	<?php }?>   
              </div>
              <?php }?>
              <script type="text/javascript">
			   	$('.setcolor').click(function(){
					$('.setcolor').removeClass('activecolor');
						$(this).addClass('activecolor');
				});
			   	function setColorTeam($id,$str){
					$.get('/ajax/checkout.php?getdatastep=setcolor&team_id='+$id+'&color='+$str, function(ret) {
						
					});
				}
				function setSize($id,$str){
					$.get('/ajax/checkout.php?getdatastep=setsize&team_id='+$id+'&size='+$str, function(ret) {
						
					});
				}
				$(document).ready(function() {
					<?php if($activateColor != "" || $activateSize != "") {?>
					$.get('/ajax/checkout.php?getdatastep=set_color_size&team_id=<?php echo $team['id']?>&color=<?php echo $activateColor?>&size=<?php echo $activateSize?>', function(ret) {
						
					});
					<?php }?>
				});
			   </script>
              <div class="price_btn_order">
                <div class="box_detail_price">
                  <div class="detail_team_price"><?php echo print_price(moneyit($team[team_price])); ?> <sub>VNĐ</sub></div>
                  <div class="detail_market_price"><?php echo print_price(moneyit($team[market_price])); ?> đ</div>
                </div>
                <div class="box_btn_order">
                  <?php  	/*  <span><a <?php echo $team['begin_time']<time()?'href="/team/ataddcart.php?id='.$team['id'].'"':''; ?> class="ataddcart"><img src="/static/css/images/but_buynow.gif" width="134" height="41" alt="Mua ngay hotdeal giá rẻ" /></a></span>  */ ?>
                  <span>
                  <?php  if($team['begin_time']<time() && $team['end_time'] > time()): ?>
                  <a href="/team/ataddcart.php?id=<?php  echo $team['id']; ?>" style="font-size: 16px;color: #FFFFFF;display: block;padding-left: 6px;width: 135px;margin: 0px auto;height: 45px;" class="ataddcart boxbuttoncss">
                  <div class="buttoncss" style="width: 127px;height: 35px;font-size: 19px;line-height: 34px;">Mua Ngay</div>
                  </a>
                  <?php  elseif($team['now_number'] >= $team['pre_number']): ?>
                  <a style="font-size: 16px;color: #FFFFFF;display: block;padding-left: 6px;width: 135px;margin: 0px auto;height: 45px;" class="ataddcart boxbuttoncss">
                  <div class="buttoncss" style="width: 127px;height: 35px;font-size: 19px;line-height: 34px;background: #9B0202;border: 1px solid #9B0202;box-shadow: 0px 3px 1px #9B0202;">Cháy hàng</div>
                  </a>
                  <?php  endif; ?>
                  </span> </div>
              </div>
            </div>
            <div class="box_detail_sale_buycount" style="font-weight: bold;">
              <div class="detail_infoleft"> <span class="detail_discountper"><?php echo ceil(moneyit((100*($team['market_price'] - $team['team_price'])/$team['market_price']))); ?>%</span> <span class="detail_info_discounttext">Tiết kiệm</span> </div>
              <!--Micro-->
              <div itemscope itemtype="http://schema.org/Product" style="display:none;"> <img itemprop="image" src="<?php echo $INI['system']['wwwprefix']; ?>/static/<?php echo $team['image']; ?>" /> <span itemprop="name"><?php echo $team['short_title']; ?></span> <span itemprop="description"><?php echo cut_string(strip_tags($team['title']),150,""); ?> [xem thêm]</span>
                <div itemprop="offers" itemscope itemtype="http://schema.org/Offer"> <span itemprop="price"><?php echo print_price(moneyit($team[team_price])); ?></span>
                  <meta itemprop="priceCurrency" style="display: none;" content="VND" />
                  <link itemprop="availability" href="http://schema.org/InStock" />
                  In Stock </div>
              </div>
              <!--End-->
              <div class="detail_info_right">
                <div class="detail_info_buy"> <span><?php echo $team['now_number']+$team['pre_number']; ?></span> <span>Người mua</span> </div>
                <div class="facebook_share">
                  <div class="fb-like" data-send="true" data-layout="button_count" data-width="200" data-show-faces="false"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script type="text/javascript">
	$(document).ready(function() {
		 $('#at_slider').nivoSlider({
        directionNav:true,
        pauseOnHover:true,
		pauseTime: 3000,
        manualAdvance:false
    });
	});
</script>
        <div class="box_detail_inofo">
          <table width="100%" class="tabledetail">
            <tr>
              <td width="50%" valign="top" class="tbtableboxsummary"><div class="detail_title_condition">
                  <h2>Điểm Nổi Bật</h2>
                  </br>
                </div>
                <div id='condi-deal'> <?php echo $team['summary']; ?> </div></td>
              <td width="50%" valign="top"><div class="detail_title_condition">
                  <h2>Điều Kiện</h2>
                  </br>
                </div>
                <div id='highlights-deal'> <?php echo $team['notice']; ?> </div></td>
            </tr>
          </table>
        </div>
        <div class="detail_box_info_coment">
          <div class="tabbed_area">
            <ul class="tabs">
              <li><a title="Thông tin" class="tab active" id="lithongtin" art="content_1">Thông tin</a></li>
              <li><a title="Thảo luận" class="tab" id="lithaoluan" art="content_2">Thảo luận</a></li>
            </ul>
            <div class="atboxinfocoment">
              <div id="content_1" class="tabcontent">
                <div id="team_desc"><?php echo htmlspecialchars_decode($team['detail']); ?></div>
                <!-- share social --> 
                </br>
                <div class="box_sharesocial"> <a href="http://digg.com/submit?phase=2&url=http://www.cheapdeal.vn/<?php echo seo_url($team['short_title'],$team['id'],$url_suffix); ?>&title=<?php echo $team['short_title']; ?> ®&bodytext=<?php echo cut_string(strip_tags($team['title']),150,""); ?> [xem thêm]&topic=world_news" target="_blank"> <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC8AAAAbCAMAAADbEiYlAAAABlBMVEX///8LCwpatgxKAAAAaklEQVQ4EeWTSwrAIAwF4/0vXZq8FEckxU1raRbKSwY0P7OwdpqZLjmLa1O++DFDa4k63dVHui9CIpOQyppEFDnVI/zVWH+tVPdEDkmQv+Q96W/OA9eASr2Uk4pkKBJU4D2kY9wGgBLv8QfIQgLkrFnG6wAAAABJRU5ErkJggg==" width="35px" height="20px"/ > </a>
                  <div class="facebook_share itemshare" style="display:none">
                    <div class="fb-like" data-send="false" share="true" data-layout="button_count" data-width="100" data-show-faces="true"></div>
                  </div>
                  <div class="itemshare">
                    <g:plusone size='medium'></g:plusone>
                  </div>
                  <div class="itemshare">
                    <div class='addthis_toolbox addthis_default_style '> <a class='addthis_counter addthis_pill_style'></a> </div>
                  </div>
                </div>
                <div>
                	<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fcheapdeal.HCM&amp;width=795&amp;height=220&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:795px; height:220px;" allowTransparency="true"></iframe>
                </div>
                <!-- end share social --> 
              </div>
              <div id="content_2" class="tabcontent" style="display:none;">
                <table width="100%" border="0">                  
                  <tr>
                    <td width="1%" align="left" valign="top" style="padding-left:20px;"><div class="deal-price">
                        <?php if(($team['state']=='soldout')){?>
                        <span class="deal-price-soldout"></span>
                        <?php } else if($team['close_time']) { ?>
                        <span class="deal-price-expire"></span>
                        <?php } else { ?>
                        <span> 
                        <!--		<a <?php echo $team['begin_time']<time()?'href="/team/ataddcart.php?id='.$team['id'].'"':''; ?> class="ataddcart"><img src="/static/css/images/but_buynow.gif" width="134" height="41" alt="Mua Ngay hotdeal giá rẻ" /></a>--> 
                        </span>
                        <?php }?>
                      </div></td>
                    <td width="20%" align="left" valign="top" style="padding-left:15px;">
                    <a href="/<?php echo seo_url($team['short_title'],$team['id'],$url_suffix); ?>?comment=display#div_dealcomment">
                    	<img src="/static/css/images/comment.gif" height="41" width="134" alt="Thảo luận hotdeal giá rẻ" border="0" />
                    </a>
                    </td>
                    <td width="60%" align="left" valign="top" style="padding-left:10px;"><div align="left" style="white-space:nowrap"><strong style="font-size:100%">Mời bạn đóng góp cảm nhận cho sản phẩm này</strong></div>
                      <div align="left" style="padding-left:5px; overflow:hidden;">
                        <table border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left" valign="top" nowrap="nowrap"><div align="left" style="width:175px; height:27px; overflow:hidden; white-space:nowrap"><a href="<?php echo share_facebook($team); ?>"><img src="/static/css/images/facebook.gif" width="27" height="27" border="0" /></a>&nbsp;&nbsp;<a href="<?php echo share_twitter($team); ?>"><img src="/static/css/images/twitter.gif" width="27" height="27" border="0" /></a>&nbsp;&nbsp;<a href="<?php echo share_mail($team); ?>"><img src="/static/css/images/mail.gif" width="27" height="27" border="0" /></a>&nbsp;&nbsp; 
                                <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
                                <g:plusone></g:plusone>
                              </div></td>
                            <td align="left" valign="top" style="padding-top:5px; padding-left:5px;" width="46"><div id="fb-root"></div>
                              <fb:like href="http://www.cheapdeal.vn/<?php echo seo_url($team['short_title'],$team['id'],$url_suffix); ?>" send="false" layout="button_count" width="46" show_faces="true" share="true" action="like" font="arial"></fb:like></td>
                          </tr>
                        </table>
                      </div></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <script>  
  
  // When the document loads do everything inside here ...  
  jQuery(document).ready(function(){  
    jQuery("a.tab").click(function () {  
        jQuery(".active").removeClass("active");  
        jQuery(this).addClass("active");  
        jQuery("div.tabcontent").hide();  
        var content_show = jQuery(this).attr("art");  
		//alert(content_show);
        jQuery("#"+content_show).show();  
        
    });  
	
	<?php 


	 if(isset($_GET['comment']) && $_GET['comment'] =="display"): ?>
	
		jQuery("#lithongtin, #lithaoluan").removeClass("active"); 
		jQuery("#lithaoluan").addClass("active"); 
		jQuery("#content_1").hide();  
		jQuery("#content_2").show();  
 	<?php  endif; ?>
  });  
 </script> 
        </div>
        <div class="boxpricebuttnmid">
          <div class="detailmidbox" style="text-align:center;padding-top: 9px;"> <span>
            <?php  if($team['begin_time']<time() && $team['end_time'] > time()): ?>
            <a href="/team/ataddcart.php?id=<?php  echo $team['id']; ?>" style="font-size: 16px;color: #FFFFFF;display: block;padding-left: 6px;width: 208px;margin: 0px auto;height: 50px;" class="ataddcart boxbuttoncss">
            <div class="buttoncss" style="width: 198px;height: 36px;font-size: 22px;line-height: 34px;">Mua Ngay</div>
            </a>
            <?php  elseif($team['now_number'] >= $team['pre_number']): ?>
            <a style="font-size: 16px;color: #FFFFFF;display: block;padding-left: 6px;width: 208px;margin: 0px auto;height: 50px;" class="ataddcart boxbuttoncss">
            <div class="buttoncss" style="width: 198px;height: 36px;font-size: 22px;line-height: 34px;background: #9B0202;border: 1px solid #9B0202;box-shadow: 0px 3px 1px #9B0202;">Cháy hàng</div>
            </a>
            <?php  endif; ?>
            </span> </div>
        </div>
        <div class="detail_boxaddress">
          <table width="100%" class="detail_map_deal">
            <tr>
              <td class="atmap" valign="top"><div class="detail_add_title">Bản đồ</div>
                <?php  /*  <div class="detail_add_title">Bản đồ</div>  */ ?>
                <div class="detail_add_container"> 
                  <!--{if $INI['system']['googlemap'] && $partner['longlat']}--> 
                  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
                  <?php  
if(!$partner['longlat'])
 $partner['longlat'] = '10.78896,106.676899';
 ?>
                  <script type="text/javascript">
      function initialize() {		 

		 var geocoder;
        var mapDiv = document.getElementById('mapcanvas');
		var myLatlng = new google.maps.LatLng(<?php echo $partner['longlat']; ?>);
        var map = new google.maps.Map(mapDiv, {
          center: myLatlng,
          zoom: 15,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
		  scrollwheel: true
        });
		
		 geocoder = new google.maps.Geocoder();
		 
		 var marker = new google.maps.Marker({
				position: myLatlng,
				title: '<?php  echo $partner['address']; ?>'
			});
			marker.setMap(map);

      }
      
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
                  <div id="mapcanvas" class="mapbody map" style="width:588px; height:300px;border: 1px solid #ccc;"></div>
                  <!--{/if}-->
                  <?php  	/*  <div align="center"><img src="/static/<?php echo $partner['image1']; ?>" alt="<?php echo $partner['title']; ?>" /></div>  */ ?>
                </div></td>
              <td valign="top"><div class="detail_add_title">Địa chỉ</div>
                <div class="detail_add_container"> <?php echo $partner['location']; ?> </div></td>
            </tr>
          </table>
        </div></td>
      <td width="244" valign="top"><?php if(!empty($other_deal)){?>
        <ul class="atmore_dealright">
          <?php if(is_array($other_deal)){foreach($other_deal AS $index=>$one) { ?>
          <?php 
                        $new_icon = $one['begin_time']+86400;
                        if($new_icon>time()){
                            $class = ' class="new"';
                        }else{
                            $class = '';
                        }
                        
                        $total_comment = DB::GetQueryResult("SELECT count(id) as total FROM topic WHERE team_id=".$one['id']);
                        $ids .= $one['id'].",";
                        $arr_group = array(16,23);
                        if(in_array($ip,$ip_arr)){
                            $now_number = RandomBuy($one['now_number'],$one['virtual_buy']);
                        }elseif(in_array($one['group_id'],$arr_group) && $one['close_time']){
                            $now_number = $one['now_number']*2;
                        }else{
                            $now_number = $one['now_number'];
                        }
                    ; ?>
          <li<?php echo $class; ?>> <a href="/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>" class=""> <img src="<?php echo team_image($one['image'],true,240); ?>" alt="" title="" width="219" height="316" class="img_more_right" /></a> <a href="/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>" class="linktitlemoreright"><?php echo $one['short_title']; ?></a>
            <div class="box_right_price_sale"> <span class="pricetoge"><?php echo print_price(moneyit($one['team_price'])); ?>đ</span> <span class="right_marketprice"><?php echo print_price(moneyit($one['market_price'])); ?>đ</span> <span class="right_sale">Giảm <?php echo ceil(moneyit((100*($one['market_price'] - $one['team_price'])/$one['market_price']))); ?>%</span> </div>
          </li>
          <?php }}?>
        </ul>
        <?php }?></td>
    </tr>
  </table>
</div>
<!-- Microdata -->
<div style="display:none;" typeof="v:Review-aggregate" xmlns:v="http://rdf.data-vocabulary.org/#"> <span property="v:itemreviewed"><?php echo $team['short_title']; ?> - C<?php echo $team['id']; ?></span> <span rel="v:rating"> <span typeof="v:Rating"> <span property="v:average"><?php echo ceil(moneyit((10*($team['team_price'])/$team['market_price']))); ?></span> su <span property="v:best">10</span> </span> </span>CheapDeal<span property="v:count">
  <?php  echo $team['viewed']; ?>
  </span> student</div>
<div style="display:none;" itemprop="offers" itemscope itemtype="http://schema.org/AggregateOffer"> <span itemprop="lowPrice"><?php echo print_price(moneyit($team[team_price])); ?></span> to <span itemprop="highPrice"><?php echo print_price(moneyit($team[market_price])); ?></span> from <span itemprop="offerCount"><?php echo ceil(moneyit((100*($team['market_price'] - $team['team_price'])/$team['market_price']))); ?>%</span> </div>
<div style="display:none;" itemscope itemtype="http://schema.org/Organization"> <span itemprop="name"><?php echo $partner['username']; ?></span> </div>
<div style="display:none;" itemscope itemtype="http://schema.org/CivicStructure"> <span itemprop="name">Giờ mở cửa</span>
  <meta itemprop="openingHours" content="Thứ hai - Thứ bảy 8am - 5:30pm">
  Thứ hai - Thứ bảy 8am - 5:30pm
  <meta itemprop="openingHours" content="Chủ nhật nghỉ">
  Chủ nhật nghỉ </div>
<div  style="display:none;" itemscope itemtype="http://schema.org/LocalBusiness">
  <h1><span itemprop="name">Cheapdeal.vn HCM</span></h1>
  <span itemprop="description"><?php echo $partner['address']; ?></span>
  <div  style="display:none;" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"> <span itemprop="streetAddress">137/5A Le Van Sy, P. 13, Q. PN</span> <span itemprop="addressLocality">Ho Chi Minh City</span>, <span itemprop="addressRegion">Vietnam</span> </div>
  Phone: <span itemprop="telephone">083-991-4018</span> </div>
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
<!--Start of Zopim Live Chat Script--
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//v2.zopim.com/?1UOFhir8vlFw0AJO0QccpK5lOjm3Abif';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>
--End of Zopim Live Chat Script--> 
<!-- Breakcumb -->
<?php include template("footer");?>
