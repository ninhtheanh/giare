<?php  
$uri =  $_SERVER['REQUEST_URI'];
$arrPage = DB::LimitQuery('page', array(
		'order' => 'ORDER BY page_type, `order`',
		'size' => $pagesize,
		'offset' => $offset,
	));	
?>
<style>
</style>
<div class="atbox_module">
    <div class="infotitle">THÔNG TIN HỮU ÍCH</div>
    <ul>
    	<?php
			$pages = getStaticPageGroup($arrPage, 'support');
			foreach($pages as $item)
			{					
			?>
            <li class="<?php  echo (trim($uri,'/')== $item['id'] . '.html')?'curent':''; ?>"><i class="cycle"></i><a title="cheapdeal.vn"  href="/<?php echo $item['id'];?>.html"><?php echo $item['name'];?></a></li>
		<?			
            }
        ?>
    </ul>
</div>
