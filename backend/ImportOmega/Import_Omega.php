<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
require_once(dirname(dirname(__FILE__)) . '/connect_omega_db.php');
need_manager();
need_auth('order');

//Import Phieu Xuat Kho

$count = Table::Count('ship_out', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 500);

$sql = "SELECT so.*, sd.* FROM ship_out AS so LEFT JOIN ship_out_data AS sd USING(out_id) GROUP BY sd.out_id ORDER BY so.out_id ASC, street, dist_id, ward_id ASC, order_id ASC LIMIT $offset,$pagesize";

$rs = DB::GetQueryResult($sql,false);

$team_ids = Utility::GetColumn($rs, 'deal_id');
$teams = Table::Fetch('team', $team_ids);
$dist = DB::GetQueryResult("SELECT dist_name FROM district WHERE dist_id IN (".$rs[0]['dist_id'].")",false);
for($i=0; $i<count($dist);$i++){
	$dist_name .= $dist[$i]['dist_name'].", ";
}
$ids = Utility::GetColumn($rs, 'creator');
$creators = Table::Fetch('user',$ids);

$ids = Utility::GetColumn($rs, 'shipper');
$shippers = Table::Fetch('shipper',$ids);

$ids = Utility::GetColumn($rs, 'updater');
$updaters = Table::Fetch('user',$ids);


if(is_array($rs)){
	$sql = "";
	for($i=0; $i<count($rs);$i++){
		$sql = "SELECT deal_id, sum(quantity) as qty,sum(amount) as amt FROM ship_out_data WHERE out_id=".$rs[$i]['out_id']." GROUP BY deal_id ORDER BY deal_id";
		$r = DB::GetQueryResult($sql, false);
		if(is_array($r)){
			foreach($r as $index => $one){
				$a = $index+1;
				$template_transaction_id = strval($rs[$i]['out_id']."-00".$a);
				//echo "INSERT INTO ET9002(InventoryID, VoucherNo, ObjectID,RefNo02, Quantity,OriginalAmount,TransactionTypeID,Voucherdate,TemplateID,TemplateTransactionID) VALUES ('".$one['deal_id']."', '".$rs[$i]['out_id']."', '".$shippers[$rs[$i]['shipper']]['id']."', '".$teams[$rs[$i]['deal_id']]['partner_id']."','".$one['qty']."', '".$one['amt']."', 'DealSocWM', '".$rs[$i]['created']."', '".$rs[$i]['out_id']."','".$template_transaction_id."' );<br>";
				mssql_query("INSERT INTO ET9002(InventoryID, VoucherNo, ObjectID,RefNo02, Quantity,OriginalAmount,TransactionTypeID,Voucherdate,TemplateID,TemplateTransactionID) VALUES ('".$one['deal_id']."', '".$rs[$i]['out_id']."', '".$shippers[$rs[$i]['shipper']]['id']."', '".$teams[$rs[$i]['deal_id']]['partner_id']."','".$one['qty']."', '".$one['amt']."', 'DealSocWM', '".$rs[$i]['created']."', '".$rs[$i]['out_id']."','".$template_transaction_id."' )");
				$aa = DB::Query("UPDATE `ship_out` SET exported='Y' WHERE out_id=".$rs[$i]['out_id']);
			}
		}
	}
}
echo $pagestring;
mssql_close($dbhandle);
