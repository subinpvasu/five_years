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
$reportDetails = $reports -> getReportDetails("AD LABEL REPORT");

?>
<!-- Table for report details  -->
<table bgcolor ="<?php echo $color_3 ;  ?>" cellpadding=1 cellspacing=1 border=1 width="98%" align="center" style="margin:0px auto;border-collapse:collapse;">
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>

<tr bgcolor ="<?php echo $color_6 ;  ?>"><td  colspan=2  width="20%" ><?php echo ucwords(strtolower($reportDetails[0]->ad_report_type_name)) ; ?></td><td colspan=8>Using labels is the best way to monitor ad copy tests and see what ads are working best. We use these to continually optimise top ads and straplines and display the results in a quick and easy fashion across the entire account.​</td></tr>
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>

<tr bgcolor ="<?php echo $color_1 ;  ?>"  style="color:<?php echo $color_2 ;  ?>;"><td  colspan=2><?php echo REPORT_NOTES_BY_ACCOUNT_MANAGER; ?></td><td colspan=8>&nbsp;</td></tr>
<tr bgcolor ="<?php echo $color_1 ;  ?>"  style="color:<?php echo $color_2 ;  ?>;" ><td colspan=10 >&nbsp;</td></tr>
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>
</table>

<!-- Table for report  -->
<table width="98%"  border="1" bgcolor ="<?php echo $color_3 ;  ?>" cellpadding=1 cellspacing=1 width="98%" align="center" style="margin:10px auto; border-collapse:collapse;">
 <tr bgcolor ="<?php echo $color_4 ;  ?>">
	<td style='width:19%'><?php echo LABEL; ?></td>
	<td style='width:9%'><?php echo CLICKS; ?></td>
	<td style='width:9%'><?php echo IMPRESSIONS; ?></td>
	<td style='width:9%'><?php echo CTR_PERCENTAGE; ?></td>
	<td style='width:9%'><?php echo AVERAGE_CPC; ?></td>
	<td style='widtd:9%'><?php echo COST_EURO; ?></td>
	<td style='width:9%'><?php echo CONVERSIONS; ?></td>
	<td style='width:9%'><?php echo COST_PER_CONVERSION_EURO; ?></td>
	<td style='width:9%'><?php echo COST_PER_CONVERSION_RATE_EURO; ?></td>
	<td style='width:9%'><?php echo CONVERSION_RATE_PERCENTAGE; ?></td>
	</tr>
	<?php

	 
	if($month==date('Y-m')){	
		$results = $main->selectAdLabelReport($id,2,$month);	
	}
	else{
		
		$duplicate = $main->checkDuplicate("ad_AdLabelReport","ad_ALreport_type",3,$month,$id);
		if(!$duplicate){
		
			$cbr = $main->getAdLabelReport($id,3,$month,$startDate,$endDate);
		}
		$results = $main->selectAdLabelReport($id,3,$month);
	}
	
	
	$_SESSION['adlabel_results'] = $results ;
	
	foreach($results as $key => $value){
	
	
	?>
<tr  bgcolor ="<?php echo $color_2 ;  ?>">
	<td style='width:16%; text-align:left;'><?php echo $value->ad_Labels ; ?></td>
	<td style='width:10%'><?php echo $value->ad_clicks ; ?></td>
	<td style='width:10%'><?php echo $value->ad_impressions ; ?> </td>
	<td style='width:7%'><?php echo $value->ad_ctr ; ?></td>
	<td style='width:10%'><?php echo $value->ad_avgCpc ; ?></td>
	<td style='width:7%'><?php echo $value->ad_cost ; ?></td>
	<td style='width:10%'><?php echo $value->ad_convrns ; ?></td>
	<td style='width:10%'><?php echo $value->ad_CostPerConversion ; ?></td>
	<td style='width:10%'><?php echo $value->ad_CstPConvR ; ?></td>
	<td style='width:10%'><?php echo $value->ad_convrate ; ?></td>
</tr>
<?php } ?>
 
 </table>