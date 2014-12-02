<table id="replies-list" width="100%" cellspacing="0" cellpadding="0" border="0">
  <?php if(is_array($replies)){foreach($replies AS $one) { ?>
  <?php if($one['status']=='N'){?>
  <?php if(($one['user_id']==$login_user_id) OR ($login_user['manager']=='Y')){?>
  <tr>
    <td width="49" valign="top"><a name="entry-<?php echo $one['id']; ?>"></a>
      <div class="avatar"><img src="<?php echo user_image($users[$one['user_id']]['avatar']); ?>" width="48" height="48" /></div></td>
    <td align="left" valign="top"><div class="author"> <span style="float:right;color:#FFFFFF"><?php echo Utility::HumanTime($one['create_time']); ?>
        <?php if(is_manager()){?>
        &nbsp;---&nbsp;<a href="/ajax/topic.php?action=topicshow&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to show the reply?" style="color:#FFFFFF"><strong>Hiển Thị</strong></a> || <a href="/ajax/topic.php?action=topicremove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to delete the reply?" style="color:#FFFFFF"><strong>Xóa</strong></a>
        <?php }?>
        </span><b>
        <?php if(($login_user['manager']=='Y')){?>
        <a href="/ajax/manage.php?action=userviewhistory&id=<?php echo $one['user_id']; ?>" class="ajaxlink"  style="color:#FFFFFF"><?php echo $users[$one['user_id']]['realname']; ?></a>
        <?php } else { ?>
        <?php echo $users[$one['user_id']]['realname']; ?>
        <?php }?>
        </b>
        <div class="clear"></div>
      </div>
      <div align="justify" style="padding-left:5px;padding-top:5px;"><?php echo nl2br(htmlspecialchars($one['content'])); ?> </div></td>
  </tr>
  <tr>
    <td align="left" colspan="2"><hr size="1" width="100%" style="color:#CCCCCC;" /></td>
  </tr>
  <?php }?>
  <?php } else { ?>
  <tr>
    <td width="49" valign="top"><a name="entry-<?php echo $one['id']; ?>"></a>
      <div class="avatar"><img src="<?php echo user_image($users[$one['user_id']]['avatar']); ?>" width="48" height="48" /></div></td>
    <td align="left" valign="top"><div class="author"><span style="float:right;color:#FFFFFF"><?php echo Utility::HumanTime($one['create_time']); ?>
        <?php if(is_manager()){?>
        &nbsp;---&nbsp;<a href="/ajax/topic.php?action=topichidden&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to hidden the reply?" style="color:#FFFFFF"><strong>Ẩn</strong></a> || <a href="/ajax/topic.php?action=topicremove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to delete the reply?" style="color:#FFFFFF"><strong>Xóa</strong></a>
        <?php }?>
        </span><b>
        <?php if(($login_user['manager']=='Y')){?>
        <a href="/ajax/manage.php?action=userviewhistory&id=<?php echo $one['user_id']; ?>" class="ajaxlink" style="color:#FFFFFF"><?php echo $users[$one['user_id']]['realname']; ?></a>
        <?php } else { ?>
        <?php echo $users[$one['user_id']]['realname']; ?>
        <?php }?>
        </b>
        <div class="clear"></div>
      </div>
      <div class="topic-content" align="justify" style="padding-left:5px;padding-top:5px;">
        <?php 
                                    $filter =  array('nhommua', 'Nhommua', 'NhomMua', 'nhom_mua', 'nhom-mua', 'nhom mua','Nhom Mua','Nhom mua', 'cungmua', 'cung_mua', 'cung-mua', 'cung mua', 'muachung', 'mua_chung', 'mua-chung', 'mua chung', 'vndoan', 'vn_doan', 'vn-doan', 'vn doan', 'hotdeal', 'hot deal', 'hot-deal', 'hotdeal.vn', 'phagia', 'pha gia', 'cuc re', 'cucre',);
                                    foreach($filter as $v){
                                        if(strpos($one['content'], $v) !== false) {
                                                $one['content'] = str_ireplace($v,"*****",$one['content']);
                                        }
                                    }
                                ; ?>
        <?php echo nl2br(htmlspecialchars($one['content'])); ?> </div>
      <div align="right" style="padding-top:10px;">
        <script type="text/javascript">
			function ShowReplyTopic(id){
				if(document.getElementById("showreplyform_"+id).style.display=="none"){									
					$('#showreplyform_'+id).show();
					$('#noneclick'+id).hide();
					$('#clicked'+id).show();								
					return;
				}else{
					$('#showreplyform_'+id).hide();
					$('#noneclick'+id).show();
					$('#clicked'+id).hide();							
					
				}
			}
			function ShowNeedLogin(id){
				if(document.getElementById("needlogin_"+id).style.display=="none"){	
					document.getElementById("needlogin_"+id).style.display="block";
					return;
				}else{
					document.getElementById("needlogin_"+id).style.display="none";
				}
			}
			jQuery(document).ready(function(){
				$("#forum-reply-form_<?php echo $one['user_id']; ?>_<?php echo $one['id']; ?>").submit(function(e) {
					e.preventDefault();
					postTopicReply('<?php echo $one["user_id"]; ?>_<?php echo $one["id"]; ?>');							
				});
			});
			function postTopicReply(id){
				error(0);
				$.ajax({
					type: "POST",
					url: "http://<?php echo $INI['system']['sitename']; ?>/forum/topic_reply.php",
					data: $("#forum-reply-form_"+id).serialize(),
					dataType: "json",
					success: function(msg){
						if(parseInt(msg.status)==0){
							error(1,msg.txt);
						}	
						$("#forum-new-content").val("");
						getPage();
						$("#showreplyform_"+id).show();
					}
				});
			}
		</script>
        <?php 
              $total_count = DB::GetQueryResult("SELECT count(id) as total FROM topic_reply WHERE user_id='".$one['user_id']."' AND topic_id='".$one['id']."'"); 
              $topic_reply = DB::GetQueryResult("SELECT * FROM topic_reply WHERE user_id='".$one['user_id']."' AND topic_id='".$one['id']."'", false);
        ; ?>
        <?php if(is_login()){?>
        <a href="javascript:void(0)" class="AnsView2" onclick="ShowReplyTopic('<?php echo $one['user_id']; ?>_<?php echo $one['id']; ?>')" id="noneclick<?php echo $one['user_id']; ?>_<?php echo $one['id']; ?>" style="text-decoration:none"><span><?php echo (int)($total_count['total']); ?> thảo luận</span></a><a href="javascript:void(0)" class="AnsView1" onclick="ShowReplyTopic('<?php echo $one['user_id']; ?>_<?php echo $one['id']; ?>')" id="clicked<?php echo $one['user_id']; ?>_<?php echo $one['id']; ?>" style="text-decoration:none;display:none;"><span><?php echo (int)($total_count['total']); ?> thảo luận</span></a>
        <?php } else { ?>
        <a href="javascript:void(0)" class="AnsView2" onclick="ShowNeedLogin('<?php echo $one['user_id']; ?>_<?php echo $one['id']; ?>')" id="noneclick" style="text-decoration:none"><span><?php echo (int)($total_count['total']); ?> thảo luận</span></a><a href="javascript:void(0)" class="AnsView1" onclick="ShowNeedLogin('<?php echo $one['user_id']; ?>_<?php echo $one['id']; ?>')" id="clicked" style="text-decoration:none;display:none;"><span><?php echo (int)($total_count['total']); ?> thảo luận</span></a>
        <?php }?>
      </div>
      <div style="clear:both"></div>
      <div style="padding-left:10px;padding-bottom:10px;display:none; padding-right:10px; padding-top:10px;" id="showreplyform_<?php echo $one['user_id']; ?>_<?php echo $one['id']; ?>">
        <?php if((!empty($topic_reply))){?>
        <?php if(is_array($topic_reply)){foreach($topic_reply AS $indexs=>$ones) { ?>
        <?php  $user_realname = DB::GetQueryResult("SELECT avatar, realname FROM `user` WHERE id='".$ones['user_id_reply']."'"); ; ?>
        <div style="padding-bottom:7px;">
          <?php if($ones['status']=='N'){?>
          <?php if((($ones['user_id']==$login_user_id) OR ($login_user['manager']=='Y'))){?>
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="48" valign="top"><a name="entry-<?php echo $one['id']; ?>"></a>
                <div class="avatar"><img src="<?php echo user_image($user_realname['avatar']); ?>" width="48" height="48" /></div></td>
              <td align="left" valign="top"><div class="author" style="color:#FFFFFF"> <span style="float:right;"><?php echo Utility::HumanTime($ones['create_time']); ?>
                  <?php if(($login_user['manager']=='Y')){?>
                  &nbsp;---&nbsp; <a href="/ajax/topic.php?action=topicreplyshow&reply_id=<?php echo $ones['id']; ?>&id=<?php echo $ones['topic_id']; ?>" class="ajaxlink" ask="sure to show the reply?" style="color:#FFFFFF"><strong>Hiển thị</strong></a> || <a href="/ajax/topic.php?action=topicreplyremove&reply_id=<?php echo $ones['id']; ?>&id=<?php echo $ones['topic_id']; ?>" class="ajaxlink" ask="sure to delete the reply?" style="color:#FFFFFF"><strong>Xóa</strong></a>
                  <?php }?>
                  </span><b>
                  <?php if(($login_user['manager']=='Y')){?>
                  <a href="/ajax/manage.php?action=userviewhistory&id=<?php echo $ones['user_id_reply']; ?>" class="ajaxlink" style="color:#FFFFFF"><?php echo $user_realname['realname']; ?></a>
                  <?php } else { ?>
                  <?php echo $user_realname['realname']; ?>
                  <?php }?>
                  </b>
                  <div class="clear"></div>
                </div>
                <div class="topic-content" style="padding-left:5px;">
                  <?php 
                    $filter =  array('nhommua', 'nhom_mua', 'nhom-mua', 'nhom mua', 'cungmua', 'cung_mua', 'cung-mua', 'cung mua', 'muachung', 'mua_chung', 'mua-chung', 'mua chung', 'vndoan', 'vn_doan', 'vn-doan', 'vn doan');
                    foreach($filter as $v){
                        if(strpos($ones['content'], $v) !== false) {
                                $ones['content'] = str_ireplace($v,"*****",$ones['content']);
                        }
                    }
                ; ?>
                  <?php echo nl2br(htmlspecialchars($ones['content'])); ?> </div></td>
            </tr>
          </table>
          <?php }?>
          <?php } else { ?>
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="48" valign="top"><a name="entry-<?php echo $one['id']; ?>"></a>
                <div class="avatar"><img src="<?php echo user_image($user_realname['avatar']); ?>" width="48" height="48" /></div></td>
              <td align="left" valign="top"><div class="author" style="color:#FFFFFF"> <span style="float:right;"><?php echo Utility::HumanTime($ones['create_time']); ?>
                  <?php if(($login_user['manager']=='Y')){?>
                  &nbsp;---&nbsp;
                  <?php if(($ones['status']=='Y')){?>
                  <a href="/ajax/topic.php?action=topicreplyhidden&reply_id=<?php echo $ones['id']; ?>&id=<?php echo $ones['topic_id']; ?>" class="ajaxlink" ask="sure to hidden the reply？"><strong>Ẩn</strong></a>
                  <?php } else { ?>
                  <a href="/ajax/topic.php?action=topicreplyshow&reply_id=<?php echo $ones['id']; ?>&id=<?php echo $ones['topic_id']; ?>" class="ajaxlink" ask="sure to show the reply？"><strong>Hiển thị</strong></a>
                  <?php }?>
                  || <a href="/ajax/topic.php?action=topicreplyremove&reply_id=<?php echo $ones['id']; ?>&id=<?php echo $ones['topic_id']; ?>" class="ajaxlink" ask="sure to delete the reply？"><strong>Xóa</strong></a>
                  <?php }?>
                  </span><b>
                  <?php if(($login_user['manager']=='Y')){?>
                  <a href="/ajax/manage.php?action=userviewhistory&id=<?php echo $ones['user_id_reply']; ?>" class="ajaxlink" style="color:#FFFFFF"><?php echo $user_realname['realname']; ?></a>
                  <?php } else { ?>
                  <?php echo $user_realname['realname']; ?>
                  <?php }?>
                  </b>
                  <div class="clear"></div>
                </div>
                <div class="topic-content">
                  <?php 
                    $filter =  array('nhommua', 'nhom_mua', 'nhom-mua', 'nhom mua', 'cungmua', 'cung_mua', 'cung-mua', 'cung mua', 'muachung', 'mua_chung', 'mua-chung', 'mua chung', 'vndoan', 'vn_doan', 'vn-doan', 'vn doan');
                    foreach($filter as $v){
                        if(strpos($ones['content'], $v) !== false) {
                                $ones['content'] = str_ireplace($v,"*****",$ones['content']);
                        }
                    }
                ; ?>
                  <?php echo nl2br(htmlspecialchars($ones['content'])); ?> </div></td>
            </tr>
          </table>
          <?php }?>
        </div>
        <?php }}?>
        <?php }?>
        <div align="center" style="padding-top:5px;">
          <form id="forum-reply-form_<?php echo $one['user_id']; ?>_<?php echo $one['id']; ?>" method="post" action="" class="validator">
            <input type="hidden" name="user_id" value="<?php echo $one['user_id']; ?>" />
            <input type="hidden" name="topic_id" value="<?php echo $one['id']; ?>" />
            <textarea style="width:99%;height:50px; border:#32ccfe 1px solid" name="content-reply" id="forum-new-content" class="f-textarea" require="true" datatype="require"></textarea>
            <div align="right" style="padding-top:10px;">&nbsp;<button type="submit" name="replytopicuser" id="leader-submit" class="formbutton">Trả lời</button></div>
          </form>
        </div>
      </div>
      <div align="left" id="needlogin_<?php echo $one['user_id']; ?>_<?php echo $one['id']; ?>" style="display:none; padding-bottom:10px">Vui lòng <a href="/account/login.php?r=<?php echo $currefer; ?>">Đăng nhập</a> hoặc <a href="/account/signup.php">Đăng ký</a> để trả lời.</div></td>
  </tr>
  <tr>
    <td align="left" colspan="2"><hr size="1" width="100%" style="color:#CCCCCC;" /></td>
  </tr>
  <?php }?>
  <?php }}?>
  <?php if($count>10){?>
  <tr>
    <td colspan="2"><?php echo $pagestring; ?></td>
  </tr>
  <?php }?>
</table>
