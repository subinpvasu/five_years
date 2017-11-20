<!--
Project     : BTW Dive
Author      : Subin
Title      : login
Description : Login page for diver
-->
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>BTW Dive</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE, NO-STORE, must-revalidate">
    <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
    <META HTTP-EQUIV="EXPIRES" CONTENT=0>
	<link href="<?php echo base_url();?>css/diver_style.css" rel="stylesheet">
         <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script type="text/javascript">

            $(function() {

                if (localStorage.chkbx && localStorage.chkbx != '') {
                    $('#remember').attr('checked', 'checked');
                    $('#username').val(localStorage.usrname);
                    $('#password').val(localStorage.password);
                } else {
                    $('#remember').removeAttr('checked');
                    $('#username').val('');
                    $('#password').val('');
                }

                $('#remember').click(function() {

                    if ($('#remember').is(':checked')) {
                        // save username and passwordword
                        localStorage.usrname = $('#username').val();
                        localStorage.password = $('#password').val();
                        localStorage.chkbx = $('#remember').val();
                    } else {
                        localStorage.usrname = '';
                        localStorage.password = '';
                        localStorage.chkbx = '';
                    }
                });
            });

  function validateForm()
  {
  	var pwd=document.getElementById('password').value;
  	var uname=document.getElementById('username').value;
  	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  	if((uname=="")&&(pwd==""))
  	{
  		alert("Please enter username and password !");
  		uname.focus;
  		return false;
  	}
  	if(uname=="")
  	{
  		alert("Please enter username !");
  		uname.focus;
  		return false;
  	}


    if (!filter.test(uname))
    {
    alert('Please provide a valid username');
    uname.focus;
    return false;
    }
  		if(pwd=="")
  		{
  		alert("Please enter password !");
  		pwd.focus;
  		return false;
  		}


  }
  </script>


</head>

<body>

	<div class="wrapper">

		<div id="main" style="padding:50px 0 0 0;">

		<!-- Form -->


		<form id="respo-form" onsubmit="return validateForm();" method="post" action="<?php echo base_url();?>index.php/customer/dlogin_check/">

			<h2 align="center">Diver Login

		  </h2>
		  <h3 align="center"><?php echo $errormsg;?>

		  </h3>
			<div>
            &nbsp;
            </div>
              <div>
				<label>
					<span>Username</span>
					<input placeholder="Please enter your username" type="text" tabindex="1" name="username" id="username"  autofocus>
				</label>
			</div>
			<div>
				<label>
					<span>Password</span>
					<input placeholder="Please enter your password" type="password" name="password" id="password" tabindex="2" >
				</label>
			</div>

			<div>
			<label><span><input type="checkbox" name="remember" id="remember" value="1">&nbsp; Remember Me<span></label>

			</div>
          <div>
              <button name="login_btn"  type="submit" id="login_btn" value="login">Login</button>
			</div>
			<div>
              <button name="login_btn"  type="button" id="" onclick="self.close()" value="login">Exit</button>
			</div>
		</form>
		<!-- /Form -->

		</div>



<div style="bottom: 0px; position: absolute; width: 93%; text-align: center;font-weight: bold;">BTW
		Dive © 2014</div>	</div>
</body>
</html>