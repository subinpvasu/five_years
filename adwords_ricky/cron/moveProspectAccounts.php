<?php

require_once dirname(__FILE__) . '/../includes/includes.php';


try{
	
	$from = DB_DATABASE;
	
	$to = DB_DATABASE_ARCHIVE ;
	
	$account = 5056002306 ;
	
	
	$main->moveAcccountDetailsFromOneTableToAnother($account,$from,$to);
	
	echo "finished" ;
	
}
catch(Exception $e){

	logToFile("Move Prospect Accounts","ERROR",$e->getCode(),$e->getMessage());

}

// function to write log
function logToFile($arg1="", $arg2="",$arg3="",$arg4="",$arg5="",$arg6=""){

	$time = date("Y-m-d H:i:s");
	
	$date = date("Y-m-d");
	
	$str = " $time \t $arg1 \t $arg2 \t $arg3 \t $arg4 \t  $arg5 \t $arg6 \t \n"; 
	
	error_log("$str\n", 3, 'log/test_MoveProspectAccounts_'.$date.'.log'); 

}





?>