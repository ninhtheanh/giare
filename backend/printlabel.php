<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
need_manager();
need_auth('eorder');
if(isset($_POST['act'])){
	$act = @$_POST['act'];		
	$order = @$_POST['myinput'];

	if($act=='printlabel'){
		$i=0; $style = "";$content="";
		foreach($order as $key => $val){
			$i++;
			$content .= PrintLabel($val);
		}
		$style = "<style type=\"text/css\">
		table{
			font-family:Arial; font-size:11px; margin:0px;
		}
		@media print{
			table {page-break-after:always}
		}
		</style>";	
	}	
}
include template('print_label');
?>
