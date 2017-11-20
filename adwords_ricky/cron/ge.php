<?php
require_once dirname(__FILE__) . '/../includes/init.php';
require_once dirname(__FILE__) . '/../includes/includes.php';

try {
	
	logToFile("Get Entities START");
	
	$sql_mcc_select = "SELECT customerId,refresh_token,prospect_account,canManageClients FROM adword_mcc_accounts WHERE prospect_account <> 10 order by mcc_id asc";
	
	$res_mcc_selects = $main -> getResults($sql_mcc_select);
	
	logToFile("MCC selected");
	
	foreach($res_mcc_selects as $res_mcc_select){
	
		if($res_mcc_select->prospect_account ==0):
		
			$dbName = DB_DATABASE ;
		
		else :
		
			$dbName = DB_DATABASE_PROSPECT ;
			
		endif;
		
			$canManageClients = $res_mcc_select -> canManageClients ;
		
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
		
		logToFile("Get Entities",$refresh_token,$customerId,$dbName);
	
		$dailylimitExceed = 0;
		
		/* $user = new AdWordsUser(NULL,$developerToken,NULL,$userAgent,NULL,NULL,$oauth2Info); */
		$user = new AdWordsUser(null,$developerToken, $userAgent, $customerId,null, $oauth2Info);
		
		$user->LogAll();
				
		logToFile("Get Entities finish"," For $count_accounts accounts",$customerId); 			
	}

	logToFile("Get Entities FINISH"); exit;
}
catch(Exception $e){

	mail('rdvarmaa@gmail.com','Get Reports Error ON '.date('d-m-y'),$e->getCode()."::".$e->getMessage());
	logToFile("Get Entities","ERROR",$e->getCode(),$e->getMessage());
	
}

// function to write log
function logToFile($arg1="", $arg2="",$arg3="",$arg4="",$arg5="",$arg6=""){

	global $main ;

	$time = date("Y-m-d H:i:s");
		
	$date = date("Y-m-d");
	
	$file = 'log/test_getEntities_'.$date.'.log' ;
	
	//fopen($file,"a+") or print_r(error_get_last()); 
	
	$str = " $time \t $arg1 \t $arg2 \t $arg3 \t $arg4 \t  $arg5 \t $arg6 \t \n"; 
	
	
	$main -> Query("insert into ".DB_DATABASE.".csvreports (col1,col2,col3,col4,col5,col6,col7) values ('$time','".addslashes($arg1)."','".addslashes($arg2)."','".addslashes($arg3)."','".addslashes($arg4)."','".addslashes($arg5)."','".addslashes($arg6)."')");
	
	//file_put_contents($file,"$str\n",FILE_APPEND | LOCK_EX) or print_r(error_get_last()); 

}




?>
