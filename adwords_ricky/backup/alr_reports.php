<?php
if(!isset($_SESSION['user_name'])){ header("Location:index.php");}
if($type !="ALR" || $id=='' ){

	header("Location:account_details.php");
}

?>

<div id="listhead">
  <table width="100%" height="100%" border="0" class="tablesorter">
  <thead>
    <tr>	 
	<th style='width:16%'>Label</th>
	<th style='width:10%'>Clicks</th>
	<th style='width:10%'>Impr. </th>
	<th style='width:7%'>CTR (%)</th>
	<th style='width:10%'>Avg CPC</th>
	<th style='width:7%'>Cost</th>
	<th style='width:10%'>Conv</th>
	<th style='width:10%'>Cost / Conv</th>
	<th style='width:10%'>Cost / Conv Rate</th>
	<th style='width:10%'>Conv Rate(%)</th>
	
	 
</tr></thead> <tbody>
<?php

$startDate = date("Y-m-d", strtotime("-30 days"));  
$endDate = date("Y-m-d");

$sql  = "SELECT max(ad_report_id) id ,ad_Labels, ad_AdGroupId , ad_AdType ,`ad_Headline`,`ad_Description1`, `ad_Description2`,`ad_DisplayUrl`, SUM(ad_Clicks) clicks , SUM(ad_Impressions) impressions ,  ROUND(((SUM(ad_Clicks)/SUM(ad_Impressions)) * 100),2) ctr ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Clicks`))/1000000),2) as ad_avgCpc ,SUM(ad_Conversions) convrns  , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2) convrate ,ROUND(((SUM(`ad_Cost`)/ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2))/1000000),2) as ad_CstPConvR, ROUND((SUM(ad_Cost)/1000000),2) cost FROM `adword_ad_reports` A WHERE ad_account_id ='$id' AND `ad_Date` BETWEEN '$startDate' AND '$endDate' AND (ad_Labels <>'' AND ad_Labels NOT LIKE '%--%') AND ad_Status='ENABLED' GROUP BY ad_Labels having clicks > 0 ; " ;

	$results = $main -> getResults($sql);
	
	foreach($results as $key => $value){
	
	
	?>
<tr>
	<td style='width:16%; text-align:left;'><?php echo $value->ad_Labels ; ?></td>
	<td style='width:10%'><?php echo $value->clicks ; ?></td>
	<td style='width:10%'><?php echo $value->impressions ; ?> </td>
	<td style='width:7%'><?php echo $value->ctr ; ?></td>
	<td style='width:10%'><?php echo $value->ad_avgCpc ; ?></td>
	<td style='width:7%'><?php echo $value->cost ; ?></td>
	<td style='width:10%'><?php echo $value->convrns ; ?></td>
	<td style='width:10%'><?php echo $value->ad_CostPerConversion ; ?></td>
	<td style='width:10%'><?php echo $value->ad_CstPConvR ; ?></td>
	<td style='width:10%'><?php echo $value->convrate ; ?></td>
</tr>
<?php } ?></tbody></table>
</div>
