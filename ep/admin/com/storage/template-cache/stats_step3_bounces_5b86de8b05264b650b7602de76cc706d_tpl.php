<?php $IEM = $tpl->Get('IEM'); ?><div id="div4" style="display:none">
	<div class="body">
		<br><?php if(isset($GLOBALS['DisplayBouncesIntro'])) print $GLOBALS['DisplayBouncesIntro']; ?>
		<br><br>
	</div>

	<div>
		<?php if(isset($GLOBALS['Calendar'])) print $GLOBALS['Calendar']; ?>
	</div>
	<br>

	<table width="100%" border="0" class="Text">
		<tr><td valign=top width="250" rowspan="2">
		<div class="MidHeading" style="width:100%"><img src="images/m_stats.gif" width="20" height="20" align="absMiddle">&nbsp;<?php print GetLang('Bounce_Summary'); ?></div>
			<UL class="Text">
				<LI><?php print GetLang('Stats_TotalBounces'); ?><?php if(isset($GLOBALS['TotalBounceCount'])) print $GLOBALS['TotalBounceCount']; ?></li>
				<LI><?php print GetLang('Stats_TotalSoftBounces'); ?><?php if(isset($GLOBALS['TotalSoftBounceCount'])) print $GLOBALS['TotalSoftBounceCount']; ?></li>
				<LI><?php print GetLang('Stats_TotalHardBounces'); ?><?php if(isset($GLOBALS['TotalHardBounceCount'])) print $GLOBALS['TotalHardBounceCount']; ?></li>
			</UL>
		</td>
		</tr>
		<tr>
			<td>
				<?php if(isset($GLOBALS['BounceChart'])) print $GLOBALS['BounceChart']; ?>
			</td>
		</tr>
	</table>

		<!-- stats_step3_bounces_table -->
		<?php if(isset($GLOBALS['Loading_Indicator'])) print $GLOBALS['Loading_Indicator']; ?>
                <div id="adminTable<?php if(isset($GLOBALS['TableType'])) print $GLOBALS['TableType']; ?>"></div>
        
                <script>
                  REMOTE_admin_table($("#adminTable<?php if(isset($GLOBALS['TableType'])) print $GLOBALS['TableType']; ?>"),'<?php if(isset($GLOBALS['TableURL'])) print $GLOBALS['TableURL']; ?>','','<?php if(isset($GLOBALS['TableType'])) print $GLOBALS['TableType']; ?>','<?php if(isset($GLOBALS['TableToken'])) print $GLOBALS['TableToken']; ?>',1,'time','down');
                </script>
		<br><br>
	</div>
</div>

<script>
	function ChangeBounceType() {
		cbouncetype = document.getElementById('choosebt');
		selected = cbouncetype.selectedIndex;
		bouncetype = cbouncetype.options[selected].value;
		REMOTE_parameters = '&bouncetype=' + bouncetype;
		REMOTE_admin_table($("#adminTable<?php if(isset($GLOBALS['TableType'])) print $GLOBALS['TableType']; ?>"),'<?php if(isset($GLOBALS['TableURL'])) print $GLOBALS['TableURL']; ?>','','<?php if(isset($GLOBALS['TableType'])) print $GLOBALS['TableType']; ?>','<?php if(isset($GLOBALS['TableToken'])) print $GLOBALS['TableToken']; ?>',1,'time','down');
	}
</script>
