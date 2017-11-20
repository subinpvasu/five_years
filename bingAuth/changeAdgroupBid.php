<?php

ini_set("log_errors", 1);
ini_set("error_log", "php-error.log");
error_log( "Hello, errors!" );

include 'bingads\CampaignManagementClasses.php';
include 'bingads\ClientProxy.php'; 
include 'ClientCredentials.php'; 

use BingAds\CampaignManagement\GetCampaignsByAccountIdRequest ; 
use BingAds\Proxy\ClientProxy;

$wsdl = "https://api.bingads.microsoft.com/Api/Advertiser/CampaignManagement/V9/CampaignManagementService.svc?singleWsdl";

try{
	echo "aaaaa";
    $cp = new ClientProxy($wsdl);
	$proxy = $cp->ConstructWithAccountAndCustomerId($wsdl, $username, $password, $developerToken, $accountId, $customerId, $authenticationToken);
	echo "bbbb";
	$request = new GetCampaignsByAccountIdRequest();
    $request->AccountId = $AccountId;
	echo "cccc";
	$campaigns = $proxy->GetService()->GetNegativeKeywordsByEntityIds($request);
	
	echo "<pre>";
	print_r($campaigns);

}
catch (Exception $e)
{
	echo $e->detail->AdApiFaultDetail->Errors->AdApiError->Code ;
	if($e->detail->AdApiFaultDetail->Errors->AdApiError->Code==109){
	
		include('refreshAccessToken.php');
		header('Location: '.$_SERVER['PHP_SELF']);
	}
   echo "<pre>";
   print_r($e);
   echo "</pre>";
    // Display the fault code and the fault string.
    print $e->faultcode . " " . $e->faultstring . ".\n";

    // Output the last request.
    print "<br />Last SOAP request:\n";
    print $client->__getLastRequest() . "\n";
	
	
	
	
}


