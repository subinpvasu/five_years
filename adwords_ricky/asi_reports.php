<?php
if(!isset($_SESSION['user_name'])){ header("Location:index.php");}
if($type !="ASI" || $id=='' ){

	header("Location:account_details.php");
}

?>

<div id="listhead">
  <table width="100%" height="100%" border="0">
    <tr>
 
	<th style='width:20%'>Campaign Name</th>
	<th style='width:10%'>Search Impr Share</th>
	<th style='width:10%'>Impr</th>
	<th style='width:10%'>Clicks</th>
	<th style='width:10%'>Conv</th>
	<th style='width:10%'>Cost</th>
	<th style='width:10%'>Cost / Conv </th>
	<th style='width:10%'>Conv Rate</th>
	<!--div style='width:10%'>Conversions Value</div-->
	<!--div style='width:10%'>Conv Value / Cost</div-->
	<!--div style='width:10%'>Conv Value / Click</div-->
 
		
	 
</tr>
  </table>
</div>
<div id="listitems">
<table width="100%"  border="0">

<?php
$startDate = date("Y-m-d", strtotime("-30 days"));  
//$startDate = date("Y-m-d",strtotime('first day of this month', strtotime($date)));
$endDate =  date("Y-m-d", strtotime("-1 days"));

/* $startDate = "2014-08-01";
$endDate = "2014-09-01";   */

	
	$sql = "SELECT `ad_CampaignName`,ROUND((SUM(`ad_Impressions`) / SUM(`ad_ExpImpressions`))*100,2) ad_SIS,AVG(ad_SearchImpressionShare) as ad_SIS1,SUM(`ad_Clicks`) ad_Cliks ,SUM(`ad_Impressions`) ad_Imprs, SUM(`ad_Conversions`) ad_Convers , ROUND((SUM(`ad_Cost`)/1000000),2) ad_Cst ,case when SUM(ad_Conversions) <> 0 THEN ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) else 0 end as ad_CPC , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks))*100,2) ad_ConvRate,SUM(ad_ConversionValue) ad_ConvValue ,ROUND((SUM(ad_ConversionValue)/SUM(`ad_Cost`)),2) conpcst ,ROUND((SUM(ad_ConversionValue)/SUM(`ad_Clicks`)),2) conpclk FROM `adword_campaign_reports` WHERE `ad_Date` BETWEEN '$startDate' AND '$endDate' AND `ad_account_id` ='$id' AND  ad_SearchImpressionShare NOT LIKE  '%--%' and ad_SearchImpressionShare NOT LIKE  '%< 10%' group by `ad_CampaignId`  HAVING ad_SIS1 < 80 and ad_SIS1 <> 0 AND ad_Imprs > 10 ORDER BY ad_Imprs DESC ";
	
	
	$results = $main -> getResults($sql);
	
	foreach($results as $key => $value){
	?>
<tr>
	<td style='width:20%; text-align:left;'><?php echo $value ->ad_CampaignName; ?></td>
	<td style='width:10%'><?php echo round($value ->ad_SIS1,2)."%" ; ?></td>
	<td style='width:10%'><?php echo $value ->ad_Imprs; ?></td>
	<td style='width:10%'><?php echo $value ->ad_Cliks; ?></td>
	<td style='width:10%'><?php echo $value ->ad_Convers; ?></td>
	<td style='width:10%'><?php echo $value ->ad_Cst ; ?></td>
	<td style='width:10%'><?php echo $value ->ad_CPC ; ?></td>
	<td style='width:10%'><?php echo $value ->ad_ConvRate."%"; ?></td>
	<!--div style='width:10%'><?php echo $value ->ad_ConvValue; ?></div-->
	<!--div style='width:10%'><?php echo $value ->conpcst; ?></div-->
	<!--div style='width:10%'><?php echo $value ->conpclk; ?></div-->
 	
</tr>
<?php } ?>
</table>
</div>