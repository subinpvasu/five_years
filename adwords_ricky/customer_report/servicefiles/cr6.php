<?php
/*

This is file to show keyword discovery report for customer report
*/

require_once dirname(__FILE__) . '/../../includes/includes.php';
$id = $_SESSION['account_id'];
$startDate = $_SESSION['startDate'] ;
$endDate = $_SESSION['endDate'] ;
?>

 <table  width='100%' border=0 >
 <tr  class='table_head'>
	<td style='width:20%'><?php echo SEARCH_QUERY; ?></td>
	<td style='width:15%'><?php echo CAMPAIGN_NAME; ?></td>
	<td style='width:15%'><?php echo KEYWORD_TEXT; ?></td>
	<td style='width:10%'><?php echo MATCH_TYPE; ?></td>
	<td style='width:15%'><?php echo DEVICE; ?></td>
	<td style='width:5%'><?php echo CLICKS; ?></td>
	<td style='width:5%'><?php echo CONVERSIONS; ?></td>
	<td style='width:5%'><?php echo COST_EURO; ?></td>
	<td style='width:5%'><?php echo COST_PER_CONVERSION_EURO; ?></td>
	<td style='width:5%'><?php echo IMPRESSIONS; ?></td>	
	</tr>
 
<?php
	$results = $main -> getResults("SELECT NULL, `ad_Query`,`ad_MatchType`,`ad_KeywordTextMatchingQuery`,`ad_CampaignId`,`ad_CampaignName`,`ad_AdGroupName`,SUM(`ad_Clicks`) ad_Clicks ,SUM(`ad_Impressions`) ad_Impressions, SUM(`ad_Conversions`) ad_Conversions , SUM(`ad_Cost`) ad_Cost ,SUM(`ad_Cost`)/ SUM(`ad_Conversions`)  as ad_CostPerConversion ,ad_Device   FROM `adword_search_query_reports` WHERE `ad_Date` BETWEEN '".$startDate."' AND '".$endDate."' AND `ad_account_id` ='".$id."' AND ad_Query <>ad_KeywordTextMatchingQuery GROUP BY `ad_Query`,`ad_Device`,`ad_CampaignName`,`ad_AdGroupName` HAVING `ad_Conversions` >0 ORDER BY  ad_Conversions DESC ,`ad_CampaignName` DESC ,ad_Device ASC  LIMIT 25");
	
	if(count($results) >0 ){
	foreach($results as $key => $value){
	?>
<tr <?php if($key%2 >0) echo "class ='odd_trs' ";  ?> >
	<td style='width:20%; text-align:left;'><?php echo $value->ad_Query ; ?></td>
	<td style='width:15%; text-align:left;'><?php echo $value->ad_CampaignName ; ?></td>
	<td style='width:15%; text-align:left;'><?php echo $value->ad_KeywordTextMatchingQuery ; ?></td>
	<td style='width:10%'><?php echo $value->ad_MatchType ; ?></td>
	<td style='width:15%'><?php echo $value->ad_Device ; ?></td>
	<td style='width:5%'><?php echo $value->ad_Clicks ; ?></td>
	<td style='width:5%'><?php echo $value->ad_Conversions ; ?></td>
	<td style='width:5%'><?php echo round($value->ad_Cost /1000000,2) ; ?></td>
	<td style='width:5%'><?php echo round($value->ad_CostPerConversion  /1000000,2); ?></td>
	<td style='width:5%'><?php echo $value->ad_Impressions ; ?></td>	
</tr>
<?php } } else {?>

    <tr><td colspan='10'  align="center"> No Results Found</td></tr>
<?php }?>
</table>

