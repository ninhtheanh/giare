<?php include template("header");?>
<?php  
$uri =  $_SERVER['REQUEST_URI'];

?>
<style>
.infotitle{background: #f8f8f8;
  background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#f4f4f4), to(#fcfcfc));
  background: -webkit-linear-gradient(top, #fcfcfc, #f4f4f4);
  background: -moz-linear-gradient(top, #fcfcfc, #f4f4f4);
  background: -ms-linear-gradient(top, #fcfcfc, #f4f4f4);
  background: -o-linear-gradient(top, #fcfcfc, #f4f4f4);
height: 43px;
color: #000;
font-weight: bold;
padding-left: 14px;
line-height: 38px;}

.atbox-setting{margin-top: 0px;margin-left: 39px;width: 84%;}
.title_info_setting{font-size: 19px;color: #8bcf06;border-bottom: 1px solid #ccc;padding-bottom:10px;}
</style>
<div id="bdw" class="bdw">
  <div id="bd" class="cf">
    <div id="learn">
      <div class="subdashboard" id="dashboard">
        <ul>
        
        </ul>
      </div>
      <div id="content" class="mainwide">
        <div class="box">
        <table width="100%" style="margin-top:8px; margin-bottom:20px;">
        	<tr>
            	<td valign="top" style="width:230px;">
                	 <?php include template("menutaikhoan");?>
                	
                </td>
                <td valign="top">
                	<div class="atbox-setting">
                    	<h2 class="title_info_setting">Mời bạn bè</h2>
                    	<table border="0" cellpadding="0" cellspacing="0" width="100%">
                          <tbody>
                            <tr>
                              <td>&nbsp;</td>
                              <td><div align="left"><img src="/static/css/images/chat48.png" align="absmiddle" /> Đây là liên kết của bạn để mời bạn bè. Hãy gửi cho bạn bè của bạn trên Chat hoặc Email</div><div align="left" style="padding-left:40px;"><input id="share-copy-text" type="text" value="<?php echo $INI['system']['wwwprefix']; ?>/r.php?r=<?php echo $login_user_id; ?>" size="35" class="f-input" onfocus="this.select()" tip="Sao chép liên kết, và gửi cho bạn bè của bạn trên Chat hoặc Email" />&nbsp;<input id="share-copy-button" type="button" value=" Chọn " class="formbutton" /></div>
                              	<div align="left" style="padding-top:10px; padding-left:60px">
                                    <table border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td align="left" style="padding-right:20px; padding-top:30px;"><a href="ymsgr:im?+&msg=Hãy tham gia <?php echo $INI['system']['abbreviation']; ?> để có được những khuyến mãi hấp dẫn giảm đến 90%. Thỏa thích mua sắm, ăn uống, giải trí, học tập, du lịch, resort, nhà hàng, làm đẹp, spa... với voucher của <?php echo $INI['system']['abbreviation']; ?> - <?php echo $INI['system']['wwwprefix']; ?>/r.php?r=<?php echo $login_user_id; ?>" title="Chia sẻ qua Yahoo!Messenger" style="text-decoration:none"><img alt="Chia sẻ qua Yahoo!Messenger" align="absmiddle" src="/static/css/images/yahoo_icon.gif" border="0" title="Chia sẻ qua Yahoo!Messenger" style="padding-right:5px;" /><strong>Chia sẻ qua Yahoo!Messenger</strong></a></td>
                                        <td style="padding-right:20px; padding-top:30px;"><a href="mailto:?subject=Hãy tham gia <?php echo $INI['system']['abbreviation']; ?> để có được những khuyến mãi hấp dẫn giảm đến 90%. Thỏa thích mua sắm, ăn uống, giải trí, học tập, du lịch, resort, nhà hàng, làm đẹp, spa... với voucher của <?php echo $INI['system']['abbreviation']; ?> - <?php echo $INI['system']['wwwprefix']; ?>/r.php?r=<?php echo $login_user_id; ?>" title="Chia sẽ qua email" style="text-decoration:none"><img alt="Chia sẻ qua email" align="absmiddle" src="/static/css/images/email_icon.gif" border="0" title="Chia sẻ qua email" style="padding-right:5px;" /><strong>Chia sẻ qua email</strong></a></td></tr></table>
                                </div>
                                <div class="clear"></div><?php if($id_promotion>0){?>
					<table cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th>Stt</th><th width="300">Họ tên</th><th width="200">Thời gian mời</th><th width="200">Mã số tặng</th></tr>
					<?php if(is_array($invites)){foreach($invites AS $index=>$one) { ?>
						<tr <?php echo $index%2?'':'class="alt"'; ?>><td><?php echo $index+1; ?></td><td style="text-align:left"><?php echo $users[$one['other_user_id']]['realname']; ?></td><td><?php echo date('d-m-Y H:i:s', $one['create_time']); ?></td><td>
                        <?php 
                        	$tang = DB::GetQueryResult("SELECT maso FROM masoduthuong WHERE team_id=".$id_promotion." AND user_id=".$one['user_id']." AND status='donation'");
                            $maso_tang = "";
                            if($tang['maso']>0){
                                echo $maso_tang = $tang['maso'];
                            }else{
                                echo $maso_tang = "";
                            }
                ; ?></td></tr>
					<?php }}?>
					</table>
                    <div align="right"><?php echo $pagestring; ?></div>
                    <div class="clear"></div><?php }?>
                              </td>
                              <td>&nbsp;</td>
                            </tr>
                          </tbody>
                        </table>                    
                    </div>
           		</td>
            </tr>
            </table>    
        
          
          <div class="box-bottom"></div>
        </div>
      </div>
    </div>
  </div>
  <!-- bd end -->
</div>
<!-- bdw end -->
<?php include template("footer");?>