<?php $IEM = $tpl->Get('IEM'); ?><script type="text/javascript">
var ImgUrl = '<?php if(isset($GLOBALS['imgLocation'])) print $GLOBALS['imgLocation']; ?>';
</script>

<link rel="stylesheet" href="includes/js/imodal/imodal.css" type="text/css">
<script type="text/javascript" src="includes/js/jquery/scrollto.js"></script>
<script type="text/javascript" src="includes/js/imodal/imodal.js"></script>
<script type="text/javascript" src="includes/js/detect.flash.js"></script>
<script type="text/javascript" src="includes/js/swfupload.js"></script>
<script type="text/javascript" src="includes/js/swfupload.handlers.js"></script>

<script type="text/javascript">

var iem = {
	util : {

		isDefined: function(obj) {
			return (typeof(obj) != 'undefined');
		},

		defaultVal: function(x, val){
			if(!iem.util.isDefined(x)){
				return val;
			}
			return x;
		},

		inArray: function(needle, array){
			for(i=0;i<array.length;i++){
				if(array[i] == needle){
					return true;
				}
			}
			return false;
		},

		randomString: function(length) {
			var chars = "0123456789abcdefghiklmnopqrstuvwxyz";
			var string_length = iem.util.defaultVal(length, 8);
			var randomstring = '';
			for (var i=0; i<string_length; i++) {
				var rnum = Math.floor(Math.random() * chars.length);
				randomstring += chars.substring(rnum,rnum+1);
			}
			return randomstring;
		},

		htmlEscape: function(str){
			str = str.replace(/</g, '&lt;');
			str = str.replace(/>/g, '&gt;');
			return str;
		},

		BindOnCheckShow : function(checkbox, displayItem) {
			$(checkbox).bind('click', function(){
				if($(checkbox).attr('checked') == true){
					$(displayItem).show();
				}else{
					$(displayItem).hide();
				}
			});

			if($(checkbox).attr('checked') == true){
				$(displayItem).show();
			}else{
				$(displayItem).hide();
			}
		},

		BindOnCheckHide : function(checkbox, displayItem) {
			$(checkbox).bind('click', function(){
				if($(checkbox).attr('checked') == true){
					$(displayItem).hide();
				}else{
					$(displayItem).show();
				}
			});

			if($(checkbox).attr('checked') == true){
				$(displayItem).hide();
			}else{
				$(displayItem).show();
			}
		}
	} // IEM.Util
} // IEM



var swfu;
var MaxFileSize = '20MB';
var global_randNum = iem.util.randomString(10);
var requiredFlashMajorVersion = 8;
var requiredFlashMinorVersion = 0;
var requiredFlashRevision = 0;
var TotalItemsToUpload = 0;
var UploadErrorFiles = new Array();
var UploadDuplicateFiles = new Array();
var FileCount = 1;
var hasReqestedFlashVersion = DetectFlashVer(requiredFlashMajorVersion, requiredFlashMinorVersion, requiredFlashRevision);


$(document).ready(function() {
	$(function() {
		AdminImageManager.ImageManagerManage('<?php echo $tpl->Get('Params'); ?>', '', '');
	});


});


function RemoveExtension(name){
	var varFile = name.split('.');
	var userFriendlyName = '';
	for(i in varFile) {
		if(i == (varFile.length - 1)){
			break;
		}
		userFriendlyName += varFile[i];
	}
	return userFriendlyName;
}

