<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
require_once(dirname(dirname(__FILE__)) . '/connect_omega_db.php');
need_manager();
need_auth('order');

//Import Phieu Xuat Kho
echo "<p>&nbsp;</p>";echo "<p>&nbsp;</p>";
$count = Table::Count('partner', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 500);

$sql = "SELECT * FROM partner";

$rs = DB::GetQueryResult($sql,false);

if(is_array($rs)){
	$sql = "";
	for($i=0; $i<count($rs);$i++){
		if($rs[$i]['contact']!=''){
			$tel = $rs[$i]['contact'];
		}else{
			$tel = $rs[$i]['contact'];
		}
		$insert = "INSERT INTO IT1202(ObjectID, ObjectName, IsUpdateName, ObjectTypeID, Address, Tel) VALUES ('MC".$rs[$i]['id']."', N'".$rs[$i]['title']."', '1','CC', N'".$rs[$i]['address']."', '".$tel."');";
		echo $insert."<br>";
		//mssql_query($insert);
	}
}
//echo $pagestring;


echo "<p>&nbsp;</p>";echo "<p>&nbsp;</p>";echo "<p>&nbsp;</p>";


$count = Table::Count('shipper', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 500);

$sql = "SELECT * FROM shipper";

$rs = DB::GetQueryResult($sql,false);

if(is_array($rs)){
	$sql = "";
	for($i=0; $i<count($rs);$i++){
		if($rs[$i]['shipper_tel']!=''){
			$tel = $rs[$i]['shipper_tel'];
		}else{
			$tel = $rs[$i]['shipper_tel'];
		}
		echo $insert = "INSERT INTO IT1202(ObjectID, ObjectName, IsUpdateName, ObjectTypeID, Address, Tel) VALUES ('".$rs[$i]['id']."', N'".$rs[$i]['shipper_name']."', '1','NV', N'".$rs[$i]['shipper_address']."', '".$tel."')";
		//mssql_query($insert);
	}
}
mssql_close($dbhandle);
