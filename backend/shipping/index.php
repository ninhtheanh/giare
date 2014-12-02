<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
//require_once(dirname(dirname(__FILE__)) . '/connect_omega_db.php');

need_manager();

//DB::$mDebug = true;

$condition = array("locked='N' AND city IN ({$city['id']},556)");
// filter ------------------------------------------

$out_id = abs(intval($_GET['out_id'])); if ($out_id) $condition['out_id'] = $out_id;
$in_id = abs(intval($_GET['in_id'])); if ($in_id) $condition['in_id'] = $in_id;
$creator = abs(intval($_GET['creator'])); if ($creator) $condition['creator'] = $creator;
$shipper = abs(intval($_GET['shipper'])); if ($shipper) $condition['shipper'] = $shipper;
$updater = abs(intval($_GET['updater'])); if ($updater) $condition['updater'] = $updater;
$approver = abs(intval($_GET['approver'])); if ($approver) $condition['approver'] = $approver;

$cbday = strval($_GET['cbday']);
$ceday = strval($_GET['ceday']);
if ($cbday) { 
	$cbtime = strtotime($cbday);
	$condition[] = "created >= '{$cbtime} 00:00:00'";
}
if ($ceday) { 
	$cetime = strtotime($ceday);
	$condition[] = "created <= '{$cetime} 23:59:59'";
}
/* end fiter */

