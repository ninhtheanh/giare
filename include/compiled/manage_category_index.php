<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo mcurrent_category($zone); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"><div class="subhead">
                    <h2>List <?php echo $cates[$zone]; ?></h2>
					<ul class="filter" style="padding-top:3px;">
						<li><a href="/ajax/manage.php?action=categoryedit&zone=<?php echo $zone; ?>" class="ajaxlink">Add <?php echo $cates[$zone]; ?></a></li>
					</ul>
				</div></div>
            <div class="box-content">
                
                <div class="sect">
                	<?php if($zone == 'group')
					{
						$result = array();
						foreach($categories as $item)
						{
							$result[] = $item;							
						}
						$categories_original = $result;
						
						function get_parent_cate($categories)
						{
							$result = array();
							foreach($categories as $item)
							{
								if($item['parent'] == 0)
									$result[] = $item;		
							}
							return $result;
						}
						function get_children_cate($categories, $parent)
						{
							$result = array();
							foreach($categories as $item)
							{
								if($item['parent'] == $parent)
									$result[] = $item;		
							}
							return $result;
						}
						$categories = get_parent_cate($categories);
					?>
                    <table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="50">ID</th><th width="250">English name</th><th width="250">English name Repeat</th><th width="80">Initial letter</th><th width="150">Group</th><th width="40" nowrap>Display</th><th width="40" nowrap>Sort</th><th width="100">Operation</th></tr>
					
					<?php if(is_array($categories)){foreach($categories AS $index=>$one) { ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?>>
						<td><b><?php echo $one['id']; ?></b></td>
						<td>
                        	<?php if($one['icon_category'] != ''){?>
                            <img src="<?php echo $one['icon_category']; ?>"> 
                            <?php }?>
                        	<b><?php echo $one['name']; ?></b>
                        </td>
						<td><?php echo $one['ename']; ?></td>
						<td><?php echo strtoupper($one['letter']); ?></td>
						<td><?php echo $one['czone']; ?></td>
						<td><?php echo trim($one['display']) == 'Y' ? 'Yes' : 'No'; ?></td>
						<td><?php echo intval($one['sort_order']); ?></td>
						<td class="op"><a href="/ajax/manage.php?action=categoryedit&id=<?php echo $one['id']; ?>" class="ajaxlink">edit</a>｜<a href="/ajax/manage.php?action=categoryremove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to delete this category？">delete</a></td>
					</tr>
                    <?php 
						$arrChild = get_children_cate($categories_original, $one['id']);
						if(count($arrChild) > 0){ //if child
						foreach($arrChild AS $index_child=>$child){
					?>
                    	<td align="right"><?php echo $child['id']; ?></td>
						<td style="padding-left:20px">
                        	<?php if($child['icon_category'] != ''){?>
                            <img src="<?php echo $child['icon_category']; ?>"> 
                            <?php }?>
                        	<?php echo $child['name']; ?>
                        </td>
						<td><?php echo $child['ename']; ?></td>
						<td><?php echo strtoupper($child['letter']); ?></td>
						<td><?php echo $child['czone']; ?></td>
						<td><?php echo trim($one['display']) == 'Y' ? 'Yes' : 'No'; ?></td>
						<td><?php echo intval($child['sort_order']); ?></td>
						<td class="op"><a href="/ajax/manage.php?action=categoryedit&id=<?php echo $child['id']; ?>" class="ajaxlink">edit</a>｜<a href="/ajax/manage.php?action=categoryremove&id=<?php echo $child['id']; ?>" class="ajaxlink" ask="sure to delete this category？">delete</a></td>
					</tr>
                    <?php }}//if child [end]?>
                    
					<?php }}?>
					<tr><td colspan="8"><?php echo $pagestring; ?></td></tr>
                    </table>
                    
                    <?php }else{?>
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="50">ID</th><th width="250">English name</th><th width="250">English name Repeat</th><th width="60">Initial letter</th><th width="150">group</th><th width="40" nowrap>navigation</th><th width="40" nowrap>sort</th><th width="100">operation</th></tr>
					<?php if(is_array($categories)){foreach($categories AS $index=>$one) { ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?>>
						<td><?php echo $one['id']; ?></td>
						<td><?php echo $one['name']; ?></td>
						<td><?php echo $one['ename']; ?></td>
						<td><?php echo strtoupper($one['letter']); ?></td>
						<td><?php echo $one['czone']; ?></td>
						<td><?php echo $one['display']; ?></td>
						<td><?php echo intval($one['sort_order']); ?></td>
						<td class="op"><a href="/ajax/manage.php?action=categoryedit&id=<?php echo $one['id']; ?>" class="ajaxlink">edit</a>｜<a href="/ajax/manage.php?action=categoryremove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="sure to delete this category？">delete</a></td>
					</tr>
					<?php }}?>
					<tr><td colspan="8"><?php echo $pagestring; ?></td></tr>
                    </table>
                    <?php }?>
				</div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("manage_footer");?>
