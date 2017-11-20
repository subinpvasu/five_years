<?php
try{
	logToFile($customer,"DISPLAY KEYWORD REPORT","START","TEST2");
	$reportArray = array();	
	
	//$reportArray['fields'] = array( 'Date','CampaignId','CampaignName','AdGroupId','AdGroupName','AdFormat','CriteriaParameters','Domain','Url','Clicks','Impressions','Cost','ConvertedClicks','CostPerConvertedClick', 'Ctr');
	$reportArray['fields'] = array( 'CampaignId','AdGroupId','Clicks','Impressions','Cost','Conversions','CampaignName','AdGroupName','Domain','Url','CriteriaParameters','Date','AdFormat');
	  
	$reportArray['reportType'] = 'URL_PERFORMANCE_REPORT';	
	$reportArray['fileType'] = 'CSV';
	
	
	$reportArray['startDate'] = $start_date;
	$reportArray['endDate'] = $end_date;
		
	$main->Query("truncate `adword_display_reports_temp`");	
	
	logToFile($customer,"DISPLAY KEYWORD REPORT","START","DELETE FROM DB");	
	
	$sql = "delete from adword_display_reports WHERE ad_Date between '$from' and '$to' AND ad_account_id='$customer'";
	
	$delete=$main -> Query($sql) ;			
	
	logToFile($customer,"DISPLAY KEYWORD REPORT","SUCCESS","DELETE DB",$delete);

	$reportArray['filePath'] = dirname(__FILE__).'/../reports/6months/'.$start_date.'_to_'.$end_date.'_dkreport_'.$customer.'.csv';			
		
	logToFile($customer,"DISPLAY KEYWORD REPORT","START","DOWNLOAD FROM API");
	
	if($filePath=$services ->getReports($user , $reportArray )){			
		
		logToFile($customer,"DISPLAY KEYWORD REPORT","FINISH","DOWNLOAD FROM API");
		
		$loadfileInsert = $main->Query("LOAD DATA LOCAL INFILE '$filePath' into TABLE adword_display_reports_temp FIELDS TERMINATED BY ',' ENCLOSED BY '\"' (`ad_campaign_id`, `ad_adgroup_id`, `ad_clicks`, `ad_impressions`, `ad_cost`, `ad_conversions`, `ad_campaign_name`, `ad_adgroup_name`, `ad_domain`, `ad_url`, `ad_criteria_parameters`,`ad_Date`,`ad_formats`)") ;
		
		logToFile($customer,"DISPLAY KEYWORD REPORT","SUCCESS","LOAD DATA",$loadfileInsert);
		
		unlink($filePath);
		
		$sql = "
			
			INSERT INTO `adword_display_reports` (`ad_account_id`, `ad_campaign_id`, `ad_adgroup_id`, `ad_clicks`, `ad_impressions`, `ad_cost`, `ad_conversions`, `ad_campaign_name`, `ad_adgroup_name`, `ad_domain`, `ad_url`, `ad_criteria_parameters`, `ad_delete_status`, `ad_created_time`, `ad_updated_time`, `ad_Date`,`ad_formats`)

			SELECT '".$customer."', tmp.`ad_campaign_id`, tmp.`ad_adgroup_id`, tmp.`ad_clicks`, tmp.`ad_impressions`, tmp.`ad_cost`, tmp.`ad_conversions`, tmp.`ad_campaign_name`, tmp.`ad_adgroup_name`, tmp.`ad_domain`, tmp.`ad_url`, tmp.`ad_criteria_parameters`, 0, NOW(), NOW(), tmp.`ad_Date`,tmp.`ad_formats`
			
			FROM adword_display_reports_temp tmp

			WHERE 	tmp.`ad_campaign_id` <> 0 ;
			";	
		
	
		set_time_limit(0); 
		logToFile($customer,"DISPLAY KEYWORD REPORT","START","INSERT DB");	
		$insert=$main -> Query($sql) ;			
		
		logToFile($customer,"DISPLAY KEYWORD REPORT","SUCCESS","INSERT DB",$insert);
		unset($sql);
		//$main->Query("truncate `adword_display_reports_temp`");	
		
		}
	logToFile($customer,"DISPLAY KEYWORD REPORT","FINISH","TEST2");	
}
 catch (Exception $e) {
	logToFile($customer,"DISPLAY KEYWORD REPORT","ERROR",$e->getCode(),$e->getMessage(),"TEST2");
}

