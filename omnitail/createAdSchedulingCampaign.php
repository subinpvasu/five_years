<?php
// some changes made by bisjo
/**
 * This will crete shoping campaign with all required criteria
 */
require_once dirname(__FILE__) . '/examples/AdWords/v201605/init.php';
require dirname(__FILE__) . '/ProductPartitionHelper.php';
require dirname(__FILE__) . '/GetCampaigns.php';
require_once dirname(__FILE__) . '/Classes/AppConstants.php';
require_once dirname(__FILE__) . '/Classes/DatabaseHelper.php';
require_once dirname(__FILE__) . '/adschedulingCampaignHelper.php';
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
    // die;
    $dbHelper = new DbHelper();
    $dbHelper->addToTestTable('Reached top');
    $record = $dbHelper->getRecordByUserId($accountId,2);
    $record_id = $record['id'];
    $fileNameArray = explode('/', $record['upload_name']);
    $uploadedFileName = dirname(__FILE__) . "/uploads/" . $fileNameArray[count($fileNameArray) - 1];
    $dbHelper->addToTestTable($fileNameArray[2]);
    $objPHPExcel = PHPExcel_IOFactory::load($uploadedFileName);
    $type = PHPExcel_IOFactory::identify($uploadedFileName);

    //starts here...

    
    
    
    
    
    
    
    
    
    
    $helperMethods = new HelperMethods();
    $ret = $helperMethods->getSpreadSheetValuesAsArray($objPHPExcel);
    $dbHelper->addToTestTable('Excel read');
    // $record_id = $dbHelper->startUpload($uploadedFileName, 1);
    //$user = new AdWordsUser();
    
    $oauth2Infos = array(
        "client_id" => AppConstants::$CLIENTID,
        "client_secret" => AppConstants::$SECRET,
        "refresh_token" => $dbHelper->getAppropriateToken($accountId)
    );
    $user = new AdWordsUser(NULL,AppConstants::$DEVTOKEN,AppConstants::$AGENT,NULL,NULL,$oauth2Infos);
    
    
    $user->SetClientCustomerId($accountId);
    // Log every SOAP XML request and response.
    //$user->LogAll();
    
    print_r($ret);exit();
   
    
   /*  foreach ($ret as $value) {
       
        if ($value['Target'] != '') {
            // initialize values
            // $dataValues = new dataConstant($value);
            $dataValues = new adschedulingCampaignHelper($value);
            // Run the Shopping campign creation.
            $dataValues->adSchedulingCamapign($user);
            
        } else {
            break;
        }
    } */
    $dbHelper->addToTestTable('Reached bottom');
    $dbHelper->finishUpload($record_id);
} catch (Exception $e) {
    printf("An error has occurred: %s\n", $e->getMessage());
}
