<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
need_manager();
need_auth('eorder');
$submit_one = false;
//&& PreventMultiSubmit()
if(isset($_POST['list_order_id']) ){
	$submit_one = true;
	$list_order_id = $_POST['list_order_id'];
}
$list_order_id = $_POST['list_order_id'];
$date_print = date("Y-m-d H:i:s",time());
$date_print_show = date("d-m-Y H:i:s",strtotime($date_print));
$sql = "SELECT op.team_id, p.delivery_properties, p.short_title, pi.quantity FROM print_items as pi, `order` AS op INNER JOIN team as p ON (p.id = op.team_id) WHERE op.id IN (".$list_order_id.") AND pi.print_time = '0000-00-00 00:00:00' AND pi.item_id = op.team_id GROUP BY op.team_id ORDER BY p.short_title ASC";
$ds = DB::GetQueryResult($sql,false);	
if(is_array($ds)){
	$list_item_id = array();
	foreach($ds as $key=>$val){
		$list_item_id[] = $val['team_id'];	
	}
	$list_item_id = implode(",",$list_item_id);
}
$total_print = count($ds);
$orderid = explode(",",$list_order_id);

if ($submit_one){
	$sql = "UPDATE `order` SET state = 'printeditem', time_process = '".$date_print."' WHERE id IN (".$list_order_id.")";			
	DB::Query($sql);
	$sql_1 = "UPDATE print_items SET print_time = '".$date_print."' WHERE item_id IN (".$list_item_id.") AND print_time = '0000-00-00 00:00:00'";			
	DB::Query($sql_1);
}

function PreventMultiSubmit($type = "post", $excl = "validator") {
	$string = "";
	foreach ($_POST as $key => $val) {
		if ($key != $excl) { 
			$string .= $val;
		}
	}
	if (isset($_SESSION['lastprint'])) {
		if ($_SESSION['lastprint'] != md5($string)) {
			return false;
		} else {
			$_SESSION['lastprint'] = md5($string);
			return true;
		}
	} else {
		$_SESSION['lastprint'] = md5($string);
		return true;
	}
}
include template('print_product_in_orders_confirmed');
?>
