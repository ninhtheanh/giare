<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
need_manager();
need_auth('admin');
	
	if(isset($_POST['countrydist'])){
		$countrydist = @$_POST['countrydist'];
		if(@$_POST['act']=="add" && @$countrydist['dist_name']!="" ){
			$sql = "INSERT INTO countries_district(dist_name, state_id, country_code, status)VALUES('".add_input($countrydist['dist_name'])."',".(int)$countrydist['state_id'].",'".$countrydist['country_code']."','".$countrydist['active']."')";
			DB::Query($sql);
			redirect( WEB_ROOT . '/backend/logistics/district.php');
		}elseif(@$_POST['act']=="update"){
			foreach($countrydist as $key => $val){
				if($val['dist_id']==$key){
					$sql = "
					UPDATE countries_district		
					SET state_id='".(int)$val['state_id']."',
						dist_name='".add_input($val['dist_name'])."',
						country_code='".$val['country_code']."',
						status='".$val['active']."' 
					WHERE dist_id=$key";
					DB::Query($sql);
				}
			}
			redirect( WEB_ROOT . '/backend/logistics/district.php');
		}elseif(@$_POST['act']=="delete"){
			foreach($countrydist as $key => $val){
				if($val['dist_id']==$key){
					DB::Query("DELETE FROM countries_district WHERE dist_id=$key");
				}
			}
			redirect( WEB_ROOT . '/backend/logistics/district.php');
		}
	}else{
		
		$condition = array();
		$search=@$_REQUEST['search'];
		$scountry = $search['country_code'];
		$state = (int)$search['state_id'];
		if(!empty($scountry)){
			$condition[] ="country_code = '$scountry'";
			$s_country = $scountry;
			
		}
		if($state>0){
			$condition[] ="state_id = {$state}";
			
		}
		$listcountry = LoadCountry($scountry);
		$liststate = LoadState($state,$s_country);
		$count = Table::Count('countries_district', $condition);
		list($pagesize, $offset, $pagestring) = pagestring($count, 50);
		$str = DB::LimitQuery('countries_district', array(
			'condition' => $condition,
			'order' => 'ORDER BY dist_name ASC',
			'size' => $pagesize,
			'offset' => $offset,
		));
	}
	
include template('logistics/manage_district_list');