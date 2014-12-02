<?php $IEM = $tpl->Get('IEM'); ?><tr class="GridRow">
	<td nowrap align="left">
		<?php if(isset($GLOBALS['EmailAddress'])) print $GLOBALS['EmailAddress']; ?>
	</td>
	<td nowrap align="left">
		<?php if(isset($GLOBALS['BounceType'])) print $GLOBALS['BounceType']; ?>
	</td>
	<td nowrap align="left">
		<?php if(isset($GLOBALS['BounceRule'])) print $GLOBALS['BounceRule']; ?>
	</td>
	<td nowrap align="left">
		<?php if(isset($GLOBALS['BounceDate'])) print $GLOBALS['BounceDate']; ?>
	</td>
</tr>
