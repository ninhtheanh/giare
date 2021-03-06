<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_system('option'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top"><div class="subhead"><h2>Options setting</h2></div></div>
            <div class="box-content">
                
                <div class="sect">
                    <form method="post">
						<div class="wholetip clear"><h3>1. Navigation</h3></div>
						<div class="field">
                            <label>Discuss</label>
							<select name="option[navforum]"><?php echo Utility::Option($option_yn, option_yesv('navforum')); ?></select>
                        </div>
						<div class="wholetip clear"><h3>2. Zigzag</h3></div>
						<div class="field">
                            <label>Failures</label>
							<select name="option[displayfailure]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('displayfailure')); ?></select><span class="inputtip">In recent deals, to display failure deals or not</span>
                        </div>
						<div class="field">
                            <label>All Q&As</label>
							<select name="option[teamask]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('teamask')); ?></select><span class="inputtip">To display all Q&As of this deal or not</span>
                        </div>
						<div class="field">
                            <label>SMS subscribe</label>
							<select name="option[smssubscribe]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('smssubscribe')); ?></select><span class="inputtip">Turn on SMS subscription or not</span>
                        </div>
						<div class="field">
                            <label>Money saved</label>
							<select name="option[moneysave]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('moneysave')); ?></select><span class="inputtip">On the page of deals list, display the total sum of money saved for users</span>
                        </div>
						<div class="field">
                            <label>Page display</label>
							<select name="option[teamwhole]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('teamwhole')); ?></select><span class="inputtip">Deals detail and biz info is displayed on the full page, not in columns</span>
                        </div>
						<div class="field">
                            <label>Id obscure</label>
							<select name="option[encodeid]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('encodeid')); ?></select><span class="inputtip">Obscure all the id number to alpha-number</span>
                        </div>
						<div class="field">
                            <label>User privacy</label>
							<select name="option[userprivacy]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('userprivacy')); ?></select><span class="inputtip">To protect users privacy to the most extent.</span>
                        </div>
						<div class="field">
                            <label>Credit</label>
							<select name="option[usercredit]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('usercredit')); ?></select><span class="inputtip">To turn on the credit feature or not</span>
                        </div>
						<div class="wholetip clear"><h3>3. Display according to category</h3></div>
                        <div class="field">
                            <label>Recent deals</label>
							<select name="option[cateteam]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('cateteam')); ?></select><span class="inputtip">To display category or not?</span>
						</div>
						<div class="wholetip clear"><h3>4. Registration options</h3></div>
						<div class="field">
                            <label>Email</label>
							<select name="option[emailverify]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('emailverify')); ?></select><span class="inputtip">When a user registers, to verify her/his Email or not?</span>
                        </div>
						<div class="field">
                            <label>Mobile</label>
							<select name="option[needmobile]" style="float:left;"><?php echo Utility::Option($option_yn, option_yesv('needmobile')); ?></select><span class="inputtip">When a user registers, need she/he type a valid mobile number?</span>
                        </div>

						<div class="act">
                            <input type="submit" value="Save" name="commit" class="formbutton" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="box-bottom"></div>
        </div>
	</div>
<!--
<div id="sidebar">
</div>
-->
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("manage_footer");?>
