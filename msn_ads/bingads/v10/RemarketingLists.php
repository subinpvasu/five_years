<?php

// Include the BingAds\v10 namespaced class file available
// for download at http://go.microsoft.com/fwlink/?LinkId=322147
include 'bingads\v10\CampaignManagementClasses.php';
include 'bingads\ClientProxy.php'; 

// Specify the BingAds\CampaignManagement objects that will be used.
use BingAds\v10\CampaignManagement\AddCampaignsRequest;
use BingAds\v10\CampaignManagement\DeleteCampaignsRequest;
use BingAds\v10\CampaignManagement\AddAdGroupsRequest;
use BingAds\v10\CampaignManagement\GetRemarketingListsRequest;
use BingAds\v10\CampaignManagement\AddAdGroupRemarketingListAssociationsRequest;
use BingAds\v10\CampaignManagement\DeleteAdGroupRemarketingListAssociationsRequest;
use BingAds\v10\CampaignManagement\GetAdGroupRemarketingListAssociationsRequest;
use BingAds\v10\CampaignManagement\UpdateAdGroupRemarketingListAssociationsRequest;
use BingAds\v10\CampaignManagement\Campaign;
use BingAds\v10\CampaignManagement\CampaignType;
use BingAds\v10\CampaignManagement\AdGroup;
use BingAds\v10\CampaignManagement\AdGroupRemarketingListAssociation;
use BingAds\v10\CampaignManagement\AdGroupRemarketingListAssociationStatus;
use BingAds\v10\CampaignManagement\RemarketingList;
use BingAds\v10\CampaignManagement\RemarketingTargetingSetting;
use BingAds\v10\CampaignManagement\EntityScope;
use BingAds\v10\CampaignManagement\BudgetLimitType;
use BingAds\v10\CampaignManagement\AdDistribution;
use BingAds\v10\CampaignManagement\Bid;
use BingAds\v10\CampaignManagement\BiddingModel;
use BingAds\v10\CampaignManagement\PricingModel;
use BingAds\v10\CampaignManagement\Date;

// Specify the BingAds\Proxy objects that will be used.
use BingAds\Proxy\ClientProxy;

// Disable WSDL caching.

ini_set("soap.wsdl_cache_enabled", "0");
ini_set("soap.wsdl_cache_ttl", "0");

// Specify your credentials.

$UserName = "<UserNameGoesHere>";
$Password = "<PasswordGoesHere>";
$DeveloperToken = "<DeveloperTokenGoesHere>";
$CustomerId = <CustomerIdGoesHere>;
$AccountId = <AccountIdGoesHere>;

// Campaign Management WSDL

$wsdl = "https://campaign.api.bingads.microsoft.com/Api/Advertiser/CampaignManagement/V10/CampaignManagementService.svc?singleWsdl";

