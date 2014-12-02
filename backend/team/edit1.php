<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
require_once(dirname(__FILE__) . '/current.php');

need_manager();
need_auth('team');

$id = abs(intval($_GET['id']));
$team = $eteam = Table::Fetch('team', $id);



if ( is_get() && empty($team) ) {
	$team = array();
	$team['id'] = 0;
	$team['user_id'] = $login_user_id;
	$team['begin_time'] = strtotime('+0 days');
	$team['end_time'] = strtotime('+7 days'); 
	$team['expire_time'] = strtotime('+3 months +1 days');
	$team['min_number'] = 10;
	$team['per_number'] = 0;
	$team['market_price'] = 1;
	$team['team_price'] = 1;
	$team['delivery'] = 'express';
	$team['address'] = $profile['address'];
	$team['mobile'] = $profile['mobile'];
	$team['fare'] = 5;
	$team['farefree'] = 0;
	$team['weight'] = 500;
	$team['bonus'] = abs(intval($INI['system']['invitecredit']));
	$team['conduser'] = $INI['system']['conduser'] ? 'Y' : 'N';
	$team['buyonce'] = 'N';
	$team['virtual_buy'] = 0;
	$team['short_title'] = $team['product'];
}
else if ( is_post() ) {
	$team = $_POST;
	$insert = array(
		'title', 'masp', 'short_title', 'market_price', 'team_price', 'end_time', 
		'begin_time', 'expire_time', 'min_number', 'max_number', 
		'summary', 'notice', 'per_number', 'product', 
		'image', 'image1', 'image2', 'image3', 'image4', 'image5', 'image6', 'image7', 'flv', 'now_number',
		'detail', 'userreview', 'card', 'systemreview', 
		'conduser', 'buyonce', 'bonus', 'sort_order',
		'delivery', 'mobile', 'address', 'fare', 
		'express', 'credit', 'farefree', 'pre_number',
		'user_id', 'city_id', 'group_id', 'partner_id',
		'team_type', 'sort_order', 'farefree', 'state',
		'condbuy', 'aff_rebate', 'weight', 'delivery_properties', 'number_of_contracts', 'sale', 'virtual_buy',
	);
	

	$team['user_id'] = $login_user_id;
	$team['state'] = 'none';
	$team['begin_time'] = strtotime($team['begin_time']);
	$team['city_id'] = abs(intval($team['city_id']));
	$team['partner_id'] = abs(intval($team['partner_id']));
	$team['sort_order'] = abs(intval($team['sort_order']));
	$team['fare'] = abs(intval($team['fare']));
	$team['farefree'] = abs(intval($team['farefree']));
	$team['pre_number'] = abs(intval($team['pre_number']));
	$team['end_time'] = strtotime($team['end_time']);
	$team['expire_time'] = strtotime($team['expire_time']);
	$team['virtual_buy'] = abs(intval($team['virtual_buy']));

	$team['image'] = upload_image('upload_image',$eteam['image'],'team');
	
	$team['image1'] = upload_image('upload_image1',$eteam['image1'],'team');
	$team['image2'] = upload_image('upload_image2',$eteam['image2'],'team');
	$team['image3'] = upload_image('upload_image3',$eteam['image3'],'team');
	$team['image4'] = upload_image('upload_image4',$eteam['image4'],'team');
	$team['image5'] = upload_image('upload_image5',$eteam['image5'],'team');
	$team['image6'] = upload_image('upload_image6',$eteam['image6'],'team');
	$team['image7'] = upload_image('upload_image7',$eteam['image7'],'team');
//	var_dump(upload_image('upload_image1',$eteam['image1'],'team'));
//	break;
	//team_type == goods
	if($team['team_type'] == 'goods'){ 
		$team['min_number'] = 1; 
		$tean['conduser'] = 'N';
	}

	if ( !$id ) {
		$team['now_number'] = $team['pre_number'];
	} else {
		$field = strtoupper($table->conduser)=='Y' ? null : 'quantity';
		$now_number = Table::Count('order', array(
					'team_id' => $id,
					/*'state' => 'pay',*/
					), $field);
		if($now_number>$team['now_number']){
			$team['now_number'] = ($now_number + $team['pre_number']);
		}

		/* Increased the total number of state is not sold out */
		if ( $team['max_number'] > $team['now_number'] ) {
			$team['close_time'] = 0;
			$insert[] = 'close_time';
		}
	}

	$insert = array_unique($insert);
	$table = new Table('team', $team);

	$table->SetStrip('summary', 'detail', 'systemreview', 'notice');
	

	if ( $team['id'] && $team['id'] == $id ) {
		$table->SetPk('id', $id);
		$table->Update($insert);
		Session::Set('notice', 'Information Successfully Modified!');
		redirect( WEB_ROOT . "/backend/team/index.php"); 
	} 
	else if ( $team['id'] ) {
		Session::Set('error', 'Illegal edition');
		redirect( WEB_ROOT . "/backend/team/index.php"); 
	}

	if ( $table->insert($insert) ) {
		
		 $atinsert =  array(
			'user_id', 'title', 'masp', 'parent_id', 'content', 'last_time', 'create_time',
			'city_id', 'team_id', 'public_id', 'status','topic_ip',
		);

		Session::Set('notice', 'New Project Success');
		redirect( WEB_ROOT . "/backend/team/index.php"); 
	}
	else {
		Session::Set('error', 'Edit project failure');
		redirect(null);
	}
}

$groups = DB::LimitQuery('category', array(
			'condition' => array( 'zone' => 'group', ),
			));
$groups = Utility::OptionArray($groups, 'id', 'name');

$partners = DB::LimitQuery('partner', array(
			'order' => 'ORDER BY id DESC',
			));
$partners = Utility::OptionArray($partners, 'id', 'masp', 'title' );
$selector = $team['id'] ? 'edit' : 'create';


include template('manage_team_edit');