<?php $IEM = $tpl->Get('IEM'); ?><input type="button" name="AddAutoresponderButton" value="<?php print GetLang('CreateAutoresponderButton'); ?>" class="SmallButton" style="width: 160px" onclick="javascript: document.location='index.php?Page=autoresponders&Action=create&<?php if(isset($GLOBALS['SubAction'])) print $GLOBALS['SubAction']; ?>';">

