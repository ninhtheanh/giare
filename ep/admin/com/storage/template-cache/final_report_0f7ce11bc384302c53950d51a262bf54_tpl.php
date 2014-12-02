<?php $IEM = $tpl->Get('IEM'); ?><table width="100%">
	<tr>
		<td class="Heading1">
			<?php if($tpl->Get('repaired')): ?>
				<?php echo GetLang('Addon_dbcheck_Heading_Repaired'); ?>
			<?php else: ?>
				<?php echo GetLang('Addon_dbcheck_Heading_Checked'); ?>
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo $tpl->Get('flash_messages'); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php if($tpl->Get('num_problems') > 0 && !$tpl->Get('repaired')): ?>
				<input type="button" class="SmallButton RunFix" value="<?php echo GetLang('Addon_dbcheck_Button_FixProblems'); ?>" />
				<input type="button" class="SmallButton ErrorReport" value="<?php echo GetLang('Addon_dbcheck_DisplayReport'); ?>" />
			<?php endif; ?>
			<input type="button" class="SmallButton" value="<?php echo GetLang('Addon_dbcheck_Button_Continue'); ?>" onclick="window.location.href='index.php';" />
			<?php if($tpl->Get('num_problems') > 0 && !$tpl->Get('repaired')): ?>
				
				<ul>
					<?php $array = $tpl->Get('problems'); if(is_array($array)): foreach($array as $type=>$problem): $tpl->Assign('type', $type, false); $tpl->Assign('problem', $problem, false);  ?>
						<?php if($tpl->Get('problem','num') > 0): ?>
							<li>
								<?php echo $tpl->Get('problem','text'); ?>
								<?php if($tpl->Get('repaired')): ?>
									<a href="#" class="ErrorReport"><?php echo GetLang('Addon_dbcheck_DisplayError'); ?></a>
								<?php endif; ?>
							</li>
						<?php endif; ?>
					 <?php endforeach; endif; ?>
				</ul>
			<?php endif; ?>
		</td>
	</tr>
</table>

<script>
	$('.RunFix').click(function() {
		alert("<?php echo GetLang('Addon_dbcheck_Advice'); ?>");
		var url = '<?php echo $tpl->Get('admin_url'); ?>&AJAX=1&Action=ShowPopup&Fix=true&keepThis=true&TB_iframe=true&height=240&width=400&modal=true&random=' + new Date().getTime();
		tb_show('', url, '');
	});

	$('.ErrorReport').click(function() {
		var url = '<?php echo $tpl->Get('admin_url'); ?>&AJAX=1&Action=ShowReport&keepThis=true&TB_iframe=true&height=400&width=500';
		tb_show('<?php echo GetLang('Addon_dbcheck_DisplayReport'); ?>', url, '');
	});
</script>
