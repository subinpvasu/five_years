<?php
if(!isset($_SESSION['user_name'])){ header("Location:index.php");}
if($type !="DEVICE" || $id=='' ){

	header("Location:account_details.php");
}


?>
<?php $ad_Impressions=$ad_Clicks=$ad_Ctr=$ad_Cost=$ad_Conversions =0 ; ?>

<div id="listhead">
  <table width="100%" height="100%" border="0">
    <tr>

	<th style='width:15%'>Device</th>
	<th style='width:10%'>Impr</th>
	<th style='width:10%'>Clicks</th>
	<th style='width:10%'>CTR</th>
	<th style='width:10%'>Cost</th>
	<th style='width:10%'>Cost / Click</th>
	<th style='width:10%'>Conv</th>
	<th style='width:10%'>Conv Rate</th>
	<th style='width:10%'>Cost/ Conv</th>		
	<th style='width:5%'>Avg Position</th>		
	 
</tr></table>
</div>
<div id="listitems">
<table width="100%"  border="0"> 

<tr>
	<td colspan="10">LAST 30 DAYS</td>		
	 
</tr> 
<?php


$date = date("Y-m-d", strtotime("-1 months"));  
$startDate = date("Y-m-d",strtotime('first day of this month', strtotime($date)));
$endDate = date("Y-m-d");

$sql = "SELECT ad_Device , SUM(ad_Impressions) ad_Impressions ,SUM(ad_Clicks) ad_Clicks , ROUND((SUM(ad_Cost)/1000000),2) ad_Cost , SUM(ad_Conversions) ad_Conversions , ROUND(((SUM(`ad_Cost`)/SUM(`ad_Clicks`))/1000000),2) as ad_CostPerClick ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion  , ROUND(SUM(ad_Clicks)/SUM(ad_Impressions)*100,2) ad_Ctr , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks))*100,2) ad_ConversionRate , ROUND(SUM(ad_Impressions * ad_AveragePosition)/SUM(ad_Impressions),2) as ad_AveragePosition  FROM adword_keyword_report1 WHERE ad_Date BETWEEN '$startDate' and '$endDate' and ad_account_id='$id' AND ad_Device <> '' AND  ad_Device in ('Computers','Mobile devices with full browsers','Other',
'Tablets with full browsers')  GROUP BY ad_Device   ";
//echo $sql ;
$results = $main -> getResults($sql);

foreach($results as $result){
    $total_sales += $result -> ad_Conversions ;
}

foreach($results as $result){

?>


<tr>
	<td style='width:15%; text-align:left;'><?php echo  $result -> ad_Device; ?></td>
	<td style='width:10%'><?php echo  $result -> ad_Impressions; ?></td>
	<td style='width:10%'><?php echo  $result -> ad_Clicks; ?></td>
	<td style='width:10%'><?php echo  $result -> ad_Ctr; ?></td>
	<td style='width:10%'><?php echo  $result -> ad_Cost; ?></td>
	<td style='width:10%'><?php echo  $result -> ad_CostPerClick; ?></td>
	<td style='width:10%'><?php echo  $result -> ad_Conversions; echo " ("; echo ROUND(($result -> ad_Conversions / $total_sales)*100,2); echo "%) "; ?></td>
	<td style='width:10%'><?php echo  $result -> ad_ConversionRate; ?></td>
	<td style='width:10%'><?php echo  $result -> ad_CostPerConversion; ?></td>		
	<td style='width:5%'><?php echo  $result -> ad_AveragePosition ; ?></td>		
	 
</tr> 

	

<?php 
$ad_Impressions += $result -> ad_Impressions ;
$ad_Clicks += $result -> ad_Clicks ;
$ad_Ctr += $result -> ad_Ctr ;
$ad_Cost += $result -> ad_Cost ;
$ad_Conversions += $result -> ad_Conversions ;
$ad_AveragePosition += $result -> ad_AveragePosition ;

} ?>

 
<tr>
	<td style='width:15%'><b>Total</b></td>
	<td style='width:10%'><?php echo  $ad_Impressions; ?></td>
	<td style='width:10%'><?php echo  $ad_Clicks; ?></td>
	<td style='width:10%'><?php echo  round(($ad_Clicks/$ad_Impressions)*100,2); ?></td>
	<td style='width:10%'><?php echo  $ad_Cost; ?></td>
	<td style='width:10%'><?php echo  round(($ad_Cost/$ad_Clicks),2) ; ?></td>
	<td style='width:10%'><?php echo  $ad_Conversions;  ?></td>
	<td style='width:10%'><?php echo  round(($ad_Conversions/$ad_Clicks)*100,2) ; ?></td>
	<td style='width:10%'><?php echo  round(($ad_Cost/$ad_Conversions),2) ; ?></td>		
	<td style='width:5%'><?php echo  round($ad_AveragePosition / count($results) ,2); ?></td>		
	 
