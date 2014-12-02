<?php include template("header");?>
<style>
.atbreadcrum a{color:#64a64e;}
.atbreadcrum a:hover{color:#000;}
</style>
<?php 

?>
<div id="atbreadcrum">
	 <div class="atbreadcrum" style="margin-left: 260px;margin-top: -22px; color:#64a64e;" >
     	
     </div>
</div>
<div class="atcontainer">
<table width="90%" class="detailtablebox">
	<tr>
    	<td valign="top">
              <table width="100%">
              	<tr>
                	<td>
                        <p class="title"><strong><span style="color:#000000;font-size:18px;"><?=$hotNews['title']?></span></strong></p>
                        <p align="justify">
                           
                            <?=$hotNews['description']?>
                        </p>	
                    </td>
                </tr>
                <tr>
                    <td valign="top">                        
                        <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fcheapdeal.HCM&amp;width=720&amp;height=220&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:720px; height:220px;" allowTransparency="true"></iframe>                   
                    </td>
                </tr>
                <tr>
                	<td>
                    	<p class="title"><strong><span style="color:#000000;font-size:14px;">Các Tin Khác</span></strong></p>
                    </td>
                </tr>
                <tr>
                	<td>
                        <ul class="links">
                            <?
                                foreach($other_news as $row)
                                { 
                                    $currentRow ++;
                                    $cate_id = $row["cate_id"];
                                    $new_id = $row["id"];
                                    $title = $row["title"];
                                    $subject = $row["subject"];
                                    $description = $row["description"];
                                    $thumb = $row["thumb"];
                                    $image = $row["image"];
                                    $activate = $row["activate"];
                              ?>
                            <li>
                                <p class="ndot"><a title="cheapdeal.vn" name="all" href="/tin-tuc/<?php echo seo_url($title,$new_id, $url_suffix, '_'); ?>"><span style="color:#000000;font-size:13px;"><?=$title?></span></a></p>                        </li>
                            <? }?>                        
                        </ul>                    	
                    </td>
                </tr>                
              </table>          	
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
                  <a href="/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>" class="">
                  <img src="<?php echo team_image($one['image'],true,240); ?>" alt="" title="" width="219" height="316" class="img_more_right" /></a>
                  <a href="/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>" class="linktitlemoreright"><?php echo $one['short_title']; ?></a>
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

	  <!--Feedback-->
  <script type="text/javascript">
var _urq = _urq || [];
_urq.push(['initSite', '7e8bfbaf-5918-48b8-ac68-10f72fc1f578']);
(function() {
var ur = document.createElement('script'); ur.type = 'text/javascript'; ur.async = true;
ur.src = ('https:' == document.location.protocol ? 'https://cdn.userreport.com/userreport.js' : 'http://cdn.userreport.com/userreport.js');
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ur, s);
})();
</script> 
<!--Start of Zopim Live Chat Script--
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//v2.zopim.com/?1UOFhir8vlFw0AJO0QccpK5lOjm3Abif';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>
--End of Zopim Live Chat Script-->
<!-- Breakcumb -->
<?php include template("footer");?>