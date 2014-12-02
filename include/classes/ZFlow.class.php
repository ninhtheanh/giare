<?php
class ZFlow {
	static public function CreateFromOrder($order) {
		if ( $order['credit'] == 0 ) return 0;

		//update user money;
		$user = Table::Fetch('user', $order['user_id']);
		Table::UpdateCache('user', $order['user_id'], array(
					'money' => array( "money - {$order['credit']}" ),
					));

		$u = array(
				'user_id' => $order['user_id'],
				'money' => $order['credit'],
				'direction' => 'expense',
				'action' => 'buy',
				'detail_id' => $order['team_id'],
				'create_time' => time(),
				);
		$q = DB::Insert('flow', $u);
	}

	static public function CreateFromCoupon($coupon) {
		if ( $coupon['credit'] <= 0 ) return 0;

		//update user money;
		$user = Table::Fetch('user', $coupon['user_id']);
		Table::UpdateCache('user', $coupon['user_id'], array(
					'money' => array( "money + {$coupon['credit']}" ),
					));

		$u = array(
				'user_id' => $coupon['user_id'],
				'money' => $coupon['credit'],
				'direction' => 'income',
				'action' => 'coupon',
				'detail_id' => $coupon['id'],
				'create_time' => time(),
				);
		return DB::Insert('flow', $u);
	}

	static public function CreateFromRefund($order) {
		global $login_user_id;
		if ( $order['state']!='pay' || $order['origin']<=0 ) return 0;

		//update user money;
		$user = Table::Fetch('user', $order['user_id']);
		Table::UpdateCache('user', $order['user_id'], array(
					'money' => array( "money + {$order['origin']}" ),
					));

		//update order
		Table::UpdateCache('order', $order['id'], array('state'=>'unpay'));

		$u = array(
				'user_id' => $order['user_id'],
				'admin_id' => $login_user_id,
				'money' => $order['origin'],
				'direction' => 'income',
				'action' => 'refund',
				'detail_id' => $order['team_id'],
				'create_time' => time(),
				);
		return DB::Insert('flow', $u);
	}

	static public function CreateFromInvite($invite) {
		global $login_user_id;
		if ( $invite['pay']!='Y' && $INI['system']['invitecredit']<=0 ) return 0;

		//update user money;
		$user = Table::Fetch('user', $invite['user_id']);
		Table::UpdateCache('user', $invite['user_id'], array(
					'money' => array( "money + {$invite['credit']}" ),
					));

		$u = array(
				'user_id' => $invite['user_id'],
				'admin_id' => $login_user_id,
				'money' => $invite['credit'],
				'direction' => 'income',
				'action' => 'invite',
				'detail_id' => $invite['other_user_id'],
				'create_time' => $invite['buy_time'],
				);
		return DB::Insert('flow', $u);
	}
	
	static public function CreateFromAff($aff) {
		global $INI, $login_user_id;		
		
		if ( $aff['pay']==0 && $INI['credit']['aff']<=0 ) return 0;

		//update user money;
		$user = Table::Fetch('user', $aff['pid']);
		Table::UpdateCache('user', $aff['pid'], array(
					'money' => array( "money + {$aff['credit']}" ),
					));

		$u = array(
				'user_id' => $aff['pid'],
				'admin_id' => $login_user_id,
				'money' => $aff['credit'],
				'direction' => 'income',
				'action' => 'aff',
				'detail_id' => $aff['buy_tid'],
				'create_time' => strtotime($aff['buy_time']),
				);
		return DB::Insert('flow', $u);
	}

	static public function CreateFromStore($user_id=0, $money=0) {
		global $login_user_id;
		$money = floatval($money);
		if ( $money == 0 || $user_id <= 0)  return;

		//update user money;
		$user = Table::Fetch('user', $user_id);
		Table::UpdateCache('user', $user_id, array(
					'money' => array( "money + {$money}" ),
					));

		/* switch store|withdraw */
		$direction = ($money>0) ? 'income' : 'expense';
		$action = ($money>0) ? 'store' : 'withdraw';
		$money = abs($money);
		/* end swtich */

		$u = array(
				'user_id' => $user_id,
				'admin_id' => $login_user_id,
				'money' => $money,
				'direction' => $direction,
				'action' => $action,
				'detail_id' => 0,
				'create_time' => time(),
				);
		return DB::Insert('flow', $u);
	}

	static public function CreateFromCharge($money,$user_id,$time,$service='alipay'){
		global $option_service;
		if (!$money || !$user_id || !$time) return 0;
		$pay_id = "charge-{$user_id}-{$time}";
		$pay = Table::Fetch('pay', $pay_id);
		if ( $pay ) return 0;
		$order_id = ZOrder::CreateFromCharge($money,$user_id,$time,$service);
		if (!$order_id) return 0;

		//insert pay record
		$pay = array(
			'id' => $pay_id,
			'order_id' => $order_id,
			'bank' => $option_service[$service],
			'currency' => 'CNY',
			'money' => $money,
			'service' => $service,
			'create_time' => $time,
		);
		DB::Insert('pay', $pay);
		//end//

		//update user money;
		$user = Table::Fetch('user', $user_id);
		Table::UpdateCache('user', $user_id, array(
					'money' => array( "money + {$money}" ),
					));

		$u = array(
				'user_id' => $user_id,
				'admin_id' => 0,
				'money' => $money,
				'direction' => 'income',
				'action' => 'charge',
				'detail_id' => $pay_id,
				'create_time' => $time,
				);
		return DB::Insert('flow', $u);
	}

	static public function Explain($record=array()) {
		if (!$record) return null;
		$action = $record['action'];
		if ('buy' == $action) {
			$team = Table::Fetch('team', $record['detail_id']);
			if ($team) {
				return  "Mua hàng - <a href=\"/team.php?id={$team['id']}\">{$team['title']}</a>";
			} else {
				return "Mua hàng - Sản phẩm này đã bị xóa";
			}
		}
		else if ( 'invite' == $action) {
			$user = Table::Fetch('user', $record['user_id']);
			return "Tiền thưởng mời bạn bè cho tài khoản friend{$user['username']}";
		}
		else if ( 'aff' == $action) {
			$user = Table::Fetch('user', $record['user_id']);	
			$team = Table::Fetch('team', $record['detail_id']);					
			return "Tiền thưởng liên kết bán hàng cho {$user['username']} - <a href=\"/team.php?id={$team['id']}\">{$team['title']}</a>";
		}
		else if ( 'store' == $action) {
			return 'Nạp tiền';
		}
		else if ( 'withdraw' == $action) {
			return 'Rút tiền';
		}
		else if ( 'coupon' == $action) {
			return "Thưởng mua hàng - Thưởng cho thẻ giảm giá";
		}
		else if ( 'refund' == $action) {
			$team = Table::Fetch('team', $record['detail_id']);
			if ($team) {
				return  "Chính sách hoàn trả tiền - <a href=\"/team.php?id={$team['id']}\">{$team['title']}</a>";
			} else {
				return "Trả lại tiền hàng - Sản phẩm đã bị xóa";
			}
		}
		else if ( 'charge' == $action) {
			return "Nạp tiền trực tuyến";
		}
		else if ( 'register' == $action) {
			return "Đăng ký để nhận tiền";
		}
	}
}
?>
