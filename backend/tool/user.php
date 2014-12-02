<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('admin');
if($_POST['submit'])
{
	$dfrom = $_POST['dfrom'];
	if(!$dfrom) exit;
	
	$date = strtotime($dfrom." 00:00:00");

	$q = DB::GetQueryResult("SELECT id, email FROM `user` WHERE create_time>$date AND id NOT IN (132968)", false);
	echo $date;
	exit();
	$content = "";
	foreach($q as $k =>$v){
		$email = $enc->decrypt('@4!@#$%@', $v['email']);//$enc->decrypt(ZUser::SECRET_KEY, $v['email']);
		//$content .= "<tr><td>".($k+1)."</td><td>".$v['id']."</td><td nowrap>".$v['email']."</td><td nowrap>".strtolower($email)."</td></tr>";
		$content .= strtolower($email)."\r\n";
	}
	//echo $content.="</table>";exit();
	header("Content-type: text/xml; charset=utf-8");
	header("Content-Disposition: attachment; filename=User-".$dfrom.".txt");
	header("Pragma: no-cache");
	header("Expires: 0");
	print "{$content}";		
	exit();
}
?>
<h1>Export Users</h1>
<form name="users" method="post">
date from : <input type="text" name="dfrom" /> (ex: 2012-03-31)
<input type="submit" name="submit" value="submit" />
</form>