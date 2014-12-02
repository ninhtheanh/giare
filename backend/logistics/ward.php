<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
need_manager();
need_auth('admin');
	
	if(isset($_POST['countryward'])){
		$countryward = @$_POST['countryward'];
		if(@$_POST['act']=="add" && @$countryward['ward_name']!="" ){
			$sql = "INSERT INTO countries_ward(ward_name, dist_id,active)VALUES('".add_input($countryward['ward_name'])."',".(int)$countryward['dist_id'].",'".$countryward['active']."')";
			DB::Query($sql);
			redirect( WEB_ROOT . $_SERVER['REQUEST_URI']);
		}elseif(@$_POST['act']=="update"){
			foreach($countryward as $key => $val){
				if($val['id']==$key){
					$sql = "
					UPDATE countries_ward		
					SET dist_id='".(int)$val['dist_id']."',
						ward_name='".add_input($val['ward_name'])."',
						active='".$val['active']."' 
					WHERE id=$key";
					DB::Query($sql);
				}
			}
			redirect( WEB_ROOT . $_SERVER['REQUEST_URI']);
		}elseif(@$_POST['act']=="delete"){
			foreach($countryward as $key => $val){
				if($val['id']==$key){
					DB::Query("DELETE FROM countries_ward WHERE id=$key");
				}
			}
			redirect( WEB_ROOT . $_SERVER['REQUEST_URI']);
		}
	}else{
		
		$condition = array();
		$search=@$_REQUEST['search'];
		$dist = (int)$search['dist_id'];
		if($dist>0){
			$condition[] ="dist_id = {$dist}";
		}
		$scountry = $search['country_code'];
		$state = (int)$search['state_id'];
		if(!empty($scountry)){
			$s_country = $scountry;
		}
		$listcountry = LoadCountry($scountry);
		$liststate = LoadState($state,$s_country);
		$listdist = LoadDist($dist,$state,$s_country);
		$count = Table::Count('countries_ward', $condition);
		list($pagesize, $offset, $pagestring) = pagestring($count, 50);
		$str = DB::LimitQuery('countries_ward', array(
			'condition' => $condition,
			'order' => 'ORDER BY ward_name ASC',
			'size' => $pagesize,
			'offset' => $offset,
		));
	}
	
include template('logistics/manage_ward_list');