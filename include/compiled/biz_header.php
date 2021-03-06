<?php include template("biz_html_header");?>
<script type="text/javascript" src="/static/js/xheditor/xheditor.js"></script> 
<div id="hdw">
	<div id="hd">
		<div id="logo"><a href="/index.php" class="link" target="_blank"><img src="/static/css/images/logo.png" /></a></div>
		<div class="guides">
			<div class="city">
				<h2>Biz backend</h2>
			</div>
		</div>
		<ul class="nav cf"><?php echo current_biz(); ?></ul>
		<?php if(is_partner()){?>
		<div class="logins">
			<ul class="links">
				<li class="username">Welcome，<?php echo $login_partner['title']; ?>！</li>
				<li class="logout"><a href="/biz/logout.php">Logout</a></li>
			</ul>
			<div class="line islogin"></div>
		</div>
		<?php }?>
	</div>
</div>

<?php if($session_notice=Session::Get('notice',true)){?>
<div class="sysmsgw" id="sysmsg-success"><div class="sysmsg"><p><?php echo $session_notice; ?></p><span class="close">close</span></div></div> 
<?php }?>
<?php if($session_notice=Session::Get('error',true)){?>
<div class="sysmsgw" id="sysmsg-error"><div class="sysmsg"><p><?php echo $session_notice; ?></p><span class="close">close</span></div></div> 
<?php }?>
