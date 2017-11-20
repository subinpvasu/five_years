<?php

// Include the BingAds\v10 namespaced class files available
// for download at http://go.microsoft.com/fwlink/?LinkId=322147
include 'bingads\v10\BulkClasses.php';
include 'bingads\ClientProxy.php';

// Specify the BingAds\Bulk objects that will be used.
use BingAds\v10\Bulk\DownloadCampaignsByAccountIdsRequest;
use BingAds\v10\Bulk\BulkDownloadEntity;
use BingAds\v10\Bulk\DataScope;
use BingAds\v10\Bulk\CampaignScope;
use BingAds\v10\Bulk\GetBulkDownloadStatusRequest;
use BingAds\v10\Bulk\DownloadFileType;
use BingAds\v10\Bulk\PerformanceStatsDateRange;
use BingAds\v10\Bulk\CustomDateRangeEnd;
use BingAds\v10\Bulk\CustomDateRangeStart;
use BingAds\v10\Bulk\Date;
use BingAds\v10\Bulk\GetBulkUploadUrlRequest;
use BingAds\v10\Bulk\ResponseMode;
use BingAds\v10\Bulk\GetBulkUploadStatusRequest;

// Specify the BingAds\Proxy objects that will be used.
use BingAds\Proxy\ClientProxy;

// Disable WSDL caching.

ini_set("soap.wsdl_cache_enabled", "0");
ini_set("soap.wsdl_cache_ttl", "0");

// Specify your credentials.

$UserName = "vbridgellp";
$Password = "vbridge123";
$DeveloperToken = "0071M925I6679867";
$CustomerId = 8008098;
$AccountId = 1118271;

// Bulk WSDL

$wsdl = "https://bulk.api.bingads.microsoft.com/Api/Advertiser/CampaignManagement/V10/BulkService.svc?singleWsdl";


// The full path to the bulk file.

$BulkFilePath = "c:\\bulk\\campaigns.zip";

// The full path to the previously extracted bulk file.
// This file is used to access the last sync time.

$ExtractedFilePath = "c:\\bulk\\extracted\\accounts.csv";

// The full path to the upload result file.

$UploadResultFilePath = "c:\\bulk\\uploadresults.zip";

// Specifies the bulk file format.

$FileFormat = DownloadFileType::Csv;


// Confirm that the download folder exist; otherwise, exit.

$length = strrpos($BulkFilePath, '\\');
$folder = substr($BulkFilePath, 0, $length);

// if (!is_dir($folder))
// {
//     printf("The output folder, %s, does not exist.\nEnsure that the " .
//         "folder exists and try again.", $folder);
//     return;
// }

