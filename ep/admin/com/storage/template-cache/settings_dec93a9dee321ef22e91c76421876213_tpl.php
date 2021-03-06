<?php $IEM = $tpl->Get('IEM'); ?><link rel="stylesheet" href="<?php echo $tpl->Get('ApplicationUrl'); ?>includes/styles/stylesheet.css" type="text/css">
<script src="<?php echo $tpl->Get('ApplicationUrl'); ?>includes/js/jquery.js"></script>
<script>
	$(function() {
		$(document.frmAddonsSystemlogSettings).submit(function(event) {
			var maxentries = Math.abs(parseInt(this.logsize.value));

			if (!maxentries || maxentries != this.logsize.value) {
				alert('<?php echo GetLang('Addon_systemlog_Alert_InvalidMaxEntries'); ?>');
				this.logsize.select();
				this.logsize.focus();
				event.stopPropagation();
				event.preventDefault();
			}
		});
	});
</script>
<div style="padding:0; margin:0;">
	<form name="frmAddonsSystemlogSettings" method="post" action="<?php echo $tpl->Get('SettingsUrl'); ?>&SubAction=SaveSettings" target="_parent" style="padding:0; margin:0;">
		<table width="100%" cellspacing="0" cellpadding="2" border="0">
			<tr>
				<td class="FieldLabel" style="width:140px;">
					<?php echo GetLang('Addon_systemlog_MaxEntries'); ?>
				</td>
				<td>
					<input type="text" name="logsize" value="<?php echo $tpl->Get('logsize'); ?>" size="5" maxlength="5" />
				</td>
			</tr>
			<tr>
				<td class="FieldLabel" style="width:140px;">&nbsp;</td>
				<td>
					<input class="FormButton SubmitButton" type="submit" value="<?php echo GetLang('Addon_systemlog_Save'); ?>" />
				</td>
			</tr>
		</table>
	</form>
</div>