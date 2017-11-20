<?php
require_once ('../../config/config.php');
require_once dirname(dirname(__FILE__)) . '/init.php';

function campaign_advert_type($campaign_id)
{
    global $conn;
    $sql = "SELECT type FROM campaign_data WHERE campaignid =" . $campaign_id;
//     echo '<br/>1';
//     echo $sql;
//     echo '<br/>';
    $result = $conn->query($sql);
    $obj = mysqli_fetch_object($result);
    return $obj->type;
}

function campaign_changed_insert($user, $campaign_id, $flag = 1)
{
    global $conn;
    $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
    // Create selector.
    $selector = new Selector();
    $selector->fields = array(
        'Id',
        'Name',
        'AdvertisingChannelType'
    );
    $selector->ordering[] = new OrderBy('Name', 'ASCENDING');
    $selector->predicates[] = new Predicate('CampaignId', 'EQUALS', $campaign_id);
    // Create paging controls.
    $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
    $campaign_type = '';
    do {
        // Make the get request.
        $page = $campaignService->get($selector);
        // Display results.
        if (isset($page->entries)) {
            foreach ($page->entries as $campaign) {
                $sql = "INSERT INTO campaign_data(customerid, campaignid, campaign_name,type, added) VALUES ('" . $_SESSION['account_number'] . "','" . $campaign_id . "','" . mysqli_real_escape_string($conn, $campaign->name) . "','" . $campaign->advertisingChannelType . "',NOW())";
                $campaign_type = $campaign->advertisingChannelType;
                echo '<br/>2';
                echo $sql;
                echo '<br/>';
               $conn->query($sql);
                // echo $sql.'2</br>';
            }
        }
        // Advance the paging index.
        $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($page->totalNumEntries > $selector->paging->startIndex);
    return $flag == 1 ? array(
        $campaign_id,
        $campaign_type
    ) : true;
}

function campaign_changed_update($user, $campaign_id, $flag = 1)
{
    global $conn;
    $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
    // Create selector.
    $selector = new Selector();
    $selector->fields = array(
        'Id',
        'Name',
        'AdvertisingChannelType'
    );
    $selector->ordering[] = new OrderBy('Name', 'ASCENDING');
    $selector->predicates[] = new Predicate('CampaignId', 'EQUALS', $campaign_id);
    // Create paging controls.
    $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
    $campaign_type = '';
    do {
        // Make the get request.
        $page = $campaignService->get($selector);
        // Display results.
        if (isset($page->entries)) {
            foreach ($page->entries as $campaign) {
                $sql = "UPDATE campaign_data SET campaign_name='" . mysqli_real_escape_string($conn, $campaign->name) . "',type='" . $campaign->advertisingChannelType . "' WHERE campaignid=$campaign_id ";
                $campaign_type = $campaign->advertisingChannelType;
                $conn->query($sql);
                    echo '<br/>3';
                    echo $sql;
                    echo '<br/>';
            }
        }
        // Advance the paging index.
        $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($page->totalNumEntries > $selector->paging->startIndex);
    return $flag == 1 ? array(
        $campaign_id,
        $campaign_type
    ) : true;
}

function adgroup_changed_insert($user, $adgroup_id, $campaign_type, $flag = 1)
{
    global $conn;
    echo 100;
    $adGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);
    $selector = new Selector();
    $selector->fields = array(
        'Id',
        'Name',
        'CampaignId',
        'CampaignName',
        'CpcBid'
    );
    $selector->ordering[] = new OrderBy('Name', 'ASCENDING');
    // Create predicates.
    if ($flag == 1) {
        $selector->predicates[] = new Predicate('Id', 'EQUALS', $adgroup_id);
    } else {
        $selector->predicates[] = new Predicate('CampaignId', 'EQUALS', $adgroup_id);
    }
    
    // Create paging controls.
    $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
    do {
        // Make the get request.
        $page = $adGroupService->get($selector);
        // Display results.
        if (isset($page->entries)) {
            // print_r($page->entries);
            foreach ($page->entries as $adGroup) {
                if ($campaign_type == 'SHOPPING') {
                    
                   
                    

                    $bid = $adGroup->biddingStrategyConfiguration->bids[0]->bid->microAmount;
                    $crname = '';
                    $crid = 0;
                    
                    $sql = "SELECT * FROM adgroup_data WHERE customerid='" . $_SESSION['account_number'] . "' AND campaignid='" . $adGroup->campaignId . "' AND adgroupid='" . $adGroup->id . "'";
                    $result = $conn->query($sql);
//                     echo '<br/>4';
//                     echo $sql;
//                     echo '<br/>';
                    
                    if($result->num_rows >0)
                    {
                        $sql = "UPDATE adgroup_data SET campaign_name='" . mysqli_real_escape_string($conn, $adGroup->campaignName) . "',adgroup_name='" . mysqli_real_escape_string($conn, $adGroup->name) . "',updated=NOW() WHERE customerid='" . $_SESSION['account_number'] . "' AND campaignid='" . $adGroup->campaignId . "' AND adgroupid='" . $adGroup->id . "'";
                        $conn->query($sql);
                    echo '<br/>5';
                    echo $sql;
                    echo '<br/>';
                    }
                    else 
                    {
                    
                    $sql = "INSERT INTO adgroup_data(customerid, campaignid, adgroupid,crid,campaign_name,adgroup_name,bid,crname,added) VALUES
												 ('" . $_SESSION['account_number'] . "','" . $adGroup->campaignId . "','" . $adGroup->id . "','" . $crid . "','" . mysqli_real_escape_string($conn, $adGroup->campaignName) . "','" . mysqli_real_escape_string($conn, $adGroup->name) . "','" . $bid . "','" . mysqli_real_escape_string($conn,$crname) . "',NOW())";
                    $conn->query($sql);
                    echo '<br/>6';
                    echo $sql;
                    echo '<br/>';
                    }
                    
                    
                    
                    if($flag==1)
                    {
                        echo 3333;
                        update_shopping_adgroup($user, $adgroup_id);
                    }
                    else 
                    {
                        echo 4444;
                        
                            update_shopping_adgroup($user, $adGroup->id);
                        
                    }
                    
                    
                    
                    /* $adGroupCriterionService = $user->GetService('AdGroupCriterionService', ADWORDS_VERSION);
                    // Create selector.
                    $selectors = new Selector();
                    $selectors->fields = array(
                        'Id',
                        'CriteriaType',
                        'PartitionType',
                        'CpcBid',
                        'CaseValue'
                    );
                    $selectors->ordering[] = new OrderBy('KeywordText', 'ASCENDING');
                    // Create predicates.
                    $selectors->predicates[] = new Predicate('AdGroupId', 'EQUALS', $adGroup->id);
                    $selectors->predicates[] = new Predicate('CriteriaType', 'IN', array(
                        'PRODUCT_PARTITION'
                    )); // partitionType
                        // $selector->predicates[] = new Predicate('PartitionType', 'IN', array('UNIT'));//partitionType
                        // Create paging controls.
                    $selectors->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
                    $resp = array();
                    do {
                        // Make the get request.
                        $pages = $adGroupCriterionService->get($selectors);
                        // Display results.
                        if (isset($pages->entries)) {
                            foreach ($pages->entries as $adGroupCriterion) {
                                if (isset($adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount) && is_numeric($adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount)) {
                                    $crid = $adGroupCriterion->criterion->id;
                                    $bid = $adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount;
                                    $crname = mysqli_real_escape_string($conn, $adGroupCriterion->criterion->caseValue->value);
                                }
                            }
                        }
                        // Advance the paging index.
                        $selectors->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
                    } while ($pages->totalNumEntries > $selectors->paging->startIndex); */
                    
                    
                    
              
                    
                  
                    
                } else {
                    $bid = $adGroup->biddingStrategyConfiguration->bids[0]->bid->microAmount;
                    $crname = '';
                    $crid = 0;
                    $sql = "SELECT * FROM adgroup_data WHERE customerid='" . $_SESSION['account_number'] . "' AND campaignid='" . $adGroup->campaignId . "' AND adgroupid='" . $adGroup->id . "'";
                    $result = $conn->query($sql);
//                     echo '<br/>7';
//                     echo $sql;
//                     echo '<br/>';
                    if($result->num_rows >0)
                    {
                        $sql = "UPDATE adgroup_data SET campaign_name='" . mysqli_real_escape_string($conn, $adGroup->campaignName) . "',adgroup_name='" . mysqli_real_escape_string($conn, $adGroup->name) . "',bid='" . $bid . "',updated=NOW() WHERE customerid='" . $_SESSION['account_number'] . "' AND campaignid='" . $adGroup->campaignId . "' AND adgroupid='" . $adGroup->id . "'";
                        $conn->query($sql);
                        echo '<br/>8';
                        echo $sql;
                        echo '<br/>';
                    }
                    else {
                    
                    $sql = "INSERT INTO adgroup_data(customerid, campaignid, adgroupid,crid,campaign_name,adgroup_name,bid,crname,added) VALUES
												 ('" . $_SESSION['account_number'] . "','" . $adGroup->campaignId . "','" . $adGroup->id . "','" . $crid . "','" . mysqli_real_escape_string($conn, $adGroup->campaignName) . "','" . mysqli_real_escape_string($conn, $adGroup->name) . "','" . $bid . "','" . mysqli_real_escape_string($conn,$crname) . "',NOW())";
                    $conn->query($sql);
                    echo '<br/>9';
                    echo $sql;
                    echo '<br/>';
                    }
                }
                // $sql = "UPDATE adgroup_data SET campaign_name='".$adGroup->campaignName."',adgroup_name='".$adGroup->name."',bid='".$bid."' ";
                
                // echo $sql.'3</br>';
            }
        }
        // Advance the paging index.
        $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($page->totalNumEntries > $selector->paging->startIndex);
}

function adgroup_changed_update($user, $adgroup_id, $campaign_type, $flag = 1)
{
    global $conn;
    $adGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);
    $selector = new Selector();
    $selector->fields = array(
        'Id',
        'Name',
        'CampaignId',
        'CampaignName',
        'CpcBid'
    );
    $selector->ordering[] = new OrderBy('Name', 'ASCENDING');
    // Create predicates.
    if ($flag == 1) {
        $selector->predicates[] = new Predicate('Id', 'EQUALS', $adgroup_id);
    } else {
        $selector->predicates[] = new Predicate('CampaignId', 'EQUALS', $adgroup_id);
    }
    // Create paging controls.
    $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
    do {
        // Make the get request.
        $page = $adGroupService->get($selector);
        // Display results.
        if (isset($page->entries)) {
            // print_r($page->entries);
            foreach ($page->entries as $adGroup) {
                if ($campaign_type == 'SHOPPING') {
                    
                    
                    $bid = $adGroup->biddingStrategyConfiguration->bids[0]->bid->microAmount;
                    $crname = '';
                    $crid = 0;
                    
                    $sql = "SELECT * FROM adgroup_data WHERE customerid='" . $_SESSION['account_number'] . "' AND campaignid='" . $adGroup->campaignId . "' AND adgroupid='" . $adGroup->id . "'";
                    $result = $conn->query($sql);
//                     echo '<br/>4a';
//                     echo $sql;
//                     echo '<br/>';
                    
                    if($result->num_rows >0)
                    {
                        $sql = "UPDATE adgroup_data SET campaign_name='" . mysqli_real_escape_string($conn, $adGroup->campaignName) . "',adgroup_name='" . mysqli_real_escape_string($conn, $adGroup->name) . "',updated=NOW() WHERE customerid='" . $_SESSION['account_number'] . "' AND campaignid='" . $adGroup->campaignId . "' AND adgroupid='" . $adGroup->id . "'";
                        $conn->query($sql);
                        echo '<br/>5a';
                        echo $sql;
                        echo '<br/>';
                    }
                    else
                    {
                    
                        $sql = "INSERT INTO adgroup_data(customerid, campaignid, adgroupid,crid,campaign_name,adgroup_name,bid,crname,added) VALUES
												 ('" . $_SESSION['account_number'] . "','" . $adGroup->campaignId . "','" . $adGroup->id . "','" . $crid . "','" . mysqli_real_escape_string($conn, $adGroup->campaignName) . "','" . mysqli_real_escape_string($conn, $adGroup->name) . "','" . $bid . "','" . mysqli_real_escape_string($conn,$crname) . "',NOW())";
                        $conn->query($sql);
                        echo '<br/>6a';
                        echo $sql;
                        echo '<br/>';
                    }
                    
                    
                    
                    if($flag==1)
                    {
                        update_shopping_adgroup($user, $adgroup_id);
                    }
                    else
                    {
                        foreach (get_adgroupid_bycampaignid($adgroup_id) as $adgroupid)
                        {
                            update_shopping_adgroup($user, $adgroupid);
                        }
                    }
                    
                    
                    
                    
                   /*  $adGroupCriterionService = $user->GetService('AdGroupCriterionService', ADWORDS_VERSION);
                    // Create selector.
                    $selectors = new Selector();
                    $selectors->fields = array(
                        'Id',
                        'CriteriaType',
                        'PartitionType',
                        'CpcBid',
                        'CaseValue'
                    );
                    $selectors->ordering[] = new OrderBy('KeywordText', 'ASCENDING');
                    // Create predicates.
                    $selectors->predicates[] = new Predicate('AdGroupId', 'EQUALS', $adGroup->id);
                    $selectors->predicates[] = new Predicate('CriteriaType', 'IN', array(
                        'PRODUCT_PARTITION'
                    )); // partitionType
                        // $selector->predicates[] = new Predicate('PartitionType', 'IN', array('UNIT'));//partitionType
                        // Create paging controls.
                    $selectors->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
                    $resp = array();
                    do {
                        // Make the get request.
                        $pages = $adGroupCriterionService->get($selectors);
                        // Display results.
                        if (isset($pages->entries)) {
                            foreach ($pages->entries as $adGroupCriterion) {
                                if (isset($adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount) && is_numeric($adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount)) {
                                    $bid = $adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount;
                                    $crid = $adGroupCriterion->criterion->id;
                                    $crname = mysqli_real_escape_string($conn, $adGroupCriterion->criterion->caseValue->value);
                                }
                            }
                        }
                        // Advance the paging index.
                        $selectors->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
                    } while ($pages->totalNumEntries > $selectors->paging->startIndex); */
                    
                    
                    
                    
                    
                } else {
                    $bid = $adGroup->biddingStrategyConfiguration->bids[0]->bid->microAmount;
                    $crname = '';
                    $crid = 0;
                    $sql = "UPDATE adgroup_data SET campaign_name='" . mysqli_real_escape_string($conn, $adGroup->campaignName) . "',adgroup_name='" . mysqli_real_escape_string($conn, $adGroup->name) . "',bid='" . $bid . "',crname='" . mysqli_real_escape_string($conn,$crname) . "',updated=NOW() WHERE campaignid=$adGroup->campaignId AND customerid=" . $_SESSION['account_number'] . " AND adgroupid=".$adGroup->id." AND crid=".$crid;
                    $conn->query($sql);
                    echo '<br/>10';
                    echo $sql;
                    echo '<br/>';
                }
                
               
                // echo $sql.'4</br>';
            }
        }
        // Advance the paging index.
        $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($page->totalNumEntries > $selector->paging->startIndex);
}

function update_shopping_adgroup(AdWordsUser $user,$adgroupid)
{
    global $conn;
    echo 2222;

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
    )); // partitionType
    // $selector->predicates[] = new Predicate('PartitionType', 'IN', array('UNIT'));//partitionType
    // Create paging controls.
    $selectors->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
    //         $resp = 0;
    do {
        // Make the get request.
        $pages = $adGroupCriterionService->get($selectors);
        // Display results.
        if (isset($pages->entries)) {
            /*  echo '<pre>';
             print_r($pages->entries);
             echo '</pre>'; */
            foreach ($pages->entries as $adGroupCriterion) {
                if (isset($adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount) && is_numeric($adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount)) {
                     
                     
                    $crid = $adGroupCriterion->criterion->id;
                    $crname = $adGroupCriterion->criterion->caseValue->value;
                    $bid = $adGroupCriterion->biddingStrategyConfiguration->bids[0]->bid->microAmount;
    
        $sql = "SELECT criterionid FROM criterion_data WHERE customerid=" . $_SESSION['account_number'] . " AND campaignid=".get_campaign_id($adgroupid)." AND adgroupid=".$adgroupid." AND criterionid=".$crid;
       // echo $sql;
//         echo '<br/>11';
//         echo $sql;
//         echo '<br/>';
        $result = $conn->query($sql);
        if(mysqli_num_rows($result)>0)
        {
            echo 9999;
            $mysql = "UPDATE criterion_data set crname='".mysqli_real_escape_string($conn,$crname)."', crbid='".$bid."',updated=NOW() WHERE customerid=" . $_SESSION['account_number'] . " AND campaignid=".get_campaign_id($adgroupid)." AND adgroupid=".$adgroupid." AND criterionid=".$crid;
              echo '<br/>12';
                    echo $mysql;
                    echo '<br/>';
            $conn->query($mysql);
        }
        else {
            echo 8888;
            $mysql = "INSERT INTO criterion_data( customerid, campaignid, adgroupid, criterionid, crname, crbid, added) VALUES (". $_SESSION['account_number'] . ",".get_campaign_id($adgroupid).",".$adgroupid.",".$crid.",'".mysqli_real_escape_string($conn,$crname)."','".$bid."',NOW())";
            //  echo $mysql;
            echo '<br/>13';
            echo $mysql;
            echo '<br/>';
            $conn->query($mysql);
        }
                      }
            }
        }
        // Advance the paging index.
        $selectors->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($pages->totalNumEntries > $selectors->paging->startIndex);
}


function get_campaign_id($adgroupid)
{
    global $conn;
    $sql = "SELECT campaignid FROM adgroup_data WHERE customerid=".$_SESSION['account_number']." AND adgroupid=".$adgroupid;
//     echo '<br/>14';
//     echo $sql;
//     echo '<br/>';
    $result = $conn->query($sql);
    $obj=mysqli_fetch_object($result);
    return $obj->campaignid;

}

function get_adgroupid_bycampaignid(AdWordsUser $user,$campaignid)
{
    global $conn;
    $adgroup = array();
    $sql = "SELECT adgroupid FROM adgroup_data WHERE customerid=".$_SESSION['account_number']." AND campaignid=".$campaignid;
//     echo '<br/>15';
//     echo $sql;
//     echo '<br/>';
    $result = $conn->query($sql);
    if(mysqli_num_rows($result)>0)
    {
        while($row = mysqli_fetch_object($result))
        {
            $adgroup[] = $row->adgroupid;
        }
    }
    return $adgroup;
}

function getCampaigns(AdWordsUser $user)
{
    global $zb;
    $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
    $customerSyncService = $user->GetService('CustomerSyncService', ADWORDS_VERSION);
    // Get an array of all campaign ids.
    $campaignIds = array();
    $selector = new Selector();
    $selector->fields = array(
        'Id'
    );
    $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
    do {
        $i = 0;
        $page = $campaignService->get($selector);
        if (isset($page->entries)) {
            foreach ($page->entries as $campaign) {
                
                $campaignIds[] = $campaign->id;
            }
        }
        $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($page->totalNumEntries > $selector->paging->startIndex);
    
    $len = count($campaignIds);
    $part = 3;
    $seg = 3;
    $count = ceil($len / 3);
    for ($i = 0; $i < $count; $i ++) {
        $zb ++;
        GetAccountChangesExample($user, array_slice($campaignIds, $i * $part, $seg));
        // print_r(array_slice($campaignIds, $i$part, $seg)).'<br/>';
    }
}

function GetAccountChangesExample(AdWordsUser $user, $campaignIds)
{
    global $conn;
    // Get the service, which loads the required classes.
    $customerSyncService = $user->GetService('CustomerSyncService', ADWORDS_VERSION);
    
    if (count($campaignIds) <= 0) {
        return;
    }
    
    date_default_timezone_set("PST8PDT");
    $dateTimeRange = new DateTimeRange();
    $mintime = '';
    $sql = "SELECT lasttime FROM timetable WHERE customerid=" . $_SESSION['account_number'];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_object()) {
            $mintime = $row->lasttime;
        }
    }
    if (strlen($mintime) < 15) {
        $mintime = date('Ymd his', strtotime('-1 day'));
    }
     //$mintime = date ( 'Ymd his', strtotime ( '-6 day' ) );
    $dateTimeRange->min = $mintime;
    $dateTimeRange->max = date('Ymd his');
    // Create selector.
    $selector = new CustomerSyncSelector();
    $selector->dateTimeRange = $dateTimeRange;
    $selector->campaignIds = $campaignIds;
    // $selector->campaignIds = $campaignID;
    // $selector->fields = array('changedAdGroups','changedAds');
    // Make the get request.
    try{
    $accountChanges = $customerSyncService->get($selector);
    }catch(Exception $e)
    {
        echo $e->getMessage();
    }
    $m = 0;
    // Display results.
    if (isset($accountChanges)) {
        //print_r($accountChanges);
        // printf ( "Most recent change: %s\n", $accountChanges->lastChangeTimestamp );
        if (isset($accountChanges->changedCampaigns)) {
            foreach ($accountChanges->changedCampaigns as $campaignChangeData) {
                
                $sql = "SELECT * FROM campaign_data WHERE campaignid=$campaignChangeData->campaignId AND customerid=" . $_SESSION['account_number'];
//                 echo '<br/>16';
//                 echo $sql;
//                 echo '<br/>';
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                   //echo '1'.$sql;
                    if ($campaignChangeData->campaignChangeStatus == 'FIELDS_CHANGED') {
                        echo "<br/>CmpId ".$campaignChangeData->campaignId."<br/>";
                        campaign_changed_update($user, $campaignChangeData->campaignId, 0);
                        
                        if (isset($campaignChangeData->changedAdGroups)) {
                            echo 4;
                            echo "<br/>CmpId ".$campaignChangeData->campaignId."<br/>";
                            $adid = $campaignChangeData->changedAdGroups[0]->adGroupId;
                            $sql = "SELECT * FROM adgroup_data WHERE campaignid=$campaignChangeData->campaignId AND customerid=" . $_SESSION['account_number'] . " AND adgroupid=".$adid;
//                             echo '<br/>17';
//                             echo $sql;
//                             echo '<br/>';
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                echo 5;
                        
                                foreach ($campaignChangeData->changedAdGroups as $adGroupChangeData) {
                                    if ($adGroupChangeData->adGroupChangeStatus == 'FIELDS_CHANGED') {
                                        echo 6;
                        echo '<br/>';
                        print_r($adGroupChangeData);
                        echo '<br/>';
                                        adgroup_changed_update($user, $adGroupChangeData->adGroupId, campaign_advert_type($campaignChangeData->campaignId));
                                    } else
                                        if ($adGroupChangeData->adGroupChangeStatus == 'NEW') {
                                            echo 7;
                        
                                            adgroup_changed_insert($user, $adGroupChangeData->adGroupId, campaign_advert_type($campaignChangeData->campaignId));
                                        } else {
                                            echo 8;
                                            if (strlen(ArrayToString($adGroupChangeData->changedCriteria)) > 1) {
                                                echo 9;
                                                 
                                                if (campaign_advert_type($campaignChangeData->campaignId) == 'SHOPPING') {
                                                    echo 10;
                                                    adgroup_changed_update($user, $adGroupChangeData->adGroupId, campaign_advert_type($campaignChangeData->campaignId));
                                                }
                                            }
                                            else
                                            {
                                                echo 11;
                                                echo ArrayToString($adGroupChangeData->changedCriteria);
                                                print_r(ArrayToString($adGroupChangeData->changedCriteria));
                                            }
                        
                                        }
                                }
                            }
                            else
                            {
                                echo 12;
                                adgroup_changed_insert($user, $adid,  campaign_advert_type($campaignChangeData->campaignId));
                        
                            }
                        }
                        
                    }
                    if ($campaignChangeData->campaignChangeStatus == 'NEW') {
                        
                        list($ID, $TYPE) = campaign_changed_update($user, $campaignChangeData->campaignId);
                        adgroup_changed_insert($user, $ID, $TYPE, 0);
                        if (isset($campaignChangeData->changedAdGroups)) {
                            echo 4;
                            $adid = $campaignChangeData->changedAdGroups[0]->adGroupId;
                            $sql = "SELECT * FROM adgroup_data WHERE campaignid=$campaignChangeData->campaignId AND customerid=" . $_SESSION['account_number'] . " AND adgroupid=".$adid;
//                             echo '<br/>18';
//                             echo $sql;
//                             echo '<br/>';
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                echo 5;
                        
                                foreach ($campaignChangeData->changedAdGroups as $adGroupChangeData) {
                                    if ($adGroupChangeData->adGroupChangeStatus == 'FIELDS_CHANGED') {
                                        echo 6;
                        
                                        adgroup_changed_update($user, $adGroupChangeData->adGroupId, campaign_advert_type($campaignChangeData->campaignId));
                                    } else
                                        if ($adGroupChangeData->adGroupChangeStatus == 'NEW') {
                                            echo 7;
                        
                                            adgroup_changed_insert($user, $adGroupChangeData->adGroupId, campaign_advert_type($campaignChangeData->campaignId));
                                        } else {
                                            echo 8;
                                            if (strlen(ArrayToString($adGroupChangeData->changedCriteria)) > 1) {
                                                echo 9;
                                                 
                                                if (campaign_advert_type($campaignChangeData->campaignId) == 'SHOPPING') {
                                                    echo 10;
                                                    adgroup_changed_update($user, $adGroupChangeData->adGroupId, campaign_advert_type($campaignChangeData->campaignId));
                                                }
                                            }
                                            else
                                            {
                                                echo 11;
                                                echo ArrayToString($adGroupChangeData->changedCriteria);
                                                print_r(ArrayToString($adGroupChangeData->changedCriteria));
                                            }
                        
                                        }
                                }
                            }
                            else
                            {
                                echo 12;
                                adgroup_changed_insert($user, $adid,  campaign_advert_type($campaignChangeData->campaignId));
                        
                            }
                        }
                    }
                    
                } else {
                    echo 3;
                    
                    list($ID, $TYPE) = campaign_changed_insert($user, $campaignChangeData->campaignId);
                    
                    adgroup_changed_insert($user, $ID, $TYPE, 0);
                    if (isset($campaignChangeData->changedAdGroups)) {
                        echo 404;
                        echo "<br/>CmpId ".$campaignChangeData->campaignId."<br/>";
                        $adid = $campaignChangeData->changedAdGroups[0]->adGroupId;
                        $sql = "SELECT * FROM adgroup_data WHERE campaignid=$campaignChangeData->campaignId AND customerid=" . $_SESSION['account_number'] . " AND adgroupid=".$adid;
//                         echo '<br/>19';
//                         echo $sql;
//                         echo '<br/>';
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            echo 5;
                    
                            foreach ($campaignChangeData->changedAdGroups as $adGroupChangeData) {
                                if ($adGroupChangeData->adGroupChangeStatus == 'FIELDS_CHANGED') {
                                    echo 6;
                    
                                    adgroup_changed_update($user, $adGroupChangeData->adGroupId, campaign_advert_type($campaignChangeData->campaignId));
                                } else
                                    if ($adGroupChangeData->adGroupChangeStatus == 'NEW') {
                                        echo 7;
                    
                                        adgroup_changed_insert($user, $adGroupChangeData->adGroupId, campaign_advert_type($campaignChangeData->campaignId));
                                    } else {
                                        echo 8;
                                        if (strlen(ArrayToString($adGroupChangeData->changedCriteria)) > 1) {
                                            echo 9;
                                             
                                            if (campaign_advert_type($campaignChangeData->campaignId) == 'SHOPPING') {
                                                echo 10;
                                                adgroup_changed_update($user, $adGroupChangeData->adGroupId, campaign_advert_type($campaignChangeData->campaignId));
                                            }
                                        }
                                        else
                                        {
                                            echo 11;
                                            echo ArrayToString($adGroupChangeData->changedCriteria);
                                            print_r(ArrayToString($adGroupChangeData->changedCriteria));
                                        }
                    
                                    }
                            }
                        }
                        else
                        {
                            echo 12;
                            adgroup_changed_insert($user, $adid,  campaign_advert_type($campaignChangeData->campaignId));
                    
                        }
                    }
                }
                
                
                
            }
        }
    } else {
        print "No changes were found.\n";
    }
    
    $sql = "UPDATE timetable SET lasttime='" . substr($accountChanges->lastChangeTimestamp, 0, 15) . "', updated=NOW() WHERE customerid=" . $_SESSION['account_number'];
    $conn->query($sql);
}

