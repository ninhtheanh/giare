<?php include template("header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf"><div id="signup">
    	<div class="subdashboard" id="dashboard">
		<ul><li class="current"><a href="#">&nbsp;&nbsp;Giỏ hàng
                          <?php if($team['farefree']>0){?>
                          &nbsp;(<span class="currency"><?php echo $team['farefree']; ?></span>free of express fee)
                          <?php }?>&nbsp;</a><span></span></li></ul></div>
	</div>
<div id="contentfontend" class="mainwide clear"><div id="deal-buy" class="box">
  <script type="text/javascript" language="javascript">
    	function checkform(){
			if(document.teambuy.is_true.checked == false){
				alert('Vui lòng chọn vào check box!!');
				return false;
			}else{
				return true;
			}
		}
    </script>
        <div class="subbox-content" >
          <div style="background-color:#FFFFFF; min-height:500px; _height:500px">
            <div align="left" style="padding:20px; padding-top:10px;"><div align="left" style="font-size:20px; padding-bottom:10px;">
                      </div>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td width="24"><img src="/static/css/images/faqbox_topleft.gif" width="24" height="20"></td>
                    <td style="background: url(&quot;/static/css/images/faqbox_topbg.gif&quot;) repeat-x scroll 0% 0% transparent;"></td>
                    <td width="23"><img src="/static/css/images/faqbox_topright.gif" width="23" height="20"></td>
                  </tr>
                  <tr>
                    <td style="background: url(&quot;/static/css/images/faqbox_leftbg.gif&quot;) repeat-y scroll right center transparent;">&nbsp;</td>
                    <td bgcolor="#f1f1f1">
                      <div align="left">
                        <table class="order-table">
                          <tr>
                            <th class="deal-buy-desc">Deal</th>
                            <th class="deal-buy-quantity">Số lượng</th>
                            <th class="deal-buy-multi"></th>
                            <th class="deal-buy-price">Đơn giá (<span class="money"><?php echo $currency; ?></span>)</th>
                            <th class="deal-buy-equal"></th>
                            <th class="deal-buy-total">Thành tiền (<span class="money"><?php echo $currency; ?></span>)</th>
                          </tr>
                          <tr>
                            <td class="deal-buy-desc"><?php echo $team['title']; ?></td>
                            <td class="deal-buy-quantity"><input type="text" class="input-text f-input" maxlength="4" name="quantity" value="<?php if(! $sess_post['quantity']){?><?php echo $order['quantity']; ?><?php } else { ?><?php echo $sess_post['quantity']; ?><?php }?>" ff="<?php echo abs(intval($team['farefree'])); ?>" id="deal-buy-quantity-input" <?php echo $team['per_number']==1?'readonly':''; ?> />
                              <!--<br /><span style="font-size:12px;color:gray;"><?php if($team['per_number']==0){?>
                              at most 9999 pieces
                              <?php } else { ?>
                              at most <?php echo $team['per_number']; ?> pieces
                              <?php }?>
                              </span>--></td>
                            <td class="deal-buy-multi">x</td>
                            <td class="deal-buy-price"><span id="deal-buy-price"><?php echo print_price($team['team_price']); ?></span></td>
                            <td class="deal-buy-equal">=</td>
                            <td class="deal-buy-total"><span id="deal-buy-total"><?php echo print_price($order['quantity']*$team['team_price']); ?></span></td>
                          </tr>
                          <?php if($team['delivery']=='express'){?>
                          <tr>
                            <td class="deal-buy-desc">Chuyển phát nhanh</td>
                            <td class="deal-buy-quantity"></td>
                            <td class="deal-buy-multi"></td>
                            <td class="deal-buy-price"><span id="deal-express-price" v="<?php echo $team['fare']; ?>"><?php echo $team['fare']; ?></span></td>
                            <td class="deal-buy-equal">=</td>
                            <td class="deal-buy-total"><span id="deal-express-total" v="<?php echo $team['fare']; ?>"><?php echo $team['fare']; ?></span></td>
                          </tr>
                          <?php }?>
                          <tr class="order-total">
                            <td class="deal-buy-desc"></td>
                            <td class="deal-buy-quantity"></td>
                            <td class="deal-buy-multi"></td>
                            <td class="deal-buy-price" nowrap="nowrap"><strong>Tổng số tiền：</strong></td>
                            <td class="deal-buy-equal">=</td>
                            <td class="deal-buy-total"><strong id="deal-buy-total-t"><?php echo print_price($order['origin']); ?></strong>&nbsp;<span class="money"><?php echo $currency; ?></span></td>
                          </tr>
                        </table>
                      </div>
                      <div align="left">
            	<div style="color:#1693cb; font-style:normal; padding-left:70px; padding-bottom:10px; padding-top:10px; font-size:15px; font-weight:bold; font-family:arial">Vui lòng kiểm tra mail và bấm vào liên kết xác nhận để nhận mã dự thưởng</div>
                <div class="form-submit">&nbsp;</div>
             </div>
                      </td>
                    <td style="background: url(&quot;/static/css/images/faqbox_rightbg.gif&quot;) repeat-y scroll right center transparent;"></td>
                  </tr>
                  <tr>
                    <td><img src="/static/css/images/faqbox_bottomleft.gif" alt="" width="24" border="0" height="21"></td>
                    <td style="background: url(&quot;/static/css/images/faqbox_bottombg.gif&quot;) repeat-x scroll 0% 0% transparent;"></td>
                    <td><img src="/static/css/images/faqbox_bottomright.gif" alt="" width="23" border="0" height="21"></td>
                  </tr>
                </tbody>
              </table></td><td align="left" valign="top" style="padding-left:7px;"><div id="sidebar">
          <?php include template("block_side_support");?>
        </div></td>
    </tr>
  </table>
            </div>
          </div>
        </div>
      </div>
  </div><!-- bd end -->
</div>
<!-- bdw end -->
<?php include template("footer");?>