try
{
    //  This example uses the UserName and Password elements for authentication. 
    $proxy = ClientProxy::ConstructWithAccountAndCustomerId($wsdl, $UserName, $Password, $DeveloperToken, $AccountId, $CustomerId, null);
    
    // For Managing User Authentication with OAuth, replace the UserName and Password elements with the AuthenticationToken, which is your OAuth access token.
    //$proxy = ClientProxy::ConstructWithAccountAndCustomerId($wsdl, null, null, $DeveloperToken, $AccountId, $CustomerId, "AuthenticationTokenGoesHere");
    
    $accounts = array();
    $accounts[] = $AccountId;

    $dataScope = DataScope::EntityData;
    
    $entities = array (
    	BulkDownloadEntity::Ads,
    	BulkDownloadEntity::AdGroups,
    	BulkDownloadEntity::Campaigns,
    	BulkDownloadEntity::Keywords,
        BulkDownloadEntity::AdGroupProductPartitions,
        BulkDownloadEntity::CampaignProductScopes
    	);

    $formatVersion = "4.0";
    
    $lastSyncTimeInUTC = GetLastSyncTime($ExtractedFilePath);
    
    // You may include PerformanceStatsDateRang if the lastSyncTime is null, and the data scope includes
    // either EntityPerformanceData, BidSuggestionsData, or QualityScoreData.
    
    /*
    date_default_timezone_set('UTC');
    $LastYear = date("Y") - 1;
    $performanceStatsDateRange = new PerformanceStatsDateRange();
    $performanceStatsDateRange->CustomDateRangeEnd = new Date();
    $performanceStatsDateRange->CustomDateRangeEnd->Day = 31;
    $performanceStatsDateRange->CustomDateRangeEnd->Month = 12;
    $performanceStatsDateRange->CustomDateRangeEnd->Year = $LastYear;
    $performanceStatsDateRange->CustomDateRangeStart = new Date();
    $performanceStatsDateRange->CustomDateRangeStart->Day = 1;
    $performanceStatsDateRange->CustomDateRangeStart->Month = 1;
    $performanceStatsDateRange->CustomDateRangeStart->Year = $LastYear;
    */
    
    // Use the bulk service to download a bulk file.
    // GetDownloadRequestId helper method calls the corresponding Bing Ads service operation
    // to request the download identifier.
    
    $downloadRequestId = GetDownloadRequestId(
    		$proxy,
    		$accounts,
    		$dataScope,
    		$FileFormat,
    		$entities,
                $formatVersion,
    		$lastSyncTimeInUTC,
    		null
    		);
    
    $waitTime = 5 * 1; 
        
    if ($downloadRequestId != null)
    {
        printf("Download Request Id: %s\n", $downloadRequestId);

        $downloadSuccess = false;
    
    	// This sample polls every 30 seconds up to 5 minutes.
    	// In production you may poll the status every 1 to 2 minutes for up to one hour.
    	// If the call succeeds, stop polling. If the call or 
    	// download fails, the call throws a fault.
    
    	for ($i = 0; $i < 10; $i++)
    	{
    		sleep($waitTime);
    
    		// GetDownloadRequestStatus helper method calls the corresponding Bing Ads service operation 
                // to get the download status.
            
    		$downloadRequestStatus = GetDownloadRequestStatus(
    			$proxy, 
    			$downloadRequestId
    			);
    
        	if (($downloadRequestStatus != null) && ($downloadRequestStatus == "Completed"))
        	{
        		$downloadSuccess = true;
        		break;
        	}
        }

        if ($downloadSuccess)
        {
            $downloadUrl = GetDownloadUrl(
            		$proxy,
            		$downloadRequestId
            		);
            printf("Downloading from %s.\n\n", $downloadUrl);
        //    DownloadFile($downloadUrl, $BulkFilePath);
            printf("The download file was written to %s.\n", $BulkFilePath);
            
        }
        else // Pending
        {
        	printf("The request is taking longer than expected.\n " .
        			"Save the download request ID (%s) and try again later.\n",
        			$downloadRequestId);
        }
    }
    
    // You may unzip and update the downloaded bulk file or prepare a new file elsewhere.
    // Changes to the bulk file are not shown here.

    DecompressFile($BulkFilePath, $ExtractedFilePath);
    CompressFile($ExtractedFilePath, $BulkFilePath);
    
    // Use the bulk service to upload a bulk file.
    
    $responseMode = ResponseMode::ErrorsAndResults;
    
    $uploadResponse = GetBulkUploadUrl(
    		$proxy, 
    		$AccountId, 
    		$responseMode
    		);
    
    $uploadRequestId = $uploadResponse->RequestId;
    $uploadUrl = $uploadResponse->UploadUrl;
    
    printf("Uploading file from %s.\n", $BulkFilePath);
    printf("Upload Request Id: %s\n", $uploadRequestId);
    printf("Upload Url: %s\n", $uploadUrl);
    
    UploadFile(
               $UserName, 
               $Password, 
               $DeveloperToken, 
               $CustomerId, 
               $AccountId,
               $uploadUrl, 
               $BulkFilePath
               );
    
    $uploadSuccess = false;
    
    // This sample polls every 30 seconds up to 5 minutes.
    // In production you may poll the status every 1 to 2 minutes for up to one hour.
    // If the call succeeds, stop polling. If the call or
    // download fails, the call throws a fault.
    
    for ($i = 0; $i < 10; $i++)
    {
    	sleep($waitTime);
        
    	// GetUploadRequestStatus helper method calls the corresponding Bing Ads service operation
    	// to get the upload status.
    	$uploadRequestStatus = GetUploadRequestStatus($proxy, $uploadRequestId);
        
    	if (($uploadRequestStatus != null) && (($uploadRequestStatus == "Completed")
    		|| ($uploadRequestStatus == "CompletedWithErrors")))
    	{
	    	$uploadSuccess = true;
	    	break;
    	}
    }
    
    if ($uploadSuccess)
    {
    	// GetUploadResultFileUrl helper method calls the corresponding Bing Ads service operation
    	// to get the upload result file Url.
    	$uploadResultFileUrl = GetUploadResultFileUrl($proxy, $uploadRequestId);
    	DownloadFile($uploadResultFileUrl, $UploadResultFilePath);
    	printf("The upload result file was written to %s.\n", $UploadResultFilePath);
    }
    else // Pending
    {
    	printf("The request is taking longer than expected.\n" +
    	"Save the upload ID (%s) and try again later.", $uploadRequestId);
    }
    
}
catch (SoapFault $e)
{
	// Output the last request/response.
	
	print "\nLast SOAP request/response:\n";
	print $proxy->GetWsdl() . "\n";
	print $proxy->GetService()->__getLastRequest()."\n";
	print $proxy->GetService()->__getLastResponse()."\n";
	
    // Bulk service operations can throw AdApiFaultDetail.
    if (isset($e->detail->AdApiFaultDetail))
    {
        // Log this fault.

        print "The operation failed with the following faults:\n";

        $errors = is_array($e->detail->AdApiFaultDetail->Errors->AdApiError)
                ? $e->detail->AdApiFaultDetail->Errors->AdApiError
                : array('AdApiError' => $e->detail->AdApiFaultDetail->Errors->AdApiError);

        // If the AdApiError array is not null, the following are examples of error codes that may be found.
        foreach ($errors as $error)
        {
            print "AdApiError\n";
            printf("Code: %d\nError Code: %s\nMessage: %s\n", $error->Code, $error->ErrorCode, $error->Message);

            switch ($error->Code)
            {
                case 0:    // InternalError
                    echo 'here';
                    break;
                case 105:  // InvalidCredentials
                    echo 'there';
                    break;
                default:
                    print "Please see MSDN documentation for more details about the error code output above.\n";
                    break;
            }
        }
    }

    // Bulk service operations can throw ApiFaultDetail.
    elseif (isset($e->detail->ApiFaultDetail))
    {
        // Log this fault.

        print "The operation failed with the following faults:\n";

        // If the BatchError array is not null, the following are examples of error codes that may be found.
        if (!empty($e->detail->ApiFaultDetail->BatchErrors))
        {
            $errors = is_array($e->detail->ApiFaultDetail->BatchErrors->BatchError)
                    ? $e->detail->ApiFaultDetail->BatchErrors->BatchError
                    : array('BatchError' => $e->detail->ApiFaultDetail->BatchErrors->BatchError);

            foreach ($errors as $error)
            {
                printf("BatchError at Index: %d\n", $error->Index);
                printf("Code: %d\nError Code: %s\nMessage: %s\n", $error->Code, $error->ErrorCode, $error->Message);

                switch ($error->Code)
                {
                    case 0:     // InternalError
                        echo "again";
                        break;
                    default:
                        print "Please see MSDN documentation for more details about the error code output above.\n";
                        break;
                }
            }
        }

        // If the OperationError array is not null, the following are examples of error codes that may be found.
        if (!empty($e->detail->ApiFaultDetail->OperationErrors))
        {
            $errors = is_array($e->detail->ApiFaultDetail->OperationErrors->OperationError)
                    ? $e->detail->ApiFaultDetail->OperationErrors->OperationError
                    : array('OperationError' => $e->detail->ApiFaultDetail->OperationErrors->OperationError);

            foreach ($errors as $error)
            {
                print "OperationError\n";
                printf("Code: %d\nError Code: %s\nMessage: %s\n", $error->Code, $error->ErrorCode, $error->Message);

                switch ($error->Code)
                {
                    case 0:     // InternalError
                        echo 'once';
                        break;
                    case 106:   // UserIsNotAuthorized
                        echo 'ok';
                        break;
                    default:
                        print "Please see MSDN documentation for more details about the error code output above.\n";
                        break;
                }
            }
        }
    }
}
catch (Exception $e)
{
    if ($e->getPrevious())
    {
        ; // Ignore fault exceptions that we already caught.
    }
    else
    {
        print $e->getCode()." ".$e->getMessage()."\n\n";
        print $e->getTraceAsString()."\n\n";
    }
}

