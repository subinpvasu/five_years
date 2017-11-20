<?php
require_once ('../../config/config.php');
require_once dirname(dirname(__FILE__)) . '/init.php';
$zb = 0;

  function getCampaigns(AdWordsUser $user)
  {
  global $zb;
  $campaignService = $user->GetService ( 'CampaignService', ADWORDS_VERSION );
  $customerSyncService = $user->GetService ( 'CustomerSyncService', ADWORDS_VERSION );
  // Get an array of all campaign ids.
  $campaignIds = array ();
  $selector = new Selector ();
  $selector->fields = array (
  'Id'
  );
  $selector->paging = new Paging ( 0, AdWordsConstants::RECOMMENDED_PAGE_SIZE );
  do {
  $i=0;
  $page = $campaignService->get ( $selector );
  if (isset ( $page->entries )) {
  foreach ( $page->entries as $campaign ) {
 
  $campaignIds [] = $campaign->id;
 
 
 
  }
  }
  $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
  } while ( $page->totalNumEntries > $selector->paging->startIndex );
 
 
  $len = count($campaignIds);
  $part = 100;
  $seg = 100;
  $count = ceil($len/100);
  for($i=0;$i<$count;$i++)
  {$zb++;
  GetAccountChangesExample ( $user ,array_slice($campaignIds, $i*$part, $seg));
  //print_r(array_slice($campaignIds, $i$part, $seg)).'<br/>';
  }
 
  }

