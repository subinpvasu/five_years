<?php
require_once dirname(dirname(__FILE__)) . '/init.php';
require_once ('../../config/config.php');









function GetAccountChangesExample(AdWordsUser $user) {
  $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
  $customerSyncService = $user->GetService('CustomerSyncService', ADWORDS_VERSION);
  $campaignIds = array();
  $selector = new Selector();
  $selector->fields = array('Id');
  $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
  do {
    $page = $campaignService->get($selector);
    if (isset($page->entries)) {
      foreach ($page->entries as $campaign) {
        $campaignIds[] = $campaign->id;
      }
    }
    else {
        echo 'no ids found.';
    }
    $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
  } while ($page->totalNumEntries > $selector->paging->startIndex);

  // Set the date time range, from 24 hours ago until now.
  $dateTimeRange = new DateTimeRange();
  $dateTimeRange->min = date('Ymd his', strtotime('-2 day'));
  $dateTimeRange->max = date('Ymd his');

  if (count($campaignIds) <= 0) {
   echo 'No values';   return;
  }
  
  // Create selector.
  $selector = new CustomerSyncSelector();
  $selector->dateTimeRange = $dateTimeRange;
  $selector->campaignIds = $campaignIds;

  
  // Make the get request.
  $accountChanges = $customerSyncService->get($selector);

  // Display results.
  if (isset($accountChanges)) {
      
   /*  printf("Most recent change: %s\n", $accountChanges->lastChangeTimestamp);echo '<br/>';
    echo count($accountChanges->changedCampaigns).'<pre>';
    print_r($accountChanges);
    
    if (isset($accountChanges->changedCampaigns)) {
        if (isset($campaignChangeData->changedAdGroups)) {
           // print_r($campaignChangeData->changedAdGroups);
            foreach($campaignChangeData->changedAdGroups as
                $adGroupChangeData) {
            echo $adGroupChangeData->changedCriteria;
                }
        }
    } */
    

    if (isset($accountChanges->changedCampaigns)) {
    	
       foreach ($accountChanges->changedCampaigns as $campaignChangeData) {
      	//print_r($campaignChangeData);
        /*  printf("Campaign with id '%.0f' has change status '%s'.\n",
            $campaignChangeData->campaignId,
            $campaignChangeData->campaignChangeStatus);  */
        
        	
          /*  printf("\tAdded ad extensions: %s\n",
              ArrayToString($campaignChangeData->addedAdExtensions)); */
          /* printf("\tRemoved ad extensions: %s\n",
              ArrayToString($campaignChangeData->removedAdExtensions)); */
        /*   printf("\tAdded campaign criteria: %s\n",
              ArrayToString($campaignChangeData->addedCampaignCriteria)); */
          /* printf("\tRemoved campaign criteria: %s\n",
              ArrayToString($campaignChangeData->removedCampaignCriteria));  */
          if (isset($campaignChangeData->changedAdGroups)) {
            foreach($campaignChangeData->changedAdGroups as
                $adGroupChangeData) {
                	//print_r($adGroupChangeData);
                	echo $adGroupChangeData->changedCriteria[0];
               /* printf("\tAd Group with id '%.0f' has change status '%s'.\n",
                  $adGroupChangeData->adGroupId,
                  $adGroupChangeData->adGroupChangeStatus);  */
             
            }
          }
     
      	
      } 
      
      
     
    }
  //  echo '</pre>';
  } else {
    print "No changes were found.\n";
  }
}

/**
 * Converts an array of values to a comma-separated string.
 * @param array $array an array of values that can be converted to a string
 * @return string a comma-separated string of the values
 */
function ArrayToString($array) {
  if (!isset($array)) {
    return '';
  } else {
    return implode(', ', $array);
  }
}

// Don't run the example if the file is being included.
/* if (__FILE__ != realpath($_SERVER['PHP_SELF'])) {
  return;
}
 */
function get_campaign_id($adgroupid)
{
    global $conn;
    $sql = "SELECT campaignid FROM adgroup_data WHERE customerid=".$_SESSION['account_number']." AND adgroupid=".$adgroupid;
    $result = $conn->query($sql);
    $obj=mysqli_fetch_object($result);
    return $obj->campaignid;
    
}
function get_adgroups_updated($user)
{ 
    global $conn;
  
    $sql = "SELECT adgroupid FROM adgroup_data a INNER JOIN campaign_data c ON a.campaignid=c.campaignid INNER JOIN account_details b ON
    b.account_number=c.customerid WHERE type='SHOPPING' AND b.account_number=".$_SESSION['account_number']." ";//AND type='SHOPPING',currency_code,AND type='SHOPPING'
    
    $result = $conn->query($sql);
    $adGroupId = array();
    while($row = $result->fetch_object()) {
        update_adgroups_separate($user,$row->adgroupid);
    }
}

