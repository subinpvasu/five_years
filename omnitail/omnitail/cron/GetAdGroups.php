<?php
ini_set ( 'max_execution_time', 1200 );
error_reporting ( E_ALL );
require_once ('../../config/config.php');
$customer = $_REQUEST ['customer'];
// Include the initialization file
require_once dirname ( dirname ( __FILE__ ) ) . '/init.php';
// Enter parameters required by the code example.
/**
 * Runs the example.
 * 
 * @param AdWordsUser $user
 *        	the user to run the example with
 * @param string $campaignId
 *        	the id of the parent campaign
 */
function GetAdGroupsExample(AdWordsUser $user, $campaignId, $type) {
	global $conn;
	$k = 0;
	
	
	$adGroupService = $user->GetService ( 'AdGroupService', ADWORDS_VERSION );
	// Create selector.
	$selector = new Selector ();
	$selector->fields = array (
			'Id',
			'Name',
			'CampaignId',
			'CampaignName',
			'CpcBid' 
	);
	$selector->ordering [] = new OrderBy ( 'Name', 'ASCENDING' );
	// Create predicates.
	$selector->predicates [] = new Predicate ( 'CampaignId', 'IN', $campaignId );
	// Create paging controls.
	$selector->paging = new Paging ( 0, AdWordsConstants::RECOMMENDED_PAGE_SIZE );
	do {
		// Make the get request.
		$page = $adGroupService->get ( $selector );
		// Display results.
		if (isset ( $page->entries )) {
		    echo count($page->entries)."<br/>";
			foreach ( $page->entries as $adGroup ) {
				$k++;
				$bid = 0;
				$crname = '';
				if ($type == 0) {
					$bid = $adGroup->biddingStrategyConfiguration->bids [0]->bid->microAmount;
				}
				else{
					$adGroupCriterionService =
					$user->GetService('AdGroupCriterionService', ADWORDS_VERSION);
					// Create selector.
					$selectors = new Selector();
					$selectors->fields = array('Id', 'CriteriaType','PartitionType','CpcBid','CaseValue');
					$selectors->ordering[] = new OrderBy('KeywordText', 'ASCENDING');
					// Create predicates.
					$selectors->predicates[] = new Predicate('AdGroupId', 'IN',$adGroup->id);
					$selectors->predicates[] =  new Predicate('CriteriaType', 'IN', array('PRODUCT_PARTITION'));//partitionType
					// $selector->predicates[] =  new Predicate('PartitionType', 'IN', array('UNIT'));//partitionType
					// Create paging controls.
					$selectors->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
					$resp = array();
					do{
						// Make the get request.
						$pages = $adGroupCriterionService->get($selectors);
						// Display results.
						if (isset($pages->entries)) {
							foreach ($pages->entries as $adGroupCriterion) {
								if(isset($adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount) && is_numeric($adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount) )
								{
									$bid = $adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount;
									$crname = mysqli_real_escape_string($conn,$adGroupCriterion->criterion->caseValue->value);
								}
							}
						}
						// Advance the paging index.
						$selectors->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
					} while ($pages->totalNumEntries > $selectors->paging->startIndex);
				}
				
				/* $mysql  = "INSERT INTO adgroup_data(customerid, campaignid, adgroupid,campaign_name,adgroup_name,bid,crname,added) VALUES
      			('" . $_SESSION ['customer'] . "','" . $adGroup->campaignId . "','" . $adGroup->id . "','" . mysqli_real_escape_string($conn,$adGroup->campaignName) . "','" . mysqli_real_escape_string($conn,$adGroup->name) . "','" . $bid . "','" . mysqli_real_escape_string($conn,$crname) . "',NOW())";
				$conn->query ( $mysql ); */
			}
		}
		// Advance the paging index.
		$selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
	} while ( $page->totalNumEntries > $selector->paging->startIndex );
	echo $k;
}
try {
	// $conn->query('TRUNCATE TABLE adgroup_data');
	$sql = "SELECT campaignid,type FROM campaign_data WHERE customerid=$customer ORDER BY campaignid ASC";
	$result = $conn->query ( $sql );
	$campaign = array ();
	$campaign_shop = array ();
	while ( $row = $result->fetch_object () ) {
		if ($row->type == 'SHOPPING') {
			$campaign_shop [] = $row->campaignid;
		} else {
			$campaign [] = $row->campaignid;
		}
	}
	$user = new AdWordsUser ( NULL, $developerToken, NULL, $userAgent, NULL, NULL, $oauth2Info );
	$user->SetClientCustomerId ( $customer );
	$_SESSION ['customer'] = $customer;
	
	if (count ( $campaign ) > 0) {
		GetAdGroupsExample ( $user, $campaign, 0 );
	}
	if (count ( $campaign_shop ) > 0) {
		GetAdGroupsExample ( $user, $campaign_shop, 1 );
	}
} catch ( Exception $e ) {
	printf ( "An error has occurred: %s\n", $e->getMessage () );
}
