<?php
function current_managecredit($selector='gift', $id=0) {
	$selector = $selector ? $selector : 'gift';
	$a = array(
		"/backend/credit/gift.php" => '      Record      ',
		"/backend/credit/addgift.php" => '      Add     ',
	);
	$l = "/backend/credit/{$selector}.php";
	return current_link($l, $a);
}
