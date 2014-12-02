<?php include template("manage_header");?>

<div id="bdw" class="bdw">
  <div id="bd" class="cf">
    <div id="coupons">
      <div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_order('confirmed'); ?>
        </ul>
      </div>
      <div id="content" class="coupons-box clear mainwide">
        <div class="box clear">
          <div class="subbox-top"><div class="subhead">
              <h2>Đơn hàng đã xác nhận</h2>
            </div></div>
          <div class="box-content">         
              <form method="get" id="target">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="filter-table">
                  <tr>
                    <td align="left" colspan="2" style="padding-top:3px; padding-left:3px;"><strong>Số HĐ</strong>
                      <input type="text" name="id" value="<?php echo $id; ?>" class="h-input"/>
                      &nbsp;&nbsp;<strong>Số Deal</strong>
                      <input type="text" name="team_id" class="h-input number" value="<?php echo $team_id; ?>" />
                      &nbsp;&nbsp;<strong>User</strong>
                      <input type="text" name="uemail" class="h-input" value="<?php echo htmlspecialchars($uemail); ?>" />
                      &nbsp;&nbsp;<strong>ĐTDĐ</strong>
                      <input type="text" class="h-input" name="mobile" value="<?php echo $mobile; ?>" />&nbsp;&nbsp;<strong>TP</strong>                      <select name="city_id" class="h-input" require="true" onchange="$('#target').submit();">
                          <option value='0'>--Chon--</option>
                          <?php echo Utility::Option(Utility::OptionArray($allcities,'id','name'),$city_id); ?>
                        
                      </select></td></tr><tr><td colspan="4" style="padding-left:10px;"><strong>SL ĐH bàn giao: </strong><select name="slbg" id="slbg" class="h-input" require="true" onchange="$('#target').submit();">
                    <option value='120'>120</option>
                    <option value='100'>100</option>
                    <option value='80'>80</option>
                    <option value='60'>60</option>
                    <option value='40'>40</option>
                  </select><script type="text/javascript">$("#slbg").val(<?php echo $slbg_filter; ?>)</script>&nbsp;Payment<select name="payment_id" id="payment_id" class="h-input" require="true">
                            <option value='0'>--Chon--</option>
                            <?php echo LoadPaymentMethod(); ?>
                            </select> 
                            <script type="text/javascript">document.getElementById('payment_id').value = '<?php echo $payment_id; ?>'</script>&nbsp;<input type="submit" value=" Lọc dữ liệu " class="formbutton"  style="padding:3px 6px;"/>
