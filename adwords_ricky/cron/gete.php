<?php
require_once dirname(__FILE__) . '/../includes/init.php';
require_once dirname(__FILE__) . '/../includes/includes.php';
require_once ADWORDS_UTIL_VERSION_PATH . '/ReportUtils.php';

try{
	
	$refresh_token = '1/qo6xrGPKYsSw-A5zgUvlc5O1dNTd1JIwjvOpm981o7c';
	
	$customerId =6093644096;
	
	$developerToken = DEVELOPER_TOKEN ;
		
	$userAgent = USER_AGENT ;
	
	$canManageClients = 1;
	
	$accounts = array();
	
	
	$accounts = array(2570035894,7545617282, 7394147621); 
	
	/*  $sql = "select ad_account_adword_id FROM adword_accounts WHERE ad_user_id <> 0";
	
	$res = $main -> getResults($sql);
	
	foreach($res as $r) {$accounts[] = $r->ad_account_adword_id ;}
  */
	$oauth2Info = array(
			"client_id" => CLIENT_ID ,
			"client_secret" => CLIENT_SECRET,
			"refresh_token" => $refresh_token 
	);
	
	$user = new AdWordsUser(null,$developerToken, $userAgent, $customerId,null, $oauth2Info);
	
	$user->LogAll();

	$dailylimitExceed = 0;
	
	//if($dailylimitExceed == 0 ) require('getCustomers.php');  
	
	foreach($accounts as $customer){
	
		$user->SetClientCustomerId($customer);
	
		//if($dailylimitExceed == 0 ) require('getCampaigns.php'); 
		//if($dailylimitExceed == 0 ) require('getAdgroups.php');
		//if($dailylimitExceed == 0 ) require('getKeywords.php'); 
		//if($dailylimitExceed == 0 ) require('getAds.php'); 
		//if($dailylimitExceed == 0 ) require('getSitelinks.php'); 
		//if($dailylimitExceed == 0 ) require('getAdgroupFeeds.php');  
		//if($dailylimitExceed == 0 ) require('getBudgetOrder.php');  
		if($dailylimitExceed == 0 ) require('getChangeHistory.php');   exit;
/* 		for($i=30; $i>0 ; $i--){

			$start_date = date("Ymd 000000",strtotime("-$i days"));
			$end_date = date("Ymd 235959",strtotime("-$i days"));
			$date = date("Y-m-d",strtotime("-$i days"));	 
			
			if($dailylimitExceed == 0 ) require('getChangeHistory.php');  
		} */
		//exit;
	}
	
}

catch(Exception $e){

	
	echo "\n ERROR CODE : ".$e->getCode()." ERROR MESSAGE : ".$e->getMessage() ; exit ; 
	
}

function logToFile($arg1="", $arg2="",$arg3="",$arg4="",$arg5="",$arg6=""){

global $main ;

	$time = date("Y-m-d H:i:s");
		
	$date = date("Y-m-d");
	
	$file = 'log/test_getReports_'.$date.'.log' ;
	
	//fopen($file,"a+") or print_r(error_get_last()); 
	
	$str = " $time \t $arg1 \t $arg2 \t $arg3 \t $arg4 \t  $arg5 \t $arg6 \t \n"; 
	
	$main -> Query("insert into ".DB_DATABASE.".csvreports (col1,col2,col3,col4,col5,col6,col7) values ('$time','".addslashes($arg1)."','".addslashes($arg2)."','".addslashes($arg3)."','".addslashes($arg4)."','".addslashes($arg5)."','".addslashes($arg6)."')");

}