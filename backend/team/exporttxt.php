<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('team');
$id = abs(intval($_GET['id']));
$team = Table::Fetch('team', $id);
$cities = Table::Fetch('category', $team['city_id']);
$content = "<p class=\"deals-image\"><img src=\"".$INI['system']['wwwprefix']."/static/".$team['image']."\" alt=\"\" /></p><ul class=\"deals-data\"><li><div class=\"discount\">
<h4 class=\"title\">Giảm giá:</h4>".ceil(moneyit((100*($team['market_price'] - $team['team_price'])/$team['market_price'])))."%</div></li><li><div class=\"valid\"><h4 class=\"title\">Có hiệu lực đến:</h4>".date("d/m/Y",$team['end_time'])."</div></li><li><div class=\"buy\"><h4 class=\"title\"><a href=\"".$INI['system']['wwwprefix']."/yahoo/team.php?id=".$team['id']."\" title=\"Xem chi tiết\">XEM</a></h4>".print_price(moneyit($team['team_price']))."<span>VNĐ</span></div></li><li><div class=\"savings-original\"><h4 class=\"savings\">Tiết kiệm: <span>".print_price($team['market_price'] - $team['team_price'])." VNĐ</span></h4><h4 class=\"original\">Giá gốc: <span>".print_price(moneyit($team['market_price']))." VNĐ</span></h4></div></li><li><div class=\"description\"><h4 class=\"title\">".$cities['name'].": ".$team['short_title']."</h4>".$team['title']."</div></li></ul>";
header("Content-type: text/plain; charset=utf-8");
header("Content-Disposition: attachment; filename=html_for_yahoowordpress_vn.txt");
header("Pragma: no-cache");
header("Expires: 0");
print "{$content}";		
exit();