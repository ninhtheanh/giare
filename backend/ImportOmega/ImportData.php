<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
require_once(dirname(dirname(__FILE__)) . '/connect_omega_db.php');

$condition = array("approved BETWEEN '2011-12-23 00:00:00' AND '2011-12-23 23:59:59'");


//$condition = array("s.in_id IN (3655, 3659)");
$condition = DB::BuildCondition( $condition );
//var_dump($condition);
//exit();
//Import Bang ke nop tien

/*$count = DB::GetQueryResult("SELECT count(*) as total FROM ship_in AS s LEFT JOIN ship_in_data AS d USING(in_id) LEFT JOIN ship_out As so USING(out_id) WHERE ".$condition);
list($pagesize, $offset, $pagestring) = pagestring($count['total'], 500);*/

$in_id = abs(intval($_GET['in_id']));
$sql = "SELECT updater,updated,s.*, d.* FROM ship_in AS s LEFT JOIN ship_in_data AS d USING(in_id) LEFT JOIN ship_out As so USING(out_id)  WHERE s.in_id=".$in_id." ORDER BY s.out_id ASC";
$rs = DB::GetQueryResult($sql,false);
if(is_array($rs)){
	foreach($rs as $index=>$one) {
		$list_order_id = ""; $dtt = 0; $sum_paid_credit=0; $sum_paid = 0;
		$order_ids =DB::GetQueryResult("SELECT order_id FROM `ship_out_data` WHERE  out_id = ".$one['out_id'], false);
		for($i=0; $i<count($order_ids);$i++){
			$orderid .= $order_ids[$i]['order_id'].", ";
		}
		$list_order_id = rtrim($orderid,", ");
		$sum_credit = DB::GetQueryResult("SELECT sum(credit) as sum_credit FROM `order` WHERE id IN ($list_order_id) AND team_id='".$one['deal_id']."' AND ship_id ='".$one['out_id']."'");
        $sum_paid_credit = $sum_credit['sum_credit'];
		
		$sum_money = DB::GetQueryResult("SELECT sum(money) as sum_money FROM `order` WHERE id IN ($list_order_id) AND team_id='".$one['deal_id']."' AND ship_id ='".$one['out_id']."'");
        $sum_paid = $sum_money['sum_money'];		
        if($one['pays']>0){
			$dtt = ($sum_paid+$sum_paid_credit);
			$conlai = $one['price']*$one['pays'] - $dtt;
        }else{
        	$dtt = 0;
			$conlai = $one['price']*$one['pays'];
        }
		
		if($one['approved']!=''){
			$voucher_date = $one['approved'];
		}else{
			$voucher_date = date('Y-m-d H:i:s',time());
		}
		
		if($_SESSION['in_id']==$one['in_id']){
			$a = $a+1;
		}else{ $index=0;$a = $index+1;}
		$template_transaction_id = "GL-".strval($one['in_id']."-00".$a);
		
		//mssql_query("INSERT INTO ET9002(UnitPrice, RefNo02, OriginalAmount, ImTaxConvertedAmount, ExpenseConvertedAmount, InventoryID, TransactionTypeID, DueDate, VoucherNo, TemplateID, TemplateTransactionID) VALUES ('".(int)$one['pays']."', '".$one['in_id']."', '".$dtt."', '".$conlai."', '".(int)$one['pendings']."', '".$one['deal_id']."', 'DealSocGL', '".$voucher_date."', '".$one['out_id']."', 'GL-".$one['in_id']."','".$template_transaction_id."')");
		$insert = "INSERT INTO ET9002(ObjectID, Quantity, RefNo02, OriginalAmount, ImTaxConvertedAmount, ExpenseConvertedAmount, InventoryID, TransactionTypeID, DueDate, Voucherdate, VoucherNo, TemplateID, TemplateTransactionID) VALUES ('".(int)$one['shipper']."','".(int)$one['pays']."', '".$one['in_id']."', '".(int)$dtt."', '".(int)$conlai."', '".(int)$one['pendings']."', '".$one['deal_id']."', 'DealSocGL', '".$voucher_date."', '".$voucher_date."','".$one['out_id']."', 'GL-".$one['in_id']."','".$template_transaction_id."');";
		$_SESSION['in_id'] = $one['in_id'];
		mssql_query($insert);
		$aa = DB::Query("UPDATE `ship_in` SET exported='Y' WHERE in_id=".$one['in_id']);
		//echo $insert. "<br>";
	}
}
mssql_close($dbhandle);
?>
