<?php include template("header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="learn">
	<div class="subdashboard" id="dashboard">
		<ul><?php echo current_help('huong-dan-mua-hang'); ?></ul>
	</div>
	<div id="content" class="mainwide">
        <div class="box">
            <div class="subbox-content">
 				<div style="background-color:#FFFFFF">
                	<div align="left" style="padding:20px"> 
                	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top" width="80%">
                        	<table border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tbody>
                                <tr>
                                  <td width="24"><img src="/static/css/images/faqbox_topleft.gif" width="24" height="20"></td>
                                  <td style="background: url(&quot;/static/css/images/faqbox_topbg.gif&quot;) repeat-x scroll 0% 0% transparent;"></td>
                                  <td width="23"><img src="/static/css/images/faqbox_topright.gif" width="23" height="20"></td>
                                </tr>
                                <tr>
                                  <td style="background: url(&quot;/static/css/images/faqbox_leftbg.gif&quot;) repeat-y scroll right center transparent;">&nbsp;</td>
                                  <td bgcolor="#f1f1f1"><div align="left" style="padding-bottom:15px;font-size:17px;"><h3>Hướng dẫn mua hàng trên <?php echo $INI['system']['abbreviation']; ?></h3></div><div align="left"><?php echo htmlspecialchars_decode($page['value']); ?></div></td>
                                  <td style="background: url(&quot;/static/css/images/faqbox_rightbg.gif&quot;) repeat-y scroll right center transparent;">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td><img src="/static/css/images/faqbox_bottomleft.gif" alt="" width="24" border="0" height="21"></td>
                                  <td style="background: url(&quot;/static/css/images/faqbox_bottombg.gif&quot;) repeat-x scroll 0% 0% transparent;"></td>
                                  <td><img src="/static/css/images/faqbox_bottomright.gif" alt="" width="23" border="0" height="21"></td>
                                </tr>
                              </tbody>
                            </table>
                        </td>
                        <td align="left" valign="top" style="padding-left:7px;"><div id="sidebar">
                            <?php include template("block_side_support");?>
                        </div><?php include template("block_side_recent");?></td>
                      </tr>
                    </table>

                   </div>
                </div>           
            </div>
            <div class="box-bottom"></div>
        </div>
	</div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("footer");?>
