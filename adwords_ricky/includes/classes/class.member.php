<?php

/********************************************************************************************************
 * @Short Description of the File	: commonly used functions
 * @version 						: 0.1
 * @author 							: Deepa Varma<rdvarmaa@gmail.com>
 * @project 						: ADWORDS RICKY
 * @Created on 						: JULY 25 2014
 * @Modified on 					: JULY 25 2014
********************************************************************************************************/


class Member extends Main {

	function getEntityWorkFlowStatus($mcc=6093644096){

		$sql = "SELECT a.ad_account_id , a.ad_download_status ,a.updated_time FROM adword_entity_workflows a where ad_download_status in (0,1) and a.ad_account_status = 1 and  a.ad_mcc_id = '$mcc' order by ad_workflow_id desc limit 1 ";

		$result = $this -> getRow($sql);

		if(count($result)==0){ $result =0 ;	}

		return $result ;

	}
	function getBulkReportWorkFlowStatus($mcc=6093644096){

		$sql = "SELECT ad_account_id , ad_download_status FROM adword_bulkreport_workflows where ad_download_status in (0,1) order by ad_workflow_id asc limit 1";

		$result = $this -> getRow($sql);

		if(count($result)==0){ $result =0 ;	}

		return $result ;

	}
	function getDailyReportWorkFlowStatus($mcc=6093644096){

		$sql = "SELECT ad_account_id , ad_date, ad_download_status FROM adword_dailyreport_workflows where ad_download_status in (0,1) and ad_date='".date('Y-m-d')."' and ad_mcc_id = '$mcc' order by ad_workflow_id asc limit 1";

		$result = $this -> getRow($sql);

		if(count($result)==0){ $result =0 ;	}

		return $result ;

	}

	function updateEntityWorkFlow($mcc=6093644096){
		
		$sql = "Update adword_accounts t1
inner join adword_entity_workflows t2
On t1.ad_account_adword_id = t2.ad_account_id 
Set t2.ad_account_status = CASE WHEN t1.ad_delete_status=1 THEN 3  Else t1.ad_account_status End 
WHERE t1.`ad_mcc_id` = '".$mcc."'
";
		
		$res = $this -> Query($sql)  ;
		
		$sql = " INSERT INTO adword_entity_workflows (ad_account_id ,ad_download_status,ad_account_status,updated_time,ad_mcc_id )  select ad_account_adword_id , 0,1, NOW(),'".$mcc."' from adword_accounts a left join adword_entity_workflows b on a.`ad_account_adword_id`=b.`ad_account_id` where a.`ad_mcc_id` = '".$mcc."' and a.ad_account_status = 1 and a.ad_delete_status = 0 and b.`ad_account_id` IS NULL ;";

		$res =  $this -> Query($sql)  ;
		
		return $res ;

	}
	function updateBulkReportWorkFlow($mcc=6093644096){

		$sql = "INSERT INTO adword_bulkreport_workflows (ad_account_id ,ad_download_status,updated_time ) SELECT ad_account_adword_id,0,NOW() FROM adword_accounts WHERE ad_account_adword_id NOT IN (SELECT ad_account_id from adword_bulkreport_workflows ) AND ad_account_status=1 AND ad_delete_status = 0";

		return $this -> Query($sql) ;

	}
	function updateDailyReportWorkFlow($mcc=6093644096){

		$sql = "

		INSERT INTO adword_dailyreport_workflows (ad_date,ad_account_id,ad_mcc_id)

		SELECT A.date,A.ad_account_adword_id ,A.ad_mcc_id FROM adword_dailyreport_workflows c RIGHT JOIN (SELECT '".date('Y-m-d')."' as date,ad_account_adword_id,ad_mcc_id FROM adword_accounts a WHERE a.ad_account_status=1 and a.`ad_delete_status` =0 and ad_mcc_id='$mcc' ORDER BY ad_account_id DESC) A on A.date=c.ad_date and A.ad_account_adword_id = c.ad_account_id WHERE ad_workflow_id IS NULL ;	";


		return $this -> Query($sql) ;
	}
	function updateEntityWorkflowStatus($status,$mcc=6093644096,$account=0){

		if($account==0) {$where = "";}	else {$where = "AND ad_account_id='$account'";}

		$sql = "UPDATE adword_entity_workflows SET ad_download_status='$status' ,updated_time =NOW() WHERE ad_mcc_id='$mcc' $where";

		$result = $this -> Query($sql);

		return $result ;

	}
	function updateBulkReportWorkFlowStatus($status,$account=0){

		if($account==0) {$where = "";}	else {$where = "WHERE ad_account_id='$account'";}

		$sql = "UPDATE adword_bulkreport_workflows SET ad_download_status='$status' ,updated_time =NOW() $where";


		$result = $this -> Query($sql);

		return $result ;

	}
	function updateDailyReportWorkFlowStatus($status,$mcc,$account=0,$date){

		if($account==0) {$where = "";}	else {$where = "AND ad_account_id='$account' and ad_date='$date'";}

		$sql = "UPDATE adword_dailyreport_workflows SET ad_download_status='$status' ,updated_time =NOW() WHERE ad_mcc_id='$mcc' $where";

		$result = $this -> Query($sql);

		return $result ;

	}
	function updateDailyLimit($mcc=6093644096){

	

		if(!$this->IsDuplicateExist('adword_daily_limit',"ad_date='".date("Y-m-d")."' and ad_mcc_id='".$mcc."'")){ echo "1";

			$this ->Query("insert into adword_daily_limit set ad_date='".date("Y-m-d")."' , ad_mcc_id='".$mcc."' , ad_limit=0 ");

		}
		else{ 

			$limit = $this->getRow("select ad_limit from adword_daily_limit where ad_date='".date("Y-m-d")."' and ad_mcc_id='".$mcc."'");

			if($limit->ad_limit > 7000 ){
				return false;
			}
			else{
			$this ->Query("update adword_daily_limit set  ad_limit=ad_limit+1 where ad_date='".date("Y-m-d")."' and ad_mcc_id='".$mcc."' ");
			}

		}
		return true;
	}


