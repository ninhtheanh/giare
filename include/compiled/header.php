<?php include template("html_header");?>
<style>
#form_nhanuudai{
	transition:all 0.5s ease;
	-webkit-transition:all 0.5s ease;
    -moz-transition:all 0.6s ease;
	opacity: 0; 
	height:0;
}
#athover:hover #form_nhanuudai{display:block;opacity:1; height:58px; overflow:hidden;}
</style>

<div id="top-menu-hotine">
	<div class="top-container">
        <ul class="nav cf" style="margin-top: 2px;">
            <li style="white-space: nowrap"><a href="/">Trang chủ</a></li>
            <li style="white-space: nowrap"><a href="/tp-ho-chi-minh/thoi-trang-nu" style="width:90px">Sản phẩm</a></li>
			<li style="white-space: nowrap"><a href="/lien-he.html">Liên hệ</a></li>
            <li style="white-space: nowrap"><a href="/hop-tac-mua-si.html">Hợp tác mua sỉ</a></li>
            <li style="white-space: nowrap"><a href="/tin-tuc.html">Tin tức</a></li>
            <li  style="white-space: nowrap" id="athover"><a id="nhanuudai" style="cursor:pointer;">Nhận ưu đãi</a>
                <div id="form_nhanuudai" style="background: #fff;box-shadow: 1px 1px 2px #6e6e6e;">
                    <form id="enter-address-form" action="/subscribe.php" method="post" class="validator">
                      <label for="textfield" style="display: block;text-align: left;margin-bottom: 8px;color: #87888c;">Nhận ưu đãi hằng ngày</label>
                      <input type="text" name="email" value="<?php echo $login_user['email']; ?>" id="textfield" placeholder="Nhập email của bạn" style="background: #fefefe;border: none;box-shadow: 1px 1px 7px #ccc inset;width: 250px;height: 36px;border-radius: 4px;padding-left: 10px;" />
                      <input class="button_emailrecied" type="submit" name="sm" value="Đăng ký" id="sm_form_nud" style="background: #65aa2d;border: 1px solid #589128;width: 85px;height: 38px;border-radius: 4px;box-shadow: 1px 1px 2px #ccc;font-weight: bold;color: #fff;text-shadow: 1px 1px #464745;" />
                    </form>
                </div>
            </li>
            <?php
            $sql = "Select promotion_category.id, promotion_type, promotion_value From promotion_category, promotion_product Where promotion_category.id = promotion_product.id_promotion_category 
            And promotion_category.activate = 1 And promotion_category.start_time <= CURDATE() And promotion_category.end_time >= CURDATE() LIMIT 0, 1;";
            $promotion_category = DB::GetQueryResult($sql);
            $id_promotion_category = $promotion_category['id'];
            //echo "<br>$id_promotion_category";
            if($id_promotion_category > 0)
            {            
            ?>
            <li style="white-space: nowrap"><a href="/khuyen-mai.html">Khuyến mãi</a></li>
            <?php
            }  
            ?>       
      </ul>
         
        <script>
    /*    $(document).ready(function() {
			$('#nhanuudai').click(function() {
					$('#form_nhanuudai').toggle();
			});
			
			$('#sm_form_nud').click(function() {
				$('#form_nhanuudai').fadeOut();
			});
	});  */
        </script>    
      <span class="hotlinetop">Hotline: 0909 682311 | 0938 122311</span>
    </div>
</div>

    <div style="padding: 7px; background-image: -moz-linear-gradient(center top , rgb(220, 22, 18), rgb(187, 19, 15)); background-color: rgb(187, 19, 15);background-repeat: repeat-x; color: white;">
	<span><strong><a  style="color: #FFFFFF;">Đặt hàng online liên hệ qua số&nbsp; <b>0909.682311 hoặc 0938.122311 </b> </a></strong> 
	 </span>
	</div>
    <!--<div style="padding: 7px; background-image: -moz-linear-gradient(center top , rgb(220, 22, 18), rgb(187, 19, 15)); background-color: rgb(187, 19, 15);background-repeat: repeat-x; color: white;">
	<span><strong><a href="http://cheapdeal.vn/giao-nhan-hang.html" style="color: #FFFFFF;">Thông báo: Từ ngày 16/09/2013, Cheapdeal tiến hành thu phí vận chuyển trong thành phố sau hơn 1 năm free-ship cho khách hàng. Xem tại đây</a></strong>
	 </span>
	</div>-->
	
	<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//v2.zopim.com/?1UOFhir8vlFw0AJO0QccpK5lOjm3Abif';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>
