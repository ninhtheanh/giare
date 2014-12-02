<?php $IEM = $tpl->Get('IEM'); ?><form method="post" action="index.php?Page=Autoresponders&Action=<?php if(isset($GLOBALS['Action'])) print $GLOBALS['Action']; ?>" onsubmit="return CheckForm()">
	<table cellspacing="0" cellpadding="0" width="100%" align="center">
		<tr>
			<td class="Heading1">
				<?php if(isset($GLOBALS['Heading'])) print $GLOBALS['Heading']; ?>
			</td>
		</tr>
		<tr>
			<td class="body pageinfo">
				<p>
					<?php if(isset($GLOBALS['Intro'])) print $GLOBALS['Intro']; ?>
				</p>
				<?php if(isset($GLOBALS['Message'])) print $GLOBALS['Message']; ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php if(isset($GLOBALS['CronWarning'])) print $GLOBALS['CronWarning']; ?>
			</td>
		</tr>
		<tr>
			<td>
				<input class="FormButton" type="submit" value="<?php print GetLang('Next'); ?>">
				<input class="FormButton" type="button" value="<?php print GetLang('Cancel'); ?>" onClick='if(confirm("<?php if(isset($GLOBALS['CancelButton'])) print $GLOBALS['CancelButton']; ?>")) { document.location="index.php?Page=Autoresponders&Action=Step2&list=<?php if(isset($GLOBALS['List'])) print $GLOBALS['List']; ?>" }'>
				<br />
				&nbsp;
				<table border="0" cellspacing="0" cellpadding="2" width="100%" class="Panel">
					<tr <?php if(isset($GLOBALS['FilterOptions'])) print $GLOBALS['FilterOptions']; ?>>
						<td colspan="2" class="Heading2">
							&nbsp;&nbsp;<?php print GetLang('AutoresponderDetails'); ?>
						</td>
					</tr>
					<tr>
						<td width="200" class="FieldLabel">
							<?php $tmpTplFile = $tpl->GetTemplate();
			$tmpTplData = $tpl->TemplateData;
			$tpl->ParseTemplate("Required");
			$tpl->SetTemplate($tmpTplFile);
			$tpl->TemplateData = $tmpTplData; ?>
							<?php print GetLang('AutoresponderName'); ?>:&nbsp;
						</td>
						<td>
							<input type="text" name="name" class="Field250" value="<?php if(isset($GLOBALS['Name'])) print $GLOBALS['Name']; ?>">&nbsp;<span class="HelpToolTip"><img src="images/help.gif" alt="?" width="24" height="16" border="0" /><span class="HelpToolTip_Title" style="display:none;"><?php print stripslashes(GetLang('AutoresponderName')); ?></span><span class="HelpToolTip_Contents" style="display:none;"><?php print stripslashes(GetLang('HLP_AutoresponderName')); ?></span></span>
							<div class="aside"><?php print GetLang('Autoresponder_Name_Reference'); ?></div>
						</td>
					</tr>
				</table>
				<table border="0" cellspacing="0" cellpadding="2" width="100%" class="Panel" <?php if(isset($GLOBALS['FilterOptions'])) print $GLOBALS['FilterOptions']; ?>>
					<tr>
						<td colspan="2" class="Heading2">
							&nbsp;&nbsp;<?php print GetLang('FilterOptions_Autoresponders'); ?>
						</td>
					</tr>
					<tr <?php if(isset($GLOBALS['FilterOptions'])) print $GLOBALS['FilterOptions']; ?>>
						<td class="FieldLabel">
							<?php $tmpTplFile = $tpl->GetTemplate();
			$tmpTplData = $tpl->TemplateData;
			$tpl->ParseTemplate("Not_Required");
			$tpl->SetTemplate($tmpTplFile);
			$tpl->TemplateData = $tmpTplData; ?>
							<?php print GetLang('ShowFilteringOptions_Autoresponders'); ?>:&nbsp;
						</td>
						<td>
							<table width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td width="260px;">
										<label for="DoNotShowFilteringOptions"><input type="radio" name="ShowFilteringOptions" id="DoNotShowFilteringOptions" value="2" <?php if(isset($GLOBALS['DoNotShowFilteringOptions'])) print $GLOBALS['DoNotShowFilteringOptions']; ?> onclick="document.getElementById('FilteringOptions').style.display = 'none';"><?php print GetLang('AutorespondersDoNotShowFilteringOptionsOneListExplain'); ?></label>
								</tr>
								<tr>
									<td>
										<label for="ShowFilteringOptions"><input type="radio" name="ShowFilteringOptions" id="ShowFilteringOptions" value="1" <?php if(isset($GLOBALS['ShowFilteringOptions'])) print $GLOBALS['ShowFilteringOptions']; ?> onclick="document.getElementById('FilteringOptions').style.display = '';"><?php print GetLang('AutorespondersShowFilteringOptionsOneListExplain'); ?></label>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>

				<table border="0" cellspacing="0" cellpadding="2" width="100%" class="Panel" id="FilteringOptions" <?php if(isset($GLOBALS['FilteringOptions_Display'])) print $GLOBALS['FilteringOptions_Display']; ?>>
					<tr>
						<td colspan="2" class="Heading2">
							&nbsp;&nbsp;<?php print GetLang('AutoresponderFilterDetails'); ?>
						</td>
					</tr>
					<Tr>
						<td colspan="2">
							<br />
							<div style='background-color:#FFF1A8; padding:5px 5px 8px 10px; margin-bottom:10px'>
								<?php print GetLang('Autoresponder_Filter_Help'); ?>
							</div>
						</td>
					</tr>
					<tr>
						<td width="200" class="FieldLabel">
							<?php $tmpTplFile = $tpl->GetTemplate();
			$tmpTplData = $tpl->TemplateData;
			$tpl->ParseTemplate("Not_Required");
			$tpl->SetTemplate($tmpTplFile);
			$tpl->TemplateData = $tmpTplData; ?>
							<?php print GetLang('MatchEmail'); ?>:&nbsp;
						</td>
						<td>
							<input type="text" name="emailaddress" value="<?php if(isset($GLOBALS['emailaddress'])) print $GLOBALS['emailaddress']; ?>" class="Field250">&nbsp;<span class="HelpToolTip"><img src="images/help.gif" alt="?" width="24" height="16" border="0" /><span class="HelpToolTip_Title" style="display:none;"><?php print stripslashes(GetLang('MatchEmail')); ?></span><span class="HelpToolTip_Contents" style="display:none;"><?php print stripslashes(GetLang('HLP_MatchEmail')); ?></span></span>
						</td>
					</tr>
					<tr>
						<td width="200" class="FieldLabel">
							<?php $tmpTplFile = $tpl->GetTemplate();
			$tmpTplData = $tpl->TemplateData;
			$tpl->ParseTemplate("Not_Required");
			$tpl->SetTemplate($tmpTplFile);
			$tpl->TemplateData = $tmpTplData; ?>
							<?php print GetLang('MatchFormat'); ?>:&nbsp;
						</td>
						<td>
							<select name="format" class="Field250">
								<?php if(isset($GLOBALS['FormatList'])) print $GLOBALS['FormatList']; ?>&nbsp;
							</select>&nbsp;<span class="HelpToolTip"><img src="images/help.gif" alt="?" width="24" height="16" border="0" /><span class="HelpToolTip_Title" style="display:none;"><?php print stripslashes(GetLang('MatchFormat')); ?></span><span class="HelpToolTip_Contents" style="display:none;"><?php print stripslashes(GetLang('HLP_MatchFormat')); ?></span></span>
						</td>
					</tr>
					<tr>
						<td width="200" class="FieldLabel">
							<?php $tmpTplFile = $tpl->GetTemplate();
			$tmpTplData = $tpl->TemplateData;
			$tpl->ParseTemplate("Not_Required");
			$tpl->SetTemplate($tmpTplFile);
			$tpl->TemplateData = $tmpTplData; ?>
							<?php print GetLang('MatchConfirmedStatus'); ?>:&nbsp;
						</td>
						<td>
							<select name="confirmed" class="Field250">
								<?php if(isset($GLOBALS['ConfirmList'])) print $GLOBALS['ConfirmList']; ?>
							</select>&nbsp;<span class="HelpToolTip"><img src="images/help.gif" alt="?" width="24" height="16" border="0" /><span class="HelpToolTip_Title" style="display:none;"><?php print stripslashes(GetLang('MatchConfirmedStatus')); ?></span><span class="HelpToolTip_Contents" style="display:none;"><?php print stripslashes(GetLang('HLP_MatchConfirmedStatus')); ?></span></span>
						</td>
					</tr>
					<tr>
						<td width="200" class="FieldLabel">
							<?php $tmpTplFile = $tpl->GetTemplate();
			$tmpTplData = $tpl->TemplateData;
			$tpl->ParseTemplate("Not_Required");
			$tpl->SetTemplate($tmpTplFile);
			$tpl->TemplateData = $tmpTplData; ?>
							<?php print GetLang('Autoresponder_ClickedOnLink'); ?>:
						</td>
						<td>
							<label for="clickedlink"><input type="checkbox" name="clickedlink" id="clickedlink" value="1" <?php if(isset($GLOBALS['clickedlink'])) print $GLOBALS['clickedlink']; ?> onClick="javascript: enable_ClickedLink(this, 'clicklink', 'linkid', '<?php print GetLang('LoadingMessage'); ?>')">&nbsp;<?php print GetLang('Autoresponder_YesFilterByLink'); ?></label>
							&nbsp;<span class="HelpToolTip"><img src="images/help.gif" alt="?" width="24" height="16" border="0" /><span class="HelpToolTip_Title" style="display:none;"><?php print stripslashes(GetLang('Autoresponder_ClickedOnLink')); ?></span><span class="HelpToolTip_Contents" style="display:none;"><?php print stripslashes(GetLang('HLP_Autoresponder_ClickedOnLink')); ?></span></span>
							<br/>
							<div id="clicklink" style="display: <?php if(isset($GLOBALS['clickedlinkdisplay'])) print $GLOBALS['clickedlinkdisplay']; ?>">
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td valign="middle">
											<img src="images/nodejoin.gif" width="20" height="20" border="0">
										</td>
										<td colspan="2">
											<select name="linktype" style="width: 120px;">
												<option value="clicked"<?php if(isset($GLOBALS['LinkType_Clicked'])) print $GLOBALS['LinkType_Clicked']; ?>><?php print GetLang('Search_HaveClicked'); ?></option>
												<option value="not_clicked"<?php if(isset($GLOBALS['LinkType_NotClicked'])) print $GLOBALS['LinkType_NotClicked']; ?>><?php print GetLang('Search_HaveNotClicked'); ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td valign="middle">
											&nbsp;
										</td>
										<td valign="middle">
											<img src="images/nodejoin.gif" width="20" height="20" border="0">
										</td>
										<td>
											<select name="linkid" id="linkid"<?php if(isset($GLOBALS['LinkChange'])) print $GLOBALS['LinkChange']; ?>>
												<?php if(isset($GLOBALS['ClickedLinkOptions'])) print $GLOBALS['ClickedLinkOptions']; ?>
											</select>
										</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
					<tr>
						<td width="200" class="FieldLabel">
							<?php $tmpTplFile = $tpl->GetTemplate();
			$tmpTplData = $tpl->TemplateData;
			$tpl->ParseTemplate("Not_Required");
			$tpl->SetTemplate($tmpTplFile);
			$tpl->TemplateData = $tmpTplData; ?>
							<?php print GetLang('Autoresponder_OpenedNewsletter'); ?>:
						</td>
						<td>
							<label for="openednewsletter"><input type="checkbox" name="openednewsletter" id="openednewsletter" value="1" <?php if(isset($GLOBALS['openednewsletter'])) print $GLOBALS['openednewsletter']; ?> onClick="javascript: enable_OpenedNewsletter(this, 'opennews', 'newsletterid', '<?php print GetLang('LoadingMessage'); ?>')">&nbsp;<?php print GetLang('Autoresponder_YesFilterByOpenedNewsletter'); ?></label>
							&nbsp;<span class="HelpToolTip"><img src="images/help.gif" alt="?" width="24" height="16" border="0" /><span class="HelpToolTip_Title" style="display:none;"><?php print stripslashes(GetLang('Autoresponder_OpenedNewsletter')); ?></span><span class="HelpToolTip_Contents" style="display:none;"><?php print stripslashes(GetLang('HLP_Autoresponder_OpenedNewsletter')); ?></span></span>
							<br/>
							<div id="opennews" style="display: <?php if(isset($GLOBALS['openednewsletterdisplay'])) print $GLOBALS['openednewsletterdisplay']; ?>">
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td valign="middle">
											<img src="images/nodejoin.gif" width="20" height="20" border="0">
										</td>
										<td colspan="2">
											<select name="opentype" style="width: 120px;">
												<option value="opened"<?php if(isset($GLOBALS['NewsletterType_Opened'])) print $GLOBALS['NewsletterType_Opened']; ?>><?php print GetLang('Search_HaveOpened'); ?></option>
												<option value="not_opened"<?php if(isset($GLOBALS['NewsletterType_NotOpened'])) print $GLOBALS['NewsletterType_NotOpened']; ?>><?php print GetLang('Search_HaveNotOpened'); ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td valign="middle">
											&nbsp;
										</td>
										<td valign="middle">
											<img src="images/nodejoin.gif" width="20" height="20" border="0">
										</td>
										<td>
											<select name="newsletterid" id="newsletterid"<?php if(isset($GLOBALS['NewsletterChange'])) print $GLOBALS['NewsletterChange']; ?>>
												<?php if(isset($GLOBALS['OpenedNewsletterOptions'])) print $GLOBALS['OpenedNewsletterOptions']; ?>
											</select>
										</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
					<?php if(isset($GLOBALS['CustomFieldInfo'])) print $GLOBALS['CustomFieldInfo']; ?>
				</table>
				<table width="100%" cellspacing="0" cellpadding="2" border="0" class="PanelPlain">
					<tr>
						<td width="200" class="FieldLabel"></td>
						<td>
							<input class="FormButton" type="submit" value="<?php print GetLang('Next'); ?>" />
							<input class="FormButton" type="button" value="<?php print GetLang('Cancel'); ?>" onClick='if (confirm("<?php if(isset($GLOBALS['CancelButton'])) print $GLOBALS['CancelButton']; ?>")) { document.location="index.php?Page=Autoresponders&Action=Step2&list=<?php if(isset($GLOBALS['List'])) print $GLOBALS['List']; ?>" }' />
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
		if (f.name.value == '') {
			alert("<?php print GetLang('EnterAutoresponderName'); ?>");
			f.name.focus();
			return false;
		}
	}
</script>
