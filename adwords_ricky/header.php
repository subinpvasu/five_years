<?php
require_once dirname(__FILE__) . '/includes/includes.php';
//register_shutdown_function('logout_now');

register_shutdown_function('logout_now');
function logout_now()
{
    global $main ;
    $main -> Query("UPDATE login_statistics SET logout_time=NOW() WHERE id='".$_SESSION['logout_user']."'");
}
$page=basename($_SERVER['PHP_SELF']);
$link = SITE_URL ;
//if($_SERVER['SERVER_NAME']=="localhost"){$link=$link."google/";}

if($page<>"index.php"){
	if(!isset($_SESSION['user_name'])){ header("Location:".$link."index.php"); }
	if($_GET['msg']=='Search'){unset($_SESSION['ad_account_adword_id']);}
	$main->select($_SESSION['user_db']);
}
else{
	if(isset($_SESSION['user_name'])){ header("Location:".$link."customers.php");}
}

if($_SESSION['prospect_account'] ==1){ $pros = "&nbsp; &nbsp;<span style=\"vertical-align:super; color:#FF6600;\">Prospect</span>";	 }
 ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Push Analyser</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

        <style>
            body{
                background-color: #00d7fe ;
                font-family: gibsonregular ;
                font-size: 14px;
                width: 100%;
				color : #434343 ;

            }
            .main_container{
                width: 98%;
                margin: 0px auto;
                height:auto;
                overflow: hidden;
            }
			.header{
				width: 100%;
				margin: 0px;
			}
			.constant-header{
				width: 100%;
				margin: 0px 0px 15px 0px;
				height:auto;
				overflow: hidden;
			}
			.logo{
				float:left;
				width:175px;
				height:66px;
				/* background-color :#854e9f;
				border: 1px #754189 solid ;
				border-bottom : 5px #754189 solid ; */
				margin:0px;
				background-image : url('<?php echo $link; ?>/images/logo.png');
				background-repeat : no-repeat;
			}
			.welcome {
				float:right;
				width:60%;
				/*border: 1px #DDD solid ;*/
				text-align : right;
				vertical-align : bottom;
				font-weight : bold;
				padding-top:49px;
			}
			.welcome a{
				text-decoration:none;
				color : #434343 ;
			}
			.header-menu{
				border-radius: 5px;
				background: #3a3a3a;
				padding: 20px 1.2%;
				width: 97%;
				height: 5px;
				margin-bottom : 15px;
			}
			.menu{
				float:left;
				padding:0px 0px;
			}
			ul.top-menu{
				list-style-type: square;
				font-weight:bold;
				font-size:15px;
				float:left;
				margin:-8px -20px;
			}

			ul.top-menu li{
				float:left;
				margin:0px 10px;
				margin-right:10px;
				padding-right:10px;
				color:#fff;
				/* border-right:2px solid #000; */

			}
			ul.top-menu li:hover{
				color:#b069d1;
			}
			ul.top-menu li a{
				color:inherit;
				text-decoration:none;
			}
			.search{
				float : right ;
				margin-top:-8px;
			}
			.content-div {
				border-radius: 5px;
				background: #FFFFFF;
				padding: 20px 1.2%;
				width: 97%;
				height: auto;
				overflow:hidden;
				margin-bottom : 15px;
			}
			.report-container{
				width: 99%;
				margin:10px auto;
			}
			.page-header {
				color:#686868 ;
				margin-botton:5px;
			}
			.footer-div {
				border-radius: 5px;
				background:#3a3a3a;
				padding: 20px 1.2%;
				width: 97%;
				height: auto;
				overflow:hidden;
				border-bottom:5px solid #1e1e1e ;
				margin-bottom : 25px;
				font-size : 20px;
				font-family : 'gibsonsemibold' ;
			}
			.footer-one{
				width:65%;
				float:left;
				border-right : 1px solid  #434343 ;
				height : auto;
				padding: 10px 50px;
			}
			.footer-two{
				width:15%;
				float:left;
				height : auto;
				padding: 10px 50px;
			}
			.copyright{
				width:100%;
				text-align:center;
				margin-bottom : 25px;
			}

			@font-face {
				font-family: 'gibsonregular';
				src: url('<?php echo $link; ?>fonts/gibson/Gibson-Regular.otf');
			}
			@font-face {
				font-family: 'gibsonsemibold';
				src: url('<?php echo $link; ?>fonts/gibson/Gibson-SemiBold.otf');
			}
			.footer-span-one{
				color:#fff;
				font-size:24px;
			}
			.footer-span-two{
				color:#ffaa00;
				font-size:24px;
			}
			.footer-div-two{
				margin-top:30px;
				margin-bottom:30px;
				font-size:18px;
				font-family : gibsonregular ;
				height:auto;
				overflow:hidden;
			}
			.footer-div-two-span1{
				color:#ffaa00;
				font-family : gibsonsemibold ;
			}
			.footer-div-two-span2{
				color:#fff;
				font-family : gibsonregular ;
				margin-left:10px;
			}
			.footer-div-two-span2 a{
				color:#fff;
				font-family : gibsonregular ;
				margin-left:10px;
				text-decoration : none;
			}
			.footer-div-two-inner{
				padding-bottom : 15px;
				float:left;
				width:100%;
			}
			.login-form-div{
				padding:10px 0;
			}
			.login-form-div input{
				margin : 10px 0;
				height : 25px;
			}
			.account-details-div table{
				border-collapse: collapse ;
				border:#fff;
			}
			.account-details-div table th{
				padding:15px 0;
				font-size : 14px;
				background-color : #efedee ;
				border:1px solid #fff;
			}

			.account-details-div table td{
				padding:10px 0;
				background-color : #fff ;
				border:1px solid #efedee;
			}
			.navigater li
			{
				display:inline;
				text-decoration:none;
			}
			.navigater li a{
				text-decoration: none;
				padding: 3px 5px 3px 3px;
				margin: 3px;
				border: 1px solid #AAAADD;
				color:#666;
			}
			.nav_left
			{
				width:30%;
				float:left;
			}
			.nav_right
			{
				width:60%;
				float:left;
			}
			.navigater{margin:10px -37px;}
			.txtcolor2{ color : #854e9f ; font-size : 18px; }
			#listhead{
				float:left;
				width:100%;
				border:1px solid #fff;
			}
			#listitems {
				float:left;
				width:100%;
			}
			.ap_left{
				margin: 10px 0;
				width:50%;
			}
			#add_edit_task{
				margin: 20px 0;
			}
			#add_edit_task input,#add_edit_task textarea ,#add_edit_task select{
				width : 250px;
				margin: 5px 0;
				min-height:25px;
			}
			.ap_right{
				float:left;
				width:40%;
			}
			.report-div{
				height:auto;
				overflow:hidden;
				width:100%;
				float:left;
			}
			.report-details1{
				width:48%;
				/*border : 1px solid red;*/
				float:left;
				padding:15px 0;
				font-size:18px;
				vertical-align:middle;
			}
			.report-details2{
				width:52%;
				/*border : 1px solid red;*/
				float:right;
				padding:15px 0;
				vertical-align:middle;
				font-size:18px;
			}
			.report-details2 select{
				height:25px;
			}
			.report-div-one{
				width:100%;
				border-bottom:2px solid #854e9f ;
				height:auto;
				overflow:hidden;
				vertical-align:middle;
				margin-bottom : 5px;
			}
			.report-div-two{
				width:100%;
				border-bottom:2px solid #854e9f ;
				height:auto;
				overflow:hidden;
				vertical-align:middle;
				height:auto;
				overflow:hidden;
			}
			.submit_button{
				margin-top:10px;
			}
			.report-details1{
				line-height:120%;
			}

			.report-details2 div{
				float:left;
				margin-right : 5px;
			}
			.report-details-1-1{
				float:left;
				width:14%;
				padding-right:5px;
			}
			.report-details-1-2{
				float:left;
				width:82%;

			}
			.report-details-1 , .report-details-2{
				width:48%;
				float:left;
				margin-top:10px;
				line-height:120%;
			}
			.report-details2 input{
				margin-top:0px;
			}

			table{

	table-layout: fixed;
	width: 100%;
	white-space: wrap;
}
td{
	white-space: wrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

            #additional_sections {
             
                width : 100%;
                height : auto;
                overflow : hidden ;
            }
            #additional_sections_form_div {
                margin : 10px;
                width : 100%;
                height : auto;
                overflow : hidden ;
            }
            #additional_sections_form_div div{
                margin : 10px ;
                float:left;
                padding:0px 5px;
            }
            #additional_sections_form_error{
                color:#DC143C ;
            }

