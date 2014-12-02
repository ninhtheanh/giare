<?php include template("header");?>
<?php // include template("atmenucolspan");?>
<div id="bdw" class="bdw">
  <div id="bd" class="cf">
            <div id="topwrapper" > 
        <div id="recent-deals">
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
                        <div class="box_deal_home  team_column_<?php  echo $k%4; ?>">
                            <div class="box_img_home">
                             <a href="/<?php echo seo_url($team['short_title'],$team['id'],$url_suffix); ?>">
                             <?php  
							 $imgload = '/static/img/grey.gif';
							 if($k<8)
								$imgload =  team_image($team['image'],true,240);
							  ?>
                             <img src="<?php  echo $imgload; ?>" data-original="<?php echo team_image($team['image'],true,240); ?>" alt="<?php echo $INI['system']['abbreviation']; ?>: phiếu giảm giá <?php echo $team['short_title']; ?>" class="loadlazy img_deal_home" /><span class="hovershow">
                     	<?php if($team['delivery_properties']==1 || ($city['id']==556 && $team['group_id']!=23)){?> Giao sản phẩm <img src="/static/img/icon_product.png" align="absmiddle" alt="Giao sản phẩm" /><?php } else { ?>Giao Voucher <img src="/static/img/icon_voucher.png" align="absmiddle" alt="Giao voucher" /><?php }?>
                     </span></a>
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
          </div>
      </div>
      
      <div style="vertical-align:central; float:inherit; margin-top:50px">
            <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fcheapdeal.HCM&amp;width=1100&amp;height=220&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:1100px; height:220px;" allowTransparency="true"></iframe> 
      </div>
      
  </div>
  <?php include template("footer");?>