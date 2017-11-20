<?php
/*

This is file to show DEVICE PERFORMANCE report for customer report
*/

require_once dirname(__FILE__) . '/../../includes/includes.php';
$id = $_REQUEST['id'];
$month = $_REQUEST['month'];
$startDate =  date("Y-m-d",strtotime('first day of this month', strtotime($month)));
if($month==date('Y-m')){ $endDate = date('Y-m-d'); }
else{$endDate = date("Y-m-d",strtotime('last day of this month', strtotime($month)));}

$thismonth = date("M",strtotime($month));
$_SESSION['thismonth'] = $thismonth;

$monthTxt = date("M-Y",strtotime($month));
$_SESSION['monthTxt'] = $monthTxt;
$datestring=$startDate.' first day of last month';
$dt=date_create($datestring);
$last_month = $dt->format('Y-m');
$lastmonth = $dt->format('M');

$_SESSION['lastmonth'] = $lastmonth;
$color_1 = "#434343";
$color_2="#FFF";
$color_3="#DDD";
$color_4="#EAEAEA";
$color_5="#F00";
$color_6="#00FFFF";


// to get detils of the report type DEVICE PERFORMANCE 
$reportDetails = $reports -> getReportDetails("DEVICE PERFORMANCE");

?>
<!-- Table for report details  -->
<table bgcolor ="<?php echo $color_3 ;  ?>" cellpadding=1 cellspacing=1 border=1 width="98%" align="center" style="margin:0px auto;border-collapse:collapse;">
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>

<tr bgcolor ="<?php echo $color_6 ;  ?>"><td  colspan=2  width="20%" ><?php echo ucwords(strtolower($reportDetails[0]->ad_report_type_name)) ; ?> Report</td><td colspan=8>Mobile and Tablet useage is changing everyday. See how clicks, conversions and cost per conversion have changed over the past 30 days compared to 90 days and whole year. Mobile useage could be up to 30% before the year end.</td></tr>
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>

<tr bgcolor ="<?php echo $color_1 ;  ?>"  style="color:<?php echo $color_2 ;  ?>;"><td  colspan=2><?php echo REPORT_NOTES_BY_ACCOUNT_MANAGER; ?></td><td colspan=8>&nbsp;</td></tr>
<tr bgcolor ="<?php echo $color_1 ;  ?>"  style="color:<?php echo $color_2 ;  ?>;" ><td colspan=10 >&nbsp;</td></tr>
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>
</table>

<!-- Table for report  -->
<table width="98%"  border="1" bgcolor ="<?php echo $color_3 ;  ?>" cellpadding=1 cellspacing=1  width="98%" align="center" style="margin:10px auto; border-collapse:collapse;">
 <tr bgcolor ="<?php echo $color_4 ;  ?>">
	<td style='width:19%'><?php echo DEVICE; ?></td>
	<td style='width:9%'><?php echo IMPRESSIONS; ?></td>
	<td style='width:9%'><?php echo CLICKS; ?></td>
	<td style='width:9%'><?php echo CTR_PERCENTAGE; ?></td>
	<td style='width:9%'><?php echo "Cost(".$_SESSION['ad_account_currencyCode'].")"; ?></td>
	<td style='widtd:9%'><?php echo "Cost / Click (".$_SESSION['ad_account_currencyCode'].")"; ?></td>
	<td style='width:9%'><?php echo CONVERSIONS; ?></td>
	<td style='width:9%'><?php echo CONVERSION_RATE_PERCENTAGE; ?></td>
	<td style='width:9%'><?php echo "Cost / Conv (".$_SESSION['ad_account_currencyCode'].")"; ?></td>
	<td style='width:9%'><?php echo AVERAGE_POSITION; ?></td>
	</tr>
 <?php

$sql = "SELECT ad_Device , SUM(ad_Impressions) ad_Impressions ,SUM(ad_Clicks) ad_Clicks , ROUND((SUM(ad_Cost)/1000000),2) ad_Cost , SUM(ad_Conversions) ad_Conversions , ROUND(((SUM(`ad_Cost`)/SUM(`ad_Clicks`))/1000000),2) as ad_CostPerClick ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion  , ROUND(SUM(ad_Clicks)/SUM(ad_Impressions)*100,2) ad_Ctr , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks))*100,2) ad_ConversionRate , ROUND(SUM(ad_Impressions * ad_AveragePosition)/SUM(ad_Impressions),2) as ad_AveragePosition  FROM adword_keyword_report1 WHERE ad_Date BETWEEN '$startDate' and '$endDate' and ad_account_id='$id' AND ad_Device <> '' AND  ad_Device in ('Computers','Mobile devices with full browsers','Other',
'Tablets with full browsers')  GROUP BY ad_Device   ";
 
$results = $main -> getResults($sql);
$_SESSION['device_reports'] = $results ;
foreach($results as $result){
    $total_sales += $result -> ad_Conversions ;
}
$_SESSION['device_total_sales'] = $total_sales ;
foreach($results as $result){

?>


<tr bgcolor="<?php echo $color_2 ;  ?>">
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

} 
$ad_ctr = round(($ad_Clicks/$ad_Impressions)*100,2);
$ad_CostPerClick = round(($ad_Cost/$ad_Clicks),2) ;
$ad_ConversionRate = round(($ad_Conversions/$ad_Clicks)*100,2) ;
$ad_CostPerConversion = round(($ad_Cost/$ad_Conversions),2) ;
$ad_AveragePosition = round($ad_AveragePosition / count($results) ,2);
$_SESSION['device_total']=array($ad_Impressions,$ad_Clicks,$ad_ctr,$ad_Cost,$ad_CostPerClick,$ad_Conversions,$ad_ConversionRate,$ad_CostPerConversion,$ad_AveragePosition);
?>

 
<tr bgcolor="<?php echo $color_2 ;  ?>">
	<td style='width:15%'><b><?php echo TOTAL; ?></b></td>
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

 </table>
 
