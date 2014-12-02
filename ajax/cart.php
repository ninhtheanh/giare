<?php  
require_once(dirname(dirname(__FILE__)) . '/app.php');

$action = strval($_GET['action']);
$carts = Session::Get('carts');

switch($action)
{
	case "update":
		$qtys = $_POST['qty'];
		foreach($qtys as $key=>$qty){
			if(isset($carts[$key])){
				$carts[$key]['quantity'] = $qty;
			}
		}
		
		Session::Set('carts',$carts);
		echo render('ajaxloadcart');
	break;
	case "clear":
		Session::Set('carts',array());
		echo '<span class="cart_empty">Không có sản phẩm trong giỏ hàng.</span>';
		return;
	break;
	case "delete":
		$team_id = (int)strval($_GET['team_id']);
		if(isset($carts[$team_id])){
			unset($carts[$team_id]);
		}
		Session::Set('carts',$carts);
		echo render('ajaxloadcart');
	break;
	case "show":
		$arr = array(
				'error'=>0,
				'data'=>array('data'=>'','type'=>'dialog'),
		);
		

		$html = render('ajaxshowcart');

		$arr['data']['data'] = $html;
		echo json_encode($arr);
		return;
	break;
	case "deleteAll":
		Session::Set('carts',null);
		echo render('ajaxloadcart');
	break;
	default:
		echo  render('ajaxloadcart');
	break;
}





$html = '';
/*  
$html .='
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
  
$html .='</tbody></table>';
$html .= '<script type="text/javascript">jQuery(\'.qtysel\').change(function (){jQuery(\'#cart\').ajaxSubmit({\'success\': function (ret) {$(\'#cart_cart\').html(ret);}});return false;});jQuery(\'a.ajaxlink3\').bind(\'click\', function () {$.get(jQuery(this).attr(\'href\'), function(data) { $(\'#cart_cart\').html(data);});return false;});</script>';  */

echo $html;
?>