	/**************************************************************************/

		function getConversionBoosterReport($ad_account_adword_id,$type,$month,$startDate,$endDate){

		$insertSql = "INSERT INTO adword_ConversionBoosterReport  SELECT NULL ,a.`ad_CampaignName`,a.`ad_AdGroupName`,a.`ad_KeywordText`,ROUND((SUM(a.ad_Clicks)/SUM(a.ad_Impressions)*100),2) Ctr, SUM(a.`ad_Clicks`) ad_Clicks,SUM(a.`ad_Impressions`) ad_Impressions ,ROUND(SUM(a.`ad_Cost`)/1000000,2) ad_Cost , SUM(a.`ad_Conversions`) Conversions_sum , ROUND((SUM(a.ad_Conversions)/SUM(a.ad_Clicks))*100,2) ad_ConversionRate , ROUND(((SUM(a.`ad_Cost`)/SUM(a.`ad_Conversions`))/1000000),2) as ad_CostPerConversion ,ROUND(AVG(a.ad_AveragePosition),2) as ad_AveragePosition , MAX(a.ad_FirstPageCpc) as ad_FirstPageCpc , MAX(a.ad_TopOfPageCpc) ad_TopOfPageCpc ,SUM(a.ad_ConversionValue) as ad_ConversionValue ,a.`ad_Keyword_Id`,a.`ad_CampaignId`,a.`ad_AdGroupId`,a.`ad_KeywordMatchType` ,'".$month."','".$type."','".$ad_account_adword_id."', now() , b.ad_QualityScore,b.ad_keyword_adword_status,b.ad_CpcBid  FROM `adword_keyword_report1` as a inner join adword_keywords as b on a.`ad_CampaignId` = b.ad_campaign_adword_id and a.`ad_AdGroupId`=b.ad_adgroup_adword_id and a.`ad_Keyword_Id` = b.ad_keyword_adword_id WHERE a.`ad_Date` BETWEEN '".$startDate."' AND '".$endDate."' AND a.ad_account_id='".$ad_account_adword_id."' AND ad_keyword_adword_status='ENABLED' GROUP BY a.`ad_Keyword_Id`,a.`ad_CampaignId`,a.`ad_AdGroupId` HAVING Ctr < 2 AND Ctr >0 AND Conversions_sum <> 0 order by a.`ad_AdGroupName` desc;";

		//echo $insertSql ;

		if($this->Query($insertSql)){ return true;	}
		else{return false;}
	}

