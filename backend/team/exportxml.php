<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('team');

$ids = $_GET['ids']; 
/*var_dump($ids);$list_id = "";
for($i=0;$i<count($ids);$i++){
	$list_id .= $ids[$i].",";
}*/
$list_id = trim($ids, ",");
$oc = array( 
	'team_type' => 'normal',
	"id IN ({$list_id})",
);	
$teams = DB::LimitQuery('team', array(
	'condition' => $oc,
	'order' => 'ORDER BY `sort_order` DESC, `id` DESC',
));
$xls[] = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?> 
<TodayDeal>
	<ArrayDeal>";
$j=0;
foreach($teams As $k=>$t) {
	$j+=1;
	$xls[] = '<deal>
			<ID>'.$t['id'].'</ID>
			<title>'.$t['title'].'</title>
			<img>'.team_image($t['image']).'</img>
			<dealcost>'.$t['team_price'].'</dealcost>
			<realcost>'.$t['market_price'].'</realcost>
			<discount>'.ceil(moneyit((100*($t['market_price'] - $t['team_price'])/$t['market_price']))).'%</discount>
			<begin_time>'.$t['begin_time'].'</begin_time>
			<end_time>'.$t['end_time'].'</end_time>
			<detail>'.$t['detail'].'</detail>
		</deal>';
}
$xls[] = '</ArrayDeal>
</TodayDeal>';
$xls = join("\r\n", $xls);
header("Content-type: text/xml; charset=utf-8");
header("Content-Disposition: attachment; filename=Dealsoc_FPT_IPTV.xml");
header("Pragma: no-cache");
header("Expires: 0");
print "{$xls}";		
exit();