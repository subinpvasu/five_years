<?php
/**
 * This file will display reports for the logged in user.
 */
include_once '../includes/config.php';
include_once './CustomClasses/Constants.php';
use CustomClasses\Constants;
if(!isset($_SESSION)){
    session_start();
}
if(!isset($_SESSION['user_name'])){ header("Location: ../index.php");}
$user = (isset($_SESSION['user_name'])&&$_SESSION['user_name']!='')?$_SESSION['user_name']:'';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Management Reports</title>

<link rel="stylesheet" type="text/css" href="../css/ricky.css">
<style>
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
        width: 100%;
        float: left;
        overflow: hidden;
        margin: 0 auto;
        margin-top: 10px;
    }
	
	/* Deepa */
	
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

</style>
<script src="../js/jquery.min.js"></script>
<script src="../js/jquery-1.7.1.min.js"></script>
<script>
/* $(document).ready(function(){
  $("#search_term").keyup(function(event){
    if(event.keyCode == 13){
        $("#srchBtn").click();
    }
});
});

 */
function goToChangeReports(){

var search_term = $("#search_term").val();

window.open('account_details.php?msg=Search&search_term='+search_term,'_self')

}

function getDeviceReport(){

	var devices = $("#devices").val();
	if(devices=='Select'){alert('Select a device'); }
	
	else {
	
	
	$.post('servicefiles/kd_reports.php',{devices:devices},function(data){
			
		$("#listitems").html(data['str']);
			
		},'json');
	
	
	}

}

</script>
</head>
<body>

<div class="master">


<header>
<?php include('../search_accounts.php'); ?>
<?php

include('../top_menu.php');
?>

</header>
<div class="logo">
<img src="../img/logo.png"/>

<div class="account_name">
    <?= $user; ?>
</div>
</div>

<div class="adsharegap">
<div class="ap_left">
<b id="report_name">
</b>&nbsp;
</div>

<div class="ap_right">
<div class="right_sub_div" style="width:25%">
<form action='reports.php' method ='get' class='reportForm'>
<input type='hidden' name='id' value='<?php echo '$id'; ?>' />
<span class="txtcolor2">Select</span> Report Type :</div>
<div class="selection_ext" style="float:left;">
<select name='type' id="report_select">
<?php
foreach(Constants::$REPOTRS as $key=>$val){

if($_SESSION[Constants::$SESSION_USER_TYPE]==3 && $key==1){
}
else{
?>
<option value='<?php echo $key ; ?>'><?php echo $val; ?></option>

<?php 
}}
?>
</select>

</div>

</form>
</div>

</div>
<div class="ad_potential">
<div class="adp_left">


</div>
<div class="adp_right">

</div>

