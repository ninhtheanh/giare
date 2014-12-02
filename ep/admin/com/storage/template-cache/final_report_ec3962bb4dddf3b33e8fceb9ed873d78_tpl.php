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
			<?php if($tpl->Get('ShowOk') == true): ?>
			<br />
			<?php echo GetLang('Addon_checkpermissions_FollowingFileFolders'); ?> <?php echo GetLang('Addon_checkpermissions_FollowingFileFolders_OK'); ?>:
			<ul>
			<?php if(!function_exists("foreach_222771")){ function foreach_222771(&$tpl, $array){ if(is_array($array)): foreach($array as $k=>$permissionChecked): $tpl->Assign('k', $k, false); $tpl->Assign('permissionChecked', $permissionChecked, false);  ?>
				<li style="color:#339933;">
					<?php echo $tpl->Get('permissionChecked'); ?>
				</li>
			 <?php endforeach; endif;}} foreach_222771($tpl, $tpl->Get('PermissionsOk')); ?>
			</ul>
			<br />
			<?php endif; ?>

			<?php if($tpl->Get('ShowFailed') == true): ?>
				<?php echo GetLang('Addon_checkpermissions_FollowingFileFolders'); ?> <?php echo GetLang('Addon_checkpermissions_FollowingFileFolders_NotOK'); ?>:
				<ul>
				<?php if(!function_exists("foreach_131749")){ function foreach_131749(&$tpl, $array){ if(is_array($array)): foreach($array as $k=>$permissionChecked): $tpl->Assign('k', $k, false); $tpl->Assign('permissionChecked', $permissionChecked, false);  ?>
					<li style="color:#993333;">
						<?php echo $tpl->Get('permissionChecked'); ?>
					</li>
				 <?php endforeach; endif;}} foreach_131749($tpl, $tpl->Get('PermissionsFailed')); ?>
				</ul>
				<?php echo GetLang('Addon_checkpermissions_WhatToDo'); ?>
				<br />
			<?php endif; ?>
			<br />
			<input type="button" class="SmallButton" value="<?php echo GetLang('Addon_checkpermissions_CheckAgain'); ?>" onclick="window.location.href='<?php echo $tpl->Get('AdminUrl'); ?>';" />
		</td>
	</tr>
</table>
