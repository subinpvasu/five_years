<?php

//some changes made by bisjo

/**
 * This will Update shoping campaign and adgroup status
 */

require_once './examples/AdWords/v201605/init.php';
require_once './Classes/AppConstants.php';
require_once './Classes/DatabaseHelper.php';
include_once './shoppingCampaignHelper.php';

try {
        $shoppingHelperObj = new shoppingCampaignHelper(array());
	$userId = 1;
	if(isset($_SESSION['user_id'])) $userId = $_SESSION['user_id'];
        $activationStatus = isset($_REQUEST['status'])?$_REQUEST['status']:'';
        $accountId = isset($_REQUEST['accountId'])?$_REQUEST['accountId']:'';
        if($accountId==''){
            echo 'Invalid account Id';
            die();
        }
        if($activationStatus == 'activate'){
            $activationAction = 'ENABLED';
            $dbStatus = 1;
        }else{
            $activationAction = 'PAUSED';
            $dbStatus = 0;
        }
	$record_id = 0;
	$dbHelper = new DbHelper;
	$record_details = $dbHelper->getRecordByUserId($accountId);
	

	
	$oauth2Infos = array(
	    "client_id" => AppConstants::$CLIENTID,
	    "client_secret" => AppConstants::$SECRET,
	    "refresh_token" => $dbHelper->getAppropriateToken($accountId)
	);
	$user = new AdWordsUser(NULL,AppConstants::$DEVTOKEN,AppConstants::$AGENT,NULL,NULL,$oauth2Infos);
	
	
	
	
	//$user = new AdWordsUser();
	$user->SetClientCustomerId($accountId);
	if(is_array($record_details) && !empty($record_details))
	{
		$record_id = $record_details['id'];
	}
	$camapignsToChangeStatus = $dbHelper->getActivationCampaigns($record_id);
	foreach($camapignsToChangeStatus as $selected_campaign)
	{
		$new_campaign_statu = $shoppingHelperObj->changeCampaignStatus($user, $selected_campaign['campaignId'], $activationAction);
		$updateDb = $dbHelper->activateCampaign($selected_campaign['campaignId'],$dbStatus);
		
	}
	$adgroupsToChangeStatus = $dbHelper->getActivationAdgroups($record_id);
	foreach($adgroupsToChangeStatus as $selected_adgroup)
	{
		$new_campaign_statu = $shoppingHelperObj->changeAdgroupStatus($user, $selected_adgroup['adgroupId'], $activationAction);
		$updateDb = $dbHelper->activateAdgroup($selected_adgroup['adgroupId'],$dbStatus);
		
	}
	$user->LogAll();
        echo 'Ads enabled...';
       
} catch (Exception $e) {
  printf("An error has occurred: %s\n", $e->getMessage());
}
