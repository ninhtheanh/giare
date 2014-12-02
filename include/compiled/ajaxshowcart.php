<div style="background:#2ea7dc;color:#fff;padding:5px;"><strong>GIỎ HÀNG</strong> <a style="color:#fff" class="close" onclick="return X.boxClose();">Đóng</a>
</div>
<div id="cartbox" class="cartbox" style="width:700px;height:500px;background:#fff;border:solid 5px #2ea7dc;padding:5px; overflow:auto;"> 
  <form name="cart" id="cart" action="/ajax/cart.php?action=update" method="post">
<div id="cart_cart">
<?php 
echo render('ajaxloadcart');
 ?>
<?php /* 
 <table class="order-table">
  <tbody><tr>
  	<th class="deal-buy-desc">No</th>
    <th class="deal-buy-desc">Deal</th>
    <th class="deal-buy-quantity">Số lượng</th>
    <th class="deal-buy-price">Đơn giá (<span class="money">đ</span>)</th>
    <th class="deal-buy-total">Thành tiền (<span class="money">đ</span>)</th>
    <th align="center" style="text-align:center">Xoá</th>
  </tr>
  

<?php    foreach($carts as $key=>$cart){ 

$limit_user = Table::Fetch('team', $cart['id']);
$countlimit = abs(intval($limit_user['per_number']));
$loop = ($countlimit==0)?10:$countlimit;
?>
<tr>
  	<td align="right" class="deal-buy-desc">1</td>
    <td class="deal-buy-desc"><?php  echo $cart['short_title'] ?></td>
    <td class="deal-buy-quantity" align="right">
    <select class="input-text f-input qtysel" name="qty[<?php  echo $cart['id']; ?>]" style="width: 53px;">  
	
	<?php  for($i=1; $i<=$loop;$i++)
	{
		$sele = '';
		if($cart['quantity'] == $i)
			$sele = 'selected = "selected"';
		 ?>
		<option value="<?php  echo $i; ?>" <?php  echo $sele; ?> ><?php  echo $i; ?></option>
	<?php  } ?>

	</select>
    <?php var_dump(); ?>
    </td>
    <td class="deal-buy-price" align="right"><span id="deal-buy-price"><?php  echo print_price(moneyit($cart['team_price'])); ?></span></td>
    <td class="deal-buy-total" align="right" style="BORDER-RIGHT: #b1d1e6 1px solid;"><span id="deal-buy-total"><?php  echo print_price(moneyit($cart['quantity']*$cart['team_price'])); ?></span> 
      
      </td>
    <td align="center"><a class="ajaxlink3" href="/ajax/cart.php?action=delete&amp;team_id=<?php  echo $cart['id']; ?>"><img src="/static/img/delete.gif"></a></td>
  </tr>
 
  <?php  } ?>
  
</tbody></table>
 */ ?>
 </div>
      <div style="text-align:right;margin-top:10px;">
       <!-- <input type="button" name="commit" id="cart_commit" value="Cập nhật số lượng" class="formbutton" />
        &nbsp;-->
        <input type="button" name="clear" id="cart_clear" value="Xóa giỏ hàng" class="formbutton">
      </div>
      <div style="text-align:center;margin-top:20px;">
        <input type="button" value="Thanh Toán" class="formbutton" onclick="location.href='/team/checkout.php'">
        &nbsp;
        <input type="button" value="Tiếp tục mua" class="formbutton" onclick="X.boxClose();">
      </div>
	  </br>
      <div style="margin-top:20px; background:#FFFFCC; border: solid 1px #6CF;padding:5px;font-size:13px;color:#666"> - Giờ đây bạn đã có thể mua nhiều voucher / sản phẩm / lần mua.<br>
        - Tiếp tục click mua, thêm, sửa, xóa voucher / SP muốn mua.<br>
        - Đến khi nào ưng ý thì click "Thanh toán" để thanh toán ĐH.<br>
        - ĐH giao toàn quốc nên mua nhiều để tiết kiệm phí vận chuyển.
    </div>
  </form>
</div>
<script type="text/javascript">jQuery('.qtysel').change(function (){jQuery('#cart').ajaxSubmit({'success': function (ret) {$('#cart_cart').html(ret); loadcartajax();}});return false;});jQuery('a.ajaxlink3').bind('click', function () {$.get(jQuery(this).attr('href'), function(data) { $('#cart_cart').html(data); loadcartajax();});return false;});

jQuery('#cart_clear').bind('click',function(){
	if(confirm("Bạn có chắc muốn xóa giỏ hàng?")) {				
		$.get("/ajax/cart.php?action=clear", function(data) { $("#cart_cart").html(data); loadcartajax(); });		
		setTimeout(function() { X.boxClose() }, 500);					
	}	
	return false
});

</script>