<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$q = strtolower($_GET["q"]);
if (!$q) return;
if(!empty($q)){
	$address = mysql_query("SELECT street_name FROM street WHERE (street_name LIKE '$q%') OR (street_name_unsigned LIKE '$q%') ORDER BY street_name ASC");
	if(mysql_num_rows($address)>0){
		while($row = mysql_fetch_array($address)){
			$items = $row['street_name'];
			echo "$items|$q\n";
		}
	}
}
?>
