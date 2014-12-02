<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="subdashboard" id="dashboard">
		
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="subbox-top"><div class="subhead">
                    <h2>List News</h2>
					<ul class="filter" style="padding-top:3px;">
						<li><a href="edit.php?id=">Add <?php echo $cates[$zone]; ?></a></li>
					</ul>
				</div></div>
            <div class="box-content">
                
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="30">ID</th><th width="250">Title</th><th width="250">Photo</th><th width="250">Activate</th><th width="100">Operation</th></tr>
					<?php 
					if(is_array($categories))
					{
						foreach($categories AS $index=>$one)
						{ 
							$thumb = $one['thumb'];
							if($thumb != "")
								$thumb = "<a href='$image' rel='lightbox'> <img src=\"$thumb\" width=\"50px\" border=\"0\"></a>";
					?>
					<tr <?php echo $index%2?'':'class="alt"'; ?>>						
                        <td><?php echo $one['id']; ?></td>
						<td>
                        	<a target="_new" href="/tin-tuc/<?php echo seo_url($one['title'],$one['id'], $url_suffix, '_'); ?>"><?php echo $one['title']; ?></a>
                        </td>
                        <td>
                        	<img src="<?php echo $one['thumb']; ?>" />
                        </td>
                        <td>
                        	<?php echo $one['activate'] == 1 ? 'Yes' : 'No'; ?>
                        </td>
						<td class="op"><a href="edit.php?id=<?php echo $one['id']; ?>">edit</a>｜
                        <a href="javascript:deleteItem('index.php', '<?php echo $one['id']; ?>')">Delete</a></td>
					</tr>
					<?php }}?>
					<tr><td colspan="8"><?php echo $pagestring; ?></td></tr>
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
