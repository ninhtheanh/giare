<?php include template("header");?>

<div id="bdw" class="bdw">
  <div id="bd" class="cf"> 
    <?php if($order && $order['service']!='cashdelivery' && $order['service']!='cashoffice' ){?>
    <div id="sysmsg-tip" >
      <div class="sysmsg-tip-top"></div>
      <div class="sysmsg-tip-content">Bạn đã đặt mua deal này rồi. Vui lòng <a href="/order/check.php?id=<?php echo $order['id']; ?>">Kiểm tra đơn hàng và thanh toán<span id="sysmsg-tip-close" class="sysmsg-tip-close">Đóng</span></div>
      <div class="sysmsg-tip-bottom"></div>
    </div>
    <?php }?>
    <div align="left"><table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="left" valign="top" nowrap="nowrap" width="85%"><div class="dashboard" id="dashboard">
              <ul style="white-space:nowrap">
                <?php echo current_frontend(); ?>
              </ul>
            </div></td><td align="left" valign="top" width="15%"><div class="searchcontent_box">
                	<div class="searchcontent_formbox">
                    <form id="topSearch" method="get" action="/team/search.php">
                    <div class="searchcontent_formbox1">
                    <input type="text" value="<?php echo $q; ?>" name="s" id="sd" class="searchcontent_formtextbox"  autocomplete="off" onfocus="if (this.value == 'Type keyword here...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Type keyword here...';}" />
                    </div>
                    <div class="searchcontent_formbox2">
                    <input type="submit" value="" class="searchcontent_formbtn" />
                    </div>
                    </form>
                    </div>                
                </div></td>
          
        </tr>
      </table></div>
    <div id="recent-deals">
      <div id="content" class="mainwide">
        <div class="box clear">
          <div class="subbox-content">
            <div style="background-color:#FFFFFF;min-height:450px;_height:450px">
              <div class="slider-wrapper theme-default">
                    <div class="ribbon">
                <div id="slider" class="nivoSlider">


<?php include template("flashbanner");?>
</div>


              </div>
  


			<table width="100%" border="0" cellspacing="0" cellpadding="0">
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
                      ; ?>
                      <div class="three_up <?php echo ($index+1)%3==0?'last':''; ?>">
                        <div class="csbox" onclick="window.location.href='/<?php echo $city['slug']; ?>/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>'" style="cursor:pointer">
                        <div align="left"> <a href="/<?php echo $city['slug']; ?>/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>" title="<?php echo $one['title']; ?>" style="color:#1f95c5; font-family:Arial; font-size:15px"> <strong><?php echo cut_string($one['short_title'],40,"..."); ?></strong></a></div>
                          	<div class="image trackable">
                                <div class="inner"><a href="/<?php echo $city['slug']; ?>/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>" title="<?php echo $one['title']; ?>"><img alt="<?php echo $one['title']; ?>" src="<?php echo team_image($one['image'],false); ?>" /></a></div>
                                <div class="index_tooltip">
                                    <span><?php if($one['delivery_properties']==1 || ($city['id']==556 && $one['group_id']!=23)){?>
                                        <img src="/static/img/icon_product.png" width="30" height="30" align="absmiddle" alt="Dealsoc giao sản phẩm tận nơi" />Giao sản phẩm<?php } else { ?><img src="/static/img/icon_voucher.png" width="30" height="30" align="absmiddle" alt="Dealsoc giao voucher tận nơi" />Giao voucher<?php }?>&nbsp;&nbsp;&nbsp;<strong style="color:#3399ff; font-size:130%;"><?php echo $one['now_number']; ?></strong> người mua</span>
                                </div>
                            </div>
                          
                          <div align="left">
                            <table width="100%" border="0">
                              <tr>
                                <td align="center" valign="top" style="padding-bottom:3px;" colspan="2"><strong class="old" style="font-size:170%; color:#c40000; white-space:nowrap"><?php echo print_price(moneyit($one['team_price'])); ?><sup style="font-size:60%; text-transform:none"><?php echo $currency; ?></sup></strong></td><td align="right" rowspan="2">
                                <div class="view-deal-button"><a class="button small trackable" title="<?php echo $one['short_title']; ?>" 
    href="/<?php echo $city['slug']; ?>/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>">MUA</a></div></td></tr><tr>
                                <td align="center" valign="top" style="padding-right:10px"><div style="font-size:11px;">Tiết kiệm</div><div align="center"><strong class="old" style="font-size:110%; color:#000000"><?php echo ceil(moneyit((100*($one['market_price'] - $one['team_price'])/$one['market_price']))); ?>%</strong></div></td>
                                <td align="left" valign="top" style="border-left:#CCC 1px solid"><div style="font-size:11px;" align="center">Thời gian còn lại</div><div class="deal-timeleft deal-on" id="deal-timeleft-<?php echo $one['id']; ?>" curtime="<?php echo $now; ?>" diff="<?php echo $diff_time; ?>" style="margin:0px; padding:0px;"><ul id="counter-<?php echo $one['id']; ?>" style="background:none; margin:0px; padding:0px;">
                            <li><span style="color:#000000; font-size:14px;"><?php echo $left_hour+(24*$left_day); ?>:<?php echo $left_minute; ?>:<?php echo $left_time; ?></span></li>
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