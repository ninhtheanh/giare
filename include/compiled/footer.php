<?php
	$arrPage = DB::LimitQuery('page', array(
		'condition' => 'show_on_footer = 1',
		'order' => 'ORDER BY page_type, `order`',
		'size' => $pagesize,
		'offset' => $offset,
	));	
?>
<?php if($_SERVER['SERVER_NAME'] != "localhost"){?>
<!-- Google Code for Remarketing Tag -->
<!--------------------------------------------------
Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
--------------------------------------------------->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 998479224;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>

<noscript>
<div style="display:inline;"> <img height="1" width="1" style="border-style:none;" alt="" src="http://googleads.g.doubleclick.net/pagead/viewthroughconversion/998479224/?value=0&amp;guid=ON&amp;script=0"/> </div>
</noscript>
<?php } ?>
<div id="footer">
  <div id="dFooter">
    <div class="footer">
      <div class="line"></div>
    </div>
    <div class="footer bg-color">
      <div class="footer-body">
        <ul class="links">
          <li>
            <p class="title"><strong><span style="color:#000000;font-size:14px;">Về CheapDeal</span></strong></p>
            <?php
            	$pages = getStaticPageGroup($arrPage, 'about');
				foreach($pages as $item)
				{					
			?>
            <p class="ndot"><a title="cheapdeal.vn" name="all" href="/<?php echo $item['id'];?>.html"><span style="color:#000000;font-size:13px;"><?php echo $item['name'];?></span></a></p>
            <?			
				}
			?>     
            <br>
            <a href="http://online.gov.vn/HomePage/WebsiteDisplay.aspx?DocId=192" ><img alt="" title="" src="http://online.gov.vn/seals/5SRTfXK7YJevZbpY0VAtGg==.jpgx" style="height:68px; width:126px" /></a> </li>
          <span class="fc-line"></span>
          <li>
            <p class="title"><strong><span style="color:#000000;font-size:14px;">Hỗ trợ</span></strong></p>
            <?php
            	$pages = getStaticPageGroup($arrPage, 'support');
				foreach($pages as $item)
				{					
			?>
            <p class="ndot"><a title="cheapdeal.vn" name="all" href="/<?php echo $item['id'];?>.html"><span style="color:#000000;font-size:13px;"><?php echo $item['name'];?></span></a></p>
            <?			
				}
			?>            
            <a href="http://www.dmca.com/Protection/Status.aspx?ID=90a5d298-6df2-4de1-80e1-b3f34fc75074" title="Chống vi phạm bản quyền"> <img src ="http://images.dmca.com/Badges/dmca_protected_sml_120m.png?ID=90a5d298-6df2-4de1-80e1-b3f34fc75074"  alt="DMCA.com" /></a> </li>
          <span class="fc-line"></span>
          <li>
          	<?php
            	$page = getStaticPageGroupByID($arrPage, 'chuyen-muc');
			?>
            <p class="title"><strong><span style="color:#000000;font-size:14px;"><?php echo $page['name'];?></span></strong></p>
            <?php echo $page['value'];?>
          </li>
          <span class="fc-line"></span>
          <li style="padding-right:0px;background:none;">
          	<?php
            	$page = getStaticPageGroupByID($arrPage, 'don-vi-chu-quan');
			?>
            <p class="title"><strong><span style="color:#000000;font-size:14px;"><?php echo $page['name'];?></span></strong></p>
            <?php echo $page['value'];?>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div id="atfooter_tag">
  <div id="atfooter_tag_content">
    <?php
    	$page = getStaticPageGroupByID($arrPage, 'lien-ket');
	?>
    <h1 style="font-weight:normal"> <strong style="color:#6c6a6a" ><?php echo $page['name'];?>: </strong> 
    <?php echo $page['value'];?>        
    <br />
    </h1>
  </div>
</div>
</body>