<?php if($INI['system']['googlemap'] && $partner['longlat']){?>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=<?php echo $INI['system']['googlemap']; ?>" type="text/javascript"></script>
<script type="text/javascript">
window.x_init_hook_gmp = function() {
	X.misc.showgooglemap = function() {
		X.get(WEB_ROOT+'/ajax/system.php?id=<?php echo $partner['id']; ?>&action=showgooglemap');
	};
};
</script>
<div class="mapbody map"><img src="http://maps.google.com/maps/api/staticmap?zoom=15&size=400x400&scale=1&maptype=roadmap&mobile=false&markers=<?php echo $partner['longlat']; ?>&sensor=true&language=en" border="0" /><a class="link" href="javascript:;" onclick="X.misc.showgooglemap();" title="click to check the complete map">Xem Bản đồ lớn</a></div>
<?php }?>