	function getAdLabelReport($ad_account_adword_id,$type,$month,$startDate,$endDate){

	//$insertSql  = "INSERT INTO ad_AdLabelReport SELECT null,max(ad_report_id) id ,ad_Labels, ad_AdGroupId , ad_AdType ,`ad_Headline`,`ad_Description1`, `ad_Description2`,`ad_DisplayUrl`, SUM(ad_Clicks) clicks , SUM(ad_Impressions) impressions ,  ROUND(((SUM(ad_Clicks)/SUM(ad_Impressions)) * 100),2) ctr ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Clicks`))/1000000),2) as ad_avgCpc ,SUM(ad_Conversions) convrns  , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2) convrate ,ROUND(((SUM(`ad_Cost`)/ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2))/1000000),2) as ad_CstPConvR, ROUND((SUM(ad_Cost)/1000000),2) cost ,'".$month."','".$type."','".$ad_account_adword_id."',now() FROM `adword_ad_reports` A WHERE ad_account_id ='".$ad_account_adword_id."' AND `ad_Date` BETWEEN '".$startDate."' AND '".$endDate."' AND (ad_Labels <>'' AND ad_Labels NOT LIKE '%--%') AND ad_Status='ENABLED' GROUP BY ad_Labels having clicks > 0 ; " ;
        $insertSql ="INSERT INTO ad_AdLabelReport SELECT null,max(report.ad_report_id) id,report.ad_Labels, ad_AdGroupId , ad_AdType ,`ad_Headline`,`ad_Description1`, `ad_Description2`,`ad_DisplayUrl`, SUM(ad_Clicks) clicks , SUM(ad_Impressions) impressions ,  ROUND(((SUM(ad_Clicks)/SUM(ad_Impressions)) * 100),2) ctr ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Clicks`))/1000000),2) as ad_avgCpc ,SUM(ad_Conversions) convrns  , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2) convrate ,ROUND(((SUM(`ad_Cost`)/ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2))/1000000),2) as ad_CstPConvR, ROUND((SUM(ad_Cost)/1000000),2) cost ,'".$month."','".$type."','".$ad_account_adword_id."',now()FROM `adword_ad_reports` report INNER JOIN (SELECT t1.`ad_Id` FROM `adword_ad_reports` t1 WHERE t1.`ad_report_id` IN (SELECT MAX(`ad_report_id`) FROM `adword_ad_reports` t2 WHERE t2.`ad_account_id` ='$ad_account_adword_id' GROUP BY `ad_Id` ) AND t1.`ad_Status`='enabled') t3 on report.`ad_Id` = t3.`ad_Id` WHERE report.`ad_Date` BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND (ad_Labels <>'' AND ad_Labels NOT LIKE '%--%')  AND `ad_account_id` ='$ad_account_adword_id' GROUP BY report.ad_Labels having clicks > 0 ;";
        
	if($this->Query($insertSql)){ return true;	}
	else{return false;}
	}
	function getWastageAnalysisReport($ad_account_adword_id,$type,$month,$startDate,$endDate){

	$insertSql = "INSERT INTO `adword_WastageAnalysis` SELECT NULL,`ad_Query`,`ad_MatchType`,`ad_KeywordTextMatchingQuery`,`ad_CampaignName`,`ad_AdGroupName`,SUM(`ad_Clicks`) ad_Clicks ,SUM(`ad_Impressions`) ad_Impressions, SUM(`ad_Conversions`) ad_Conversions , SUM(`ad_Cost`) ad_Cost ,SUM(`ad_Cost`)/ SUM(`ad_Conversions`)  as ad_CostPerConversion ,SUM(`ad_ConversionValue`) ad_ConversionValue,`ad_AveragePosition`,'".$month."','".$ad_account_adword_id."',now(),'".$type."' FROM `adword_search_query_reports` WHERE `ad_Date` BETWEEN '".$startDate."' AND '".$endDate."' AND `ad_account_id` ='".$ad_account_adword_id."' AND ad_Query <>ad_KeywordTextMatchingQuery GROUP BY `ad_Query`,`ad_CampaignName`,`ad_AdGroupName` HAVING `ad_Clicks` >0 and ad_Conversions=0 ORDER BY  ad_Clicks DESC ,`ad_CampaignName` DESC LIMIT 25";


	if($this->Query($insertSql)){ return true;	}
	else{return false;}
}
	function getKeywordDiscoveryReport($ad_account_adword_id,$type,$month,$startDate,$endDate){

	$insertSql = "INSERT INTO `adword_KeywordDiscovery` SELECT NULL, `ad_Query`,`ad_MatchType`,`ad_KeywordTextMatchingQuery`,`ad_CampaignId`,`ad_CampaignName`,`ad_AdGroupName`,SUM(`ad_Clicks`) ad_Clicks ,SUM(`ad_Impressions`) ad_Impressions, SUM(`ad_Conversions`) ad_Conversions , SUM(`ad_Cost`) ad_Cost ,SUM(`ad_Cost`)/ SUM(`ad_Conversions`)  as ad_CostPerConversion ,ad_Device ,'".$month."','".$ad_account_adword_id."',now(),'".$type."'  FROM `adword_search_query_reports` WHERE `ad_Date` BETWEEN '".$startDate."' AND '".$endDate."' AND `ad_account_id` ='".$ad_account_adword_id."' AND ad_Query <>ad_KeywordTextMatchingQuery GROUP BY `ad_Query`,`ad_Device`,`ad_CampaignName`,`ad_AdGroupName` HAVING `ad_Conversions` >0 ORDER BY  ad_Conversions DESC ,`ad_CampaignName` DESC ,ad_Device ASC  LIMIT 25";


	if($this->Query($insertSql)){ return true;	}
	else{return false;}
	}
	function deleteReport($report,$rportTypeName,$rportType,$month,$ad_account_adword_id){

		$deleteSql = "DELETE from $report where $rportTypeName=$rportType and ad_Month = '".$month."' and ad_account_id='".$ad_account_adword_id."'";
		$this->Query($deleteSql);
	}
	function checkDuplicate($report,$rportTypeName,$rportType,$month,$ad_account_adword_id){

	$duplicateSql = "SELECT count(*) as total from $report where $rportTypeName=$rportType and ad_Month = '".$month."' and ad_account_id='".$ad_account_adword_id."'";

	$result = $this->getRow($duplicateSql);
	if($result->total >0){
		return true;
	}
	else{
		return false;
	}
	}

	function selectConversionBoosterReports($id,$type,$month=""){

		if($month<>""){ $where = "and ad_Month LIKE '$month%'";} else { $where="and ad_Month LIKE '".date('Y-m')."%'"; }
		$sql = "SELECT ad_CampaignName,ad_AdGroupName,ad_KeywordText,ad_KeywordMatchType,ad_keyword_adword_status,ad_QualityScore,ad_Clicks,ad_Impressions,
		ad_Cost,ad_ConversionRate,ad_CostPerConversion,ad_Ctr,ad_Conversions,ad_AveragePosition,ad_FirstPageCpc,ad_CpcBid FROM
		adword_ConversionBoosterReport WHERE ad_account_id='$id' and ad_CBreport_type='$type' $where group by ad_KeywordText,ad_AdGroupName,ad_CampaignName order by ad_Ctr asc";

		$results = $this ->getResults($sql);
		echo '<!--Sql '.$sql.' <br/> -->';
		return $results ;

	}

	function selectAdLabelReport($id,$type,$month=""){

		if($month<>""){ $where = "and ad_Month LIKE '$month%'";} else { $where="and ad_Month LIKE '".date('Y-m')."%'"; }

		$sql = "SELECT ad_Labels,ad_clicks,ad_impressions,ad_ctr,ad_avgCpc,ad_cost,ad_CostPerConversion,ad_CstPConvR,ad_convrate,ad_convrns FROM ad_AdLabelReport WHERE ad_account_id='$id' and ad_ALreport_type='$type' $where group by ad_Labels order by ad_clicks desc ";
	    
		
		$results = $this ->getResults($sql);

		return $results ;
	}
	/* function selectWastageAnalysis($id,$type,$month=""){

		if($month<>""){ $where = "and ad_Month='$month'";} else {$where="";}

		$sql = "SELECT `ad_Query`,`ad_MatchType`,`ad_KeywordTextMatchingQuery`,`ad_CampaignName`,`ad_AdGroupName`, ad_Clicks ,ad_Impressions,ad_Conversions ,ad_Cost ,ad_CostPerConversion , ad_ConversionValue,`ad_AveragePosition` FROM `adword_WastageAnalysis` WHERE ad_account_id='$id' and ad_WAReport_type=$type";

		$results = $this ->getResults($sql);

		return $results ;
	} */

