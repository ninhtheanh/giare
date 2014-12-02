<?php $IEM = $tpl->Get('IEM'); ?><tr class="GridRow">
	<td valign="top"><img src="images/user.gif"></td>
	<td>
		<?php if(isset($GLOBALS['UserName'])) print $GLOBALS['UserName']; ?>
	</td>
	<td>
		<?php if(isset($GLOBALS['FullName'])) print $GLOBALS['FullName']; ?>
	</td>
	<td>
		<?php if(isset($GLOBALS['Status'])) print $GLOBALS['Status']; ?>
	</td>
	<td>
		<?php if(isset($GLOBALS['UserType'])) print $GLOBALS['UserType']; ?>
	</td>
	<td>
		<a href="index.php?Page=Stats&Action=User&SubAction=Step2&user=<?php if(isset($GLOBALS['UserID'])) print $GLOBALS['UserID']; ?>"><?php print GetLang('View'); ?></a>
	</td>
</tr>
