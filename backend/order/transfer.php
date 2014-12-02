<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('order');
$id = abs(intval($_REQUEST['id']));
$transferID = abs(intval($_REQUEST['transferid']));
$date_times = date("Y-m-d H:i:s",time());
$table = new Table('order', $_POST);
if(!$_POST['note_times_1']) {
	Session::Set('error', 'Transfer note must be typed');
	redirect(null);
}
if($transferID>0){
	$row = DB::GetQueryResult("SELECT is_times_1, is_times_2 FROM order_wait_call WHERE order_id=".$id." AND id=".$transferID);
	if($row['is_times_1']=='yes' && $row['is_times_2']=='no'){
		Table::UpdateCache('order_wait_call', $transferID, array(
			'date_times_2' => $date_times,
			'note_times_2' => $_POST['note_times_1'],
			'is_times_2' => 'yes',
		));
		save_order_history($id,'calling','','Called Times 2');
	}else{
		Table::UpdateCache('order_wait_call', $transferID, array(
			'date_times_3' => $date_times,
			'note_times_3' => $_POST['note_times_1'],
			'is_times_3' => 'yes',
		));
		save_order_history($id,'calling','','Called Times 3');
	}
}else{
	save_order_history($id,'calling','','Called Times 1');	
	DB::Insert('order_wait_call',array(
		'order_id' => $id,
		'date_times_1' => $date_times,
		'note_times_1' => $_POST['note_times_1'],
		'is_times_1' => 'yes',
	));
}
Table::UpdateCache('order', $id, array(
	'state' => 'calling',
));
redirect(null);