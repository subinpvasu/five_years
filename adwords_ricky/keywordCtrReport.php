<?php
if(!isset($_SESSION['user_name'])){ header("Location:index.php");}
if($type !="CBR" || $id=='' ){

	header("Location:account_details.php");
}

?>

<div id="listhead">
  <table width="100%" height="100%" border="0">
    <tr>
    <th style='width:10%'>Campaign Name</th>
    <th style='width:15%'>AdGroup Name</th>
    <th style='width:15%'>Keyword Text</th>
    <th style='width:5%'>Match Type</th>
    <th style='width:5%'>Status</th>
    <th style='width:5%'>Q S</th>	
    <th style='width:5%'>Clicks</th>		
    <th style='width:5%'>Impr</th>		
    <th style='width:5%'>Cost</th>		
    <th style='width:5%'>Conv</th>		
    <th style='width:5%'>Conv Rate</th>		
    <th style='width:5%'>Cost / Conv</th>		
    <th style='width:5%'>Ctr %</th>	
    <th style='width:5%'>Avg Position</th>
    <!--th style='width:10%'>First Page Cpc</th-->
    <th style='width:5%'>Top Of Page Cpc</th>
    <!--th style='width:5%'>Conversion Value</th-->
</tr>
  </table>	
</div> 
<div id="listitems">
<table width="100%"  border="0">
<?php
    $startDate = date("Y-m-d", strtotime("-3 months"));  //echo  $startDate ; exit;
    //$startDate = date("Y-m-d",strtotime('first day of this month', strtotime($date)));
    $endDate = date("Y-m-d");
 	

	$sql = "SELECT `ad_CampaignName`,`ad_AdGroupName`,`ad_KeywordText`,ROUND((SUM(ad_Clicks)/SUM(ad_Impressions)*100),2) Ctr, SUM(`ad_Clicks`) ad_Clicks,SUM(`ad_Impressions`) ad_Impressions ,ROUND(SUM(`ad_Cost`)/1000000,2) ad_Cost , SUM(`ad_Conversions`) Conversions_sum , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks))*100,2) ad_ConversionRate , ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion ,ROUND(AVG(ad_AveragePosition),2) as ad_AveragePosition , MAX(ad_FirstPageCpc) as ad_FirstPageCpc , MAX(ad_TopOfPageCpc) ad_TopOfPageCpc ,SUM(ad_ConversionValue) as ad_ConversionValue  ,`ad_Keyword_Id`,`ad_CampaignId`,`ad_AdGroupId`,ad_KeywordMatchType
	
	FROM `adword_keyword_report1` 
	WHERE `ad_Date` BETWEEN '$startDate' AND '$endDate' AND ad_account_id='$id'  GROUP BY `ad_Keyword_Id`,`ad_CampaignId`,`ad_AdGroupId` HAVING Ctr < 2 AND Ctr >0 AND Conversions_sum <> 0 order by `ad_AdGroupName` desc
	";
	
	$results = $main ->getResults($sql);
			

    foreach($results as $result){

	$sel = "select ad_QualityScore,ad_keyword_adword_status,adword_keywords.ad_QualityScore,ad_CpcBid FROM adword_keywords where adword_keywords.ad_keyword_adword_id = '".$result->ad_Keyword_Id."' and adword_keywords.ad_campaign_adword_id = '".$result->ad_CampaignId."' and adword_keywords.ad_adgroup_adword_id = '".$result->ad_AdGroupId."' and ad_keyword_adword_status='ENABLED'";
	
	$sel_res = $main->getRow($sel);

	
	if(count($sel_res)>0){
				
    $ad_FirstPageCpc = round($result -> ad_FirstPageCpc / 1000000 , 2);
    $ad_TopOfPageCpc = round($result -> ad_TopOfPageCpc /1000000 , 2);
    $ad_CpcBid = round($sel_res -> ad_CpcBid /1000000 , 2);

    if($ad_FirstPageCpc > $ad_CpcBid) {$style = "color : red;";} else {$style ="";}

?>

<tr>
    <td style='width:10%; text-align:left;'><?php echo $result -> ad_CampaignName ;?> </td>
    <td style='width:15%; text-align:left;'><?php echo $result -> ad_AdGroupName ;?> </td>
    <td style='width:15%; text-align:left;'><?php echo $result -> ad_KeywordText ;?> </td>
    <td style='width:5%'><?php echo $result -> ad_KeywordMatchType ;?> </td>
    <td style='width:5%'><?php echo $sel_res -> ad_keyword_adword_status; ?> </td>
    <td style='width:5%'><?php echo $sel_res -> ad_QualityScore ;?> </td>	
    <td style='width:5%'><?php echo $result -> ad_Clicks ;?> </td>		
    <td style='width:5%'><?php echo $result -> ad_Impressions ;?> </td>		
    <td style='width:5%'><?php echo $result ->ad_Cost ;?> </td>		
    <td style='width:5%'><?php echo $result -> Conversions_sum ;?> </td>		
    <td style='width:5%'><?php echo $result ->ad_ConversionRate ;?> </td>		
    <td style='width:5%'><?php echo $result ->ad_CostPerConversion ;?> </td>		
    <td style='width:5%'><?php echo $result ->Ctr;?> </td>	
    <td style='width:5%'><?php echo $result -> ad_AveragePosition ;?> </td>
    <!--td style='width:10%'><?php echo $ad_FirstPageCpc ;?> </td-->
    <td style='width:5%'><?php echo $ad_TopOfPageCpc ;?> </td>
    <!--td style='width:5%'><?php echo $result -> ad_ConversionValue ;?> </td-->
</tr> 

<?php } } ?>
</table>
</div>