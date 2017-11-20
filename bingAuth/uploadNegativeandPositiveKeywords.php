<?php

include('ClientCredentials.php');
// To ensure that a cached WSDL is not being used,
// disable WSDL caching.
ini_set("soap.wsdl_cache_enabled", "0");
$log_filename = 'logs/neg_and_positive_keywords_log_'.date('Y_m_d_H_i_s').'.txt';
$adgroupId = "3471294088";

$keywords = array();

$keywords[] = array("Text"=>"Arif pos Test 1","MatchType"=>"Content","Bid"=>0.55);
$keywords[] = array("Text"=>"Arif pos Test 2","MatchType"=>"Content","Bid"=>0.55);
$keywords[] = array("Text"=>"Arif pos Test 3","MatchType"=>"Content","Bid"=>0.55);

$NegativeKeywords = array();

$NegativeKeywords[]=array("Text"=>"Arif neg 1","MatchType"=>"Exact");
$NegativeKeywords[]=array("Text"=>"Arif neg 2","MatchType"=>"Exact");


try
{
    $URI = "https://api.bingads.microsoft.com/Api/Advertiser/";
	
    // The API namespace.
    $xmlns = "https://bingads.microsoft.com/CampaignManagement/v9";

    // The proxy for the Campaign Management Web service.
    $campaignProxy = 
        $URI . "CampaignManagement/v9/CampaignManagementService.svc?wsdl";

    
	$AuthenticationToken = $accessToken ;

    // Create the SOAP headers.
    $headerApplicationToken = 
        new SoapHeader
        (
            $xmlns,
            'ApplicationToken',
            $applicationToken,
            false
        );
    $headerDeveloperToken = 
        new SoapHeader
        (
            $xmlns,
            'DeveloperToken',
            $developerToken,
            false
        );
    $headerUserName = 
        new SoapHeader
        (
            $xmlns,
            'UserName',
            $username,
            false
        );
    $headerPassword = 
        new SoapHeader
        (
            $xmlns,
            'Password',
            $password,
            false
        );

    $headerCustomerAccountId = 
        new SoapHeader
        (
            $xmlns,
            'CustomerAccountId',
            $accountId,
            false
        );
		
		
	$headerAuthenticationToken = 
        new SoapHeader
        (
            $xmlns,
            'AuthenticationToken',
            $authenticationToken,
            false
        );


    // Create the SOAP input header array.
    $inputHeaders = array
    (
        $headerApplicationToken,
        $headerDeveloperToken,
        $headerUserName,
        $headerPassword,
        $headerCustomerAccountId,
        $headerAuthenticationToken
		
    );

    // Create the SOAP client.
    $opts = array('trace' => true);
	
	echo "<br/>Create the SOAP client<br/>";
    $client = new SOAPClient($campaignProxy, $opts); 

	/* ADD POSITIVE KEYWORDS TO ADGROUP */
	
	// The name of the service operation that will be called.
    $action = "AddKeywords";
	
    // Specify the parameters for the SOAP call.
    $params = array
    (
        'AdGroupId' => $adgroupId,
		'Keywords' => $keywords
    );

	echo "<br/>Execute the SOAP call <br/>";
    // Execute the SOAP call.
    $result = $client->__soapCall
    (
        $action,
        array( $action.'Request' => $params ),
        null,
        $inputHeaders,
        $outputHeaders
    );

    
		
     print "Successful $action call.\n";
     print "TrackingId output from response header: "
          . $outputHeaders['TrackingId']
          . ".\n";
     
     // Insert a blank line to separate the text that follows.
     print "\n";
     
	/* ADD Negative KEYWORDS TO ADGROUP */
	
	// The name of the service operation that will be called.
    $action = "AddNegativeKeywordsToEntities";
	
	$EntityNegativeKeywords = array(array("EntityId"=>$adgroupId,"EntityType"=>"AdGroup","NegativeKeywords"=>$NegativeKeywords));
	
    // Specify the parameters for the SOAP call.
    $params = array
    (
        'EntityNegativeKeywords' => $EntityNegativeKeywords,
		
    );

	echo "<br/>Execute the SOAP call <br/>";
    // Execute the SOAP call.
    $result = $client->__soapCall
    (
        $action,
        array( $action.'Request' => $params ),
        null,
        $inputHeaders,
        $outputHeaders
    );
	$request_log = $client->__getLastRequest() . PHP_EOL ;
	$response_log= $client->__getLastResponse(). PHP_EOL;
    $log_file = fopen($log_filename, 'a+');
	fwrite($log_file, 'Request Sample'.PHP_EOL);
	fwrite($log_file, $request_log);
	fwrite($log_file, 'Response Sample'.PHP_EOL);
	fwrite($log_file, $response_log.PHP_EOL); // Add http response to file
	fclose($log_file);
     print "Successful $action call.\n";
     print "TrackingId output from response header: "
          . $outputHeaders['TrackingId']
          . ".\n";
     
     // Insert a blank line to separate the text that follows.
     print "\n";
     
    
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

?>