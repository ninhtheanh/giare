<?php include template("header");?>
<style>
.atbreadcrum a{color:#64a64e;}
.atbreadcrum a:hover{color:#000;}
</style>
<?php 

$slug =  $city['slug'];
$gid = $team['group_id'];
$arrcatid = array(
	55=>array("/$slug/thoi-trang-nu",'Thời trang nữ'),
	56=>array("/$slug/balo-tui-sach-vi",'Balo túi sách'),
	57=>array("/$slug/me-va-be",'Mẹ & Bé'),
	58=>array("/$slug/suc-khoe-lam-dep",'Sức khỏe làm đẹp'),
	59=>array("/$slug/du-lich-giai-tri",'Du lịch - Giải trí'),
	60=>array("/$slug/nha-hang-am-thuc",'Nhà hàng ẩm thực'),
	61=>array("/$slug/tieu-dung-gia-dung",'Tiêu dùng - Gia dụng'),
	62=>array("/$slug/dien-tu-cong-nghe",'Điện tử - Công nghệ'),
	63=>array("/$slug/thoi-trang-nam",'Thời trang nam'),
);
 ?>
<div id="atbreadcrum">
	 <div class="atbreadcrum" style="margin-left: 260px;margin-top: -22px; color:#64a64e;" >
     	<a href="/<?php  echo $city['slug']; ?>">Khuyến mãi </a>
        <?php  if(isset($arrcatid[$gid])): ?>
        > <a href="<?php  echo $arrcatid[$gid][0]; ?>"><?php  echo $arrcatid[$gid][1]; ?></a>
        <?php  endif; ?>
        > <a style="color:#000;"><strong><?php  echo $team['short_title']; ?></strong></a> <g:plusone size="small"></g:plusone>
     </div>
<?php  /*  <div class="atbreadcrum">
	<a href="">Khuyến mãi </a> > <a href="#">Thời trang</a> > <span>Product</span>
</div>  */
//echo $team['group_id'];//
 ?>
</div>
<div class="atcontainer">
<table width="100%" class="detailtablebox">
	<tr>
    	<td valign="top">
        <div class="detail_info_content_top">
        <div id="atdetail_slider">
        	<div id="at_slider" class="at_nivoSlider" style="width:500px; height:380px;">
               <img src="<?php echo team_image($team['image1'],true,500); ?>" alt="" title="" />
               <img src="<?php echo team_image($team['image2'],true,500); ?>" alt="" title="" />
               <img src="<?php echo team_image($team['image3'],true,500); ?>" alt="" title="" />
            </div>
        </div>
        <div id="atdetail_info">
        	<div class="atinfo_productat">
            	<span class="atinfopatt"><?php if($team['delivery_properties']==1 || ($city['id']==556 && $team['group_id']!=23)){?> Giao sản phẩm <img src="/static/img/icon_product.png" align="absmiddle" alt="Giao sản phẩm" /><?php } else { ?>Giao Voucher <img src="/static/img/icon_voucher.png" align="absmiddle" alt="Giao voucher" /><?php }?></span>
                <span class="atinfonumview">Số người xem: <?php  echo $team['viewed']; ?></span>
            </div>
            <div class="atdetail_title">
            	<h1><?php echo $team['product']; ?></h1>
            </div>
            <div class="deal_summary" style="height: 172px;overflow: hidden;line-height: 2;">
            	<?php echo $team['title']; ?>
            </div>
            <?php  if(isset($team['condbuy']) && $team['condbuy'] !=''): 
                  $condbuy = nanooption($team['condbuy']);
                 ?>
              <div class="color" style="margin: 10px 0px;">
              	<label style="font-weight: bold;margin-right: 7px;">Màu sắc: </label>
                 
				 <?php  
				 $cls = (array)Session::Get('colorteam');
				 foreach($condbuy as $color): 
				 $clsactive = '';
				 	//if(isset($cls[$team['id']]) && $cls[$team['id']] == $color)
					if( isset($_SESSION['color_'.$team['id']]) && $_SESSION['color_'.$team['id']] == $color )
						$clsactive = 'activecolor';
				 ?>
                 
                 <a id="color_<?php  echo $team['id']; ?>" class="setcolor <?php  echo $clsactive; ?>" onclick="setColorTeam(<?php  echo $team['id']; ?>,'<?php  echo $color ?>');"><span style="cursor:pointer;border:1px solid #999;width:16px; height:16px; display:inline-block;background:<?php  echo $color; ?>"></span></a>
                 <?php  endforeach; ?>
               </div>
               <style>
			   .setcolor{ display: inline-block;padding: 3px;}
			   .activecolor{background: #75C70D;}
			   </style>
               <script type="text/javascript">
			   	$('.setcolor').click(function(){
					$('.setcolor').removeClass('activecolor');
						$(this).addClass('activecolor');
				});
			   	function setColorTeam($id,$str){
					$.get('/ajax/checkout.php?getdatastep=setcolor&team_id='+$id+'&color='+$str, function(ret) {
						
					});
				}
				function setSize($id,$str){
					$.get('/ajax/checkout.php?getdatastep=setsize&team_id='+$id+'&size='+$str, function(ret) {
						
					});
				}
			   </script>
            <?php  endif; ?>
            <?php if($team['size'] != ""){?>
              <div class="color" style="margin: 10px 0px;">
                <label style="font-weight: bold;margin-right: 7px;">Size: </label>
                <?php 
				 	$size = $team['size'];
					$size = str_replace("}{", ", ", $size);
					$size = str_replace("{", "", $size);
					$size = str_replace("}", "", $size);
				 	//echo $size; 
					$arrSize = split(",", $size);
					foreach($arrSize as $size)
					{						
				 ?>
                 	<input type="radio" name="radio_size" value="<?php echo $size;?>" onchange="setSize(<?php  echo $team['id']; ?>,'<?php  echo $size ?>');" <?php if( isset($_SESSION['size_'.$team['id']]) && $_SESSION['size_'.$team['id']] == $size ) echo 'checked="checked"'?>/> <?php echo $size;?>
                    &nbsp;
              	<?php }?>   
              </div>
              <?php }?>
            <div class="price_btn_order">
            	 <div class="box_detail_price">
                 	<div class="detail_team_price"><?php echo print_price(moneyit($team[team_price])); ?> <sub>VNĐ</sub></div>
                    <div class="detail_market_price"><?php echo print_price(moneyit($team[market_price])); ?> đ</div>
                 </div>
                 <div class="box_btn_order">
                 
                 <?php  	/*  <span><a <?php echo $team['begin_time']<time()?'href="/team/ataddcart.php?id='.$team['id'].'"':''; ?> class="ataddcart"><img src="/static/css/images/but_buynow.gif" width="134" height="41" alt="Mua ngay hotdeal giá rẻ" /></a></span>  */ ?>
                   <span>
            
                   <?php  if($team['begin_time']<time() && $team['end_time'] > time()): ?>
                    <a href="/team/ataddcart.php?id=<?php  echo $team['id']; ?>" style="font-size: 16px;color: #FFFFFF;display: block;padding-left: 6px;width: 135px;margin: 0px auto;height: 45px;" class="ataddcart boxbuttoncss">
                                        <div class="buttoncss" style="width: 127px;height: 35px;font-size: 19px;line-height: 34px;">Mua Ngay</div>
                          </a>
                    <?php  elseif($team['now_number'] >= $team['pre_number']): ?>
                     <a style="font-size: 16px;color: #FFFFFF;display: block;padding-left: 6px;width: 135px;margin: 0px auto;height: 45px;" class="ataddcart boxbuttoncss">
                                        <div class="buttoncss" style="width: 127px;height: 35px;font-size: 19px;line-height: 34px;background: #9B0202;border: 1px solid #9B0202;box-shadow: 0px 3px 1px #9B0202;">Cháy hàng</div>
                          </a>
                    <?php  endif; ?>
                    
                    </span>     
                 </div>
            </div>
            <div class="box_detail_sale_buycount">
            	<div class="detail_infoleft">
                	<span class="detail_discountper"><?php echo ceil(moneyit((100*($team['market_price'] - $team['team_price'])/$team['market_price']))); ?>%</span>
                    <span class="detail_info_discounttext">Tiết kiệm</span>
                </div>
                <div class="detail_info_right">
                	<div class="detail_info_buy">
                    	<span><?php echo $team['now_number']+$team['pre_number']; ?></span>
                        <span>Số người mua</span>
                    </div>
                    <div class="facebook_share">
                    	<div class="fb-like" data-send="true" data-layout="button_count" data-width="200" data-show-faces="false"></div>
                    </div>
                </div>
            </div>
        </div>
        </div>
<script type="text/javascript">
	$(document).ready(function() {
		 $('#at_slider').nivoSlider({
        directionNav:true,
        pauseOnHover:true,
        manualAdvance:false
    });
	});
</script>     
		<div class="box_detail_inofo">   
        <table width="100%" class="tabledetail">
        	<tr>
            	<td width="50%" valign="top" class="tbtableboxsummary">
                	<div class="detail_title_condition">
                    	<h2>Điểm Nổi Bật</h2>
                    </div>
                    <div class="detail_content_more">
                    <?php echo $team['summary']; ?>
                    </div>
                </td>
                <td width="50%" valign="top">
                	<div class="detail_title_condition">
                    	<h2>Điều Kiện</h2>
                    </div>
                    <div class="detail_content_more">
                    <?php echo $team['notice']; ?>
                    </div>
                </td>
            </tr>
        </table>
        </div>
        <div class="detail_box_info_coment">
        	 <div class="tabbed_area">  
                    <ul class="tabs">  
                       <li><a title="content_1" class="tab active" id="lithongtin">Thông tin</a></li>  
                        <li><a title="content_2" class="tab" id="lithaoluan">Thảo luận</a></li>  
                    </ul>
                    <div class="atboxinfocoment">
                    	<div id="content_1" class="tabcontent">
                        	 <div id="team_desc"><?php echo htmlspecialchars_decode($team['detail']); ?></div>
                             <!-- share social -->
                             <div class="box_sharesocial">
                             <div class="facebook_share itemshare">
                                   <div class="fb-like" data-send="false" data-layout="button_count" data-width="100" data-show-faces="true"></div>
                                </div>
                            <div class="itemshare">
                            	<a href="https://twitter.com/share" class="twitter-share-button" data-related="jasoncosta" data-lang="en" data-size="small" data-count="horizontal">Tweet</a>
                            </div>
                            <div class="itemshare">
                            	<g:plusone size='Small'></g:plusone>
                            </div>
                            <div class="itemshare">
                            	<div class='addthis_toolbox addthis_default_style '>
                                <a class='addthis_counter addthis_pill_style'></a>
                                </div>

                            </div>
                            
                            
                            </div>
                         
                             <!-- end share social -->
                        </div>  
                        <div id="content_2" class="tabcontent" style="display:none;">
                        	<table width="100%" border="0">
              <tr>
               <td>
               <div align="left" style="overflow:hidden">
              <table cellspacing="0" cellpadding="0" border="0" width="100%">
                <?php if(is_array($asks)){foreach($asks AS $one) { ?>
                <tr>
                  <td align="left" valign="top" style="padding-right:10px;"><div class="topic-content"> <span style="color:#249BC6; font-weight:bold; font-size:14px;">Mời các bạn cùng thảo luận Deal: </span><?php echo nl2br(htmlspecialchars($team['title'])); ?> </div></td>
                </tr>
                <?php }}?>
                <tr>
                  <td align="right" valign="top" style="margin-top:10px;padding-right:10px"><?php 
                        $now_time = date("Y-m-d",time());
                        $d = date("D",time());
                        if($d=='Sun'){
                            $time = ' 23:00:00';
                        }else{
                            $time = ' 23:59:59';	
                        }
                        $time_off = strtotime($now_time.$time);
                       
                      ; ?> 
                    <?php if($time_off>time()){?>
                    
                    <div style="padding:10px;"> 
                      <?php if(is_login() && !in_array($team['state'],array('soldout','expired')) && $team['end_time']>time()){?>
                      <form id="forum-topic-form" method="post" action="/<?php echo seo_url($team['short_title'],$team['id'],$url_suffix); ?>?comment=display" class="validator">
                        <input type="hidden" name="parent_id" value="<?php echo $topic['id']; ?>" />
                        <input type="hidden" name="city_id" value="<?php echo $city['id']; ?>" />
                        <input type="hidden" name="team_id" value="<?php echo $topic['team_id']; ?>" />
                        <input type="hidden" name="public_id" value="<?php echo $topic['public_id']; ?>" />
                        <input type="hidden" name="id" value="<?php echo $topic['id']; ?>" />
                        <textarea style="width:680px;height:100px; border:#32ccfe 1px solid" name="topic_content" id="forum-new-topic-content" class="f-textarea" require="true" datatype="require"></textarea>
                        <div align="right" style="padding-top:10px;">
                          <div id="error" style="width:300px; float:left"></div>
                          <img id="imgloading" align="absmiddle" src="/static/css/images/ajax-loader.gif" alt="processing..." />&nbsp;
                          <button type="submit" name="commit" id="leader-submit" class="formbutton">Gửi</button>
                        </div>
                      </form>
                      <?php } else if(!is_login()) { ?> 
                      Vui lòng <a href="/account/login.php?r=<?php echo $currefer; ?>">Đăng nhập</a> hoặc <a href="/account/signup.php">Đăng ký</a> để gởi bài. 
                      <?php }?>
                      <div class="clear"></div>
                    </div>
                    
                    <?php }?></td>
                </tr>
                <tr>
                  <td align="left" valign="top" style="padding-right:10px" id="forum"><div style="border-top:dotted 1px #ccc"></div>
                    <div class="sect" id="topic_content" style="padding-top:10px">
                      <table id="replies-list" width="100%" cellspacing="0" cellpadding="0" border="0">
                        <?php if(is_array($replies)){foreach($replies AS $index=>$one) { ?> 
                        
                        <?php 
                              $topics = DB::GetQueryResult("SELECT count(*) as count FROM topic WHERE user_id='".$one['user_id']."'"); 
                              $comments = DB::GetQueryResult("SELECT count(*) as count FROM topic_reply WHERE user_id_reply='".$one['user_id']."'");
                              $buys = DB::GetQueryResult("SELECT sum(quantity) as count FROM `order` WHERE user_id='".$one['user_id']."'");  
                              $buys['count'] = ($buys['count']) ? $buys['count'] : 0;                           
                        ; ?> 
                        
                        <?php if($one['status']=='N'){?> 
                        <?php if(($one['user_id']==$login_user_id) OR ($login_user['manager']=='Y')){?>
                        <tr bgcolor="<?php echo ($index%2) ? '#f1f3f5' : '#f1f3f5';; ?>">
                          <td width="100" valign="top" style="font-size:80%;"><a name="entry-<?php echo $one['id']; ?>"></a>
                            <div style="font-weight:bold; color:#666666; text-transform:capitalize"> 
                              <?php if(($login_user['manager']=='Y')){?> 
                              <a href="/ajax/manage.php?action=userviewhistory&id=<?php echo $one['user_id']; ?>" class="ajaxlink"><?php echo $users[$one['user_id']]['realname']; ?></a> 
                              <?php } else { ?> 
                              <?php echo $users[$one['user_id']]['realname']; ?> 
                              <?php }?> 
                            </div>
                            <div class="avatar"><img src="<?php echo user_image($users[$one['user_id']]['avatar']); ?>" width="60" height="60" /></div>
                            <div style="margin-top:10px;">Regs: <?php echo date('d-m-Y',$users[$one['user_id']]['create_time']); ?></div>
                            <div>Topics: <?php echo $topics['count']; ?></div>
                            <div>Comments: <?php echo $comments['count']; ?></div>
                            <div>Mua : <?php echo $buys['count']; ?></div></td>
                          <td align="left" valign="top"><div style="font-size:90%"> <span style="float:right;"><?php echo Utility::HumanTime($one['create_time']); ?> 
                              <?php if(is_manager()){?> 
                              &nbsp;---&nbsp;<a href="/ajax/topic.php?action=topicshow&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to show the reply?"><strong>Hiển Thị</strong></a> | <a href="/ajax/topic.php?action=topicremove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to delete the reply?"><strong>Xóa</strong></a> 
                              <?php }?> 
                              </span>
                              <div class="clear"></div>
                            </div>
                            <div align="justify" style="padding-left:5px;padding-top:5px;"><?php echo nl2br(htmlspecialchars($one['content'])); ?> </div></td>
                        </tr>
                        <tr>
                          <td align="left" colspan="2"><div style="border-bottom:dotted 1px #ccc">&nbsp;</div>
                            <br /></td>
                        </tr>
                        <?php }?> 
                        <?php } else { ?>
                        
                        <tr>
                          <td width="100" valign="top" style="font-size:80%;"><a name="entry-<?php echo $one['id']; ?>"></a>
                            <div style="font-weight:bold; color:#666666; text-transform:capitalize"> 
                              <?php if(($login_user['manager']=='Y')){?> 
                              <a href="/ajax/manage.php?action=userviewhistory&id=<?php echo $one['user_id']; ?>" class="ajaxlink"><?php echo $users[$one['user_id']]['realname']; ?></a> 
                              <?php } else { ?> 
                              <?php echo $users[$one['user_id']]['realname']; ?> 
                              <?php }?> 
                            </div>
                            <div class="avatar"><img src="<?php echo user_image($users[$one['user_id']]['avatar']); ?>" width="60" height="60" /></div>
                            <div style="margin-top:10px;">Regs: <?php echo date('d-m-Y',$users[$one['user_id']]['create_time']); ?></div>
                            <div>Topics : <?php echo $topics['count']; ?></div>
                            <div>Comments : <?php echo $comments['count']; ?></div>
                            <div>Mua : <?php echo $buys['count']; ?></div></td>
                          <td align="left" valign="top"><div ><span style="float:right; font-size:80%"><?php echo Utility::HumanTime($one['create_time']); ?> 
                              <?php if(is_manager()){?> 
                              &nbsp;---&nbsp;<a href="/ajax/topic.php?action=topichidden&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to hidden the reply?"><strong>Ẩn</strong></a> | <a href="/ajax/topic.php?action=topicremove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to delete the reply?"><strong>Xóa</strong></a> 
                              <?php }?> 
                              </span>
                              <div class="clear"></div>
                            </div>
                            <div align="justify" style="padding-left:5px;padding-top:5px;"> 
                              <?php 
				$filter =  array('nhommua', 'Nhommua', 'NhomMua', 'nhom_mua', 'nhom-mua', 'nhom mua','Nhom Mua','Nhom mua', 'cungmua', 'cung_mua', 'cung-mua', 'cung mua', 'muachung', 'mua_chung', 'mua-chung', 'mua chung', 'vndoan', 'vn_doan', 'vn-doan', 'vn doan', 'hotdeal', 'hot deal', 'hot-deal', 'hotdeal.vn', 'phagia', 'pha gia', 'cuc re', 'cucre', 'dealvip', 'deal vip');
				foreach($filter as $v){
					if(strpos($one['content'], $v) !== false) {
							$one['content'] = str_ireplace($v,"*****",$one['content']);
					}
				}
            ; ?> 
                              <?php echo nl2br(htmlspecialchars($one['content'])); ?> </div>
                            <div align="right" style="padding-top:10px;"> 
                              <script type="text/javascript">
								function ShowReplyTopic(id){
									if(document.getElementById("showreplyform_"+id).style.display=="none"){									
										$('#showreplyform_'+id).show();
										$('#noneclick'+id).hide();
										$('#clicked'+id).show();								
										return;
									}else{
										$('#showreplyform_'+id).hide();
										$('#noneclick'+id).show();
										$('#clicked'+id).hide();							
										
									}
								}
								function ShowNeedLogin(id){
									if(document.getElementById("needlogin_"+id).style.display=="none"){	
										document.getElementById("needlogin_"+id).style.display="block";
										return;
									}else{
										document.getElementById("needlogin_"+id).style.display="none";
									}
								}
							</script> 
                              <?php 
              $total_count = DB::GetQueryResult("SELECT count(id) as total FROM topic_reply WHERE user_id='".$one['user_id']."' AND status NOT IN ('D') AND topic_id='".$one['id']."'"); 
              $topic_reply = DB::GetQueryResult("SELECT * FROM topic_reply WHERE user_id='".$one['user_id']."' AND status NOT IN ('D') AND topic_id='".$one['id']."'", false);              
        ; ?> 
                              <?php if(is_login()){?> 
                              <a href="javascript:void(0)" class="AnsView2" onclick="ShowReplyTopic('<?php echo $one['user_id']; ?>_<?php echo $one['id']; ?>')" id="noneclick<?php echo $one['user_id']; ?>_<?php echo $one['id']; ?>" style="text-decoration:none"><span><?php echo (int)($total_count['total']); ?> thảo luận</span></a><a href="javascript:void(0)" class="AnsView1" onclick="ShowReplyTopic('<?php echo $one['user_id']; ?>_<?php echo $one['id']; ?>')" id="clicked<?php echo $one['user_id']; ?>_<?php echo $one['id']; ?>" style="text-decoration:none;display:none;"><span><?php echo (int)($total_count['total']); ?> thảo luận</span></a> 
                              <?php } else if($my) { ?> 
                              <a href="javascript:void(0)" class="AnsView2" onclick="ShowNeedLogin('<?php echo $one['user_id']; ?>_<?php echo $one['id']; ?>')" id="noneclick" style="text-decoration:none"><span><?php echo (int)($total_count['total']); ?> đã thảo luận</span></a><a href="javascript:void(0)" class="AnsView1" onclick="ShowNeedLogin('<?php echo $one['user_id']; ?>_<?php echo $one['id']; ?>')" id="clicked" style="text-decoration:none;display:none;"><span><?php echo (int)($total_count['total']); ?> thảo luận</span></a> 
                              <?php }?> 
                            </div>
                            <div style="clear:both"></div>
                            <div style="padding-left:10px;padding-bottom:10px;display:none; padding-right:10px; padding-top:10px;" id="showreplyform_<?php echo $one['user_id']; ?>_<?php echo $one['id']; ?>"> 
                              <?php if((!empty($topic_reply))){?> 
                              <?php if(is_array($topic_reply)){foreach($topic_reply AS $indexs=>$ones) { ?> 
                              
                              <?php 
                              $ctopics = DB::GetQueryResult("SELECT count(*) as count FROM topic WHERE user_id='".$ones['user_id_reply']."'"); 
                              $ccomments = DB::GetQueryResult("SELECT count(*) as count FROM topic_reply WHERE user_id_reply='".$ones['user_id_reply']."'");
                              $cbuys = DB::GetQueryResult("SELECT sum(quantity) as count FROM `order` WHERE user_id='".$ones['user_id_reply']."'");   
                              $cbuys['count'] = ($cbuys['count']) ? $cbuys['count'] : 0;                                 
                        	; ?>
                              
                              <div style="border-bottom: #cccccc 1px dotted">&nbsp;</div>
                              <?php  $user_realname = DB::GetQueryResult("SELECT avatar, realname FROM `user` WHERE id='".$ones['user_id_reply']."'"); ; ?>
                              <div style="padding-bottom:7px;"> 
                                <?php if($ones['status']=='N'){?> 
                                <?php if((($ones['user_id']==$login_user_id) OR ($login_user['manager']=='Y'))){?>
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td width="100" valign="top" style="font-size:80%"><a name="entry-<?php echo $one['id']; ?>"></a>
                                      <div class="avatar"><img src="<?php echo user_image($user_realname['avatar']); ?>" width="60" height="60" /></div>
                                      <div style="margin-top:10px;">Regs: <?php echo date('d-m-Y',$users[$one['user_id']]['create_time']); ?></div>
                                      <div>Topics : <?php echo $ctopics['count']; ?></div>
                                      <div>Comments : <?php echo $ccomments['count']; ?></div>
                                      <div>Mua : <?php echo $cbuys['count']; ?></div></td>
                                    <td align="left" valign="top"><div style="font-size:90%;margin-top:10px"> <span style="float:right;"><?php echo Utility::HumanTime($ones['create_time']); ?> 
                                        <?php if(($login_user['manager']=='Y')){?> 
                                        &nbsp;---&nbsp; <a href="/ajax/topic.php?action=topicreplyshow&reply_id=<?php echo $ones['id']; ?>&id=<?php echo $ones['topic_id']; ?>" class="ajaxlink" ask="sure to show the reply?"><strong>Hiển thị</strong></a> | <a href="/ajax/topic.php?action=topicreplyremove&reply_id=<?php echo $ones['id']; ?>&id=<?php echo $ones['topic_id']; ?>" class="ajaxlink" ask="sure to delete the reply?"><strong>Xóa</strong></a> 
                                        <?php }?> 
                                        </span><b> 
                                        <?php if(($login_user['manager']=='Y')){?> 
                                        <a href="/ajax/manage.php?action=userviewhistory&id=<?php echo $ones['user_id_reply']; ?>" class="ajaxlink"><?php echo $user_realname['realname']; ?></a> 
                                        <?php } else { ?> 
                                        <?php echo $user_realname['realname']; ?> 
                                        <?php }?> 
                                        </b>
                                        <div class="clear"></div>
                                      </div>
                                      <div class="topic-content" style="padding-top:5px;"> 
                                        <?php 
                                            $filter =  array('nhommua', 'Nhommua', 'NhomMua', 'nhom_mua', 'nhom-mua', 'nhom mua','Nhom Mua','Nhom mua', 'cungmua', 'cung_mua', 'cung-mua', 'cung mua', 'muachung', 'mua_chung', 'mua-chung', 'mua chung', 'vndoan', 'vn_doan', 'vn-doan', 'vn doan', 'hotdeal', 'hot deal', 'hot-deal', 'hotdeal.vn', 'phagia', 'pha gia', 'cuc re', 'cucre', 'dealvip', 'deal vip');
                                            foreach($filter as $v){
                                                if(strpos($ones['content'], $v) !== false) {
                                                        $ones['content'] = str_ireplace($v,"*****",$ones['content']);
                                                }
                                            }
                                        ; ?> 
                                        <?php echo nl2br(htmlspecialchars($ones['content'])); ?> </div></td>
                                  </tr>
                                </table>
                                <?php }?> 
                                <?php } else { ?>
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td width="100" valign="top" style="font-size:80%"><a name="entry-<?php echo $one['id']; ?>"></a>
                                      <div class="avatar"><img src="<?php echo user_image($user_realname['avatar']); ?>" width="60" height="60" /></div>
                                      <div style="margin-top:10px;">Regs: <?php echo date('d-m-Y',$users[$one['user_id']]['create_time']); ?></div>
                                      <div>Topics : <?php echo $ctopics['count']; ?></div>
                                      <div>Comments : <?php echo $ccomments['count']; ?></div>
                                      <div>Mua : <?php echo $cbuys['count']; ?></div></td>
                                    <td align="left" valign="top"><div style="margin-top:10px; font-size:90%"> <span style="float:right;"><?php echo Utility::HumanTime($ones['create_time']); ?> 
                                        <?php if(($login_user['manager']=='Y')){?> 
                                        &nbsp;---&nbsp; 
                                        <?php if(($ones['status']=='Y')){?> 
                                        <a href="/ajax/topic.php?action=topicreplyhidden&reply_id=<?php echo $ones['id']; ?>&id=<?php echo $ones['topic_id']; ?>" class="ajaxlink" ask="sure to hidden the reply？"><strong>Ẩn</strong></a> 
                                        <?php } else { ?> 
                                        <a href="/ajax/topic.php?action=topicreplyshow&reply_id=<?php echo $ones['id']; ?>&id=<?php echo $ones['topic_id']; ?>" class="ajaxlink" ask="sure to show the reply？"><strong>Hiển thị</strong></a> 
                                        <?php }?> 
                                        | <a href="/ajax/topic.php?action=topicreplyremove&reply_id=<?php echo $ones['id']; ?>&id=<?php echo $ones['topic_id']; ?>" class="ajaxlink" ask="sure to delete the reply？"><strong>Xóa</strong></a> 
                                        <?php }?> 
                                        </span><b> 
                                        <?php if(($login_user['manager']=='Y')){?> 
                                        <a href="/ajax/manage.php?action=userviewhistory&id=<?php echo $ones['user_id_reply']; ?>" class="ajaxlink"><?php echo $user_realname['realname']; ?></a> 
                                        <?php } else { ?> 
                                        <?php echo $user_realname['realname']; ?> 
                                        <?php }?> 
                                        </b>
                                        <div class="clear"></div>
                                      </div>
                                      <div class="topic-content" style="padding-top:5px;"> 
                                        <?php 
                                       $filter =  array('nhommua', 'Nhommua', 'NhomMua', 'nhom_mua', 'nhom-mua', 'nhom mua','Nhom Mua','Nhom mua', 'cungmua', 'cung_mua', 'cung-mua', 'cung mua', 'muachung', 'mua_chung', 'mua-chung', 'mua chung', 'vndoan', 'vn_doan', 'vn-doan', 'vn doan', 'hotdeal', 'hot deal', 'hot-deal', 'hotdeal.vn', 'phagia', 'pha gia', 'cuc re', 'cucre', 'dealvip', 'deal vip');
                                        foreach($filter as $v){
                                            if(strpos($ones['content'], $v) !== false) {
                                                    $ones['content'] = str_ireplace($v,"*****",$ones['content']);
                                            }
                                        }
                                    ; ?> 
                                        <?php echo nl2br(htmlspecialchars($ones['content'])); ?> </div></td>
                                  </tr>
                                </table>
                                <?php }?> 
                              </div>
                              <?php }}?> 
                              <?php }?> 
                              <?php if(is_login() && !in_array($team['state'],array('soldout','expired')) && $team['end_time']>time()){?>
                              <div align="center" style="padding-top:5px;">
                                <form id="forum-reply-form_<?php echo $one['user_id']; ?>_<?php echo $one['id']; ?>" method="post" action="" class="validator">
                                  <input type="hidden" name="user_id" value="<?php echo $one['user_id']; ?>" />
                                  <input type="hidden" name="topic_id" value="<?php echo $one['id']; ?>" />
                                  <textarea style="width:99%;height:50px; border:#32ccfe 1px solid" name="content-reply" id="forum-new-content" class="f-textarea" require="true" datatype="require"></textarea>
                                  <div align="right" style="padding-top:10px;">&nbsp;
                                    <button type="submit" name="replytopicuser" id="leader-submit" class="formbutton">Trả lời</button>
                                  </div>
                                </form>
                              </div>
                              <?php } else if(!is_login()) { ?>
                              <div align="left" id="needlogin_<?php echo $one['user_id']; ?>_<?php echo $one['id']; ?>" style="padding-bottom:10px">Vui lòng <a href="/account/login.php?r=<?php echo $currefer; ?>">Đăng nhập</a> hoặc <a href="/account/signup.php">Đăng ký</a> để thảo luận.</div>
                              <?php }?> 
                            </div></td>
                        </tr>
                        <tr>
                          <td align="left" colspan="2"><div style="border-bottom:dotted 1px #ccc">&nbsp;</div>
                            <br /></td>
                        </tr>
                        <?php }?> 
                        <?php }}?> 
                        <?php if($count>10){?>
                        <tr>
                          <td colspan="2"><?php echo $pagestring; ?></td>
                        </tr>
                        <?php }?>
                      </table>
                    </div></td>
                </tr>
              </table>
            </div>
               </td>
              </tr>
            </table>
                        </div>   
                    </div>
              </div>
              
              
              <script>  
  
  // When the document loads do everything inside here ...  
  jQuery(document).ready(function(){  
    jQuery("a.tab").click(function () {  
        jQuery(".active").removeClass("active");  
        jQuery(this).addClass("active");  
        jQuery("div.tabcontent").hide();  
        var content_show = jQuery(this).attr("title");  
        jQuery("#"+content_show).show();  
        
    });  
	
	<?php 


	 if(isset($_GET['comment'])): ?>
	
		jQuery("#lithongtin, #lithaoluan").removeClass("active"); 
		jQuery("#lithaoluan").addClass("active"); 
		jQuery("#content_1").hide();  
		jQuery("#content_2").show();  
 	<?php  endif; ?>
  });  
 </script>  

        </div>
        <div class="boxpricebuttnmid">
        		
                <div class="detailmidbox" style="text-align:center;padding-top: 9px;">
                
                <span><?php  if($team['begin_time']<time() && $team['end_time'] > time()): ?>
                    <a href="/team/ataddcart.php?id=<?php  echo $team['id']; ?>" style="font-size: 16px;color: #FFFFFF;display: block;padding-left: 6px;width: 208px;margin: 0px auto;height: 50px;" class="ataddcart boxbuttoncss">
                                        <div class="buttoncss" style="width: 198px;height: 36px;font-size: 22px;line-height: 34px;">Mua Ngay</div>                          </a>
                    <?php  elseif($team['now_number'] >= $team['pre_number']): ?>
                     <a style="font-size: 16px;color: #FFFFFF;display: block;padding-left: 6px;width: 208px;margin: 0px auto;height: 50px;" class="ataddcart boxbuttoncss">
                                        <div class="buttoncss" style="width: 198px;height: 36px;font-size: 22px;line-height: 34px;background: #9B0202;border: 1px solid #9B0202;box-shadow: 0px 3px 1px #9B0202;">Cháy hàng</div>
                          </a>
                    <?php  endif; ?></span>
                </div>
                
        </div>
        <div class="detail_boxaddress">
        	<table width="100%" class="detail_map_deal">
            	<tr>
                	<td class="atmap" valign="top">
                    	<?php  /*  <div class="detail_add_title">Bản đồ</div>  */ ?>
                        <div class="detail_add_container">
                        <!--{if $INI['system']['googlemap'] && $partner['longlat']}-->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<?php  
if(!$partner['longlat'])
 $partner['longlat'] = '10.78896,106.676899';
 ?>
<script type="text/javascript">
      function initialize() {		 

		 var geocoder;
        var mapDiv = document.getElementById('mapcanvas');
		var myLatlng = new google.maps.LatLng(<?php echo $partner['longlat']; ?>);
        var map = new google.maps.Map(mapDiv, {
          center: myLatlng,
          zoom: 20,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
		  scrollwheel: true
        });
		
		 geocoder = new google.maps.Geocoder();
		 
		 var marker = new google.maps.Marker({
				position: myLatlng,
				title: '<?php  echo $partner['address']; ?>'
			});
			marker.setMap(map);

      }
      
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
<div id="mapcanvas" class="mapbody map" style="width:588px; height:300px;"></div>
<!--{/if}-->
                        <?php  	/*  <div align="center"><img src="/static/<?php echo $partner['image1']; ?>" alt="<?php echo $partner['title']; ?>" /></div>  */ ?>
                        </div>
                    </td>
                    <td valign="top">
                    	<div class="detail_add_title">Địa chỉ</div>
                <div class="detail_add_container">
                    <?php echo $partner['location']; ?>
                </div>
                    </td>
                </tr>
            </table>
        </div>
        </td>
        <td width="244" valign="top">
        	<?php if(!empty($other_deal)){?>
                <ul class="atmore_dealright">
                    <?php if(is_array($other_deal)){foreach($other_deal AS $index=>$one) { ?>
                    <?php 
                        $new_icon = $one['begin_time']+86400;
                        if($new_icon>time()){
                            $class = ' class="new"';
                        }else{
                            $class = '';
                        }
                        
                        $total_comment = DB::GetQueryResult("SELECT count(id) as total FROM topic WHERE team_id=".$one['id']);
                        $ids .= $one['id'].",";
                        $arr_group = array(16,23);
                        if(in_array($ip,$ip_arr)){
                            $now_number = RandomBuy($one['now_number'],$one['virtual_buy']);
                        }elseif(in_array($one['group_id'],$arr_group) && $one['close_time']){
                            $now_number = $one['now_number']*2;
                        }else{
                            $now_number = $one['now_number'];
                        }
                    ; ?>
                  <li<?php echo $class; ?>>
                  <a href="/<?php echo $city['slug']; ?>/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>" class=""><img src="<?php echo team_image($one['image']); ?>" alt="" title="" width="219" height="316" class="img_more_right" /></a>
                  <a href="/<?php echo $city['slug']; ?>/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>" class="linktitlemoreright"><?php echo $one['short_title']; ?></a>
                  <div class="box_right_price_sale">
                  <span class="pricetoge"><?php echo print_price(moneyit($one['team_price'])); ?>đ</span>
                  <span class="right_marketprice"><?php echo print_price(moneyit($one['market_price'])); ?>đ</span>
                  <span class="right_sale">Giảm <?php echo ceil(moneyit((100*($one['market_price'] - $one['team_price'])/$one['market_price']))); ?>%</span>
                  </div>
                  </li>
                  <?php }}?>
                </ul><?php }?>
        </td>
    </tr>
</table>
</div>
<?php include template("footer");?>