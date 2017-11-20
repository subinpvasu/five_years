<?php
namespace CustomClasses;
include_once dirname(__FILE__).'/dbConnect.php';
include_once dirname(__FILE__).'/responseClass.php';
use CustomClasses\responseClass;
use CustomClasses\dbConnect;
//$b = dirname(__FILE__);
/**
 * This class will have all the functions related to database.
 *
 * @author user
 */
class dbOperations {


    /**
     * This method will execute an sql query and returns
     * the result in a responseClass object.
     *
     * @param type $sql
     * @return responseClass
     */
    public function exeuteQuery($sql){
        $response = new responseClass();

        try{
            $objdb = new dbConnect();
            $connection = $objdb->connectToDb();
            $result = $connection->query($sql);
            if($result){
                $response->responseCode = 1;
                $response->responseMessage = "Succes";
                $response->returnObject = $result;
            }else{
                $response->responseCode = 0;
                $response->responseMessage = "Failed";
                $response->returnObject = $result;
            }
            $objdb->closeConnection($connection);
        }  catch (\Exception $ex){
            $response->responseCode = 1;
            $response->responseMessage = $ex->getMessage();
            $response->returnObject = null;
        }
        return $response;
    }

    /**
     * This method will fetch a specific summary report from database.
     *
     * @param type $userName
     * @param type $reportIndex
     * @return responseClass\
     */
    public function getSpecificSummeryReports($userName, $reportIndex){
        $response = new responseClass();
        try{
            $objdb = new dbConnect();
            $connection = $objdb->connectToDb();
            $result = $connection->query("CALL spad_getsummeryreports('$userName',$reportIndex)");
            if($result){
                $response->responseCode = 1;
                $response->responseMessage = "Succes";
                $response->returnObject = $result;
            }else{
                $response->responseCode = 0;
                $response->responseMessage = "Failed";
                $response->returnObject = $result;
            }
            $objdb->closeConnection($connection);
        } catch (\Exception $ex) {
            $response->responseCode = 1;
            $response->responseMessage = $ex->getMessage();
            $response->returnObject = null;
        }
        return $response;
    }

    /**
     * This method will fetch daily reports for a user.
     *
     * @param type $userName
     * @param type $userId
     * @param type $customerName
     * @return responseClass
     */
    public function getDailyReports($userName, $userId='', $customerName=''){
        $response = new responseClass();
        try{
            $objdb = new dbConnect();
            $connection = $objdb->connectToDb();
            $result = $connection->query("CALL spad_getdailyreports('$userName','$userId','$customerName')");
            
            if($result){
                $response->responseCode = 1;
                $response->responseMessage = "Succes";
                $response->returnObject = $result;
            }else{
                $response->responseCode = 0;
                $response->responseMessage = "Failed";
                $response->returnObject = $result;
            }
            $objdb->closeConnection($connection);
        } catch (\Exception $ex) {
            $response->responseCode = 1;
            $response->responseMessage = $ex->getMessage();
            $response->returnObject = null;
        }
        return $response;
    }

    /**
     * This method will get a user using user name.
     *
     * @param type $userName
     * @return responseClass
     */
    public function getUser($userName){
        $response = new responseClass();
        try{
            $objdb = new dbConnect();
            $connection = $objdb->connectToDb();
            $result = $connection->query("select * from adword_user where ad_user_name ='$userName';");
            if($result){
                $response->responseCode = 1;
                $response->responseMessage = "Succes";
                $response->returnObject = $result;
            }else{
                $response->responseCode = 0;
                $response->responseMessage = "Failed";
                $response->returnObject = $result;
            }
            $objdb->closeConnection($connection);
        } catch (\Exception $ex) {
            $response->responseCode = 1;
            $response->responseMessage = $ex->getMessage();
            $response->returnObject = null;
        }
        return $response;
    }

    /**
     * getDailyReports override here and works for campaign analysis report.
     * CHANGES MADE BY SUBINPVASU on 11/12/2015.
     */
    public function getCampaignAnalysisReports($adword_account_id,$date_range){
        $response = new responseClass();
        try{
            $objdb = new dbConnect();
            $connection = $objdb->connectToDb();


            $newstr = substr_replace($adword_account_id, '-', 3, 0);
            $string = substr_replace($newstr, '-', 7, 0);

            $sql = "SELECT * FROM campaign_analysis_report WHERE client_id='$string' AND date_range=$date_range ORDER BY adwords_conversions_current_month DESC ";


            $result = $connection->query($sql);
            if($result){
                $response->responseCode = 1;
                $response->responseMessage = "Succes";
                $response->returnObject = $result;
            }else{
                $response->responseCode = 0;
                $response->responseMessage = "Failed";
                $response->returnObject = $result;
            }
            $objdb->closeConnection($connection);
        } catch (\Exception $ex) {
            $response->responseCode = 1;
            $response->responseMessage = $ex->getMessage();
            $response->returnObject = null;
        }
        return $response;
    }

    /**
     * getDailyReports override here and works for campaign analysis report.
     * CHANGES MADE BY Bisjo  on 13/10/2016.
     */
    public function getUsers(){
        $response = new responseClass();
        try{
            $objdb = new dbConnect();
            $connection = $objdb->connectToDb();
            $sql = "SELECT ad_user_id, ad_person_name, ad_user_name, ad_user_password, ad_delete_status, ad_user_type, ad_user_report_link, user_users, ad_user_account_show_previlage, created_time, updated_time FROM adword_user where ad_delete_status <> 1 and (ad_user_type = 1 or  ad_user_type = 2);";
            $result = $connection->query($sql);
            if($result){
                $response->responseCode = 1;
                $response->responseMessage = "Succes";
                $response->returnObject = $result;
            }else{
                $response->responseCode = 0;
                $response->responseMessage = "Failed";
                $response->returnObject = $result;
            }
            $objdb->closeConnection($connection);
        } catch (\Exception $ex) {
            $response->responseCode = 0;
            $response->responseMessage = $ex->getMessage();
            $response->returnObject = null;
        }
        return $response;
    }
}
