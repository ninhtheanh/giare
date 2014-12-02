<?php include template("header");?>
<style>
.infotitle {
	background: #f8f8f8;
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#f4f4f4), to(#fcfcfc));
	background: -webkit-linear-gradient(top, #fcfcfc, #f4f4f4);
	background: -moz-linear-gradient(top, #fcfcfc, #f4f4f4);
	background: -ms-linear-gradient(top, #fcfcfc, #f4f4f4);
	background: -o-linear-gradient(top, #fcfcfc, #f4f4f4);
	height: 43px;
	color: #000;
	font-weight: bold;
	padding-left: 14px;
	line-height: 38px;
}
.atbox-setting {
	margin-top: 0px;
	margin-left: 39px;
	width: 84%;
}
</style>
<div id="bdw" class="bdw">
  <div id="bd" class="cf">
    <div id="learn">
      <div class="subdashboard" id="dashboard">
        <ul>
        </ul>
      </div>
      <div id="content" class="mainwide">
        <div class="box">
          <table width="100%" style="margin-top:8px; margin-bottom:20px;" border="0">
            <tr>
              <td valign="top" style="width:230px;"><?php include template("thongtinhuuich"); //left 1?>
                <?php include template("menu-gioithieu"); //left 2?></td>
              <td valign="top"><div class="atbox-setting"> <?php echo htmlspecialchars_decode($page['value']); ?> </div>
                <br />
                <br />
                <div class="atbox-setting">
                <?php 
					if($idcontent == 'lien-he')
					{
						include "../include/compiled/contact_form.php"; 
				?>
                		<div class="detail_add_title" style="padding-left:0px">Bản đồ</div>
						<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
						<script type="text/javascript">
                              function initialize() {		 
                        
                                 var geocoder;
                                var mapDiv = document.getElementById('mapcanvas');
                                var myLatlng = new google.maps.LatLng(<?php echo $partner['longlat']; ?>);
                                var map = new google.maps.Map(mapDiv, {
                                  center: myLatlng,
                                  zoom: 15,
                                  mapTypeId: google.maps.MapTypeId.ROADMAP,
                                  scrollwheel: true
                                });
                                
                                 geocoder = new google.maps.Geocoder();
                                 
                                 var marker = new google.maps.Marker({
                                        position: myLatlng,
                                        title: '10.78896,106.676899'
                                    });
                                    marker.setMap(map);
                        
                              }
                              
                              google.maps.event.addDomListener(window, 'load', initialize);
                            </script>
                        <div id="mapcanvas" class="mapbody map" style="width:588px; height:300px;border: 1px solid #ccc;"></div>
                <?php	
					}
				?>                  
                </div>
                <div style="float:left; margin-left:40px; margin-top:10px">
                    <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fcheapdeal.HCM&amp;width=737&amp;height=220&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:737px; height:220px;" allowTransparency="true"></iframe> 
                </div>
                </td>
            </tr>
          </table>
          
        </div>
      </div>
    </div>
  </div>
  <!-- bd end --> 
</div>
<!-- bdw end -->
<?php include template("footer");?>
