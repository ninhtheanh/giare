<?php 
	include template("manage_header");
	$str_id = "";
?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_system('page'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="subbox-top">
            	<div class="subhead"><h2>Pape List</h2>
                	<ul class="filter" style="padding-top:3px;">
						<li><a href="static_edit.php?id=">Add</a></li>
					</ul>
                </div>                
            </div>
            <div class="box-content">
                <div class="sect">
                <form method="post" class="validator" action="">
                    <table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table" style="width:99%">
					<tr><th width="50">Page type</th><th width="30">ID</th><th width="250">Name</th><th width="60">Show on footer</th><th width="30">Order</th><th width="100">Operation</th></tr>
					<?php if(is_array($categories)){foreach($categories AS $index=>$one) 
					{ 						
						if($str_id <> "")
							$str_id .= ",";
							
						$str_id .= $one['id'];	
										?>
					<tr <?php echo $index%2?'':'class="alt"'; ?>>
						<td><?php echo getPageTypeName($arrPageType, $one['page_type']); ?></td>
                        <td><?php echo $one['id']; ?></td>
						<td>
                        	<a target="_new" href="../../<?php echo $one['id']; ?>.html"><?php echo $one['name']; ?></a>
                        </td>
                        <td align="center">
                        	<input type="checkbox" name="show_on_footer_<?php echo $one['id']; ?>" <?php echo $one['show_on_footer'] == 1 ? 'checked="checked"' : ''; ?>/>
                        </td>
                        <td>
                        	<input type="text" name="order_<?php echo $one['id']; ?>" size="5" value="<?php echo $one['order']; ?>" class="f-input" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                        </td>
						<td class="op"><a href="static_edit.php?id=<?php echo $one['id']; ?>">Edit</a>｜
                        <a href="javascript:deletePage('<?php echo $one['id']; ?>')" ask="Are you sure to delete this category？">Delete</a></td>
					</tr>
					<?php }}?>
                    <tr><td colspan="6"><hr /></td></tr>                                       
                    <tr>						
						<td></td>
                        <td></td>
						<td></td>
                        <td><input type="submit" name="submit" value="Update" /></td>
                        <td></td>
					</tr>                    
					<tr><td colspan="6"><?php echo $pagestring; ?></td></tr>
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
<script>
	function deletePage(id)
	{
		if(confirm('Are you sure you want to delete this items?'))
		{
			location.href = 'page.php?action=delete&id=' + id;
		}
		return false;
	}
</script>
<?php include template("manage_footer");?>
