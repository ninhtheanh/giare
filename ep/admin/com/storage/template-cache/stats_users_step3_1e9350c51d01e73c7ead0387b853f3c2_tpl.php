<?php $IEM = $tpl->Get('IEM'); ?><table cellspacing="0" cellpadding="0" width="100%" align="center">
	<tr>
		<td>

<div class="Heading1"><?php print GetLang('Stats_UserStatistics'); ?></div>

<script>
	var TabSize = 2;
</script>

<div>
	<br>

	<ul id="tabnav">
		<li><a href="#" class="active" onClick="ShowTab(1)" id="tab1"><?php print GetLang('Stats_UserStatistics'); ?></a></li>
		<li><a href="#" onClick="ShowTab(2)" id="tab2"><?php print GetLang('UserStatistics_Snapshot_EmailsSent'); ?></a></li>
	</ul>

</div>

<div id="div1">
	<div class="body pageinfo">
		<br><?php if(isset($GLOBALS['SummaryIntro'])) print $GLOBALS['SummaryIntro']; ?>
		<br><br>
	</div>
	<table width="100%" border="0">
		<tr>
			<td width="45%" valign="top" rowspan="2">
				<table border=0 width="100%" class="Text" cellspacing="0">
					<tr class="Heading3">
						<td colspan="2" nowrap align="left">
							<?php print GetLang('UserStatisticsSnapshot'); ?>
						</td>
					</tr>
					<tr class="GridRow">
						<td width="30%" height="22" nowrap align="left">
							&nbsp;<?php print GetLang('Stats_UserCreateDate'); ?>
						</td>
						<td width="70%" nowrap align="left">
							<?php if(isset($GLOBALS['UserCreateDate'])) print $GLOBALS['UserCreateDate']; ?>
						</td>
					</tr>
					<tr class="GridRow">
						<td width="30%" height="22" nowrap align="left">
							&nbsp;<?php print GetLang('Stats_UserLastLoggedIn'); ?>
						</td>
						<td width="70%" nowrap align="left">
							<?php if(isset($GLOBALS['LastLoggedInDate'])) print $GLOBALS['LastLoggedInDate']; ?>
						</td>
					</tr>
					<tr class="GridRow">
						<td width="30%" height="22" nowrap align="left">
							&nbsp;<?php print GetLang('UserLastNewsletterSent'); ?>
						</td>
						<td width="70%" nowrap align="left">
							<?php if(isset($GLOBALS['LastNewsletterSentDate'])) print $GLOBALS['LastNewsletterSentDate']; ?>
						</td>
					</tr>
					<tr class="GridRow">
						<td width="30%" height="22" nowrap align="left">
							&nbsp;<?php print GetLang('Stats_TotalLists'); ?>
						</td>
						<td width="70%" nowrap align="left">
							<?php if(isset($GLOBALS['ListsCreated'])) print $GLOBALS['ListsCreated']; ?>
						</td>
					</tr>
					<tr class="GridRow">
						<td width="30%" height="22" nowrap align="left">
							&nbsp;<?php print GetLang('UserAutorespondersCreated'); ?>
						</td>
						<td width="70%" nowrap align="left">
							<?php if(isset($GLOBALS['AutorespondersCreated'])) print $GLOBALS['AutorespondersCreated']; ?>
						</td>
					</tr>
					<tr class="GridRow">
						<td width="30%" height="22" nowrap align="left">
							&nbsp;<?php print GetLang('UserNewslettersSent'); ?>
						</td>
						<td width="70%" nowrap align="left">
							<?php if(isset($GLOBALS['NewslettersSent'])) print $GLOBALS['NewslettersSent']; ?>
						</td>
					</tr>
					<tr class="GridRow">
						<td width="30%" height="22" nowrap align="left">
							&nbsp;<?php print GetLang('Stats_TotalEmailsSent'); ?>
						</td>
						<td width="70%" nowrap align="left">
							<?php if(isset($GLOBALS['EmailsSent'])) print $GLOBALS['EmailsSent']; ?>
						</td>
					</tr>
					<tr class="GridRow">
						<td width="30%" height="22" nowrap align="left" valign="top">
							&nbsp;<?php print GetLang('Stats_TotalOpens'); ?>
						</td>
						<td width="70%" nowrap align="left">
							<?php if(isset($GLOBALS['TotalOpens'])) print $GLOBALS['TotalOpens']; ?>
						</td>
					</tr>
					<tr class="GridRow">
						<td width="30%" height="22" nowrap align="left" valign="top">
							&nbsp;<?php print GetLang('Stats_TotalUniqueOpens'); ?>
						</td>
						<td width="70%" nowrap align="left">
							<?php if(isset($GLOBALS['UniqueOpens'])) print $GLOBALS['UniqueOpens']; ?>
						</td>
					</tr>
					<tr class="GridRow">
						<td width="30%" height="22" nowrap align="left" valign="top">
							&nbsp;<?php print GetLang('Stats_TotalBounces'); ?>
						</td>
						<td width="70%" nowrap align="left">
							<?php if(isset($GLOBALS['TotalBounces'])) print $GLOBALS['TotalBounces']; ?>
						</td>
					</tr>
				</table>

			</td>
			<td align="center" width="55%">
			 <?php if(isset($GLOBALS['SummaryChart'])) print $GLOBALS['SummaryChart']; ?>
			</td>
		</tr>
	</table>
</div>


<div id="div2" style="display:none">
	<?php if(isset($GLOBALS['UsersSummaryPage'])) print $GLOBALS['UsersSummaryPage']; ?>
</div>


		</td>
	</tr>
</table>