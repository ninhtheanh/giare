<?php include template("header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="maillist">
	<div id="content">
        <div class="box">
            <div class="box-top"></div>
            <div class="box-content welcome">
				<div class="head">
					 <h2>You will now be registered</h2>

				</div>
                <div class="sect">
					<div class="lead"><h4>Twitter Connect :Last Step</h4></div>
					<div class="enter-address">
						<div class="enter-address-c">
						<form id="enter-address-form" action="/account/signup_twitteremail.php" method="post" class="validator">
						<div class="mail">
							<label>Enter Your Email address: </label>

							<input id="enter-address-mail" name="email" class="f-input f-mail" type="text" value="<?php echo $login_user['email']; ?>" size="20" require="true" datatype="email" />
							<span class="tip">(Don't worry, your email is safe with us!)</span>
						</div>
						<div class="city">
							<label>&nbsp;</label>
							<input id="enter-address-commit" type="submit" class="formbutton" value="Submit" />
						</div>
						</form>

					</div>
					<div class="clear"></div>
				</div>
				<div class="intro">
					<p>Our daily deals consist of:</p>
					<p>Massages, Restaurants, Hotels, Spas, Theaters, and a whole lot more...</p>
				</div>
			</div>

		</div>
		<div class="box-bottom"></div>
	</div>
</div>
<div id="sidebar">
	<div class="side-pic">
	   <p><img src="/static/img/subscribe-pic1.jpg" /></p> 
	   <p><img src="/static/img/subscribe-pic2.jpg" /></p> 
	   <p><img src="/static/img/subscribe-pic3.jpg" /></p> 
	</div>
</div>
</div>

</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("footer");?>
