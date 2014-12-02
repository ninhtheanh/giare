<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('team');

$ids = $_POST['id']; 
var_dump($ids);$list_id = "";
for($i=0;$i<count($ids);$i++){
	$list_id .= $ids[$i].",";
}
$list_id = trim($list_id, ",");
$oc = array( 
	'team_type' => 'normal',
	"id IN ({$list_id})",
);	
$teams = DB::LimitQuery('team', array(
	'condition' => $oc,
	'order' => 'ORDER BY `sort_order` DESC, `id` DESC',
));
$xls[] = "<html><meta http-equiv=content-type content=\"text/html; charset=UTF-8\"><body><table border=1 cellspacing=\"0\" cellpadding=\"0\"><col width=\"64\"><col width=\"100\"><col width=\"300\"><tr height=\"21\"><td height=\"21\" width=\"64\">&nbsp;</td><td width=\"100\">Content</td><td width=\"300\">Data Needed</td></tr>";
$j=0;
foreach($teams As $k=>$t) {
	$j+=1;
	$xls[] = '<tr><td rowspan="3" width="64">Item '.$j.'</td><td>image</td><td>fp_'.date('md', time()).'_item'.$j.'.jpg</td></tr><tr><td>text</td><td width="198">'.cut_string($t['short_title'],40,'').'</td></tr><tr height="21"><td height="21">hyperlink</td><td>'.$INI['system']['wwwprefix']."/yahoo/team.php?id=".$t['id'].'</td></tr>';
}
$xls[] = '</table></body></html>';
$xls = join("\r\n", $xls);
header('Content-Disposition: attachment; filename="4thumbnailtemplateyahoo.xls"');
die(mb_convert_encoding($xls,'UTF-8','UTF-8'));