<?php  
$html = '';

$html .= '<div style="background:#2ea7dc;color:#fff;padding:5px;"><strong>GIỎ HÀNG</strong> <a style="color:#fff" class="close" onclick="return X.boxClose();">Đóng</a>
</div>'; 

$html .='<div id="cartbox" class="cartbox" style="width:700px;height:500px;background:#fff;border:solid 5px #2ea7dc;padding:5px; overflow:auto;"> 
  <form name="cart" id="cart" action="/ajax/cart.php?action=update" method="post">
    <div id="cart_cart">
      <table class="order-table">
  <tbody><tr>
  	<th class="deal-buy-desc">No</th>
    <th class="deal-buy-desc">Deal</th>
    <th class="deal-buy-quantity">Số lượng</th>
    <th class="deal-buy-price">Đơn giá (<span class="money">đ</span>)</th>
    <th class="deal-buy-total">Thành tiền (<span class="money">đ</span>)</th>
    <th align="center" style="text-align:center">x</th>
  </tr>';
  
 // add item deal 
  foreach($carts as $cart){
$html .='<tr>
  	<td align="right" class="deal-buy-desc">1</td>
    <td class="deal-buy-desc">'.$cart['short_title'].'</td>
    <td class="deal-buy-quantity" align="right">
    <select class="input-text f-input qtysel" name="qty['.$cart['id'].']">';   
	
	for($i=1; $i<=10;$i++)
	{
		$sele = '';
		if($cart['quantity'] == $i)
			$sele = 'selected = "selected"';
		
		$html .='<option value="'.$i.'" '.$sele.' >'.$i.'</option>';
	}

$html .='</select>
    </td>
    <td class="deal-buy-price" align="right"><span id="deal-buy-price">'.$cart['team_price'].'</span></td>
    <td class="deal-buy-total" align="right" style="BORDER-RIGHT: #b1d1e6 1px solid;"><span id="deal-buy-total">'.$cart['quantity']*$cart['team_price'].'</span> 
      
      </td>
    <td align="center"><a class="ajaxlink3" href="/ajax/cart.php?action=delete&amp;team_id='.$cart['id'].'"><img src="/static/img/delete.gif"></a></td>
  </tr>';
 
  }
  
$html .='</tbody></table>
      </div>
      <div style="text-align:right;margin-top:10px;">
       <!-- <input type="button" name="commit" id="cart_commit" value="Cập nhật số lượng" class="formbutton" />
        &nbsp;-->
        <input type="button" name="clear" id="cart_clear" value="Xóa giỏ hàng" class="formbutton">
      </div>
      <div style="text-align:center;margin-top:20px;">
        <input type="button" value="Thanh Toán" class="formbutton" onclick="location.href=\'/team/checkout.php\';">
        &nbsp;
        <input type="button" value="Tiếp tục mua" class="formbutton" onclick="X.boxClose();">
      </div>
      <div style="margin-top:20px; background:#FFFFCC; border: solid 1px #6CF;padding:5px;font-size:11px;color:#666"> - Giờ đây bạn đã có thể mua nhiều voucher / sản phẩm / lần mua.<br>
        - Tiếp tục click mua, thêm, sửa, xóa voucher / SP muốn mua.<br>
        - Đến khi nào ưng ý thì click "Thanh toán" để thanh toán ĐH.<br>
        - ĐH giao toàn quốc nên mua nhiều để tiết kiệm phí vận chuyển.
    </div>
  </form>
</div>';

$html .= '<script type="text/javascript">jQuery(\'.qtysel\').change(function (){jQuery(\'#cart\').ajaxSubmit({\'success\': function (ret) {$(\'#cart_cart\').html(ret);}});return false;});
//clear cart
jQuery("#cart_clear").click(function () {
	if(confirm("Bạn có chắc muốn xóa giỏ hàng?")) {				
		$.get("/ajax/cart.php?action=clear", function(data) { $("#cart_cart").html(data);/*.fadeTo(100,0).fadeTo(1000,1);*/ });		
		setTimeout(function() { X.boxClose(); location.href=\'/index.php\'; }, 500);					
	}	
	return false
});jQuery(\'a.ajaxlink3\').bind(\'click\', function () {$.get(jQuery(this).attr(\'href\'), function(data) { $(\'#cart_cart\').html(data);});return false;});</script>';

return $html;