</tr>

<?php $ad_Impressions=$ad_Clicks=$ad_Ctr=$ad_Cost=$ad_Conversions = $total_sales = $ad_AveragePosition =0 ; ?>

<tr>
	<td  colspan="10">LAST 90 DAYS</td>		
	 
</tr> 
<?php


$date = date("Y-m-d", strtotime("-3 months"));  
$startDate = date("Y-m-d",strtotime('first day of this month', strtotime($date)));
$endDate = date("Y-m-d");

$sql = "SELECT ad_Device , SUM(ad_Impressions) ad_Impressions ,SUM(ad_Clicks) ad_Clicks , ROUND((SUM(ad_Cost)/1000000),2) ad_Cost , SUM(ad_Conversions) ad_Conversions , ROUND(((SUM(`ad_Cost`)/SUM(`ad_Clicks`))/1000000),2) as ad_CostPerClick ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion  , ROUND(SUM(ad_Clicks)/SUM(ad_Impressions)*100,2) ad_Ctr , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks))*100,2) ad_ConversionRate , ROUND(SUM(ad_Impressions * ad_AveragePosition)/SUM(ad_Impressions),2) as ad_AveragePosition  FROM adword_keyword_report1 WHERE ad_Date BETWEEN '$startDate' and '$endDate' and ad_account_id='$id' AND ad_Device <> '' AND  ad_Device in ('Computers','Mobile devices with full browsers','Other',
'Tablets with full browsers')  GROUP BY ad_Device   ";
//echo $sql ;
$results = $main -> getResults($sql);
 
foreach($results as $result){
    $total_sales += $result -> ad_Conversions ;
}

foreach($results as $result){

?>

<tr>
	<td style='width:15%; text-align:left;'><?php echo  $result -> ad_Device; ?></td>
	<td style='width:10%'><?php echo  $result -> ad_Impressions; ?></td>
	<td style='width:10%'><?php echo  $result -> ad_Clicks; ?></td>
	<td style='width:10%'><?php echo  $result -> ad_Ctr; ?></td>
	<td style='width:10%'><?php echo  $result -> ad_Cost; ?></td>
	<td style='width:10%'><?php echo  $result -> ad_CostPerClick; ?></td>
	<td style='width:10%'><?php echo  $result -> ad_Conversions; echo " ("; echo ROUND(($result -> ad_Conversions / $total_sales)*100,2); echo " %) ";?></td>
	<td style='width:10%'><?php echo  $result -> ad_ConversionRate; ?></td>
	<td style='width:10%'><?php echo  $result -> ad_CostPerConversion; ?></td>		
	<td style='width:5%'><?php echo  $result -> ad_AveragePosition; ?></td>		
	 
</tr> 
<?php 
$ad_Impressions += $result -> ad_Impressions ;
$ad_Clicks += $result -> ad_Clicks ;
$ad_Ctr += $result -> ad_Ctr ;
$ad_Cost += $result -> ad_Cost ;
$ad_Conversions += $result -> ad_Conversions ;
$ad_AveragePosition += $result -> ad_AveragePosition ;
} ?>

 
<tr>
	<td style='width:15%'><b>Total</b></td>
	<td style='width:10%'><?php echo  $ad_Impressions; ?></td>
	<td style='width:10%'><?php echo  $ad_Clicks; ?></td>
	<td style='width:10%'><?php echo  round(($ad_Clicks/$ad_Impressions)*100,2); ?></td>
	<td style='width:10%'><?php echo  $ad_Cost; ?></td>
	<td style='width:10%'><?php echo  round(($ad_Cost/$ad_Clicks),2) ; ?></td>
	<td style='width:10%'><?php echo  $ad_Conversions; ?></td>
	<td style='width:10%'><?php echo  round(($ad_Conversions/$ad_Clicks)*100,2) ; ?></td>
	<td style='width:10%'><?php echo  round(($ad_Cost/$ad_Conversions),2) ; ?></td>
	<td style='width:5%'><?php echo  round($ad_AveragePosition / count($results) ,2); ?></td>		

	 
</tr>
</table></div>
<div style="width:100%; " >&nbsp;</div>
<div style="width:100%; margin:10px;">
<table><tr>
<td >
		<h2>Conversions for each Device (30 Days)</h2>
		<img width="400" height="350" src="graph_30days_devicereport.php" />
	</td>
	
<td >
		<h2>Conversions for each Device (90 Days)</h2>
		<img width="400" height="350" src="graph_90days_devicereport.php" />
	</td>
</tr></table>
</div>
 