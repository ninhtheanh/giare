<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$id = abs(intval($_GET['id']));
$team = Table::Fetch('team', $id);
//invalid deal
if ( !$team || $team['begin_time']>time() ) {
	Session::Set('error', 'Deal bạn mua không tồn tại');
	redirect( WEB_ROOT . '/index.php' );
}
//expired deal
if ($team['end_time']<time()) {
	Session::Set('notice', 'Deal đã đóng!');
	redirect(WEB_ROOT  . "/index.php");
}
//whether buyed
$ex_con = array(
		'user_id' => $login_user_id,
		'team_id' => $team['id'],
		'state' => 'unpay',
		);	
		
$order = DB::LimitQuery('order', array(
	'condition' => $ex_con,
	'one' => true,
));

//$qty = (Session::Get('qty')) ? Session::Get('qty') : 1;

if(isset($_GET['edit'])){
	$qty = $order['quantity'];
}else{
	$qty = 1+$order['quantity'];
}
$v = checkVerified($login_user_id,$id);
$oid = checkOrderId($login_user_id,$id);
// promoted deal - bypass payment
if($oid['id']>0 && $id==$id_promotion && $v['verified']=='Y'){
	redirect(WEB_ROOT."/order/pay.php?id={$oid['id']}");
	exit();
}
//buyonce condition
if (strtoupper($team['buyonce'])=='Y') {
	$ex_con['state'] = 'pay';
	if ( Table::Count('order', $ex_con) ) {
		if($id==$id_promotion && $v['verified']=='Y'){
			redirect(WEB_ROOT."/order/pay.php?id={$oid['id']}");
			exit();
		}elseif($id==$id_promotion && $v['verified']=='N'){
			redirect(WEB_ROOT."/team/verifyurl.php?id={$id}");
			exit();
		}else{
			Session::Set('error', 'Deal này bạn đã mua rồi, vui lòng xem và mua deal khác!!');
			redirect( WEB_ROOT . "/index.php"); 
		}
	}
}

//repeat buy - peruser buy count condition
if ($team['per_number']>0) {
	$now_count = Table::Count('order', array(
		'user_id' => $login_user_id,
		'team_id' => $id,
		'state' => 'unpay',
	), 'quantity');
	$team['per_number'] -= $now_count;
	if ($team['per_number']<=0){
		if($id==$id_promotion && $v['verified']=='Y'){
			redirect(WEB_ROOT."/order/pay.php?id={$oid['id']}");
			exit();
		}elseif($id==$id_promotion && $v['verified']=='N'){
			redirect(WEB_ROOT."/team/verifyurl.php?id={$id}");
			exit();
		}else{
			Session::Set('error', 'Bạn đã mua quá số lượng giới hạn cho Deal này!!!');
			redirect( WEB_ROOT . "/index.php"); 
		}
	}
}
//deal's partner
$partner = Table::Fetch('partner', $team['partner_id']);

