<table class="order-table">
<thead>
  <tr>
    <th class="deal-buy-desc">Deal</th>
    <th class="deal-buy-quantity">Số lượng</th>
    <th class="deal-buy-price">Giá (<span class="money">đ</span>)</th>
    <th class="deal-buy-total">Tiền (<span class="money">đ</span>)</th>    
  </tr>
  </thead>
 <tbody>  
  <?php 
 
  
 $thanhtien = 0; 
 $phivanchuyen = 0;
$tongcong = 0;

$paymentshiping = Session::Get('paymentshipping');
if($paymentshiping){
  $payment = (int)$paymentshiping['payment'];
  $dbpayment = DB::LimitQuery('payment_descriptions', array(
			'condition' => array('status'=>'A', 'payment_id'=>$payment),
			'one' => true,
		));
	$phivanchuyen = moneyit($dbpayment['adding_cost']);
}
  
/*  if(isset($infotransfer['city_id']) && $infotransfer){
	if($infotransfer['city_id'] != 11){
    	$phivanchuyen = 25000;
    }
}  */
    foreach($carts as $cart){ ?>
                <tr>
                <td class="deal-buy-desc">
					<?php echo $cart['short_title']; ?>
                	<?php echo showColorSize($cart); ?>					
                </td>
                <td class="deal-buy-quantity" align="right">
                <?php  echo $cart['quantity']; ?>
                </td>
                <td class="deal-buy-price" align="right"><span id="deal-buy-price"><?php echo print_price(moneyit($cart['team_price'])); ?></span></td>
                <td class="deal-buy-total" align="right" style="BORDER-RIGHT: #b1d1e6 1px solid;"><span id="deal-buy-total">
                <?php  $tt =  $cart['quantity']*$cart['team_price']; 
                	$thanhtien = $thanhtien + $tt;
                echo print_price(moneyit($tt));
                ?></span> 
                  
                  </td>
              </tr>
            <?php  } ?>
            
            
<tr class="order-total" bgcolor="#FDFA9D">
    <td colspan="4" class="deal-buy-total" style="text-align:right;BORDER-LEFT: #b1d1e6 1px solid;BORDER-BOTTOM: #b1d1e6 1px solid;"><strong>Thành tiền (đ) : <?php echo print_price(moneyit($thanhtien)); ?></strong></td>
  </tr>
  <?php  
  $tongcong = $thanhtien + $phivanchuyen;
   ?>
<!--<tr class="order-total" bgcolor="#FDFA9D">
    <td colspan="4" class="deal-buy-total" style="text-align:right;BORDER-LEFT: #b1d1e6 1px solid;BORDER-BOTTOM: #b1d1e6 1px solid;"><strong>Phí vận chuyển (đ) : <?php echo print_price(moneyit($phivanchuyen)); ?></strong></td>
  </tr>
<tr class="order-total" bgcolor="#FDFA9D">
    <td colspan="4" class="deal-buy-total" style="text-align:right;BORDER-LEFT: #b1d1e6 1px solid;BORDER-BOTTOM: #b1d1e6 1px solid;"><strong>Thành tiền (đ) : <?php echo print_price(moneyit($tongcong)); ?></strong></td>
  </tr>
  -->
  
</tbody></table>

<div style="margin-top:20px; background:#FFFFCC; border: solid 1px #6CF;padding:5px;font-size:13px;">Miễn phí giao hàng nội thành TPHCM.<br>Cước vận chuyển đến các tỉnh thành là 30.000đ cho các đơn hàng dưới 500g và cộng thêm 5.000đ cho mỗi 500g tiếp theo.<br>
Đơn hàng từ 2 sản phẩm trở lên sẽ được miễn phí giao hàng tỉnh
<br>Thời gian giao hàng 3-6 ngày làm việc tùy theo khu vực. Hàng hóa sẽ được giao tận tay người nhận qua đường bưu điện.</div>

<div style="margin-top:20px;font-size:13px;"><strong>Ghi chú:</strong> ( ghi chú nhận hàng, màu sắc, kích cỡ, kiểu dáng... )</div></br>

<form id="fstep4" name="fstep4" action="/ajax/checkout.php" method="post" class="">
<div>
<textarea name="remark" id="remark" class="f-input" style="width:98%;height:80px;"><?php  echo $cl; ?></textarea></div>
<div style="margin-top:10px;" align="center"><input style="width:110;height:60px;" name="f4submit" id="btn_submit_finish" type="submit" value="Đặt Hàng" class="formbutton"></div>
 <input type="hidden" name="atact" value="endstep4" />
</form>
<script type="text/javascript">

jQuery('#btn_submit_finish').bind('click', function () {
	jQuery('#fstep4').ajaxSubmit({
		'dataType':'json',
		'success': function (ret) {
			if(ret['error']==0){
				window.location = '/thanhcong.php';
			}else if(ret['error']==1){
				alert(ret['msg']);
				return;
			}else if(ret['error']==2){
				alert(ret['msg']);
				window.location = '/<?php echo $city['slug']; ?>';
				return;
			}
		}
	});			
	return false;
	});
</script>