// Read a page's GET URL variables and return them as an associative array.
function getUrlVars() {
  var vars = [], hash;
  var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
  for(var i = 0; i < hashes.length; i++) {
	hash = hashes[i].split('=');
	vars.push(hash[0]);
	vars[hash[0]] = hash[1];
  }
  return vars;
}
jQuery(document).ready(function() {
	var domain = 'hotdeal.vn';								
  //jQuery('#widgetForm').validate();
  //add script after load
  jQuery("#loadScript").html('<script type="text/javascript" src="/static/js/widget_api.js"></scri' + 'pt>');
	var codeSnippet = '<link rel="stylesheet" media="screen" type="text/css" href="http://' + domain + '/static/css/reset.css" />\n<script type="text/javascript">\n';
	codeSnippet += 'var _gwparam = _gwparam || [];\n';
	codeSnippet += '_gwparam["APIKEY"] = "{APIKEY}";\n';
	codeSnippet += '_gwparam["size"] = "{SIZE}";\n';
	codeSnippet += '_gwparam["location"] = "{LOCATION}";\n';
	codeSnippet += '_gwparam["bgcolor"] = "{BGCOLOR}";\n';
	codeSnippet += '_gwparam["title"] = "{TITLE}";\n';
	codeSnippet += '_gwparam["PID"] = "{PID}";\n';
	codeSnippet += '_gwparam["AID"] = "{AID}";\n';
	codeSnippet += '</scri' + 'pt>\n';
	codeSnippet += '<script id="grouponAd" type="text/javascript" src="http://'+domain+'/static/js/widget_api.js"></scri' + 'pt>';
	//codeSnippet += '<script id="grouponAd" type="text/javascript" src="http://localhost:3000/javascripts/common/affiliate_widget/grouponwidget.js"></scri' + 'pt>';
	//jQuery('#grouponAdContainer').hide();
	
  if(typeof getUrlVars()['AID'] != 'undefined'){
    jQuery('#AID').val(getUrlVars()['AID']);
  }
  if(typeof getUrlVars()['PID'] != 'undefined')
    jQuery('#PID').val(getUrlVars()['PID']);

	/*
	// populate divisions select box...
	jQuery.getJSON('http://'+domain+'/affiliate/json.php?callback=?', function(data) {
		// sort the data by division name...
		data.divisions.sort(function(a,b) { 
			if (a.name == b.name) {
			   return 0;
			}
			return a.name> b.name ? 1 : -1;
		});
		
		jQuery.each(data.divisions, function(index, division) {
			jQuery('#location').append('<option value="'+division.location.latitude+','+division.location.longitude+'">'+division.name+'</option>');
		});
		jQuery('#loadingCities').hide();
		jQuery('#location').show();
	});
	
	*/
	jQuery('#createAd').click(function(e) {
		e.preventDefault();
		var adErrors=false;
		//jQuery('#widgetForm').validate();
		if(jQuery('#PID').val().length<1){
		  if(jQuery("#PIDerror").length<1){
		    jQuery('#PID').after('<span class="reqError" id="PIDerror">bắt buộc nhập</span>').focus()
	    }
		  adErrors=true;
		} else {
		  jQuery('#PIDerror').remove();
		}
		if(jQuery('#APIKEY').val().length<1){
		  if(jQuery('#APIerror').length<1){
		    jQuery('#APIKEY').after('<span class="reqError" id="APIerror">bắt buộc nhập</span>').focus();
	    }
		  adErrors=true;
		} else {jQuery('#APIerror').remove();}
		if(adErrors==true){return false;}
		var APIKEY = jQuery('#APIKEY').val();
		var selectedCity = jQuery('#location').val();
		var selectedSize = new String();
		var selectedSize = jQuery('#size').val();
		var selectedColor = jQuery('#color').val();
		var PID = jQuery('#PID').val();
		var AID = jQuery('#AID').val();
		var TITLE = jQuery('#TITLE').val();
		// selectedColor2 = $('#color2').val();
		newSnippet = codeSnippet.replace(/{APIKEY}/,APIKEY).replace(/{SIZE}/,selectedSize).replace(/{LOCATION}/,selectedCity).replace(/{BGCOLOR}/,selectedColor).replace(/{PID}/,PID).replace(/{AID}/,AID).replace(/{TITLE}/,TITLE);
		jQuery('#snippet').val(newSnippet);
		jQuery('#grouponAdContainer').remove();
		jQuery('#grouponCSS').remove();
		displayGrouponAd(APIKEY, selectedSize, selectedCity, selectedColor, true, PID, AID, TITLE);
		//jQuery('#grouponAdContainer').css('text-align','center');
		
	});
	jQuery('#size').change(function() {
		if (jQuery(this).val() == '250.250') {
			jQuery('.customTitle').show();
		} else {
			jQuery('#title').val('');
			jQuery('.customTitle').hide();
		}
	});
	jQuery('#colorDefault').click(function() {
		document.getElementById('color').color.fromString('#8bc53f');
	});
	jQuery('#snippet').click(function(e){
    this.select();
  })
  
})
