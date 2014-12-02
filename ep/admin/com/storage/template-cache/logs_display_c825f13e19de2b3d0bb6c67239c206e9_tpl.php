<?php $IEM = $tpl->Get('IEM'); ?>	<style>
		td.QuickView
		{
			background-color: #dbf3d1;
			padding: 10pt;
		}

		tr.QuickView td
		{
			background-color: #dbf3d1;
		}
	</style>
	<script>
		function ShowLog(id)
		{
			var basename = "addon_<?php echo $tpl->Get('AddonId'); ?>_"+id;
			var tr = document.getElementById(basename);
			var trQ = document.getElementById('Show_' + basename);
			var tdQ = document.getElementById('ShowCell_' + basename);
			var img = document.getElementById('expand'+id);

			if(img.src.indexOf("plus.gif") > -1)
			{
				img.src = "<?php echo $tpl->Get('TemplateUrl'); ?>images/minus.gif";

				for(i = 0; i < tr.childNodes.length; i++)
				{
					if(tr.childNodes[i].style != null)
						tr.childNodes[i].style.backgroundColor = "#dbf3d1";
				}

				$(trQ).find('.QuickView').load('<?php echo $tpl->Get('AdminUrl'); ?>&AJAX=1&Action=ViewLog&id='+id, {}, function() {
					trQ.style.display = "";
				});
			}
			else
			{
				img.src = "<?php echo $tpl->Get('TemplateUrl'); ?>images/plus.gif";

				for(i = 0; i < tr.childNodes.length; i++)
				{
					if(tr.childNodes[i].style != null)
						tr.childNodes[i].style.backgroundColor = "";
				}
				trQ.style.display = "none";
			}
		}

		function DeleteLogs()
		{
			if (!confirm('<?php echo GetLang('Addon_systemlog_Alert_DeleteSelected'); ?>')) {
				return false;
			}

			frm = document.getElementById('LogForm');
			logs_found = 0;
			for (var i=0;i < frm.length;i++)
			{
				fldObj = frm.elements[i];
				if (fldObj.type == 'checkbox')
				{
					if (fldObj.checked) {
						logs_found++;
						break;
					}
				}
			}

			if (logs_found == 0) {
				alert('<?php echo GetLang('Addon_systemlog_ChooseLogsToDelete_Alert'); ?>');
				return false;
			}

			frm.action = frm.action + '&Action=Delete';
			frm.submit();
		}

		function DeleteAllLogs()
		{
			// Please choose at least one entry to delete.
			if (confirm('<?php echo GetLang('Addon_systemlog_Alert_DeleteAll'); ?>')) {
				frm = document.getElementById('LogForm');
				frm.action = frm.action + '&Action=DeleteAll';
				frm.submit();

				return true;
			}
			return false;
		}
	</script>
	<form id="LogForm" method="post" action="<?php echo $tpl->Get('AdminUrl'); ?>">
	<table width="100%" border="0" class="text" cellpadding="2" cellspacing="0">
		<tr>
			<td colspan="2"class="Heading1"><?php echo GetLang('Addon_systemlog_Logs'); ?></td>
		</tr>
		<tr>
			<td colspan="2" class="body pageinfo"><p><?php echo GetLang('Addon_systemlog_Logs_Introduction'); ?></p></td>
		</tr>
		<tr>
			<td colspan="2">
				<?php echo $tpl->Get('FlashMessages'); ?>
			</td>
		</tr>
		<tr>
			<td valign="bottom">
				<div>
					<input type="button" value="<?php echo GetLang('Addon_systemlog_DeleteButton'); ?>" onClick="return DeleteLogs();" class="SmallButton" style="width: 160px;">&nbsp;
					<input type="button" value="<?php echo GetLang('Addon_systemlog_DeleteAllButton'); ?>" onClick="return DeleteAllLogs();" class="SmallButton" style="width: 160px;">&nbsp;
				</div>
			</td>
			<td align="right">
				<div align="right">
					<?php echo $tpl->Get('Paging'); ?>
				</div>
			</td>
		</tr>
	</table>
	<table class="text" width="100%" cellspacing="0" cellpadding="2" border="0" style="margin-top:10px;">
		<tr class="Heading3">
			<td width="1" align="center">
				<input type="checkbox" onclick="javascript: toggleAllCheckboxes(this);" name="toggle"/>
			</td>
			<td>&nbsp;</td>
			<td>
				<?php echo GetLang('Addon_systemlog_Severity'); ?>
			</td>
			<td>
				&nbsp;
			</td>
			<td>
				<?php echo GetLang('Addon_systemlog_Summary'); ?>
			</td>
			<td>
				<?php echo GetLang('Addon_systemlog_Module'); ?>
			</td>
			<td>
				<?php echo GetLang('Addon_systemlog_Date'); ?>
			</td>
		</tr>
	<?php $array = $tpl->Get('logsList'); if(is_array($array)): foreach($array as $k=>$logentry): $tpl->Assign('k', $k, false); $tpl->Assign('logentry', $logentry, false);  ?>
		<tr class="GridRow" id="<?php echo $tpl->Get('logentry','rowid'); ?>">
			<td width="1">
				<input type="checkbox" name="logids[]" value="<?php echo $tpl->Get('logentry','logid'); ?>">
			</td>
			<td width="1">
				<img src="<?php echo $tpl->Get('TemplateUrl'); ?>images/<?php echo $tpl->Get('logentry','image'); ?>" width="18" height="18">
			</td>
			<td width="80">
				<?php echo $tpl->Get('logentry','severity'); ?>
			</td>
			<td align="center" style="width: 15px;">
				<a href="#" onClick="ShowLog('<?php echo $tpl->Get('logentry','logid'); ?>'); return false;"><img id="expand<?php echo $tpl->Get('logentry','logid'); ?>" src="<?php echo $tpl->Get('TemplateUrl'); ?>images/plus.gif" border="0"></a>
			</td>
			<td>
				<?php echo $tpl->Get('logentry','logsummary'); ?>
			</td>
			<td>
				<?php echo $tpl->Get('logentry','logmodule'); ?>
			</td>
			<td>
				<?php echo $tpl->Get('logentry','logdate'); ?>
			</td>
		</tr>
		<tr id="Show_<?php echo $tpl->Get('logentry','rowid'); ?>" style="display: none;">
			<td colspan="3">&nbsp;</td>
			<td id="ShowCell_<?php echo $tpl->Get('logentry','rowid'); ?>" class="QuickView" colspan="4"></td>
			<td colspan="2">&nbsp;</td>
		</tr>
	 <?php endforeach; endif; ?>
</table>
</form>

