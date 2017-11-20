<?php
/********************************************************************************************************
 * @Short Description of the File	: commonly used functions
 * @version 						: 0.1
 * @author 							: Deepa Varma<rdvarmaa@gmail.com>
 * @project 						: ADWORDS RICKY
 * @Created on 						: JULY 25 2014
 * @Modified on 					: JULY 25 2014
********************************************************************************************************/

/**** Class for Adwords Services  *****/
class Adwordservices
{


function GetAccounts(AdWordsUser $user) {

	//https://developers.google.com/adwords/api/docs/appendix/selectorfields#v201406-ManagedCustomerService
  // Get the service, which loads the required classes.
  $managedCustomerService = $user->GetService('ManagedCustomerService', ADWORDS_VERSION);

	// Create selector. 
	$selector = new Selector();
	// Specify the fields to retrieve.
	$selector->fields = array( 'CustomerId',  'Name','CompanyName','CanManageClients','CurrencyCode','DateTimeZone');
	$selector->ordering[] = new OrderBy('Name', 'ASCENDING');
	// Make the get request.
	$graph = $managedCustomerService->get($selector);

	// Display serviced account graph.
  if (isset($graph->entries)) {
    // Create map from customerId to parent and child links.
    $childLinks = array();
    $parentLinks = array();
    if (isset($graph->links)) {
      foreach ($graph->links as $link) {
        $childLinks[$link->managerCustomerId][] = $link;
        $parentLinks[$link->clientCustomerId][] = $link;
      }
    }
    // Create map from customerID to account, and find root account.
    $accounts = array();
    $rootAccount = NULL;
    foreach ($graph->entries as $account) {
      
	  $accounts[$account->customerId] = $account;
       
    }
	return $accounts ;

  } else {
    return false;
  }
}
function GetCampaigns(AdWordsUser $user) {
  // Get the service, which loads the required classes.
  $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);

  // Create selector.
  $selector = new Selector();
  $selector->fields = array('Id', 'Name','Status','Eligible','Amount');
  $selector->ordering[] = new OrderBy('Name', 'ASCENDING');

  // Create paging controls.
 // $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);

