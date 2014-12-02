<?php
require_once('../app.php');
/*$o = DB::GetQueryResult("SELECT Ma_GD, Ma_DH FROM `temp_nl`",false);
for($i=0;$i<count($o);$i++){
	echo "UPDATE `order` SET transaction_id_nl=".(int)$o[$i]['ma_gd']." WHERE id = ".$o[$i]['ma_dh'];
	echo ";<br>";
	//mysql_query("UPDATE ship_out_data SET qty_successful=".$o[$i]['quantity_successful']." WHERE order_id = ".$o[$i]['id']." AND out_id=".$o[$i]['ship_id']);
}*/


$o = DB::GetQueryResult("SELECT cus_id, verify_code, cus_mobile, u.email FROM `verify_code` as vc LEFT JOIN `user` as u ON vc.cus_id=u.id WHERE vc.team_id=753 AND vc.verified='N'",false);
$verifycode = base64_decode('LTEwOTc4Ng==');
$code = explode("-",$verifycode);
$vcode = DB::GetQueryResult("SELECT id FROM verify_code WHERE cus_id='".$code[1]."' AND team_id='753' AND verify_code='".$code[0]."'");
/*if(!$vcode){
	echo "<script> alert('Mã xác nhận không đúng. Vui lòng kiểm tra lại');window.location.href='/team/buy.php?id={$id}';</script>";
}else*/{
	var_dump($vcode);
}
/*echo "<br>";

$u = DB::GetQueryResult("SELECT id, email, username FROM `user` WHERE `email` LIKE '%@yahoo%' OR `email` LIKE '%@gmail%'", false);


foreach($u as $i => $v){
	$email = $m = mysql_real_escape_string($enc->encrypt('@4!@#$%@', $v['email']));
	echo 'UPDATE `user` SET email="'.$email.'", username="'.$email.'" WHERE id='.$v['id'].";<br>";
	//DB::Query("UPDATE `user` SET email='".$email."', username='".$email."' WHERE id={$v['id']}");
}*/
$html = "<table width='100%' border=1><tr bgcolor='#f1f3f5'><td>STT</td><td>Email</td><td>User ID</td><td>Code</td><td>Link Active</td><td>Decode</td></tr><tr><td colspan=6>KH có đơn hàng</td></tr>";
$html1 = "<table width='100%' border=1><tr bgcolor='#f1f3f5'><td>STT</td><td>Email</td><td>User ID</td><td>Code</td><td>Link Active</td><td>Decode</td></tr><tr><td colspan=6>KH chưa có đơn hàng</td></tr>";

foreach($o as $index =>$key){
	$stt = $index+1;
	$uid = $key['cus_id'];
	$email = $enc->decrypt('@4!@#$%@', $key['email']) ;	
	$encode = base64_encode($key['verify_code']."-".$uid);
	$decode = base64_decode($encode);
	$sql = DB::GetQueryResult("SELECT id FROM `order` WHERE user_id=".$uid);
	$link = "{$INI['system']['wwwprefix']}/team/activecode.php?id=".$sql['id']."&mobile=".$key['cus_mobile']."&did=753&code=".$key['verify_code'];
	if((int)$sql['id']==0){
		$bgcolor = "#f1f3f5";
		$html1 .="<tr bgcolor='".$bgcolor."'><td>".$stt."</td><td>".$email."</b></td><td>".$uid."- Ma ĐH: <b>".$sql['id']."</td><td>".$key['verify_code']."</td><td>".$link."</td><td>".$decode."</td></tr>";
	}else{
		$bgcolor = "#ffffff";
		$html .="<tr bgcolor='".$bgcolor."'><td>".$stt."</td><td>".$email."</b></td><td>".$uid."- Ma ĐH: <b>".$sql['id']."</td><td>".$key['verify_code']."</td><td>".$link."</td><td>".$decode."</td></tr>"	;
	}
	
	

}
$html .="</table>";$html1 .="</table>";

echo $html1.$html;
?>