var OriginalTextValue = '';
var AdminImageManager = {

	noflashTotalUploads: 0,
	percentIncrementNonFlash: 0,
	totalPercentNonFlash: 0,
	totalFieldsNonFlash: 0,
	currentFieldNonFlash: 0,

	GetImageRow: function() {
		return '<span style="margin-bottom:20px;" class="ManageImageBox" id="%%image_id%%">'
		+ '  <input type="checkbox" id="deleteimages[]" value="%%image_realname%%" class="%%image_id%%_Class" />'
		+ '  <input class="TemplateHeading inPlaceImageBoxDefault" id="%%image_id%%_name" value="%%image_name%%" />'
		+ '  <input type="hidden" id="%%image_id%%_realname" value="%%image_realname%%" />'
		+ '  <br />'
		+ '  <div style="width: 200px; height: 150px; margin-top: 5px;">'
		+ '    <a href=\'%%image_url%%\' id="%%image_id%%_url" target="_blank">'
		+ '      <img src=\'%%image_url%%\' style=" border: solid 1px #CACACA;" id="%%image_id%%_image" width="%%image_width%%" height="%%image_height%%" title="<?php echo GetLang('ClickForFullSize'); ?>" alt="thumbnail" />'
		+ '    </a>'
		+ '  </div>'
		+ '  <a href=\'%%image_url%%\' id="%%image_id%%_url" target="_blank">'
		+ '    <img width="10" hspace="3" height="11" border="0" src="images/magnify.gif" title="<?php echo GetLang('ImageManagerViewFullSize'); ?>" alt="magnify" /><?php echo GetLang('ImageManagerViewFullSize'); ?>'
		+ '  </a>'
		+ '  <br />'
		+ '  <?php echo GetLang('ImageSize'); ?>: %%image_size%%<br /><?php echo GetLang('ImageDimension'); ?>: %%image_dimensions%%px<br />'
		+ '  <input type="button" class="Field150" id="%%image_id%%_delete" value="<?php print GetLang('DelThisImage'); ?>" />'
		+ '</span>';
	},

	CheckDelete: function() {
		if (!$('#imagesList .ManageImageBox').exists()) {
			$('#hasImages').hide();
			$('#hasNoImages').show();
			$('#deleteButton').hide();
		} else {
			$('#hasImages').show();
			$('#hasNoImages').hide();
			$('#deleteButton').show();
		}
	},

	CheckAllCheckBoxes: function(checkBox){
		if($('#toggleAllChecks').attr('checked')){
			$('#imagesList input:checkbox').attr('checked', 'checked');
		}else{
			$('#imagesList input:checkbox').removeAttr('checked');
		}
	},

	AddImage: function(name, url, size, displaywidth, displayheight, dimensions, id){
		$('#hasImages').show();
		$('#hasNoImages').hide();
		$('#deleteButton').show();
		var html = AdminImageManager.GetImageRow();
		var varFile = name.split('.');
		var extension = varFile[ varFile.length -1 ];
		var userFriendlyName = '';
		for(i in varFile) {
			if(i == (varFile.length - 1)){
				break;
			}
			userFriendlyName += varFile[i];
		}

		html = html.replace(/%%image_name%%/g, userFriendlyName);
		html = html.replace(/%%image_realname%%/g, name);
		html = html.replace(/%%image_id%%/g, id);
		html = html.replace(/%%image_url%%/g, url);
		html = html.replace(/%%image_size%%/g, size);
		html = html.replace(/%%image_width%%/g, displaywidth);
		html = html.replace(/%%image_height%%/g, displayheight);
		html = html.replace(/%%image_dimensions%%/g, dimensions);

		$(html).appendTo('#imagesList');

		$('#'+id+'_delete').bind('click',
		function () {
			var idBits = this.id.split('_');
			var id = idBits[0];
			var animate = true;
			if(confirm('Are you sure you want to delete "' + $('#'+id+'_name').val() +  '"? Click OK to confirm.')) {
				var sendPOST = 'deleteimages[]='+escape($('#' + id + '_realname').val())+'&what=imagemanagerdelete';
				$.post('remote.php', sendPOST,
				function(json){
					var result = $.evalJSON(json);
					if(result.success){
						for(i in result.successimages) {
							var str = result.successimages[i];
							if (str.length > 1) {
								$('input:checkbox[value=' + result.successimages[i] + ']').removeAttr('checked');
								$('input:text[value=' + result.successimages[i] + ']').parent().hide('slow');
								$('input:text[value=' + result.successimages[i] + ']').parent().remove();
							}
						}
						AdminImageManager.ImageManagerManage('<?php echo $tpl->Get('Params'); ?>', 'success', result.message);
						AdminImageManager.CheckDelete();
					}else{
						$('#MainMessage').errorMessage(result.message);
					}
				});
			}
		}
		);

		$('#'+id+'_name').bind('mouseover',
		function () {

			if(!$(this).hasClass("inPlaceFieldFocus")) {
				$(this).addClass("inPlaceImageBoxFieldHover");
			}
		}
		);

		$('#'+id+'_name').bind('mouseout',
		function () {
			$(this).removeClass("inPlaceImageBoxFieldHover");
		}
		);

		$('#'+id+'_name').bind('keyup', function() {
			var val = $(this).val();
			val = val.replace(/[^a-zA-Z0-9\.\-_]/g, '');
			$(this).val(val);
		});

		$('#'+id+'_name').bind('keypress', function() {
			var val = $(this).val();
			val = val.replace(/[^a-zA-Z0-9\.\-_]/g, '');
			$(this).val(val);
		});

		$('#'+id+'_name').bind('focus',
		function () {
			$('.inPlaceFieldFocus').each(function(){
				cancelEditName($(this));
				$(this).removeClass('inPlaceFieldFocus');
			});
			$(this).removeClass("inPlaceImageBoxFieldHover");
			$(this).addClass("inPlaceFieldFocus");
			OriginalTextValue = this.value;
			this.select();
			$('<div style="background-color: #F9F9F9; width: 205px; position: relative; margin-top: 5px; padding-bottom: 3px; text-align: left;" id="EditNameButtons"><input type="button" class="Field" name="saveEdit" value="<?php print GetLang('Save'); ?>"  style="float: right;" onclick="saveEditName($(\'#' + this.id + '\'));" /><input type="button" class="Field" name="cancelEdit" value="<?php print GetLang('Cancel'); ?>" style="float: left;"  onclick="cancelEditName($(\'#' + this.id + '\'));" /> </div>').insertAfter(this);
		}
		);


		if ($.browser.mozilla) {
			var event = "keypress";
		} else {
			var event = "keydown";
		}

		$('#'+id+'_name').bind(event, function(e) {
			if (e.keyCode == 13) {
				$('#'+id+'_name').blur();
			}
		});
	},

	UploadNonFlashImages: function() {

		global_randNum = iem.util.randomString(10);
		TotalItemsToUpload = 0;
		UploadErrorFiles = new Array();
		UploadDuplicateFiles = new Array();
		FileCount = 0;

		$('#uploadFormNoFlash').hide();
		$('#noFlashProgressWindow').show();

		AdminImageManager.noflashTotalUploads = $('.noflashUploadField').size() -2 ; //remove the blank field from the count
		AdminImageManager.percentIncrementNonFlash = parseInt((100 / AdminImageManager.noflashTotalUploads));
		AdminImageManager.totalPercentNonFlash = 0;
		AdminImageManager.totalFieldsNonFlash = $('.noflashUploadField').size()-2;
		AdminImageManager.currentFieldNonFlash = 0;
		AdminImageManager.RunNextUploadNonFlash();

	},

	RunNextUploadNonFlash: function(){
		var tmpCounter = 0;
		$('.noflashUploadField').each(function() {

			if($(this).val() == '') {
				return true;
			}

			if(tmpCounter != AdminImageManager.currentFieldNonFlash){
				if(tmpCounter > AdminImageManager.totalFieldsNonFlash){
					return false;
				}
				tmpCounter++;
				return true;
			}


			var thisId = $(this).attr('id');

			$.ajaxFileUpload ({
				url:'index.php?Page=ImageManager&Action=remoteupload',
				secureuri:false,
				fileElementId: thisId,
				dataType: 'json',
				beforeSend: function (){
					var name = $('#' + this.fileElementId).val().replace(/\\/g, '/');
					name = name.split('/');
					var pos = name.length;
					var fileName = name[pos-1];
					$('.progressBarStatus').html('Uploading Image '+FileCount+' of ' + AdminImageManager.noflashTotalUploads);
					$('.ProgressBarText').html('Uploading ' + fileName + '...');
				},
				success: function (result)
				{
					AdminImageManager.totalPercentNonFlash = AdminImageManager.totalPercentNonFlash + AdminImageManager.percentIncrementNonFlash;
					$('.progressBarPercentage').css('width', AdminImageManager.totalPercentNonFlash + "%");
					$('.progressPercent').html(AdminImageManager.totalPercentNonFlash + "%");
					FileCount++;

					if(result.Filedata.duplicate){
						UploadDuplicateFiles.push(result.Filedata.name);

					}else if(result.Filedata.errorfile != ''){
						UploadErrorFiles.push(result.Filedata.name);

					}else if(result.Filedata.error == 0){
						// success!
						AdminImageManager.AddImage( result.Filedata.name, result.Filedata.imagepath + result.Filedata.name,  result.Filedata.filesize, result.Filedata.width, result.Filedata.height, result.Filedata.origwidth + ' x ' + result.Filedata.origheight,  result.Filedata.id);
					}

					AdminImageManager.currentFieldNonFlash++;

					if(AdminImageManager.currentFieldNonFlash > AdminImageManager.totalFieldsNonFlash){
						AdminImageManager.UploadNonFlashFinished();
					}else{
						AdminImageManager.RunNextUploadNonFlash();
					}
					$('#deleteButton').show();
					$('#pagination').show();

					var sendPOST = 'what=imagemanagerimagenumshown';
					$.post('remote.php', sendPOST,
					function(json){
						var result = $.evalJSON(json);
						if(result.text){
							$('#ImgNum').html(result.text);
						}
					});
				}
			});
			return false;
		});
	},

	UploadNonFlashFinished: function(){
		$.iModal.close();
		if(UploadErrorFiles.length > 0){
			var imageList = '';
			var thisImage = '';
			for(i in UploadErrorFiles){
				thisImage = UploadErrorFiles[i];
				if ( $(thisImage).text().search('{') < 0) {
					imageList += '<li>' + $('<p>' + thisImage + '</p>').text() + '</li>'; // strips out any html
				}

			}
			if(UploadErrorFiles.length == TotalItemsToUpload){
				$('#MainMessage').errorMessage('<?php print GetLang('ImageManagerNotValidImage'); ?>: <ul>' + imageList + '</ul>');
			}else{
				$('#MainMessage').warningMessage('<?php print GetLang('ImageManagerNotValidImageException'); ?>: <ul>' + imageList + '</ul>');
			}
		} else if(UploadDuplicateFiles.length > 0) {
			var imageList = '';
			var thisImage = '';
			for(i in UploadDuplicateFiles){
				thisImage = UploadDuplicateFiles[i];
				if ( $(thisImage).text().search('{') < 0) {
					imageList += '<li>' + $('<p>' + thisImage + '</p>').text() + '</li>'; // strips out any html
				}

			}
			$('#MainMessage').warningMessage('<?php print GetLang('ImageManagerUploadDuplicate'); ?> <ul>' + imageList + '</ul>');
		} else {
			if(FileCount == 1){
				$('#MainMessage').successMessage('<?php print GetLang('ImageManagerUploadSuccessSingle'); ?>');
			} else {
				$('#MainMessage').successMessage('<?php print GetLang('ImageManagerUploadSuccessMultiple'); ?>');
			}
			AdminImageManager.CheckDelete();
		}
	},

	ImageManagerManage: function(params, mesgType, mesg) {
		$.ajax({
			type: 'post',
			url: 'remote.php'+params,
			data: {'what': 'imagemanagermanage'},
			success: function(resp){
				$('#ImageManager').html(resp);
				if (hasReqestedFlashVersion) {
					swfu = new SWFUpload({
						// Backend Settings
						upload_url: "<?php if(isset($GLOBALS['adminUrl'])) print $GLOBALS['adminUrl']; ?>/index.php?Page=ImageManager&Action=remoteupload",
						// File Upload Settings
						file_size_limit : "20 MB",
						file_types : "*.jpg;*.gif;*.png;*.tiff,*.bmp,*.jpeg",
						file_types_description : " Images",
						file_upload_limit : "0",
						post_params: {"<?php echo $tpl->Get('SessionName'); ?>": "<?php echo $tpl->Get('SessionID'); ?>", "what": "imagemanagerupload"},

						// Event Handler Settings
						file_queue_error_handler : fileQueueError,
						file_dialog_complete_handler : fileDialogComplete,
						upload_progress_handler : uploadProgress,
						upload_error_handler : uploadError,
						upload_success_handler : uploadSuccess,
						upload_complete_handler : uploadComplete,

						// Button Settings
						button_placeholder_id : "spanButtonPlaceholder",
						button_width: 130,
						button_height: 22,
						button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
						button_cursor: SWFUpload.CURSOR.HAND,

						// Flash Settings
						flash_url : "<?php if(isset($GLOBALS['adminUrl'])) print $GLOBALS['adminUrl']; ?>/images/swfupload.swf",

						custom_settings : {
							upload_target : "divFileProgressContainer"
						},

						// Debug Settings
						debug: false
					});
				} else { // no flash installed!
					$('#btnUpload').bind('click', function () {
						// we has a function
						$.iModal({ width: 500, title: 'Uploading Images',
						type: 'ajax',
						url: 'index.php?Page=imagemanager&Action=noflashupload',
						buttons: '<input type="button" onclick="$.iModal.close();" style="float: left" value="<?php print GetLang('Cancel'); ?>"  class="Field" /><input type="button" value="<?php print GetLang('Upload'); ?>"  class="Field" id="uploadButton" style="font-weight: bold;"/>'});
					});
				}

				$('#deleteButton').bind('click', function(){
					if(!$('#hasImages input:checkbox:checked').exists()){
						alert('<?php print GetLang('ImageManagerNoImageSelected'); ?>');
						return;
					}
					if(confirm('<?php print GetLang('ImageManagerDeleteConfirmation'); ?>')) {
						var sendPOST = '';
						$('input:checkbox:checked').each(function (){
							if(this.value == '%%image_name%%') { return; }
							sendPOST += '&deleteimages[]=' + escape(this.value);
						});
						sendPOST += '&what=imagemanagerdelete';
						$.post('<?php if(isset($GLOBALS['adminUrl'])) print $GLOBALS['adminUrl']; ?>/remote.php', sendPOST,
						function(json){
							var result = $.evalJSON(json);
							if(result.success){
								for(i in result.successimages) {
									var str = result.successimages[i];
									if (str.length > 1) {
										$('input:checkbox[value=' + result.successimages[i] + ']').removeAttr('checked');
										$('input:text[value=' + result.successimages[i] + ']').parent().hide('slow');
										$('input:text[value=' + result.successimages[i] + ']').parent().remove();
									}
								}
								AdminImageManager.CheckDelete();
								AdminImageManager.ImageManagerManage('<?php echo $tpl->Get('Params'); ?>', 'success', result.message);
							}else{
								$('#MainMessage').errorMessage(result.message);
							}
						});
					}
				});


				if (mesgType == 'success') {
					$('#MainMessage').successMessage(mesg);
				} else if (mesgType == 'error') {
					$('#MainMessage').errorMessage(mesg);
				} else if (mesgType == 'warning') {
					$('#MainMessage').warningMessage(mesg);
				}



			}
		});
	}
};