	function selectWastageAnalysis($id,$type,$cname='',$month=""){

	   if($month<>""){ $where = "and ad_Month LIKE '$month%'";} else { $where="and ad_Month LIKE '".date('Y-m')."%'"; }


	    $sql = "SELECT ad_Query,ad_MatchType,ad_KeywordTextMatchingQuery,ad_CampaignName,ad_AdGroupName, ad_Clicks ,ad_Impressions,ad_Conversions ,ad_Cost ,ad_CostPerConversion , ad_ConversionValue,ad_AveragePosition FROM adword_WastageAnalysis WHERE ad_account_id='$id' and ad_WAReport_type=$type $where ";

	    if($cname<>'all' && $cname<>''){ $sql.= " and ad_CampaignName='$cname'";} else {$sql.="";}

	    //echo $sql;
	    $results = $this ->getResults($sql);

	    return $results ;
	}

/* 	function selectKeywordDiscovery($id,$type,$month=""){

		if($month<>""){ $where = "and ad_Month='$month'";} else {$where="";}

		$sql = "SELECT `ad_report_id`, `ad_Query`, `ad_MatchType`, `ad_KeywordTextMatchingQuery`, `ad_CampaignName`, `ad_AdGroupName`, `ad_Clicks`, `ad_Impressions`, `ad_Conversions`, `ad_Cost`, `ad_CostPerConversion`, `ad_Device`, `ad_Month`, `ad_account_id` FROM `adword_KeywordDiscovery` WHERE ad_account_id='$id' and ad_KDReport_type=$type limit 25 ";

		//echo $sql;

		$results = $this ->getResults($sql);

		return $results ;
	} */

	function selectKeywordDiscovery($id,$type,$cname='',$month=""){

		if($month<>""){ $where = "and ad_Month LIKE '$month%'";} else { $where="and ad_Month LIKE '".date('Y-m')."%'"; }

	    $sql = "SELECT ad_report_id, ad_Query, ad_MatchType, ad_KeywordTextMatchingQuery,ad_CampaignId, ad_CampaignName, ad_AdGroupName, ad_Clicks, ad_Impressions, ad_Conversions, ad_Cost, ad_CostPerConversion, ad_Device, ad_Month, ad_account_id FROM adword_KeywordDiscovery WHERE ad_account_id='$id' and ad_KDReport_type=$type $where";
		
	    if($cname<>'all' && $cname<>''){ $sql.= " and ad_CampaignName='$cname' ";} else {$sql.="";}

	    $sql .= " limit 25 ";
	    //echo $sql;

	    $results = $this ->getResults($sql);

	    return $results ;
	}


	function moveCampaigns($account,$from,$to){

		$moveSql = "INSERT INTO `$to`.`adword_campaigns` (`ad_campaign_id`,`ad_campaign_adword_id`,`ad_campaign_name`,`ad_campaign_adword_status`,`ad_campaign_adword_eligible`,`ad_account_id`,`ad_sitelinks`,`ad_delete_status`,`created_time`,`updated_time`) SELECT NULL,`ad_campaign_adword_id`,`ad_campaign_name`,`ad_campaign_adword_status`,`ad_campaign_adword_eligible`,`ad_account_id`,`ad_sitelinks`,`ad_delete_status`,`created_time`,NOW() FROM `$from`.`adword_campaigns` WHERE ad_account_id='$account'";

		return $results = $this ->getResults($moveSql);
	}

	function deleteCampaigns($account,$from){

		$delSql = "delete from `$from`.`adword_campaigns` WHERE ad_account_id='$account'";

		return $results = $this ->getResults($delSql);

	}

	function moveAdgroups($account,$from,$to){

		$moveSql = "INSERT INTO `$to`.`adword_adgroups` (`ad_adgroup_id`, `ad_adgroup_adword_id`, `ad_adgroup_name`, `ad_adgroup_adword_status`, `ad_campaign_id`, `ad_account_id`, `ad_delete_status`, `created_time`, `updated_time` )
		SELECT NULL, `ad_adgroup_adword_id`, `ad_adgroup_name`, `ad_adgroup_adword_status`, `ad_campaign_id`, `ad_account_id`, `ad_delete_status`, `created_time`, `updated_time` FROM `adword_adgroups` WHERE `ad_account_id`='$account'";

		return $results = $this ->getResults($moveSql);
	}

	function deleteAdgroups($account,$from){

		$delSql = "delete from `$from`.`adword_adgroups` WHERE ad_account_id='$account'";

		return $results = $this ->getResults($delSql);

	}

	function moveAds($account,$from,$to){

		$moveSql = "INSERT INTO `$to`.`adword_ads` (`ad_ads_id`, `ad_ads_adword_id`, `ad_ads_headline`, `ad_ads_description1`, `ad_ads_description2`, `ad_ads_url`, `ad_ads_displayUrl`, `ad_ads_type`, `ad_ads_adword_status`, `ad_adgroup_adword_id`, `ad_campaign_adword_id`, `ad_account_id`, `ad_delete_status`, `created_time`, `updated_time`)
		SELECT `ad_ads_id`, `ad_ads_adword_id`, `ad_ads_headline`, `ad_ads_description1`, `ad_ads_description2`, `ad_ads_url`, `ad_ads_displayUrl`, `ad_ads_type`, `ad_ads_adword_status`, `ad_adgroup_adword_id`, `ad_campaign_adword_id`, `ad_account_id`, `ad_delete_status`, `created_time`, `updated_time` FROM `adword_ads` WHERE `ad_account_id`='$account'";

		return $results = $this ->getResults($moveSql);
	}

	function deleteAds($account,$from){

		$delSql = "delete from `$from`.`adword_ads` WHERE ad_account_id='$account'";

		return $results = $this ->getResults($delSql);

	}