//process mode
if($_GET['process']==true && (int)$_GET['in_id']){
	$ship_out = DB::GetQueryResult("SELECT order_id, state, qty_successful, quantity, notes, date_received, service FROM ship_out_data WHERE out_id=".$out_id,false);
	$qty_success = 0;
	for($i=0;$i<count($ship_out);$i++){
		if($ship_out[$i]['state']=='canceled'){
			$o = DB::GetQueryResult("SELECT money, credit, user_id FROM `order` WHERE id=".$ship_out[$i]['order_id']);
			if($o['money']>0){
				Table::UpdateCache('user', $o['user_id'], array(
					'money' => $o['money'],
				));
				Table::UpdateCache('order', $ship_out[$i]['order_id'], array(
					'money' => 0,
				));
			}elseif($o['credit']>0){
				Table::UpdateCache('user', $o['user_id'], array(
					'money' => $o['credit'],
				));
				Table::UpdateCache('order', $ship_out[$i]['order_id'], array(
					'credit' => 0,
				));
			}
		}elseif($ship_out[$i]['state']=='hanging'){
			$rs = array(
				'order_id' => $ship_out[$i]['order_id'],
				'date_received' => $ship_out[$i]['date_received'],
			);		
			DB::Insert('order_hanging', $rs);
		}else{
			if($ship_out[$i]['qty_successful']>0){
				$qty_success = $ship_out[$i]['qty_successful'];
			}else{
				$qty_success = $ship_out[$i]['quantity'];
			}	
		}
		$notes_id= 0;
		$vv = DB::GetQueryResult("SELECT notes_id FROM order_notes WHERE order_id=".$ship_out[$i]['order_id']." AND out_id=".$out_id);
		$nn = array(); $notes=""; $notes_id= $vv['notes_id'];
		if((int)$notes_id>0){
			$nn = DB::GetQueryResult("SELECT title FROM notes WHERE id=".$vv['notes_id']);
			$notes = $nn['title'];
		}
		Table::UpdateCache('order', $ship_out[$i]['order_id'], array(
			'state' => $ship_out[$i]['state'],
			'notes' => rtrim($ship_out[$i]['notes'].", ".$notes,", "),
			'service' => $ship_out[$i]['service'],
			'quantity_successful' => $qty_success,
			'admin_id'=>$login_user_id,
		));
		$orderid .= $order_ids[$i]['order_id'].", ";
	}
	$list_order_id = rtrim($orderid,", ");
	//UPDATE vao phan mem Omega
	$in_id = abs(intval($_GET['in_id']));
	$sql = "SELECT updater,updated,s.*, d.* FROM ship_in AS s LEFT JOIN ship_in_data AS d USING(in_id) LEFT JOIN ship_out As so USING(out_id) WHERE in_id=".$in_id;
	$rs = DB::GetQueryResult($sql,false);
	/*  if(is_array($rs)){
		$sql = "SELECT TemplateTransactionID FROM ET9002 WHERE TemplateID='GL-".$in_id."'";
		$a = mssql_query($sql);
		if(mssql_num_rows($a)>0){
			mssql_query("DELETE FROM ET9002 WHERE TemplateID='GL-".$in_id."'");
		}
		foreach($rs AS $index=>$one) {
			//$list_order_id = ""; 
			$dtt = 0; $sum_paid_credit=0;$sum_paid = 0;
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
			}  */

			//echo "UPDATE ET9002 SET UnitPrice='".$one['pays']."', RefNo02='".$one['in_id']."',OriginalAmount='".$dtt."', ImTaxConvertedAmount='".$conlai."', ExpenseConvertedAmount='".$one['pendings']."', TransactionTypeID='DealSocGL', DueDate='".$voucher_date."' WHERE  VoucherNo='".$one['out_id']."' AND InventoryID='".$one['deal_id']."';";
			/*  $a = $index+1;
			$template_transaction_id = "GL-".strval($one['in_id']."-00".$a);  */
			//echo "INSERT INTO ET9002(UnitPrice, RefNo02, OriginalAmount, ImTaxConvertedAmount, ExpenseConvertedAmount, InventoryID, TransactionTypeID, DueDate, VoucherNo, TemplateID, TemplateTransactionID) VALUES ('".(int)$one['pays']."', '".$one['in_id']."', '".$dtt."', '".$conlai."', '".(int)$one['pendings']."', '".$one['deal_id']."', 'DealSocGL', '".$voucher_date."', '".$one['out_id']."', 'GL-".$one['in_id']."','".$template_transaction_id."')";
			/*  if($one['city']!=11){
				$description = "Cac DH gui di tinh";	
			}else{
				$description = "";	
			}
			
			mssql_query("INSERT INTO ET9002(ObjectID, Quantity, RefNo02, ImTaxConvertedAmount, OriginalAmount, ExpenseConvertedAmount, InventoryID, TransactionTypeID, DueDate, Voucherdate, VoucherNo, TemplateID, TemplateTransactionID, Description) VALUES ('".(int)$one['shipper']."', '".(int)$one['pays']."', '".$one['in_id']."', '".$dtt."', '".$conlai."', '".(int)$one['pendings']."', '".$one['deal_id']."', 'DealSocGL', '".$voucher_date."', '".$voucher_date."', '".$one['out_id']."', 'GL-".$one['in_id']."','".$template_transaction_id."', '".$description."')");
		}
	}
  */
	
	
	//update ship_in set updater
	DB::Update('ship_in', $in_id, array('locked'=>'Y','approver'=>$login_user_id,'approved'=>date('Y-m-d H:i:s',time())),'in_id');
	//ship_log		
	save_ship_log(0,$in_id,'XACNH');
	redirect();
}

//$condition = DB::BuildCondition( $condition );
//$condition = (null==$condition) ? null : "WHERE $condition";
//DB::$mDebug = true;
$count = Table::Count('ship_in', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 100);
$total = Table::Count('ship_in', $condition);
$rs = DB::LimitQuery('ship_in', array(
	'condition' => $condition,
	'order' => 'ORDER BY in_id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));

$ids = Utility::GetColumn($rs, 'creator');
$creators = Table::Fetch('user',$ids);

$ids = Utility::GetColumn($rs, 'shipper');
$shippers = Table::Fetch('shipper',$ids);

$ids = Utility::GetColumn($rs, 'updater');
$updaters = Table::Fetch('user',$ids);

$ids = Utility::GetColumn($rs, 'approver');
$approvers = Table::Fetch('user',$ids);
//mssql_close($dbhandle);
include template('shipping/index');
