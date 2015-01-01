<?php  
require_once(dirname(dirname(__FILE__)) . '/app.php');

$atact = '';
if($_POST){
$atact =  $_POST['atact'];
}
if($_GET){
	if(isset($_GET['getdatastep'])){
		$atact = $_GET['getdatastep'];
	}
}

switch($atact)
{
	case "inforec":
	
	$realname = $_POST['realname'];
	$city_id = $_POST['city_id'];
	$dist_id = $_POST['dist_id'];
	$ward_id = $_POST['ward_id'];
	$house_number = $_POST['house_number'];
	$street_name = $_POST['street_name'];
	$note_address = $_POST['note_address'];
	$mobile = $_POST['mobile'];
	
	$city = id_city($city_id);
	$dist = ename_dist($dist_id);
	$wardname = wardname($dist['dist_id'],$ward_id);
	
	$city_name = $city['name'];
	$dist_name = $dist['dist_name'];
	$ward_name = $wardname['ward_name'];
	
	
	$cus_address = rtrim($house_number.','.$street_name.','.$ward_name.','.$dist_name.','.$city_name); 
	if($note_address != '')
	{
		$cus_address .= ' ( '.$note_address .' )';
	}
	
//	echo $cus_address;
	
	$uinfo = array(
		'realname'=>$realname,
		'city_id'=>$city_id,
		'city_name'=>$city_name,
		'dist_id'=>$dist_id,
		'dist_name'=>$dist_name,
		'ward_id'=>$ward_id,
		'ward_name'=>$ward_name,
		'house_number'=>$house_number,
		'street_name'=>$street_name,
		'note_address'=>$note_address,
		'mobile'=>$mobile,
		'cus_address'=>$cus_address,
	);
	
	Session::Set('customerinfo',$uinfo);
	if(!empty($login_user)){
		$uid = $login_user['id'] ;
		$k = DB::Query("UPDATE user SET city_id = $city_id, dist_id = $dist_id, ward_id = $ward_id, house_number = '{$house_number}', street_name = '{$street_name}', mobile = '{$mobile}' WHERE id = $uid");
	}
	
	$html = '';
	
	if($city_id == 11){
		//HCM city
	//	$html = render('atajax_transfer_hcm');
		 
	}else{
		//other
		
		//$html = render('atajax_transfer');
	}
	
	$html = render('atajax_transfer');
	
	$json = array(
			'error'=>0,
			'name'=>$realname,
			'address'=>$cus_address,
			'phone'=>$mobile,
			'html'=>$html,
		);
		
		echo json_encode($json);
	break;
	case "paymenttransfer":
		
		$setpayment = array();		
		$arr = array('error'=>0);
		if($_POST){
			$methods = $_POST['methods'];
			$payment = $methods['payment'];
			$shipping = $methods['shipping'];
			
			$payment = $payment > 0 ? $payment : 1;
			
			$arr['payment'] = $setpayment['payment'] = $payment;
			$arr['shipping'] = $setpayment['shipping'] = $shipping;		
		}else{
			$arr = array('error'=>1);
		}			
		Session::Set('paymentshipping',$setpayment);	
				
		$html = '';	
		$dbpayment = DB::LimitQuery('payment_descriptions', array(
			'condition' => array('status'=>'A', 'payment_id'=>$arr['payment']),
			'one' => true,
		));
		if($dbpayment)
			$html .='<div style="with:40%;float:left"><b>'.$dbpayment['payment'].'</b></div>';
		$dbshipping = DB::LimitQuery('shippings', array(
			'condition' => array('status'=>'A', 'shipping_id'=>$arr['shipping']),
			'one' => true,
		));
		if($dbshipping)
			$html .= '<div style="with:40%;float:right;margin-right:80px"><b>'.$dbshipping['shipping_name'].'</b></div>';		
		$html .='<div style="clear:both"></div>';		
		$arr['html'] = $html;
		echo json_encode($arr);
		
	break;
	case "finish":
		$carts = Session::Get('carts');	
		$infotransfer = Session::Get('customerinfo');
		
		$arr = (array)Session::Get('colorteam');
		
		$cl = '';
		
		foreach($carts as $key=>$cat){
			if(isset($arr[$key])){
				$cl .='Sản phẩm: '.$cat['short_title'].' ( Chọn Màu: ' . str_replace("customize:", "", $arr[$key]) . ' ) ;';		
			}
		}
		
		echo  render('atcart_finish');
		//*  atcart_finish  */
	break;
	case "endstep4":
		$respon = array('error'=>0,'msg'=>'Quá trình đặt hàng thành công');
		$msg = '';
		$remark = '';
		if($_POST)
		{
			$remark = $_POST['remark'];  // ghi chu yeu cau them
		}
		
		$carts = (array)Session::Get('carts');	
		$userinfo = (array)Session::Get('customerinfo');
		$paymentshipping = (array)Session::Get('paymentshipping');
		
		$_countquantity  = 0;
		$_titleproduct = '';
		$_totalpriceproduct = 0;
		foreach($carts as $key=>$ord)
		{
			$_titleproduct .= $ord['short_title'].' || ';
			$_countquantity += $ord['quantity'];
			$_totalpriceproduct += $ord['quantity']*$ord['team_price'];
		}
		

	if(count($carts)){
			
		$ologs  = new Table('order_logs', null);
		$ologs->SetPk('id', null);
		$ologs->carts = json_encode($carts);
		$ologs->userinfos = json_encode($userinfo);
		$ologs->shippings = json_encode($paymentshipping);
		$ologs->producttitle = $_titleproduct;
		$ologs->countproduct = count($carts);
		$ologs->countquantity = $_countquantity;
		$ologs->totalprices = $_totalpriceproduct;
		$ologs->note = $remark;
		$ologs->user_id = $login_user['id'];
		$ologs->update(array('carts','userinfos','shippings','producttitle','countproduct','countquantity','totalprices','note','user_id'));
		if($ologs->id){
			$idlogs = $ologs->id;
			
			Session::Set('idcarlog',$idlogs);
			//order_group
			//insert all order
			//DB::$mDebug=true;
			foreach($carts as $key=>$order){
				$team = Table::FetchForce('team', abs(intval($order['id'])));
				
		 		$table = new Table('order', null);
				$table->SetPk('id', null);
				$table->order_group = $idlogs;
				$table->quantity = abs(intval($order['quantity']));
				$table->state = 'unpay';
				$table->user_id = $login_user_id;
				$table->realname = $userinfo['realname'];
				$table->state = 'unpay';
				$table->team_id = $order['id'];
				$table->city_id = $userinfo['city_id'];
				//
				$table->color = $order['color'];
				$table->size = $order['size'];
				//
				
				$table->express = ($team['delivery']=='express') ? 'Y' : 'N';
				$table->fare = $table->express=='Y' ? $team['fare'] : 0;
				$table->price = $order['team_price'];
				$table->credit = 0;
				$table->create_time = time();
				$table->origin = team_origin($team, $table->quantity);
				$table->address = $table->house_number." ".$table->street_name;
				
				$table->brealname = $userinfo['realname'];
				$table->dist_id = $userinfo['dist_id'];
				$table->ward_id = $userinfo['ward_id'];
				$table->mobile = $userinfo['mobile'];
				$table->note_address = $userinfo['note_address'];
				$table->house_number =		$userinfo['house_number'];
				$table->street_name =	 	$userinfo['street_name'];
				$table->address = $table->house_number." ".$table->street_name;
				
				
				$table->bcity_id =  $table->city_id;
				$table->bdist_id = $table->dist_id;
				$table->bward_id = $table->ward_id;
				
				$table->bhouse_number =	 	$userinfo['house_number'];
				$table->bstreet_name =	 	$userinfo['street_name'];
				$table->bnote_address =		$userinfo['note_address'];
				$table->bmobile = $userinfo['mobile'];
				$table->baddress = $table->bhouse_number." ".$table->bstreet_name;
				
				if((int)$team['weight']==0){
					$team['weight'] = 100;	
				}
				$table->total_weight = $team['weight']*$table->quantity;
				
				
				$table->shipping_id = $paymentshipping['shipping'];
				$table->payment_id = $paymentshipping['payment'];
				
				$dbpayment = DB::LimitQuery('payment_descriptions', array(
								'condition' => array('status'=>'A', 'payment_id'=>$paymentshipping['payment']),
								'one' => true,
							));
				  if($dbpayment){
					  $table->payment_cost = $dbpayment['adding_cost'];
				  }				
				$table->notes = $remark;
                //Check promotion
                $sql = "Select promotion_category.id, promotion_name, promotion_type, promotion_value From promotion_category, promotion_product 
                Where promotion_category.id = promotion_product.id_promotion_category And promotion_category.start_time <= CURDATE() And promotion_category.end_time >= CURDATE() 
                And promotion_category.activate = 1 And promotion_product.id_product = '" . $order['id'] . "' LIMIT 0, 1;";                
                $promotion_category = DB::GetQueryResult($sql);
                if(count($promotion_category) > 0)
                {
                    $id_promotion_category = $promotion_category['id'];
                    $promotion_name = $promotion_category['promotion_name'];
                    $promotion_type = $promotion_category['promotion_type'];
                    $promotion_value = $promotion_category['promotion_value'];    
                } 
                else
                {
                    $id_promotion_category = 0;
                    $promotion_name = "";
                    $promotion_type = 0;
                    $promotion_value = 0;
                }
                $table->id_promotion_category = $id_promotion_category;
                $table->promotion_name = $promotion_name;
                $table->promotion_type = $promotion_type;
                $table->promotion_value = $promotion_value;               
                //Check promotion End
				$insert = array('order_group','user_id', 'team_id', 'city_id', 'dist_id', 'ward_id', 'house_number', 'street_name', 'bcity_id', 'bdist_id', 'bward_id', 'bhouse_number', 'bstreet_name', 'state', 'fare', 'express', 'origin', 'price', 'address', 'note_address', 'baddress', 'bnote_address', 'zipcode', 'realname', 'mobile', 'brealname', 'bmobile', 'quantity', 'create_time', 'remark', 'condbuy', 'total_weight','shipping_id','payment_id','notes','color','size','id_promotion_category','promotion_name','promotion_type','promotion_value');
				
				if ($table->update($insert)) {
					
					$respon['error'] = 0;
					$msg .='Save success :'.$table->id.' , ';
					//success
				}
				
				
			} //end insert all order
			
			//set empty carts
			Session::Set('carts',null);	
		}
		else{
			//error log cart order
			$respon['error'] = 1;
			$respon['msg'] = 'Lỗi quá trình đặt hàng vui lòng thực hiện lại.';
		}
		
	}else{
		$respon['error'] = 2;
		$respon['msg'] = 'Lỗi giỏ hàng không có sản phẩm';
	}
	
	echo json_encode($respon);

//begin insert new order
	/* 				$totalquantity = 0;
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
					$table->realname = $userinfo['realname'];
					$table->state = 'unpay';
					if($team_id > 0){
						$table->team_id = $team_id;
					}
					
					$table->city_id = $userinfo['city_id'];
					
					
					$table->express = 'Y';
					$table->fare = 0;
					$table->price = $totalprice;
					$table->credit = 0;
					
					$table->create_time = time();
					$table->origin = $totalprice; // team_origin($team, $table->quantity);
		
				
					$table->brealname = $userinfo['realname'];
			
					$table->dist_id = $userinfo['dist_id'];
					$table->ward_id = $userinfo['ward_id'];
					$table->mobile = $userinfo['mobile'];
					$table->note_address = $userinfo['note_address'];
					$table->house_number =		$userinfo['house_number'];
					$table->street_name =	 	$userinfo['street_name'];
					$table->address = $table->house_number." ".$table->street_name;
					
					
					$table->bcity_id = ($_POST['bcity_id']) ? $_POST['bcity_id'] : $table->city_id;
					$table->bdist_id = ($_POST['bdist_id']) ? $_POST['bdist_id'] : $table->dist_id;
					$table->bward_id = ($_POST['bward_id']) ? $_POST['bward_id'] : $table->ward_id;
					
					$table->bhouse_number =	 	$userinfo['house_number'];
					$table->bstreet_name =	 	$userinfo['street_name'];
					$table->bnote_address =		$userinfo['note_address'];
					$table->bmobile = $userinfo['mobile'];
					$table->baddress = $table->bhouse_number." ".$table->bstreet_name;
				
					$table->total_weight = 0;
					
					$table->shipping_id = $paymentshipping['shipping'];
					$table->payment_id = $paymentshipping['payment'];
					
					if($table->city_id != 11){
						$table->shipping_cost = 0;
					}
					
				//	$table->payment_cost = 0;
					
					  $dbpayment = DB::LimitQuery('payment_descriptions', array(
								'condition' => array('status'=>'A', 'payment_id'=>$paymentshipping['payment']),
								'one' => true,
							));
					if($dbpayment){
						$table->payment_cost = $dbpayment['adding_cost'];
					}

					
				//	print_r($table);
				
				$insert = array('user_id', 'team_id', 'city_id', 'dist_id', 'ward_id', 'house_number', 'street_name', 'bcity_id', 'bdist_id', 'bward_id', 'bhouse_number', 'bstreet_name', 'state', 'fare', 'express', 'origin', 'price', 'address', 'note_address', 'baddress', 'bnote_address', 'zipcode', 'realname', 'mobile', 'brealname', 'bmobile', 'quantity', 'create_time', 'remark', 'condbuy', 'total_weight','shipping_cost','payment_cost','shipping_id','payment_id',);
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
		//		redirect(WEB_ROOT  . "/index.php");
				//end insert new order
				//end order deal
		
		
		
		$arr = array('error'=>0,'msg'=>'Cảm ơn bạn đã đặt hàng thành công');
		Session::Set('carts',null);	
		echo json_encode($arr);
		 */
//end insert order to database
		
	break;
	case "cretaeuser":
		$arr = array();
		$u = array();
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
		//	Session::Set('error', 'Địa chỉ email không hợp lệ');
		//	redirect( WEB_ROOT . '/account/signup.php?ref='.$ref);
			$arr['error'] = 1;
			$arr['msg'] = 'Địa chỉ email không hợp lệ';
			
			echo json_encode($arr);
			return;
		}
		if (strlen(trim($_POST['password']))>6 && $_POST['password']) {
			if ( option_yes('emailverify') ) { 
				$u['enable'] = 'Y'; 
			}
			
			//register new user
			if ( $user_id = ZUser::Create($u) ) {
				
				//login user
				ZLogin::Login($user_id);
				
				$arr['error'] = 0;
					$arr['msg'] =  'Đã lưu tài khoản thành công';
				echo json_encode($arr);
				return;
				
			} else {			
				$au = Table::Fetch('user', $enc->encrypt(ZUser::SECRET_KEY, $_POST['email']), 'email');			
				if ($au) {
					//Session::Set('error', 'Email này đã được đăng ký tài khoản trên '.$INI['system']['sitename'].'. Nếu bạn quên mật khẩu vui lòng click <a href="/account/repass.php">vào đây</a> để lấy lại mật khẩu');
					
					$arr['error'] = 1;
					$arr['msg'] =  'Email này đã được đăng ký tài khoản trên '.$INI['system']['sitename'].' Nếu bạn quên mật khẩu vui lòng click vào mục quên mật khẩu để được cấp lại';
					
					echo json_encode($arr);
					return;
					
				} else {
					//Session::Set('error', 'Tên đăng nhập đã được đăng ký.');
					$arr['error'] = 1;
					$arr['msg'] =  'Email này đã được đăng ký tài khoản trên '.$INI['system']['sitename'].' Nếu bạn quên mật khẩu vui lòng click vào mục quên mật khẩu để được cấp lại';
					
					echo json_encode($arr);
					return;
				}
			}
			//end register new user
			
		}else{
			Session::Set('error', 'Mật khẩu không hợp lệ');
			
			$arr['error'] = 1;
			$arr['msg'] = 'Mật khẩu không hợp lệ ( mật khẩu ít nhất phải 6 ký tự )';
			
			echo json_encode($arr);
			return;
			
		}
		
		
	break;
	case "setcolor":
		$id = $_GET['team_id'];
		$color = $_GET['color'];
		$arr = array();
		$arr[$id] = $color;
		Session::Set('colorteam',$arr);
		Session::Set('color_' . $id,$color);
		echo 'ok';
	break;
	case "setsize":
		$id = $_GET['team_id'];
		$size = $_GET['size'];
		$arr = array();
		$arr[$id . '_size'] = $size;
		//Session::Set('sizeteam',$arr);
		Session::Set('size_' . $id,$size);
		echo 'ok';
	break;
	case "set_color_size":
		$id = $_GET['team_id'];
		
		$color = $_GET['color'];
		$arr = array();
		$arr[$id] = $color;
		Session::Set('colorteam', $arr);
		Session::Set('color_' . $id, $color);
		
		$size = $_GET['size'];
		$arr = array();
		$arr[$id . '_size'] = $size;
		//Session::Set('sizeteam', $arr);
		Session::Set('size_' . $id, $size);
		echo 'ok';
	break;
	case "cartcount":
		$carts = Session::Get('carts');
		$atcarttotal = 0;
		if($carts != null && !empty($carts)){
			foreach($carts as $cart)
			{
				$atcarttotal += $cart['quantity'];
			}
		}
		echo $atcarttotal;
	break;
}
