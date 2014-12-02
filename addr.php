<?php

/*$str = '112/123/145 bau cat 3 p.8';
//$pat = '/([0-9a-zA-Z\/\-_]+\s)+([\w\s\]+)([\.,pqfPQF]+)/';
$pat = '/([0-9]+[\/\-_]+[0-9a-zA-Z]+)+(\s)+([\w\s]+)([\.,\s]+[pqfPQF])/';
preg_match($pat,$str,$match);
foreach($match as $v)
{
	echo $v . '<br>';
}
die();*/

require_once(dirname(__FILE__) . '/app.php');


$pat = '/';
$pat .= '(.*)?([0-9][a-zA-Z]?[\s-,])+';
//$pat .= '([\w\s]+)+';
$pat .= '([^,pqfPQF]*)';
$pat .='(.*)';
//$pat .= '([\.,\s-]+[pqfPQF]+)?';
$pat .='/';

echo $pat . '<br>';

//$pat = '/([0-9]+[/\-_]+[0-9a-zA-Z]+)(\s)+([\w\s]+)([\.,\s]+[pqfPQF])/';



//fetch streets from table streets
$st = DB::LimitQuery('streets', array(
	'select' => 'keyword,name',	
));

foreach($st as $v)
{
	$rs = DB::LimitQuery('order', array(
		'select' => 'id',	
		'condition' => "address LIKE '%".$v['keyword']."%' OR address LIKE '%".$v['name']."%'"
	));
	
	if(!empty($rs))
	{
		foreach($rs as $vv)
		{			
			Table::UpdateCache('order', $vv['id'],array('add_street'=>$v['name']));
		}		
	}
	
}

/*

//addresses does not existed in table streets, do insert
$st = DB::LimitQuery('order', array(
	'select' => 'id,address',	
	'condition' => 'isnull(add_street)',
));

foreach($st as $v)
{	
	preg_match($pat,$v['address'],$match);
	echo $v['address'] . '<font color=red>===>---' .$match[3]. '</font><font color=green>-------' .$match[2]. '--------' .$match[3].'--------' .$match[4]. '</font><br>';	
}	


*/

die();






$al = DB::LimitQuery('order', array(
	'select' => 'address',
	'condition' => array('dist_id'=>490)
));


foreach($al as $v)
{
	$add = $v['address'];
	/*$add_keyword = make_keyword($add);
	
	$rs = DB::LimitQuery('streets', array(
		'select' => 'name',
		'condition' =>array("keyword LIKE '%".$add_keyword."%'")
	));	*/
	
	if($rs)
	{
		echo $rs['name'];
	}else{	
	
		preg_match($pat,$add,$match);
		echo $v['address'] . '<font color=red>===>---' .$match[3]. '</font><font color=green>-------' .$match[2]. '--------' .$match[3].'--------' .$match[4]. '</font><br>';
	}	
	//echo $v['address'] . '--------<font color="red">' .$match[3]. '</font><br>'; 
	
	/*
	if($match[4])
	{
		$add_key = make_keyword($match[4]);
		
		//DB::Insert('street', array('word'=>$add_key,'name'=>$match[4]));
	
	}
	*/
	//echo '-----------------------------------------------------<br>';
	//var_dump($match);
}


function make_keyword($string,$keepcase=false)
{
	if ($string == '')	return '';	

	//--Start processing ---/
	$arr_search  = array(
							"á","à","ả","ã","ạ"   ,"â","ấ","ầ","ẩ","ậ","ẫ"   ,"ă","ắ","ằ","ẵ","ặ","ẳ"

						   ,"Á","À","Ả","Ã","Ạ"   ,"Â","Ấ","Ầ","Ẩ","Ậ","Ẫ"   ,"Ă","Ắ","Ằ","Ẵ","Ặ","Ẳ"   

						   ,"é","è","ẻ","ẽ","ẹ"   ,"ê","ế","ề","ể","ệ","ễ"	

						   ,"É","È","Ẻ","Ẽ","Ẹ"   ,"Ê","Ế","Ề","Ể","Ệ","Ễ"   

						   ,"ó","ò","ỏ","õ","ọ"   ,"ơ","ớ","ờ","ở","ỡ"   ,"ợ","ô","ố","ồ","ổ","ỗ","ộ"  

						   ,"Ó","Ò","Ỏ","Õ","Ọ"   ,"Ơ","Ớ","Ờ","Ở","Ỡ"   ,"Ợ","Ô","Ố","Ồ","Ổ","Ỗ","Ộ"   

						   ,"ú","ù","ủ","ũ","ụ"   ,"ư","ứ","ừ","ử","ữ","ự"

						   ,"Ú","Ù","Ủ","Ũ","Ụ"   ,"Ư","Ứ","Ừ","Ử","Ữ","Ự"

						   ,"í","ì","ỉ","ĩ","ị"   ,"ý","ỳ","ỷ","ỹ","ỵ"

						   ,"Í","Ì","Ỉ","Ĩ","Ị"   ,"Ý","Ỳ","Ỷ","Ỹ","Ỵ"

						   ,"đ","Đ"									  

						);

	$arr_replace = array(

							"a","a","a","a","a"   ,"a","a","a","a","a","a"   ,"a","a","a","a","a","a" 

						   ,"A","A","A","A","A"   ,"A","A","A","A","A","A"   ,"A","A","A","A","A","A" 

						   ,"e","e","e","e","e"   ,"e","e","e","e","e","e" 

						   ,"E","E","E","E","E"   ,"E","E","E","E","E","E"  

						   ,"o","o","o","o","o"   ,"o","o","o","o","o"   ,"o","o","o","o","o","o","o"  

						   ,"O","O","O","O","O"   ,"O","O","O","O","O"   ,"O","O","O","O","O","O","O"  

						   ,"u","u","u","u","u"   ,"u","u","u","u","u","u"

						   ,"U","U","U","U","U"   ,"U","U","U","U","U","U"

						   ,"i","i","i","i","i"   ,"y","y","y","y","y"

						   ,"I","I","I","I","I"   ,"Y","Y","Y","Y","Y"

						   ,"d","D"

						);	

	$string = trim($string);
	$string = str_replace($arr_search, $arr_replace, $string);	

	//$string = preg_replace("/[^a-z0-9\\040\\.\\-\\_&]/i","",$string);

	$string = preg_replace("/[^a-z0-9\\040]/i","",$string);

	//$string = preg_replace("/([ ]{1,9})/", '-', $string);	

	//$string = preg_replace('/\s+/', '-', $string);

	if($keepcase==false){
		$string = strtolower(trim($string));
	}

	//--End processing ---/

	return $string;

}

function clean_string($string){		

	//$string = preg_replace("/[^a-z0-9\\040\\.\\-\\_&]/i","",$string);	

	$string = preg_replace( '/[~!@#$%^&*()_\+\-=\[\]\{\}\'";:\?\/\.>,<]/i', ' ', $string );

	$string = preg_replace( '/\s+/', ' ', $string );

	$string = trim( $string );

	$string = strtolower( $string );	

	return $string;

}
?>