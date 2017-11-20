<?php
require_once ('../../config/config.php');
require_once dirname(dirname(__FILE__)) . '/init.php';

function get_userlist(AdWordsUser $user)
{
    $userListService = $user->GetService('AdwordsUserListService', ADWORDS_VERSION);
    $selector = new Selector();
    $selector->fields = array('Id','Name','ListType');
    $list_type = array('CRM_BASED');
    $audiences = array();
//     $selector->predicates[] =     new Predicate('ListType', 'EQUALS', 'UNKNOWN');
//     $selector->predicates[] =     new Predicate('ListType', 'EQUALS', 'REMARKETING');
    $selector->predicates[] =     new Predicate('ListType', 'IN', $list_type);
    $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
    echo "<pre>";
    do {
        // Make the get request.
        $page = $userListService->get($selector);
    
        // Display results.
        if (isset($page->entries)) {
//             print_r($page->entries);
            foreach ($page->entries as $campaignCriterion) {
                
               $audiences[] = array($campaignCriterion->id,$campaignCriterion->name);
               
                //        printf("Campaign targeting criterion with ID '%s' and type '%s' was "
                //            . "found.<br>", $campaignCriterion->criterion->id,
                //            $campaignCriterion->criterion->CriterionType);
            }
        } else {
            print "No user list were found.<br>";
        }
    
        // Advance the paging index.
        $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($page->totalNumEntries > $selector->paging->startIndex);
    print_r($audiences);
// return $audiences;
}
$adGroupId = '27845797351';
function AddAudienceExample(AdWordsUser $user, $adGroupId) {
  // Get the service, which loads the required classes.
  $adGroupCriterionService = $user->GetService('AdGroupCriterionService', ADWORDS_VERSION);
  $adGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);

 
  $operations = array();
 
  $criterion = new CriterionUserList();
  $criterion->userListId = 391252940;
  
 
  

  
    // Create biddable ad group criterion.
    $adGroupCriterion = new BiddableAdGroupCriterion();
    $adGroupCriterion->adGroupId = $adGroupId;
    $adGroupCriterion->criterion = $criterion;
    $adGroupCriterion->bidModifier  = 0.6;
    
    $target = new TargetingSettingDetail();
    $target->criterionTypeGroup = 'USER_INTEREST_AND_LIST';
    $target->targetAll = FALSE;
    
    $targetsetting = new TargetingSetting();
    $targetsetting->details = $target;
    
    $adgroupSettings = new AdGroup();
    $adgroupSettings->id=$adGroupId;
    $adgroupSettings->campaignId = 379788631;
    $adgroupSettings->settings = $targetsetting;
    $op = new AdGroupOperation();
    $op->operand = $adgroupSettings;
    $op->operator = 'SET'; 
    $adGroupService->mutate($op);
    // Set additional settings (optional).
 
    // Set bids (optional).
  

    // Create operation.
    $operation = new AdGroupCriterionOperation();
    $operation->operand = $adGroupCriterion;
    $operation->operator = 'ADD';
    $operations[] = $operation;


  // Make the mutate request.
  $result = $adGroupCriterionService->mutate($operations);

  // Display results.
  foreach ($result->value as $adGroupCriterion) {
    printf("Keyword with text '%s', match type '%s', and ID '%s' was added.\n",
        $adGroupCriterion->criterion->text,
        $adGroupCriterion->criterion->matchType,
        $adGroupCriterion->criterion->id);
  }
}
function GetCampaignsExample(AdWordsUser $user)
{
    global $conn;
    $first_part = array();
    $desired_campaign = array();
    $audiences = get_userlist($user);

    //                 echo $campaign->id;
    //               print_r($campaign);exit();
    
   
    
    
    
    
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
    

    // printf("%s,%s \n", $campaign->id, $campaign->name);
    $adgroupService = $user->GetService('AdGroupService',ADWORDS_VERSION);
    $selectors = new Selector();
    $selectors->fields = array(
        'Id',
        'Name',
        'CampaignId',
        'CampaignName'
    );
    $selectors->predicates[] =     new Predicate('CampaignId', 'IN', $desired_campaign);
    $selectors->ordering[] = new OrderBy('CampaignName', 'ASCENDING');
    // Create paging controls.
    $selectors->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
    //                 echo '<pre>';
    do {
        // Make the get request.
        $pages = $adgroupService->get($selectors);
        // Display results.
        if (isset($pages->entries)) {
            //                         print_r($pages->entries);
            foreach ($pages->entries as $data) {
                $first_part[] = array($data->campaignId,$data->campaignName,$data->id,$data->name);
    
            }
        }
        // Advance the paging index.
        $selectors->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($pages->totalNumEntries > $selectors->paging->startIndex);
    
    
  
   return array($audiences,$first_part);
}


    $EMAILS = array('customer1@example.com', 'customer2@example.com','Client3@example.com ');;
/**
 * Runs the example.
 * @param AdWordsUser $user the user to run the example with
 * @param array $EMAILS a list of member emails to be added to a user list
 */
function AddCrmBasedUserList(AdWordsUser $user, array $EMAILS) {
  // Get the services, which loads the required classes.
  $userListService = $user->GetService('AdwordsUserListService',
      ADWORDS_VERSION);

  // Create remarketing user list.
  $userList = new CrmBasedUserList();
  $userList->name = 'Customer relationship management list #' . uniqid();
  $userList->description =
      'A list of customers that originated from email addresses';

  // Maximum life span is 180 days.
  $userList->membershipLifeSpan = 180;

  // This field is required. It links to a service you created that allows
  // members of this list to remove themselves. It will be shown in the
  // "Why This Ad?" of an ad and so it needs to be verified. Read more about
  // "Why This Ad?" here https://support.google.com/ads/answer/2662850.
  $userList->optOutLink = 'http://endpoint1.example.com/optout';

  // Create operations to add the user list.
  $operation = new UserListOperation();
  $operation->operand = $userList;
  $operation->operator = 'ADD';

  $operations = array($operation);

  // Add user list.
  $result = $userListService->mutate($operations);

  // Display user list.
  $userListAdded = $result->value[0];
  printf("User list with name '%s' and ID '%d' was added.\n",
      $userListAdded->name, $userListAdded->id);

  // Get a user list ID.
  $userListId = $userListAdded->id;

  // Create operation to add members to the user list based on email addresses.
  $mutateMembersOperation = new MutateMembersOperation();
  $operand = new MutateMembersOperand();
  $operand->userListId = $userListId;

  // You can optionally provide this field.
  $operand->dataType = 'EMAIL_SHA256';

  // Hash normalized email addresses based on SHA-256 hashing algorithm.
  $emailHashes = array();
  foreach ($EMAILS as $email) {
    $emailHashes[] = hash('sha256', strtolower(trim($email)));
  }

  // Add email address hashes.
  $operand->members = $emailHashes;
  $mutateMembersOperation->operand = $operand;
  $mutateMembersOperation->operator = 'ADD';

  $mutateMembersOperations = array($mutateMembersOperation);

  // Add members to the user list based on email addresses.
  $mutateMembersResult =
      $userListService->mutateMembers($mutateMembersOperations);

  // Display results.
  // Reminder: it may take several hours for the list to be populated with
  //     members.
//   foreach ($mutateMembersResult->userLists as $userListResult) {
//     printf(
//         "%d email addresses were uploaded to user list with name '%s' and ID"
//             . " '%d' and are scheduled for review.\n",
//         count($EMAILS),
//         $userListResult->name,
//         $userListResult->id
//     );
//   }
}
function get_budget_orders(AdWordsUser $user){
    $userListService = $user->GetService('BudgetOrderService', ADWORDS_VERSION);
    $selector = new Selector();
    $selector->fields = array('BillingAccountId','BillingAccountName','BudgetOrderName');
//     $list_type = array('CRM_BASED');
//     $audiences = array();
    //     $selector->predicates[] =     new Predicate('ListType', 'EQUALS', 'UNKNOWN');
    //     $selector->predicates[] =     new Predicate('ListType', 'EQUALS', 'REMARKETING');
//     $selector->predicates[] =     new Predicate('ListType', 'IN', $list_type);
    $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
    echo "<pre>";
    do {
        // Make the get request.
        try{
        $page = $userListService->get($selector);
        }catch(Exception $e)
        {
            echo "Account# ".$_SESSION['account_number']." - ".$e->getMessage();
            break;
        }
    
        // Display results.
        if (isset($page->entries)) {
                        print_r($page->entries);
                        echo "<br/>-*----------------------------------------------------*-<br/>";
          /*   foreach ($page->entries as $campaignCriterion) {
    
                $audiences[] = array($campaignCriterion->id,$campaignCriterion->name);
                 
                //        printf("Campaign targeting criterion with ID '%s' and type '%s' was "
                //            . "found.<br>", $campaignCriterion->criterion->id,
                //            $campaignCriterion->criterion->CriterionType);
            } */
        } else {
            print "No user list were found.<br>";
        }
    
        // Advance the paging index.
        $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($page->totalNumEntries > $selector->paging->startIndex);
   // print_r($audiences);
}

try {
   


    $sqla = "SELECT *,a.account_number AS account FROM prospect_credentials p INNER JOIN account_details a ON p.account_number=a.mccid WHERE p.manage=1 AND account_status=1";//12268117756539291121  AND a.account_number=1226811775 6539291121
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
            get_budget_orders($user);
//             AddCrmBasedUserList($user, $EMAILS);
//             get_userlist($user);
//             AddAudienceExample($user, $adGroupId);
           // $user->LogAll();
//        $datum = GetCampaignsExample($user);
//        echo '<pre>';
//        get_userlist($user);
//           print_r($datum);
          
        }
    }
    
} catch (Exception $e) {
    echo $e->getMessage();
}