<?php

if($page=="managementReports.php"){

?>
			.account_name{
				text-transform: capitalize;
			}
			.report_head{
				float: left;
				width: 100%;
				background: none repeat scroll 0 0 #eaeaea;
				font-size: 12px;
				text-align: left;
				word-wrap: break-word;

			}
			.summery_report_head{
				float: left;
				width: 100%;
				background: none repeat scroll 0 0 #eaeaea;
				font-size: 12px;
				word-wrap: break-word;
				padding:5px 0px;
			}
			.report_single_head{
				float: left;
				width: 5%;
				padding: 0.1px;
			}
			.report_single_head_dual{
				float: left;
				width: 7.2%;
			}
			.this_prev_head{
				width:100%;
				float:left;
				text-align: center;
			}
			.this_month{
				width:50%;
				float:left;
				height:50%;
				text-align: left;
			}
			.prev_month{
				width:50%;
				float:left;
				height:50%;
				text-align: left;
			}
			.summery_report_single_head{
				float: left;
				width: 50%;
			}
			.report_feed{
				float: left;
				width: 100%;
				background: none repeat scroll 0 0 #fff;
				display: none;
				border-bottom: 2px solid rgb(241, 241, 241);
			}
			.summery_report_feed{
				float: left;
				width: 100%;
				background: none repeat scroll 0 0 #fff;
				display: none;
				word-wrap: break-word;
				border-bottom: 2px solid rgb(241, 241, 241);
			}
			.report_single_feed{
				float: left;
				width: 5%;
				font-size: 12px;
				word-wrap: break-word;
			}
			.summery_report_single_feed{
				float: left;
				width: 50%;
				font-size: 12px;
				word-wrap: break-word;
			}
			.hidden_div{
				height: 0px;
				width: 0px;
				display: none;
			}
			.report_loader{
				width: 100%;
				display: none;
			}
			.report_loader img{
				width: 10%;
			}
			#daily_report_view .report_loader img{
				width: 3%;
			}
			.show_message{
				display: none;
				float: left;
				width: 100%;
			}
			#report_view{
				width:100%;
				float: left;
				overflow: hidden;
			}
			#daily_report_view{
				display: none;
			}
			#summery_report_view{
				width:33%;
				float: left;
				display: none;
			}
			#biggest_underspends_report{
				width:32.4%;
				float: left;
				display: none;
				margin-left: 10px;
			}
			.biggest_underspends_report_head{
				float: left;
				width: 100%;
				background: none repeat scroll 0 0 #eaeaea;
				font-size: 12px;
				word-wrap: break-word;
				padding : 5px 0;
			}
			.biggest_underspends_report_single_head{
				float: left;
				width: 50%;
			}
			.biggest_underspends_report_feed{
				float: left;
				width: 100%;
				background: none repeat scroll 0 0 #fff;
				display: none;
				word-wrap: break-word;
				border-bottom: 2px solid rgb(241, 241, 241);
			}
			.biggest_underspends_report_single_feed{
				float: left;
				width: 50%;
				font-size: 12px;
				word-wrap: break-word;
			}
			#biggest_increase_in_cpc_report{
				width:33%;
				float: left;
				display: none;
				margin-left: 10px;
			}
			.biggest_increase_in_cpc_report_head{
				float: left;
				width: 100%;
				background: none repeat scroll 0 0 #eaeaea;
				font-size: 12px;
				word-wrap: break-word;
			}
			.biggest_increase_in_cpc_report_single_head{
				float: left;
				width: 50%;
				padding : 5px 0 ;
			}
			.biggest_increase_in_cpc_report_feed{
				float: left;
				width: 100%;
				background: none repeat scroll 0 0 #fff;
				display: none;
				word-wrap: break-word;
				border-bottom: 2px solid rgb(241, 241, 241);
			}
			.biggest_increase_in_cpc_report_single_feed{
				float: left;
				width: 50%;
				font-size: 12px;
				word-wrap: break-word;
			}
			.over {
				z-index: 100000;
				width:500px;
			}
			.report_single_feed div:hover .over {
				display: block;
			}

			div.report_single_feed {

			}
			div.report_single_feed:hover {
				text-decoration: none;
				background: #ffffff;
				z-index: 6;
			}
			div.report_single_feed span {
				background-color: #40e0d0;
				color: #ffffff;
				font-size: 20px;
				position: absolute;
				left: -9999px;
				margin: 20px 0 0 0px;
				padding: 3px 3px 3px 3px;
				border-style:solid;
				border-color:black;
				border-width:1px;
				z-index: 6;
			}
			div.report_single_feed:hover span {
				left: 2%;
				/*background: #ffffff;*/
			}
			div.report_single_feed span {
				position: absolute;
				left: -9999px;
				margin: 4px 0 0 0px;
				padding: 3px 3px 3px 3px;
				border-style:solid;
				border-color:black;
				border-width:1px;
			}
			div.report_single_feed:hover span {
				margin: 20px 0 0 170px;
				/*background: #ffffff;*/
				z-index:6;
			}
			div.report_single_feed:nth-child(2) div {
				text-decoration: underline;
			}
			div.report_single_feed:hover div{
				text-decoration: none;
			}
			#worst_5_with_biggest_decrease_in_visitors_report{
				width:33%;
				float: left;
				display: none;
			}
			.worst_5_with_biggest_decrease_in_visitors_report_head{
				float: left;
				width: 100%;
				background: none repeat scroll 0 0 #eaeaea;
				font-size: 12px;
				word-wrap: break-word;
				padding:5px 0;
			}
			.worst_5_with_biggest_decrease_in_visitors_report_single_head{
				float: left;
				width: 50%;
			}
			.worst_5_with_biggest_decrease_in_visitors_report_feed{
				float: left;
				width: 100%;
				background: none repeat scroll 0 0 #fff;
				display: none;
				word-wrap: break-word;
				border-bottom: 2px solid rgb(241, 241, 241);
			}
			.worst_5_with_biggest_decrease_in_visitors_report_single_feed{
				float: left;
				width: 50%;
				font-size: 12px;
				word-wrap: break-word;
			}
			#best_decrease_in_cpc_report{
				width:33%;
				float: left;
				display: none;
				margin-left: 10px;
			}
			.best_decrease_in_cpc_report_head{
				float: left;
				width: 100%;
				background: none repeat scroll 0 0 #eaeaea;
				font-size: 12px;
				word-wrap: break-word;
				padding:5px 0;
			}
			.best_decrease_in_cpc_report_single_head{
				float: left;
				width: 50%;
			}
			.best_decrease_in_cpc_report_feed{
				float: left;
				width: 100%;
				background: none repeat scroll 0 0 #fff;
				display: none;
				word-wrap: break-word;
				border-bottom: 2px solid rgb(241, 241, 241);
			}
			.best_decrease_in_cpc_report_single_feed{
				float: left;
				width: 50%;
				font-size: 12px;
				word-wrap: break-word;
			}
			#biggest_overspends_report{
				width:32.4%;
				float: left;
				display: none;
				margin-left: 10px;
			}
			.biggest_overspends_report_head{
				float: left;
				width: 100%;
				background: none repeat scroll 0 0 #eaeaea;
				font-size: 12px;
				word-wrap: break-word;
				padding:5px 0;
			}
			.biggest_overspends_report_single_head{
				float: left;
				width: 50%;
			}
			.biggest_overspends_report_feed{
				float: left;
				width: 100%;
				background: none repeat scroll 0 0 #fff;
				display: none;
				word-wrap: break-word;
				border-bottom: 2px solid rgb(241, 241, 241);
			}
			.biggest_overspends_report_single_feed{
				float: left;
				width: 50%;
				font-size: 12px;
				word-wrap: break-word;
			}
			#biggest_gaiin_in_expected_conversions_report{
				width:33%;
				float: left;
				display: none;
			}
			.biggest_gaiin_in_expected_conversions_report_head{
				float: left;
				width: 100%;
				background: none repeat scroll 0 0 #eaeaea;
				font-size: 12px;
				word-wrap: break-word;
				padding:5px 0;
			}
			.biggest_gaiin_in_expected_conversions_report_single_head{
				float: left;
				width: 50%;
			}
			.biggest_gaiin_in_expected_conversions_report_feed{
				float: left;
				width: 100%;
				background: none repeat scroll 0 0 #fff;
				display: none;
				word-wrap: break-word;
				border-bottom: 2px solid rgb(241, 241, 241);
			}
			.biggest_gaiin_in_expected_conversions_report_single_feed{
				float: left;
				width: 50%;
				font-size: 12px;
				word-wrap: break-word;
			}
			#biggest_change_in_cpa_report{
				width:33%;
				float: left;
				display: none;
				margin-left: 10px;
			}
			.biggest_change_in_cpa_report_head{
				float: left;
				width: 100%;
				background: none repeat scroll 0 0 #eaeaea;
				font-size: 12px;
				word-wrap: break-word;
				padding:5px 0;
			}
			.biggest_change_in_cpa_report_single_head{
				float: left;
				width: 50%;
			}
			.biggest_change_in_cpa_report_feed{
				float: left;
				width: 100%;
				background: none repeat scroll 0 0 #fff;
				display: none;
				word-wrap: break-word;
				border-bottom: 2px solid rgb(241, 241, 241);
			}
			.biggest_change_in_cpa_report_single_feed{
				float: left;
				width: 50%;
				font-size: 12px;
				word-wrap: break-word;
			}
			#worst_drop_in_expected_conversions_report{
				width:33%;
				float: left;
				display: none;
			}
			.worst_drop_in_expected_conversions_report_head{
				float: left;
				width: 100%;
				background: none repeat scroll 0 0 #eaeaea;
				font-size: 12px;
				word-wrap: break-word;
				padding:5px 0;
			}
			.worst_drop_in_expected_conversions_report_single_head{
				float: left;
				width: 50%;
			}
			.worst_drop_in_expected_conversions_report_feed{
				float: left;
				width: 100%;
				background: none repeat scroll 0 0 #fff;
				display: none;
				word-wrap: break-word;
				border-bottom: 2px solid rgb(241, 241, 241);
			}
			.worst_drop_in_expected_conversions_report_single_feed{
				float: left;
				width: 50%;
				font-size: 12px;
				word-wrap: break-word;
			}
			#best_change_in_cpa_report{
				width:33%;
				float: left;
				display: none;
				margin-left: 10px;
			}
			.best_change_in_cpa_report_head{
				float: left;
				width: 100%;
				background: none repeat scroll 0 0 #eaeaea;
				font-size: 12px;
				word-wrap: break-word;
				padding:5px 0;
			}
			.best_change_in_cpa_report_single_head{
				float: left;
				width: 50%;
			}
			.best_change_in_cpa_report_feed{
				float: left;
				width: 100%;
				background: none repeat scroll 0 0 #fff;
				display: none;
				word-wrap: break-word;
				border-bottom: 2px solid rgb(241, 241, 241);
			}
			.best_change_in_cpa_report_single_feed{
				float: left;
				width: 50%;
				font-size: 12px;
				word-wrap: break-word;
			}

			.rep_head{
				width: 100%;
				text-align: center;
				background: none repeat scroll 0 0 #eaeaea;
			}
			.common_wrapper{
				width: 102%;
				float: left;
				overflow: hidden;
				margin: 0 auto;
				margin-top: 10px;
			}

			/* Deepa */
			.common_wrapper div{
				padding-top : 5px;
			}

			.report_single_feed div:hover .over {
				display: block;
			}

			div.report_single_feed {

			}
			div.popclient:hover {
				text-decoration: none;
				background: #ffffff;
				z-index: 6;
			}
			div.popclient span {
				background-color: #40e0d0;
				color: #ffffff;
				font-size: 20px;
				position: absolute;
				left: -9999px;
				margin: 20px 0 0 0px;
				padding: 3px 3px 3px 3px;
				border-style:solid;
				border-color:black;
				border-width:1px;
				z-index: 6;
			}
			div.popclient:hover span {
				left: 2%;
				/*background: #ffffff;*/
			}
			div.popclient span {
				position: absolute;
				left: -9999px;
				margin: 4px 0 0 0px;
				padding: 3px 3px 3px 3px;
				border-style:solid;
				border-color:black;
				border-width:1px;
			}
			div.popclient:hover span {
				margin: 20px 0 0 170px;
				/*background: #ffffff;*/
				z-index:6;
			}
			div.popclient:nth-child(2) div {
				text-decoration: underline;
			}
			div.popclient:hover div{
				text-decoration: none;
			}
