<?php
if(!isset($_SESSION)){
    session_start();
}
include_once './Classes/AppConstants.php';
include_once './Classes/DatabaseHelper.php';
// $userId = isset($_SESSION['user_id'])?$_SESSION['user_id']:1;
$account = isset($_REQUEST['account'])?$_REQUEST['account']:''; 
$master  = isset($_REQUEST['master'])?$_REQUEST['master']:''; 
// $objDb = new DbHelper();
// $objDb->addToTestTable("Populte rows started");
// $record = $objDb->getRecordByUserId($accountId,3);
// if($record['process_enabled']==0){
//     $updateStatus = $objDb->updateEnableProcessStatus($record['id']);
//     if($updateStatus){
        $fileToExec = dirname(__FILE__)."/omnitail/cron/GetKeywordBidSimulationsTest.php";
        $fullCommand = AppConstants::$COMMAND . $fileToExec ." ".$master." ".$account." 'alert' >> request_info.log &";
    //    $fullCommand = $command . $fileToExec .$userId." ".$accountId." 'alert' >> request_info.log &";
    //    $b = shell_exec($fullCommand);
        $b = exec($fullCommand);
    //    echo $fullCommand;
        echo 'Upload process started. Please check status after some time.';
//     }else{
//         echo 'Invalid account...';
//     }
// }else{
//     echo 'Process already started. Please check status after some time...<br>';
// }
