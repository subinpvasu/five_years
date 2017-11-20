<!--
Project     : BTW Dive
Author      : Subin
Title      : Display anodes in the anode work orders
Description : Anodes in the  work order will be displayed here
-->
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>BTW Dive</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="author" content="@toddmotto">
<link href="<?php echo base_url(); ?>css/diver_style.css"
	rel="stylesheet">


</head>

<body>

	<div class="wrapper">

		<div id="main" style="padding: 50px 0 0 0;">

			<!-- Form -->
			<form id="respo-form" method="post">
				<div id="headerbtns">
					<table width="100%">
						<td width="40%">
							<button name="home"
								onclick="window.location = '<?php echo base_url(); ?>index.php/customer/diver_home/'"
								type="button" id="homebtn">Home</button>
						</td>
						<td width="20%" style="background-color: #000000;"></td>
						<td width="40%">
							<button name="log_out"
								onclick="window.location = '<?php echo base_url(); ?>index.php/customer/diver_logout/'"
								type="button" id="Log_out">Log Out</button>
						</td>
					</table>
				</div>
				<div>&nbsp;</div>
				<h2>Were zincs changed on this boat?</h2>
				<div>&nbsp;</div>
				<div>
					<button name="s"
						onclick="window.location = '<?php echo base_url(); ?>index.php/customer/diver_anode_cwo2/<?php echo $pkwork; ?>'"
						type="button" id="yes">Yes</button>

				</div>



				<div>
					<button name="s"
						onclick="window.location = '<?php echo base_url(); ?>index.php/customer/diver_clean_ynot/<?php echo $pkwork; ?>'"
						type="button" id="no">No</button>
				</div>

		<div>
                            <button name="s"  onclick="window.location='<?php echo base_url();?>index.php/customer/view_wo_details/<?php echo $pkwork;?>'" type="button" >Back</button>


                        </div>
		</form>
		<!-- /Form -->


	</div>
<div
		style="bottom: 0px; position: absolute; width: 93%; text-align: center; font-weight: bold;">BTW
		Dive © 2014</div>
	</div>



</body>
</html>