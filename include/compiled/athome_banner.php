<link href="/static/css/number_slideshow.css" rel="stylesheet" type="text/css"></link>
<script type="text/javascript" src="/static/js/number_slideshow.js"></script>
<?php
$arrBanner = DB::LimitQuery('banner', array(
	'order' => 'ORDER BY `order`',
	'condition' => "banner_type = 'top' And activate = 1"
));
?>
<script language="javascript" type="text/javascript">
            $(function() {
                $("#number_slideshow").number_slideshow({
                    slideshow_autoplay: 'enable',//enable disable
                    slideshow_time_interval: 30000,
                    slideshow_window_background_color: "#fff",
                    slideshow_window_padding: '0',
                    slideshow_window_width: '871',
                    slideshow_window_height: '389',
                    slideshow_border_size: '0',
                    slideshow_transition_speed: 500, //'normal','slow','fast' or numeral
                    slideshow_border_color: 'none',
                    slideshow_show_button: 'enable',//enable disable
                    slideshow_show_title: 'disable',//enable disable
                    slideshow_button_border_size: '0'
                });
			});
</script>
<div id="number_slideshow" class="number_slideshow">
    <ul>
    	<?php foreach($arrBanner as $item){?>
		<li><a href="<?php echo $item['url']; ?>"><img src="<?php echo $item['img']; ?>" width="872" height="389" alt="slideshow"/></a></li>		     
		<?php }?>
     </ul>
    <ul class="number_slideshow_nav">
    	<?php foreach($arrBanner as $item){?>
        	<li><a href="#"> </a></li>
        <?php }?>
    </ul>
    <div style="clear: both"></div>
</div>
