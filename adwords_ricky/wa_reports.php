<?php
if(!isset($_SESSION['user_name'])){ header("Location:index.php");}
if($type !="WA" || $id=='' ){

	header("Location:account_details.php");
}

?>
<div id="listhead">
  <table width="100%" height="100%" border="0">
    <tr>
	<th style='width:15%'>Query</th>
	<th style='width:15%'>Campaign Name</th>
	<th style='width:15%'>Keyword Text</th>
	<th style='width:15%'>Match Type</th>
	<th style='width:5%'>Clicks</th>
	<th style='width:5%'>Conv</th>
	<th style='width:5%'>Cost</th>
	<th style='width:5%'>Cost/ Conv</th>
	<th style='width:5%'>Impr</th>	
	<th style='width:5%'>Avg Position</th>	
	<!--th style='width:10%'>Conversion Value</th-->	
	</tr>
	</table> 
</div>
<div id="listitems">
<table width="100%"  border="0"> 
<?php
$startDate = date("Y-m-d", strtotime("-1 months"));  
//$startDate = date("Y-m-d",strtotime('first day of this month', strtotime($date)));
$endDate = date("Y-m-d");

 
	
	$sql = "SELECT `ad_Query`,`ad_MatchType`,`ad_KeywordTextMatchingQuery`,`ad_CampaignName`,`ad_AdGroupName`,SUM(`ad_Clicks`) ad_Clicks ,SUM(`ad_Impressions`) ad_Impressions, SUM(`ad_Conversions`) ad_Conversions , SUM(`ad_Cost`) ad_Cost ,SUM(`ad_Cost`)/ SUM(`ad_Conversions`)  as ad_CostPerConversion ,SUM(`ad_ConversionValue`) ad_ConversionValue,`ad_AveragePosition` FROM `adword_search_query_reports` WHERE `ad_Date` BETWEEN '$startDate' AND '$endDate' AND `ad_account_id` ='$id' AND ad_Query <>ad_KeywordTextMatchingQuery GROUP BY `ad_Query`,`ad_CampaignName`,`ad_AdGroupName` HAVING `ad_Clicks` >0 and ad_Conversions=0 ORDER BY  ad_Clicks DESC ,`ad_CampaignName` DESC LIMIT 100";
	
	
	$results = $main->getResults($sql);

	
	foreach($results as $key => $value){
	?>
<tr>
	<td style='width:15%; text-align:left;'><?php echo $value->ad_Query ; ?></td>
	<td style='width:15%; text-align:left;'><?php echo $value->ad_CampaignName ; ?></td>
	<td style='width:15%; text-align:left;'><?php echo $value->ad_KeywordTextMatchingQuery ; ?></td>
	<td style='width:15%'><?php echo $value->ad_MatchType ; ?></td>
	<td style='width:5%'><?php echo $value->ad_Clicks ; ?></td>
	<td style='width:5%'><?php echo $value->ad_Conversions ; ?></td>
	<td style='width:5%'><?php echo $value->ad_Cost /1000000 ; ?></td>
	<td style='width:5%'><?php echo $value->ad_CostPerConversion  /1000000; ?></td>
	<td style='width:5%'><?php echo $value->ad_Impressions ; ?></td>	
	<td style='width:5%'><?php echo $value->ad_AveragePosition ; ?></td>	
	<!--td style='width:5%'><?php echo $value->ad_ConversionValue ; ?></td-->	
</tr>
<?php } ?>
</table>
</div>