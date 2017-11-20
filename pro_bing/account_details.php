<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once './classes/constant_classes.php';
include_once './classes/authentication_classes.php';
include_once './classes/prepare_soap.php';

$body = array();
$body['AccountId'] = constants::$ACCOUNTID;
//$body['CampaignType'] = 'SearchAndContent';
$action = 'GetAccountsInfo';

$wsdl = 'https://clientcenter.api.bingads.microsoft.com/Api/CustomerManagement/v9/CustomerManagementService.svc?singleWsdl' ;
$ns = 'https://bingads.microsoft.com/Customer/v9' ;

		try{	
$option=array('trace'=>1);
$client = new SOAPClient($wsdl,$option);
$headers = new soap();
$client->__setSoapHeaders($headers->prepare_soap_header($ns, $action));
$info = $client->GetAccountsInfo($body);
echo '<pre>';
print_r($info);

echo $client->__getLastRequest();
echo $client->__getLastResponse();
		}
		catch(Exception $e){
			echo "Code : ".$e->getCode() ."Message : ".$e->getMessage() ;
			echo "REQUEST:\n" . $client->__getLastRequest() . "\n";
		}