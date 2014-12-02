<?php $IEM = $tpl->Get('IEM'); ?><table cellspacing="0" cellpadding="0" width="100%" align="center">
        <tr>
                <td class="Heading1"><?php print GetLang('Stats_NewsletterStatistics'); ?></td>
        </tr>
        <tr>
                <td class="body pageinfo"><p><?php print GetLang('Stats_Newsletters_Step1_Intro'); ?></p></td>
        </tr>
	<tr>
		<td class="body pageinfo">
			<p>
				<?php if(isset($GLOBALS['Message'])) print $GLOBALS['Message']; ?>
			</p>
		</td>
	</tr>
	<tr>
		<td class="body"><?php if(isset($GLOBALS['Newsletters_SendButton'])) print $GLOBALS['Newsletters_SendButton']; ?></td>
	</tr>
</table>