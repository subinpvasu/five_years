<?php
require_once dirname(__FILE__) . '/../includes/init.php';
require_once dirname(__FILE__) . '/../includes/includes.php';

try {
	exit;
	logToFile("BULK REPORTING","START");
	
	$sql_mcc_select = "SELECT customerId,refresh_token,prospect_account FROM adword_mcc_accounts WHERE prospect_account <> 10 order by mcc_id asc limit 1  ";
	
	$res_mcc_selects = $main -> getResults($sql_mcc_select);
	
	foreach($res_mcc_selects as $res_mcc_select){
	
		if($res_mcc_select->prospect_account ==0):
		
			$dbName = DB_DATABASE ;
		
		else :
		
			$dbName = DB_DATABASE_PROSPECT ;
			
		endif;
		
		$main -> Select($dbName) ;
		
		$refresh_token = $res_mcc_select -> refresh_token ;
		
		$developerToken = DEVELOPER_TOKEN ;
		
		$userAgent = USER_AGENT ;
		
		$oauth2Info = array(
			"client_id" => CLIENT_ID ,
			"client_secret" => CLIENT_SECRET,
			"refresh_token" => $refresh_token 
		);
		
		
		
		$dailylimitExceed = 0;
		
		$customerId = $res_mcc_select ->customerId ;
		
		logToFile("BULK REPORTING","START",$customerId);
		
		$user = new AdWordsUser(null,$developerToken, $userAgent, $customerId,null, $oauth2Info);
		
		//$user->LogAll();
		
		$sql = "select count(*) total from adword_bulkreport_workflows where ad_mcc_id='".$customerId."'";
		
		$res = $main->getRow($sql);
		
		$total = $res -> total ;
		
		logToFile("BULK REPORTING",$total."total",$customerId);
		
		
		if($total>0):
			
			logToFile("BULK REPORTING","ALREADY IN BULK REPORT",$customerId);
			
		else:
			
			
			$sql = "insert into adword_bulkreport_workflows (`ad_account_id`, `ad_mcc_id`, `ad_download_status`) SELECT `ad_account_adword_id`,'".$customerId."','0' FROM `adword_accounts` WHERE `ad_mcc_id` = '".$customerId."' and ad_accout_status=1";
			
			logToFile("BULK REPORTING",$sql,$customerId);
			
			$insert = $main->Query($sql);
			
			logToFile("BULK REPORTING",$insert." Customers added",$customerId);
		
		endif;
		
		$sql = "select ad_account_id from adword_bulkreport_workflows where ad_mcc_id='".$customerId."' and (ad_download_status=0 or ad_download_status=1)";	
		
		
		$res = $main->getResults($sql); 
		
		
		logToFile("BULK REPORTING",count($res)." Customers to collect report",$customerId);
		
		$dailylimitExceed = 0;
		
		for($i=2; $i>=0 ; $i--){
			
			$start_date = date("Ymd",strtotime('first day of this month', strtotime("-".$i." month")));
			$end_date = date("Ymd",strtotime('last day of this month', strtotime("-".$i." month")));
			$from = date("Y-m-d",strtotime('first day of this month', strtotime("-".$i." month")));	 
			$to = date("Y-m-d",strtotime('last day of this month', strtotime("-".$i." month")));
			
			logToFile("BULK REPORTING",$from,$to,$customerId);
			
			foreach($res as $r){
				
				$customer = $r -> ad_account_id ;
				
				logToFile("BULK REPORTING",$customer,$customerId);
				
				$user->SetClientCustomerId($customer);
				
//				if($dailylimitExceed == 0 ) require('testAcr2.php'); 
//				if($dailylimitExceed == 0 ) require('testCTr2.php');
//				if($dailylimitExceed == 0 ) require('testCr2.php');
//				if($dailylimitExceed == 0 ) require('testKr2.php');
//				if($dailylimitExceed == 0 ) require('testAr2.php');
//				if($dailylimitExceed == 0 ) require('testSQr2.php'); 
				if($dailylimitExceed == 0 ) require('testAp.php'); 
				
				if($dailylimitExceed == 0 ) {
					
//					$main -> Query("update adword_bulkreport_workflows  SET ad_download_status=2,updated_time=NOW() WHERE ad_account_id= '$customer' ;");
				
				}
				
				else{ logToFile("BULK REPORTING","Daily Limit Exceed","Account loop",$customerId); break;}
								
			}
			
			if($dailylimitExceed <> 0 ) { logToFile("BULK REPORTING","Daily Limit Exceed","month",$customerId); break;}
		}
		
		logToFile("BULK REPORTING","END",$customerId);
	}


}
catch(Exception $e){

	logToFile("Get Reports","ERROR",$e->getCode(),$e->getMessage());

}

// function to write log
function logToFile($arg1="", $arg2="",$arg3="",$arg4="",$arg5="",$arg6=""){

	global $main ;

	$time = date("Y-m-d H:i:s");
		
	$date = date("Y-m-d");
	
	$file = 'log/test_getBulkReports_'.$date.'.log' ;
	
	//fopen($file,"a+") or print_r(error_get_last()); 
	
	$str = " $time \t $arg1 \t $arg2 \t $arg3 \t $arg4 \t  $arg5 \t $arg6 \t \n"; 
	
	$main -> Query("insert into ".DB_DATABASE.".csvreports (col1,col2,col3,col4,col5,col6,col7) values ('$time','".addslashes($arg1)."','".addslashes($arg2)."','".addslashes($arg3)."','".addslashes($arg4)."','".addslashes($arg5)."','".addslashes($arg6)."')");
	
	//file_put_contents($file,"$str\n",FILE_APPEND | LOCK_EX) or print_r(error_get_last()); 

}




?>