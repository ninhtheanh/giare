<?php $IEM = $tpl->Get('IEM'); ?><html>
	<head>
		<link rel="stylesheet" href="<?php echo $tpl->Get('ApplicationUrl'); ?>includes/styles/stylesheet.css" type="text/css" />
		<style type="text/css" media="all">
			#ProgressReportContainer {
				padding: 0px;
				margin: 0px;
				width: auto;
			}
		
			#ProgressReportProgress {
				margin: 0px;
				text-align: center;
			}
		
			#ProgressReportProgressBar {
				padding: 0px;
				height: 20px;
				margin: auto;
				width: 300px;
				border: 1px solid #CCCCCC;
				background: url("<?php echo $tpl->Get('TemplateUrl'); ?>images/progressbar.gif") no-repeat -300px 0px;
				text-align: center;
				font-weight: bold;
			}
		
			#ProgressReportStatus {
				text-align: center;
			}
		</style>
	</head>

	<body class="popupBody">
		<div class="popupContainer">

			<div id="ProgressReportContainer">
				<div id="ProgressReportTitle" class="Heading1">
					<?php if($tpl->Get('Fix')): ?>
						<?php echo GetLang('Addon_dbcheck_ProgressTitleFix'); ?>
					<?php else: ?>
						<?php echo GetLang('Addon_dbcheck_ProgressTitleCheck'); ?>
					<?php endif; ?>
				</div>
				<br />
				<div id="ProgressReportMessage" class="body pageinfo"><p>
					<?php if($tpl->Get('Fix')): ?>
						<?php echo GetLang('Addon_dbcheck_ProgressIntroFix'); ?>
					<?php else: ?>
						<?php echo GetLang('Addon_dbcheck_ProgressIntroCheck'); ?>
					<?php endif; ?>
				</p></div>
				<br />
				<div id="ProgressReportReport" class="body"></div>
				<br />
				<div id="ProgressReportProgress">
					<div id="ProgressReportProgressBar">&nbsp;</div>
				</div>
				<div id="ProgressReportStatus" class="intro">&nbsp;</div>
			</div>
			
			<!-- iframe which does all of the work -->
			<iframe id="fmeWorker" width="1" height="1" frameborder="0"></iframe>
			
			<script>
				setTimeout(function() {
					var e = document.getElementById('fmeWorker');
					e.src = '<?php echo $tpl->Get('AdminUrl'); ?>&AJAX=1&Action=CheckDatabase<?php if($tpl->Get('Fix')): ?>&Fix=true<?php endif; ?>&r=<?php echo $tpl->Get('RandomValue'); ?>';
				}, 2);
				
				function UpdateStatus(status, percentage)
				{
					var f = document.getElementById('ProgressReportProgressBar');
					f.style.background = 'url("<?php echo $tpl->Get('TemplateUrl'); ?>images/progressbar.gif") no-repeat -' + (300 - (percentage * 3)) + 'px 0px';
					f.innerHTML = parseInt(percentage) + "%";
					document.getElementById('ProgressReportStatus').innerHTML = status;
				}
			
				function UpdateStatusReport(report)
				{
					document.getElementById('ProgressReportReport').innerHTML = report;
				}
			
				function ProcessFinished()
				{
					self.parent.location = '<?php echo $tpl->Get('AdminUrl'); ?>&Action=Finished<?php if($tpl->Get('Fix')): ?>&Repair=Complete<?php endif; ?>';
				}
			
				function ProcessFailed()
				{
					self.parent.location = '<?php echo $tpl->Get('AdminUrl'); ?>&Action=Finished';
				}
			</script>
		
		</div>
	</body>
</html>
