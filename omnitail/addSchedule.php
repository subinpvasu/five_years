<?php
if(!isset($_SESSION)){
    session_start();
}
include_once './Classes/AppConstants.php';
include_once './Classes/DatabaseHelper.php';
$objDb = new DbHelper();
$objDb->addToTestTable("Ad scheduling started");
$userId = isset($_SESSION['user_id'])?$_SESSION['user_id']:1;
$accountId = isset($_REQUEST['accountId'])?$_REQUEST['accountId']:'';
if($accountId!=''){
    $fileToExec = dirname(__FILE__)."/createAdSchedulingCampaign.php ";
    $fullCommand = AppConstants::$COMMAND . $fileToExec .$userId." ".$accountId." 'alert' >> request_info.log &";
    $b = shell_exec($fullCommand);
    echo 'Upload process started. Please check after some time.';
}else{
    echo 'Invalid account...';
}