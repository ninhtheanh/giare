<?php
if(in_array($_SERVER['REMOTE_ADDR'], array('localhost', '127.0.0.1'))) 
{
	$value = array (
	  'host' => 'localhost',
	  'user' => 'root',
	  'pass' => 'usbw',
	  'name' => 'giare',
	);
}
else
{
	$value = array (
	  
	);
}
?>