function update_adgroups_separate(AdWordsUser $user,$adgroupid)
{
global $conn;
    //$adGroupId[]=$row->adgroupid;
    
    $adGroupCriterionService = $user->GetService('AdGroupCriterionService', ADWORDS_VERSION);
    // Create selector.
    $selectors = new Selector();
    $selectors->fields = array('Id','CpcBid','CaseValue');
    $selectors->ordering[] = new OrderBy('KeywordText', 'ASCENDING');
    // Create predicates.
    $selectors->predicates[] = new Predicate('AdGroupId', 'EQUALS', $adgroupid);
    $selectors->predicates[] = new Predicate('CriteriaType', 'IN', array(
        'PRODUCT_PARTITION'
    ));
    $selectors->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
    
    do {
        // Make the get request.
        $pages = $adGroupCriterionService->get($selectors);
        // Display results.
        if (isset($pages->entries)) {
    
            foreach ($pages->entries as $adGroupCriterion) {
                if (isset($adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount) && is_numeric($adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount)) {
                     
                     
                    $crid = $adGroupCriterion->criterion->id;
                    $crname = $adGroupCriterion->criterion->caseValue->value;
                    $bid = $adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount;
    
                    $mysql = "INSERT INTO criterion_data( customerid, campaignid, adgroupid, criterionid, crname, crbid, added) VALUES (". $_SESSION['account_number'] . ",".get_campaign_id($adgroupid).",".$$adgroupid.",".$crid.",'".$crname."','".$bid."',NOW())";
                      echo $mysql;
                   // $conn->query($mysql);
                }
            }
        }
        // Advance the paging index.
        $selectors->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($pages->totalNumEntries > $selectors->paging->startIndex);
}
function GetCampaignsExample(AdWordsUser $user) {
    
   // global $conn;

    // Get the service, which loads the required classes.
    $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);

    // Create selector.
    $campaign_title = 'campaign10';
    $selector = new Selector();
    $selector->fields = array('Id','Amount','BudgetId');
    $selector->predicates[] = new Predicate('Name','EQUALS',$campaign_title);
    $selector->predicates[] = new Predicate('AdvertisingChannelType','EQUALS','SEARCH');
    $selector->ordering[] = new OrderBy('Name', 'ASCENDING');

    // Create paging controls.
    $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);

    do {
        // Make the get request.
        $page = $campaignService->get($selector);

        // Display results.
        echo '<pre>';
        if (isset($page->entries)) {
            //     	echo count($page->entries);
            foreach ($page->entries as $campaign) {
               print_r($campaign);
               echo $campaign->budget->amount->microAmount;
               echo '<br/>';
               echo $campaign->budget->budgetId;
//             echo $campaign->id;
                /*  printf("Campaign with name '%s' and ID '%s' was found.\n",
                 $campaign->name, $campaign->id);
                echo '<br/>'; */
                 
                /* $sql = "INSERT INTO campaign_data(customerid, campaignid, campaign_name,type, added) VALUES ('".$_SESSION['customer']."','".$campaign->id."','".$campaign->name."','".$campaign->advertisingChannelType."',NOW())";
                 $conn->query($sql); */
            }
        } /* else {
        print "No campaigns were found.\n";
        } */

        // Advance the paging index.
        $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($page->totalNumEntries > $selector->paging->startIndex);
}

$adGroupId = '32191031685';
$adId = array('141172968360','141172968363');

/**
 * Runs the example.
 * @param AdWordsUser $user the user to run the example with
 * @param string $adGroupId the id of the ad group containing the ad
 * @param string $adId the ID of the ad
 */
function PauseAdExample(AdWordsUser $user, $adGroupId, $adId) {
  // Get the service, which loads the required classes.
  $adGroupAdService = $user->GetService('AdGroupAdService', ADWORDS_VERSION);
  // Create ad using an existing ID. Use the base class Ad instead of TextAd to
  // avoid having to set ad-specific fields.
 for($i=0;$i<count($adId);$i++)
 {
  $ad = new Ad();
  $ad->id = $adId[$i];
  // Create ad group ad.
  $adGroupAd = new AdGroupAd();
  $adGroupAd->adGroupId = $adGroupId;
  $adGroupAd->ad = $ad;
  // Update the status.
  $adGroupAd->status = 'PAUSED';
  // Create operation.
  $operation = new AdGroupAdOperation();
  $operation->operand = $adGroupAd;
  $operation->operator = 'SET';
  $operations = array($operation);
  
  // Make the mutate request.
  $result = $adGroupAdService->mutate($operations);
 }
  // Display result.
  $adGroupAd = $result->value[0];
  printf("Ad of type '%s' with ID '%s' has updated status '%s'.\n",
      $adGroupAd->ad->AdType, $adGroupAd->ad->id, $adGroupAd->status);
}
function GetAdGroupsExample(AdWordsUser $user, $campaignId) {
    // Get the service, which loads the required classes.
    $adGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);

    // Create selector.
    $selector = new Selector();
    $selector->fields = array('Id', 'Name','CpcBid','BiddingStrategyId');
    $selector->ordering[] = new OrderBy('Name', 'ASCENDING');

    // Create predicates.
    $selector->predicates[] =
    new Predicate('CampaignId', 'IN', array($campaignId));

    // Create paging controls.
    $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
