<?php include template("manage_header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_misc('forum'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"><div class="subhead"><h2>Forum Management</h2></div></div>
            <div class="box-content">
                
				<div class="sect" style="padding:10px; background: #AADFF1 ">
					<form method="get">
                        <strong>ID:</strong> <input type="text" name="id" value="<?php echo htmlspecialchars($id); ?>" class="h-input" size="3" />
                        <strong>Content:</strong> <input type="text" name="content" value="<?php echo htmlspecialchars($content); ?>" class="h-input" />
                        &nbsp;<strong>User:</strong> <input type="text" name="uemail" class="h-input" value="<?php echo htmlspecialchars($uemail); ?>" >
                        &nbsp;<strong>Deal ID:</strong> <input type="text" name="team_id" class="h-input" value="<?php echo htmlspecialchars($team_id); ?>" >
                        &nbsp;<strong>City:</strong> <select name="city_id" class="h-input" require="true" onchange="this.form.submit();">
                        <option value='0'>--Chon--</option><?php echo Utility::Option(Utility::OptionArray($allcities,'id','name'),$city_id); ?></select>
						<p style="margin:5px 0;">
                        <strong>Date From:</strong> <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="cbday" value="<?php echo $cbday; ?>" /> 
                        <strong>Date To:</strong> <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="ceday" value="<?php echo $ceday; ?>" />
                        &nbsp;<!--paying time：<input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="pbday" value="<?php echo $pbday; ?>" /> - <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="peday" value="<?php echo $peday; ?>" />-->
						&nbsp;<input type="submit" value="  Select  " class="formbutton"  style="padding:1px 6px;"/></p>
					</form>
				</div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table" width="100%">
					<tr><th width="20">ID</th><th width="400">Content</th><th width="100">User</th><th width="20">City/Deal/Time</th><th width="50">Action</th></tr>
					<?php if(is_array($orders)){foreach($orders AS $index=>$one) { ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>">
						<td><?php echo $one['id']; ?></td>
						<td><a href="/team.php?id=<?php echo $one['team_id']; ?>&comment=display#div_dealcomment" target="_blank"><?php echo cut_string($one['content'],300,'...'); ?></a>
                        <?php 
                               	$urep = "";
                                $reply = DB::GetQueryResult("SELECT user_id_reply FROM topic_reply WHERE topic_id=".$one['id']);
                                if($reply['user_id_reply']>0){
                                    $m = DB::GetQueryResult("SELECT manager, username FROM `user` WHERE id=".$reply['user_id_reply']);
                                    if($m['manager']=='Y'){
                                    	$urep = "<br><strong>".$enc->decrypt('@4!@#$%@', $m['username'])." đã trả lời</strong>";
                                	}
                                }
                                $realemail = $enc->decrypt('@4!@#$%@', $users[$one['user_id']]['email']);
                            ; ?>  
                            <?php echo $urep; ?>                  
                        </td>
						<td><a href="/ajax/manage.php?action=userview&id=<?php echo $one['user_id']; ?>" class="ajaxlink"><?php echo $realemail; ?><br/><?php echo $users[$one['user_id']]['realname']; ?><br /><?php echo $users[$one['user_id']]['mobile']; ?></a><br /><strong>IP: <?php echo $one[topic_ip]; ?></strong></br><?php if(total_order_user($users[$one['user_id']]['id'])>0){?><b style="color:#FA6D18"><?php echo $old_cus='KH cũ'; ?></b><?php } else { ?><b style="color:#C40000"><?php echo $old_cus='KH mới'; ?></b><?php }?><?php if(Utility::IsMobile($users[$one['user_id']]['mobile'])){?>&nbsp;&raquo;&nbsp;<a href="/ajax/misc.php?action=sms&v=<?php echo $users[$one['user_id']]['mobile']; ?>" class="ajaxlink">SMS</a><?php }?></td>						
                        <td><?php echo $cities[$one['city_id']]['name']; ?><br />
                        DealID : <?php echo $one['team_id']; ?><br />
                        <?php echo Utility::HumanTime($one['create_time']); ?>
                        </td>                        
						<td nowrap="nowrap">
                        <a href="/ajax/topic.php?action=topicedit&id=<?php echo $one['id']; ?>" class="ajaxlink">Edit</a> -- <?php if($one['status']=='Y'){?><a href="/ajax/topic.php?action=topichidden&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to hidden the comment？"><strong>Ẩn</strong></a><?php } else { ?><a href="/ajax/topic.php?action=topicshow&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to hidden the comment？"><strong>Hiển thị</strong></a><?php }?><br />                   
                         <a href="/ajax/topic.php?action=topicremove&id=<?php echo $one['id']; ?>"  class="ajaxlink" ask="sure to delete this comment?">Delete</a></td>
					</tr>
					<?php }}?>
					<tr><td colspan="9"><?php echo $pagestring; ?></tr>
                    </table>
				</div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("manage_footer");?>
