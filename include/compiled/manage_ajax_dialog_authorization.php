<div id="order-pay-dialog" class="order-pay-dialog-c" style="width:650px;">
	<h3><span id="order-pay-dialog-close" class="close" onclick="return X.boxClose();">close</span>Management authorization：<?php echo $user['email']; ?></h3>
	<div style="overflow-x:hidden;padding:10px;">
	<form method="POST" id="form_authorization_id">
	<input type="hidden" name="action" value="authorization" />
	<input type="hidden" name="id" value="<?php echo $user['id']; ?>" />
	<table width="98%" class="coupons-table">
		<tr><td width="150"><input type="checkbox" name="auth[]" value="team" <?php echo in_array('team', $INI['authorization'][$user['id']])?'checked':''; ?>/>&nbsp;<b>Deals Manager</b></td><td>(edit and add deals)</td></tr>
		<tr><td nowrap="nowrap"><input type="checkbox" name="auth[]" value="help" <?php echo in_array('help', $INI['authorization'][$user['id']])?'checked':''; ?>/>&nbsp;<b>Customer Service Manager</b></td><td>(Q & A of this deal, webpage, template and bulletin)</td></tr>
		<tr><td><input type="checkbox" name="auth[]" value="order" <?php echo in_array('order', $INI['authorization'][$user['id']])?'checked':''; ?>/>&nbsp;<b>Orders Manager</b></td><td>(Order management, refund, express and etc.)</tr>
        <tr><td><input type="checkbox" name="auth[]" value="eorder" <?php echo in_array('eorder', $INI['authorization'][$user['id']])?'checked':''; ?>/>&nbsp;<b>Đơn hàng tỉnh</b></td><td>(Quản lý đơn hàng tỉnh, đơn hàng TT trước...)</tr>
		<tr><td><input type="checkbox" name="auth[]" value="market" <?php echo in_array('market', $INI['authorization'][$user['id']])?'checked':''; ?>/>&nbsp;<b>marketing Manager</b></td><td>(email & SMS marketing, data download)</td></tr>
		<tr><td><input type="checkbox" name="auth[]" value="admin" <?php echo in_array('admin', $INI['authorization'][$user['id']])?'checked':''; ?>/>&nbsp;<b>System Manager</b></td><td>(users, categories, bizes, financial stuff, etc.)</tr>
        <tr><td><input type="checkbox" name="auth[]" value="shipping" <?php echo in_array('shipping', $INI['authorization'][$user['id']])?'checked':''; ?>/>&nbsp;<b>Delivery Manager</b></td><td nowrap="nowrap">(Xác nhận nộp tiền, biên bản bàn giao, bảng kê nộp tiền, ...)</tr>
		<tr><td><input type="checkbox" name="auth[]" value="logistics" <?php echo in_array('logistics', $INI['authorization'][$user['id']])?'checked':''; ?>/>&nbsp;<b>Shipping Manager</b></td><td nowrap="nowrap">(Streets, Shipper, ...)</tr>
        <tr><td><input type="checkbox" name="auth[]" value="misc" <?php echo in_array('misc', $INI['authorization'][$user['id']])?'checked':''; ?>/>&nbsp;<b>Forum Manager</b></td><td nowrap="nowrap">(Forum, ...)</tr>
        <tr><td><input type="checkbox" name="auth[]" value="sale" <?php echo in_array('sale', $INI['authorization'][$user['id']])?'checked':''; ?>/>&nbsp;<b>Sale Report</b></td><td nowrap="nowrap">(Sale Report, ...)</tr>
		<tr><td colspan="2"><input type="submit" class="formbutton" value="Determination authorization" /></td></tr>
	</table>
	</form>
	</div>
</div>
