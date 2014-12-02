<div id="atboxmenu">
	<div class="atmenu-title">
    	<i class="icon icon-menu"></i>
        <span>Ngành hàng</span>
    </div>
    <div class="atboxmenulist">    
    	<ul class="atlistmenu">
            <?php
				//echo at_current_top();
				//Home page
            	leftMenuCategory();
			?>
            <?php   /*
            <li class="parent">            
            	<a href="#"><i class="icon icon-thoitrang"></i> Thời trang</a>
            	<ul class="submenu">
                    <li><a href="#"><i class="icon icon-phukien"></i> Phụ kiện thời trang</a></li>
                    <li><a href="#"><i class="icon icon-nhahang"></i> Nhà hàng - Ẩm thực</a></li>
                    <li><a href="#"><i class="icon icon-suckhoe"></i> Sức khỏe - Làm đẹp</a></li>
                	
                </ul>
            </li>
            <li><a href="#"><i class="icon icon-phukien"></i> Phụ kiện thời trang</a></li>
            <li class="parent">            
            	<a href="#"><i class="icon icon-thoitrang"></i> Thời trang</a>
            	<ul class="submenu">
                    <li><a href="#"><i class="icon icon-phukien"></i> Phụ kiện thời trang</a></li>
                    <li><a href="#"><i class="icon icon-nhahang"></i> Nhà hàng - Ẩm thực</a></li>
                    <li><a href="#"><i class="icon icon-suckhoe"></i> Sức khỏe - Làm đẹp</a></li>                	
                </ul>
            </li>
            <li><a href="#"><i class="icon icon-nhahang"></i> Nhà hàng - Ẩm thực</a></li>
            <li><a href="#"><i class="icon icon-suckhoe"></i> Sức khỏe - Làm đẹp</a></li>
            <li><a href="#"><i class="icon icon-dulich"></i> Du khách - Khách sạn</a></li>
            <li><a href="#"><i class="icon icon-giaitri"></i> Giải trí - Đào tạo</a></li>
            <li><a href="#"><i class="icon icon-giadung"></i> Gia dụng - Nội thất</a></li>
            <li><a href="#"><i class="icon icon-congnghe"></i> Điện tử - Công nghệ</a></li>
            <li><a href="#"><i class="icon icon-mebe"></i> Mẹ và bé</a></li> 
            <li class="parent">            
            	<a href="#"><i class="icon icon-thoitrang"></i> Thời trang</a>
            	<ul class="submenu">
                    <li><a href="#"><i class="icon icon-phukien"></i> Phụ kiện thời trang</a></li>
                    <li><a href="#"><i class="icon icon-nhahang"></i> Nhà hàng - Ẩm thực</a></li>
                    <li><a href="#"><i class="icon icon-suckhoe"></i> Sức khỏe - Làm đẹp</a></li>
                	
                </ul>
            </li>
			*/ ?>
        </ul>
    </div>
</div>

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