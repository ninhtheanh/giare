<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

//DB::$mDebug = true;

need_manager();
need_auth('sale');
if(!isset($_GET['view']) && !isset($_GET['s'])){
	if($login_user_id!=1 && (int)$_GET['sale']){
		$sale = (int)$_GET['sale'];
		$where = "AND team.sale=".$sale;	
	}elseif($login_user_id!=1){
		$sale = (int)$login_user_id;
		$where = "AND team.sale=".$login_user_id;
	}elseif($login_user_id==1 && (int)$_GET['sale']){
		$sale = (int)$_GET['sale'];
		$where = "AND team.sale=".$sale;	
	}else{
		$where = "";	
	}

	$condition = array();
	$fr = $to = time();		
	
	// data posted
	/*$count = Table::Count('team', $condition);
	list($pagesize, $offset, $pagestring) = pagestring($count, 100);*/
	//SUM(IF((o.service!='cashoffice' AND o.state='confirmed'),quantity,0)) + SUM(IF((o.service!='cashoffice' AND o.state='pending'),quantity,0)) + Sum(IF((o.service='cashoffice' AND o.state='confirmed'),quantity,0)) + 
	
	
	
	$sql = "SELECT o.team_id AS team_id, team.sale AS sale_id, team.short_title AS team_name, sales.name AS sale_name, FROM_UNIXTIME(team.begin_time,'%Y-%m-%d') AS begin_time, Sum(o.quantity) AS total,
	(Sum(IF(o.state='confirmed',quantity,0)) + Sum(IF(o.state='pending',quantity,0)) + Sum(IF(o.state='oncredit',quantity,0)) + Sum(IF(o.state='processing',quantity,0)) + Sum(IF(o.state='printeditem',quantity,0)) + Sum(IF(o.state='packaged',quantity,0)) + Sum(IF(o.state='calling',quantity,0)) + Sum(IF(o.state='hanging',quantity,0)) + Sum(IF(o.state='unpay',quantity,0))) AS confirm, (Sum(IF(o.state='canceled',quantity,0)) + Sum(IF(o.state='dealsoc_cancel',quantity,0))) AS cancel, (Sum(IF(o.state='delivered',quantity,0)) + Sum(IF(o.state='transported',quantity,0))) AS delivery,
	Sum(IF(o.state='pay',quantity_successful,0)) AS pay, IF(team.`status`='Y','Đang GH','Hết GH') AS team_status,
	FROM_UNIXTIME(team.end_time,'%Y-%m-%d') AS deal_close, IF(team.`delivery_properties`='1','Giao SP','Giao Voucher') AS delivery_properties
	FROM `order` AS o INNER JOIN team ON o.team_id = team.id INNER JOIN sales ON team.sale = sales.id WHERE team.group_id!=23 {$where} GROUP BY team_id ORDER BY team_id DESC";// LIMIT {$offset},{$pagesize}";
	$rs = DB::GetQueryResult($sql,false);
	list($pagesize, $offset, $pagestring) = pagestring(count($rs), 100);
	include template('report/sale_report');
}else{
	$deal_id = (int)$_GET['view'];
	$sale_id = (int)$_GET['s'];
	$team = DB::GetQueryResult("SELECT short_title, sale FROM `team` WHERE id=".$deal_id);
	if($sale_id!=$team['sale'] && $login_user_id!=1){
		Session::Set('notice', 'Access Denine');
		redirect( WEB_ROOT . "/backend/report/sale_report.php");	
	}else{
		$stock = DB::GetQueryResult("SELECT merchant_quantity, date_create FROM `products_in_stock` WHERE deal_id=".$deal_id." AND sale_id=".$sale_id, false);
		if ( $_POST ) {
			$table = new Table('products_in_stock', $_POST);
			$table->sale_id = $sale_id;
			$table->deal_id = $deal_id;
			$table->user_id = $login_user_id;
			$table->date_create = date("Y-m-d H:i:s",time());
			$up_array = array(
				'sale_id', 'deal_id', 'merchant_quantity', 'date_create', 'user_id',
			);
		
			$flag = $table->insert( $up_array );
			if ( $flag ) {
				Session::Set('notice', 'Required Success');
				redirect( WEB_ROOT . "/backend/report/sale_report.php?view={$deal_id}&s={$sale_id}");
			}
		}
		
	}
	include template('report/sale_import');
}