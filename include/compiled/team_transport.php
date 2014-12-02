<?php include template("header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="recent-deals">
<?php if(option_yes('cateteam')){?>
	<div class="dashboard" id="dashboard">
		<ul><?php echo current_teamcategory($group_id); ?></ul>
	</div>
    
<?php } else { ?>
<div class="dashboard" id="dashboard">
		<ul><?php echo current_frontend(); ?></ul>
	</div>
<?php }?>
    <div id="content" class="mainwide">
        <div class="box clear">
            <div class="subbox-content"><div style="background-color:#FFFFFF;min-height:450px;_height:450px">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="top" width="90%" style="padding-top:7px;padding-left:5px;padding-bottom:10px;">
                        <ul class="deals-list">
                            <?php if(is_array($teams)){foreach($teams AS $index=>$one) { ?>
                            <?php $team_cat = Table::Fetch('category', $one['group_id']);; ?>
                            <li class="<?php echo $index++%2?'alt':''; ?> <?php echo $index<=2?'first':''; ?>" style="padding:0px;margin:0px;padding-bottom:3px; padding-right:3px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tbody>
                                <tr>
                                  <td align="right" valign="top"><img src="/static/css/images/box_tl.gif" border="0" width="20" height="19"></td>
                                  <td style="background: url('/static/css/images/box_tc.gif') repeat-x scroll 0% 0% transparent;"></td>
                                  <td align="left"><img src="/static/css/images/box_tr.gif" width="20" height="19"></td>
                                </tr>
                                <tr>
                                  <td style="background: url(&quot;/static/css/images/box_sl.gif&quot;) repeat-y scroll right transparent;"></td>
                                  <td align="left" valign="top" style="padding:10px;" bgcolor="#ffffff">
                                        <h4 style="font-size:101%; height:28px; margin-top:-5px; font-family:Arial"><a href="/<?php echo $city['slug']; ?>/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>" title="<?php echo $one['title']; ?>"><strong><?php echo $one['short_title']; ?> - Phiếu giảm giá <?php echo $team_cat['name']; ?></strong> <span class="time" style="color:#999;">(<?php echo date('d/m/Y', $one['begin_time']); ?>)</span></a></h4>                                                  
                                        <div class="pic">                                                                             
                                            <!--<div class="<?php echo $one['picclass']; ?>"></div>--><a href="/<?php echo $city['slug']; ?>/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>" title="<?php echo $one['title']; ?>"><img alt="<?php echo $one['title']; ?>" src="<?php echo team_image($one['image'],true); ?>" width="250" /></a>                                   
                                            <div style="z-index:100; position:absolute; top:0; left:175px;text-align:right;">
                                            
												<div style="width:100px;height:25px;background:url('/static/css/images/boxs.png') top right no-repeat; padding-top:10px;padding-right:5px;">
												<strong class="old"><?php echo print_price(moneyit($one['team_price'])); ?> <?php echo $currency; ?></strong></div>
                                            
												<div style="width:100px;height:25px;background:url('/static/css/images/boxs.png') top right no-repeat; margin-top:1px;padding-top:10px;padding-right:5px;">
												<strong class="old" style="text-decoration:line-through"><?php echo print_price(moneyit($one['market_price'])); ?> <?php echo $currency; ?></strong></div>
                                            
												<div style="width:100px;height:25px;background:url('/static/css/images/boxs.png') top right no-repeat; margin-top:1px;padding-top:10px;padding-right:5px;">
												<strong class="old" style="color:red">Giảm <?php echo ceil(team_discount($one)); ?>%</strong></div>
                                            
												<div style="width:100px;height:30px;background:url('/static/css/images/boxs.png') top right no-repeat; margin-top:1px;padding-top:7px;padding-right:5px;">
												<strong class="old" style="color:#3399ff; font-size:130%;"> <?php echo $one['now_number']; ?></strong> mua</strong></div>
                                            
												<div style="_margin-top:-1px;margin-top:0px">
												 <?php if($one['state']=='soldout' ){?>
														<img src="/static/css/images/btn_soldout.png" />    										
												 <?php } else if($one['state']=='expired' ) { ?>
														<img src="/static/css/images/btn_expires.png" />    										
												 <?php } else { ?>
														<a href="/<?php echo $city['slug']; ?>/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>" title="<?php echo $one['title']; ?>"><img src="/static/css/images/btn_buy.png" /></a>
												<?php }?>
												</div>
                                        </div>
                                  </td>
                                  <td style="background: url(&quot;/static/css/images/box_sr.gif&quot;) repeat-y scroll left transparent;"></td>
                                </tr>
                                <tr>
                                  <td align="right" valign="bottom"><img src="/static/css/images/box_bl.gif" alt="" width="20" border="0" height="19"></td>
                                  <td style="background: url(&quot;/static/css/images/faqbox_bottombg.gif&quot;) repeat-x scroll 0% 0% transparent;"></td>
                                  <td align="left"><img src="/static/css/images/box_br.gif" alt="" width="20" border="0" height="19"></td>
                                </tr>
                              </tbody>
                            </table>
                          </li> 
                        	<?php }}?>
						</ul>
                        
                        <div class="clear"></div>	
                        
                        <?php if($count>10){?><div style="text-align:center"><?php echo $pagestring; ?></div><?php }?>
                        
                     </td>
                     <td width="10%" align="left" valign="top" style="padding-top:10px; padding-right:10px">
                     	<div id="sidebar">
                          <?php include template("block_side_support");?>
                        </div>
                     </td></tr></table>
					<div class="clear"></div>					
				</div>
            </div>
        </div><div class="clear"></div>
    </div>
</div>
    </div> <!-- bd end -->
</div> <!-- bdw end -->
<?php include template("footer");?>