function GetAccountChangesExample(AdWordsUser $user,$campaignIds)
{ // ,$campaignIds,$campaignID
    global $conn;
    // Get the service, which loads the required classes.
    $customerSyncService = $user->GetService('CustomerSyncService', ADWORDS_VERSION);
    $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
    // Get an array of all campaign ids.
    /* $campaignIds = array();
    $selector = new Selector();
    $selector->fields = array(
        'Id'
    );
    $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
    do {
        $i = 0;
        $page = $campaignService->get($selector);
        if (isset($page->entries)) {
            foreach ($page->entries as $campaign) {
                $campaignIds[] = $campaign->id;
            }
        }
        $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($page->totalNumEntries > $selector->paging->startIndex); */
    if (count($campaignIds) <= 0) {
        return;
    }
    // echo 'Z'.count($campaignIds);
    // Set the date time range, from 24 hours ago until now.
    date_default_timezone_set("PST8PDT");
    $dateTimeRange = new DateTimeRange();
    $mintime = '';
    $sql = "SELECT lasttime FROM timetable WHERE customerid=" . $_SESSION['account_number'];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_object()) {
            $mintime = $row->lasttime;
        }
    }
    if (strlen($mintime) < 15) {
        $mintime = date('Ymd his', strtotime('-15 day'));
    }
    // $mintime = date ( 'Ymd his', strtotime ( '-15 day' ) );
    $dateTimeRange->min = $mintime;
    $dateTimeRange->max = date('Ymd his');
    // Create selector.
    $selector = new CustomerSyncSelector();
    $selector->dateTimeRange = $dateTimeRange;
    $selector->campaignIds = $campaignIds;
    //$selector->campaignIds = $campaignID;
    // $selector->fields = array('changedAdGroups','changedAds');
    // Make the get request.
    $accountChanges = $customerSyncService->get($selector);
    $m = 0;
    // Display results.
    if (isset($accountChanges)) {
        // printf ( "Most recent change: %s\n", $accountChanges->lastChangeTimestamp );
        if (isset($accountChanges->changedCampaigns)) {
            foreach ($accountChanges->changedCampaigns as $campaignChangeData) {
                // echo '<pre>';
                // print_r($campaignChangeData);
                // echo '</pre>';
                $m ++;
                $sql = "SELECT * FROM campaign_data WHERE campaignid=$campaignChangeData->campaignId AND customerid=" . $_SESSION['account_number'];
                $result = $conn->query($sql);
                // echo $sql.'A</br>';
                if ($result->num_rows > 0) {
                    if ($campaignChangeData->campaignChangeStatus == 'FIELDS_CHANGED') {
                        // Get the service, which loads the required classes.
                        $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
                        // Create selector.
                        $selector = new Selector();
                        $selector->fields = array(
                            'Id',
                            'Name',
                            'AdvertisingChannelType'
                        );
                        $selector->ordering[] = new OrderBy('Name', 'ASCENDING');
                        $selector->predicates[] = new Predicate('CampaignId', 'EQUALS', $campaignChangeData->campaignId);
                        // Create paging controls.
                        $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
                        do {
                            // Make the get request.
                            $page = $campaignService->get($selector);
                            // Display results.
                            if (isset($page->entries)) {
                                foreach ($page->entries as $campaign) {
                                    $sql = "UPDATE campaign_data SET campaign_name='" . mysqli_real_escape_string($conn, $campaign->name) . "',type='" . $campaign->advertisingChannelType . "' WHERE campaignid=$campaignChangeData->campaignId ";
                                    $conn->query($sql);
                                    // echo $sql.'1</br>';
                                }
                            }
                            // Advance the paging index.
                            $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
                        } while ($page->totalNumEntries > $selector->paging->startIndex);
                    }
                   
                
                        
                        
                        
                } else {
                    // Get the service, which loads the required classes.
                    $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
                    // Create selector.
                    $selector = new Selector();
                    $selector->fields = array(
                        'Id',
                        'Name',
                        'AdvertisingChannelType'
                    );
                    $selector->ordering[] = new OrderBy('Name', 'ASCENDING');
                    $selector->predicates[] = new Predicate('CampaignId', 'EQUALS', $campaignChangeData->campaignId);
                    // Create paging controls.
                    $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
                    $campType = '';
                    do {
                        // Make the get request.
                        $page = $campaignService->get($selector);
                        // Display results.
                        if (isset($page->entries)) {
                            foreach ($page->entries as $campaign) {
                                $sql = "INSERT INTO campaign_data(customerid, campaignid, campaign_name,type, added) VALUES ('" . $_SESSION['account_number'] . "','" . $campaignChangeData->campaignId . "','" . mysqli_real_escape_string($conn, $campaign->name) . "','" . $campaign->advertisingChannelType . "',NOW())";
                                $campType = $campaign->advertisingChannelType;
                                $conn->query($sql);
                                // echo $sql.'2</br>';
                            }
                        }
                        // Advance the paging index.
                        $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
                    } while ($page->totalNumEntries > $selector->paging->startIndex);
                    // adgroup details
                    $adGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);
                    $selector = new Selector();
                    $selector->fields = array(
                        'Id',
                        'Name',
                        'CampaignId',
                        'CampaignName',
                        'CpcBid'
                    );
                    $selector->ordering[] = new OrderBy('Name', 'ASCENDING');
                    // Create predicates.
                    $selector->predicates[] = new Predicate('CampaignId', 'EQUALS', $campaignChangeData->campaignId);
                    // Create paging controls.
                    $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
                    do {
                        // Make the get request.
                        $page = $adGroupService->get($selector);
                        // Display results.
                        if (isset($page->entries)) {
                            // print_r($page->entries);
                            foreach ($page->entries as $adGroup) {
                                if ($campType == 'SHOPPING') {
                                    $adGroupCriterionService = $user->GetService('AdGroupCriterionService', ADWORDS_VERSION);
                                    // Create selector.
                                    $selectors = new Selector();
                                    $selectors->fields = array(
                                        'Id',
                                        'CriteriaType',
                                        'PartitionType',
                                        'CpcBid',
                                        'CaseValue'
                                    );
                                    $selectors->ordering[] = new OrderBy('KeywordText', 'ASCENDING');
                                    // Create predicates.
                                    $selectors->predicates[] = new Predicate('AdGroupId', 'IN', $adGroup->id);
                                    $selectors->predicates[] = new Predicate('CriteriaType', 'IN', array(
                                        'PRODUCT_PARTITION'
                                    )); // partitionType
                                        // $selector->predicates[] = new Predicate('PartitionType', 'IN', array('UNIT'));//partitionType
                                        // Create paging controls.
                                    $selectors->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
                                    $resp = array();
                                    do {
                                        // Make the get request.
                                        $pages = $adGroupCriterionService->get($selectors);
                                        // Display results.
                                        if (isset($pages->entries)) {
                                            foreach ($pages->entries as $adGroupCriterion) {
                                                if (isset($adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount) && is_numeric($adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount)) {
                                                    $bid = $adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount;
                                                    $crname = mysqli_real_escape_string($conn, $adGroupCriterion->criterion->caseValue->value);
                                                }
                                            }
                                        }
                                        // Advance the paging index.
                                        $selectors->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
                                    } while ($pages->totalNumEntries > $selectors->paging->startIndex);
                                } else {
                                    $bid = $adGroup->biddingStrategyConfiguration->bids[0]->bid->microAmount;
                                    $crname = '';
                                }
                                // $sql = "UPDATE adgroup_data SET campaign_name='".$adGroup->campaignName."',adgroup_name='".$adGroup->name."',bid='".$bid."' ";
                                $sql = "INSERT INTO adgroup_data(customerid, campaignid, adgroupid,campaign_name,adgroup_name,bid,crname,added) VALUES
												 ('" . $_SESSION['account_number'] . "','" . $adGroup->campaignId . "','" . $adGroup->id . "','" . mysqli_real_escape_string($conn, $adGroup->campaignName) . "','" . mysqli_real_escape_string($conn, $adGroup->name) . "','" . $bid . "','" . $crname . "',NOW())";
                                $conn->query($sql);
                                // echo $sql.'3</br>';
                            }
                        }
                        // Advance the paging index.
                        $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
                    } while ($page->totalNumEntries > $selector->paging->startIndex);
                }
                if (isset($campaignChangeData->changedAdGroups)) {
                    $adid = $campaignChangeData->changedAdGroups[0]->adGroupId;
                    $sql = "SELECT * FROM adgroup_data WHERE campaignid=$campaignChangeData->campaignId AND customerid=" . $_SESSION['account_number'] . " AND adgroupid=$adid ";
                    $result = $conn->query($sql);
                    // echo $sql.'B</br>';
                    
                    
                    
                    if ($result->num_rows > 0) {
                        foreach($campaignChangeData->changedAdGroups as
                            $adGroupChangeData) {
                        if ($adGroupChangeData->adGroupChangeStatus == 'FIELDS_CHANGED') {
                            $adGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);
                            $selector = new Selector();
                            $selector->fields = array(
                                'Id',
                                'Name',
                                'CampaignId',
                                'CampaignName',
                                'CpcBid'
                            );
                            $selector->ordering[] = new OrderBy('Name', 'ASCENDING');
                            // Create predicates.
                            $selector->predicates[] = new Predicate('Id', 'EQUALS', $adGroupChangeData->adGroupId);
                            // Create paging controls.
                            $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
                            do {
                                // Make the get request.
                                $page = $adGroupService->get($selector);
                                // Display results.
                                if (isset($page->entries)) {
                                    // print_r($page->entries);
                                    foreach ($page->entries as $adGroup) {
                                        if ($campaignChangeData->advertisingChannelType == 'SHOPPING') {
                                            $adGroupCriterionService = $user->GetService('AdGroupCriterionService', ADWORDS_VERSION);
                                            // Create selector.
                                            $selectors = new Selector();
                                            $selectors->fields = array(
                                                'Id',
                                                'CriteriaType',
                                                'PartitionType',
                                                'CpcBid',
                                                'CaseValue'
                                            );
                                            $selectors->ordering[] = new OrderBy('KeywordText', 'ASCENDING');
                                            // Create predicates.
                                            $selectors->predicates[] = new Predicate('AdGroupId', 'IN', $adGroup->id);
                                            $selectors->predicates[] = new Predicate('CriteriaType', 'IN', array(
                                                'PRODUCT_PARTITION'
                                            )); // partitionType
                                                // $selector->predicates[] = new Predicate('PartitionType', 'IN', array('UNIT'));//partitionType
                                                // Create paging controls.
                                            $selectors->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
                                            $resp = array();
                                            do {
                                                // Make the get request.
                                                $pages = $adGroupCriterionService->get($selectors);
                                                // Display results.
                                                if (isset($pages->entries)) {
                                                    foreach ($pages->entries as $adGroupCriterion) {
                                                        if (isset($adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount) && is_numeric($adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount)) {
                                                            $bid = $adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount;
                                                            $crname = mysqli_real_escape_string($conn, $adGroupCriterion->criterion->caseValue->value);
                                                        }
                                                    }
                                                }
                                                // Advance the paging index.
                                                $selectors->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
                                            } while ($pages->totalNumEntries > $selectors->paging->startIndex);
                                        } else {
                                            $bid = $adGroup->biddingStrategyConfiguration->bids[0]->bid->microAmount;
                                            $crname = '';
                                        }
                                        $sql = "UPDATE adgroup_data SET campaign_name='" . mysqli_real_escape_string($conn, $adGroup->campaignName) . "',adgroup_name='" . mysqli_real_escape_string($conn, $adGroup->name) . "',bid='" . $bid . "',crname='" . $crname . "' WHERE campaignid=$campaignChangeData->campaignId AND customerid=" . $_SESSION['account_number'] . " AND adgroupid=$adGroupChangeData->adGroupId ";
                                        $conn->query($sql);
                                        // echo $sql.'4</br>';
                                    }
                                }
                                // Advance the paging index.
                                $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
                            } while ($page->totalNumEntries > $selector->paging->startIndex);
                        }
                        else
                        {
                      //check campaign
                      $campType = '';
                            $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
                            // Create selector.
                            $selector = new Selector();
                            $selector->fields = array(
                                'Id',
                                
                                'AdvertisingChannelType'
                            );
                            $selector->ordering[] = new OrderBy('Name', 'ASCENDING');
                            $selector->predicates[] = new Predicate('CampaignId', 'EQUALS', $campaignChangeData->campaignId);
                            // Create paging controls.
                            $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
                            do {
                                // Make the get request.
                                $page = $campaignService->get($selector);
                                // Display results.
                                if (isset($page->entries)) {
                                    foreach ($page->entries as $campaign) {
                                        $campType = $campaign->advertisingChannelType;
                                    }
                                }
                                // Advance the paging index.
                                $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
                            } while ($page->totalNumEntries > $selector->paging->startIndex);
                            
                      //check end
                            
                            foreach($campaignChangeData->changedAdGroups as
                                $adGroupChangeData) {
                                    if($campType=='SHOPPING'){
                                    if(strlen(ArrayToString($adGroupChangeData->changedCriteria))>1)
                                    {
                                        /*****************************************************************************/
                                        //update bid
                                        //$adGroupChangeData->adGroupId
                                        $bid=0;
                                        $crname = '';
                                       
                                        
                                        $adGroupCriterionService = $user->GetService('AdGroupCriterionService', ADWORDS_VERSION);
                                        // Create selector.
                                        $selectors = new Selector();
                                        $selectors->fields = array(
                                            'Id',
                                            'CriteriaType',
                                            'PartitionType',
                                            'CpcBid',
                                            'CaseValue'
                                        );
                                        $selectors->ordering[] = new OrderBy('KeywordText', 'ASCENDING');
                                        // Create predicates.
                                        $selectors->predicates[] = new Predicate('AdGroupId', 'IN', $adGroupChangeData->adGroupId);
                                        $selectors->predicates[] = new Predicate('CriteriaType', 'IN', array(
                                            'PRODUCT_PARTITION'
                                        )); // partitionType
                                        // $selector->predicates[] = new Predicate('PartitionType', 'IN', array('UNIT'));//partitionType
                                        // Create paging controls.
                                        $selectors->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
                                        $resp = array();
                                        do {
                                            // Make the get request.
                                            $pages = $adGroupCriterionService->get($selectors);
                                            // Display results.
                                            if (isset($pages->entries)) {
                                                foreach ($pages->entries as $adGroupCriterion) {
                                                    if (isset($adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount) && is_numeric($adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount)) {
                                                        $bid = $adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount;
                                                        $crname = mysqli_real_escape_string($conn, $adGroupCriterion->criterion->caseValue->value);
                                                    }
                                                }
                                            }
                                            // Advance the paging index.
                                            $selectors->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
                                        } while ($pages->totalNumEntries > $selectors->paging->startIndex);
                                        
                                        $sql = "UPDATE adgroup_data SET bid='" . $bid . "',crname='" . $crname . "',updated=NOW() WHERE campaignid=$campaignChangeData->campaignId AND customerid=" . $_SESSION['account_number'] . " AND adgroupid=$adGroupChangeData->adGroupId ";
                                        
                                        $conn->query($sql);
                                       
                                        /*****************************************************************************/
                                    }
                                }
                                }
                        
                        }
                    }
                        
                       
                        
                        
                    } else {
                        
                        $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
                        // Create selector.
                        $selector = new Selector();
                        $selector->fields = array(
                            'Id',
                        
                            'AdvertisingChannelType'
                        );
                        $selector->ordering[] = new OrderBy('Name', 'ASCENDING');
                        $selector->predicates[] = new Predicate('CampaignId', 'EQUALS', $campaignChangeData->campaignId);
                        // Create paging controls.
                        $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
                        do {
                            // Make the get request.
                            $page = $campaignService->get($selector);
                            // Display results.
                            if (isset($page->entries)) {
                                foreach ($page->entries as $campaign) {
                                    $campType = $campaign->advertisingChannelType;
                                }
                            }
                            // Advance the paging index.
                            $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
                        } while ($page->totalNumEntries > $selector->paging->startIndex);
                        
                        
                        
                        $adGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);
                        $selector = new Selector();
                        $selector->fields = array(
                            'Id',
                            'Name',
                            'CampaignId',
                            'CampaignName',
                            'CpcBid'
                        );
                        $selector->ordering[] = new OrderBy('Name', 'ASCENDING');
                        // Create predicates.
                        $selector->predicates[] = new Predicate('CampaignId', 'EQUALS', $campaignChangeData->campaignId);
                        // Create paging controls.
                        $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
                        do {
                            // Make the get request.
                            $page = $adGroupService->get($selector);
                            // Display results.
                            if (isset($page->entries)) {
                                // print_r($page->entries);
                                foreach ($page->entries as $adGroup) {
                                    if ($campType == 'SHOPPING') {
                                        $adGroupCriterionService = $user->GetService('AdGroupCriterionService', ADWORDS_VERSION);
                                        // Create selector.
                                        $selectors = new Selector();
                                        $selectors->fields = array(
                                            'Id',
                                            'CriteriaType',
                                            'PartitionType',
                                            'CpcBid',
                                            'CaseValue'
                                        );
                                        $selectors->ordering[] = new OrderBy('KeywordText', 'ASCENDING');
                                        // Create predicates.
                                        $selectors->predicates[] = new Predicate('AdGroupId', 'IN', $adGroup->id);
                                        $selectors->predicates[] = new Predicate('CriteriaType', 'IN', array(
                                            'PRODUCT_PARTITION'
                                        )); // partitionType
                                            // $selector->predicates[] = new Predicate('PartitionType', 'IN', array('UNIT'));//partitionType
                                            // Create paging controls.
                                        $selectors->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
                                        $resp = array();
                                        do {
                                            // Make the get request.
                                            $pages = $adGroupCriterionService->get($selectors);
                                            // Display results.
                                            if (isset($pages->entries)) {
                                                foreach ($pages->entries as $adGroupCriterion) {
                                                    if (isset($adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount) && is_numeric($adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount)) {
                                                        $bid = $adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount;
                                                        $crname = mysqli_real_escape_string($conn, $adGroupCriterion->criterion->caseValue->value);
                                                    }
                                                }
                                            }
                                            // Advance the paging index.
                                            $selectors->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
                                        } while ($pages->totalNumEntries > $selectors->paging->startIndex);
                                    } else {
                                        $bid = $adGroup->biddingStrategyConfiguration->bids[0]->bid->microAmount;
                                        $crname = '';
                                    }
                                    // $sql = "UPDATE adgroup_data SET campaign_name='".$adGroup->campaignName."',adgroup_name='".$adGroup->name."',bid='".$bid."' ";
                                    $sql = "INSERT INTO adgroup_data(customerid, campaignid, adgroupid,campaign_name,adgroup_name,bid,crname,added) VALUES
            						 ('" . $_SESSION['account_number'] . "','" . $adGroup->campaignId . "','" . $adGroup->id . "','" . mysqli_real_escape_string($conn, $adGroup->campaignName) . "','" . mysqli_real_escape_string($conn, $adGroup->name) . "','" . $bid . "','" . $crname . "',NOW())";
                                    // echo $sql.'</br>';
                                    $conn->query($sql);
                                    // echo $sql.'5</br>';
                                }
                            }
                            // Advance the paging index.
                            $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
                        } while ($page->totalNumEntries > $selector->paging->startIndex);
                    }
                }
            }
        }
        // echo "---".$m;
        $sql = "UPDATE timetable SET lasttime='" . substr($accountChanges->lastChangeTimestamp, 0, 15) . "', updated=NOW() WHERE customerid=" . $_SESSION['account_number'];
        $conn->query($sql);
        // echo $sql.'6<br/>';
    } 

    else {
        print "No changes were found.\n";
    }
}

