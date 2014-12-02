<?php  
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Editor</title>
<script src="ckeditor.js"></script>

</head>

<body>
<textarea id="demo1"></textarea>
</body>
<script>

	CKEDITOR.replace( 'demo1',
	{
		filebrowserBrowseUrl : '/ckfinder/ckfinder.html',
		filebrowserImageBrowseUrl : '/ckfinder/ckfinder.html?type=Images',
		filebrowserFlashBrowseUrl : '/ckfinder/ckfinder.html?type=Flash',
		filebrowserUploadUrl : 
		   '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&currentFolder=/archive/',
		filebrowserImageUploadUrl : 
		   '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&currentFolder=/cars/',
		filebrowserFlashUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
	});
</script>
</html>