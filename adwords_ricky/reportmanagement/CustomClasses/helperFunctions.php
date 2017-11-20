<?php
namespace CustomClasses;
include_once dirname(__FILE__).'/responseClass.php';
include_once dirname(__FILE__).'/dbOperations.php';
include_once dirname(__FILE__).'/Constants.php';
include_once dirname(__FILE__).'/topFiveBiggestIncreaseInVisitors.php';
include_once dirname(__FILE__).'/BiggestIncreaseInCpc.php';
include_once dirname(__FILE__).'/BiggestUnderspend.php';
include_once dirname(__FILE__).'/WorstFiveWithBiggestDecreaseInVisitors.php';
include_once dirname(__FILE__).'/BestDecreasesInCPC.php';
include_once dirname(__FILE__).'/BiggestOverspends.php';
include_once dirname(__FILE__).'/BiggestGainInExpectedConversions.php';
include_once dirname(__FILE__).'/BiggestChangeInCPA.php';
include_once dirname(__FILE__).'/WorstDropInExpectedConversions.php';
include_once dirname(__FILE__).'/BestChangeInCPA.php';
include_once dirname(__FILE__).'/DailyReport.php';
include_once dirname(__FILE__).'/User.php';
use CustomClasses\dbOperations;
use CustomClasses\responseClass;
use CustomClasses\Constants;
use CustomClasses\topFiveBiggestIncreaseInVisitors;
use CustomClasses\BiggestIncreaseInCpc;
use CustomClasses\BiggestUnderspend;
use CustomClasses\WorstFiveWithBiggestDecreaseInVisitors;
use CustomClasses\BestDecreasesInCPC;
use CustomClasses\BiggestOverspends;
use CustomClasses\BiggestGainInExpectedConversions;
use CustomClasses\BiggestChangeInCPA;
use CustomClasses\WorstDropInExpectedConversions;
use CustomClasses\BestChangeInCPA;
use CustomClasses\DailyReport;
use CustomClasses\User;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of helperFunctions
 *
 * @author user
 */
class helperFunctions {


    public function fillEmptyColumns($colDiff){
        $emptyColumns = "";
        for($i=1;$i<$colDiff;$i++){
            $emptyColumns .= ",''";
        }
        return $emptyColumns;
    }

    public function makeSqlValues($inputString, $inpArray, $user,$userId, $clientReplacer,$valueReplacer,$headingReplacer, $userReplacer, $userIdReplacer, $zeroReplacementArray, $emptyReplacementArray){
        $opt1="";
        for ($i=0;$i<count($inpArray);$i++){
            if($i%2 == 0){
                $opt = str_replace($clientReplacer, $inpArray[$i], $inputString);
            }else if($opt1!=""){
                $opt1 .= ",".str_replace($valueReplacer, $inpArray[$i], $opt);
            }else{
                $opt1 .= str_replace($valueReplacer, $inpArray[$i], $opt);
            }
        }

        $opt1 = str_replace($userIdReplacer, $userId, $opt1);
        $opt1 = str_replace($userReplacer, $user, $opt1);
        $opt1 = str_replace($headingReplacer, 1, $opt1);
        $opt1 = str_replace($zeroReplacementArray, '0', $opt1);
        $opt1 = str_replace($emptyReplacementArray, '', $opt1);
        return $opt1;

    }


    public function getTop5BiggestIncreaseInVisitors($userName){
        $response = new responseClass();
        $objDb = new dbOperations();
        $itemsFromDB = array();
        try{
            $dbResult = $objDb->getSpecificSummeryReports($userName, Constants::$TOP_FIVE_BIGGEST_INCREASE_IN_VISITORS_INDEX);
            while ($reportsToDisplay = mysqli_fetch_object($dbResult->returnObject)){
                $topFiveObj = new topFiveBiggestIncreaseInVisitors();
                $itemsFromDB[] = $topFiveObj->populateModel($reportsToDisplay);
            }
            if(count($itemsFromDB)>0){
                $response->responseCode = 1;
                $response->responseMessage = "Success";
                $response->returnObject = $itemsFromDB;
            }else{
                $response->responseCode= 0;
                $response->responseMessage= "Not found";
                $response->returnObject= null;
            }
        } catch (\Exception $ex) {
            $response->responseCode = 0;
            $response->responseMessage = $ex->getMessage();
            $response->returnObject = null;
        }
        return $response;
    }