// IMPORTANT: This example requires that you are enabled for Upgraded URLs.
try
{
    //  This example uses the UserName and Password elements for authentication. 
    $proxy = ClientProxy::ConstructWithAccountAndCustomerId($wsdl, $UserName, $Password, $DeveloperToken, $AccountId, $CustomerId, null);
    
    // For Managing User Authentication with OAuth, replace the UserName and Password elements with the AuthenticationToken, which is your OAuth access token.
    //$proxy = ClientProxy::ConstructWithAccountAndCustomerId($wsdl, null, null, $DeveloperToken, $AccountId, $CustomerId, "AuthenticationTokenGoesHere");
	
    // To discover all remarketing lists that the user can associate with ad groups in the current account (per CustomerAccountId header), 
    // set RemarketingListIds to null when calling the GetRemarketingLists operation.

    $remarketingLists = GetRemarketingLists($proxy, null)->RemarketingLists;

    // You must already have at least one remarketing list for the remainder of this example. 
    // The Bing Ads API does not support remarketing list add, update, or delete operations.

    if (count($remarketingLists) < 1)
    {
        return;
    }
                
    // Add an ad group in a campaign. The ad group will later be associated with remarketing lists. 
    
    $campaigns = array();
   
    $campaign = new Campaign();
    $campaign->Name = "Winter Clothing " . $_SERVER['REQUEST_TIME'];
    $campaign->Description = "Winter clothing line.";
    $campaign->BudgetType = BudgetLimitType::MonthlyBudgetSpendUntilDepleted;
    $campaign->MonthlyBudget = 1000.00;
    $campaign->TimeZone = "PacificTimeUSCanadaTijuana";
    $campaign->DaylightSaving = true;

    $campaigns[] = $campaign;

    
    $adGroups = array();

    date_default_timezone_set('UTC');
    $endDate = new Date();
    $endDate->Day = 31;
    $endDate->Month = 12;
    $endDate->Year = date("Y");

    $adGroup = new AdGroup();
    $adGroup->Name = "Women's Heated Ski Glove Sale";
    $adGroup->AdDistribution = AdDistribution::Search;
    $adGroup->BiddingModel = BiddingModel::Keyword;
    $adGroup->PricingModel = PricingModel::Cpc;
    $adGroup->StartDate = null;
    $adGroup->EndDate = $endDate;
    $adGroup->SearchBid = new Bid();
    $adGroup->SearchBid->Amount = 0.07;
    $adGroup->Language = "English";

    // Applicable for all remarketing lists that are associated with this ad group. TargetAndBid indicates 
    // that you want to show ads only to people included in the remarketing list, with the option to change
    // the bid amount. Ads in this ad group will only show to people included in the remarketing list.
    $adGroup->RemarketingTargetingSetting = RemarketingTargetingSetting::TargetAndBid;
    
    $adGroups[] = $adGroup;

        
    $addCampaignsResponse = AddCampaigns($proxy, $AccountId, $campaigns);
    $campaignIds = $addCampaignsResponse->CampaignIds->long;
    $campaignErrors = $addCampaignsResponse->PartialErrors;
    if(isset($addCampaignsResponse->PartialErrors->BatchError)){
        $campaignErrors = $addCampaignsResponse->PartialErrors->BatchError;
    }
    OutputCampaignsWithPartialErrors($campaigns, $campaignIds, $campaignErrors);
    
    $addAdGroupsResponse = AddAdGroups($proxy, $campaignIds[0], $adGroups);
    $adGroupIds = $addAdGroupsResponse->AdGroupIds->long;
    $adGroupErrors = $addAdGroupsResponse->PartialErrors;
    if(isset($addAdGroupsResponse->PartialErrors->BatchError)){
        $adGroupErrors = $addAdGroupsResponse->PartialErrors->BatchError;
    }
    OutputAdGroupsWithPartialErrors($adGroups, $adGroupIds, $adGroupErrors);


    // If the campaign or ad group add operations failed then we cannot continue this example. 

    if (empty($addAdGroupsResponse->AdGroupIds) || count($addAdGroupsResponse->AdGroupIds) < 1)
    {
        return;
    }

   $adGroupRemarketingListAssociations = array();

    // This example associates all of the remarketing lists with the new ad group.

    foreach ($remarketingLists->RemarketingList as $remarketingList)
    {
        if ($remarketingList->Id != null)
        {
            $adGroupRemarketingListAssociation = new AdGroupRemarketingListAssociation();
            $adGroupRemarketingListAssociation->AdGroupId = $adGroupIds[0];
            $adGroupRemarketingListAssociation->BidAdjustment = 20.00;
            $adGroupRemarketingListAssociation->RemarketingListId = $remarketingList->Id;
            $adGroupRemarketingListAssociation->Status = AdGroupRemarketingListAssociationStatus::Paused;
            
            $adGroupRemarketingListAssociations[] = $adGroupRemarketingListAssociation;

            print("\nAssociating the following remarketing list with the ad group.\n\n");
            OutputRemarketingList($remarketingList);
        }
    }

    $addAdGroupRemarketingListAssociationsResponse = AddAdGroupRemarketingListAssociations($proxy, $adGroupRemarketingListAssociations);

    $getAdGroupRemarketingListAssociationsResponse = GetAdGroupRemarketingListAssociations($proxy, $adGroupIds);

    if(!empty($getAdGroupRemarketingListAssociationsResponse->AdGroupRemarketingListAssociations)){
        foreach ($getAdGroupRemarketingListAssociationsResponse->AdGroupRemarketingListAssociations->AdGroupRemarketingListAssociation as $adGroupRemarketingListAssociation)
        {
            print("\nThe following ad group remarketing list association was added.\n\n");
            OutputAdGroupRemarketingListAssociation($adGroupRemarketingListAssociation);
        }
    }
    

    // You can store the association IDs which can be used to update or delete associations later. 

    $associationIds = $addAdGroupRemarketingListAssociationsResponse->AssociationIds->long;
    
    // If the associations were added and retrieved successfully let's practice updating and deleting one of them.

    if ($associationIds != null && count($associationIds) > 0)
    {
        $adGroupRemarketingListAssociations = array();
        
        $updateAdGroupRemarketingListAssociation = new AdGroupRemarketingListAssociation();
        $updateAdGroupRemarketingListAssociation->AdGroupId = $adGroupIds[0];
        $updateAdGroupRemarketingListAssociation->BidAdjustment = 10.00;
        $updateAdGroupRemarketingListAssociation->Id = $associationIds[0];
        $updateAdGroupRemarketingListAssociation->Status = AdGroupRemarketingListAssociationStatus::Active;
        
        $adGroupRemarketingListAssociations[] = $updateAdGroupRemarketingListAssociation;
        
        $updateAdGroupRemarketingListAssociationsResponse = UpdateAdGroupRemarketingListAssociations($proxy, $adGroupRemarketingListAssociations);
        
        $deleteAdGroupRemarketingListAssociationsResponse = DeleteAdGroupRemarketingListAssociations($proxy, $adGroupRemarketingListAssociations);
    }

    // Delete the campaign, ad group, and ad group remarketing list associations that were previously added. 
    // You should remove this line if you want to view the added entities in the 
    // Bing Ads web application or another tool.

    DeleteCampaigns($proxy, $AccountId, array($campaignIds[0]));
    printf("\nDeleted CampaignId %d\n\n", $campaignIds[0]);
}
catch (SoapFault $e)
{
    // Output the last request/response.
	
    print "\nLast SOAP request/response:\n";
    print $proxy->GetWsdl() . "\n";
    print $proxy->GetService()->__getLastRequest()."\n";
    print $proxy->GetService()->__getLastResponse()."\n";
	
    // Campaign Management service operations can throw AdApiFaultDetail.
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
                case 105:  // InvalidCredentials
                    break;
                case 117:  // CallRateExceeded
                    break;
                default:
                    print "Please see MSDN documentation for more details about the error code output above.\n";
                    break;
            }
        }
    }

    // Campaign Management service operations can throw ApiFaultDetail.
    elseif (isset($e->detail->EditorialApiFaultDetail))
    {
        // Log this fault.

        print "The operation failed with the following faults:\n";

        // If the BatchError array is not null, the following are examples of error codes that may be found.
        if (!empty($e->detail->EditorialApiFaultDetail->BatchErrors))
        {
            $errors = is_array($e->detail->EditorialApiFaultDetail->BatchErrors->BatchError)
            ? $e->detail->EditorialApiFaultDetail->BatchErrors->BatchError
            : array('BatchError' => $e->detail->EditorialApiFaultDetail->BatchErrors->BatchError);

            foreach ($errors as $error)
            {
                printf("BatchError at Index: %d\n", $error->Index);
                printf("Code: %d\nError Code: %s\nMessage: %s\n", $error->Code, $error->ErrorCode, $error->Message);

                switch ($error->Code)
                {
                    default:
                        print "Please see MSDN documentation for more details about the error code output above.\n";
                        break;
                }
            }
        }

        // If the EditorialError array is not null, the following are examples of error codes that may be found.
        if (!empty($e->detail->EditorialApiFaultDetail->EditorialErrors))
        {
            $errors = is_array($e->detail->EditorialApiFaultDetail->EditorialErrors->EditorialError)
            ? $e->detail->EditorialApiFaultDetail->EditorialErrors->EditorialError
            : array('BatchError' => $e->detail->EditorialApiFaultDetail->EditorialErrors->EditorialError);

            foreach ($errors as $error)
            {
                printf("EditorialError at Index: %d\n", $error->Index);
                printf("Code: %d\nError Code: %s\nMessage: %s\n", $error->Code, $error->ErrorCode, $error->Message);
                printf("Appealable: %s\nDisapproved Text: %s\nCountry: %s\n", $error->Appealable, $error->DisapprovedText, $error->PublisherCountry);

                switch ($error->Code)
                {
                    default:
                        print "Please see MSDN documentation for more details about the error code output above.\n";
                        break;
                }
            }
        }

        // If the OperationError array is not null, the following are examples of error codes that may be found.
        if (!empty($e->detail->EditorialApiFaultDetail->OperationErrors))
        {
            $errors = is_array($e->detail->EditorialApiFaultDetail->OperationErrors->OperationError)
            ? $e->detail->EditorialApiFaultDetail->OperationErrors->OperationError
            : array('OperationError' => $e->detail->EditorialApiFaultDetail->OperationErrors->OperationError);

            foreach ($errors as $error)
            {
                print "OperationError\n";
                printf("Code: %d\nError Code: %s\nMessage: %s\n", $error->Code, $error->ErrorCode, $error->Message);

                switch ($error->Code)
                {
                    case 106:   // UserIsNotAuthorized
                        break;
                    case 1102:  // CampaignServiceInvalidAccountId
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

// Adds one or more campaigns to the specified account.

function AddCampaigns($proxy, $accountId, $campaigns)
{
    $request = new AddCampaignsRequest();
    $request->AccountId = $accountId;
    $request->Campaigns = $campaigns;
    
    return $proxy->GetService()->AddCampaigns($request);
}

// Deletes one or more campaigns from the specified account.

function DeleteCampaigns($proxy, $accountId, $campaignIds)
{
    $request = new DeleteCampaignsRequest();
    $request->AccountId = $accountId;
    $request->CampaignIds = $campaignIds;
    
    $proxy->GetService()->DeleteCampaigns($request);
}

// Adds one or more ad groups to the specified campaign.

function AddAdGroups($proxy, $campaignId, $adGroups)
{
    $request = new AddAdGroupsRequest();
    $request->CampaignId = $campaignId;
    $request->AdGroups = $adGroups;
    
    return $proxy->GetService()->AddAdGroups($request);
}

// Retrieves remarketing lists. If RemarketingListIds is null or empty,
// the service will return all remarketing lists that the current authenticated user can access.

function GetRemarketingLists($proxy, $remarketingListIds)
{
    $request = new GetRemarketingListsRequest();
    $request->RemarketingListIds = $remarketingListIds;
    
    return $proxy->GetService()->GetRemarketingLists($request);
}

// Associates the specified ad groups with the respective remarketing lists.

function AddAdGroupRemarketingListAssociations($proxy, $adGroupRemarketingListAssociations)
{
    $request = new AddAdGroupRemarketingListAssociationsRequest();
    $request->AdGroupRemarketingListAssociations = $adGroupRemarketingListAssociations;
    
    return $proxy->GetService()->AddAdGroupRemarketingListAssociations($request);
}

// Deletes one or more ad group remarketing list associations.

function DeleteAdGroupRemarketingListAssociations($proxy, $adGroupRemarketingListAssociations)
{
    $request = new DeleteAdGroupRemarketingListAssociationsRequest();
    $request->AdGroupRemarketingListAssociations = $adGroupRemarketingListAssociations;
        
    return $proxy->GetService()->DeleteAdGroupRemarketingListAssociations($request);
}

// Gets the ad group remarketing list associations.

function GetAdGroupRemarketingListAssociations($proxy, $adGroupIds)
{
    $request = new GetAdGroupRemarketingListAssociationsRequest();
    $request->AdGroupIds = $adGroupIds;
    
    return $proxy->GetService()->GetAdGroupRemarketingListAssociations($request);
}

// Updates one or more ad group remarketing list associations.

function UpdateAdGroupRemarketingListAssociations($proxy, $adGroupRemarketingListAssociations)
{
    $request = new UpdateAdGroupRemarketingListAssociationsRequest();
    $request->AdGroupRemarketingListAssociations = $adGroupRemarketingListAssociations;
    
    return $proxy->GetService()->UpdateAdGroupRemarketingListAssociations($request);
}

// Outputs the campaign identifiers, as well as any partial errors.

function OutputCampaignsWithPartialErrors($campaigns, $campaignIds, $partialErrors)
{
    // Output the identifier of each successfully added campaign.

    for ($index = 0; $index < count($campaigns); $index++ )
    {
        // The array of campaign identifiers equals the size of the attempted campaign. If the element 
        // is not empty, the campaign at that index was added successfully and has a campaign identifer. 

        if (!empty($campaignIds[$index]))
        {
            printf("Campaign[%d] (Name:%s) successfully added and assigned CampaignId %s\n", 
                $index, 
                $campaigns[$index]->Name, 
                $campaignIds[$index] );
        }
    }

    // Output the error details for any campaign not successfully added.
    // Note also that multiple error reasons may exist for the same attempted campaign. 

    foreach ($partialErrors as $error)
    {
        // The index of the partial errors is equal to the index of the list
        // specified in the call to AddCampaigns.

        printf("\nCampaign[%d] (Name:%s) not added due to the following error:\n", $error->Index, $campaigns[$error->Index]->Name);

        printf("\tIndex: %d\n", $error->Index);
        printf("\tCode: %d\n", $error->Code);
        printf("\tErrorCode: %s\n", $error->ErrorCode);
        printf("\tMessage: %s\n", $error->Message);

        // In the case of an EditorialError, more details are available

        if ($error->Type == "EditorialError" && $error->ErrorCode == "CampaignServiceEditorialValidationError")
        {
            printf("\tDisapprovedText: %s\n", $error->DisapprovedText);
            printf("\tLocation: %s\n", $error->Location);
            printf("\tPublisherCountry: %s\n", $error->PublisherCountry);
            printf("\tReasonCode: %d\n", $error->ReasonCode);
        }
    }

    print "\n";
}

// Outputs the ad group identifiers, as well as any partial errors.

function OutputAdGroupsWithPartialErrors($adGroups, $adGroupIds, $partialErrors)
{
    // Output the identifier of each successfully added ad group.

    for ($index = 0; $index < count($adGroups); $index++ )
    {
        // The array of ad group identifiers equals the size of the attempted ad group. If the element 
        // is not empty, the ad group at that index was added successfully and has an ad group identifer. 

        if (!empty($adGroupIds[$index]))
        {
            printf("AdGroup[%d] (Name:%s) successfully added and assigned AdGroupId %s\n", 
                $index, 
                $adGroups[$index]->Name, 
                $adGroupIds[$index] );
        }
    }

    // Output the error details for any ad group not successfully added.
    // Note also that multiple error reasons may exist for the same attempted ad group.

    foreach ($partialErrors as $error)
    {
        // The index of the partial errors is equal to the index of the list
        // specified in the call to AddAdGroups.

        printf("\nAdGroup[%d] (Name:%s) not added due to the following error:\n", $error->Index, $adGroups[$error->Index]->Name);

        printf("\tIndex: %d\n", $error->Index);
        printf("\tCode: %d\n", $error->Code);
        printf("\tErrorCode: %s\n", $error->ErrorCode);
        printf("\tMessage: %s\n", $error->Message);

        // In the case of an EditorialError, more details are available

        if ($error->Type == "EditorialError" && $error->ErrorCode == "CampaignServiceEditorialValidationError")
        {
            printf("\tDisapprovedText: %s\n", $error->DisapprovedText);
            printf("\tLocation: %s\n", $error->Location);
            printf("\tPublisherCountry: %s\n", $error->PublisherCountry);
            printf("\tReasonCode: %d\n", $error->ReasonCode);
        }
    }

    print "\n";
}

// Outputs the remarketing list.

function OutputRemarketingList($remarketingList)
{
    if ($remarketingList != null)
    {
        printf("Description: %s\n", $remarketingList->Description);
        if ($remarketingList->ForwardCompatibilityMap != null)
        {
            foreach ($remarketingList->ForwardCompatibilityMap as $pair)
            {
                printf("\tKey: %s\n", $pair->Key);
                printf("\tValue: %s\n", $pair->Value);
            }
        }
        printf("Id: %s\n", $remarketingList->Id);
        printf("MembershipDuration: %s\n", $remarketingList->MembershipDuration);
        printf("Name: %s\n", $remarketingList->Name);
        printf("ParentId: %s\n", $remarketingList->ParentId);
        printf("Scope: %s\n", $remarketingList->Scope);
        printf("TagId: %s\n\n", $remarketingList->TagId);
    }
    
}

// Outputs the ad group remarketing list association.

function OutputAdGroupRemarketingListAssociation($adGroupRemarketingListAssociation)
{
    if ($adGroupRemarketingListAssociation != null)
    {
        printf("AdGroupId: %s\n", $adGroupRemarketingListAssociation->AdGroupId);
        printf("BidAdjustment: %s\n", $adGroupRemarketingListAssociation->BidAdjustment);
        printf("Id: %s\n", $adGroupRemarketingListAssociation->Id);
        printf("RemarketingListId: %s\n", $adGroupRemarketingListAssociation->RemarketingListId);
        printf("Status: %s\n\n", $adGroupRemarketingListAssociation->Status);
    }
}


?>