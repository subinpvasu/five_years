<?php
require_once dirname(__FILE__) . '/../includes/init.php';
require_once dirname(__FILE__) . '/../includes/includes.php';
require_once ADWORDS_UTIL_VERSION_PATH . '/ReportUtils.php';

try{
	
	$refresh_token = '1/qo6xrGPKYsSw-A5zgUvlc5O1dNTd1JIwjvOpm981o7c';
	
	$customerId =6093644096;
	
	$developerToken = DEVELOPER_TOKEN ;
		
	$userAgent = USER_AGENT ;
	
	$accounts = array(2570035894,7545617282,7394147621);
	
	
	$oauth2Info = array(
			"client_id" => CLIENT_ID ,
			"client_secret" => CLIENT_SECRET,
			"refresh_token" => $refresh_token 
	);
	
	$user = new AdWordsUser(null,$developerToken, $userAgent, $customerId,null, $oauth2Info);
	
	$user->LogAll();
	
	$start_date = date("Ymd",strtotime("-30 days"));
	$end_date = date("Ymd");
	$from = date("Y-m-d",strtotime("-30 days"));	 
	$to = date("Y-m-d");
	
	$dailylimitExceed = 0;
	
	foreach($accounts as $customer){
	
		$user->SetClientCustomerId($customer);
	
		//if($main->updateDailyLimit($customerId)) { require('testAcr2.php');} 
		//if($main->updateDailyLimit($customerId)) { require('testCTr2.php');}
//		if($main->updateDailyLimit($customerId)) { require('testCr2.php');}
		//if($main->updateDailyLimit($customerId)) { require('testKr2.php');}
		//if($main->updateDailyLimit($customerId)) { require('testAr2.php');}
		//if($main->updateDailyLimit($customerId)) { require('testSQr2.php');}
		//if($main->updateDailyLimit($customerId)) { require('testdkr.php');}  
		//if($main->updateDailyLimit($customerId)) { require('testAp.php');}  
                
//      if($dailylimitExceed == 0 ) require('testAp.php'); 

		
		
	}
	
	require('create_budget_order_report.php');
	
}

catch(Exception $e){

	
	echo "ERROR CODE : ".$e->getCode()." ERROR MESSAGE : ".$e->getMessage() ; exit;
	
}

function logToFile($arg1="", $arg2="",$arg3="",$arg4="",$arg5="",$arg6=""){

	echo " $arg1 , $arg2 , $arg3 , $arg4 , $arg5 , $arg6   \n " ;

}