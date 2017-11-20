<?php
/**
 * Description of shoppingCampaignHelper
 * This class perform Create, Update, Remove, Get operations on Adwords API
 * @author shijo k.j
 */
class adschedulingCampaignHelper
{
    private $campaignId;
    private $campaignName;
    private $dayOfWeek;
    private $startHour;
    private $startMinute;
    private $endHour;
    private $endMinute;
    private $bidModifier;
    public function __construct($value, $schedule)
    {
        if (count($value) > 0) {
            $this->campaignId = $value;
            $this->dayOfWeek = $schedule['day'];
            $this->startHour = $schedule['startHour'];
            $this->startMinute = $schedule['startMin'];
            $this->endHour = $schedule['endHour'];
            $this->endMinute = $schedule['endMin'];
            $this->bidModifier = $schedule['bid'];
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
    function minuteConversion($minute)
    {
        switch ($minute) {
            case '00':
                return 'ZERO';
                break;
            case '15':
                return 'FIFTEEN';
                break;
            case '30':
                return 'THIRTY';
                break;
            case '45':
                return 'FORTY_FIVE';
                break;
            default:
                return 'ZERO';
                break;
        }
    }
    function remove_existing_schedules(AdWordsUser $user, $campaignId)
    {
        $campaignCriterionService = $user->GetService('CampaignCriterionService', ADWORDS_VERSION);
        // Create Mobile Platform. The ID can be found in the documentation.
        // https://developers.google.com/adwords/api/docs/appendix/platforms
        $selector = new Selector();
        $selector->fields = array(
            'Id'
        );
        $selector->ordering[] = new OrderBy('Id', 'ASCENDING');
        $selector->predicates[] = new Predicate('CampaignId', 'EQUALS', $campaignId);
        $page = $campaignCriterionService->get($selector);
        // Display results.
        if (isset($page->entries)) {
            foreach ($page->entries as $critera) {
                if ($critera->criterion->type == 'AD_SCHEDULE') {
                    $criterionid = $critera->criterion->id;
                    $remove = new AdSchedule();
                    $remove->id = $criterionid;
                    $removeCamp = new CampaignCriterion();
                    $removeCamp->campaignId = $campaignId;
                    $removeCamp->criterion = $remove;
                    $opr = new CampaignCriterionOperation();
                    $opr->operator = 'REMOVE';
                    $opr->operand = $removeCamp;
                    $campaignCriterionService->mutate(array(
                        $opr
                    ));
                }
            }
        }
        return true;
    }
    
    /**
     * Method for ad scheduling
     * @param AdWordsUser $user
     * @return string
     */
    function adSchedulingCamapign(AdWordsUser $user){
        $campaignCriterionService = $user->GetService('CampaignCriterionService', ADWORDS_VERSION);
        $criterionid = 0;
        $schedule = new AdSchedule();
        $schedule->dayOfWeek = strtoupper(trim($this->dayOfWeek));
        $schedule->startHour = $this->startHour;
        $schedule->startMinute = $this->minuteConversion($this->startMinute);
        $schedule->endHour = $this->endHour;
        $schedule->endMinute = $this->minuteConversion($this->endMinute);
        // Create criterion with modified bid.
        $criterion = new CampaignCriterion();
        $criterion->campaignId = $this->campaignId;
        $criterion->criterion = $schedule;
        $criterion->bidModifier = $this->bidConversion($this->bidModifier);
        
        // Create SET operation.
        $operation = new CampaignCriterionOperation();
        if ($criterionid > 0) {
            $schedule->id = $criterionid;
            $operation->operator = 'SET';
        } else {
            $operation->operator = 'ADD';
        }
        $operation->operand = $criterion;
        
        // Update campaign criteria.
        $return = array();
        try {
            $results = $campaignCriterionService->mutate(array($operation));
            $return['status'] = 'Created'; $return['err_message']= '' ; 
            
        } catch (Exception $e) {
            $return['status'] = 'Error'; $return['err_message']= "Code : ".$e->getLine()." , Message : ".$e->getMessage() ; 
        }
        return $return ;
    }
    
    /**
     * Returns campaign name, Id, schedule as separate arrays 
     * @param type $ret
     * @return type
     */
    public function splitCampaingNameScheduleAndId($ret) {
        $campaignIdArray = array();
        $scheduleArray = array();
        $campaignNameArray = array();
        for ($x = 0, $y = count($ret); $x < $y; $x ++) {
            if($ret[$x]['CampaignId']!=''){
                $campaignIdArray[] = $ret[$x]['CampaignId'];
            }
            if($ret[$x]['CampaignName']!=''){
                $campaignNameArray[] = $ret[$x]['CampaignName'];
            }
            if (trim($ret[$x]['BidModifier%']) !== '') {
    //            echo $ret[$x]['BidModifier%'].'<br>';
                if($ret[$x]['StartHour']==0 && $ret[$x]['EndHour']==0)
                {
                    if($ret[$x]['StartMin']==0 && $ret[$x]['EndMin']==0)
                    {
                        $endHour = 24;
                        $endMin  = 0;
                    }
                    else 
                    {
                        $endHour = $ret[$x]['EndHour'];
                        $endMin  = $ret[$x]['EndMin'];
                    }
                }
                else
                {
                    $endHour = $ret[$x]['EndHour'];
                    $endMin  = $ret[$x]['EndMin'];
                }
                if($endHour<$ret[$x]['StartHour'])
                {
                    $endHour = 24;
                }
                if($endHour==24)
                {
                    $endMin = 0;
                }
                $scheduleArray[] = array(
                    'bid' => $ret[$x]['BidModifier%'],
                    'day' => $ret[$x]['Day'],
                    'startHour' => $ret[$x]['StartHour'],
                    'startMin' => $ret[$x]['StartMin'],
                    'endHour' => $endHour,
                    'endMin' => $endMin
                );
            }
        }
        $scheduleArray = array_map("unserialize", array_unique(array_map("serialize", $scheduleArray)));
        return array($campaignIdArray, $campaignNameArray, $scheduleArray);
    }
    

    
    
}
