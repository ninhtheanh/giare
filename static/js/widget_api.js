var domain = 'hotdeal.vn';
var dcolor = 'black';
var dynLoaded = false;

// function to load jQuery...
load = function() {
	load.getScript("http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js");
	load.tryReady(0); // This function waits until jQuery loads before using it.
}
// dynamically load a javascript file.
load.getScript = function(filename) {
	var script = document.createElement('script')
	script.setAttribute("type","text/javascript")
	script.setAttribute("src", filename)
	if (typeof script!="undefined")
	document.getElementsByTagName("head")[0].appendChild(script)
}
load.tryReady = function(time_elapsed) {
	// Continually polls to see if jQuery is loaded.
	if (typeof jQuery == "undefined") { // if jQuery isn't loaded yet...
		if (time_elapsed <= 10000) { // and we havn't given up trying...
			setTimeout("load.tryReady(" + (time_elapsed + 200) + ")", 200); // set a timer to check again in 200 ms.  
		} else {
			// alert("Timed out while loading jQuery.")
		}
	} else {
		// Any code to run after jQuery loads goes here!
		// for example:
		dynLoaded = true;
		groupon_init();
	}
}

if (typeof(jQuery) == 'undefined') {
	// jQuery isn't loaded, so we need to load it...
	load();
} else {
	groupon_init();
}

var DateDiff = function(d1, d2) {
	var t2 = d2.getTime();
	var t1 = d1.getTime();
	var wholeDays = 0;
	var wholeHours = 0;
	var wholeMinutes = 0;
	var wholeSeconds = 0;
	
	var totalSeconds = parseInt((t2-t1) / 1000);
	// 86400 seconds in 1 day
	(totalSeconds > 86400) ? wholeDays = Math.abs(parseInt(totalSeconds / (86400))) : wholeDays = 0;
	var leftAfterDays = totalSeconds - (wholeDays * 86400);
	// 3600 seconds in 1 hour
	var wholeHours = Math.abs(parseInt(leftAfterDays / 3600));
	var leftAfterHours = leftAfterDays - (wholeHours * 3600);
	// 60 seconds in 1 minute
	var wholeMinutes = Math.abs(parseInt(leftAfterHours / 60));
	var leftAfterMinutes = leftAfterHours - (wholeMinutes * 60);
	
	var breakDown = new Object();
	breakDown['days'] = wholeDays;
	if (wholeDays > 0) {
		wholeHours = wholeHours + (24*wholeDays);
	}
	breakDown['hours'] = wholeHours;
	breakDown['minutes'] = wholeMinutes;
	breakDown['seconds'] = leftAfterMinutes;
	
	return breakDown;
}
 
var niceDateDiff = '';

var coords = new Object();
coords['Chicago'] = {'lat' : 41.90, 'lng' : -87.65};
coords['Dallas'] = {'lat' : 32.90, 'lng' : -97.03};
coords['Los Angeles'] = {'lat' : 33.93, 'lng' : -118.40};
coords['Minneapolis / St. Paul'] = {'lat' : 44.9799654, 'lng' : -93.2638361 };

function addCommas(num) {
var objRegExp  = new RegExp('(-?[0-9]+)([0-9]{3})'); 
    while(objRegExp.test(num)) {
       num = num.replace(objRegExp, '$1,$2');
    }
	return num;
}

function groupon_niceNum(num) {
	if (typeof(num) == 'number') { 
		return num;
	} else {
		return addCommas(num);
		//return num.substr(num, num.indexOf('.'));
	}
}
var gInterval=new Array();
function startCountdown(endDate, i) {
	gInterval[i]=setInterval(function() {
		d1 = new Date();
		niceDateDiff = DateDiff(d1, endDate);
		// $('#grouponDays' + i).text(niceDateDiff['days']);
		jQuery('#grouponHours' + i).text(niceDateDiff['hours']);
		jQuery('#grouponMinutes' + i).text(niceDateDiff['minutes']);
		jQuery('#grouponSeconds' + i).text(niceDateDiff['seconds']);
	}, 1000);
}

