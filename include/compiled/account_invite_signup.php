<?php include template("header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="referrals">
    <div id="content">
        <div class="box clear">
            <div class="subbox-top"><div class="subhead"><h2>Mời bạn bè và nhận thưởng</h2></div></div>
            <div class="box-content">
                <div class="sect" style="padding-top:10px">
                    <p class="intro">Khi bạn bè chấp nhận lời mời của bạn, và tham gia mua lần đầu tiên tại <?php echo $INI['system']['sitename']; ?>, hệ thống sẽ gửi <strong><?php echo print_price($INI['system']['invitecredit']); ?> <?php echo $currency; ?></strong> tới tài khoản điện tử <?php echo $INI['system']['sitename']; ?> của bạn. Số lượng không giới hạn, mời càng nhiều, tiền thưởng càng nhiều.</p>
                    <p class="login">Hãy <a href="/account/login.php?r=<?php echo $currefer; ?>">đăng nhập</a> hoặc <a href="/account/signup.php">đăng ký</a> để nhận Link dùng để mời bạn bè của bạn</p>
        		</div>
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