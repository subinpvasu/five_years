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
$headers['AuthenticationToken'] = 'EwD4AnhlBAAUxT83/QvqiAZEx5SuwyhZqHzk21oAAW1SKvkbR5tBXLyu1IjEjTsZ9olEL0GRbJm/5C8bW3CYkxbZVFV6mm8d6F2BDY2hzuIIvsK8R6Nrp671FT+XsL5K6kqx77ZjtpVf1Sg0Q3pBtig4ulq030AMSz0sxUVT3xA3UzVwjl5S3wMQECQrwHS1yKqh1mLw0MMogn5mWO9skz7XMqHkB9EuBUb/B+9VNFlbvBzGAaJZ0IaSOJfISSu5g/PoenOXBiiYpL0OKdBWJx8Ns9TvTDDzsci0V4G95jd909rBZPwAX53p1eTsvxg5mIYuvUO0TolpeqJ26zq24NRiOHew5tGiGXeUqB3lgiVscYMkjPIeDGm16/pM5QcDZgAACIj/RhTsSaARyAHsVYidg/Ngk+TNYMV0qFqAz4ykpyfsez9/bAHOgYLrfOYi41Du4gY2I+f+KigVW01099oh3gcQiG15RDEqEHWMzgZmnnG2nmaoutRzXYOGMHCbndq1Mn2wPmoh8SKYzFdYjIwfKClX8hh50L9L+6kozNyzcajYJHZmgP/ik15sBakiIjLY/fz62GUqGxlgj+IfS/FZ/D51FCYDsYIdbQis9/OCf+vFuWfE89iamdSAsfkPa6lR1rbKqSZedBgQ9wba4epXuACnUpkbgJfQ26y8QKjWzbUF/+VTSIqQ5lZzcf3e1Z5aDt86TT6p6VjC+DlP7Vq/C8+cze2tDkbX08VUaA/ebc1UkdH0Fnz6RYxP91EjyDOE7S03UxWN4kybxmRk/WWdDt2hHYF/LXECprcTVfG3FCbiCTRB3+LC/BNA9JpoqJF6c3MD9Z9D6O5JAglM0eW3Fra7JM563QER8BLUeX3uQ40ZWRQOHPExbztnclUQEGvDcPeabfI+TK2zkmbeINk2t21l7l8SknVK+iI1yu9LkvEHW3nXr7oR2qZ8Nscd+fr9HYeHmBD2a5hig6LQyRDNYWDzwOhs0VCY5QTjX9uoUC7Vf5/xAQ==';


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
		
$client = @new SOAPClient($wsdl);
$client->__setSoapHeaders($heads);


$info = $client->GetCampaignsByAccountId($body);

echo "REQUEST:\n" . $client->__getLastRequest() . "\n";

echo "<br /><pre>";
print_r($info) ;

print "<br />Last SOAP request:\n";
print $client->__getLastRequest() . "\n";

print "<br />Last SOAP response:\n";
print $client->__getLastResponse() . "\n";

		}
		
		catch(Exception $e){
			
			echo "Code : ".$e->getCode() ."Message : ".$e->getMessage() ;
			echo "REQUEST:\n" . $client->__getLastRequest() . "\n";
		}