<?php

//some changes made by bisjo

/**
 * This will crete shoping campaign with all required criteria
 */
//mail('bisjo.vbridge@gmail.com', 'Just Test', 'This message was send at - '.time().' on '.date('D F Y'));
require_once dirname(__FILE__) .'/examples/AdWords/v201605/init.php';
require dirname(__FILE__) .'/ProductPartitionHelper.php';
require dirname(__FILE__) .'/GetCampaigns.php';
require_once dirname(__FILE__) .'/Classes/AppConstants.php';
require_once dirname(__FILE__) .'/Classes/DatabaseHelper.php';
require_once dirname(__FILE__) . '/shoppingCampaignHelper.php';


try {
    require_once dirname(__FILE__) . '/Classes/PHPExcel/IOFactory.php';
    include_once dirname(__FILE__) .'/Classes/HelperMethods.php';
    $restartCount = 0;
    restart:
    ini_set("max_execution_time", 0);
    set_time_limit(0);
    $dbHelper = new DbHelper;
    $allRecords = array();
//    echo $argc;
//    echo php_sapi_name();
    if(defined('STDIN')||  php_sapi_name() == 'cgi-fcgi' || php_sapi_name() == 'cli'){
        
//        echo $argc;
//        die("\n died.\n");
        if($argc>2){
            $list = $dbHelper->getRecordByUserId($argv[1],1,true);
            if(count($list)>0){
                $allRecords[] = $list;
            }
            
//            mail('bisjo.vbridge@gmail.com', 'getRecordByUserId with arguments - '.$argc, 'This message was send at - '.time().' on '.date('D F Y'));
        }else{
            // get all non processed sheets
            $allRecords = $dbHelper->getSheetsToProcess();
//            mail('bisjo.vbridge@gmail.com', 'getSheetsToProcess with arguments - '.$argc, 'This message was send at - '.time().' on '.date('D F Y'));
        }
    }else{
        die("Should be run as CLI or cron only.");
    }
    $dbHelper->addToTestTable('Cron started. This message was send at - '.time().' on '.date('jS F Y'));
//    mail('bisjo.vbridge@gmail.com', 'getSheetsToProcess with arguments - '.$argc , 'This message was send at - '.time().' on '.date('D F Y'));
//    print_r($allRecords);
//    die("died");
    
    foreach ($allRecords as $record){
        $accountId = $record->account_id;
        $record_id = $record->id;
        // get all non processed rows in a particular sheet
        $ret = $dbHelper->getSheetNonProcessedRows($record_id);
        $fileNameArray = explode('/', $record->upload_name);
        $uploadedFileName = dirname(__FILE__) . "/uploads/".$fileNameArray[count($fileNameArray)-1];
        $helperMethods = new HelperMethods();
        $total = count($ret);
        $oauth2Infos = array(
	    "client_id" => AppConstants::$CLIENTID,
	    "client_secret" => AppConstants::$SECRET,
	    "refresh_token" => $dbHelper->getAppropriateToken($accountId)
	);
	$user = new AdWordsUser(NULL,AppConstants::$DEVTOKEN,AppConstants::$AGENT,NULL,NULL,$oauth2Infos);
        $user->SetClientCustomerId($accountId);
        
        $budgetService = $user->GetService('BudgetService', ADWORDS_VERSION); 
        $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
        $labelService = $user->GetService('LabelService', ADWORDS_VERSION);
        $adGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);
        $adGroupCriterionService = $user->GetService('AdGroupCriterionService', ADWORDS_VERSION);
        $campaignCriterionService = $user->GetService('CampaignCriterionService', ADWORDS_VERSION);


        foreach ($ret as $value) {
            if(isset($value->target)&&$value->target!=''){
                
                //initialize values
                $dataValues = new shoppingCampaignHelper($value);

                // Run the Shopping campign creation.
                $status  =   $dataValues->addShoppingCampaign($user, $record_id, $dbHelper, $budgetService, $campaignService, $labelService, $adGroupService, $adGroupCriterionService, $campaignCriterionService);
                // update processed row count
                $dbHelper->updateProcessedRecordCount($record_id);
                // update processed row status
                $dbHelper->updateProcessedRowStatus($record_id, $value->position_no, implode(',', $status));
            
                $dbHelper->addToTestTable('Row process finished.');
            }else {
            }   
        }
        $remainingRows = $dbHelper->getSheetNonProcessedRows($record_id);
        if(count($remainingRows)==0){
            // mark upload as finished
            $dbHelper->finishUpload($record_id);
        }
    }   
} catch (Exception $e) {
    $dbHelper = new DbHelper();
    $dbHelper->addToTestTable($e->getMessage());
    printf("An error has occurred: %s\n", $e->getMessage());
    if($restartCount<3){
        $restartCount++;
        goto restart;
    }
    
}
$dbHelper->addToTestTable('Just Test finished. This message was send at - '.time().' on '.date('jS F Y'));
//mail('bisjo.vbridge@gmail.com', 'Just Test finished', 'This message was send at - '.time().' on '.date('D F Y'));