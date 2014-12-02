<?php

echo md5('123456' . '@4!@#$%@');

$r = unserialize('a:2:{s:5:"Lists";a:1:{i:0;s:1:"1";}s:5:"Rules";a:1:{i:0;a:3:{s:4:"type";s:5:"group";s:9:"connector";s:3:"and";s:5:"rules";a:3:{i:0;a:3:{s:4:"type";s:4:"rule";s:9:"connector";s:3:"and";s:5:"rules";a:3:{s:8:"ruleName";s:1:"4";s:12:"ruleOperator";s:4:"like";s:10:"ruleValues";a:1:{i:0;s:4:"T437";}}}i:1;a:3:{s:4:"type";s:4:"rule";s:9:"connector";s:3:"and";s:5:"rules";a:3:{s:8:"ruleName";s:1:"6";s:12:"ruleOperator";s:10:"isnotempty";s:10:"ruleValues";a:1:{i:0;s:0:"";}}}i:2;a:3:{s:4:"type";s:4:"rule";s:9:"connector";s:3:"and";s:5:"rules";a:3:{s:8:"ruleName";s:2:"11";s:12:"ruleOperator";s:7:"between";s:10:"ruleValues";a:2:{i:0;s:1:"0";i:1;s:5:"10000";}}}}}}}');
var_dump($r);

/*
set_time_limit(0);
$conn = mysql_connect('localhost','dev','devp@ssw0rd') or die ('db connect failed');
mysql_select_db('ds_email') or die('select db failed');
/*
$qq=mysql_query("select * from my.ved where subscriberid=53");
while($rr=mysql_fetch_assoc($qq))
{	
	mysql_query("insert into email_subscribers_data (`subscriberid`,`fieldid`,`data`) values (290243,'".$rr['fieldid']."','".$rr['data']."')");
	
}

$qq=mysql_query("select * from my.ved where subscriberid=54");
while($rr=mysql_fetch_assoc($qq))
{	
	mysql_query("insert into email_subscribers_data (`subscriberid`,`fieldid`,`data`) values (290244,'".$rr['fieldid']."','".$rr['data']."')");
	
}
*/
/*
$q=mysql_query('select subscriberid,emailaddress,domainname,requestdate,confirmdate,subscribedate,bounced,unsubscribed from my.ve where sync<>1');
while($r=mysql_fetch_assoc($q))
{
	$t=split('@',$r['emailaddress']);
	$d=$t[1];
	
	mysql_query("insert into email_list_subscribers 
	(listid,emailaddress,domainname,format,confirmed,confirmcode,requestdate,confirmdate,subscribedate,bounced,unsubscribed) values (
	1
	,'".$r['emailaddress']."'
	,'@".$d."'
	,'h'
	,1	
	,'676de7c3602caf5546a2797f8432be99'
	,'".$r['requestdate']."'
	,'".$r['confirmdate']."'
	,'".$r['subscribedate']."'
	,'".$r['bounced']."'
	,'".$r['unsubscribed']."'	
	)");
	
	$id = mysql_insert_id();
	
	$qq=mysql_query("select * from my.ved where subscriberid=".$r['subscriberid']);
	while($rr=mysql_fetch_assoc($qq))
	{	
		mysql_query("insert into email_subscribers_data (`subscriberid`,`fieldid`,`data`) values ('".$id."','".$rr['fieldid']."','".$rr['data']."')");
	}
	
	mysql_query("update my.ve set sync=1 where subscriberid=".$r['subscriberid']);
	
	//echo $id.'\r\n';
}
*/
?>