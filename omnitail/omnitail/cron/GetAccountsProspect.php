<?php


// Include the initialization file
require_once dirname(dirname(__FILE__)) . '/init.php';



/**
 * This example gets all targeting criteria for a campaign. To add targeting
* criteria, run AddCampaignTargetingCriteria.php.
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

// Enter parameters required by the code example.
$campaignId = '223536914';
//360724964
/**
 * Runs the example.
 * @param AdWordsUser $user the user to run the example with
 * @param string $campaignId the ID of the campaign to get targeting criteria
 *     for
 */
function GetCampaignTargetingCriteriaExample(AdWordsUser $user, $campaignId) {
    // Get the service, which loads the required classes.
    $campaignCriterionService =
    $user->GetService('CampaignCriterionService', ADWORDS_VERSION);

    // Create selector.
    $selector = new Selector();
    $selector->fields = array('Id', 'CriteriaType');

    // Create predicates.
    $selector->predicates[] =
    new Predicate('CampaignId', 'IN', array($campaignId));
    $selector->predicates[] = new Predicate('CriteriaType', 'IN',
        array('LANGUAGE', 'LOCATION', 'AGE_RANGE', 'CARRIER',
            'OPERATING_SYSTEM_VERSION', 'GENDER', 'PROXIMITY', 'PLATFORM'));

    // Create paging controls.
    $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);

    do {
        // Make the get request.
        $page = $campaignCriterionService->get($selector);

        // Display results.
        if (isset($page->entries)) {
            foreach ($page->entries as $campaignCriterion) {
                echo "<pre>";
                print_r($campaignCriterion);
                echo "</pre>";
                //        printf("Campaign targeting criterion with ID '%s' and type '%s' was "
                //            . "found.<br>", $campaignCriterion->criterion->id,
                //            $campaignCriterion->criterion->CriterionType);
            }
        } else {
            print "No campaign targeting criteria were found.<br>";
        }

        // Advance the paging index.
        $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($page->totalNumEntries > $selector->paging->startIndex);
}

// Don't run the example if the file is being included.
//if (__FILE__ != realpath($_SERVER['PHP_SELF'])) {
//  return;
//}




try {
  // Get AdWordsUser from credentials in "../auth.ini"
  // relative to the AdWordsUser.php file's directory.
  $refresh_token = "1/EKqbXlgE7Tx94AEIU7vKhjeq_BfaKJ03bvEJnnAbAm0MEudVrK5jSpoR30zcRFq6";
  $developerToken = 'dDdipQC2xWmL2WIIDCDvYw';
   $userAgent = 'vbridge';
   $oauth2Info = array(
           "client_id" => "603826599811-0ugc0p9t59jl30k7k8s7cgj18unuccrv.apps.googleusercontent.com",
           "client_secret" => "gZM21g6iOLqAQ27zBmG4RclZ",
           "refresh_token" => $refresh_token
       );
 $user = new AdWordsUser(NULL,$developerToken,NULL,$userAgent,NULL,NULL,$oauth2Info);
 $user->SetClientCustomerId(6539291121);
 //$user = new AdWordsUser();
  // Log every SOAP XML request and response.6539291121
  $user->LogAll();

  // Run the example.
 
 GetCampaignTargetingCriteriaExample($user, $campaignId);
} catch (Exception $e) {
  printf("An error has occurred: %s\n", $e->getMessage());
}
