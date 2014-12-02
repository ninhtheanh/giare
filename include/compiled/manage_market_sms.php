<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_market('sms'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top"> <div class="subhead"><h2>Group SMS</h2></div></div>
            <div class="box-content">
                <div class="sect" style="padding-top:5px;">
                    <form method="post" class="validator">
                        <div class="field">
                            <label>Mobile</label>
							<div style="float:left;"><textarea cols="45" rows="5" name="phones" class="f-textarea" datatype="require" require="true"><?php echo htmlspecialchars($_POST['phones']); ?></textarea></div>
							<span class="hint">Use coma, space or new line to differentiate mobile numbers, and the maximum for one sending is 300 mobile numbers.</span>
                        </div>

                        <div class="field">
                            <label>SMS content</label>
							<div style="float:left;"><textarea id="sms-content-id" cols="45" rows="5" name="content" class="f-textarea" datatype="require" require="true" onkeyup='return X.misc.smscount();'><?php echo htmlspecialchars($_POST['content']); ?></textarea></div>
							<span class="hint">One SMS is within 70 characters. A single letter is one character. Now there are &nbsp;<span id="span-sms-length-id" style="color:red;font-weight:bold;font-size:14px;">0</span>&nbsp; characters，which are sent in &nbsp;<span id="span-sms-split-id" style="color:red;font-weight:bold;font-size:14px;">0</span>&nbsp; SMS</span>
                        </div>

                        <div class="act">
                            <input type="submit" value="send" name="commit" class="formbutton"/>
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
