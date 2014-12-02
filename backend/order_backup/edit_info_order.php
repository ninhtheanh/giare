<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('order');

$condition = array(
	"state IN ('confirmed','pending')",
	'id_address_list'	=> 0,
);

$dist_id = abs(intval($_GET['dist_id']));
if ($dist_id) {
	$condition['dist_id'] = $dist_id;
} else { $dist_id = 0; }

$count = Table::Count('order', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 10);
$orders = DB::LimitQuery('order', array(
	'condition' => $condition,
	'order' => 'ORDER BY id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));

for($j=0;$j<count($orders);$j++){
	$oid = $orders[$j]['id'];
	$sc .= "$(\"#ward_id_$oid\").chained(\"#dist_id_$oid\");";
}
if(isset($_POST['update'])){
	$id = $_POST['myinput'];
	for($i=0;$i<count($id);$i++){
		$address = $_POST["address_{$id[$i]}"];
		$dist_id = $_POST["dist_id_{$id[$i]}"];
		$ward_id = $_POST["ward_id_{$id[$i]}"];
		$note_address = $_POST["note_address_{$id[$i]}"];
		$notes = $_POST["notes_{$id[$i]}"];
		$list = check_address_list($dist_id, $ward_id, $address);
		if($list['id']>0){
			Table::UpdateCache('address_list', $list['id'], array(
				'address' => $address,
				'dist_id' => $dist_id,
				'ward_id' => $ward_id,
			));
			$id_address_list = $list['id'];
		}else{
			DB::Insert('address_list',array(
				'address' => $address,
				'dist_id' => $dist_id,
				'ward_id' => $ward_id,
			));
			$id_address_list  = mysql_insert_id();
		}
		Table::UpdateCache('order', $id[$i], array(
			'id_address_list' => $id_address_list,
			'address' => $address,
			'dist_id' => $dist_id,
			'ward_id' => $ward_id,
			'note_address' => $note_address,
		));
		Table::UpdateCache('user', $orders[$i]['user_id'], array(
			'address' => $address,
			'note_address' => $note_address,
			'dist_id' => $dist_id,
			'ward_id' => $ward_id,
			'id_address_list' => $id_address_list,
		));
		save_order_history($id[$i],'changed','','');
		//build add_street
		ZOrder::BuildAddStreet($order);
	}
	redirect( WEB_ROOT .$_SERVER['REQUEST_URI']);
}
include template('manage_edit_info_order');