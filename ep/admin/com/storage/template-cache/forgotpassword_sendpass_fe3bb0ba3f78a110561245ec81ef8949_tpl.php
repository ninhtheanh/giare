<?php $IEM = $tpl->Get('IEM'); ?><style type="text/css">
	.popupContainer {
		border: 0px;
	}
</style>
<form action="index.php?Page=<?php print $IEM['CurrentPage']; ?>&Action=<?php if(isset($GLOBALS['SubmitAction'])) print $GLOBALS['SubmitAction']; ?>" method="post" name="frmLogin" id="frmLogin">
	<div id="box" class="loginBox">
		<table><tr><td style="border:solid 2px #DDD; padding:20px; background-color:#FFF; width:300px;">
		<table>
			<tr>
			<td class="Heading1">
				<img src="images/logo.jpg" alt="<?php echo GetLang('SendingSystem'); ?>" />
			</td>
		</tr>
		<tr>
			<td style="padding:10px 0px 5px 0px"><?php if(isset($GLOBALS['Message'])) print $GLOBALS['Message']; ?></td>
		</tr>
		</table>
		</td></tr>
		</table>

	</div>

	</form>

	<script>

		$('#frmLogin').submit(function() {
				var f = document.frmLogin;

				if(f.ss_username.value == '')
				{
					alert('<?php print GetLang('NoUsername'); ?>');
					f.ss_username.focus();
					return false;
				}

				// Everything is OK
				return true;
		});

		function sizeBox() {
			var w = $(window).width();
			var h = $(window).height();
			$('#box').css('position', 'absolute');
			$('#box').css('top', h/2-($('#box').height()/2)-50);
			$('#box').css('left', w/2-($('#box').width()/2));
		}

		$(document).ready(function() {
			sizeBox();
			$('#ss_username').focus();
			$('#ss_username').select();
		});

		$(window).resize(function() {
			//sizeBox();
		});
		createCookie("screenWidth", screen.availWidth, 1);

	</script>