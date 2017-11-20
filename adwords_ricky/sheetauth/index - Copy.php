<?php
$clientId = '98018610115-02617t0ogfuh1tn05k01o1iqdn2mopd3.apps.googleusercontent.com';
$clientSecret = 'ypqz8eGLPDo4R_KTpjPyzX50';
$redirectUrl = 'http://localhost/googleads-php-lib-5.7.1';
require_once 'src/Google_Client.php';
session_start();
$client = new Google_Client();
$client->setClientId($clientId);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUrl);
$client->setScopes(array('https://spreadsheets.google.com/feeds'));

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    echo $client->getAccessToken();
    exit;
}
print '<a href="' . $client->createAuthUrl() . '">Authenticate</a>';


//4/95dnfpExqzNRvI9hc6699BpiGjbm77a2Yw6B7dGhnFE.wq3k74eCeaYVoiIBeO6P2m_g9cj8lgI
//4/U_vqfH2ldGESKtx0g3eQ7j-8pJ74IRypZFNXCpq6Tys.kgrrvtgS_5wXoiIBeO6P2m8Sy9kFlwI
//http://localhost/googleoauth/index.php?code=4/95dnfpExqzNRvI9hc6699BpiGjbm77a2Yw6B7dGhnFE.wq3k74eCeaYVoiIBeO6P2m_g9cj8lgI
//https://accounts.google.com/AccountChooser?
//service=lso&continue=https%3A%2F%2Faccounts.google.com%2Fo%2Foauth2%2Fauth%3F
//scope%3Dhttps%3A%2F%2Fspreadsheets.google.com%2Ffeeds%2Bhttps%3A%2F%2Fwww.googleapis.com%2Fauth%2Fdrive%26
//response_type%3Dcode%26access_type%3Doffline%26
//redirect_uri%3Dhttp%3A%2F%2Flocalhost%2Fgoogleoauth%2Findex.php%26approval_prompt%3Dforce%26
//client_id%3D89739822384-6h5agapf1j1vb3p1f2i5a1fsgit7pi92.apps.googleusercontent.com%26hl%3Den%26from_login%3D1%26as%3D-56b8eaff6fe0c43d&btmpl=authsub&hl=en


//https://accounts.google.com/o/oauth2/auth?response_type=code&redirect_uri=http%3A%2F%2Flocalhost%2Fgoogleoauth%2Findex.php&client_id=89739822384-6h5agapf1j1vb3p1f2i5a1fsgit7pi92.apps.googleusercontent.com&scope=https%3A%2F%2Fspreadsheets.google.com%2Ffeeds&access_type=offline&approval_prompt=force
//https://accounts.google.com/o/oauth2/auth?client_id=89739822384-6h5agapf1j1vb3p1f2i5a1fsgit7pi92.apps.googleusercontent.com&redirect_uri=http://localhost/googleoauth/index.php&scope=https%3A%2F%2Fspreadsheets.google.com%2Ffeeds&response_type=code&access_type=offline


https://accounts.google.com/o/oauth2/auth?client_id=98018610115-02617t0ogfuh1tn05k01o1iqdn2mopd3.apps.googleusercontent.com&redirect_uri=http://localhost/googleads-php-lib-5.7.1&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fadwords&response_type=code&access_type=offline