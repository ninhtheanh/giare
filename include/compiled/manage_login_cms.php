<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="manage">
    <div id="content" class="manage">
        <div class="box">
            <div class="box-content" style="padding-left:200px; width:801px; background-color:#f3e161;border-top:#ef820e 1px solid">
                                <div class="head"><h2>Manager login</h2></div>
                <div class="sect">
                    <form id="manage-user-form" method="post" action="/cms/login.php" class="validator">
                        <div class="field">
                            <label for="manage-login">Login name</label>
                            <input type="text" size="30" name="username" id="manage-username" class="f-input" datatype="require" require="true" />
                        </div>
                        <div class="field">
                            <label for="manage-password">Password</label>
                            <input type="password" size="30" name="password" id="manage-password" class="f-input" datatype="require" require="true" />
                        </div>
                        <div class="act" style="padding-bottom:10px">
                            <input type="submit" value="Submit" name="commit" id="login-submit" class="formbutton"/>
                        </div>
                    </form>
                </div>
                            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->
<?php include template("manage_footer");?>