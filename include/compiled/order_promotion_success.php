<?php include template("header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
  <div id="content" class="mainwide">
    <div id="order-pay-return" class="box clear">
      <div class="subbox-content">
        <div style="background-color:#FFFFFF">
          <div align="left" style="padding:20px;padding-bottom:10px;padding-top:10px;">
            <div align="left" style="font-size:18px;">
              <h2><img src="/static/css/images/bg-pay-return-success.jpg" align="absmiddle" />&nbsp;
                <?php if($order['state'] == 'pay'){?>
                Bạn đã tham gia chương trình này rồi. Bên dưới là thông tin và mã số dự thưởng của bạn.
                <?php } else { ?>
                Bạn đã xác nhận thành công, bên dưới là thông tin và mã số dự thưởng của bạn.
                <?php }?>
              </h2>
            </div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top" style="padding-top:5px;"><div class="sect" style="background-color:#f1f3f5; border:#CCCCCC 1px solid;">
                    <div id="divOrderMess">
                      <div style="font-size:15px;" align="center">Giải thưởng "Miễn phí 01 năm mua sắm trên web: www.dealsoc.vn" với tổng giá trị giải thưởng lên đến 185.000.000 VNĐ</div>
                      <div align="center" style="vertical-align:middle">Mã số dự thưởng của bạn:&nbsp;<span style="font-size:30px; text-shadow:#CCCCCC 1px 1px; color:#1B91B9"><?php echo $order['maso']; ?></span></div>
                    </div>
                    <hr />
                    <div align="center" style="padding-bottom:30px;padding-top:10px; font-size:15px;">Chia sẻ link bên dưới đến bạn bè để có thêm cơ hội trúng "Miễn phí 01 năm mua sắm trên web: www.dealsoc.vn".<br />
                      Danh sách bạn bè giới thiệu sẽ được hiển thị trong tài khoản của bạn để tiện theo dõi.<br />
                      <br />
                      <br />
                      <strong>URL:</strong>&nbsp;
                      <input id="share-copy-text" type="text" value="<?php echo $INI['system']['wwwprefix']; ?>/r.php?r=<?php echo $user_id; ?>" size="35" class="f-input" style="font-size:16px; font-family:Arial; font-weight:bold" onfocus="this.select()" tip="Sao chép liên kết, và gửi cho bạn bè của bạn trên Chat hoặc Email" />
                      <input id="share-copy-button" type="button" value=" Chọn " class="formbutton" />
                    </div>
                    <div class="clear"></div>
                    <div align="center">
                      <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td align="left" style="padding-right:20px;"><a href="ymsgr:im?+&msg=Hãy tham gia chương trình &quot;Miễn phí 01 năm mua sắm trên web: www.dealsoc.vn&quot; - <?php echo $INI['system']['wwwprefix']; ?>/r.php?r=<?php echo $login_user_id; ?>" title="Chia sẻ qua Yahoo!Messenger" style="text-decoration:none"><img alt="Chia sẻ qua Yahoo!Messenger" align="absmiddle" src="/static/css/images/yahoo.png" border="0" title="Chia sẻ qua Yahoo!Messenger" style="padding-right:5px;" /><strong>Chia sẻ qua Yahoo!Messenger</strong></a> </td>
                          <td><a href="mailto:?subject=Tham gia và Miễn phí 01 năm mua sắm trên web: www.dealsoc.vn&body=Hãy tham gia chương trình &quot;Miễn phí 01 năm mua sắm trên web: www.dealsoc.vn&quot; - <?php echo $INI['system']['wwwprefix']; ?>/r.php?r=<?php echo $login_user_id; ?>" title="Chia sẽ qua email" style="text-decoration:none"><img alt="Chia sẻ qua email" align="absmiddle" src="/static/css/images/email.png" border="0" title="Chia sẻ qua email" style="padding-right:5px;" /><strong>Chia sẻ qua email</strong></a> </td>
                        </tr>
                      </table>
                    </div>
                    <div align="left" style="padding-top:10px;">
                      <h2 style="font-size:16px; font-weight:bold">Danh sách bạn bè đã mời thành công</h2>
                    </div>
                    <?php 
                	$condition = array( 'user_id' => $login_user_id, 'team_id' => $order['team_id'], );
                    $count = Table::Count('invite', $condition);
                    
                    $money = Table::Count('invite', $condition, 'credit');
                    
                    list($pagesize, $offset, $pagestring) = pagestring($count, 20);
                    
                    $invites = DB::LimitQuery('invite', array(
                                'condition' => $condition,
                                'order' => 'ORDER BY buy_time DESC',
                                'size' => $pagesize,
                                'offset' => $offset,
                                ));
                    
                    $user_ids = Utility::GetColumn($invites, 'other_user_id');
                    $team_ids = Utility::GetColumn($invites, 'team_id');
                    
                    $users = Table::Fetch('user', $user_ids);
                    $teams = Table::Fetch('team', $team_ids);
                ; ?>
                    <div align="left">
                      <table cellspacing="0" cellpadding="0" border="0" class="coupons-table">
                        <tr>
                          <th style="background-color:#47bded; color:#FFFFFF">Stt</th>
                          <th width="200" style="background-color:#47bded; color:#FFFFFF">Email</th>
                          <th width="305" style="background-color:#47bded; color:#FFFFFF">Họ tên</th>
                          <th width="200" style="background-color:#47bded; color:#FFFFFF">Thời gian mời</th>
                        </tr>
                        <?php if(is_array($invites)){foreach($invites AS $index=>$one) { ?>
                        <tr <?php echo $index%2?'':'class="alt"'; ?>>
                          <td><?php echo $stt=$index+1; ?></td>
                          <td><?php echo $users[$one['other_user_id']]['email']; ?></td>
                          <td style="text-align:left"><?php echo $users[$one['other_user_id']]['realname']; ?></td>
                          <td><?php echo date('d-m-Y H:i:s', $one['create_time']); ?></td>
                        </tr>
                        <?php }}?>
                      </table>
                    </div>
                    <div align="left" style="padding-top:5px;">Ghi chú: Việc giới thiệu chỉ thành công khi:<br />
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-Người được giới thiệu là khách hàng mới và chưa được giới thiệu trên dealsoc.vn.<br />
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-Người được giới thiệu phải click vào link của bạn và tham gia thành công.</div>
                  </div></td>
                <td align="left" valign="top" style="padding-left:7px;"><div id="sidebar">
                    <?php include template("block_side_support");?>
                </div></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div id="side"> </div>
  </div>
  <!-- bd end -->
</div>
<!-- bdw end -->
<?php include template("footer");?>