	function moveKeywords($account,$from,$to){

		$moveSql = "INSERT INTO `$to`.`adword_keywords` (`ad_keyword_id`, `ad_keyword_adword_id`, `ad_keyword_text`, `ad_keyword_matchtype`, `ad_keyword_adword_status`, `ad_account_id`, `ad_campaign_adword_id`, `ad_adgroup_adword_id`, `ad_isNegative`, `ad_CriterionUse`, `ad_QualityScore`, `ad_CpcBid`, `created_time`, `ad_delete_status`, `updated_time`, `ad_BidSource`)
		SELECT NULL, `ad_keyword_adword_id`, `ad_keyword_text`, `ad_keyword_matchtype`, `ad_keyword_adword_status`, `ad_account_id`, `ad_campaign_adword_id`, `ad_adgroup_adword_id`, `ad_isNegative`, `ad_CriterionUse`, `ad_QualityScore`, `ad_CpcBid`, `created_time`, `ad_delete_status`,NOW(), `ad_BidSource` FROM `$from`.`adword_keywords` WHERE ad_account_id='$account'";

		return $results = $this ->getResults($moveSql);
	}

	function deleteKeywords($account,$from){

		$delSql = "delete from `$from`.`adword_keywords` WHERE ad_account_id='$account'";

		return $results = $this ->getResults($delSql);

	}

	function moveCampaignReports($account,$from,$to){

		$moveSql = "INSERT INTO `$to`.`adword_campaign_reports` (`ad_report_id`,`ad_account_id`,`ad_Date`,`ad_CampaignId`,`ad_CampaignName`,`ad_SearchImpressionShare`,`ad_Clicks`,`ad_Impressions`,`ad_ExpImpressions`,`ad_Cost`,`ad_Conversions`,`ad_ConversionRate`,`ad_CostPerConversion`,`ad_Ctr`,`ad_AveragePosition`,`ad_ConversionValue`,`ad_AverageCpc`,`ad_DayOfWeek`,`ad_HourOfDay`,`ad_delete_status`,`created_time`,`updated_time`)
		            SELECT NULL,`ad_account_id`,`ad_Date`,`ad_CampaignId`,`ad_CampaignName`,`ad_SearchImpressionShare`,`ad_Clicks`,`ad_Impressions`,`ad_ExpImpressions`,`ad_Cost`,`ad_Conversions`,`ad_ConversionRate`,`ad_CostPerConversion`,`ad_Ctr`,`ad_AveragePosition`,`ad_ConversionValue`,`ad_AverageCpc`,`ad_DayOfWeek`,`ad_HourOfDay`,`ad_delete_status`,`created_time`,NOW() FROM `$from`.`adword_campaign_reports` WHERE ad_account_id='$account'";

		return $results = $this ->getResults($moveSql);
	}

	function deleteCampaignReports($account,$from){

		$delSql = "delete from `$from`.`adword_campaign_reports` WHERE ad_account_id='$account'";

		return $results = $this ->getResults($delSql);

	}

	function moveAccountReports($account,$from,$to){

		$moveSql = "INSERT INTO `$to`.`adword_monthly_report`(`ad_report_id`, `ad_month`, `ad_account_adword_id`, `ad_Clicks`, `ad_Impressions`, `ad_Cost`, `ad_Ctr`, `ad_AverageCpc`, `ad_ConversionRate`, `ad_Conversions`, `ad_CostPerConversion`, `ad_ConversionValue`, `ad_EstimatedTotalConversions`, `ad_SearchImpressionShare`, `created_time`, `updated_time`)
		            SELECT NULL, `ad_month`, `ad_account_adword_id`, `ad_Clicks`, `ad_Impressions`, `ad_Cost`, `ad_Ctr`, `ad_AverageCpc`, `ad_ConversionRate`, `ad_Conversions`, `ad_CostPerConversion`, `ad_ConversionValue`, `ad_EstimatedTotalConversions`, `ad_SearchImpressionShare`, `created_time`, NOW() FROM `$from`.`adword_monthly_report` WHERE `ad_account_adword_id`='$account'";

		return $results = $this ->getResults($moveSql);
	}

	function deleteAccountReports($account,$from){

		$delSql = "delete from `$from`.`adword_monthly_report` WHERE `ad_account_adword_id`='$account'";

		return $results = $this ->getResults($delSql);

	}

	function moveConversionTypeReports($account,$from,$to){

		$moveSql = "INSERT INTO `$to`.`adword_convtype_report`(`ad_report_id`, `ad_account_adword_id`, `ad_month`, `ad_Conversions`, `ad_ConversionTypeName`, `created_time`, `updated_time`)
		            SELECT NULL, `ad_account_adword_id`, `ad_month`, `ad_Conversions`, `ad_ConversionTypeName`, `created_time`, NOW() FROM `$from`.`adword_convtype_report` WHERE `ad_account_adword_id`='$account'";

		return $results = $this ->getResults($moveSql);
	}

	function deleteConversionTypeReports($account,$from){

		$delSql = "delete from `$from`.`adword_convtype_report` WHERE `ad_account_adword_id`='$account'";

		return $results = $this ->getResults($delSql);

	}

	function moveAdReports($account,$from,$to){

		$moveSql = "INSERT INTO `$to`.`adword_ad_reports`(`ad_report_id`, `ad_account_id`, `ad_Id`, `ad_AdGroupId`, `ad_AdGroupName`, `ad_AdType`, `ad_Date`, `ad_CampaignName`, `ad_CampaignId`, `ad_Clicks`, `ad_Impressions`, `ad_Cost`, `ad_Conversions`, `ad_ConversionRate`, `ad_Ctr`, `ad_ConversionValue`, `ad_Description1`, `ad_Description2`, `ad_Device`, `ad_DisplayUrl`, `ad_Headline`, `ad_Status`, `ad_AdGroupStatus`, `ad_Labels`, `ad_delete_status`, `created_time`, `updated_time`)
		            SELECT NULL, `ad_account_id`, `ad_Id`, `ad_AdGroupId`, `ad_AdGroupName`, `ad_AdType`, `ad_Date`, `ad_CampaignName`, `ad_CampaignId`, `ad_Clicks`, `ad_Impressions`, `ad_Cost`, `ad_Conversions`, `ad_ConversionRate`, `ad_Ctr`, `ad_ConversionValue`, `ad_Description1`, `ad_Description2`, `ad_Device`, `ad_DisplayUrl`, `ad_Headline`, `ad_Status`, `ad_AdGroupStatus`, `ad_Labels`, `ad_delete_status`, `created_time`, NOW() FROM `$from`.`adword_ad_reports` WHERE `ad_account_id`='$account'";

		return $results = $this ->getResults($moveSql);
	}