  do{
    // Make the get request.
		$page = $campaignService->get($selector);
		// Display results.
		if (isset($page->entries)) {
		  return $page->entries ;
		} else {
		  return false ;
		} 
		$selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
	}
	while ($page->totalNumEntries > $selector->paging->startIndex);
}

	function GetAdGroups(AdWordsUser $user, $campaignIds) {
  // Get the service, which loads the required classes.
  //https://developers.google.com/adwords/api/docs/appendix/selectorfields
	  $adGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);

	  // Create selector.
	  $selector = new Selector();
	  $selector->fields = array('Id', 'Name','CampaignId','Status','Labels','ExperimentId');
	  $selector->ordering[] = new OrderBy('Name', 'ASCENDING');

	  // Create predicates.
	  //foreach($campaignIds as $campaignId){
	  
		$selector->predicates[] =  new Predicate('CampaignId', 'IN', $campaignIds);
	  
	 // }

	  // Create paging controls.
	 // $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);

	  do {
		// Make the get request.
		$page = $adGroupService->get($selector);

		// Display results.
		if (isset($page->entries)) {
		  return $page->entries ;
		} else {
		  return false ;
		}

		// Advance the paging index.
		$selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
	  } while ($page->totalNumEntries > $selector->paging->startIndex);
	}
	
	function GetKeywords(AdWordsUser $user, $adGroupIds) {
	  // Get the service, which loads the required classes.
		$adGroupCriterionService =
		$user->GetService('AdGroupCriterionService', ADWORDS_VERSION);

	  // Create selector.
		$selector = new Selector();
		$selector->fields = array('KeywordText', 'KeywordMatchType', 'Id','Status','AdGroupId','QualityScore','CpcBid');
		$selector->ordering[] = new OrderBy('KeywordText', 'ASCENDING');

	  // Create predicates.
		//$selector->predicates[] = new Predicate('AdGroupId', 'IN', $adGroupIds);
		$selector->predicates[] = new Predicate('AdGroupId', 'IN', $adGroupIds);
		$selector->predicates[] =  new Predicate('CriteriaType', 'IN', array('KEYWORD'));
		//$selector->predicates[] =  new Predicate('CpcBidSource', 'EQUALS', 'CRITERION');

	  // Create paging controls.
		//$selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);

		do {
		// Make the get request.
			$page = $adGroupCriterionService->get($selector);
			// Display results.
			if (isset($page->entries)) {
			   return $page->entries ;
			} else {
			  return false ;
			}

			// Advance the paging index.
			//$selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
		} while ($page->totalNumEntries > $selector->paging->startIndex);
	}
	
	
	function GetKeywordsFromCampaigns(AdWordsUser $user, $camapaignId) {
	  // Get the service, which loads the required classes.
		$adGroupCriterionService =
		$user->GetService('CampaignCriterionService', ADWORDS_VERSION);

	  // Create selector.
		$selector = new Selector();
		$selector->fields = array('KeywordText', 'KeywordMatchType', 'Id','TargetingStatus','CampaignId');
		$selector->ordering[] = new OrderBy('KeywordText', 'ASCENDING');

	  // Create predicates.
		//$selector->predicates[] = new Predicate('AdGroupId', 'IN', $adGroupIds);
		$selector->predicates[] = new Predicate('CampaignId', 'IN', $camapaignId);
		$selector->predicates[] =  new Predicate('CriteriaType', 'IN', array('KEYWORD'));

	  // Create paging controls.
		//$selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);

		do {
		// Make the get request.
			$page = $adGroupCriterionService->get($selector);
			// Display results.
			if (isset($page->entries)) {
			   return $page->entries ;
			} else {
			  return false ;
			}

			// Advance the paging index.
			//$selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
		} while ($page->totalNumEntries > $selector->paging->startIndex);
	}
	
	function GetTextAds(AdWordsUser $user, $adGroupIds) {
	  // Get the service, which loads the required classes.
		$adGroupAdService = $user->GetService('AdGroupAdService', ADWORDS_VERSION);

		// Create selector.
		$selector = new Selector();
		//$selector->fields = array( 'Id','Status','AdGroupId','AdType','Labels','Description','Description1','Description2','DevicePreference','DisplayUrl','Headline','HeadlinePart1','HeadlinePart2','Path1','Path2','LongHeadline','Url');
		//$selector->fields = array('Status',);
		$selector->fields = array('Id','Status','AdGroupId','AdType');
		//$selector->ordering[] = new OrderBy('Headline', 'ASCENDING');

		// Create predicates.
		$selector->predicates[] = new Predicate('AdGroupId', 'IN', $adGroupIds);
		$selector->predicates[] = new Predicate('AdType', 'IN', array('EXPANDED_TEXT_AD'));
		// By default disabled ads aren't returned by the selector. To return them
		// include the DISABLED status in a predicate.
		$selector->predicates[] = new Predicate('Status', 'IN', array('ENABLED'));

		// Create paging controls.
		//$selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);

		do {
		// Make the get request.
			$page = $adGroupAdService->get($selector);
			// Display results.
			if (isset($page->entries)) {
			  return $page->entries;
			} else {
			  return false;
			}
			// Advance the paging index.
			$selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
		} while ($page->totalNumEntries > $selector->paging->startIndex);
	}

 
 
 function getCampaignFeedService(AdWordsUser $user){
	$CampaignFeedService = $user->GetService('CampaignFeedService', ADWORDS_VERSION);
	$selector = new Selector();
	$selector->fields = array('CampaignId', 'FeedId','PlaceholderTypes','Status','MatchingFunction');
	//$selector->predicates[] = new Predicate('FeedId', 'IN', $FeedIds);
	//$selector->predicates[] = new Predicate('Status', 'IN', array('ENABLED'));
	$selector->predicates[] = new Predicate('PlaceholderTypes', 'EQUALS', '1');
	do {
	// Make the get request.
		$page = $CampaignFeedService->get($selector);
		// Display results.
		if (isset($page->entries)) {
		  return $page->entries;
		} else {
		   return false;
		}
		// Advance the paging index.
		$selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
	} while ($page->totalNumEntries > $selector->paging->startIndex);
	
 
 }
 function getAdGroupFeedService(AdWordsUser $user){
	$AdGroupFeedService = $user->GetService('AdGroupFeedService', ADWORDS_VERSION);
	$selector = new Selector();
	$selector->fields = array('AdGroupId', 'FeedId','PlaceholderTypes','Status','MatchingFunction');
	//$selector->predicates[] = new Predicate('FeedId', 'IN', $FeedIds);
	//$selector->predicates[] = new Predicate('Status', 'IN', array('ENABLED'));
	//$selector->predicates[] = new Predicate('PlaceholderTypes', 'EQUALS', '1');
	do {
	// Make the get request.
		$page = $AdGroupFeedService->get($selector);
		// Display results.
		if (isset($page->entries)) {
		  return $page->entries;
		} else {
		   return false;
		}
		// Advance the paging index.
		$selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
	} while ($page->totalNumEntries > $selector->paging->startIndex);
	
 
 }
 
 function getFeedMappingService(AdWordsUser $user){
	$CampaignFeedService = $user->GetService('FeedMappingService', ADWORDS_VERSION);
	$selector = new Selector();
	$selector->fields = array('FeedId', 'AttributeFieldMappings','CriterionType','FeedMappingId','PlaceholderType','Status');
	//$selector->predicates[] = new Predicate('FeedId', 'IN', $feedIds);
	do {
	// Make the get request.
		$page = $CampaignFeedService->get($selector);
		// Display results.
		if (isset($page->entries)) {
		  return $page->entries;
		} else {
		   return false;
		}
		// Advance the paging index.
		$selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
	} while ($page->totalNumEntries > $selector->paging->startIndex);
	
 
 }
 function getFeedItemService(AdWordsUser $user){
	$CampaignFeedService = $user->GetService('FeedItemService', ADWORDS_VERSION);
	$selector = new Selector();
	$selector->fields = array('FeedId', 'FeedItemId','AttributeValues','Status','TargetingCampaignId','TargetingAdGroupId','DevicePreference','KeywordMatchType','KeywordText');
	//$selector->predicates[] = new Predicate('FeedId', 'IN', $feedIds);
	 
	do {
	// Make the get request.
		$page = $CampaignFeedService->get($selector);
		// Display results.
		if (isset($page->entries)) {
		  return $page->entries;
		} else {
		   return false;
		}
		// Advance the paging index.
		$selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
	} while ($page->totalNumEntries > $selector->paging->startIndex);
	
 
 }
 function getReports(AdWordsUser $user , $reportArray ){
	
	//$user->SetClientCustomerId($reportArray['ClientCustomerId']);
	
	// Load the service, so that the required classes are available.
	$user->LoadService('ReportDefinitionService', ADWORDS_VERSION);
	 // Create selector.
	$selector = new Selector();
	
	$selector->fields = $reportArray['fields'];
	
	$dateRange = new DateRange();
	$dateRange->min = $reportArray['startDate'];
	$dateRange->max = $reportArray['endDate'];
	$selector->dateRange = $dateRange;
	// Create report definition.
	$reportDefinition = new ReportDefinition();
	
	$reportDefinition->selector = $selector;
	
	$reportDefinition->dateRangeType  = 'CUSTOM_DATE';
	
	$reportDefinition->reportType = $reportArray['reportType'];
	
	$reportDefinition->reportName = $reportArray['reportType'].' #' . uniqid();
	
	$reportDefinition->downloadFormat = $reportArray['fileType'];
	// Exclude criteria that haven't recieved any impressions over the date range.
	//$reportDefinition->includeZeroImpressions = FALSE;
	// Set additional options.
	$options = array('version' => ADWORDS_VERSION);
	$options['includeZeroImpressions'] = false;
	// Download report.
	$reportUtils = new ReportUtils();
    $reportUtils->DownloadReport($reportDefinition, $reportArray['filePath'], $user, $options);
	//ReportUtils::DownloadReport($reportDefinition, $reportArray['filePath'], $user, $options);
	
	return $reportArray['filePath'] ;
 }
 
