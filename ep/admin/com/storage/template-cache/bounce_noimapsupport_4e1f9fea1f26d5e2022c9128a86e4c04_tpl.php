<?php $IEM = $tpl->Get('IEM'); ?><table cellspacing="0" cellpadding="0" width="100%" align="center">
	<tr>
		<td class="Heading1" colspan="2">
			<?php print GetLang('Bounce_No_ImapSupport_Heading'); ?>
		</td>
	</tr>
	<tr>
		<td colspan="2"><?php if(isset($GLOBALS['ErrorMessage'])) print $GLOBALS['ErrorMessage']; ?></td>
	</tr>
</table>
