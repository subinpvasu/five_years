<?php
/*

This is file to show DEVICE PERFORMANCE report for customer report
*/

require_once dirname(__FILE__) . '/../../includes/includes.php';
$id = $_SESSION['account_id'];
$startDate = $_SESSION['startDate'] ;
$endDate = $_SESSION['endDate'] ;

?>

<!-- Table for report  -->
 <table  width='100%' border=0 >
 <tr  class='table_head'>
	<td style='width:19%'><?php echo DEVICE; ?></td>
	<td style='width:9%'><?php echo IMPRESSIONS; ?></td>
	<td style='width:9%'><?php echo CLICKS; ?></td>
	<td style='width:9%'><?php echo CTR_PERCENTAGE; ?></td>
	<td style='width:9%'><?php echo COST_EURO; ?></td>
	<td style='widtd:9%'><?php echo COST_PER_CLICKS_EURO; ?></td>
	<td style='width:9%'><?php echo CONVERSIONS; ?></td>
	<td style='width:9%'><?php echo CONVERSION_RATE_PERCENTAGE; ?></td>
	<td style='width:9%'><?php echo COST_PER_CONVERSION_EURO; ?></td>
	<td style='width:9%'><?php echo AVERAGE_POSITION; ?></td>
	</tr>
 <?php

$sql = "SELECT ad_Device , SUM(ad_Impressions) ad_Impressions ,SUM(ad_Clicks) ad_Clicks , ROUND((SUM(ad_Cost)/1000000),2) ad_Cost , SUM(ad_Conversions) ad_Conversions , ROUND(((SUM(`ad_Cost`)/SUM(`ad_Clicks`))/1000000),2) as ad_CostPerClick ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion  , ROUND(SUM(ad_Clicks)/SUM(ad_Impressions)*100,2) ad_Ctr , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks))*100,2) ad_ConversionRate , ROUND(SUM(ad_Impressions * ad_AveragePosition)/SUM(ad_Impressions),2) as ad_AveragePosition  FROM adword_keyword_report1 WHERE ad_Date BETWEEN '$startDate' and '$endDate' and ad_account_id='$id' AND ad_Device <> '' AND  ad_Device in ('Computers','Mobile devices with full browsers','Other',
'Tablets with full browsers')  GROUP BY ad_Device   ";
//echo $sql ;
$results = $main -> getResults($sql);

foreach($results as $result){
    $total_sales += $result -> ad_Conversions ;
}
if(count($results)>0 ){
foreach($results as $key => $result){

?>

<tr <?php if($key%2 >0) echo "class ='odd_trs' ";  ?> >
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

 
<tr  <?php if($key%2 == 0) echo "class ='odd_trs' ";  ?>>
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
<?php } else { ?>

<tr><td colspan='10'  align="center"> No Results Found</td></tr>
<?php } ?>
 </table>
 
