<?php
if(!isset($_SESSION['user_name'])){ header("Location:index.php");}
if($type !="ETC" || $id=='' ){

	header("Location:account_details.php");
}

?>
<style>
.headerSortUp
	{
background-image: url("./images/downn.png");
		 background-position: center top;
    background-repeat: no-repeat;
    background-size: 20px auto;

cursor: pointer;
    }
.headerSortDown
	{
background-image: url("./images/up.png");
		 	 background-position: center top;
    background-repeat: no-repeat;
    background-size: 20px auto;
cursor: pointer;
	}
</style>


<div id="listhead">
  <table width="100%" height="100%" border="0" class="tablesorter">
  <thead>
    <tr>
	<th style='width:12%' id="camp_name">Campaign Name</th>
	<th style='width:12%'>AdGroup Name</th>
	<th style='width:11%'>Keyword Text</th>
	<th style='width:10%'>Match Type</th>
	<th style='width:5%'>Clicks</th>
	<th style='width:5%'>Impr</th>
	<th style='width:4%'>Ctr (%)</th>
	<th style='width:6%'>Avg Position</th>
	<th style='width:5%'>Cost</th>
	<th style='width:5%'>Conv</th>
	<th style='width:5%'>Conv Rate</th>
	<th style='width:5%'>Cost / Conv</th>
	<th style='width:5%'>Q S</th>
	<th style='width:5%'>First Page Cpc</th>
	<th style='width:5%'>Top Of Page Cpc</th>
	<!--th style='width:5%'>Conversion Value</th-->
