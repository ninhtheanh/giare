<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dealsoc.vn - Giá rẻ mỗi ngày</title>
</head>
<body>
<table cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
  <tr>
    <td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" style="width: 1px;" width="1px">
        <tr>
          <td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#FFFFFF" style="background-color:#ffffff">
              <tr>
                <td style="width: 15px;" width="15px"></td>
                <td bgcolor="#1c95c2" style="margin: 0; border-width: 0; border-style: solid; -moz-border-radius: 8px  8px  0  0; border-top-left-radius: 8px; padding: 0; border-top-right-radius: 8px; width: 100%; border-width: 5px; border-style: solid; border-color: #50bde8; background-repeat: no-repeat; border-bottom: 0; padding: 10px  10px  0  10px;"><table cellpadding="0" cellspacing="0" style="width: 700px;" width="700">
                    <tr>
                      <td bgcolor="#FFFFFF" align="left" valign="top" style="background-color: #ffffff; padding: 5px; border-bottom: 2px  solid  #f4a021; -moz-border-radius-topright: 8px; -moz-border-radius-topleft: 8px; -khtml-border-radius-topright: 8px; khtml-border-radius-topleft: 8px; -webkit-border-top-right-radius: 8px; -webkit-border-top-left-radius: 8px; border-top-right-radius: 8px; border-top-left-radius: 8px;"><table border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                          <tr>
                            <td style="width: 80px; padding-right: 10px;" width="80"><a href="http://www.dealsoc.vn/?utm_campaign=logoDealsocemail&amp;utm_medium=email&amp;utm_source=mailnewsletter&amp;utm_content=deal"target="_blank"><img src="http://email.dealsoc.vn/templates/images/logo_dealsoc.jpg"align="left" border="0" height="80" width="165" alt="Logo Dealsoc" /></a> </td>
                            <td align="right" style="font-size: 12px; -webkit-text-size-adjust: none; font-family: Arial; padding-right:5px;" valign="top"> Nếu bạn không muốn nhận email Cheapdeal hàng ngày, vui lòng <a href="<?php echo $ulink; ?>" style="text-decoration:none"><strong>click vào đây</strong></a> <br />
                              Vui lòng thêm địa chỉ <span style="color:#0000FF">newsletter@dealsoc.vn</span> vào danh bạ email của bạn để đảm bảo nhận được thông tin và đơn đặt hàng vào hộp thư.<br />
                              Thư này được gửi từ dealsoc.vn
                              <div style="margin-left:20px;font-family: Arial; color: #f39d22; font-size: 12pt; font-weight:bold;">TP Hồ Chí Minh</div></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
                  <?php if($data['tdesc'] && $data['tlink'] && $data['tfile']){?>
                  <a href="<?php echo $data['tlink']; ?>" target="_blank"><img border="0" alt="<?php echo $data['tdesc']; ?>" title="<?php echo $data['tdesc']; ?>" src="http://www.dealsoc.vn/static/<?php echo $data['tfile']; ?>" width="700" height="100" /></a>
                  <?php }?>
                  <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                      <td align="left" style="padding: 10px  10px  0px  10px; background-color: #ffffff;" valign="top" bgcolor="#FFFFFF"><table cellpadding="5" cellspacing="0" style="width: 100%;" width="100%">
                          <?php if(is_array($rs)){foreach($rs AS $index=>$one) { ?>
                          <tr style="background-color:#<?php echo ($index%2==0)?'ffffff':'ffffff';; ?>">
                            <td valign="top" align="left" width="220" style="width:220px; padding-bottom:15px;" rowspan="2">
                            <table width="252" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                  <tr>
                                <td height="1" colspan="3"><img src="http://saigonmua.vn/resources/email/bo.jpg" alt="a" width="267" height="1" hspace="0" vspace="0" /></td>
                              </tr>
                                  <tr>
                                    <td width="3"><img src="http://www.dealsoc.vn/static/img/bl.jpg" alt="a" width="3" height="200" hspace="0" vspace="0" /></td>
                                    <td width="252" align="left"><table width="252" border="0" cellpadding="0" cellspacing="0">
                                      <tbody>
                                        <tr>
                                          <td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:5px" valign="top" width="252" align="left"><a href="http://www.dealsoc.vn/<?php echo $city['slug']; ?>/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>?utm_campaign=<?php echo seo_url($one['short_title'],$one['id']); ?>&amp;utm_medium=email&amp;utm_source=mailnewsletter&amp;utm_content=Deal" style="font-family: Arial; color: #0792bd; text-decoration: none;" target="_blank"><img alt="<?php echo $one['title']; ?>" title="<?php echo $one['title']; ?>" border="0" width="252" src="http://www.dealsoc.vn/static/<?php echo $one['image']; ?>" height="190" /></a></td>
                                        </tr>
                                      </tbody>
                                    </table></td>
                                    <td width="3"><img src="http://www.dealsoc.vn/static/img/br.jpg" alt="a" width="3" height="200" hspace="0" vspace="0" /></td>
                                  </tr>
                                  <tr><td height="6" colspan="3"><img src="http://www.dealsoc.vn/static/img/bu.jpg" alt="a" width="267" height="6" hspace="0" vspace="0" /></td></tr>
                                </tbody>
                              </table>
                            </td>
                            <td align="left" style="padding-left: 10px; padding-top:5px; padding-right:10px; text-align:justify" valign="top"><a href="http://www.dealsoc.vn/<?php echo $city['slug']; ?>/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>?utm_campaign=<?php echo seo_url($one['short_title'],$one['id']); ?>&amp;utm_medium=email&amp;utm_source=mailnewsletter&amp;utm_content=Deal" style="font-family: Arial; color: #0792bd; text-decoration: none; font-size:16px;" target="_blank"><?php echo $one['title']; ?></a></td>
                            
                          </tr>
                          <tr><td align="center" style="padding-left:10px; padding-right:10px;" valign="top"><table width="90%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><div style="width:150px;padding:5px; padding-top:10px;font-weight:bold;color:#c40000; font-family:Arial; font-size:170%; white-space:nowrap" align="center"><?php echo print_price(moneyit($one['team_price'])); ?> <sup style="font-size:50%">VNĐ</sup></div></td>
                    <td align="left" valign="top"><div style="margin-top:5px;" align="center"><a href="http://www.dealsoc.vn/<?php echo $city['slug']; ?>/<?php echo seo_url($one['short_title'],$one['id'],$url_suffix); ?>?utm_campaign=<?php echo seo_url($one['short_title'],$one['id']); ?>&amp;utm_medium=email&amp;utm_source=mailnewsletter&amp;utm_content=Deal" target="_blank"><img alt="Xem chi tiết deal" border="0" src="http://www.dealsoc.vn/static/css/images/but_buynow.gif" style="font-family: Arial; color: #0792bd; text-decoration: none;" /></a></div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><div style="margin-top:3px; padding:5px;font-family:Arial; color:#666666; font-size:12px;" align="center">Giá thị trường <br /><span style="font-size:170%; font-family:Arial;font-weight:bold; "><?php echo print_price(moneyit($one['market_price'])); ?> <sup style="font-size:50%">VNĐ</sup></span></div></td>
                    <td align="left" valign="top"><div style="margin-top:3px;padding:5px;font-family:Arial; color:#666666; font-size:12px;" align="center">Tiết kiệm <br /><span style="font-size:170%; font-family:Arial;font-weight:bold; "><?php echo print_price(moneyit($one['market_price']-$one['team_price'])); ?> <sup style="font-size:50%">VNĐ</sup></span></div></td>
                  </tr>
                </table>
</td></tr><tr><td colspan="2" height="10" style="border-top:1px solid #CCCCCC; height:10px;"></td></tr>
                          <?php }}?>
                        </table>
                        <br />
                        <table cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                          <tr>
                            <td align="left" valign="top"><a
