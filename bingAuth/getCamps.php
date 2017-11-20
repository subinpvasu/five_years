<?php

$DeveloperToken = "0071M925I6679867";
$CustomerId = 8008098;
$AccountId = 1118271;
$headers = array();

$headers['UserName'] = 'vbridgellp@hotmail.com';
$headers['Password'] = 'vBr1dge123';
$headers['CustomerAccountId'] = 1118271;
$headers['CustomerId'] = 8008098;
$headers['DeveloperToken'] = '0071M925I6679867';
$headers['Action'] = 'GetCampaignsByAccountId';

$headers['UserName'] = 'vbridgellp';
$headers['Password'] = 'vBr1dge123';
$headers['CustomerAccountId'] = 1118271;
$headers['CustomerId'] = 8008098;
$headers['DeveloperToken'] = '0071M925I6679867';
$headers['Action'] = 'GetCampaignsByAccountId';
$headers['AuthenticationToken'] = 'EwD4AnhlBAAUxT83/QvqiAZEx5SuwyhZqHzk21oAAeHaV5PmbGcVw1zdVoVh3Nq2prs32wbxQwCp2Kz+oNQyV7l5gKcQ7eShApS5lTxRNlDTcr88JOGDtHABV/RsunWj7xNjtpmGRi2pGaMXY1TBzioNhkGrV6zhF6I1YCIYzwQ/kmyvfL6nlIdpXLCY4dxFqDnO+jVAA8yjqnYS51jfqxnNravRlTcCVA6MQmADX+3tkI2JGHvhV+1+gwByIXPypKIHYy8aCutrxk29uFgfHRwK1bbdw6RpN/SuoQSHZ9Yk6Tb8f5DhTiHg2dnv1l5If9RhJ8ZmEbNIrHcitRJJZrJtk/9BCvxS7itl3akG2y5hMKnLWOzJC+G+1PM+CiUDZgAACOmwBXlyb8G/yAEq2TLOKErgp1zSMBw7XMPdA8dDDcJg4iEMcGaqvUhNP92+MAra/2ehm00/8rdV2L033sY0X2xvzyquoS95Qdynz6RuWLQ49RsIkwyOucd6kKshUTuS1wwQELtGbK7WDqKIkK7AQPrrN1UqHuf/4xqyszIrJa1BEgiATDRVGo+7d6JpXL/NsasL8CKVWdu1gqcOfQlr7DkMUWrqa5KfWZAOYUGIIiRFkaWap8M93kt6REnQji9qLO2tKwii64Ex00TZTxYUmPIw2r9Ul6WtLqwbOYc5DgQ745rWMeKL9toxGLP+5Rsk29dr7Kdww4WJ6CRDnhmIF2ia0fwTYLbApIjZYcEROCGf+uCJ4P2ln1T4l3wpK1Xl2a4Q6XdPOKc/nRogXrkWLu9eJGQY3vc3vr1NGaKBIfnCMe8gmdzmJCgs2yTeK8jf1zT4FUuEzaE3QGSxS6gHJsSMIE2NHCuAC6xPtLr2eqb/fOCUb461ax7DZQMn/IZneW9Vbt4wK9I/x5vehPxMzR04VktV/+I4aAqsynJlKd8SEnhoNYCsCrUd9/Yc004XNswQeJQjuRmAaJlgWipjYbskMPXrcC8s2P9Zy4Jbtox9RmfxAQ==';


$body = array();
$body['AccountId'] = 1118271;
$body['CampaignType'] = 'SearchAndContent';


/* $ns = 'https://bingads.microsoft.com/CampaignManagement/v10' ;

$wsdl = 'https://campaign.api.bingads.microsoft.com/Api/Advertiser/CampaignManagement/V10/CampaignManagementService.svc?singleWsdl' ;

$client = new SoapClient($wsdl);

$header = new SOAPHeader($ns, 'RequestorCredentials', $headers);  

$client->__setSoapHeaders($header); 

echo "REQUEST:\n" . $client->__getLastRequest() . "\n";
 */
$wsdl = 'https://campaign.api.bingads.microsoft.com/Api/Advertiser/CampaignManagement/V10/CampaignManagementService.svc?singleWsdl' ;

$ns = 'https://bingads.microsoft.com/CampaignManagement/v10' ;

/* $heads[] = new SoapHeader(
				$ns,
				'UserName',
				$headers['UserName']
		);
$heads[] = new SoapHeader(
				$ns,
				'Password',
				$headers['Password']
		); */
$heads[] = new SoapHeader(
				$ns,
				'DeveloperToken',
				$headers['DeveloperToken']
		);
$heads[] = new SoapHeader(
				$ns,
				'Action',
				$headers['Action']
		);
		
$heads[] = new SoapHeader(
				$ns,
				'CustomerAccountId',
				$headers['CustomerAccountId']
		);
$heads[] = new SoapHeader(
				$ns,
				'CustomerId',
				$headers['CustomerId']
		);
		
		$heads[] = new SoapHeader(
				$ns,
				'AuthenticationToken',
				$headers['AuthenticationToken']
		);


		try{
		
$option=array('trace'=>1);
$client = new SOAPClient($wsdl,$option);
$client->__setSoapHeaders($heads);




$info = $client->GetCampaignsByAccountId($body);

echo $client->__getLastRequest();
echo $client->__getLastResponse();

//echo  $client->__getLastRequest() . "\n";

//echo "<br /><pre>";
//print_r($client) ;
//echo "<br /><pre>";
//print_r($info) ;

		}
		
		catch(Exception $e){
			
			echo "Code : ".$e->getCode() ."Message : ".$e->getMessage() ;
			echo "REQUEST:\n" . $client->__getLastRequest() . "\n";
		}