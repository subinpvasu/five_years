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
$action = 'GetTargetsByIds';

$wsdl = 'https://campaign.api.bingads.microsoft.com/Api/Advertiser/CampaignManagement/V10/CampaignManagementService.svc?singleWsdl' ;
$ns = 'https://bingads.microsoft.com/CampaignManagement/v10' ;

		try{	
$option=array('trace'=>1);
$client = new SOAPClient($wsdl,$option);
$headers = new soap();
$client->__setSoapHeaders($headers->prepare_soap_header($ns, $action));
$info = $client->GetTargetsByIds($body);
echo '<pre>';
print_r($info);

echo $client->__getLastRequest();
echo $client->__getLastResponse();
		}
		catch(Exception $e){
			echo "Code : ".$e->getCode() ."Message : ".$e->getMessage() ;
			echo "REQUEST:\n" . $client->__getLastRequest() . "\n";
		}