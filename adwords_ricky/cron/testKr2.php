<?php
try{
	logToFile($customer,"KEYWORD REPORT","START","TEST2");
	$reportArray = array();	
	
	$reportArray['fields'] =array( 'Id', 'Date', 'CampaignName', 'AdGroupName', 'Criteria','QualityScore','Clicks',
      'Impressions','Cost','Conversions', 'AllConversionRate','CostPerConversion', 'Ctr', 'AveragePosition', 
      'FirstPageCpc', 'TopOfPageCpc', 'ConversionValue','Device','KeywordMatchType','CampaignId','AdGroupId');
	  
	$reportArray['reportType'] = 'KEYWORDS_PERFORMANCE_REPORT';
	
	$reportArray['fileType'] = 'CSV';
	
	
		$reportArray['startDate'] = $start_date;
		$reportArray['endDate'] = $end_date;
			
		$main->Query("truncate `adword_keyword_report_temp`");	
		
		logToFile($customer,"KEYWORD REPORT","START","DELETE FROM DB");	
		
		$sql = "delete from adword_keyword_report1 WHERE ad_Date between '$from' and '$to' AND ad_account_id='$customer'";
		$delete=$main -> Query($sql) ;

		logToFile($customer,"KEYWORD REPORT","SUCCESS","DELETE DB",$delete);		

		$reportArray['filePath'] = dirname(__FILE__).'/../reports/6months/'.$start_date.'_to_'.$end_date.'_Kreport_'.$customer.'.csv';			
		
		logToFile($customer,"KEYWORD REPORT","START","DOWNLOAD FROM API");
		
		if($filePath=$services ->getReports($user , $reportArray )){			
		
			logToFile($customer,"KEYWORD REPORT","FINISH","DOWNLOAD FROM API");
		
			$loadfileInsert = $main->Query("LOAD DATA LOCAL INFILE '$filePath' into TABLE adword_keyword_report_temp FIELDS TERMINATED BY ',' ENCLOSED BY '\"' (`ad_Keyword_Id`,`ad_Date`,`ad_CampaignName`,`ad_AdGroupName`,`ad_KeywordText`,`ad_QualityScore`,`ad_Clicks`,`ad_Impressions`,`ad_Cost`,`ad_Conversions`,`ad_ConversionRate`,`ad_CostPerConversion`,`ad_Ctr`,`ad_AveragePosition`,`ad_FirstPageCpc`,`ad_TopOfPageCpc`,`ad_ConversionValue`,`ad_Device`,`ad_KeywordMatchType`,`ad_CampaignId`,`ad_AdGroupId`)") ;
			
			logToFile($customer,"KEYWORD REPORT","SUCCESS","LOAD DATA",$loadfileInsert);
			
			unlink($filePath);
						
			$sql ="INSERT INTO `adword_keyword_report1` (ad_account_id,ad_Keyword_Id,ad_Date,ad_CampaignName,ad_AdGroupName,ad_KeywordText,ad_QualityScore,ad_Clicks,ad_Impressions,ad_Cost,ad_Conversions,ad_ConversionRate,ad_CostPerConversion,ad_Ctr,ad_AveragePosition,ad_FirstPageCpc,ad_TopOfPageCpc,ad_ConversionValue,ad_Device,ad_KeywordMatchType,ad_CampaignId,ad_AdGroupId,`created_time`,`updated_time`) 		
			
			SELECT '".$customer."' ,
			tmp.ad_Keyword_Id,
			tmp.ad_Date,
			tmp.ad_CampaignName,
			tmp.ad_AdGroupName,
			tmp.ad_KeywordText,
			tmp.ad_QualityScore,
			tmp.ad_Clicks,
			tmp.ad_Impressions,
			tmp.ad_Cost,
			tmp.ad_Conversions,
			REPLACE(tmp.ad_ConversionRate,'%',''),
			tmp.ad_CostPerConversion,
			REPLACE(tmp.ad_Ctr,'%',''),
			tmp.ad_AveragePosition,
			tmp.ad_FirstPageCpc,
			tmp.ad_TopOfPageCpc,
			tmp.ad_ConversionValue,
			tmp.ad_Device,
			tmp.ad_KeywordMatchType,
			tmp.ad_CampaignId,
			tmp.ad_AdGroupId,NOW(),NOW() 
			
			FROM adword_keyword_report_temp tmp

			WHERE tmp.`ad_Keyword_Id` <> 0  ;
			
			
			";
			
			set_time_limit(0); 
			logToFile($customer,"KEYWORD REPORT","START","INSERT DB");	
			$insert=$main -> Query($sql) ;			
			logToFile($customer,"KEYWORD REPORT","SUCCESS","INSERT DB",$insert);
			unset($sql);
			$main->Query("truncate `adword_keyword_report_temp`");
		
		}
	logToFile($customer,"KEYWORD REPORT","FINISH","TEST2");	
}
 catch (Exception $e) {
	logToFile($customer,"KEYWORD REPORT","ERROR",$e->getCode(),$e->getMessage(),"TEST2");
}

