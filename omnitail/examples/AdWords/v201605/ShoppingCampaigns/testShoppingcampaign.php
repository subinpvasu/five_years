<?php
/**
 * This example creates a ProductPartition tree.
 *
 * @package    GoogleApiAdsAdWords
 * @subpackage v201509
 * @category   WebServices
 * @license    http://www.apache.org/licenses/LICENSE-2.0 Apache License,
 *             Version 2.0
 */

// Include the initialization file
require_once dirname(dirname(__FILE__)) . '/init.php';

$adGroupId = '25526521484';

$operations = [];

$user = new AdWordsUser();
$user->SetClientCustomerId('718-172-2645');
  // Log every SOAP XML request and response.
  $user->LogAll();
  
$adGroupCriterionService = $user->GetService('AdGroupCriterionService',
        ADWORDS_VERSION);

// Create Root
$root = new ProductPartition('SUBDIVISION');
$root->id = -1;

$rootCriterion = new BiddableAdGroupCriterion();
$rootCriterion ->adGroupId = $adGroupId;
$rootCriterion ->criterion = $root;

$rootOperation = new AdGroupCriterionOperation();
$rootOperation->operand = $rootCriterion ;
$rootOperation->operator = 'ADD';
$operations[] = $rootOperation;

// Create bid for product
$value = new ProductOfferId();
$value->value = 'MANCHUCK';

$unit = new ProductPartition('UNIT');
$unit->parentCriterionId = $root->id;
$unit->caseValue = $value;

$biddingStrategyConfiguration = new BiddingStrategyConfiguration();
$biddingStrategyConfiguration->bids = [];
$cpcBid = new \CpcBid();
$cpcBid->bid = new \Money(20000);
$biddingStrategyConfiguration->bids[] = $cpcBid;

$criterion = new \BiddableAdGroupCriterion();
$criterion->adGroupId = $adGroupId;
$criterion->criterion = $unit;
$criterion->biddingStrategyConfiguration = $biddingStrategyConfiguration;

$operation = new AdGroupCriterionOperation();
$operation->operand = $criterion;
$operation->operator = 'ADD';
$operations[] = $operation;

// Send the ops to be mutated
try {
    $adGroupCriterionService->mutate($operations);
} catch (\Exception $googleException) {
    echo sprintf('attempting change failed: %s', $googleException->getMessage());
    die(2);
}

echo "Done";