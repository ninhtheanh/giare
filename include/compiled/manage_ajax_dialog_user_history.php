<div id="order-pay-dialog" class="order-pay-dialog-c" style="width:700px;">
	<h3><span id="order-pay-dialog-close" class="close" onclick="return X.boxClose();"><strong>Close</strong></span>User Info & Order & Topic</h3>
	<div style="overflow-x:hidden;padding:10px;">
	<table width="96%" class="coupons-table">
	<!--{
	
	 $realemail = $enc->decrypt('@4!@#$%@', $user['email']);
	
	}-->
		<tr><td width="80" align="right"><b>Email:</b></td><td><?php echo $enc->decrypt('@4!@#$%@',$user['email']); ?></td></tr>
		<tr><td align="right"><b>Real name:</b></td><td><?php echo $user['realname']; ?></td></tr>
		<tr><td align="right"><b>Mobile:</b></td><td><?php echo $user['mobile']; ?></td></tr>
		<tr><td align="right"><b>Address:</b></td><td><?php echo $user['address']; ?></td></tr>
        <tr><td align="right"><b>Created date:</b></td><td><?php echo date("d/m/y H:i:s",$user['create_time']); ?></td></tr>
		<tr><td align="right"><b>Registration IP:</b></td><td><?php echo $user['ip']; ?></td></tr>
		<tr><td colspan="2"><hr /></td></tr>
		<tr><td nowrap="nowrap"><b>Order statistics:</b></td><td><b><?php echo moneyit($user['costcount']); ?></b></td></tr>
        <tr><td nowrap="nowrap"><b>Topic statistics:</b></td><td><b><?php echo moneyit($user['post_topic']); ?></b></td></tr>
		<tr><td colspan="2"><hr /></td></tr>
	</table>
	</div>
</div>
