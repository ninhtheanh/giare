<?php $IEM = $tpl->Get('IEM'); ?>	<table cellspacing="0" cellpadding="0" width="100%" align="center">
		<tr>
			<td class="Heading1"><?php echo GetLang('Addon_systemlog_Logs'); ?></td>
		</tr>
		<tr>
			<td class="body pageinfo"><p><?php echo GetLang('Addon_systemlog_Logs_Introduction'); ?></p></td>
		</tr>
		<tr>
			<td>
				<?php echo $tpl->Get('FlashMessages'); ?>
			</td>
		</tr>
		<tr>
			<td class="body">
				<?php echo $tpl->Get('Addon_systemlog_Logs_Empty'); ?>
			</td>
		</tr>
	</table>