// GetDownloadRequestId helper method calls the DownloadCampaignsByAccountIds service operation 
// to request the download identifier.
        
function GetDownloadRequestId($proxy, $accounts, $dataScope, $downloadFileType, 
		$entities, $formatVersion, $lastSyncTimeInUTC, $performanceStatsDateRange)
{
    // Set the request information.
    $request = new DownloadCampaignsByAccountIdsRequest();
    $request->AccountIds = $accounts;
    $request->DataScope = $dataScope;
    $request->DownloadFileType = $downloadFileType;
    $request->Entities = $entities;
    $request->FormatVersion = $formatVersion;
    $request->LastSyncTimeInUTC = $lastSyncTimeInUTC;
    $request->PerformanceStatsDateRange = $performanceStatsDateRange;
        
    return $proxy->GetService()->DownloadCampaignsByAccountIds($request)->DownloadRequestId;
}


// GetDownloadRequestStatus helper method calls the GetBulkDownloadStatus service operation 
// to get the download request status.

function GetDownloadRequestStatus($proxy, $requestId)
{
    $request = new GetBulkDownloadStatusRequest();
    $request->RequestId = $requestId;

    return $proxy->GetService()->GetBulkDownloadStatus($request)->RequestStatus;
}

// GetDownloadUrl helper method calls the GetBulkDownloadStatus service operation 
// to get the download Url.

