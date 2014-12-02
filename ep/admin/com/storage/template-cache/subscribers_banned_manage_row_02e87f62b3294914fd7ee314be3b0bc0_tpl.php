<?php $IEM = $tpl->Get('IEM'); ?><tr class="GridRow">
	<td align="center">
		<input type="checkbox" name="subscribers[]" value="<?php if(isset($GLOBALS['BanID'])) print $GLOBALS['BanID']; ?>" class="UICheckboxToggleRows">
	</td>
	<td>
		<img src="images/m_banned.gif">
	</td>
	<td>
		<?php if(isset($GLOBALS['Email'])) print $GLOBALS['Email']; ?>
	</td>
	<td>
		<?php if(isset($GLOBALS['BanDate'])) print $GLOBALS['BanDate']; ?>
	</td>
	<td>
		<?php if(isset($GLOBALS['SubscriberAction'])) print $GLOBALS['SubscriberAction']; ?>
	</td>
</tr>
