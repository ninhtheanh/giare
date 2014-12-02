<div id="order-pay-dialog" class="order-pay-dialog-c" style="width:380px;">
	<h3><span id="order-pay-dialog-close" class="close" onclick="return X.boxClose();">close</span>user info & recharge</h3>
	<div style="overflow-x:hidden;padding:10px;">
	<table width="96%" class="coupons-table">
		<?php if($login_user_id==1){?><tr><td width="80"><b>Email：</b></td><td><?php echo $email = $enc->decrypt('@4!@#$%@', $user['email']); ?></td></tr>
		<tr><td><b>username：</b></td><td><?php echo $username = $enc->decrypt('@4!@#$%@', $user['username']); ?></td></tr><?php }?>
		<tr><td><b>real name：</b></td><td><?php echo $user['realname']; ?></td></tr>
		<tr><td><b>mobile：</b></td><td><b style="color:red"><?php echo $user['mobile']; ?></b> </td></tr>
		<tr><td><b>zipcode：</b></td><td><?php echo $user['zipcode']; ?></td></tr>
		<tr><td><b>address：</b></td><td><?php echo $user['address']; ?></td></tr>
		<tr><td><b>registration IP：</b></td><td><?php echo $user['ip']; ?></td></tr>
		<tr><td colspan="2"><hr /></td></tr>
		<tr><td><b>account balance：</b></td><td><b><?php echo moneyit($user['money']); ?></b> $</td></tr>
		<tr><td><b>credit balance：</b></td><td><b><?php echo moneyit($user['score']); ?></b> Points</td></tr>
		<tr><td><b>Consumption statistics：</b></td><td>Total consumption <b><?php echo moneyit($user['costcount']); ?></b> Times, the cumulative <b><?php echo moneyit($user['cost']); ?></b> Element</td></tr>
		<tr><td colspan="2"><hr /></td></tr>
		<!--<tr><td><b>Account recharge：</b></td><td><input type="text" name="in" id="user-dialog-input-id" value="0" size="6" maxLength="6" require="true" datatype="number" class="number" uid="<?php echo $user['id']; ?>" ask="Determine the top-up to the user？" />&nbsp;&nbsp;<input type="submit" value="Submit" onclick="return X.manage.usermoney();"/></td></tr>-->
	</table>
	</div>
</div>
