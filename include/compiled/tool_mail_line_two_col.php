<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Xuất email template Cheapdeal</title>
</head>
<body>
<table cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
  <tr>
    <td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" style="width: 1px;" width="1px">
        <tr>
          <td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#FFFFFF" style="background-color:#ffffff">
              <tr>
                <td style="width: 15px;" width="15px"></td>
                <td bgcolor="#2eac1d" style="margin: 0; border-top-left-radius: 0px; padding: 0; border-top-right-radius: 0px; width: 100%;  background-repeat: no-repeat; border-bottom: 0; padding: 10px  10px  0  10px;"><table cellpadding="0" cellspacing="0" style="width: 780px;" width="780">
                    <tr>
                      <td bgcolor="#FFFFFF" align="left" valign="top" style="background-color: #ffffff; padding: 5px; -moz-border-radius-topright: 8px; -moz-border-radius-topleft: 8px; -khtml-border-radius-topright: 8px; khtml-border-radius-topleft: 8px; -webkit-border-top-right-radius: 8px; -webkit-border-top-left-radius: 8px; border-top-right-radius: 8px; border-top-left-radius: 8px; border-bottom: 2px  solid  #f4a021;"><table border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                          <tr>
                            <td style="width: 300px; padding-right: 10px;" width="300"><span style="font-size: 11px; -webkit-text-size-adjust: none; font-family: Arial; padding-left:5px; padding-right:5px">Quý khách không xem được hình ảnh, vui lòng </br>click <a href="http://www.cheapdeal.vn/?utm_campaign=emailkm-<?php echo date("m20y"); ?>&utm_medium=<?php echo date("20ymd"); ?>&utm_source=emailkm"><strong>tại đây</strong></a> để xem trực tiếp.</span>
							<a href="http://www.cheapdeal.vn/?utm_campaign=emailkm-<?php echo date("m20y"); ?>&amp;utm_medium=<?php echo date("20ymd"); ?>&amp;utm_source=emailkm&utm_content=logo-cheapdeal-mail" target="_blank"><img src="http://cheapdeal.vn/static/css/images/logo1.jpg" align="center" border="0" height="75" width="204" /></a></td>
                            <td width="485" align="right" valign="top" style="font-size: 12px; -webkit-text-size-adjust: none; font-family: Arial; padding-left:5px; padding-right:5px"><a href="http://www.cheapdeal.vn/?utm_campaign=emailkm-<?php echo date("m20y"); ?>&utm_medium=<?php echo date("20ymd"); ?>&utm_source=emailkm"><img alt="Rất tiếc! Bạn không thể xem được hình ảnh trong mail này. Click vào 'Hiển thị hình ảnh' để xem toàn bộ nội dung." src="http://cheapdeal.vn/static/banner/bannermail2.gif" width="500" height="100" /></a></td></tr></table></td>
                    </tr>
                  </table>
                  <?php if($data['tdesc'] && $data['tlink'] && $data['tfile']){?><a href="<?php echo $data['tlink']; ?>" target="_blank"><img border="0" alt="<?php echo $data['tdesc']; ?>" title="<?php echo $data['tdesc']; ?>" src="http://cheapdeal.vn/static/<?php echo $data['tfile']; ?>" width="780" height="100" /></a><?php }?>
                  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="width:100%">
                    <tr>
                      <td align="left" style="background-color: #ffffff;padding-left:10px; padding-top:5px;" valign="top" bgcolor="#FFFFFF">
					  <table cellpadding="0" cellspacing="0" border="0">
                          <?php if(is_array($rs)){foreach($rs AS $index=>$one) { ?>
                          <?php if((($index)%3==0)){?><tr><?php }?>
                          	<td align="left" valign="top" style="padding: 3px 0px; width: 244px; padding-right: 11px; padding-bottom:8px">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ebebeb" style="background-color: #ebebeb; box-shadow: 1px 2px 3px 0px #cccccc;  -moz-box-shadow: 1px 2px 3px 0px #cccccc; -webkit-box-shadow: 1px 2px 3px 0px #cccccc; ">
                          <tr>
                            <td align="left" valign="top" style="padding: 7px 7px 7px 7px; border: 1px solid #cccccc;">
                                <table border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td align="left" valign="top"><a href="http://www.cheapdeal.vn/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>?utm_campaign=emailkm-<?php echo date("m20y"); ?>&amp;utm_medium=<?php echo date("20ymd"); ?>&amp;utm_source=emailkm&utm_content=<?php echo seo_url($one['short_title'],$one['id']); ?>" style="font-family: Arial; color: #0792bd; text-decoration: none; font-size:15px; vertical-align:middle; font-weight:bold" target="_blank"><?php echo cut_string($one['short_title'],33,"[...]"); ?></a></td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top" style="padding:3px; background-color:#FFFFFF" bgcolor="#FFFFFF"><a href="http://www.cheapdeal.vn/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>?utm_campaign=emailkm-<?php echo date("m20y"); ?>&amp;utm_medium=<?php echo date("20ymd"); ?>&amp;utm_source=emailkm&utm_content=<?php echo seo_url($one['short_title'],$one['id']); ?>" style="font-family: Arial;font-size:12px; color: #fff; text-decoration: none;" target="_blank"><img  border="1" width="220" src="http://cheapdeal.vn/static/<?php echo $one['image']; ?>" height="265" /></a></td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top" style="padding-top:5px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td align="center" valign="middle" colspan="2"><span style="font-weight:bold;color:#c40000; font-family:Arial; font-size:135%; white-space:nowrap" align="center"><?php echo print_price(moneyit($one['team_price'])); ?></span> <sup style="font-size:70%; font-family:Arial">VND</sup></td><td align="right" rowspan="2">
                                        <div><a href="http://www.cheapdeal.vn/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>?utm_campaign=emailkm-<?php echo date("m20y"); ?>&amp;utm_medium=<?php echo date("20ymd"); ?>&amp;utm_source=emailkm&utm_content=<?php echo seo_url($one['short_title'],$one['id']); ?>" target="_blank"><img alt="Xem deal" width="60px" height="22px" border="0" src="http://cheapdeal.vn/static/css/images/xem.png" style="font-family: Arial; color: #0792bd; text-decoration: none;" /></a></div></td></tr><tr>
                                        <td align="center" valign="top" style="padding-right:10px"><div align="center"><span style="font-size:90%; font-family:Arial;font-weight:bold; text-decoration:line-through"><?php echo print_price(moneyit($one['market_price'])); ?></span> <sup style="font-size:50%; font-family:Arial">VND</sup></div></td></tr>
                                    </table></td>
                                  </tr>
                                </table>
                                </td></tr></table>
                      		</td><?php if((($index+1)%3==0)){?></tr><?php }?>
                      <?php }}?>
                     </table></td>
                    </tr>
                    
                    
    <?php if($resort>0){?><tr><td height="15" style="height:15px; background-color:#FFF" bgcolor="#FFFFFF"></td></tr><tr><td align="left" valign="top" bgcolor="#FFFFFF" style="background-color:#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="8%"><img src="http://cheapdeal.vn/static/css/images/logo.jpg" width="120px" height="58px" /></td>
    <td width="92%" align="left" valign="bottom"><div style="text-align: left;color:#01b0f3;text-transform: uppercase; font-size: 18px;text-shadow: #838383 1px 1px 1px; white-space:nowrap; padding-top:3px; padding-bottom:3px; padding-left:10px;border-bottom: 2px  solid  #f4a021;"><strong>Truy tìm deal hot</strong></div></td>
  </tr>
</table>
</td></tr>
                    <tr><td align="left" style="background-color: #ffffff;padding-left:10px; padding-top:5px;" valign="top" bgcolor="#FFFFFF">
                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr><td align="left" valign="top"><table cellpadding="0" cellspacing="0" border="0">
 	<?php if(is_array($rs_resort)){foreach($rs_resort AS $i=>$o) { ?>
    <?php if((($i)%3==0)){?><tr><?php }?>
    	<td align="left" valign="top" style="padding: 3px 0px; width: 244px;  padding-right: 11px; padding-bottom:8px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ebebeb" style="background-color: #ebebeb; box-shadow: 1px 2px 3px 0px #cccccc;  -moz-box-shadow: 1px 2px 3px 0px #cccccc; -webkit-box-shadow: 1px 2px 3px 0px #cccccc; ">
                          <tr>
                            <td align="left" valign="top" style="padding: 7px 7px 7px 7px; border: 1px solid #cccccc;">
                            	<table border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td align="left" valign="top"><a href="http://cheapdeal.vn/<?php echo seo_url($o['short_title'],$o['id'],$url_suffix); ?>?utm_campaign=<?php echo seo_url($o['short_title'],$o['id']); ?>&amp;utm_medium=email&amp;utm_source=mailnewsletter&amp;utm_content=deal" style="font-family: Arial; color: #0792bd; text-decoration: none; font-size:12px; vertical-align:middle; font-weight:bold" target="_blank"><?php echo cut_string($o['short_title'],33,"..."); ?></a></td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top" style="padding:3px; background-color:#FFFFFF" bgcolor="#FFFFFF"><a href="http://cheapdeal.vn/<?php echo seo_url($o['short_title'],$o['id'],$url_suffix); ?>?utm_campaign=<?php echo seo_url($o['short_title'],$o['id']); ?>&amp;utm_medium=email&amp;utm_source=mailnewsletter&amp;utm_content=deal" style="font-family: Arial; color: #0792bd; text-decoration: none;" target="_blank"><img alt="<?php echo $oo['title']; ?>"  border="0" width="220" src="http://cheapdeal.vn/static/<?php echo $o['image']; ?>" height="165" /></a></td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top" style="padding-top:5px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td align="center" valign="middle" colspan="2"><span style="font-weight:bold;color:#c40000; font-family:Arial; font-size:105%; white-space:nowrap" align="center"><?php echo print_price(moneyit($o['team_price'])); ?> <sup style="font-size:50%; font-family:Arial">VND</sup></span></td><td align="right" rowspan="2">
                                        <div><a href="http://cheapdeal.vn/<?php echo seo_url($o['short_title'],$o['id'],$url_suffix); ?>?utm_campaign=<?php echo seo_url($o['short_title'],$o['id']); ?>&amp;utm_medium=email&amp;utm_source=mailnewsletter&amp;utm_content=deal" target="_blank"><img alt="Xem deal" border="0" src="http://cheapdeal.vn/static/css/images/buy_email.gif" style="font-family: Arial; color: #0792bd; text-decoration: none;" /></a></div></td></tr><tr>
                                        <td align="center" valign="top"><div align="center"><span style="font-size:90%; font-family:Arial;font-weight:bold; text-decoration:line-through"><?php echo print_price(moneyit($o['market_price'])); ?></span> <sup style="font-size:50%; font-family:Arial">VND</sup></div></td></tr>
                                    </table></td>
                                  </tr>
                                </table>                            </td>
                          </tr>
                        </table>
                      </td><?php if((($i+1)%3==0)){?></tr><?php }?>
    <?php }}?></table>
  </td></tr>
</table></td></tr>
<?php }?>
                    
                    
                    <?php if($bestseller>0){?><tr><td height="15" style="height:15px;background-color:#FFF" bgcolor="#FFFFFF"></td></tr>
                    <tr><td align="left" valign="top" bgcolor="#FFFFFF" style="background-color:#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="8%"><img src="http://cheapdeal.vn/static/css/images/logo.jpg" width="122" height="52" /></td>
    <td width="92%" align="left" valign="bottom"><div style="text-align: left;color:#01b0f3; text-transform: uppercase;font-family: Arial; font-size: 18px;text-shadow: #838383 0px 0px 0px; white-space:nowrap; padding-top:3px; padding-bottom:3px; padding-left:10px;border-bottom: 2px  solid  #f4a021;"><strong>Sản phẩm bán chạy</strong></div></td>
  </tr>
</table>
</td>
  </tr>
                    <tr><td align="left" style="background-color: #ffffff;padding-left:10px; padding-top:5px;" valign="top" bgcolor="#FFFFFF">
                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr><td align="left" valign="top"><table cellpadding="0" cellspacing="0" border="0">
                            <?php if(is_array($rs_bestseller)){foreach($rs_bestseller AS $j=>$oo) { ?><?php if((($j)%3==0)){?><tr><?php }?>
                                            <td style="padding: 3px 0px; width: 244px;  padding-right: 11px; padding-bottom:8px">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ebebeb" style="background-color: #ebebeb; box-shadow: 1px 2px 3px 0px #cccccc;  -moz-box-shadow: 1px 2px 3px 0px #cccccc; -webkit-box-shadow: 1px 2px 3px 0px #cccccc;">
                          <tr>
                            <td align="left" valign="top" style="padding: 7px 7px 7px 7px; border: 1px solid #cccccc;">
                                                <table border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td align="left" valign="top"><a href="http://cheapdeal.vn/<?php echo seo_url($oo['short_title'],$oo['id'],$url_suffix); ?>?utm_campaign=emailkm-<?php echo date("m20y"); ?>&amp;utm_medium=<?php echo date("20ymd"); ?>&amp;utm_source=emailkm&utm_content=<?php echo seo_url($one['short_title'],$one['id']); ?>" style="font-family: Arial; color: #0792bd; text-decoration: none; font-size:14px; vertical-align:middle; font-weight:bold" target="_blank"><?php echo cut_string($oo['short_title'],33,"[...]"); ?></a></td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top" style="padding:3px; background-color:#FFFFFF" bgcolor="#FFFFFF"><a href="http://cheapdeal.vn/<?php echo seo_url($oo['short_title'],$oo['id'],$url_suffix); ?>?utm_campaign=emailkm-<?php echo date("m20y"); ?>&amp;utm_medium=<?php echo date("20ymd"); ?>&amp;utm_source=emailkm&utm_content=<?php echo seo_url($one['short_title'],$one['id']); ?>" style="font-family: Arial; color: #fff; text-decoration: none;" target="_blank"><img  border="0" width="220" src="http://cheapdeal.vn/static/<?php echo $oo['image']; ?>" height="265" /></a></td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top" style="padding-top:5px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td align="center" valign="middle"><span style="font-weight:bold;color:#c40000; font-family:Arial; font-size:14px; white-space:nowrap" align="center"><?php echo print_price(moneyit($oo['team_price'])); ?></span> <sup style="font-size:50%; font-family:Arial">VND</sup></td>
                                        <td align="center" valign="top" rowspan="2"><strong style="color:#3399ff; font-size:14px; font-family:Arial"><?php echo $oo['now_number']+$oo['pre_number']; ?></strong><br /><span style="font-size:10px; font-family:Arial">người mua</span></td><td align="right" rowspan="2"><a href="http://cheapdeal.vn/<?php echo seo_url($oo['short_title'],$oo['id'],$url_suffix); ?>?utm_campaign=emailkm-<?php echo date("m20y"); ?>&amp;utm_medium=<?php echo date("20ymd"); ?>&amp;utm_source=emailkm&utm_content=<?php echo seo_url($one['short_title'],$one['id']); ?>" target="_blank"><img alt="Xem deal" border="0" src="http://cheapdeal.vn/static/css/images/xem.png" style="font-family: Arial; color: #0792bd; text-decoration: none;" /></a></td></tr><tr>
                                        <td align="center" valign="top" style="padding-right:10px">
									<!--	<div align="center"><span style="font-size:90%; font-family:Arial;font-weight:bold; text-decoration:line-through"><?php echo print_price(moneyit($oo['market_price'])); ?></span> <sup style="font-size:50%; font-family:Arial">VND</sup></div> -->
										</td></tr>
                                    </table></td>
                                  </tr>
                                </table>                                               </td></tr></table>
                                              </td><?php if((($j+1)%3==0)){?></tr><?php }?>
                            <?php }}?></table>
                          </td></tr>
                        </table>
                        </td></tr><?php }?>
                    	<tr><td align="left" style="background-color: #ffffff;padding-left:10px; padding-top:5px;" valign="top" bgcolor="#FFFFFF">
                        <table cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                          <tr>
                            <td align="left" valign="top"><a
