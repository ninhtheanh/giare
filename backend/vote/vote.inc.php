<?php
function mcurrent_vote($selector='index'){
	$a = array(
		'/backend/vote/index.php' => 'Home',
		'/backend/vote/feedback.php' => 'Feedback',
		'/backend/vote/question.php' => 'Questions',
	);
	$l = "/backend/vote/{$selector}.php";
	return current_link($l,$a,true);
}
