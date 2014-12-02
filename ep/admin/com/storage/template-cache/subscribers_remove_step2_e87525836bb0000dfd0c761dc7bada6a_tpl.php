<?php $IEM = $tpl->Get('IEM'); ?><form method="post" action="index.php?Page=Subscribers&Action=Remove&SubAction=Step3&list=<?php if(isset($GLOBALS['list'])) print $GLOBALS['list']; ?>" enctype="multipart/form-data" onsubmit="return CheckForm();">
	<table cellspacing="0" cellpadding="0" width="100%" align="center">
		<tr>
			<td class="Heading1">
				<?php print GetLang('Subscribers_Remove_Step2'); ?>
			</td>
		</tr>
		<tr>
			<td class="body pageinfo">
				<p>
					<?php print GetLang('Subscribers_Remove_Step2_Intro'); ?>
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<?php if(isset($GLOBALS['Message'])) print $GLOBALS['Message']; ?>
			</td>
		</tr>
		<tr>
			<td>
				<input class="FormButton" type="submit" value="<?php print GetLang('Next'); ?>">
				<input class="FormButton" type="button" value="<?php print GetLang('Cancel'); ?>" onClick='if(confirm("<?php print GetLang('Subscribers_Remove_CancelPrompt'); ?>")) { document.location="index.php?Page=Subscribers&Action=Remove" }'>
				<br />
				&nbsp;
				<table border="0" cellspacing="0" cellpadding="2" width="100%" class="Panel">
					<tr>
						<td colspan="2" class="Heading2">
							<?php print GetLang('Subscribers_Remove_Heading'); ?>
						</td>
					</tr>
					<tr style="height:15px">
						<td class="FieldLabel">
							<?php $tmpTplFile = $tpl->GetTemplate();
			$tmpTplData = $tpl->TemplateData;
			$tpl->ParseTemplate("Required");
			$tpl->SetTemplate($tmpTplFile);
			$tpl->TemplateData = $tmpTplData; ?>
							<?php print GetLang('RemoveEmails'); ?>:&nbsp;
						</td>
						<td>
							<input type="radio" name="howRemove" id="radioTextbox" /> <label for="radioTextbox"><?php print GetLang('RemoveViaTextbox'); ?></label>
						</td>
					</tr>
					<tr style="display:none" id="trTextbox">
						<td class="FieldLabel">
							&nbsp;
						</td>
						<td valign="top" style="padding-left:20px">
							<img src="images/nodejoin.gif" style="float:left" />&nbsp; <textarea name="RemoveEmailList" id="RemoveEmailList" cols="30" rows="5" style="width: 250px;"></textarea>&nbsp;&nbsp;&nbsp;<span class="HelpToolTip"><img src="images/help.gif" alt="?" width="24" height="16" border="0" /><span class="HelpToolTip_Title" style="display:none;"><?php print stripslashes(GetLang('RemoveEmails')); ?></span><span class="HelpToolTip_Contents" style="display:none;"><?php print stripslashes(GetLang('HLP_RemoveEmails')); ?></span></span>
						</td>
					</tr>
					<tr style="height:15px">
						<td class="FieldLabel">
							&nbsp;
						</td>
						<td>
							<input type="radio" name="howRemove" id="radioFile" /> <label for="radioFile"><?php print GetLang('RemoveViaFile'); ?></label>
						</td>
					</tr>
					<tr style="display:none" id="trFile">
						<td class="FieldLabel">
							&nbsp;
						</td>
						<td valign="top" style="padding-left:20px">
							<img src="images/nodejoin.gif" style="float:left" />&nbsp; <input type="file" name="RemoveFile" id="RemoveFile" class="Field250">
							<span class="HelpToolTip"><img src="images/help.gif" alt="?" width="24" height="16" border="0" /><span class="HelpToolTip_Title" style="display:none;"><?php print stripslashes(GetLang('RemoveFile')); ?></span><span class="HelpToolTip_Contents" style="display:none;"><?php print stripslashes(GetLang('HLP_RemoveFile')); ?></span></span>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<?php $tmpTplFile = $tpl->GetTemplate();
			$tmpTplData = $tpl->TemplateData;
			$tpl->ParseTemplate("Required");
			$tpl->SetTemplate($tmpTplFile);
			$tpl->TemplateData = $tmpTplData; ?>
							<?php print GetLang('RemoveOptions'); ?>:&nbsp;
						</td>
						<td>
							<select name="RemoveOption" id="RemoveOption">
								<option value="Unsubscribe"><?php print GetLang('RemoveUnsubscribe'); ?></option>
								<option value="Delete"><?php print GetLang('RemoveDelete'); ?></option>
							</select>
							&nbsp;<span class="HelpToolTip"><img src="images/help.gif" alt="?" width="24" height="16" border="0" /><span class="HelpToolTip_Title" style="display:none;"><?php print stripslashes(GetLang('RemoveOptions')); ?></span><span class="HelpToolTip_Contents" style="display:none;"><?php print stripslashes(GetLang('HLP_RemoveOptions')); ?></span></span>
						</td>
					</tr>
				</table>
				<table width="100%" cellspacing="0" cellpadding="2" border="0" class="PanelPlain">
					<tr>
						<td width="200" class="FieldLabel">&nbsp;</td>
						<td valign="top" height="30">
							<input class="FormButton" type="submit" value="<?php print GetLang('Next'); ?>">
							<input class="FormButton" type="button" value="<?php print GetLang('Cancel'); ?>" onClick='if(confirm("<?php print GetLang('Subscribers_Remove_CancelPrompt'); ?>")) { document.location="index.php?Page=Subscribers&Action=Remove" }'>
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
		if (f.RemoveEmailList.value == "" && f.RemoveFile.value =="") {
			alert("<?php print GetLang('EnterEmailAddressesToRemove'); ?>");
			f.RemoveEmailList.focus();
			return false;
		}

		// Double check they really want to do this if they selected the delete option (Added by Mitch)
		if(document.getElementById('RemoveOption').selectedIndex == 1) {
			if(!confirm('<?php print GetLang('RemoveConfirmDelete'); ?>')) {
				return false;
			}
		}

		return true;
	}

	// Added by Mitch when redesigning the removal process for IEM 5
	$('#radioTextbox').click(function() {
		$('#trTextbox').show();
		$('#trFile').hide();
		$('#RemoveEmailList').focus();
	});

	$('#radioFile').click(function() {
		$('#trTextbox').hide();
		$('#trFile').show();
	});

</script>
