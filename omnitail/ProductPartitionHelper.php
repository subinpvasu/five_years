<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * A helper for creating ProductPartition trees
 *
 * @package    GoogleApiAdsAdWords
 * @subpackage v201509
 */
class ProductPartitionHelper {
    /**
   * The next temporary criterion ID to be used.
   *
   * When creating our tree we need to specify the parent-child relationships
   * between nodes. However, until a criterion has been created on the server
   * we do not have a criterionId with which to refer to it.
   *
   * Instead we can specify temporary IDs that are specific to a single mutate
   * request. Once the criteria have been created they are assigned an ID as
   * normal and the temporary ID will no longer refer to it.
   *
   * A valid temporary ID is any negative integer.
   * @var integer
   */
  private $nextId = -1;

  /**
   * The set of mutate operations needed to create the current tree.
   * @var array
   */
  private $operations = array();

  /**
   * The ID of the AdGroup that we wish to attach the partition tree to.
   * @var int
   */
  private $adGroupId;

  /**
   * Constructor
   * @param int $adGroupId The ID of the AdGroup that we wish to attach the
   *                       partition tree to.
   */
  public function __construct($adGroupId) {
    $this->adGroupId = $adGroupId;
  }

  /**
   * Creates a subdivision node
   * @param  ProductPartition $parent The node that should be this node's parent
   * @param  ProductDimension $value The value being partitioned on
   * @return ProductPartition A new subdivision node
   */
  public function createSubdivision(ProductPartition $parent = null,
      ProductDimension $value = null) {
    $division = new ProductPartition('SUBDIVISION');
    $division->id = $this->nextId--;

    // The root node has neither a parent nor a value
    if (!is_null($parent)) {
      $division->parentCriterionId = $parent->id;
      $division->caseValue = $value;
    }

    $criterion = new BiddableAdGroupCriterion();
    $criterion->adGroupId = $this->adGroupId;
    $criterion->criterion = $division;

    $this->createAddOperation($criterion);

    return $division;
  }

  /**
   * Creates a unit node.
   * @param  ProductPartition $parent The node that should be this node's parent
   * @param  ProductDimension $value The value being partitioned on
   * @param  int $bid_amount The amount to bid for matching products, in micros
   * @return ProductPartition A new unit node
   */
  public function createUnit(ProductPartition $parent = null,
      ProductDimension $value = null, $bid_amount = null) {
      
    $unit = new ProductPartition('UNIT');

    // The root node has neither a parent nor a value
    if (!is_null($parent)) {
      $unit->parentCriterionId = $parent->id;
      $unit->caseValue = $value;
    }

    if (!is_null($bid_amount) && $bid_amount > 0) {
      $biddingStrategyConfiguration = new BiddingStrategyConfiguration();
      $biddingStrategyConfiguration->bids = array();
      $cpcBid = new CpcBid();
      $cpcBid->bid = new Money($bid_amount);
      $biddingStrategyConfiguration->bids[] = $cpcBid;

      $criterion = new BiddableAdGroupCriterion();
      $criterion->biddingStrategyConfiguration = $biddingStrategyConfiguration;
    } else {
      $criterion = new NegativeAdGroupCriterion();
    }

    $criterion->adGroupId = $this->adGroupId;
    $criterion->criterion = $unit;

    $this->createAddOperation($criterion);

    return $unit;
  }
  
  /**
   * Set the Unit we want to remove
   * @param type $productCriterion
   */
  public function removeUnit($productCriterion) {
      $criterion = new BiddableAdGroupCriterion();
      $criterion->adGroupId = $this->adGroupId;
      $criterion->criterion = $productCriterion;
      
      $this->createRemoveOperation($criterion);
      
  }

  /**
   * Returns the set of mutate operations needed to create the current tree.
   * @return array The set of operations
   */
  public function getOperations() {
    return $this->operations;
  }

  /**
   * Creates an AdGroupCriterionOperation for the given criterion
   * @param  AdGroupCriterion $criterion The criterion we want to add
   */
  private function createAddOperation(AdGroupCriterion $criterion) {
    $operation = new AdGroupCriterionOperation();
    $operation->operand = $criterion;
    $operation->operator = 'ADD';
    $this->operations[] = $operation;
  }
  
  /**
   * Set AdGroupCriterionOperation to remove
   * @param AdGroupCriterion $criterion the criterion we want to remove
   */
  private function createRemoveOperation(AdGroupCriterion $criterion) {
    $operation = new AdGroupCriterionOperation();
    $operation->operand = $criterion;
    $operation->operator = 'REMOVE';
    $this->operations[] = $operation;
  }
}
