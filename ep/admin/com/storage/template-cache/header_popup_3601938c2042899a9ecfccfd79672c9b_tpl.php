<?php $IEM = $tpl->Get('IEM'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title><?php print GetLang('ControlPanel'); ?></title>
		<link rel="shortcut icon" href="<?php print $IEM['ApplicationFavicon']; ?>" type="image/vnd.microsoft.icon">
		<link rel="icon" href="<?php print $IEM['ApplicationFavicon']; ?>" type="image/vnd.microsoft.icon">
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo strtolower(defined("SENDSTUDIO_CHARSET") ? SENDSTUDIO_CHARSET : "UTF-8"); ?>">
		<link rel="stylesheet" href="includes/styles/stylesheet.css" type="text/css">
		<script>
			var UnsubLinkPlaceholder = "<?php print GetLang('UnsubLinkPlaceholder'); ?>";
			var ModifyLinkPlaceholder = "<?php print GetLang('ModifyLinkPlaceholder'); ?>";
			var SendToFriendLinkPlaceholder = "<?php print GetLang('SendToFriendLinkPlaceholder'); ?>";
			var UsingWYSIWYG = '<?php if(isset($GLOBALS['UsingWYSIWYG'])) print $GLOBALS['UsingWYSIWYG']; ?>';
		</script>

		<script src="includes/js/jquery.js"></script>
		<script src="includes/js/jquery/jquery.json-1.3.min.js"></script>
		<script src="includes/js/javascript.js"></script>
		<script src="includes/js/tiny_mce/tiny_mce.js"></script>
		<script defer>
			// Hack for IE
			if(navigator.userAgent.indexOf('MSIE') > -1) {
				document.getElementById('popContainer').style.width = '100%';
			}
		</script>
</head>

<body class="popupBody">
	<div class="popupContainer" id="popContainer">
<!-- END PAGE HEADER -->
