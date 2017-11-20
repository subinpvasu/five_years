<?php
try{
	
	logToFile($customer,"AD REPORT","START","TEST2");
	
	$reportArray = array();	
	
	$reportArray['fields'] =array( 'AdGroupId', 'AdGroupName','AdType','Date', 'CampaignName','CampaignId','Clicks',
      'Impressions','Cost','Conversions', 'AllConversionRate', 'Ctr', 'ConversionValue','Description1','Description2','DisplayUrl','Headline','Status','AdGroupStatus','Id','Labels');
	  
	$reportArray['reportType'] = 'AD_PERFORMANCE_REPORT';
	
	$reportArray['fileType'] = 'CSV';
		
		$reportArray['startDate'] = $start_date;
		$reportArray['endDate'] = $end_date;		
	
		$main->Query("truncate `adword_ad_reports_temp`");	
		
		logToFile($customer,"AD REPORT","START","DELETE FROM DB");
		$sql = "delete from adword_ad_reports WHERE ad_Date between '$from' and '$to' AND ad_account_id='$customer'";
		
		$delete=$main -> Query($sql) ;			
		
		logToFile($customer,"AD REPORT","SUCCESS","DELETE DB",$delete);
		
		
		$reportArray['filePath'] = dirname(__FILE__).'/../reports/6months/'.$start_date.'_to_'.$end_date.'_Adreport_'.$customer.'.csv';			
		
		logToFile($customer,"AD REPORT","START","DOWNLOAD FROM API");
		
	
		if($filePath=$services ->getReports($user , $reportArray )){ 
			 // test
			logToFile($customer,"AD REPORT","FINISH","DOWNLOAD FROM API");
		 
			$loadfileInsert =$main->Query("LOAD DATA LOCAL INFILE '$filePath' into TABLE adword_ad_reports_temp FIELDS TERMINATED BY ',' ENCLOSED BY '\"'(ad_AdGroupId,ad_AdGroupName,ad_AdType,ad_Date,ad_CampaignName,ad_CampaignId,ad_Clicks,ad_Impressions,ad_Cost,ad_Conversions,ad_ConversionRate,ad_Ctr,ad_ConversionValue,ad_Description1,ad_Description2,ad_DisplayUrl,ad_Headline,ad_Status,ad_AdGroupStatus,ad_Id,ad_Labels)") ;
			
			logToFile($customer,"AD REPORT","SUCCESS","LOAD DATA",$loadfileInsert);
			
			unlink($filePath);
			    
                  
  $sql ="INSERT INTO `adword_ad_reports` (ad_account_id,ad_Date,ad_CampaignId,ad_CampaignName,ad_AdGroupId,ad_AdGroupName,ad_AdType,ad_Clicks,ad_Impressions,ad_Cost,ad_Conversions,ad_ConversionRate,ad_Ctr,ad_ConversionValue,ad_Description1,ad_Description2,ad_DisplayUrl,ad_Headline,ad_Status,ad_AdGroupStatus,ad_Id,`ad_delete_status`, `created_time`, `updated_time`,`ad_Labels`) 

		SELECT '$customer', tmp.ad_Date,tmp.ad_CampaignId,tmp.ad_CampaignName,tmp.ad_AdGroupId,tmp.ad_AdGroupName,tmp.ad_AdType,tmp.ad_Clicks,tmp.ad_Impressions,tmp.ad_Cost,tmp.ad_Conversions,REPLACE(tmp.ad_ConversionRate,'%',''),REPLACE(tmp.ad_Ctr,'%',''),tmp.ad_ConversionValue,tmp.ad_Description1,tmp.ad_Description2,tmp.ad_DisplayUrl,tmp.ad_Headline,tmp.ad_Status,tmp.ad_AdGroupStatus,tmp.ad_Id,0,now(),now(),tmp.ad_Labels 
		FROM `adword_ad_reports_temp` tmp

		WHERE tmp.ad_AdGroupId <> 0  ";
			
			set_time_limit(0); 
			logToFile($customer,"AD REPORT","START","INSERT DB");	
			$insert=$main -> Query($sql) ;			
			logToFile($customer,"AD REPORT","SUCCESS","INSERT DB",$insert);
			unset($sql);
			
			$main->Query("truncate `adword_ad_reports_temp`");	
			
		}
	logToFile($customer,"AD REPORT","FINISH","TEST2");	


}
 catch (Exception $e) {

 logToFile($customer,"AD REPORT","ERROR",$e->getCode(),$e->getMessage(),"TEST2");

}

