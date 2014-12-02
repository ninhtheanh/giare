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
.boxsubinfo label{text-align: left !important;width: 100px;display: inline-block;}
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
                	
                     <?php include template("thongtinhuuich");?>
                    <?php include template("menu-gioithieu");?>
                </td>
                <td valign="top">
                	<div class="boxsubinfo" style="border: 1px solid #9d999a;padding: 12px;width: 93%;margin:0px 15px;">
                         	<h2 style="border-bottom: 2px solid #bebebe;color: #000;padding-bottom: 11px;font-size: 20px;">Liên hệ hợp tác KD</h2>
                    	 <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                
                  <tr>
                 
                    <td >
                      <div align="left" style="padding:0px 10px;">
                        <p class="notice">Chào mừng bạn liên hệ hợp tác với <?php echo $INI['system']['abbreviation']; ?>! Bạn hãy để lại thông tin và nội dung đề nghị hợp tác, chúng tôi sẽ liên hệ ngay với bạn.</p>
                        <form id="feedback-user-form" method="post" action="/feedback/seller.php" class="validator">
                          <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                              <tr>
                                <td align="left" height="35"><div class=" fullname">
                                    <label for="feedback-fullname">Tên</label>
                                    <input type="text" size="30" name="title" id="feedback-fullname" class="f-input" value="<?php echo $login_user['username']; ?>" require="true" datatype="require" />
                                  </div></td>
                              </tr>
                            
                              <tr>
                                <td align="left" height="35"><div class=" email">
                                    <label for="feedback-email-address">Email - Số ĐT</label>
                                    <input type="text" size="30" name="contact" id="feedback-email-address" class="f-input" value="<?php echo $login_user['email']; ?>" require="true" datatype="require" /> </div>
                                    <div class="hint">Xin vui lòng nhập email và điện thoại để chúng tôi liên hệ với bạn.</div></td>
                              </tr>
                             
                              <tr>
                                <td align="left" height="35" style="padding-top:5px;"><div align="left">
                                    <label for="feedback-suggest">Nội dung liên hệ</label>&nbsp;<textarea cols="30" rows="5" name="content" id="feedback-suggest" class="f-textarea" style="width:500px; height:150px" require="true" datatype="require"></textarea>
                                  </div></td>
                              </tr>
                             
                              <tr>
                                <td align="left" height="35" style="padding-left:100px"><div class="act">
                                    <input type="submit" value="  Gửi  " name="commit" id="feedback-submit" class="formbutton" style="padding-top:7px; padding-bottom:7px;"/>
                                  </div></td>
                              </tr>
                            </tbody>
                          </table>
                        </form>
                      </div></td>
                   
                  </tr>

                </tbody>
              </table>
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