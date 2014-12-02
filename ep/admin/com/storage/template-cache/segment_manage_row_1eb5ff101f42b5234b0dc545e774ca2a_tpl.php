<?php $IEM = $tpl->Get('IEM'); ?><tr class="GridRow">
	<td align="center">
		<input type="checkbox" name="Segments[]" class="SegmentManageSegmentSelection" value="<?php if(isset($GLOBALS['SegmentID'])) print $GLOBALS['SegmentID']; ?>" title="<?php if(isset($GLOBALS['SegmentName'])) print $GLOBALS['SegmentName']; ?>" />
	</td>
	<td><img src="images/m_segments.gif" /></td>
	<td><?php if(isset($GLOBALS['SegmentName'])) print $GLOBALS['SegmentName']; ?></td>
	<td><?php if(isset($GLOBALS['Created'])) print $GLOBALS['Created']; ?></td>
	<td><div class="SegmentSubscriberCount SegmentSubscriberCount_Unprocessed" id="sectionSegmentSubscriberCount_<?php if(isset($GLOBALS['SegmentID'])) print $GLOBALS['SegmentID']; ?>" style="text-align: center;"><img src="images/loading.gif" alt="wait..." /></div></td>
	<td><?php if(isset($GLOBALS['SegmentAction'])) print $GLOBALS['SegmentAction']; ?></td>
</tr>
