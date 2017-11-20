<?php
include("header.php");
$type = 'ETC';
?>
<div id="listhead">
  <table width="100%" height="100%" border="0">
    <tr>
	<th style='width:12%'>Campaign Name</th>
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
</tr></table></div>
<div id="listitems">

<table width="100%"  border="0"> 

<?php
	$today = date("Y-m-d");														
   	
	$sql = "SELECT * FROM reports_80_20 WHERE reports_80_20.ad_account_id = '".$id."' AND reports_80_20.added_date = '".$today ."'";
	
	$results = $main->getResults($sql);
	if(!empty($results)) {
	foreach($results as $result){
															
?>                                                                                                                    
    <tr>

		<td style='width:12%; text-align:left;'><?php echo $result -> ad_CampaignName ;?> </td>
		<td style='width:12%; text-align:left;'><?php echo $result -> ad_AdGroupName ;?> </td>
		<td style='width:11%; text-align:left;'><?php echo $result -> ad_KeywordText ;?> </td>
		<td style='width:10%'><?php echo $result -> ad_KeywordMatchType ;?></td>
		<td style='width:5%'><?php echo $result -> ad_Clicks ;?> </td>
		<td style='width:5%'><?php echo $result -> ad_Impressions ;?> </td>
		<td style='width:4%'><?php echo $result -> Ctr ;?> </td>
		<td style='width:6%'><?php echo round($result -> ad_AveragePosition, 2) ;?> </td>
		<td style='width:5%'><?php echo $result -> ad_Cost ;?> </td>
		<td style='width:5%'><?php echo $result -> ad_convers ;?> </td>		
		<td style='width:5%'><?php echo $result -> ad_ConversionRate ;?> </td>		
		<td style='width:5%'><?php echo $result ->ad_CostPerConversion ;?> </td>
		<td style='width:5%'><?php echo $result ->ad_QualityScore ;?> </td>	
		<td style='width:5%'><?php echo $result ->ad_FirstPageCpc ;?> </td>
		<td style='width:5%'><?php echo $result ->ad_TopOfPageCpc ;?> </td>
		<!--td style='width:5%'><?php echo $result -> ad_ConversionValue ;?> </td-->
	
    </tr>
	
<?php 

} }?>
</table></div>