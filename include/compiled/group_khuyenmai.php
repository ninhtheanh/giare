<?php include template("group/khuyenmai_header");?>

<div id="bdw" class="bdw">
  <div id="bd" class="cf"> 
   
    <div id="topwrapper" >
    <div align="left" style="background-color:#EE840c;"><table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr bgcolor="#FFFFFF">
          <td align="left" valign="top" nowrap="nowrap"><div class="dashboard" id="dashboard">
              <ul style="white-space:nowrap">
                <?php echo current_frontend(); ?>
              </ul>
            </div>
            </td>
        </tr>
        
      </table></div>
    </div>
    <div id="recent-deals">
      <div id="content" class="mainwide">
        <div class="box clear">
          <div class="subbox-content">
            <div style="background-color:#FFFFFF;min-height:450px;_height:450px">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
            <td align="left" valign="top" colspan="2"><div class="slider-wrapper theme-default">
                <div class="ribbon"></div>
                <div id="slider" class="nivoSlider"><a href="/static/promotion/GoogleNexus7/?utm_campaign=PromotionGoogleNexus7&amp;utm_medium=email&amp;utm_source=homebanner&amp;utm_content=deal" target="_blank"><img src="/static/banner/Banner_Google_Nexus7.jpg" width="983" height="100" /></a></div>
              </div></td>
          </tr><tr><td align="left" valign="top" style="padding-top:10px; padding-left:10px; padding-right:10px"><h1><strong>Khuyến mãi cực sốc tại Dealsoc.vn.</strong></h1>
