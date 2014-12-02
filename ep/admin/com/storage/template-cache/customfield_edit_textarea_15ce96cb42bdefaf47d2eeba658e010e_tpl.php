<?php $IEM = $tpl->Get('IEM'); ?>		<td width="200" class="FieldLabel">
			<?php if(isset($GLOBALS['Required'])) print $GLOBALS['Required']; ?>
			<?php if(isset($GLOBALS['FieldName'])) print $GLOBALS['FieldName']; ?>:&nbsp;
		</td>
		<td>
			<textarea id="CustomFields[<?php if(isset($GLOBALS['FieldID'])) print $GLOBALS['FieldID']; ?>]" name="CustomFields[<?php if(isset($GLOBALS['FieldID'])) print $GLOBALS['FieldID']; ?>]" style="font-size: 11px; width: 250px; font-family: Tahoma;"><?php if(isset($GLOBALS['DefaultValue'])) print $GLOBALS['DefaultValue']; ?></textarea>
		</td>
