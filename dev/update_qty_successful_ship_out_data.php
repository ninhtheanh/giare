<?php
require_once('../app.php');
/*$o = DB::GetQueryResult("SELECT Ma_GD, Ma_DH FROM `temp_nl`",false);
for($i=0;$i<count($o);$i++){
	echo "UPDATE `order` SET transaction_id_nl=".(int)$o[$i]['ma_gd']." WHERE id = ".$o[$i]['ma_dh'];
	echo ";<br>";
	//mysql_query("UPDATE ship_out_data SET qty_successful=".$o[$i]['quantity_successful']." WHERE order_id = ".$o[$i]['id']." AND out_id=".$o[$i]['ship_id']);
}*/
echo base64_encode('58013-78071')."<br>";
echo base64_decode('NTgwMTMtNzgwNzE=');

?>