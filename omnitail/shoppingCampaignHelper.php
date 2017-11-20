<?php

/**
 * Description of shoppingCampaignHelper
 * This class perform Create, Update, Remove, Get operations on Adwords API
 * @author shijo k.j
 */
class shoppingCampaignHelper {
        
    private $target;
    private $targetData;
    private $brand;
    private $cl0;
    private $campaignName;
    private $adgroupName;
    private $bid;
    private $priority = '0';
    private $merchantId = '469547';
    private $budget;
    private $label = 'PLA';
    private $country = 'US';
    private $campaignStatus='Campaign not processed';
    private $adgroupStatus='Ad group not processed';
    private $productStatus='Product group not processed';
 
    public function __construct($value) {
        if(count($value)>0){
            $this->target = $value->target;
            $this->targetData = $value->target_data;
            $this->brand = $value->brand;
            $this->cl0 = $value->clo;
            $this->campaignName = $value->campaign_name;
            $this->adgroupName = $value->ad_group_name;
            $this->bid = $value->bid;
            $this->priority = $value->priority;
            $this->merchantId = $value->merchant_id;
            $this->budget = $value->budget;
            $this->label = $value->label;
            if($value->country == 'United States')
                $this->country = 'US';
            else
                $this->country = 'CA';
        }
     }
  
     // Test Function to display Class variables
     public function test(){
        echo "Target: " . $this->target . '<br>';
        echo "Target Data: " . $this->targetData . '<br>';
        echo "Brand: " . $this->brand . '<br>';
        echo "CLO: " . $this->cl0 . '<br>';
        echo "Campaign Name: " . $this->campaignName . '<br>';
        echo "Adgroup Name: " . $this->adgroupName . '<br>';
        echo "Bid: " . $this->bid . '<br>';
        echo "Priority: " . $this->priority . '<br>';
        echo "Merchant ID: " . $this->merchantId . '<br>';
        echo "Budget: " . $this->budget . '<br>';
        echo "Label: " . $this->label . '<br>';
        echo "Country: " . $this->country . '<br><br>';
     }
     
    /**
    * Runs the example.
    * @param AdWordsUser $user the user to run the example with
    * @param string $campaignId the id of the parent campaign
    */
    function GetAdGroups(AdWordsUser $user, $campaignId) {
        $returnArray = array();
      // Get the service, which loads the required classes.
      $adGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);

      // Create selector.
      $selector = new Selector();
      $selector->fields = array('Id', 'Name');
      $selector->ordering[] = new OrderBy('Name', 'ASCENDING');

      // Create predicates.
      $selector->predicates[] =
          new Predicate('CampaignId', 'IN', array($campaignId));

