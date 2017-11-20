<?php
require_once ('../../config/config.php');
/**
 * This example gets all campaigns in the account. To add a campaign, run
 * AddCampaign.php.
 *
 * Copyright 2014, Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package    GoogleApiAdsAdWords
 * @subpackage v201509
 * @category   WebServices
 * @copyright  2014, Google Inc. All Rights Reserved.
 * @license    http://www.apache.org/licenses/LICENSE-2.0 Apache License,
 *             Version 2.0
 */

// Include the initialization file
require_once dirname(dirname(__FILE__)) . '/init.php';

/**
 * Runs the example.
 * @param AdWordsUser $user the user to run the example with
 */
function GetCampaignsExample(AdWordsUser $user) {
	global $conn;
	
  // Get the service, which loads the required classes.
  $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);

  // Create selector.
  $selector = new Selector();
  $selector->fields = array('Id', 'Name','AdvertisingChannelType');
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

/**
 * Adgroup entries
 * 
 */
function GetAdGroupsExample(AdWordsUser $user, $campaignId) {
	global $conn;
	// Get the service, which loads the required classes.
	$adGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);

	// Create selector.
	$selector = new Selector();
	$selector->fields = array('Id', 'Name','CampaignId','CampaignName','CpcBid');
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
				//         printf("Ad group with name '%s' and ID '%s' was found.\n",
				//             $adGroup->name, $adGroup->id);
				//         echo '<br/>';
				/* $bid = $adGroup->biddingStrategyConfiguration->bids[0]->bid->microAmount;
				$sql = "INSERT INTO adgroup_data(customerid, campaignid, adgroupid,campaign_name,adgroup_name,bid,added) VALUES
      			('".$_SESSION['customer']."','".$adGroup->campaignId."','".$adGroup->id."','".$adGroup->campaignName."','".$adGroup->name."','".$bid."',NOW())";
				//echo $sql.'</br>';
				$conn->query($sql); */
			}
		} /* else {
			print "No ad groups were found.\n";
		} */

		// Advance the paging index.
		$selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
	} while ($page->totalNumEntries > $selector->paging->startIndex);
}

/**
 * Account entries
 */
 
function GetAccounts(AdWordsUser $user) {

	// https://developers.google.com/adwords/api/docs/appendix/selectorfields#v201406-ManagedCustomerService
	// Get the service, which loads the required classes.
	$managedCustomerService = $user->GetService ( 'ManagedCustomerService', ADWORDS_VERSION );

	// Create selector.
	$selector = new Selector ();
	// Specify the fields to retrieve.
	$selector->fields = array (
			'CustomerId',
			'CompanyName',
			'Name'
	);
	// 'Login', 'Name','CompanyName','CanManageClients'
	$selector->ordering [] = new OrderBy ( 'Name', 'ASCENDING' );
	// Make the get request.
	$graph = $managedCustomerService->get ( $selector );

	// Display serviced account graph.
	if (isset ( $graph->entries )) {
		// Create map from customerId to parent and child links.
		$childLinks = array ();
		$parentLinks = array ();
		if (isset ( $graph->links )) {
			foreach ( $graph->links as $link ) {
				$childLinks [$link->managerCustomerId] [] = $link;
				$parentLinks [$link->clientCustomerId] [] = $link;
			}
		}
		// Create map from customerID to account, and find root account.
		$accounts = array ();
		$rootAccount = NULL;
		foreach ( $graph->entries as $account ) {
				
			$accounts [$account->customerId] = $account;
		}
		return $accounts;
	} else {
		return false;
	}
}

// Don't run the example if the file is being included.
/* if (__FILE__ != realpath($_SERVER['PHP_SELF'])) {
  return;
}
 */
try {
  // Get AdWordsUser from credentials in "../auth.ini"
  // relative to the AdWordsUser.php file's directory.
  // Get AdWordsUser from credentials in "../auth.ini"
	// relative to the AdWordsUser.php file's directory.
	
    $sql = "SELECT *,a.account_number AS account FROM prospect_credentials p INNER JOIN account_details a ON p.account_number=a.mccid WHERE p.account_number=1226811775";
    $result = $conn->query ( $sql );
    if ($result->num_rows > 0) {
        while ( $row = $result->fetch_object () ) {
           // print_r($row);
            
       $userAgent = 'Omnitail';
       $oauth2Info = array(
               "client_id" => $clientId,
               "client_secret" => $clientSecret,
               "refresh_token" => $row->refresh_token
           );
     $user = new AdWordsUser(NULL,$developerToken,$userAgent,NULL,NULL,$oauth2Info);//clientCustomerId = "6743897063"9197135874
     $user->SetClientCustomerId ($row->account);
	 $user->LogAll();
     try{
     //$accounts = GetAccounts ( $user );
     GetCampaignsExample($user);
     
     }
     catch(Exception $e)
     {
         echo $e->getMessage();
     }
     /* echo '<pre>';
     foreach ( $accounts as $a ) {
         print_r($a);
         }
         echo '</pre>'; */
        }
    }
 
     
    
    
    
    
	
	
//	$user = new AdWordsUser ();
	// Log every SOAP XML request and response.
	
	
	// Run the example.
	
	
	//print_r($accounts);
	//$conn->query ( 'TRUNCATE TABLE account_details' );

		/* $name = mysqli_real_escape_string($conn,$a->name);
		$company = mysqli_real_escape_string($conn,$a->companyName);
		$sql = "INSERT INTO account_details( name,account_number,company_name, added) VALUES ('$name','$a->customerId','$company',NOW())";
		if ($conn->query ( $sql ) === FALSE) {
			echo "Error: " . $sql . "<br>" . $conn->error;
		} */
	
		//echo $a->customerId.'<br/>';
	
	
	///////////////////////accounts added.
	
	
//	$user = new AdWordsUser(NULL,$developerToken,NULL,$userAgent,NULL,NULL,$oauth2Info);
	//$conn->query('TRUNCATE TABLE campaign_data');
			//$sql = 'SELECT * FROM account_details';
			//$result = $conn->query($sql);
		//	while($row = $result->fetch_object()) {
			
			
// 			$user->SetClientCustomerId($row->account_number);
//  			$_SESSION['customer']=$row->account_number;
//  			GetCampaignsExample($user);
				//echo $row->account_number.'<br/>';
			/* $user->SetClientCustomerId(6539291121);
			$_SESSION['customer']=6539291121; */
		//	GetCampaignsExample($user);
		//	}
			
			/* $conn->query('TRUNCATE TABLE adgroup_data');
			$sql = 'SELECT * FROM campaign_data GROUP BY campaignid ORDER BY customerid ASC';
			$result = $conn->query($sql);
			while($row = $result->fetch_object()) {
			
				$user->SetClientCustomerId($row->customerid);
				$_SESSION['customer']=$row->customerid;
				GetAdGroupsExample($user,$row->campaignid);
			
			
// 							$user->SetClientCustomerId(7181722645);
// 				 			$_SESSION['customer']=7181722645;
// 				 			GetAdGroupsExample($user,139300724);
					
			} */
	
	//$user = new AdWordsUser ();

  // Log every SOAP XML request and response.
  //$user->LogAll();

  // Run the example.
 // GetCampaignsExample($user);
} catch (Exception $e) {
  printf("An error has occurred: %s\n", $e->getMessage());
}
