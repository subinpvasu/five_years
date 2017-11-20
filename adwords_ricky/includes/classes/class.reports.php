<?php
/********************************************************************************************************
 * @Short Description of the File	: Functions using for reports
 * @version 						: 0.1
 * @author 							: Deepa Varma<rdvarmaa@gmail.com>
 * @project 						: ADWORDS RICKY
 * @Created on 						: FEB 19 2015
 * @Modified on 					: FEB 19 2015
********************************************************************************************************/

class Reports extends Main {


	function getAdLabelReportFromDB($accountId,$startDate,$endDate){
	
		$sql  = "SELECT max(ad_report_id) id ,ad_Labels, ad_AdGroupId , ad_AdType ,`ad_Headline`,`ad_Description1`, `ad_Description2`,`ad_DisplayUrl`, SUM(ad_Clicks) clicks , SUM(ad_Impressions) impressions ,  ROUND(((SUM(ad_Clicks)/SUM(ad_Impressions)) * 100),2) ctr ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Clicks`))/1000000),2) as ad_avgCpc ,SUM(ad_Conversions) convrns  , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2) convrate ,ROUND(((SUM(`ad_Cost`)/ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2))/1000000),2) as ad_CstPConvR, ROUND((SUM(ad_Cost)/1000000),2) cost FROM `adword_ad_reports` A WHERE ad_account_id ='$accountId' AND `ad_Date` BETWEEN '$startDate' AND '$endDate' AND (ad_Labels <>'' AND ad_Labels NOT LIKE '%--%') AND ad_Status='ENABLED' GROUP BY ad_Labels having clicks > 0 ; " ;

		return $this -> getResults($sql);
	
	}
	
	function getDevicePerformanceReportFromDB($accountId,$startDate,$end_date){
		
		$sql = "SELECT ad_Device , SUM(ad_Impressions) ad_Impressions ,SUM(ad_Clicks) ad_Clicks , ROUND((SUM(ad_Cost)/1000000),2) ad_Cost , SUM(ad_Conversions) ad_Conversions , ROUND(((SUM(`ad_Cost`)/SUM(`ad_Clicks`))/1000000),2) as ad_CostPerClick ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion  , ROUND(SUM(ad_Clicks)/SUM(ad_Impressions)*100,2) ad_Ctr , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks))*100,2) ad_ConversionRate , ROUND(SUM(ad_Impressions * ad_AveragePosition)/SUM(ad_Impressions),2) as ad_AveragePosition  FROM adword_keyword_report WHERE ad_Date BETWEEN '$startDate' and '$endDate' and ad_account_id='$accountId' AND ad_Device <> '' AND  ad_Device in ('Computers','Mobile devices with full browsers','Other',
		'Tablets with full browsers')  GROUP BY ad_Device   ";
	
