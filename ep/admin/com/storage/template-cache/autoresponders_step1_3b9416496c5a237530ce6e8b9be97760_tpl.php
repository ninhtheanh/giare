<?php $IEM = $tpl->Get('IEM'); ?><form method="get" action="index.php" onsubmit="return CheckForm();">
	<input type="hidden" name="Page" value="Autoresponders" />
	<input type="hidden" name="Action" value="Step2" />
	<table cellspacing="0" cellpadding="0" width="100%" align="center">
		<tr>
			<td class="Heading1">
				<?php print GetLang('Autoresponder_Step1'); ?>
			</td>
		</tr>
		<tr>
			<td class="body pageinfo">
				<p>
					<?php print GetLang('Autoresponder_Step1_Intro'); ?>
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<?php if(isset($GLOBALS['CronWarning'])) print $GLOBALS['CronWarning']; ?>
			</td>
		</tr>
		<tr>
			<td>
				<input class="FormButton" type="submit" value="<?php print GetLang('Next'); ?>" />
				<input class="FormButton" type="button" value="<?php print GetLang('Cancel'); ?>" onClick='if (confirm("<?php print GetLang('Autoresponder_Step1_CancelPrompt'); ?>")) { window.location.href="index.php?Page=Autoresponders" }' />
				<br />
				&nbsp;
				<table border="0" cellspacing="0" cellpadding="2" width="100%" class="Panel">
					<tr>
						<td colspan="2" class="Heading2">
							&nbsp;&nbsp;<?php print GetLang('MailingListDetails'); ?>
						</td>
					</tr>
					<tr>
						<td width="200" class="FieldLabel">
							<?php $tmpTplFile = $tpl->GetTemplate();
			$tmpTplData = $tpl->TemplateData;
			$tpl->ParseTemplate("Not_Required");
			$tpl->SetTemplate($tmpTplFile);
			$tpl->TemplateData = $tmpTplData; ?>
							<?php print GetLang('MailingList'); ?>:&nbsp;
						</td>
						<td>
							<select name="list" style="width: 450px;" size="15" onDblClick="CheckForm() && this.form.submit()">
								<?php if(isset($GLOBALS['SelectList'])) print $GLOBALS['SelectList']; ?>
							</select>&nbsp;<span class="HelpToolTip"><img src="images/help.gif" alt="?" width="24" height="16" border="0" /><span class="HelpToolTip_Title" style="display:none;"><?php print stripslashes(GetLang('MailingList')); ?></span><span class="HelpToolTip_Contents" style="display:none;"><?php print stripslashes(GetLang('HLP_MailingList')); ?></span></span>
						</td>
					</tr>
				</table>
				<table width="100%" cellspacing="0" cellpadding="2" border="0" class="PanelPlain">
					<tr>
						<td width="200" class="FieldLabel"></td>
						<td>
							<input class="FormButton" type="submit" value="<?php print GetLang('Next'); ?>" />
							<input class="FormButton" type="button" value="<?php print GetLang('Cancel'); ?>" onClick='if (confirm("<?php if(isset($GLOBALS['CancelButton'])) print $GLOBALS['CancelButton']; ?>")) { window.location.href="index.php?Page=Autoresponders" }' />
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>

<script>
	function CheckForm() {
		var f = document.forms[0];
		if (f.list.selectedIndex < 0) {
			alert("<?php print GetLang('SelectOneList'); ?>");
			f.list.focus();
			return false;
		}
		return true;
	}
</script>