</td>
                  </tr>
		          </table>
              </form>
            <script language="javascript">
				function checkForm(){					
					ischecked = false;
					for(i=1;i<document.f_delivery.orderid.length;i++){
						obj=document.getElementById(document.f_delivery.orderid[i].value);
						if(obj.checked==true){
							ischecked=true;
							break;
						}
					}		
					if(!ischecked){
						alert("Vui lòng chọn một hoặc nhiều đơn hàng để xử lý...");
						return false;
					}
					if(!confirm("Bạn muốn tiếp nhận các đơn hàng đã chọn để xử lý???")){			
						return false;
					}
					return true;
				}
				</script>
            <div class="sect">
              <form id="fde" name="f_delivery" method="post" action="./orderprocessing.php" onsubmit="return checkForm()">
                <input type="hidden" name="team_id" value="<?php echo $team_id; ?>" >
                <input type="hidden" name="ward_id" value="<?php echo $list_ward_id; ?>" >
                <input type="hidden" name="dist_id" value="<?php echo $list_dist_id; ?>" >
                <input type="hidden" name="city_id" value="<?php echo $city_id; ?>" >
                <input type="hidden" name="id" value="<?php echo $id; ?>" >
                <input type="hidden" name="uemail" value="<?php echo $uemail; ?>" >
                <input type="hidden" name="orderid[0]" id="orderid" value="nothing">
                <table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
    <tr>
     <th width="10">&nbsp;&nbsp;<input type="checkbox" name="checkall" id="checkall" onclick="jqCheckAll( this.id, 'myinput' )" /></th><th width="100">ID</th>
      <th width="350">Thông tin thanh toán</th>
      <th width="350">Thông tin vận chuyển</th>
      <th width="60" nowrap>Thành tiền</th>
      <th width="40" nowrap>&nbsp;</th>
    </tr>
    <?php if(is_array($orders)){foreach($orders AS $index=>$one) { ?>
    <tr style="background-color:#<?php echo getStatusColor($one['state']); ?>" id="order-list-id-<?php echo $one['id']; ?>"><td align="center"><input type="hidden" name="orderid[]" id="orderid" value="<?php echo $one['id']; ?>"><input name="myinput[]" id="<?php echo $one['id']; ?>" value="<?php echo $one['id']; ?>" type="checkbox"></td>
      <td>Deal: <strong><?php echo $one['team_id']; ?>&nbsp;
      (
      <a class="deal-title" href="/<?php echo $city['slug']; ?>/<?php echo seo_url($teams[$one['team_id']]['short_title'],$one['team_id'],$url_suffix); ?>" target="_blank"><?php echo $teams[$one['team_id']]['short_title']; ?>
      <?php echo showColorSize($one); ?>
      </a>
      )
      </strong><br />Số đ.hàng: <a href="/backend/order/orderedit.php?id=<?php echo $one['id']; ?>&redirect=<?php echo $_SERVER['REQUEST_URI']; ?>" title="Sửa thông tin đơn hàng"><strong><?php echo $one['id']; ?></strong></a><br />
      <?php if($one['payment_id']==5 && (int)$one['transaction_id_nl']>0){?>
      Mã GD NL: <span style="color:#c40000"><strong><?php echo $one['transaction_id_nl']; ?></strong></span><br />
     <?php }?>
       <span style="white-space:nowrap"> Ngày đặt: <?php echo date('Y-m-d H:i:s',$one['create_time']);; ?></span></td>
      <td>Họ tên: <a href="/ajax/manage.php?action=userview&id=<?php echo $one['user_id']; ?>" class="ajaxlink"><strong><?php echo $one['realname']; ?></strong></a><br />
      
		<?php 
        	$note_address = "";$note_baddress="";
        
            if($one['note_address']!=''){
                $note_address = htmlspecialchars($one['note_address']).", ";
            }
            $one['billing_address'] = $note_address.htmlspecialchars($one['address']);
            if(ward_name($one['dist_id'],$one['ward_id'])){
                $wardname = ward_name($one['dist_id'],$one['ward_id']);
                $one['billing_address'] .=", ".strip_input($wardname['ward_name']);
            }
            if(ename_dist($one['dist_id'])){
                $dists = ename_dist($one['dist_id']);
                $one['billing_address'] .=", ".strip_input($dists['dist_name']);		
            }
            if(id_city($one['city_id'])){
                $citys = id_city($one['city_id']);
                $one['billing_address'] .=", ".strip_input($citys['name']);		
            }
            
            
            if($one['bnote_address']!=''){
                $note_baddress = htmlspecialchars($one['bnote_address']).", ";
            }
            $one['shipping_address'] = $note_address.htmlspecialchars($one['baddress']);
            if(ward_name($one['bdist_id'],$one['bward_id'])){
                $bwardname = ward_name($one['bdist_id'],$one['bward_id']);
                $one['shipping_address'] .=", ".strip_input($bwardname['ward_name']);
            }
            if(ename_dist($one['bdist_id'])){
                $bdists = ename_dist($one['bdist_id']);
                $one['shipping_address'] .=", ".strip_input($bdists['dist_name']);		
            }
            if(id_city($one['bcity_id'])){
                $bcitys = id_city($one['bcity_id']);
                $one['shipping_address'] .=", ".strip_input($bcitys['name']);		
            }
            
      ; ?>      
      
        Địa chỉ: <?php echo $one['billing_address']; ?><br />ĐT: <?php echo $one['mobile']; ?><br /><span style="color:#c40000"><strong><?php echo GetPaymentName($one['payment_id']); ?></strong></span></td>
      <td>Họ tên: <a href="/ajax/manage.php?action=userview&id=<?php echo $one['user_id']; ?>" class="ajaxlink"><strong><?php echo $one['brealname']; ?></strong></a><br />
        Địa chỉ: <?php echo $one['shipping_address']; ?><br />Điện thoại: <?php echo $one['bmobile']; ?><br /><span style="color:#c40000"><strong><?php echo GetShippingName($one['shipping_id']); ?></strong></span></td>
      <td align="right" style="color:#FF0000"><strong><?php echo print_price(moneyit(TotalOrder($one['id']))); ?></strong></td>
      <td align="center"><a href="/ajax/manage.php?action=orderview&id=<?php echo $one['id']; ?>" class="ajaxlink"><strong>Detail</strong></a><br /><a href="/ajax/manage.php?action=ordercancel&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to cancel it?"><strong>Cancel</strong></a>
    
      <br /><a href="/ajax/manage.php?action=orderdatratien&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to cancel it?"><strong>Da tra tien</strong></a>
      </td>
    </tr>
    <?php }}?>
    <tr>
      <td colspan="9"><div align="left" style="padding:10px;background:#FFFFCC"><input type="submit" value=" Tiếp nhận đơn hàng để xử lý " class="formbutton" name="processing" style="padding:3px 6px;" /></div></td>
    </tr>
    <tr>
      <td colspan="9"><?php echo $pagestring; ?></td>
    </tr>
  </table>
              </form>
            </div>
          </div>
          <div class="box-bottom"></div>
        </div>
      </div>
    </div>
  </div>
  <!-- bd end -->
</div>
<!-- bdw end -->
<?php include template("manage_footer");?>