/**
 * Converts an array of values to a comma-separated string.
 *
 * @param array $array
 *            an array of values that can be converted to a string
 * @return string a comma-separated string of the values
 */
function ArrayToString($array)
{
    if (! isset($array)) {
        return '';
    } else {
        return implode(', ', $array);
    }
}

function GetAccounts(AdWordsUser $user)
{
    $managedCustomerService = $user->GetService('ManagedCustomerService', ADWORDS_VERSION);
    $selector = new Selector();
    // Specify the fields to retrieve.
    $selector->fields = array(
        'CustomerId',
        'CompanyName',
        'Name',
        'CurrencyCode'
    );
    $selector->ordering[] = new OrderBy('Name', 'ASCENDING');
    // Make the get request.
    $graph = $managedCustomerService->get($selector);
    // Display serviced account graph.
    if (isset($graph->entries)) {
        // Create map from customerId to parent and child links.
        $childLinks = array();
        $parentLinks = array();
        if (isset($graph->links)) {
            foreach ($graph->links as $link) {
                $childLinks[$link->managerCustomerId][] = $link;
                $parentLinks[$link->clientCustomerId][] = $link;
            }
        }
        // Create map from customerID to account, and find root account.
        $accounts = array();
        $rootAccount = NULL;
        foreach ($graph->entries as $account) {
            $accounts[$account->customerId] = $account;
        }
        return $accounts;
    } else {
        return false;
    }
}
function customerDetails(AdWordsUser $user)
{
    $customerService = $user->GetService('CustomerService', ADWORDS_VERSION);
    $accounts = $customerService->get();//$selector
    // Display serviced account graph.
    $super =array();
    if (isset($accounts)) {
       /* echo '<pre>';
         print_r($accounts); 
        echo '</pre>'; */
        $super[]=$accounts;
        return $super;
        
    } 
  
}
try {
    // echo 'here';exit();
    // $conn->query('DELETE FROM `account_details` WHERE `mccid`=9197135874');
    
     $mysql = "SELECT * FROM prospect_credentials WHERE account_status=1";
    $rezult = $conn->query($mysql);
    $m = 0;
    if ($rezult->num_rows > 0) {
        while ($row = $rezult->fetch_object()) {
            
            $m ++;
            $oauth2Info = array(
                "client_id" => $clientId,
                "client_secret" => $clientSecret,
                "refresh_token" => $row->refresh_token
            );
            $mccid = $row->account_number;
            $manage = $row->manage;
            $user = new AdWordsUser(NULL, $developerToken, $userAgent, $row->account_number, NULL, $oauth2Info);
            $accounts = $row->manage==0? customerDetails($user): GetAccounts($user);
            $conn->query("DELETE FROM account_details WHERE mccid='$mccid'");
            if (count($accounts) > 0) {
                foreach ($accounts as $a) {
                    
 $name = $manage==1?mysqli_real_escape_string($conn, $a->name):mysqli_real_escape_string($conn, $a->descriptiveName);
                    $company = mysqli_real_escape_string($conn, $a->companyName); // currencyCode
                    $sql = "INSERT INTO account_details( name,account_number,company_name,currency_code, added,mccid,prospect) VALUES ('$name','$a->customerId','$company','$a->currencyCode',NOW(),'$mccid'," . $row->prospect . ")";
                    $conn->query($sql);
                }
            }
        }
    }
    
    $skl = "SELECT customerid FROM timetable ";
    $result = $conn->query($skl);
    $customer = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_object()) {
            $customer[] = $row->customerid;
        }
    }
    $sql = "SELECT account_number FROM account_details ORDER BY  id ASC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_object()) {
            if (array_search($row->account_number, $customer) === false) {
                $sql = "INSERT INTO timetable(customerid)values(" . $row->account_number . ")";
                $conn->query($sql);
            }
        }
    } 
    
    $sqla = "SELECT *,a.account_number AS account FROM prospect_credentials p INNER JOIN account_details a ON p.account_number=a.mccid WHERE  account_status=1  ";// AND a.account_number=1226811775  AND a.account_number=1226811775
    // 12268117756539291121 AND a.account_number=1226811775 5493971629  1728364983 AND a.account_number=1728364983
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
            getCampaigns($user);
            // GetAccountChangesExample($user);
            // getCamapaigns($user);
            // echo $col->refresh_token."|||".$id['account']."||".$id['mcc']."<br/>";
        }
    }
    
 
} catch (Exception $e) {
    printf("An error has occurred: %s\n", $e->getMessage());
}

