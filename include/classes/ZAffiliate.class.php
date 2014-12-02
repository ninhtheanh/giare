<?php
class ZAffiliate
{	
	static public function ___Rec($pid,$team_id) {	
		global $INI;	
		//$have = Table::Fetch('click', $pid, 'pid');	
		
		$cond = array( 
		'pid='.$pid, 
		'team_id='.$team_id, 
		"ip_click='".$_SERVER['REMOTE_ADDR']."'", 
		"domain_click='".$_SERVER['HTTP_REFERER']."'" 
		);
		$have = DB::LimitQuery('click', array(				
			'condition' => $cond,			
			'size' => 1
		));
		
		if ( $have ) 
		{
			return Table::UpdateCache('click', $have['id'], array(
			'time_click' => date('Y-m-d H:i:s',time()),			
			));
		
		}else{
			$aff = array(
			'api_key' => $pid,
			'pid' => $pid,
			'aid' => 0,
			'uid' => 0,			
			'team_id' => $team_id,
			'ip_click' => $_SERVER['REMOTE_ADDR'],
			'domain_click' => $_SERVER['HTTP_REFERER'],
			'time_click' => date('Y-m-d H:i:s',time()),
			'credit' => $INI['credit']['aff'],
			);
			//cookieset('_rid', null, -1);
			return DB::Insert('click', $aff);		
		}
		
	}
	
	static public function Create($pid,$tid,$ip,$dom,$time) {	
		global $INI;
	
		$aff = array(
		'api_key' => $pid,
		'pid' => $pid,
		'aid' => 0,
		'uid' => 0,			
		'team_id' => $tid,
		'ip_click' => $ip,
		'domain_click' => $dom,
		'time_click' => date('Y-m-d H:i:s',$time),
		'credit' => $INI['credit']['aff'],
		'pay' => $INI['credit']['aff'],
		'buy_ip' => $_SERVER['REMOTE_ADDR'],
		'buy_time' => date('Y-m-d H:i:s',time()),
		'credit' => $INI['credit']['aff'],
		);
		cookieset('_aff', NULL, -1);
		return DB::Insert('click', $aff);
		
	}

	//current working
	static public function Check($order,$team) {
		global $INI;	
		
		list($pid,$tid,$ip, $dom,$time) = @split('\|',cookieget('_aff'));
		//self::Create($pid,$tid,$ip, $dom,$time, $order['user_id'], $order['team_id']);
		
		//check invite vs aff, which is most recent
		$have = Table::Fetch('invite', $order['user_id'], 'other_user_id');	
		
		if($have['create_time']>$time) return;
		
		//if ( $order['state'] == 'unpay' ) return;
		$user = Table::Fetch('user', $order['user_id']);
		//$team = Table::Fetch('team', $order['team_id']);
		if ( !$user ) return;		
		
		
		$aff = array(
		'api_key' => $pid,
		'pid' => $pid,
		'aid' => 0,			
		'team_id' => $tid,
		'click_ip' => $ip,
		'click_domain' => $dom,
		'click_time' => date('Y-m-d H:i:s',$time),
		'buy_tid' => $order['team_id'],
		'buy_uid' => $order['user_id'],
		'buy_oid' => $order['id'],
		'buy_ip' => $_SERVER['REMOTE_ADDR'],
		'buy_time' => date('Y-m-d H:i:s',time()),
		'pay' => 0,
		//'credit' => floor($team['team_price'] * $team['aff_bonus'] / 100),	
		'credit' => floor($team['team_price'] * $INI['credit']['aff'] / 100),		
		);
		
		return DB::Insert('click', $aff);
		cookieset('_aff', NULL, -1);
		
		//$aff = Table::Fetch('click',$order['user_id'],'other_user_id');
		//$affcredit = abs(intval($team['bonus']));

		/* aff not recorded or rebate given or cancelled */
		/*if (!$aff || $aff['credit']>0 || $aff['pay']>0) {
			return;
		}
		if (time() - $aff['time_click'] > 7*86400) {
			return;
		}*/
		
		/*Table::UpdateCache('click', $aff['id'], array(
			//'credit' => $affcredit,
			'uid' => $order['user_id'],
			'team_id' => $order['team_id'],
			'ip_buy' => $_SERVER['REMOTE_ADDR'],
			'time_buy' => date('Y-m-d H:i:s',time()),
			'pay' => 1,
		));
		
		return true;*/
	}
}