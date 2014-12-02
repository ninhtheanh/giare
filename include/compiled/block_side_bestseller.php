<?php 
$others_side_ns = abs(intval($INI['system']['sideteam']));
$min_buy = 150;
$others_city_id = abs(intval($city['id']));
if ( abs(intval($INI['system']['sideteam'])) ) {
	$oc = array( 
    'city_id' => array($others_city_id, 0,556), 
    'team_type' => 'normal',
    "begin_time < UNIX_TIMESTAMP()",
    "end_time > UNIX_TIMESTAMP()",
    "((max_number>0 and now_number<max_number) OR (max_number=0))",
    );
    $ckey = 'recent';	
	$others = DB::LimitQuery('team', array(
        'condition' => $oc,
        'order' => 'ORDER BY `sort_order` DESC, `id` DESC LIMIT 20,100' ,
        //'size' => $others_side_ns,
        ));
}
; ?>
<?php if($others){?>
<div class="sbox"><div class="sbox-top"><h2>Dealsoc trong ngày</h2></div>
	<div class="sbox-content">
   	<table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tbody>
            <tr>
              <td bgcolor="#ffffff" align="left" valign="top">
              	 <?php $index=0; ?>
                	<?php if(is_array($others)){foreach($others AS $one) { ?>
                        <?php 
                            $index+=1;
                            if($index<count($others)){
                                $line = "<div><hr size='1' width='99%' style='color:#1e94c4' /></div>";
                                $padding_bottom = "0px";
                            }else{
                                $line = "";
                                $padding_bottom = "0px";
                            }
                            $team_cat = Table::Fetch('category', $one['group_id']);
                            //$team_partner = Table::Fetch('partner', $one['partner_id']);                       
                        ; ?>
                    
                    <div style="cursor:pointer;" onclick="window.location='/<?php echo $city['slug']; ?>/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>'">
                        <div style='color:#FFFFFF; cursor:pointer' class='aListBPLine'>
                          <h3><a href="/<?php echo $city['slug']; ?>/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>" style="color:#000000; font-size:13px;"><?php echo $one['short_title']; ?></a></h3>
                          <div class='dInfoBRNew'><?php if($one['image']){?><a href="/<?php echo $city['slug']; ?>/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>" style="color:#000000; font-size:13px;"><img src="<?php echo team_image($one['image'], true); ?>" border="0" alt="<?php echo $one['short_title']; ?>" /></a><?php }?></div>
                          <div class='dSOListBRN'>
                            <div class='div_TietKiem'><strong class='styleText14'>Giảm</strong><br/>
                              <strong class='styleText15'><?php echo ceil(team_discount($one)); ?><span style="font-size:12px"><sup>%</sup></span></strong></div>
                          </div>
                          <div class='PriceDealBRL'>
                            <div class='divPrice'><span class='styleText17'>Giá trị: <span class='StyleTextGT lineHorizontal styleText13' style="text-decoration:line-through"><?php echo print_price(moneyit($one['market_price'])); ?> <?php echo $currency; ?></span></span></div>
                            <div class='div_infoMoney'><span class='styleText17'>Còn Lại: <span class='styleText5'><?php echo print_price(moneyit($one['team_price'])); ?>&nbsp;<?php echo $currency; ?></span></span></div>
                        </div>
                    </div><?php echo $line; ?>	
                    <?php }}?>
                </td>
            </tr>
          </tbody>
        </table>
      </div>
	<div class="sbox-bottom"></div>
</div><?php }?>