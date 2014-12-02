<?php $IEM = $tpl->Get('IEM'); ?><table width="100%" border="0">
	<tr>
		<td class="Heading1"><?php echo GetLang('Addon_splittest_Stats_Heading'); ?></td>
	</tr>
	<tr>
		<td class="body pageinfo"><p><?php echo GetLang('Addon_splittest_Stats_Intro'); ?></p></td>
	</tr>
	<tr>
		<td>
			<?php echo $tpl->Get('FlashMessages'); ?>
		</td>
	</tr>
	<tr>
		<td class="body">
			<?php echo $tpl->Get('Addon_splittest_Stats_Empty'); ?>
		</td>
	</tr>
	<tr>
		<td class="body">
			<?php echo $tpl->Get('SplitTest_Create_Button'); ?>
		</td>
	</tr>
</table>

