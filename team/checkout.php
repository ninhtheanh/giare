<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$carts = Session::Get('carts');	
$pagetitle = 'Nhập thông tin mua sản phẩm';
$ref = 'index.php'; //$_GET['ref']; 

if($carts == null || count($carts) < 1){
	Session::Set('notice', 'Chưa có sản phẩm trong giỏ hàng để thanh toán');
	redirect(WEB_ROOT  . "/index.php");
}

$u = array();

/* if( $_POST){
	$atstate = $_POST['atstate'];
	
	//process new user submit
	if($atstate == 'new'){
		
	$u['username'] = strval($_POST['email']);
	$u['password'] = strval($_POST['password']);
	$u['email'] = strval($_POST['email']);
	$u['realname'] = strval($_POST['realname']);
	$u['gender'] = strval($_POST['gender']);
	$u['dob'] = checkdate((int)@$_POST['dob_m'],(int)@$_POST['dob_d'],(int)@$_POST['dob_y']) ? (int)@$_POST['dob_y']."-".(int)@$_POST['dob_m']."-".(int)@$_POST['dob_d'] : "";
	$u['house_number'] = $_POST['house_number'];
	$u['street_name'] = $_POST['street_name'];
	$u['address'] = $_POST['house_number']." ".$_POST['street_name'];
	$u['note_address'] = strval($_POST['note_address']);
	$u['dist_id'] = isset($_POST['dist_id']) ? abs(intval($_POST['dist_id'])) : abs(intval($dist['dist_id']));
	$u['ward_id'] = isset($_POST['ward_id']) ? abs(intval($_POST['ward_id'])) : abs(intval($dist['ward_id']));
	$u['city_id'] = isset($_POST['city_id']) ? abs(intval($_POST['city_id'])) : abs(intval($city['id']));
	$u['mobile'] = strval($_POST['mobile']);
	
	
		//check dang ky nhan deal qua email
		if ( $_POST['subscribe'] ) { 
			ZSubscribe::Create($u['email'], abs(intval($u['city_id']))); 
		}
		
		if ( ! Utility::ValidEmail($u['email'], true) ) {
			Session::Set('error', 'Địa chỉ email không hợp lệ');
			redirect( WEB_ROOT . '/account/signup.php?ref='.$ref);
		}
		if (strlen(trim($_POST['password']))>6 && $_POST['password']) {
			if ( option_yes('emailverify') ) { 
				$u['enable'] = 'Y'; 
			}
			//register new user
			if ( $user_id = ZUser::Create($u) ) {
				
				//
				if ( option_yes('emailverify') ) {
					mail_sign_id($user_id);
				//	Session::Set('unemail', $_POST['email']);
			//		redirect( WEB_ROOT . '/account/signuped.php?ref='.$ref);
				} else {
					ZLogin::Login($user_id);
					// sign up email
					$content = render('account_email_signup', $u);			
			//		mail_custom($u['email'], 'Cheapdeal - Xác nhận đăng ký tài khoản', $content); // maybe you will get some delay here
					
			//		redirect(get_loginpage(WEB_ROOT . '/index.php'));
				}
				
				//begin order deal
				//begin insert new order
					$totalquantity = 0;
					$totalprice = 0;
					$team_id = 0;
					foreach($carts as $key=>$cart){
						$totalquantity =  $totalquantity +  abs(intval($cart['quantity']));
						$totalprice = $totalprice + ($cart['quantity'] * $cart['team_price']);
						$team_id = $key;
					}
					$table = new Table('order', $_POST);
					$table->SetPk('id', null);
					$table->quantity = $totalquantity;
					$table->user_id = $login_user['id'];
					$table->realname = $_POST['realname'];
					$table->state = 'unpay';
					if($team_id > 0){
						$table->team_id = $team_id;
					}
					if(isset($_POST['city_id'])){
						$table->city_id = $_POST['city_id'];
					}else{
						$table->city_id = $login_user['city_id'];
					}
					$table->express = 'Y';
					$table->fare = 0;
					$table->price = $totalprice;
					$table->credit = 0;
					
					$table->create_time = time();
					$table->origin = $totalprice; // team_origin($team, $table->quantity);
		
				
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
				
					$table->total_weight = 0;
					
					
					
				//	print_r($table);
				
				$insert = array('user_id', 'team_id', 'city_id', 'dist_id', 'ward_id', 'house_number', 'street_name', 'bcity_id', 'bdist_id', 'bward_id', 'bhouse_number', 'bstreet_name', 'state', 'fare', 'express', 'origin', 'price', 'address', 'note_address', 'baddress', 'bnote_address', 'zipcode', 'realname', 'mobile', 'brealname', 'bmobile', 'quantity', 'create_time', 'remark', 'condbuy', 'total_weight',);
				if ($flag = $table->update($insert)) {
					
					$order_id = abs(intval($table->id));			
						//insert cart detail
						foreach($carts as $key=>$addcart){
							$tborder  = new Table('order_detail', null);
							$tborder->SetPk('id', null);
							$tborder->order_id = $order_id;
							$tborder->team_id = $key;
							$tborder->short_title = $addcart['short_title'];
							$tborder->quantity = $addcart['quantity'];
							$tborder->team_price = $addcart['team_price'];
							$tborder->update(array('order_id','team_id','short_title','quantity','team_price'));
						}
						//end insert cart detail
				}
				
				Session::Set('notice', 'Đặt hàng thành công, chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất!.');
				redirect(WEB_ROOT  . "/index.php");
				//end insert new order
				//end order deal
			
			} else {			
				$au = Table::Fetch('user', $enc->encrypt(ZUser::SECRET_KEY, $_POST['email']), 'email');			
				if ($au) {
					Session::Set('error', 'Email này đã được đăng ký tài khoản trên '.$INI['system']['sitename'].'. Nếu bạn quên mật khẩu vui lòng click <a href="/account/repass.php">vào đây</a> để lấy lại mật khẩu');
				} else {
					Session::Set('error', 'Tên đăng nhập đã được đăng ký.');
				}
			}
			//end register new user
			
		}else{
			Session::Set('error', 'Mật khẩu không hợp lệ');
		}

	}else{
		//process user login
		
		//begin order deal
				//begin insert new order
					$totalquantity = 0;
					$totalprice = 0;
					$team_id = 0;
					foreach($carts as $key=>$cart){
						$totalquantity =  $totalquantity +  abs(intval($cart['quantity']));
						$totalprice = $totalprice + ($cart['quantity'] * $cart['team_price']);
						$team_id = $key;
					}
					$table = new Table('order', $_POST);
					$table->SetPk('id', null);
					$table->quantity = $totalquantity;
					$table->user_id = $login_user['id'];
					$table->realname = $_POST['realname'];
					$table->state = 'unpay';
					if($team_id > 0){
						$table->team_id = $team_id;
					}
					if(isset($_POST['city_id'])){
						$table->city_id = $_POST['city_id'];
					}else{
						$table->city_id = $login_user['city_id'];
					}
					$table->express = 'Y';
					$table->fare = 0;
					$table->price = $totalprice;
					$table->credit = 0;
					
					$table->create_time = time();
					$table->origin = $totalprice; // team_origin($team, $table->quantity);
		
				
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
				
					$table->total_weight = 0;
					
					
					
				//	print_r($table);
				
				$insert = array('user_id', 'team_id', 'city_id', 'dist_id', 'ward_id', 'house_number', 'street_name', 'bcity_id', 'bdist_id', 'bward_id', 'bhouse_number', 'bstreet_name', 'state', 'fare', 'express', 'origin', 'price', 'address', 'note_address', 'baddress', 'bnote_address', 'zipcode', 'realname', 'mobile', 'brealname', 'bmobile', 'quantity', 'create_time', 'remark', 'condbuy', 'total_weight',);
				if ($flag = $table->update($insert)) {
					
					$order_id = abs(intval($table->id));			
						//insert cart detail
						foreach($carts as $key=>$addcart){
							$tborder  = new Table('order_detail', null);
							$tborder->SetPk('id', null);
							$tborder->order_id = $order_id;
							$tborder->team_id = $key;
							$tborder->short_title = $addcart['short_title'];
							$tborder->quantity = $addcart['quantity'];
							$tborder->team_price = $addcart['team_price'];
							$tborder->update(array('order_id','team_id','short_title','quantity','team_price'));
						}
						//end insert cart detail
				}
				
				Session::Set('notice', 'Đặt hàng thành công, chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất!.');
				redirect(WEB_ROOT  . "/index.php");
				//end insert new order
				//end order deal
	}
} */
if(!empty($login_user)){

	/*    */
	
if(!Session::Get('customerinfo')){
	
	
	$city = id_city($login_user['city_id']);
	$dist = ename_dist($login_user['dist_id']);
	$wardname = wardname($login_user['dist_id'],$login_user['ward_id']);
	
	$city_name = $city['name'];
	$dist_name = $dist['dist_name'];
	$ward_name = $wardname['ward_name'];
	
	$uinfo = array(
		'realname'=>$login_user['realname'],
		'city_id'=>$login_user['city_id'],
		'city_name'=>$city_name,
		'dist_id'=>$login_user['dist_id'],
		'dist_name'=>$dist_name,
		'ward_id'=>$login_user['ward_id'],
		'ward_name'=>$ward_name,
		'house_number'=>$login_user['house_number'],
		'street_name'=>$login_user['street_name'],
		'note_address'=>$login_user['note_address'],
		'mobile'=>$login_user['mobile'],
		'cus_address'=>$login_user['address'],
	);
	Session::Set('customerinfo',$uinfo);
}
	
}
include template('team_checkout');