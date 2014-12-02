<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_system('index'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top"><div class="subhead"><h2>Basic setting</h2></div></div>
            <div class="box-content">
                
                <div class="sect">
                    <form method="post">
						<div class="wholetip clear"><h3>1. Basic information</h3></div>
                        <div class="field">
                            <label>website</label>
                            <input type="text" size="30" name="system[sitename]" class="f-input" value="<?php echo $INI['system']['sitename']; ?>"/>
                        </div>
                        <div class="field">
                            <label>website name</label>
                            <input type="text" size="30" name="system[sitetitle]" class="f-input" value="<?php echo $INI['system']['sitetitle']; ?>"/>
                        </div>
                        <div class="field">
                            <label>site abbrev</label>
                            <input type="text" size="30" name="system[abbreviation]" class="f-input" value="<?php echo $INI['system']['abbreviation']; ?>"/>
                        </div>
                        <div class="field">
                            <label>coupon name</label>
                            <input type="text" size="30" name="system[couponname]" class="f-input" value="<?php echo $INI['system']['couponname']; ?>"/>
                        </div>
                        <div class="field">
                            <label>currency icon</label>
                            <input type="text" size="30" name="system[currency]" class="number" value="<?php echo $INI['system']['currency']; ?>"/>
						</div>
                        <div class="field">
                            <label>currency code</label>
                            <input type="text" size="30" name="system[currencyname]" class="number" value="<?php echo $INI['system']['currencyname']; ?>"/><span class="inputtip">e.g.：CNY, USD and etc.</span>
						</div>
                        <div class="field">
                            <label>invite & rebate</label>
                            <input type="text" size="30" name="system[invitecredit]" class="number" value="<?php echo abs(intval($INI['system']['invitecredit'])); ?>"/>
							<span class="inputtip">unit：<?php echo $currency; ?></span>
						</div>
                        <div class="field">
                            <label>side deal?</label>
                            <input type="text" size="30" name="system[sideteam]" class="number" value="<?php echo abs(intval($INI['system']['sideteam'])); ?>"/>
							<span class="inputtip">The default side deal number is 0</span>
							<span class="hint">On the right column of the deal page, to display other today deals or not?</span>
						</div>
						<div class="wholetip clear"><h3>2. Zigzag</h3></div>
                        <div class="field">
                            <label>deal condition</label>
                            <input type="text" size="30" name="system[conduser]" class="number" value="<?php echo abs(intval($INI['system']['conduser'])); ?>"/><span class="inputtip">1-- deal decided by number of buyers who have paid; 0-- deal decided by quantity of products purchased</span>
						</div>
                        <div class="field">
                            <label>download</label>
                            <input type="text" size="30" name="system[partnerdown]" class="number" value="<?php echo abs(intval($INI['system']['partnerdown'])); ?>"/><span class="inputtip">1--the biz can download both the coupon No. and code; 0--the biz can only download the coupon No.</span>
						</div>
                        <div class="field">
                            <label>gzip</label>
                            <input type="text" size="30" name="system[gzip]" class="number" value="<?php echo abs(intval($INI['system']['gzip'])); ?>"/><span class="inputtip">1 gzip on，0 gzip off</span>
							<span class="hint">Compression can reduce network traffic transmission output and save download time, but will slightly reduce the server performance</span>
						</div>
						<div class="wholetip clear"><h3>3. Customer service</h3></div>
                        <div class="field">
                            <label>QQ</label>
                            <input type="text" size="30" name="system[kefuqq]" class="f-input" value="<?php echo $INI['system']['kefuqq']; ?>"/>
						</div>
                        <div class="field">
                            <label>MSN</label>
                            <input type="text" size="30" name="system[kefumsn]" class="f-input" value="<?php echo $INI['system']['kefumsn']; ?>"/>
                            
						</div>
						<div class="wholetip clear"><h3>4. Others</h3></div>
                        <div class="field">
                            <label>ICP</label>
                            <input type="text" size="30" name="system[icp]" class="f-input" value="<?php echo $INI['system']['icp']; ?>"/>
						</div>
                        <div class="field">
                            <label>Statistical code</label>
                            <input type="text" size="30" name="system[statcode]" class="f-input" value="<?php echo htmlspecialchars(stripslashes($INI['system']['statcode'])); ?>"/>
						</div>
                        <div class="field">
                            <label>Sina</label>
                            <input type="text" size="30" name="system[sinajiwai]" class="f-input" value="<?php echo htmlspecialchars(stripslashes($INI['system']['sinajiwai'])); ?>"/>
						</div>
                        <div class="field">
                            <label>TenCent</label>
                            <input type="text" size="30" name="system[tencentjiwai]" class="f-input" value="<?php echo htmlspecialchars(stripslashes($INI['system']['tencentjiwai'])); ?>"/>
						</div>
                        <div class="field">
                            <label>Google Apikey</label>
                            <input type="text" size="30" name="system[googlemap]" class="f-input" value="<?php echo htmlspecialchars(stripslashes($INI['system']['googlemap'])); ?>" style="width:500px;"/><span class="inputtip">google map Apikey：<a href="http://code.google.com/intl/en/apis/maps/signup.html" target="_blank">Apply for one now </a></span>
						</div>
						<div class="act">
                            <input type="submit" value="save" name="commit" class="formbutton" />
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
