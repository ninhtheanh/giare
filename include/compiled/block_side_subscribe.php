<div class="sbox side-support-tip">
  <div align="left" style="background-color:#e3f0d6;">
    <h2>Nhận deal mỗi ngày</h2>
  </div>
  <div align="center" style="padding-top:15px; padding-bottom:20px;background-color:#FAFAFA;">
    <table class="address">
      <form id="deal-subscribe-form" method="post" action="/subscribe.php">
        <tr>
          <td><input type="text" name="email" class="f-text" id="deal-subscribe-form-email" xtip="Nhập địa chỉ Email..." value="" style="height:15px" /></td>
          <td style="padding-left:3px;"><input type="hidden" name="city_id" value="<?php echo $city['id']; ?>" />
            <input type="image" src="/static/css/images/button-subscribe.gif" value="Subscribe" /></td>
        </tr>
      </form>
      <tr>
        <td colspan="2" align="left" style="padding-top:20px;" valign="top"><table>
            <tr>
              <td><strong>Facebook:</strong></td>
              <td style="padding-left:10px;"><iframe src="<?php echo $facebook_domain; ?>/plugins/like.php?href=<?php echo $facebook_page; ?>&amp;layout=button_count&amp;show_faces=true&amp;width=90&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:21px;" allowTransparency="true"></iframe></td>
            </tr>
            <?php if(!isset($_GET['id'])){?>
            <tr>
              <td style="padding-top:10px;" valign="top"><strong>Google Plus:</strong></td>
              <td style="padding-left:10px; padding-top:5px;"><g:plusone></g:plusone></td>
            </tr>
            <?php }?>
          </table></td>
      </tr>
    </table>
  </div>
</div>
<div align="center" style="padding-bottom:10px"><a href="http://hotdeal.vn/about/notice.php" target="_blank"><img src="/static/css/images/thong-bao-hotdeal-hn4.gif" border="0" /></a></div>
