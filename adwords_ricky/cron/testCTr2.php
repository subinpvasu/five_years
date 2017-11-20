<?php
try{
	logToFile($customer,"CONVERSION TYPE REPORT","START","TEST2");
	
	$reportArray = array();		
	$reportArray['fields'] = array( 'Conversions','Month','ConversionTypeName');
	
	$reportArray['startDate'] = date("Ymd",strtotime('first day of this month', strtotime($from)));
	$reportArray['endDate'] = $end_date;
	$reportArray['filePath'] = dirname(__FILE__) . '/../reports/6months/report_conversiontype_'.$customer.'.csv';	
	$reportArray['reportType'] = 'ACCOUNT_PERFORMANCE_REPORT';
	$reportArray['fileType'] = 'CSV';	
	$main->Query("truncate `csvrprts`");	
	
	logToFile($customer,"CONVERSION TYPE REPORT","START","DOWNLOAD FROM API");
	
	if($filePath=$services ->getReports($user , $reportArray )){	
		
		logToFile($customer,"CONVERSION TYPE REPORT","FINISH","DOWNLOAD FROM API");
		
		$loadfileInsert = $main->Query("LOAD DATA LOCAL INFILE '$filePath' into TABLE csvrprts FIELDS TERMINATED BY ',' ENCLOSED BY '\"'  (`col1`,`col2`,  `col3`)") ;
		
		logToFile($customer,"CONVERSION TYPE REPORT","SUCCESS","LOAD DATA");
		
		unlink($filePath);
		
		$sql = "	
		UPDATE
			adword_convtype_report 		
		INNER JOIN
			csvrprts  
		ON
			adword_convtype_report.ad_account_adword_id = '$customer' and
			adword_convtype_report.ad_month = DATE_FORMAT( csvrprts.`col2`,'%Y-%m') and 
			adword_convtype_report.ad_ConversionTypeName =col3
			
		SET
			adword_convtype_report.ad_account_adword_id = '$customer',
			adword_convtype_report.ad_month = DATE_FORMAT( csvrprts.`col2`,'%Y-%m'),
			adword_convtype_report.ad_Conversions = csvrprts.col1,
			adword_convtype_report.ad_ConversionTypeName = csvrprts.col3,
			adword_convtype_report.updated_time=now()
			
		";
		logToFile($customer,"CONVERSION TYPE REPORT","START","UPDATE DB");	
		$update=$main -> Query($sql);
		
		logToFile($customer,"CONVERSION TYPE REPORT","SUCCESS","UPDATE DB",$update);
		
		unset($sql);
	
		$sql = "
		INSERT INTO adword_convtype_report (ad_account_adword_id,ad_month,ad_Conversions,ad_ConversionTypeName,updated_time)
		SELECT '$customer', DATE_FORMAT(`col2`,'%Y-%m'),col1,col3,NOW() FROM csvrprts LEFT OUTER JOIN adword_convtype_report ON DATE_FORMAT( csvrprts.`col2`,'%Y-%m') = ad_month and col3 = ad_ConversionTypeName AND ad_account_adword_id ='$customer' WHERE `col1` <> 'Total' AND id > 2 AND adword_convtype_report.ad_ConversionTypeName IS NULL ;";
		
		
		logToFile($customer,"CONVERSION TYPE REPORT","START","INSERT DB");	
		 
		$insert=$main -> Query($sql) ;			
		
		logToFile($customer,"CONVERSION TYPE REPORT","SUCCESS","INSERT DB",$insert);
		
		unset($sql);
	
		$main->Query("truncate `csvrprts`");	
	}
	logToFile($customer,"CONVERSION TYPE REPORT","FINISH","TEST2");	
}
 catch (Exception $e) {
	
	logToFile($customer,"CONVERSION TYPE REPORT","ERROR",$e->getCode(),$e->getMessage(),"TEST2");

}

