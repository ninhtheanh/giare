<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
//require_once(dirname(dirname(__FILE__)) . '/connect_omega_db.php');
//echo dirname(dirname(__FILE__)) . '/connect_omega_db.php';
need_manager();
need_auth('order');


$out_id = abs(intval($_GET['out_id']));

$sql = "SELECT so.*, sd.* FROM ship_out AS so LEFT JOIN ship_out_data AS sd USING(out_id) WHERE so.out_id=".$out_id." ORDER BY dist_id, ward_id ASC, street, order_id DESC";

$rs = DB::GetQueryResult($sql,false);

$team_ids = Utility::GetColumn($rs, 'deal_id');

$teams = Table::Fetch('team', $team_ids);

/* $teams = DB::LimitQuery('team', array(
		'condition' => array('id'=>$team_ids),
		'order' => 'ORDER BY `sort_order` DESC, `id` DESC',
	)); */

$dist = DB::GetQueryResult("SELECT dist_name FROM countries_district WHERE dist_id IN (".$rs[0]['dist_id'].")",false);
for($i=0; $i<count($dist);$i++){
	$dist_name .= $dist[$i]['dist_name'].", ";
}

$qcity = DB::GetQueryResult("SELECT name FROM countries_state WHERE id IN (".$rs[0]['city'].")",false);
$city_name = $qcity[0]['name'].", ";

$ids = Utility::GetColumn($rs, 'creator');
$creators = Table::Fetch('user',$ids);

$ids = Utility::GetColumn($rs, 'shipper');
$shippers = Table::Fetch('shipper',$ids);

$ids = Utility::GetColumn($rs, 'updater');
$updaters = Table::Fetch('user',$ids);

//sumary
$sql = "SELECT so.deal_id,sum(so.quantity) as qty,sum(so.amount) as amt, o.payment_id FROM ship_out_data as so LEFT JOIN `order` as o ON o.id=so.order_id WHERE out_id=".$out_id." GROUP BY deal_id ORDER BY deal_id";
$r = DB::GetQueryResult($sql,false);

if(is_array($r)){
	foreach($r AS $index=>$one) {
		$a = $index+1;
		$template_transaction_id = strval($rs[0]['out_id']."-00".$a);
		if($rs[0]['city']!=11){
			$description = "Phieu xuat kho di tinh";	
		}else{
			$description = "";	
		}

		//echo "INSERT INTO ET9002(InventoryID, VoucherNo, ObjectID,RefNo02, Quantity,OriginalAmount,TransactionTypeID,Voucherdate,TemplateID,TemplateTransactionID, Description, PaymentID) VALUES ('".$one['deal_id']."', '".$rs[0]['out_id']."', '".$shippers[$rs[0]['shipper']]['id']."', '".$teams[$one['deal_id']]['partner_id']."','".$one['qty']."', '".$one['amt']."', 'DealSocWM', '".$rs[0]['created']."', '".$rs[0]['out_id']."','".$template_transaction_id."', '".$description."','".(int)$one['payment_id']."');";
		//echo $one['payment_id']."<br>";
	/*  	mssql_query("INSERT INTO ET9002(InventoryID, VoucherNo, ObjectID,RefNo02, Quantity,OriginalAmount,TransactionTypeID,Voucherdate,TemplateID,TemplateTransactionID, Description, PaymentID) VALUES ('".$one['deal_id']."', '".$rs[0]['out_id']."', '".$shippers[$rs[0]['shipper']]['id']."', '".$teams[$one['deal_id']]['partner_id']."','".$one['qty']."', '".$one['amt']."', 'DealSocWM', '".$rs[0]['created']."', '".$rs[0]['out_id']."','".$template_transaction_id."', '".$description."','".(int)$one['payment_id']."')");  */
		
	}
}
if($rs[0]['city']!=11){
	include template('shipping/ship_out_data_all');
}else{
	include template('shipping/ship_out_data');
}
