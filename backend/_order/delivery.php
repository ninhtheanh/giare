<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
need_manager();
need_auth('order');

$condition = array(
	'shipper_id > 0',
	'state' => 'delivered',
	'credit = 0',
	'team_id > 0',
);

/* filter */
$uemail = strval($_GET['uemail']);
if ($uemail) {
	$field = strpos($uemail, '@') ? 'email' : 'username';
	$field = is_numeric($uemail) ? 'id' : $field;
	$uuser = Table::Fetch('user', $uemail, $field);
	if($uuser) $condition['user_id'] = $uuser['id'];
	else $uemail = null;
}
$id = abs(intval($_GET['id'])); if ($id) $condition['id'] = $id;

$team_id = abs(intval($_GET['team_id']));
if ($team_id) {
	$condition['team_id'] = $team_id;
} else { $team_id = null; }

$dist_id = abs(intval($_GET['dist_id']));
if ($dist_id) {
	$condition['dist_id'] = $dist_id;
} else { $dist_id = null; }

$city_id = abs(intval($_GET['city_id']));
if($city_id) {
	$condition['city_id'] = $city_id;
} else { $city_id = $city['id']; }

$shipper_id = abs(intval($_GET['shipper_id']));
if($shipper_id) {
	$condition['shipper_id'] = $shipper_id;
} else { $shipper_id = null; }

$delivery_time = abs(intval($_GET['delivery_time']));
if($delivery_time) {
	$condition['delivery_time'] = $delivery_time;
} else { $delivery_time = 0; }

$cbday = strval($_GET['cbday']);
$ceday = strval($_GET['ceday']);
$pbday = strval($_GET['pbday']);
$peday = strval($_GET['peday']);
if ($cbday) { 
	$cbtime = strtotime($cbday);
	$condition[] = "create_time >= '{$cbtime}'";
}
if ($ceday) { 
	$cetime = strtotime($ceday);
	$condition[] = "create_time <= '{$cetime}'";
}
if ($pbday) { 
	$pbtime = strtotime($pbday);
	$condition[] = "pay_time >= '{$pbtime}'";
}
if ($peday) { 
	$petime = strtotime($peday);
	$condition[] = "pay_time <= '{$petime}'";
}
$mobile = strval($_GET['mobile']);
if ($mobile) { 
	$condition['mobile'] = $mobile;
}
$delivery_code = strval($_GET['delivery_code']);
if ($delivery_code) { 
	$condition['delivery_code'] = $delivery_code;
}
if(isset($_POST['process'])){

	//update ship_out set updater
	DB::Update('ship_out', $delivery_code, array('updater'=>$login_user_id,'updated'=>date('Y-m-d H:i:s',time())),'out_id');
	//ship_log		
	save_ship_log($delivery_code,0,'TRABA');
			
	$list_order_id_pay = implode(",",$_POST['orderid']);
	$id = explode(",",$list_order_id_pay);
	for($i=0;$i<count($id);$i++){
		$row = $_POST["row{$id[$i]}"];
		$note = $_POST["note{$id[$i]}"];
		$money = $_POST["money{$id[$i]}"];
		$user = $_POST["user{$id[$i]}"];
		/*echo $id[$i]."--row value: ".$row."--note: ".$note."<br>";*/
		if($row!=''){
			if($row=='canceled' && $money>0){
				Table::UpdateCache('user', $user, array(
					'money' => $money,
				));
			}
			Table::UpdateCache('order', $id[$i], array(
				'state' => $row,
				'notes' => $note,
				'admin_id'=>$login_user_id,
			));
			save_order_history($id[$i],$row,$note);
			//update ship_out
			DB::Update('ship_out_data', $id[$i], array('state'=>$row,'notes'=>$note),'order_id');
		}
	}
	/*URL Balance*/
	$url_open_balance = WEB_ROOT."./confirmed_delivery.php?shipper_id={$shipper_id}&team_id={$team_id}&dist_id={$dist_id}&city_id={$city_id}&order_id_list={$list_order_id_pay}&delivery_time={$delivery_time}&delivery_code={$delivery_code}&export=word";
	/*echo "<script type=\"text/javascript\" language=\"javascript\">function open_win()
	{
	window.open(\"{$url_open_balance}\")
	}if(confirm('Xuất bảng kê nộp tiền?')){open_win();}else{
		window.location.href='".WEB_ROOT . $_SERVER['REQUEST_URI']."';}</script>";*/
	Session::Set('notice', 'Xác nhận trả bàn giao thành công. <a href="'.$url_open_balance.'"  style="color:#ff6600; font-weight:bold; font-size:16px;" target="_blank">Xuất bảng kê nộp tiền</a>');
	redirect( WEB_ROOT . $_SERVER['REQUEST_URI']);
}
/* end filter */
	$count = Table::Count('order', $condition);
	list($pagesize, $offset, $pagestring) = pagestring($count, 60);
	$total_voucher = Table::Count('order', $condition, 'quantity');
	$orders = DB::LimitQuery('order', array(
		'condition' => $condition,
		'order' => 'ORDER BY dist_id ASC, ward_id ASC, add_street ASC, id_address_list ASC, id DESC',
		'size' => $pagesize,
		'offset' => $offset,
	));
	
	$pay_ids = Utility::GetColumn($orders, 'pay_id');
	$pays = Table::Fetch('pay', $pay_ids);
	
	$user_ids = Utility::GetColumn($orders, 'user_id');
	$users = Table::Fetch('user', $user_ids);
	
	$team_ids = Utility::GetColumn($orders, 'team_id');
	$teams = Table::Fetch('team', $team_ids);
	
	$orders_all = DB::LimitQuery('order', array(
		'condition' => $condition,
		'order' => 'ORDER BY delivery_time DESC, id DESC',
	));
	$order_ids = Utility::GetColumn($orders_all, 'id');
	$order_id_list = implode(",",$order_ids);
	
	include template('manage_order_delivery');