href="https://www.facebook.com/cheapdeal.hcm?utm_campaign=LogoFBCheapdeal&amp;utm_medium=LogoFBCheapdeal&amp;utm_source=emailkm&utm_content=<?php echo seo_url($one['short_title'],$one['id']); ?>"
target="_blank"><img src="http://cheapdeal.vn/static/img/CheapdealOnFacebook.jpg"
align="absmiddle" border="0" height="45" width="220" alt="Cheapdeal On Facebook" /></a></td>
                            <td align="right" style="padding: 0px  2px  0  15px;"><a href="http://www.cheapdeal.vn/?utm_campaign=emailkm-<?php echo date("m20y"); ?>&amp;utm_medium=<?php echo date("20ymd"); ?>&amp;utm_source=emailkm&amp;utm_content=viewalldeal" style="font-family: Arial; font-size:13px; color: #0792bd; text-decoration: none; font-weight:bold;" target="_blank">Xem tất cả khuyến mãi ►</a></td>
                          </tr></table></td></tr>
                    <tr>
                      <td height="15" bgcolor="#FFFFFF" style="background-color: #ffffff; padding: 2px  2px  2px  2px;-moz-border-radius-bottomright: 8px; -moz-border-radius-bottomleft: 8px; -khtml-border-radius-bottomright: 8px; khtml-border-radius-bottomleft: 8px; -webkit-border-bottom-right-radius: 8px; -webkit-border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; border-bottom-left-radius: 8px;height:15px"><?php if($data['bdesc'] && $data['blink'] && $data['bfile']){?>
                  <a href="<?php echo $data['blink']; ?>" target="_blank"><img border="0" alt="<?php echo $data['bdesc']; ?>" title="<?php echo $data['bdesc']; ?>" src="http://cheapdeal.vn/static/<?php echo $data['bfile']; ?>" width="780" height="100" /></a>
                  <?php }?></td>
                    </tr>
                  </table>
                  
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="color:#FFFFFF; font-family:Arial, Helvetica, sans-serif;font-size:11px">
                    <tr>
                      <td width="65%" align="left" valign="top" style="line-height:18px; padding-top:10px;color:#FFFFFF; "><span style="font-size:18px;"><strong>CheapDeal.vn</strong></span><br />
                        137/5A Lê Văn Sỹ, P.13, Q.Phú Nhuận. TPHCM<br />
                        <strong>SDT</strong>: 090.68.2311&nbsp;&nbsp;&nbsp;&nbsp;<strong>Hotline</strong>: 0934 024124<br />
                        <strong>Email hỗ trợ khách hàng</strong>: <a href="mailto:support@cheapdeal.vn" style="color:#f1f3f5; text-decoration:none">support@cheapdeal.vn</a><br />
                      </td>
                      <td width="35%" align="left" valign="middle" style="white-space:nowrap;color:#FFFFFF; "><span style="font-size:17px;"><strong>CheapDeal.vn cam kết: </strong></span><br />
                        <span style="font-size:11px;"><strong>- Đảm bảo hàngchất lượng<br />
                      - Giá rẻ nhất thị trường<br />
                      - Chế độ bảo hành - hậu mãi tốt<br />
                      - Giao hàng nhanh chóng</strong><br /></span>
					 <!-- <a href="http://www.cheapdeal.vn/?utm_campaign=logocheapdealemail&amp;utm_medium=email&amp;utm_source=mailnewsletter&amp;utm_content=deal"target="_blank">
					  <img src="http://cheapdeal.vn/static/css/images/logo.png" border="0" height="55" width="127" alt="Logo Cheapdeal" /></a>
					  <br />Giá cả mang bạn đến, chất lượng giữ chân bạn
					  --></td>
                    </tr>
					<td colspan="2" align="center">
					  <br />
					  Bạn nhận được thư này là do địa chỉ email đã được đăng ký thành viên Cheapdeal.<br />
Để ngưng không nhận email thông báo các khuyến mãi từ Cheapdeal, <a href="mailto:cheapdeal.cs@gmail.com?subject=Unsubcribe" style="color:#f1f3f5; text-decoration:none" >vui lòng click vào đây (unsubscribe)</a></td>
					
                  </table></td>
				  
              </tr>
              <tr>
                <td style="width: 15px;" width="15px"></td>
                <td bgcolor="#2eac1d" height="15" style="border-bottom-left-radius: 0px; margin: 0; border-bottom-right-radius: 0px; -moz-border-radius: 0  0  8px  8px; padding: 0; width: 100%; <!--border-width: 5px; border-style: solid; border-color: #2eac1d; --> background-repeat: no-repeat; border-top: 0;height:15px;"></td>
                <td style="width: 15px;" width="15px"></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php if($ulink=='[[unsubscribe]]'){?>

<?php }?>
</body>
</html>
