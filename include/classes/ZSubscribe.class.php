<?php
class ZSubscribe
{
	static public function Create($email, $city_id) 
	{
		global $enc;
		if (!Utility::ValidEmail($email, true)) return;
		
		$email = $enc->encrypt(ZUser::SECRET_KEY, $email);
		
		$secret = md5($email . $city_id);
		$table = new Table('subscribe', array(
					'email' => $email,
					'city_id' => $city_id,
					'secret' => $secret,
					));
		//Van Add
		$condition['email'] = $email;
		$condition['city_id'] = $city_id;
		$count = Table::Count('subscribe', $condition);
		//End
	
		if($count>0){
			Table::Delete('subscribe', $email, 'email');
		}
		$table->insert(array('email', 'city_id', 'secret'));
		//var_dump(DB::$mError);exit;
		/*
		if($count==0){
			$table->insert(array('email', 'city_id', 'secret'));
		}
		*/
	}

	static public function Unsubscribe($subscribe) {
		//Table::Delete('subscribe', $subscribe['email'], 'email');
                //HOC EDIT 29/07/2011
                    $unsubscribe       =  1;
                    $unsubscribe_time  =  date("Y:m:d H:m:s");
                    $unsubscribe_ip    =  isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

                    DB::Query("UPDATE subscribe SET unsubscribe='1',unsubscribe_time='{$unsubscribe_time}',unsubscribe_ip='{$unsubscribe_ip}' WHERE email='{$subscribe['email']}'");

	}
}
