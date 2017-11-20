<?php
try{
	logToFile($customer,"ACCOUNT REPORT","START","TEST2");
	
	$reportArray = array();		
	$reportArray['fields'] = array( 'Impressions', 'Clicks', 'Cost','Ctr','AverageCpc','AllConversionRate','Conversions','CostPerConversion','ConversionValue','SearchImpressionShare','Month','AllConversions');		
	$reportArray['filePath'] = dirname(__FILE__) . '/../reports/6months/report_account_'.$customer.'.csv';	
	$reportArray['startDate'] = date("Ymd",strtotime('first day of this month', strtotime($from)));
	$reportArray['endDate'] = $end_date ;
	$reportArray['reportType'] = 'ACCOUNT_PERFORMANCE_REPORT';
	$reportArray['fileType'] = 'CSV';	
	$main->Query("truncate `csvrprts`");	
	
	logToFile($customer,"ACCOUNT REPORT","START","DOWNLOAD FROM API");
	
	if($filePath=$services ->getReports($user , $reportArray )){	
		
		logToFile($customer,"ACCOUNT REPORT","FINISH","DOWNLOAD FROM API");
		
		$loadfileInsert = $main->Query("LOAD DATA LOCAL INFILE '$filePath' into TABLE csvrprts FIELDS TERMINATED BY ',' ENCLOSED BY '\"' (`col1`,`col2`,  `col3`, `col4`, `col5`, `col6`, `col7`, `col8`, `col9`, `col10`, `col11`,`col12`)") ;
		
		logToFile($customer,"ACCOUNT REPORT","SUCCESS","LOAD DATA",$loadfileInsert);
		
		unlink($filePath);
		
		$sql = "	
		UPDATE
			adword_monthly_report 		
		INNER JOIN
			csvrprts  
		ON
			adword_monthly_report.ad_account_adword_id = '$customer' and
			adword_monthly_report.ad_month = DATE_FORMAT( csvrprts.`col11`,'%Y-%m') 
			
		SET
			adword_monthly_report.ad_account_adword_id = '$customer',
			adword_monthly_report.ad_month = DATE_FORMAT( csvrprts.`col11`,'%Y-%m'),
			adword_monthly_report.ad_Impressions = csvrprts.col1,
			adword_monthly_report.ad_Clicks = csvrprts.col2,
			adword_monthly_report.ad_Cost = csvrprts.col3, 
			adword_monthly_report.ad_Ctr = REPLACE(csvrprts.col4,'%',''),  
			adword_monthly_report.ad_AverageCpc = csvrprts.col5,	 
			adword_monthly_report.ad_ConversionRate = REPLACE(csvrprts.col6,'%',''), 	 
			adword_monthly_report.ad_CostPerConversion = csvrprts.col8,	 
			adword_monthly_report.ad_ConversionValue = csvrprts.col9, 
			adword_monthly_report.ad_SearchImpressionShare =REPLACE(csvrprts.col10,'%',''), 
			adword_monthly_report.ad_Conversions = csvrprts.col7	,  
			adword_monthly_report.ad_EstimatedTotalConversions = csvrprts.col12	  
		";
		logToFile($customer,"ACCOUNT REPORT","START","UPDATE DB");	

		$update=$main -> Query($sql);
		
		logToFile($customer,"ACCOUNT REPORT","SUCCESS","UPDATE DB",$update);
		
		unset($sql);
	
		$sql = "INSERT INTO adword_monthly_report (ad_account_adword_id,ad_month,ad_Impressions,ad_Clicks,ad_Cost,ad_Ctr,ad_AverageCpc,ad_ConversionRate,ad_Conversions,ad_CostPerConversion,ad_ConversionValue,ad_SearchImpressionShare,ad_EstimatedTotalConversions) SELECT '$customer', DATE_FORMAT( csvrprts.`col11`,'%Y-%m'),col1,col2,col3,REPLACE(csvrprts.col4,'%',''),col5,REPLACE(csvrprts.col6,'%',''),col7,col8,col9,REPLACE(csvrprts.col10,'%','') , `col12` FROM csvrprts WHERE DATE_FORMAT( csvrprts.`col11`,'%Y-%m') NOT IN (SELECT ad_month FROM adword_monthly_report WHERE ad_account_adword_id = '$customer') AND `col1` <> 'Total' AND id > 2 ;  ";
		
		logToFile($customer,"ACCOUNT REPORT","START","INSERT DB");	
		 
		$insert=$main -> Query($sql) ;			
		
		logToFile($customer,"ACCOUNT REPORT","SUCCESS","INSERT DB",$insert);
		
		unset($sql);
	
		$main->Query("truncate `csvrprts`");	
	}
	logToFile($customer,"ACCOUNT REPORT","FINISH");	
}
 catch (Exception $e) {
	
	logToFile($customer,"ACCOUNT REPORT","ERROR",$e->getCode(),$e->getMessage());

}

