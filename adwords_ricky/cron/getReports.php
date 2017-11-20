<?php
require_once dirname(__FILE__) . '/../includes/init.php';
require_once dirname(__FILE__) . '/../includes/includes.php';

require_once ADWORDS_UTIL_VERSION_PATH . '/ReportUtils.php';

try {
	
	$customerId = '';

	logToFile("DAILY REPORTING","START");
	
	$sql_mcc_select = "SELECT customerId,refresh_token,prospect_account,canManageClients FROM adword_mcc_accounts WHERE prospect_account <> 10 order by mcc_id desc";
	
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
				
		$customerId = $res_mcc_select ->customerId ;
				
		$dailylimitExceed = $main->updateDailyLimit($customerId) ;
		
		$user = new AdWordsUser(null,$developerToken, $userAgent, $customerId,null, $oauth2Info);
		
		//$user->LogAll();
		
		
		logToFile("Get Reports","MCC",$customerId,$dbName);
				
		$update = $main -> updateDailyReportWorkFlow($customerId) ;
		
		$count_accounts = 0;
		
		logToFile("Get Reports","Customer",$customerId);
		
		$sql = "SELECT `ad_mcc_id`, `ad_date`, `ad_account_id` FROM `adword_dailyreport_workflows` WHERE `ad_date` = DATE(NOW()) AND `ad_download_status` = 0 ;";
		
		$results = $main -> getResults($sql);

		
		foreach($results as $key => $res ){
			
			$customer = $res->ad_account_id ;
			
			logToFile("Get Reports","Account",$customer);
						
			$main->updateDailyReportWorkFlowStatus(1,$customerId,$res->ad_account_id,$res->ad_date);
			
			$start_date = date("Ymd", strtotime("-10 days"));	 
			$end_date = date("Ymd", strtotime("-1 days"));
			$from = date("Y-m-d", strtotime("-10 days"));	 
			$to = date("Y-m-d", strtotime("-1 days")); 
			
			$user->SetClientCustomerId($customer);
			
			if($main->updateDailyLimit($customerId)) { require('testAcr2.php');}
			if($main->updateDailyLimit($customerId)) { require('testCTr2.php');}
			if($main->updateDailyLimit($customerId)) { require('testCr2.php');}
			if($main->updateDailyLimit($customerId)) { require('testKr2.php');}
			if($main->updateDailyLimit($customerId)) { require('testAr2.php');}
			if($main->updateDailyLimit($customerId)) { require('testSQr2.php');}
			if($main->updateDailyLimit($customerId)) { require('testdkr.php');} 
			if($main->updateDailyLimit($customerId)) { require('testAp.php');} 
			if($main->updateDailyLimit($customerId)) { require('getBudgetOrder.php');} 
			
			if($main->updateDailyLimit($customerId)) { $main->updateDailyReportWorkFlowStatus(2,$customerId,$res->ad_account_id,$res->ad_date); 
													   logToFile($customer,"IMPORT REPORT FINISH");}
			else{logToFile("Get Reports","Daily Limit Exceed",$customerId); break ;}
			
		}
		
		logToFile("Get Reports"," For $key accounts",$customerId);
	}	

}
catch(Exception $e){
	
	mail('rdvarmaa@gmail.com','Get Reports Error ON '.date('d-m-y'),$e->getCode()."::".$e->getMessage());

	logToFile("Get Reports","ERROR",$e->getCode(),$e->getMessage());
	
}

// function to write log
function logToFile($arg1="", $arg2="",$arg3="",$arg4="",$arg5="",$arg6=""){

	global $main ;

	$time = date("Y-m-d H:i:s");
		
	$date = date("Y-m-d");
	
	$file = 'log/test_getReports_'.$date.'.log' ;
	
	//fopen($file,"a+") or print_r(error_get_last()); 
	
	$str = " $time \t $arg1 \t $arg2 \t $arg3 \t $arg4 \t  $arg5 \t $arg6 \t \n"; 
	
	$main -> Query("insert into ".DB_DATABASE.".csvreports (col1,col2,col3,col4,col5,col6,col7) values ('$time','".addslashes($arg1)."','".addslashes($arg2)."','".addslashes($arg3)."','".addslashes($arg4)."','".addslashes($arg5)."','".addslashes($arg6)."')");
	
	//file_put_contents($file,"$str\n",FILE_APPEND | LOCK_EX) or print_r(error_get_last()); 

}




?>