<?php
use CustomClasses\fileOperations;
//Test account details
// $clientId = '665334475158-i9tkc0tpaj1bug137cb2gbs1d19iljcn.apps.googleusercontent.com';
// $clientSecret = 'k3rvOAmRwGRBWxfqCD6LP_rx';
// $redirectUrl = 'http://localhost/adwords_ricky/sheet/index.php';


//client's credentials
$clientId = '89739822384-6h5agapf1j1vb3p1f2i5a1fsgit7pi92.apps.googleusercontent.com';
$clientSecret = 'xPqgyUz3w02dz6nbNTpLrx7_';
$redirectUrl = 'http://localhost/googleoauth/index.php';

require_once 'src/Google_Client.php';
require_once '../reportmanagement/CustomClasses/fileOperations.php';
require_once '../reportmanagement/CustomClasses/responseClass.php';

session_start();

//config file path
$filePath = '../reportmanagement/setup/sam.ini';

$client = new Google_Client();
$client->setClientId($clientId);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUrl);
$client->setScopes(array('https://spreadsheets.google.com/feeds'));
$client->setApprovalPrompt('auto');

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $content = $client->getAccessToken();
    $file = new fileOperations();
    $result = $file->writeToFile($filePath, $content);
    print_r($result);
    exit;
}
print '<a href="' . $client->createAuthUrl() . '">Authenticate</a>';

