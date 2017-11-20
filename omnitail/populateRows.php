<?php
if(!isset($_SESSION)){
    session_start();
}
include_once './Classes/AppConstants.php';
include_once './Classes/DatabaseHelper.php';
$userId = isset($_SESSION['user_id'])?$_SESSION['user_id']:1;
$accountId = isset($_REQUEST['accountId'])?$_REQUEST['accountId']:'';
$objDb = new DbHelper();
$objDb->addToTestTable("Populte rows started");
$record = $objDb->getRecordByUserId($accountId);
$updateStatus = $objDb->updateEnableProcessStatus($record['id']);
if($updateStatus){
    $fileToExec = dirname(__FILE__)."/createShoppingCampaign.php ";
    $fullCommand = AppConstants::$COMMAND . $fileToExec ." ".$accountId." 'alert' >> request_info.log &";
//    $fullCommand = $command . $fileToExec .$userId." ".$accountId." 'alert' >> request_info.log &";
//    $b = shell_exec($fullCommand);
    $b = exec($fullCommand);
//    echo $fullCommand;
    echo 'Upload process started. Please check after some time.';
}else{
    echo 'Invalid account...';
}