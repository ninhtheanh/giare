<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi" lang="vi" dir="ltr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <?php if(!$pagetitle||$request_uri=='index'){?>
    <title> CheapDeal® | Cùng mua chung theo nhóm, mua hotdeal giá rẻ</title>
    <?php } else if($team) { ?>
    <title><?php $team_cat = Table::Fetch('category', $team['group_id']);; ?><?php echo $team['short_title']; ?> ® - C<?php echo $team['id']; ?> | <?php echo $team_cat['name']; ?></title>    
     <?php } else if(strpos($_SERVER['REQUEST_URI'],'/team/')!==false) { ?>
		<?php if($pagetitle=='Hàng nhập từ Mỹ' ){?>
       	<title>CheapDeal | Phiếu giảm giá cực rẻ Deal du lich</title> 
		<?php } else if($pagetitle=='Thời trang' ) { ?>
	  	<title>CheapDeal | Phiếu giảm giá cực rẻ Deal dịch vụ ăn uống, làm đẹp<?php echo $INI['system']['sitename']; ?> | <?php echo $city['name']; ?></title> 
		<?php } else if($pagetitle=='Deal thời trang mỹ phẩm' ) { ?>
		<title>CheapDeal | Phiếu giảm giá cực rẻ Deal deal thời trang, mỹ phẩm<?php echo $INI['system']['sitename']; ?> | <?php echo $city['name']; ?></title>
		<?php } else if($pagetitle=='Deal sản phẩm' ) { ?>
   		<title>CheapDeal | Phiếu giảm giá cực rẻ Deal sản phẩm<?php echo $INI['system']['sitename']; ?> | <?php echo $city['name']; ?></title>
		<?php } else if($pagetitle=='Deal gần đây' ) { ?>
  		<title>CheapDeal | Cùng mua chung theo nhóm, mua hot deal sản phẩm, dịch vụ, du lịch, phiếu giảm giá cực rẻ mỗi ngày tại <?php echo $INI['system']['sitename']; ?> | <?php echo $city['name']; ?></title>
		<?php } else { ?>
		<title><?php echo $pagetitle; ?><?php echo $INI['system']['sitename']; ?> | <?php echo $city['name']; ?></title> 
		<?php }?>
		<?php } else { ?>
        <title><?php echo $category['name']; ?><?php echo $page['name']; ?> CheapDeal® | Cung mua chung theo nhom, mua hotdeal voi gia cuc re</title> 
		<?php }?>
		<meta name="robots" content="noodp, noydir,index,follow">
		<meta name='revisit-after' content='1 days' />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="<?php echo $team['short_title']; ?>®" />
		<link id="canon" rel="canonical" href="/<?php echo seo_url($team['short_title'],$team['id'],$url_suffix); ?>" />
		<link id="headIMG" rel="image_src" href="<?php echo $INI['system']['wwwprefix']; ?>/static/<?php echo $team['image']; ?>" />
    <?php if(!$pagetitle||$request_uri=='index'){?>
    	 <meta name="description" content="CheapDeal cam kết mang lại sự chăm sóc đặc biệt cho khách hàng ghé thăm và mua hàng; đơn giản hóa mọi quá trình nhằm tiết kiệm thời gian, chi phí." />
    
	<!-- Change [] to <> if you want to use seo_description
	[?php } else if($seo_description) { ?]
        <meta name="description" content="[?php echo $team['short_title']; ?], [?php echo $seo_description; ?] [?php echo ($_GET['comment']) ? ' thảo luận deal' : '';; ?] [?php echo $city['name']; ?]" />
	-->
	
	<?php } else if($team) { ?>
    <meta name="description" content="<?php echo $team['short_title']; ?>® - <?php echo cut_string(strip_tags($team['title']),150,""); ?> [xem thêm]"/>
    <?php } else if(strpos($_SERVER['REQUEST_URI'],'/team/')!==false) { ?>
		<?php if($pagetitle=='Deal du lịch' ){?>
        <meta name="description" content="Hot <?php echo $pagetitle; ?> tour du lich travel, tour du lịch mới nhất tại các khu du lịch trong nước và thế giới giảm giá cực rẻ đến 90% tại<?php echo $city['name']; ?> - trang <?php echo ($_GET['page']) ? $_GET['page'] : 1;; ?>" />
		<?php } else if($pagetitle=='Deal dịch vụ' ) { ?>
		<meta name="description" content="Hot <?php echo $pagetitle; ?>, Thưởng thức các món ăn ngon, lạ và các địa điểm ăn uống với giá cực rẻ. Các dịch vụ chăm sóc Sức khỏe - Làm đẹp được giảm giá tại<?php echo $city['name']; ?> - trang <?php echo ($_GET['page']) ? $_GET['page'] : 1;; ?>" />
		<?php } else if($pagetitle=='Deal thời trang mỹ phẩm' ) { ?>
		<meta name="description" content="Hot <?php echo $pagetitle; ?>, Khuyến mãi giảm giá thời trang mỹ phẩm quần áo, giày, mắt kính, trang sức tại trêngiảm giá tới 90% tại <?php echo $city['name']; ?> - trang <?php echo ($_GET['page']) ? $_GET['page'] : 1;; ?>" />
		<?php } else if($pagetitle=='Deal sản phẩm' ) { ?>
		<meta name="description" content="Hot <?php echo $pagetitle; ?>, CheapDeal khuyến mãi giảm giá nước hoa, bảo hiểm, chăn dra gối nệm, đồ chơi, túi xách và phụ kiện trêngiảm giá đến 90% tại <?php echo $city['name']; ?> - trang <?php echo ($_GET['page']) ? $_GET['page'] : 1;; ?>" />
		<?php } else if($pagetitle=='Deal gần đây' ) { ?>
		<meta name="description" content="Hot <?php echo $pagetitle; ?>, Deals sản phẩm, dịch vụ, du lịch được bán giảm giá cực rẻ gần đây trên| <?php echo $city['name']; ?> - trang <?php echo ($_GET['page']) ? $_GET['page'] : 1;; ?>" />
		<?php } else { ?>
			<meta name="description" content="<?php echo $pagetitle; ?>, CheapDeal khuyến mãi giảm giá Cùng nhóm mua chung hotdeal du lịch giảm giá cực rẻ tới 90% <?php echo $city['name']; ?>" />
		<?php }?>
    <?php } else { ?>
        <?php if($pagetitle=='Về Cheap Deal' ){?>
            <meta name="description" content="Cheapdeal là công ty chuyên cung cấp các sản phẩm, dịch vụ, giải trí, du lịch với mục tiêu mang lại giá rẻ nhất đem đến cho khách hàng sự hài lòng và tin cậy cao" />
        <?php } else if($pagetitle=='Hỏi đáp' ) { ?>
            <meta name="description" content="Những câu hỏi thường gặp khi mua hàng và nhận giải đáp về các deal đã, đang và sắp diễn ra trên Cheapdeal.vn" />
        <?php } else if($pagetitle=='Hướng dẫn mua hàng' ) { ?>
            <meta name="description" content="Hướng dẫn khách hàng mua hàng, phương thức thanh toán, thời gian nhận hàng và bất kỳ vấn đề gì liên quan đến mua hàng tại Cheapdeal.vn" />
        <?php } else if($pagetitle=='Liên hệ' ) { ?>
            <meta name="description" content="Thông tin liên hệ CTY CP TM Cheapdeal 137/5A Lê Văn Sỹ P 13 Q Phú Nhuận TPHCM ĐT 08-3991 4018" />
        <?php } else if($pagetitle=='Điều khoản sử dụng' ) { ?>
            <meta name="description" content="Những qui định bắt buộc người tham gia mua hàng tạiphải tuân thủ" />
        <?php } else if($pagetitle=='Tuyển dụng' ) { ?>
            <meta name="description" content="Tham gia cùng đại gia đình Cheapdeal cùng phát triển tương lai" />
        <?php } else if($pagetitle=='Hợp tác với Cheapdeal' ) { ?>
            <meta name="description" content="Bạn sẽ được đảm bảo về hiệu quả kinh doanh và kết quả marketing. Bạn không tốn chi phí trả trước, không tốn nhân sự, nguồn lực marketing" />
        <?php } else if($pagetitle=='Thông báo' ) { ?>
            <meta name="description" content="Thông báo những tình trạng của các deal đang bán hoặc đã bán tại Cheapdeal.vn. hãy nhóm mua chung những hotdeal, cùng mua các deal sản phẩm và dịch vụ,..." />
        <?php } else { ?>
            <meta name="description" content="<?php echo cut_string(strip_tags($page['value']),150,"[xem thêm]"); ?>" />
        <?php }?>
	<?php }?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <?php if(!$pagetitle||$request_uri=='index'){?>
     	<meta name="keywords" content="<?php echo $team['short_title']; ?>cheapdeal, cungmua, hotdeal, thoi trang, tui xach" />
    <?php } else if($seo_keyword) { ?>
	<meta name="keywords" content="<?php echo $seo_keyword; ?>, <?php echo ($_GET['comment']) ? 'thảo luận' : '';; ?>" />
    <?php } else if($team) { ?>
        <meta name="keywords" content="<?php echo $partner['title']; ?>, <?php echo $team['short_title']; ?> <?php echo ($_GET['comment']) ? ' thảo luận deal' : ' ';; ?>" />
   <?php } else if(strpos($_SERVER['REQUEST_URI'],'/team/')!==false) { ?>
		<?php if($pagetitle=='Deal du lịch' ){?>
        <meta name="keywords" content="du lich, dulich,tour, travel ,Cheapdeal, deals,khuyen mai, <?php echo $pagetitle; ?>, du lịch giá rẻ, du lịch tiết kiệm,gia re,<?php echo $city['name']; ?>" />
		<?php } else if($pagetitle=='Deal dịch vụ' ) { ?>
	 	<meta name="keywords" content="<?php echo $pagetitle; ?>, deal ăn uống, deal làm dẹp, deal spa, deal giải trí, sức khỏe, làm đẹp," />
		<?php } else if($pagetitle=='Deal thời trang' ) { ?>
		<meta name="keywords" content="<?php echo $pagetitle; ?>, mỹ phẩm giá rẻ, mua theo nhom, mua hang theo nhom, <?php echo $city['name']; ?>" />
		<?php } else if($pagetitle=='Deal sản phẩm' ) { ?>
		<meta name="keywords" content="<?php echo $pagetitle; ?> giá rẻ, sản phẩm giảm giá, sản phẩm độc đáo <?php echo $city['name']; ?>" />
		<?php } else if($pagetitle=='Deal gần đây' ) { ?>
		<meta name="keywords" content="<?php echo $pagetitle; ?> giá tốt, sản phẩm gần đây tiện dụng <?php echo $city['name']; ?>" />
		<?php } else { ?>
		<meta name="keywords" content="<?php echo $pagetitle; ?> trang <?php echo ($_GET['page']) ? $_GET['page'] : 1;; ?> <?php echo $city['name']; ?>" />
		<?php }?>
 	<?php } else { ?>
        <meta name="keywords" content="<?php echo $category['name']; ?><?php echo $page['name']; ?>" />
	<?php }?>
	<link href="<?php echo $INI['system']['wwwprefix']; ?>/feed.php?ename=<?php echo $city['ename']; ?>" rel="alternate" title="subscription update" type="application/rss+xml" />
	
	<link rel="shortcut icon" href="/static/icon/favicon.ico" />
	<link rel="stylesheet" href="/static/css/deal_all.css" type="text/css" media="screen" charset="utf-8" />
    <link href="/static/css/nivo-slider.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/static/css/jquery.autocomplete.css" />
    <script type="text/javascript">var WEB_ROOT = '<?php echo WEB_ROOT; ?>';var LOGINUID= '<?php echo abs(intval($login_user_id)); ?>';</script>
   
	<script src="/static/js/jquery.min.js" type="text/javascript"></script>
     <script src="/static/js/index.js" type="text/javascript"></script>
    <script type="text/javascript" src="/static/js/jquery.nivo.slider.pack.js"></script>
    <script type='text/javascript' src="/static/js/jquery.autocomplete.js"></script>
    <script type='text/javascript' src="/static/js/jquery.lazyload.js"></script>
