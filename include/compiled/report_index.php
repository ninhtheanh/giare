<?php include template("manage_header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_report('index'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"><div class="subhead">
                    <h2>Today's Statistics</h2>
				</div></div>
            <div class="box-content">               
				<div class="sect" style="padding:5px; background:#FFFFCC">                        
						<p align="right">Today's registered users : <strong><?php echo print_price(moneyit($ucount)); ?></strong></p>
                        <p align="right">Today's active delivery man : <strong><?php echo print_price(moneyit($mcount)); ?></strong></p>
                        <p align="right">Today's running deals : <strong><?php echo print_price(moneyit($dcount)); ?></strong></p>
				</div>
                <h3>Today's Orders by Deal (<?php echo $ocount; ?>)</h3>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
                  <tr>
                    <th width="50">DealID</th>
                    <th width="50">OrderID</th>
                    <th>UserID</th>  
                    <th>DealName</th>
                    <th>Qty Purchased</th>
                  </tr>
                  <?php if(is_array($rs)){foreach($rs AS $index=>$one) { ?>                     
                  <tr style="background-color:#<?php echo ($index%2==0)?'ffffff':'efefef';; ?>" id="order-list-id-<?php echo $one['id']; ?>">                   
                      <td><?php echo $one['id']; ?></td> 
                      <td align="center"><?php echo $one['order_id']; ?></td>                
                     <td align="center"><?php echo $one['user_id']; ?></td>          
                    <td width="60%"><?php echo $one['short_title']; ?></td>                        
                    <td align="right"><?php echo $one['qty']; ?></td> 
                    </tr>
                  <?php }}?>                                  
                </table>
				</div>
			
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("manage_footer");?>