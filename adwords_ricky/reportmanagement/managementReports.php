<?php
/**
 * This file will display reports for the logged in user.
 */
include('../header.php');

include_once '../includes/config.php';
include_once './CustomClasses/Constants.php';
include_once './CustomClasses/helperFunctions.php';
use CustomClasses\Constants;
use CustomClasses\helperFunctions;

$helper = new helperFunctions();
//$user = (isset($_SESSION['user_name'])&&$_SESSION['user_name']!='')?$_SESSION['user_name']:'keerat@pushgroup.co.uk';
//$userId = (isset($_SESSION['user_id'])&&$_SESSION['user_id']!='')?$_SESSION['user_id']:'3';
//$userType = (isset($_SESSION['user_type'])&&$_SESSION['user_type']!='')?$_SESSION['user_type']:'1';
$user = (isset($_SESSION['user_name'])&&$_SESSION['user_name']!='')?$_SESSION['user_name']:'ricky@pushgroup.co.uk';
$userId = (isset($_SESSION['user_id'])&&$_SESSION['user_id']!='')?$_SESSION['user_id']:'12';
$userType = (isset($_SESSION['user_type'])&&$_SESSION['user_type']!='')?$_SESSION['user_type']:'2';
if($userType == 2){
    $selectUsersResp = $helper->getHeadAndNormalUsersOnly();
    if($selectUsersResp->responseCode == 1){
        $selectUsers = $selectUsersResp->returnObject;
    }else{
        $selectUsers = array();
    }
}