function saveEditName(field){
	$(field).attr('disabled', true);

	var idBits = field.attr('id');
	idBits = idBits.split('_');
	var id = idBits[0];
	$('#EditNameButtons').remove();

	field.removeClass("inPlaceFieldFocus");
	if(field.val() != OriginalTextValue){
		$.post('remote.php', 'what=imagemanagerrename&fromName=' + escape($('#' + id + '_realname').val()) + '&toName=' + escape(field.val()),
		function(json){
			var result = $.evalJSON(json);
			if(result.success){
				var message = '<?php print GetLang('ImageManagerRenameSuccess'); ?>';
				message = message.replace('%from%', OriginalTextValue);
				message = message.replace('%to%', result.newname);

				$('#' + id + '_image').attr('src', result.newurl);
				$('#' + id + '_url').attr('href', result.newurl);
				$('#' + id + '_realname').val(result.newrealname);
				$('#' + id + '_name').val(result.newname);
				$('.' + id + '_Class').val(result.newrealname);
				$('#MainMessage').successMessage(message);
			}else{
				$('#MainMessage').errorMessage('<?php print GetLang('ImageManagerRenameError'); ?>' + result.message);
				$('#'+id+'_name').val(OriginalTextValue);
			}
		});
	}
	$(field).attr('disabled', false);
}


function cancelEditName(field){
	$(field).val(OriginalTextValue);
	$(field).removeClass("inPlaceFieldFocus");
	$('#EditNameButtons').remove();
}

function ChangeImageManagerSorting(object, pagenumber) {
	pagingId = object.selectedIndex;
	var sortby = object[pagingId].value;
	AdminImageManager.ImageManagerManage('?Page=ImageManager&DisplayPage=' + pagenumber + '&SortBy='+ sortby, '', '');
}

</script>
<div id="ImageManager">
</div>