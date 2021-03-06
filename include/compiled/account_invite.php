<?php include template("header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="referrals">
	 <div id="content" class="refers">
        <div class="box clear">
            <div class="subbox-top"><div class="subhead"><h2>Mời bạn bè tham gia có thưởng</h2></div>
</div>
            <div class="box-content">
                <div class="sect" style="padding-top:10px">
					<?php if($money){?>
					<!--<p class="notice-total">You have invited <strong><?php echo $count; ?></strong> people, got in total <strong><?php echo print_price(moneyit($money)); ?> <span class="money"><?php echo $currency; ?></span></strong> rebate,<a href="/account/refer.php">Check List </a>。</p>-->
					<?php }?>
					<p class="intro">Khi bạn bè của bạn chấp nhận lời mời, và tham gia mua lần đầu tiên tại <?php echo $INI['system']['sitename']; ?>, trong vòng 24 giờ hệ thống sẻ gửi <strong><?php echo print_price($INI['system']['invitecredit']); ?> <?php echo $currency; ?></strong> tới tài khoản điện tử <?php echo $INI['system']['abbreviation']; ?> của bạn. Bạn có thể sử dụng tài khoản điện tử của bạn để mua hàng. Số lượng không giới hạn, mời càng nhiều, tiền thưởng càng nhiều.</p>
					<div class="share-list">
						<div class="blk im">
							<div class="logo"><img src="/static/css/images/chat48.png" /></div>
							<div class="info">
								<h4>Đây là Link dùng để mời bạn bè, hãy gửi đến bạn bè của bạn qua Gtalk ,Skype, MSN ,Yahoo.</h4>
								<input id="share-copy-text" type="text" value="<?php echo $INI['system']['wwwprefix']; ?>/r.php?r=<?php echo $login_user_id; ?>" size="35" class="f-input" onfocus="this.select()" tip="Copy link, và gửi cho bạn bè của bạn trên Chat" />
								<input id="share-copy-button" type="button" value="Copy" class="formbutton" />
							</div>
						</div>
						<div class="blk">
							<div class="info finder-form">
								<div id="email_invitation" style="display:none;">
								<form action="/account/invite.php" method="post" id="finder-form" class="validator">
								 <p><label for="recipients">Danh sách mời</label>
									<textarea name="recipients" id="recipients" class="f-input" rows="5" cols="50" require="true" datatype="require"></textarea>
								</p>
								<p><label for="invitation_content">Nội dung mời</label>
									<textarea name="invitation_content" id="invitation_content"  class="f-input" cols="50" rows="5" require="true" datatype="require">Hi，recently I'm surfing <?php echo $INI['system']['sitename']; ?>, and find it has wonderful deals everyday. Do come and have a look~ </textarea>
								</p>
								<p><label for="real_name">Tên bạn</label>
									<input id="real_name" type="text" value="<?php echo htmlspecialchars($login_user['username']); ?>" name="real_name" size="12" class="f-input"  require="true" datatype="require" />
								</p>
								<p class="commit"><input type="submit" class="formbutton" value="continue" /></p>
								</form>
								</div>
							</div>
						</div>
					<?php if($team){?>
						<div class="blk last">
							<div class="logo"><img src="/static/css/images/logo_share.png" /></div>
							<div class="info">
								<h4>Chia sẻ sản phẩm hôm nay cùng bạn bè của mình, bạn cũng có thể nhận được <?php echo print_price(abs($team['bonus'])); ?> <?php echo $currency; ?> tiền thưởng!</h4>
								<div class="deal-info">
									<p class="pic"><a href="/team.php?id=<?php echo $team['id']; ?>" target="_blank"><img src="<?php echo team_image($team['image']); ?>" width="150" height="90" /></a></p>
									<p class="deal-title"><?php echo $team['title']; ?></p>
                                    <div class="clear"></div>
                                    <div id="deal-share" >
                                        <!-- AddThis Button BEGIN -->
                                        <div class="addthis_toolbox addthis_default_style">
                                        <a class="addthis_button_preferred_1" addthis:url="<?php echo $INI['system']['wwwprefix']; ?>/r.php?r=<?php echo $login_user_id; ?>" ></a>
                                        <a class="addthis_button_preferred_2" addthis:url="<?php echo $INI['system']['wwwprefix']; ?>/r.php?r=<?php echo $login_user_id; ?>"></a>
                                        <a class="addthis_button_preferred_3" addthis:url="<?php echo $INI['system']['wwwprefix']; ?>/r.php?r=<?php echo $login_user_id; ?>"></a>
                                        <a class="addthis_button_preferred_4" addthis:url="<?php echo $INI['system']['wwwprefix']; ?>/r.php?r=<?php echo $login_user_id; ?>"></a>
                                        <a class="addthis_button_preferred_5" addthis:url="<?php echo $INI['system']['wwwprefix']; ?>/r.php?r=<?php echo $login_user_id; ?>"></a>
                                        </div>
                                        <!-- AddThis Button END -->
									</div>
								</div>
							</div>
						<?php }?>
						</div>
				</div>
				</div><div class="clear"></div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
    <div id="sidebar">
		<?php include template("block_side_invitetip");?>
    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->
<?php include template("footer");?>