<?php
require_once ('../../config/config.php');
//$customer = $_REQUEST['customer'];
/**
 * This example gets all ad groups in a campaign. To add ad groups, run
 * AddAdGroup.php. To get campaigns, run GetCampaigns.php.
 *
 * Copyright 2014, Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package    GoogleApiAdsAdWords
 * @subpackage v201509
 * @category   WebServices
 * @copyright  2014, Google Inc. All Rights Reserved.
 * @license    http://www.apache.org/licenses/LICENSE-2.0 Apache License,
 *             Version 2.0
 */

// Include the initialization file
//require_once dirname(dirname(__FILE__)) . '/init.php';

// Enter parameters required by the code example.
//$campaignId = 'INSERT_CAMPAIGN_ID_HERE';

/**
 * Runs the example.
 * @param AdWordsUser $user the user to run the example with
 * @param string $campaignId the id of the parent campaign
 */
// function GetAdGroupsExample(AdWordsUser $user, $campaignId) {
//   // Get the service, which loads the required classes.
//   $adGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);

//   // Create selector.
//   $selector = new Selector();
//   $selector->fields = array('Id', 'Name');
//   $selector->ordering[] = new OrderBy('Name', 'ASCENDING');

//   // Create predicates.
//   $selector->predicates[] =
//       new Predicate('CampaignId', 'IN', $campaignId);

//   // Create paging controls.
//   $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
// $i=0;
//   do {
//     // Make the get request.
//     $page = $adGroupService->get($selector);

//     // Display results.
//     if (isset($page->entries)) {
//       foreach ($page->entries as $adGroup) {
//        $i++;
//       }
//     } else {
//      // print "No ad groups were found.\n";
//     }

//     // Advance the paging index.
//     $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
//   } while ($page->totalNumEntries > $selector->paging->startIndex);
//   echo $i;
// }

// // Don't run the example if the file is being included.


// try {
// 	$sql = "SELECT campaignid,type FROM campaign_data WHERE customerid=$customer ORDER BY customerid ASC";
// 	$result = $conn->query($sql);
// 	$campaign = array();
// 	while($row = $result->fetch_object()) {
		
// 		$campaign[] = $row->campaignid;
				
// 	}
// 	$user = new AdWordsUser(NULL,$developerToken,NULL,$userAgent,NULL,NULL,$oauth2Info);
// 	$user->SetClientCustomerId($customer );
// 	$_SESSION['customer']=$customer;
// 	$user->LogAll();
	

//   // Run the example.
//   GetAdGroupsExample($user, $campaign);
// } catch (Exception $e) {
//   printf("An error has occurred: %s\n", $e->getMessage());
// }


/**
 * This example gets all available keyword bid simulations within an ad group.
* To get ad groups, run BasicOperation/GetAdGroups.php.
*
* Restriction: adwords-only
*
* Copyright 2014, Google Inc. All Rights Reserved.
*
* Licensed under the Apache License, Version 2.0 (the "License");
* you may not use this file except in compliance with the License.
* You may obtain a copy of the License at
*
*     http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
* See the License for the specific language governing permissions and
* limitations under the License.
*
* @package    GoogleApiAdsAdWords
* @subpackage v201509
* @category   WebServices
* @copyright  2015, Google Inc. All Rights Reserved.
* @license    http://www.apache.org/licenses/LICENSE-2.0 Apache License,
*             Version 2.0
*/

// Include the initialization file
require_once dirname(dirname(__FILE__)) . '/init.php';

// Enter parameters required by the code example.
$adGroupId = '23775468674';
$campaignId = '380456916';

/**
 * Runs the example.
 * @param AdWordsUser $user the user to run the example with
 * @param string $adGroupId the id the ad group containing keyword bid
 *     simulations
 */
function GetKeywordBidSimulationsExample(AdWordsUser $user, $adGroupId) {
    // Get the service, which loads the required classes.
    $dataService = $user->GetService('DataService', ADWORDS_VERSION);

    // Create selector.
    $selector = new Selector();
    $selector->fields = array('AdGroupId', 'CriterionId','CampaignId', 'StartDate', 'EndDate',
        'Bid', 'LocalClicks', 'LocalCost', 'LocalImpressions');

    // Create predicates.
    $selector->predicates[] = new Predicate('AdGroupId', 'IN', array($adGroupId));

    // Create paging controls.
    $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);

    do{
        // Make the getCriterionBidLandscape request.
        $page = $dataService->getCriterionBidLandscape($selector);

        // Display results.
        if (isset($page->entries)) {
            echo '<pre>';
            print_r($page->entries);
            echo '</pre>';
           /*  foreach ($page->entries as $bidLandscape) {
                printf("Found criterion bid landscape for keyword with id '%s', start "
                    . "date '%s', end date '%s', and landscape points:<br>",
                    $bidLandscape->criterionId, $bidLandscape->startDate,
                    $bidLandscape->endDate);
                    foreach ($bidLandscape->landscapePoints as $bidLandscapePoint) {
                        printf("  bid: %.0f => clicks: %d, cost: %.0f, impressions: %d<br>",
                        $bidLandscapePoint->bid->microAmount,
                        $bidLandscapePoint->clicks,
                        $bidLandscapePoint->cost->microAmount,
                        $bidLandscapePoint->impressions);
                    }
                    print "<br>";
            } */
        }

        // Advance the paging index.
        $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while (isset($page->entries) && count($page->entries) > 0);

    if ($selector->paging->startIndex === 0) {
        print "No criterion bid landscapes were found.<br>";
    }

}

