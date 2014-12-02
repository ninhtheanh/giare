<?php
//if( $_GET['token'] != '123456@123' ) die('not authorized');
$output = shell_exec('sudo sh dev2online.sh 2>&1');
echo "<pre>$output</pre>";
//echo system('sh /root/rsync_dev_online.sh');
?>
