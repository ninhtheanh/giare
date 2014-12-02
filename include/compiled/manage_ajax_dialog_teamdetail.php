<div id="order-pay-dialog" class="order-pay-dialog-c" style="width:580px;">
	<h3><span id="order-pay-dialog-close" class="close" onclick="return X.boxClose();">Close</span>Deal Details</h3>
	<div style="overflow-x:hidden;padding:10px;">
	<table width="96%" align="center" class="coupons-table">
		<tr><td width="80"><b>Deal Title：</b></td><td><b><?php echo $team['title']; ?></b></td></tr>
		<tr><td><b>Begin Time</b></td><td>Start:<b><?php echo date('Y-m-d',$team['begin_time']); ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As Of:<b><?php echo date('Y-m-d',$team['end_time']); ?></b></td></tr>

		<tr><td><b>Current State：</b></td><td><span style="color:#F00;font-weight:bold;"><?php echo state_explain($team); ?></span><?php if($team['close_time']&&$team['now_number']>=$team['min_number']&&$team['delivery']!='express'){?>&nbsp;&nbsp;<span style="color:#F8C;font-weight:bold;"><?php if(($team['teamcoupon'])){?>&lt;<?php echo $INI['system']['couponname']; ?>Not Finished&gt;<?php } else { ?>&lt;<?php echo $INI['system']['couponname']; ?> Have Been issued&gt;<?php }?></span><?php }?></td></tr>
		<tr><td><b>Quote：</b></td><td>Minimum:<?php echo $team['min_number']; ?>&nbsp;&nbsp;&nbsp;&nbsp;Maximum：<?php echo $team['max_number']==0?'No Limit':$team['max_number']; ?></td></tr>
		<tr><td><b>Deal Pricing:</b></td><td>Market Price：<b><?php echo print_price(moneyit($team['market_price'])); ?></b>&nbsp;<span class="money"><?php echo $currency; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Item Price：<b><?php echo print_price(moneyit($team['team_price'])); ?></b>&nbsp;<span class="money"><?php echo $currency; ?></span></td></tr>
		<tr><th colspan="2"><hr/></th></td>
		<tr><td><b>Deal situation：</b></td><td><b><?php echo $team['now_number']; ?></b>&nbsp;，The actual total&nbsp;<b><?php echo $paycount; ?></b>&nbsp;People bought&nbsp;<b><?php echo $buycount; ?></b>&nbsp;Bought Times
		</td></tr>
		<tr><td><b>Payment statistics：</b></td><td>Online payment:<b><?php echo print_price(moneyit($onlinepay)); ?></b>&nbsp;$&nbsp;&nbsp;&nbsp;&nbsp;Balance of payments:<b><?php echo print_price(moneyit($creditpay)); ?></b>&nbsp;<span class="money"><?php echo $currency; ?></span></td></tr>
		<tr><td><b>Account balance:</b></td><td>Total payments:<b><?php echo print_price(moneyit($onlinepay+$creditpay)); ?></b>&nbsp;$&nbsp;&nbsp;&nbsp;&nbsp;Credit vouchers:<b><?php echo print_price(moneyit($cardpay)); ?></b>&nbsp;<span class="money"><?php echo $currency; ?></span></td></tr>
	<?php if($team['needline']){?>
		<tr><th colspan="2"><hr/></th></td>
		<tr><td colspan="2">
			<button style="padding:0;" id="dialog_subscribe_button_id" onclick="if(confirm('Send e-mail process, please be patient, agreed to do？')){this.disabled=true;return X.misc.noticenext(<?php echo $team['id']; ?>,0);}">Mail subscription&nbsp;(<span id="dialog_subscribe_count_id">0</span>/<?php echo $subcount; ?>)</button>&nbsp;
			<?php if($team['noticesmssubscribe']){?><button style="padding:0;" id="dialog_smssubscribe_button_id" onclick="if(confirm('The process of sending text messages, please be patient, agreed to do？')){this.disabled=true;return X.misc.noticenextsms(<?php echo $team['id']; ?>,0);}">SMS Subscription&nbsp;(<span id="dialog_smssubscribe_count_id">0</span>/<?php echo $smssubcount; ?>)</button>&nbsp;<?php }?>
			<?php if($team['noticesms']){?><button id="dialog_sms_button_id" onclick="if(confirm('The process of sending text messages, please be patient, agreed to do？')){this.disabled=true;return X.misc.noticesms(<?php echo $team['id']; ?>,0);}">Text messages sent in coupons&nbsp;(<span id="dialog_sms_count_id">0</span>/<?php echo $couponcount; ?>)</button>&nbsp;<?php }?>
			<?php if($team['teamcoupon']){?><button onclick="this.disabled=true;return X.manage.teamcoupon(<?php echo $team['id']; ?>);">Sends the ticket automatically&nbsp;(<?php echo $couponcount; ?>/<?php echo $buycount; ?>)</button>&nbsp;<?php }?>
		</td></tr>
	<?php }?>
	</table>
	</div>
</div>
