<?php
function current_manageorder($selector='calling', $id=0) {
	$selector = $selector ? $selector : '';
	$a = array(
		"/backend/order/calling.php" => '   Lần 1   ',
		"/backend/order/calling_times_1.php" => '   Lần 2   ',
		"/backend/order/calling_times_2.php" => '   Lần 3   ',
	);
	$l = "/backend/order/{$selector}.php";
	return current_link($l, $a);
}


function current_manageorder_confirm($selector='calling', $id=0) {
	$selector = $selector ? $selector : '';
	$a = array(
		"/backend/order/office.php" => '   Nhận tại VP   ',
		"/backend/order/hanging.php" => '   ĐH tạm hoản   ',
	);
	$l = "/backend/order/{$selector}.php";
	return current_link($l, $a);
}
