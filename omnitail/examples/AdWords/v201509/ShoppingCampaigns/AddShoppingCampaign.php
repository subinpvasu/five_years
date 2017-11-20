<?php
/**
 * This example adds a Shopping campaign.
 *
 * @package    GoogleApiAdsAdWords
 * @subpackage v201509
 * @category   WebServices
 * @license    http://www.apache.org/licenses/LICENSE-2.0 Apache License,
 *             Version 2.0
 */

// Include the initialization file
require_once dirname(dirname(__FILE__)) . '/init.php';

//$budgetId = 'INSERT_BUDGET_ID_HERE';
$merchantId = '469547';

//vbridge
//$merchantId = '106846477';
//469547 - client merchant id

/**
 * Runs the example.
 * @param AdWordsUser $user the user to run the example with
 * @param int $budgetId the ID of a shared budget to use for the campaign
 * @param int $merchantId the Merchant Center account ID to use for product data
 */
function addShoppingCampaignExample(AdWordsUser $user, $budgetId, $merchantId) {
  // Get the services, which loads the required classes.
  $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
  $adGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);
  $adGroupAdService = $user->GetService('AdGroupAdService', ADWORDS_VERSION);

  // Create campaign.
  $campaign = new Campaign();
  $campaign->name = 'Test Shopping campaign_1 #' . uniqid();
  // The advertisingChannelType is what makes this a Shopping campaign
  $campaign->advertisingChannelType = 'SHOPPING';
  $campaign->status = 'PAUSED';

  // Set shared budget (required).
  $campaign->budget = new Budget();
  $campaign->budget->budgetId = $budgetId;

  // Set bidding strategy (required).
  $biddingStrategyConfiguration = new BiddingStrategyConfiguration();
  $biddingStrategyConfiguration->biddingStrategyType = 'MANUAL_CPC';

  $campaign->biddingStrategyConfiguration = $biddingStrategyConfiguration;

  // All Shopping campaigns need a ShoppingSetting.
  $shoppingSetting = new ShoppingSetting();
  $shoppingSetting->salesCountry = 'US';
  $shoppingSetting->salesCountry = 'CA';
  $shoppingSetting->campaignPriority = 0;
  $shoppingSetting->merchantId = $merchantId;
  // Set to "true" to enable Local Inventory Ads in your campaign.
  $shoppingSetting->enableLocal = true;
  $campaign->settings[] = $shoppingSetting;

  $operations = array();
  // Create operation.
  $operation = new CampaignOperation();
  $operation->operand = $campaign;
  $operation->operator = 'ADD';
  $operations[] = $operation;

  // Make the mutate request.
  $result = $campaignService->mutate($operations);

  // Display result.
  $campaign = $result->value[0];
  printf("Campaign with name '%s' and ID '%s' was added.<br>", $campaign->name,
        $campaign->id);

  // Create ad group.
  $adGroup = new AdGroup();
  $adGroup->campaignId = $campaign->id;
  $adGroup->name = 'Test Ad Group #' . uniqid();
  $adGroup->status = 'PAUSED';

  unset($operations);
  $operations = array();
  // Create operation.
  $operation = new AdGroupOperation();
  $operation->operand = $adGroup;
  $operation->operator = 'ADD';
  $operations[] = $operation;

  // Make the mutate request.
  $result = $adGroupService->mutate($operations);

  // Display result.
  $adGroup = $result->value[0];
  printf("Ad group with name '%s' and ID '%s' was added.<br>", $adGroup->name,
        $adGroup->id);

  // Create product ad.
  $productAd = new ProductAd();

  // Create ad group ad.
  $adGroupAd = new AdGroupAd();
  $adGroupAd->adGroupId = $adGroup->id;
  $adGroupAd->ad = $productAd;
  $adGroupAd->status = 'PAUSED';

  unset($operations);
  $operations = array();
  // Create operation.
  $operation = new AdGroupAdOperation();
  $operation->operand = $adGroupAd;
  $operation->operator = 'ADD';
  $operations[] = $operation;

  // Make the mutate request.
  $result = $adGroupAdService->mutate($operations);

  // Display result.
  $adGroupAd = $result->value[0];
  printf("Product ad with ID '%s' was added.<br>", $adGroupAd->ad->id);
}

// Don't run the example if the file is being included.
//if (__FILE__ != realpath($_SERVER['PHP_SELF'])) {
//  return;
//}

try {
  // Get AdWordsUser from credentials in "../auth.ini"
  // relative to the AdWordsUser.php file's directory.
  $user = new AdWordsUser();
$user->SetClientCustomerId('718-172-2645');

//vbridge
//$user->SetClientCustomerId('746-122-8875');
  // Log every SOAP XML request and response.
  $user->LogAll();
  
    // Get the BudgetService, which loads the required classes.
  $budgetService = $user->GetService('BudgetService', ADWORDS_VERSION);

  // Create the shared budget (required).
  $budget = new Budget();
  $budget->name = 'Interplanetary Cruise Budget #' . uniqid();
  $budget->period = 'DAILY';
  $budget->amount = new Money(1000000);
  $budget->deliveryMethod = 'ACCELERATED';
//  $budget->deliveryMethod = 'STANDARD';

  $operations = array();

  // Create operation.
  $operation = new BudgetOperation();
  $operation->operand = $budget;
  $operation->operator = 'ADD';
  $operations[] = $operation;

   // Make the mutate request.
  $result = $budgetService->mutate($operations);
  $budget = $result->value[0];
  $budgetId = $budget->budgetId;
  // Run the example.
  addShoppingCampaignExample($user, $budgetId, $merchantId);
} catch (Exception $e) {
  printf("An error has occurred: %s\n", $e->getMessage());
}
