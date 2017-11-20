<?php
/**
 * This will crete ad schedules for all given campaigns
 */

//session initializing
if (!isset($_SESSION)) {
    session_start();
}

// initial server settings
ini_set("memory_limit", "1024M");
ini_set("max_execution_time", 0);
set_time_limit(0);

// collect all required files and classes
require_once dirname(__FILE__) . '/examples/AdWords/v201605/init.php';
require dirname(__FILE__) . '/ProductPartitionHelper.php';
require dirname(__FILE__) . '/GetCampaigns.php';
require_once dirname(__FILE__) . '/Classes/AppConstants.php';
require_once dirname(__FILE__) . '/Classes/DatabaseHelper.php';
require_once dirname(__FILE__) . '/adschedulingCampaignHelper.php';
require_once dirname(__FILE__) . '/Classes/PHPExcel/IOFactory.php';
include_once dirname(__FILE__) . '/Classes/HelperMethods.php';

try {
    // checks whether command line execution or not
    if (defined('STDIN')) {
        $userId = $argv[1];
        $accountId = $argv[2];
    } else {
        $userId = isset($_GET['user_id']) ? $_GET['user_id'] : '';
        $accountId = isset($_REQUEST['accountId']) ? $_REQUEST['accountId'] : '';
    }
    
    $dbHelper = new DbHelper();
    $record = $dbHelper->getRecordByUserId($accountId, 2);
    $record_id = $record['id'];

    // setting google auth tokens
    $oauth2Infos = array(
        "client_id" => AppConstants::$CLIENTID,
        "client_secret" => AppConstants::$SECRET,
        "refresh_token" => $dbHelper->getAppropriateToken($accountId)
    );
    $user = new AdWordsUser(NULL,AppConstants::$DEVTOKEN,AppConstants::$AGENT,NULL,NULL,$oauth2Infos);
    $user->SetClientCustomerId($accountId);
    
    // getting schedules from database.
    $schedules = $dbHelper->selectAdSchedules($record_id,AppConstants::$NOT_PROCESSED_STATUS);

    $z = 0;
    $currentScheduleStatus = '';
    $campaigns = array ();
    foreach ($schedules as $schedule) {
        $value = $schedule['campaign'];
        $scheduleArray = array(
            'bid' => trim($schedule['bid']),
            'day' => trim($schedule['day']),
            'startHour' => trim($schedule['startHour']),
            'startMin' => trim($schedule['startMin']),
            'endHour' => trim($schedule['endHour']),
            'endMin' => trim($schedule['endMin'])
        );
        
        //intiating helper classs
        $dataValues = new adschedulingCampaignHelper($value, $scheduleArray);

        //removing campaigns schedules
        if(!in_array($value,$campaigns)) {
            $dataValues->remove_existing_schedules($user, $value);
            $campaigns[]=$value;
        }
        
        //setting campaign schedules
        $currentScheduleStatus = $dataValues->adSchedulingCamapign($user);
               
        //update status to table
        $update = $dbHelper->updateAdSchedules($schedule['id'], $currentScheduleStatus['status'],  addslashes($currentScheduleStatus['err_message']));
        $recordId = $schedule['recordId'];
    }
    // mark current scheduling process as complete.
    $dbHelper->finishUpload($record_id);
} catch (Exception $e) {
    printf("An error has occurred: %s\n", $e->getMessage());
} 
