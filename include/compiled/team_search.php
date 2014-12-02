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
    
    <div id="recent-deals">
      <div id="content" class="mainwide">
        <div class="box clear">
          <div class="subbox-content_bk atboxinfocoment_bk " style="background:none; margin:10px 0px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr><td align="right" valign="top" style="padding-top:5px; padding-right:5px">Tìm thấy <strong><?php echo $count; ?></strong> deal cho hoặc liên quan đến từ khóa <span style="color:#c40000"><strong><?php echo $q; ?></strong></span></td></tr></table>
          <?php  
          $rows = $teams;
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
                	 <a href="/<?php echo seo_url($team['short_title'],$team['id'],$url_suffix); ?>">
                      <?php  
					 $imgload = '/static/img/grey.gif';
					 if($k<16)
					 	$imgload =  team_image($team['image'],true,240);
					  ?>
                      
                     <img src="<?php  echo $imgload; ?>" data-original="<?php echo team_image($team['image'],true,240); ?>" alt="<?php echo $INI['system']['abbreviation']; ?>: phiếu giảm giá <?php echo $team['short_title']; ?>" class="loadlazy img_deal_home" /></a>
                	</div>
                <div class="box-title-home">
                	<a href="http://cheapdeal.vn/<?php echo seo_url($team['short_title'],$team['id'],$url_suffix); ?>"><?php echo $team['masp']; ?>: <?php echo $team['product']; ?></a>
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