echo '<pre>';
    do {
        // Make the get request.
        $page = $adGroupService->get($selector);

        // Display results.
        if (isset($page->entries)) {
            foreach ($page->entries as $adGroup) {
//                 printf("Ad group with name '%s' and ID '%s' was found.\n",
//                 $adGroup->name, $adGroup->id);
print_r($adGroup);
//echo $adGroup->biddingStrategyConfiguration->bids['CpcBid']->bid->microAmount;
// print_r($adGroup->biddingStrategyConfiguration->bids[0]->bid->microAmount);
echo $adGroup->biddingStrategyConfiguration->bids[0]->bid->microAmount;
            }
        } else {
            print "No ad groups were found.\n";
        }

        // Advance the paging index.
        $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($page->totalNumEntries > $selector->paging->startIndex);
}
function GetExpandedTextAdsExample(AdWordsUser $user, $adGroupId) {
    // Get the service, which loads the required classes.
    $adGroupAdService = $user->GetService('AdGroupAdService', ADWORDS_VERSION);

    // Create selector.
    $selector = new Selector();
    $selector->fields =
    array('Id', 'Status', 'HeadlinePart1', 'HeadlinePart2', 'Description','CreativeFinalUrls');
    $selector->ordering[] = new OrderBy('Id', 'ASCENDING');

    // Create predicates.
    $selector->predicates[] = new Predicate('AdGroupId', 'IN', array($adGroupId));
//     $selector->predicates[] =
//     new Predicate('AdType', 'IN', array('EXPANDED_TEXT_AD'));
    $selector->predicates[] =
    new Predicate('Status', 'IN', array('ENABLED', 'PAUSED'));

    // Create paging controls.
    $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);

    do {
        // Make the get request.
        $page = $adGroupAdService->get($selector);

        // Display results.
        if (isset($page->entries)) {
            print_r($page->entries);
//             foreach ($page->entries as $adGroupAd) {
//                 printf(
//                 "Expanded text ad with ID '%d' status '%s', and headline '%s - %s' "
//                     . "was found.\n",
//                     $adGroupAd->ad->id,
//                     $adGroupAd->status,
//                     $adGroupAd->ad->headlinePart1,
//                     $adGroupAd->ad->headlinePart2
//                 );
//             }
        } else {
            print "No expanded text ads were found.\n";
        }

        // Advance the paging index.
        $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($page->totalNumEntries > $selector->paging->startIndex);
}
function AddKeywordsExample(AdWordsUser $user, $adGroupId) {
    // Get the service, which loads the required classes.
    $adGroupCriterionService =
    $user->GetService('AdGroupCriterionService', ADWORDS_VERSION);

    $numKeywords = 3;
    $operations = array();
    for ($i = 0; $i < $numKeywords; $i++) {
        // Create keyword criterion.
        $keyword = new Keyword();
        $keyword->text = 'mars cruise 9495546474';
        $keyword->matchType = 'BROAD';

        // Create biddable ad group criterion.
        $adGroupCriterion = new BiddableAdGroupCriterion();
        $adGroupCriterion->adGroupId = $adGroupId;
        $adGroupCriterion->criterion = $keyword;

        // Set additional settings (optional).
        $adGroupCriterion->userStatus = 'PAUSED';
//         $adGroupCriterion->finalUrls = array('http://www.example.com/mars');

        // Set bids (optional).
        $bid = new CpcBid();
        $bid->bid =  new Money(500000);
        $biddingStrategyConfiguration = new BiddingStrategyConfiguration();
        $biddingStrategyConfiguration->bids[] = $bid;
        $adGroupCriterion->biddingStrategyConfiguration =
        $biddingStrategyConfiguration;

        $adGroupCriteria[] = $adGroupCriterion;

        // Create operation.
        $operation = new AdGroupCriterionOperation();
        $operation->operand = $adGroupCriterion;
        $operation->operator = 'ADD';
        $operations[] = $operation;
    }

    // Make the mutate request.
    $result = $adGroupCriterionService->mutate($operations);
print_r($result->value);
    // Display results.
//     foreach ($result->value as $adGroupCriterion) {
// //         printf("Keyword with text '%s', match type '%s', and ID '%s' was added.\n",
// //         $adGroupCriterion->criterion->text,
// //         $adGroupCriterion->criterion->matchType,
// //         $adGroupCriterion->criterion->id);
//     }
}





