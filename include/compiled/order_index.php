<?php include template("header");?>

<style>
.infotitle{background: #f8f8f8;
  background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#f4f4f4), to(#fcfcfc));
  background: -webkit-linear-gradient(top, #fcfcfc, #f4f4f4);
  background: -moz-linear-gradient(top, #fcfcfc, #f4f4f4);
  background: -ms-linear-gradient(top, #fcfcfc, #f4f4f4);
  background: -o-linear-gradient(top, #fcfcfc, #f4f4f4);
height: 43px;
color: #000;
font-weight: bold;
padding-left: 14px;
line-height: 38px;}
.atbox-setting{margin-top: 0px;margin-left: 39px;width: 84%;}

</style>
<div id="bdw" class="bdw">
  <div id="bd" class="cf">
    <div id="learn">
      <div class="subdashboard" id="dashboard">
        <ul>
        
        </ul>
      </div>
      <div id="content" class="mainwide">
        <div class="box">
        <table width="100%" style="margin-top:8px; margin-bottom:20px;">
        	<tr>
            	<td valign="top" style="width:230px;">
                	
                    <?php include template("menutaikhoan");?>
                    
                </td>
                <td valign="top">
                	<div class="atbox-setting_order">
                		<div>
            <div style="background-color:#FFFFFF;min-height:500px;_height:500px">
            	<div style="color:rgb(139, 207, 6); font-size:18px; text-align:left; padding: 0px 6px 20px 10px"><strong>Lịch sử mua hàng</strong></div>
	           <div align="left" style="padding:10px; padding-top:0px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tbody>
                    
                    <tr>
                      
                      <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0" class="order-table">
                          <tbody>
                            <tr>
                            <th align="center" width="20" nowrap="nowrap">Mã GH</th>
                              <th align="center" width="20" nowrap="nowrap">Mã ĐH</th>
                              <th align="center" width="500">Tên Deal</th>
                              <th align="center" width="50">Ngày Mua</th>
                              <th align="center" width="20">SL</th>
                              <th align="center" width="50">Đơn Giá</th>
                              <th align="center" width="60">Thành Tiền</th>
                              <th align="center" width="60">Phí </p>thanh toán</th>
                              <?php  /*  <th align="center" width="60">Phí thanh toán</th>  */ ?>
                              <th align="center" width="60">Tổng Tiền</th>
                              <?php  /*  <th align="center" width="90">Số dư tài khoản</th>  */ ?>
                              
                              <th align="center" width="110" nowrap="nowrap">Trạng thái</th>
                            </tr>
                            <?php if(is_array($orders)){foreach($orders AS $index=>$one) { ?> 
                            <?php 
                	
                    $maso = DB::GetQueryResult("SELECT maso FROM masoduthuong WHERE order_id=".$one['id']." AND team_id=".$one['team_id']." AND user_id=".$login_user['id']);
              
                   $his = DB::GetQueryResult("SELECT * FROM order_history WHERE order_id=".$one['id']." AND status_code NOT IN ('changed') GROUP BY status_code ORDER BY date DESC, order_id",false);
                   /* $his = DB::LimitQuery('order_history', array(
                        'condition' => array('order_id' => $one['id'],'status_code NOT IN ("changed")'), 
                        'order' => 'ORDER BY date DESC,order_id',
                    ));*/
                ; ?> 
                            <?php $status_color = getStatusColor($one['state']);$status_name=getStatusName($one['state']);; ?>
                            
                            <tr bgcolor="#<?php echo $status_color; ?>">
                            	<td align="center" style="font-size: 20px;color:#fff;background:<?php echo toColor($one['create_time']+$one['user_id']); ?>"><strong><?php echo  $one['order_group']; ?></strong></td>
                              <td align="center" <?php if($maso['maso']>0){?>rowspan=2<?php }?> ><strong><?php echo $one['id']; ?></strong></td>
                              <td align="left"><a class="deal-title" href="/<?php echo $city['slug']; ?>/<?php echo seo_url($teams[$one['team_id']]['short_title'],$one['team_id'],$url_suffix); ?>" target="_blank"><strong><?php echo $teams[$one['team_id']]['product']; ?></strong></a>
                              
                              <?php echo showColorSize($one); ?>
                              <br />
                                
                                <?php if ($one['note_address']!=''){$note_address = $one['note_address'].", ";}else{$note_address="";}; ?> 
                                <?php echo $note_address; ?><?php echo $one['address']; ?>, 
                                <?php if(wardname($one['dist_id'],$one['ward_id'])){?> 
                                <?php $wardname = wardname($one['dist_id'],$one['ward_id']); ?> 
                                <?php echo $wardname['ward_name']; ?>, 
                                <?php }?> 
                                <?php if(ename_dist($one['dist_id'])){?> 
                                <?php $dists = ename_dist($one['dist_id']); ?> 
                                <?php echo $dists['dist_name']; ?> 
                                <?php }?> 
                                <br /><?php if($one['remark'] || $one['remark2'] || $one['notes']){?><span style="color:#EF2544"><strong>Ghi chú:</strong> <?php echo $one['remark']; ?> - <?php echo $one['remark2']; ?> - <?php echo $one['notes']; ?></span><?php }?></td>
                              <td align="center"><?php echo date('d/m/Y H:i:s',$one['create_time']); ?></td>
                              <td align="center" <?php if($maso['maso']>0){?>rowspan=2<?php }?>><?php echo $one['quantity']; ?></td>
                              <td align="center" <?php if($maso['maso']>0){?>rowspan=2<?php }?>><?php echo print_price(moneyit($one['price'])); ?></td>
                              <td align="center" <?php if($maso['maso']>0){?>rowspan=2<?php }?>>
<?php echo print_price(moneyit($one['origin'])); ?></td><td align="center" <?php if($maso['maso']>0){?>rowspan=2<?php }?>>
                              <?php echo print_price(moneyit($one['shipping_cost'])); ?></td>
                              <?php  /*  <td align="center" <?php if($maso['maso']>0){?>rowspan=2<?php }?>>
                   <?php echo print_price(moneyit($one['payment_cost'])); ?></td>  */ ?>
                              
                              
                              
                              
                              <td align="center" <?php if($maso['maso']>0){?>rowspan=2<?php }?>>
                              <?php $sub_total = $one['origin']+ $one['shipping_cost'] + $one['payment_cost'];; ?><?php echo print_price(moneyit($sub_total)); ?></td><?php  /*  <td align="center" <?php if($maso['maso']>0){?>rowspan=2<?php }?>><?php if($login_user['money']>0){?> 
                                <?php echo print_price(moneyit($login_user['money'])); ?> 
                                <?php } else { ?>0<?php }?></td>  */ ?>
                              <td align="center" <?php if($maso['maso']>0){?>rowspan=2<?php }?> style="font-weight:bold" id="td_<?php echo $one['id']; ?>"><?php if($one['team_id']==$id_promotion){?>Đã tham gia<?php } else { ?><?php echo $status_name; ?><?php }?><?php if($one['state']=='unpay'){?><a href="/team/buy.php?id=<?php echo $one['team_id']; ?>&edit=true"><br />
                              &raquo; Sửa ĐH</a><br /><a href="/order/view.php?id=<?php echo $one['id']; ?>"><b>&raquo; Chi tiết</b></a>
							  <br /><a href="/order/unorder.php?id=<?php echo $one['id']; ?>" onClick="if(confirm('Bạn có chắc xóa đơn hàng này?')!=true){return false;}"><b>&raquo; Hủy ĐH</b></a><?php } else { ?><br /><b><a href="/order/view.php?id=<?php echo $one['id']; ?>"><b>&raquo; Chi tiết</b></a><?php }?>
                              </td>
                            </tr>
                            
                <?php if($maso['maso']>0){?>
                <tr bgcolor="#<?php echo $status_color; ?>"><td valign="top" align="left" style="padding-top:12px;" colspan="2"><strong>Mã số dự thưởng</strong><span colspan="9" style="font-size:20px; font-family:Arial; color:#c40000; font-weight:bold">&nbsp;<?php echo $maso['maso']; ?></span></td></tr><?php }?>
                            <?php }}?>
                          </tbody>
                        </table>
                        <div><?php echo $pagestring; ?></div>
                       
                      </td>
                      
                    </tr>
                   
                  </tbody>
                </table>
              </div>
            </div>
          </div>
                    </div>
           		</td>
            </tr>
            <tr>
            	<td colspan="2">
                <div style="border:1px solid #ccc; padding:10px;">
                 <div align="left" style="padding-left:20px; padding-bottom:10px;padding-top:10px;">
                          <ul>
                            <strong>Chú thích trạng thái đơn hàng:</strong>
                            <li style="padding-left:15px;">- <strong style="color:#c40000">Đã xác nhận:</strong> Đã được xác nhận từ <?php echo $INI['system']['abbreviation']; ?>. <?php echo $INI['system']['abbreviation']; ?> đang lên kế hoạch giao hàng.</li>
                            <li style="padding-left:15px;">- <strong style="color:#c40000"> Đang giao hàng:</strong> <?php echo $INI['system']['abbreviation']; ?> đang trên đường giao.</li>
                            <li style="padding-left:15px;">- <strong style="color:#c40000"> Giao không thành công:</strong> Nhân viên của <?php echo $INI['system']['abbreviation']; ?> đã đi giao hàng nhưng vì nhiều lý do khác nhau nên chưa giao kịp cho quý khách. <?php echo $INI['system']['abbreviation']; ?> sẽ lên kế hoạch giao hàng vào hôm khác.</li>
                            <li style="padding-left:15px;">- <strong style="color:#c40000"> Đã giao:</strong> Đã giao voucher/hàng hoá cho khách hàng.</li>
                            <li style="padding-left:15px;">- <strong style="color:#c40000"> Hủy bởi khách hàng:</strong> Đơn hàng bạn đã đặt mua tại <?php echo $INI['system']['abbreviation']; ?> đã được hủy, nếu bạn không yêu cầu hủy đơn hàng vui lòng liên hệ <strong>08 3991 4018</strong> để được giải đáp.
</li><li style="padding-left:15px;">- <strong style="color:#c40000"> Hủy bởi Cheapdeal:</strong> Đơn hàng bạn đã đặt mua tại <?php echo $INI['system']['abbreviation']; ?> đã được hủy với nhiều lý do như: hết hạn giao hàng, deal không đạt được số người mua tối thiểu,...</li>
                          </ul>
                          <ul>
                            <strong>Ghi chú:</strong>
                            <li style="padding-left:15px;"><strong style="color:#c40000; font-weight:normal">Tất cả các đơn hàng đã được giao cho bộ phận giao hàng, sau 3 lần đi giao mà không giao được thì <?php echo $INI['system']['abbreviation']; ?> sẽ tự động hủy đơn hàng đó. Nếu bộ phận giao hàng của <?php echo $INI['system']['abbreviation']; ?> không liên hệ với quý khách sau 3 lần giao, vui lòng liên hệ <strong>08 3991 4018</strong> để thông báo với <?php echo $INI['system']['abbreviation']; ?> về tình trạng đơn hàng. <?php echo $INI['system']['abbreviation']; ?> luôn trân trọng sự góp ý của khách hàng để <?php echo $INI['system']['abbreviation']; ?> phục vụ quý khách hàng ngày một tốt hơn</li>
                          </ul>
                        </div>
                        <div style="margin-top:10px; color: rgb(102, 102, 102); font-weight: normal; line-height: 22px;" align="left"> - Bạn cần đem theo phiếu (voucher/hàng hoá) của <strong>Cheapdeal</strong> đến nơi cung cấp sản phẩm/dịch vụ để  nhận được sản phẩm/dịch vụ giảm giá.<br />
                          - Thời gian giao hàng dự kiến: Từ 3- 5 ngày không tính thứ 7 & CN.<br />
                          - Quyền lợi của khách hàng là trách nhiệm của <strong>Cheapdeal</strong>. Khi nhận phiếu/hàng vui lòng ký vào biên bản xác nhận của nhận viên giao hàng. <strong>Cheapdeal</strong> sẽ không chịu trách nhiệm bất cứ khiếu nại nào nếu không có chữ ký của khách hàng trong biên bản xác nhận.</div>
                         </div>
                </td>
            </tr>
            </table>    
        
          
          <div class="box-bottom"></div>
        </div>
      </div>
    </div>
  </div>
  <!-- bd end -->
</div>
<!-- bdw end -->
<?php include template("footer");?>