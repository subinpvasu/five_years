<?php
try{
	logToFile($customer,"CAMPAIGN REPORT","START","TEST2");
	$reportArray = array();	
	
	$reportArray['fields'] = array( 'CampaignId', 'Date', 'CampaignName', 'SearchImpressionShare','Clicks',
      'Impressions','Cost','Conversions', 'ConversionRate','CostPerConversion', 'Ctr', 'AveragePosition','ConversionValue','DayOfWeek','HourOfDay');
	  
	$reportArray['reportType'] = 'CAMPAIGN_PERFORMANCE_REPORT';	
	$reportArray['fileType'] = 'CSV';
	
	
	$reportArray['startDate'] = $start_date;
	$reportArray['endDate'] = $end_date;
		
	$main->Query("truncate `adword_campaign_reports_temp`");	
	
	logToFile($customer,"CAMPAIGN REPORT","START","DELETE FROM DB");	
	
	$sql = "delete from adword_campaign_reports WHERE ad_Date between '$from' and '$to' AND ad_account_id='$customer'";
	
	$delete=$main -> Query($sql) ;			
	
	logToFile($customer,"CAMPAIGN REPORT","SUCCESS","DELETE DB",$delete);

	$reportArray['filePath'] = dirname(__FILE__).'/../reports/6months/'.$start_date.'_to_'.$end_date.'_Creport_'.$customer.'.csv';			
		
	logToFile($customer,"CAMPAIGN REPORT","START","DOWNLOAD FROM API");
	
	if($filePath=$services ->getReports($user , $reportArray )){
		
		logToFile($customer,"CAMPAIGN REPORT","FINISH","DOWNLOAD FROM API");
		
		$loadfileInsert = $main->Query("LOAD DATA LOCAL INFILE '$filePath' into TABLE adword_campaign_reports_temp  FIELDS TERMINATED BY ',' ENCLOSED BY '\"'  (`ad_CampaignId`,`ad_Date`,`ad_CampaignName`,ad_SearchImpressionShare,ad_Clicks,ad_Impressions,ad_Cost,ad_Conversions,ad_ConversionRate,ad_CostPerConversion,ad_Ctr,ad_AverageCpc,ad_ConversionValue,ad_DayOfWeek,ad_HourOfDay)") ;
		
		logToFile($customer,"CAMPAIGN REPORT","SUCCESS","LOAD DATA",$loadfileInsert);
		
		unlink($filePath);
		
		$sql = "
			
			INSERT INTO `adword_campaign_reports` (`ad_account_id`, `ad_Date`, `ad_CampaignId`, `ad_CampaignName`, `ad_SearchImpressionShare`, `ad_Clicks`, `ad_Impressions`,`ad_ExpImpressions`,`ad_Cost`, `ad_Conversions`, `ad_ConversionRate`, `ad_CostPerConversion`, `ad_Ctr`, `ad_AveragePosition`, `ad_ConversionValue`, `ad_delete_status`, `created_time`, `updated_time`,`ad_DayOfWeek`,`ad_HourOfDay`)

			SELECT '".$customer."' ,tmp.`ad_Date`, tmp.`ad_CampaignId`, tmp.`ad_CampaignName`,  REPLACE(tmp.ad_SearchImpressionShare,'%',''), tmp.ad_Clicks, tmp.ad_Impressions,ROUND((( tmp.ad_Impressions /REPLACE(tmp.ad_SearchImpressionShare,'%',''))*100)) ,tmp.ad_Cost, tmp.ad_Conversions, REPLACE(tmp.ad_ConversionRate,'%',''), tmp.ad_CostPerConversion, REPLACE(tmp.ad_Ctr,'%',''), tmp.ad_AverageCpc,tmp.ad_ConversionValue,0,NOW() ,NOW(),tmp.ad_DayOfWeek,tmp.ad_HourOfDay 
			
			FROM adword_campaign_reports_temp tmp

			WHERE 	tmp.`ad_CampaignId` <> 0 ;
			";	
		
			
		set_time_limit(0); 
		logToFile($customer,"CAMPAIGN REPORT","START","INSERT DB");	
		$insert=$main -> Query($sql) ;			
		
		logToFile($customer,"CAMPAIGN REPORT","SUCCESS","INSERT DB",$insert);
		unset($sql);
		
		
		}
	logToFile($customer,"CAMPAIGN REPORT","FINISH","TEST2");	
}
 catch (Exception $e) {
	logToFile($customer,"CAMPAIGN REPORT","ERROR",$e->getCode(),$e->getMessage(),"TEST2");
}

