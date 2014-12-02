<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
need_manager();
need_auth('admin');
$where = "";
if(isset($_GET['city_id'])){
	$city_id = (int)$_GET['city_id'];
	$where .="AND category.id = {$city_id} ";	
}else{
	$city_id = $city['id'];
}
if(isset($_GET['dist_id']) && (int)$_GET['dist_id']>0){
	$dist_id = $_GET['dist_id'];
	$where =  "AND district.dist_id = {$dist_id}";
}else{
	$dist_id=0;	
}
if(isset($_GET['ward_id']) && (int)$_GET['ward_id']>0){
	$ward_id = $_GET['ward_id'];
	//$ids = DB::GetQueryResult("SELECT id FROM ward WHERE dist_id = {$dist_id} ORDER BY id ASC",false);
	//if($ward==$ids[0]['id'])	
	$where .=" AND ward.id = {$ward_id}";
}else{
	$ward_id=0;	
}
if(isset($_GET['street_id']) && (int)$_GET['street_id']>0){
	$street_id = (int)$_GET['street_id'];
	$street = DB::GetQueryResult("SELECT name FROM streets WHERE id=".(int)$street_id);
}else{
	$street_id = 0;	
}
if($city_id>0 && $dist_id>0 && $ward_id>0 && $street_id>0){
	$action	= "/backend/logistics/streets.php?city_id={$city_id}&dist_id={$dist_id}&ward_id={$ward_id}&street_id={$street_id}";
	if(isset($_GET['del']) && $_GET['del']=='true'){
		DB::Query("DELETE FROM zones WHERE city_id='".(int)($city_id)."' AND dist_id='".(int)($dist_id)."' AND ward_id='".(int)($ward_id)."' AND street_id='".(int)($street_id)."'");
		Session::Set('notice', "Delete successfully");
		redirect(WEB_ROOT . "/backend/logistics/streets.php?city_id={$city_id}&dist_id={$dist_id}&ward_id={$ward_id}");
	}
}else{
	$action = "/backend/logistics/streets.php";	
}
if(isset($_POST['Editcommit'])){
	DB::Query("UPDATE streets SET name='".trim($_POST["name"])."', keyword='".make_keyword($_POST["name"])."' WHERE id = {$street_id}");
	DB::Query("UPDATE zones SET city_id='".trim($_POST["city_id"])."', dist_id='".trim($_POST["dist_id"])."',ward_id='".trim($_POST["ward_id"])."',street_id='".trim($_POST["street_id"])."' WHERE id = {$street_id}");
	Session::Set('notice', 'Edit successfully');
	redirect(WEB_ROOT . "/backend/logistics/streets.php?city_id={$city_id}&dist_id={$dist_id}&ward_id={$ward_id}");
}elseif(isset($_POST['Addcommit'])){
	$arr_name = explode(",",$_POST['name']);
	
	for($i=0;$i<count($arr_name);$i++){
		$keyword = make_keyword(trim($arr_name[$i]));
		$check = DB::GetQueryResult("SELECT id FROM streets WHERE keyword='".$keyword."'");
		if((int)$check['id']==0){
			$table = new Table('streets', $_POST);
			$table->create_time = date("Y-m-d H:i:s", time());
			$table->user_id = $login_user_id;
			$table->name = trim($arr_name[$i]);
			$table->keyword = $keyword;
			$table->status = (strtoupper($table->status)=='A') ? 'A' : 'D';
			$insert=array(
				'name', 'keyword', 'status', 'create_time', 'user_id',
			);
			
			if (!$table->id) {
				$table->SetPk('id', null);
				if ($flag = $table->update($insert)) {
					$street_id = abs(intval($table->id));
					$zones_table = new Table ('zones',$_POST);
					$zones_table->street_id = $street_id;
					$zones_table->user_id = $login_user_id;
					$zones_table->create_date = date("Y-m-d H:i:s", time());
					$zones_table->status = (strtoupper($zones_table->status)=='A') ? 'A' : 'D';
					$zones_table->insert(array(
						'city_id', 'dist_id', 'ward_id', 'street_id', 'create_date', 'user_id','status'
					));
				}
				$dist_id = $zones_table->dist_id; $ward_id = $zones_table->ward_id; 
				Session::Set('notice', 'Insert successfully');
				$link = WEB_ROOT . '/backend/logistics/streets.php?dist_id='.$dist_id.'&ward_id='.$ward_id;
			}
		}else{
			$check_zones = DB::GetQueryResult("SELECT id FROM zones WHERE city_id='".(int)$_POST['city_id']."' AND dist_id='".(int)$_POST['dist_id']."' AND ward_id='".(int)$_POST['ward_id']."' AND street_id='".(int)$check['id']."'");
			if($check_zones['id']==0){
				$zones_table = new Table ('zones',$_POST);
				$zones_table->street_id = (int)$check['id'];
				$zones_table->user_id = $login_user_id;
				$zones_table->create_date = date("Y-m-d H:i:s", time());
				$zones_table->status = (strtoupper($zones_table->status)=='A') ? 'A' : 'D';
				$zones_table->insert(array(
					'city_id', 'dist_id', 'ward_id', 'street_id', 'create_date', 'user_id','status'
				));
				$dist_id = $zones_table->dist_id; $ward_id = $zones_table->ward_id; 
				Session::Set('notice', 'Record Added successfully');
				$link = WEB_ROOT . '/backend/logistics/streets.php?dist_id='.$dist_id.'&ward_id='.$ward_id;
			}
		}
	}
	redirect($link);
}
$accept_id = array(1,150755);
if($dist_id==0 || $ward_id==0){
	$count = DB::GetQueryResult("SELECT count(s.id) as total_street FROM streets as s INNER JOIN zones as z ON z.street_id=s.id");
	list($pagesize, $offset, $pagestring) = pagestring($count['total_street'], 25);
	$limit =  "LIMIT {$offset},{$pagesize}";
}
if(!in_array($login_user_id,$accept_id)){
	 $and = "AND zones.user_id={$login_user_id}	";
}else{
	$and = "";	
}


$str = DB::GetQueryResult("SELECT `zones`.city_id, `zones`.dist_id, `zones`.ward_id, `zones`.street_id, countries_state.`name` as city_name, countries_district.dist_name, countries_ward.ward_name, streets.`name` as street_name FROM zones
INNER JOIN streets ON streets.id = zones.street_id
INNER JOIN countries_ward ON countries_ward.id = zones.ward_id
INNER JOIN countries_district ON countries_district.dist_id = zones.dist_id
INNER JOIN countries_state ON countries_state.id = zones.city_id
WHERE 1 {$and} {$where} ORDER BY dist_name ASC, ward_name ASC {$limit}",false);


/*$str = DB::LimitQuery('streets', array(
	'condition' => $condition,
	'order' => 'ORDER BY name ASC',
	'size' => $pagesize,
	'offset' => $offset,
));*/
include template('logistics/manage_street_create');