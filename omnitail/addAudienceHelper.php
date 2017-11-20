<?php
class addAudienceHelper
{
    private $campaignId;
    private $campaignName;
    private $adgroupId;
    private $adgroupName;
    private $audienceId;
    private $audienceName;
    private $targetingSetting;
    private $bidModifier;
    public function __construct($value, $audience)
    {
        if (count($value) > 0) {
            $this->campaignId = $value['CampaignId'];
            //$this->campaignName = $value['CampaignName'];
            $this->adgroupId = $value['AdgroupId'];
            //$this->adgroupName = $value['AdgroupName'];
            $this->audienceId = $audience['AudienceID'];
            $this->audienceName = $audience['AudienceName'];
            $this->targetingSetting = $audience['TargetSetting'];
            $this->bidModifier = $audience['BidAdj'];
            
        }
    }
    function bidConversion($bid)
    {
        if (strpos($bid, '-') !== false) {
            $rest = 1-(0.01 * (- 1) * $bid);
        }else if(abs($bid) == 0){
            $rest = 1;
        } else {
            $rest = 1 + (0.01 * $bid);
        }
        return $rest;
    }
    public function splitCampaingNameAudienceAndId($ret) {
        $campaignIdArray = array();
        $audienceArray = array();
        
        for ($x = 0, $y = count($ret); $x < $y; $x ++) {
            if($ret[$x]['CampaignId']!=''){
                $campaignIdArray[] = array($ret[$x]['CampaignId'],$ret[$x]['CampaignName'],$ret[$x]['AdGroupId'],$ret[$x]['AdGroupName']);
            }
            
            if (trim($ret[$x]['AudienceId']) !== '') {
               $audienceArray[] = array($ret[$x]['AudienceId'],$ret[$x]['AudienceName'],$ret[$x]['BidAdj'],$ret[$x]['TargetSetting']);
            }
        }
        $audienceArray = array_map("unserialize", array_unique(array_map("serialize", $audienceArray)));
        return array($campaignIdArray,  $audienceArray);
    }
    function adAudienceAdgroup(AdWordsUser $user){
        
        $adGroupCriterionService = $user->GetService('AdGroupCriterionService', ADWORDS_VERSION);
        $adGroupService = $user->GetService('AdGroupService',ADWORDS_VERSION);
        $adwordsUserListService = $user->GetService('AdwordsUserListService',ADWORDS_VERSION);
        $operations = array();
        $criterion = new CriterionUserList();
        $criterion->userListId = $this->audienceId;
        
        
        

       
        // Create biddable ad group criterion.
        $adGroupCriterion = new BiddableAdGroupCriterion();
        $adGroupCriterion->adGroupId = $this->adgroupId;
        $adGroupCriterion->criterion = $criterion;
        $adGroupCriterion->bidModifier  =$this->bidConversion($this->bidModifier);
        
        
        $target = new TargetingSettingDetail();
        $target->criterionTypeGroup = 'USER_INTEREST_AND_LIST';
        $target->targetAll = strtolower($this->targetingSetting)=='bid only'?TRUE:FALSE;
        
        $targetsetting = new TargetingSetting();
        $targetsetting->details = $target;
        
        $adgroupSettings = new AdGroup();
        $adgroupSettings->id = $this->adgroupId;
        $adgroupSettings->campaignId = $this->campaignId;
        $adgroupSettings->settings = $targetsetting;
        $op = new AdGroupOperation();
        $op->operand = $adgroupSettings;
        
        try{
            $op->operator = 'ADD';
        $adGroupService->mutate($op);
        }catch (Exception $e)
        {
           
            $op->operator = 'SET';
            $adGroupService->mutate($op);
           
        }
        
        
        // Set additional settings (optional).
        
        // Set bids (optional).
        
        
        // Create operation.
        $operation = new AdGroupCriterionOperation();
        $operation->operand = $adGroupCriterion;
        $operation->operator = 'ADD';
        $operations[] = $operation;
        
        
        // Make the mutate request.
        $return = array();
        try {
        $result = $adGroupCriterionService->mutate($operations);
        $return['status'] = 'Created'; $return['err_message']= '' ;
        
        } catch (Exception $e) {
            if(strpos($e->getMessage(),'OPERATION_NOT_PERMITTED_FOR_CAMPAIGN_TYPE')!==FALSE)
            {
                $return['status'] = 'Process Ignored'; $return['err_message']= '' ;
            }
            else
            {
            
           
            $return['status'] = 'Error'; $return['err_message']= "Code : ".$e->getCode()." , Message : ".$e->getMessage() ;
            }
        }
        
        return $return ;
        
        // Display results.
//         foreach ($result->value as $adGroupCriterion) {
//             printf("Keyword with text '%s', match type '%s', and ID '%s' was added.\n",
//             $adGroupCriterion->criterion->text,
//             $adGroupCriterion->criterion->matchType,
//             $adGroupCriterion->criterion->id);
//         }
        
    }
    
}