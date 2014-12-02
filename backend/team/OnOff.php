<?php

require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

//require_once(dirname(dirname(__FILE__)) . '/connect_omega_db.php');

need_manager();
need_auth('team');

$now = time();
$condition = array(
	'system' => 'Y',
	"city_id IN ({$city['id']},0,556)",
	/*"now_number > min_number",*/
	'begin_time <= '.time(),
);
/* filter start */
$team_type = strval($_GET['team_type']);
if ($team_type) { $condition['team_type'] = $team_type; }
/* filter end */
$key = strval($_GET['key']);
if ($key)
{
$condition[] = "masp like '%".mysql_escape_string($key)."%' or product like '%".mysql_escape_string($key)."%'";
}
$sale = intval($_GET['sale']);
if ($sale>0) {
	$condition['sale'] = $sale;
}
$team_id = intval($_GET['id']);
if ($team_id>0) {
	$condition['id'] = $team_id;
}
$count = Table::Count('team', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 50);

$teams = DB::LimitQuery('team', array(
	'condition' => $condition,
	'order' => 'ORDER BY id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));

$cities = Table::Fetch('category', Utility::GetColumn($teams, 'city_id'));
$groups = Table::Fetch('category', Utility::GetColumn($teams, 'group_id'));

$selector = 'index';


/*  if(is_array($teams)){
	foreach($teams as $key=>$value){
		$sql = mssql_query("SELECT InventoryID FROM IT1302 WHERE InventoryID=".$value['id']);
		$ds = mssql_fetch_array ($sql);
		$value['short_title'] = str_replace("-"," ",make_keyword($value['short_title']));
		$value['title'] = str_replace("-"," ",make_keyword(str_replace("'"," ",$value['title'])));  */
		/*if($value['id']==435){	
			echo "INSERT INTO IT1302 (S1, S2, S3, InventoryID, InventoryName, UnitID, IsSource, MethodID, AccountID, SalesAccountID, PrimeCostAccountID, PurchaseAccountID, Notes01, InventoryTypeID, I01ID, SalePrice01, SalePrice02, CreateDate, LastModifyDate) SELECT '','','','".$value['id']."',N'".$value['short_title']."','CAI','0','4','1561','511','632','1561',N'".$value['title']."','".$value['group_id']."','".$value['partner_id']."','".$value['team_price']."','".$value['market_price']."','".date("Y-m-d H:i:s",$value['begin_time'])."','".date("Y-m-d H:i:s",$value['end_time'])."'";
		}*/
		/*  if((int)$ds['InventoryID']>0){
			mssql_query("UPDATE IT1302 SET S1='', S2='', S3='', InventoryName=N'".$value['short_title']."', UnitID='CAI', IsSource='0', MethodID='4', AccountID='1561', SalesAccountID='511', PrimeCostAccountID='632', PurchaseAccountID='1561', Notes01=N'".$value['title']."', InventoryTypeID='".$value['group_id']."', I01ID='".$value['partner_id']."', SalePrice01='".$value['team_price']."', SalePrice02='".$value['market_price']."', CreateDate='".$value['begin_time']."', LastModifyDate='".$value['end_time']."' WHERE InventoryID=".(int)$ds['InventoryID']);
		}else{
			mssql_query("INSERT INTO IT1302 (S1, S2, S3, InventoryID, InventoryName, UnitID, IsSource, MethodID, AccountID, SalesAccountID, PrimeCostAccountID, PurchaseAccountID, Notes01, InventoryTypeID, I01ID, SalePrice01, SalePrice02, CreateDate, LastModifyDate) SELECT '','','','".$value['id']."',N'".$value['short_title']."','CAI','0','4','1561','511','632','1561',N'".$value['title']."','".$value['group_id']."','".$value['partner_id']."','".$value['team_price']."','".$value['market_price']."','".date("Y-m-d H:i:s",$value['begin_time'])."','".date("Y-m-d H:i:s",$value['end_time'])."'");
		}
	}
	mssql_free_result($sql);
}
mssql_close($dbhandle);  */
include template('manage_team_onoff');
