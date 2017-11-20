<?php
if(!isset($_SESSION['user_name'])){ header("Location:index.php");}
if($type !="ALR" || $id=='' ){

	header("Location:account_details.php");
}

?>


<div id="selectDevicex" style="width:100%;font-weight: bold;height:auto; overflow:hidden; margin-bottom:5px;" >
<table width="100%" height="100%" border="0">
<tr><td align='right' width="20%"> <span class="txtcolor2"> Select </span> Report : &nbsp;</td>
<td><div class="selection_ext" style="margin-top: 0px;"><select id="alr_type" onchange="getAdLabelReport();">

<option value='1'>Ad Label Report</option>
<option value='2'>Existing Ad Label Report</option>

</select></div></td></tr>
</table>

</div>
<div id="listhead">
  <table width="100%" height="100%" border="0">
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
	
	 
</tr></table>
</div>
<div id="listitems">
<table width="100%"  border="0"> 
<?php

$startDate = date("Y-m-d", strtotime("-30 days"));  
$endDate = date("Y-m-d");

/* $sql  = "SELECT report.ad_Labels, ad_AdGroupId , ad_AdType ,`ad_Headline`,`ad_Description1`, `ad_Description2`,`ad_DisplayUrl`, SUM(ad_Clicks) clicks , SUM(ad_Impressions) impressions ,  ROUND(((SUM(ad_Clicks)/SUM(ad_Impressions)) * 100),2) ctr ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Clicks`))/1000000),2) as ad_avgCpc ,SUM(ad_Conversions) convrns  , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2) convrate ,ROUND(((SUM(`ad_Cost`)/ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2))/1000000),2) as ad_CstPConvR, ROUND((SUM(ad_Cost)/1000000),2) cost FROM `adword_ad_reports` report INNER JOIN (SELECT t1.`ad_Id` FROM `adword_ad_reports` t1 WHERE t1.`ad_report_id` IN (SELECT MAX(`ad_report_id`) FROM `adword_ad_reports` t2 WHERE t2.`ad_account_id` ='$id' GROUP BY `ad_Id` ) AND t1.`ad_Status`='enabled') t3 on report.`ad_Id` = t3.`ad_Id` WHERE report.`ad_Date` BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND (ad_Labels <>'' AND ad_Labels NOT LIKE '%--%') AND `ad_account_id` ='$id' GROUP BY report.ad_Labels having clicks > 0 ;" ; */

$sql ="SELECT report.ad_Labels, ad_AdGroupId , ad_AdType ,`ad_Headline`,`ad_Description1`, `ad_Description2`,`ad_DisplayUrl`, SUM(ad_Clicks) clicks , SUM(ad_Impressions) impressions ,  ROUND(((SUM(ad_Clicks)/SUM(ad_Impressions)) * 100),2) ctr ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Clicks`))/1000000),2) as ad_avgCpc ,SUM(ad_Conversions) convrns  , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2) convrate ,ROUND(((SUM(`ad_Cost`)/ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2))/1000000),2) as ad_CstPConvR, ROUND((SUM(ad_Cost)/1000000),2) cost FROM `adword_ad_reports` report inner join adword_ads ads on ads.ad_ads_adword_id = report.ad_Id and ads.ad_account_id = report.ad_account_id   WHERE report.`ad_Date` BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND (ad_Labels <>'' AND ad_Labels NOT LIKE '%--%')  AND report.`ad_account_id` ='$id' GROUP BY report.ad_Labels having clicks > 0  ORDER BY clicks desc; ";


	$results = $main -> getResults($sql);
        
        $_SESSION['alr_result'] = $results;
	
	foreach($results as $key => $value){
	
	if($value->ad_CostPerConversion) $cpc = $value->ad_CostPerConversion ; else $cpc =0 ;
	if($value->ad_CstPConvR) $cpcr = $value->ad_CstPConvR ; else $cpcr =0 ;
	
	?>
<tr>
	<td style='width:16%;' align=left><?php echo $value->ad_Labels ; ?></td>
	<td style='width:10%'><?php echo $value->clicks ; ?></td>
	<td style='width:10%'><?php echo $value->impressions ; ?> </td>
	<td style='width:7%'><?php echo $value->ctr ; ?></td>
	<td style='width:10%'><?php echo $value->ad_avgCpc ; ?></td>
	<td style='width:7%'><?php echo $value->cost ; ?></td>
	<td style='width:10%'><?php echo $value->convrns ; ?></td>
	<td style='width:10%'><?php echo $cpc ; ?></td>
	<td style='width:10%'><?php echo $cpcr ; ?></td>
	<td style='width:10%'><?php echo $value->convrate ; ?></td>
</tr>
<?php } ?></table>
</div>
