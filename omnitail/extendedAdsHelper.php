<?php

class extendedAdsHelper
{

    private $campaign_name;

    private $adgroup_name;

    private $budget;

    private $bid;

    private $headline1;

    private $headline2;

    private $keyword1;

    private $keyword2;

    private $keyword3;

    private $keyword4;

    private $keywordz = array();

    private $finalurl;

    private $description;

    private $availability;

    private $path1;

    private $path2;

    private $country;
   
    private $overall_status;
    
    private $all_campaigns = array();
    private $campaign_adgroup = array();
    private $expanded_text_ads = array();
    private $eta_keywords = array();
    
    private $CampaignService;
    private $AdGroupService;
    private $AdGroupAdService;
    private $AdGroupCriterionService;
    private $BudgetService;

    public function __construct($all_campaigns,$all_adgroups,$ads_details,$all_keywords,$user)
    {
//         if (count($array) > 0) {
//             $this->campaign_name = $array['campaign_name'];
//             $this->adgroup_name = $array['adgroup_name'];
//             $this->budget = $array['budget'];
//             $this->bid = $array['bid'];
//             $this->headline1 = $array['headline1'];
//             $this->headline2 = $array['headline2'];
//             $this->keyword1 = $array['keyword1'];
//             $this->keyword2 = $array['keyword2'];
//             $this->keyword3 = $array['keyword3'];
//             $this->keyword4 = $array['keyword4'];
//             $this->keywordz = array(
//                 $array['keyword1'],
//                 $array['keyword2'],
//                 $array['keyword3'],
//                 $array['keyword4']
//             );
//             $this->finalurl = $array['finalurl'];
//             $this->description = $array['description'];
//             $this->availability = $array['availability'];
//             $this->path1 = $array['path1'];
//             $this->path2 = $array['path2'];
//             $this->country = 'USA';
//             if (strtolower(trim($this->availability)) == 'in stock') {
//                 $this->overall_status = 'ENABLED';
//             } else {
//                 $this->overall_status = 'PAUSED';
//             }
//         }
        $this->all_campaigns = $all_campaigns;
        $this->campaign_adgroup = $all_adgroups;
        $this->expanded_text_ads = $ads_details;
        $this->eta_keywords = $all_keywords;
        
        $this->AdGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);
        $this->CampaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
        $this->AdGroupAdService = $user->GetService('AdGroupAdService', ADWORDS_VERSION);
        $this->AdGroupCriterionService = $user->GetService('AdGroupCriterionService', ADWORDS_VERSION);
        $this->BudgetService = $user->GetService('BudgetService', ADWORDS_VERSION);
        
        
    }

    public function perform_extended_ads_creation(AdWordsUser $user){
        // create and update camapigns
        
        try {
            
            $allcampaign = $this->download_all_campaign($user);
            foreach ($this->all_campaigns as $key => $name)
            {
                
                $state = array();
                $error = array();
                $campaign = $this->get_existing_campaign($allcampaign, trim($name[0]['campaign_name']));
                
                if ($campaign['id'] == 0) {
                    $budget = $this->status_shared_budget($user, $name[0]['budget']);
                    $campaignid = $this->create_campaigns($user, $name[0]['campaign_name'], $budget);
                    $state[] = 'Campaign Created - '.implode(" | ",$name[0]);

                   foreach ($this->campaign_adgroup as $key => $aname)
                   {
                      
                      if($key == trim($name[0]['campaign_name']))
                      {
                          foreach ($aname as $adgs)
                          {
                              $adgroupid = $this->create_adgroup($user, $campaignid, $adgs['adgroup_name'], $adgs['bid']);
                              
                              $state[] = 'Adgroup Created - '.$adgroupid." | ".implode(" | ",$adgs);
                              
                              foreach ($this->expanded_text_ads as $key => $ename)
                              {
                                  if($key ==  trim($name[0]['campaign_name']).'|'.$adgs['adgroup_name'])
                                  {
                                                 $this->create_extended_text_ads($user, $adgroupid,$ename);
                                      foreach ($ename as $e)
                                      {
                                          $state[] = 'Ad Created - '.count($ename);// - '.$key." | ".implode(" | ",$e);
                                      }
                                      
                                      
                                     
                                       
                                  }
                              }
                              
                              foreach ($this->eta_keywords as $key => $kname)
                              {
                                  if($key ==  trim($name[0]['campaign_name']).'|'.$adgs['adgroup_name'])
                                  {
                                      $this->add_extended_keywords($user, $adgroupid,$kname);
                                      foreach ($kname as $k)
                                      {
                                          $state[] = 'Keyword Added - '.implode(" | ",$k);
                                      }
                                      
                                  }
                              }
                          }
                         
                          
                      }
                   }
                    
                }
                else 
                {
                    if($campaign['amount']!=($name[0]['budget']*1000000))
                    {
                        $budget = $this->status_shared_budget($user, $name[0]['budget']);
                        $this->update_campaigns($user, $campaign['id'], $budget);
                        $state[] = 'Campaign Updated';
                    }
                    else 
                    {
                        $state[] = 'Campaign Skipped';
                    }
                    
                    $all_existing_adgroups = $this->download_all_adgroups($user,$campaign['id']);
                    
                    print_r($all_existing_adgroups);
//                    exit();
                    foreach ($this->campaign_adgroup as $key => $aname)
                    {
                        if($key ==  trim($name[0]['campaign_name']))
                        {
                            $adgroup = $this->get_existing_adgroup($user, $campaign['id'], $aname[0]['adgroup_name']);
                            if ($adgroup == 0) 
                            {
                                $adgroupid = $this->create_adgroup($user, $campaign['id'], $aname[0]['adgroup_name'], $aname[0]['bid']);
                                $state[]='AdGroup Added';
                                
                                foreach ($this->expanded_text_ads as $key => $ename)
                                {
                                    if($key ==  trim($name[0]['campaign_name']).'|'.$aname[0]['adgroup_name'])
                                    {
                                        $this->create_extended_text_ads($user, $adgroupid,$ename);
                                        $state[] = 'Ad Created';
                                         
                                    }
                                }
                                foreach ($this->eta_keywords as $key => $kname)
                                {
                                    if($key ==  trim($name[0]['campaign_name']).'|'.$aname[0]['adgroup_name'])
                                    {
                                        $this->add_extended_keywords($user, $adgroupid,$kname);
                                        $state[] = 'Keyword Added';
                                    }
                                }
                            }
                            else
                            {
                                $this->status_adgroup_bid($user, $adgroup, $aname[0]['bid']);
                                $state[] = 'AdGroup Skipped';
                                
                                foreach ($this->expanded_text_ads as $key => $ename)
                                {
                                    if($key ==  trim($name[0]['campaign_name']).'|'.$aname[0]['adgroup_name'])
                                    {
                                        $kid = $this->get_existing_etads($user, $adgroup,$ename);
                                        if ($kid['id'] == 0) {
                                            $adid = $this->create_extended_text_ads($user, $adgroup,$ename);
                                            $state[] = 'Ad Created';
                                            
                                            foreach ($this->eta_keywords as $key => $kname)
                                            {
                                                if($key ==  trim($name[0]['campaign_name']).'|'.$aname[0]['adgroup_name'])
                                                {
                                                    $this->add_extended_keywords($user, $adgroup,$kname);
                                                    $state[] = 'Keyword Added';
                                                }
                                            }
                                            
                                        }
                                        else 
                                        {
                                            if (strtolower(trim($ename[0]['availability'])) == 'in stock') {
                                                $ads_status = 'ENABLED';
                                            } else {
                                                $ads_status = 'PAUSED';
                                            }
                                            if ($ads_status != $kid['status']) {
                                                if ($ads_status == 'ENABLED') {
                                                    $this->update_existing_ads($user, $adgroup, $kid['id'], 1);
                                                } else {
                                                    $this->update_existing_ads($user, $adgroup, $kid['id'], 0);
                                                }
                                                
                                                $state[] = 'Ad Updated';
                                                
                                                foreach ($this->eta_keywords as $key => $kname)
                                                {
                                                    if($key ==  trim($name[0]['campaign_name']).'|'.$aname[0]['adgroup_name'])
                                                    {
                                                        $this->add_extended_keywords($user, $adgroup,$kname);
                                                        $state[] = 'Keyword Updated';
                                                        break;
                                                    }
                                                }
                                                
                                            }
                                            else {
                                                $state[] = 'Ad Skipped';
                                                $state[] = 'Keywords Skipped';
                                            }
                                        }
                                        continue;
                                         
                                    }
                                }
                                
                            }
                    
                        }
                    }
                   
                    
                   
                    
                }
                // insert status and error here.
                
            }
           
            echo '<br/>';
            echo time();
            echo '<br/>';
        } catch (Exception $e) {
            $error[] =  "Error : ".$e->getMessage();
        }
        return array('status'=>$state,'error'=>$error);
    }
    
    // cretae or update campaign
    // create or update adgroup
    // create or update ads
   
        public function get_existing_campaign($campstack, $campaign)
        {
             
            foreach ($campstack as $key => $camp)
            {
                if($key==$campaign)
                {
             return array('id' => $camp['id'],
            'budgetid' => $camp['budgetid'],
            'amount'=>$camp['amount'],
            'name'=>$camp['name'],
            'state'=>'Campaign Skipped');
                }
            }
            return array('id'=>0);
        
       
        
    }

    public function create_campaigns(AdWordsUser $user, $campaign_name, $budgetid)
    {
        global $error;
        $campaignService = $this->CampaignService;
        $campaign = new Campaign();
        $campaign->name = addslashes(trim($campaign_name));
        // The advertisingChannelType is what makes this a Shopping campaign
        $campaign->advertisingChannelType = 'SEARCH';
        $campaign->status = 'ENABLED';
        
        // Set dedicated budget (required).
        $campaign->budget = new Budget();
        $campaign->budget->budgetId = $budgetid;
        
        // Set bidding strategy (required).
        $biddingStrategyConfiguration = new BiddingStrategyConfiguration();
        $biddingStrategyConfiguration->biddingStrategyType = 'MANUAL_CPC';
        
        $campaign->biddingStrategyConfiguration = $biddingStrategyConfiguration;
        
        $operations = array();
        // Create operation.
        $operation = new CampaignOperation();
        $operation->operand = $campaign;
        $operation->operator = 'ADD';
        $operations[] = $operation;
        try{
        $result = $campaignService->mutate($operations);
        }
        catch(Exception $e){$error[] = 'Error :-'.$e->getMessage();}
        $campaignId = $result->value[0];
        return $campaignId->id;
    }
    
    public function update_campaigns(AdWordsUser $user, $campaignid, $budgetid)
    {
        global $error;
        $campaignService = $this->CampaignService;
        $campaign = new Campaign();
        $campaign->id = $campaignid;
        // The advertisingChannelType is what makes this a Shopping campaign
        
    
        // Set dedicated budget (required).
        $campaign->budget = new Budget();
        $campaign->budget->budgetId = $budgetid;
    
        // Set bidding strategy (required).
        $biddingStrategyConfiguration = new BiddingStrategyConfiguration();
        $biddingStrategyConfiguration->biddingStrategyType = 'MANUAL_CPC';
    
        $campaign->biddingStrategyConfiguration = $biddingStrategyConfiguration;
    
        $operations = array();
        // Create operation.
        $operation = new CampaignOperation();
        $operation->operand = $campaign;
        $operation->operator = 'SET';
        $operations[] = $operation;
        try{
        $result = $campaignService->mutate($operations);
        return $result;
        }
            catch(Exception $e){$error[] = 'Error :-'.$e->getMessage();}
        $campaignId = $result->value[0];
        
    }

    public function update_shared_budget(AdWordsUser $user, $campaignid, $budgetid)
    {
        global $error;
        $campaignService = $this->CampaignService;
        $campaign = new Campaign();
        $campaign->id = $campaignid;
        
        // Set dedicated budget (required).
        $campaign->budget = new Budget();
        $campaign->budget->budgetId = $budgetid;
        
        $operations = array();
        // Create operation.
        $operation = new CampaignOperation();
        $operation->operand = $campaign;
        $operation->operator = 'SET';
        $operations[] = $operation;
        try{
        $result = $campaignService->mutate($operations);
        }
        catch(Exception $e){$error[] = 'Error :-'.$e->getMessage();}
    }

    public function status_shared_budget(AdWordsUser $user, $budgets)
    {
        global $error;
        $budgetService = $this->BudgetService;
        $budgetId = 0;
        
        $selector = new Selector();
        $selector->fields = array(
            'BudgetId'
        )
        ;
        $micro_amount = $budgets * 1000000;
        $selector->predicates[] = new Predicate('Amount', 'EQUALS', $micro_amount);
        $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
        $selector->predicates[] = new Predicate('IsBudgetExplicitlyShared', 'EQUALS', 'TRUE');
        $selector->predicates[] = new Predicate('BudgetStatus', 'NOT_EQUALS', 'REMOVED');
        $selector->paging = new Paging(0, 1);
        $selector->ordering[] = new OrderBy('BudgetId', 'DESCENDING');
        try{
        $page = $budgetService->get($selector);
        }
        catch(Exception $e){$error[] = 'Error :-'.$e->getMessage();}
        
        if (isset($page->entries)) {
            
            foreach ($page->entries as $budget) {
                $budgetId = $budget->budgetId;
            }
        }
        
        if ($budgetId == 0) {
            
            $budget = new Budget();
            $budget->name = 'SKU Tools #' . uniqid();
            $budget->period = 'DAILY';
            $budget->amount = new Money($budgets * 1000000);
            $budget->deliveryMethod = 'ACCELERATED';
            $budget->isExplicitlyShared = TRUE;
            
            $operations = array();
            
            // Create operation.
            $operation = new BudgetOperation();
            $operation->operand = $budget;
            $operation->operator = 'ADD';
            $operations[] = $operation;
            
            // Make the mutate request.
            try{
            $result = $budgetService->mutate($operations);
            }
            catch(Exception $e){$error[] = 'Error :-'.$e->getMessage();}
            $budgetz = $result->value[0];
           // print_r($budgetz);exit();
            $budgetId = $budgetz->budgetId;
        }
        return $budgetId;
    }
    
    public function status_adgroup_bid(AdWordsUser $user, $adgroupid,$bidz)
    {
        global $error;
        // Get the service, which loads the required classes.
        $adGroupService = $this->AdGroupService;
       
        $cpcbidamount=0;
        
        // Create selector.
        $selector = new Selector();
        $selector->fields = array('Id','CpcBid');
        $selector->ordering[] = new OrderBy('Name', 'ASCENDING');
        
        // Create predicates.
        $selector->predicates[] = new Predicate('Id', 'EQUALS', $adgroupid);
        
        // Create paging controls.
        $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
        
        do {
            // Make the get request.
            try{
            $page = $adGroupService->get($selector);
            }
            catch(Exception $e){$error[] = 'Error :-'.$e->getMessage();}
        
            // Display results.
            if (isset($page->entries)) {
                foreach ($page->entries as $adGroup) {
//                     printf("Ad group with name '%s' and ID '%s' was found.\n",
//                     $adGroup->name, $adGroup->id);
//print_r($adGroup);
$cpcbidamount = $adGroup->biddingStrategyConfiguration->bids[0]->bid->microAmount;
                }
            } else {
                print "No ad groups were found.\n";
            }
        
            // Advance the paging index.
            $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
        } while ($page->totalNumEntries > $selector->paging->startIndex);
        
        if($cpcbidamount != ($bidz*1000000))
        {
            $adGroup = new AdGroup();
            $adGroup->id = $adgroupid;
            
            // Update the bid.
            $bid = new CpcBid();
            $bid->bid =  new Money($this->bid * AdWordsConstants::MICROS_PER_DOLLAR);
            $biddingStrategyConfiguration = new BiddingStrategyConfiguration();
            $biddingStrategyConfiguration->bids[] = $bid;
            $adGroup->biddingStrategyConfiguration = $biddingStrategyConfiguration;
            
            // Create operation.
            $operation = new AdGroupOperation();
            $operation->operand = $adGroup;
            $operation->operator = 'SET';
            
            $operations = array($operation);
            
            // Make the mutate request.
            try{
            $adGroupService->mutate($operations);
            }
            catch(Exception $e){$error[] = 'Error :-'.$e->getMessage();}
            
        }
    }

    public function get_existing_adgroup(AdWordsUser $user, $campaign, $adgroup)
    {
        global $error;
        $adGroupService = $this->AdGroupService;
        $adgroupid = 0;
        $selector = new Selector();
        $selector->fields = array(
            'Id'
        );
        $selector->ordering[] = new OrderBy('Id', 'ASCENDING');
        $adgroup_name = trim($adgroup);
        // Create predicates.
        $selector->predicates[] = new Predicate('CampaignId', 'EQUALS', $campaign);
        $selector->predicates[] = new Predicate('Name', 'EQUALS', $adgroup_name);
        // Create paging controls.
        $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
        do {
            // Make the get request.
            try{
            $page = $adGroupService->get($selector);
            }
            catch(Exception $e){$error[] = 'Error :-'.$e->getMessage();}
            // Display results.
            if (isset($page->entries)) {
                foreach ($page->entries as $adGroup) {
                    $adgroupid = $adGroup->id;
                }
            } else {
                $adgroupid = 0;
            }
            // Advance the paging index.
            $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
        } while ($page->totalNumEntries > $selector->paging->startIndex);
        return $adgroupid;
    }

    public function create_adgroup(AdWordsUser $user, $campaign, $adgroupname, $bids)
    {
        global $error;
        $adGroupService = $this->AdGroupService;
        $operations = array();
        
        // Create ad group.
        $adGroup = new AdGroup();
        $adGroup->campaignId = $campaign;
        $adGroup->name = trim($adgroupname);
        
        // Set bids (required).
        $bid = new CpcBid();
        $bid->bid = new Money($bids * 1000000);
        $biddingStrategyConfiguration = new BiddingStrategyConfiguration();
        $biddingStrategyConfiguration->bids[] = $bid;
        $adGroup->biddingStrategyConfiguration = $biddingStrategyConfiguration;
        
        // Set additional settings (optional).
        $adGroup->status = 'ENABLED';
        
        $targetingSetting = new TargetingSetting();
        
        $targetingSetting->details[] = new TargetingSettingDetail('PLACEMENT', false);
        
        $targetingSetting->details[] = new TargetingSettingDetail('VERTICAL', true);
        $adGroup->settings[] = $targetingSetting;
        
        // Create operation.
        $operation = new AdGroupOperation();
        $operation->operand = $adGroup;
        $operation->operator = 'ADD';
        // Make the mutate request.
        try{
        $result = $adGroupService->mutate($operation);
        return $result->value[0]->id;
        }
        catch(Exception $e){$error[] = 'Error :-'.$e->getMessage();}
        
        // Display result.
        
        
        // return $result;
    }

    public function create_extended_text_ads(AdWordsUser $user, $adgroupid,$ads)
    {
        global $error;
        // Get the service, which loads the required classes.
        $adGroupAdService = $this->AdGroupAdService;
        
        $operations = array();
        for($i=0;$i<count($ads);$i++)
        {
        // Create an expanded text ad.
        $expandedTextAd = new ExpandedTextAd();
        $expandedTextAd->headlinePart1 = $ads[$i]['headline1'];
        $expandedTextAd->headlinePart2 = $ads[$i]['headline2'];
        $expandedTextAd->description = $ads[$i]['description'];
        $expandedTextAd->finalUrls = array(
            $ads[$i]['finalurl']
        );
        $expandedTextAd->path1 = $ads[$i]['path1'];
        $expandedTextAd->path2 = $ads[$i]['path2'];
        
        // Create ad group ad.
        $adGroupAd = new AdGroupAd();
        $adGroupAd->adGroupId = $adgroupid;
        $adGroupAd->ad = $expandedTextAd;
        
        // Set additional settings (optional).
    if (strtolower(trim($ads[$i]['availability'])) == 'in stock') {
                $adGroupAd->status = 'ENABLED';
            } else {
                $adGroupAd->status = 'PAUSED';
            }
        
        
        // Create operation.
        $operation = new AdGroupAdOperation();
        $operation->operand = $adGroupAd;
        $operation->operator = 'ADD';
        
        $operations[] = $operation;
            } 
        
        // Make the mutate request.
        try{
        $result = $adGroupAdService->mutate($operations);
//          return $result;
return $i;
        }
        catch(Exception $e){$error[] = 'Error :-'.$e->getMessage();}
        
    }

    public function add_extended_keywords(AdWordsUser $user, $adgroupid,$keywordz)
    {
        global $error;
        $adGroupCriterionService = $this->AdGroupCriterionService;
        $operations = array();
        foreach ($keywordz as $keywordSingle){
        
        foreach($keywordSingle as $k){
            // Create keyword criterion.
            $keyword = new Keyword();
            $keytext = trim($k);
            $keyword->text = $keytext;
            $keyword->matchType = 'BROAD';
            
            // Create biddable ad group criterion.
            $adGroupCriterion = new BiddableAdGroupCriterion();
            $adGroupCriterion->adGroupId = $adgroupid;
            $adGroupCriterion->criterion = $keyword;
            
            // Create operation.
            $operation = new AdGroupCriterionOperation();
            $operation->operand = $adGroupCriterion;
            $operation->operator = 'ADD';
            $operations[] = $operation;
        }
        }
        
        // Make the mutate request.
        try{
        $result = $adGroupCriterionService->mutate($operations);
        }
        catch(Exception $e){$error[] = 'Error :-'.$e->getMessage();}
    }

    public function get_existing_etads(AdWordsUser $user, $adGroupId,$ads)
    {
        $retArray = array();
        $error = "";
        // Get the service, which loads the required classes.
        $adGroupAdService = $this->AdGroupAdService;
        $etadId = 0;
        // Create selector.
        $selector = new Selector();
        $selector->fields = array(
            'Id',
            'Status',
            'HeadlinePart1',
            'HeadlinePart2',
            'Description'
        );
        $selector->ordering[] = new OrderBy('Id', 'ASCENDING');
        
        // Create predicates.
        $selector->predicates[] = new Predicate('AdGroupId', 'EQUALS', $adGroupId);
        $selector->predicates[] = new Predicate('AdType', 'IN', array(
            'EXPANDED_TEXT_AD'
        ));
        // $selector->predicates[] = new Predicate('Status', 'IN', array('ENABLED', 'PAUSED'));
        
        foreach ($ads as $ad){
            $heading1[] = trim($ad['headline1']);
            $heading2[] = trim($ad['headline2']);
            $desc[] = trim($ad['description']);
            $path1[] = trim($ad['path1']);
            $path2[] = trim($ad['path2']);
        }
        
        $selector->predicates[] = new Predicate('HeadlinePart1', 'IN', $heading1);
        $selector->predicates[] = new Predicate('HeadlinePart2', 'IN', $heading2);
        $selector->predicates[] = new Predicate('Description', 'IN', $desc);
        $selector->predicates[] = new Predicate('Path1', 'IN', $path1);
        $selector->predicates[] = new Predicate('Path2', 'IN', $path2);
//        $selector->predicates[] = new Predicate('HeadlinePart2', 'EQUALS', trim($ads['headline2']));
//        $selector->predicates[] = new Predicate('Description', 'EQUALS', trim($ads['description']));
//        // $selector->predicates[] = new Predicate('FinalUrls', 'EQUALS', trim($this->finalurl));
//        $selector->predicates[] = new Predicate('Path1', 'EQUALS', trim($ads['path1']));
//        $selector->predicates[] = new Predicate('Path2', 'EQUALS', trim($ads['path2']));
        
        // Create paging controls.
        $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
        
        do {
            // Make the get request.
            try{
            $page = $adGroupAdService->get($selector);
            }
            catch(Exception $e){$error = 'Error :-'.$e->getMessage();}
            
            // Display results.
            if (isset($page->entries)) {
                foreach ($page->entries as $adGroupAd) {
                    
                    $retArray = array(
                        'id' => $adGroupAd->ad->id,
                        'status' => $adGroupAd->status
                    );
                    break;
                }
            } else {
                $retArray = array(
                    'id' => 0,
                    'status' => 0
                );
            }
            
            // Advance the paging index.
            $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
        } while ($page->totalNumEntries > $selector->paging->startIndex);
        $retArray['error'] = $error;
        return $retArray;
        
    }

    public function update_existing_ads(AdWordsUser $user, $adGroupIds, $adid, $statused)
    {
        global $error;
        $adGroupAdService = $this->AdGroupAdService;
        
        // Create ad using an existing ID. Use the base class Ad instead of TextAd to
        // avoid having to set ad-specific fields.
        $ad = new Ad();
        $ad->id = $adid;
        // echo $adid.$adGroupIds.$statused;
        
        // Create ad group ad.
        $adGroupAd = new AdGroupAd();
        $adGroupAd->adGroupId = $adGroupIds;
        if ($statused == 0) {
            $adGroupAd->status = 'PAUSED';
        } else {
            $adGroupAd->status = 'DISABLED';
        }
        $adGroupAd->ad = $ad;
        
        // Update the status.
        
        // Create operation.
        $operation = new AdGroupAdOperation();
        $operation->operand = $adGroupAd;
        $operation->operator = 'SET';
        
        // $operations = array($operation);
        
        // Make the mutate request.
        try{
        $result = $adGroupAdService->mutate($operation);
        }
        catch(Exception $e){$error[] = 'Error :-'.$e->getMessage();}
        if ($statused == 1) {
            $this->create_extended_text_ads($user, $adGroupIds);
        }
        // Display result.
    }
    public function download_all_campaign(AdWordsUser $user)
    {
        $campaignService = $this->CampaignService;
        $all_campaigns = array();
        // Create selector.
        $selector = new Selector();
        $selector->fields = array('Id', 'Name','BudgetId','Amount');
        $selector->ordering[] = new OrderBy('Name', 'ASCENDING');
        
        // Create paging controls.
        $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
        
        do {
            // Make the get request.
            $page = $campaignService->get($selector);
        
            // Display results.
            if (isset($page->entries)) {
                foreach ($page->entries as $campaign) {
                    
                    $all_campaigns[$campaign->name] = array('name'=>$campaign->name,'id'=>$campaign->id,'budgetid'=>$campaign->budget->budgetId,'amount'=>$campaign->budget->amount->microAmount);
//                     printf("Campaign with name '%s' and ID '%s' was found.\n",
//                     $campaign->name, $campaign->id);
                }
            } 
        
            // Advance the paging index.
            $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
        } while ($page->totalNumEntries > $selector->paging->startIndex);
        return $all_campaigns;
        
    }
    public function download_all_adgroups(AdWordsUser $user, $campaignid)
    {
        $adGroupService = $this->AdGroupService;
        $all_adgroups = array();
        // Create selector.
        $selector = new Selector();
        $selector->fields = array('Id', 'Name','CampaignId','CampaignName');
        $selector->ordering[] = new OrderBy('Name', 'ASCENDING');
        
        // Create predicates.
        $selector->predicates[] =
        new Predicate('CampaignId', 'IN', array($campaignid));
        
        // Create paging controls.
        $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
        
        do {
            // Make the get request.
            $page = $adGroupService->get($selector);
        
            // Display results.
            if (isset($page->entries)) {
                foreach ($page->entries as $adGroup) {

                    $all_adgroups[$adGroup->name] = array('id'=>$adGroup->id,'name'=>$adGroup->name,'campid'=>$adGroup->campaignId,'campname'=>$adGroup->campaignName);
                   
                }
            } 
        
            // Advance the paging index.
            $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
        } while ($page->totalNumEntries > $selector->paging->startIndex);
        return $all_adgroups;
    }
}