<?php
	}
?>




        </style>
        
	
        
        
        
		<?php include("javascript.php"); ?>

    </head>
    <body>
        <div class="main_container">
			<div class="header">
				<div class="constant-header">
					<div class="logo"></div>
					<div class="welcome">
					<?php if($page=='account_details.php'||$page=='reports.php'||$page=='customer_report.php'){ ?>
					Customer : <?php echo $_SESSION['descriptiveName'] ;  ?> ( <?php echo $_SESSION['ad_mcc_id'] ;  ?> ) <?php echo $pros ;  ?>
					<?php } ?>

					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if($page<>"index.php") { ?>Welcome <?php echo $_SESSION['user_name'] ?>&nbsp&nbsp |&nbsp&nbsp <a href="<?php echo $link ; ?>logout.php" >Logout </a> &nbsp;<?php } ?></div>
				</div>
				<div class="header-menu">
				<?php if($page<>"index.php") { ?>
				<div class="menu">
                                    <ul class="top-menu">
                                            <li <?php if($page=="account_details.php" ||$page=="customers.php") { ?>
                                                style="color:#b069d1;" <?php }?> >
                                                <a href="<?php echo $link ; ?>customers.php">Account&nbsp;Details</a></li>
                                            <?php if($_SESSION['user_type']==2 || $_SESSION['user_type']==1 ) { ?>
                                                <li  <?php if($page=="change_histry.php") { ?>
                                                    style="color:#b069d1;" <?php }?> >
                                                    <a href="<?php echo $link ; ?>change_history.php">Change&nbsp;History</a></li> <?php } ?>
													
													   <li  <?php if($page=="budget_order.php") { ?>
                                                    style="color:#b069d1;" <?php }?> >
                                                    <a href="<?php echo $link ; ?>budget_order.php">Budget Order</a></li>
                                                <?php if($_SESSION['user_type']==2) { ?>
                                                <!--li  <?php if($page=="danger_list.php") { ?>
                                                    style="color:#b069d1;" <?php }?> >
                                                    <a href="<?php echo $link ; ?>danger/danger_list.php">Danger&nbsp;List<sup style="color:red"><small>25</small></sup></a></li --> <?php } ?>
											 <?php if($_SESSION['user_type']==2) { ?>
                                                <li  <?php if($page=="task_manager.php") { ?>
                                                    style="color:#b069d1;" <?php }?> >
                                                    <a href="<?php echo $link ; ?>task_manager/task_manager.php">Task&nbsp;Manager</a></li> <?php } ?>
                                            <?php if($_SESSION['user_type'] <> 4) { ?>
                                                <li  <?php if($page=="managementReports.php") { ?>
                                                    style="color:#b069d1;" <?php }?> >
                                                    <a href="<?php echo $link ; ?>reportmanagement/managementReports.php">Daily&nbsp;Projections</a></li><?php } ?>
                                            <?php if($_SESSION['user_type'] == 2) { ?>
                                                <li  <?php if($page=="user_manager.php") { ?>
                                                    style="color:#b069d1;" <?php }?>>
                                                    <a href="<?php echo $link ; ?>user_manager/user_manager.php">User&nbsp;Manager</a></li><?php } ?>
                                            <?php if($_SESSION['user_type'] == 2) { ?>
                                                <li  <?php if($page=="login_list.php") { ?>
                                                    style="color:#b069d1;" <?php }?>>
                                                    <a href="<?php echo $link ; ?>statistics/login_list.php">Login&nbsp;Statistics</a></li><?php } ?>
                                                <li <?php if($page=="tool.php") { ?>
                                                    style="color:#b069d1;" <?php }?>><a href="<?php echo $link ; ?>KWTool/tool.php">Keyword Tool</a></li>
                                    </ul>

				</div>
                                <div class="search">
                                    <input type="text" placeholder="Search Accounts" id="search_term"
                                           value="<?php echo $_REQUEST['search_term']; ?>" /> &nbsp;
                                    <input type="button" value="Go" onclick="goToChangeReports()" id="srchBtn"
                                           style="cursor:pointer;" />
                                </div>
				</div>
				<?php } ?>
			</div>
						<!-----  Report Container  ------>
			<div class="content-div">