<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
  _fbq.push(['addPixelId', '249635345231612']);
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', 'PixelInitialized', {}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=249635345231612&amp;ev=NoScript" /></noscript>
		
    <script type="text/javascript">
	$(document).ready(function(){
		 $("img.loadlazy").lazyload({
            effect : "fadeIn"
        }); 
		
	});
    $(window).load(function() {
		
    //    $('#slider').nivoSlider();
	//	$("#sd").autocomplete('/team/autosearch.php',{width: 260, selectFirst: false});
	
    });
    </script>
	<style type="text/css">
			.searchcontent_box {
				width:270px;
				height:38px;
				margin: -5px auto 0 auto;
				background: #ffffff url("/static/img/search-box.gif") no-repeat top left;
			}
			.searchcontent_box .searchcontent_formbox {
				width:260px;
				height:28px;
				padding:5px;
			}
			.searchcontent_box .searchcontent_formbox .searchcontent_formbox1 {
				width:202px;
				height:28px;
				float:left;
			}
			.searchcontent_box .searchcontent_formbox .searchcontent_formbox1 .searchcontent_formtextbox {
				width:197px; 
				height:25px;
				font:14px Arial, Helvetica, sans-serif;
				border: 1px solid #ffffff;
				padding:0 0 0 5px;
			}
			*html .searchcontent_box .searchcontent_formbox .searchcontent_formbox1 .searchcontent_formtextbox {
				width:197px; 
				height:22px;
				padding:3px 0 0 5px;
			}
