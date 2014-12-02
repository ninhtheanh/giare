
<div id="bdw" class="bdw">
  <div id="bd" class="cf">
    <div id="topwrapper" > 
    
    
    </div>
    
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
                                    
									
   /*   $condition = array(
        'system' => 'Y',
        "end_time < $now",
        "now_number >= min_number"
    );  */

//	$count = Table::Count('team', array()); 
    
    $rows = DB::LimitQuery('team', array(
        'condition' => $condition,
        'order' => 'ORDER BY `sort_order` DESC, `id` DESC',
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
                     <img src="<?php  echo $imgload; ?>" data-original="<?php echo team_image($team['image'],true,240); ?>" alt="<?php echo $INI['system']['abbreviation']; ?>: phiếu giảm giá <?php echo $team['short_title']; ?>" class="loadlazy img_deal_home" />
                     
                     </a>
                	</div>
                <div class="box-title-home">
                	<a href="/<?php echo seo_url($team['short_title'],$team['id'],$url_suffix); ?>"><?php echo $team['product']; ?><div class="team_price"><?php echo print_price(moneyit($team['team_price'])); ?> đ</div></a>
					 
                </div>
                <div class="box-price-sale">
               
                               
                </div>
               </div> 
            <?php  endif; ?>
        </td>
        <?php  endfor; ?>
    </tr>
    <?php  endfor; ?>
   </table> 
    </div>
	<!--sidebar-->
   
	
  </div>
  <!-- bd end --> 
</div>
<!-- bdw end --> 
