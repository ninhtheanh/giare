<HTML> 

<HEAD> 
<?php 
set_time_limit(0);
#include('Crypt.php'); 
// Create a new Encryption Object 
#$enc = new Encryption; 

require_once(dirname(dirname(__FILE__)) . '/app.php');

//DB::$mDebug=true;
/*
$rs = DB::GetQueryResult('SELECT email FROM `user` WHERE up<>1 ORDER BY id',false);
foreach($rs as $v)
{
	$m = mysql_real_escape_string($enc->encrypt('@4!@#$%@', $v['email']));
	DB::Query("UPDATE `user` SET email='$m',username='$m',up=1 WHERE email='".$v['email']."'");	
}
*/
/*
$rs = DB::GetQueryResult('SELECT email FROM `subscribe` ORDER BY id',false);
foreach($rs as $v)
{
	$m = mysql_real_escape_string($enc->encrypt('@4!@#$%@', $v['email']));
	DB::Query("UPDATE `subscribe` SET email='$m' WHERE email='".$v['email']."'");	
	
}
*/

$rs = DB::GetQueryResult('SELECT id,email FROM `maillist` WHERE id>31422 and id<100000 ORDER BY id',false);
foreach($rs as $v)
{
        $m = mysql_real_escape_string($enc->encrypt('@4!@#$%@', $v['email']));
        DB::Query("UPDATE IGNORE `maillist` SET email='$m' WHERE id='".$v['id']."'");

}


var_dump($enc->errors);
var_dump(DB::$mError);
die();

/*
$encstr = ''; 
$decstr = ''; 
if (isset($_POST['encrypt'])) { 
    $key = $_POST['keystr'];  
    // Encrypt the Source Text 
    $encstr = $enc->encrypt($key, $_POST['text']); 
} elseif (isset($_POST['decrypt'])) { 
    $encstr = $_POST['enctext']; 
    $key = $_POST['keystr'];  
    // Decrypt the Encrypted Text 
    $decstr = $enc->decrypt($key, $_POST['enctext']); 
}
*/
?> 
</HEAD>     
     
<BODY> 

<FORM action = '<?php echo $_SERVER['PHP_SELF'] ?>' method = 'post'> 
<BR>Original Text<BR> 
<TEXTAREA name = 'text' cols="40" rows="8" wrap="soft">Welcome to the Real World.</TEXTAREA> 
<BR>Enter Key String<BR> 
<INPUT name = 'keystr' type = 'text' value = '<?php echo $_POST['keystr'] ?>'> 
<BR><Input type='submit' value = 'Encrypt' name='encrypt'><Input type='submit' value = 'Decrypt' name='decrypt'> 
<BR>Encrypted Text<BR> 
<TEXTAREA name = 'enctext' cols="40" rows="8" wrap="soft"><?php 
if (isset($_POST['encrypt']) || isset($_POST['decrypt'])) 
    echo $encstr; 

?></TEXTAREA> 
<BR>Decrypted Text<BR> 
<TEXTAREA name = 'dectext' cols="40" rows="8" wrap="soft"><?php 
if (isset($_POST['encrypt']) || isset($_POST['decrypt'])) 
    echo $decstr; 

?></TEXTAREA> 
</FORM> 

</BODY> 

</HTML>