	function deleteAdReports($account,$from){

		$delSql = "delete from `$from`.`adword_ad_reports` WHERE `ad_account_id`='$account'";

		return $results = $this ->getResults($delSql);

	}

	function moveKeywordReports($account,$from,$to){

		$moveSql = "INSERT INTO `$to`.`adword_keyword_report1`(`ad_report_id`, `ad_account_id`, `ad_Keyword_Id`, `ad_AdGroupId`, `ad_CampaignId`, `ad_Date`, `ad_CampaignName`, `ad_AdGroupName`, `ad_KeywordText`, `ad_QualityScore`, `ad_Clicks`, `ad_Impressions`, `ad_Cost`, `ad_Conversions`, `ad_ConversionRate`, `ad_CostPerConversion`, `ad_Ctr`, `ad_AveragePosition`, `ad_FirstPageCpc`, `ad_TopOfPageCpc`, `ad_ConversionValue`, `ad_Device`, `ad_KeywordMatchType`, `created_time`, `updated_time`)
		            SELECT NULL, `ad_account_id`, `ad_Keyword_Id`, `ad_AdGroupId`, `ad_CampaignId`, `ad_Date`, `ad_CampaignName`, `ad_AdGroupName`, `ad_KeywordText`, `ad_QualityScore`, `ad_Clicks`, `ad_Impressions`, `ad_Cost`, `ad_Conversions`, `ad_ConversionRate`, `ad_CostPerConversion`, `ad_Ctr`, `ad_AveragePosition`, `ad_FirstPageCpc`, `ad_TopOfPageCpc`, `ad_ConversionValue`, `ad_Device`, `ad_KeywordMatchType`, `created_time`, NOW() FROM `$from`.`adword_keyword_report1` WHERE `ad_account_id`='$account'";

		return $results = $this ->getResults($moveSql);
	}

	function deleteKeywordReports($account,$from){

		$delSql = "delete from `$from`.`adword_keyword_report1` WHERE `ad_account_id`='$account'";

		return $results = $this ->getResults($delSql);

	}

	function moveSearchQueryReports($account,$from,$to){

		$moveSql = "INSERT INTO `$to`.`adword_search_query_reports`(`ad_report_id`, `ad_AdGroupId`, `ad_CampaignId`, `ad_Date`, `ad_CampaignName`, `ad_AdGroupName`, `ad_Clicks`, `ad_Impressions`, `ad_Cost`, `ad_Ctr`, `ad_Conversions`, `ad_CostPerConversion`, `ad_AveragePosition`, `ad_ConversionValue`, `ad_MatchType`, `ad_Device`, `ad_KeywordTextMatchingQuery`, `ad_CreativeId`, `ad_KeywordId`, `ad_Query`, `ad_account_id`, `created_time`, `updated_time`)
		            SELECT NULL, `ad_AdGroupId`, `ad_CampaignId`, `ad_Date`, `ad_CampaignName`, `ad_AdGroupName`, `ad_Clicks`, `ad_Impressions`, `ad_Cost`, `ad_Ctr`, `ad_Conversions`, `ad_CostPerConversion`, `ad_AveragePosition`, `ad_ConversionValue`, `ad_MatchType`, `ad_Device`, `ad_KeywordTextMatchingQuery`, `ad_CreativeId`, `ad_KeywordId`, `ad_Query`, `ad_account_id`, `created_time`, NOW() FROM `$from`.`adword_search_query_reports` WHERE `ad_account_id`='$account'";

		return $results = $this ->getResults($moveSql);
	}

	function deleteSearchQueryReports($account,$from){

		$delSql = "delete from `$from`.`adword_search_query_reports` WHERE `ad_account_id`='$account'";

		return $results = $this ->getResults($delSql);

	}


	function moveAcccountDetailsFromOneTableToAnother($account,$from,$to){


		$this -> moveAccountReports($account,$from,$to) ;
		$this -> deleteAccountReports($account,$from);

		$this -> moveConversionTypeReports($account,$from,$to) ;
		$this -> deleteConversionTypeReports($account,$from);

		$this -> moveCampaigns($account,$from,$to) ;
		$this -> deleteCampaigns($account,$from);
		$this -> moveCampaignReports($account,$from,$to) ;
		$this -> deleteCampaignReports($account,$from);

		$this -> moveAdgroups($account,$from,$to) ;
		$this -> deleteAdgroups($account,$from);

		/* $this -> moveSitelinks($account,$from,$to) ;
		$this -> deleteSitelinks($account,$from); */

		$this -> moveAds($account,$from,$to) ;
		$this -> deleteAds($account,$from);
		$this -> moveAdReports($account,$from,$to) ;
		$this -> deleteAdReports($account,$from);

		$this -> moveKeywords($account,$from,$to) ;
		$this -> deleteKeywords($account,$from);
		$this -> moveKeywordReports($account,$from,$to) ;
		$this -> deleteKeywordReports($account,$from);

		$this -> moveSearchQueryReports($account,$from,$to) ;
		$this -> deleteSearchQueryReports($account,$from);

	}

	function splitString($str,$n){

		for($i=$n; $i<strlen($str) ; $i += $n+1 ){

			$str = $this->stringInsert($str," ",$i) ;

		}
		return $str ;
	}
	function stringInsert($str,$insertstr,$pos)
	{
		$str = substr($str, 0, $pos) . $insertstr . substr($str, $pos);
		return $str;
	}
	
