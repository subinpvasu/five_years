{% load staticfiles %}
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
	<link rel="stylesheet" type="text/css" href="../static/css/style.css">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="../static/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="../static/css/font-awesome.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="../static/js/bootstraps/jquery.js"></script>
	<script src="../static/js/bootstraps/bootstrap.min.js"></script>
  </head>
	  <body id="center" style="color:#58595B;">
	  	<div class="container">
			<div class="login-container">
	            <div id="output"></div>
	            <div class="form-box">
	           		<form role="form" method="post" action="/login/">
                  <span style="padding:10px">
                  {% if error %}
    							<span class="label label-danger"><strong>{{error}}</strong></span>
    							{% endif %}
                </span>
	                	{% csrf_token %}
	                	<input for="Email" id="id_username" maxlength="254" class="form-control" name="username" type="text" placeholder="Username">
	                	<input id="id_password" for="pwd" class="form-control" name="password" type="password" placeholder="Password">
	                    <button class="btn btn-info btn-block login" type="submit">Login</button>
	                </form>
	            </div>
	        </div>
		</div>
	  </body>
 </html>
