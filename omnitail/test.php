<?php
require_once dirname(__FILE__) .'/examples/AdWords/v201509/init.php';
require_once dirname(__FILE__) .'/Classes/AppConstants.php';
require_once dirname(__FILE__) .'/Classes/DatabaseHelper.php';

$accountId = "6539291121";
//$accountId = "1226811775";
$dbHelper = new DbHelper();
$oauth2Infos = array(
        "client_id" => AppConstants::$CLIENTID,
        "client_secret" => AppConstants::$SECRET,
        "refresh_token" => $dbHelper->getAppropriateToken($accountId)
    );
$user = new AdWordsUser(NULL,AppConstants::$DEVTOKEN,AppConstants::$AGENT,NULL,NULL,$oauth2Infos);
$user->SetClientCustomerId($accountId);

$campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
$adGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);
$adGroupAdService = $user->GetService('AdGroupAdService', ADWORDS_VERSION);
$budgetService = $user->GetService('BudgetService', ADWORDS_VERSION); 
$labelService = $user->GetService('LabelService', ADWORDS_VERSION);

$budgetId = 0;
     
   
$selector = new Selector ();
$selector->fields = array (
//    'BudgetId'
    'Amount','BudgetId','BudgetName','BudgetReferenceCount','BudgetStatus','DeliveryMethod','IsBudgetExplicitlyShared'
);
$micro_amount = 100000000;
$selector->predicates[] = new Predicate('Amount', 'EQUALS', $micro_amount);
$selector->predicates[] = new Predicate('IsBudgetExplicitlyShared', 'EQUALS', 'TRUE');
$selector->predicates[] = new Predicate('BudgetStatus', 'NOT_EQUALS', 'REMOVED');
$selector->paging = new Paging ( 0, 10 );
$selector->ordering[] = new OrderBy('BudgetId', 'DESCENDING');
$page = $budgetService->get ( $selector );
echo '<pre>';
print_r($page);
echo '</pre>';
if (isset ( $page->entries )) {
    foreach ( $page->entries as $budget ) {
         $budgetId = $budget->budgetId;
    }
}


//do {
//    
//    $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
//} while ( $page->totalNumEntries > $selector->paging->startIndex );


die("<br>".$budgetId);

$budget = new Budget();
$budget->name = 'Shopping Budget #' . uniqid();
$budget->period = 'DAILY';
$budget->amount = new Money(10000000);
$budget->deliveryMethod = 'ACCELERATED';
$budget->isExplicitlyShared = TRUE;

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

echo '<pre>';
print_r($result);
echo '</pre>';

// Create campaign.
$campaign = new Campaign();
$campaign->name = "Bisjo_Test_Campaign_1008";
// The advertisingChannelType is what makes this a Shopping campaign
$campaign->advertisingChannelType = 'SHOPPING';
$campaign->status = 'PAUSED';

// Set dedicated budget (required).
$campaign->budget = new Budget();
$campaign->budget->budgetId = $budgetId;

// Set bidding strategy (required).
$biddingStrategyConfiguration = new BiddingStrategyConfiguration();
$biddingStrategyConfiguration->biddingStrategyType = 'MANUAL_CPC';

$campaign->biddingStrategyConfiguration = $biddingStrategyConfiguration;


// All Shopping campaigns need a ShoppingSetting.
$shoppingSetting = new ShoppingSetting();
$shoppingSetting->salesCountry = "US";
$shoppingSetting->campaignPriority = 0;
$shoppingSetting->merchantId = "109771959";
// Set to "true" to enable Local Inventory Ads in your campaign.
$shoppingSetting->enableLocal = true;
$campaign->settings[] = $shoppingSetting;


//top
//
// Create campaign.
$campaignNew = new Campaign();
$campaignNew->name = "Bisjo_Test_Campaign_1007";
// The advertisingChannelType is what makes this a Shopping campaign
$campaignNew->advertisingChannelType = 'SHOPPING';
$campaignNew->status = 'PAUSED';

$campaignNew->budget = new Budget();
$campaignNew->budget->budgetId = $budgetId;

$campaignNew->biddingStrategyConfiguration = $biddingStrategyConfiguration;

$campaignNew->settings[] = $shoppingSetting;

$campaignOperations = array();
// Create operation.
$campaignOperation = new CampaignOperation();
$campaignOperation->operand = $campaign;
$campaignOperation->operator = 'ADD';
$campaignOperationNew = new CampaignOperation();
$campaignOperationNew->operand = $campaignNew;
$campaignOperationNew->operator = 'ADD';
$campaignOperations[] = $campaignOperation;
$campaignOperations[] = $campaignOperationNew;

$result = $campaignService->mutate($campaignOperations);
echo '<pre>';
print_r($result);
echo '</pre>';

//try {
//    
//} catch (Exception $exc) {
//    echo $exc->getTraceAsString();
//}