	function get_quarter($i=0) {
	$y = date('Y');
	$m = date('m');
	if($i > 0) {
		for($x = 0; $x < $i; $x++) {
			if($m <= 3) { $y--; }
			$diff = $m % 3;
			$m = ($diff > 0) ? $m - $diff:$m-3;
			if($m == 0) { $m = 12; }
		}
	}
	switch($m) {
		case $m >= 1 && $m <= 3:
			$start = $y.'-01-01';
			$end = $y.'-03-31';
			$quarter = "Q1-".$y ;
			break;
		case $m >= 4 && $m <= 6:
			$start = $y.'-04-01';
			$end = $y.'-06-30';
			$quarter = "Q2-".$y ;
			break;
		case $m >= 7 && $m <= 9:
			$start = $y.'-07-01';
			$end = $y.'-09-30';
			$quarter = "Q3-".$y ;
			break;
		case $m >= 10 && $m <= 12:
			$start = $y.'-10-01';
			$end = $y.'-12-31';
			$quarter = "Q4-".$y ;
	    	break;
	}
	return array(
		'start' => $start,
		'end' => $end ,
        'quarter'=>$quarter		
	);
}
function getGivenNumberOfQuarters($no=6){
	
	for($i=$no-1; $i >= 0 ; $i--){ $array[]	 = $this->get_quarter($i); }
	
	return $array ;
	
}

function getChangeHistory($account){
	
	$result = array();
	
	for($i=1; $i < 5 ; $i++){
		
		$weekdays = $this -> findWeekDays("-$i","Monday","Sunday") ;
		
		$start = $weekdays[0] ;
		
		$end = $weekdays[1] ;		
	
		$result[] = array(
		
		'ad_account_adword_id' => $account ,
		'campaigns' => $this -> numberOfCampaignsChanged($account,$start,$end) ,
		'adgroups' => $this -> numberOfAdgroupsChanged($account,$start,$end) ,
		'ads' => $this -> numberOfAdsChanged($account,$start,$end) ,
		'keywords' => $this -> numberOfKeywordsChanged($account,$start,$end) , 
		'start' => $start,
		'end' => $end
		
		
		);
		
	}
	
	return $result ;
	
	
	
}

//function to find last week start day and end day


function findWeekDays($week='-1',$startDay="Sunday",$endDay="Saturday"){
	
	$previous_week = strtotime("$week week +1 day");
	
	
	$start_week = strtotime("last $startDay midnight",$previous_week);
	$end_week = strtotime("next $endDay",$start_week);

	$start_week = date("Y-m-d",$start_week);
	$end_week = date("Y-m-d",$end_week);
	
	$result=array($start_week,$end_week);
	return $result ;
}
	
// function to get number of campaigns changed()

function numberOfCampaignsChanged($account,$start,$end){
	
	$sql = "SELECT COUNT(DISTINCT(ad_campaignId)) campaigns FROM adword_campain_change_history WHERE ad_campaignChangeStatus <> 'FIELDS_UNCHANGED' AND ad_account_id='$account' AND ad_date BETWEEN '$start' AND '$end'";
	
	$res = $this ->getRow($sql);
	
	if(count($res)>0){ return $res ->campaigns ; } else { return 0; }
}	

function numberOfAdgroupsChanged($account,$start,$end){
	
	$sql = "SELECT COUNT(DISTINCT(ad_adGroupId)) adgroups FROM adword_adgroup_change_history WHERE ad_adGroupChangeStatus <> 'FIELDS_UNCHANGED' AND ad_account_id='$account' AND ad_date BETWEEN '$start' AND '$end'";
	
	$res = $this ->getRow($sql);
	
	if(count($res)>0){ return $res ->adgroups ; } else { return 0; }
}	

function numberOfAdsChanged($account,$start,$end){
	
	$sql = "SELECT GROUP_CONCAT(ad_changedAds SEPARATOR ',') ads FROM adword_adgroup_change_history WHERE ad_account_id='$account' AND ad_date BETWEEN '$start' AND '$end'";
	
	$res = $this ->getRow($sql);
	
	if(count($res)>0){

		$ads = $res ->ads ;
		
		$ads = explode(",",$ads) ;
		
		$ads = array_unique($ads) ;
		
		return count($ads);
	
	} else { return 0; }
}	

function numberOfKeywordsChanged($account,$start,$end){
	
	$sql = "SELECT GROUP_CONCAT(ad_changedCriteria SEPARATOR ',') ckeywords  FROM adword_adgroup_change_history WHERE ad_account_id='$account' AND ad_date BETWEEN '$start' AND '$end'";
	
	$res = $this ->getRow($sql);
	
	if(count($res)>0){

		$ckeywords = $res ->ckeywords ;
		
		$ckeywords = explode(",",$ckeywords) ;
		
		$ckeywords = array_unique($ckeywords) ;
		
		return count($ckeywords);
	
	} else { return 0; }
}	

function getChangeHistoryReport($uid,$utype){
	
	$where ="";
	
	if($utype==1){ $where = "WHERE ad_account_id IN (SELECT ad_account_adword_id FROM adword_accounts WHERE ad_user_id='".$uid."')";}
	
	$sql ="SELECT `ad_report_id`, `ad_account_id`, `ad_account_name`, `ad_campaigns`, `ad_adgroups`, `ad_ads`, `ad_keywords`, `ad_start`, `ad_end`, `created_time` FROM `adword_change_history_reports` $where ;";
	
	
	$res = $this ->getResults($sql,'ARRAY_A');
	
	return $res ;
	
}

function checkifEntityDownloadNeeded($accountid){
	
	$sql = "select ad_account_id from adword_entity_workflows where (`created_time` LIKE '".date('Y-m-d')."%' OR updated_time < (SELECT created_time FROM adword_campain_change_history order by ad_campaign_change_history_id asc limit 1) OR ad_account_id IN (SELECT ad_account_id FROM adword_campain_change_history WHERE created_time > '".date('Y-m-d',strtotime('-5 days'))."'  AND ad_account_id = '$accountid' ) OR ad_account_id IN (SELECT ad_account_id FROM adword_adgroup_change_history WHERE created_time > '".date('Y-m-d',strtotime('-5 days'))."'  AND ad_account_id = '$accountid' ) ) AND ad_account_id = '$accountid' ";
	
	$res = $this ->getResults($sql,'ARRAY_A');
	
	if(count($res)>0){ return true ;} else{ return false ;}
	
}

function getBudgetOrder($mcc=6093644096){

	
	$sql = "
	SELECT 
	A.ad_account_id ,
	CASE WHEN `ad_budget_order_adword_id` IS NULL THEN '--' else `ad_budget_order_adword_id` end as 'ad_budget_order_adword_id' ,
	CASE WHEN `ad_budget_order_name` IS NULL THEN '--' else `ad_budget_order_name` end as 'ad_budget_order_name' ,
	CASE WHEN `ad_po_number` IS NULL THEN '--' else `ad_po_number` end as 'ad_po_number' ,
	CASE WHEN `ad_primary_billing_id` IS NULL THEN '--' else `ad_primary_billing_id` end as 'ad_primary_billing_id' ,
	CASE WHEN `ad_billing_account_id` IS NULL THEN '--' else `ad_billing_account_id` end as 'ad_billing_account_id' ,
	CASE WHEN `ad_billing_account_name` IS NULL THEN '--' else `ad_billing_account_name` end as 'ad_billing_account_name' ,	
	A.`ad_spending_limit`, A.`ad_start_time`, A.`ad_end_time`, A.`ad_budget_order_status`, B.ad_account_name ,B.ad_account_company ,B.ad_account_currencyCode ,B.ad_user_id
	FROM adword_budget_orders A	
	LEFT JOIN adword_accounts B on A.ad_account_id = B.ad_account_adword_id
	WHERE A.ad_budgetorder_id IN (SELECT ad_budgetorder_id  FROM adword_budget_orders  WHERE (ad_account_id,ad_end_time) IN (SELECT ad_account_id,MAX(ad_end_time) ad_end_time FROM adword_budget_orders GROUP BY ad_account_id  )  order by ad_budgetorder_id DESC)
	AND B.ad_account_status=1 and B.ad_delete_status = 0 AND ad_mcc_id = '$mcc'
	ORDER BY A.ad_end_time ASC  , A.ad_spending_limit DESC ;
	";	
	 
	$results = $this -> getResults($sql);
		
	$spentarray = $return = array() ;
	
	foreach($results as $result){
		
		if($result ->ad_spending_limit >0 ){
			
			if($result ->ad_end_time > date('Y-m-d H:i:s',"+20 years")) { 
				$startDate = date("Y-m-d", strtotime('first day of this month')); 
				$endDate = date("Y-m-d");
				}
			else{
				$startDate = date('Y-m-d',strtotime($result ->ad_start_time));
				$endDate = date('Y-m-d',strtotime($result ->ad_end_time));
			}
			
			$spentsql = "select SUM( ad_Cost ) cost , ROUND((SUM( ad_Cost ) * 100 / ".$result ->ad_spending_limit." ),2) spent FROM adword_campaign_reports WHERE ad_account_id = '".$result->ad_account_id."' and ad_Date BETWEEN '".$startDate."' AND '".$endDate."' GROUP BY ad_account_id ;";
			$spentres = $this -> getRow($spentsql) ;

			if($spentres){
		
				$spent = $spentres -> spent ;
			
			}
			else{
				
				$spent = 0;
			}
		}
		else{
			
			$spent = 0;
		}
		
		$spentarray[] = $spent ;
		
		$return[] = array(
		
		'ad_budget_order_adword_id' => $result -> ad_budget_order_adword_id ,
		'ad_budget_order_name' => $result -> ad_budget_order_name ,
		'ad_po_number' => $result -> ad_po_number,
		'ad_billing_account_id' => $result -> ad_billing_account_id,
		'ad_billing_account_name' => $result -> ad_billing_account_name,
		'ad_account_company' => $result -> ad_account_company,
		'ad_primary_billing_id' => $result -> ad_primary_billing_id,
		'ad_start_time' => $result -> ad_start_time,
		'ad_end_time' => $result -> ad_end_time,
		'ad_budget_order_status' => $result -> ad_budget_order_status,
		'ad_account_name' => $result -> ad_account_name,
		'ad_account_id' => $result -> ad_account_id,
		'ad_spending_limit' => $result -> ad_spending_limit/ 1000000,
		'spent' => $spent,
		'ad_user_id' => $result -> ad_user_id ,
		'ad_account_currencyCode' => $result -> ad_account_currencyCode 
		
		
		);
		
	}
	
	arsort($spentarray);
	
	$returnar = array();
	
	foreach($spentarray as $key => $value){
		
		$returnar[] = $return[$key] ;
	}
	
	return $returnar ;
}


function getBudgetOrderReport($mcc=6093644096,$user_id=0,$user_type =0){
	
	if($user_type==3) {
		
		$sql = "SELECT user_users FROM DB_DATABASE.adword_users WHERE ad_user_id = '$user_id';";
		
		$res = $this ->getRow($sql) ;
		
		$user_id = $res -> user_users ;
	}
	
	$sql = "SELECT * FROM adword_budget_order_reports WHERE ad_mcc_id='$mcc'";
	
	if($user_id <> 2) $sql = $sql . "AND ad_user_id IN('".$user_id."')";
	
	$res = $this ->getResults($sql ,'ARRAY_A');
	
	return $res ;

}



}



?>