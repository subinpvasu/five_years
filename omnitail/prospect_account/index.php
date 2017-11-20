<?php
//require_once dirname ( dirname ( __FILE__ ) ) . '/init.php';
require_once ('../omnitail/init.php');
require_once ('../config/config.php');
//require_once dirname(__FILE__) . '/../includes/includes.php';
try {
  // Get the client ID and secret from the auth.ini file. If you do not have a
  // client ID or secret, please create one of type "installed application" in
  // the Google API console: https://code.google.com/apis/console#access
  // and set it in the auth.ini file.
  
  $oauth2Info = array(
    'client_id' => $clientId,
    'client_secret' => $clientSecret
  );
  
  $user = new AdWordsUser(null, null, null, null, null, $oauth2Info);
  $user->LogAll();
  
  $code = $_GET['code'];
  //$redirectUri = REDIRECT_URI;

  $OAuth2Handler = $user->GetOAuth2Handler();
  
  // Get the OAuth2 credential.
  $user->SetOAuth2Info($OAuth2Handler->GetAccessToken($user->GetOAuth2Info(), $code, $redirect_uri));			
			
  $oauth2Info =  $user->GetOAuth2Info();
  
  //print_r($oauth2Info);exit;
  $refreshToken = $oauth2Info['refresh_token'];
 
  
  $user = new AdWordsUser(null, $developerToken, $userAgent, null, null,$oauth2Info);

  $customerService = $user->GetService("CustomerService");
  
  $customer = $customerService->get();
  
/* if($customer->canManageClients==1)
{ */
    try{
    $sql = "INSERT INTO prospect_credentials(account_name,name,manage,account_number, access_token, refresh_token, added) VALUES ('".$customer->companyName."','".$customer->descriptiveName."','".$customer->canManageClients."','".$customer->customerId."','".$oauth2Info['access_token']."','".$refreshToken."',NOW())";
    $conn->query($sql);
    echo '<h1>Permission granted successfully</h1>';
    }
    catch(Exception $e)
    {
        //$sql = "UPDATE prospect_credentials SET account_name="
        echo '<h1>Account credentials already exists</h1>';
    }
/* }
else
{
    echo '<h1>
        This is not an MCC Account.
        </h1>';
} */
  

/*  echo "<pre>";
 print_r($oauth2Info);
 print_r($customer) ; 

echo '</pre>'; */
  
  
} catch (Exception $e) {
  printf("An error has occurred: %s\n", $e->getMessage());
}

