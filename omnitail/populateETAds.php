<?php
if(!isset($_SESSION)){
    session_start();
}
include_once './Classes/AppConstants.php';
include_once './Classes/DatabaseHelper.php';
$userId = isset($_SESSION['user_id'])?$_SESSION['user_id']:1;
$accountId = isset($_REQUEST['accountId'])?$_REQUEST['accountId']:'';
$objDb = new DbHelper();
$record = $objDb->getRecordByUserId($accountId,4);
if($record['process_enabled']==0){
    $objDb->addToTestTable("Populate ETA rows started");
    $updateStatus = $objDb->updateEnableProcessStatus($record['id']);
    if($updateStatus){
        $fileToExec = dirname(__FILE__)."/populateExtendedAds.php ";
        $fullCommand = AppConstants::$COMMAND . $fileToExec ." ".$userId." ".$accountId."  'alert' >> request_info.log &";
        $b = exec($fullCommand);
        echo 'Upload process started. Please check status after some time.';
    }else{
        echo 'Invalid account...';
    }
}else{
    echo 'Process already started. Please check status after some time...<br>';
}