    public function getBiggestIncreaseInCPC($userName){
        $response = new responseClass();
        $objDb = new dbOperations();
        $itemsFromDB = array();
        try{
            $dbResult = $objDb->getSpecificSummeryReports($userName, Constants::$BIGGEST_INCREASE_IN_CPC_INDEX);
            while ($reportsToDisplay = mysqli_fetch_object($dbResult->returnObject)){
                $biggestIncreaseinCPCObj = new BiggestIncreaseInCpc();
                $itemsFromDB[] = $biggestIncreaseinCPCObj->populateModel($reportsToDisplay);
            }
            if(count($itemsFromDB)>0){
                $response->responseCode = 1;
                $response->responseMessage = "Success";
                $response->returnObject = $itemsFromDB;
            }else{
                $response->responseCode= 0;
                $response->responseMessage= "Not found";
                $response->returnObject= null;
            }
        } catch (\Exception $ex) {
            $response->responseCode = 0;
            $response->responseMessage = $ex->getMessage();
            $response->returnObject = null;
        }
        return $response;
    }


    public function getBiggestUnderSpend($userName){
        $response = new responseClass();
        $objDb = new dbOperations();
        $itemsFromDB = array();
        try{
            $dbResult = $objDb->getSpecificSummeryReports($userName, Constants::$BIGGEST_UNDERSPEND_INDEX);
            while ($reportsToDisplay = mysqli_fetch_object($dbResult->returnObject)){
                $biggestUnderSpendObj = new BiggestUnderspend();
                $itemsFromDB[] = $biggestUnderSpendObj->populateModel($reportsToDisplay);
            }
            if(count($itemsFromDB)>0){
                $response->responseCode = 1;
                $response->responseMessage = "Success";
                $response->returnObject = $itemsFromDB;
            }else{
                $response->responseCode= 0;
                $response->responseMessage= "Not found";
                $response->returnObject= null;
            }
        } catch (\Exception $ex) {
            $response->responseCode = 0;
            $response->responseMessage = $ex->getMessage();
            $response->returnObject = null;
        }
        return $response;
    }


    public function getWorstFiveWithBiggestDecreaseInVisitors($userName){
        $response = new responseClass();
        $objDb = new dbOperations();
        $itemsFromDB = array();
        try{
            $dbResult = $objDb->getSpecificSummeryReports($userName, Constants::$WORST_FIVE_WITH_BIGGEST_DECREASE_IN_VISITORS_INDEX);
            while ($reportsToDisplay = mysqli_fetch_object($dbResult->returnObject)){
                $worstFiveWithBiggestDecreaseInVisitorsObj = new WorstFiveWithBiggestDecreaseInVisitors();
                $itemsFromDB[] = $worstFiveWithBiggestDecreaseInVisitorsObj->populateModel($reportsToDisplay);
            }
            if(count($itemsFromDB)>0){
                $response->responseCode = 1;
                $response->responseMessage = "Success";
                $response->returnObject = $itemsFromDB;
            }else{
                $response->responseCode= 0;
                $response->responseMessage= "Not found";
                $response->returnObject= null;
            }
        } catch (\Exception $ex) {
            $response->responseCode = 0;
            $response->responseMessage = $ex->getMessage();
            $response->returnObject = null;
        }
        return $response;
    }


    public function getBestDecreaseInCPC($userName){
        $response = new responseClass();
        $objDb = new dbOperations();
        $itemsFromDB = array();
        try{
            $dbResult = $objDb->getSpecificSummeryReports($userName, Constants::$BEST_DECREASE_IN_CPC_INDEX);
            while ($reportsToDisplay = mysqli_fetch_object($dbResult->returnObject)){
                $bestDecreasesInCPCObj = new BestDecreasesInCPC();
                $itemsFromDB[] = $bestDecreasesInCPCObj->populateModel($reportsToDisplay);
            }
            if(count($itemsFromDB)>0){
                $response->responseCode = 1;
                $response->responseMessage = "Success";
                $response->returnObject = $itemsFromDB;
            }else{
                $response->responseCode= 0;
                $response->responseMessage= "Not found";
                $response->returnObject= null;
            }
        } catch (\Exception $ex) {
            $response->responseCode = 0;
            $response->responseMessage = $ex->getMessage();
            $response->returnObject = null;
        }
        return $response;
    }


