<?php
/*

*
* Service file for showing customer report
*

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

 $sql = "SELECT `ad_report_id`,`ad_month`,`ad_account_adword_id`,`ad_Clicks`,`ad_Impressions`,ROUND((`ad_Cost`/1000000),2) as ad_Cost ,`ad_Ctr`,ROUND((`ad_AverageCpc`/1000000),2) as ad_AverageCpc,`ad_ConversionRate`,`ad_Conversions`,ROUND((`ad_CostPerConversion`/1000000),2) as ad_CostPerConversion,`ad_ConversionValue`,`ad_SearchImpressionShare`,`ad_month`,`ad_EstimatedTotalConversions`,ROUND((`ad_Cost`/(`ad_EstimatedTotalConversions`*1000000)),2) as ad_CostPerEstConv FROM  adword_monthly_report WHERE ad_account_adword_id='".$id."' and (ad_month= '$last_month' or ad_month='$month') ";

 
 $result = $main -> getResults($sql);
 
    echo "<pre>";
 print_r($result);
 foreach($result as $key => $val){
 
	//if($val==''){$val=0;}
 
	$res[$val->ad_month] = $val ;
 
 }
 
 $lmntData = $res[$last_month];
 $mntData = $res[$month];
 
 $sql = "SELECT ad_month,ad_ConversionTypeName,ad_Conversions FROM  adword_convtype_report WHERE ad_account_adword_id='".$id."' and (ad_month= '$last_month' or ad_month='$month') ";
$result = $main -> getResults($sql);
 $type = array();
 foreach($result as $key => $val){

	if($val->ad_month==$last_month){
		$lmntConv[$val->ad_ConversionTypeName] =$val->ad_Conversions ;
	}
	else{
		$mntConv[$val->ad_ConversionTypeName] =$val->ad_Conversions ;
	}

	if(!in_array($val->ad_ConversionTypeName,$type)){
		$type[]=$val->ad_ConversionTypeName;
	}

 }

 $typeCount = count($type);
 
 $_SESSION['lmntConv'] = $lmntConv;
 $_SESSION['mntConv'] = $mntConv;
 $_SESSION['lmntData'] = $lmntData;
 $_SESSION['mntData'] = $mntData;
 $_SESSION['type'] = $type;
 

?>
<!--


/* 

THIS MONTH LAST MONTH SUMMARY REPORT

 */

-->

<table bgcolor ="<?php echo $color_3 ;  ?>" cellpadding=1 cellspacing=1 border=1  width="98%" align="center" style="margin:10px auto; border-collapse:collapse;">
<tr bgcolor ="<?php echo $color_1 ;  ?>"  style="color:<?php echo $color_2 ;  ?>;" >
<td colspan=2><?php echo $_SESSION['ad_account_name']; ?></td>
<td colspan=2> <?php echo $monthTxt; ?> <?php echo PPC_PUSH_REPORT; ?> </td>
 <td colspan=6 >Generated from Push™ Analyser
</td></tr>

<tr bgcolor ="<?php echo $color_2 ;  ?>">
<td width="10%" >&nbsp;</td>
<td  width="10%">&nbsp;</td>
<td  width="10%">&nbsp;</td>
<td width="10%">&nbsp;</td>
<td width="10%">Deepa</td>
<td width="10%">&nbsp;</td>
<td width="10%">&nbsp;</td>
<td width="10%">&nbsp;</td>
<td width="10%">&nbsp;</td>
<td width="10%">&nbsp;</td>
</tr>
<tr bgcolor ="<?php echo $color_6 ;  ?>">
	<td><?php echo CONVERSIONS_FULL; ?></td>
	<td><?php echo $thismonth; ?></td>
	<td><?php echo $lastmonth; ?></td>
	<td>&nbsp;</td>
	<td>Conversion Data</td>
	<td><?php echo $thismonth; ?></td>
	<td><?php echo $lastmonth; ?></td>
	<td>&nbsp;</td>
	<td><?php echo $thismonth; ?></td>
	<td><?php echo $lastmonth; ?></td>
</tr>
<tr bgcolor ="<?php echo $color_2 ;  ?>">
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr bgcolor ="<?php echo $color_4 ;  ?>">
	<td><?php echo $type[0]; ?>&nbsp;</td>
	<td><?php echo $mntConv[$type[0]]; ?>&nbsp;</td>
	<td><?php echo $lmntConv[$type[0]]; ?>&nbsp;</td>
	<td>&nbsp;</td>
	<td><?php echo CONVERSIONS; ?></td>
	<td><?php echo $mntData->ad_Conversions; ?></td>
	<td><?php echo $lmntData->ad_Conversions; ?></td>
	<td><?php echo SPENT; ?></td>
	<td><?php echo $_SESSION['ad_account_currencyCode']; ?><?php echo $mntData->ad_Cost; ?></td>
	<td><?php echo $_SESSION['ad_account_currencyCode']; ?><?php echo $lmntData->ad_Cost; ?></td>