// Don't run the example if the file is being included.
function xml2array ( $xmlObject, $out = array () )
{
	foreach ( (array) $xmlObject as $index => $node )
		$out[$index] = ( is_object ( $node ) ) ? $this -> xml2array ( $node ) : $node;

	return $out;
}

function getFeedService(AdWordsUser $user){
	$FeedService = $user->GetService('FeedService', ADWORDS_VERSION);
	$selector = new Selector();
	$selector->fields = array('Attributes', 'FeedStatus','Id','Name','Origin','SystemFeedGenerationData');

	do {
	// Make the get request.
		$page = $FeedService->get($selector);
		// Display results.
		if (isset($page->entries)) {
		  return $page->entries;
		} else {
		   return false;
		}
		// Advance the paging index.
		$selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
	} while ($page->totalNumEntries > $selector->paging->startIndex);
	
 
 }
 
 function getChangeHistory(AdWordsUser $user,$start_date,$end_date){
	 

	//$campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
	$customerSyncService = $user->GetService('CustomerSyncService', ADWORDS_VERSION);

/* 	// Get an array of all campaign ids.
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
  
   */

  // Set the date time range, from 24 hours ago until now.
  $dateTimeRange = new DateTimeRange();
  $dateTimeRange->min = $start_date ;
  $dateTimeRange->max = $end_date ;

  // Create selector.
  $selector = new CustomerSyncSelector();
  $selector->dateTimeRange = $dateTimeRange;
 // $selector->campaignIds = $campaignIds;

  
  // Make the get request.
  $accountChanges = $customerSyncService->get($selector);
  
  return $accountChanges ;

	
 }
 
	/**
 * Converts an array of values to a comma-separated string.
 * @param array $array an array of values that can be converted to a string
 * @return string a comma-separated string of the values
 */
function ArrayToString($array) {
  if (!isset($array)) {
    return '';
  } else {
    return implode(', ', $array);
  }
}


function getBudgetOrderService(AdWordsUser $user) {
  // Get the service, which loads the required classes.
  $budgetOrderService = $user->GetService('BudgetOrderService', ADWORDS_VERSION);

  // Create selector.
  $selector = new Selector();
  $selector->fields = array('BillingAccountId', 'BillingAccountName','BudgetOrderName','EndDateTime','Id','LastRequest', 'PoNumber','PrimaryBillingId','SecondaryBillingId','SpendingLimit','StartDateTime','TotalAdjustments');
  $selector->ordering[] = new OrderBy('EndDateTime', 'DESCENDING');

  // Create paging controls.
 // $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);

  do{
    // Make the get request.
		$page = $budgetOrderService->get($selector);
		
		//$billinginfo = $budgetOrderService->getBillingAccounts();

		// Display results.
		if (isset($page->entries)) {
		  return $page->entries ;
		} else {
		  return false ;
		} 
		$selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
	}
	while ($page->totalNumEntries > $selector->paging->startIndex);
}
 
}


?>