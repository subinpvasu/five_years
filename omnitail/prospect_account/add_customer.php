<?php
include('config/config.php');
if(isset($_POST['emailnew'])){
    $_SESSION['prospect_email'] = $_POST['emailnew'];
	//require_once dirname(__FILE__) . '/includes/includes.php';
	$link ='https://accounts.google.com/o/oauth2/auth?response_type=code&client_id='.$clientId.'&redirect_uri='.$redirect_uri.'&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fadwords&access_type=offline';
	header('Location:'.$link);
	exit;
}
include("header.php");
?>
<div class="report-container">
	<div class="page-header"><h1>Add New Customer</h1></div>
	<div class="nav_left">
		<!-- ul class="navigater">

		  <li>Select All <input type="checkbox"  name='en_dis_all' id='en_dis_all' ></li>
		  <li><button type="submit" value="Enable" class="En_Dis">Enable</button></li>
		  <li><button type="submit" value="Disable" class="En_Dis">Disable</button></li>
		  </ul -->
	</div>
	<div class="nav_right" style="text-align:right;padding-left:1%;width:58%" > 
	</div>
	<div class="report-div">
		<div class="account-details-div">
			<form action="add_customer.php" method=post >
			<input type=text name="emailnew" placeholder="Enter Email Id"  style ="height:20px; width:250px;"/><br/> <br/>
			<input type=submit name="emailsubmit" placeholder="Enter Email Id" value= "Add Customer" style ="height:25px; width:100px;"/><br/> <br/>
			<form>
		</div>
		
		<div class="nav_right" style="text-align:right;padding-left:1%;width:58%" > 
		</div>
	</div>
</div>
<?php include("footer.php"); ?>
