<?php

class extendedAdsHelperNew
{
    private $budget;

    private $bid;

    private $description;


    private $path1;

    private $path2;

    public  $error = array();
    
    private $CampaignService;
    private $AdGroupService;
    private $AdGroupAdService;
    private $AdGroupCriterionService;
    private $BudgetService;
    
    private $fullList;
    private $adsOnlyList;
    private $adGroupList;
    private $budgetsList = array();
    private $AdKeywordsList;
    private $totalKeywordsExisting;
    
    private $campaignsInAdwords = array();
    private $adgroupsInAdwords = array();
    private $adsInAdwordsAsArray = array();
    private $dbObj;
    
    public function __construct($user, $objDb){
        $this->AdGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);
        $this->CampaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
        $this->AdGroupAdService = $user->GetService('AdGroupAdService', ADWORDS_VERSION);
        $this->AdGroupCriterionService = $user->GetService('AdGroupCriterionService', ADWORDS_VERSION);
        $this->BudgetService = $user->GetService('BudgetService', ADWORDS_VERSION);
        $this->dbObj = $objDb;
        $this->campaignsInAdwords = $this->download_all_campaign();
        $campaignIdArray = $this->getUnique($this->campaignsInAdwords, AppConstants::$ID_NAME_DB);
        $this->adgroupsInAdwords = $this->downloadAllAdgroupsInGivenCampaigns($campaignIdArray);
        $adGroupIds = $this->getAdGroupIds();
        $this->getAllExistingEtads($adGroupIds);
        
    }
    
    public function setAdsOnlyList($list){
        $this->adsOnlyList = $list;
    }
    
    function setAdGroupList($adGroupList) {
        $this->adGroupList = $adGroupList;
    }
    function setAdKeywordsList($list)
    {
        $this->AdKeywordsList = $list;
    }
    
    public function initialize($rowArray)
    {
        $this->fullList[] = $rowArray;
    }
    
    
    /**
     * Get all ids of adgroups in an array
     * @return type
     */
    private function getAdGroupIds(){
        $retArray = array();
        foreach ($this->adgroupsInAdwords as $adGroups){
            $retArray[] = $adGroups[AppConstants::$ID_NAME_DB];
        }
        return $retArray;
    }
    
    /**
     * Get adgroup details with id
     * @param type $id
     * @return type
     */
    private function getAdGroupDetails($id){
        foreach ($this->adgroupsInAdwords as $adGrp){
            if($adGrp[AppConstants::$ID_NAME_DB]==$id){
                return $adGrp;
            }
        }
    }

    
    /**
     * Get adgroup details with campaign name and ad group name
     * @param type $adGrpName
     * @param type $campName
     * @return type
     */
    private function getAdGroupDetailsWithNames($adGrpName, $campName){
        foreach ($this->adgroupsInAdwords as $adGrp){
            if($adGrp[AppConstants::$CAMPAIGN_NAME_DB]==$campName && $adGrp[AppConstants::$NAME]==$adGrpName){
                return $adGrp;
            }
        }
    }
    
    /**
     * Get to be updated ads
     * @return type
     */
    private function getToBeUpdatedAds(){
        $retArray = array();
        foreach ($this->fullList as $dbRows){
            foreach ($this->adsInAdwordsAsArray as $ad){
                if(
                    $dbRows[AppConstants::$HEAD1_NAME_DB] == $ad[AppConstants::$HEAD1_NAME_DB] &&
                    $dbRows[AppConstants::$HEAD2_NAME_DB] == $ad[AppConstants::$HEAD2_NAME_DB] &&
                    $dbRows[AppConstants::$FINAL_URL_NAME_DB] == $ad[AppConstants::$FINAL_URL_NAME_DB] &&
                    $dbRows[AppConstants::$DESC_NAME_DB] == $ad[AppConstants::$DESC_NAME_DB] &&
                    $dbRows[AppConstants::$PATH1_NAME_DB] == $ad[AppConstants::$PATH1_NAME_DB] &&
                    $dbRows[AppConstants::$PATH2_NAME_DB] == $ad[AppConstants::$PATH2_NAME_DB]
                    ){
                    if((strtolower(trim($dbRows[AppConstants::$AVAILABILITY_NAME_DB])) == AppConstants::$AVAIL_STATUS_IN_STOCK)&&($ad[AppConstants::$STATUS_NAME_DB]==AppConstants::$CAMPAIGN_STATUS_PAUSED)){
                        // change to enabled
                        $ad[AppConstants::$STATUS_NAME_DB] = AppConstants::$CAMPAIGN_STATUS_ENABLED;
                        $retArray[] = $ad;
                    }else if((strtolower(trim($dbRows[AppConstants::$AVAILABILITY_NAME_DB])) != AppConstants::$AVAIL_STATUS_IN_STOCK)&&($ad[AppConstants::$STATUS_NAME_DB]==AppConstants::$CAMPAIGN_STATUS_ENABLED)){
                        // change to paused
                        $ad[AppConstants::$STATUS_NAME_DB] = AppConstants::$CAMPAIGN_STATUS_PAUSED;
                        $retArray[] = $ad;
                    }
                }
            }
        }
        return $retArray;
    }

    
    /**
     * returns ads to be created
     * @return type
     */
    private function getTobeCreatedAds(){
        $retArray = array();
        foreach ($this->adsOnlyList as $key => $uploadedAds){
            foreach ($uploadedAds as $value){
                $splitKey = explode('|', $key);
                $campName = $splitKey[0];
                $adgName = $splitKey[1];
                $isAdExist = false;
                
                foreach ($this->adsInAdwordsAsArray as $adGrp){
                    $adGroupDetails = $this->getAdGroupDetails($adGrp[AppConstants::$ADGROUP_ID_ADWORDS]);
                    if($adgName == $adGroupDetails[AppConstants::$NAME]){
                        if(
                            $value[AppConstants::$HEAD1_NAME_DB] == $adGrp[AppConstants::$HEAD1_NAME_DB] &&
                            $value[AppConstants::$HEAD2_NAME_DB] == $adGrp[AppConstants::$HEAD2_NAME_DB] &&
                            $value[AppConstants::$FINAL_URL_NAME_DB] == $adGrp[AppConstants::$FINAL_URL_NAME_DB] &&
                            $value[AppConstants::$DESC_NAME_DB] == $adGrp[AppConstants::$DESC_NAME_DB] &&
                            $value[AppConstants::$PATH1_NAME_DB] == $adGrp[AppConstants::$PATH1_NAME_DB] &&
                            $value[AppConstants::$PATH2_NAME_DB] == $adGrp[AppConstants::$PATH2_NAME_DB]
                            ){
                            $isAdExist = true;
                        }
                    }
                }
                if(!$isAdExist){
                    $value[AppConstants::$CAMPAIGN_NAME_DB] = $campName;
                    $value[AppConstants::$ADGROUP_NAME_DB] = $adgName;
                    $retArray[] = $value;
                }
            }
        }
        return $retArray;
    }

    /**
     * Get campaign details
     * @param type $campaignName
     * @return type
     */
    private function getCampaignDetailsWithName($campaignName){
        foreach ($this->campaignsInAdwords as $campaign){
            if(trim($campaignName)==trim($campaign[AppConstants::$NAME])){
                return $campaign;
            }
        }
    }
    
    /**
     * Get all adgroup ads
     * @param type $adGroupId
     * @return type
     */
    private function getAdGroupAds($adGroupId){
        $retArray = array();
        foreach ($this->adsInAdwordsAsArray as $ads){
            if($ads[AppConstants::$ADGROUP_ID_ADWORDS] == $adGroupId){
                $retArray[] = $ads;
            }
        }
        return $retArray;
    }

    
    /**
     * Update status of process
     */
    public function updateStatus(){
        $isDownloaded = 0;
        $prevCampaignName = '';
        $prevAdgroupName = '';
        $inArray = array();
        $inArrayUp = array();
        $inAdArray = array();
        $inAdArrayUp = array();
        foreach ($this->fullList as $dbRow){
            $statusMessage = '';
            $flag = false;
            $campaign = $this->getCampaignDetailsWithName($dbRow[AppConstants::$CAMPAIGN_NAME_DB]);
            
            if($campaign[AppConstants::$IS_DOWNLOADED] == AppConstants::$YES_INT){
                if ($campaign[AppConstants::$IS_UPDATED] == AppConstants::$YES_INT && ($prevCampaignName != $campaign[AppConstants::$NAME] )){
                    $statusMessage .= AppConstants::$CAMPAIGN_UPDATED_STATUS;
                }else{
                    $statusMessage .= AppConstants::$CAMPAIGN_SKIPPED_STATUS;
                }
            }else{
                if($campaign[AppConstants::$IS_UPDATED]==AppConstants::$NO_INT && ($prevCampaignName != $campaign[AppConstants::$NAME])){
                    $statusMessage .= AppConstants::$CAMPAIGN_CREATED_STATUS;
                    $inArray[] = $campaign[AppConstants::$ID_NAME_DB];
                }else if($campaign[AppConstants::$IS_UPDATED]==AppConstants::$NO_INT && ($prevCampaignName == $campaign[AppConstants::$NAME])){
                    $statusMessage .= AppConstants::$CAMPAIGN_SKIPPED_STATUS;
                }else if($campaign[AppConstants::$IS_UPDATED]==AppConstants::$YES_INT && !in_array($campaign[AppConstants::$ID_NAME_DB], $inArray)){
                    $statusMessage .= AppConstants::$CAMPAIGN_CREATED_STATUS;
                    $inArray[] = $campaign[AppConstants::$ID_NAME_DB];
                }else if($campaign[AppConstants::$IS_UPDATED]==AppConstants::$YES_INT && !in_array($campaign[AppConstants::$ID_NAME_DB], $inArrayUp)){
                    $statusMessage .= AppConstants::$CAMPAIGN_UPDATED_STATUS;
                    $inArrayUp[] = $campaign[AppConstants::$ID_NAME_DB];
                }else if($campaign[AppConstants::$IS_UPDATED]==AppConstants::$YES_INT && in_array($campaign[AppConstants::$ID_NAME_DB], $inArrayUp)){
                    $statusMessage .= AppConstants::$CAMPAIGN_SKIPPED_STATUS;
                }else if($campaign[AppConstants::$IS_UPDATED]==AppConstants::$YES_INT && in_array($campaign[AppConstants::$ID_NAME_DB], $inArray)){
                    $statusMessage .= AppConstants::$CAMPAIGN_SKIPPED_STATUS;
                }
            }
            
            
            $adGroup = $this->getAdGroupDetailsWithNames(trim($dbRow[AppConstants::$ADGROUP_NAME_DB]), trim($dbRow[AppConstants::$CAMPAIGN_NAME_DB]));
            if($adGroup[AppConstants::$IS_DOWNLOADED] == AppConstants::$YES_INT){
                if ($adGroup[AppConstants::$IS_UPDATED] == AppConstants::$YES_INT && ($prevAdgroupName != $adGroup[AppConstants::$NAME] )){
                    $statusMessage .= AppConstants::$ADGROUP_UPDATED_STATUS;
                }else{
                    $statusMessage .= AppConstants::$ADGROUP_SKIPPED_STATUS;
                }
            }else{
                if($adGroup[AppConstants::$IS_UPDATED]==AppConstants::$NO_INT && ($prevAdgroupName != $adGroup[AppConstants::$NAME])){
                    $statusMessage .= AppConstants::$ADGROUP_CREATED_STATUS;
                    $inAdArray[] = $adGroup[AppConstants::$ID_NAME_DB];
                }else if($adGroup[AppConstants::$IS_UPDATED]==AppConstants::$NO_INT && ($prevAdgroupName == $adGroup[AppConstants::$NAME]) && ($prevCampaignName != $adGroup[AppConstants::$CAMPAIGN_NAME_DB])){
                    $statusMessage .= AppConstants::$ADGROUP_CREATED_STATUS;
                }else if($adGroup[AppConstants::$IS_UPDATED]==AppConstants::$NO_INT && ($prevAdgroupName == $adGroup[AppConstants::$NAME]) && ($prevCampaignName == $adGroup[AppConstants::$CAMPAIGN_NAME_DB])){
                    $statusMessage .= AppConstants::$ADGROUP_SKIPPED_STATUS;
                }else if($adGroup[AppConstants::$IS_UPDATED]==AppConstants::$YES_INT && !in_array($adGroup[AppConstants::$ID_NAME_DB], $inAdArray)){
                    $statusMessage .= AppConstants::$ADGROUP_CREATED_STATUS;
                    $inAdArray[] = $adGroup[AppConstants::$ID_NAME_DB];
                }else if($adGroup[AppConstants::$IS_UPDATED]==AppConstants::$YES_INT && !in_array($adGroup[AppConstants::$ID_NAME_DB], $inAdArrayUp)){
                    $statusMessage .= AppConstants::$ADGROUP_UPDATED_STATUS;
                    $inAdArrayUp[] = $adGroup[AppConstants::$ID_NAME_DB];
                }else if($adGroup[AppConstants::$IS_UPDATED]==AppConstants::$YES_INT && in_array($adGroup[AppConstants::$ID_NAME_DB], $inAdArrayUp)){
                    $statusMessage .= AppConstants::$ADGROUP_SKIPPED_STATUS;
                }else if($adGroup[AppConstants::$IS_UPDATED]==AppConstants::$YES_INT && in_array($adGroup[AppConstants::$ID_NAME_DB], $inAdArray)){
                    $statusMessage .= AppConstants::$ADGROUP_SKIPPED_STATUS;
                }
            }
            $prevCampaignName = $campaign[AppConstants::$NAME];
            $prevAdgroupName = $adGroup[AppConstants::$NAME];
            $adGroupAds = $this->getAdGroupAds($adGroup[AppConstants::$ID_NAME_DB]);
            
            foreach ($adGroupAds as $adGroupAd){
                if(
                    $dbRow[AppConstants::$HEAD1_NAME_DB] == $adGroupAd[AppConstants::$HEAD1_NAME_DB] &&
                    $dbRow[AppConstants::$HEAD2_NAME_DB] == $adGroupAd[AppConstants::$HEAD2_NAME_DB] &&
                    $dbRow[AppConstants::$DESC_NAME_DB] == $adGroupAd[AppConstants::$DESC_NAME_DB] &&
                    $dbRow[AppConstants::$FINAL_URL_NAME_DB] == $adGroupAd[AppConstants::$FINAL_URL_NAME_DB] &&
                    $dbRow[AppConstants::$PATH1_NAME_DB] == $adGroupAd[AppConstants::$PATH1_NAME_DB] &&
                    $dbRow[AppConstants::$PATH2_NAME_DB] == $adGroupAd[AppConstants::$PATH2_NAME_DB] &&
                    $adGroupAd[AppConstants::$IS_DOWNLOADED] == AppConstants::$YES_INT
                    ){
                    //ad skipped
                    $statusMessage .= AppConstants::$AD_SKIPPED_STATUS;
                }else if(
                    $dbRow[AppConstants::$HEAD1_NAME_DB] == $adGroupAd[AppConstants::$HEAD1_NAME_DB] &&
                    $dbRow[AppConstants::$HEAD2_NAME_DB] == $adGroupAd[AppConstants::$HEAD2_NAME_DB] &&
                    $dbRow[AppConstants::$DESC_NAME_DB] == $adGroupAd[AppConstants::$DESC_NAME_DB] &&
                    $dbRow[AppConstants::$FINAL_URL_NAME_DB] == $adGroupAd[AppConstants::$FINAL_URL_NAME_DB] &&
                    $dbRow[AppConstants::$PATH1_NAME_DB] == $adGroupAd[AppConstants::$PATH1_NAME_DB] &&
                    $dbRow[AppConstants::$PATH2_NAME_DB] == $adGroupAd[AppConstants::$PATH2_NAME_DB] &&
                    $adGroupAd[AppConstants::$IS_DOWNLOADED] == AppConstants::$NO_INT
                    ){
                    // ad created
                    $statusMessage .= AppConstants::$AD_CREATED_STATUS;
                }else if(
                    $dbRow[AppConstants::$HEAD1_NAME_DB] == $adGroupAd[AppConstants::$HEAD1_NAME_DB] &&
                    $dbRow[AppConstants::$HEAD2_NAME_DB] == $adGroupAd[AppConstants::$HEAD2_NAME_DB] &&
                    $dbRow[AppConstants::$DESC_NAME_DB] == $adGroupAd[AppConstants::$DESC_NAME_DB] &&
                    $dbRow[AppConstants::$FINAL_URL_NAME_DB] == $adGroupAd[AppConstants::$FINAL_URL_NAME_DB] &&
                    $dbRow[AppConstants::$PATH1_NAME_DB] == $adGroupAd[AppConstants::$PATH1_NAME_DB] &&
                    $dbRow[AppConstants::$PATH2_NAME_DB] == $adGroupAd[AppConstants::$PATH2_NAME_DB] &&
                    $adGroupAd[AppConstants::$IS_DOWNLOADED] == AppConstants::$UPDATED_INT
                    ){
                    // ad updated
                    $statusMessage .= AppConstants::$AD_UPDATED_STATUS;
                }
            }
            
            $statusMessage .= $this->updateKeywordStatus($adGroup, $dbRow);
            
            $this->dbObj->updateExtendedAdsStatus($dbRow[AppConstants::$ID_NAME_DB], $statusMessage, ' ');
        }
    }
    
    /**
     * Update keywords
     * @param type $adGroup
     * @param type $dbRow
     */
    private function updateKeywordStatus($adGroup, $dbRow){
        $statusMessage = '';
        $key1 = false;
        $key2 = false;
        $key3 = false;
        $key4 = false;
        foreach ($adGroup[AppConstants::$KEY_WORD] as $keyword){
            if($keyword[AppConstants::$KEY_WORD_NAME] == $dbRow[AppConstants::$KEY1_NAME_DB]){
                
                if(!$this->searchForId($keyword[AppConstants::$KEY_WORD_NAME], $this->totalKeywordsExisting))
                {
                $statusMessage .= AppConstants::$KEYWORD1_CREATED_STATUS;
                $key1 = true;
                }
                else
                {
                    $statusMessage .= AppConstants::$KEYWORD1_SKIPPED_STATUS;
                }
                
                
            }
            if($keyword[AppConstants::$KEY_WORD_NAME] == $dbRow[AppConstants::$KEY2_NAME_DB]){
                
                if(!$this->searchForId($keyword[AppConstants::$KEY_WORD_NAME], $this->totalKeywordsExisting))
                {
                $statusMessage .= AppConstants::$KEYWORD2_CREATED_STATUS;
                $key2 = true;
                }
                else
                {
                    $statusMessage .= AppConstants::$KEYWORD2_SKIPPED_STATUS;
                }
            }
            if($keyword[AppConstants::$KEY_WORD_NAME] == $dbRow[AppConstants::$KEY3_NAME_DB]){
                
                if(!$this->searchForId($keyword[AppConstants::$KEY_WORD_NAME], $this->totalKeywordsExisting))
                {
                $statusMessage .= AppConstants::$KEYWORD3_CREATED_STATUS;
                $key3 = true;
                }
                else
                {
                    $statusMessage .= AppConstants::$KEYWORD2_SKIPPED_STATUS;
                }
            }
            if($keyword[AppConstants::$KEY_WORD_NAME] == $dbRow[AppConstants::$KEY4_NAME_DB]){
                
                if(!$this->searchForId($keyword[AppConstants::$KEY_WORD_NAME], $this->totalKeywordsExisting))
                {
                $statusMessage .= AppConstants::$KEYWORD4_CREATED_STATUS;
                $key4 = true;
                }
                else
                {
                    $statusMessage .= AppConstants::$KEYWORD4_SKIPPED_STATUS;
                }
            }
        }
//         if(!$key1){
//             $statusMessage .= AppConstants::$KEYWORD1_SKIPPED_STATUS;
//         }
//         if(!$key2){
//             $statusMessage .= AppConstants::$KEYWORD2_SKIPPED_STATUS;
//         }
//         if(!$key3){
//             $statusMessage .= AppConstants::$KEYWORD3_SKIPPED_STATUS;
//         }
//         if(!$key4){
//             $statusMessage .= AppConstants::$KEYWORD4_SKIPPED_STATUS;
//         }
        return $statusMessage;
    }
    
    private function searchForId($id, $array) {
        foreach ($array as $key => $val) {
            if ($val['keyword'] === $id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get all to be updated campaigns
     * @return type
     */
    private function getToBeUpdatedCampaigns(){
        $this->campaignsInAdwords;
        $this->fullList;
        $retArray = array();
        foreach ($this->fullList as $dbRow){
            if(
                    (array_key_exists(trim($dbRow[AppConstants::$CAMPAIGN_NAME_DB]),$this->campaignsInAdwords))&&
                    ($this->campaignsInAdwords[$dbRow[AppConstants::$CAMPAIGN_NAME_DB]][AppConstants::$AMOUNT]!=$dbRow[AppConstants::$BUDGET_NAME_DB]*AppConstants::$CAMPAIGN_BID_MULTIPLIER)&&
                    (!array_key_exists(trim($dbRow[AppConstants::$CAMPAIGN_NAME_DB]), $retArray))
                ){
                $retArray[trim($dbRow[AppConstants::$CAMPAIGN_NAME_DB])] = array(
                    AppConstants::$ID_NAME_DB => trim($this->campaignsInAdwords[$dbRow[AppConstants::$CAMPAIGN_NAME_DB]][AppConstants::$ID_NAME_DB]),
                    AppConstants::$BUDGET_NAME_DB => trim($dbRow[AppConstants::$BUDGET_NAME_DB]),
                );
            }
        }
        return $retArray;
    }
    
    /**
     * Get to be updated ad groups
     * @return type
     */
    private function getToBeUpdatedAdGroups(){
        $retArray = array();
        foreach ($this->fullList as $dbRow){
            $adGroup = $this->getAdGroupDetailsWithNames($dbRow[AppConstants::$ADGROUP_NAME_DB], $dbRow[AppConstants::$CAMPAIGN_NAME_DB]);
            if(
                (($dbRow[AppConstants::$BID_NAME_DB]*AppConstants::$CAMPAIGN_BID_MULTIPLIER)!=$adGroup[AppConstants::$BID_NAME_DB]) && 
                (!array_key_exists(trim($adGroup[AppConstants::$ID_NAME_DB]), $retArray))
                ){
                $retArray[$adGroup[AppConstants::$ID_NAME_DB]] = array(
                    AppConstants::$ID_NAME_DB => $adGroup[AppConstants::$ID_NAME_DB],
                    AppConstants::$BID_NAME_DB => $dbRow[AppConstants::$BID_NAME_DB],
                );
            }
        }
        return $retArray;
    }

    /**
     * This method initiate spread sheet data process
     */
    public function processData(){
       
        $toBeCreatedCamp = $this->getNonExistingCampaigns();
        if(count($toBeCreatedCamp)>0){
            $this->createCampaignsBulk($toBeCreatedCamp);
        }
        $toBeUpdatedCamp = $this->getToBeUpdatedCampaigns();
        if(count($toBeUpdatedCamp)>0){
            $this->updateBulkCampaigns($toBeUpdatedCamp);
        }
        
        $toBeCreatedAdGroups = $this->getNonExistingAdGroups();
        if(count($toBeCreatedAdGroups)>0){
            $this->createBulkAdgroups($toBeCreatedAdGroups);
        }
        $toBeUpdatedAdGroups = $this->getToBeUpdatedAdGroups();
        if(count($toBeUpdatedAdGroups)>0){
            $this->updateAdwordsBidBulk($toBeUpdatedAdGroups);
        }
        
        $adGroupIds = $this->getAdGroupIds();
        
        // get to be created ads
        $adsToBeCreated = $this->getTobeCreatedAds();
        if(count($adsToBeCreated)>0){
            $this->createBulkExtendedTextAds($adsToBeCreated);
        }
        
        $toBeUpdatedAds = $this->getToBeUpdatedAds();
        if(count($toBeUpdatedAds)>0){
            $this->updateExistingAdsBulk($toBeUpdatedAds);
        }
        
        $this->totalKeywordsExisting = $this->downloadAllKeywordsInGivenAdgroups($adGroupIds);
        
        
        $this->addBulkExtendedKeywords($this->AdKeywordsList);
        echo '<pre>';
        print_r($this->campaignsInAdwords);
        print_r($this->adgroupsInAdwords);
        print_r($this->AdKeywordsList);
        print_r($this->totalKeywordsExisting);
        echo '</pre>';
        
    }
    
    
    /**
     * Get to be created ad groups
     * @return type
     */
    private function getNonExistingAdGroups(){
        $retArray = array();
        foreach($this->adGroupList as $campaignName => $uploadedCampaigns){
            foreach($uploadedCampaigns as $uploadedAdg){
                $isExist = false;
                foreach ($this->adgroupsInAdwords as $adGroups){
                    if($adGroups[AppConstants::$NAME]==$uploadedAdg[AppConstants::$ADGROUP_NAME_DB]&&($adGroups[AppConstants::$CAMPAIGN_NAME_DB]==$campaignName)){
                        $isExist = true;
                    }
                }
                if(!$isExist){
                    $retArray[$campaignName.'|'.$uploadedAdg[AppConstants::$ADGROUP_NAME_DB]] = array(
                        AppConstants::$CAMPAIGN_NAME_DB => $campaignName,
                        AppConstants::$ADGROUP_NAME_DB => $uploadedAdg[AppConstants::$ADGROUP_NAME_DB],
                        AppConstants::$BID_NAME_DB => $uploadedAdg[AppConstants::$BID_NAME_DB],
                    );
                }
            }
        }
        return $retArray;
    }
    
    /**
     * Get to be created campaigns
     * @return type
     */
    private function getNonExistingCampaigns(){
        $retArray = array();
        foreach ($this->fullList as $key => $value){
            if((!array_key_exists(trim($value[AppConstants::$CAMPAIGN_NAME_DB]),$this->campaignsInAdwords))&&(!array_key_exists(trim($value[AppConstants::$CAMPAIGN_NAME_DB]), $retArray))){
                $retArray[trim($value[AppConstants::$CAMPAIGN_NAME_DB])] = array(
                    AppConstants::$CAMPAIGN_NAME_DB => trim($value[AppConstants::$CAMPAIGN_NAME_DB]),
                    AppConstants::$BUDGET_NAME_DB => trim($value[AppConstants::$BUDGET_NAME_DB]),
                );
            }
        }
        return $retArray;
    }

    

    /**
     * Removes duplicate and returns array
     * @param type $inputArray
     * @param type $type
     * @return type
     */
    public function getUnique($inputArray,$type){
        $returnArray = array();
        foreach ($inputArray as $values){
            if(!in_array($values[$type], $returnArray)){
                $returnArray[] = $values[$type];
            }
        }
        return $returnArray;
    }


    /**
     * Create campaign
     * @param type $campaign_name
     * @param type $budgetid
     * @return type
     */
    public function createCampaignsBulk($campaign_nameArray)
    {
        $errorMessage = '';
        $campaignId = 0;
        $campaignService = $this->CampaignService;
        $operations = array();
        foreach ($campaign_nameArray as $campaigns){
            $campaign = new Campaign();
            $campaign->name = addslashes(trim($campaigns[AppConstants::$CAMPAIGN_NAME_DB]));
            // The advertisingChannelType is what makes this a Shopping campaign
            $campaign->advertisingChannelType = AppConstants::$CAMPAIGN_TYPE_SEARCH;
            $campaign->status = AppConstants::$CAMPAIGN_STATUS_ENABLED;
            // Set dedicated budget (required).
            $campaign->budget = new Budget();
            $budgetid = $this->status_shared_budget($campaigns[AppConstants::$BUDGET_NAME_DB]);
            $campaign->budget->budgetId = $budgetid;

            // Set bidding strategy (required).
            $biddingStrategyConfiguration = new BiddingStrategyConfiguration();
            $biddingStrategyConfiguration->biddingStrategyType = AppConstants::$BID_STRATEGY_TYPE_MAN_CPC;

            $campaign->biddingStrategyConfiguration = $biddingStrategyConfiguration;

            
            // Create operation.
            $operation = new CampaignOperation();
            $operation->operand = $campaign;
            $operation->operator = AppConstants::$CREATE_OPERAND;
            $operations[] = $operation;
        }
        
        try{
            $result = $campaignService->mutate($operations);
            foreach ($result->value as $createdCampaign){

                $this->campaignsInAdwords[$createdCampaign->name] = array(
                    AppConstants::$NAME => $createdCampaign->name,
                    AppConstants::$ID_NAME_DB => $createdCampaign->id,
                    AppConstants::$BUDGET_ID => $createdCampaign->budget->budgetId,
                    AppConstants::$AMOUNT => $createdCampaign->budget->amount->microAmount,
                    AppConstants::$IS_DOWNLOADED => AppConstants::$NO_INT,
                    AppConstants::$IS_UPDATED => AppConstants::$NO_INT,
                );
            }
        }
        catch(Exception $e){
            $errorMessage = 'Error :-'.$e->getMessage();
            $this->dbObj->addToTestTable($e->getMessage());
        }
        
    }
    

    
    /**
     * Update bulk number of campaigns
     * @global string $error
     * @param type $campaigns
     * @param type $campaignid
     * @param type $budgetid
     */
    public function updateBulkCampaigns($campaigns)
    {
        global $error;
        $campaignService = $this->CampaignService;
        $operations = array();
        foreach ($campaigns as $singleCampaign){
            $campaign = new Campaign();
            $campaign->id = $singleCampaign[AppConstants::$ID_NAME_DB];
            $campaign->budget = new Budget();
            $campaign->budget->budgetId = $this->status_shared_budget($singleCampaign[AppConstants::$BUDGET_NAME_DB]);
            $biddingStrategyConfiguration = new BiddingStrategyConfiguration();
            $biddingStrategyConfiguration->biddingStrategyType = AppConstants::$BID_STRATEGY_TYPE_MAN_CPC;
    
            $campaign->biddingStrategyConfiguration = $biddingStrategyConfiguration;
            $operation = new CampaignOperation();
            $operation->operand = $campaign;
            $operation->operator = AppConstants::$UPDATE_OPERAND;
            $operations[] = $operation;
        }
        
        try{
            $result = $campaignService->mutate($operations);
            foreach ($result->value as $createdCampaign){
                $this->campaignsInAdwords[$createdCampaign->name][AppConstants::$BUDGET_ID] = $createdCampaign->budget->budgetId;
                $this->campaignsInAdwords[$createdCampaign->name][AppConstants::$AMOUNT] = $createdCampaign->budget->amount->microAmount;
                $this->campaignsInAdwords[$createdCampaign->name][AppConstants::$IS_UPDATED] = AppConstants::$YES_INT;

//                $this->campaignsInAdwords[$createdCampaign->name] = array(
//                    AppConstants::$NAME => $createdCampaign->name,
//                    AppConstants::$ID_NAME_DB => $createdCampaign->id,
//                    AppConstants::$BUDGET_ID => $createdCampaign->budget->budgetId,
//                    AppConstants::$AMOUNT => $createdCampaign->budget->amount->microAmount,
//                    AppConstants::$IS_DOWNLOADED => AppConstants::$UPDATED_INT,
//                    AppConstants::$IS_UPDATED => AppConstants::$UPDATED_INT,
//                );
            }
        }catch(Exception $e){
            $error[] = 'Error :-'.$e->getMessage();
            $this->dbObj->addToTestTable($e->getMessage());
        }
        
    }
    
    /**
     * Get budget id
     * @global string $error
     * @param type $budgets
     * @return type
     */
    public function status_shared_budget($budgets)
    {
        global $error;
        $budgetService = $this->BudgetService;
        $budgetId = 0;
        
        if(!array_key_exists($budgets, $this->budgetsList)){
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
            catch(Exception $e){
                $error[] = 'Error :-'.$e->getMessage();
                $this->dbObj->addToTestTable($e->getMessage());
            }

            if (isset($page->entries)) {
                foreach ($page->entries as $budget) {
                    $budgetId = $budget->budgetId;
                }
            }
            $this->budgetsList[$budgets] = $budgetId;
        }else{
            $budgetId = $this->budgetsList[$budgets];
        }
        
        if ($budgetId == 0) {
            $response = $this->createNewBudget($budgets);
            $budgetId = $response[0];
            
        }
        return $budgetId;
    }
    
    /**
     * Creates new budget
     * @param type $budgets
     * @return type
     */
    public function createNewBudget($budgets){
        $budgetId = 0;
        $error = array();
        $budgetService = $this->BudgetService;
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
        catch(Exception $e){
            $error[] = 'Error :-'.$e->getMessage();
            $this->dbObj->addToTestTable($e->getMessage());
        }
        $budgetz = $result->value[0];
        $budgetId = $budgetz->budgetId;
        return array($budgetId,$error);
    }
    
    /**
     * Update adgroup bid in bulk
     * @param type $adGroups
     */
    private function updateAdwordsBidBulk($adGroups){
        $adGroupService = $this->AdGroupService;
        $operations = array();
        foreach ($adGroups as $singleAdGroup){
            $adGroup = new AdGroup();
            $adGroup->id = $singleAdGroup[AppConstants::$ID_NAME_DB];
            $bid = new CpcBid();
            $bid->bid =  new Money($singleAdGroup[AppConstants::$BID_NAME_DB] * AppConstants::$CAMPAIGN_BID_MULTIPLIER);
            $biddingStrategyConfiguration = new BiddingStrategyConfiguration();
            $biddingStrategyConfiguration->bids[] = $bid;
            $adGroup->biddingStrategyConfiguration = $biddingStrategyConfiguration;
            $operation = new AdGroupOperation();
            $operation->operand = $adGroup;
            $operation->operator = AppConstants::$UPDATE_OPERAND;
            
            $operations[] = $operation;
        }
        try{
            $result = $adGroupService->mutate($operations);
            foreach ($result->value as $adGroupSingle){
                $this->adgroupsInAdwords[$adGroupSingle->id][AppConstants::$IS_UPDATED] = AppConstants::$YES_INT;
                $this->adgroupsInAdwords[$adGroupSingle->id][AppConstants::$BID_NAME_DB] = $adGroupSingle->biddingStrategyConfiguration->bids[0]->bid->microAmount;
//                $this->adgroupsInAdwords[$adGroupSingle->id] = array(
//                        AppConstants::$ID_NAME_DB => $adGroupSingle->id,
//                        AppConstants::$NAME => $adGroupSingle->name,
//                        AppConstants::$CAMPAIGN_ID_VAR => $adGroupSingle->campaignId,
//                        AppConstants::$CAMPAIGN_NAME_DB => $adGroupSingle->campaignName,
//                        AppConstants::$BID_NAME_DB => $adGroupSingle->biddingStrategyConfiguration->bids[0]->bid->microAmount,
//                        AppConstants::$IS_DOWNLOADED => AppConstants::$UPDATED_INT,
//                    );
            }
        }
        catch(Exception $e){
            $this->dbObj->addToTestTable($e->getMessage());
        }
        
    }

    /**
     * create ad groups in bulk
     * @param type $adGroupList
     * @return type
     */
    private function createBulkAdgroups($adGroupList)
    {
        $errorMessage = '';
        $adGroupId = 0;
        $adGroupService = $this->AdGroupService;
        $operations = array();
        
        foreach ($adGroupList as $adGroupArray){
            $campaignId = $this->campaignsInAdwords[$adGroupArray[AppConstants::$CAMPAIGN_NAME_DB]][AppConstants::$ID_NAME_DB];
            // Create ad group.
            $adGroup = new AdGroup();
            $adGroup->campaignId = $campaignId;
            $adGroup->name = trim($adGroupArray[AppConstants::$ADGROUP_NAME_DB]);
            
            // Set bids (required).
            $bid = new CpcBid();
            $bid->bid = new Money($adGroupArray[AppConstants::$BID_NAME_DB] * AppConstants::$CAMPAIGN_BID_MULTIPLIER);
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
            $operation->operator = AppConstants::$CREATE_OPERAND;
            $operations[] = $operation;
        }
        
        // Make the mutate request.
        try{
            $result = $adGroupService->mutate($operations);
            foreach ($result->value as $createdCampaign){
            
                $this->adgroupsInAdwords[$createdCampaign->id] = array(
                    AppConstants::$NAME => $createdCampaign->name,
                    AppConstants::$ID_NAME_DB => $createdCampaign->id,
                    AppConstants::$BID_NAME_DB => $createdCampaign->biddingStrategyConfiguration->bids[0]->bid->microAmount,
                    AppConstants::$CAMPAIGN_NAME_DB => $createdCampaign->campaignName,
                    AppConstants::$CAMPAIGN_ID_VAR => $createdCampaign->campaignId,
                    AppConstants::$IS_DOWNLOADED => AppConstants::$NO_INT,
                    AppConstants::$IS_UPDATED => AppConstants::$NO_INT,
                );
            }
        }
        catch(Exception $e){
            $this->dbObj->addToTestTable($e->getMessage());
            $errorMessage = $e->getMessage();
        }
        return array($adGroupId,$errorMessage);
    }

    /**
     * Create bulk extended ads
     * @global string $error
     * @param type $ads
     * @return type
     */
    public function createBulkExtendedTextAds($ads){
        global $error;
        $all_ads = array();
        // Get the service, which loads the required classes.
        $adGroupAdService = $this->AdGroupAdService;
        $ads = array_values($ads);
        $operations = array();
        $count = count($ads);
        $page = ceil($count/AppConstants::$MUTATE_LIMIT_ADS);
        
        for($i=0;$i<$count;$i++){
            
            $ad = $ads[$i];
            $adGroupDetails = $this->getAdGroupDetailsWithNames($ad[AppConstants::$ADGROUP_NAME_DB], $ad[AppConstants::$CAMPAIGN_NAME_DB]);

            // Create an expanded text ad.
            $expandedTextAd = new ExpandedTextAd();
            $expandedTextAd->headlinePart1 = $ad[AppConstants::$HEAD1_NAME_DB];
            $expandedTextAd->headlinePart2 = $ad[AppConstants::$HEAD2_NAME_DB];
            $expandedTextAd->description = $ad[AppConstants::$DESC_NAME_DB];
            $expandedTextAd->finalUrls = array(
                $ad[AppConstants::$FINAL_URL_NAME_DB]
            );
            $expandedTextAd->path1 = $ad[AppConstants::$PATH1_NAME_DB];
            $expandedTextAd->path2 = $ad[AppConstants::$PATH2_NAME_DB];

            // Create ad group ad.
            $adGroupAd = new AdGroupAd();
            $adGroupAd->adGroupId = $adGroupDetails[AppConstants::$ID_NAME_DB];
            $adGroupAd->ad = $expandedTextAd;

            // Set additional settings (optional).
            if (strtolower(trim($ad[AppConstants::$AVAILABILITY_NAME_DB])) == AppConstants::$AVAIL_STATUS_IN_STOCK) {
                $adGroupAd->status = AppConstants::$CAMPAIGN_STATUS_ENABLED;
            } else {
                $adGroupAd->status = AppConstants::$CAMPAIGN_STATUS_PAUSED;
            }


            // Create operation.
            $operation = new AdGroupAdOperation();
            $operation->operand = $adGroupAd;
            $operation->operator = 'ADD';

            $operations[] = $operation;
             
            if(((($i+1) % AppConstants::$MUTATE_LIMIT_ADS)==0 && $i!=0)||(($i+1) == $count)){
            // Make the mutate request.
                try{
                    $result = $adGroupAdService->mutate($operations);
                    foreach ($result->value as $adGroupAd){
                        $this->adsInAdwordsAsArray[$adGroupAd->ad->id] =  array(
                            AppConstants::$ID_NAME_DB => $adGroupAd->ad->id,
                            AppConstants::$STATUS_NAME_DB => $adGroupAd->status,
                            AppConstants::$HEAD1_NAME_DB => $adGroupAd->ad->headlinePart1,
                            AppConstants::$HEAD2_NAME_DB => $adGroupAd->ad->headlinePart2,
                            AppConstants::$DESC_NAME_DB => $adGroupAd->ad->description,
                            AppConstants::$FINAL_URL_NAME_DB => $adGroupAd->ad->finalUrls[0],
                            AppConstants::$PATH1_NAME_DB => $adGroupAd->ad->path1,
                            AppConstants::$PATH2_NAME_DB => $adGroupAd->ad->path2,
                            AppConstants::$ADGROUP_ID_ADWORDS => $adGroupAd->adGroupId,
                            AppConstants::$IS_DOWNLOADED => AppConstants::$NO_INT,
                        );
                    }       
                }
                catch(Exception $e){
                $error[] = 'Error :-'.$e->getMessage();
                $this->dbObj->addToTestTable($e->getMessage());
            }
                $operations = array();
            }
        }
       return $this->adsInAdwordsAsArray;
        
    }
    
  

    /**
     * Create kewords as bulk
     * @global string $error
     * @param type $keyWordsArray
     * @return type
     */
    public function addBulkExtendedKeywords($keyWordsArray){
        global $error;
        $adGroupCriterionService = $this->AdGroupCriterionService;
        $all_ads = array();
        $operations = array();
        foreach ($keyWordsArray as $key => $value){
            $splitKey = explode('|', $key);
            $campName = $splitKey[0];
            $adgName = $splitKey[1];
            $adGroupDetails = $this->getAdGroupDetailsWithNames($adgName, $campName);
            foreach ($value as $keywordSingle){
                foreach($keywordSingle as $k){
                    // Create keyword criterion.
                    $keyword = new Keyword();
                    $keytext = trim($k);
                    $keyword->text = $keytext;
                    $keyword->matchType = 'BROAD';
                    
                    // Create biddable ad group criterion.
                    $adGroupCriterion = new BiddableAdGroupCriterion();
                    $adGroupCriterion->adGroupId = $adGroupDetails[AppConstants::$ID_NAME_DB];
                    $adGroupCriterion->criterion = $keyword;

                    // Create operation.
                    $operation = new AdGroupCriterionOperation();
                    $operation->operand = $adGroupCriterion;
                    $operation->operator = 'ADD';
                    $operations[] = $operation;
                }
            }
        }
        
        // Make the mutate request.
        try{
            $result = $adGroupCriterionService->mutate($operations);
            foreach ($result->value as $v){
                $this->adgroupsInAdwords[$v->adGroupId][AppConstants::$KEY_WORD][$v->criterion->id] = array(
                    AppConstants::$KEY_WORD_NAME => $v->criterion->text,
                    AppConstants::$KEY_WORD_MATCH_TYPE_NAME => $v->criterion->matchType,
                    AppConstants::$ID_NAME_DB => $v->criterion->id,
                    AppConstants::$IS_DOWNLOADED=>AppConstants::$NO_INT
                );
            }
        }
        catch(Exception $e){
                $error[] = 'Error :-'.$e->getMessage();
                $this->dbObj->addToTestTable($e->getMessage());
            }
        return $this->adgroupsInAdwords;
    }
  


    /**
     * get all extended ads per adgroups
     * @param type $adGroupIdArray
     * @return type
     */
    public function getAllExistingEtads($adGroupIdArray){
        $error = '';
        // Get the service, which loads the required classes.
        $adGroupAdService = $this->AdGroupAdService;
        // Create selector.
        $selector = new Selector();
        $selector->fields = array(
            AppConstants::$ID_NAME_ADWORDS,
            AppConstants::$STATUS_NAME_ADWORDS,
            AppConstants::$HEAD1_NAME_ADWORDS,
            AppConstants::$HEAD2_NAME_ADWORDS,
            AppConstants::$DESC_NAME_ADWORDS,
            AppConstants::$FINAL_URL_NAME_ADWORDS,
            AppConstants::$PATH1_NAME_ADWORDS,
            AppConstants::$PATH2_NAME_ADWORDS,
            AppConstants::$ADGROUP_ID_ADWORDS,
        );
        $selector->ordering[] = new OrderBy('Id', 'ASCENDING');
    
        // Create predicates.
        $selector->predicates[] = new Predicate(AppConstants::$ADGROUP_ID_ADWORDS, 'IN', $adGroupIdArray);
        $selector->predicates[] = new Predicate('AdType', 'IN', array(
            'EXPANDED_TEXT_AD'
        ));
        
        // Create paging controls.
        $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
    
        do {
            // Make the get request.
            try{
                $page = $adGroupAdService->get($selector);
                if (isset($page->entries)) {
                    foreach ($page->entries as $adGroupAd) {

                        $this->adsInAdwordsAsArray[$adGroupAd->ad->id] =  array(
                            AppConstants::$ID_NAME_DB => $adGroupAd->ad->id,
                            AppConstants::$STATUS_NAME_DB => $adGroupAd->status,
                            AppConstants::$HEAD1_NAME_DB => $adGroupAd->ad->headlinePart1,
                            AppConstants::$HEAD2_NAME_DB => $adGroupAd->ad->headlinePart2,
                            AppConstants::$DESC_NAME_DB => $adGroupAd->ad->description,
                            AppConstants::$FINAL_URL_NAME_DB => $adGroupAd->ad->finalUrls[0],
                            AppConstants::$PATH1_NAME_DB => $adGroupAd->ad->path1,
                            AppConstants::$PATH2_NAME_DB => $adGroupAd->ad->path2,
                            AppConstants::$ADGROUP_ID_ADWORDS => $adGroupAd->adGroupId,
                            AppConstants::$IS_DOWNLOADED => AppConstants::$YES_INT,
                        );
                    }
                }
            }
            catch(Exception $e){
                $error[] = 'Error :-'.$e->getMessage();
                $this->dbObj->addToTestTable($e->getMessage());
            }
            // Display results.
            
    
            // Advance the paging index.
            $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
        } while ($page->totalNumEntries > $selector->paging->startIndex);
        return array($this->adsInAdwordsAsArray,$error);
    }

    /**
     * Update bulk ads
     * @global string $error
     * @param type $adGroupIds
     * @param type $ads
     * @param type $flag
     * @return type
     */
    public function updateExistingAdsBulk($updatingAds)
    {
        global $error;
        $adGroupAdService = $this->AdGroupAdService;
        $operations = array();
        foreach ($updatingAds as $updatingAd){
            
            $ad = new Ad();
            $ad->id = $updatingAd[AppConstants::$ID_NAME_DB];
            $adGroupAd = new AdGroupAd();
            $adGroupAd->adGroupId = $updatingAd[AppConstants::$ADGROUP_ID_ADWORDS];
            $adGroupAd->status = $updatingAd[AppConstants::$STATUS_NAME_DB];
            $adGroupAd->ad = $ad;
            $operation = new AdGroupAdOperation();
            $operation->operand = $adGroupAd;
            $operation->operator = 'SET';
            $operations[] = $operation;
        }
        
        try{
            $result = $adGroupAdService->mutate($operations);
            foreach ($result->value as $adGroupAd){
                $this->adsInAdwordsAsArray[$adGroupAd->ad->id] =  array(
                    AppConstants::$ID_NAME_DB => $adGroupAd->ad->id,
                    AppConstants::$STATUS_NAME_DB => $adGroupAd->status,
                    AppConstants::$HEAD1_NAME_DB => $adGroupAd->ad->headlinePart1,
                    AppConstants::$HEAD2_NAME_DB => $adGroupAd->ad->headlinePart2,
                    AppConstants::$DESC_NAME_DB => $adGroupAd->ad->description,
                    AppConstants::$FINAL_URL_NAME_DB => $adGroupAd->ad->finalUrls[0],
                    AppConstants::$PATH1_NAME_DB => $adGroupAd->ad->path1,
                    AppConstants::$PATH2_NAME_DB => $adGroupAd->ad->path2,
                    AppConstants::$ADGROUP_ID_ADWORDS => $adGroupAd->adGroupId,
                    AppConstants::$IS_DOWNLOADED => AppConstants::$UPDATED_INT,
                );
            }
        }
        catch(Exception $e){
                $error[] = 'Error :-'.$e->getMessage();
                $this->dbObj->addToTestTable($e->getMessage());
            }
        return $this->adsInAdwordsAsArray;
    }

    /**
     * Get all campaigns in adwords
     * @return type
     */
    public function download_all_campaign()
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
                    
                    $all_campaigns[$campaign->name] = array(
                        AppConstants::$NAME => $campaign->name,
                        AppConstants::$ID_NAME_DB => $campaign->id,
                        AppConstants::$BUDGET_ID => $campaign->budget->budgetId,
                        AppConstants::$AMOUNT => $campaign->budget->amount->microAmount,
                        AppConstants::$IS_DOWNLOADED => AppConstants::$YES_INT,
                        AppConstants::$IS_UPDATED => AppConstants::$NO_INT,
                    );
                }
            } 
        
            // Advance the paging index.
            $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
        } while ($page->totalNumEntries > $selector->paging->startIndex);
        return $all_campaigns;
        
    }
    
    /**
     * Download all adgroups
     * @param type $campaignIdArray
     * @return type
     */
    public function downloadAllAdgroupsInGivenCampaigns($campaignIdArray)
    {
        $adGroupService = $this->AdGroupService;
        $all_adgroups = array();
        // Create selector.
        $selector = new Selector();
        $selector->fields = array('Id', 'Name','CampaignId','CampaignName','CpcBid');
        $selector->ordering[] = new OrderBy('Name', 'ASCENDING');
        
        // Create predicates.
        $selector->predicates[] =
        new Predicate('CampaignId', 'IN', $campaignIdArray);
        
        // Create paging controls.
        $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
        
        do {
            try{
                // Make the get request.
                $page = $adGroupService->get($selector);

                // Display results.
                if (isset($page->entries)) {
                    foreach ($page->entries as $adGroup) {

                        $all_adgroups[$adGroup->id] = array(
                            AppConstants::$ID_NAME_DB => $adGroup->id,
                            AppConstants::$NAME => $adGroup->name,
                            AppConstants::$CAMPAIGN_ID_VAR => $adGroup->campaignId,
                            AppConstants::$CAMPAIGN_NAME_DB => $adGroup->campaignName,
                            AppConstants::$BID_NAME_DB => $adGroup->biddingStrategyConfiguration->bids[0]->bid->microAmount,
                            AppConstants::$IS_DOWNLOADED => AppConstants::$YES_INT,
                            AppConstants::$IS_UPDATED => AppConstants::$NO_INT,
                        );

                    }
                } 

                // Advance the paging index.
                $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
            } catch (Exception $ex) {
                return array();
            }
            
        } while ($page->totalNumEntries > $selector->paging->startIndex);
        return $all_adgroups;
    }
    
    /**
     * 
     * @param unknown $campaignIdArray
     * @return multitype:multitype:NULL number
     */
    public function downloadAllKeywordsInGivenAdgroups($adgroupIdArray)
    {
        $adGroupService = $this->AdGroupCriterionService;
        $all_adgroups = array();
        // Create selector.
        $selector = new Selector();
        $selector->fields = array('Id', 'CriteriaType', 'KeywordMatchType','KeywordText');
        $selector->ordering[] = new OrderBy('Id', 'ASCENDING');
    
        // Create predicates.
        $selector->predicates[] = new Predicate('AdGroupId', 'IN', $adgroupIdArray);
    
        // Create paging controls.
        $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
    
        do {
            // Make the get request.
            $page = $adGroupService->get($selector);
    
            // Display results.
            if (isset($page->entries)) {
                foreach ($page->entries as $adGroupCriterion) {
    
                    $all_adgroups[$adGroupCriterion->criterion->id] = array(
                    AppConstants::$KEY_WORD_NAME => $adGroupCriterion->criterion->text,
                    AppConstants::$KEY_WORD_MATCH_TYPE_NAME => $adGroupCriterion->criterion->matchType,
                    AppConstants::$ID_NAME_DB => $adGroupCriterion->criterion->id,
                    AppConstants::$ADGROUP_ID_ADWORDS => $adGroupCriterion->adGroupId,
                    AppConstants::$IS_DOWNLOADED=>AppConstants::$YES_INT                        
                    );
                     
                }
            }
    
            // Advance the paging index.
            $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
        } while ($page->totalNumEntries > $selector->paging->startIndex);
        return $all_adgroups;
    }
}