<?php
require_once dirname(__FILE__) . '/../includes/init.php';
require_once dirname(__FILE__) . '/../includes/includes.php';

$type = 'ETC';
$id = 2570035894;
$current_day = date('Y-m-d');
   
 $sel = "SELECT ad_account_adword_id FROM adword_accounts where adword_accounts.ad_account_status= '1'";		
 $accounts = $main->getResults($sel);	
 foreach($accounts as $selectd_account)											
 {
    $id = $selectd_account->ad_account_adword_id;
    $startDate = date("Y-m-d", strtotime("-3 months"));  
    //$startDate = date("Y-m-d",strtotime('first day of this month', strtotime($date)));
    $endDate = date("Y-m-d",strtotime("-1 days"));
	$count = $main->getRow("SELECT SUM(ad_Conversions) as sum FROM adword_keyword_report1 WHERE ad_account_id='".$id."' and ad_Date BETWEEN '".$startDate."' AND '".$endDate."' and ad_Conversions <> 0") ;
	
	$count=$count->sum ;
	
	
	$sql = "SELECT `ad_CampaignName`,`ad_AdGroupName`,`ad_KeywordText`,ad_KeywordMatchType,ROUND((SUM(ad_Clicks)/SUM(ad_Impressions)*100),2) Ctr, SUM(`ad_Clicks`) ad_Clicks,SUM(`ad_Impressions`) ad_Impressions ,ROUND(SUM(`ad_Cost`)/1000000,2) ad_Cost , SUM(`ad_Conversions`) ad_convers , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks))*100,2) ad_ConversionRate , ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion ,ROUND(AVG(ad_AveragePosition),2) as ad_AveragePosition , SUM(ad_FirstPageCpc) as ad_FirstPageCpc,SUM(ad_TopOfPageCpc) ad_TopOfPageCpc  ,SUM(ad_ConversionValue) as ad_ConversionValue ,ad_Keyword_Id,ad_AdGroupId,ad_CampaignId
	FROM `adword_keyword_report1` 
	WHERE `ad_Date` BETWEEN '$startDate' AND '$endDate' AND ad_account_id='$id'  GROUP BY adword_keyword_report1.`ad_Keyword_Id`,`ad_CampaignId`,`ad_AdGroupId`  order by `ad_convers` desc LIMIT 25
	";
	
	$results = $main->getResults($sql);
	
	
	$ad_Conversions=0;
    foreach($results as $result){
	
	
	   /*$sel = "select ad_QualityScore,ad_keyword_adword_status FROM adword_keywords where adword_keywords.ad_keyword_adword_id = '".$result->ad_Keyword_Id."' AND ad_keyword_adword_status='ENABLED'";*/
	   $sel = "select ad_QualityScore,ad_keyword_adword_status FROM adword_keywords where adword_keywords.ad_keyword_adword_id = '".$result->ad_Keyword_Id."' AND adword_keywords.ad_adgroup_adword_id = '".$result->ad_AdGroupId."' AND adword_keywords.ad_campaign_adword_id = '".$result->ad_CampaignId."' and ad_keyword_adword_status='ENABLED'";
	   
	   
	    $sel_res = $main->getRow($sel);
		
		if(count($sel_res)>0){
  /*   $cost = round($result -> ad_Cost / 1000000,2) ;
    $ad_ConversionRate = round($result -> ad_ConversionRate / 1000000,2) ;
    $ad_CostPerConversion = round($result -> ad_CostPerConversion / 1000000,2) ; */
    $ad_FirstPageCpc = round($result -> ad_FirstPageCpc / 100000000, 2);
    $ad_TopOfPageCpc = round($result -> ad_TopOfPageCpc / 100000000, 2);
	
	if($ad_Conversions > ($count * .8) ) { /* echo " $ad_Conversions  Which is just greater than 80%. Loop stops now. <br />"; */ break ;}
	
	$ad_Conversions += $result -> ad_convers ;
	
	
															
$ad_AveragePosition = $result -> ad_AveragePosition;
$query = "INSERT INTO reports_80_20 (`added_date`, `ad_account_id`, `ad_CampaignName`, `ad_AdGroupName`, `ad_KeywordText`, `ad_KeywordMatchType`, `ad_Clicks`, `ad_Impressions`, `Ctr`, `ad_AveragePosition`, `ad_Cost`, `ad_convers`, `ad_ConversionRate`, `ad_CostPerConversion`, `ad_QualityScore`, `ad_FirstPageCpc`, `ad_TopOfPageCpc`) 
VALUES ('".$current_day." ', '".$id."','".$result -> ad_CampaignName."', '".$result -> ad_AdGroupName."', '".$result -> ad_KeywordText."',
 '".$result -> ad_KeywordMatchType."', '".$result -> ad_Clicks."', '".$result -> ad_Impressions."', '".$result -> Ctr."',
 '".$ad_AveragePosition."', '".$result -> ad_Cost."', '".$result -> ad_convers."', '".$result -> ad_ConversionRate."',
 '".$result ->ad_CostPerConversion."', '".$sel_res -> ad_QualityScore."', '".$ad_FirstPageCpc."', '".$ad_TopOfPageCpc."')";
 
 
 

} }}
?>