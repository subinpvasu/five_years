<?php
/*

This is file to show keyword discovery report for customer report
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


// to get detils of the report type KEYWORD DISCOVERY 
$reportDetails = $reports -> getReportDetails("WASTAGE ANALYSIS");

?>
<!-- Table for report details  -->
<table bgcolor ="<?php echo $color_3 ;  ?>" cellpadding=1 cellspacing=1 border=1 width="98%" align="center" style="margin:0px auto;border-collapse:collapse;">
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>

<tr bgcolor ="<?php echo $color_6 ;  ?>"><td  colspan=2  width="20%" ><?php echo ucwords(strtolower($reportDetails[0]->ad_report_type_name)) ; ?></td><td colspan=8>The column called query is the actual keyword and this is not in the account as a keywords or negative. By eliminating those consistently coming through and not leading to conversions or assisted conversions we can drive down the CPA and focus budget on whats working</td></tr>
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>

<tr bgcolor ="<?php echo $color_1 ;  ?>"  style="color:<?php echo $color_2 ;  ?>;"><td  colspan=2><?php echo REPORT_NOTES_BY_ACCOUNT_MANAGER; ?></td><td colspan=8>&nbsp;</td></tr>
<tr bgcolor ="<?php echo $color_1 ;  ?>"  style="color:<?php echo $color_2 ;  ?>;" ><td colspan=10 >&nbsp;</td></tr>
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>
</table>

<!-- Table for report  -->

 <table width="98%"  border="1" bgcolor ="<?php echo $color_3 ;  ?>" cellpadding=1 cellspacing=1 width="98%" align="center" style="margin:10px auto;  border-collapse:collapse;">
 <tr bgcolor ="<?php echo $color_4 ;  ?>">
	<td style='width:19%'><?php echo SEARCH_QUERY; ?></td>
	<td style='width:18%'><?php echo CAMPAIGN_NAME; ?></td>
	<td style='width:18%'><?php echo KEYWORD_TEXT; ?></td>
	<td style='width:10%'><?php echo MATCH_TYPE; ?></td>
	<td style='width:5%'><?php echo CLICKS; ?></td>
	<td style='widtd:5%'><?php echo CONVERSIONS; ?></td>
	<td style='width:5%'><?php echo "Cost (".$_SESSION['ad_account_currencyCode'].")"; ?></td>
	<td style='width:5%'><?php echo "Cost / Conv (".$_SESSION['ad_account_currencyCode'].")"; ?></td>
	<td style='width:5%'><?php echo IMPRESSIONS; ?></td>	
	<td style='width:10%'><?php echo AVERAGE_POSITION; ?></td>	
	</tr>
<?php
	
 
	if($month==date('Y-m')){	
		$results = $main->selectWastageAnalysis($id,2,'',$month);	
	}
	else{
		
		$duplicate = $main->checkDuplicate("adword_WastageAnalysis","ad_WAReport_type",3,$month,$id);
		if(!$duplicate){
		
			$cbr = $main->getWastageAnalysisReport($id,3,$month,$startDate,$endDate);
		}
		$results = $main->selectWastageAnalysis($id,3,'',$month);
		//echo "<pre>";
		//print_r($results);
	}
	$_SESSION['wastage_analysis'] = $results ; 
	foreach($results as $key => $value){
	?>
<tr bgcolor ="<?php echo $color_2 ;  ?>">
	<td style='width:15%; text-align:left;'><?php echo $value->ad_Query ; ?></td>
	<td style='width:15%; text-align:left;'><?php echo $value->ad_CampaignName ; ?></td>
	<td style='width:15%; text-align:left;'><?php echo $value->ad_KeywordTextMatchingQuery ; ?></td>
	<td style='width:15%'><?php echo $value->ad_MatchType ; ?></td>
	<td style='width:5%'><?php echo $value->ad_Clicks ; ?></td>
	<td style='width:5%'><?php echo $value->ad_Conversions ; ?></td>
	<td style='width:5%'><?php echo $value->ad_Cost /1000000 ; ?></td>
	<td style='width:5%'><?php echo $value->ad_CostPerConversion  /1000000; ?></td>
	<td style='width:5%'><?php echo $value->ad_Impressions ; ?></td>	
	<td style='width:5%'><?php echo round($value->ad_AveragePosition,2) ; ?></td>	

</tr>
<?php } ?>
 
 </table>
 