<?php include template("manage_header");
$str_id = "";
?>

<div id="bdw" class="bdw">
  <div id="bd" class="cf">
    <div id="coupons">
      <div class="subdashboard" id="dashboard">
        <ul>
          <?php echo mcurrent_team($selector); ?>
        </ul>
      </div>
      <div id="content" class="coupons-box clear mainwide">
        <div class="box clear">
          <div class="subbox-top">
            <div class="subhead">
              <h2>Promotion category</h2>        
				<ul class="filter" style="padding-top:3px;">
					<li><a href="promotion_category_edit.php?id=">Add</a></li>
				</ul>
            </div>
          </div>
          <div class="box-content">
            <div class="sect">
            <form method="post" class="validator" action="">
              <table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr>
                        <th width="30">ID</th>
                        <th width="100">Name</th>
                        <th width="100">Promotion type</th>
                        <th width="100">Promotion value</th>
                        <th width="100">Start time</th>
                        <th width="100">End time</th>
                        <th width="100">Date created</th>
                        <th width="100">Product</th>
                        <th width="50">Activate</th>
                        <th width="80">Opration</th>
                    </tr>
					<?php 
					if(is_array($categories))
					{
						$arrPromotionText = array(0=>"Giảm theo %", 1=>"Giảm theo số tiền", 2=>"Sản phẩm đồng giá");
                        foreach($categories AS $index=>$one)
						{ 								
					?>
					<tr <?php echo $index%2?'':'class="alt"'; ?>>						
                        <td><?php echo $one['id']; ?></td>
						<td>
                        	<a href="promotion_category_edit.php?id=<?php echo $one['id']; ?>"><?php echo $one['promotion_name']; ?></a>
                        </td>
                        <td>
                        	<?php echo $arrPromotionText[$one['promotion_type']]; ?>
                        </td>
                        <td>
                        	<?php echo print_price(moneyit($one['promotion_value'])); 
                             if($one['promotion_type'] == 0) echo "%";
                             ?>
                        </td>
                        <td>
                        	<?php echo $one['start_time']; ?>
                        </td>
                        <td>
                        	<?php echo $one['end_time']; ?>
                        </td>
                        <td>
                        	<?php echo $one['date_created']; ?>
                        </td> 
                        <td>
                        	<a href="promotion_product.php?id=<?php echo $one['id']; ?>">View</a>
                            (<?php
                            $sqlCount = "SELECT count(1) as count_item FROM promotion_product WHERE id_promotion_category = '".$one['id']."'";
            				//echo "<br>$sqlCount";
                            $count_item = DB::GetQueryResult($sqlCount);
                            echo (int)$count_item["count_item"];
                            ?> products)
                        </td>                         
                        <td>
                        	<?php echo $one['activate'] == 1 ? '<font color="red">Yes</font>' : 'No'; ?>
                        </td>
						<td class="op">
                            <a href="promotion_category_edit.php?id=<?php echo $one['id']; ?>">edit</a>｜
                            <a href="javascript:deleteItem('promotion_category.php', '<?php echo $one['id']; ?>')">Delete</a>
                        </td>
					</tr>
					<?php }}?>
					<tr><td colspan="8"><?php echo $pagestring; ?></td></tr>
                    </table>
                    <input type="hidden" name="hidden_str_id" value="<?php echo $str_id; ?>" />
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
