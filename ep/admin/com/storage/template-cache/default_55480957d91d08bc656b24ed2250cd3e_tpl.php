<?php $IEM = $tpl->Get('IEM'); ?><table>
	<tr>
		<td class="Heading1">
			<?php echo GetLang('Addon_checkpermissions_Heading'); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo GetLang('Addon_checkpermissions_Intro'); ?>
		</td>
	</tr>
	<tr>
		<td>
			<input type="button" class="SmallButton" value="<?php echo GetLang('Addon_checkpermissions_GoButton'); ?>" onClick="RunCheck();">
		</td>
	</tr>
</table>

<script>
	function RunCheck()
	{
		x = '<?php echo $tpl->Get('AdminUrl'); ?>&AJAX=1&Action=ShowPopup&keepThis=true&TB_iframe=true&height=240&width=400&modal=true&random='+new Date().getTime();
		tb_show('', x, '');
	}
</script>
