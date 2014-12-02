<?php $IEM = $tpl->Get('IEM'); ?><table cellspacing="0" cellpadding="0" width="100%" align="center">
	<tr>
		<td class="Heading1">
			<?php print GetLang('Send_Step1'); ?>
		</td>
	</tr>
	<tr>
		<td class="body pageinfo">
			<p>
				<?php if(isset($GLOBALS['Message'])) print $GLOBALS['Message']; ?>
			</p>
		</td>
	</tr>
	<tr><td class="body"><?php if(isset($GLOBALS['Newsletters_AddButton'])) print $GLOBALS['Newsletters_AddButton']; ?></td></tr>
</table>