</tr>
</thead> <tbody>
<?php

    $startDate = date("Y-m-d", strtotime("-3 months"));
    //$startDate = date("Y-m-d",strtotime('first day of this month', strtotime($date)));
    $endDate = date("Y-m-d",strtotime("-1 days"));

	$count = $main->getRow("SELECT SUM(ad_Conversions) as sum FROM adword_keyword_report1 WHERE ad_account_id='".$id."' and
	    ad_Date BETWEEN '".$startDate."' AND '".$endDate."' and ad_Conversions <> 0") ;

	$count=$count->sum ;


	$sqlss = "SELECT a.ad_CampaignName,a.ad_AdGroupName,a.ad_KeywordText,a.ad_KeywordMatchType,ROUND((SUM(a.ad_Clicks)/SUM(a.ad_Impressions)*100),2) Ctr,
	SUM(a.ad_Clicks) ad_Clicks,SUM(a.ad_Impressions) ad_Impressions ,ROUND(SUM(a.ad_Cost)/1000000,2) ad_Cost , SUM(a.ad_Conversions) ad_convers ,
	ROUND((SUM(a.ad_Conversions)/SUM(a.ad_Clicks))*100,2) ad_ConversionRate , ROUND(((SUM(a.ad_Cost)/SUM(a.ad_Conversions))/1000000),2) as ad_CostPerConversion,
	ROUND(AVG(a.ad_AveragePosition),2) as ad_AveragePosition , SUM(a.ad_FirstPageCpc) as ad_FirstPageCpc,SUM(a.ad_TopOfPageCpc) ad_TopOfPageCpc  ,
	SUM(a.ad_ConversionValue) as ad_ConversionValue ,a.ad_Keyword_Id,a.ad_AdGroupId,a.ad_CampaignId,(select ad_QualityScore FROM adword_keywords where adword_keywords.ad_keyword_adword_id = a.ad_Keyword_Id
	    AND ad_keyword_adword_status='ENABLED' LIMIT 1) 'ad_QualityScore',(select ad_keyword_adword_status FROM adword_keywords where adword_keywords.ad_keyword_adword_id = a.ad_Keyword_Id
	    AND ad_keyword_adword_status='ENABLED' LIMIT 1) 'ad_keyword_adword_status'
	FROM adword_keyword_report1 a
	WHERE a.ad_Date BETWEEN  '$startDate' AND '$endDate'  AND a.ad_account_id='$id'   GROUP BY a.ad_Keyword_Id,a.ad_CampaignId,
	a.ad_AdGroupId  order by ad_QualityScore DESC
		";

	$sql = "SELECT `ad_CampaignName`,`ad_AdGroupName`,`ad_KeywordText`,ad_KeywordMatchType,ROUND((SUM(ad_Clicks)/SUM(ad_Impressions)*100),2) Ctr,
	SUM(`ad_Clicks`) ad_Clicks,SUM(`ad_Impressions`) ad_Impressions ,ROUND(SUM(`ad_Cost`)/1000000,2) ad_Cost , SUM(`ad_Conversions`) ad_convers ,
	ROUND((SUM(ad_Conversions)/SUM(ad_Clicks))*100,2) ad_ConversionRate , ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion,
	ROUND(AVG(ad_AveragePosition),2) as ad_AveragePosition , SUM(ad_FirstPageCpc) as ad_FirstPageCpc,SUM(ad_TopOfPageCpc) ad_TopOfPageCpc  ,
	SUM(ad_ConversionValue) as ad_ConversionValue ,ad_Keyword_Id,ad_AdGroupId,ad_CampaignId
	FROM `adword_keyword_report1`
	WHERE `ad_Date` BETWEEN '$startDate' AND '$endDate' AND ad_account_id='$id'  GROUP BY adword_keyword_report1.`ad_Keyword_Id`,`ad_CampaignId`,
	`ad_AdGroupId`  order by `ad_convers` desc LIMIT 25
	";
$sqlasd = "SELECT * FROM conversions_eight_two WHERE ad_account_id='$id'";
	//echo $sql ; exit;

	$results = $main->getResults($sql);



	$ad_Conversions=0;
    foreach($results as $result){


	   /* $sel = "select ad_QualityScore,ad_keyword_adword_status FROM adword_keywords where adword_keywords.ad_keyword_adword_id = '".$result->ad_Keyword_Id."' AND adword_keywords.ad_adgroup_adword_id = '".$result->ad_AdGroupId."' AND adword_keywords.ad_campaign_adword_id = '".$result->ad_CampaignId."' and ad_keyword_adword_status='ENABLED'";*/
	   $sel = "select ad_QualityScore,ad_keyword_adword_status FROM adword_keywords where adword_keywords.ad_keyword_adword_id = '".$result->ad_Keyword_Id."'
	    AND ad_keyword_adword_status='ENABLED'";

	    $sel_res = $main->getRow($sel);


		if(count($sel_res)>0){
  /*   $cost = round($result -> ad_Cost / 1000000,2) ;
    $ad_ConversionRate = round($result -> ad_ConversionRate / 1000000,2) ;
    $ad_CostPerConversion = round($result -> ad_CostPerConversion / 1000000,2) ; */
    $ad_FirstPageCpc = round($result -> ad_FirstPageCpc / 100000000, 2);
    $ad_TopOfPageCpc = round($result -> ad_TopOfPageCpc / 100000000, 2);

	if($ad_Conversions > ($count * .8) ) { /* echo " $ad_Conversions  Which is just greater than 80%. Loop stops now. <br />"; */ break ;}

	$ad_Conversions += $result -> ad_convers ;



?>

 <!--    <tr>

		<td style='width:12%;'><?php echo $result -> campaign_name ;?> </td>
		<td style='width:12%;'><?php echo $result -> adgroup_name ;?> </td>
		<td style='width:11%; '><?php echo $result -> keyword_text ;?> </td>
		<td style='width:10%'><?php echo $result -> match_type ;?></td>
		<td style='width:5%'><?php echo $result -> clicks ;?> </td>
		<td style='width:5%'><?php echo $result -> impr ;?> </td>
		<td style='width:4%'><?php echo $result -> ctr ;?> </td>
		<td style='width:6%'><?php echo $result->avg_position ;?> </td>
		<td style='width:5%'><?php echo $result -> cost ;?> </td>
		<td style='width:5%'><?php echo $result -> conv ;?> </td>
		<td style='width:5%'><?php echo $result -> conv_rate ;?> </td>
		<td style='width:5%'><?php echo $result ->cost_conv ;?> </td>
		<td style='width:5%'><?php echo $result -> qs ;?> </td>
		<td style='width:5%'><?php echo $result->first_page_cpc ;?> </td>
		<td style='width:5%'><?php echo $result->top_page_cpc ;?> </td>
		<!--td style='width:5%'><?php echo $result -> ad_ConversionValue ;?> </td

    </tr>-->

    <tr>

		<td style='width:12%;'><?php echo $result -> ad_CampaignName ;?> </td>
		<td style='width:12%;'><?php echo $result -> ad_AdGroupName ;?> </td>
		<td style='width:11%; '><?php echo $result -> ad_KeywordText ;?> </td>
		<td style='width:10%'><?php echo $result -> ad_KeywordMatchType ;?></td>
		<td style='width:5%'><?php echo $result -> ad_Clicks ;?> </td>
		<td style='width:5%'><?php echo $result -> ad_Impressions ;?> </td>
		<td style='width:4%'><?php echo $result -> Ctr ;?> </td>
		<td style='width:6%'><?php echo round($result -> ad_AveragePosition, 2) ;?> </td>
		<td style='width:5%'><?php echo $result -> ad_Cost ;?> </td>
		<td style='width:5%'><?php echo $result -> ad_convers ;?> </td>
		<td style='width:5%'><?php echo $result -> ad_ConversionRate ;?> </td>
		<td style='width:5%'><?php echo $result ->ad_CostPerConversion ;?> </td>
		<td style='width:5%'><?php echo $sel_res -> ad_QualityScore ;?> </td>
		<td style='width:5%'><?php echo $ad_FirstPageCpc ;?> </td>
		<td style='width:5%'><?php echo $ad_TopOfPageCpc ;?> </td>
		<!--td style='width:5%'><?php echo $result -> ad_ConversionValue ;?> </td-->

   </tr>
<?php } }
echo '<!--Sql '.$sql.' <br/> Sel '.$sel.' -->';

?></tbody>
</table></div>