<!--
Project     : BTW Dive
Author      : Subin
Title      : Home page
Description : Diver login home page
-->
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>BTW Dive</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<meta name="author" content="@toddmotto">
	<link href="<?php echo base_url();?>css/diver_style.css" rel="stylesheet">
   <script type="text/javascript">

   </script>

</head>

<body>

	<div class="wrapper">

		<div id="main" style="padding:50px 0 0 0;">

		<form id="respo-form" method="post">

			<h2>Welcome <?php echo $dname; ?>


		  </h2>
			<div>
            &nbsp;
            </div>

			<div>
				<button name="comp_wo" onclick="window.location='<?php echo base_url();?>index.php/customer/diver_completed_wo/'" type="button"  id="comp_wo">Completed Work Orders</button>

			</div>
          <div>
			<button name="incomp_wo" onclick="window.location='<?php echo base_url();?>index.php/customer/diver_incompleted_wo/'" type="button" id="incomp_wo">Incomplete Work Orders</button>
			</div>
			 <div>
			<button name="logout" onclick="window.location='<?php echo base_url();?>index.php/customer/diver_logout/'" type="button" id="Log_out">Log Out</button>
			</div>
		</form>
		<!-- /Form -->
		</div>



<div style="bottom: 0px; position: absolute; width: 93%; text-align: center;font-weight: bold;">BTW
		Dive © 2014</div>	</div>
</body>
</html>