function getBid(AdWordsUser $user, $adGroupId)
{
    $adGroupCriterionService = $user->GetService('AdGroupCriterionService', ADWORDS_VERSION);
    // Create selector.
    $selectors = new Selector();
    $selectors->fields = array('Id','CpcBid','CaseValue');
    $selectors->ordering[] = new OrderBy('KeywordText', 'ASCENDING');
    // Create predicates.
    $selectors->predicates[] = new Predicate('AdGroupId', 'EQUALS', $adGroupId);
    $selectors->predicates[] = new Predicate('CriteriaType', 'IN', array(
        'PRODUCT_PARTITION'
    )); // partitionType
    // $selector->predicates[] = new Predicate('PartitionType', 'IN', array('UNIT'));//partitionType
    // Create paging controls.
    $selectors->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
    $resp = 0;
    do {
        // Make the get request.
        $pages = $adGroupCriterionService->get($selectors);
        // Display results.
        if (isset($pages->entries)) {
            /* echo '<pre>';
            print_r($pages->entries);
            echo '</pre>'; */
            foreach ($pages->entries as $adGroupCriterion) {
               /*  if (isset($adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount) && is_numeric($adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount)) {
                    $bid = $adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount;
                    $crname = mysqli_real_escape_string($conn, $adGroupCriterion->criterion->caseValue->value);
                } */
                echo "Id : ".$adGroupCriterion->criterion->id;echo '<br/>';
                echo "Name : ".$adGroupCriterion->criterion->caseValue->value;echo '<br/>';
                echo "Bid : ".$adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount;echo '<br/>';
                
                $resp++;
            }
        }
        // Advance the paging index.
        $selectors->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($pages->totalNumEntries > $selectors->paging->startIndex);
    echo $resp;
}

function GetAccountChangesExample(AdWordsUser $user,$campaignID) {
    // Get the service, which loads the required classes.
    $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
    $customerSyncService = $user->GetService('CustomerSyncService', ADWORDS_VERSION);

    // Get an array of all campaign ids.
    $campaignIds = array();
    /* $selector = new Selector();
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
    } while ($page->totalNumEntries > $selector->paging->startIndex); */
    $campaignIds[] = $campaignID;

    // Set the date time range, from 24 hours ago until now.
    $dateTimeRange = new DateTimeRange();
    $dateTimeRange->min = date('Ymd his', strtotime('-1 day'));
    $dateTimeRange->max = date('Ymd his');

    // Create selector.
    $selector = new CustomerSyncSelector();
    $selector->dateTimeRange = $dateTimeRange;
    $selector->campaignIds = $campaignIds;

    // Make the get request.
    $accountChanges = $customerSyncService->get($selector);

    // Display results.
    if (isset($accountChanges)) {
        printf("Most recent change: %s\n", $accountChanges->lastChangeTimestamp);
        if (isset($accountChanges->changedCampaigns)) {
        echo '<pre>';
        print_r($accountChanges->changedCampaigns);
        //echo $adGroupChangeData->changedCriteria
        
            foreach ($accountChanges->changedCampaigns as $campaignChangeData) {
                printf("Campaign with id '%.0f' has change status '%s'.\n",
                $campaignChangeData->campaignId,
                $campaignChangeData->campaignChangeStatus);
                if ($campaignChangeData->campaignChangeStatus != 'NEW') {
                    printf("\tAdded ad extensions: %s\n",
                    ArrayToString($campaignChangeData->addedAdExtensions));
                    printf("\tRemoved ad extensions: %s\n",
                    ArrayToString($campaignChangeData->removedAdExtensions));
                    printf("\tAdded campaign criteria: %s\n",
                    ArrayToString($campaignChangeData->addedCampaignCriteria));
                    printf("\tRemoved campaign criteria: %s\n",
                    ArrayToString($campaignChangeData->removedCampaignCriteria));
                    if (isset($campaignChangeData->changedAdGroups)) {
                        foreach($campaignChangeData->changedAdGroups as
                            $adGroupChangeData) {
                                printf("\tAd Group with id '%.0f' has change status '%s'.\n",
                                $adGroupChangeData->adGroupId,
                                $adGroupChangeData->adGroupChangeStatus);
                                if ($adGroupChangeData->adGroupChangeStatus != 'NEW') {
                                    printf("\t\tChanged ads: %s\n",
                                    ArrayToString($adGroupChangeData->changedAds));
                                    printf("\t\tChanged criteria: %s\n",
                                    ArrayToString($adGroupChangeData->changedCriteria));
                                    printf("\t\tRemoved criteria: %s\n",
                                    ArrayToString($adGroupChangeData->removedCriteria));
                                }
                            }
                    }
                }
            }
        }
    } else {
        print "No changes were found.\n";
    }
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

// Don't run the example if the file is being included.

// Don't run the example if the file is being included.
//if (__FILE__ != realpath($_SERVER['PHP_SELF'])) {
//  return;
//}

try {
    // Get AdWordsUser from credentials in "../auth.ini"
    // relative to the AdWordsUser.php file's directory.
    $user = new AdWordsUser();

    // Log every SOAP XML request and response.
    $user->LogAll();

    $user->SetClientCustomerId(1728364983);
    // Run the example.
   // GetKeywordBidSimulationsExample($user, $adGroupId);
   //getBid($user, $adGroupId);
  GetAccountChangesExample($user,$campaignId);
} catch (Exception $e) {
    printf("An error has occurred: %s<br>", $e->getMessage());
}
