<?php
try{
	logToFile($customer,"DANGER LIST REPORT","START","TEST2");
	$reportArray = array();	
	
	$reportArray['fields'] =array( 'AccountDescriptiveName', 'Conversions', 'Cost','ExternalCustomerId','Date');
	  
	$reportArray['reportType'] = 'ACCOUNT_PERFORMANCE_REPORT';
	
	$reportArray['fileType'] = 'CSV';
	
	
		$reportArray['startDate'] = $start_date;//change
		$reportArray['endDate'] = $end_date;
			
		$main->Query("truncate danger_list_temp");	
		
		logToFile($customer,"DANGER LIST REPORT","START","DELETE FROM DB");	
		
		$sql = "delete from adwords_danger_list WHERE dated between '$from' and '$to' AND ad_account_id='$customer'";
		$delete=$main -> Query($sql) ;

		logToFile($customer,"DANGER LIST REPORT","SUCCESS","DELETE DB",$delete);		

		$reportArray['filePath'] = dirname(__FILE__).'/../reports/danger/'.$start_date.'_to_'.$end_date.'_Preport_'.$customer.'.csv';		
                echo $reportArray['filePath'];
		
		logToFile($customer,"DANGER LIST REPORT","START","DOWNLOAD FROM API");
		
		if($filePath=$services ->getReports($user , $reportArray )){			
		
			logToFile($customer,"DANGER LIST REPORT","FINISH","DOWNLOAD FROM API");
		
			$loadfileInsert = $main->Query("LOAD DATA LOCAL INFILE '$filePath' into TABLE danger_list_temp FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ( `account_name`, `conversions`, `cost`,`account_id`, `dated`)") ;
			
			logToFile($customer,"DANGER LIST REPORT","SUCCESS","LOAD DATA",$loadfileInsert);
			
		unlink($filePath);
						
			$sql ="INSERT INTO `adwords_danger_list` (`account_id`, `account_name`, `conversions`, `cost`, ``, `added`, `updated`) 		
			
			SELECT '".$customer."' ,
			tmp.account_name,
			tmp.conversions,
			tmp.cost,
			tmp.dated,
			NOW(),NOW() 
			FROM danger_list_temp tmp
			WHERE tmp.`account_id` <> 0  ;
			
			
			";
			//echo $sql.'<br/>';
			set_time_limit(0); 
			logToFile($customer,"ACCOUNT PERFORMANCE REPORT","START","INSERT DB");	
			$insert=$main -> Query($sql) ;			
			logToFile($customer,"ACCOUNT PERFORMANCE REPORT","SUCCESS","INSERT DB",$insert);
			unset($sql);
			$main->Query("truncate `danger_list_temp`");
		
		}
	logToFile($customer,"ACCOUNT PERFORMANCE REPORT","FINISH","TEST2");	
}
 catch (Exception $e) {
	logToFile($customer,"ACCOUNT PERFORMANCE REPORT","ERROR",$e->getCode(),$e->getMessage(),"TEST2");
}

