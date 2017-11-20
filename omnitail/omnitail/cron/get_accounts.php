<?php

// Include the initialization file
require_once dirname ( dirname ( __FILE__ ) ) . '/init.php';
require_once ('../../config/config.php');
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
			'Name',
			'CurrencyCode'
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

try {
	// Get AdWordsUser from credentials in "../auth.ini"
	// relative to the AdWordsUser.php file's directory.
	// $refresh_token = "1/izoBSK3Adjirj_nGBgORSZyS21qtfW_FAlxysBdLvHk";
	// $developerToken = 'dDdipQC2xWmL2WIIDCDvYw';
	// $userAgent = 'vbridge';
	// $oauth2Info = array(
	// "client_id" => "603826599811-0ugc0p9t59jl30k7k8s7cgj18unuccrv.apps.googleusercontent.com",
	// "client_secret" => "gZM21g6iOLqAQ27zBmG4RclZ",
	// "refresh_token" => $refresh_token
	// );
	// $user = new AdWordsUser(NULL,$developerToken,NULL,$userAgent,NULL,NULL,$oauth2Info);
	$user = new AdWordsUser ();
	// Log every SOAP XML request and response.
	$user->LogAll ();
	
	// Run the example.
	
	$accounts = GetAccounts ( $user );
	//print_r($accounts);
	$conn->query ( 'TRUNCATE TABLE account_details' );
	foreach ( $accounts as $a ) {
		$name = mysqli_real_escape_string($conn,$a->name);
		$company = mysqli_real_escape_string($conn,$a->companyName);//currencyCode
		$sql = "INSERT INTO account_details( name,account_number,company_name,currency_code, added) VALUES ('$name','$a->customerId','$company','$a->currencyCode',NOW())";
		if ($conn->query ( $sql ) === FALSE) {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		//echo $a->customerId.'<br/>';
	}
	$conn->close ();
} catch ( Exception $e ) {
	printf ( "An error has occurred: %s\n", $e->getMessage () );
}
