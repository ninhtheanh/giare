<?php

if (!isset($_POST['test0'])) {
	$output = '<form name=test method=post>';
	$string = 'asd';

	for ($i=0;$i<800;$i++) 
		$output .= '<input type="hidden" name="test' . $i . '" value="' . $i . $string . '" />';

	$output .= '<input type="submit" value="submit" /></form>';
	echo $output;
}else {
	echo '<pre>' . print_r($_POST, 1) . '</pre>';
}

?>