function GetDownloadUrl($proxy, $requestId)
{
	$request = new GetBulkDownloadStatusRequest();
	$request->RequestId = $requestId;

	return $proxy->GetService()->GetBulkDownloadStatus($request)->ResultFileUrl;
}

// GetBulkUploadUrl helper method calls the GetBulkUploadUrl service operation 
// to request the upload identifier and upload Url via GetBulkUploadUrlResponse.

function GetBulkUploadUrl($proxy, $accountId, $responseMode)
{
	$request = new GetBulkUploadUrlRequest();
	$request->AccountId = $accountId;
	$request->ResponseMode = $responseMode;

	return $proxy->GetService()->GetBulkUploadUrl($request);
}

// GetUploadRequestStatus helper method calls the GetBulkUploadStatus service operation 
// to get the upload request status.

function GetUploadRequestStatus($proxy, $requestId)
{
	$request = new GetBulkUploadStatusRequest();
	$request->RequestId = $requestId;

	return $proxy->GetService()->GetBulkUploadStatus($request)->RequestStatus;
}

// GetUploadResultFileUrl helper method calls the GetBulkUploadStatus service operation 
// to get the upload result file Url.

function GetUploadResultFileUrl($proxy, $requestId)
{
	$request = new GetBulkUploadStatusRequest();
	$request->RequestId = $requestId;

	return $proxy->GetService()->GetBulkUploadStatus($request)->ResultFileUrl;
}

// Using the URL returned by the GetBulkUploadUrl operation,
// POST the bulk file using a HTTP client.

