<?php 
session_start();
if(isset($_SESSION['status']) && $_SESSION['status']=='loggedin')
{
	header('location:account.php');	
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="" content="">
    <meta name="author" content="">
    <title>Google Shopping Campaign</title>
	<link rel="stylesheet" type="text/css" href="static/css/style.css">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="static/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="static/css/font-awesome.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="static/js/bootstraps/jquery.js"></script>
	<script src="static/js/bootstraps/bootstrap.min.js"></script>
	<script>
$(document).ready(function(){
	$("#login_button").click(function(){
		$("#login_form").submit();
		});
	
});

	</script>
  </head>
	  <body id="center" style="color:#58595B;">
	    <header style ="background-color:white">
      <div class="row ">
      <div class="logo col-md-6">
        <img src="static/img/logo.png" style="width:250px;">
      </div>
      <div class="navagation col-md-6">
        <div class="col-md-10">
          <a href="/accounts"><button class="pull-right btn btn-default hidden">Accounts</button></a>
        </div>
          <a type="button" class="btn btn-default hidden"  href="/logout" class="logout">Logout</a>
      </div>
      </div>
    </header>
	  	<div class="container">
			<div class="login-container">
	            <div id="output"></div>
	            <div class="form-box">
	            
	            
	            
	            
	           		<form role="form" method="post" action="processor.php" id="login_form">
                  <span style="padding:10px">
                   <?php if(isset($_GET['msg']) && $_GET['msg']=='error'){?>
    							<span class="label label-danger "><strong>Email and Password NOT Matching!</strong></span>
    							<?php }?>
                </span>
	                	<!-- {% csrf_token %} -->
	                	<input for="Email" id="id_username" maxlength="254" class="form-control" name="username" type="text" placeholder="Username">
	                	<input id="id_password" for="pwd" class="form-control" name="password" type="password" placeholder="Password">
	                    <button class="btn btn-info btn-block login" id="login_button" >Login</button>
	                    <input   type="hidden" name="submit" value="Login">
	                </form>
	            </div>
	        </div>
		</div>
	  </body>
 </html>
