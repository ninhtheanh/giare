<?php
require_once(dirname(__FILE__) . '/app.php');
$id = $_GET['id'];
$id_denine = array(53,768,311,1502,717,1513,1014,1493,1657);
if(in_array($id,$id_denine)){
	redirect("/404.html");
	exit();
}
if(isset($id)){
	DB::Query("UPDATE team SET viewed = viewed + 1 WHERE id = $id ");
    $id =  get_id_from_gid($id);
}

$ckey = 'detail'.$id;
$team = Table::FetchForce('team', $id);
if(!cookieget('city')){
	cookieset('city', $team['city_id']);
}



/* refer */
if(!$team){
	redirect( WEB_ROOT);
	exit();
}
if($team['begin_time']>time()){
	redirect( WEB_ROOT);
	exit();	
}

if($team['status'] != 'Y'){
	Session::Set('error','Sản phẩn đã xóa hoặc tắt tạm thời khỏi hệ thống.');
	redirect( WEB_ROOT);
	exit();	
}

if ($_rid = abs(intval($_GET['r']))) { 
	if($_rid) cookieset('_rid', abs(intval($_GET['r'])));
}
//affiliate
if ($_aff = abs(intval($_GET['utm_campaign']))) { 
	if($_aff) cookieset( '_aff', abs(intval($_aff)) . '|' . $id . '|' . $_SERVER['REMOTE_ADDR'] . '|' . $_SERVER['HTTP_REFERER'] . '|' . time(), 86400 * 3 );
}

$teamcity = Table::Fetch('category', $team['city_id']);
$city = $teamcity ? $teamcity : $city;
$city = $city ? $city : array('id'=>0, 'name'=>'All');

$pagetitle = $team['title'];

$discount_price = $team['market_price'] - $team['team_price'];
$discount_rate = team_discount($team);

$left = array();
$now = time();
if($team['end_time']<$team['begin_time']){$team['end_time']=$team['begin_time'];}

$diff_time = $left_time = $team['end_time']-$now;
if ( $team['team_type'] == 'seconds' && $team['begin_time'] >= $now ) {
	$diff_time = $left_time = $team['begin_time']-$now;
}
$keyword = explode(", ", $team['seo_keyword']);

for($i=0;$i<count($keyword);$i++){
		$team['detail'] = str_replace($keyword[$i], "<a href='http://www.cheapdeal.vn/team/search.php?s=".trim($keyword[$i])."' style='text-decoration:underline'>".$keyword[$i]."</a>", $team['detail']);
}


/*$string = 'The quick brown fox jumped over the lazy dog.';
$patterns = array();
$patterns[0] = '/quick/';
$patterns[1] = '/quick brown/';
$patterns[2] = '/fox/';
$replacements = array();
$replacements[0] = '<a href="quick">quick</a>';
$replacements[1] = '<a href="quick brown">quick brown</a>';
$replacements[2] = 'slow';
echo preg_replace($patterns, $replacements, $string);*/




$left_day = floor($diff_time/86400);
$left_time = $left_time % 86400;
$left_hour = floor($left_time/3600);
$left_time = $left_time % 3600;
$left_minute = floor($left_time/60);
$left_time = $left_time % 60;

/* progress bar size */
$bar_size = ceil(150*($team['now_number']/$team['min_number']));
$bar_offset = ceil(5*($team['now_number']/$team['min_number']));
$partner = Table::Fetch('partner', $team['partner_id']);
$team['state'] = team_state($team);

/* your order */
if ($login_user_id && 0==$team['close_time']) {
	$order = DB::LimitQuery('order', array(
				'condition' => array(
					'team_id' => $id,
					'user_id' => $login_user_id,
					'state' => 'unpay',
					),
				'one' => true,
				));
}
/* end order */

/*kxx team_type */
if ($team['team_type'] == 'seconds') {
	die(include template('team_view_seconds'));
}
if ($team['team_type'] == 'goods') {
	die(include template('team_view_goods'));
}
/*xxk*/
$team['url'] = urlencode("http://{$INI['system']['sitename']}/team.php?id=".$team['id']);
/*seo*/
$seo_title = $team['seo_title'];
$seo_keyword = $team['seo_keyword'];
$seo_description = $team['seo_description'];
/*end*/

$other_deal = DB::GetQueryResult("SELECT id, short_title, begin_time, now_number, team_price, market_price, image FROM `team` WHERE group_id =".$team['group_id']." AND id <> ".$team['id']."  AND begin_time < UNIX_TIMESTAMP() AND end_time > UNIX_TIMESTAMP() ORDER BY begin_time DESC LIMIT 0,7",false);


