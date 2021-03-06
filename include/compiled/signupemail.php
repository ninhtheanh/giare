<?php include template("header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="maillist">
	<div id="content">
        <div class="box">
            <div class="box-top"></div>
            <div class="box-content welcome">
				<div class="head">
					 <h2>Sign In Email</h2>

				</div>
                <div class="sect">
					<div class="lead"><h4>Sign up to see today's deal and experience <?php echo $city['name']; ?> up to 90% off!</h4></div>
					<div class="enter-address">
						<p>Signing up using Facebook Connect</p>
						<div class="enter-address-c">
						<form id="enter-address-form" action="/account/signupemail.php" method="post" class="validator">

						<div class="field email">
							<label>Enter your email address: </label>
							<input id="enter-address-mail" name="email" class="f-input" type="text" value="<?php echo $_SESSION['FB_USER_LOGIN']['email']; ?>" size="30" require="true" datatype="email" />
							<span class="hint">(We hate Spam!, your email is safe with us!)</span>
						</div>
						<div class="field username">
                            <label for="signup-username">Username</label>

                            <input type="text" size="30" name="username" id="signup-username" class="f-input" value="<?php echo $_SESSION['FB_USER_LOGIN']['email']; ?>" datatype="limit" require="true" min="2" max="16" maxLength="16" />
                            <span class="hint">4-16 characters only</span>
                        </div>
                        <div class="field password">
                            <label for="signup-password">Password</label>
                            <input type="password" size="30" name="password" id="signup-password" class="f-input" require="true" datatype="require" />
                            <span class="hint">At least 4 characters</span>

                        </div>
                        <div class="field password">
                            <label for="signup-password-confirm">Confirm password</label>
                            <input type="password" size="30" name="password2" id="signup-password-confirm" class="f-input" require="true" datatype="compare" compare="signup-password" />
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
	   <!--<p><img src="/static/img/subscribe-pic1.jpg" /></p> 
	   <p><img src="/static/img/subscribe-pic2.jpg" /></p> 
	   <p><img src="/static/img/subscribe-pic3.jpg" /></p> -->
	</div>

</div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("footer");?>