      // Create paging controls.
      $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);

      do {
        // Make the get request.
        $page = $adGroupService->get($selector);

        // Display results.
        if (isset($page->entries)) {
          foreach ($page->entries as $adGroup) {
            $returnArray[$adGroup->id] = $adGroup->name;
          }
        } else {
            //print "No ad groups were found.\n";
        }

        // Advance the paging index.
        $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
      } while ($page->totalNumEntries > $selector->paging->startIndex);
      
      return $returnArray;
    }
    
    /**
     * Function to get Critrion(productgroup) of an Adgroup
     * @param AdWordsUser $user
     * @param type $adGroupId
     * @return type Array
     */
    public function GetAdgroupCritrion(AdWordsUser $user, $adGroupId) {
        $adGroupCriterionService = $user->GetService('AdGroupCriterionService', ADWORDS_VERSION);
        
        // Create selector.
        $selector = new Selector();
        $selector->fields = array('Id', 'CpcBid', 'CaseValue', 'ParentCriterionId', 'PartitionType');
        
        // Create predicates.
        $selector->predicates[] =
            new Predicate('AdGroupId', 'EQUALS', $adGroupId);
        
        $page = $adGroupCriterionService->get($selector);
        return $page->entries;
    }

    /**
     * Function to create Budget, Campaign, Adgroup 
     * @param AdWordsUser $user
     * @param type $recordId
     * @param type $dbHelper
     * @return type
     */
   public function addShoppingCampaign(AdWordsUser $user, $recordId, $dbHelper, $budgetService, $campaignService, $labelService, $adGroupService, $adGroupCriterionService, $campaignCriterionService) {

//       $dbHelper->addToTestTable('Entered Function');
     // Get the services, which loads the required classes.
//     $budgetService = $user->GetService('BudgetService', ADWORDS_VERSION); 
     
     
//     $adGroupAdService = $user->GetService('AdGroupAdService', ADWORDS_VERSION);
     
     
     
     //check the budget if avaialble
     $budgetId = 0;
//     $dbHelper->addToTestTable('Services initiated and finding budgets started - api');
   
     $selector = new Selector ();
     $selector->fields = array (
        'BudgetId'
    //    'Amount','BudgetId','BudgetName','BudgetReferenceCount','BudgetStatus','DeliveryMethod','IsBudgetExplicitlyShared'
    );
     $micro_amount = $this->budget*1000000;
     $selector->predicates[] = new Predicate('Amount', 'EQUALS', $micro_amount);
     $selector->paging = new Paging ( 0, AdWordsConstants::RECOMMENDED_PAGE_SIZE );
     $selector->predicates[] = new Predicate('IsBudgetExplicitlyShared', 'EQUALS', 'TRUE');
     $selector->predicates[] = new Predicate('BudgetStatus', 'NOT_EQUALS', 'REMOVED');
    $selector->paging = new Paging ( 0, 1 );
    $selector->ordering[] = new OrderBy('BudgetId', 'DESCENDING');
     
    $page = $budgetService->get ( $selector );
    if (isset ( $page->entries )) {
        foreach ( $page->entries as $budget ) {
             $budgetId = $budget->budgetId;
        }
    }
    
//    $dbHelper->addToTestTable('Budget finding finished - '.$budgetId);
     
     
     
     	if($budgetId==0){
//            $dbHelper->addToTestTable('Creating budget started');
     // Create the shared budget (required).
     $budget = new Budget();
     $budget->name = 'Shopping Budget #' . uniqid();
     $budget->period = 'DAILY';
     $budget->amount = new Money($this->budget*1000000);
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
//     $dbHelper->addToTestTable('Creating budget finished');
     	}

        $dbHelper->addToTestTable("BudgetId = $budgetId");
//        $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
     // Create campaign.
     $campaign = new Campaign();
     $campaign->name = $this->campaignName;
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
     $shoppingSetting->salesCountry = $this->country;
     $shoppingSetting->campaignPriority = $this->priority;
     $shoppingSetting->merchantId = $this->merchantId;
     // Set to "true" to enable Local Inventory Ads in your campaign.
     $shoppingSetting->enableLocal = true;
     $campaign->settings[] = $shoppingSetting;

     $operations = array();
     // Create operation.
     $operation = new CampaignOperation();
     $operation->operand = $campaign;
     $operation->operator = 'ADD';
     $operations[] = $operation;

     
     
     try {
//         $dbHelper->addToTestTable('Creating campaign initiated - api call');
         // Make the mutate request.
        $result = $campaignService->mutate($operations);
        $campaign = $result->value[0];
        $addedCampaignId = $dbHelper->addCampaign($campaign->id, $campaign->name, $this->merchantId, $recordId);
        $this->campaignStatus = 'Campaign Created';
//        $dbHelper->addToTestTable('Creating campaign finished - api call');
     } catch (Exception $ex) {
         $dbHelper->addToTestTable('Error creating campaign - '.addslashes($ex->getMessage()));
         //Get campaign Id, if campaign already exist
         if(strpos($ex->getMessage(),'DUPLICATE_CAMPAIGN_NAME')!==FALSE)
         {
            
            $campaign = GetCampaignByName($user, $campaignService, $this->campaignName);
            $addedCampaignId = $dbHelper->getCampaignId($campaign->id, $campaign->name, $this->merchantId, $recordId);
            $this->campaignStatus = 'Campaign Skipped';
         }
         else
         {
             $this->campaignStatus = 'Campaign Error';
             return array($this->campaignStatus,$this->adgroupStatus,$this->productStatus);
         }
     }
//     $dbHelper->addToTestTable('Geting labels initiated');
     // Create selector.
     $selector = new Selector();
     $selector->fields = array('LabelId', 'LabelName');
     $selector->ordering[] = new OrderBy('LabelName', 'ASCENDING');
     $selector->predicates[] =  new Predicate('LabelName', 'EQUALS', $this->label  );
     
     $deatil_label = array();
     $operationce = array();
     $operationz = array();
   
//     $dbHelper->addToTestTable('Geting labels initiated - api');
     
//     $labelService = $user->GetService('LabelService', ADWORDS_VERSION);
     
     // Make the get request.
     $page = $labelService->get($selector);
//     $dbHelper->addToTestTable('Geting labels finished - api');
     // Display results.
     if (isset($page->entries)) {
        foreach ($page->entries as $label) {
            $deatil_label[] = $label->id;
        }
     } 
     
     if(count($deatil_label)>0)
     {
//         $dbHelper->addToTestTable('Creating campaign labels initiated for existing labels');
         // Label already exist, assign to campaign
         $label = new CampaignLabel();
         $label->campaignId = $campaign->id;
         $label->labelId = $deatil_label[0];
          
         $operation = new CampaignLabelOperation();
         $operation->operator = 'ADD';
         $operation->operand = $label;
         $operationz[] = $operation;
     }
     else
     {
//         $dbHelper->addToTestTable('Creating text labels initiated');
         //Label not exist, create label first then assign to campaign
         $label = new TextLabel();
         $label->name = $this->label;
          
         $operation = new LabelOperation();
         $operation->operand = $label;
         $operation->operator = 'ADD';
         $operationce[] = $operation;
         
         try {
//             $dbHelper->addToTestTable('Creating text labels initiated - api');
             $result = $labelService->mutate($operationce);
//             $dbHelper->addToTestTable('Creating text labels finished - api');
         } catch (Exception $ex) {
             $dbHelper->addToTestTable('Error creating label - '.addslashes($ex->getMessage()));
             echo $ex;
         }
//          $dbHelper->addToTestTable('Creating campaign labels initiated for new text labels');
         $label = new CampaignLabel();
         $label->campaignId = $campaign->id;
         $label->labelId = $result->value[0]->id;
     
         $operation = new CampaignLabelOperation();
         $operation->operator = 'ADD';
         $operation->operand = $label;
         $operationz[] = $operation;
          
     }
     try {
//         $dbHelper->addToTestTable('Creating campaign labels initiated - api');
        $campaignService->mutateLabel($operationz);
//        $dbHelper->addToTestTable('Creating campaign labels finished - api');
     }
     catch(Exception $Ex) {
         $dbHelper->addToTestTable('Error mutating label - '.addslashes($ex->getMessage()));
     }

//     $dbHelper->addToTestTable('Creating adgroups');
//     $adGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);
     // Create ad group.
     $adGroup = new AdGroup();
     $adGroup->campaignId = $campaign->id;
     $adGroup->name = $this->adgroupName;
     $adGroup->status = 'PAUSED';

     unset($operations);
     $operations = array();
     // Create operation.
     $operation = new AdGroupOperation();
     $operation->operand = $adGroup;
     $operation->operator = 'ADD';
     $operations[] = $operation;
     
     $isAdGroupNew = false;
     
     try{
//         $dbHelper->addToTestTable('Creating adgroups - api');
         // Make the mutate request.
        $result = $adGroupService->mutate($operations);
//        $dbHelper->addToTestTable('Creating adgroups finished - api');
        $adGroup = $result->value[0];
        $createdAdgroupId = $dbHelper->addAdgroup($adGroup->id, $adGroup->name, 
                $addedCampaignId, $this->merchantId, $recordId);
        $this->adgroupStatus = 'Adgroup Created';
     }  catch (Exception $ex){
         $dbHelper->addToTestTable('Error creating adgroup - '.addslashes($ex->getMessage()));
         
//         $dbHelper->addToTestTable('Getting adgroups - api');
         $adGroupsArray = $this->GetAdGroups($user, $campaign->id);
//         $dbHelper->addToTestTable('Getting adgroups finished - api');
         foreach ($adGroupsArray as $key => $val){
             if($val == $this->adgroupName){
                
                $adGroup->id = $key;
                $adGroup->name = $val;
                $isAdGroupNew = true;
                if(strpos($ex->getMessage(),'DUPLICATE_ADGROUP_NAME')!==FALSE) {
                    $this->adgroupStatus = 'Adgroup Skipped';
                    if(!$dbHelper->isAdgroupExist($val, $addedCampaignId)){
                        $createdAdgroupId = $dbHelper->addAdgroup($key, $val, $addedCampaignId, $this->merchantId, $recordId);
                    }else{
                        $createdAdgroupId = $dbHelper->updateAdgroup($val, $recordId);
                    }
                }
                else {
                   $this->adgroupStatus = 'Adgroup Error';
                   return array($this->campaignStatus,$this->adgroupStatus,$this->productStatus);
                }
             }
         }
     }

//     $dbHelper->addToTestTable('Set targetting - api');
     // Set Campaign Target Criteria 
     $this->AddCampaignTargetingCriteria($user, $campaign->id, $campaignCriterionService);

//     $dbHelper->addToTestTable('Set targetting finished - api');
     
     // Creating Product partition
    try {
       $this->addProductPartitionTree($user, $adGroup->id, $isAdGroupNew, $dbHelper, 
                $createdAdgroupId, $campaign->id, $recordId, $adGroupCriterionService);
       $this->productStatus = 'Product Group Created';
    } catch (Exception $e) {
        $dbHelper->addToTestTable('Error creating product group - '.addslashes($ex->getMessage()));
        if(strpos($e->getMessage(), 'PRODUCT_PARTITION_ALREADY_EXISTS')) {
            $this->productStatus = 'Product Group Skipped';
        } else {
            $this->productStatus = 'Product Group Error';
        }
     }

     //Return Sataus of each operation
     return array($this->campaignStatus,$this->adgroupStatus,$this->productStatus);
   }
   
   /**
    * Function to add targeting critrion to campaign
    * @param AdWordsUser $user the user to run the example with
    * @param string $campaignId the id of the campaign to add targeting criteria to
    */
   public function AddCampaignTargetingCriteria(AdWordsUser $user, $campaignId, $campaignCriterionService) {
     // Get the service, which loads the required classes.
//     $campaignCriterionService =
//         $user->GetService('CampaignCriterionService', ADWORDS_VERSION);

     $campaignCriteria = array();

     // Create locations. The IDs can be found in the documentation or retrieved
     // with the LocationCriterionService.
     $canada = new Location();
     $canada->id = 2124;
     $campaignCriteria[] = new CampaignCriterion($campaignId, null, $canada);

     $unitedstate = new Location();
     $unitedstate->id = 2840;
     $campaignCriteria[] = new CampaignCriterion($campaignId, null, $unitedstate);

     // Create operations.
     $operations = array();
     foreach ($campaignCriteria as $campaignCriterion) {
       $operations[] = new CampaignCriterionOperation($campaignCriterion, 'ADD');
     }

     // Make the mutate request.
     $result = $campaignCriterionService->mutate($operations);

   }
   
   /**
    * Function to Create Product partition/Group inside the Adgroup
    * @param AdWordsUser $user
    * @param type $adGroupId
    * @param type $isAdGroupNew
    * @param type $dbHelper
    * @param type $createdAdgroupId
    * @param type $campaignId
    * @param type $recordId
    */
   public function addProductPartitionTree(AdWordsUser $user, $adGroupId, 
           $isAdGroupNew=false, $dbHelper, $createdAdgroupId, $campaignId, 
           $recordId, $adGroupCriterionService) {
//       $dbHelper->addToTestTable('Add product partition function reached');
        // Get the AdGroupCriterionService, which loads the required classes.
//        $adGroupCriterionService = $user->GetService('AdGroupCriterionService',
//              ADWORDS_VERSION);
        $helper = new ProductPartitionHelper($adGroupId);

        // Check for the existance of AdGroup, if not
        // create new product partition. Otherwise,
        // update existing partition
        $parents = $this->GetAdgroupCritrion($user, $adGroupId);
        
        
        //There is no Adgroup and product group existe
        if($isAdGroupNew == false || !isset($parents)){
            //Creating new product partition
           $root = $helper->createSubdivision();
           $targetType = $this->getTargetType($this->target);

           $helper->createUnit($root, $targetType[0], ($this->bid * 1000000));
           $helper->createUnit($root, $targetType[1]);
           
        }else{
            //Adgroup or Product Group exist
            foreach($parents as $parent) {
                if(isset($parent->criterion->caseValue->type) && $parent->criterion->caseValue->type == $this->target) {
                    $root = $parents[0]->criterion;
                }
            }
            // If ProductGroup with Same kind of Target is not there
            if(!isset($root)) {
                // Removing last Unit to add Subdivision
                $productCriterion = $parents[1]->criterion;
                $helper->removeUnit($productCriterion);

                // Create a Subdivision
                $subRoot = $parents[0]->criterion;
                $targetType = $this->getTargetType($parents[count($parents)-1]->criterion->caseValue->type);
                $root = $helper->createSubdivision($subRoot, $targetType[1]);

                $unitTargetType = $this->getTargetType($this->target);
                $helper->createUnit($root, $unitTargetType[0] , ($this->bid * 1000000));
                $helper->createUnit($root, $unitTargetType[1]);             
                
            }else { // If ProductGroup with Same kind of Target is there
                $unitTargetType = $this->getTargetType($this->target);
                $helper->createUnit($root, $unitTargetType[0] , ($this->bid * 1000000));
            }
        }

//        $dbHelper->addToTestTable('Creating product partition - api');
        
        // Make the mutate request.
        $result = $adGroupCriterionService->mutate($helper->getOperations());
//        $dbHelper->addToTestTable('Creating product partition finished - api');
        
        //Save Product group to DB
        $dbHelper->addProductGroup($this->target, $this->targetData, $createdAdgroupId, 
                $campaignId, $this->merchantId, $recordId);
   }
   
   /**
    * Function to get the Object of ProductGroup Target type
    * @param type $type Productgroup Target type
    * @return \ProductType|\ProductChannel|\ProductCanonicalCondition|
    * \ProductBrand|\ProductCustomAttribute|\ProductBiddingCategory|
    * \ProductChannelExclusivity|\ProductOfferId
    */
   public function getTargetType($type) {
       $retObj = array();
       switch ($type) {
           case 'Brand':
               $retObj[] = new ProductBrand($this->targetData);
               $retObj[] = new ProductBrand();
               
               return $retObj;
               break;
           case 'Condition':
               $retObj[] = new ProductCanonicalCondition($this->targetData);
               $retObj[] = new ProductCanonicalCondition();
               
               return $retObj;
               break;
           case 'Category':
               $retObj[] = new ProductBiddingCategory('BIDDING_CATEGORY_L1', $this->targetData);
               $retObj[] = new ProductBiddingCategory('BIDDING_CATEGORY_L1');
               
               return $retObj;
               break;
           case 'Channel':
               $retObj[] = new ProductChannel($this->targetData);
               $retObj[] = new ProductChannel();
               
               return $retObj;
               break;
           case 'Item ID':
               $retObj[] = new ProductOfferId($this->targetData);
               $retObj[] = new ProductOfferId();
               
               return $retObj;
               break;
           case 'Product type':
               $retObj[] = new ProductType('PRODUCT_TYPE_L1', $this->targetData);
               $retObj[] = new ProductType('PRODUCT_TYPE_L1');
               
               return $retObj;
               break;
           case 'Channel exclusivity':
               $retObj[] = new ProductChannelExclusivity($this->targetData);
               $retObj[] = new ProductChannelExclusivity();
               
               return $retObj;
               break;
           case 'CUSTOM_ATTRIBUTE_0':
               $retObj[] = new ProductCustomAttribute($type, $this->targetData);
               $retObj[] = new ProductCustomAttribute($type);
               $retObj[] = new ProductCustomAttribute();
               
               return $retObj;
               break;
           case 'CUSTOM_ATTRIBUTE_1':
               $retObj[] = new ProductCustomAttribute($type, $this->targetData);
               $retObj[] = new ProductCustomAttribute($type);
               $retObj[] = new ProductCustomAttribute();
               
               return $retObj;
               break;
           case 'CUSTOM_ATTRIBUTE_2':
               $retObj[] = new ProductCustomAttribute($type, $this->targetData);
               $retObj[] = new ProductCustomAttribute($type);
               $retObj[] = new ProductCustomAttribute();
               
               return $retObj;
               break;
           case 'CUSTOM_ATTRIBUTE_3':
               $retObj[] = new ProductCustomAttribute($type, $this->targetData);
               $retObj[] = new ProductCustomAttribute($type);
               $retObj[] = new ProductCustomAttribute();
               
               return $retObj;
               break;
           case 'CUSTOM_ATTRIBUTE_4':
               $retObj[] = new ProductCustomAttribute($type, $this->targetData);
               $retObj[] = new ProductCustomAttribute($type);
               $retObj[] = new ProductCustomAttribute();
               
               return $retObj;
               break;
           
           default:
               break;
       }
   }

   /**
    * Function to change Campaign Status
    * @param AdWordsUser $user
    * @param type $campaignId
    * @param type $status
    * @return type Campaign Object
    */
   public function changeCampaignStatus(AdWordsUser $user, $campaignId, $status) {
        $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
        
        $campaign = new Campaign();
        $campaign->id = $campaignId;
        $campaign->status = $status;
       
        $operations = array();
        // Create operation.
        $operation = new CampaignOperation();
        $operation->operand = $campaign;
        $operation->operator = 'SET';
        $operations[] = $operation;
        
        $result = $campaignService->mutate($operations);
		$dbHelper = new DbHelper;
		$change_campaign = $dbHelper->activateCampaign($campaignId);
        return $result;
   }
   
   /**
    * Function to change the Status of the AdGroup
    * @param AdWordsUser $user
    * @param type $adgroupId
    * @param type $status
    * @return type AdGroup Object
    */
   public function changeAdgroupStatus(AdWordsUser $user, $adgroupId, $status) {
       $adGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);
       
       // Create ad group.
       $adGroup = new AdGroup();
       $adGroup->id = $adgroupId;
       $adGroup->status = $status;
       
       $operations = array();
       $operation = new AdGroupOperation();
       $operation->operand = $adGroup;
       $operation->operator = 'SET';
       $operations[] = $operation;
       
       $result = $adGroupService->mutate($operations);
	   $dbHelper = new DbHelper;
	   $change_adgroup = $dbHelper->activateAdgroup($adgroupId);
       return $result;
   }
   
    /**
     * only for Eligible (limit by budget included) customers 
     * @param AdWordsUser $user
     * @return type
     */
    function getTotalBudget(AdWordsUser $user){
        $budgetz = 0;
        $budgetService = $user->GetService('CampaignService', ADWORDS_VERSION);
        $selector = new Selector();
        $selector->fields = array('Id', 'Amount');
        $selector->ordering[] = new OrderBy('Id', 'ASCENDING');//CampaignStatus
        $selector->predicates[] =  new Predicate('CampaignStatus', 'EQUALS', 'ENABLED'  );
        $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
    
        do {
            // Make the get request.
            $page = $budgetService->get($selector);
            if (isset($page->entries)) {
                 foreach ($page->entries as $budget) {
                    $budgetz += $budget->budget->amount->microAmount/1000000;
                 }
            } else {
                print "No labels were found.\n";
            }

            // Advance the paging index.
            $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
        } while ($page->totalNumEntries > $selector->paging->startIndex);
        
        return number_format($budgetz,2);
    } 

}
