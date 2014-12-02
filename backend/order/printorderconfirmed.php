<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
need_manager();
need_auth('order');

$condition = array(
	'state' => "processing",
);

$count = Table::Count('order', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 100);
$total_print = Table::Count('order', $condition, 'quantity');
//DB::$mDebug = true;
$orders = DB::LimitQuery('order', array(
	'condition' => $condition,
	'order' => 'ORDER BY id ASC',
	'size' => $pagesize,
	'offset' => $offset,
));
$team_ids = Utility::GetColumn($orders, 'team_id');
$teams = Table::Fetch('team', $team_ids);
if(count($orders)>0){
	include template('manage_order_processing');
}else{
	$button_print = "";
	$print_time="";
	$phantrang="";
	$vs = DB::GetQueryResult("SELECT DISTINCT print_time FROM print_items ORDER BY print_time DESC",false);

	if(is_array($vs)){
		$list="";
		foreach($vs as $index=>$value){
			$printtime = $value["print_time"];
			if($printtime!="0000-00-00 00:00:00"){
				$time_label_print = date('d-m-Y H:i:s',strtotime($printtime));			
				$list .="<option value=\"{$printtime}\">".$time_label_print."</option>";
			}
		}
	}
	$product_item = ""; $total_print = 0; $disabled = "disabled";
	if(isset($_POST['block'])){
		$disabled = "";
		$print_time = $_POST['block'];
		$sql = "SELECT op.team_id, p.delivery_properties, p.short_title, pi.quantity, pi.modified_by, pi.date_modified FROM print_items as pi, `order` AS op INNER JOIN team as p ON p.id = op.team_id WHERE pi.print_time = '$print_time' AND pi.item_id = op.team_id GROUP BY op.team_id";
		$products = DB::GetQueryResult($sql,false);

		$total_print = count($products);
	}
	include template('manage_product_printed');
}

?>
