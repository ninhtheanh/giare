<?php
# Logging in with Google accounts requires setting special identity, so this example shows how to do it.
require_once(dirname(dirname(__FILE__)) . '/app.php');
require 'openid.php';
try {
    $openid = new LightOpenID;
    if(!$openid->mode) {
        if(isset($_GET['login'])) {
            $openid->identity = 'https://www.google.com/accounts/o8/id';
            $openid->required = array('namePerson/friendly', 'contact/email', 'birthDate', 'person/gender'); 
			header('Location: ' . $openid->authUrl());
        }
    }elseif($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    }else {
		$uu = $openid->getAttributes();
		if($uu){
			$login_user = ZUser::GetUserByGoogle_IdMail('yes',$uu['contact/email']);
			if($login_user) {
				if($login_user['is_google']=='no') {
					//update
					$sql = "UPDATE `user` SET is_google = 'yes' WHERE id ='".$login_user['id']."'";
					mysql_query($sql);
					//login
					Session::Set('user_id', $login_user['id']);
					ZLogin::Remember($login_user);
					($goto = Session::Get('loginpage', true)) || ($goto = WEB_ROOT.'/index.php');
					echo '<script type="text/javascript" language="javascript">window.close();window.opener.location="'.$goto.'";</script>';
					//Utility::Redirect($goto);
				} else {
					Session::Set('user_id', $login_user['id']);
					ZLogin::Remember($login_user);
					($goto = Session::Get('loginpage', true)) || ($goto = WEB_ROOT.'/index.php');
					echo '<script type="text/javascript" language="javascript">window.close();window.opener.location="'.$goto.'";</script>';
					//Utility::Redirect($goto);
			}
			} else {
				$u['realname'] = $uu['namePerson/friendly'];
				$u['email'] = $uu['contact/email'];
				$u['gender'] = $uu['person/gender'];
				$_SESSION['GOOGLE_USER_LOGIN'] = $u;
				$openid->returnUrl = WEB_ROOT .'/account/signupgoogle.php';
				echo '<script type="text/javascript" language="javascript">window.close();window.opener.location="'.$openid->returnUrl.'";</script>';
			}
		}
		//header('Location: ' . $openid->returnUrl);
		//Utility::Redirect( WEB_ROOT . '/account/signupemail.php');
    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}