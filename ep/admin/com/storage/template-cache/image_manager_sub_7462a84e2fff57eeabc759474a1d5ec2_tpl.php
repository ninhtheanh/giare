<?php $IEM = $tpl->Get('IEM'); ?><div style="display: none" id="ProgressWindow">
<div id="ProgressBarDiv" style="text-align: center;"><br/><span id="ProgressBarText" class="ProgressBarText"><?php print GetLang('ImageManagerImageUpload'); ?></span><br/><br/><br/>
	<div style="border: 1px solid #ccc; width: 300px; padding: 0px; margin: 0 auto; position: relative;">
		<div class="progressBarPercentage" style="margin: 0; padding: 0; background: url('images/progressbar.gif') no-repeat; height: 20px; width: 0%; ">
			&nbsp;
		</div>
		<div style="position: absolute; top: 0px; left: 0; text-align: center; width: 300px; font-weight: bold;line-height:1.5;color:#333333;font-family:Tahoma;font-size:11px;" class="progressPercent">&nbsp;</div>
	</div>
	<span id="progressBarStatus" class="progressBarStatus" style="text-align: center; font-size: 10px; color: gray; padding-top: 5px;">&nbsp;</span>
</div>

</div>

<table cellspacing="0" cellpadding="0" width="100%" align="center">
	<tr>
		<td class="Heading1"><?php print GetLang('ImageManagerManage'); ?></td>
	</tr>
	<tr>
		<td class="body pageinfo">
			<p><?php print GetLang('Help_ImageManagerManage'); ?></p>
		</td>
	</tr>
	<tr>
		<td>
			<div id="MainMessage">
			<?php if(isset($GLOBALS['Message'])) print $GLOBALS['Message']; ?>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0">
				<tr>
					<td valign="top" valign="bottom">
						<span id="spanButtonPlaceholder"></span>
						<?php if(isset($GLOBALS['ImageManager_AddButton'])) print $GLOBALS['ImageManager_AddButton']; ?>
						<?php if(isset($GLOBALS['ImageManager_DeleteButton'])) print $GLOBALS['ImageManager_DeleteButton']; ?>
					</td>
					<td id="pagination" align="right" valign="top" style="display:<?php if(isset($GLOBALS['DisplayImagePanel'])) print $GLOBALS['DisplayImagePanel']; ?>;">
						<div style="float:right" >
						<?php echo $tpl->Get('Pagination'); ?>
						</div>
						<div style="float:right; padding-right:10px;">
						<?php print GetLang('SortBy'); ?>: <select name="SortBy" class="Field" style="width: 170px; margin-bottom:4px;" onChange="ChangeImageManagerSorting(this, '<?php echo $tpl->Get('PageNumber'); ?>');">
						<?php if(isset($GLOBALS['SortList'])) print $GLOBALS['SortList']; ?>
						</select>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<div id="hasImages" style="display: <?php if(isset($GLOBALS['DisplayImagePanel'])) print $GLOBALS['DisplayImagePanel']; ?>;">
<table cellspacing="0" cellpadding="0" width="100%" align="center">
	<tr>
		<td class="body">
			<table border=0 cellspacing="0" cellpadding="0" width=100% class="Text">
				<tr class="Heading3">
					<td nowrap>
						<input type="checkbox" name="toggleAllChecks" class="UICheckboxToggleSelector" id="toggleAllChecks" style="margin: 3px 0pt 0pt 3pt; float: left;" onclick="AdminImageManager.CheckAllCheckBoxes(this);"/> <label style="display: block; padding-top: 4px; float: left; padding-left: 10px;" for="toggleAllChecks"><span id="ImgNum"><?php if(isset($GLOBALS['NumImageShown'])) print $GLOBALS['NumImageShown']; ?></span></label>
					</td>
				</tr>
				<tr class="GridRow">
					<td style="padding:0pt;">
						<div id="imagesList"><script type="text/javascript">
						<!--
						<?php if(isset($GLOBALS['dirImages'])) print $GLOBALS['dirImages']; ?>
						//-->
						</script>
					
						</div>
					</td>
			</table>
		</td>
	</tr>
</table>
</div>