*+html .searchcontent_box .searchcontent_formbox .searchcontent_formbox1 .searchcontent_formtextbox {
	width:197px; 
	height:22px;
	padding:3px 0 0 5px;
}
.searchcontent_box .searchcontent_formbox .searchcontent_formbox2 {
	width:58px;
	height:28px;
	float:left;
}
.searchcontent_box .searchcontent_formbox .searchcontent_formbox2 .searchcontent_formbtn {
	width:58px;
	height:27px;
	border:0;
	background: #e6e6e6 url("/static/img/search-button.gif") no-repeat top left;
}
.theme-default #slider {
			margin: 0px auto 0 auto;
			width:983px;
			height:100px;
		}
		.theme-pascal.slider-wrapper,
		.theme-orman.slider-wrapper {
			margin-top:10px;
		}
		.clear {
			clear:both;
		}
		.aListBPLine{width:235px;display:block;top:0px;z-index:10;left:0px;position:relative;}
		.aListBPLine h3{font-size:12px;color:#00CCFF;padding-left:5px; padding-top:5px;}
		.dInfoBRNew{width:225px;margin:auto;border:1px solid #bfbfbf;margin:5px 0 0 5px; position:relative; height:168px}
		.dSOListBRN{position:absolute;background:transparent url(/static/css/images/imggiam.png) no-repeat;width:52px;height:50px;right:3px;}
		.dSOListBRN .div_TietKiem {height:42px;padding:3px 0 0 0;text-align:center;width:59px;}
		.PriceDealBRL{ padding-left:5px; padding-right:3px; padding-bottom:5px;}
		.PriceDealBRL .divPrice{padding:2px 0 0 5px; white-space:nowrap; color:#fff;font-size:12px; font-family:Arial, Helvetica, sans-serif; background-color:#53beea;line-height:18px;}
		.PriceDealBRL .div_infoMoney{padding:2px 0 0 5px; background-color:#53beea;line-height:20px;}
		.PriceDealBRL .strTextVND{margin-left:36px;}.PriceDealBRL .div_TextInfoMoney{width:auto;}
		.styleText14{
			font-size:12px; font-family:Arial, Helvetica, sans-serif; text-align:center
		}
		.styleText15{
			font-size:16px; font-family:Arial, Helvetica, sans-serif;text-shadow:0 1px 1px rgba(0, 0, 0, 0.7); padding-left:5px;
		}
		.styleText16{
			font-size:7px; font-family:Arial, Helvetica, sans-serif
		}
		.styleText17{
			font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#fff
		}
		.styleText13{
			font-size:13px; font-family:Arial, Helvetica, sans-serif
		}
		.styleText5{
			font-size:16px; font-family:Arial, Helvetica, sans-serif;text-shadow:0 1px 1px rgba(0, 0, 0, 0.5); color:#fff; letter-spacing:0px; font-weight:800
		}
		.pLineDotted{width:225px;margin-left:2px; margin-top:3px; opacity:0.5;filter:alpha(opacity=50);}
		.pGiaTienID{
			text-align:center; font-family:Arial, Helvetica, sans-serif
		}
    </style>
    <?php if(empty($city)){?>
		<style type="text/css">
        #fade { /*--Transparent background layer--*/
                display: none; /*--hidden by default--*/
                background: #000;
                position: fixed; left: 0; top: 0;
                width: 100%; height: 100%;
                opacity: .80;
                z-index: 9999;
        }
		.popup_block{
                display: none; /*--hidden by default--*/
                background: #F1F3F5;
                padding: 2px;
                border: 10px solid #F4a515;
                float: left;
                font-size: 1.2em;
                position: fixed;
                top: 50%; left: 50%;
                z-index: 99999;
                /*--CSS3 Box Shadows--*/
                -webkit-box-shadow: 0px 0px 10px #000;
                -moz-box-shadow: 0px 0px 10px #000;
                box-shadow: 0px 0px 10px #000;
                /*--CSS3 Rounded Corners--*/
                -webkit-border-radius: 10px;
                -moz-border-radius: 10px;
                border-radius: 10px;
        }
        img.btn_close {
                float: right;
                margin: -30px -48px -10px 0;
        }
        /*--Making IE6 Understand Fixed Positioning--*/
        *html #fade {
                position: absolute;
        }
        *html .popup_block {
                position: absolute;
        }
        </style> 
    
    
    <script type="text/javascript">
	$(document).ready(function(){
																		  
			/*When you click on a link with class of poplight and the href starts with a # */
		   var popID = "popup_name"; /*Get Popup Name*/
			var popURL = "#?w=600"; /*Get Popup href to define size*/
			
							
			//Pull Query and Variables from href URL
			var query= popURL.split("?");
			var dim= query[1].split("&amp;");
			var popWidth = dim[0].split('=')[1];/*Gets the first query string value*/
		
			/*Fade in the Popup and add close button*/
			
			
			$('#' + popID).fadeIn().css({ 'width': Number( popWidth ) }).prepend('');
			
			/*Define margin for center alignment (vertical + horizontal) - we add 80 to the height/width to accomodate for the padding + border width defined in the css*/
			var popMargTop = ($('#' + popID).height() + 40) / 2;
			var popMargLeft = ($('#' + popID).width() + 40) / 2;
			
			/*Apply Margin to Popup*/
		
			$('#' + popID).css({ 
					'margin-top' : -popMargTop,
					'margin-left' : -popMargLeft
			});
			
			/*Fade in Background*/
			//$('body').append('<div id="fade"></div>'); /*Add the fade layer to bottom of the body tag.*/
			
		//	$('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn(); /*Fade in the fade layer */
		
		
			/*
			//Close Popups and Fade Layer
			$('a.close').live('click', function() { //When clicking on the close or fade layer...
					  $('#fade , .popup_block').fadeOut(function() {
							$('#fade, a.close').remove();  
			}); //fade them both out
			*/
			 //Close Popups and Fade Layer
			$('a.close').live('click', function() { //When clicking on the close or fade layer...
					  $('.popup_block').fadeOut(function() {
							$('a.close').remove();  
			}); //fade them both out      
				return false;
			});
			$('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeOut(); /*Fade in the fade layer */
	 
			
	});
</script><?php }?>   
<script type="text/javascript">
$(function(){
/*  	var menu = $('#subm'), pos = menu.offset(), cicon = $('#cicon');	
	$(window).scroll(function(){			
		if($(this).scrollTop() > pos.top+menu.height()){
				menu.addClass('fixed');	
				//cicon.addClass('fixed2');				
		} else if($(this).scrollTop() <= pos.top){				
				menu.removeClass('fixed');	
				//cicon.removeClass('fixed2');		
		}			
	});	
	  */
	  
	  $("#showcart").click(function() {			
		X.get(jQuery(this).attr('href'));
		return false;
	});
	//buy
	jQuery('a.ataddcart').click(function () {			
		$(this).fadeTo(100,0.5).fadeTo(500,1);		
		var json =  X.get(jQuery(this).attr('href'));
		loadcartajax();
		return false;
	});	
	
	
});
function loadcartajax()
{
	$.get('/ajax/checkout.php?getdatastep=cartcount', function(data) { 		
			$('.product-number').html(data);
		});	
}
</script> 
<!-- -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-44278171-1', 'cheapdeal.vn');
  ga('send', 'pageview');

</script>
</head>
<body>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-TPL8PD"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TPL8PD');</script>
<!-- End Google Tag Manager -->

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="pagemasker"></div><div id="dialog"></div>
<div id="doc" align="center">

<!-- Piwik -->
<script type="text/javascript"> 
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://cheapdeal.vn/piwik//";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 1]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
    g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();

</script>
<noscript><p><img src="http://cheapdeal.vn/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
<!-- End Piwik Code -->


<!-- End Piwik Code -->

<!--- popup -->
<style type="text/css">
    #floating
    {
        z-index: 9999999;
        position: absolute;
        width: 600px;
        height: 420px;
        border: 0px !important;
    }
    #overPage
    {
        background: black;
        z-index: 9999999;
        position: absolute;
        left: 0;
        top: 0;
    }
</style>

<!--<div id="ctl00_ContentPlaceHolder1_Adv_Popup_pnAdv" style="display:none">
    <div id="overPage">
    </div>
  <div id="floating" >
        <a href="/tp-ho-chi-minh/deal-gia-hot/">
			
           <div style="margin:0 auto;background:url(http://cheapdeal.vn/static/banner/chuc-mung-nam-moi-2014.jpg) no-repeat center 0;width:600px;height:420px"></div> 
              <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" height="420" width="600">
                    <param name="movie" value="http:///ads/ads.swf"/>
                    <param name="quality" value="high"/>
                    <param name="wmode" value="transparent"/>
                    <embed src="http:///ads/ads.swf" wmode="transparent" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" height="420" width="600"/>
                </object>
        </a>
        <p style="float: right; position: relative;top:-438px; left:14px">
            <a href="javascript:closeMe();"><img src="http://cheapdeal.vn/static/banner/fancy_close.png"/></a>
        </p>
  </div>
</div>-->

<script language="javascript" type="text/javascript">
    function opennew(){
        var expire=new Date();
        expire=new Date(expire.getTime()+50000000);
        document.cookie="RSSgame=here; expires="+expire;
    }

    function GetCookie(name) {
          var arg=name+"=";
          var alen=arg.length;
          var clen=document.cookie.length;
          var i=0;
          while (i<clen) {
            var j=i+alen;
            if (document.cookie.substring(i,j)==arg)
              return "here";
            i=document.cookie.indexOf(" ",i)+1;
            if (i==0) break;
          }
          return null;
    }

    var visit=GetCookie("RSSgame");
    if (visit==null){
      $("#ctl00_ContentPlaceHolder1_Adv_Popup_pnAdv").show();
    }
        var lastScroll;
        var delay = 30;
        var speed = 50;
        var img_w = 490;
        var img_h = 360;
        function centerIt() {
            $("#overPage").css("width", $(window).width());
            $("#overPage").css("height", $(document).height());
            $("#floating").css("left", $(window).width() / 2 - img_w / 2);
            $("#floating").css("top", $(window).height() / 2 - img_h / 2 + $(document).scrollTop());
        }
        $(document).ready(function() {
            $("#overPage").css("opacity", 0.7);
            $("#overPage,#floating").show();
            centerIt();
        });
        $(window).scroll(function() {
            setTimeout(function() { ani(); }, delay);
            lastScroll = new Date().getTime();
        });
        $(window).resize(function() {
            centerIt();
        });
        function ani() {
            if ((new Date().getTime() - lastScroll) >= (delay - 20)) {
                $("#floating").animate({ top: ($(window).height() / 2 - img_h / 2 + $(document).scrollTop()) }, speed);
            }
        }
        function closeMe() {
            $("#overPage,#floating").hide();
            opennew();
        }
<!-- End of pop-up -->
</script>