Các deal, voucher khuyến mãi luôn mang đến sự hấp dẫn. Dealsoc.vn có các deal, voucher khuyến mãi sản phẩm; deal, voucher khuyến mãi du lịch; deal, voucher khuyến mãi làm đẹp, spa; deal, voucher khuyến mãi ăn uống, nhà hàng, cafe, v.v... Tại Dealsoc.vn, chúng tôi luôn cố gắng để đem đến cho khách những các deals, voucher khuyến mãi giá rẻ tốt nhất, cộng với dịch vụ chăm sóc khách hàng chu đáo, Dealsoc hy vọng những khuyến mãi đó sẽ làm hài lòng khách hàng. Hãy cho chúng tôi biết các ý kiến của bạn để chúng tôi mang đến những khuyến mãi tốt hơn nữa. Và đừng quên cùng nhóm mua chung những hot deal cực rẻ ngay hôm nay bạn nhé!</td></tr>
                <tr>
                  <td align="left" valign="top" style="padding-left:6px; padding-top:6px;">   <?php if(is_array($teams)){foreach($teams AS $index=>$one) { ?>
                      <?php 
                      	$left = array();
                        $now = time();
                        if($one['end_time']<$one['begin_time']){$one['end_time']=$one['begin_time'];}
                        
                       $diff_time = $left_time = $one['end_time']-$now;
                        if ( $one['team_type'] == 'seconds' && $one['begin_time'] >= $now ) {
                            $diff_time = $left_time = $one['begin_time']-$now;
                        }
                        
                        $left_day = floor($diff_time/86400);
                        $left_time = $left_time % 86400;
                        $left_hour = floor($left_time/3600);
                        $left_time = $left_time % 3600;
                        $left_minute = floor($left_time/60);
                        $left_time = $left_time % 60;
                        if($index%2==0)
                        {
                            $p[0] = 'deal ' . $index . ': cùng mua chung nhóm mua hot deal!'; 
                            $p[1] = 'deal ' . $index . ': khuyen mai gia re!'; 
                            $p[2] = 'deal ' . $index . ': san pham dich vu an uong du lich!';  
                            $w = $p[rand(0,2)];   
                        }else{
                        	$w = NULL;
                        }                           
                      ; ?>
                      <div class="three_up <?php echo ($index+1)%3==0?'last':''; ?>">
                        <div class="csbox" onclick="window.location.href='/<?php echo $city['slug']; ?>/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>'" style="cursor:pointer">
                        <div align="left"> <a href="/<?php echo $city['slug']; ?>/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>" title="<?php echo $one['title']; ?>" style="color:#1f95c5; font-family:Arial; font-size:15px"> <strong><?php echo cut_string($one['short_title'],40,"..."); ?></strong></a></div>                 
                          	<div class="image trackable">
                                <div class="inner"><a href="/<?php echo $city['slug']; ?>/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>" title="<?php echo $one['title']; ?>"><img alt="cùng mua chung theo nhóm mua hot deal khuyen mai - <?php echo $one['short_title']; ?>" src="<?php echo team_image($one['image'],false); ?>" /></a></div>
                                <div class="index_tooltip">  
                                     <?php 
                                                                            if(in_array($ip,$ip_arr)){
                                            $now_number = RandomBuy($one['now_number'],$one['virtual_buy']);
                                        }else{
                                            $now_number = $one['now_number'];
                                        }
                                  ; ?><span>                                   
                                    <?php if($one['delivery_properties']==1 || ($city['id']==556 && $one['group_id']!=23)){?>
                                        <img src="/static/img/icon_product.png" width="30" height="30" align="middle" alt="Dealsoc giao sản phẩm tận nơi" />Giao sản phẩm<?php } else { ?><img src="/static/img/icon_voucher.png" width="30" height="30" align="middle" alt="Dealsoc giao voucher tận nơi" />Giao voucher<?php }?>&nbsp;&nbsp;&nbsp;<strong style="color:#3399ff; font-size:130%;"><?php echo $now_number; ?></strong> người mua</span>
                                </div>
                            </div>
                          
                          <div align="left">
                            <table width="100%" border="0">
                              <tr>
                                <td align="center" valign="middle" style="padding-bottom:3px;" colspan="2"><strong class="old" style="font-size:170%; color:#c40000; white-space:nowrap"><?php echo print_price(moneyit($one['team_price'])); ?><sup style="font-size:60%; text-transform:none"><?php echo $currency; ?></sup></strong></td><td rowspan="2" align="right">
                                <div class="view-deal-button"><a class="button small trackable" title="<?php echo $one['short_title']; ?>" 
    href="/<?php echo $city['slug']; ?>/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>">MUA</a></div></td></tr><tr>
                                <td align="center" valign="top" style="padding-right:10px"><div style="font-size:11px;">Tiết kiệm</div><div align="center"><strong class="old" style="font-size:110%; color:#000000"><?php echo ceil(moneyit((100*($one['market_price'] - $one['team_price'])/$one['market_price']))); ?>%</strong></div></td>
                                <td align="left" valign="top" style="border-left:#CCC 1px solid"><div style="font-size:11px;" align="center">Thời gian còn lại</div><div class="deal-timeleft deal-on" id="deal-timeleft-<?php echo $one['id']; ?>" diff="<?php echo $diff_time; ?>" style="margin:0px; padding:0px;"><ul id="counter-<?php echo $one['id']; ?>" style="background:none; margin:0px; padding:0px;">
                            <li><span style="color:#000000; font-size:14px;"><?php echo $left_hour+(24*$left_day); ?>:<?php echo $left_minute; ?>:<?php echo $left_time; ?></span><strong style="color:#EBEBEB; font-size:5px;"><?php echo $w; ?></strong></li>
                          </ul>
                        </div></td>
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>
                      <?php }}?>
                    <div class="clear"></div>
                    
                    <?php if($count>$home_side_ns){?>
                    
                    <div  style="padding:0;margin:0;float:right;margin-right:10px; margin-top:10px;text-align:center;z-index:99;"><?php echo $pagestring; ?></div>
                    
                    <?php }?></td>
                </tr>
              </table>
              <div class="clear"></div>
            </div>
          </div>
        </div>
        <div class="clear"></div>
      </div>
    </div>
  </div>
  <!-- bd end --> 
</div>
<!-- bdw end -->
<script language="javascript" type="text/javascript">
	  var sec = {};
	  function getInitTime(){
		  $('div.deal-timeleft').each(function(){
			 var jobj = $(this);
			 var SysSecond = parseInt(jobj.attr('diff'));
			 var theid = parseInt((jobj.attr('id')).replace(/deal-timeleft-/,''));
			 sec[theid]= SysSecond;
		  });
	  }
	  getInitTime();
	  function SetRemainTime() {
			for(var i in sec){
				setRemainTimeSite(i,sec[i]);
			}
	   }
	  function setRemainTimeSite(theid,SysSecond){
		  if (SysSecond > 0) {
			   SysSecond = SysSecond - 1;
			   var second = Math.floor(SysSecond % 60).toString();
			   var minite = Math.floor((SysSecond / 60) % 60).toString();
			  /* var hour = Math.floor((SysSecond / 3600) % 24).toString();*/
			  var hour = Math.floor(SysSecond / 3600).toString();
			   var day = Math.floor((SysSecond / 3600) / 24).toString();
			   $("#counter-"+theid).html("<li><span style='color:#000000; font-size:14px;'>"+hour+":"+minite+":"+second+"</span></li>");
			   sec[theid]--;
		  }else{
			return;
		  }
		}
	  window.setInterval(SetRemainTime,1000);
	 	  
</script>
<?php include template("footer");?>