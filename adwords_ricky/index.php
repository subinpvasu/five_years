<?php
//header('Location:updating.php');
include("header.php");
?>
<div class="report-container">
	<div class="page-header"><h1>Log In</h1></div>
	<div class="report-div">
		<div class="login-form-div">
			<form method="post" id="login_form" onsubmit="return loginSubmit();" >
				<table>
					<tr><td colspan="2"><input type="text" class="textbox" placeholder="Email" id="contact-name" /></td></tr>
					<tr><td colspan="2"><input type="password" class="textbox" placeholder="Password" id="contact-pass" /></td></tr>
					<tr><td><button type="submit" value="Submit" class="button">Enter</button><button type="reset" value="Reset"  style="margin-left:5px;">Reset</button></td><td></td></tr>

				</table>
			</form>
		</div>
	</div>
</div>
<?php include("footer.php"); ?>