<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
$q = strtolower($_GET["q"]);
if (!$q) return;
if(!empty($q)){

	$address = mysql_query("SELECT name FROM streets WHERE (name LIKE '$q%') OR (keyword LIKE '$q%') ORDER BY name ASC");
	if(mysql_num_rows($address)>0){
		while($row = mysql_fetch_array($address)){
			$items = $row['name'];
			echo "$items|$q\n";
		}
	}
}
?>
