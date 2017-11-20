<?php

try { 
	
	if($main ->updateDailyLimit($customerId)){ 
		
		$user->SetClientCustomerId($customerId);
		
		$main -> Update('adword_accounts',array('ad_delete_status'=>1)," ad_mcc_id='$customerId'");
		
		logToFile("Get Customers","Start" , $customerId);
		
		$sql_insert = "INSERT INTO csv (`col1`,`col2`,`col3`,`col4`,`col5`,`col6`,`col7`) VALUES ";
		
		if($canManageClients):
		
			$accounts = $services -> GetAccounts($user);
			
			$main ->updateDailyLimit($customerId) ;
			
			$main->Query("truncate `csv`");
					
			$criterionCount = count($accounts);
			
			logToFile( "\n criterionCount".$criterionCount."\n" );
			
			$balance = $criterionCount % 1000 ;

			$criterionCount1 = $criterionCount - $balance  ;
					
			$count =0; $sqlArray = array();
				
			foreach ($accounts as $account) {	
			
				$count++;
				
				$sqlArray[] = "('".$account->customerId."','".addslashes($account->name)."','','".addslashes($account->companyName)."','".addslashes($account->canManageClients)."','".$account->currencyCode."','".$account->dateTimeZone."')";
								
				if($count % 1000 ==0  || $count-$criterionCount1 == $balance ){
						
					$sql = implode(",",$sqlArray);
					
					$sql = $sql_insert . $sql ;  
									
					unset($sqlArray) ; $sqlArray = array();
					
					$main ->Query($sql) ;
					
					unset($sql);					
				}	
				unset($accounts);
			}
		 
		else:

			$account = $main -> getRow("select * from ".DB_DATABASE.".adword_mcc_accounts where customerId='$customerId'");

			$sql = $sql_insert." ('".$account->customerId."','".addslashes($account->descriptiveName)."','".$account->login."','".addslashes($account->companyName)."','".addslashes($account->canManageClients)."','".$account->currencyCode."','".$account->dateTimeZone."')";

			logToFile("Get Customer",$sql);
			
			$main ->Query($sql) ;
			
			unset($sql);
			
		
		endif ;
		
		
		$sql = "
		
		UPDATE
			adword_accounts 
			
		INNER JOIN
			csv  
		ON
			adword_accounts.ad_account_adword_id = csv.col1
			
		SET
			adword_accounts.ad_account_adword_id = csv.col1,
			adword_accounts.ad_account_name = csv.col2,
			adword_accounts.ad_account_login = csv.col3,
			adword_accounts.ad_account_company = csv.col4,
			adword_accounts.ad_account_canManageClients = csv.col5,
			adword_accounts.ad_account_currencyCode = csv.col6,
			adword_accounts.ad_account_dateTimeZone = csv.col7,
			adword_accounts.ad_delete_status = 0,
			adword_accounts.updated_time = NOW()	 
		";
		
		$update = $main -> Query($sql) ;
		
		
		if($update){logToFile("Get Customers","Updated" ,"$update Accounts" , $customerId);}
		
		else{ logToFile("Get Customers","None to update" , $customerId);}
		
		unset($sql) ;
		
		
		$sql = "INSERT INTO adword_accounts (ad_account_adword_id,ad_account_name,ad_account_login,ad_account_company,ad_account_canManageClients,ad_account_currencyCode,ad_account_dateTimeZone,ad_delete_status,updated_time,ad_mcc_id) SELECT  col1, col2 ,col3,col4,col5,col6,col7,0,NOW(),'$customerId' FROM csv WHERE col1 NOT IN (SELECT ad_account_adword_id from adword_accounts WHERE ad_mcc_id = '$customerId' )";
		
		$insert = $main -> Query($sql) ;
		
		if($insert){logToFile("Get Customers","New" ,"$insert Accounts" , $customerId);}
		
		else{logToFile("Get Customers","New" ,"0 Accounts" , $customerId);}
		
		unset($sql) ;
		
		$main->Query("truncate `csv`");	
		
		
		// update the accounts with account manager from daily reports master sheet. details are in management_daily_report
		
		$main->Query("UPDATE adword_accounts a INNER JOIN management_daily_report b ON a.ad_account_adword_id = REPLACE( b.`client_id` ,  '-',  '' ) SET a.ad_user_id = b.`user_id_fk`;");	
	
	}
	else{ logToFile("Get Customers",$customerId,'Daily Limit Exceed'); $dailylimitExceed = 1 ;}
	

}
catch (Exception $e) {
	
  logToFile("Get Customers","error",$e->getMessage(),$e->getCode() ,$customerId );
 
}




?>