<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
need_manager();
need_auth('admin');
if(isset($_GET['destid'])){
	$dest_id = (int)$_GET['destid'];
	$sql = "SELECT destination_name FROM destination WHERE destination_id=".$dest_id;
	$ds = DB::GetQueryResult($sql);
	$destination_name = $ds['destination_name'];
	//---COUNTRY_1ST-------------------------------
	$query = "SELECT country_name,country_code FROM countries WHERE status='A' AND country_code NOT IN (SELECT value FROM destination_detail WHERE type='C') ORDER BY country_name";
	$cs = DB::GetQueryResult($query, false);
	foreach($cs as $key => $value){
		$option_country_1st .= "<option value=".$value['country_code'].">".$value['country_name']."</option>";
	}
	//---CURRENT DESTINATION COUNTRY
	$query3 = "SELECT country_name,country_code FROM countries as country, destination_detail as dest WHERE country.country_code = dest.value AND type = 'C' AND destination_id = $dest_id ORDER BY country_name";
	$currcountry = DB::GetQueryResult($query3, false);
	foreach($currcountry as $key => $value){
		$country_curr .= "<option value='".$value['country_code']."'>".$value['country_name']."</option>";
	}
	//---STATE_1ST---------------------------------
	//$query1 = "SELECT country_name, id, `name` FROM countries as country, countries_state as state WHERE country.`status`='A' AND state.display='Y' AND country.country_code = state.country_code AND id NOT IN (SELECT value FROM destination_detail WHERE type='S') ORDER BY country_name, `name` ";
	$query1 = "SELECT country_name, id, `name` FROM countries as country, countries_state as state WHERE country.`status`='A' AND country.country_code = state.country_code AND id NOT IN (SELECT value FROM destination_detail WHERE type='S') ORDER BY country_name, `name` ";
	$ss = DB::GetQueryResult($query1, false);
	foreach($ss as $key => $value){
		$option_state_1st .= "<option value=".$value['id'].">".$value['country_name']." - ".$value['name']."</option>";
	}
	//---CURRENT DESTINATION STATE--------------------
	$query4 = "SELECT country_name,state.id, state.name FROM countries as country, countries_state as state, destination_detail as dest WHERE country.country_code = state.country_code AND dest.value = state.id AND type='S' AND destination_id = ".$dest_id." ORDER BY country.country_name, state.name";
	$curstate = DB::GetQueryResult($query4,false);
	foreach($curstate as $key => $value){
		$state_curr .= "<option value='".$value['id']."'>".$value['country_name']." - ".$value['name']."</option>";
	}
	//---DIST_1ST---------------------------------
	$query2 = "SELECT dist_name, dist.state_id, state.name, country.country_name, dist_id FROM countries as country, countries_state as state, countries_district as dist WHERE state.display='Y' AND country.country_code = state.country_code AND dist.state_id = state.id AND dist_id NOT IN (SELECT value FROM destination_detail WHERE type='T') ORDER BY dist.country_code, dist.state_id, dist_name";
	$dis = DB::GetQueryResult($query2,false);
	foreach($dis as $key => $value){
		$dist_1st .="<option value='".$value['dist_id']."'>".$value['country_name']." - ".$value['name']." - ".$value['dist_name']."</option>";
	}
	//---CURRENT DESTINATION DISTRICT--------------------
	$query5 = "SELECT country.country_name, state.name, dist.state_id, dist_name, dist_id FROM countries as country, countries_state as state, countries_district as dist, destination_detail as dest WHERE country.country_code = state.country_code AND state.id = dist.state_id AND dest.value = dist_id AND dest.type='T' AND destination_id = $dest_id ORDER BY state.name, dist.dist_name";
	$currdist = DB::GetQueryResult($query5,false);
	if(is_array($currdist)){
		foreach($currdist as $key => $value){
			$dist_curr .="<option value='".$value['dist_id']."'>".$value['country_name']." - ".$value['name']." - ".$value['dist_name']."</option>";
		}	
	}else{$dist_curr ="<option value=''>-</option>";}
	
	if(isset($_POST['destination'])){
		$value = "";
		$dest = @$_POST['destination'];
		//COUNTRY
		if(isset($dest['country']) && count(@$dest['country'])>0){
			for($i=0;$i<count(@$dest['country']);$i++)
				if($dest['country'][$i]!="")
					$value.="('".$dest_id."','".$dest['country'][$i]."','C'),";
		}
		//STATE
		if(isset($dest['state']) && count(@$dest['state'])>0){
			for($i=0;$i<count(@$dest['state']);$i++)
				if((int)$dest['state'][$i]>0)
					$value.="('".$dest_id."','".(int)$dest['state'][$i]."','S'),";
		}
		//DISTRICT
		if(isset($dest['dist']) && count(@$dest['dist'])>0){
			for($i=0;$i<count(@$dest['dist']);$i++)
				if((int)$dest['dist'][$i]>0)
					$value.="('".$dest_id."','".(int)$dest['dist'][$i]."','T'),";
		}
		$value = rtrim($value,",");
		if(!empty($value)){			
			DB::Query("DELETE FROM destination_detail WHERE destination_id=".$dest_id);
			DB::Query("INSERT INTO destination_detail(destination_id,value,type) VALUES {$value}");
		}
		redirect( WEB_ROOT . '/backend/logistics/destination.php?destid='.$dest_id);
	}
	include template('logistics/manage_destination_detail');
}else{
	if(isset($_POST['destination'])){
		$destination = @$_POST['destination'];
		if(@$_POST['act']=="add" && @$destination['destination_name']!="" ){
			$sql = "INSERT INTO destination(destination_name, status)VALUES('".add_input($destination['destination_name'])."','".$destination['active']."')";
			DB::Query($sql);
			redirect( WEB_ROOT . '/backend/logistics/destination.php');
		}elseif(@$_POST['act']=="update"){
			foreach($destination as $key => $val){
				if($val['destination_id']==$key){
					$sql = "
					UPDATE destination			
					SET destination_name='".add_input($val['destination_name'])."',
						status='".$val['active']."'
					WHERE destination_id=$key";
					DB::Query($sql);
				}
			}
			redirect( WEB_ROOT . '/backend/logistics/destination.php');
		}elseif(@$_POST['act']=="delete"){
			foreach($destination as $key => $val){
				if($val['destination_id']==$key){
					DB::Query("DELETE FROM destination WHERE destination_id=$key");
				}
			}
			redirect( WEB_ROOT . '/backend/logistics/destination.php');
		}
	}
	$str = DB::LimitQuery('destination', array(
		'order' => 'ORDER BY destination_name ASC',
		'size' => $pagesize,
		'offset' => $offset,
	));
	include template('logistics/manage_destination_list');
}
