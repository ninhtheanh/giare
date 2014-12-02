<?php $IEM = $tpl->Get('IEM'); ?><div class="body">
	<br><?php if(isset($GLOBALS['EmailsSentIntro'])) print $GLOBALS['EmailsSentIntro']; ?>
	<br><br>
	<table border=0 cellpadding="5" cellspacing="1" width="100%" class="Text">
		<tr>
			<td width="100%" colspan="2">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top">
							<?php if(isset($GLOBALS['Calendar'])) print $GLOBALS['Calendar']; ?>
						</td>
						<td valign="top" align="right">
							&nbsp;
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td width="100%" colspan="2">
				<?php if(isset($GLOBALS['UserChart'])) print $GLOBALS['UserChart']; ?>
			</td>
		</tr>
		<tr class="Heading3">
			<td width="30%" nowrap align="left">
				<?php print GetLang('DateTime'); ?>
			</td>
			<td width="70%" nowrap align="left">
				<?php print GetLang('UserNewslettersSent'); ?>
			</td>
		</tr>
		<?php if(isset($GLOBALS['Stats_Step3_EmailsSent_List'])) print $GLOBALS['Stats_Step3_EmailsSent_List']; ?>
		<tr class="Heading3">
			<td nowrap align="left">
				<?php print GetLang('Total'); ?>
			</td>
			<td nowrap align="left">
				<?php if(isset($GLOBALS['TotalEmailsSent'])) print $GLOBALS['TotalEmailsSent']; ?>
			</td>
		</tr>
	</table>
	<br><br>
</div>
