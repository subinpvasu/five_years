<?php

require_once ('../../config/config.php');
$account = isset($_REQUEST['account']) ? $_REQUEST['account'] : 0;
$master  = isset($_REQUEST['master'])?$_REQUEST['master']:$master_account;
require_once dirname(dirname(__FILE__)) . '/init.php';
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=CampaignList_' . $account . '.csv');
printf("CampaignId,Campaign Name\n");
function GetCampaignsExample(AdWordsUser $user)
{
    global $conn;
    // Get the service, which loads the required classes.
    $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
    // Create selector.
    $selector = new Selector();
    $selector->fields = array(
        'Id',
        'Name',
        'AdvertisingChannelType'
    );
    $selector->ordering[] = new OrderBy('Name', 'ASCENDING');
    // Create paging controls.
    $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);
    do {
        // Make the get request.
        $page = $campaignService->get($selector);
        // Display results.
        if (isset($page->entries)) {
            foreach ($page->entries as $campaign) {
                printf("%s,%s \n", $campaign->id, $campaign->name);
            }
        }
        // Advance the paging index.
        $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($page->totalNumEntries > $selector->paging->startIndex);
}
try {

    $sql = "SELECT refresh_token FROM prospect_credentials WHERE account_number='$master'";
    $result = $conn->query($sql);
    $obj=mysqli_fetch_object($result);
    $oauth2Infos = array(
        "client_id" => $clientId,
        "client_secret" => $clientSecret,
        "refresh_token" => $obj->refresh_token
    );
    $user = new AdWordsUser(NULL, $developerToken, $userAgent, NULL, NULL, $oauth2Infos);
    $user->SetClientCustomerId($account);
    GetCampaignsExample($user);
} catch (Exception $e) {
    printf("An error has occurred: %s\n", $e->getMessage());
}