</div>
    
    <div id="report_view">
        
    <div style="width:100%;" id="daily_report_view" >
        <div style="" class="report_head">
            <div class="report_single_head" style="width: 4%;">Manager</div>
            <div class="report_single_head"  style="width:5%;">Client</div>
            <div class="report_single_head" style="width:4%;">Budget</div>
            <div class="report_single_head_dual" style="width: 6.5%;">
                <div class="this_prev_head" >PPC Visitors</div>
                <div class="prev_month" >January</div>
                <div class="this_month" >Februvary</div>
            </div>
            <div class="report_single_head">% @ This Point on Last Month</div>
            <div class="report_single_head_dual" style="width: 6%;">
                <div class="this_prev_head" >CPC</div>
                <div class="prev_month" >January</div>
                <div class="this_month" >Februvary</div>
            </div>
            <div class="report_single_head" style="width: 4%;">Change in CPC</div>
            <div class="report_single_head_dual" style="/*width: 6%;*/">
                <div class="this_prev_head" >PPC Spend</div>
                <div class="prev_month" >January</div>
                <div class="this_month" >Februvary</div>
            </div>
            <div class="report_single_head">REMAINING BUDGET</div>
            <div class="report_single_head">Remaining Budget @ PPC Spend</div>
            <div class="report_single_head" style="width: 4%;">Daily Budget</div>
            <div class="report_single_head">Avg. Daily Spends MTD</div>
            <div class="report_single_head">+/-  Daily Budget Available</div>
            <div class="report_single_head" style="width: 4%;">Yesterday Spends</div>
            <div class="report_single_head_dual" style="/*width: 5%;*/">
                <div class="this_prev_head" >AdWords Conversions</div>
                <div class="prev_month" >January</div>
                <div class="this_month" >Februvary</div>
            </div>
            <div class="report_single_head">Conversions @ Current Rate</div>
            <div class="report_single_head">% On Last Month @ Current Rate</div>
            <div class="report_single_head_dual" style="width:6%;">
                <div class="this_prev_head">PPC CPA</div>
                <div class="prev_month" >January</div>
                <div class="this_month" >Februvary</div>
            </div>
            <div class="report_single_head">Change in CPA</div>
        </div>		
        <div class="report_loader"><img src="../img/loading.gif" /></div>
        <div class="show_message">&nbsp;</div>
        <div style="" class="report_feed">
            <div class="report_single_feed" style="width: 4%;">Manager</div>
            <div class="report_single_feed" style="width:5%;">
                <div >Client</div>
                <span class="over">123</span>
            </div>
            <div class="report_single_feed"  style="width:4%;">Budget</div>
            <div class="report_single_feed" style="width:3.25%;">January</div>
            <div class="report_single_feed" style="width:3.25%;">February</div>
            <div class="report_single_feed">% @ This Point on Last Month</div>
            <div class="report_single_feed" style="width:3%;">January</div>
            <div class="report_single_feed" style="width:3%;">February</div>
            <div class="report_single_feed" style="width: 4%;">Change in CPC</div>
            <div class="report_single_feed" style="width:3.6%;">January</div>
            <div class="report_single_feed" style="width:3.6%;">February</div>
            <div class="report_single_feed">REMAINING BUDGET</div>
            <div class="report_single_feed">Remaining Budget @ PPC Spend</div>
            <div class="report_single_feed" style="width: 4%;">Daily Budget</div>
            <div class="report_single_feed">Avg. Daily Spends MTD</div>
            <div class="report_single_feed">+/-  Daily Budget Available</div>
            <div class="report_single_feed" style="width: 4%;">Yesterday Spends</div>
            <div class="report_single_feed" style="width: 3.6%;">January</div>
            <div class="report_single_feed" style="width: 3.6%;">February</div>
            <div class="report_single_feed">Conversions @ Current Rate</div>
            <div class="report_single_feed">Percent On Last Month @ Current Rate</div>
            <div class="report_single_feed" style="width: 3%;">January</div>
            <div class="report_single_feed" style="width: 3%;">February</div>
            <div class="report_single_feed">Change in CPA</div>
        </div>		
    </div>
        <div class="common_wrapper">
            <div id="summery_report_view" >
                <div class="rep_head">Top 5 with Biggest Increase in visitors</div>
                <div style="" class="summery_report_head">
                    <div class="summery_report_single_head">Client Name</div>
                    <div class="summery_report_single_head">% Visitors to Last Month</div>
                </div>
                <div class="report_loader" ><img src="../img/loading.gif"></div>
                <div class="show_message">&nbsp;</div>
                <div style="" class="summery_report_feed">
                    <div class="summery_report_single_feed popclient">Client Id</div>
                    <div class="summery_report_single_feed">Client Id</div>
                </div>		
            </div>
            <div style="" id="biggest_increase_in_cpc_report" >
                <div class="rep_head">Biggest Increases in CPC</div>
                <div style="" class="biggest_increase_in_cpc_report_head">
                    <div class="biggest_increase_in_cpc_report_single_head">Client Name</div>
                    <div class="biggest_increase_in_cpc_report_single_head">CPC Diff</div>
                </div>
                <div class="report_loader" ><img src="../img/loading.gif"></div>
                <div class="show_message">&nbsp;</div>
                <div style="" class="biggest_increase_in_cpc_report_feed">
                    <div class="biggest_increase_in_cpc_report_single_feed popclient">Client Id</div>
                    <div class="biggest_increase_in_cpc_report_single_feed">Client Id</div>
                </div>
            </div>

            <div style="" id="biggest_underspends_report" >
                <div class="rep_head">Biggest Underspends</div>
                <div style="" class="biggest_underspends_report_head">
                    <div class="biggest_underspends_report_single_head">Client Name</div>
                    <div class="biggest_underspends_report_single_head">Remaining Spends</div>
                </div>		
                <div class="report_loader" ><img src="../img/loading.gif"></div>
                <div class="show_message">&nbsp;</div>
                <div style="" class="biggest_underspends_report_feed">
                    <div class="biggest_underspends_report_single_feed popclient">Client Id</div>
                    <div class="biggest_underspends_report_single_feed">Client Id</div>
                </div>		
            </div>
        </div>
    
        <div class="common_wrapper">
            <div style="" id="worst_5_with_biggest_decrease_in_visitors_report" >
                <div class="rep_head">Worst 5 with biggest decrease in visitors</div>
                <div style="" class="worst_5_with_biggest_decrease_in_visitors_report_head">
                    <div class="worst_5_with_biggest_decrease_in_visitors_report_single_head">Client Name</div>
                    <div class="worst_5_with_biggest_decrease_in_visitors_report_single_head">% Visitors to Last Month</div>
                </div>		
                <div class="report_loader" ><img src="../img/loading.gif"></div>
                <div class="show_message">&nbsp;</div>
                <div style="" class="worst_5_with_biggest_decrease_in_visitors_report_feed">
                    <div class="worst_5_with_biggest_decrease_in_visitors_report_single_feed popclient">Client Id</div>
                    <div class="worst_5_with_biggest_decrease_in_visitors_report_single_feed">Client Id</div>
                </div>		
            </div>

            <div style="" id="best_decrease_in_cpc_report" >
                <div class="rep_head">Best Decreases in CPC</div>
                <div style="" class="best_decrease_in_cpc_report_head">
                    <div class="best_decrease_in_cpc_report_single_head">Client Name</div>
                    <div class="best_decrease_in_cpc_report_single_head">CPC Diff</div>
                </div>		
                <div class="report_loader" ><img src="../img/loading.gif"></div>
                <div class="show_message">&nbsp;</div>
                <div style="" class="best_decrease_in_cpc_report_feed">
                    <div class="best_decrease_in_cpc_report_single_feed popclient">Client Id</div>
                    <div class="best_decrease_in_cpc_report_single_feed">Client Id</div>
                </div>		
            </div>

            <div style="" id="biggest_overspends_report" >
                <div class="rep_head">Biggest Overspends</div>
                <div style="" class="biggest_overspends_report_head">
                    <div class="biggest_overspends_report_single_head">Client Name</div>
                    <div class="biggest_overspends_report_single_head">Remaining Spends</div>
                </div>	
                <div class="report_loader" ><img src="../img/loading.gif"></div>
                <div class="show_message">&nbsp;</div>
                <div style="" class="biggest_overspends_report_feed">
                    <div class="biggest_overspends_report_single_feed popclient">Client Id</div>
                    <div class="biggest_overspends_report_single_feed">Client Id</div>
                </div>		
            </div>
        </div>
    
        <div class="common_wrapper">
            <div style="" id="biggest_gaiin_in_expected_conversions_report" >
                <div class="rep_head">Biggest Gain in Expected Conversions</div>
                <div style="" class="biggest_gaiin_in_expected_conversions_report_head">
                    <div class="biggest_gaiin_in_expected_conversions_report_single_head">Client Name</div>
                    <div class="biggest_gaiin_in_expected_conversions_report_single_head">% Conversions to Last Month</div>
                </div>		
                <div class="report_loader" ><img src="../img/loading.gif"></div>
                <div class="show_message">&nbsp;</div>
                <div style="" class="biggest_gaiin_in_expected_conversions_report_feed">
                    <div class="biggest_gaiin_in_expected_conversions_report_single_feed popclient">Client Id</div>
                    <div class="biggest_gaiin_in_expected_conversions_report_single_feed">Client Id</div>
                </div>		
            </div>

            <div style="" id="biggest_change_in_cpa_report" >
                <div class="rep_head">Biggest Change in CPA</div>
                <div style="" class="biggest_change_in_cpa_report_head">
                    <div class="biggest_change_in_cpa_report_single_head">Client Name</div>
                    <div class="biggest_change_in_cpa_report_single_head">CPC Change</div>
                </div>	
                <div class="report_loader" ><img src="../img/loading.gif"></div>
                <div class="show_message">&nbsp;</div>
                <div style="" class="biggest_change_in_cpa_report_feed">
                    <div class="biggest_change_in_cpa_report_single_feed popclient">Client Id</div>
                    <div class="biggest_change_in_cpa_report_single_feed">Client Id</div>
                </div>		
            </div>
        </div>
    
    
        <!--<div class="free_space">&nbsp;</div>-->
    
        <div class="common_wrapper">
            <div style="" id="worst_drop_in_expected_conversions_report" >
                <div class="rep_head">Worst drop in expected conversions</div>
                <div style="" class="worst_drop_in_expected_conversions_report_head">
                    <div class="worst_drop_in_expected_conversions_report_single_head">Client Name</div>
                    <div class="worst_drop_in_expected_conversions_report_single_head">% Conversions to Last Month</div>
                </div>	
                <div class="report_loader" ><img src="../img/loading.gif"></div>
                <div class="show_message">&nbsp;</div>
                <div style="" class="worst_drop_in_expected_conversions_report_feed">
                    <div class="worst_drop_in_expected_conversions_report_single_feed popclient">Client Id</div>
                    <div class="worst_drop_in_expected_conversions_report_single_feed">Client Id</div>
                </div>		
            </div>

            <div style="" id="best_change_in_cpa_report" >
                <div class="rep_head">Best Change in CPA</div>
                <div style="" class="best_change_in_cpa_report_head">
                    <div class="best_change_in_cpa_report_single_head">Client Name</div>
                    <div class="best_change_in_cpa_report_single_head">CPA Change</div>
                </div>
                <div class="report_loader" ><img src="../img/loading.gif"></div>
                <div class="show_message">&nbsp;</div>
                <div style="" class="best_change_in_cpa_report_feed">
                    <div class="best_change_in_cpa_report_single_feed popclient">Client Id</div>
                    <div class="best_change_in_cpa_report_single_feed">Client Id</div>
                </div>		
            </div>
        </div>
    
        
    </div>
	<div style="float:left;"> 
