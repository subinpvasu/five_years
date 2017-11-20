<?php
require_once dirname(__FILE__) . '/../includes/init.php';
require_once dirname(__FILE__) . '/../includes/includes.php';

try{
	
	logToFile($customer,"DAILY REPORTING","START");

	$main -> updateDailyReportWorkFlow() ;
		
	$i = 0; 
	
	a: {
	
		$user = new AdWordsUser();
		
		//$user->LogAll();
		
		
		
		set_time_limit(0);
		
		$workflowStatus = $main->getDailyReportWorkFlowStatus();
	
		if($workflowStatus<>0): 
			
			$main->updateDailyReportWorkFlowStatus(1,$workflowStatus->ad_account_id,$workflowStatus->ad_date);		
			
			$customer = $workflowStatus->ad_account_id ;
			
			logToFile($customer,"TEST START");
			
			$user->SetClientCustomerId($customer);

			$start_date = date("Ymd", strtotime("-10 days"));	 
			$end_date = date("Ymd", strtotime("-1 days"));
			$from = date("Y-m-d", strtotime("-10 days"));	 
			$to = date("Y-m-d", strtotime("-1 days"));	 
			
			logToFile($customer,"REPORT","FROM $from","TO $to");
		
			require("testAcr2.php");
			require("testCTr2.php");
			require("testCr2.php");
			require("testKr2.php");
			require("testAr2.php");
			require("testSQr2.php");
		
			logToFile($customer,"IMPORT REPORT FINISH");
			
			$i++;
			
			logToFile("TOTAL",$i);
			
			$main->updateDailyReportWorkFlowStatus(2,$customer,$workflowStatus->ad_date);
			//exit;
			goto a ;
			
		endif;	
	
	}
}
	
catch(Exception $e){

	logToFile("ERROR",$e->getCode(),$e->getMessage());
}

// function to write log
function logToFile($arg1="", $arg2="",$arg3="",$arg4="",$arg5="",$arg6=""){

	$time = date("Y-m-d H:i:s");
	
	$date = date("Y-m-d");
	
	$str = " $time \t $arg1 \t $arg2 \t $arg3 \t $arg4 \t  $arg5 \t $arg6 \t \n"; 
	
	error_log("$str\n", 3, 'log/test_error_daily_'.$date.'.log'); 

}