</tr>
<tr bgcolor ="<?php echo $color_4 ;  ?>">
	<td><?php echo $type[1]; ?>&nbsp;</td>
	<td>&nbsp;<?php echo $mntConv[$type[1]]; ?></td>
	<td>&nbsp;<?php echo $lmntConv[$type[1]]; ?></td>
	<td>&nbsp;</td><td><?php echo CONVERSION_VALUE; ?></td>
	<td><?php echo $mntData->ad_ConversionValue; ?></td>
	<td><?php echo $lmntData->ad_ConversionValue; ?></td>
	<td>CPC</td>
	<td><?php echo $_SESSION['ad_account_currencyCode']; ?><?php echo $mntData->ad_AverageCpc; ?></td>
	<td><?php echo $_SESSION['ad_account_currencyCode']; ?><?php echo $lmntData->ad_AverageCpc; ?></td>
</tr>
<tr bgcolor ="<?php echo $color_4 ;  ?>">
	<td><?php echo $type[2]; ?>&nbsp;</td>
	<td>&nbsp;<?php echo $mntConv[$type[2]]; ?></td>
	<td>&nbsp;<?php echo $lmntConv[$type[2]]; ?></td>
	<td>&nbsp;</td>
	<td> Cost/Conv (<?php echo $_SESSION['ad_account_currencyCode']; ?>)</td>
	<td><?php echo $_SESSION['ad_account_currencyCode']; ?><?php echo $mntData->ad_CostPerConversion; ?></td>
	<td><?php echo $_SESSION['ad_account_currencyCode']; ?><?php echo $lmntData->ad_CostPerConversion; ?></td>
	<td><?php echo CLICKS; ?></td>
	<td><?php echo number_format($mntData->ad_Clicks); ?></td>
	<td><?php echo number_format($lmntData->ad_Clicks); ?></td>
</tr>
<tr bgcolor ="<?php echo $color_4 ;  ?>">
	<td><?php echo $type[3]; ?>&nbsp;</td>
	<td><?php echo $mntConv[$type[3]]; ?>&nbsp;</td>
	<td><?php echo $lmntConv[$type[3]]; ?>&nbsp;</td>
	<td>&nbsp;</td>
	<td><?php echo ESTIMATED_CONVERSIONS; ?></td>
	<td><?php echo $mntData->ad_EstimatedTotalConversions; ?></td>
	<td><?php echo $lmntData->ad_EstimatedTotalConversions; ?></td>
	<td><?php echo CONVERSION_RATE_PERCENTAGE; ?></td>
	<td><?php echo $mntData->ad_ConversionRate; ?>%</td>
	<td><?php echo $lmntData->ad_ConversionRate; ?>%</td>
</tr>
<tr bgcolor ="<?php echo $color_4 ;  ?>">
	<td><?php echo $type[4]; ?>&nbsp;</td>
	<td><?php echo $mntConv[$type[4]]; ?>&nbsp;</td>
	<td><?php echo $lmntConv[$type[4]]; ?>&nbsp;</td>
	<td>&nbsp;</td>
	<td>Cost / Estimated Conv(<?php echo $_SESSION['ad_account_currencyCode']; ?>)</td>
	<td><?php echo $_SESSION['ad_account_currencyCode']; ?><?php echo 0+$mntData->ad_CostPerEstConv; ?></td>
	<td><?php echo $_SESSION['ad_account_currencyCode']; ?><?php echo 0+$lmntData->ad_CostPerEstConv; ?></td>
	<td>Impressions</td>
	<td><?php echo number_format($mntData->ad_Impressions);?></td>
	<td><?php echo number_format($lmntData->ad_Impressions); ?></td>
</tr>
<tr bgcolor ="<?php echo $color_4 ;  ?>">
	<td><?php echo $type[5]; ?>&nbsp;</td>
	<td><?php echo $mntConv[$type[5]]; ?>&nbsp;</td>
	<td><?php echo $lmntConv[$type[5]]; ?>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>CTR</td>
	<td><?php echo $mntData->ad_Ctr; ?>%</td>
	<td><?php echo $lmntData->ad_Ctr; ?>% </td>
</tr>
<?php for($i=6; $i<count($type); $i++){ ?>
<tr bgcolor ="<?php echo $color_4 ;  ?>">
	<td><?php echo $type[$i]; ?>&nbsp;</td>
	<td><?php echo $mntConv[$type[$i]]; ?>&nbsp;</td>
	<td><?php echo $lmntConv[$type[$i]]; ?>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<?php } ?>
<tr bgcolor ="<?php echo $color_2 ;  ?>">
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
</table>
	
<?php 

/* AD LABEL REPORTS */

include_once('adlabel_report.php'); 


?>
<?php 

/* DEVICE REPORTS */

include_once('device_report.php'); 


?>
<?php 

/* WASTAGE ANALYSIS REPORTS */

include_once('wastage_analysis.php'); 


?>

<?php 
/* KEYWORD DISCOVERY REPORTS */

include_once('keyword_discovery.php'); 


?>

<?php 
/* CONVERSION BOOSTER REPORTS */

include_once('conversion_booster_report_old.php'); 


?>

<?php 
/* DAILY HOURLY REPORT */

include_once('daily_hourly_report.php'); 


?>
