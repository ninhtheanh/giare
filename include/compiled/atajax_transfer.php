<?php  
//print_r($uinfo);
$city_id = (int)$uinfo['city_id'];

$dist_id = (int)$uinfo['dist_id'];
$result = GetDestID($city_id,$dist_id);

$payments = array();

if(isset($result[0]) && $result[0]>0 ){
	$destinatio_id = $result[0];
	
	$payments = DB::GetQueryResult("SELECT payment_id, adding_cost, adding_type, payment, description FROM payment_descriptions WHERE status='A' AND payment_id <> 6 AND destination LIKE('%$destinatio_id%') ORDER BY position", false);

}

 ?>

<form id="fstep3" action="/ajax/checkout.php" method="post" class="validator">
<?php  
  /*  $payments = DB::LimitQuery('payment_descriptions', array(
        'condition' =>array('status'=>'A', 'destination LIKE "%7%"'),
       'order' => 'ORDER BY position ASC',
      //  'size' => 500,
	//	'offset' => 0,
    ));
  */
 $shippings = DB::LimitQuery('shippings', array(
        'condition' =>array('status'=>'A'), //, 'shipping_id in (2,5)'
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
      <td align="left" valign="top" style="padding-left:10px; padding-top:7px;" width="49%"><table cellspacing="5" cellpadding="5">
          <tbody>
          <?php  if(!empty($payments)): ?>
         <?php  foreach($payments as $key=>$payment): ?>          
          <tr><td align="right" valign="top"><input type="radio" name="methods[payment]" id="payment" value="<?php  echo $payment['payment_id']; ?>" <?php  if($key==0): ?>checked="checked"<?php  endif; ?>></td><td align="left" valign="top" class="text_bold" style="padding-left:3px"><?php  echo $payment['payment']; ?></td></tr><tr><td></td><td align="left" valign="top" style="color:#666; padding-left:5px;padding-bottom:10px;font-size:80%"><?php  echo nl2br(html_entity_decode($payment['description'])); ?></td></tr>        
<?php  endforeach; ?>
		<?php  else: ?>
        <tr><td><div>Địa chỉ của bạn chưa xác định phương thức thanh toán.<br /> Vui lòng điều chỉnh lại hoặc liên hệ: <a href="mailto:support@cheapdeal.vn">support@cheapdeal.vn</a></div></td></tr>
        <?php  endif; ?>
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
    <div class="check-act" align="right">
  
    <input id="btn_paymentnextstep3" type="button" value="Lưu và tiếp tục" class="formbutton">   
    <input type="button" value="Hủy" id="c3c" class="formbutton" style="display:none"> 
     
  </div>
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
				jQuery('.order_step4').addClass('content_active').removeClass('content_hide');
				
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