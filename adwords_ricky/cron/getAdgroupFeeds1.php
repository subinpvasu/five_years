<?php
require_once dirname(__FILE__) . '/../includes/init.php';
require_once dirname(__FILE__) . '/../includes/includes.php';

$sql_mcc_select = "SELECT customerId,refresh_token,prospect_account FROM adword_mcc_accounts order by mcc_id asc limit 1 ";

$res_mcc_selects = $main -> getResults($sql_mcc_select);


$refresh_token = $res_mcc_selects[0] -> refresh_token ;
		
$developerToken = DEVELOPER_TOKEN ;

$userAgent = USER_AGENT ;

$oauth2Info = array(
	"client_id" => CLIENT_ID ,
	"client_secret" => CLIENT_SECRET,
	"refresh_token" => $refresh_token 
);


$user = new AdWordsUser(NULL,$developerToken,NULL,$userAgent,NULL,NULL,$oauth2Info);

$user->LogAll();

$customerId = $res_mcc_selects[0] ->customerId ;

 $customer = 4008115079 ;
/*echo $customer ;
exit; */

$user->SetClientCustomerId($customer);


$adgroupFeeds = $services -> getFeedItemService($user);                  

foreach($adgroupFeeds as $adgroupFeed){

$adgroup_feeds[] = array(

'feedId' => $adgroupFeed -> feedId ,
'feedItemId' => $adgroupFeed -> feedItemId ,
'status' => $adgroupFeed -> status ,
'devicePreference' => $adgroupFeed -> devicePreference ->devicePreference ,
'campaignTargeting' => $adgroupFeed ->campaignTargeting -> TargetingCampaignId ,
'adGroupTargeting' => $adgroupFeed ->adGroupTargeting -> TargetingAdGroupId ,



);

}


echo "<pre>";

print_r($adgroup_feeds);

echo "</pre>";