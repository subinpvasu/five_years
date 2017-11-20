<?php
require_once dirname(__FILE__) . '/../includes/init.php';
require_once dirname(__FILE__) . '/../includes/includes.php';


try{
	
	$refresh_token = '1/qo6xrGPKYsSw-A5zgUvlc5O1dNTd1JIwjvOpm981o7c';
	
	$customerId =6093644096;
	
	$developerToken = DEVELOPER_TOKEN ;
		
	$userAgent = USER_AGENT ;
	
	$startDate = '20150601 000000';
	
	$endDate = '20160720 20000';
	
	//$account =  7209280788  ;
	$account =  2570035894  ;
	
	$oauth2Info = array(
			"client_id" => CLIENT_ID ,
			"client_secret" => CLIENT_SECRET,
			"refresh_token" => $refresh_token 
	);
	
	$user = new AdWordsUser(null,$developerToken, $userAgent, $customerId,null, $oauth2Info);
	
	$user->LogAll();
	
	$user->SetClientCustomerId($account);
	
$campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
$customerSyncService = $user->GetService('CustomerSyncService', ADWORDS_VERSION);

  // Get an array of all campaign ids.
  $campaignIds = array();
  $selector = new Selector();
  $selector->fields = array('Id');
  $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
  do {
    $page = $campaignService->get($selector);
    if (isset($page->entries)) {
      foreach ($page->entries as $campaign) {
        $campaignIds[] = $campaign->id;
      }
    }
    $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
  } while ($page->totalNumEntries > $selector->paging->startIndex);
  
  

  // Set the date time range, from 24 hours ago until now.
  $dateTimeRange = new DateTimeRange();
  $dateTimeRange->min = date('Ymd his', strtotime('-30 days'));
  $dateTimeRange->max = date('Ymd his', strtotime('-1 days'));

  // Create selector.
  $selector = new CustomerSyncSelector();
  $selector->dateTimeRange = $dateTimeRange;
  $selector->campaignIds = $campaignIds;

  
  // Make the get request.
  $accountChanges = $customerSyncService->get($selector);
  
  echo "<pre>";
  
  print_r($accountChanges ) ;

	
}

catch(Exception $e){

	
	echo "ERROR CODE : ".$e->getCode()." ERROR MESSAGE : ".$e->getMessage() ;
	
}

