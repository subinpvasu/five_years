<?php
/*

This is file to show daily hourly report for customer report
*/
// to get detils of the report type DAILY & HOURLY REPORT 
$reportDetails = $reports -> getReportDetails("CONVERSION BOOSTER REPORTS");

?>
<!-- Table for report details  -->
<table bgcolor ="<?php echo $color_3 ;  ?>" cellpadding=1 cellspacing=1 border=1 width="98%" align="center" style="margin:0px auto;border-collapse:collapse;">
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>

<tr bgcolor ="<?php echo $color_6 ;  ?>"><td  colspan=2  width="20%" ><?php echo ucwords(strtolower($reportDetails[0]->ad_report_type_name)) ; ?></td><td colspan=8><?php echo $reportDetails[0]->ad_report_type_left ; ?></td></tr>
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>

<tr bgcolor ="<?php echo $color_1 ;  ?>"  style="color:<?php echo $color_2 ;  ?>;"><td  colspan=2><?php echo REPORT_NOTES_BY_ACCOUNT_MANAGER; ?></td><td colspan=8>&nbsp;</td></tr>
<tr bgcolor ="<?php echo $color_1 ;  ?>"  style="color:<?php echo $color_2 ;  ?>;" ><td colspan=10 >&nbsp;</td></tr>
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>
</table>

<!-- Table for report  -->


<table width="98%"  border="1" bgcolor ="<?php echo $color_3 ;  ?>" cellpadding=1 cellspacing=1 width="98%" align="center" style="margin:10px auto; border-collapse:collapse; ">
    <tr bgcolor ="<?php echo $color_4 ;  ?>">
	<td style='width:12%;color:<?php echo $color_5 ;  ?>;' ><?php echo CAMPAIGN_NAME; ?> Name</td>
	<td style='width:12%;color:<?php echo $color_5 ;  ?>;' ><?php echo ADGROUP_NAME; ?> Name</td>
	<td style='width:11%'><?php echo KEYWORD_TEXT; ?></td>
	<td style='width:10%;color:<?php echo $color_5 ;  ?>;'  ><?php echo MATCH_TYPE; ?></td>
	<td style='width:5%;color:<?php echo $color_5 ;  ?>;'  ><?php echo STATUS; ?></td>
	<td style='width:5%'><?php echo QUALITY_SCORE; ?></td>
	<td style='width:5%'><?php echo CLICKS; ?></td>
	<td style='width:5%'><?php echo IMPRESSIONS; ?></td>
	
	<td style='width:5%'>Cost (<?php echo $_SESSION['ad_account_currencyCode']; ?>)</td>		
	<td style='width:5%'><?php echo CONVERSIONS; ?></td>
	<td style='width:5%'><?php echo CONVERSION_RATE_PERCENTAGE; ?></td>
	<td style='width:5%'>Cost / Conv(<?php echo $_SESSION['ad_account_currencyCode']; ?>)</td>
	<td style='width:4%'><?php echo CTR_PERCENTAGE; ?></td>
	<td style='width:6%'><?php echo AVERAGE_POSITION; ?></td>
	<td style='width:5%'><?php echo TOP_PAGE_OF_CPC; ?></td>
	

</tr>

<?php
    	
	if($month==date('Y-m')){	
		$results = $main->selectConversionBoosterReports($id,2);	
	}
	else{
		
		$duplicate = $main->checkDuplicate("adword_ConversionBoosterReport","ad_CBreport_type",3,$month,$id);
		if(!$duplicate){
		
			$cbr = $main->getConversionBoosterReport($id,3,$month,$startDate,$endDate);
		}
		$results = $main->selectConversionBoosterReports($id,3,$month);
	}
	$_SESSION['cbr_reports'] = $results ;			

   foreach($results as $result){

	$ad_TopOfPageCpc = round($result -> ad_TopOfPageCpc /1000000 , 2);
?>

<tr bgcolor="<?php echo $color_2 ;  ?>" style="">
    <td style='width:10%; text-align:left;'><?php echo $result -> ad_CampaignName ;?> </td>
    <td style='width:15%; text-align:left;'><?php echo $result -> ad_AdGroupName ;?> </td>
    <td style='width:15%; text-align:left;'><?php echo $result -> ad_KeywordText ;?> </td>
    <td style='width:5%'><?php echo $result -> ad_KeywordMatchType ;?> </td>
    <td style='width:5%'><?php echo $result -> ad_keyword_adword_status; ?> </td>
    <td style='width:5%'><?php echo $result -> ad_QualityScore ;?> </td>	
    <td style='width:5%'><?php echo $result -> ad_Clicks ;?> </td>		
    <td style='width:5%'><?php echo $result -> ad_Impressions ;?> </td>		
    <td style='width:5%'><?php echo $result ->ad_Cost ;?> </td>		
    <td style='width:5%'><?php echo $result -> ad_Conversions ;?> </td>		
    <td style='width:5%'><?php echo $result ->ad_ConversionRate ;?> </td>		
    <td style='width:5%'><?php echo $result ->ad_CostPerConversion ;?> </td>		
    <td style='width:5%'><?php echo $result ->ad_Ctr;?> </td>	
    <td style='width:5%'><?php echo $result -> ad_AveragePosition ;?> </td>

    <td style='width:5%'><?php echo $ad_TopOfPageCpc ;?> </td>

</tr> 

<?php 


 }
 
 ?>

</table>