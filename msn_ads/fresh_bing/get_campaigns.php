<?php

// To ensure that a cached WSDL is not being used,
// disable WSDL caching.
ini_set("soap.wsdl_cache_enabled", "0");

try
{
    $accountId = 1118271; // Application-specific value.
    
    // Use either the sandbox or the production URI.
    // This example is for the sandbox URI.
    $URI =
        "https://api.sandbox.bingads.microsoft.com/Api/Advertiser/v10/";
    // The following commented-out line contains the production URI.
    //$URI = "https://adcenterapi.microsoft.com/api/advertiser/v8/";

    // The API namespace.
    $xmlns = "https://adcenter.microsoft.com/v10";

    // The proxy for the Campaign Management Web service.
    $campaignProxy = 
        $URI . "CampaignManagement/CampaignManagementService.svc?wsdl";

    // The name of the service operation that will be called.
    $action = "GetCampaignsByAccountId";

    // The user name, password, and developer token are
    // expected to be passed in as command-line
    // arguments.
    // $argv[0] is the PHP file name.
    // $argv[1] is the user name.
    // $argv[2] is the password.
    // $argv[3] is the developer token.
   /*  if ($argc !=4)
    {
        printf("Usage:\n");
        printf(
          "php file.php username password devtoken\n");
        exit(0);
    } */
    $username = "vbridgellp";
    $password = "vbridge123";
    $developerToken = "0071M925I6679867";
    
    $applicationToken = "EwD4AnhlBAAUxT83/QvqiAZEx5SuwyhZqHzk21oAAaN3Ah918yWR6U8Ewn99Xo5sh6wD3KOYdWQcLjM5gK1Dyi02v1hGpZbfifDtPlweNWmZMs2ZLUTS4PWqK9QDgwj5GgWVq1N7g5udFHFgqRMsJRI2Fo5skcrbVZZ0EJfsX1Rpw/qCwnSoxWSnNxQEtHYMtPjd67PjfWS7XCtOLfaUZb/ax37DHtULP2JvGW0B0Pf/1Uri1KBIr2+FKno22wd2NJwkLohHge8kr+HayV0eRwwrm9oLuNEC2VlUbsrBQkiddbFS6QmVx8dOig8sJ/MAZT5gjKbu/IaQY3XrjwaWZZyATZueibmuHDOx2JXg/Dn/8YBfetcDTleppiqltl4DZgAACPmWWyh5xQoQyAEupxP8GtZxMv1dpTkX8yCE2NH4ymSAVIZniSyup2eZheSHm4mefI+lh9EjcH/J0UeN25ZGtFTyBMo8Q9QIf0wYUrU2HvCrJL4pPlgia9VoXFABFN+EPxlesRsIbKsuAfVkGtCEOeJmbeFmdWG6sGvNPSPmGf01ocuvm8Ob+Jvn4Ky2PmD+ScwVhgrUFzAebcdfeBdrHkE+OVoXApnKRaITWCnBJ6uZBSeRzdSRLP8iHJwj243kFZ/SPr4wsdwUjfqkLs00Cx4iGowBV7QjCb3BkIsJYinUJG22oscpUpSCSZC0CRGWCC2LQIrHpFKp2heocJ7rxaOa59d1q/5hMMDqpRxbUUF32R42x1YXFjRUPDtvMUav99WuoH9qJehHUZaS8bGnGhUalDD38+c4jtdAt0RA/C9z+jseMB284nao59vMEvrxP3iQ4GohbMwZ4uUAD/molXEliDD3hD/LyKd4+nS11sobYf21JweSSt4CbdHB9tgkhOsjP/XVP6ANfYHmtdlKgUZw5j5MyTqkhCT3zf7Q+UPcDQw5wuWDdobRk53K48SpQQrAJPi7O4OwS4lknODjdZSXbd6fmPrF7UyegpDRx+JruxrxAQ==";

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


    // Create the SOAP input header array.
    $inputHeaders = array
    (
        $headerApplicationToken,
        $headerDeveloperToken,
        $headerUserName,
        $headerPassword,
        $headerCustomerAccountId
    );

    // Create the SOAP client.
    $opts = array('trace' => true);
    $client = new SOAPClient($campaignProxy, $opts); 

    // Specify the parameters for the SOAP call.
    $params = array
    (
        'AccountId' => $accountId,
    );

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
     
    // Retrieve the campaigns.
    if (isset(
        $result->Campaigns
        ))
    {
        if (is_array($result->Campaigns->Campaign))
        {
            // An array of campaigns has been returned.
            $obj = $result->Campaigns->Campaign;
        }
        else
        {
            // A single campaign has been returned.
            $obj = $result->Campaigns;
        }
        
        // Display the campaigns.
        foreach ($obj as $campaign)
        {
            print "Name          : " . $campaign->Name . "\n";
            print "Description   : " . $campaign->Description . "\n";
            print "MonthlyBudget : " . $campaign->MonthlyBudget . "\n";
            print "BudgetType    : " . $campaign->BudgetType . "\n";
            print "\n";
        }
    }
}

