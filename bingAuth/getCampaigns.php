<?php

// Copyright 2014 Microsoft Corporation

// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at

//    http://www.apache.org/licenses/LICENSE-2.0

// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

// Include the Bing Ads namespaced class file available
// for download at http://go.microsoft.com/fwlink/?LinkId=322147
include 'bingads\CampaignManagementClasses.php';
include 'bingads\ClientProxy.php'; 

// Specify the BingAds\CampaignManagement objects that will be used.
use BingAds\CampaignManagement\AddNegativeKeywordsToEntitiesRequest;
use BingAds\CampaignManagement\DeleteNegativeKeywordsFromEntitiesRequest;
use BingAds\CampaignManagement\GetNegativeKeywordsByEntityIdsRequest;
use BingAds\CampaignManagement\AddSharedEntityRequest;
use BingAds\CampaignManagement\GetSharedEntitiesByAccountIdRequest;
use BingAds\CampaignManagement\UpdateSharedEntitiesRequest;
use BingAds\CampaignManagement\DeleteSharedEntitiesRequest;
use BingAds\CampaignManagement\AddListItemsToSharedListRequest;
use BingAds\CampaignManagement\GetListItemsBySharedListRequest;
use BingAds\CampaignManagement\DeleteListItemsFromSharedListRequest;
use BingAds\CampaignManagement\SetSharedEntityAssociationsRequest;
use BingAds\CampaignManagement\GetSharedEntityAssociationsByEntityIdsRequest;
use BingAds\CampaignManagement\GetSharedEntityAssociationsBySharedEntityIdsRequest;
use BingAds\CampaignManagement\DeleteSharedEntityAssociationsRequest;
use BingAds\CampaignManagement\AddCampaignsRequest;
use BingAds\CampaignManagement\DeleteCampaignsRequest;
use BingAds\CampaignManagement\Campaign;
use BingAds\CampaignManagement\EntityNegativeKeyword;
use BingAds\CampaignManagement\SharedEntityAssociation;
use BingAds\CampaignManagement\SharedEntity;
use BingAds\CampaignManagement\SharedList;
use BingAds\CampaignManagement\SharedListItem;
use BingAds\CampaignManagement\NegativeKeyword;
use BingAds\CampaignManagement\NegativeKeywordList;
use BingAds\CampaignManagement\BudgetLimitType;
use BingAds\CampaignManagement\MatchType;

// Specify the BingAds\Proxy objects that will be used.
use BingAds\Proxy\ClientProxy;

// Disable WSDL caching.

ini_set("soap.wsdl_cache_enabled", "0");
ini_set("soap.wsdl_cache_ttl", "0");

// Specify your credentials.

$UserName = "vbridgellp";
$Password = "vbridge123";
$DeveloperToken = "0071M925I6679867"; 
$AccountId = 1118271;



// Campaign Management WSDL

$wsdl = "https://api.bingads.microsoft.com/Api/Advertiser/CampaignManagement/V9/CampaignManagementService.svc?singleWsdl";

try
{


    $proxy = ClientProxy::ConstructWithAccountAndCustomerId($wsdl, $UserName, $Password, $DeveloperToken, $AccountId, null, null);

    // Specify one or more campaigns.
    
    $campaignIds = GetCampaignsByAccountId($proxy, $AccountId);
    print_r($campaignIds);
}
catch(Exception $e){

	echo "<pre>";
	print_r($e);
	echo "</pre>";

}