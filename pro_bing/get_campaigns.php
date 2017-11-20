<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



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
$headers['AuthenticationToken'] = 'EwD4AnhlBAAUxT83/QvqiAZEx5SuwyhZqHzk21oAAatrSNMKOE8LLu8pDkAlBvjaKnSWTgD1qRQZaWCf9I3GZYwIzry4GiKzfFgMhSDLPRklYvnO2y1IQdVzGJtWgdlKIk0OwpRgr/toJ7kwpyubEKS8XtM250ABsTSqeHRQlDHw7bZ4VRCik3UQjCO7PsC8gfQyjVhAvb38WmzxolBlaCH0a/R8Z81x57oqgkDckZ2sNMcs77RwkykSfxBOATQ73lj/ID6oHxL5dJpRuOV8WjdU07YtQFlSMvVXYIWIoQ/ZkRpb76NWUfWJeGpeaxpG9q3odKiPYvFjx4bofPqH9a8lc4wWrf+af5Se+YBAfRfJwvGet6mUzvJJTl2Fm3MDZgAACLVyP6agWvh/yAHj8bVqKM9f5ghFStKICxyMtR4bqEDNme9FB1LyNfRYew/WmIbUVtexen04ZezBw2Lj3WO0cXwFTGVa2JYjU1FWW4utagNb0ISpfYrOJerWcsCC90IeeQb/vBoZO/SmYQbLKz+Bw0omjrsY7NPt2nxOeiZXQzCeMQqdp02aoof8wcMF9ZQP+sicj7id5S9tk0/eTZUPupqHmH5WM2yGL5F8gbK9bc/9BZJaw1Z2T14Rpop4OZSaXXEs9z7wBBJkd9ZLiesosfCd3mJksqBor/JKRt5TC8c9SdwWoswoIMLGdlyW3nS6w+DXIPfgSzprkszRPZoqr27FdT48kbBEHuUJe1DB9dq5Qp/8RCk+MvKZ/4Z2UXd8prfH5c8ddsNRGXVSZgUKQ0MZ4sw+xyihDcJs5f8kll2CzqnvgLwarIPrJAG9VQaSo19pQvyW2uZugjau6/UU1a+5rRy9tF+/ERCLy3wNxW3lGiatj/tnnx7VIYpyAOBh9lSNOn/rpmYDnm5OarIw68p9aciJtq9bhX6wYg2OTIUJcCisRUuDhdjguKwovMoJj61PO0QRnQoXd76qlTfjOhie5u2Pp9lLzFKdlXq6ejKJxTjxAQ==';


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