catch (Exception $e)
{
    print "$action failed.\n";
    
    if (isset($e->detail->ApiFaultDetail))
    {
      print "ApiFaultDetail exception encountered\n";
      print "Tracking ID: " . 
          $e->detail->ApiFaultDetail->TrackingId . "\n";

      // Process any operation errors.
      if (isset(
          $e->detail->ApiFaultDetail->OperationErrors->OperationError
          ))
      {
          if (is_array(
              $e->detail->ApiFaultDetail->OperationErrors->OperationError
              ))
          {
              // An array of operation errors has been returned.
              $obj = $e->detail->ApiFaultDetail->OperationErrors->OperationError;
          }
          else
          {
              // A single operation error has been returned.
              $obj = $e->detail->ApiFaultDetail->OperationErrors;
          }
          foreach ($obj as $operationError)
          {
              print "Operation error encountered:\n";
              print "\tMessage: ". $operationError->Message . "\n"; 
              print "\tDetails: ". $operationError->Details . "\n"; 
              print "\tErrorCode: ". $operationError->ErrorCode . "\n"; 
              print "\tCode: ". $operationError->Code . "\n"; 
          }
      }

      // Process any batch errors.
      if (isset(
          $e->detail->ApiFaultDetail->BatchErrors->BatchError
          ))
      {
          if (is_array(
              $e->detail->ApiFaultDetail->BatchErrors->BatchError
              ))
          {
              // An array of batch errors has been returned.
              $obj = $e->detail->ApiFaultDetail->BatchErrors->BatchError;
          }
          else
          {
              // A single batch error has been returned.
              $obj = $e->detail->ApiFaultDetail->BatchErrors;
          }
          foreach ($obj as $batchError)
          {
              print "Batch error encountered for array index " . $batchError->Index . ".\n";
              print "\tMessage: ". $batchError->Message . "\n"; 
              print "\tDetails: ". $batchError->Details . "\n"; 
              print "\tErrorCode: ". $batchError->ErrorCode . "\n"; 
              print "\tCode: ". $batchError->Code . "\n"; 
          }
      }
    }

    if (isset($e->detail->AdApiFaultDetail))
    {
      print "AdApiFaultDetail exception encountered\n";
      print "Tracking ID: " . 
          $e->detail->AdApiFaultDetail->TrackingId . "\n";

      // Process any operation errors.
      if (isset(
          $e->detail->AdApiFaultDetail->Errors
          ))
      {
          if (is_array(
              $e->detail->AdApiFaultDetail->Errors
              ))
          {
              // An array of errors has been returned.
              $obj = $e->detail->AdApiFaultDetail->Errors;
          }
          else
          {
              // A single error has been returned.
              $obj = $e->detail->AdApiFaultDetail->Errors;
          }
          foreach ($obj as $Error)
          {
              print "Error encountered:\n";
              print "\tMessage: ". $Error->Message . "\n"; 
              print "\tDetail: ". $Error->Detail . "\n"; 
              print "\tErrorCode: ". $Error->ErrorCode . "\n"; 
              print "\tCode: ". $Error->Code . "\n"; 
          }
      }

    }

    // Display the fault code and the fault string.
    print $e->faultcode . " " . $e->faultstring . ".\n";

    // Output the last request.
    print "Last SOAP request:\n";
    print $client->__getLastRequest() . "\n";
}

?>