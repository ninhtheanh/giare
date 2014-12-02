<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
need_manager();
need_auth('eorder');
function ProductInQueue($id){	
	$sql = "SELECT COUNT(product_id) as total_product_queue FROM product_queue WHERE product_id = ".$id;
	$ds = DB::GetQueryResult($sql);
	return $ds["total_product_queue"];
}
if(isset($_POST['processing'])){
	$team_id_list = implode(",",$_POST['team_id']);
	$order_list_id = implode(",",$_POST['myinput']);
	DB::Query("UPDATE `order` SET state='processing' WHERE id IN ({$order_list_id})");
	$sql = "SELECT team_id, SUM(quantity) as item_qty FROM `order` WHERE  id IN ({$order_list_id}) GROUP BY team_id";	
	$ds = DB::GetQueryResult($sql, false);
	if(is_array($ds)){
		$date_print = date("Y-m-d H:i:s",time());
		foreach($ds as $key => $val){
			$product_id = $val["team_id"];
			$itemqty = $val["item_qty"];
			if(ProductInQueue($product_id)>0){
				$sql_0 = "UPDATE product_queue SET quantity = quantity+".$itemqty.", date_modified = '".$date_print."', modified_by = '".$login_user['username']."' WHERE product_id = ".$product_id;
			}else{
				$sql_0 = "INSERT INTO product_queue(product_id, quantity, date_modified, modified_by) VALUES (".$product_id.",".$itemqty.",'".$date_print."','".$login_user['username']."')";
			}
			DB::Query($sql_0);
			$sql_1 = "SELECT COUNT(item_id) as total_itemid FROM print_items WHERE item_id = ".$product_id." AND print_time = '0000-00-00 00:00:00'";
			$bs = DB::GetQueryResult($sql_1);
			if($bs["total_itemid"]>0){
				$sql_2 = " UPDATE print_items SET quantity = quantity + ".$itemqty." WHERE item_id = ".$product_id." AND print_time = '0000-00-00 00:00:00'";
			}else{
				$sql_2 = "INSERT INTO print_items(item_id, print_time, quantity, date_modified, modified_by) VALUES (".$product_id.", '0000-00-00 00:00:00',".$itemqty.", '".$date_print."', '".$login_user['username']."')";
			}
			DB::Query($sql_2);
		}
		Session::Set('notice', 'Tiếp nhận xử lý các đơn hàng bạn đã chọn thành công');
		redirect( WEB_ROOT . "/backend/order/confirmed.php?city_id=556");
	}
}
