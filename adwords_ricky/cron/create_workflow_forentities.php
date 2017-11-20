<?php
require_once dirname(__FILE__) . '/../includes/init.php';
require_once dirname(__FILE__) . '/../includes/includes.php';

$main ->Query("INSERT INTO csvreports SET `col1` = NOW() , col2='Start' , col3 ='Circle'");
try{

if(!$main->updateDailyLimit($mcc)){logToFile("get customer","limit exceed"); exit;}

$count_accounts = 0 ;

$user = new AdWordsUser();
	
$user->LogAll();

//require('getCustomers.php');

a: {

	logToFile("get customer","limit not exceed");

	// get status of work flow table
	
	$workflowStatus = $main->getEntityWorkFlowStatus();
	
	if($workflowStatus==0):
		logToFile("get customer","Downloading new customer",date("Y-m-d H:i:s"));
	    // update to work flow table from accounts table where ad_account_status=1
	
		$update = $main -> updateEntityWorkFlow() ;		
		
		if($update==0){ $main ->Query("INSERT INTO csvreports SET `col1` = '".date('Y-m-d H:i:s')."' , col2='Start' ,col3='Getting New Customers'"); require('getCustomers.php'); $main ->Query("INSERT INTO csvreports SET `col1` = '".date('Y-m-d H:i:s')."' , col2='END' ,col3='Getting New Customers'"); }	 // if affected rows is 0 ,then get accounts 
		//exit;
		$workflowStatus = $main->getEntityWorkFlowStatus();
		
		if($workflowStatus == 0){ $main ->Query("INSERT INTO csvreports SET `col1` = NOW() , `col2` ='End' , col3 ='circle'" );   $main->updateEntityWorkflowStatus(0); }
		
		goto a ;
	
	else:
	
		if($workflowStatus->ad_download_status == 1) :
		
			// check if any of entity tables has  updated time less than 30 mins
			
			$getMaxUpdatedTimeStatus = $main->getMaxUpdatedTimeStatus(); 
			
			// update status is one then nothing to do let process continue
			
			if($getMaxUpdatedTimeStatus==1){$main ->Query("INSERT INTO csvreports SET `col1` = NOW() , col2='End' , col3 ='Maximum Updated time',col4='less than 300 mins'");exit;}
			
			// status is 0 ,which means cron crashed somewhere. So need to set the account tatus to 0 and restart the process .
			
			else{ $main->updateEntityWorkflowStatus(0,$workflowStatus->ad_account_id);  goto a ;}
		
		else:
			
			
			//if download status =0 means there is account to download entities ; 
			$main->updateEntityWorkflowStatus(1,$workflowStatus->ad_account_id);		
			
			$customer = $workflowStatus->ad_account_id ;
			
			$user->SetClientCustomerId($customer);
			
			logToFile("get entities","Customer",$customer,date("Y-m-d H:i:s"));
			
			$main ->Query("INSERT INTO csvreports SET `col1` = NOW() , col2='START' ,col3='".$customer."',col4='Entity Download'");
			
			require('getCampaigns.php'); 
 			require('getAdgroups.php');
			require('getKeywords.php');
			require('getAds.php');
			require('getSitelinks.php'); 
			
			$main->updateEntityWorkflowStatus(2,$workflowStatus->ad_account_id);			
  			
			$main ->Query("INSERT INTO csvreports SET `col1` = NOW() , col2='END' ,col3='".$customer."',col4='Entity Download'");
			
			$count_accounts++;
			
			logToFile("get entities","No of customers",$count_accounts,date("Y-m-d H:i:s"));
			
			goto a ;
			 
		endif;

	endif ;


}
}catch(Exception $e){

$main ->Query("INSERT INTO csvreports SET `col1` = NOW() , col2='Entity Download' ,col3='Error Caught',col4='".$e->getMessage()."'");

}

function logToFile($arg1="", $arg2="",$arg3="",$arg4="",$arg5="",$arg6=""){

	$date = date("Y-m-d H:i:s");
  
	
	$str = " $date \t $arg1 \t $arg2 \t $arg3 \t $arg4 \t  $arg5 \t $arg6 \t \n"; 
	
	error_log("$str\n", 3, 'log/testentity1.log'); 

}



?>