    public function getBiggestOverspends($userName){
        $response = new responseClass();
        $objDb = new dbOperations();
        $itemsFromDB = array();
        try{
            $dbResult = $objDb->getSpecificSummeryReports($userName, Constants::$BIGGEST_OVERSPENDS_INDEX);
            while ($reportsToDisplay = mysqli_fetch_object($dbResult->returnObject)){
                $biggestOvrspendsObj = new BiggestOverspends();
                $itemsFromDB[] = $biggestOvrspendsObj->populateModel($reportsToDisplay);
            }
            if(count($itemsFromDB)>0){
                $response->responseCode = 1;
                $response->responseMessage = "Success";
                $response->returnObject = $itemsFromDB;
            }else{
                $response->responseCode= 0;
                $response->responseMessage= "Not found";
                $response->returnObject= null;
            }
        } catch (\Exception $ex) {
            $response->responseCode = 0;
            $response->responseMessage = $ex->getMessage();
            $response->returnObject = null;
        }
        return $response;
    }


    public function getBiggestGainInExpectedConversions($userName){
        $response = new responseClass();
        $objDb = new dbOperations();
        $itemsFromDB = array();
        try{
            $dbResult = $objDb->getSpecificSummeryReports($userName, Constants::$BIGGEST_GAIN_IN_EXPECTED_CONVERSIONS_INDEX);
            while ($reportsToDisplay = mysqli_fetch_object($dbResult->returnObject)){
                $biggestGainInExpectedConversionsObj = new BiggestGainInExpectedConversions();
                $itemsFromDB[] = $biggestGainInExpectedConversionsObj->populateModel($reportsToDisplay);
            }
            if(count($itemsFromDB)>0){
                $response->responseCode = 1;
                $response->responseMessage = "Success";
                $response->returnObject = $itemsFromDB;
            }else{
                $response->responseCode= 0;
                $response->responseMessage= "Not found";
                $response->returnObject= null;
            }
        } catch (\Exception $ex) {
            $response->responseCode = 0;
            $response->responseMessage = $ex->getMessage();
            $response->returnObject = null;
        }
        return $response;
    }


    public function getBiggestChangeInCPA($userName){
        $response = new responseClass();
        $objDb = new dbOperations();
        $itemsFromDB = array();
        try{
            $dbResult = $objDb->getSpecificSummeryReports($userName, Constants::$BIGGEST_CHANGE_IN_CPA_INDEX);
            while ($reportsToDisplay = mysqli_fetch_object($dbResult->returnObject)){
                $biggestChangeInCPAObj = new BiggestChangeInCPA();
                $itemsFromDB[] = $biggestChangeInCPAObj->populateModel($reportsToDisplay);
            }
            if(count($itemsFromDB)>0){
                $response->responseCode = 1;
                $response->responseMessage = "Success";
                $response->returnObject = $itemsFromDB;
            }else{
                $response->responseCode= 0;
                $response->responseMessage= "Not found";
                $response->returnObject= null;
            }
        } catch (\Exception $ex) {
            $response->responseCode = 0;
            $response->responseMessage = $ex->getMessage();
            $response->returnObject = null;
        }
        return $response;
    }


    public function getWorstDropInExpectedConversions($userName){
        $response = new responseClass();
        $objDb = new dbOperations();
        $itemsFromDB = array();
        try{
            $dbResult = $objDb->getSpecificSummeryReports($userName, Constants::$WORST_DROP_IN_EXPECTED_CONVERSIONS_INDEX);
            while ($reportsToDisplay = mysqli_fetch_object($dbResult->returnObject)){
                $worstDropInExpectedConversionsObj = new WorstDropInExpectedConversions();
                $itemsFromDB[] = $worstDropInExpectedConversionsObj->populateModel($reportsToDisplay);
            }
            if(count($itemsFromDB)>0){
                $response->responseCode = 1;
                $response->responseMessage = "Success";
                $response->returnObject = $itemsFromDB;
            }else{
                $response->responseCode= 0;
                $response->responseMessage= "Not found";
                $response->returnObject= null;
            }
        } catch (\Exception $ex) {
            $response->responseCode = 0;
            $response->responseMessage = $ex->getMessage();
            $response->returnObject = null;
        }
        return $response;
    }


    public function getBestChangeInCPA($userName){
        $response = new responseClass();
        $objDb = new dbOperations();
        $itemsFromDB = array();
        try{
            $dbResult = $objDb->getSpecificSummeryReports($userName, Constants::$BEST_CHANGE_IN_CPA_INDEX);
            while ($reportsToDisplay = mysqli_fetch_object($dbResult->returnObject)){
                $worstDropInExpectedConversionsObj = new BestChangeInCPA();
                $itemsFromDB[] = $worstDropInExpectedConversionsObj->populateModel($reportsToDisplay);
            }
            if(count($itemsFromDB)>0){
                $response->responseCode = 1;
                $response->responseMessage = "Success";
                $response->returnObject = $itemsFromDB;
            }else{
                $response->responseCode= 0;
                $response->responseMessage= "Not found";
                $response->returnObject= null;
            }
        } catch (\Exception $ex) {
            $response->responseCode = 0;
            $response->responseMessage = $ex->getMessage();
            $response->returnObject = null;
        }
        return $response;
    }