		return $this -> getResults($sql);
	}

	function getWastageAnalysisRportFromDB($accountId,$startDate,$endDate){
	
		$sql = "SELECT `ad_Query`,`ad_MatchType`,`ad_KeywordTextMatchingQuery`,`ad_CampaignName`,`ad_AdGroupName`,SUM(`ad_Clicks`) ad_Clicks ,SUM(`ad_Impressions`) ad_Impressions, SUM(`ad_Conversions`) ad_Conversions , SUM(`ad_Cost`) ad_Cost ,SUM(`ad_Cost`)/ SUM(`ad_Conversions`)  as ad_CostPerConversion ,SUM(`ad_ConversionValue`) ad_ConversionValue,`ad_AveragePosition` FROM `adword_search_query_reports` WHERE `ad_Date` BETWEEN '$startDate' AND '$endDate' AND `ad_account_id` =          '$accountId' AND ad_Query <>ad_KeywordTextMatchingQuery GROUP BY `ad_Query`,`ad_CampaignName`,`ad_AdGroupName` HAVING `ad_Clicks` >0 and ad_Conversions=0 ORDER BY  ad_Clicks DESC ,`ad_CampaignName` DESC LIMIT 25";
	
	
		return $this->getResults($sql);
	
	}

	function getKeywordDiscoveryReportFromDB($accountId,$startDate,$endDate){
	
		$sql = "SELECT `ad_Query`,`ad_MatchType`,`ad_KeywordTextMatchingQuery`,`ad_CampaignName`,`ad_AdGroupName`,SUM(`ad_Clicks`) ad_Clicks ,SUM(`ad_Impressions`) ad_Impressions, SUM(`ad_Conversions`) ad_Conversions , SUM(`ad_Cost`) ad_Cost ,SUM(`ad_Cost`)/ SUM(`ad_Conversions`)  as ad_CostPerConversion ,ad_Device FROM `adword_search_query_reports` WHERE `ad_Date` BETWEEN '$startDate' AND '$endDate' AND `ad_account_id` ='$accountId' AND ad_Query <>ad_KeywordTextMatchingQuery GROUP BY `ad_Query`,`ad_Device`,`ad_CampaignName`,`ad_AdGroupName` HAVING `ad_Conversions` >0 ORDER BY  ad_Conversions DESC ,`ad_CampaignName` DESC ,ad_Device ASC  LIMIT 25";
	

	
		return $this -> getResults($sql);
	}
	function getConversionBoosterReportsFromDB($accountId,$startDate,$endDate){
	
		$return = array();
	
		$sql = "SELECT `ad_CampaignName`,`ad_AdGroupName`,`ad_KeywordText`,ROUND((SUM(ad_Clicks)/SUM(ad_Impressions)*100),2) Ctr, SUM(`ad_Clicks`) ad_Clicks,SUM(`ad_Impressions`) ad_Impressions ,ROUND(SUM(`ad_Cost`)/1000000,2) ad_Cost , SUM(`ad_Conversions`) Conversions_sum , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks))*100,2) ad_ConversionRate , ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion ,ROUND(AVG(ad_AveragePosition),2) as ad_AveragePosition , MAX(ad_FirstPageCpc) as ad_FirstPageCpc , MAX(ad_TopOfPageCpc) ad_TopOfPageCpc ,SUM(ad_ConversionValue) as ad_ConversionValue  ,`ad_Keyword_Id`,`ad_CampaignId`,`ad_AdGroupId`,ad_KeywordMatchType
	
		FROM `adword_keyword_report` 
		WHERE `ad_Date` BETWEEN '$startDate' AND '$endDate' AND ad_account_id='$id'  GROUP BY adword_keyword_report.`ad_Keyword_Id`,`ad_CampaignId`,`ad_AdGroupId` HAVING Ctr < 2 AND Ctr >0 AND Conversions_sum <> 0 order by `ad_AdGroupName` desc
		";

		$results = $this ->getResults($sql);
		
		foreach($results as $result){

			$sel = "select ad_QualityScore,ad_keyword_adword_status,adword_keywords.ad_QualityScore,ad_CpcBid FROM adword_keywords where adword_keywords.ad_keyword_adword_id = '".$result->ad_Keyword_Id."' AND adword_keywords.ad_adgroup_adword_id = '".$result->ad_AdGroupId."' AND adword_keywords.ad_campaign_adword_id = '".$result->ad_CampaignId."' and ad_keyword_adword_status='ENABLED'";
			
			$sel_res = $main->getRow($sel);
			
			if(count($sel_res)>0){
						
				$ad_FirstPageCpc = round($result -> ad_FirstPageCpc / 1000000 , 2);
				$ad_TopOfPageCpc = round($result -> ad_TopOfPageCpc /1000000 , 2);
				$ad_CpcBid = round($sel_res -> ad_CpcBid /1000000 , 2);

				
				$return[]=array(
				
				'ad_CampaignName'=>$result -> ad_CampaignName ,
				'ad_AdGroupName'=>$result -> ad_AdGroupName ,
				'ad_KeywordText'=>$result -> ad_KeywordText ,
				'ad_KeywordMatchType'=>$result -> ad_KeywordMatchType ,
				'ad_Clicks'=>$result -> ad_Clicks ,
				'ad_Impressions'=>$result -> ad_Impressions ,
				'ad_Cost'=>$result -> ad_Cost ,
				'Conversions_sum'=>$result -> Conversions_sum ,
				'ad_ConversionRate'=>$result -> ad_ConversionRate ,
				'ad_CostPerConversion'=>$result -> ad_CostPerConversion ,
				'Ctr'=>$result -> Ctr ,
				'ad_AveragePosition'=>$result -> ad_AveragePosition ,
				'ad_TopOfPageCpc'=>$ad_TopOfPageCpc ,
				'ad_FirstPageCpc'=>$ad_FirstPageCpc ,
				'ad_CpcBid'=>$ad_CpcBid ,
				'ad_keyword_adword_status'=>$sel_res -> ad_keyword_adword_status ,
				'ad_QualityScore'=>$sel_res -> ad_QualityScore ,
				
				
				);
			

			}
		}
		
		return $return ;
	
	}
	
	function getMonthlyReportFromDB($accountId,$month="",$noOfMonths=24){
		
		if($month==""){$month=date('Y-m');}
		
		$monthbeforeNoOfMonths = date("Y-m",strtotime("-".$noOfMonths." Months",strtotime($month)));
		
	
		$sql = "SELECT `ad_report_id`,`ad_month`,`ad_account_adword_id`,`ad_Clicks`,`ad_Impressions`,ROUND((`ad_Cost`/1000000),2) as ad_Cost ,`ad_Ctr`,ROUND((`ad_AverageCpc`/1000000),2) as ad_AverageCpc,`ad_ConversionRate`,`ad_Conversions`,ROUND((`ad_CostPerConversion`/1000000),2) as ad_CostPerConversion,`ad_ConversionValue`,`ad_SearchImpressionShare`,`ad_month`,`ad_EstimatedTotalConversions`,ROUND((`ad_Cost`/(`ad_EstimatedTotalConversions`*1000000)),2) as ad_CostPerEstConv FROM  adword_monthly_report WHERE ad_account_adword_id='$accountId' and ad_month between '$monthbeforeNoOfMonths' and '$month'";
		
		

	
	}
	
	function getReportDetails($name){
	
		$where = "";
		if($name != ""){$where = "WHERE `ad_report_type_name`='$name' ";}
	
		$sql = "SELECT `ad_report_type_id`,`ad_report_type_name`,`ad_report_type_file`,`report_type_field`,`ad_delete_status`,`ad_report_type_img`,`ad_report_type_left`,`ad_report_type_right`,`ad_report_type_title` FROM `adword_report_types` $where order by `ad_delete_status` asc";
	
		return $this->getResults($sql);
	
	}
	

}



?>