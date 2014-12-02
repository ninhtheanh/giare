<?php
	if(isset($_POST) && $_POST['name'] != "")
	{
		$name = $_POST['name'];
		$email = $_POST['email'];
		$phone = $_POST['phone2'];
        $place = $_POST['place'];
        $message = $_POST['message'];
		$body = "Tên: $name <br>Email: $email <br>Số ĐT: $phone <br>Khu vực: $place <br><br>Nội dung: $message";
		//mail('infocheapdeal@gmail.com', 'Thong Tin Lien He', $message);
		//Send email
		$emails = array('infocheapdeal@gmail.com');
		$subject = "Thong Tin Lien He";
		global $INI;
		$encoding = $INI['mail']['encoding'] ? $INI['mail']['encoding'] : 'UTF-8';
		settype($emails, 'array');	
		$options = array(
			'contentType' => 'text/html',
			'encoding' => $encoding,
		);	
		$from = $INI['mail']['from'];
		$to = array_shift($emails);	
		if ($INI['mail']['mail']=='mail') {
		
			Mailer::SendMail($from, $to, $subject, $message, $options, $emails);
		} else {
		//Mailer::SendMail($from, $to, $subject, $message, $options, $emails);
			Mailer::SmtpMail($from, $to, $subject, $message, $options, $emails);
		}
		//Send email end
		redirect("lien-he-cam-on.html");
	}
?>
<style>
/* form style */

.form-style-heading {
	font-weight: bold;
	font-style: italic;
	border-bottom: 2px solid #ddd;
	margin-bottom: 10px;
	font-size: 15px;
	padding-bottom: 3px;
}
.form-style label {
	display: block;
	margin: 0px 0px 15px 0px;
}
.form-style label > span {
	width: 100px;
	font-weight: bold;
	float: left;
	padding-top: 8px;
	padding-right: 5px;
}
.form-style span.required {
	color:red;
}
.form-style .tel-number-field {
	width: 40px;
	text-align: left;
}
.form-style .long {
	width: 120px;
}
.form-style input.input-field {
	width: 48%;
}
.form-style input.input-field, .form-style .tel-number-field, .form-style .textarea-field,  .form-style .select-field {
	-webkit-transition: all 0.30s ease-in-out;
	-moz-transition: all 0.30s ease-in-out;
	-ms-transition: all 0.30s ease-in-out;
	-o-transition: all 0.30s ease-in-out;
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	border: 1px solid #C2C2C2;
	box-shadow: 1px 1px 4px #EBEBEB;
	-moz-box-shadow: 1px 1px 4px #EBEBEB;
	-webkit-box-shadow: 1px 1px 4px #EBEBEB;
	border-radius: 3px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	padding: 7px;
	outline: none;
}
.form-style .input-field:focus, .form-style .tel-number-field:focus, .form-style .textarea-field:focus, .form-style .select-field:focus {
	border: 1px solid #0C0;
}
.form-style .textarea-field {
	height:100px;
	width: 55%;
}
.form-style input[type="button"], .form-style input[type="submit"] {
	-moz-box-shadow: inset 0px 1px 0px 0px #3985B1;
	-webkit-box-shadow: inset 0px 1px 0px 0px #3985B1;
	box-shadow: inset 0px 1px 0px 0px #3985B1;
	background-color: #216288;
	border: 1px solid #17445E;
	display: inline-block;
	cursor: pointer;
	color: #FFFFFF;
	padding: 8px 18px;
	text-decoration: none;
	font: 12px Arial, Helvetica, sans-serif;
}
.form-style input[type="button"]:hover, .form-style input[type="submit"]:hover {
	background: linear-gradient(to bottom, #2D77A2 5%, #337DA8 100%);
	background-color: #28739E;
}
.form-style .success {
	background: #D8FFC0;
	padding: 5px 10px 5px 10px;
	margin: 0px 0px 5px 0px;
	border: none;
	font-weight: bold;
	color: #2E6800;
	border-left: 3px solid #2E6800;
}
.form-style .error {
	background: #FFE8E8;
	padding: 5px 10px 5px 10px;
	margin: 0px 0px 5px 0px;
	border: none;
	font-weight: bold;
	color: #FF0000;
	border-left: 3px solid #FF0000;
}
</style>
<!-- include Google hosted jQuery Library -->

<!-- Start jQuery code -->
<script type="text/javascript">
$(document).ready(function() {
    $("#submit_btn").click(function() { 
       
        var proceed = true;
        //simple validation at client's end
        //loop through each field and we simply change border color to red for invalid fields       
        $("#contact_form input[required=true], #contact_form textarea[required=true]").each(function(){
            $(this).css('border-color',''); 
            if(!$.trim($(this).val())){ //if this field is empty 
                $(this).css('border-color','red'); //change border color to red   
                proceed = false; //set do not proceed flag
            }
            //check invalid email
            var email_reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/; 
            if($(this).attr("type")=="email" && !email_reg.test($.trim($(this).val()))){
                $(this).css('border-color','red'); //change border color to red   
                proceed = false; //set do not proceed flag              
            }   
        });
       
        if(proceed) //everything looks good! proceed...
        {
            //get input field values data to be sent to server
            post_data = {
                'user_name'     : $('input[name=name]').val(), 
                'user_email'    : $('input[name=email]').val(),                 
                'phone_number'  : $('input[name=phone2]').val(), 
                'subject'       : $('select[name=subject]').val(), 
                'msg'           : $('textarea[name=message]').val()
            };
           
		  $( "#frmContactForm" ).submit();
		   /*
            //Ajax post data to server
            $.post('contact_me.php', post_data, function(response){  
                if(response.type == 'error'){ //load json data from server and output message     
                    output = '<div class="error">'+response.text+'</div>';
                }else{
                    output = '<div class="success">'+response.text+'</div>';
                    //reset values in all input fields
                    $("#contact_form  input[required=true], #contact_form textarea[required=true]").val(''); 
                    $("#contact_form #contact_body").slideUp(); //hide form after success
                }
                $("#contact_form #contact_results").hide().html(output).slideDown();
            }, 'json');
			*/
        }
    });
    
    //reset previously set border colors and hide all message on .keyup()
    $("#contact_form  input[required=true], #contact_form textarea[required=true]").keyup(function() { 
        $(this).css('border-color',''); 
        $("#result").slideUp();
    });
});
</script>
<form name="frmContactForm" method="post" action="">
	<div class="form-style" id="contact_form">
      <div class="form-style-heading">Bạn hãy để lại thông tin và nội dung bên dưới, chúng tôi sẽ liên hệ ngay với bạn.</div>
      <div id="contact_results"></div>
      <div id="contact_body">
        <label><span>Tên <span class="required">*</span></span>
          <input type="text" name="name" id="name" required="true" class="input-field"/>
        </label>
        <label><span>Email <span class="required">*</span></span>
          <input type="email" name="email" required="true" class="input-field"/>
        </label>
        <label><span>Số ĐT <span class="required">*</span></span>
          <input type="text" name="phone2" maxlength="15"  required="true" class="tel-number-field long" />
        </label>
        <label for="place"><span>Khu vực:</span>
          <select name="place" class="select-field">
            <option value="HCM">Hồ Chí Minh</option>
            <option value="HN">Hà Nội</option>
          </select>
        </label>
        <label for="field5"><span>Nội dung: <span class="required">*</span></span>
          <textarea name="message" id="message" class="textarea-field" required="true"></textarea>
        </label>
        <label> <span>&nbsp;</span>
          <input type="submit" id="submit_btn" value="Submit" />
        </label>
      </div>
    </div>
</form>

		