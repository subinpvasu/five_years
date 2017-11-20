<?php
/*

This is file to show daily hourly report for customer report
*/
// to get detils of the report type DAILY & HOURLY REPORT 
$reportDetails = $reports -> getReportDetails("DAILY & HOURLY REPORT");
include_once('dhr_reports_1.php'); 
include_once('dhr_reports_2.php'); 

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

<?php $_SESSION['dailyFileName'] = $dailyFileName; ?>
<?php $_SESSION['hourlyFileName'] = $hourlyFileName; ?>

<table><tr>
<td width="50%" colspan=5 >
		<h2>Avg. by Day of Week</h2>
		<img width="90%" height="500" align="center" src="<?php echo SITE_URL ;?>customer_report/img/<?php echo $dailyFileName ; ?>" />
	</div>
	
<td width="50%" colspan=5 >
		<h2>Total by Hour of Day</h2>
		<img width="90%" height="500" src="<?php echo SITE_URL ;?>customer_report/img/<?php echo $hourlyFileName; ?>" />
	</td>
</tr></table>
