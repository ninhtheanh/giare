<?php $IEM = $tpl->Get('IEM'); ?><script>
	Application.Page.SubscribersBannedManage = {
		eventDOMReady: function(event) {
			Application.Ui.CheckboxSelection(	'table#SubscribersBannedManageList',
												'input.UICheckboxToggleSelector',
												'input.UICheckboxToggleRows');
		}
	}

	Application.init.push(Application.Page.SubscribersBannedManage.eventDOMReady);
</script>
<table cellspacing="0" cellpadding="0" width="100%" align="center">
	<tr>
		<td class="Heading1"><?php if(isset($GLOBALS['SubscribersBannedManage'])) print $GLOBALS['SubscribersBannedManage']; ?></td>
	</tr>
	<tr>
		<td class="body pageinfo"><p><?php print GetLang('Manage_Banned_Intro'); ?></p></td>
	</tr>
	<tr>
		<td>
			<?php if(isset($GLOBALS['Message'])) print $GLOBALS['Message']; ?>
		</td>
	</tr>
	<tr><td class=body height="10"><?php if(isset($GLOBALS['Subscribers_AddButton'])) print $GLOBALS['Subscribers_AddButton']; ?></td></tr>
	<tr>
		<td class=body>
			<form name="bannedform" method="post" action="index.php?Page=Subscribers&Action=Banned&SubAction=Delete&list=<?php if(isset($GLOBALS['List'])) print $GLOBALS['List']; ?>" onsubmit="return DeleteSelectedBans(this);">
			<table width="100%" border="0" cellspacing="0">
				<tr>
					<td valign="top">
						<div style="padding-bottom:10px">
							<input type="button" name="AddBannedButton" value="<?php print GetLang('BannedAddButton'); ?>" class="SmallButton" style="width:210px" onclick="javascript: document.location='index.php?Page=Subscribers&Action=Banned&SubAction=add';" />
							<input type="submit" name="DeleteBannedButton" value="<?php print GetLang('Delete_Banned_Selected'); ?>" class="SmallButton" />
						</div>
					</td>
					<td align="right">
						%%TPL_Paging%%
					</td>
				</tr>
			</table>
			<table border="0" cellspacing="0" cellpadding="0" width="100%" class="Text" id="SubscribersBannedManageList">
				<tr class="Heading3">
					<td width="5" nowrap align="center">
						<input type="checkbox" name="toggle" class="UICheckboxToggleSelector">
					</td>
					<td width="5">&nbsp;</td>
					<td width="80%">
						<?php print GetLang('BannedSubscriberEmail'); ?>&nbsp;<a href='index.php?Page=Subscribers&Action=Banned&SubAction=Step2&SortBy=EmailAddress&Direction=Up&list=<?php if(isset($GLOBALS['List'])) print $GLOBALS['List']; ?>'><img src="images/sortup.gif" border=0></a>&nbsp;<a href='index.php?Page=Subscribers&Action=Banned&SubAction=Step2&SortBy=EmailAddress&Direction=Down&list=<?php if(isset($GLOBALS['List'])) print $GLOBALS['List']; ?>'><img src="images/sortdown.gif" border=0></a>
					</td>
					<td width="20%">
						<?php print GetLang('BannedDate'); ?>&nbsp;<a href='index.php?Page=Subscribers&Action=Banned&SubAction=Step2&SortBy=BanDate&Direction=Up&list=<?php if(isset($GLOBALS['List'])) print $GLOBALS['List']; ?>'><img src="images/sortup.gif" border=0></a>&nbsp;<a href='index.php?Page=Subscribers&Action=Banned&SubAction=Step2&SortBy=BanDate&Direction=Down&list=<?php if(isset($GLOBALS['List'])) print $GLOBALS['List']; ?>'><img src="images/sortdown.gif" border=0></a>
					</td>
					<td width="70" nowrap>
						<?php print GetLang('Action'); ?>
					</td>
				</tr>
				%%TPL_Subscribers_Banned_Manage_Row%%
			</table>
			%%TPL_Paging_Bottom%%
			</form>
		</td>
	</tr>
</table>


<script>
	function DeleteSelectedBans(formObj) {

		bans_found = 0;
		for (var i=0;i < formObj.length;i++)
		{
			fldObj = formObj.elements[i];
			if (fldObj.type == 'checkbox')
			{
				if (fldObj.checked) {
					bans_found++;
					break;
				}
			}
		}

		if (bans_found <= 0) {
			alert("<?php print GetLang('ChooseBannedSubscribers'); ?>");
			return false;
		}

		if (confirm("<?php print GetLang('ConfirmRemoveBannedSubscribers'); ?>")) {
			return true;
		}
		return false;
	}

	function ConfirmDelete(EmailID) {
		var List = '<?php if(isset($GLOBALS['List'])) print $GLOBALS['List']; ?>';
		if (!EmailID) {
			return false;
		}
		if (confirm("<?php print GetLang('DeleteBannedSubscriberPrompt'); ?>")) {
			document.location='index.php?Page=Subscribers&Action=Banned&SubAction=Delete&list=' + List + '&id=' + EmailID;
			return true;
		}
	}
</script>