<!--End of Zopim Live Chat Script-->

	
<div id="hdw">
  <div id="hd">  	
    <div id="logo" align="left"><a href="/" class="link"><img src="<?php echo SiteURL;?>/static/css/images/logo.png" alt="Logo <?php echo $INI['system']['sitename']; ?>" /></a></div>

	<div id="atsearchh">
    	<form id="topSearch" method="get" action="/team/search.php">
        	<input type="hidden" name="gid" value="0" id="catgroupid" />
<?php  
$atlist = array(0=>"Tất cả",55=>"Áo – Áo khoác nữ",56=>"Hàng cao cấp",'57'=>'Gia dụng – công nghệ','58'=>'Sức khỏe _ Làm đẹp','59'=>'Túi xách – Phụ Kiện','60'=>'Mẹ Bé',61=>'Thời trang nam','62'=>'Đồ thể thao nam nữ','63'=>'Váy – Đầm nữ');
$s = strtolower($_GET["s"]);
 ?>
    	<div class="box-searchtop">
        	<div class="boxslectsearch">
        		<span id="selectcategory" style="margin: 5px 3px; cursor:pointer;display: block; white-space: nowrap">
				<?php  
                	//echo $atlist[abs(intval($_GET['gid']))];
					//$id_name = abs(intval($_GET['id_name']));
					$category_name = $category_name != "" ? $category_name : "Tất cả";
                	echo $category_name;
                 ?>
                 </span>
                <ul class="listdealcategory">
                	<?php /* foreach($atlist as $key=>$op): ?>
                	<li value="<?php  echo $key; ?>"><?php  echo $op; ?></li>
                    <?php  endforeach; */ ?>
                    <?php  
						function topMenuCagetogyAtSearch($parent_id = 0){						
							$categories = DB::LimitQuery('category', array(		
								'condition' => "display = 'Y' And zone = 'group' And parent = '$parent_id'",
								'order' => 'ORDER BY sort_order, name',
							));							
							foreach($categories as $index=>$item)
							{
								$id = $item['id'];
								$name = $item['name'];
								$iconName = $item['icon'];
								$id_name = $item['id_name'];
								$parent = $item['parent']; 
								if( haveSubCategory($id) )
								{
									echo "<li class='parent' value='$id' text=\"$name\">";	
										echo $name;
									echo '<ul class="submenu">';	
										topMenuCagetogyAtSearch($id);
									echo '</ul></li>';
								}
								else
								{
									echo "<li value='$id' text=\"$name\">" . $name . "</li>";
								}		
							}
						}
						topMenuCagetogyAtSearch();
					?>
                </ul>
            </div>
            <div class="searchcontent_formbox">
                  
                    <div class="searchcontent_formbox1">
                      <input type="text" value="<?php echo $s; ?>" name="s" id="sdeal" class="searchcontent_formtextbox"  autocomplete="off" placeholder="Vui lòng nhập từ khóa tìm kiếm" required="required" />
                   
                    </div>
                  
                </div>
                <div class="searthbutton">
                	<input type="submit" value="Go" class="searchcontent_formbtn" />
                </div>
              </div>
        </form>
        <script type="text/javascript">
		$(document).ready(function(){
			$('#selectcategory').click(function(){
				$('.listdealcategory').slideToggle('fast');
			});
			$('.boxslectsearch').on("mouseleave",function(){
				$('.listdealcategory').hide();
			});
			$('.listdealcategory li').click(function(){
				$val = $(this).attr('value');
				$('#catgroupid').val($val);
				$('#selectcategory').text($(this).text());
				$('.listdealcategory').slideToggle();
				
			//	$('#topSearch').submit();
			});
		});
		</script>
    </div>
    <div id="atmoduserh">
    	<?php if($login_user){?>
<style>
.boxuserinfo{
clear: both;
display: block;
cursor:pointer;
margin-right: 10px;	
}
.boxuserinfo:hover .boxinfouser1{
background: #303843;
}
.boxuserinfo:hover .boxinfohover{
	display:block;
}
.boxuserinfo:hover span{
	color:#FFF;
}
.boxinfouser1{
	height: 50px;
text-align: left;
clear: both; border-radius: 4px 4px 0px 0px;
padding: 7px 0px 5px 7px;}
.boxinfouser1 img{float: left;}
.boxinfouser1 span{font-weight: bold;color: black;padding-left: 7px;line-height: 48px;font-size: 14px;}
.boxinfohover{display:none; width: 340px;background: #fff;box-shadow: 0px 3px 1px 0px #a9a9a7;border-radius: 5px 0px 5px 5px;height: 134px;margin-left: -144px;border-top: 2px solid #2e3844;margin-top: -1px;}
.boximginfo{float: left;margin-top: 20px;margin-left: 18px;margin-right: 45px;}
.boxactioninfo{float:left;}
.boximginfo img{box-shadow: 1px 1px 4px #ccc;}
.boxactioninfo ul{margin-top: 7px;}
.boxactioninfo ul li a{font-size: 14px;color: #000;line-height: 31px;}
</style>
        <div class="boxinfologin" style="margin-top: 21px;">
        <span class="boxuserinfo">
        	<div class="boxinfouser1">
        	<?php if($login_user['avatar']!=""){?>
                <img src="<?php echo user_image($login_user['avatar']); ?>" width="50" height="50"  alt="avatar <?php echo $INI['system']['sitename']; ?>: cùng mua chung theo nhóm mua hot deal khuyen mai" />
                <?php } else { ?>
                	<img src="<?php echo SiteURL;?>/static/css/images/noavatar.png" width="50" height="50"  alt="user <?php echo $INI['system']['sitename']; ?>: cùng mua chung theo nhóm mua hot deal khuyen mai" />
                
             <?php }?>

               <span>
                <?php  
                 if($login_user['realname']){?>
                    <?php echo $login_user['realname']; ?>！
                    <?php } else { ?>
                    <?php echo $login_user['email']; ?>
                    <?php } 
                 ?>
               </span>
           	</div>
            <div class="boxinfohover">
            	<?php  /*    */ ?>
                <div class="boximginfo">
            	<?php if($login_user['avatar']!=""){?>
                <img src="<?php echo user_image($login_user['avatar']); ?>" width="90" height="90"  alt="avatar <?php echo $INI['system']['sitename']; ?>: cùng mua chung theo nhóm mua hot deal khuyen mai" />
                <?php } else { ?>
                	<img src="<?php echo SiteURL;?>/static/css/images/noavatar.png" width="90" height="90"  alt="user <?php echo $INI['system']['sitename']; ?>: cùng mua chung theo nhóm mua hot deal khuyen mai" />
                
             <?php }?>
             	</div>
                <div class="boxactioninfo">
                	<ul>
                    	<li><a href="/account/settings.php">Thông tin</a></li>
                        <li><a href="/order/index.php">Đơn hàng</a></li>
                        <li><a href="/account/refer.php">Mời bạn bè</a></li>
                        <li><a href="/account/logout.php">Thoát</a></li>
                    </ul>
                </div>
                <?php  /*    */ ?>
            </div>
           </span> 

        </div>
    
         <?php } else { ?>
      <ul class="links_login">
         <li class="atlogin" style="border-right: 1px solid #7ea6c0;padding-right: 3px;">
          <a href="/account/login.php">Đăng nhập</a>
            </li>
            <li class="atsignup2">
              <a href="/account/signup.php">Đăng ký</a>
             </li>
      </ul>
   
      <?php }?>
      
    </div>
    
    <?php  
    $carts = Session::Get('carts');
    $atcarttotal = 0;
    if($carts != null && !empty($carts)){
    	foreach($carts as $cart)
        {
        	$atcarttotal += $cart['quantity'];
        }
    }
     ?>
    <div id="atviewcart">
    	<div class="boxviewcart">
        	<span class="product-number"><?php  echo $atcarttotal; ?></span>
            <span class="cart-text"><a href="/ajax/cart.php?action=show" id="showcart">Giỏ hàng</a></span>
        </div>
    </div>
    <?php   /* 
    //city select

    <div class="guides">
   
      <div class="city" id="city-change" style="cursor:pointer; margin-top:-3px;">
       
       <?php if($city){?> 
        <h2><?php echo $city['name']; ?>&nbsp;<span id="guides-city-change"><img align="absmiddle" src="<?php echo SiteURL;?>/static/css/images/btn_nextnum.gif" alt="Chọn thành phố" width="17" height="17"  alt="thanh pho <?php echo $INI['system']['sitename']; ?>: cùng mua chung theo nhóm mua hot deal khuyen mai" /></span></h2>
        <?php } else { ?><h2>TP Hồ Chí Minh</h2>
        <?php }?>
        <h4>Giá cả mang bạn đến, chất lượng giữ chân bạn</h4>
      </div>
      <?php if(count($j_hotcities)>1){?>     
      <div id="guides-city-list" class="city-list">
        <ul>
          <?php echo current_city($city['name'], $j_hotcities); ?>
        </ul>
      </div>      
      <?php }?>  
     

      
      <div class="clear"></div>
    </div>
     */ ?>    
<?php  /*     
//AT dang nhap dang xuat
    <div class="logins">
   
   
      <?php if($login_user){?>
      <ul class="links">
        <li class="username">
          <table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td rowspan="3" align="left" valign="top" nowrap="nowrap">
			  
			  	<?php if($login_user['avatar']!=""){?>
                <div style="margin-right:10px; border:1px #ccc solid;background:#fff;padding:2px; width:28px;height:28px"><img src="<?php echo user_image($login_user['avatar']); ?>" width="28" height="28"  alt="avatar <?php echo $INI['system']['sitename']; ?>: cùng mua chung theo nhóm mua hot deal khuyen mai" /></div>
                <?php } else { ?>
                <?php if($login_user['fb_userid']){?>
                <div style="margin-right:10px; border:1px #ccc solid;background:#fff;padding:2px; width:28px;height:28px"><img src="https://graph.facebook.com/<?php echo $login_user['fb_userid']; ?>/picture" width="28" height="28" />
                  <div style="position:absolute; left:56px; bottom:15px;"><img src="<?php echo SiteURL;?>/static/css/images/f16.jpg" width="12" height="12" /></div>
                </div>
                <?php } else { ?>
                <div style="margin-right:10px; border:1px #ccc solid;background:#fff;padding:2px; width:28px;height:28px"><img src="<?php echo SiteURL;?>/static/css/images/noavatar.png" width="28" height="28"  alt="user <?php echo $INI['system']['sitename']; ?>: cùng mua chung theo nhóm mua hot deal khuyen mai" /></div>
                <?php }?>
                <?php }?></td>
              <td align="left" valign="top" colspan="2" style="padding-bottom:5px;padding-top:7px;font-weight:bold"> Chào, 
                <?php if($login_user['realname']){?>
                <?php echo $login_user['realname']; ?>！
                <?php } else { ?>
                <?php echo $login_user['email']; ?>
                <?php }?>
   
   
              <td align="left" valign="top" class="account" >
              <ul id="myaccount"><li><a href="/order/index.php" class="account" style="padding:5px;">My <?php echo $INI['system']['abbreviation']; ?></a>
              <ul id="myaccount-menu">
      <?php echo current_account(null); ?>
    </ul></li></ul>
</td>
              <td align="left" valign="top" class="logout" style="padding-top:5px"><a style="padding:5px;" href="/account/logout.php">Đăng xuất</a></td>
            </tr>
          </table>
        </li>
      </ul>
      <?php } else { ?>
      <ul class="links">
        <li class="login">
          <a href="/account/signup.php">Đăng ký</a>&nbsp;&nbsp;<img src="<?php echo SiteURL;?>/static/css/images/menu_spacer.gif" align="absmiddle" />&nbsp;&nbsp;<a href="/account/login.php">Đăng nhập</a>&nbsp;&nbsp;<img src="<?php echo SiteURL;?>/static/css/images/menu_spacer.gif" align="absmiddle" />&nbsp;&nbsp;
          <span  style="font-size:13px; font-family:Arial; font-weight:bold">Đăng nhập bằng</span>&nbsp;<a href="javascript:void(0)" title="Yahoo"><img src="<?php echo SiteURL;?>/static/css/images/yahoo_connect.gif" title="Yahoo Login" onclick="yahoo_login();" border="0" align="absmiddle"></a>&nbsp;<a href="javascript:void(0)" title="Gmail"> <img src="<?php echo SiteURL;?>/static/css/images/google_connect.gif" onclick="google_login();" title="Gmail" border="0" align="absmiddle"></a>
        </li>
      </ul>
      <?php }?>
    </div>
*/ ?>

<?php    /*    <div class="subscribe" align="center">
        <form action="/subscribe.php" method="post" id="header-subscribe-form"  class="validator">
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="top" nowrap="nowrap" class="label-big-subscription" colspan="3" style="padding-left:10px;">Nhập email để nhận deal tốt mỗi ngày</td></tr><tr>
            <td align="left" style="padding-left:10px;"><input id="header-subscribe-email" type="text" xtip="Your Email Address" value="" class="f-text-top" name="email" require="true" datatype="require" /></td>
            <td align="left"><select name="city_id" class="f-input-top"><?php echo Utility::Option(Utility::OptionArray($allcities,'id','name'), $city['id']); ?></select></td>
            <td align="left"><input value="Gửi" type="submit" class="submit"></td>
          </tr>
        </table>
        </form>
    </div>  */ ?>
   	
  </div>
</div>

<?php  
if(isset($ishome) && $ishome == 1){
	include template("atmenu_banner");
}else{
	include template("atmenucolspan");
}
?>
<?php if($session_notice=Session::Get('notice',true)){?>
<div class="sysmsgw" id="sysmsg-success">
  <div class="sysmsg">
    <p><?php echo $session_notice; ?><span class="close">Đóng</span></p>
  </div>
</div>
<?php }?>
<?php if($session_notice=Session::Get('error',true)){?>
<div class="sysmsgw" id="sysmsg-error">
  <div class="sysmsg">
    <p><?php echo $session_notice; ?><span class="close">Đóng</span></p>
  </div>
</div>
<?php }?>