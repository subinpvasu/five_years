<?php
require_once './examples/AdWords/v201605/init.php';
require_once 'config/config.php';
$accounts_id = $_REQUEST['accountid'];
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=AudienceList_' . $accounts_id .'_'.time().'.csv');
printf("CampaignId,CampaignName,AdGroupId,AdGroupName,AudienceId,AudienceName,BidAdj,TargetSetting\n");
$csv = '';
function get_userlist(AdWordsUser $user)
{
    $userListService = $user->GetService('AdwordsUserListService', ADWORDS_VERSION);
    $selector = new Selector();
    $selector->fields = array('Id','Name','ListType');
    $list_type = array('REMARKETING', 'RULE_BASED','CRM_BASED','LOGICAL');//,'CRM_BASED'
    $audiences = array();
    $selector->predicates[] =     new Predicate('ListType', 'IN', $list_type);
    $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
//     echo "<pre>";
    do {
        // Make the get request.
        $page = $userListService->get($selector);
    
        // Display results.
        if (isset($page->entries)) {
            foreach ($page->entries as $campaignCriterion) {
               $audiences[] = array($campaignCriterion->id,str_replace(",","|",$campaignCriterion->name));
            }
        } else {
            print "No user list were found.<br>";
        }
    
        // Advance the paging index.
        $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($page->totalNumEntries > $selector->paging->startIndex);
 //   print_r($audiences);
 return $audiences;
}
function GetCampaignsExample(AdWordsUser $user)
{
    global $conn;
    $first_part = array();
    $desired_campaign = array();
    $audiences = get_userlist($user);
//     Get the service, which loads the required classes.
    $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
    // Create selector.
    $selector = new Selector();
    $selector->fields = array(
        'Id' 
    );
    $cmp_type =array('SEARCH','SHOPPING');
    
    $selector->predicates[] =     new Predicate('AdvertisingChannelType', 'IN', $cmp_type);
    $selector->ordering[] = new OrderBy('Name', 'ASCENDING');
    // Create paging controls.
    $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
    do {
        // Make the get request.
        $page = $campaignService->get($selector);
        // Display results.
        if (isset($page->entries)) {
            //print_r($page->entries);
            foreach ($page->entries as $campaign) {
                $desired_campaign[] = $campaign->id;
            }
        }
        // Advance the paging index.
        $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($page->totalNumEntries > $selector->paging->startIndex);
    $adgroupService = $user->GetService('AdGroupService',ADWORDS_VERSION);
    $selectors = new Selector();
    $selectors->fields = array(
        'Id',
        'Name',
        'CampaignId',
        'CampaignName'
    );
    $selectors->predicates[] =     new Predicate('CampaignId', 'IN', $desired_campaign);
    $selectors->ordering[] = new OrderBy('CampaignId', 'ASCENDING');
    // Create paging controls.
    $selectors->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
    do {
        // Make the get request.
        $pages = $adgroupService->get($selectors);
        // Display results.
        if (isset($pages->entries)) {
            foreach ($pages->entries as $data) {
                $first_part[] = array($data->campaignId,str_replace(",","|",$data->campaignName),$data->id,str_replace(",","|",$data->name));
            }
        }
        // Advance the paging index.
        $selectors->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($pages->totalNumEntries > $selectors->paging->startIndex);
   return array($audiences,$first_part);
}
try {
    $sqla = "SELECT *,a.account_number AS account FROM prospect_credentials p INNER JOIN account_details a ON p.account_number=a.mccid WHERE p.manage=1 AND account_status=1 AND a.account_number=".$accounts_id." limit 0,1";//12268117756539291121  AND a.account_number=1226811775 6539291121
    $resulta = $conn->query($sqla);
    $account = array();
    
    if ($resulta->num_rows > 0) {
        while ($row = $resulta->fetch_object()) {
    
            $userAgent = 'Omnitail';
            $oauth2Infos = array(
                "client_id" => $clientId,
                "client_secret" => $clientSecret,
                "refresh_token" => $row->refresh_token
            );
            $user = new AdWordsUser(NULL, $developerToken, $userAgent, NULL, NULL, $oauth2Infos); // clientCustomerId = "6743897063"9197135874
            $user->SetClientCustomerId($row->account);
            $_SESSION['account_number'] = $row->account;
       $datum = GetCampaignsExample($user);

     $audience_all = $datum[0];
    
     $data = $datum[1];

   $data =  array_map("unserialize", array_unique(array_map("serialize", $data)));

     $a = count($audience_all);
     $dt = count($data);
//      if($dt>$a){
     for($i=0;$i<$dt;$i++)
     {
          $csv.= implode(",", $data[$i]);
         if($i<$a)
         {
             $csv.=',';
             $csv.= implode(",", $audience_all[$i]);
             $csv .= ",0,";
             $csv .= "Bid only|Target and Bid";
            
         }
//          else {
//              $csv .= ", , ,0,";
//              $csv .= "Bid only|Target and Bid";
//          }
        $csv .= "\n";


    

     }
     echo $csv;
     }
   /*   else 
     {
         for($i=0;$i<$a;$i++)
         {
         $csv.= printf(implode(",", $data[$i]));
             if($i<$a)
             {
             $csv.= printf(implode(",", $audience[$i]));
             }
             }
     } */
     
     

          
       
    }
    
} catch (Exception $e) {
    echo $e->getMessage();
}