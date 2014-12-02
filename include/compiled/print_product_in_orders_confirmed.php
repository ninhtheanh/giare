<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dealsoc.vn - In Danh sách lấy hàng</title>
<body>
<center>
    <table width="780" cellpadding="2" >
      <tr>
        <td width="41%" align="left"><a href="javascript:window.print();">PRINT</a>&nbsp;&nbsp; </td>
        <td width="59%" align="right"></td>
      </tr>
    </table>
  	<table width="820" border="1" cellpadding="2" cellspacing="0" style=" border:#000000 1px #000000; border-collapse:collapse">
    <tr>
                <td colspan="2" align="left" style="border-bottom:#CCC 1px solid; border-right:none"><a href="http://<?php echo $INI['system']['sitename']; ?>" target="_blank"><img src="/static/css/images/LogoConfirmOrder.jpg" border="0" width="145" height="60" /></a></td><td colspan="5" align="right" valign="top" style="border-bottom:#CCC 1px solid; border-left:none"><div  style="color:#1d94bf; font-size:15px; font-family:Arial, Helvetica, sans-serif;font-weight:bold; padding-right:10px; padding-top:5px; padding-bottom:5px">CHEAPDEAL TP.HỒ CHÍ MINH</div>
                <div  style="padding-right:10px;font-size:12px; font-family:Arial, Helvetica, sans-serif;padding-bottom:5px;">137/5A Lê Văn Sỹ, P.13, Q.Phú Nhuận, Tp. HCM</div><div style="padding-right:10px;font-size:12px; font-family:Arial, Helvetica, sans-serif;padding-bottom:5px;"><strong>Tel:</strong> 08 3991 4018 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Hotline:</strong> 0934 024124</div></td>
              </tr>
    
    <tr>
      <td colspan="10" height="35"><div style=" text-align:right; margin:3px; float:right">Ngày in: <strong><?php echo $date_print_show; ?></strong></div>
        <h2 style=" margin:3px; padding:0; text-align:center">Danh sách sản phẩm cần lấy hàng</h2>
      </td>
    </tr>
    <tr bgcolor="#c0c0c0" height="25">
      <td align="center" width="20"><b>Stt</b></td>
      <td align="center" width="30"><b>Mã SP</b></td>
      <td align="center" width="570"><b>Tên SP</b></td>
      <td align="center" width="80" nowrap><b>Loại</b></td>
      <td align="center" width="20"><b>SL</b></td>
      <td align="center" width="100" nowrap><b>Thực nhận</b></td>
    </tr>
    <?php if(is_array($ds)){foreach($ds AS $index=>$one) { ?>
    <tr height="25">
      <td align="center"><?php echo $index+1; ?></td>
      <td align="center"><?php echo $one['team_id']; ?></td>
      <td><?php echo $one['short_title']; ?> <?php echo showColorSize($one); ?></td>
      <td><?php if($one['delivery_properties']==0){?>Voucher<?php } else { ?>Sản phẩm<?php }?></td>
      <td align="center"><?php echo $one['quantity']; ?></td>
      <td align="center">&nbsp;</td>
    </tr>
     <?php }}?>
    <tr>
      <td colspan="10" height="50"><p align="right">Tổng cộng có&nbsp; <strong><?php echo $total_print; ?></strong> sản phẩm</p></td>
    </tr>
  </table>
</center>
</body>
</html>
