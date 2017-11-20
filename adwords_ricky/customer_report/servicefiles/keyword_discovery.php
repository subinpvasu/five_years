<?php
/*

This is file to show keyword discovery report for customer report
*/
// to get detils of the report type KEYWORD DISCOVERY 
$reportDetails = $reports -> getReportDetails("KEYWORD DISCOVERY");

?>
<!-- Table for report details  -->
<table bgcolor ="<?php echo $color_3 ;  ?>" cellpadding=1 cellspacing=1 border=1 width="98%" align="center" style="margin:0px auto;border-collapse:collapse;">
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>

<tr bgcolor ="<?php echo $color_6 ;  ?>"><td  colspan=2  width="20%" ><?php echo ucwords(strtolower($reportDetails[0]->ad_report_type_name)) ; ?></td><td colspan=8>The column called query is the actual keyword and this is not in the account as a keyword, coming through a phrase or broad match. By adding these and giving them their own ads and bids we can really focus on improving the CTR and generating more leads/sales.</td></tr>
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
	<td style='width:10%'><?php echo DEVICE; ?></td>
	<td style='width:5%'><?php echo CLICKS; ?></td>
	<td style='widtd:5%'><?php echo CONVERSIONS; ?></td>
	<td style='width:5%'>Cost (<?php echo $_SESSION['ad_account_currencyCode']; ?>)</td>
	<td style='width:5%'>Cost / Conv (<?php echo $_SESSION['ad_account_currencyCode']; ?>)</td>
	<td style='width:5%'><?php echo IMPRESSIONS; ?></td>	
	</tr>
 
<?php


	if($month==date('Y-m')){	
		$results = $main->selectKeywordDiscovery($id,2);	
	}
	else{
		
		$duplicate = $main->checkDuplicate("adword_KeywordDiscovery","ad_KDReport_type",3,$month,$id);
		if(!$duplicate){
		
			$cbr = $main->getKeywordDiscoveryReport($id,3,$month,$startDate,$endDate);
		}
		$results = $main->selectKeywordDiscovery($id,2,$month);
	}
	$_SESSION['keyword_discovery'] = $results ;
	
	
	foreach($results as $key => $value){
	?>
<tr bgcolor="<?php echo $color_2 ;  ?>" >
	<td style='width:20%; text-align:left;'><?php echo $value->ad_Query ; ?></td>
	<td style='width:15%; text-align:left;'><?php echo $value->ad_CampaignName ; ?></td>
	<td style='width:15%; text-align:left;'><?php echo $value->ad_KeywordTextMatchingQuery ; ?></td>
	<td style='width:5%'><?php echo $value->ad_MatchType ; ?></td>
	<td style='width:10%'><?php echo $value->ad_Device ; ?></td>
	<td style='width:5%'><?php echo $value->ad_Clicks ; ?></td>
	<td style='width:5%'><?php echo $value->ad_Conversions ; ?></td>
	<td style='width:5%'><?php echo round($value->ad_Cost /1000000,2) ; ?></td>
	<td style='width:5%'><?php echo round($value->ad_CostPerConversion  /1000000,2); ?></td>
	<td style='width:5%'><?php echo $value->ad_Impressions ; ?></td>	
</tr>
<?php } ?>
</table>