<?php include('../footer.php'); ?>
</div>

</div>

    <div class="hidden_div">
        <input type="hidden" name="IHUserName" id="IHUserName" value="<?= $user ?>" />
    </div>
    
<script type="text/javascript">
    
    var DISPLAY_NONE = "none";
    var DISPLAY_BLOCK = "block";
    var DISPLAY = "display";
    var DAILY_REPORT = "Daily Reports";
    var SUMMARY_REPORT = "Summary Reports";
    var RED_COLOUR = "#dd7e6b";
    var GREEN_COLOUR = "#b6d7a8";
    var d = new Date();
    var month = new Array();
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "June";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";
    var thisMonth;
    var prevMonth;
    $(document).ready(function (){
        if(d.getMonth()==0){
            prevMonth = month[11];
            thisMonth = month[d.getMonth()];
        }else{
            prevMonth = month[d.getMonth()-1];
            thisMonth = month[d.getMonth()];
        }
        $(".this_month").text(thisMonth);
        $(".prev_month").text(prevMonth);
        $("#report_name").text(DAILY_REPORT);
        $(".common_wrapper").fadeOut(100);
        ajaxReadReports(11,".report_feed",".report_single_feed","#daily_report_view");
    });
    
    
    $("#report_select").change(function(){
        $("#summery_report_view").fadeOut(100);
        $("#daily_report_view").fadeOut(100);
        $("#biggest_increase_in_cpc_report").fadeOut(100);
        $("#biggest_underspends_report").fadeOut(100);
        $("#worst_5_with_biggest_decrease_in_visitors_report").fadeOut(100);
        $("#best_decrease_in_cpc_report").fadeOut(100);
        $("#biggest_overspends_report").fadeOut(100);
        $("#biggest_gaiin_in_expected_conversions_report").fadeOut(100);
        $("#biggest_change_in_cpa_report").fadeOut(100);
        $("#worst_drop_in_expected_conversions_report").fadeOut(100);
        $("#best_change_in_cpa_report").fadeOut(100);
        $(".common_wrapper").fadeOut(100);
        
        if($(this).val()==11){
            $("#report_name").text(DAILY_REPORT);
            ajaxReadReports($(this).val(),".report_feed",".report_single_feed","#daily_report_view");
        }else if($(this).val()==1){
            $(".common_wrapper").fadeIn(1);
            $("#report_name").text(SUMMARY_REPORT);
            ajaxReadReports(1,'#summery_report_view .summery_report_feed',".summery_report_single_feed","#summery_report_view");
            ajaxReadReports(2,'#biggest_increase_in_cpc_report .biggest_increase_in_cpc_report_feed',".biggest_increase_in_cpc_report_single_feed","#biggest_increase_in_cpc_report");
            ajaxReadReports(3,'#biggest_underspends_report .biggest_underspends_report_feed',".biggest_underspends_report_single_feed","#biggest_underspends_report");
            ajaxReadReports(4,'#worst_5_with_biggest_decrease_in_visitors_report .worst_5_with_biggest_decrease_in_visitors_report_feed',".worst_5_with_biggest_decrease_in_visitors_report_single_feed","#worst_5_with_biggest_decrease_in_visitors_report");
            ajaxReadReports(5,'#best_decrease_in_cpc_report .best_decrease_in_cpc_report_feed',".best_decrease_in_cpc_report_single_feed","#best_decrease_in_cpc_report");
            ajaxReadReports(6,'#biggest_overspends_report .biggest_overspends_report_feed',".biggest_overspends_report_single_feed","#biggest_overspends_report");
            ajaxReadReports(7,'#biggest_gaiin_in_expected_conversions_report .biggest_gaiin_in_expected_conversions_report_feed',".biggest_gaiin_in_expected_conversions_report_single_feed","#biggest_gaiin_in_expected_conversions_report");
            ajaxReadReports(8,'#biggest_change_in_cpa_report .biggest_change_in_cpa_report_feed',".biggest_change_in_cpa_report_single_feed","#biggest_change_in_cpa_report");
            ajaxReadReports(9,'#worst_drop_in_expected_conversions_report .worst_drop_in_expected_conversions_report_feed',".worst_drop_in_expected_conversions_report_single_feed","#worst_drop_in_expected_conversions_report");
            ajaxReadReports(10,'#best_change_in_cpa_report .best_change_in_cpa_report_feed',".best_change_in_cpa_report_single_feed","#best_change_in_cpa_report");
        }else{
            
        }
        
    });
    
    /**
     * This method will fetch reports from server using ajax call.
     * 
     * @param {type} report
     * @param {type} obj
     * @param {type} secondObj
     * @param {type} mainObj
     * @returns {undefined}
     */
    function ajaxReadReports(report,obj,secondObj,mainObj){
        var postingobj={};
        var returnObj={};
        var domObj = {};
        postingobj.report=report;
        $(obj).each(function(){
            if($(this).css(DISPLAY)!=DISPLAY_NONE){
                $(this).remove();
            }
        });
        $(mainObj).fadeIn(100);
        $(mainObj).find(".report_loader").fadeIn(100);
        $.ajax({ type: 'POST', url: 'getReports.php', data:postingobj, dataType: 'json', async: true, 
            success: function(msg) 
            {
                if(msg.responseCode==1){
                    returnObj=msg.returnObject;
                    if(report == 11){
                        for(var i=0;i<returnObj.length;i++){
                            $(obj).last().clone(true).insertAfter($(obj).last());
                            substituteValues(domObj,obj,secondObj,returnObj[i]);
                        }
                    }else{
                        for(var i=0;i<returnObj.length;i++){
                            $(obj).last().clone(true).insertAfter($(obj).last());
                            substituteSummaryReportValue(domObj,obj,secondObj,returnObj[i],report);
                        }
                    }
                }else{
                    $(mainObj).find(".show_message").html(msg.responseMessage);
                    $(mainObj).find(".show_message").fadeIn(100);
                }
                $(mainObj).find(".report_loader").fadeOut(100);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(mainObj).find(".show_message").html(textStatus);
                $(mainObj).find(".show_message").fadeIn(100);
                $(mainObj).find(".report_loader").fadeOut(100);
            }
        });
    }
    
    /**
    * This method will substitute summary report values in html.
    * 
    * @param {type} domObj
    * @param {type} obj
    * @param {type} secondObj
    * @param {type} returnObj
    * @param {type} report
    * @returns {undefined}     
    */
    function substituteSummaryReportValue(domObj,obj,secondObj,returnObj,report){
        domObj = $(obj).last().find(secondObj);
		
        if($.trim(returnObj.client)!=''){
            $("#daily_report_view .over").each(function(){
               if($.trim($(this).parent().find("div").text())==returnObj.client){
                       //domObj.first().html("&nbsp;123"+returnObj.client);
                       //
                       //var clientId = (returnObj.clientId).replace(new RegExp('-', 'g'), '');
                       domObj.first().html($(this).parent().html());
               }
            }); 
        }else{
            domObj.first().html("&nbsp;");
        }
		
       
        if(report == 1 || report == 4 ){
            domObj.first().next().html("&nbsp;"+returnObj.percentVisitorsToLastMonth);
        }else if(report == 2 || report == 5 ){
            domObj.first().next().html("&nbsp;"+returnObj.cpcDiffer);
        }else if(report == 3 || report == 6 ){
            domObj.first().next().html("&nbsp;"+returnObj.remainingSpends);
        }else if(report == 7 || report == 9 ){
            domObj.first().next().html("&nbsp;"+returnObj.percentConversionsToLastMonth);
        }else if(report == 8 ){
            domObj.first().next().html("&nbsp;"+returnObj.cpcChange);
        }else if(report == 10 ){
            domObj.first().next().html("&nbsp;"+returnObj.cpaChange);
        }
        domObj.parent().css(DISPLAY,DISPLAY_BLOCK);
    }
    

    /**
    * This method will substitute daily report values in html.
    * 
    * @param {type} domObj
    * @param {type} obj
    * @param {type} secondObj
    * @param {type} returnObj
    * @returns {undefined}     
    */
    function substituteValues(domObj,obj,secondObj,returnObj){
        domObj = $(obj).last().find(secondObj);
        domObj.parent().css(DISPLAY,DISPLAY_BLOCK);
        domObj.first().html("&nbsp;"+returnObj.userName);
        var clientId = (returnObj.clientId).replace(new RegExp('-', 'g'), '');
        var link = '<?php  echo SITE_URL;?>'+"reports.php?id="+clientId+"&type=TO";
        domObj.first().next().find("div").html("&nbsp;<a href='"+link+"' >"+returnObj.clientName+"</a>");
        var str = "";
        if(returnObj.changeInCpa<0){
            var changeInCpaVal = returnObj.changeInCpa*(-1);
            str = "Conversions this month are expected to hit "+returnObj.percentOnLastMonthAtCurrentRate+" of last month conversions, and the CPA is "+changeInCpaVal+" less, visitor numbers are "+returnObj.percentAtThisPointLastMonth+" at the same time last month.";
        }else{
            str = "Conversions this month are expected to hit "+returnObj.percentOnLastMonthAtCurrentRate+" of last month conversions, and the CPA is "+returnObj.changeInCpa+" more, visitor numbers are "+returnObj.percentAtThisPointLastMonth+" at the same time last month.";
        }
        if(returnObj.changeInCpc<0){
            str += "CPC is "+((returnObj.changeInCpc))+"p less than last month and ";
        }else{
            str += "CPC is "+(returnObj.changeInCpc)+"p more than last month and ";
        }
        if(returnObj.remainingBudgetAtPpcSpend<0){
            str += "you will overspend by "+returnObj.remainingBudgetAtPpcSpend+".";
        }else{
            str += "you will underspend by "+returnObj.remainingBudgetAtPpcSpend+".";
        }
        domObj.first().next().find(".over").html("&nbsp;"+str);
        domObj.first().next().next().html("&nbsp;"+returnObj.budget);
        domObj.first().next().next().next().html("&nbsp;"+returnObj.ppcVisitorsLastMonth);
        domObj.first().next().next().next().next().html("&nbsp;"+returnObj.ppcVisitorsCurrentMonth);
        domObj.first().next().next().next().next().next().html("&nbsp;"+returnObj.percentAtThisPointLastMonth);
        str = parseFloat(returnObj.percentAtThisPointLastMonth.substring(0, returnObj.percentAtThisPointLastMonth.length - 1));
        if(str < parseFloat(80)){
            domObj.first().next().next().next().next().next().css("background-color",RED_COLOUR);
        }else if(str > parseFloat(120)){
            domObj.first().next().next().next().next().next().css("background-color",GREEN_COLOUR);
        }else{
            domObj.first().next().next().next().next().next().css("background-color","");
        }
        
        domObj.first().next().next().next().next().next().next().html("&nbsp;"+returnObj.cpcLastMonth);
        domObj.first().next().next().next().next().next().next().next().html("&nbsp;"+returnObj.cpcCurrentMonth);
        domObj.first().next().next().next().next().next().next().next().next().html("&nbsp;"+returnObj.changeInCpc);
        str = parseFloat(returnObj.changeInCpc);
        if(str > parseFloat(0)){
            domObj.first().next().next().next().next().next().next().next().next().css("background-color",RED_COLOUR);
        }else{
            domObj.first().next().next().next().next().next().next().next().next().css("background-color","");
        }
        
		var ppcSpendLastMonth = Math.round((returnObj.ppcSpendLastMonth).replace(new RegExp(',', 'g'), ''));
		var ppcSpendCurrentMonth = Math.round((returnObj.ppcSpendCurrentMonth).replace(new RegExp(',', 'g'), ''));
		var remainingBudget = Math.round((returnObj.remainingBudget).replace(new RegExp(',', 'g'), ''));
        domObj.first().next().next().next().next().next().next().next().next().next().html("&nbsp;"+ppcSpendLastMonth);
        domObj.first().next().next().next().next().next().next().next().next().next().next().html("&nbsp;"+ppcSpendCurrentMonth);
        domObj.first().next().next().next().next().next().next().next().next().next().next().next().html("&nbsp;"+remainingBudget);
        str = parseFloat(returnObj.remainingBudget);
        if(str < parseFloat(-0.5)){
            domObj.first().next().next().next().next().next().next().next().next().next().next().next().css("background-color",RED_COLOUR);
        }else{
            domObj.first().next().next().next().next().next().next().next().next().next().next().next().css("background-color","");
        }
		var remainingBudgetAtPpcSpend = Math.round((returnObj.remainingBudgetAtPpcSpend).replace(new RegExp(',', 'g'), ''));
        domObj.first().next().next().next().next().next().next().next().next().next().next().next().next().html("&nbsp;"+remainingBudgetAtPpcSpend);
        str = parseFloat(returnObj.remainingBudgetAtPpcSpend);
        if(str < parseFloat(0)){
            domObj.first().next().next().next().next().next().next().next().next().next().next().next().next().css("background-color",RED_COLOUR);
        }else{
            domObj.first().next().next().next().next().next().next().next().next().next().next().next().next().css("background-color","");
        }
		var dailyBudget = Math.round((returnObj.dailyBudget).replace(new RegExp(',', 'g'), ''));
        domObj.first().next().next().next().next().next().next().next().next().next().next().next().next().next().html("&nbsp;"+dailyBudget);
		var avgDailySpendsMtd = Math.round((returnObj.avgDailySpendsMtd).replace(new RegExp(',', 'g'), ''));
        domObj.first().next().next().next().next().next().next().next().next().next().next().next().next().next().next().html("&nbsp;"+avgDailySpendsMtd);
		var plusOrMinusDailyBudgetAvailable = Math.round((returnObj.plusOrMinusDailyBudgetAvailable).replace(new RegExp(',', 'g'), ''));
        domObj.first().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().html("&nbsp;"+plusOrMinusDailyBudgetAvailable);
        str = parseFloat(returnObj.plusOrMinusDailyBudgetAvailable);
        if(str < parseFloat(0)){
            domObj.first().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().css("background-color",RED_COLOUR);
        }else{
            domObj.first().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().css("background-color","");
        }
		var yesterdaySpends = Math.round((returnObj.yesterdaySpends).replace(new RegExp(',', 'g'), ''));
        domObj.first().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().html("&nbsp;"+yesterdaySpends);
        domObj.first().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().html("&nbsp;"+returnObj.adwordsConversionsLastMonth);
        domObj.first().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().html("&nbsp;"+returnObj.adwordsConversionsCurrentMonth);
        domObj.first().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().html("&nbsp;"+returnObj.conversionsAtCurrentRate);
        domObj.first().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().html("&nbsp;"+returnObj.percentOnLastMonthAtCurrentRate);
        str = parseFloat(returnObj.percentOnLastMonthAtCurrentRate.substring(0, returnObj.percentOnLastMonthAtCurrentRate.length - 1));
        if(str < parseFloat(80)){
            domObj.first().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().css("background-color",RED_COLOUR);
        }else if(str > parseFloat(120)){
            domObj.first().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().css("background-color",GREEN_COLOUR);
        }else{
            domObj.first().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().css("background-color","");
        }
        domObj.first().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().html("&nbsp;"+returnObj.ppcCpaLastMonth);
        domObj.first().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().html("&nbsp;"+returnObj.ppcCpaCurrentMonth);
        domObj.first().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().html("&nbsp;"+returnObj.changeInCpa);
        str = parseFloat(returnObj.changeInCpa);
        if(str > parseFloat(0)){
            domObj.first().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().css("background-color",RED_COLOUR);
        }else{
            domObj.first().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().next().css("background-color","");
        }
    }
</script>
</body>
</html>