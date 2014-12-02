<?php include template("header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">

	<div id="deal-default">
		<div id="content">
			<div id="deal-intro" class="cf">
                <h1 style="padding-left:0;">Biz: <?php echo $partner['title']; ?></h1>
                <div class="main">
					<div class="other"><?php echo htmlspecialchars_decode($partner['other']); ?></div>
					<div class="other" style="margin-top:5px;">
						<p><b>Phone</b>：<?php echo $partner['phone']; ?></p>
						<p><b>Location</b>：<?php echo $partner['address']; ?></p>
					<?php if($partner['homepage']){?>
						<p><b>Website</b>：<a href="<?php echo $partner['homepage']; ?>" target="_blank"><?php echo domainit($partner['homepage']); ?></a></p>
					<?php }?>
					</div>
					<div class="partner_team_info" style="margin:10px;padding:5px;background-color:#C3DCAF;">
						<p>organized group buy deals <b><?php echo $team_count; ?></b> times<p>
						<p>buy <b><?php echo $join_number; ?></b> person time</p>
						<p>save <b><?php echo print_price(moneyit($save_number)); ?></b> <?php echo $currency; ?></p>
					</div>
				</div>
                <div class="side">
                    <div class="deal-buy-cover-img" id="team_images">
					<?php if($partner['image1']||$partner['image2']){?>
						<div class="mid">
							<ul>
								<li class="first"><img src="<?php echo team_image($partner['image']); ?>"/></li>
							<?php if($partner['image1']){?>
								<li><img src="<?php echo team_image($partner['image1']); ?>"/></li>
							<?php }?>
							<?php if($partner['image2']){?>
								<li><img src="<?php echo team_image($partner['image2']); ?>"/></li>
							<?php }?>
							</ul>
							<div id="img_list">
								<a ref="1" class="active">1</a>
							<?php $imageindex=1;; ?>
							<?php if($partner['image1']){?>
								<a ref="<?php echo ++$imageindex; ?>" ><?php echo $imageindex; ?></a>
							<?php }?>
							<?php if($partner['image2']){?>
								<a ref="<?php echo ++$imageindex; ?>" ><?php echo $imageindex; ?></a>
							<?php }?>
							</div> 
						</div>
						<?php } else { ?>
							<img src="<?php echo team_image($partner['image']); ?>" width="440" height="280" />
						<?php }?>
					</div>
                </div>
            </div>
            <div id="recent-deals" class="cf" style="margin-top:15px;">
				<div class="box">
					<div class="box-top"></div>
					<div class="box-content">
						<div class="head">
						  <h2>Deals</h2>
						</div>
						<div class="sect">
							<ul class="deals-list">
							<?php if(is_array($teams)){foreach($teams AS $index=>$one) { ?>
								<li class="<?php echo $index++%2?'alt':''; ?> <?php echo $index<=2?'first':''; ?>">
									<p class="time"><?php echo date('d/n/Y H:i:s', $one['begin_time']); ?></p>
									<h4><a href="/team.php?id=<?php echo $one['id']; ?>" title="<?php echo $one['title']; ?>" target="_blank"><?php echo mb_strimwidth($one['title'],0,86,'...'); ?></a></h4>
									<div class="pic">
										<div class="<?php echo $one['picclass']; ?>"></div>
										<a href="/team.php?id=<?php echo $one['id']; ?>" title="<?php echo $one['title']; ?>" target="_blank"><img alt="<?php echo $one['title']; ?>" src="<?php echo team_image($one['image']); ?>" width="200" height="121"></a>
									</div>
									<div class="info"><p class="total" align="center"><strong class="count"><?php echo $one['now_number']; ?></strong><br />người đã mua</p></div>
                                      <div class="clear"><table width="100%" border="0">
                                      <tr>
                                        <td class="price"><!--Original price：-->Giá gốc: <strong class="old"><?php echo print_price(moneyit($one['market_price'])); ?> <span class="money"><?php echo $currency; ?></span></strong></td>
                                        <td class="price">Giảm:</strong> <strong class="discount"><?php echo moneyit((100*($one['market_price'] - $one['team_price'])/$one['market_price'])); ?> %</strong></td>
                                      </tr>
                                      <tr>
                                        <td class="price">Giá bán: <strong><?php echo print_price(moneyit($one['team_price'])); ?> <span class="money"><?php echo $currency; ?></span></strong></td>
                                        <td class="price">Tiến kiệm: <strong><?php echo print_price(moneyit($one['market_price']-$one['team_price'])); ?> <span class="money"><?php echo $currency; ?></span></strong></td>
                                      </tr>
                                    </table>
                                    </div>
								</li>
							<?php }}?>
							</ul>
							<div class="clear"></div>
							<div><?php echo $pagestring; ?></div>
						</div>
					</div>
					<div class="box-bottom"></div>
				</div>
            </div>
		</div>
    </div>
    <div id="sidebar">
		<?php include template("block_side_business");?>
		<?php include template("block_side_subscribe");?>
	</div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("footer");?>
