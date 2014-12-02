<?php $IEM = $tpl->Get('IEM'); ?><script type="text/javascript">
	function PreviewHTMLContent() {
			var html;
			html = $('textarea.ContentsTextEditor').val();
			win = window.open(", ", 'popout', 'toolbar = no, status = no');
		  	win.document.write("" + html + "");
	}
</script>

<textarea name="<?php if(isset($GLOBALS['Name'])) print $GLOBALS['Name']; ?>" id="<?php if(isset($GLOBALS['Name'])) print $GLOBALS['Name']; ?>" rows="10" cols="60" class="ContentsTextEditor"><?php if(isset($GLOBALS['HTMLContent'])) print $GLOBALS['HTMLContent']; ?></textarea>
<input type="button" onclick="javascript: PreviewHTMLContent(); return false;" value="<?php print GetLang('PreviewHTMLContent'); ?>" class="FormButton" style="width: 150px;" />
<br /><br />
<div class="aside"><?php print GetLang('TextWidthLimit_Explaination'); ?></div>

