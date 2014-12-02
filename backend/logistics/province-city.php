<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
need_manager();
need_auth('admin');
	if(isset($_POST['countrystate'])){
		$countrystate = @$_POST['countrystate'];
		
		if(@$_POST['act']=="add" && @$countrystate['name']!="" ){
				$sql = "INSERT INTO countries_state(name, country_code, display)VALUES('".add_input($countrystate['name'])."','".$countrystate['country_code']."','".$countrystate['active']."')";
				DB::Query($sql);
				redirect( WEB_ROOT . '/backend/logistics/province-city.php');
		}elseif(@$_POST['act']=="update"){
			foreach($countrystate as $key => $val){
				if($val['id']==$key){
					$sql = "UPDATE countries_state	SET	
						name='".add_input($val['name'])."',
						country_code='".$val['country_code']."',
						slug = '".make_keyword($val['name'])."',
						display='".$val['active']."' 
					WHERE id=$key";
					DB::Query($sql);
				}
			}
			redirect( WEB_ROOT . '/backend/logistics/province-city.php');
		}elseif(@$_POST['act']=="delete"){
			foreach($countrystate as $key => $val){
				if($val['id']==$key){
					DB::Query("DELETE FROM countries_state WHERE id=$key");
					DB::Query("DELETE FROM countries_district WHERE state_id=$key");
				}
			}
			redirect( WEB_ROOT . '/backend/logistics/province-city.php');
		}
	}else{
		$str = DB::LimitQuery('countries_state', array(
			'order' => 'ORDER BY name ASC',
			'size' => $pagesize,
			'offset' => $offset,
		));
	}
	
include template('logistics/manage_province_city_list');