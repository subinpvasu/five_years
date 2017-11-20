<?php
require_once dirname(__FILE__) . '/../includes/init.php';
require_once dirname(__FILE__) . '/../includes/includes.php';

try{
	set_time_limit(0);
	$user = new AdWordsUser();
	//$user->LogAll();
	$workflowStatus = $main->getBulkReportWorkFlowStatus();
	
	if($workflowStatus==0):
		$update = $main -> updateBulkReportWorkFlow() ;	
	else :
		$main -> Query("update adword_bulkreport_workflows  SET ad_download_status=0");
	endif;
	
	$sql = "SELECT ad_account_id FROM adword_bulkreport_workflows WHERE ad_download_status=0 ;";
	
	$result = $main ->getResults($sql);
	
	$i=0;
	foreach($result as $key=>$val){
		
		$customer = $val->ad_account_id ;
		$main -> Query("update adword_bulkreport_workflows  SET ad_download_status=1,updated_time=NOW() WHERE ad_account_id= '$customer' ;");
		
		logToFile($customer,"TEST START");
		$user->SetClientCustomerId($customer);

		$start_date = "20151101";
		$end_date = "20151201";
		$from = "2015-11-01";
		$to = "2015-12-01";
		
		logToFile($customer,"REPORT","FROM $from","TO $to");
	
		logToFile($customer,"TEST START","LOAD FILE TO TEMPORARY TABLE . DELETE EXISTING VALUES AND INSERT NEW VALUES");
		//require("testAcr2.php");
		//require("testCTr2.php");
		require("testCr2.php");
		//require("testKr2.php");
		//require("testAr2.php");
		//require("testSQr2.php");
		require("testdkr.php");

		$main -> Query("update adword_bulkreport_workflows  SET ad_download_status=2,updated_time=NOW() WHERE ad_account_id= '$customer' ;");
		
		logToFile($customer,"IMPORT REPORT FINISH");
		$i++;
		logToFile("TOTAL",$i);
		
		
	}	
}
catch(Exception $e){

	logToFile("ERROR",$e->getCode(),$e->getMessage());
}

function logToFile($arg1="", $arg2="",$arg3="",$arg4="",$arg5="",$arg6=""){

	$date = date("Y-m-d H:i:s");
	
	$str = " $date \t $arg1 \t $arg2 \t $arg3 \t $arg4 \t  $arg5 \t $arg6 \t \n"; 
	
	error_log("$str\n", 3, 'log/testerror1.log'); 

}



?>