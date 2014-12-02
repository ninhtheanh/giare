<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$q = strtolower($_GET["q"]);
if (!$q) return;
if(!empty($q)){
	$t = mysql_query("SELECT short_title FROM team WHERE id NOT IN (53,768,311,1502) AND ((title LIKE '%$q%') OR (short_title LIKE '%$q%')) ORDER BY short_title ASC");
	if(mysql_num_rows($t)>0){
		while($row = mysql_fetch_array($t)){
			$items = $row['short_title'];
			echo "$items|$q\n";
		}
	}
}
?>
