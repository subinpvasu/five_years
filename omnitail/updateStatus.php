<?php
/* if(!isset($_SESSION)){
    session_start();
} */
include_once 'functions.php';
include_once './Classes/AppConstants.php';
include_once './Classes/DatabaseHelper.php';

$userId = isset($_SESSION['user_id'])?$_SESSION['user_id']:1;
$accountId = isset($_REQUEST['account'])?$_REQUEST['account']:'';
$location = isset($_REQUEST['location'])?$_REQUEST['location']:1;
$objDb = new DbHelper();
$result_array = array('errorStatus'=>0,'errorMessage'=>'','uploadFinished' => 0,'campaignCreated' => 0,'campaignUpdated' => 0, 'adgroupCreated' => 0,'adgroupUpdated' => 0, 'productGroupCount' => 0,'upload_name' =>'');

$record_details = $objDb->getRecordByUserId($accountId,$location);
if(is_array($record_details) && !empty($record_details)){
    $fileNameArray = explode('/', $record_details['upload_name']);
    $uploadedFileName =  "uploads/".$fileNameArray[count($fileNameArray)-1];
    $record_id = $record_details['id'];
    $result_array = $objDb->getUpdatedCount($record_id);
    $result_array['uploadFinished'] = $record_details['uploadFinished'];
    $result_array['upload_name'] = $uploadedFileName;
    $result_array['isUploadFinished'] = $record_details['upload_status'];
    $result_array['errorStatus'] = 1;
    $result_array['errorMessage'] = "No error";
}else{
    $result_array['errorStatus'] = 0;
    $result_array['errorMessage'] = "Details not found. Please check after some time.";
}
//$final_result = array_merge($result_array);
echo json_encode($result_array);
?>