<?php include template("header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="recent-deals">
<?php if(option_yes('cateteam')){?>
	<div class="dashboard" id="dashboard">
		<ul><?php echo current_teamcategory($group_id); ?></ul>
	</div>
<?php } else { ?>
<div class="dashboard" id="dashboard" style="z-index:-1;">
		<ul style="z-index:-1"><?php echo current_frontend(); ?></ul>        
	</div>
    <?php if($count>15){?><div style="padding:0;margin:0;float:right;margin-top:-35px;margin-right:10px;text-align:center;z-index:99"><?php echo $pagestring; ?></div><?php }?>
<?php }?>
    <div id="content" class="mainwide">
        <div class="box clear">
            <div class="subbox-content"><div style="background-color:#FFFFFF;min-height:450px;_height:450px">
            <a href="http://www.dealsoc.vn/tp-ho-chi-minh/cap-ao-thun-tinh-nhan-gia-0d-287.html"><img src="/static/banner/topbanner.jpg" /></a>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="top" width="90%" style="padding-top:7px;padding-left:5px;padding-bottom:10px;">
                        <ul class="deals-list" style="margin-left:3px;">
                            <?php if(is_array($teams)){foreach($teams AS $index=>$one) { ?>
                            <?php $team_cat = Table::Fetch('category', $one['group_id']);; ?>
                            <li class="<?php echo $index++%3==0?'first':'alt'; ?>" style="padding:0px;margin:0px;padding-bottom:3px; padding-right:3px;">
                           		<div class="csbox">
                                        <h4 style="font-size:110%; font-family:Arial; width:279px">
                                        <a href="/<?php echo $city['slug']; ?>/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>" title="<?php echo $one['title']; ?>">
                                        <strong><?php echo $one['short_title']; ?></strong></a>
                                         <span class="time" style="color:#999;"> - <?php echo date('d/m/Y', $one['begin_time']); ?></span>
                                        </h4>
                                                                                         
                                        <div class="pic">                                                                             
                                            <!--<div class="<?php echo $one['picclass']; ?>"></div>--><a href="/<?php echo $city['slug']; ?>/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>" title="<?php echo $one['title']; ?>"><img alt="<?php echo $one['title']; ?>" src="<?php echo team_image($one['image'],true); ?>" width="250" /></a>                                   
                                            <div style="z-index:100; position:absolute; top:0; left:184px;text-align:right;">
                                            
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
                              </div>
                              </div>
                          </li> 
                        	<?php }}?>
						</ul>
                        
                        <div class="clear"></div>
                        
                        <?php if($count>15){?><div style="text-align:center"><?php echo $pagestring; ?></div><?php }?>
                        
                     </td>
                     </tr></table>
					<div class="clear"></div>					
				</div>
            </div>
        </div><div class="clear"></div>
    </div>
</div>
    </div> <!-- bd end -->
</div> <!-- bdw end -->
<?php include template("footer");?>