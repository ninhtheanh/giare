<div id="order-pay-dialog" class="order-pay-dialog-c" style="width:600px;">
	<h3><span id="order-pay-dialog-close" class="close" onclick="return X.boxClose();">close</span>Edit Topic No. <?php echo $topic['id']; ?></h3>
	<div style="overflow-x:hidden;padding:10px;">
        <form method="post" action="/backend/misc/forum_edit.php" class="validator">
            <input type="hidden" name="id" value="<?php echo $topic['id']; ?>" />
            <h5>Nội dung</h5><textarea name="content" class="f-textarea" style="width:98%;height:150px;"><?php echo $topic['content']; ?></textarea>
                <p style="padding-top:15px;"><input type="submit" value="Update" class="formbutton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Reply" onclick="ShowReplyTopic()" class="formbutton" /></p>
        </form>
	</div>
    <script type="text/javascript">
		function ShowReplyTopic(){
			if(document.getElementById("showreplyform").style.display=="none"){	
				document.getElementById("showreplyform").style.display="block";
				return;
			}else{
				document.getElementById("showreplyform").style.display="none";
			}
		}
	</script>
    <div style="overflow-x:hidden;padding:10px; display:none" id="showreplyform">
    	<form method="post" action="/backend/misc/forum_edit.php" class="validator">
            <input type="hidden" name="topic_id" value="<?php echo $topic['id']; ?>" />
            <input type="hidden" name="user_id" value="<?php echo $topic['user_id']; ?>" />
            <h5>Trả lời</h5><textarea name="content_reply" class="f-textarea" style="width:98%;height:150px;"></textarea>
                <p style="padding-top:15px;"><input type="submit" value="Submit" name="replytopicuser" class="formbutton" /></p>
        </form>
	</div>    
</div>
