<?php 
	include template("manage_header");
	$str_id = "";
?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_system('banner'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top">
            	<div class="subhead"><h2>Banner List</h2>
                	<ul class="filter" style="padding-top:3px;">
						<li><a href="banner_edit.php?id=">Add</a></li>
					</ul>
                </div>                
            </div>
            <div class="box-content">
                <div class="sect">
                <form method="post" class="validator" action="">
                    <table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table" style="width:99%">
					<tr><th width="30">ID</th><th width="820">Banner</th><th width="30">Order</th><th width="30">Actiate</th><th width="100">Operation</th></tr>
					<?php if(is_array($categories)){foreach($categories AS $index=>$one) 
					{ 						
						if($str_id <> "")
							$str_id .= ",";
							
						$str_id .= $one['id'];	
										?>
					<tr <?php echo $index%2?'':'class="alt"'; ?>>
						 <td><?php echo $one['id']; ?><br /><?php echo $one['banner_type']; ?></td>
						<td>
                        	<a href="<?php echo $one['url']; ?>" target="_blank">
                            	<img src="<?php echo $one['img']; ?>" alt="slideshow"/>
                            </a>
                        </td>
                        <td>
                        	<input type="text" name="order_<?php echo $one['id']; ?>" size="5" value="<?php echo $one['order']; ?>" class="f-input" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                        </td>
                        <td align="center">
                        	<input type="checkbox" name="activate_<?php echo $one['id']; ?>" <?php echo $one['activate'] == 1 ? 'checked="checked"' : ''; ?>/>
                        </td>
						<td class="op"><a href="banner_edit.php?id=<?php echo $one['id']; ?>">Edit</a>｜
                        <a href="javascript:deleteItem('banner.php', '<?php echo $one['id']; ?>')">Delete</a></td>
					</tr>
					<?php }}?>
                    <tr><td colspan="5"><hr /></td></tr>
                                       
                    <tr>
                        <td></td>
                        <td></td>
						<td></td>
                        <td><input type="submit" name="submit" value="Update" /></td>
                        <td></td>
					</tr>
                    
					<tr><td colspan="5"><?php echo $pagestring; ?></td></tr>
                    </table>
                    <input type="hidden" name="hidden_str_id" value="<?php echo $str_id; ?>" />
                    </form>
                </div>
            </div>
            <div class="box-bottom"></div>
        </div>
	</div>
<!--
<div id="sidebar">
</div>
-->
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->
<?php include template("manage_footer");?>
