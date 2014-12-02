<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
//require_once(dirname(dirname(__FILE__)) . '/connect_omega_db.php');
need_manager();
need_auth('order');

$in_id = abs(intval($_GET['in_id']));

$sql = "SELECT updater,updated,s.*, d.* FROM ship_in AS s LEFT JOIN ship_in_data AS d USING(in_id) LEFT JOIN ship_out As so USING(out_id) WHERE in_id=".$in_id;
$rs = DB::GetQueryResult($sql,false);

$team_ids = Utility::GetColumn($rs, 'deal_id');
$teams = Table::Fetch('team', $team_ids);

$ids = Utility::GetColumn($rs, 'creator');
$creators = Table::Fetch('user',$ids);

$order_ids =DB::GetQueryResult("SELECT order_id FROM `ship_out_data` WHERE out_id = ".$rs[0]['out_id'], false);
for($i=0; $i<count($order_ids);$i++){
	$orderid .= $order_ids[$i]['order_id'].", ";
}
$list_order_id = rtrim($orderid,", ");

$ids = Utility::GetColumn($rs, 'shipper');
$shippers = Table::Fetch('shipper',$ids);

$ids = Utility::GetColumn($rs, 'updater');
$updaters = Table::Fetch('user',$ids);

$ids = Utility::GetColumn($rs, 'approver');
$approvers = Table::Fetch('user',$ids);

//sumary
$sql_0 = "SELECT locked FROM ship_in WHERE in_id=".$in_id;
$ss = DB::GetQueryResult($sql_0);


if($ss['locked']=='N'){
	if(is_array($rs)){
		$sql = "SELECT TemplateTransactionID FROM ET9002 WHERE TemplateID='GL-".$in_id."'";
		/*  $a = mssql_query($sql);
		if(mssql_num_rows($a)>0){
			mssql_query("DELETE FROM ET9002 WHERE TemplateID='GL-".$in_id."'");
		}  */
		foreach($rs AS $index=>$one) {
			//$list_order_id = ""; 
			$dtt = 0; $sum_paid_credit=0;$sum_paid = 0;$payment="";
			$sum_credit = DB::GetQueryResult("SELECT sum(credit) as sum_credit FROM `order` WHERE id IN ($list_order_id) AND team_id='".$one['deal_id']."'");
			$sum_paid_credit = $sum_credit['sum_credit'];
			
			$sum_money = DB::GetQueryResult("SELECT sum(money) as sum_money FROM `order` WHERE id IN ($list_order_id) AND team_id='".$one['deal_id']."'");
			$sum_paid = $sum_money['sum_money'];
			
			if($one['pays']>0){
				$dtt = ($sum_paid+$sum_paid_credit);
			}
			
			if($one['pays']>0){
				$conlai = $one['price']*$one['pays'] - $dtt;
			}else{
				$conlai = $one['price']*$one['pays'];
			}
			if($one['approved']!=''){
				$voucher_date = $one['approved'];
			}else{
				$voucher_date = date('Y-m-d H:i:s',time());
			}

			$oid_arr = explode(", ", $list_order_id);
			$payment = DB::GetQueryResult("SELECT payment_id FROM `order` WHERE id=".$oid_arr[$index]);
			//echo "UPDATE ET9002 SET UnitPrice='".$one['pays']."', RefNo02='".$one['in_id']."',OriginalAmount='".$dtt."', ImTaxConvertedAmount='".$conlai."', ExpenseConvertedAmount='".$one['pendings']."', TransactionTypeID='DealSocGL', DueDate='".$voucher_date."' WHERE  VoucherNo='".$one['out_id']."' AND InventoryID='".$one['deal_id']."';";
			$a = $index+1;
			$template_transaction_id = "GL-".strval($one['in_id']."-00".$a);
			//echo "INSERT INTO ET9002(UnitPrice, RefNo02, OriginalAmount, ImTaxConvertedAmount, ExpenseConvertedAmount, InventoryID, TransactionTypeID, DueDate, VoucherNo, TemplateID, TemplateTransactionID) VALUES ('".(int)$one['pays']."', '".$one['in_id']."', '".$dtt."', '".$conlai."', '".(int)$one['pendings']."', '".$one['deal_id']."', 'DealSocGL', '".$voucher_date."', '".$one['out_id']."', 'GL-".$one['in_id']."','".$template_transaction_id."')";
			if($one['city']!=11){
				$description = "Cac DH gui di tinh";	
			}else{
				$description = "";	
			}
		/*  	mssql_query("INSERT INTO ET9002(ObjectID, Quantity, RefNo02, ImTaxConvertedAmount, OriginalAmount, ExpenseConvertedAmount, InventoryID, TransactionTypeID, DueDate, Voucherdate, VoucherNo, TemplateID, TemplateTransactionID, Description, PaymentID) VALUES ('".(int)$one['shipper']."', '".(int)$one['pays']."', '".$one['in_id']."', '".$dtt."', '".$conlai."', '".(int)$one['pendings']."', '".$one['deal_id']."', 'DealSocGL', '".$voucher_date."', '".$voucher_date."', '".$one['out_id']."', 'GL-".$one['in_id']."','".$template_transaction_id."', '".$description."','".(int)$payment['payment_id']."')");  */
		}
	}
//	mssql_close($dbhandle);
}

include template('shipping/ship_in_data');
