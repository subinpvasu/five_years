<?php
require_once dirname(__FILE__) . '/includes/init.php';
require_once dirname(__FILE__) . '/includes/includes.php';

require_once ADWORDS_UTIL_PATH . '/ReportUtils.php';
function DownloadKeywordperformanceReport(AdWordsUser $user, $filePath,$startDate, $endDate) {
    
  // Load the service, so that the required classes are available.
  $user->LoadService('ReportDefinitionService', ADWORDS_VERSION);

  // Create selector.
  $selector = new Selector();
  
  $selector->fields = array( 'CreativeId','Date', 'CampaignName', 'AdGroupName','KeywordTextMatchingQuery','CampaignId','Clicks','Impressions','Cost','Conversions','KeywordId','CostPerConversion','Ctr', 'AveragePosition','Query', 
   'AdGroupId','ConversionValue','Device','MatchType');
  
  // Filter out removed criteria.
  //$selector->predicates[] = new Predicate('Status', 'NOT_IN', array('REMOVED'));
  $myarray = array();
   
  // Set date range to request stats for.
  $dateRange = new DateRange();
  $dateRange->min = $startDate;
  $dateRange->max = $endDate;
  $selector->dateRange = $dateRange;

  // Create report definition.
  $reportDefinition = new ReportDefinition();
  $reportDefinition->selector = $selector;
  $reportDefinition->reportName = 'SEARCH_QUERY_PERFORMANCE_REPORT #' . uniqid();
  $reportDefinition->dateRangeType = 'CUSTOM_DATE';
  $reportDefinition->reportType = 'SEARCH_QUERY_PERFORMANCE_REPORT';
  $reportDefinition->downloadFormat = 'CSV';

  // Exclude criteria that haven't recieved any impressions over the date range.
  $reportDefinition->includeZeroImpressions = FALSE;

  // Set additional options.
  $options = array('version' => ADWORDS_VERSION);

  // Download report.
  ReportUtils::DownloadReport($reportDefinition, $filePath, $user, $options);

  return $filePath ;
  
 /*  printf("Report with name '%s' was downloaded to '%s'.<br />",
      $reportDefinition->reportName, $filePath); */
  
}

try { 
   
	$user = new AdWordsUser();

	$user->LogAll();    
	
	$get_account_ids = $main->getResults("select ad_account_adword_id from adword_accounts where ad_account_status = 1 and ad_delete_status=0 ;");   
 
	$i =0 ;
	
	$date = date("Y-m-d", strtotime("-4 months"));	 
	$date = date("Y-m-d",strtotime('first day of this month', strtotime($date)));
	$report_date = date("Ymd",strtotime('first day of this month', strtotime($date)));
	
	$days =0;
	
	a: { 
        
		//echo $date  . "<br />";		
		
		$report_date = date("Ymd",strtotime($date));
		
		if($report_date < date('Ymd')){
		
		
		foreach($get_account_ids as $key => $value){
 
		$ClientCustomerId = $value->ad_account_adword_id ;
		$user->SetClientCustomerId($ClientCustomerId);
		$main->Query("truncate `csvdata`");
		// Download the report to a file in the same directory as the example.
		$filePath = SITE_DIR.'reports/6months/'.$report_date.'_to_'.$report_date.'_SQreport_'.$ClientCustomerId.'.csv';
		 
		// report downloading function call
		if($filePath = DownloadKeywordperformanceReport($user, $filePath,$report_date,$report_date)){
					
			$main->Query("LOAD DATA LOCAL INFILE '$filePath' into TABLE csvdata FIELDS TERMINATED BY ',' (`Id`, `Date`, `CampaignName`, `AdGroupName`, `KeywordText`, `QualityScore`, `Clicks`, `Impressions`, `Cost`, `Conversions`, `ConversionRate`, `CostPerConversion`, `Ctr`, `AveragePosition`, `FirstPageCpc`, `TopOfPageCpc`, `ConversionValue`,`Device`,`KeywordMatchType`)") ; 			 
				$main ->Query("INSERT INTO `adword_search_query_reports` (`ad_Date`,`ad_CampaignName`,`ad_AdGroupName`,`ad_Clicks`,`ad_Impressions`,`ad_Cost`,`ad_Conversions`,`ad_CostPerConversion`,`ad_AveragePosition`,`ad_ConversionValue`,`ad_MatchType`,`ad_KeywordTextMatchingQuery`,`ad_CreativeId`,`ad_KeywordId`,`ad_Query`,`ad_account_id`, `created_time`, `updated_time`) SELECT `Date`,`CampaignName`,`AdGroupName`,`Clicks`,`Impressions`,`Cost`,`Conversions`,`CostPerConversion`,`AveragePosition`,`ConversionValue`,`KeywordMatchType`,`KeywordText`,`Id`,`ConversionRate`,`FirstPageCpc`,'".$ClientCustomerId."',NOW(),NOW() FROM `csvdata` WHERE id <> 'Total' and tableid >2 ");
			unlink($filePath);
		}
		
		

	}


		$date = strtotime("+ 1 days", strtotime($date));
		$date = date("Y-m-d", $date);		 
		goto a;
	}
		 
		
		
    } 	
       
} catch (Exception $e) {
    
  printf("An error has occurred: %s\n", $e->getMessage());
  
}




?>