/*Forum*/
if(isset($_GET['comment'])){

	//head toptic
	$head = DB::GetQueryResult("SELECT * FROM topic WHERE team_id=$id AND parent_id=0",true);
	
	if(empty($head)){
		 $atinsert =  array(
			'user_id', 'title', 'parent_id', 'content', 'last_time', 'create_time',
			'city_id', 'team_id', 'public_id', 'status','topic_ip',
		);
		
		$topic = 	new Table('topic', $_POST);
		$topic->user_id = 1;
		$topic->title = $team['title'];
		$topic->parent_id = 0;
		$topic->content = $team['title'];
		$topic->status = 'Y';
		$topic->city_id = $team['city_id'];
		$topic->team_id = $team['id'];
		$topic->insert($atinsert);
		$head = DB::GetQueryResult("SELECT * FROM topic WHERE team_id=$id AND parent_id=0",true);
		
	}
	
	
	$ask_con = array('length(content)>0');	
	$ask_con['team_id'] = $id;
	$ask_con['status'] = 'Y';
	$ask_con['parent_id'] = 0;
	$ask_count = Table::Count('topic', $ask_con);
	$asks = DB::LimitQuery('topic', array('condition'=>$ask_con, 'size'=>1));
	
	$topic_ids = Utility::GetColumn($asks, 'id');
	$topic = Table::Fetch('topic', $topic_ids[0]);
	
	
	$total_comment = 0;
	$count = $topic['reply_number'];
	list($pagesize, $offset, $pagestring) = pagestring($count, 20);
	
	// topics
	$replies = DB::LimitQuery('topic', array(
		'condition' => array( 'parent_id' => $topic_ids[0], "status NOT IN ('D')"),
		'order' => 'ORDER BY last_time DESC, reply_number DESC',
		'size' => $pagesize,
		'offset' => $offset,
	));
	
	if($topic['city_id']==0){
		$topic['city_id']=$city['id'];
	}
	$user_ids = Utility::GetColumn($replies, 'user_id');
	$user_ids[] = $topic['user_id'];
	$users = Table::Fetch('user', $user_ids);
	
	$public = Table::Fetch('category', $topic['public_id']);
	Table::UpdateCache('topic', $id, array('view_number' => array('view_number + 1')));
	
	$now_time = date("Y-m-d",time());
	$d = date("D",time());
	if($d=='Sat'){
		$time = '12:00:00';
	}elseif($d=='Mon'){
		$time = '7:30:00';
	}else{
		$time = '16:30:00';	
	}
	
	//topic posted
	
	$p = strtotime($now_time.' '.$time);
	if (is_post() && isset($_POST['commit'])) {
		need_login();
		$reply = new Table('topic', $_POST);
		$reply->user_id = $login_user_id;
		$reply->city_id = $_POST['city_id'];
		$reply->team_id = $_POST['team_id'];
		$reply->public_id = $_POST['public_id'];
		$reply->content = $_POST['topic_content'];
		$reply->last_time = time();
		$reply->create_time = time();
		$reply->topic_ip = $ip;
		if((time() >= strtotime($p)) || ($d=='Sun') || ($d=='Mon' && time() <= strtotime($p))){
			$reply->status = 'N';
		}else{
			$reply->status = 'N';
		}
		$insert =  array(
			'user_id', 'parent_id', 'content', 'last_time', 'create_time',
			'city_id', 'team_id', 'public_id', 'status','topic_ip',
		);
		$reply->insert($insert);
		$count = Table::Count('topic', array('parent_id' => $_POST['parent_id']));
		Table::UpdateCache('topic', $_POST['id'], array(
			'reply_number' => $count,
			'last_time' => $reply->create_time,
			'last_user_id' => $login_user_id,
			
		));		
		redirect( WEB_ROOT ."/".$city['slug']."/".seo_url($team['short_title'],$team['id'],$url_suffix)."?comment=display#div_dealcomment");
	}
	
	// commment posted
	if(is_post() && isset($_POST['replytopicuser'])){
		need_login();
		$reply_topic_user = new Table('topic_reply', $_POST);
		$reply_topic_user->user_id_reply = $login_user_id;
		$reply_topic_user->create_time = time();
		$reply_topic_user->content = $_POST['content-reply'];
		$reply_topic_user->reply_ip = $ip;
		if((time() >= strtotime($p)) || ($d=='Sun') || ($d=='Mon' && time() <= strtotime($p))){
			$reply_topic_user->status = 'N';
		}else{
			$reply_topic_user->status = 'N';
		}
		$insert =  array(
				'user_id', 'topic_id', 'user_id_reply', 'content', 'create_time', 'status','reply_ip',
			);
		$reply_topic_user->insert($insert);
		redirect( WEB_ROOT . "/".$city['slug']."/".seo_url($team['short_title'],$team['id'],$url_suffix)."?comment=display#div_dealcomment");
	}


	include template('team_view_comment');

}else{
	include template('team_view');
}