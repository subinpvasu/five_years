<?php
if(!isset($_SESSION['user_name'])){ header("Location:index.php");}
if($type !="KD" || $id=='' ){

	header("Location:account_details.php");
}

?>
<div id="selectDevicex" style="width:100%;font-weight: bold;height:auto; overflow:hidden; margin-bottom:5px;" >
<table width="100%" height="100%" border="0">
<tr><td align='right' width="20%"> <span class="txtcolor2">Select</span> Device Type : &nbsp;</td>
<td><div class="selection_ext" style="margin-top: 0px;"><select id="devices" onchange="getDeviceReport();">
<option value="Select">---Select---</option>
<option value='Computers'>Computers</option>
<option value='Tablets with full browsers'>Tablets with full browsers</option>
<option value='Mobile devices with full browsers'>Mobile devices with full browsers</option>
</select></div></td></tr>
</table>

</div>



<div id="listhead">
  <table width="100%" height="100%" border="0">
    <tr>
	<th style='width:20%'>Query</th>
	<th style='width:15%'>Campaign Name</th>
	<th style='width:15%'>Keyword Text</th>
	<th style='width:5%'>Match Type</th>
	<th style='width:10%'>Device</th>
	<th style='width:5%'>Clicks</th>
	<th style='width:5%'>Conv</th>
	<th style='width:5%'>Cost</th>
	<th style='width:5%'>Cost/ Conv</th>
	<th style='width:5%'>Impr</th>	
	 </tr></table>
</div>
<div id="listitems">
<table width="100%"  border="0"> 

<?php
$startDate = date("Y-m-d", strtotime("-1 months"));  
$endDate = date("Y-m-d");

	
	$sql = "SELECT `ad_Query`,`ad_MatchType`,`ad_KeywordTextMatchingQuery`,`ad_CampaignName`,`ad_AdGroupName`,SUM(`ad_Clicks`) ad_Clicks ,SUM(`ad_Impressions`) ad_Impressions, SUM(`ad_Conversions`) ad_Conversions , SUM(`ad_Cost`) ad_Cost ,SUM(`ad_Cost`)/ SUM(`ad_Conversions`)  as ad_CostPerConversion ,ad_Device FROM `adword_search_query_reports` WHERE `ad_Date` BETWEEN '$startDate' AND '$endDate' AND `ad_account_id` ='$id' AND ad_Query <>ad_KeywordTextMatchingQuery GROUP BY `ad_Query`,`ad_Device`,`ad_CampaignName`,`ad_AdGroupName` HAVING `ad_Conversions` >0 ORDER BY  ad_Conversions DESC ,`ad_CampaignName` DESC ,ad_Device ASC  LIMIT 100";
	
	//echo $sql ;
	
	$results = $main -> getResults($sql);
	
	$_SESSION['deviceResults'] = $results ;
	
	foreach($results as $key => $value){
	?>
<tr>
	<td style='width:20%; text-align:left;'><?php echo $value->ad_Query ; ?></td>
	<td style='width:15%; text-align:left;'><?php echo $value->ad_CampaignName ; ?></td>
	<td style='width:15%; text-align:left;'><?php echo $value->ad_KeywordTextMatchingQuery ; ?></td>
	<td style='width:5%'><?php echo $value->ad_MatchType ; ?></td>
	<td style='width:10%'><?php echo $value->ad_Device ; ?></td>
	<td style='width:5%'><?php echo $value->ad_Clicks ; ?></td>
	<td style='width:5%'><?php echo $value->ad_Conversions ; ?></td>
	<td style='width:5%'><?php echo round($value->ad_Cost /1000000,2) ; ?></td>
	<td style='width:5%'><?php echo round($value->ad_CostPerConversion  /1000000,2); ?></td>
	<td style='width:5%'><?php echo $value->ad_Impressions ; ?></td>	
</tr>
<?php } ?>
</table>
</div>
