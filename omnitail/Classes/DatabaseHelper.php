<?php
/**
 * Class for performing database operations
 */

class DbHelper{
    
    /**
     * Method to establish database connection
     * @return \mysqli
     */
    private function getConnection(){
        try{
            $connection = new mysqli(AppConstants::$SERVER_NAME, AppConstants::$USER_NAME, 
                AppConstants::$PASSWORD, AppConstants::$DB_NAME);
            return $connection;
        } catch (Exception $ex) {
            trigger_error(AppConstants::$MYSQL_CONNECTION_ERROR.$ex->getMessage(),E_ERROR);
//            die(AppConstants::$MYSQL_CONNECTION_ERROR.$ex->getMessage());
        }
        
    }
    
    /**
     * Close previously established databse connection
     * @param type $connection
     */
    private function closeConnection($connection){
        try{
            mysqli_close($connection);
        } catch (Exception $ex) {

        }
    }

    /**
     * Function calls when upload starting
     * @param type $uploadFileName
     * @param type $uploadedBy
     * @param type $accountId
     * @return type
     */
    public function startUpload($uploadFileName, $uploadedBy, $accountId,$location, $totalRows){
        $currentDateTime = date('Y-m-d H:i:s');
        $connect = $this->getConnection();
        $result = $connect->query("INSERT INTO tbl_records (uploadStarted,upload_name, 	user_id_fk, account_id,location,total_rows) VALUES ('$currentDateTime','$uploadFileName', $uploadedBy, '$accountId','$location',$totalRows)");
        if ($result) {
            $id = $connect->insert_id;
            $this->closeConnection($connect);
            return $id;
        }else{ 
            echo $connect->error;
            $this->closeConnection($connect);
        }

    }

    /**
     * Function calls when upload finishing
     * @param type $record_id
     * @return type
     */
    public function finishUpload($record_id)
    {
        $currentDateTime = date('Y-m-d H:i:s');
        $connect = $this->getConnection();
        $result = $connect->query("UPDATE tbl_records SET `uploadFinished` = '$currentDateTime' , upload_status = 1 WHERE `tbl_records`.`id` = $record_id;");
        if ($result) {
            $id = $connect->insert_id;
            $this->closeConnection($connect);
            return $id;
        }else{
            echo $connect->error;
            $this->closeConnection($connect);
        }

    }

