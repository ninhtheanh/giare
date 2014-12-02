<?php $IEM = $tpl->Get('IEM'); ?><table cellspacing="0" cellpadding="0" width="100%" align="center">
	<tr>
		<td class="Heading1"><?php print GetLang('AutorespondersManage'); ?></td>
	</tr>
	<tr>
		<td class="body pageinfo"><p><?php print GetLang('Help_AutorespondersManage'); ?></p></td>
	</tr>
	<tr>
		<td class="body"><?php if(isset($GLOBALS['Message'])) print $GLOBALS['Message']; ?></td>
	</tr>
	<tr>
		<td>
			<?php if(isset($GLOBALS['CronWarning'])) print $GLOBALS['CronWarning']; ?>
		</td>
	</tr>
	<tr><td class="body"><?php if(isset($GLOBALS['Autoresponders_AddButton'])) print $GLOBALS['Autoresponders_AddButton']; ?></td></tr>
</table>

