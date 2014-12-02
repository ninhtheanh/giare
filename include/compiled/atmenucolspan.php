<div style="width:1110px; margin:0px auto;clear: both;height: 26px;">
<div id="atboxmenu" style="text-align:left;width: 238px;float: left; clear:both;">
	<div class="atmenu-title" style="cursor:pointer; display: inline-block;">
    	<i class="icon icon-menu" style="margin: 14px 15px;"></i>
        <span style="line-height: 15px;margin-top: 14px;display: inline-block;">Ngành hàng</span>
    </div>
    <div class="atboxmenulist" style="position: absolute;z-index: 9999;background: #fff; display:none;">
    	<ul class="atlistmenu">
        	<?php  
				//echo at_current_top();
				leftMenuCategory();
			?>
        </ul>
    </div>
</div>
</div>
<style>
#atboxmenu:hover .atboxmenulist{
	display:block !important;
}
</style>
<script type="text/javascript">
/*  $(document).ready(function(){
	$('.atmenu-title').click(function(){
		$('.atboxmenulist').slideToggle('slow');
	});
});  */
</script>
<script>
$(document).ready(function(e) {
    $('.atlistmenu > li').hover(
	
	function(e) {
        $('.submenu').css('display','none');
		$(this).find('.submenu').css('display','block');
    },
	function(e){
		$('.submenu').css('display','none');
	});
});
</script>