//post buy ----------------------------------------------------------------------------------------------------------------------------------------
if ( $_POST ) {
	Session::Set('qty', $_POST['quantity']);
	need_login();
	$table = new Table('order', $_POST);
	$table->quantity = abs(intval($table->quantity));	
	
	//$table->quantity = ($_POST['quantity']) ? $_POST['quantity'] : abs(intval($table->quantity));		
	//$table->quantity = abs(intval($table->quantity));	
	//user have order - increase quantity
	if ( $table->quantity == 0 ) {
		Session::Set('error', 'Số lượng mua không thể nhỏ hơn 1');
		redirect( WEB_ROOT . "/team/buy.php?id={$team['id']}");
	} 
	elseif ( $team['per_number']>0 && $table->quantity > $team['per_number'] ) {
		Session::Set('error', 'Số lượng mua quá giới hạn!');
		redirect( WEB_ROOT . "/team.php?id={$id}"); 
	}

	if ($order && $order['state']=='unpay') {
		$table->SetPk('id', $order['id']);
	}
	
	$table->user_id = $login_user_id;
	$table->realname = $_POST['realname'];
	$table->state = 'unpay';
	$table->team_id = $team['id'];
	if(isset($_POST['city_id'])){
		$table->city_id = $_POST['city_id'];
	}else{
		$table->city_id = $login_user['city_id'];
	}
	$table->express = ($team['delivery']=='express') ? 'Y' : 'N';
	$table->fare = $table->express=='Y' ? $team['fare'] : 0;
	$table->price = $team['team_price'];
	$table->credit = 0;
	//$table->quantity = $table->quantity+abs(intval($order['quantity']));

	if ( $table->id ) {
		$eorder = Table::Fetch('order', $table->id);
		if ($eorder['state']=='unpay' 
				&& $eorder['team_id'] == $id
				&& $eorder['user_id'] == $login_user_id
		   ) {
			$table->origin = team_origin($team, $table->quantity);
			$table->origin -= $eorder['card'];
		} else {
			$eorder = null;
		}
	} 
	if (!$eorder){
		$table->SetPk('id', null);
		$table->create_time = time();
		$table->origin = team_origin($team, $table->quantity);
	}
	$table->address = $table->house_number." ".$table->street_name;
	if(!empty($_POST['settings-realname'])){
		$table->brealname = $_POST['settings-realname'];
	}else{
		$table->brealname = $_POST['realname'];
	}
	$table->dist_id = $_POST['dist_id'];
	$table->ward_id = $_POST['ward_id'];
	
	$table->bcity_id = ($_POST['bcity_id']) ? $_POST['bcity_id'] : $table->city_id;
	$table->bdist_id = ($_POST['bdist_id']) ? $_POST['bdist_id'] : $table->dist_id;
	$table->bward_id = ($_POST['bward_id']) ? $_POST['bward_id'] : $table->ward_id;
	
	$table->bhouse_number = ($_POST['bhouse_number']) ? $_POST['bhouse_number'] : $table->house_number;
	$table->bstreet_name = ($_POST['bstreet_name']) ? $_POST['bstreet_name'] : $table->street_name;
	$table->bnote_address = ($_POST['bnote_address']) ? $_POST['bnote_address'] : $table->note_address;
	$table->bmobile = ($_POST['bmobile']) ? $_POST['bmobile'] : $table->mobile;;
	$table->baddress = $table->bhouse_number." ".$table->bstreet_name;
	if((int)$team['weight']==0){
		$team['weight'] = 100;	
	}
	$table->total_weight = $team['weight']*$table->quantity;
	
	//var_dump($table);exit;
	
	$insert = array('user_id', 'team_id', 'city_id', 'dist_id', 'ward_id', 'house_number', 'street_name', 'bcity_id', 'bdist_id', 'bward_id', 'bhouse_number', 'bstreet_name', 'state', 'fare', 'express', 'origin', 'price', 'address', 'note_address', 'baddress', 'bnote_address', 'zipcode', 'realname', 'mobile', 'brealname', 'bmobile', 'quantity', 'create_time', 'remark', 'condbuy', 'total_weight',);
	
	if ($flag = $table->update($insert)) {
		$order_id = abs(intval($table->id));
		if($id==$id_promotion){
			Table::UpdateCache('order', $order_id, array(
				'state' => '',
			));
			$email[] = $login_user['email'];
			$str_arr = array("0","1","2","3","4","5","6","7","8","9","0","1","2","3","4","5","6","7","8","9");
			$keys = array_rand($str_arr, 5);
			$str='';
			foreach($keys as $n=>$i){
				$str.= $str_arr[$i];
			}
			
			$check = checkSendedCode($_POST['mobile'],$team['id']);
			
			if(empty($check['verify_code'])){
				DB::Insert('verify_code',array(
					'cus_id' => $login_user_id,
					'cus_mobile' => $_POST['mobile'],
					'team_id' => $team['id'],
					'verify_code' => $str.$login_user_id,
					'status' => 'sended',
				));
				//$code = base64_encode($check['verify_code']."-".$login_user_id);
				$code = $str.$login_user_id;
				$str_url = "{$INI['system']['wwwprefix']}/team/activecode.php?id=".$order_id."&uid=".$login_user_id."&did=".$id."&code=".$code;
				$subject = "{$INI['system']['abbreviation']} - Xác nhận tham gia chương trình \"Miễn phí 01 năm mua sắm trên web: www.dealsoc.vn\"";
				$content = render('order_email_active_code', $order);
				try{
					mail_custom($email, $subject, $content);
					Session::Set('notice', "Vui lòng kiểm tra mail và bấm vào liên kết xác nhận để nhận mã dự thưởng");
					redirect(WEB_ROOT."/team/verifyurl.php?id={$id}");
					exit();
				}catch(Exception $e) {
					Session::Set('error', 'Gởi email xác nhận thất bại. Vui lòng thử lại sau:'. $e->getMessage());
				}
			}elseif(!empty($check['verify_code']) && $check['verified']=='N'){
				//$code = base64_encode($check['verify_code']."-".$login_user_id);
				$code = $check['verify_code'];
				$str_url = "{$INI['system']['wwwprefix']}/team/activecode.php?id=".$order_id."&mobile=".$_POST['mobile']."&did=".$id."&code=".$code;
				$subject = "{$INI['system']['abbreviation']} - Xác nhận tham gia chương trình \"Miễn phí 01 năm mua sắm trên web: www.dealsoc.vn\"";
				$content = render('order_email_active_code', $order);
				try{
					mail_custom($email, $subject, $content);
					Session::Set('notice', "Vui lòng kiểm tra mail và bấm vào liên kết xác nhận để nhận mã dự thưởng");
					redirect(WEB_ROOT."/team/verifyurl.php?id={$id}");
					exit();
				}catch(Exception $e) {
					Session::Set('error', 'Gởi email xác nhận thất bại. Vui lòng thử lại sau:'. $e->getMessage());
				}
			}
			elseif(!empty($check['verify_code']) && $check['verified']=='Y'){
				Session::Set('error', 'Mỗi số điện thoại chỉ được tham gia 01 lần duy nhất. Cảm ơn bạn đã tham gia chương trình.');	
				redirect(WEB_ROOT."/team/verifyurl.php?id={$id}");		
			}
		//process db
		}else{
			$order = DB::GetQueryResult("SELECT create_time FROM `order` WHERE team_id='".$id."' AND id='".$order_id."'");
			//echo time()."-----".date("Y-m-d H:i:s",$order['create_time']);
			//echo "<br>". $begin_date_promotion."------".$end_date_promotion;exit();
			if($order['create_time']>=$begin_date_promotion && $order['create_time']<=$end_date_promotion){
				$checkcode = DB::GetQueryResult("SELECT maso FROM masoduthuong WHERE team_id='".$id."' AND order_id='".$order_id."' AND user_id = '".$login_user_id."'");
				if(empty($checkcode)){
					DB::Insert('masoduthuong',array(
						'order_id' => $order_id,
						'fullname' => $table->realname,
						'address' => $table->address,
						'telephone' => $_POST['mobile'],
						'team_id' => $id,
						'user_id' => $login_user_id,
					));
				}
			}
			//if (CheckCityDeal($team['city_id'])){
				redirect(WEB_ROOT."/order/BillingShipping.php?id={$order_id}");
			//}else{
			//	redirect(WEB_ROOT."/order/check.php?id={$order_id}");
			//}	
		}
	}
}

//each user per day per buy
if (!$order) { 
	$order = json_decode(Session::Get('loginpagepost'),true);
	settype($order, 'array');
	if ($order['mobile']) $login_user['mobile'] = $order['mobile'];
	if ($order['zipcode']) $login_user['zipcode'] = $order['zipcode'];
	if ($order['address']) $login_user['address'] = $order['address'];
	if ($order['realname']) $login_user['realname'] = $order['realname'];	
	$order['quantity'] = (Session::Get('qty')) ? Session::Get('qty') : 1;	
}
//end;

$order['origin'] = team_origin($team, $order['quantity']);

if ($team['max_number']>0 && $team['conduser']=='N') {
	$left = $team['max_number'] - $team['now_number'];
	if ($team['per_number']>0) {
		$team['per_number'] = min($team['per_number'], $left);
	} else {
		$team['per_number'] = $left;
	}
}
if (CheckCityDeal($team['city_id'])){
	include template('team_buy_all');
}else{
	include template('team_buy');
}
/*include template('team_buy_all');*/