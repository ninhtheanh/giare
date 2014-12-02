<?php
function current_manageteam($selector='edit', $id=0) {
	$selector = $selector ? $selector : 'edit';
	$a = array(
		"/backend/team/edit.php?id={$id}" => 'Thông tin cơ bản',
		"/backend/team/editzz.php?id={$id}" => 'Miscellaneous Information',
		"/backend/team/editseo.php?id={$id}" => 'Thông tin SEO',
	);
	$l = "/backend/team/{$selector}.php?id={$id}";
	return current_link($l, $a);
}
