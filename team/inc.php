<?php
function current_ask($selector='ask', $id=0) {
	$a = array(
			"/team/ask.php?id={$id}" => 'Q&A on deals',
			"/team/transfer.php?id={$id}" => 'transfer wanted',
			);
	$l = "/team/{$selector}.php?id={$id}";
	return current_link($l, $a, true);
}
