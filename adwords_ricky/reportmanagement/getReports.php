<?php
/**
 * This file will give back each report in json format
 * if given parameters are correct.
 */
include_once './CustomClasses/Constants.php';
include_once './CustomClasses/helperFunctions.php';
include_once './CustomClasses/responseClass.php';
use CustomClasses\Constants;
use CustomClasses\helperFunctions;
use CustomClasses\responseClass;
if(!isset($_SESSION)){
    session_start();
}
//if(isset($_SERVER)&&($_SERVER['REQUEST_METHOD']==Constants::$POST_REQUEST_NAME)){
    $userName = (isset($_SESSION[Constants::$SESSION_USER_NAME])&& $_SESSION[Constants::$SESSION_USER_NAME]!='')?$_SESSION[Constants::$SESSION_USER_NAME]:'';
    $reportIndex = (isset($_POST[Constants::$POST_REQUEST_REPORT_NAME])&& $_POST[Constants::$POST_REQUEST_REPORT_NAME]!='')?$_POST[Constants::$POST_REQUEST_REPORT_NAME]:'11';
    $customerName = (isset($_POST['customerName'])&& $_POST['customerName']!='')?$_POST['customerName']:'';
    $userId = (isset($_POST['userId'])&& $_POST['userId']!='')?$_POST['userId']:'';
    
    
    $campaignIndex = $_POST['campaign_index'];
    $date_range = $_POST['date_range'];
    $helper = new helperFunctions();

    switch ($reportIndex) {
        case Constants::$TOP_FIVE_BIGGEST_INCREASE_IN_VISITORS_INDEX:
            if($_SESSION[Constants::$SESSION_USER_TYPE]==2){
                $userName = Constants::$MASTER_NAME ;
            }
            echo json_encode($helper->getTop5BiggestIncreaseInVisitors($userName));
            break;
        case Constants::$BIGGEST_INCREASE_IN_CPC_INDEX:
            if($_SESSION[Constants::$SESSION_USER_TYPE]==2){
                $userName = Constants::$MASTER_NAME ;
            }
            echo json_encode($helper->getBiggestIncreaseInCPC($userName));
            break;
        case Constants::$BIGGEST_UNDERSPEND_INDEX:
            if($_SESSION[Constants::$SESSION_USER_TYPE]==2){
                $userName = Constants::$MASTER_NAME ;
            }
            echo json_encode($helper->getBiggestUnderSpend($userName));
            break;
        case Constants::$WORST_FIVE_WITH_BIGGEST_DECREASE_IN_VISITORS_INDEX:
            if($_SESSION[Constants::$SESSION_USER_TYPE]==2){
                $userName = Constants::$MASTER_NAME ;
            }
            echo json_encode($helper->getWorstFiveWithBiggestDecreaseInVisitors($userName));
            break;
        case Constants::$BEST_DECREASE_IN_CPC_INDEX:
            if($_SESSION[Constants::$SESSION_USER_TYPE]==2){
                $userName = Constants::$MASTER_NAME ;
            }
            echo json_encode($helper->getBestDecreaseInCPC($userName));
            break;
        case Constants::$BIGGEST_OVERSPENDS_INDEX:
            if($_SESSION[Constants::$SESSION_USER_TYPE]==2){
                $userName = Constants::$MASTER_NAME ;
            }
            echo json_encode($helper->getBiggestOverspends($userName));
            break;
        case Constants::$BIGGEST_GAIN_IN_EXPECTED_CONVERSIONS_INDEX:
            if($_SESSION[Constants::$SESSION_USER_TYPE]==2){
                $userName = Constants::$MASTER_NAME ;
            }
            echo json_encode($helper->getBiggestGainInExpectedConversions($userName));
            break;
        case Constants::$BIGGEST_CHANGE_IN_CPA_INDEX:
            if($_SESSION[Constants::$SESSION_USER_TYPE]==2){
                $userName = Constants::$MASTER_NAME ;
            }
            echo json_encode($helper->getBiggestChangeInCPA($userName));
            break;
        case Constants::$WORST_DROP_IN_EXPECTED_CONVERSIONS_INDEX:
            if($_SESSION[Constants::$SESSION_USER_TYPE]==2){
                $userName = Constants::$MASTER_NAME ;
            }
            echo json_encode($helper->getWorstDropInExpectedConversions($userName));
            break;
        case Constants::$BEST_CHANGE_IN_CPA_INDEX:
            if($_SESSION[Constants::$SESSION_USER_TYPE]==2){
                $userName = Constants::$MASTER_NAME ;
            }
            echo json_encode($helper->getBestChangeInCPA($userName));
            break;
        case Constants::$CAMPAIGN_REPORT_INDEX:
            echo json_encode($helper->getCampaignAnalysisReports($campaignIndex,$date_range));
            break;
        case Constants::$DAILY_REPORT_INDEX:
            if($_SESSION[Constants::$SESSION_USER_TYPE]==2){
                $userName = '';
		echo json_encode($helper->getDailyReports($userName, $userId, $customerName));
            }
            elseif($_SESSION[Constants::$SESSION_USER_TYPE]==3){

		$itemsFromDB = array();

                foreach($_SESSION[Constants::$SESSION_USER_USERS] as $userName){

                        $uname = explode('@', $userName);
                        $uname = $uname[0];

                        $result = $helper->getDailyReports($uname) ;

                        if($result->responseCode==1){

                                $itemsFromDB = array_merge($itemsFromDB,$result->returnObject);
                        }
                }
                $response = new responseClass();

                $response->responseCode = 1;
                $response->responseMessage = "Success";
                $response->returnObject = $itemsFromDB;

                echo json_encode($response);
            }
            elseif($_SESSION[Constants::$SESSION_USER_TYPE]==4){
                //Prospect User
                $userName = explode('@', $userName);
                $userName = $userName[0];
                echo json_encode($helper->getProspectUserDailyReports($userName));

            }
            else{
                $userName = explode('@', $userName);
                $userName = $userName[0];
                echo json_encode($helper->getDailyReports($userName));
            }
            break;
        default:
            break;
    }

//}







