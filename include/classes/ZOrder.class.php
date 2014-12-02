<?php
class ZOrder {
	static public function OnlineIt($order_id, $pay_id, $money, $currency='CNY', $service='alipay', $bank='支付宝'){ 
		list($_, $_, $quantity, $_) = explode('-', $pay_id);
		if (!$order_id || !$pay_id || $money <= 0 ) return false;
		$order = Table::Fetch('order', $order_id);
		if ( $order['state'] == 'unpay' ) {
			Table::UpdateCache('order', $order_id, array(
				'pay_id' => $pay_id,
				'money' => $money,
				'state' => 'pay',
				'service' => $service,
				'quantity' => $quantity,
				'pay_time' => time(),
			));
			$order = Table::FetchForce('order', $order_id);
			if ( $order['state'] == 'pay' ) {
				$table = new Table('pay');
				$table->id = $pay_id;
				$table->order_id = $order_id;
				$table->money = $money;
				$table->currency = $currency;
				$table->bank = $bank;
				$table->service = $service;
				$table->create_time = time();
				$table->insert( array('id', 'order_id', 'money', 'currency', 'service', 'create_time', 'bank') );
				
				//TeamBuy Operation
				ZTeam::BuyOne($order);
			}
		}
		return true;
	}

	static public function CashIt($order) {
		global $login_user_id;
		if (! $order['state']=='pay' ) return 0;

		//update order
		Table::UpdateCache('order', $order['id'], array(
			'state' => 'pay',
			'service' => 'cash',
			'admin_id' => $login_user_id,
			'money' => $order['origin'],
			'pay_time' => time(),
		));

		$order = Table::FetchForce('order', $order['id']);
		ZTeam::BuyOne($order);
	}

	static public function CreateFromCharge($money, $user_id, $time,$service) {
		if (!$money || !$user_id || !$time || !$service) return 0;
		$pay_id = "charge-{$user_id}-{$time}";
		$oarray = array(
			'user_id' => $user_id,
			'pay_id' => $pay_id,
			'service' => $service,
			'state' => 'pay',
			'money' => $money,
			'origin' => $money,
			'create_time' => $time,
		);
		return DB::Insert('order', $oarray);
	}
	
	static public function BuildAddStreet($order) {
	
		//fetch streets from table streets
		$st = DB::LimitQuery('streets', array(
			'select' => 'keyword,name',	
		));
		//loop through streets
		foreach($st as $v)
		{
			//check if this order address found in streets
			$rs = DB::LimitQuery('order', array(
				'select' => 'id',	
				'condition' => "id=".$order['id']." AND (address LIKE '%".$v['keyword']."%' OR address LIKE '%".$v['name']."%')"
			));
			
			if(!empty($rs))
			{
				foreach($rs as $vv)
				{			
					Table::UpdateCache('order', $vv['id'],array('add_street'=>$v['name']));
				}		
			}
			
		}
		Table::UpdateCache('order', $order_id, array(
				'add_street' => $add_street,
		));
	}
}
?>
