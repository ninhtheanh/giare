<?php 
$seconds_now_today = strtotime(date('Y-m-d H:i:s'));
$seconds_now_tomorrow = strtotime('+1 day');
$seconds_side_nn = abs(intval($INI['system']['sideteam']));
$seconds_team_id = abs(intval($team['id']));
$seconds_city_id = abs(intval($city['id']));

if ( $seconds_side_nn ) {
	$oc = array( 
			'city_id' => array($seconds_city_id, 0),
			'team_type' => 'seconds',
			"id <> '$id'",
			"begin_time >= '$seconds_now_today'",
			"end_time <= '$seconds_now_tomorrow'",
			);
	$others_seconds = DB::LimitQuery('team', array(
				'condition' => $oc,
				'order' => 'ORDER BY `sort_order` DESC, `id` DESC',
				'size' => $seconds_side_nn,
				));
}
; ?>
<?php if($others_seconds){?>
<div class="sbox side-Business">
	<div class="sbox-top"></div>
	<div class="sbox-content">
		<div class="tip">
		<h2>Today's Deal</h2>
		<?php $index=0; ?>
		<?php if(is_array($others_seconds)){foreach($others_seconds AS $one) { ?>
			<b><?php echo ++$index; ?>. <?php echo $one['title']; ?>&nbsp;<?php if($one['begin_time'] > time()){?>(Not Started)<?php } else if($one['end_time'] < time()) { ?>(Ended)<?php } else { ?>(Running)<?php }?></b>
			<?php if($one['image']){?><p><a href="/team.php?id=<?php echo $one['id']; ?>"><img src="<?php echo team_image($one['image'], true); ?>" width="195" border="0" /></a></p><?php }?>
			<p><a href="/team.php?id=<?php echo $one['id']; ?>">&raquo;&nbsp;Click to Subscribe for Single-Deal</a></p>
			</p>
		<?php }}?>
		</div>
	</div>
	<div class="sbox-bottom"></div>
</div>
<?php }?>
