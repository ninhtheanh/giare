<form id="fstep3" action="/ajax/checkout.php" method="post" class="validator">

<?php  
  $payments = DB::LimitQuery('payment_descriptions', array(
        'condition' =>array('status'=>'A', 'destination'=>1),
       'order' => 'ORDER BY position ASC',
      //  'size' => 500,
	//	'offset' => 0,
    ));

 $shippings = DB::LimitQuery('shippings', array(
        'condition' =>array('status'=>'A'), //, 'shipping_id in (1,3)'
       'order' => 'ORDER BY position ASC',
      //  'size' => 500,
	//	'offset' => 0,
    ));

 ?>

<table width="100%" border="0" cellspacing="4" cellpadding="0">
    <tbody><tr>
      <td align="left" valign="top" style="font-size:14px; padding-top:10px; font-family:Arial, Helvetica, sans-serif; color:#C40000; text-transform:uppercase"><h4>Phương thức thanh toán</h4></td>
      <td width="4%"></td>
      <td align="left" valign="top" style="font-size:14px; padding-top:10px; font-family:Arial, Helvetica, sans-serif; color:#C40000; text-transform:uppercase"><h4>Phương thức vận chuyển</h4></td>
    </tr>
    <tr>
      <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
      <td width="4%"></td>
      <td style="background: url(&quot;/static/css/images/faqbox_break.gif&quot;) repeat-x scroll 0% 0% transparent;" height="4"></td>
    </tr>
    <tr>
      <td align="left" valign="top" style="padding-left:10px; padding-top:7px;" width="49%">
      	<table cellspacing="5" cellpadding="5">
          <tbody>
          <?php  foreach($payments as $key=>$payment): ?>          
          <tr><td align="right" valign="top"><input type="radio" name="methods[payment]" id="payment" value="<?php  echo $payment['payment_id']; ?>" <?php  if($key==0): ?>checked="checked"<?php  endif; ?>></td><td align="left" valign="top" class="text_bold" style="padding-left:3px"><?php  echo $payment['payment']; ?></td></tr><tr><td></td><td align="left" valign="top" style="color:#666; padding-left:5px;padding-bottom:10px;font-size:80%"><?php  echo nl2br(html_entity_decode($payment['description'])); ?></td></tr>        
<?php  endforeach; ?>
			</tbody></table></td>
      <td width="4%"></td>
      <td align="left" valign="top" style="padding-left:10px; padding-top:7px;" width="49%"><table cellspacing="5" cellpadding="5">
          <tbody>
          <?php  foreach($shippings as $k=>$ship): ?>
          <tr><td align="right" valign="top"><input type="radio" name="methods[shipping]" id="shipping" value="<?php  echo $ship['shipping_id']; ?>" <?php if($k==0):  ?>checked="checked"<?php  endif; ?>></td><td align="left" valign="top" class="text_bold" style="padding-left:3px"><?php  echo $ship['shipping_name']; ?></td></tr><tr><td></td><td align="left" valign="top" style="color:#666; padding-left:5px;padding-bottom:10px;font-size:80%"><?php  echo $ship['delivery_time']; ?></td></tr>
          <?php  endforeach; ?>
          </tbody></table></td>
    </tr>
  </tbody></table>
<input id="btn_paymentnextstep3" type="button" value="Lưu và tiếp tục" class="formbutton">
 <input type="hidden" name="atact" value="paymenttransfer" />
</form>
<script type="text/javascript">

jQuery('#btn_paymentnextstep3').bind('click', function () {
	jQuery('#fstep3').ajaxSubmit({
		'dataType':'json',
		'success': function (ret) {
			if(ret['error']==0){
				jQuery('#responserst3content').html(ret['html']);
				jQuery('.order_step3').removeClass('content_active').removeClass('content_hide');
			//	jQuery('.order_step4').addClass('content_active').removeClass('content_hide');
				$.get('/ajax/checkout.php?getdatastep=finish', function(data) { 		
					$('#responser_content_step4').html(data);
					jQuery('.order_step4').addClass('content_active').removeClass('content_hide');
					
				});	
			}
		}
	});			
	return false;
	});
</script>