/**
 * Converts an array of values to a comma-separated string.
 *
 * @param array $array
 *            an array of values that can be converted to a string
 * @return string a comma-separated string of the values
 */
function ArrayToString($array)
{
    if (! isset($array)) {
        return '';
    } else {
        return implode(', ', $array);
    }
}

function GetAccounts(AdWordsUser $user)
{
    $managedCustomerService = $user->GetService('ManagedCustomerService', ADWORDS_VERSION);
    $selector = new Selector();
    // Specify the fields to retrieve.
    $selector->fields = array(
        'CustomerId',
        'CompanyName',
        'Name',
        'CurrencyCode'
    );
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
        return $accounts;
    } else {
        return false;
    }
}
try {
   // echo 'here';exit();
    // $conn->query('DELETE FROM `account_details` WHERE `mccid`=9197135874');
    
    $mysql = "SELECT * FROM prospect_credentials WHERE account_status=1 AND manage=1";
    $rezult = $conn->query($mysql);
    $m = 0;
    if ($rezult->num_rows > 0) {
        while ($row = $rezult->fetch_object()) {
            
            $m ++;
            $oauth2Info = array(
                "client_id" => $clientId,
                "client_secret" => $clientSecret,
                "refresh_token" => $row->refresh_token
            );
            $mccid = $row->account_number;
            $user = new AdWordsUser(NULL, $developerToken, $userAgent, $row->account_number, NULL, $oauth2Info);
            $accounts = GetAccounts($user);
            $conn->query("DELETE FROM account_details WHERE mccid='$mccid'");
            if (count($accounts) > 0) {
                foreach ($accounts as $a) {
                    
                    $name = mysqli_real_escape_string($conn, $a->name);
                    $company = mysqli_real_escape_string($conn, $a->companyName); // currencyCode
                    $sql = "INSERT INTO account_details( name,account_number,company_name,currency_code, added,mccid,prospect) VALUES ('$name','$a->customerId','$company','$a->currencyCode',NOW(),'$mccid'," . $row->prospect . ")";
                    $conn->query($sql);
                }
            }
        }
    }
    
    $skl = "SELECT customerid FROM timetable ";
    $result = $conn->query($skl);
    $customer = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_object()) {
            $customer[] = $row->customerid;
        }
    }
    $sql = "SELECT account_number FROM account_details ORDER BY  id ASC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_object()) {
            if (array_search($row->account_number, $customer) === false) {
                $sql = "INSERT INTO timetable(customerid)values(" . $row->account_number . ")";
                $conn->query($sql);
            }
        }
    }
    
    $sqla = "SELECT *,a.account_number AS account FROM prospect_credentials p INNER JOIN account_details a ON p.account_number=a.mccid WHERE p.manage=1 AND account_status=1 ";//12268117756539291121  AND a.account_number=1226811775 
    $resulta = $conn->query($sqla);
    $account = array();
    
    if ($resulta->num_rows > 0) {
        while ($row = $resulta->fetch_object()) {
            
            $userAgent = 'Omnitail';
            $oauth2Infos = array(
                "client_id" => $clientId,
                "client_secret" => $clientSecret,
                "refresh_token" => $row->refresh_token
            );
            $user = new AdWordsUser(NULL, $developerToken, $userAgent, NULL, NULL, $oauth2Infos); // clientCustomerId = "6743897063"9197135874
            $user->SetClientCustomerId($row->account);
            $_SESSION['account_number'] = $row->account;
            
            //$user->LogAll();
           getCampaigns($user);
            //GetAccountChangesExample($user);
            // getCamapaigns($user);
            // echo $col->refresh_token."|||".$id['account']."||".$id['mcc']."<br/>";
        }
    }
    
    // Get AdWordsUser from credentials in "../auth.ini"
    // relative to the AdWordsUser.php file's directory.
    
    // print_r($id);return;
    // new oath
    
    // Log every SOAP XML request and response.
    // echo $zb;
    // Run the example.
} catch (Exception $e) {
    printf("An error has occurred: %s\n", $e->getMessage());
}
