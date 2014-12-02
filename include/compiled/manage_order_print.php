<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dealsoc.com - Giá sốc mỗi ngày</title>
<style type="text/css">
			table{
				font-family:Arial; font-size:11px; margin:0px;
			}
			@media print{
				table {page-break-after:always}
			}
			</style>
</head>
<body onLoad="alert('Press Ctr+P to print');">
<center><?php if(is_array($rs)){foreach($rs AS $index=>$one) { ?>
		<?php 
        	
        	if($one['bnote_address']!=''){
				$note_address = htmlspecialchars($one['bnote_address']).", ";
            }else{
            	$note_address = "";
            }
            $shipping_address = $note_address.htmlspecialchars($one['baddress']);
            if(ward_name($one['bdist_id'],$one['bward_id'])){
                $wardname = ward_name($one['bdist_id'],$one['bward_id']);
                $shipping_address .=", ".strip_input($wardname['ward_name']);
            }
            if(ename_dist($one['bdist_id'])){
                $dists = ename_dist($one['bdist_id']);
                $shipping_address .=", ".strip_input($dists['dist_name']);		
            }
            if(id_city($one['bcity_id'])){
                $citys = id_city($one['bcity_id']);
                $shipping_address .=", ".strip_input($citys['name']);		
            }
            $createtime = date("Y-m-d H:i:s",time());
            $subtotal = print_price(moneyit($one['origin']+$one['shipping_cost']+$one['payment_cost']));
            if($one['payment_id']==1){
                $cod = "COD<br />".$subtotal."&nbsp;<span style='font-size:60%; text-transform:none'>".$currency."</span>";	
            }else{
                $cod = "&nbsp;";	
            }
            
        ; ?>
    	<table border="0" cellspacing="1" cellpadding="1" width="650" height="450" style="margin:0px">
          <tbody>
            <tr>
              <td width="50%" height="45" align="left" valign="top"><img class="logo" src="/static/css/images/LogoConfirmOrder.jpg" height="45" alt="" /></td>
              <td width="50%" align="right" valign="top"><img src="/barcode/?barcode=<?php echo $one['id']; ?>" border="0" alt="" height="45" /></td>
            </tr>
            <tr>
              <td colspan="2" valign="top"><table width="100%" cellpadding="5" cellspacing="0" style="border-left:#000000 1px solid;border-right:#000000 1px solid;border-top:#000000 1px solid;border-bottom:#000000 1px solid;">
                  <tbody>
                    <tr>
                      <td width="85%" height="79" style="font-size:16px; font-family:Arial;border-bottom:none;"><u>FROM</u>: <strong>CHEAPDEAL TP.HỒ CHÍ MINH</strong><br>                        
                     137/5A Lê Văn Sỹ, P.13, Q.PN, Tp. HCM<br>
                        Tel: 08 3991 4018&nbsp;&nbsp;&nbsp;&nbsp;Hotline: 0934 024124</td>
                      <td width="15%" align="center" valign="top" nowrap style="font-size:22px; font-family:Georgia, 'Times New Roman', Times, serif;border-bottom:none;"><strong><?php echo $cod; ?></strong></td>
                    </tr>
                    <tr>
                      <td height="40" style="border-bottom:none;border-top:none" colspan="2" align="center"><span style="font-size:130%"><strong>Sản phẩm: </strong></span><span style="font-size:160%"><b><?php echo $teams[$one['team_id']]['short_title']; ?></b></span></td>
                    </tr>
                    <tr>
                      <td valign="bottom" style="border-bottom:none;border-top:none;" colspan="2"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                          <tbody>
                            <tr>
                              <td width="45%" align="left" valign="bottom"></td>
                              <td width="55%" align="left" valign="top"><span style="text-decoration:underline; font-size:22px; font-family:Arial">TO:</span> <span style="font-size:22px; font-family:Aria; text-transform:uppercase; font-weight:bold"><strong><?php echo $one['brealname']; ?></strong></span><br />
                              <span style="font-size:20px; font-family:Arial; font-weight:normal"><?php echo $shipping_address; ?><br />
                              Tel: <?php echo $one['bmobile']; ?></span></td>
                            </tr>
                          </tbody>
                        </table></td>
                    </tr>
            <?php if($one['payment_id']==1){?><tr>
              <td align="center" height="60" colspan="2" style="font-size:16px; font-family:Arial;border-bottom:none;border-top:none;">Vui lòng giao hàng khi người nhà đồng ý nhận và thanh toán tiền thay. Chân thành cảm ơn nhân viên PCN</td>
            </tr><?php }?><tr>
                      <td colspan="2" align="left" valign="bottom" style="border-top:#000000 0.5px solid; font-size:11px; font-family:Arial">Print at: <?php echo $createtime; ?></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
          </tbody>
        </table><?php }}?>
</center>
</body>
</html>