function UploadFile($UserName, $Password, $DeveloperToken, $CustomerId, $CustomerAccountId,
                    $uploadUrl, $filePath)
{
    date_default_timezone_set("UTC");
    $ch = curl_init($uploadUrl);

    curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
                
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                "UserName: $UserName",
                                "Password: $Password",
                                "DeveloperToken: $DeveloperToken",
                                "CustomerId: $CustomerId",
                                "CustomerAccountId: $CustomerAccountId"
                                ));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);

    // PHP < 5.5
    //curl_setopt($ch, CURLOPT_POSTFIELDS, array("file" => "@$filePath"));

    // PHP 5.5+
    $file = curl_file_create($filePath, "application/zip", "payload.zip");
    curl_setopt($ch, CURLOPT_POSTFIELDS, array("payload" => $file));

    $result = curl_exec($ch);
              
    if (curl_errno($ch))
    {
        print "Curl Error: " . curl_error($ch) . "\n";
    }
    else
    {
        print "Upload Result:\n" . $result . "\n";
        // Whether or not the curl execution failed, the response could include Bing Ads error codes  
        // if the bulk file upload failed, for example in the range of 3220-3227.
        // 
        // {
        //     "TrackingId":"Tracking-Id-Here",
        //     "RequestId":"Request-Id-Here",
        //     "Code":3224,
        //     "ErrorCode":"BulkServiceUrlAlreadyUsedForUpload",
        //     "Message":"The URL has already been used for file upload."
        // }
    }
             
    curl_close($ch);
}

// Using the URL that the GetBulkDownloadStatus operation returned,
// send an HTTP request to get the download data and write it to the specified
// ZIP file.

function DownloadFile($downloadUrl, $filePath)
{
    if (!$reader = fopen($downloadUrl, 'rb'))
    {
        throw new Exception("Failed to open URL " . $downloadUrl . ".");
    }

    if (!$writer = fopen($filePath, 'wb'))
    {
        fclose($reader);
        throw new Exception("Failed to create ZIP file " . $filePath . ".");
    }

    $bufferSize = 100 * 1024;

    while (!feof($reader))
    {
        if (false === ($buffer = fread($reader, $bufferSize)))
        {
            fclose($reader);
            fclose($writer);
            throw new Exception("Read operation from URL failed.");
        }

        if (fwrite($writer, $buffer) === false)
        {
            fclose($reader);
            fclose($writer);
            throw new Exception ("Write operation to ZIP file failed.");
        }
    }

    fclose($reader);
    fflush($writer);
    fclose($writer);
}

// Decompresses a ZIP Archive and writes the contents to the specified file path.

function DecompressFile($fromZipArchive, $toExtractedFile)
{
    $archive = new ZipArchive;

    if ($archive->open($fromZipArchive) === TRUE) {
        $archive->extractTo(dirname($toExtractedFile));
        $archive->close();
    }
    else {
        throw new Exception ("Decompress operation from ZIP file failed.");
    }
}

// Compresses a bulk file to a ZIP Archive.

function CompressFile($fromExtractedFile, $toZipArchive)
{
    $archive = new ZipArchive;

    if ($archive->open($toZipArchive, ZipArchive::OVERWRITE) === TRUE) {
        $archive->addFile($fromExtractedFile, basename($fromExtractedFile));
        $archive->close();
    }
    else {
        throw new Exception ("Compress operation to ZIP file failed.");
    }
}

// Get the time stamp of the last download from the previous
// download file. The SyncTime node contains the time stamp.

function GetLastSyncTime($path)
{
    $lastSyncTime = null;

    if (is_file($path))
    {
        $reader = @fopen($path, "r");

        try
        {
            $syncTimeColumn = 0;

            // The first record contains column header information, for example "Type" and "Sync Time".
            $record = fgets($reader);

            if($record != null)
            {
            	$fields = explode(",", $record, 100);
            	$column = 0;
            	
            	do
                {
                    $syncTimeColumn = ($fields[$column] == "Sync Time") ? $column : $syncTimeColumn;
                } while($syncTimeColumn == 0 && (++$column < count($fields)));
            }
            
            // Look for the Account record after any other metadata.

            $isAccount = false;

            do
            {
            	$record = fgets($reader);
                $fields = explode(",", $record, 100);
                if($fields[0] == "Account")
                {
                    date_default_timezone_set("UTC");
            	    $date = (new DateTime($fields[$syncTimeColumn]))->format('Y-m-d\TH:i:s');
            	    $lastSyncTime = ($fields[$syncTimeColumn] != "") ? $date : null;
                    $isAccount = true;
                }
            } while(!$isAccount);
            
            fclose($reader);
            $reader = null;

        }
        catch (Exception $e)
        {
            if (isset($reader))
            {
                fclose($reader);
            }
            throw $e;
        }
    }

    return $lastSyncTime;
}
 
?>