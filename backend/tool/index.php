<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('team');

//DB::$mDebug = true;

// review ------------------------------------------------------------------
if($_GET['review'])
{
	/*$rs = DB::LimitQuery('mail_template', array('condition' => 'id='.$_GET['review']));	
	$data = unserialize($rs[0]['data']);	*/
	$data = $_SESSION['mtpl'];	
	
	$ulink = $data['ulink'];
	$tpl = $data['tpl'];
	$ids = $data['ids'];
	$head = $data['head'];
	$resort = $data['resort'];
	$bestseller = $data['bestseller'];

	if(!$head)
	{
		$rs = DB::LimitQuery('team', array('condition' => 'id IN ('.$ids.')','order' => 'ORDER BY sort_order DESC,id DESC'));
	}else{
		$r1 = DB::LimitQuery('team', array('condition' => 'id='.$head));		
		$r2 = DB::LimitQuery('team', array('condition' => 'id IN ('.$ids.') AND id<>'.$head,'order' => 'ORDER BY sort_order DESC,id DESC'));	
		$rs = array_merge($r1,$r2);
	}
	if((int)$resort>0){
		//DB::$mDebug=true;
		$rs_resort = DB::LimitQuery('team', array('condition' => 'id NOT IN ('.$ids.') AND group_id=23 AND begin_time < UNIX_TIMESTAMP() AND end_time > UNIX_TIMESTAMP()','order' => 'ORDER BY sort_order DESC,id DESC LIMIT 0,'.$resort));	
	}
	if((int)$bestseller>0){
		$rs_bestseller = DB::LimitQuery('team', array('condition' => 'id NOT IN ('.$ids.') AND begin_time < UNIX_TIMESTAMP() AND end_time > UNIX_TIMESTAMP() AND group_id!=23','order' => 'ORDER BY now_number DESC, sort_order DESC,id DESC LIMIT 0,'.$bestseller));	
	}

	include template('tool/mail_'.$tpl);	
	exit;	
}

// process mode ------------------------------------------------------------------
if($_POST['process'])
{	
	// invalid input return
	if(!$_POST['ids']) return redirect( "./index.php");	
	
	// input processing
	$service = ($_POST['service']) ? $_POST['service'] : 'mimi';
	switch($service)
	{
		case 'interspire' : $ulink = '%%unsubscribelink%%'; break;
		default : $ulink = '[[unsubscribe]]'; break;
	}
	
	$template = ($_POST['template']) ? $_POST['template'] : 'line';		
	switch($template)
	{
		case 'one' : $tpl = 'one'; break;
		case 'row' : $tpl = 'line_new'; break;
		case 'col' : $tpl = 'line_two_col'; break;
		default : $tpl = 'line'; break;
	}
	
	$ids = implode(',',$_POST['ids']);	
	
	// banner top
	if($_POST['bannerTdesc'] && $_POST['bannerTlink'] && $_FILES['bannerTfile'])
	{
		$data['tdesc'] = $_POST['bannerTdesc'];
		$data['tlink'] = $_POST['bannerTlink'];
		$data['tfile'] = upload_image('bannerTfile','','banner');
	}
	
	// banner bot
	if($_POST['bannerBdesc'] && $_POST['bannerBlink'] && $_FILES['bannerBfile'])
	{
		$data['bdesc'] = $_POST['bannerBdesc'];
		$data['blink'] = $_POST['bannerBlink'];
		$data['bfile'] = upload_image('bannerBfile','','banner');
	}
	
	// insert db
	$data['ulink'] = $ulink;
	$data['tpl'] = $tpl;
	$data['ids'] = $ids;
	$data['head'] = $_POST['head'];	
	$data['resort'] = $_POST['no_resort'];
	$data['bestseller'] = $_POST['no_bestseller'];
	$_SESSION['mtpl'] = $data;	
	
	redirect( "./index.php?review=yes");
	/*$data = serialize($data);
	DB::Query("INSERT INTO mail_template VALUES ('',$login_user_id,UNIX_TIMESTAMP(),'$data')");
	redirect( "./index.php?review=".mysql_insert_id());	*/
	exit;
	
}

// load deals ------------------------------------------------------------------
$cond = array( 
			'team_type' => 'normal',
			"begin_time < UNIX_TIMESTAMP()",
			"end_time > UNIX_TIMESTAMP()",
			"(max_number>0 AND now_number < max_number) OR max_number=0",
			);

$rs = DB::LimitQuery('team', array(
	'condition' => $cond,
	'order' => 'ORDER BY sort_order DESC,id DESC',	
));

include template('tool/index');