    public function getDailyReports($userName, $userId='', $customerName=''){
        $response = new responseClass();
        $objDb = new dbOperations();
        $itemsFromDB = array();
        try{
            $dbResult = $objDb->getDailyReports($userName, $userId, $customerName);
            while ($reportsToDisplay = mysqli_fetch_object($dbResult->returnObject)){
                $dailyReportObj = new DailyReport();
                $itemsFromDB[] = $dailyReportObj->populateModel($reportsToDisplay);
            }
            if(count($itemsFromDB)>0){
                $response->responseCode = 1;
                $response->responseMessage = "Success";
                $response->returnObject = $itemsFromDB;
            }else{
                $response->responseCode= 0;
                $response->responseMessage= "Not found";
                $response->returnObject= null;
            }
        } catch (\Exception $ex) {
            $response->responseCode = 0;
            $response->responseMessage = $ex->getMessage();
            $response->returnObject = null;
        }
        return $response;
    }


    public function getUser($userName){
        $response = new responseClass();
        $objDb = new dbOperations();
        $itemsFromDB = array();
        try{
            $dbResult = $objDb->getUser($userName);
            while ($reportsToDisplay = mysqli_fetch_object($dbResult->returnObject)){
                $userObj = new User();
                $itemsFromDB = $userObj->populateModel($reportsToDisplay);
            }
            if($itemsFromDB){
                $response->responseCode = 1;
                $response->responseMessage = "Success";
                $response->returnObject = $itemsFromDB;
            }else{
                $response->responseCode= 0;
                $response->responseMessage= "Not found";
                $response->returnObject= null;
            }
        } catch (\Exception $ex) {
            $response->responseCode = 0;
            $response->responseMessage = $ex->getMessage();
            $response->returnObject = null;
        }
        return $response;
    }


    public function addToArray($reportArray,$column,$content,$firstCol,$secondCol){
        if($column==$secondCol && ((count($reportArray)%2)==0)){
            $reportArray[] = "";
            $reportArray[] = addslashes($content);
        }else if($column==$firstCol && ((count($reportArray)%2)==1)){
            $reportArray[] = "";
            $reportArray[] = addslashes($content);
        }else{
            $reportArray[] = addslashes($content);
        }
        return $reportArray;
    }
    //getCampaignAnalysisReports
    /**
     *daily report changed to getCampaignAnalysisReports
     *changes made by subinpvasu on 11/12/2015
     */
    public function getCampaignAnalysisReports($adword_account_id,$date_range){
        $response = new responseClass();
        $objDb = new dbOperations();
        $itemsFromDB = array();
        try{
            $dbResult = $objDb->getCampaignAnalysisReports($adword_account_id,$date_range);
            while ($reportsToDisplay = mysqli_fetch_object($dbResult->returnObject)){
                $dailyReportObj = new DailyReport();
                $itemsFromDB[] = $dailyReportObj->populateModel($reportsToDisplay);
            }
            if(count($itemsFromDB)>0){
                $response->responseCode = 1;
                $response->responseMessage = "Success";
                $response->returnObject = $itemsFromDB;
            }else{
                $response->responseCode= 0;
                $response->responseMessage= "Not found";
                $response->returnObject= null;
            }
        } catch (\Exception $ex) {
            $response->responseCode = 0;
            $response->responseMessage = $ex->getMessage();
            $response->returnObject = null;
        }
        return $response;
    }
    
    /**
     * Get head of search and other users
     * @param type $adword_account_id
     * @param type $date_range
     * @return responseClass
     */
    public function getHeadAndNormalUsersOnly(){
        $response = new responseClass();
        $objDb = new dbOperations();
        $itemsFromDB = array();
        try{
            $dbResult = $objDb->getUsers();
            while ($reportsToDisplay = mysqli_fetch_object($dbResult->returnObject)){
                $dailyReportObj = new User();
                $itemsFromDB[] = $dailyReportObj->populateModel($reportsToDisplay);
            }
            if(count($itemsFromDB)>0){
                $response->responseCode = 1;
                $response->responseMessage = "Success";
                $response->returnObject = $itemsFromDB;
            }else{
                $response->responseCode= 0;
                $response->responseMessage= "Not found";
                $response->returnObject= null;
            }
        } catch (\Exception $ex) {
            $response->responseCode = 0;
            $response->responseMessage = $ex->getMessage();
            $response->returnObject = null;
        }
        return $response;
    }
}
