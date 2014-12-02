<?php $IEM = $tpl->Get('IEM'); ?><form method="post" action="index.php?Page=Schedule&Action=Update&job=<?php if(isset($GLOBALS['JobID'])) print $GLOBALS['JobID']; ?>">
	<table cellspacing="0" cellpadding="0" width="100%" align="center">
		<tr>
			<td class="Heading1">
				<?php print GetLang('Schedule_Edit'); ?>
			</td>
		</tr>
		<tr>
			<td class="body pageinfo">
				<p>
					<?php print GetLang('Help_Schedule_Edit'); ?>
				</p>
			</td>
		</tr>
		<tr>
			<td class="body">
				<?php if(isset($GLOBALS['Message'])) print $GLOBALS['Message']; ?>
			</td>
		</tr>
		<tr>
			<td>
				<input class="FormButton" type="submit" value="<?php print GetLang('Save'); ?>">
				<input class="FormButton" type="button" value="<?php print GetLang('Cancel'); ?>" onClick='if(confirm("<?php print GetLang('ScheduleEditCancel_Prompt'); ?>")) { document.location="index.php?Page=Schedule" }'>
				<br />
				&nbsp;
				<table border="0" cellspacing="0" cellpadding="2" width="100%" class="Panel">
					<tr>
						<td colspan="2" class="Heading2">
							&nbsp;&nbsp;<?php print GetLang('NewsletterDetails'); ?>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<?php $tmpTplFile = $tpl->GetTemplate();
			$tmpTplData = $tpl->TemplateData;
			$tpl->ParseTemplate("Not_Required");
			$tpl->SetTemplate($tmpTplFile);
			$tpl->TemplateData = $tmpTplData; ?>
							<?php print GetLang('MailingList'); ?>:&nbsp;
						</td>
						<td>
							<?php if(isset($GLOBALS['Send_SubscriberList'])) print $GLOBALS['Send_SubscriberList']; ?>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<?php $tmpTplFile = $tpl->GetTemplate();
			$tmpTplData = $tpl->TemplateData;
			$tpl->ParseTemplate("Not_Required");
			$tpl->SetTemplate($tmpTplFile);
			$tpl->TemplateData = $tmpTplData; ?>
							<?php print GetLang('SendNewsletter'); ?>:&nbsp;
						</td>
						<td>
							<?php if(isset($GLOBALS['Send_NewsletterName'])) print $GLOBALS['Send_NewsletterName']; ?>&nbsp;&nbsp;
							<a href="#" onclick="javascript: PreparePreview(); return false;"><img src="images/magnify.gif" border="0">&nbsp;<?php print GetLang('Preview'); ?></a>
						</td>
					</tr>
					<tr>
						<td width="200" class="FieldLabel">
							<?php $tmpTplFile = $tpl->GetTemplate();
			$tmpTplData = $tpl->TemplateData;
			$tpl->ParseTemplate("Required");
			$tpl->SetTemplate($tmpTplFile);
			$tpl->TemplateData = $tmpTplData; ?>
							<?php print GetLang('SendTime'); ?>:&nbsp;
						</td>
						<td>
							<input type="hidden" name="sendtime" id="sendtime" value="" />
							<?php if(isset($GLOBALS['SendTimeBox'])) print $GLOBALS['SendTimeBox']; ?>&nbsp;<span class="HelpToolTip"><img src="images/help.gif" alt="?" width="24" height="16" border="0" /><span class="HelpToolTip_Title" style="display:none;"><?php print stripslashes(GetLang('SendTime')); ?></span><span class="HelpToolTip_Contents" style="display:none;"><?php print stripslashes(GetLang('HLP_SendTime')); ?></span></span>
						</td>
					</tr>
					<tr>
						<td>
							&nbsp;
						</td>
						<td>
							<input class="FormButton" type="submit" value="<?php print GetLang('Save'); ?>">
							<input class="FormButton" type="button" value="<?php print GetLang('Cancel'); ?>" onClick='if(confirm("<?php print GetLang('ScheduleEditCancel_Prompt'); ?>")) { document.location="index.php?Page=Schedule" }'>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>

<script>
	function PreparePreview() {
		var baseurl = "index.php?Page=Newsletters&Action=Preview&id=";
		var realId = <?php if(isset($GLOBALS['NewsletterID'])) print $GLOBALS['NewsletterID']; ?>;
		window.open(baseurl + realId , "pp");
	}

	function SetSendTime() {
		var h = $('#sendtime_hours').val();
		var m = $('#sendtime_minutes').val();
		var a = $('#sendtime_ampm').val();
		var sendtime = h + ':' + m + a;
		$('#sendtime').val(sendtime);
	}

	$(function() { SetSendTime(); })
</script>