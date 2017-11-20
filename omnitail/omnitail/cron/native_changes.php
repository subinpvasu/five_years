<?php
/**
 * This example gets the changes in the account during the last 24 hours.
 * Note: this example must be run using the credentials of an ad-serving
 * account.
 *
 * PHP version 5
 *
 * Copyright 2016, Google Inc. All Rights Reserved.
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
 * @subpackage v201605
 * @category   WebServices
 * @copyright  2016, Google Inc. All Rights Reserved.
 * @license    http://www.apache.org/licenses/LICENSE-2.0 Apache License,
 *             Version 2.0
 */

// Include the initialization file
require_once ('../../config/config.php');
require_once dirname(dirname(__FILE__)) . '/init.php';

/**
 * Runs the example.
 * @param AdWordsUser $user the user to run the example with
 */
function GetAccountChangesExample(AdWordsUser $user) {
  // Get the service, which loads the required classes.
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
  $dateTimeRange->min = date('Ymd his', strtotime('-1 day'));
  $dateTimeRange->max = date('Ymd his');

  // Create selector.
  $selector = new CustomerSyncSelector();
  $selector->dateTimeRange = $dateTimeRange;
  $selector->campaignIds = $campaignIds;

  // Make the get request.
  $accountChanges = $customerSyncService->get($selector);

  // Display results.
  if (isset($accountChanges)) {/* 
    printf("Most recent change: %s\n", $accountChanges->lastChangeTimestamp);
    if (isset($accountChanges->changedCampaigns)) {
      foreach ($accountChanges->changedCampaigns as $campaignChangeData) {
        printf("Campaign with id '%.0f' has change status '%s'.\n",
            $campaignChangeData->campaignId,
            $campaignChangeData->campaignChangeStatus);
        if ($campaignChangeData->campaignChangeStatus != 'NEW') {
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
    } */
      echo '<pre>';
      print_r($accountChanges);
      echo '</pre>';
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
// if (__FILE__ != realpath($_SERVER['PHP_SELF'])) {
//   return;
// }

try {
    $sqla = "SELECT *,a.account_number AS account FROM prospect_credentials p INNER JOIN account_details a ON p.account_number=a.mccid WHERE  account_status=1  AND a.account_number=9768094975 ";// AND a.account_number=1226811775  AND a.account_number=1226811775
    // 12268117756539291121 AND a.account_number=1226811775 5493971629  1728364983 AND a.account_number=1728364983
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
    
//             $user->LogAll();
//             getCampaigns($user);
            // GetAccountChangesExample($user);
            // getCamapaigns($user);
            // echo $col->refresh_token."|||".$id['account']."||".$id['mcc']."<br/>";
        }
    }
  // Get AdWordsUser from credentials in "../auth.ini"
  // relative to the AdWordsUser.php file's directory.
 // $user = new AdWordsUser();

  // Log every SOAP XML request and response.
 $user->LogAll();

  // Run the example.
  GetAccountChangesExample($user);
} catch (Exception $e) {
  printf("An error has occurred: %s\n", $e->getMessage());
}