function displayGrouponAd(APIKEY, size, location, color1, showpreloader, pid, aid, title) {
	APIURL = 'http://'+domain+'/affiliate/json.php?apikey='+APIKEY+'&callback=?';
	ASSETDOMAIN = 'http://'+domain;
	//ASSETDOMAIN = 'http://localhost:3000/'
	CSSURL = new String();	
	CSSURL = ASSETDOMAIN + '/static/css/widget/ad' + size + '.css';	
	//CSSURL = ASSETDOMAIN + '/static/css/widget/ad300.250.css';		

	//jQuery('HEAD').append('<link id="grouponCSS" rel="stylesheet" type="text/css" href="' + CSSURL + '" />');
	//jQuery('#grouponCSS').href = CSSURL;
	IMGURL = ASSETDOMAIN + '/static/img/';	
	if (location.length) {
		var latLon = location.split(',');
		APIURL += '&lat=' + latLon[0];
		APIURL += '&lng=' + latLon[1];
	}
	
	jQuery('<div id="grouponAdContainer"></div>').insertAfter('#grouponAd');
	jQuery('#grouponAdContainer').parent().css('white-space','normal');
	//jQuery('HEAD').append('<link rel="stylesheet" media="screen" type="text/css" href="' + ASSETDOMAIN + '/static/css/reset.css' + '" />');
	var sizeSplit = size.split('.');
	//jQuery('#grouponAdContainer').css({'width' : sizeSplit[0], 'height' : sizeSplit[1]});	
	//jQuery('<div id="grouponAdContainer" style="border:solid 1px #000;width:'+sizeSplit[0]+'px;height:'+sizeSplit[1]+'px;margin:0 auto;padding:0;"></div>').insertAfter('#grouponAd');
	if (showpreloader) {
		jQuery('#grouponAdContainer').html('<div style="text-align: center; font: 10px arial normal; width: ' + sizeSplit[0] + '"><img width="64" height="64" src="http://'+domain+'/static/img/loader.gif" align="center" /><br>Loading...</div>');		
	}
	
	jQuery.getJSON(APIURL, function(data) {								
		data.discount_percent = Math.round(data.discount_percent,1);
		var d1 = new Date();
		var theDate = data.end_date;
		var safeDateTime = theDate.split('T');
		var safeDate = safeDateTime[0].replace(/-/g,"/");
		var safeTime = safeDateTime[1].replace(/Z/g,"");
		
		var d2 = new Date(safeDate + ' ' + safeTime);
		
		var nicePrice = '$' + groupon_niceNum(data.price);
		jQuery('#grouponAdContainer').html('');
		//adding code to not loop through to side-deal if there isnt one
		if(data.url==undefined){var lE=1;}else{var lE=2;}
		//and if the color doesnt have hashtag, we'll add one
		if(color1.indexOf("#")<0){color1="#"+color1;}
		//prepend CJ information to the clickthru
		var cjprepend='http://'+domain+'/team.php?id='+data.id+'&utm_medium=afl&utm_campaign='+pid+'&utm_source=rvs&aid='+aid+'&url=';
		switch (size) {
			case '300.250':
				jQuery('#grouponAdContainer').append('<div id="grouponAdContents" style="width:290px;height:240px;background:white;padding:5px;"></div>');
				var cityDiv = '<div id="grouponCity" style="color:'+color1+';font-size:130%;font-weight:bold;">Deal hôm nay - ' + data.division_name + '</div>'
				jQuery('#grouponAdContents').append(cityDiv);
				
				var descriptionDiv = '<div id="grouponDescription" style="overflow:hidden;margin-top:10px;height:30px;color:'+dcolor+';font-size:1.1em">' + data.title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(descriptionDiv);
				
				var valueChart = '<div id="grouponValueChart" style="margin-top:0px;"><font color="#666">Giảm giá: </font><span style="color:#c40000;font-size:1.8em">' + data.discount_percent + '%</span><br><br><font color="#666">Tiết kiệm: </font><span style="color:#c40000;font-size:1.1em">' + groupon_niceNum(data.discount_amount) + ' Đ</span></div>';
				
				var footer = '<div id="grouponFooter" style="margin-top:10px;"><p><font color="' + dcolor + '">' + data.quantity_sold + '</font> người mua</p></div>';
				
				var buyTag = '<h3 id="grouponBuy" style="margin-top:10px;text-decoration:underline;color:'+color1+'">MUA NGAY!</h3>';
				
				
				//var buyButton = '<div id="grouponBuyButton">'+data.value+' Đ</div>';
				var midLeftContent =  valueChart + footer + buyTag//buyButton +
				var midContent = '<div id="grouponMidContainer" style="margin-top:15px;width:300px;height:120px;"><div id="grouponMidLeft" style="float: left;">' + midLeftContent + '</div><div id="grouponImage" style="float:right;margin-right:4px;width:160px;height:113px;overflow:hidden;margin-top:0px;"><img width="160" id="grouponIMG" src="http://' + domain+'/static/'+data.large_image_url + '"></div></div>';
				jQuery('#grouponAdContents').append(midContent);
				
				var countdown = '<div style="float:left;margin:15px 0px 0px 0px;width:60px;"><span style="font-size:0.9em;color:#666">Thời gian còn lại:</span></div><div style="float:left;margin-top:15px;margin-left:10px;font-size:1em" id="grouponCountdown"><div id="grouponCountContainer"><span class="countdownTime" style="width:30px;float:left;color:#666;">Giờ<br><span id="grouponHours">0</span></span><span class="grouponColon" style="float: left;">:</span><span class="countdownTime" style="width:30px;float:left;color:#666;">Phút<br><span id="grouponMinutes">0</span></span><span class="grouponColon" style="float: left;">:</span><span class="countdownTime" style="width:30px;float:left;color:#666;">Giây<br><span id="grouponSeconds">0</span></span></div></div>';
				// $('#grouponImage').css('background-image','url(' + data.large_image_url + ')');		
				jQuery('#grouponAdContents').append(countdown);
				
				var poweredByDiv = '<br><div id="grouponPoweredBy" style="float:right;margin-top:-2px;"><img src="http://'+domain+'/static/img/power.png" width="77" height="29"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				
				setInterval(function() {
					d1 = new Date();
					niceDateDiff = DateDiff(d1, d2);
					jQuery('#grouponHours').text(niceDateDiff['hours']);
					jQuery('#grouponMinutes').text(niceDateDiff['minutes']);
					jQuery('#grouponSeconds').text(niceDateDiff['seconds']);
				}, 1000);
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border', 'solid 1px ' + color1);					
				}	
			/*	setTimeout(function() {
					jQuery('#grouponDescription').autoEllipsis();
				}, 200);*/
				break;
				
			case '88.31':
				thisTitle = data.title.replace("&","and");
				var grouponAd = '<div id="grouponAdContents" style="width:88px;height:31px;"><a title="' + thisTitle.replace(/\"/g, '&quot;') + '" href="' + cjprepend+data.deal_url + '" target="_blank"><img src="http://'+domain+'/static/img/power.png"></a></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				//jQuery('#grouponAdContainer').css('text-align','center');
				// change color of border... 
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border', 'solid 1px ' + color1);
				}
				break;
			case '120.60':
				var grouponAd = '<div id="grouponAdContents" style="width:120px;height:60px;background:#fff;padding:2px;"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);				
				var titleDiv = '<div id="grouponTitle" style="height:40px;font-size:75%">' + data.title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				var getDiv = '<h4 id="grouponGet" style="text-decoration:underline;margin-top:3px;">MUA!</h4>';
				jQuery('#grouponAdContents').append(getDiv);
				var poweredByDiv = '<div id="grouponPoweredBy" style="float:right;margin-top:-14px"><img src="http://'+domain+'/static/img/powers.png"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				// change color of text... 
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border', 'solid 1px ' + color1);
					jQuery('#grouponGet').css('color', color1);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '120.90.lofi':
				var grouponAd = '<div id="grouponAdContents"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity">' + data.division_name + '</div>';
				jQuery('#grouponAdContents').append(cityDiv);
				if (data.division_name.length > 14) {
					jQuery('#grouponCity').css('font-size','10px');
					jQuery('#grouponCity').css('top','6px');
				}
				var titleDiv = '<div id="grouponTitle">' + data.title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				var getDiv = '<div id="grouponGet">Get It!</div>';
				jQuery('#grouponAdContents').append(getDiv);
				var poweredByDiv = '<div id="grouponPoweredBy"><img src="http://www.groupon.com/images/groupon/widget/poweredby_small_lofi.gif"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				// change color of text... 
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponGet').css('color', color1);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '120.90':
				var grouponAd = '<div id="grouponAdContents" style="background:#fff;width:120px;height:90px;border:solid 1px '+color1+'"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity"><p style="padding:3px;font:bold 0.8em arial;color:white">'+data.division_name+'</p></div>';
				jQuery('#grouponAdContents').append(cityDiv);
				var titleDiv = '<div id="grouponTitle" style="margin:3px;height:30px;font-size:75%;color:'+dcolor+'">' + data.title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				//var imgDiv = '<div id="grouponImage"><img width="70" height="42" src="' + data.large_image_url + '" /></div>';
				//jQuery('#grouponAdContents').append(imgDiv);
				var tagDiv = '<div id="grouponTag" style="margin:3px;margin-top:-10px;font-size:85%;">Giảm giá : <span style="color:#c40000;font-size:1.4em">' + data.discount_percent + '%</span></div>';				
				jQuery('#grouponAdContents').append(tagDiv);
				var getDiv = '<h4 id="grouponGet" style="margin:6px;text-decoration:underline;color:'+color1+'">MUA!</h4>';
				jQuery('#grouponAdContents').append(getDiv);
				var poweredByDiv = '<div id="grouponPoweredBy" style="float:right;margin-top:-20px;"><img src="http://hotdeal.vn/static/img/powers.png"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponCity').css('background-color', color1);
				}
				if (typeof(color2) != 'undefined') {
					jQuery('#grouponCity').css('color', color2);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);				
				//jQuery('#grouponAdContainer').css({'border':'solid 1px '+color1, 'width' : sizeSplit[0], 'height' : sizeSplit[1]});	
				break;
			case '125.125.lofi':
				var grouponAd = '<div id="grouponAdContents"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity">' + data.division_name + '</div>';
				jQuery('#grouponAdContents').append(cityDiv);
				if (data.division_name.length > 14) {
					jQuery('#grouponCity').css('font-size','11px');
				}
				var titleDiv = '<div id="grouponTitle">' + data.title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				var tableDiv = '<div class="grouponTable"><div class="grouponTableLeft" align="center"></div><div class="grouponTableRight"></div>';
				jQuery('#grouponAdContents').append(tableDiv);
				jQuery('#grouponAdContents .grouponTableLeft').html('Discount:<br>You Save:');
				jQuery('#grouponAdContents .grouponTableRight').html(groupon_niceNum(data.discount_percent) + '%<br>$' + groupon_niceNum(data.discount_amount));
				var getDiv = '<div id="grouponGet">Get It!</div>';
				jQuery('#grouponAdContents').append(getDiv);
				var poweredByDiv = '<div id="grouponPoweredBy"><img src="http://www.groupon.com/images/groupon/widget/poweredby_small_lofi.gif"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				// change color of text... 
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponGet').css('color', color1);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '125.125':
				var grouponAd = '<div id="grouponAdContents" style="background:#fff;font-size:80%;width:'+sizeSplit[0]+'px;height:'+sizeSplit[1]+'px;border:solid 2px '+color1+'"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity" style="color:white;padding:0px;font:bold 1.1em arial">'+data.division_name+'</div>';
				jQuery('#grouponAdContents').append(cityDiv);
				var titleDiv = '<div id="grouponTitle" style="margin:3px;margin-top:6px;height:30px;color:'+dcolor+'">' + data.title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				//var imgDiv = '<div id="grouponImage"><img width="71" height="42" src="' + data.large_image_url + '" /></div>';
				//jQuery('#grouponAdContents').append(imgDiv);
				var tagDiv = '<div id="grouponTag"><a href="' + cjprepend+data.deal_url + '" target="_blank">' + nicePrice + '</a></div>';
				//jQuery('#grouponAdContents').append(tagDiv);
				var discountDiv = '<div id="grouponDiscount" style="margin:3px;margin-top:0px;">Giảm giá: <span style="color:#c40000;font:bold 1.4em arial;">' + data.discount_percent + '%</span></div><div id="grouponSave" style="margin:3px;">Tiết kiệm: <span style="color:#c40000;font:bold 1.1em arial;">' + data.discount_amount + 'Đ</span></div>';
				jQuery('#grouponAdContents').append(discountDiv);
			
				var getDiv = '<h3 id="grouponGet" style="margin:3px;text-decoration:underline;color:'+color1+'">MUA!</font></h3>';
				jQuery('#grouponAdContents').append(getDiv);
				var poweredByDiv = '<div id="grouponPoweredBy" style="float:right;margin-top:-10px;"><img src="http://hotdeal.vn/static/img/powers.png></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponCity').css('background-color', color1);
				}
				if (typeof(color2) != 'undefined') {
					jQuery('#grouponCity').css('color', color2);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
					jQuery('#grouponCity').autoEllipsis();
				}, 200);
				break;
			case '180.150.lofi':
				var grouponAd = '<div id="grouponAdContents"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity">Daily Deal:' + data.division_name + '</div>';
				jQuery('#grouponAdContents').append(cityDiv);
				var titleDiv = '<div id="grouponTitle">' + data.title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				var discountDiv = '<div id="grouponDiscount"><div>DISCOUNT:</div>'+groupon_niceNum(data.discount_percent)+'%<div>SAVE:</div>$'+groupon_niceNum(data.discount_amount)+'</div>';
				jQuery('#grouponAdContents').append(discountDiv);
				var imgDiv = '<div id="grouponImage"><img width="113" height="66" src="' + data.medium_image_url + '" /></div>';
				jQuery('#grouponAdContents').append(imgDiv);
				var getDiv = '<div id="grouponGet">Get It!</div>';
				jQuery('#grouponAdContents').append(getDiv);
				var poweredByDiv = '<div id="grouponPoweredBy"><img src="http://www.groupon.com/images/groupon/widget/poweredby_small_lofi.gif"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				// change color of text... 
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponCity').css('color', color1);
					jQuery('#grouponGet').css('color', color1);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '180.150':
				var grouponAd = '<div id="grouponAdContents" style="background:#fff;font-size:90%;width:180px;height:150px;border:solid 5px '+color1+'"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity" style="color:#fff"><strong>Deal hôm nay : ' + data.division_name + '!</strong></div>';
				jQuery('#grouponAdContents').append(cityDiv);
				var titleDiv = '<div id="grouponTitle" style="margin:3px;height:30px;">' + data.title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);				
				var imgDiv = '<div id="grouponImage" style="float:right;margin-top:0px;"><img width="93" height="56" src="http://' + domain+'/static/' + data.large_image_url + '" /></div>';
				jQuery('#grouponAdContents').append(imgDiv);
				var vDiv = '<div id="grouponTag" style="margin-top:0px;padding-top:3px;text-align:center;width:81px;height:23px;background:url(http://' + domain+'/static/img/bgbuy.gif) no-repeat;"><p style="color:white;font-weight:bold;">' + data.value + ' Đ</p></div>';
				jQuery('#grouponAdContents').append(vDiv);
				var tableDiv = '<div id="grouponTable" style="margin-top:5px;margin-left:0px;color:#666"><div id="grouponTableLeft"></div><div id="grouponTableRight"></div>';
				jQuery('#grouponAdContents').append(tableDiv);
				jQuery('#grouponTableLeft').html('<div align="center" style="width:70px;">Giảm<br><span style="color:#c40000"><b>' + data.discount_percent + '%</b></span></div>');
				jQuery('#grouponTableRight').html('<div align="center" style="width:70px;padding-top:5px">Tiết kiệm:<br><span style="color:#c40000"><b>' + groupon_niceNum(data.discount_amount)+' Đ</b></span></div>');
				//jQuery('#grouponAdContents').append(discountDiv);
				var tagDiv = '<div align="right" id="tagDiv" style="margin-right:2px; margin-top:-17px;font:1.5em bold Arial;color:'+color1+'"><img width="50" height="17" src="http://' + domain+'/static/img/buy_aff.gif" />&nbsp;<img width="50" height="17" src="http://' + domain+'/static/img/by_hotdeal.gif" /></div>';
				jQuery('#grouponAdContents').append(tagDiv);
				var poweredByDiv = '<div id="grouponPoweredBy"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponCity').css('background-color', color1);
				}
				if (typeof(color2) != 'undefined') {
					jQuery('#grouponCity').css('color', color2);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '234.60.lofi':
				var grouponAd = '<div id="grouponAdContents"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity">Daily Deal: ' + data.division_name + '</div>';
				jQuery('#grouponAdContents').append(cityDiv);
				if (data.division_name.length > 14) {
					jQuery('#grouponCity').css('font-size','10px');
					jQuery('#grouponCity').css('top','6px');
				}
				var titleDiv = '<div id="grouponTitle">' + data.title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				var getDiv = '<div id="grouponGet">Get It!</div>';
				jQuery('#grouponAdContents').append(getDiv);
				var poweredByDiv = '<div id="grouponPoweredBy"><img src="http://www.groupon.com/images/groupon/widget/poweredby_small_lofi.gif"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				// change color of text... 
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponGet').css('color', color1);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);
				break;
				
			case '234.60':
				var grouponAd = '<div id="grouponAdContents" style="background:#fff;font-size:90%;width:'+sizeSplit[0]+'px;height:'+sizeSplit[1]+'px;border:solid 1px '+color1+'"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity" style="font:bold 1.0em arial;padding:3px;color:#fff">Deal hôm nay : ' + data.division_name + '</div>';
				jQuery('#grouponAdContents').append(cityDiv);
				var titleDiv = '<div id="grouponTitle" style="margin:3px;height:20px;">' + data.title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);				
				
				var discountDiv = '<div style="margin:2px;margin-top:-10px;">Giảm : <span style="font:bold 1.4em arial;color:#c40000">' + data.discount_percent + '% </span>&nbsp;&nbsp;&nbsp;<span id="tagDiv" style="text-decoration:underline;font:bold 1.1em Arial;color:'+color1+'">MUA!</span></div><div style="float:right;margin-top:-20px"><img src="http://hotdeal.vn/static/img/powers.png"></div>';				
				jQuery('#grouponAdContents').append(discountDiv);				
				
				jQuery('#grouponAdContents').append(tagDiv);
				var poweredByDiv = '<div id="grouponPoweredBy"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponCity').css('background-color', color1);
				}
				if (typeof(color2) != 'undefined') {
					jQuery('#grouponCity').css('color', color2);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);
				break;
				
			case '230.260':
			var grouponAd = '<div id="grouponAdContents" style="background:#fff;font-size:1em;padding:5px;width:218px;height:248px;border:solid 1px '+color1+'"></div>';
			jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity" style="font-size:1.2em;margin-top:5px;color:'+color1+'"><strong>Deal hôm nay - ' + data.division_name + '</strong></div>'
				jQuery('#grouponAdContents').append(cityDiv);
				var descriptionDiv = '<div id="grouponDescription" style="overflow:hidden;height:30px;margin-top:15px;color:'+dcolor+';">' + data.title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(descriptionDiv);
				var valueChart = '<div id="grouponValueChart" style="font-size:1em;margin-top:10px;"><font color="#666">Giảm giá: </font><span style="color:#c40000;font-size:1.8em">' + data.discount_percent + '%</span><br><font color="#666">Tiết kiệm: </font><span style="color:#c40000;font-size:1em;">' + groupon_niceNum(data.discount_amount) + ' Đ</span></div>';
				
				var footer = '<div id="grouponFooter" style="margin-top:10px;"><p><font color="' + dcolor + '">' + data.quantity_sold + '</font> người mua</p></div>';
				
				var buyTag = '<h3 id="grouponBuy" style="margin-top:15px;text-decoration:underline;color:'+color1+'">MUA NGAY!</h3>';				
				
				var buyButton = '<div id="grouponBuyButton">'+data.value+' Đ</div>';
				var midLeftContent =  valueChart + footer + buyTag;//buyButton +
				var midContent = '<div id="grouponMidContainer"><div style="margin-right:-5px;float: right;width:125px;height:125px;overflow:hidden;"><img width="130" src="http://' + domain+'/static/'+data.large_image_url + '"></div><div id="grouponMidLeft">' + midLeftContent + '</div></div>';
				jQuery('#grouponAdContents').append(midContent);
				// $('#grouponImage').css('background-image','url(' + data.large_image_url + ')');		
				
				var countdown = '<div style="float:left;width:180px"><div style="color:#666">Thời gian còn lại:</div><div><span id="grouponHours">0</span> giờ <span id="grouponMinutes">0</span> phút <span id="grouponSeconds">0</span> giây</div></div>';
				jQuery('#grouponAdContents').append(countdown);
				
				var poweredByDiv = '<div id="grouponPoweredBy" style="float:right;margin-top:-30px;"><img src="http://'+domain+'/static/img/power.png"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				
				setInterval(function() {
					d1 = new Date();
					niceDateDiff = DateDiff(d1, d2);
					jQuery('#grouponHours').text(niceDateDiff['hours']);
					jQuery('#grouponMinutes').text(niceDateDiff['minutes']);
					jQuery('#grouponSeconds').text(niceDateDiff['seconds']);
				}, 1000);
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border', 'solid 1px ' + color1);					
				}
				/*setTimeout(function() {
					jQuery('#grouponDescription').autoEllipsis();
				}, 200);*/
				break;
				
			case '250.250':
			var grouponAd = '<div id="grouponAdContents" style="background:#fff;font-size:1em;padding:5px;width:250px;height:250px;border:solid 1px '+color1+'"></div>';
			jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity" style="font-size:1.1em;margin-top:5px;color:'+color1+'"><strong>Deal hôm nay - ' + data.division_name + '</strong></div>'
				jQuery('#grouponAdContents').append(cityDiv);
				var descriptionDiv = '<div id="grouponDescription" style="margin-top:15px;"><p style="color:'+dcolor+'">' + data.title.replace("&","and") + '</p></div>';
				jQuery('#grouponAdContents').append(descriptionDiv);
				var valueChart = '<div id="grouponValueChart" style="font-size:1em;margin-top:10px;"><font color="#666">Giảm giá: </font><span style="color:#c40000;font-size:1.8em">' + data.discount_percent + '%</span><br><font color="#666">Tiết kiệm: </font><span style="color:#c40000;font-size:1em;">' + groupon_niceNum(data.discount_amount) + ' Đ</span></div>';
				
				var footer = '<div id="grouponFooter" style="margin-top:10px;"><p><font color="' + dcolor + '">' + data.quantity_sold + '</font> người mua</p></div>';
				
				var buyTag = '<h3 id="grouponBuy" style="margin-top:15px;text-decoration:underline;color:'+color1+'">MUA NGAY!</h3>';				
				
				var buyButton = '<div id="grouponBuyButton">'+data.value+' Đ</div>';
				var midLeftContent =  valueChart + footer + buyTag;//buyButton +
				var midContent = '<div id="grouponMidContainer"><div style="margin-right:-5px;float: right;width:125px;height:125px;overflow:hidden;"><img width="130" src="http://' + domain+'/static/'+data.large_image_url + '"></div><div id="grouponMidLeft">' + midLeftContent + '</div></div>';
				jQuery('#grouponAdContents').append(midContent);
				// $('#grouponImage').css('background-image','url(' + data.large_image_url + ')');		
				
				var countdown = '<div style="float:left;width:180px"><div style="color:#666">Thời gian còn lại:</div><div><span id="grouponHours">0</span> giờ <span id="grouponMinutes">0</span> phút <span id="grouponSeconds">0</span> giây</div></div>';
				jQuery('#grouponAdContents').append(countdown);
				
				var poweredByDiv = '<div id="grouponPoweredBy" style="float:right;margin-top:-30px;"><img src="http://'+domain+'/static/img/power.png"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				
				setInterval(function() {
					d1 = new Date();
					niceDateDiff = DateDiff(d1, d2);
					jQuery('#grouponHours').text(niceDateDiff['hours']);
					jQuery('#grouponMinutes').text(niceDateDiff['minutes']);
					jQuery('#grouponSeconds').text(niceDateDiff['seconds']);
				}, 1000);
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border', 'solid 1px ' + color1);					
				}
				/*setTimeout(function() {
					jQuery('#grouponDescription').autoEllipsis();
				}, 200);*/
				break;
			
			case '250.250.lofi':
				var grouponAd = '<div id="grouponAdContents"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity">Today\'s Deal: ' + data.division_name + '</div>';
				jQuery('#grouponAdContents').append(cityDiv);
				if (data.division_name.length > 14) {
					jQuery('#grouponCity').css('font-size','13px');
				}
				var titleDiv = '<div id="grouponTitle">' + data.title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				var imgDiv = '<div id="grouponImage"><img width="153" height="87" src="' + data.large_image_url + '" /></div>';
				var tableDiv = '<div id="grouponTable"><div id="grouponTableLeft"></div><div id="grouponTableRight"></div>';
				jQuery('#grouponAdContents').append(tableDiv);
				jQuery('#grouponTableLeft').html('Discount:<br>You Save:');
				jQuery('#grouponTableRight').html(groupon_niceNum(data.discount_percent) + '%<br>$' + groupon_niceNum(data.discount_amount));
				jQuery('#grouponAdContents').append(imgDiv);
				var boughtDiv = '<div id="grouponBought"><strong>' + data.quantity_sold + '</strong> Bought</div>';
				jQuery('#grouponAdContents').append(boughtDiv);
				var getDiv = '<div id="grouponGet">Get It!</div>';
				jQuery('#grouponAdContents').append(getDiv);
				var countdown = '<div id="grouponCountdown"><div id="grouponCountContainer"><span class="countdownText">Time left<br>to buy</span><span class="countdownTime"><span id="grouponHours">0</span><br>H</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponMinutes">0</span><br>M</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponSeconds">0</span><br>S</span></div></div>';
				jQuery('#grouponAdContents').append(countdown);
				setInterval(function() {
					d1 = new Date();
					niceDateDiff = DateDiff(d1, d2);
					jQuery('#grouponHours').text(niceDateDiff['hours']);
					jQuery('#grouponMinutes').text(niceDateDiff['minutes']);
					jQuery('#grouponSeconds').text(niceDateDiff['seconds']);
				}, 1000);
				var poweredByDiv = '<div id="grouponPoweredBy"><img src="http://www.groupon.com/images/groupon/widget/poweredby_large_lofi.png"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				// change color of text... 
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponCity').css('color', color1);
					jQuery('#grouponGet').css('color', color1);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '250.250.lofimulti':
				for (i=0; i<lE; i++) {
					thisDeal = '#grouponAdContents' + i;
					var grouponAd = '<div id="grouponAdContents'+i+'" class="grouponAdContents"></div>';
					jQuery('#grouponAdContainer').append(grouponAd);
					if ((title != null) && (title != '') && (title!='undefined')) {
						cityText = title;
					} else {
						cityText = 'Today\'s Deal: ' + data.deals[i].division_name;
					}
					var cityDiv = '<div class="grouponCity">'+cityText+'</div>';
					jQuery(thisDeal).append(cityDiv);
					if (data.deals[i].division_name.length > 14) {
						jQuery(thisDeal+' .grouponCity').css('font-size','13px');
					}
					var titleDiv = '<div class="grouponTitle">' + data.deals[i].title.replace("&","and") + '</div>';
					jQuery(thisDeal).append(titleDiv);
					var imgDiv = '<div class="grouponImage"><img width="153" height="87" src="' + data.deals[i].large_image_url + '" /></div>';
					jQuery(thisDeal).append(imgDiv);
					if(lE==2){
					  if (i == 0) {
						  thisButtonID = 'grouponShowSide'
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="28" height="126" src="http://www.groupon.com/images/groupon/widget/showsidedeal_medium.png" /></div>';
					  } else {
						  thisButtonID = 'grouponShowDaily';
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="28" height="126" src="http://www.groupon.com/images/groupon/widget/showdailydeal_medium.png" /></div>';
					  }
					  jQuery(thisDeal).append(otherDealDiv);
				  }
					var tableDiv = '<div class="grouponTable"><div class="grouponTableLeft"></div><div class="grouponTableRight"></div>';
					jQuery(thisDeal).append(tableDiv);
					jQuery(thisDeal+' .grouponTableLeft').html('Discount:<br>You Save:');
					jQuery(thisDeal+' .grouponTableRight').html(groupon_niceNum(data.deals[i].discount_percent) + '%<br>$' + groupon_niceNum(data.deals[i].discount_amount));
					var boughtDiv = '<div class="grouponBought"><strong>' + data.deals[i].quantity_sold + '</strong> Bought</div>';
					jQuery(thisDeal).append(boughtDiv);
					var getDiv = '<div class="grouponGet">Get It!</div>';
					jQuery(thisDeal).append(getDiv);
					var countdown = '<div class="grouponCountdown"><div class="grouponCountContainer"><span class="countdownText">Time left<br>to buy</span><span class="countdownTime"><span id="grouponHours'+i+'">0</span><br>H</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponMinutes'+i+'">0</span><br>M</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponSeconds'+i+'">0</span><br>S</span></div></div>';
					jQuery(thisDeal).append(countdown);
					if(typeof(gInterval)!='undefined'){
  			    clearInterval(gInterval[i]); 
  			  }
					startCountdown(d2, i);
					var poweredByDiv = '<div class="grouponPoweredBy"><img src="http://www.groupon.com/images/groupon/widget/poweredby_large_lofi.gif"></div>';
					jQuery(thisDeal).append(poweredByDiv);
					// change color of text... 
					if (typeof(color1) != 'undefined') {
						jQuery(thisDeal).css('border-color', color1);
						jQuery('.grouponCity').css('color', color1);
						jQuery('.grouponGet').css('color', color1);
					}
				}
				jQuery('#grouponShowSide').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '-=250'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
							window.location.href= cjprepend+data.deals[1].deal_url;
						});
					});
					return false;
				});
				jQuery('#grouponShowDaily').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '+=250'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
							window.location.href= cjprepend+data.deal_url;
						});
					});
					return false;
				});
				setTimeout(function() {
					jQuery('.grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '300.250.lofimulti':
				for (i=0; i<lE; i++) {
					thisDeal = '#grouponAdContents' + i;
					var grouponAd = '<div id="grouponAdContents'+i+'" class="grouponAdContents"></div>';
					jQuery('#grouponAdContainer').append(grouponAd);
					var cityDiv = '<div class="grouponCity">Today\'s Deal: ' + data.deals[i].division_name + '</div>';
					jQuery(thisDeal).append(cityDiv);
					if (data.deals[i].division_name.length > 14) {
						jQuery(thisDeal+' .grouponCity').css('font-size','13px');
					}
					var titleDiv = '<div class="grouponTitle">' + data.deals[i].title.replace("&","and") + '</div>';
					jQuery(thisDeal).append(titleDiv);
					var imgDiv = '<div class="grouponImage"><img width="190" height="108" src="' + data.deals[i].large_image_url + '" /></div>';
					jQuery(thisDeal).append(imgDiv);
					if(lE==2){
					  if (i == 0) {
						  thisButtonID = 'grouponShowSide'
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="28" height="126" src="http://www.groupon.com/images/groupon/widget/showsidedeal_medium.png" /></div>';
					  } else {
						  thisButtonID = 'grouponShowDaily';
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="28" height="126" src="http://www.groupon.com/images/groupon/widget/showdailydeal_medium.png" /></div>';
					  }
					  jQuery(thisDeal).append(otherDealDiv);
				  }
					var tableDiv = '<div class="grouponTable"><div class="grouponTableLeft"></div><div class="grouponTableRight"></div>';
					jQuery(thisDeal).append(tableDiv);
					jQuery(thisDeal+' .grouponTableLeft').html('Discount:<br>You Save:');
					jQuery(thisDeal+' .grouponTableRight').html(groupon_niceNum(data.deals[i].discount_percent) + '%<br>$' + groupon_niceNum(data.deals[i].discount_amount));
					var boughtDiv = '<div class="grouponBought"><strong>' + data.deals[i].quantity_sold + '</strong> Bought</div>';
					jQuery(thisDeal).append(boughtDiv);
					var getDiv = '<div class="grouponGet">Get It!</div>';
					jQuery(thisDeal).append(getDiv);
					var countdown = '<div class="grouponCountdown"><div class="grouponCountContainer"><span class="countdownText">Time left<br>to buy</span><span class="countdownTime"><span id="grouponHours'+i+'">0</span><br>H</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponMinutes'+i+'">0</span><br>M</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponSeconds'+i+'">0</span><br>S</span></div></div>';
					jQuery(thisDeal).append(countdown);
					if(typeof(gInterval)!='undefined'){
  			    clearInterval(gInterval[i]); 
  			  }
					startCountdown(d2, i);
					var poweredByDiv = '<div class="grouponPoweredBy"><img src="http://www.groupon.com/images/groupon/widget/poweredby_large_lofi.gif"></div>';
					jQuery(thisDeal).append(poweredByDiv);
					// change color of text... 
					if (typeof(color1) != 'undefined') {
						jQuery(thisDeal).css('border-color', color1);
						jQuery('.grouponCity').css('color', color1);
						jQuery('.grouponGet').css('color', color1);
					}
				}
				jQuery('#grouponShowSide').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '-=300'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
							window.location.href= cjprepend+data.deals[1].deal_url;
						});
					});
					return false;
				});
				jQuery('#grouponShowDaily').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '+=300'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
							window.location.href= cjprepend+data.deal_url;
						});
					});
					return false;
				});
				setTimeout(function() {
					jQuery('.grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '300.250.lofi':
				var grouponAd = '<div id="grouponAdContents"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity">Today\'s Deal: ' + data.division_name + '</div>';
				jQuery('#grouponAdContents').append(cityDiv);
				var titleDiv = '<div id="grouponTitle">' + data.title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				var imgDiv = '<div id="grouponImage"><img width="192" height="113" src="' + data.large_image_url + '" /></div>';
				var tableDiv = '<div id="grouponTable"><div id="grouponTableLeft"></div><div id="grouponTableRight"></div>';
				jQuery('#grouponAdContents').append(tableDiv);
				jQuery('#grouponTableLeft').html('Price:<br>Value:<br>Save:');
				jQuery('#grouponTableRight').html('$' + groupon_niceNum(data.price) + '<br>$' + groupon_niceNum(data.value) + '<br>$' + groupon_niceNum(data.discount_amount));
				jQuery('#grouponAdContents').append(imgDiv);
				var boughtDiv = '<div id="grouponBought"><strong>' + data.quantity_sold + '</strong> Bought</div>';
				jQuery('#grouponAdContents').append(boughtDiv);
				var getDiv = '<div id="grouponGet">Get It!</div>';
				jQuery('#grouponAdContents').append(getDiv);
				var countdown = '<div id="grouponCountdown"><div id="grouponCountContainer"><span class="countdownText">Time left<br>to buy</span><span class="countdownTime"><span id="grouponHours">0</span><br>H</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponMinutes">0</span><br>M</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponSeconds">0</span><br>S</span></div></div>';
				jQuery('#grouponAdContents').append(countdown);
				setInterval(function() {
					d1 = new Date();
					niceDateDiff = DateDiff(d1, d2);
					jQuery('#grouponHours').text(niceDateDiff['hours']);
					jQuery('#grouponMinutes').text(niceDateDiff['minutes']);
					jQuery('#grouponSeconds').text(niceDateDiff['seconds']);
				}, 1000);
				var poweredByDiv = '<div id="grouponPoweredBy"><img src="http://www.groupon.com/images/groupon/widget/poweredby_large_lofi.png"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				// change color of text... 
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponCity').css('color', color1);
					jQuery('#grouponGet').css('color', color1);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);
				break;
				
			case '336.280':
			var grouponAd = '<div id="grouponAdContents" style="padding:5px;background:#fff;font-size:1em;padding:5px;width:336px;height:280px;border:solid 1px '+color1+'"></div>';
			jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity" style="font-size:1.3em;color:'+color1+'"><strong>Deal hôm nay - ' + data.division_name + '</strong></div>'
				jQuery('#grouponAdContents').append(cityDiv);
				var descriptionDiv = '<br><div id="grouponDescription" style="height:40px;color:'+dcolor+'">' + data.title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(descriptionDiv);
				var valueChart = '<div id="grouponValueChart" style="margin-top:15px;"><font color="#666">Giảm giá : </font><span style="color:#c40000;font-size:1.8em;">' + data.discount_percent + '%</span><br><br><font color="#666">Tiết kiệm : </font><span style="color:#c40000;font-size:1.1em;">' + groupon_niceNum(data.discount_amount) + ' Đ</span></div>';
				
				var footer = '<br><div id="grouponFooter"><p><font color="' + dcolor + '">' + data.quantity_sold + '</font> người mua</p></div>';
				
				var buyTag = '<br><h3 id="grouponBuy" style="text-decoration:underline;color:'+color1+';">MUA NGAY!</h3>';				
				
				var countdown = '<br><div style="margin-top:25px;color:#666">Thời gian còn lại:</div><div><span id="grouponHours">0</span> giờ <span id="grouponMinutes">0</span> phút <span id="grouponSeconds">0</span> s</div>';
				
				
				var buyButton = '<div id="grouponBuyButton">'+data.value+' Đ</div>';
				var midLeftContent =  valueChart + footer + buyTag + countdown;//buyButton +
				var midContent = '<div id="grouponMidContainer"><div style="margin-top:15px;margin-right:-5px;float: right;width:195px;height:120px;overflow:hidden;"><img width="195" src="http://' + domain+'/static/'+data.large_image_url + '"></div><div id="grouponMidLeft">' + midLeftContent + '</div></div>';
				jQuery('#grouponAdContents').append(midContent);
				// $('#grouponImage').css('background-image','url(' + data.large_image_url + ')');		
				
				
				var poweredByDiv = '<div id="grouponPoweredBy" style="float:right;margin-top:-30px;"><img src="http://'+domain+'/static/img/power.png"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				
				setInterval(function() {
					d1 = new Date();
					niceDateDiff = DateDiff(d1, d2);
					jQuery('#grouponHours').text(niceDateDiff['hours']);
					jQuery('#grouponMinutes').text(niceDateDiff['minutes']);
					jQuery('#grouponSeconds').text(niceDateDiff['seconds']);
				}, 1000);
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border', 'solid 1px ' + color1);					
				}
				break;	
				
				
			case '336.280.lofimulti':
				for (i=0; i<lE; i++) {
					thisDeal = '#grouponAdContents' + i;
					var grouponAd = '<div id="grouponAdContents'+i+'" class="grouponAdContents"></div>';
					jQuery('#grouponAdContainer').append(grouponAd);
					var cityDiv = '<div class="grouponCity">Today\'s Deal: ' + data.deals[i].division_name + '</div>';
					jQuery(thisDeal).append(cityDiv);
					if (data.deals[i].division_name.length > 14) {
						jQuery(thisDeal+' .grouponCity').css('font-size','13px');
					}
					var titleDiv = '<div class="grouponTitle">' + data.deals[i].title.replace("&","and") + '</div>';
					jQuery(thisDeal).append(titleDiv);
					var imgDiv = '<div class="grouponImage"><img width="223" height="129" src="' + data.deals[i].large_image_url + '" /></div>';
					jQuery(thisDeal).append(imgDiv);
					if(lE==2){
					  if (i == 0) {
						  thisButtonID = 'grouponShowSide'
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="28" height="126" src="http://www.groupon.com/images/groupon/widget/showsidedeal_medium.png" /></div>';
					  } else {
						  thisButtonID = 'grouponShowDaily';
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="28" height="126" src="http://www.groupon.com/images/groupon/widget/showdailydeal_medium.png" /></div>';
					  }
					  jQuery(thisDeal).append(otherDealDiv);
				  }
					var tableDiv = '<div class="grouponTable"><div class="grouponTableLeft"></div><div class="grouponTableRight"></div>';
					jQuery(thisDeal).append(tableDiv);
					jQuery(thisDeal+' .grouponTableLeft').html('Discount:<br>You Save:');
					jQuery(thisDeal+' .grouponTableRight').html(groupon_niceNum(data.deals[i].discount_percent) + '%<br>$' + groupon_niceNum(data.deals[i].discount_amount));
					var boughtDiv = '<div class="grouponBought"><strong>' + data.deals[i].quantity_sold + '</strong> Bought</div>';
					jQuery(thisDeal).append(boughtDiv);
					var getDiv = '<div class="grouponGet">Get It!</div>';
					jQuery(thisDeal).append(getDiv);
					var countdown = '<div class="grouponCountdown"><div class="grouponCountContainer"><span class="countdownText">Time left<br>to buy</span><span class="countdownTime"><span id="grouponHours'+i+'">0</span><br>H</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponMinutes'+i+'">0</span><br>M</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponSeconds'+i+'">0</span><br>S</span></div></div>';
					jQuery(thisDeal).append(countdown);
					if(typeof(gInterval)!='undefined'){
  			    clearInterval(gInterval[i]); 
  			  }
					startCountdown(d2, i);
					var poweredByDiv = '<div class="grouponPoweredBy"><img src="http://www.groupon.com/images/groupon/widget/poweredby_large_lofi.gif"></div>';
					jQuery(thisDeal).append(poweredByDiv);
					// change color of text... 
					if (typeof(color1) != 'undefined') {
						jQuery(thisDeal).css('border-color', color1);
						jQuery('.grouponCity').css('color', color1);
						jQuery('.grouponGet').css('color', color1);
					}
				}
				jQuery('#grouponShowSide').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '-=336'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
							window.location.href= cjprepend+data.deals[1].deal_url;
						});
					});
					return false;
				});
				jQuery('#grouponShowDaily').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '+=336'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
							window.location.href= cjprepend+data.deal_url;
						});
					});
					return false;
				});
				setTimeout(function() {
					jQuery('.grouponTitle').autoEllipsis();
				}, 200);
				break;
				
			case '468.60':
			var grouponAd = '<div id="grouponAdContents" style="background:#fff;font-size:90%;padding:3px;width:'+sizeSplit[0]+'px;height:'+sizeSplit[1]+'px;border:solid 1px '+color1+'"></div>';
			jQuery('#grouponAdContainer').append(grouponAd);
			
			var html = '<div style="float:left;width:125px;"><div><font color="#666">Giảm giá : </font><span style="color:#c40000;font:bold 1.4em arial">' + data.discount_percent + '%</span><br><font color="#666">Tiết kiệm : </font><span style="color:#c40000;font-size:1.1em;">' + groupon_niceNum(data.discount_amount) + ' Đ</span></div>';
						
			html += '<h3 id="grouponBuy" style="margin-top:5px;text-decoration:underline;color:'+color1+'">MUA NGAY!</h3></div>';			
			
			html += '<div style="float:left;width:100px;height:60px;overflow:hidden;"><img width="100" src="http://' + domain+'/static/'+data.large_image_url + '"></div>';
							
			html += '<div style="margin-left:5px;float:left;width:230px;"><div style="font:1.1em arial; color:'+color1+'"><strong>Deal hôm nay - ' + data.division_name + '</strong></div>'
			html += '<div id="titleDiv" style="height:40px;color:'+dcolor+'">' + data.title.replace("&","and") + '</div>';
			
			html += '<div style="margin-top:-8px;color:#666">' + data.quantity_sold + ' đã mua</div>';		
			
			html += '<div id="grouponPoweredBy" style="float:right;margin-top:-16px;margin-right:-5px;"><img src="http://'+domain+'/static/img/powers.png"></div></div>';
			jQuery('#grouponAdContents').append(html);
			
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border', 'solid 1px ' + color1);					
				}
					setTimeout(function() {
					jQuery('#titleDiv').autoEllipsis();
				}, 200);
				break;	
				
				case '470.105':
			var grouponAd = '<div id="grouponAdContents" style="overflow:hidden;background:#fff;font-size:1em;padding:4px;width:458px;height:95px;border:solid 1px '+color1+'"></div>';
			jQuery('#grouponAdContainer').append(grouponAd);
			
			var html = '<div style="float:left;width:110px;"><div><font color="#666">Giảm giá: </font><span style="color:#c40000;font:bold 1.4em arial">' + data.discount_percent + '%</span><br><br><font color="#666">Tiết kiệm:</font><br><span style="color:#c40000;font-size:1.1em;">' + groupon_niceNum(data.discount_amount) + ' Đ</span></div>';
						
			html += '<h2 id="grouponBuy" style="margin-top:10px;text-decoration:underline;color:'+color1+'">MUA NGAY!</h2></div>';			
			
			html += '<div style="float:left;width:100px;height:95px;overflow:hidden;"><img width="150" src="http://' + domain+'/static/'+data.large_image_url + '"></div>';
							
			html += '<div style="margin-left:10px;float:left;width:220px;"><div style="font:1.1em arial; color:'+color1+'"><strong>Deal hôm nay - ' + data.division_name + '</strong></div>'
			html += '<div id="titleDiv" style="overflow:hidden;width:240px;margin-top:8px;height:35px;color:'+dcolor+'">' + data.title.replace("&","and") + '</div>';
			
			html += '<div style="margin-top:18px;color:#666">' + data.quantity_sold + ' đã mua</div>';		
			
			html += '<div id="grouponPoweredBy" style="float:right;margin-top:-28px;margin-right:-20px;"><img src="http://'+domain+'/static/img/power.png"></div></div>';
			jQuery('#grouponAdContents').append(html);
			
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border', 'solid 1px ' + color1);					
				}
					/*setTimeout(function() {
					jQuery('#titleDiv').autoEllipsis();
				}, 200);*/
				break;	
				
				
			case '468.60.lofi':
				var grouponAd = '<div id="grouponAdContents"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity">Daily Deal: ' + data.division_name + '</div>';
				jQuery('#grouponAdContents').append(cityDiv);
				var titleDiv = '<div id="grouponTitle">' + data.title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				var imgDiv = '<div id="grouponImage"><img width="93" height="55" src="' + data.medium_image_url + '" /></div>';
				var tableDiv = '<div id="grouponTable"><div id="grouponTableLeft"></div><div id="grouponTableRight"></div>';
				jQuery('#grouponAdContents').append(tableDiv);
				jQuery('#grouponTableLeft').html('Discount:<br>You Save:');
				jQuery('#grouponTableRight').html(groupon_niceNum(data.discount_percent) + '%<br>$' + groupon_niceNum(data.discount_amount));
				jQuery('#grouponAdContents').append(imgDiv);
				var getDiv = '<div id="grouponGet">Get It!</div>';
				jQuery('#grouponAdContents').append(getDiv);
				var poweredByDiv = '<div id="grouponPoweredBy"><img src="http://www.groupon.com/images/groupon/widget/poweredby_small_h_lofi.png"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				// change color of text... 
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponCity').css('color', color1);
					jQuery('#grouponGet').css('color', color1);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);
				break;
				
			case '728.90':
			var grouponAd = '<div id="grouponAdContents" style="z-index:100;background:#fff;font-size:100%;padding:3px;width:718px;height:90px;border:solid 1px '+color1+'"></div>';
			jQuery('#grouponAdContainer').append(grouponAd);
			
			var html = '<div style="width:150px;float:left;font-size:0.9em"><div><font color="#666">Giảm đến : </font><span style="font-weight:bold;color:#c40000;font-size:1.5em;">' + data.discount_percent + '%</span><br><br><font color="#666">Tiết kiệm : </font><span style="font-weight:bold;color:#c40000;font-size:1em;">' + groupon_niceNum(data.discount_amount) + ' Đ</span></div>';
						
			html += '<br><h3 id="grouponBuy" style="text-decoration:underline;color:'+color1+'">MUA NGAY!</h3></div>';			
			
			html += '<div style="overflow:hidden;width:145px;float:left;margin-left:5px;margin-right:5px;"><img height="90" src="http://' + domain+'/static/'+data.large_image_url + '"></div>';
							
			html += '<div style="float:left;width:400px"><div style="color:'+color1+'"><h3>Deal hôm nay - ' + data.division_name + '</h3></div>'
			html += '<div id="titleDiv" style="margin-top:10px;height:40px;"><p style="color:'+dcolor+'">' + data.title.replace("&","and") + '</p></div>';		
			
			html += '<div id="grouponFooter" style="margin-top:0px;"><font color="' + dcolor + '">' + data.quantity_sold + '</font> đã mua';				
			
			html += '&nbsp;&nbsp;&nbsp;<span style="color:#666">Thời gian còn lại : </span><span id="grouponHours">0</span> giờ <span id="grouponMinutes">0</span> phút <span id="grouponSeconds">0</span> giây</div>';
			
			
			html += '<div id="grouponPoweredBy" style="float:right;margin-top:-28px;margin-right:-20px"><img src="http://'+domain+'/static/img/power.png"></div></div>';
			jQuery('#grouponAdContents').append(html);
			
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border', 'solid 1px ' + color1);					
				}
				/*setTimeout(function() {
					jQuery('#titleDiv').autoEllipsis();
				}, 200);*/
				setInterval(function() {
					d1 = new Date();
					niceDateDiff = DateDiff(d1, d2);
					jQuery('#grouponHours').text(niceDateDiff['hours']);
					jQuery('#grouponMinutes').text(niceDateDiff['minutes']);
					jQuery('#grouponSeconds').text(niceDateDiff['seconds']);
				}, 1000);
				break;	
				
			case '940.120':
			var grouponAd = '<div id="grouponAdContents" style="z-index:100;background:#fff;font-size:1.2em;padding:5px;width:933px;height:113px;border:solid 1px '+color1+'"></div>';
			jQuery('#grouponAdContainer').append(grouponAd);
			
			var html = '<div style="width:150px;float:left;font-size:0.9em"><div style="margin-top:10px"><font color="#666">Giảm đến : </font><span style="font-weight:bold;color:#c40000;font-size:1.5em;">' + data.discount_percent + '%</span></div><div style="margin-top:20px;"><font color="#666">Tiết kiệm : </font><span style="font-weight:bold;color:#c40000;font-size:1em;">' + groupon_niceNum(data.discount_amount) + ' Đ</span></div>';
						
			html += '<br><h3 id="grouponBuy" style="margin-top:10px;text-decoration:underline;color:'+color1+'">MUA NGAY!</h3></div>';			
			
			html += '<div style="overflow:hidden;margin-right:5px;width:190px;float:left;margin-top:-4px;"><img height="121" src="http://' + domain+'/static/'+data.large_image_url + '"></div>';
							
			html += '<div style="float:left;width:550px;"><div style="margin-top:10px;color:'+color1+'"><h3>Deal hôm nay - ' + data.division_name + '</h3></div>'
			html += '<div id="titleDiv" style="margin-top:10px;height:80px;"><p style="color:'+dcolor+'">' + data.title.replace("&","and") + '</p></div>';		
			
			html += '<div id="grouponFooter" style="margin-top:-25px;"><font color="' + dcolor + '">' + data.quantity_sold + '</font> đã mua';				
			
			html += '&nbsp;&nbsp;&nbsp;<span style="color:#666">Thời gian còn lại : </span><span id="grouponHours">0</span> giờ <span id="grouponMinutes">0</span> phút <span id="grouponSeconds">0</span> giây</div>';
			
			
			html += '<div id="grouponPoweredBy" style="float:right;margin-top:-28px;margin-right:-40px"><img src="http://'+domain+'/static/img/power.png"></div></div>';
			jQuery('#grouponAdContents').append(html);
			
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border', 'solid 1px ' + color1);					
				}
				setTimeout(function() {
					jQuery('#titleDiv').autoEllipsis();
				}, 200);
				setInterval(function() {
					d1 = new Date();
					niceDateDiff = DateDiff(d1, d2);
					jQuery('#grouponHours').text(niceDateDiff['hours']);
					jQuery('#grouponMinutes').text(niceDateDiff['minutes']);
					jQuery('#grouponSeconds').text(niceDateDiff['seconds']);
				}, 1000);
				break;
				
			case '728.90.lofimulti':
				for (i=0; i<lE; i++) {
					thisDeal = '#grouponAdContents' + i;
					var grouponAd = '<div id="grouponAdContents'+i+'" class="grouponAdContents"></div>';
					jQuery('#grouponAdContainer').append(grouponAd);
					var cityDiv = '<div class="grouponCity">Daily Deal: ' + data.deals[i].division_name + '</div>';
					jQuery(thisDeal).append(cityDiv);
					var titleDiv = '<div class="grouponTitle">' + data.deals[i].title.replace("&","and") + '</div>';
					jQuery(thisDeal).append(titleDiv);
					var imgDiv = '<div class="grouponImage"><img width="137" height="80" src="' + data.deals[i].large_image_url + '" /></div>';
					jQuery(thisDeal).append(imgDiv);
					if(lE==2){
					  if (i == 0) {
						  thisButtonID = 'grouponShowSide'
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="126" height="26" src="http://www.groupon.com/images/groupon/widget/showsidedeal_h_medium.png" /></div>';
					  } else {
						  thisButtonID = 'grouponShowDaily';
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="126" height="26" src="http://www.groupon.com/images/groupon/widget/showdailydeal_h_medium.png" /></div>';
					  }
					  jQuery(thisDeal).append(otherDealDiv);
				  }
					var tableDiv = '<div class="grouponTable"><div class="grouponTableLeft"></div><div class="grouponTableRight"></div>';
					jQuery(thisDeal).append(tableDiv);
					jQuery(thisDeal+' .grouponTableLeft').html('Discount:<br>You Save:');
					jQuery(thisDeal+' .grouponTableRight').html(groupon_niceNum(data.deals[i].discount_percent) + '%<br>$' + groupon_niceNum(data.deals[i].discount_amount));
					var boughtDiv = '<div class="grouponBought"><strong>' + data.deals[i].quantity_sold + '</strong> Bought</div>';
					jQuery(thisDeal).append(boughtDiv);
					var getDiv = '<div class="grouponGet">Get It!</div>';
					jQuery(thisDeal).append(getDiv);
					var countdown = '<div class="grouponCountdown"><span class="countdownText">Time left to buy </span> <span class="countdownTime"><span id="grouponHours'+i+'">0</span>:H</span> <span class="countdownTime"><span id="grouponMinutes'+i+'">0</span>:M</span> <span class="countdownTime"><span id="grouponSeconds'+i+'">0</span>:S</span></div>';
					jQuery(thisDeal).append(countdown);
					if(typeof(gInterval)!='undefined'){
  			    clearInterval(gInterval[i]); 
  			  }
					startCountdown(d2, i);
					var poweredByDiv = '<div class="grouponPoweredBy"><img src="http://www.groupon.com/images/groupon/widget/poweredby_large_lofi.gif"></div>';
					jQuery(thisDeal).append(poweredByDiv);
					// change color of text... 
					if (typeof(color1) != 'undefined') {
						jQuery(thisDeal).css('border-color', color1);
						jQuery('.grouponCity').css('color', color1);
						jQuery('.grouponGet').css('color', color1);
					}
				}
				jQuery('#grouponShowSide').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '-=728'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
							window.location.href= cjprepend+data.deals[1].deal_url;
						});
					});
					return false;
				});
				jQuery('#grouponShowDaily').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '+=728'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
							window.location.href= cjprepend+data.deal_url;
						});
					});
					return false;
				});
				setTimeout(function() {
					jQuery('.grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '728.90.lofi':
				var grouponAd = '<div id="grouponAdContents"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity">Today\'s Deal: ' + data.division_name + '</div>';
				jQuery('#grouponAdContents').append(cityDiv);
				var titleDiv = '<div id="grouponTitle">' + data.title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				var imgDiv = '<div id="grouponImage"><img width="137" height="80" src="' + data.medium_image_url + '" /></div>';
				var tableDiv = '<div id="grouponTable"><div id="grouponTableLeft"></div><div id="grouponTableRight"></div>';
				jQuery('#grouponAdContents').append(tableDiv);
				jQuery('#grouponTableLeft').html('Discount:<br>You Save:');
				jQuery('#grouponTableRight').html(groupon_niceNum(data.discount_percent) + '%<br>$' + groupon_niceNum(data.discount_amount));
				jQuery('#grouponAdContents').append(imgDiv);
				var boughtDiv = '<div id="grouponBought"><strong>' + data.quantity_sold + '</strong> Bought</div>';
				jQuery('#grouponAdContents').append(boughtDiv);
				var getDiv = '<div id="grouponGet">Get It!</div>';
				jQuery('#grouponAdContents').append(getDiv);
				var countdown = '<div id="grouponCountdown"><span class="countdownText">Time left to buy </span> <span class="countdownTime"><span id="grouponHours">0</span>:H</span> <span class="countdownTime"><span id="grouponMinutes">0</span>:M</span> <span class="countdownTime"><span id="grouponSeconds">0</span>:S</span></div>';
				jQuery('#grouponAdContents').append(countdown);
				setInterval(function() {
					d1 = new Date();
					niceDateDiff = DateDiff(d1, d2);
					jQuery('#grouponHours').text(niceDateDiff['hours']);
					jQuery('#grouponMinutes').text(niceDateDiff['minutes']);
					jQuery('#grouponSeconds').text(niceDateDiff['seconds']);
				}, 1000);
				var poweredByDiv = '<div id="grouponPoweredBy"><img src="http://www.groupon.com/images/groupon/widget/poweredby_large_lofi.png"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				// change color of text... 
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponCity').css('color', color1);
					jQuery('#grouponGet').css('color', color1);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);
				break;
				
			case '120.600':
				var grouponAd = '<div id="grouponAdContents" style="background:#fff;font-size:1.1em;padding:5px;width:120px;height:600px;border:solid 1px '+color1+'"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity" style="font:bold 1.2em arial;color:'+color1+'"><strong>Deal hôm nay<br>' + data.division_name + '</strong></div>'
				jQuery('#grouponAdContents').append(cityDiv);
				var descriptionDiv = '<div id="grouponDescription" style="height:100px;margin-top:20px;"><p style="color:#666">' + data.title.replace("&","and") + '</p></div>';
				jQuery('#grouponAdContents').append(descriptionDiv);
				
				var midContent = '<div style="margin-top:-10px;width:120px;height:120px"><img width="120" src="http://' + domain+'/static/'+data.large_image_url + '"></div>';
				jQuery('#grouponAdContents').append(midContent);
				
				var valueChart = '<div id="grouponValueChart" style="margin-top:-30px;"><font color="#666">Giảm giá : </font><span style="color:#c40000;font:bold 1.5em arial;">' + data.discount_percent + '%</span><br><br><font color="#666">Tiết kiệm : </font><br><span style="color:#c40000;font:bold 1em arial;">' + groupon_niceNum(data.discount_amount) + ' Đ</span></div>';
				
				var footer = '<br><div id="grouponFooter"><p><font color="' + dcolor + '">' + data.quantity_sold + '</font> đã mua</p></div>';
				
				var buyTag = '<h3 id="grouponBuy" style="margin-top:20px;text-decoration:underline;color:'+color1+'">MUA NGAY!<h3>';				
				
				var countdown = '<br><div style="color:#666;font-size:0.9em;">Thời gian còn lại:</div><span id="grouponHours">0</span> H <span id="grouponMinutes">0</span> m <span id="grouponSeconds">0</span> s</div>';
				
				
				var midLeftContent =  valueChart + footer + buyTag + countdown;//buyButton +
				jQuery('#grouponAdContents').append(midLeftContent);
				
				// $('#grouponImage').css('background-image','url(' + data.large_image_url + ')');		
				
				
				var poweredByDiv = '<br><br><div id="grouponPoweredBy" style="float:right;margin-top:25px;"><img src="http://'+domain+'/static/img/power.png"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				
				setInterval(function() {
					d1 = new Date();
					niceDateDiff = DateDiff(d1, d2);
					jQuery('#grouponHours').text(niceDateDiff['hours']);
					jQuery('#grouponMinutes').text(niceDateDiff['minutes']);
					jQuery('#grouponSeconds').text(niceDateDiff['seconds']);
				}, 1000);
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border', 'solid 1px ' + color1);					
				}
				/*setTimeout(function() {
					jQuery('#grouponDescription').autoEllipsis();
				}, 200);*/
				break;	
				
				
			case '160.600':
				var grouponAd = '<div id="grouponAdContents" style="background:#fff;font-size:1.1em;padding:5px;width:160px;height:600px;border:solid 1px '+color1+'"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity" style="font:bold 1.2em arial;color:'+color1+'"><strong>Deal hôm nay<br>' + data.division_name + '</strong></div>'
				jQuery('#grouponAdContents').append(cityDiv);
				var descriptionDiv = '<div id="grouponDescription" style="margin-top:20px;"><p style="color:#666">' + data.title.replace("&","and") + '</p></div>';
				jQuery('#grouponAdContents').append(descriptionDiv);
				
				var midContent = '<div style="margin-top:20px;width:160px;height:160px"><br><img width="160" src="http://' + domain+'/static/'+data.large_image_url + '"></div>';
				jQuery('#grouponAdContents').append(midContent);
				
				var valueChart = '<div id="grouponValueChart" style="margin-top:-10px;"><font color="#666">Giảm giá : </font><span style="color:#c40000;font:bold 1.5em arial;">' + data.discount_percent + '%</span><br><br><font color="#666">Tiết kiệm : </font><br><span style="color:#c40000;font:bold 1.1em arial;">' + groupon_niceNum(data.discount_amount) + ' Đ</span></div>';
				
				var footer = '<br><div id="grouponFooter"><p><font color="' + dcolor + '">' + data.quantity_sold + '</font> đã mua</p></div>';
				
				var buyTag = '<br><br><h3 id="grouponBuy" style="text-decoration:underline;font:bold 1.5em Arial;color:'+color1+'">MUA NGAY!<h3>';				
				
				var countdown = '<br><div style="color:#666">Thời gian còn lại:</div><span id="grouponHours">0</span> giờ <span id="grouponMinutes">0</span> phút <span id="grouponSeconds">0</span> giây</div>';
				
				
				var midLeftContent =  valueChart + footer + buyTag + countdown;//buyButton +
				jQuery('#grouponAdContents').append(midLeftContent);
				
				// $('#grouponImage').css('background-image','url(' + data.large_image_url + ')');		
				
				
				var poweredByDiv = '<div id="grouponPoweredBy" style="margin-top:20px;float:right"><img src="http://'+domain+'/static/img/power.png"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				
				setInterval(function() {
					d1 = new Date();
					niceDateDiff = DateDiff(d1, d2);
					jQuery('#grouponHours').text(niceDateDiff['hours']);
					jQuery('#grouponMinutes').text(niceDateDiff['minutes']);
					jQuery('#grouponSeconds').text(niceDateDiff['seconds']);
				}, 1000);
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border', 'solid 1px ' + color1);					
				}
				/*setTimeout(function() {
					jQuery('#grouponDescription').autoEllipsis();
				}, 200);*/
				break;	
				
				
			case '180.600':
				var grouponAd = '<div id="grouponAdContents" style="background:#fff;font-size:1.1em;padding:5px;width:168px;height:588px;border:solid 1px '+color1+'"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity" style="font:bold 1.2em arial;color:'+color1+'"><strong>Deal hôm nay<br>' + data.division_name + '</strong></div>'
				jQuery('#grouponAdContents').append(cityDiv);
				var descriptionDiv = '<div id="grouponDescription" style="margin-top:20px;height:120px;color:#666;">' + data.title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(descriptionDiv);
				
				var midContent = '<div style="margin-top:-15px;margin-left:-2px;width:172px;height:160px"><br><img width="172" src="http://' + domain+'/static/'+data.large_image_url + '"></div>';
				jQuery('#grouponAdContents').append(midContent);
				
				var valueChart = '<div id="grouponValueChart" style="margin-top:-10px;"><font color="#666">Giảm giá : </font><span style="color:#c40000;font:bold 1.5em arial;">' + data.discount_percent + '%</span><br><br><font color="#666">Tiết kiệm : </font><br><span style="color:#c40000;font:bold 1.1em arial;">' + groupon_niceNum(data.discount_amount) + ' Đ</span></div>';
				
				var footer = '<br><div id="grouponFooter"><p><font color="' + dcolor + '">' + data.quantity_sold + '</font> đã mua</p></div>';
				
				var buyTag = '<br><br><h3 id="grouponBuy" style="text-decoration:underline;font:bold 1.5em Arial;color:'+color1+'">MUA NGAY!<h3>';				
				
				var countdown = '<br><div style="color:#666">Thời gian còn lại:</div><span id="grouponHours">0</span> giờ <span id="grouponMinutes">0</span> phút <span id="grouponSeconds">0</span> giây</div>';
				
				
				var midLeftContent =  valueChart + footer + buyTag + countdown;//buyButton +
				jQuery('#grouponAdContents').append(midLeftContent);
				
				// $('#grouponImage').css('background-image','url(' + data.large_image_url + ')');		
				
				
				var poweredByDiv = '<div id="grouponPoweredBy" style="margin-top:20px;float:right"><img src="http://'+domain+'/static/img/power.png"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				
				setInterval(function() {
					d1 = new Date();
					niceDateDiff = DateDiff(d1, d2);
					jQuery('#grouponHours').text(niceDateDiff['hours']);
					jQuery('#grouponMinutes').text(niceDateDiff['minutes']);
					jQuery('#grouponSeconds').text(niceDateDiff['seconds']);
				}, 1000);
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border', 'solid 1px ' + color1);					
				}
				/*setTimeout(function() {
					jQuery('#grouponDescription').autoEllipsis();
				}, 200);*/
				break;	
				
				
			case '120.600.lofimulti':
				for (i=0; i<lE; i++) {
					thisDeal = '#grouponAdContents' + i;
					var grouponAd = '<div id="grouponAdContents'+i+'" class="grouponAdContents"></div>';
					jQuery('#grouponAdContainer').append(grouponAd);
					var cityDiv = '<div class="grouponCity">Today\'s Deal: ' + data.deals[i].division_name + '</div>';
					jQuery(thisDeal).append(cityDiv);
					var titleDiv = '<div class="grouponTitle">' + data.deals[i].title.replace("&","and") + '</div>';
					jQuery(thisDeal).append(titleDiv);
					var imgDiv = '<div class="grouponImage"><img width="112" height="64" src="' + data.deals[i].large_image_url + '" /></div>';
					jQuery(thisDeal).append(imgDiv);
					if(lE==2){
					  if (i == 0) {
						  thisButtonID = 'grouponShowSide'
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="112" height="27" src="http://www.groupon.com/images/groupon/widget/showsidedeal_h_small.png" /></div>';
					  } else {
						  thisButtonID = 'grouponShowDaily';
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="112" height="27" src="http://www.groupon.com/images/groupon/widget/showdailydeal_h_small.png" /></div>';
					  }
					  jQuery(thisDeal).append(otherDealDiv);
				  }
					var tableDiv = '<div class="grouponTable"><div class="grouponTableLeft"></div><div class="grouponTableRight"></div>';
					jQuery(thisDeal).append(tableDiv);
					jQuery(thisDeal+' .grouponTableLeft').html('Discount:<br>You Save:');
					jQuery(thisDeal+' .grouponTableRight').html(groupon_niceNum(data.deals[i].discount_percent) + '%<br>$' + groupon_niceNum(data.deals[i].discount_amount));
					var boughtDiv = '<div class="grouponBought"><strong>' + data.deals[i].quantity_sold + '</strong> Bought</div>';
					jQuery(thisDeal).append(boughtDiv);
					var getDiv = '<div class="grouponGet">Get It!</div>';
					jQuery(thisDeal).append(getDiv);
					var countdown = '<div class="grouponCountdown"><div class="grouponCountContainer"><span class="countdownText">Time left to buy</span><div class="timeShim"></div><span class="countdownTime"><span id="grouponHours'+i+'">0</span><br>H</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponMinutes'+i+'">0</span><br>M</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponSeconds'+i+'">0</span><br>S</span></div></div>';
					jQuery(thisDeal).append(countdown);
					if(typeof(gInterval)!='undefined'){
  			    clearInterval(gInterval[i]); 
  			  }
					startCountdown(d2, i);
					var poweredByDiv = '<div class="grouponPoweredBy"><img src="http://www.groupon.com/images/groupon/widget/poweredby_large_c_lofi.gif"></div>';
					jQuery(thisDeal).append(poweredByDiv);
					// change color of text... 
					if (typeof(color1) != 'undefined') {
						jQuery(thisDeal).css('border-color', color1);
						jQuery('.grouponCity').css('color', color1);
						jQuery('.grouponGet').css('color', color1);
					}
				}
				jQuery('#grouponShowSide').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '-=120'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
							window.location.href= cjprepend+data.deals[1].deal_url;
						});
					});
					return false;
				});
				jQuery('#grouponShowDaily').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '+=120'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
							window.location.href= cjprepend+data.deal_url;
						});
					});
					return false;
				});
				setTimeout(function() {
					jQuery('.grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '160.600.lofimulti':
				for (i=0; i<lE; i++) {
					thisDeal = '#grouponAdContents' + i;
					var grouponAd = '<div id="grouponAdContents'+i+'" class="grouponAdContents"></div>';
					jQuery('#grouponAdContainer').append(grouponAd);
					var cityDiv = '<div class="grouponCity">Today\'s Deal: ' + data.deals[i].division_name + '</div>';
					jQuery(thisDeal).append(cityDiv);
					var titleDiv = '<div class="grouponTitle">' + data.deals[i].title.replace("&","and") + '</div>';
					jQuery(thisDeal).append(titleDiv);
					var imgDiv = '<div class="grouponImage"><img width="151" height="87" src="' + data.deals[i].large_image_url + '" /></div>';
					jQuery(thisDeal).append(imgDiv);
					if(lE==2){
					  if (i == 0) {
						  thisButtonID = 'grouponShowSide'
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="148" height="32" src="http://www.groupon.com/images/groupon/widget/showsidedeal_h_large.png" /></div>';
					  } else {
						  thisButtonID = 'grouponShowDaily';
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="148" height="32" src="http://www.groupon.com/images/groupon/widget/showdailydeal_h_large.png" /></div>';
					  }
					  jQuery(thisDeal).append(otherDealDiv);
					}
					var tableDiv = '<div class="grouponTable"><div class="grouponTableLeft"></div><div class="grouponTableRight"></div>';
					jQuery(thisDeal).append(tableDiv);
					jQuery(thisDeal+' .grouponTableLeft').html('Discount:<br>You Save:');
					jQuery(thisDeal+' .grouponTableRight').html(groupon_niceNum(data.deals[i].discount_percent) + '%<br>$' + groupon_niceNum(data.deals[i].discount_amount));
					var boughtDiv = '<div class="grouponBought"><strong>' + data.deals[i].quantity_sold + '</strong> Bought</div>';
					jQuery(thisDeal).append(boughtDiv);
					var getDiv = '<div class="grouponGet">Get It!</div>';
					jQuery(thisDeal).append(getDiv);
					var countdown = '<div class="grouponCountdown"><div class="grouponCountContainer"><span class="countdownText">Time left to buy</span><div class="timeShim"></div><span class="countdownTime"><span id="grouponHours'+i+'">0</span><br>H</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponMinutes'+i+'">0</span><br>M</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponSeconds'+i+'">0</span><br>S</span></div></div>';
					jQuery(thisDeal).append(countdown);
					if(typeof(gInterval)!='undefined'){
  			    clearInterval(gInterval[i]); 
  			  }
					startCountdown(d2, i);
					var poweredByDiv = '<div class="grouponPoweredBy"><img src="http://www.groupon.com/images/groupon/widget/poweredby_large_c_lofi.gif"></div>';
					jQuery(thisDeal).append(poweredByDiv);
					// change color of text... 
					if (typeof(color1) != 'undefined') {
						jQuery(thisDeal).css('border-color', color1);
						jQuery('.grouponCity').css('color', color1);
						jQuery('.grouponGet').css('color', color1);
					}
				}
				jQuery('#grouponShowSide').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '-=160'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
							window.location.href= cjprepend+data.deals[1].deal_url;
						});
					});
					return false;
				});
				jQuery('#grouponShowDaily').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '+=160'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
							window.location.href= cjprepend+data.deal_url;
						});
					});
					return false;
				});
				setTimeout(function() {
					jQuery('.grouponTitle').autoEllipsis();
				}, 200);
				break;
		}
		jQuery('#grouponAdContents').css('cursor','pointer').click(function() {																				
			window.open(cjprepend+data.deal_url);
		});
	});
}


