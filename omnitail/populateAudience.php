<?php

if (!isset($_SESSION)) {
    session_start();
}
ini_set("memory_limit", "1024M");

// some changes made by bisjo
/**
 * This will crete ad schedules for all given campaigns
 */
require_once dirname(__FILE__) . '/examples/AdWords/v201605/init.php';
require dirname(__FILE__) . '/ProductPartitionHelper.php';
require dirname(__FILE__) . '/GetCampaigns.php';
require_once dirname(__FILE__) . '/Classes/AppConstants.php';
require_once dirname(__FILE__) . '/Classes/DatabaseHelper.php';
require_once dirname(__FILE__) . '/addAudienceHelper.php';

try {
    // Get AdWordsUser from credentials in "../auth.ini"
    // relative to the AdWordsUser.php file's directory.
    require_once dirname(__FILE__) . '/Classes/PHPExcel/IOFactory.php';
    include_once dirname(__FILE__) . '/Classes/HelperMethods.php';
    ini_set("max_execution_time", 0);
    set_time_limit(0);
    if (defined('STDIN')) {
        $userId = $argv[1];
        $accountId = $argv[2];
    } else {
        $userId = isset($_GET['user_id']) ? $_GET['user_id'] : '';
        $accountId = isset($_REQUEST['accountId']) ? $_REQUEST['accountId'] : '';
    }
    $dbHelper = new DbHelper();
    $record = $dbHelper->getRecordByUserId($accountId,3);
  //  print_r($record);
    $record_id = $record['id'];
   // echo $record_id;

    $oauth2Infos = array(
        "client_id" => AppConstants::$CLIENTID,
        "client_secret" => AppConstants::$SECRET,
        "refresh_token" => $dbHelper->getAppropriateToken($accountId)
    );
    $user = new AdWordsUser(NULL,AppConstants::$DEVTOKEN,AppConstants::$AGENT,NULL,NULL,$oauth2Infos);
    $user->SetClientCustomerId($accountId);
      
    $audiences = $dbHelper->selectAudiences($record_id,AppConstants::$NOT_PROCESSED_STATUS);
// print_r($audiences);
    $z = 0;
    $currentAudienceStatus = '';
    
    $campaigns = array ();
    $adgroupid = array();
    foreach ($audiences as $schedule) {
        $adgroupid['AdgroupId'] = $schedule['adgroupid'];
        $adgroupid['CampaignId'] = $schedule['campaignid'];
        $audienceArray = array(
            'AudienceID' => $schedule['audienceid'],
            'AudienceName' => $schedule['audience_name'],
            'BidAdj' => $schedule['bid_adjust'],
            'TargetSetting' => $schedule['targeting_setting']           
        );
        
        //intiating helper classs
    //    print_r($audienceArray);exit();
        $dataValues = new addAudienceHelper($adgroupid, $audienceArray);

        //removing campaigns schedules
       
        //if(!in_array($adgroupid,$campaigns)) { $dataValues->remove_existing_schedules($user, $value); $campaigns[]=$value; }
        
        //setting campaign schedules
        
        $currentAudienceStatus = $dataValues->adAudienceAdgroup($user);
               print_r($currentAudienceStatus);
        //update status to table
        $update = $dbHelper->updateAudiences($schedule['id'], $currentAudienceStatus['status'],  addslashes($currentAudienceStatus['err_message']));

        $recordId = $schedule['recordId'];
    }


    $dbHelper->addToTestTable('Scedules updated for '.$recordId);
    $dbHelper->finishUpload($record_id);
 echo 'Audience Associate Completed';
} catch (Exception $e) {
    printf("An error has occurred: %s\n", $e->getMessage());
} 