?>
<script src="../js/jquery-1.9.0.min.js"></script>
<!--<script src="../js/fusioncharts-jquery-plugin.js"></script>-->
<script type="text/javascript" src="../fusioncharts/fusioncharts.js"></script>
<script type="text/javascript" src="../fusioncharts/themes/fusioncharts.theme.zune.js"></script>
<script type="text/javascript" src="../fusioncharts/themes/fusioncharts.theme.fint.js"></script>


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
    .user-data h5 div:hover .over {
    /*.report_single_feed div:hover .over {*/
        display: block;
    }

    div.report_single_feed {

    }
    .user-data h5:hover {
    /*div.report_single_feed:hover {*/
        text-decoration: none;
        background: #ffffff;
        z-index: 6;
    }
    .user-data h5 span {
    /*div.report_single_feed span {*/
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
    .user-data h5:hover span {
    /*div.report_single_feed:hover span {*/
        left: 2%;
        /*background: #ffffff;*/
    }
    .user-data h5 span {
    /*div.report_single_feed span {*/
        position: absolute;
        left: -9999px;
        margin: 4px 0 0 0px;
        padding: 3px 3px 3px 3px;
        border-style:solid;
        border-color:black;
        border-width:1px;
    }
    .user-data h5:hover span {
    /*div.report_single_feed:hover span {*/
        margin: 20px 0 0 170px;
        /*background: #ffffff;*/
        z-index:6;
    }
    .user-data h5:nth-child(2) div {
    /*div.report_single_feed:nth-child(2) div {*/
        text-decoration: none;
    }
    .user-data h5:hover div{
    /*div.report_single_feed:hover div{*/
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
        width: 102%;
        float: left;
        overflow: hidden;
        margin: 0 auto;
        margin-top: 10px;
    }

	/* Deepa */

    .user-data h5 div:hover .over {
    /*.report_single_feed div:hover .over {*/
        display: block;
    }

    .user-data h5 {
    /*div.report_single_feed {*/

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
    .user-data{
        float: left;
        overflow: hidden;
        background-color: rgb(255, 255, 255);
        height: 134px;
        margin-right: 2px;
        width: 123px;
        font-family: Gibson-SemiBold;
    }
    .user-data a{
        color: #8B5DA5;
        text-decoration: none;
    }
    .user-data h4{
        margin-bottom: 0px;
        margin-top: 12px;
        padding-top: 10px;
    }
    .user-data h5{
        margin-bottom: 0px;
        color: #8B5DA5;
        margin-top: 10px;
    }
    .user-data h6{
        margin-bottom: 0px;
        margin-top: 7px;
    }
    .singleLine{
        width: 100%;
        float: left;
        overflow: hidden;
        background-color: #F6F6F6;
        height: 158px;
    }
    .singleGraph{
        background-color: #FFFFFF;
        width: auto;
        float: left;
        margin-right: 2px;
        text-align: center;
        overflow: hidden;
    }
    .singleLine .singleGraph:last-child{
        margin-right: 0px;
        width: 14.6%;
        /*width: 180px;*/
    }
    .daily_report_head{
        width:100%;
        float: left;
        overflow: hidden;
        /*margin-bottom: 20px;*/
        margin-top: 10px;
        text-align: center;
        /*background-color: #F6F6F6;*/
/*        padding-bottom: 10px;
        padding-top: 10px;*/
    }
    .daily_report_head div{
        float: left;
        overflow: hidden;
        background-color: #EFEDEE;
        height: 35px;
        padding-top: 15px;
        margin-right: 1px;
        font-weight: bold;
    }
    .daily_report_head div:last-child{
        margin-right: 0px;
        width: 14.8%;
        /*width: 182px;*/
    }
    @media screen and (max-width: 1024px) {
        .daily_report_head div:last-child{
            margin-right: 0px;
            width: 14.6%;
            /*width: 182px;*/
        }
    }
    @media screen and (max-width: 1366px) {
        .daily_report_head div:last-child{
            margin-right: 0px;
            width: 14.7%;
            /*width: 182px;*/
        }
    }

    body{
        background-color: #00D7FE;
    }
    #newReport{
        width:100%;
        float: left;
        overflow: hidden;
        background-color: #FFFFFF;
        border-radius: 5px;

    }
    .spacer{
        width: 100%;
        float: left;
        overflow: hidden;
        height: 50px;
    }
    .more-loader{
        width: 100%;
        float: left;
        overflow: hidden;
        height: 75px;
        background-color: #EFEDEE;
        margin-bottom: 15px;
        border-bottom: 1px #C8C8C8 solid;
        font-weight: bold;
    }
    .more-loader div{
        width: 43%;
        float: left;
        overflow: hidden;
        margin-top: 27px;
    }
    .moreDataDisplay{
        margin-top: 0px;
        margin-bottom: 0px;
        margin-left: 5px;
        cursor: pointer;
    }
    .immediate-inner{
        width: 99%;
        /*width: 99%;*/
        margin: 0 auto;
/*        max-width: 1231.56px;
        min-width: 1231.56px;*/
    }


</style>
<input type="hidden" id="account" value="<?php echo $_REQUEST['account'];?>"/>
<div class="report-container">
	<div class="page-header"><h1><b id="report_name"></b></h1></div>
	<div class="report-div">
	<div class="report-div-one">
			<div class="report-details1">
                            <?php
                            if($userType == 2){
                            ?>
                            <div style="width:auto;float:left;"><input style="height: 19px;" placeholder="Customer Name" id="c_name" name="c_name" type="text">&nbsp;</div>
                            <div style="width:auto;float:left;">
                                <select style="height: 25px;" id="userId_select">
                                    <option value="0" selected="true" >Select Account Manager</option>
                                    <?php
                                    foreach($selectUsers as $dpdnUser){
                                        echo '<option usertype="'.$dpdnUser->userType.'" username="'.$dpdnUser->userName.'" value="'.$dpdnUser->userId.'">'.$dpdnUser->personName.'</option>';
                                    }
                                    ?>
                                </select>
                                <button id="search_reports">Search</button>
                            </div>
                            <?php 
                            }
                            ?>
                        </div>
			<div class="report-details2">
				<form action='reports.php' method ='get' class='reportForm'>
					<input type='hidden' name='id' value='<?php echo $id; ?>' />
					<div><span class="txtcolor2">Select</span> Report Type&nbsp;:&nbsp;	</div>
					<div><select name='type' id="report_select">
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
					<div></div>
				</form>
			</div>

		</div>
	<div class="account-details-div">
<div id="report_view">

    <div style="width:100%;" id="daily_report_view" >

        <div class="report_loader"><img src="../img/loading.gif" /></div>
        <div class="show_message">&nbsp;</div>
        <div class="hidden_reports" style="display: none;">

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
	    <div id="newReport" style="display: none;">
        <!--<div style="width: 100%;background-color: #F6F6F6;float: left;overflow: hidden;">-->
        <div class="immediate-inner">
            <div class="daily_report_head" style="">
                <div style="width:10%;">Customer</div>
                <div style="width:15%;">Visitors to Date</div>
                <div style="width:15%;">CPC</div>
                <div style="width:14.8%;">Spend</div>
                <div style="width:14.9%;" id="daily_budget">Daily Budget</div>
                <div style="width:15%;">Conversions</div>
                <div style="">CPA</div>
            </div>
            <div class="singleLine" style="display: none;">
                <div class="user-data" style="width:10%;">
                    <h4 style="">Manager Name</h4>
                    <h5 style="">Client Name</h5>
                    <h6 style="">Budget</h6>
                    <p></p>
                </div>
                <div id="chartContainer" class="singleGraph" style="display: none;">

                </div>
            </div>
            <div class="spacer"></div>
            <div class="more-loader">
                <div style="text-align: right; margin-top: 20px;">
                    <img src="../images/giphy.gif" style="width:35px;display: none">
                </div>
                <div>
                    <p class="moreDataDisplay">Load more data</p>
                </div>
            </div>
        </div>
        <!--</div>-->
    </div>

    </div>
	</div>
	</div>

    <div class="hidden_div">
        <input type="hidden" name="IHUserName" id="IHUserName" value="<?= $user ?>" />
    </div>
<script type="text/javascript">
    var screenWidth = screen.width;
    var screenHeight = screen.height;
    var graphHeight = "100";
    var graphWidth = "200";
    var DISPLAY_NONE = "none";
    var DISPLAY_BLOCK = "block";
    var DISPLAY = "display";
    var DAILY_REPORT = "Daily Reports";
    var SUMMARY_REPORT = "Summary Reports";
    var RED_COLOUR = "#dd7e6b";
    var GREEN_COLOUR = "#b6d7a8";
    var dailyReportsJson;
    var userType = "<?= $userType; ?>";
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
    var shortMonth = new Array();
    shortMonth[0] = "Jan";
    shortMonth[1] = "Feb";
    shortMonth[2] = "Mar";
    shortMonth[3] = "Apr";
    shortMonth[4] = "May";
    shortMonth[5] = "Jun";
    shortMonth[6] = "Jul";
    shortMonth[7] = "Aug";
    shortMonth[8] = "Sep";
    shortMonth[9] = "Oct";
    shortMonth[10] = "Nov";
    shortMonth[11] = "Dec";
    var thisMonth;
    var prevMonth;
    var thisMonthShort;
    var prevMonthShort;


    $(document).ready(function (){
        if(d.getMonth()==0){
            prevMonth = month[11];
            thisMonth = month[d.getMonth()];
            prevMonthShort = shortMonth[11];
            thisMonthShort = shortMonth[d.getMonth()];
        }else{
            prevMonth = month[d.getMonth()-1];
            thisMonth = month[d.getMonth()];
            prevMonthShort = shortMonth[d.getMonth()-1];
            thisMonthShort = shortMonth[d.getMonth()];
        }
        $(".this_month").text(thisMonth);
        $(".prev_month").text(prevMonth);
        $("#report_name").text(DAILY_REPORT);
        $(".common_wrapper").fadeOut(100);
        $(".common_wrapper:last").fadeIn(100);
        $(".common_wrapper:last").prev().fadeIn(100);

        if(userType == 1){
            if(isNaN(parseInt($("#account").val())))
            {
                ajaxReadReports(11,"#newReport",".report_single_feed","#daily_report_view");
                $("#analysis_link").css("display","block");
            }
            else
            {
                ajaxReadReports(12,"#newReport",".report_single_feed","#daily_report_view");
            }
        }
        
    });

    $("#search_reports").click(function(){
        $("#summery_report_view").fadeOut(100);
        $("#daily_report_view").fadeOut(100);
        $("#newReport").fadeOut(100);
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
        $("#newReport").find(".singleLine").each(function(){
            if($(this).css(DISPLAY)!=DISPLAY_NONE){
                $(this).remove();
            }
        });
        if($("#userId_select").val()=="0"){
            alert("Please select an Account Manager");
            return false;
        }
        $("#report_name").text(DAILY_REPORT);
        if(userType == 2){
            if(isNaN(parseInt($("#account").val())))
            {
                ajaxReadReports(11,"#newReport",".report_single_feed","#daily_report_view");
                $("#analysis_link").css("display","block");
            }
            else
            {
                ajaxReadReports(12,"#newReport",".report_single_feed","#daily_report_view");
            }
        }
    });

    $("#report_select").change(function(){
        $("#summery_report_view").fadeOut(100);
        $("#daily_report_view").fadeOut(100);
        $("#newReport").fadeOut(100);
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
        $("#newReport").find(".singleLine").each(function(){
            if($(this).css(DISPLAY)!=DISPLAY_NONE){
                $(this).remove();
            }
        });

        if($(this).val()==11){
            $("#report_name").text(DAILY_REPORT);
            ajaxReadReports(11,"#newReport",".report_single_feed","#daily_report_view");
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
        if(userType == 2){
            postingobj.customerName=$("#c_name").val();
            postingobj.userId=$("#userId_select").val();
        }
        try
        {
        postingobj.campaign_index=$("#account").val();
        }
        catch(e){}

        if(report == 11){
            if($("#userId_select").val()=="0"){
                alert("Please select an Account Manager");
                return false;
            }
            $(obj).find(".singleLine").each(function(){
                if($(this).css(DISPLAY)!=DISPLAY_NONE){
                    $(this).remove();
                }
            });
        }else{
            $(obj).each(function(){
                if($(this).css(DISPLAY)!=DISPLAY_NONE){
                    $(this).remove();
                }
            });
        }

        $(mainObj).fadeIn(100);
        $(mainObj).find(".report_loader").fadeIn(100);
        $.ajax({ type: 'POST', url: 'getReports.php', data:postingobj, dataType: 'json', async: true,
            success: function(msg)
            {
                if(msg.responseCode==1){
                    returnObj=msg.returnObject;
                    if(report == 11 || report == 12){
                        $(obj).fadeIn();
                        dailyReportsJson = returnObj;
                        var first = 0;
                        var limit = 5;
                        makeFixedData(returnObj,first,limit);
                        var str = "";
                        for(var i=0;i<returnObj.length;i++){
                            str += "<div>"+makeClientDataString(returnObj[i])+"</div>";
                        }
                        $(".hidden_reports").html(str);

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

    function makeFixedData(returnObj,first,limit){
        var max = first+limit;
        if(returnObj.length < max){
            max = returnObj.length;
        } else if(returnObj.length == first || returnObj.length < first){
            $(".moreDataDisplay").parent().prev().find("img").fadeOut(1);
            $(".moreDataDisplay").text("Data loading finished");
        }
        for(var i=first;i<max;i++){
            $(".singleLine").first().clone(true).insertAfter($(".singleLine").last());
            $(".singleLine").last().fadeIn(1);
            makeDailyReports($(".singleLine").last(),returnObj[i]);
        }
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
            $(".hidden_reports .over").each(function(){
               if($.trim($(this).parent().find("div").text())==returnObj.client){
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


    $(".moreDataDisplay").click(function(){
        var limit = 5;
        var first = ($(".singleLine").length)-1;
        $(".moreDataDisplay").parent().prev().find("img").fadeIn(1);
        $(".moreDataDisplay").text("Loading more data");
        makeFixedData(dailyReportsJson,first,limit)
    });

    /**
    * This method will substitute daily report values in html.
    *
    * @param {type} obj
    * @param {type} returnObj
    * @returns {undefined}
    */
    function makeDailyReports(obj,returnObj){
        $(obj).find(".user-data h4").text(returnObj.userName);
        var clientData = makeClientDataString(returnObj);
        var campData   = makeCampaignString(returnObj);
        $(obj).find(".user-data h5").html(clientData);
        $(obj).find(".user-data h6").text("Budget £"+returnObj.budget);
        $(obj).find(".user-data p").html(campData);
//         if(!isNaN(parseInt($("#account").val())))
//         {$("#analysis_link").css("color","red");}

       //$(obj).find(".user-data a").attr("href","management_reports.php?account="+);
        var graphWidth;
        if(screen.width < 1366){
            graphWidth = "139"
        }else{
            graphWidth = "183";
        }
        var graphSize = {};
//        graphSize.width = "303";
        graphSize.width = graphWidth;
        graphSize.height = "130";
//        graphSize.width = (screenWidth*14.64128843338214)/100;283-for last div
//        graphSize.height = (screenHeight*13.02083333333333)/100;
        graphSize.marginBottom = "3";
        loadVisitorsAngularGraph(obj,returnObj,graphSize);
        loadCPCGraph(obj,returnObj,graphSize);
        loadSpendGraph(obj,returnObj,graphSize);


        if(isNaN(parseInt($("#account").val()))){loadDailyBudgetBarGraph(obj,returnObj,graphSize);}
        else{$("#daily_budget").css("display","none");}



        loadConversionsAngularGraph(obj,returnObj,graphSize);
        loadCPAGraph(obj,returnObj,graphSize);
    }

    function makeClientDataString(returnObj){
        var clientId = (returnObj.clientId).replace(new RegExp('-', 'g'), '');
        var link = '<?php  echo SITE_URL ;?>'+"reports.php?id="+clientId+"&type=TO";
        var dataString = "<div><a href='"+link+"'>"+returnObj.clientName+"</a></div>";
        var spanContent = makeStringForHoverSpan(returnObj);
        dataString += '<span class="over">'+spanContent+'</span>';
        return dataString;
    }

    function makeCampaignString(returnObj){
        var clientId = (returnObj.clientId).replace(new RegExp('-', 'g'), '');
        var link = '<?php  echo SITE_URL ;?>'+"reportmanagement/management_reports.php?account="+clientId;
        var dataString = "<div><a href='"+link+"'   target='_blank'>Campaign Analysis</a></div>";
        return dataString;
    }

    /*
     *
     * @param {type} returnObj
     * @returns {String}
     */
    function makeStringForHoverSpan(returnObj){
        var hoverReport = "";
        if(returnObj.changeInCpa<0){
            var changeInCpaVal = returnObj.changeInCpa*(-1);
            hoverReport = "Conversions this month are expected to hit "+returnObj.percentOnLastMonthAtCurrentRate+" of last month conversions, and the CPA is "+changeInCpaVal+" less, visitor numbers are "+returnObj.percentAtThisPointLastMonth+" at the same time last month.";
        }else{
            hoverReport = "Conversions this month are expected to hit "+returnObj.percentOnLastMonthAtCurrentRate+" of last month conversions, and the CPA is "+returnObj.changeInCpa+" more, visitor numbers are "+returnObj.percentAtThisPointLastMonth+" at the same time last month.";
        }
        if(returnObj.changeInCpc<0){
            hoverReport += "CPC is "+((returnObj.changeInCpc))+"p less than last month and ";
        }else{
            hoverReport += "CPC is "+(returnObj.changeInCpc)+"p more than last month and ";
        }
        if(returnObj.remainingBudgetAtPpcSpend<0){
            hoverReport += "you will overspend by "+returnObj.remainingBudgetAtPpcSpend+".";
        }else{
            hoverReport += "you will underspend by "+returnObj.remainingBudgetAtPpcSpend+".";
        }
        return hoverReport;
    }

    function makeGraphDiv(obj,width){
        var initialCount = $(".singleGraph").length+1;
        $(obj).find(".singleGraph:first").clone(true).insertAfter($(obj).find(".singleGraph:last"));
        $(obj).find(".singleGraph:last").fadeIn(1);
        $(obj).find(".singleGraph:last").attr("id","chartContainer"+initialCount);
        $(obj).find(".singleGraph:last").width(width);
        var objectAngularId = "chartContainer"+initialCount;
        return objectAngularId;
    }

    function loadVisitorsAngularGraph(obj,returnObj,graphSize){
        var objectAngularId = makeGraphDiv(obj,"14.9%");
        var lowerLimit = (returnObj.ppcVisitorsCurrentMonth).replace(/,/g , "");
        var upperLimit = (returnObj.ppcVisitorsLastMonth).replace(/,/g , "");
        if(isNaN(lowerLimit)){
            lowerLimit = 0;
        }
        if(isNaN(upperLimit)){
            upperLimit = 0;
        }
        var dataValue = (lowerLimit/upperLimit)*100;
        var displayValue =returnObj.percentAtThisPointLastMonth ;
        loadAngularGraph(objectAngularId,graphSize,lowerLimit,upperLimit,dataValue,displayValue,"",40);
    }

    function loadConversionsAngularGraph(obj,returnObj,graphSize){
        var objectAngularId = makeGraphDiv(obj,"15%");
        var lowerLimit = (returnObj.adwordsConversionsCurrentMonth).replace(/,/g , "");
        var upperLimit = (returnObj.adwordsConversionsLastMonth).replace(/,/g , "");
        if(isNaN(lowerLimit)){
            lowerLimit = 0;
        }
        if(isNaN(upperLimit)){
            upperLimit = 0;
        }
        var dataValue = (lowerLimit/upperLimit)*100;
        var displayValue = returnObj.percentOnLastMonthAtCurrentRate;
        loadAngularGraph(objectAngularId,graphSize,lowerLimit,upperLimit,dataValue,displayValue,"Expected "+returnObj.conversionsAtCurrentRate,45);
   }

    function loadDailyBudgetBarGraph(obj,returnObj,graphSize){
        var objectId = makeGraphDiv(obj,"14.7%");
        var avgDailySpendsMtd = (returnObj.avgDailySpendsMtd).replace(/,/g , "");
        var yesterdaySpends = (returnObj.yesterdaySpends).replace(/,/g , "");
        var remainingBudget = (returnObj.remainingBudget).replace(/,/g , "");
        var budgetCap = (returnObj.budgetCap).replace(/,/g , "");
        var plusOrMinusDailyBudgetAvailable = (returnObj.plusOrMinusDailyBudgetAvailable).replace(/,/g , "");
        if(isNaN(avgDailySpendsMtd)){
            avgDailySpendsMtd = 0;
        }
        if(isNaN(yesterdaySpends)){
            yesterdaySpends = 0;
        }
        if(isNaN(remainingBudget)){
            remainingBudget = 0;
        }
        if(isNaN(plusOrMinusDailyBudgetAvailable)){
            plusOrMinusDailyBudgetAvailable = 0;
        }
        if(plusOrMinusDailyBudgetAvailable<0){
            var category = [{"label": "Avg"},{"label": "Budget Cap"},{"label": "Yesterday"},{"label": "Left"},{"label": "Decrease"}];
        }else{
            var category = [{"label": "Avg"},{"label": "Budget Cap"},{"label": "Yesterday"},{"label": "Left"},{"label": "Increase"}];
        }
        
        var data = [{"value": avgDailySpendsMtd,"color": "#28DB4C"},
			{"value": budgetCap,"color": "#FFA701"},
            {"value": yesterdaySpends,"color": "#9331C6"},
            {"value": remainingBudget,"color": "#FFA701"},
            {"value": plusOrMinusDailyBudgetAvailable,"color": "#FD1F90"}];
        var numPrefix = "£";
        loadBarGraph(objectId,graphSize,numPrefix,category,data);
    }

    function loadCPCGraph(obj,returnObj,graphSize){
        var objectId = makeGraphDiv(obj,"15%");
        if(isNaN(returnObj.cpcLastMonth)){
            returnObj.cpcLastMonth = 0.00;
        }
        if(isNaN(returnObj.cpcCurrentMonth)){
            returnObj.cpcCurrentMonth = 0.00;
        }
        loadColumnGraph(objectId,graphSize,"",prevMonth,thisMonth,returnObj.cpcLastMonth,returnObj.cpcCurrentMonth,returnObj.changeInCpc);
    }


    function loadCPAGraph(obj,returnObj,graphSize){
        var divWidth;
        if(screen.width < 1366){
            divWidth = "14.4%"
        }else{
            divWidth = "14.6%";
        }
        var objectId = makeGraphDiv(obj,divWidth);
        if(isNaN(returnObj.ppcCpaLastMonth)){
            returnObj.ppcCpaLastMonth = 0.00;
        }
        if(isNaN(returnObj.ppcCpaCurrentMonth)){
            returnObj.ppcCpaCurrentMonth = 0.00;
        }
        loadColumnGraph(objectId,graphSize,"",prevMonth,thisMonth,returnObj.ppcCpaLastMonth,returnObj.ppcCpaCurrentMonth,returnObj.changeInCpa);
    }

   function loadSpendGraph(obj,returnObj,graphSize){
        var objectId = makeGraphDiv(obj,"14.7%");
        var budget = ((returnObj.budget).replace(/,/g , ""));
        var ppcSpendCurrentMonth = ((returnObj.ppcSpendCurrentMonth).replace(/,/g , ""));
        var ppcSpendLastMonth = (returnObj.ppcSpendLastMonth).replace(/,/g , "");
        var remainingBudget = ((returnObj.remainingBudgetAtPpcSpend).replace(/,/g , ""));
        if(isNaN(ppcSpendCurrentMonth)){
            ppcSpendCurrentMonth = 0.00;
        }
        if(isNaN(ppcSpendLastMonth)){
            ppcSpendLastMonth = 0.00;
        }
        if(isNaN(remainingBudget)){
            remainingBudget = 0.00;
        }
        var calculatedValue = (parseFloat(budget) - parseFloat(remainingBudget)).toFixed(2);
        var anchorImg = "";
        if(calculatedValue >0){
            anchorImg = "<?php  echo SITE_URL ;?>"+"images/anchor_image_pink.png";
        }else{
            anchorImg = "<?php  echo SITE_URL ;?>"+"images/anchor_image_green.png";
        }
        var data = [{
                "displayValue":returnObj.ppcSpendCurrentMonth+" "+thisMonthShort,
                "anchorImageUrl":"<?php  echo SITE_URL ;?>"+"images/anchor_image.png",
                "value": ppcSpendCurrentMonth
            },{
                "displayValue":calculatedValue+" "+thisMonthShort,
                "anchorImageUrl":anchorImg,
                "value": calculatedValue
            },{
                "displayValue":returnObj.ppcSpendLastMonth+" "+prevMonthShort,
                "anchorImageUrl":"<?php  echo SITE_URL ;?>"+"images/anchor_image.png",
                "value": ppcSpendLastMonth
            }];
        loadLineGraph(objectId,graphSize,data);

   }

    function loadAngularGraph(objectId,graphSize,lowerLimit,upperLimit,dataValue,displayValue,caption,y){
        var radius;
        var innerRadius;
        var endAngle;
        var startAngle;
        var marginBottom;

		if(isNaN(dataValue)){dataValue=0;}
        if(parseInt(dataValue) > 100){
            radius = "45";
            innerRadius = "35";
            endAngle = "-30";
            startAngle = "180";
            //dataValue = "85.71";
        } else{
            radius = "50";
            innerRadius = "40";
            endAngle = "0";
            startAngle = "180";
        }
        if(caption == ""){
            marginBottom = graphSize.marginBottom;
        }else{
            marginBottom = 10;
        }


        FusionCharts.ready(function(){
            var revenueChart = new FusionCharts({
                type: "angulargauge",
                renderAt: objectId,
                width: graphSize.width,
                height: graphSize.height,
                dataFormat: "json",
                dataSource: {
                    "chart": {
                        "caption": "",
                        "lowerlimit": "0",
                        "upperlimit": "100",
                        "lowerlimitdisplay": lowerLimit,
                        "upperlimitdisplay": upperLimit,
                        "numbersuffix": "%",
                        "showvalue": "1",
                        "valueFontBold": "1",
//                        "valueFontSize": "50",
                        "showborder":"0",
                        "showlimits":"0",
                        "majorTMNumber":"0",
                        "majorTMHeight":"0",
                        "showTickValues":"0",
                        "chartBottomMargin":marginBottom,
                        "usePlotGradientColor": "0",
                        "gaugeouterradius": radius,
                        "gaugeInnerRadius": innerRadius,
                        "gaugestartangle": startAngle,
                        "gaugeendangle": endAngle,
                        "pivotRadius": "0",
                        "showTickMarks": "0",
                        "valueFontSize": "13",
//                        "tickValueStep": "4",
                        "decimals":"2",
                        "bgColor":"ffffff",
                        "theme": "fint"
                    },
                    "annotations": {
                        "groups": [
                            {
                                "id": "infobar",
                                "items": [
                                    {
                                        "id": "label",
                                        "type": "text",
                                        "text": upperLimit,
                                        "fillcolor": "#000000",
//                                        "fillcolor": "#6baa01",
                                        "x" : "$chartCenterX+55",
                                        "y": "$chartEndY - 60",
                                    }
                                ]
                            },
                            {
                                "id": "infobar",
                                "items": [
                                    {
                                        "id": "label",
                                        "type": "text",
                                        "text": lowerLimit,
                                        "fillcolor": "#000000",
//                                        "fillcolor": "#6baa01",
                                        "x" : "$chartCenterX - 55",
                                        "y": "$chartEndY - 60",
                                    }
                                ]
                            },
                            {
                                "id": "infobar",
                                "items": [
                                    {
                                        "id": "label",
                                        "type": "text",
                                        "text": caption,
                                        "fillcolor": "#000000",
//                                        "fillcolor": "#6baa01",
                                        "x" : "$chartCenterX ",
                                        "y": "$chartEndY -5 ",
                                    }
                                ]
                            },
							{
                                "id": "infobar",
                                "items": [
                                    {
                                        "id": "label",
                                        "type": "text",
                                        "text": "To Date",
                                        "fillcolor": "#000000",
//                                        "fillcolor": "#6baa01",
                                        "x" : "$chartCenterX ",
                                        "y": "$chartEndY - "+y,
                                    }
                                ]
                            }

                        ]
                    },
                    "colorrange": {
                          "color": [
                            {
                                  "minvalue": "0",
                                  "maxvalue": dataValue,
                                  "code": "661399"
//                                  "code": "FF5904"
                            },
                            {
                                  "minvalue": dataValue,
                                  "maxvalue": "100",
                                  "code": "9330C9"
                            }
                          ]
                    },
                    "dials": {
                          "dial": [
                            {
                                  "value": displayValue,
                                  "radius": "0",
                                  "baseRadius": "0",
                                  "rearExtension": "0",
                                  "borderAlpha": "0"
                            }
                          ]
                    }
                },
                "events": {
                    "beforeRender": function (evt, data) {
                        $(".moreDataDisplay").parent().prev().find("img").fadeIn(1);
                        $(".moreDataDisplay").text("Loading more data");
                        renderingCount++;
                    },
                    "rendered": function (evt, data) {
                        finishedCount++;
                        if(renderingCount == finishedCount){
                            $(".moreDataDisplay").parent().prev().find("img").fadeOut(1);
                            $(".moreDataDisplay").text("Load more data");
                        }else{
                            $(".moreDataDisplay").parent().prev().find("img").fadeIn(1);
                            $(".moreDataDisplay").text("Loading more data");
                        }
                    }
                }
        }).render();
//        revenueChart.ha;
//        revenueChart.render(objectId);
        });

    }


    function loadBarGraph(objectId,graphSize,numPrefix,category,data){
        FusionCharts.ready(function () {
        var barChart = new FusionCharts({
            type: 'msbar2d',
            renderAt: objectId,
            width: graphSize.width,
            height: graphSize.height,
            dataFormat: 'json',
            dataSource: {
                "chart": {
//                    "yAxisname": "Sales (In USD)",
                    "numberPrefix": numPrefix,
//                    "paletteColors": "#0075c2",
                    "bgColor": "#ffffff",
                    "showBorder": "0",
                    "showHoverEffect":"1",
                    "showCanvasBorder": "0",
                    "usePlotGradientColor": "0",
                    "plotBorderAlpha": "10",
                    "legendBorderAlpha": "0",
                    "legendShadow": "0",
                    "showLegend": "0",
                    "placevaluesInside": "0",
                    "numDivLines": "0",
//                    "valueFontColor": "#ffffff",
                    "divLineColor": "#ffffff",
                    "chartBottomMargin":graphSize.marginBottom,
                    "showXAxisLine": "1",
                    "showYAxisValues": "0",
                    "xAxisLineColor": "#999999",
//                    "divlineColor": "#999999",
                    "divLineIsDashed": "1",
                    "showAlternateVGridColor": "0",
                    "subcaptionFontBold": "0",
                    "showLabels": "1",
                    "decimals":"2",
                    "subcaptionFontSize": "14",
                    "theme": "fint"
                },
                "categories": [
                    {
                        "category": category
                    }
                ],
                "dataset": [
                    {
                        "data": data
                    }
                ]
            },
            "events": {
                "beforeRender": function (evt, data) {
                    $(".moreDataDisplay").parent().prev().find("img").fadeIn(1);
                    $(".moreDataDisplay").text("Loading more data");
                    renderingCount++;
                },
                "rendered": function (evt, data) {
                    finishedCount++;
                    if(renderingCount == finishedCount){
                        $(".moreDataDisplay").parent().prev().find("img").fadeOut(1);
                        $(".moreDataDisplay").text("Load more data");
                    }else{
                        $(".moreDataDisplay").parent().prev().find("img").fadeIn(1);
                        $(".moreDataDisplay").text("Loading more data");
                    }
                }
            }
//        });
        }).render();
    });
    }

    function loadColumnGraph(objectId,graphSize,numPrefix,lMonth,cMonth,val1,val2,val3){

        var firstColumnColour = "00D7FE";
        var middleColumnColour = "FFFFFF";
        var lessColour = "#28DB4C";
        var moreColour = "FC1F91";
        var displayColour = "";
        var dispVal = "";
        var maxInTwo = "";
        var chartBgImage = "";
        val1 = parseFloat(val1).toFixed(2);
        val2 = parseFloat(val2).toFixed(2);
        val3 = parseFloat(val3).toFixed(2);

        if(0 < val3){
            dispVal = val3;
            displayColour = moreColour;
            maxInTwo = val2/100;
            chartBgImage = "<?php  echo SITE_URL ;?>"+"images/up_arrow.png";
        }else if(0 > val3){
            dispVal = val3;
            displayColour = lessColour;
            maxInTwo = val1/100;
            chartBgImage = "<?php  echo SITE_URL ;?>"+"images/down_arrow.png";
        }else{
            dispVal = val3;
            displayColour = lessColour;
            maxInTwo = val1/100;
            chartBgImage = "";
        }
        FusionCharts.ready(function () {
            var columnChart = new FusionCharts({
                type: "MSColumn2D",
                renderAt: objectId,
                width: graphSize.width,
                height: graphSize.height,
                dataFormat: "json",
                dataSource: {
                    "chart":{
                        "bgcolor":"ffffff",
                        "bgImage":chartBgImage,
//                        "bgImageDisplayMode":"center",
                        "bgImageVAlign":"top",
                        "bgImageHAlign":"middle",
                        "canvasBgAlpha":"0",
                        "numDivLines":"0",
                        "showAlternateHGridColor": "0",
                        "showXAxisLine": "1",
                        "showYAxisValues": "0",
                        "xaxislinethickness": "10",
                        "xAxisLineColor": "#EFEDEE",
                        "divLineColor": "#ffffff",
                        "divLineAlpha":"0",
                        "showborder":"0",
                        "showHoverEffect":"0",
                        "showCanvasBorder": "0",
                        "showlabels":"1",
                        "showvalues":"1",
                        "decimals":"2",
                        "chartBottomMargin":graphSize.marginBottom,
                        "showLegend":"0",
                        "placevaluesInside": "0",
                        "usePlotGradientColor": "0",
                        "showPlotBorder":"0",
                        "plotSpacePercent": "50",
                        "theme": "fint",
                        "numberprefix":numPrefix
                    },
                    "categories":[
                        {
                            "category":[
                                {
                                    "label":lMonth
                                },
                                {
                                    "label":""
                                },
                                {
                                    "label":cMonth
                                }
                            ]
                        }
                    ],
                    "dataset":[
                        {
                            "data":[
                                {
                                    "color":firstColumnColour,
                                    "value":val1
                                },
                                {
                                    "color":middleColumnColour,
                                    "alpha": "0",
                                    "displayValue":dispVal,
                                    "value":maxInTwo
                                },
                                {
                                    "color":displayColour,
                                    "value":val2
                                }
                            ]
                        }
                    ]
                },
                "events": {
                    "beforeRender": function (evt, data) {
                        $(".moreDataDisplay").parent().prev().find("img").fadeIn(1);
                        $(".moreDataDisplay").text("Loading more data");
                        renderingCount++;
                    },
                    "rendered": function (evt, data) {
                        finishedCount++;
                        if(renderingCount == finishedCount){
                            $(".moreDataDisplay").parent().prev().find("img").fadeOut(1);
                            $(".moreDataDisplay").text("Load more data");
                        }else{
                            $(".moreDataDisplay").parent().prev().find("img").fadeIn(1);
                            $(".moreDataDisplay").text("Loading more data");
                        }
                    }
                }
            }).render();
        });
    }

    var renderingCount = 0;
    var finishedCount = 0;
    var isRendering;
    function loadLineGraph(objectId,graphSize,data){
        FusionCharts.ready(function () {
            var lineChart = new FusionCharts({
                type: "line",
                renderAt: objectId,
                width: graphSize.width,
                height: graphSize.height,
                dataFormat: "json",
                dataSource: {
                    "chart": {
                        "lineThickness": "5",
                        "lineColor": "#EFEDEE",
                        "anchorBgColor": "#00DAFD",
                        "anchorRadius": "3",
                        "baseFontColor": "#333333",
                        "baseFont": "Helvetica Neue,Arial",
                        "showBorder": "0",
                        "divLineColor": "#ffffff",
                        "chartBottomMargin":25,
                        "numDivLines":"0",
                        "showlabels":"0",
                        "showYAxisValues": "0",
                        "bgColor": "#ffffff",
                        "showShadow": "0",
                        "canvasBgColor": "#ffffff",
                        "canvasBorderAlpha": "0",
                        "divlineAlpha": "100",
                        "divlineColor": "#999999",
                        "divlineThickness": "1",
                        "divLineDashed": "1",
                        "divLineDashLen": "1",
                        "divLineGapLen": "1",
                        "showAlternateHGridColor": "0"
//                        "theme": "fint"
                    },
					"annotations": {
                        "groups": [
                            {
                                "id": "infobar",
                                "items": [
                                    {
                                        "id": "label",
                                        "type": "text",
                                        "text": "Expected Spend",
                                        "fillcolor": "#000000",
//                                        "fillcolor": "#6baa01",
                                        "x" : "$chartCenterX-5",
                                        "y": "$chartEndY-10",
                                    }
                                ]
                            },
{
                                "id": "infobar",
                                "items": [
                                    {
                                        "id": "label",
                                        "type": "image",
                                        "url": "<?php  echo SITE_URL ;?>"+"images/anchor_image_pink.png",
                                        "fillcolor": "#000000",
//                                        "fillcolor": "#6baa01",
                                        "x" : "$chartCenterX - 65",
                                        "y": "$chartEndY-20",
                                    }
                                ]
                            }
                        ]
                    },

                    "data": data
                },
                "events": {
                    "beforeRender": function (evt, data) {
                        $(".moreDataDisplay").parent().prev().find("img").fadeIn(1);
                        $(".moreDataDisplay").text("Loading more data");
                        renderingCount++;
                    },
                    "rendered": function (evt, data) {
                        finishedCount++;
                        if(renderingCount == finishedCount){
                            $(".moreDataDisplay").parent().prev().find("img").fadeOut(1);
                            $(".moreDataDisplay").text("Load more data");
                        }else{
                            $(".moreDataDisplay").parent().prev().find("img").fadeIn(1);
                            $(".moreDataDisplay").text("Loading more data");
                        }
                    }
                }
            }).render();
        });
    }

</script>



<?php include('../footer.php'); ?>

