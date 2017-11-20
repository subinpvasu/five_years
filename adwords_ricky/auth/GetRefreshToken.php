<?php
require_once dirname(__FILE__) . '/init.php';
require_once dirname(__FILE__) . '/../includes/includes.php';
try {
  // Get the client ID and secret from the auth.ini file. If you do not have a
  // client ID or secret, please create one of type "installed application" in
  // the Google API console: https://code.google.com/apis/console#access
  // and set it in the auth.ini file.
  
  $oauth2Info = array(
    'client_id' => CLIENT_ID,
    'client_secret' => CLIENT_SECRET
  );
  
  $user = new AdWordsUser(null, null, null, null, null, $oauth2Info);
  $user->LogAll();
  
  $code = $_GET['code'];
  $redirectUri = REDIRECT_URI;

  $OAuth2Handler = $user->GetOAuth2Handler();
  
  // Get the OAuth2 credential.
  $user->SetOAuth2Info($OAuth2Handler->GetAccessToken($user->GetOAuth2Info(), $code, $redirectUri));			
			
  $oauth2Info =  $user->GetOAuth2Info();
  
  $user = new AdWordsUser(null, DEVELOPER_TOKEN, USER_AGENT, null, null,$oauth2Info);
  
  $customerService = $user->GetService("CustomerService");
  
  $customer = $customerService->get();
  
  //echo "<pre>"; print_r($customer) ;//exit;
  
  $fieldArray = array(
  
	'customerId' => $customer ->customerId ,
	'currencyCode' => $customer ->currencyCode ,
	'dateTimeZone' => $customer ->dateTimeZone ,
	'descriptiveName' => $customer ->descriptiveName ,
	'companyName' => $customer ->companyName ,
	'refresh_token' => $oauth2Info->refresh_token ,
	'updated_time'=>"NOW()"
  );
  
if($main->IsDuplicateExist('adword_mcc_accounts',"customerId='".$customer->customerId."'")){
	$update = $main -> Update('adword_mcc_accounts',$fieldArray,"customerId='".$customer->customerId."'");
	if($update){ echo "Thank you for revoking the refresh token";}
	else{echo "Please Try Agian";}

}
else{
	$fieldArray['prospect_account'] = 1;
	$insert = $main -> Insert('adword_mcc_accounts',$fieldArray);
	if($insert){ echo "Successfully added new customer";}
	else{echo "Please Try Agian";}
}
  
  
} catch (Exception $e) {
  printf("An error has occurred: %s\n", $e->getMessage());
}

