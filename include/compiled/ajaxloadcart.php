 <table class="order-table">
  <tbody><tr>
  	<th class="deal-buy-desc">No</th>
    <th class="deal-buy-desc">Deal</th>
    <th class="deal-buy-quantity">Số lượng</th>
    <th class="deal-buy-price">Đơn giá (<span class="money">đ</span>)</th>
    <th class="deal-buy-total">Thành tiền (<span class="money">đ</span>)</th>
    <th align="center" style="text-align:center">Xoá</th>
  </tr>
  

<?php    
//print_r($carts);
foreach($carts as $key=>$cart){ 
$limit_user = Table::Fetch('team', $cart['id']);
$countlimit = abs(intval($limit_user['per_number']));
$loop = ($countlimit==0)?10:$countlimit;
?>
<tr>
  	<td align="right" class="deal-buy-desc">1</td>
    <td class="deal-buy-desc">
		<?php  echo $cart['short_title'];?>.
        <?php echo showColorSize($cart); ?>
    </td>
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
    </td>
    <td class="deal-buy-price" align="right"><span id="deal-buy-price"><?php  echo print_price(moneyit($cart['team_price'])); ?></span></td>
    <td class="deal-buy-total" align="right" style="BORDER-RIGHT: #b1d1e6 1px solid;"><span id="deal-buy-total"><?php  echo print_price(moneyit($cart['quantity']*$cart['team_price'])); ?></span> 
      
      </td>
    <td align="center"><a class="ajaxlink3" href="/ajax/cart.php?action=delete&amp;team_id=<?php  echo $cart['id']; ?>"><img src="/static/img/delete.gif"></a></td>
  </tr>
 
  <?php  } ?>
  
</tbody></table>
<script type="text/javascript">jQuery('.qtysel').change(function (){jQuery('#cart').ajaxSubmit({'success': function (ret) {$('#cart_cart').html(ret); loadcartajax();}});return false;});jQuery('a.ajaxlink3').bind('click', function () {$.get(jQuery(this).attr('href'), function(data) { $('#cart_cart').html(data); loadcartajax();});return false;});

jQuery('#cart_clear').bind('click',function(){
	if(confirm("Bạn có chắc muốn xóa giỏ hàng?")) {				
		$.get("/ajax/cart.php?action=clear", function(data) { $("#cart_cart").html(data); loadcartajax(); });		
		setTimeout(function() { X.boxClose() }, 500);					
	}	
	return false
});

</script>