    /**
     * Function to return record by recordid
     * @param type $record_id
     * @return string
     */
    public function getRecordById($record_id){
        $connect = $this->getConnection();
        $result = $connect->query("SELECT * FROM tbl_records WHERE `tbl_records`.`id` = $record_id;");
        if ($result) {
            $this->closeConnection($connect);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    return $row;
                }
            }else {
                return 'No results found';
            }
        }else{ 
        echo $connect->error;
        $this->closeConnection($connect);
        }
    }

    /**
     * Function to return last record of user by userid
     * @param type $accountId
     * @return string
     */
    public function getRecordByUserId($accountId,$location=1,$isObject=false){
        $connect = $this->getConnection();
        $result = $connect->query("SELECT * FROM tbl_records WHERE `tbl_records`.`account_id` = '$accountId'  AND location='$location' ORDER BY `tbl_records`.`id` DESC;");
        if ($result) {
            $this->closeConnection($connect);
            if ($result->num_rows > 0 && $isObject) {
                $row = mysqli_fetch_object($result);
                return $row;
            }else if($result->num_rows > 0 && !$isObject){
                $row = $result->fetch_assoc();
                return $row;
            }else {
                return 'No results found';
            }
        }else {
            echo $connect->error;
            $this->closeConnection($connect);
        }
    }

    /**
     * Get count of campaigns created on  an upload
     * @param type $recordId
     * @return type
     */
    public function getCampaignCount($recordId)
    {
        $totalCount = 0;
        $connect = $this->getConnection();
        $result = $connect->query("SELECT * FROM tbl_campaigns WHERE `tbl_campaigns`.`recordId` = $recordId");
        if ($result) {
            $this->closeConnection($connect);
            $totalCount = $result->num_rows;
            return $totalCount;
        }else{ 
            echo $connect->error;
            $this->closeConnection($connect);
        }
    }
    
    /**
     * Get count of created campaigns
     * @param type $recordId
     * @param type $uploaded_time
     * @return type
     */
    public function getCreatedCampaignCount($recordId,$uploaded_time){
        $totalCount = 0;
        $connect = $this->getConnection();
        $result = $connect->query("SELECT * FROM tbl_campaigns WHERE `tbl_campaigns`.`recordId` = $recordId AND `tbl_campaigns`.`campaignCreated` > '$uploaded_time'");
        if ($result) {
            $this->closeConnection($connect);
            $totalCount = $result->num_rows;
            return $totalCount;
        }else{
            echo $connect->error;
            $this->closeConnection($connect);

        }
    }
    
    /**
     * Get count of updated campaigns
     * @param type $recordId
     * @param type $uploaded_time
     * @return type
     */
    public function getUpdatedCampaignCount($recordId,$uploaded_time){
        $totalCount = 0;
        $connect = $this->getConnection();
        $result = $connect->query("SELECT * FROM tbl_campaigns WHERE `tbl_campaigns`.`recordId` = $recordId AND `tbl_campaigns`.`campaignCreated` < '$uploaded_time'");
        if ($result) {
            $this->closeConnection($connect);
            $totalCount = $result->num_rows;
            return $totalCount;
        }else{ 
            echo $connect->error;
            $this->closeConnection($connect);
        }
    }
 
    /**
     * Return campaigns to activate
     * @param type $recordId
     * @return type
     */
    public function getActivationCampaigns($recordId){
        $campaignsList = array();
        $connect = $this->getConnection();
        $result = $connect->query("SELECT * FROM tbl_campaigns WHERE `tbl_campaigns`.`recordId` = $recordId AND `campaignStatus` = 0" );
        if ($result) {
            $this->closeConnection($connect);
            while($row = $result->fetch_assoc()) {
                $campaignsList[] = $row;
            }
            return $campaignsList;
        }else{
            echo $connect->error;
            $this->closeConnection($connect);
        }
    }

    /**
     * Returns id of a campaign
     * @param type $campaignId
     * @param type $campaignName
     * @param type $merchantId
     * @param type $recordId
     * @return type
     */
    public function getCampaignId($campaignId, $campaignName, $merchantId, $recordId)
    {
        $campaign_id = 0;
        $connect = $this->getConnection();
        $result = $connect->query("SELECT * FROM tbl_campaigns WHERE `tbl_campaigns`.`campaignId` = $campaignId AND `merchantId` = $merchantId");
        if ($result) {
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $currentDateTime = date('Y-m-d H:i:s');
                    $result = $connect->query("UPDATE tbl_campaigns SET `lastUpdated` = '$currentDateTime', `recordId` = $recordId WHERE `tbl_campaigns`.`campaignId` = $campaignId AND `tbl_campaigns`.`merchantId` = $merchantId;");
                    if ($result) {
                        $this->closeConnection($connect);
                        return $row['id']; 
                    }else{
                        echo $connect->error;
                        $this->closeConnection($connect);
                    }
                }
           }else {
               $result = $connect->query("INSERT INTO tbl_campaigns (campaignId, campaignName, merchantId, recordId) VALUES ($campaignId,'$campaignName', $merchantId, $recordId);");
               if ($result) {
                   $id = $connect->insert_id;
                    $this->closeConnection($connect);
                    return $id;
                }else{
                    echo $connect->error;
                    $this->closeConnection($connect);
                }
           }
        }else{
            echo $connect->error;
            $this->closeConnection($connect);
        }
    }


    /**
     * Function to add details of campaign Call when new campaign created
     * @param type $campaignId
     * @param type $campaignName
     * @param type $merchantId
     * @param type $recordId
     * @return type
     */
    public function addCampaign($campaignId, $campaignName, $merchantId, $recordId){
        $connect = $this->getConnection();
        $result = $connect->query("INSERT INTO tbl_campaigns (campaignId, campaignName, merchantId, recordId) VALUES ($campaignId,'$campaignName', $merchantId, $recordId);");
        if ($result) {
            $id = $connect->insert_id;
            $this->closeConnection($connect);
            return $id;
        }else{
            echo $connect->error;
            $this->closeConnection($connect);
        }
    }
	

    /**
     * Function to update status of campaign Call when new activation button clicked
     * @param type $campaignId
     * @param type $status
     */
    public function activateCampaign($campaignId, $status=0){
        $currentDateTime = date('Y-m-d H:i:s');
        $connect = $this->getConnection();
        $result = $connect->query("UPDATE tbl_campaigns SET `campaignStatus` = '$status', `lastUpdated` = '$currentDateTime' WHERE `tbl_campaigns`.`campaignId` = $campaignId;");
        if ($result) {
            $this->closeConnection($connect);
          $campaign = "Campaign updated"; 
        }else{
            echo $connect->error;
            $this->closeConnection($connect);
        }
    }

    /**
     * Get count of adgroup created on  an upload
     * @param type $recordId
     * @return type
     */
    public function getAdgroupCount($recordId){
        $totalCount = 0;
        $connect = $this->getConnection();
        $result = $connect->query("SELECT * FROM tbl_adgroups WHERE `tbl_adgroups`.`recordId` = $recordId");
        if ($result) {
            $this->closeConnection($connect);
            return $result->num_rows;
        }else{
            echo $connect->error;
            $this->closeConnection($connect);
        }
    }
    
    /**
     * get count of created adgroups
     * @param type $recordId
     * @param type $uploaded_time
     * @return type
     */
    public function getCreatedAdgroupCount($recordId,$uploaded_time){
        $totalCount = 0;
        $connect = $this->getConnection();
        $result = $connect->query("SELECT * FROM tbl_adgroups WHERE `tbl_adgroups`.`recordId` = $recordId AND `tbl_adgroups`.`adgroupCreated` > '$uploaded_time'");
        if ($result) {
            $this->closeConnection($connect);
            return $result->num_rows;
        }else{
            echo $connect->error;
            $this->closeConnection($connect);
        }
    }
    
    /**
     * Get count of updated adgroups
     * @param type $recordId
     * @param type $uploaded_time
     * @return type
     */
    public function getUpdatedAdgroupCount($recordId,$uploaded_time){
        $totalCount = 0;
        $connect = $this->getConnection();
        $result = $connect->query("SELECT * FROM tbl_adgroups WHERE `tbl_adgroups`.`recordId` = $recordId AND `tbl_adgroups`.`adgroupCreated` < '$uploaded_time'");
        if ($result) {
            $this->closeConnection($connect);
            return $result->num_rows;
        }else{
            echo $connect->error;
            $this->closeConnection($connect);
        }
    }

    /**
     * Return already existing adgroupId
     * @param type $adgroupId
     * @param type $adgroupName
     * @param type $campaignId
     * @param type $merchantId
     * @param type $recordId
     * @return type
     */
    public function getAdgroupId($adgroupId, $adgroupName, $campaignId, $merchantId, $recordId){
        $campaign_id = 0;
        $connect = $this->getConnection();
        $result = $connect->query("SELECT * FROM tbl_adgroups WHERE `tbl_adgroups`.`campaignId` = $campaignId AND `adgroupId` = '$adgroupId'");
        if ($result) {
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $currentDateTime = date('Y-m-d H:i:s');
                    $result = $connect->query("UPDATE tbl_adgroups SET `lastUpdated` = '$currentDateTime', `recordId` = $recordId WHERE `tbl_campaigns`.`campaignId` = $campaignId AND `tbl_campaigns`.`adgroupId` = '$adgroupId';");
                    if ($result) {
                        $this->closeConnection($connect);
                      return $row['id']; 
                    }else{
                        echo $connect->error;
                        $this->closeConnection($connect);
                    }
                }
            }else{
                $result = $connect->query("INSERT INTO tbl_adgroups (adgroupId, adgroupName, campaignId, merchantId, recordId) VALUES ('$adgroupId', '$adgroupName', $campaignId, $merchantId, $recordId);");
                if ($result) {
                    $id = $connect->insert_id;
                    $this->closeConnection($connect);
                    return $id;
                }else{
                    echo $connect->error;
                    $this->closeConnection($connect);
                }
           }
        }else{
            echo $connect->error;
            $this->closeConnection($connect);
        }
    }

    /**
     * Return PAUSED adgroups to activate
     * @param type $recordId
     * @return type
     */
    public function getActivationAdgroups($recordId){
        $adgroupsList = array();
        $connect = $this->getConnection();
        $result = $connect->query("SELECT * FROM tbl_adgroups WHERE `tbl_adgroups`.`recordId` = $recordId AND `adgroupStatus` = 0" );
        if ($result) {
            $this->closeConnection($connect);
            while($row = $result->fetch_assoc()) {
                $adgroupsList[] = $row;
            }
            return $adgroupsList;
        }else{
            echo $connect->error;
            $this->closeConnection($connect);
        }
    }

    /**
     * Function to add new Adgroup Call when new adgroup created
     * @param type $adgroupId
     * @param type $adgroupName
     * @param type $campaignId
     * @param type $merchantId
     * @param type $recordId
     * @return type
     */
    public function addAdgroup($adgroupId, $adgroupName, $campaignId, $merchantId, $recordId){
        $connect = $this->getConnection();
        $result = $connect->query("INSERT INTO tbl_adgroups (adgroupId, adgroupName, campaignId, merchantId, recordId) VALUES ('$adgroupId', '$adgroupName', $campaignId, $merchantId, $recordId);");
        if ($result) {
            $id = $connect->insert_id;
            $this->closeConnection($connect);
            return $id;
        }else{
            echo $connect->error;
            $this->closeConnection($connect);
        }

    }

    /**
     * Function to update time stamp of Adgroup 
     * @param type $adgroupName
     * @param type $recordId
     * @return type
     */
    public function updateAdgroup($adgroupName, $recordId){
        $connect = $this->getConnection();
        $currentDateTime = date('Y-m-d H:i:s');
        $result = $connect->query("UPDATE tbl_adgroups SET `lastUpdated` = '$currentDateTime' WHERE `recordId` = $recordId AND adgroupName = '$adgroupName';");
        if ($result) {
            $result = $connect->query("SELECT * from tbl_adgroups WHERE `recordId` = $recordId AND adgroupName = '$adgroupName';");
            $this->closeConnection($connect);
            $resultObj = mysqli_fetch_object($result);
           return $resultObj->id;
        }else{
            echo $connect->error;
        }

    }

    /**
     * Function to check an adgroup exist
     * @param type $adgroupId
     * @param type $adgroupName
     * @param type $campaignId
     * @param type $merchantId
     * @param type $recordId
     * @return type
     */
    public function isAdgroupExist($adgroupName, $campaignId){
        $connect = $this->getConnection();
        $result = $connect->query("SELECT count(*) as groupCount from tbl_adgroups where adgroupName='$adgroupName' and campaignId=$campaignId;");
        $this->closeConnection($connect);
        $retObj = mysqli_fetch_object($result);
        if ($retObj->groupCount >= 1) {
           return true;
        }else{
            return false;
        }

    }
    
    /**
     * Activate paused adgroup
     * @param type $adgroupId
     * @param type $status
     */
    public function activateAdgroup($adgroupId, $status=0){
        $currentDateTime = date('Y-m-d H:i:s');
        $connect = $this->getConnection();
        $result = $connect->query("UPDATE tbl_adgroups SET `adgroupStatus` = $status, `lastUpdated` = '$currentDateTime' WHERE `tbl_adgroups`.`adgroupId` = '$adgroupId' ;");
        $this->closeConnection($connect);
        if ($result) {

        }else{
            echo $connect->error;
        }
    }

    /**
     * Get count of product group created on  an upload
     * @param type $recordId
     * @return type
     */
    public function getProductGroupCount($recordId){
        $connect = $this->getConnection();
        $result = $connect->query("SELECT * FROM tbl_productgroups WHERE `tbl_productgroups`.`recordId` = $recordId");
        $this->closeConnection($connect);
        if ($result) {
            return $result->num_rows;
        }else{
            echo $connect->error;
        }
    }
    
    /**
     * Create product group in db
     * @param type $target_type
     * @param type $target_value
     * @param type $adgroupId
     * @param type $campaignId
     * @param type $merchantId
     * @param type $recordId
     */
    public function addProductGroup($target_type, $target_value, $adgroupId, $campaignId, $merchantId, $recordId){
        $connect = $this->getConnection();
        $result = $connect->query("INSERT INTO tbl_productgroups (target, targetData, adgroupId, campaignId, merchantId, recordId) VALUES ('$target_type', '$target_value', $adgroupId, $merchantId, $campaignId, $recordId);");
        $this->closeConnection($connect);
        if ($result) {
           //echo 'The ID is: '.$connect->insert_id;
        }else{
            echo $connect->error;
        }
    }
    
    /**
     * get count of updated campaigns, adgroups
     * @param type $recordId
     * @return type
     */
    public function getUpdatedCount($recordId){
        $record_detais = $this->getRecordById($recordId);
        $recordCreatedTime = $record_detais['uploadStarted'];
        $created_campaign_count = $this->getCreatedCampaignCount($recordId,$recordCreatedTime);
        $updated_campaign_count = $this->getUpdatedCampaignCount($recordId,$recordCreatedTime);
        $created_adgroup_count = $this->getCreatedAdgroupCount($recordId,$recordCreatedTime);
        $updated_adgroup_count = $this->getUpdatedAdgroupCount($recordId,$recordCreatedTime);
        $productGroupCount = $this->getProductGroupCount($recordId);
        $countArray = array('campaignCreated' => $created_campaign_count,'campaignUpdated' => $updated_campaign_count, 'adgroupCreated' => $created_adgroup_count,'adgroupUpdated' => $updated_adgroup_count, 'productGroupCount' => $productGroupCount);
        return $countArray;

    }
    
    /**
     * get all accounts from db
     * @return type
     */
    public function getAllAccounts($account=null){
        $accuntsList = array();
        if(is_null($account) || $account=='')
        {
            $account = AppConstants::$MASTER;
        }
        $connect = $this->getConnection();
        $result = $connect->query("SELECT  `name` ,  `account_number` FROM  `account_details` WHERE mccid='$account' ");
        $this->closeConnection($connect);
        if ($result) {
            while($row = $result->fetch_assoc()) {
                $campaign_count = $this->getCampaignCountsAccounts($row['account_number']);
                $adgroup_count = $this->getAdgroupCountsAccounts($row['account_number']);
                $row['campaign_count'] = $campaign_count;
                $row['adgroup_count'] = $adgroup_count;
                $accuntsList[] = $row;
            }
            return $accuntsList;
        }else{
            echo $connect->error;
        }
    }
    
    /**
     * get an account details with id
     * @param type $accountID
     * @return type
     */
    public function getSelectedAccounts($accountID){
        $accuntsList = array();
        $connect = $this->getConnection();
        $result = $connect->query("SELECT  * FROM  `account_details` where `account_number` = $accountID");
        $this->closeConnection($connect);
        if ($result) {
            while($row = $result->fetch_assoc()) {
                $accuntsList = $row;
            }
            return $accuntsList;
        }else{
            echo $connect->error;
        }
    }
    
    /**
     * get count of campaigns in an account
     * @param type $accountID
     * @return type
     */
    public function getCampaignCountsAccounts($accountID){
        $connect = $this->getConnection();
        $result = $connect->query("SELECT  * FROM  `campaign_data` where `customerid` = $accountID");
        $this->closeConnection($connect);
        if ($result) {
            return $result->num_rows;
        }else{
            echo $connect->error;
        }
    }
    
    /**
     * get campaigns from db
     * @param type $accountID
     * @return type
     */
    public function getCampaignsFromDB($accountID){
        $totalCount = 0;
        $retArray = array();
        $connect = $this->getConnection();
        $result = $connect->query("SELECT  * FROM  `campaign_data` where `customerid` = $accountID");
        $this->closeConnection($connect);
        if ($result) {
            while ($row = mysqli_fetch_object($result)) {
                $retArray[] = $row;
            }
            return $retArray;
        }else{
            echo $connect->error;
        }
    }
    
    /**
     * get count of adgroups in an account
     * @param type $accountID
     * @return type
     */
    public function getAdgroupCountsAccounts($accountID){
        $connect = $this->getConnection();
        $result = $connect->query("SELECT  * FROM  `adgroup_data` where `customerid` = $accountID");
        $this->closeConnection($connect);
        if ($result) {
            return $result->num_rows;
        }else{
            echo $connect->error;
        }
    }
    
    /**
     * get adgroups under a campaign from databse
     * @param type $campaignId
     * @return type
     */
    public function getAdgroupsFromDB($campaignId){
        $retArray = array();
        $connect = $this->getConnection();
        $result = $connect->query("SELECT  * FROM  `adgroup_data` where `campaignid` = $campaignId");
        $this->closeConnection($connect);
        if ($result) {
            while ($row = mysqli_fetch_object($result)) {
                $retArray[] = $row;
            }
            return $retArray;
        }else{
            echo $connect->error;
        }
    }
     
    /**
     * Adding value to a test table for logging data
     * @param type $val
     */
    public function addToTestTable($val) {
        $val = addslashes($val);
        $connect = $this->getConnection();
        $result = $connect->query("INSERT INTO test_tbl (text) VALUES ('$val');");
        $this->closeConnection($connect);
        return $result;
    }
    /**
     * only for refresh token of the account
     * @param unknown $account
     */
    public function getAppropriateToken($account)
    {
        $connect = $this->getConnection();
        $result = $connect->query("SELECT refresh_token FROM prospect_credentials p INNER JOIN account_details a ON p.account_number=a.mccid WHERE a.account_number='$account' ");
        $this->closeConnection($connect);
        if($result)
        {
             $obj=mysqli_fetch_object($result);
             return $obj->refresh_token;
        }
    }
    
    /**
     * This method will update number of processed records
     * @param type $recordId
     * @return boolean
     */
    public function updateProcessedRecordCount($recordId){
        $connect = $this->getConnection();
        $result = $connect->query("CALL spot_updateFinishedRows($recordId)");
        $this->closeConnection($connect);
        if($result){
             return true;
        }else{
            return false;
        }
    }
    
    /**
     * This method will insert status value of a row into process_status table
     * @param type $recordId
     * @param type $position
     * @param type $statusMessage
     * @return boolean
     */
    public function insertStatusOfRow($recordId, $position, $statusMessage) {
        $connect = $this->getConnection();
        $result = $connect->query("insert into process_status (record_id, position_no, processed_status) values ($recordId, $position, '$statusMessage')");
        $this->closeConnection($connect);
        if($result){
             return true;
        }else{
            return false;
        }
    }
    
    /**
     * This method will get the status of all processed rows
     * @param type $recordId
     * @return boolean
     */
    public function getProcessStatus($recordId) {
        $retArray = array();
        $connect = $this->getConnection();
        $result = $connect->query("SELECT * FROM process_status WHERE record_id=$recordId");
        $this->closeConnection($connect);
        if($result){
            while ($row = mysqli_fetch_object($result)) {
                $retArray[] = $row;
            }
            return $retArray;
        }else{
            return false;
        }
        
    }
    
    /**
     * Insert sheet rows to database
     * @param type $insertString
     * @return boolean
     */
    public function insertUploadedFileDetails($insertString){
        $connect = $this->getConnection();
        $query = "insert into process_status (record_id, position_no, processed_status, target, target_data, brand, clo, campaign_name, ad_group_name, bid, priority, merchant_id, budget, label, country) values $insertString ;";
        $result = $connect->query($query);
        $this->closeConnection($connect);
        if($result){
             return true;
        }else{
            return false;
        }
    }
    
    /**
     * Get all sheets to process
     * @return type
     */
    public function getSheetsToProcess() {
        $retArray = array();
        $connect = $this->getConnection();
        $query = "select * from tbl_records where process_enabled = 1 and upload_status = 0";
        $result = $connect->query($query);
        $this->closeConnection($connect);
        if($result){
            while ($row = mysqli_fetch_object($result)) {
                $retArray[] = $row;
            }
            return $retArray;
        }else{
            return null;
        }
    }
    
    /**
     * Get all unprocessed rows
     * @param type $recordId
     * @return type
     */
    public function getSheetNonProcessedRows($recordId) {
        $retArray = array();
        $connect = $this->getConnection();
        $query = "select * from process_status where record_id = $recordId and processed_status='".AppConstants::$NOT_PROCESSED_STATUS."'";
        $result = $connect->query($query);
        $this->closeConnection($connect);
        if($result){
            while ($row = mysqli_fetch_object($result)) {
                $retArray[] = $row;
            }
            return $retArray;
        }else{
            return null;
        }
    }
    
    /**
     * Get all sheet rows
     * @param type $recordId
     * @return type
     */
    public function getSheetRows($recordId) {
        $retArray = array();
        $connect = $this->getConnection();
        $query = "select * from process_status where record_id = $recordId";
        $result = $connect->query($query);
        $this->closeConnection($connect);
        if($result){
            while ($row = mysqli_fetch_object($result)) {
                $retArray[] = $row;
            }
            return $retArray;
        }else{
            return null;
        }
    }
    
    /**
     * Update status of current processing row
     * @param type $recordId
     * @param type $rowNo
     * @param type $statusString
     * @return boolean
     */
    public function updateProcessedRowStatus($recordId, $rowNo, $statusString) {
        $connect = $this->getConnection();
        $query = "update process_status set processed_status='$statusString' where record_id = $recordId and position_no = $rowNo and processed_status='".AppConstants::$NOT_PROCESSED_STATUS."'";
        $result = $connect->query($query);
        $this->closeConnection($connect);
        if($result){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Sets particular sheet for processing
     * @param type $recordId
     * @return boolean
     */
    public function updateEnableProcessStatus($recordId) {
        $connect = $this->getConnection();
        $query = "update tbl_records set process_enabled=1 where id = $recordId";
        $result = $connect->query($query);
        $this->closeConnection($connect);
        if($result){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Inserts schedules 
     * @param type string $insertQuery
     * @return boolean
     */
    
    public function insertAdSchedulingStatus($insertQuery){
        
        $connect = $this->getConnection();
        
        $query = "INSERT INTO ad_schedule_status (`recordId`,`campaignName`,`campaign`,`bid`,`day`,`startHour`,`startMin`,`endHour`,`endMin`) VALUES $insertQuery"; 
        
        echo $query ;
        $result = $connect->query($query);
        
        $this->closeConnection($connect);
        
        if($result){
            return true;
        }else{
            return false;
        }
        
        
    }
    
    public function insertAudienceSatus($insertQuery){
        $connect = $this->getConnection();
        
        $query = "INSERT INTO ad_audience_status( recordId, campaignid, campaign_name, adgroupid, adgroup_name, audienceid, audience_name, bid_adjust, targeting_setting,status, added) VALUES $insertQuery";
        
        echo $query ;
        $result = $connect->query($query);
        
        $this->closeConnection($connect);
        
        if($result){
        return true;
        }else{
        return false;
        }
        
    }
    
    /**
     * Selects schedules with record ID and status 
     * @param type int $recordId & String $status
     * @return array
     */
    
    public function selectAdSchedules($recordId,$status=''){
        
        $retArray = array();
        $connect = $this->getConnection();
        $where = '';
        
        if($status<>'') $where = "and status = '".$status."'" ;
        
        $query = "select * from ad_schedule_status where recordId = '$recordId' $where";
        $result = $connect->query($query);
        $this->closeConnection($connect);
        if($result){
            while ($row = mysqli_fetch_assoc($result)) {
                $retArray[] = $row;
            }
            return $retArray;
        }else{
            return null;
        }
        
    }
    
    public function selectAudiences($recordId,$status=''){
    
        $retArray = array();
        $connect = $this->getConnection();
        $where = '';
    
        if($status<>'') $where = "and status = '".$status."'" ;
    
        $query = "select * from ad_audience_status where recordId = '$recordId' $where";
       // echo $query;
        $result = $connect->query($query);
        $this->closeConnection($connect);
        if($result){
            while ($row = mysqli_fetch_assoc($result)) {
                $retArray[] = $row;
            }
            return $retArray;
        }else{
            return null;
        }
    
    }
    
    public function selectExpandedAds($recordId,$status=''){
    
        $retArray = array();
        $connect = $this->getConnection();
        $where = '';
    
        if($status<>'') $where = "and status = '".$status."'" ;
    
        $query = "select * from extended_ads_status where recordId = '$recordId' $where";
        // echo $query;
        $result = $connect->query($query);
        $this->closeConnection($connect);
        if($result){
            while ($row = mysqli_fetch_assoc($result)) {
                $retArray[] = $row;
            }
            return $retArray;
        }else{
            return null;
        }
    
    }
    /**
     * update schedules having id with status and message
     * @param type int $id & String $status, String $message
     * @return boolean
     */
    
    public function updateAdSchedules($id,$status,$message){
        $connect = $this->getConnection();
        $query = "update ad_schedule_status set status ='$status' , message='$message' , updated_time=NOW()  where id = '$id'";
        $result = $connect->query($query);
        $this->closeConnection($connect);
        if($result){
            return true ;
        }else{
            return false;
        }
        
    }
    
    public function updateAudiences($id,$status,$message){
        $connect = $this->getConnection();
        $query = "update ad_audience_status set status ='$status' , message='$message' , updated=NOW()  where id = ".$id;
       // echo $query;
        $result = $connect->query($query);
        $this->closeConnection($connect);
        if($result){
            return true ;
        }else{
            return false;
        }
    
    }
    public function updateExtendedAdsStatus($id,$status,$message){
        $connect = $this->getConnection();
        $query = "update extended_ads_status set status ='$status' , message='$message' , updated=NOW()  where id = ".$id." and status='".AppConstants::$NOT_PROCESSED_STATUS."'";
        $result = $connect->query($query);
        $this->closeConnection($connect);
        if($result){
            return true ;
        }else{
            return false;
        }
    
    }
    /*
     * Insert Extended ads to db from CSV
     */
    
    public function insertETAdsFileDetails($insertString){
        $connect = $this->getConnection();
        $query = "INSERT INTO extended_ads_status(recordId, status, added, keyword1, keyword2, keyword3, keyword4, headline1, headline2,description, finalurl,  path1, path2, availability,bid, campaign_name, adgroup_name, budget) VALUES $insertString ;";
        $result = $connect->query($query);
        $this->closeConnection($connect);
        if($result){
            return true;
        }else{
            return false;
        }
    }
    
    public function selectAds($recordId, $status='', $start=0, $end=0){
    
        $retArray = array();
        $connect = $this->getConnection();
        $where = '';
        $limit = '';
        if($end != 0){
            $limit = " LIMIT $start,$end";
        }
    
        if($status<>'') $where = "and status = '".$status."'" ;
    
        $query = "select * from extended_ads_status where recordId = '$recordId' $where order by id asc ".$limit;
//        $query = "select * from extended_ads_status where recordId = '$recordId' $where order by campaign_name asc,adgroup_name asc".$limit;
        // echo $query;
        $result = $connect->query($query);
        $this->closeConnection($connect);
        if($result){
            while ($row = mysqli_fetch_assoc($result)) {
                $retArray[] = $row;
            }
            return $retArray;
        }else{
            return null;
        }
    
    }
    
    /**
     * Count of non processed rows
     * @param type $record_id
     * @return int
     */
    public function getNonProcessedAds($record_id){
        $connect = $this->getConnection();
        $result = $connect->query("SELECT id FROM extended_ads_status where status = 'Not Processed' and recordId = $record_id;");
        if ($result) {
            if ($result->num_rows > 0) {
                return $result->num_rows;
            }else {
                return 0;
            }
        }else{ 
        echo $connect->error;
        $this->closeConnection($connect);
        }
    }
	
}

?>