function groupon_init() {
	// ellipsis plugin
	// <reference path="jquery-1.3.2-vsdoc.js"/>
	/*
		by Homam Hosseini
		http://abstractform.wordpress.com
		bluesnowball@gmail.com

	*/
	jQuery.fn.autoEllipsis = function(options) {
		var get_AutoEllipsisScroller = function(id) {
			var aeScrollerId = "WingooliAutoEllipsisScroller_" + id
			if (!document.getElementById(aeScrollerId)) {
				var div = document.createElement("div");
				div.id = aeScrollerId + "_Container";
				div.innerHTML = '<span id="' + aeScrollerId + '" style="overflow: visible; position: absolute; top: -2000px; color: orange"></span>';
				document.body.appendChild(div);
			}
			return document.getElementById(aeScrollerId);
		};

		var StringEllipsesByMaxLetters = function(element, originalText, maxLettersAllowed) {
			element.title = "";
			var text = originalText;
			
			if (text == null || text == "") text = element.innerHTML;
			var maxAllowedLatterIndex = text.length - maxLettersAllowed;
			if (maxAllowedLatterIndex > 0) {				
				element.title = text;
				if (originalText == null)
					originalText = text;					
				element.innerHTML = text.substr(0, maxLettersAllowed - 2) + "&hellip;";//added 50
				//alert(text.substr(0, 15+element.offsetHeight + maxLettersAllowed - 2) + "&hellip;");
			} else {
				element.innerHTML = text;
			}
			
		};

		var _this = this;

		var settings = jQuery.extend({}, options);
		this.each(function(i) {
			var aeScroller = get_AutoEllipsisScroller(i);
			saeScroller = jQuery(aeScroller);
			sthis = jQuery(this);
			saeScroller.text(sthis.text());

			var origText = sthis.html();

			var element = this;
			var elementBounds = { width: element.offsetWidth, height: element.offsetHeight };
    
			var jAeScroller = jQuery(aeScroller);
			var jElement = jQuery(element);

			var props = ["margin", "font", "color", "font-size", "font-weight", "font-family", "font-style", "padding"];

			for (var i = 0; i < props.length; i++) {
				try {
					jAeScroller.css(props[i], jElement.css(props[i]));
				} catch (ex) { }
			}
			jElement.css("overflow", "visible");

			jAeScroller.width(jElement.innerWidth());

			var isIe = (document.all != undefined);
			var scrollerWidth = jAeScroller.innerWidth();
			var scrollerHeight = jAeScroller.innerHeight();
			var fitText = saeScroller.text();

			while (scrollerHeight > elementBounds.height && fitText != "") {
				fitText = fitText.substr(0, fitText.length - 2);
				var autoScrollerInnerHTML = fitText + "&hellip;";
				saeScroller.html(autoScrollerInnerHTML);
				scrollerHeight = jAeScroller.innerHeight();
			}
			if (fitText == "") {
				fitText = origText;
				saeScroller.html(fitText);
				jElement.css("whiteSpace", "nowrap");
				jAeScroller.width("");
				var scrollerWidth = jAeScroller.width();
			}
			while (scrollerWidth > elementBounds.width && fitText != "") {
				fitText = fitText.substr(0, fitText.length - 2);
				var autoScrollerInnerHTML = fitText + "&hellip;";
				saeScroller.html(autoScrollerInnerHTML);
				scrollerWidth = jAeScroller.innerWidth();
			}
			
			var scrollerHeight = aeScroller.offsetHeight;
			var r = (Math.ceil(elementBounds.height / scrollerHeight) - 1);
			r += (r == 0) ? 1 : 0;
			var maxLettersAllowed = fitText.length * r;
			//
			StringEllipsesByMaxLetters(element, origText, maxLettersAllowed + (r + 1));
		});
	}
	// initialize with options...
	if ((typeof(_gwparam) != 'undefined') && (typeof(_gwparam['size']) != 'undefined')) {
		displayGrouponAd(_gwparam['APIKEY'] ,_gwparam['size'], _gwparam['location'], _gwparam['bgcolor'], true, _gwparam['PID'], _gwparam['AID'], _gwparam['title'] );
	}
}