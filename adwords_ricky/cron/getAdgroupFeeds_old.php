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

 $customer = 7351858675 ;
/*echo $customer ;
exit; */

$user->SetClientCustomerId($customer);


$adgroupFeeds = $services -> getFeedItemService($user);                  

/* $feeditems = array();

foreach($adgroupFeeds as $feeds){
	
	$feeditems[] = array($feeds -> feedId ,$feeds -> feedItemId,$feeds -> status,$feeds -> devicePreference ->devicePreference,$feeds -> campaignTargeting ->TargetingCampaignId ,$feeds -> adGroupTargeting -> TargetingAdGroupId ) ;
	
	
}
 */

echo "<pre>";

print_r($adgroupFeeds);

echo "</pre>";