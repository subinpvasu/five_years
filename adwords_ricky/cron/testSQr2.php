<?php
try{
	logToFile($customer,"SEARCH QUERY REPORT","START","TEST2");
	$reportArray = array();	
	
	$reportArray['fields'] =array( 'CreativeId','Date', 'CampaignName', 'AdGroupName','KeywordTextMatchingQuery','CampaignId','Clicks','Impressions','Cost','Conversions','KeywordId','CostPerConversion','Ctr', 'AveragePosition','Query', 
   'AdGroupId','ConversionValue','Device','QueryMatchTypeWithVariant');
   
	$reportArray['reportType'] = 'SEARCH_QUERY_PERFORMANCE_REPORT';
	
	$reportArray['fileType'] = 'CSV';
	$reportArray['startDate'] = $start_date;
	$reportArray['endDate'] = $end_date;
		
	$main->Query("truncate `adword_search_query_reports_temp`");	
	
	logToFile($customer,"SEARCH QUERY REPORT","START","DELETE FROM DB");	
	
	$sql = "delete from adword_search_query_reports WHERE ad_Date between '$from' and '$to' AND ad_account_id='$customer'";
	
	$delete=$main -> Query($sql) ;			
	
	logToFile($customer,"SEARCH QUERY REPORT","SUCCESS","DELETE DB",$delete);

	$reportArray['filePath'] = dirname(__FILE__).'/../reports/6months/'.$start_date.'_to_'.$end_date.'_SQreport_'.$customer.'.csv';			
		
	logToFile($customer,"SEARCH QUERY REPORT","START","DOWNLOAD FROM API");
	
	if($filePath=$services ->getReports($user , $reportArray )){			
		
		logToFile($customer,"SEARCH QUERY REPORT","FINISH","DOWNLOAD FROM API");
		
		$loadfileInsert = $main->Query("LOAD DATA LOCAL INFILE '$filePath' into TABLE adword_search_query_reports_temp  FIELDS TERMINATED BY ',' ENCLOSED BY '\"'  (ad_CreativeId,ad_Date,ad_CampaignName,ad_AdGroupName,ad_KeywordTextMatchingQuery,ad_CampaignId,ad_Clicks,ad_Impressions,ad_Cost,ad_Conversions,ad_KeywordId,ad_CostPerConversion,ad_Ctr,ad_AveragePosition,ad_Query,ad_AdGroupId,ad_ConversionValue,ad_Device,ad_MatchType)") ;
			
		logToFile($customer,"SEARCH QUERY REPORT","SUCCESS","LOAD DATA",$loadfileInsert);
		
		unlink($filePath);
		
		$sql ="INSERT INTO `adword_search_query_reports` (`ad_account_id`,`ad_CreativeId`,`ad_Date`, `ad_CampaignName`, `ad_AdGroupName`,`ad_KeywordTextMatchingQuery`,`ad_CampaignId`,`ad_Clicks`,`ad_Impressions`,`ad_Cost`,`ad_Conversions`,`ad_KeywordId`,`ad_CostPerConversion`,`ad_Ctr`, `ad_AveragePosition`,`ad_Query`,   `ad_AdGroupId`,`ad_ConversionValue`,`ad_Device`,`ad_MatchType`,`created_time`,`updated_time`) 			
			SELECT '".$customer."' ,tmp.ad_CreativeId,tmp.ad_Date,tmp.ad_CampaignName,tmp.ad_AdGroupName,tmp.ad_KeywordTextMatchingQuery,tmp.ad_CampaignId,tmp.ad_Clicks,tmp.ad_Impressions,tmp.ad_Cost,tmp.ad_Conversions,tmp.ad_KeywordId,tmp.ad_CostPerConversion,REPLACE(tmp.ad_Ctr,'%',''),tmp.ad_AveragePosition,tmp.ad_Query,tmp.ad_AdGroupId,tmp.ad_ConversionValue,tmp.ad_Device,tmp.ad_MatchType,NOW(),NOW() 
			
			FROM adword_search_query_reports_temp tmp

			WHERE tmp.ad_CreativeId <> 0 ;";
			
		set_time_limit(0); 
		logToFile($customer,"SEARCH QUERY REPORT","START","INSERT DB");	
		$insert=$main -> Query($sql) ;			
		logToFile($customer,"SEARCH QUERY REPORT","SUCCESS","INSERT DB",$insert);
		unset($sql);
		
		
		}
	logToFile($customer,"SEARCH QUERY REPORT","FINISH","TEST2");	
}
 catch (Exception $e) {
	logToFile($customer,"SEARCH QUERY REPORT","ERROR",$e->getCode(),$e->getMessage(),"TEST2");
}

