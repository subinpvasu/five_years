<?php 
require_once dirname(__FILE__) . '/includes/includes.php';

if(!isset($_SESSION['user_name'])){ header("Location:index.html");}

if($_GET['msg']=='Search'){unset($_SESSION['ad_account_adword_id']);}

if(isset($_SESSION['ad_account_adword_id'])){ header("Location:reports.php?id=".$_SESSION['ad_account_adword_id']."&type=TO"); }

?>
<!DOCTYPE HTML>
<!--
	Escape Velocity 2.5 by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>PUSH GROUP ADWORDS</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,700,900" rel="stylesheet" />
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><link rel="stylesheet" href="css/ie8.css" /><![endif]-->
		<script src="js/jquery.min.js"></script>
		<!-- <script src="js/jquery-1.9.0.min.js"></script> -->
		<script src="js/jquery-1.7.1.min.js"></script>
		<script src="js/jquery.dropotron.min.js"></script>
		<script src="js/config.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-panels.min.js"></script>
		<script src="js/account_reports.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel-noscript.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-desktop.css" />
			<link rel="stylesheet" href="css/page/pagination.css" />
			<link rel="stylesheet" href="css/page/grey.css" />
			<link rel="stylesheet" href="css/account_details.css" />
		</noscript>
	</head>
	<body class="homepage">

		<!-- Header Wrapper -->
			<div id="header-wrapper" class="wrapper">
				<div class="container">
					<div class="row">
						<div class="12u">
						
							<!-- Header -->
								<div id="header">
									
									<!-- Logo -->
										<div id="logo">
											<h1><a href="#">Push Group</a></h1>
											<span class="byline">Welcome To Push Group Adwords Panel</span>
										</div>
									<!-- /Logo -->
									
									<!-- Nav -->
									<?php include_once('top_menu.php');  ?>
									<!-- /Nav -->

								</div>
							<!-- /Header -->

						</div>
					</div>
				</div>
			</div>
		<!-- /Header Wrapper -->

		
		<!-- Main Wrapper -->
			<div class="wrapper wrapper-style2">
				<div class="title">Account Reports</div>
				<div class="container">
					<div class="row">
						<div class="12u">
							
							<!-- Main -->
								<div id="main">
							 
									<div class="container">							
										<div id="Search-div">
										Select account for reports : 
										<input type='text' placeholder='Search Account' id='search_term' />
										<input type="button" value="Search" id="search_button" /></div>
										<div class="row" id="results" >
										
											 
									    </div>
										<div class="row" id="results" >
										
											 
									    </div>
									</div>
								</div>
							<!-- /Main -->
							
						</div>
					</div>
				</div>
			</div>
		<!-- /Main Wrapper -->
		
		<!-- Highlights Wrapper -->
			
		<!-- /Highlights Wrapper -->

		<!-- Footer Wrapper -->
			<div id="footer-wrapper" class="wrapper">
				<div class="title">Footer</div>
				<div class="container">
					<div class="row">
						<div class="12u">

							<!-- Footer -->
							<!-- /Footer -->

							<!-- Copyright -->
								<div id="copyright">
									<span>
										&copy; Push Group. 
									</span>
								</div>
							<!-- /Copyright -->
						
						</div>
					</div>
				</div>
			</div>
		<!-- /Footer Wrapper -->

	</body>
</html>