<?php
if(!isset($_SESSION['user_name'])){ header("Location:index.php");}
if($type !="QSM" || $id=='' ){

	header("Location:account_details.php");
}

?>
<div id="listhead">
  <table width="100%" height="100%" border="0">
    <tr>
	<th style='width:10%'>Campaign Name</th>
	<th style='width:10%'>AdGroup Name</th>
	<th style='width:10%'>Keyword Text</th>
	<th style='width:5%'>Quality Score</th>	
	<th style='width:10%'>Impr</th>		
	<th style='width:5%'>Clicks</th>		
	<th style='width:10%'>Conv</th>		
	<th style='width:10%'>Cost</th>		
	<th style='width:10%'>Cost/ Conv</th>		
	<th style='width:10%'>QS Before 1 Month</th>		
	<th style='width:10%'>QS Before 2 Months</th>		
	<!--th style='width:10%'>Conversion Value</th-->
 </tr></table>
</div>
<div id="listitems">
<table width="100%"  border="0"> 
<?php
 
	
$sql = "SELECT SUM(`ad_Clicks`) ad_Clicks,SUM(`ad_Impressions`) ad_Impressions, SUM(`ad_Cost`) ad_Cost, SUM(`ad_Conversions`) convs ,case when SUM(`ad_Conversions`) <>0 THEN SUM(`ad_Cost`)/ SUM(`ad_Conversions`) else 0 end as ad_CostPerConversion,SUM(`ad_ConversionValue`) ad_ConversionValue, A.ad_Keyword_Id,A.ad_AdGroupId,A.ad_CampaignId ,B.`ad_QualityScore`,B.`ad_KeywordText`,B.`ad_AdGroupName`,B.`ad_CampaignName` FROM adword_keyword_report1 A INNER JOIN (SELECT `ad_QualityScore`,`ad_Keyword_Id`,`ad_CampaignName`,`ad_AdGroupName`,`ad_KeywordText`,ad_CampaignId,ad_AdGroupId FROM adword_keyword_report1 A  INNER JOIN (SELECT MAX(ad_report_id) max FROM adword_keyword_report1 WHERE `ad_account_id` ='$id' GROUP BY ad_Keyword_Id,ad_AdGroupId,ad_CampaignId HAVING SUM(`ad_Clicks`) <>0 ) B ON A.ad_report_id = B.max  
WHERE `ad_QualityScore` < 5 AND `ad_QualityScore` <> 0 ) B ON B.ad_Keyword_Id = A.ad_Keyword_Id AND B.`ad_AdGroupId`=A.`ad_AdGroupId` AND A.`ad_CampaignId` = B.`ad_CampaignId` GROUP BY A.ad_Keyword_Id,A.ad_AdGroupId,A.ad_CampaignId ORDER BY convs desc ;";
	
	$results = $main -> getResults($sql);
	
	
	foreach($results as $result){
	
	
	$sql = " 
	SELECT ad_QualityScore,ad_Date from adword_keyword_report1 WHERE ad_Date IN ('".date("Y-m-d",strtotime('-1 months'))."','".date("Y-m-d",strtotime('-2 months'))."') and `ad_account_id` ='$id' and ad_Keyword_Id = '".$result->ad_Keyword_Id."' AND ad_AdGroupId = '".$result->ad_AdGroupId."' AND ad_CampaignId = '".$result->ad_CampaignId."' ";
	
	$res = $main -> getResults($sql);
	
	foreach($res as $val){
	
		if($val->ad_Date == date("Y-m-d",strtotime('-1 months'))) {$before1month = $val->ad_QualityScore;}
		elseif($val->ad_Date == date("Y-m-d",strtotime('-2 months'))) {$before2month = $val->ad_QualityScore;}
	
	}
	
	?>
<tr>
	<td style='width:10%; text-align:left;'><?php echo $result->ad_CampaignName; ?></td>
	<td style='width:10%; text-align:left;'><?php echo $result->ad_AdGroupName; ?></td>
	<td style='width:10%; text-align:left;'><?php echo $result->ad_KeywordText; ?></td>
	<td style='width:5%'><?php echo $result->ad_QualityScore; ?></td>	
	<td style='width:10%'><?php echo $result->ad_Impressions; ?></td>		
	<td style='width:5%'><?php echo $result->ad_Clicks; ?></td>
	<td style='width:10%'><?php echo $result->convs; ?></td>	
	<td style='width:10%'><?php echo ROUND($result->ad_Cost/ 100000,2); ?></td>		
	<td style='width:10%'><?php echo ROUND($result->ad_CostPerConversion / 100000,2); ?></td>		
	<!--td style='width:10%'><?php echo $result->ad_ConversionValue; ?></td-->		
	<td style='width:10%'><?php echo $before1month; ?></td>
	<td style='width:10%'><?php echo $before2month; ?></td>
</tr>
<?php } ?></table>
</div>