function GetKeywordsExample(AdWordsUser $user, $adGroupId) {
  // Get the service, which loads the required classes.
  $adGroupCriterionService =
      $user->GetService('AdGroupCriterionService', ADWORDS_VERSION);

  // Create selector.
  $selector = new Selector();
  $selector->fields = array('Id', 'CriteriaType', 'KeywordMatchType','KeywordText');
  $selector->ordering[] = new OrderBy('KeywordText', 'ASCENDING');

  // Create predicates.
  $selector->predicates[] = new Predicate('AdGroupId', 'IN', array($adGroupId));
  $selector->predicates[] =
      new Predicate('CriteriaType', 'IN', array('KEYWORD'));
  // Create paging controls.
  $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
  
  do {
      // Make the get request.
      $page = $adGroupCriterionService->get($selector);
  
      // Display results.
      if (isset($page->entries)) {
          print_r($page->entries);
          foreach ($page->entries as $adGroupCriterion) {
              print_r($adGroupCriterion->criterion);
//               printf("Keyword with text '%s', match type '%s', criteria type '%s', "
//                   . "and ID '%s' was found.\n",
//                   $adGroupCriterion->criterion->text,
//                   $adGroupCriterion->criterion->matchType,
//                   $adGroupCriterion->criterion->type,
//                   $adGroupCriterion->criterion->id);
          }
      } else {
          print "No keywords were found.\n";
      }
      // Advance the paging index.
      $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
      } while ($page->totalNumEntries > $selector->paging->startIndex);
      }




try {
    $sqla = "SELECT *,a.account_number AS account FROM prospect_credentials p INNER JOIN account_details a ON p.account_number=a.mccid WHERE  account_status=1 AND a.account_number=1226811775 ";// AND a.account_number=5493971629 
//     // 12268117756539291121 AND a.account_number=1226811775 5493971629  1728364983 AND a.account_number=1728364983
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
            
             $user->LogAll();
             echo '<pre>';
//              GetExpandedTextAdsExample($user, 29258670370);
//              AddKeywordsExample($user, 29258670370);
GetKeywordsExample($user, 39972674771);
//              PauseAdExample($user, $adGroupId, $adId);
            //get_adgroups_updated($user);
         //    GetAccountChangesExample($user);
//             GetCampaignsExample($user);
// GetAdGroupsExample($user, 665386795);
            // getCamapaigns($user);
            // echo $col->refresh_token."|||".$id['account']."||".$id['mcc']."<br/>";
        }
    }
		

  // Run the example.
 // GetAccountChangesExample($user);
 
    //****************************************************************************************************
//     define('CLIENT_ID', '468464043387.apps.googleusercontent.com');
//     define('CLIENT_SECRET', 'HMEdj6M_kK37djfKEXQLQv06');
//     define('DEVELOPER_TOKEN', '3cQGzPPFUQYrohn-pUlgEw');
//     define('USER_AGENT', 'pushGroupAPI');
//     define('REDIRECT_URI', 'http://pushanalyser.co.uk/app/auth/GetRefreshToken.php');
    
//     $refresh_token = '1/qo6xrGPKYsSw-A5zgUvlc5O1dNTd1JIwjvOpm981o7c';
    
//     $customerId =6093644096;
    
//     $developerToken = DEVELOPER_TOKEN ;
    
//     $userAgent = USER_AGENT ;
    
//     //$account =  2570035894;
//     $account =  2570035894;
    
//     $oauth2Info = array(
//         "client_id" => CLIENT_ID ,
//         "client_secret" => CLIENT_SECRET,
//         "refresh_token" => $refresh_token
//     );
    
//     $user = new AdWordsUser(null,$developerToken, $userAgent, $customerId,null, $oauth2Info);
    
//     $user->LogAll();
    
//     $user->SetClientCustomerId($account);
    
    
//     $adgroupid = 1046622536;
//     GetExpandedTextAdsExample($user, $adgroupid);
    //****************************************************************************************************
    
    
} catch (Exception $e) {
  printf("An error has occurred: %s\n", $e->getMessage());
}