href="http://www.facebook.com/dealsochcm?utm_campaign=DealsocOnFacebook&amp;utm_medium=email&amp;utm_source=mailnewsletter&amp;utm_content=deal"
target="_blank"><img src="http://email.dealsoc.vn/templates/images/DealsocOnFacebook.jpg"
align="absmiddle" border="0" height="45" width="240" alt="Dealsoc On Facebook" /></a></td>
                            <td align="right" style="padding: 12px  2px  0  15px;"><a href="http://www.dealsoc.vn/?utm_campain=DealSoc&amp;utm_medium=email&amp;utm_source=mailnewsletter&amp;utm_content=ViewAllDeal" style="font-family: Arial; color: #0792bd; text-decoration: none;" target="_blank">Xem tất cả dealSoc tại TP Hố Chí Minh ►</a></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td height="15" bgcolor="#FFFFFF" style="background-color: #ffffff; padding: 2px  2px  2px  2px;-moz-border-radius-bottomright: 8px; -moz-border-radius-bottomleft: 8px; -khtml-border-radius-bottomright: 8px; khtml-border-radius-bottomleft: 8px; -webkit-border-bottom-right-radius: 8px; -webkit-border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; border-bottom-left-radius: 8px;height:15px">&nbsp;</td>
                    </tr>
                  </table>
                  <?php if($data['bdesc'] && $data['blink'] && $data['bfile']){?>
                  <a href="<?php echo $data['blink']; ?>" target="_blank"><img border="0" alt="<?php echo $data['bdesc']; ?>" title="<?php echo $data['bdesc']; ?>" src="http://www.dealsoc.vn/static/<?php echo $data['bfile']; ?>" width="700" height="100" /></a>
                  <?php }?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="color:#FFFFFF; font-family:Arial, Helvetica, sans-serif;font-size:11px">
                    <tr>
                      <td width="78%" align="left" valign="top" style="line-height:18px; padding-top:10px;padding-left:15px"><span style="font-size:18px;"><strong>Dealsoc.vn</strong></span><br />
                        Lầu 8, Tòa nhà Alpha Tower, 151 Nguyễn Đình Chiểu, P.6, Q.3. TPHCM<br />
                        <strong>ĐT</strong>: 84-8 73024401&nbsp;&nbsp;&nbsp;&nbsp;<strong>Fax</strong>: 84-8 39300394<br />
                        <strong>Email hỗ trợ khách hàng</strong>: <a href="mailto:support@dealsoc.vn" style="color:#f1f3f5; text-decoration:none">support@dealsoc.vn</a><br />
                        <strong>Email kinh doanh:</strong> <a href="mailto:sales@dealsoc.vn" style="color:#f1f3f5; text-decoration:none">sales@dealsoc.vn</a><br/></td>
                      <td width="22%" align="right" valign="middle"><a href="http://www.dealsoc.vn/?utm_campaign=logoDealsocemail&amp;utm_medium=email&amp;utm_source=mailnewsletter&amp;utm_content=deal"target="_blank"><img src="http://email.dealsoc.vn/templates/images/logo1.png"align="left" border="0" height="55" width="127" alt="Logo Dealsoc" /></a></td>
                    </tr>
                  </table></td>
                <td style="width: 15px;" width="15px"></td>
              </tr>
              <tr>
                <td style="width: 15px;" width="15px"></td>
                <td bgcolor="#1c95c2" height="15" style="border-bottom-left-radius: 8px; margin: 0; border-width: 0; border-style: solid; border-bottom-right-radius: 8px; -moz-border-radius: 0  0  8px  8px; padding: 0; width: 100%; border-width: 5px; border-style: solid; border-color: #50bde8; background-repeat: no-repeat; border-top: 0;height:15px;"></td>
                <td style="width: 15px;" width="15px"></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php if($ulink=='[[unsubscribe]]'){?>
<p style="visibility:hidden;" title="Web beacon">[[tracking_beacon]]</p>
<?php }?>
</body>
</html>
