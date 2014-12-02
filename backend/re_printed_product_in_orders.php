<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

if(isset($_POST['date_print'])){
	$date_print = $_POST['date_print'];
	$date_print_show = date("d-m-Y H:i:s",strtotime($date_print));
	$sql = "SELECT op.team_id, p.delivery_properties, p.short_title, pi.quantity FROM print_items as pi, `order` AS op INNER JOIN team as p ON (p.id = op.team_id) WHERE pi.print_time = '".$date_print."' AND pi.item_id = op.team_id GROUP BY op.team_id ORDER BY p.short_title ASC";
	$ds = DB::GetQueryResult($sql,false);
}
$total_print = count($ds);
include template('print_product_in_orders_confirmed');
?>
