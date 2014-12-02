<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
//header('Content-Type: application/xml; charset=UTF-8');

$cats =  array(
		1	=> '19,20,25', //an uong
		2	=> '23', // du lich
		3	=> '41', // lam dep
		4	=> '37', // giao duc
		5	=> '16', // giai tri
		6	=> '43', // ky thuat so
		7	=> '31', // spa thu gian
		8	=> '45', // dien thoai
		9	=> '49', // thoi trang
		26	=> '0', // khac
		27	=> '45', // hang gia dung
	);

$cities =  array(	
		'556'	=> '1',	
		'11'	=> '44',
	);


$daytime = strtotime(date('Y-m-d'));
$condition = array( 
		'team_type' => 'normal',
		"begin_time <= {$daytime}",
		"end_time > {$daytime}",
		);
$teams = DB::LimitQuery('team', array(
			'condition' => $condition,
			'order' => 'ORDER BY sort_order DESC, id DESC',			
			));

$oa = array();
$si = array(
		'sitename' => $INI['system']['sitename'],
		'wwwprefix' => $INI['system']['wwwprefix'],
		'imgprefix' => $INI['system']['imgprefix'],
		);

foreach($teams AS $one) {
	//$city = Table::Fetch('category', $one['city_id']);
	//$group = Table::Fetch('category', $one['group_id']);
	$item = array();
	//$item['loc'] = $si['wwwprefix'] . "/team.php?id={$one['id']}";
	$item['loc'] = $si['wwwprefix'].'/'.$city['slug'].'/'.seo_url($one['short_title'],$one['id'],$url_suffix);
	$item['data'] = array();
	$item['data']['display'] = array();

	$o = array();
	$o['website'] = $INI['system']['sitename'];
	$o['siteurl'] = $INI['system']['wwwprefix'];
	
	$o['city'] = $cities[$one['city_id']];
	//($o['city'] = $city['name']) || ($o['city'] = 'Toan Quoc');
	//$o['group'] = $group['name'];
	
	
	$o['title'] = $one['title'];
	$o['summary'] = $one['summary'];
	$o['notice'] = $one['notice'];
	$o['image'] = $si['imgprefix']  .'/static/' . $one['image'];
	$o['startTime'] = $one['begin_time'];
	$o['endTime'] = $one['end_time'];
	$o['value'] = $one['market_price'];
	$o['price'] = $one['team_price'];
	$o['discount'] = ceil(moneyit((100*($one['market_price'] - $one['team_price'])/$one['market_price'])));
	if ( $one['market_price'] > 0 ) {
		$o['rebate'] = moneyit(10*$one['team_price']/$one['market_price']);
	} else {
		$o['rebate'] = '0';
	}
	$o['bought'] = abs(intval($one['now_number']));

	$item['data']['display'] = $o;
	$oa[] = $item;
}
//var_dump($oa[0]);
?>
<xml version="1.0" encoding="utf-8">
<listdeals>
   <header> 
      <tendoanhnghiepdoitac>Dealsoc</tendoanhnghiepdoitac>
      <ngaytao><?php echo date('m/d/Y',time()); ?></ngaytao>
      <tongsotindang><?php echo sizeof($teams); ?></tongsotindang>	
   </header>
   <content>
       <Itemlist>
	   <?php foreach($oa as $v) { ?>
		<deal>
            <motangan><?php echo $v['data']['display']['title'] ?></motangan>
            <lienket><?php echo $v['loc'] ?></lienket>
            <hinhanh><?php echo $v['data']['display']['image'] ?></hinhanh>
            <giagoc><?php echo moneyit($v['data']['display']['value']) ?></giagoc>
            <phantram_khuyenmai><?php echo moneyit($v['data']['display']['discount']) ?></phantram_khuyenmai>
            <gia_khuyenmai><?php echo moneyit($v['data']['display']['price']) ?></gia_khuyenmai>
            <thoigian_batdau><?php echo date('m/d/Y',$v['data']['display']['startTime']) ?></thoigian_batdau>
            <thoigian_ketthuc><?php echo date('m/d/Y',$v['data']['display']['endTime']) ?></thoigian_ketthuc>
            <khuvuc_apdung>
                <khuvuc><?php echo $v['data']['display']['city'] ?></khuvuc>
            </khuvuc_apdung>
            <diemnoibat>
                <![CDATA[ <?php echo $v['data']['display']['summary'] ?> ]]>
            </diemnoibat>
            <dieukien>
                <![CDATA[ <?php echo $v['data']['display']['notice'] ?> ]]>
            </dieukien>
            <danhmuc_apdung>            
            	<danhmuc>1</danhmuc>
            </danhmuc_apdung>
         </deal>
		 <?php } ?>      
       </Itemlist>
   </content>
</listdeals>