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

$monthTxt = date("M-Y",strtotime($month));
$_SESSION['monthTxt'] = $monthTxt;
$datestring=$startDate.' first day of last month';
$dt=date_create($datestring);
$last_month = $dt->format('Y-m');

$color_1 = "#434343";
$color_2="#FFF";
$color_3="#DDD";
$color_4="#EAEAEA";
$color_5="#F00";
$color_6="#00FFFF";

 $sql = "SELECT `ad_report_id`,`ad_month`,`ad_account_adword_id`,`ad_Clicks`,`ad_Impressions`,ROUND((`ad_Cost`/1000000),2) as ad_Cost ,`ad_Ctr`,ROUND((`ad_AverageCpc`/1000000),2) as ad_AverageCpc,`ad_ConversionRate`,`ad_Conversions`,ROUND((`ad_CostPerConversion`/1000000),2) as ad_CostPerConversion,`ad_ConversionValue`,`ad_SearchImpressionShare`,`ad_month`,`ad_EstimatedTotalConversions`,ROUND((`ad_Cost`/(`ad_EstimatedTotalConversions`*1000000)),2) as ad_CostPerEstConv FROM  adword_monthly_report WHERE ad_account_adword_id='".$id."' and (ad_month= '$last_month' or ad_month='$month') ";

 
 $result = $main -> getResults($sql);
 
 foreach($result as $key => $val){
 
	if($val==''){$val=0;}
 
	$res[$val->ad_month] = $val ;
 
 }
  echo "<pre>";
 print_r($res);
 
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
 
 

?>
<!--


/* 

THIS MONTH LAST MONTH SUMMARY REPORT

 */

-->

<table bgcolor ="<?php echo $color_3 ;  ?>" cellpadding=1 cellspacing=1 border=1  width="98%" align="center" style="margin:10px auto; border-collapse:collapse;">
<tr bgcolor ="<?php echo $color_1 ;  ?>"  style="color:<?php echo $color_2 ;  ?>;" ><td colspan=2><?php echo $_SESSION['ad_account_name']; ?></td><td colspan=8> <?php echo $monthTxt; ?> <?php echo PPC_PUSH_REPORT; ?> </td></tr>

<tr bgcolor ="<?php echo $color_2 ;  ?>">
<td width="10%" >&nbsp;</td>
<td  width="10%">&nbsp;</td>
<td  width="10%">&nbsp;</td>
<td width="10%">&nbsp;</td>
<td width="10%">&nbsp;</td>
<td width="10%">&nbsp;</td>
<td width="10%">&nbsp;</td>
<td width="10%">&nbsp;</td>
<td width="10%">&nbsp;</td>
<td width="10%">&nbsp;</td>
</tr>
<tr bgcolor ="<?php echo $color_6 ;  ?>">
	<td><?php echo CONVERSIONS_FULL; ?></td>
	<td>This Month</td>
	<td>Last Month</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>This Month</td>
	<td>Last Month</td>
	<td>&nbsp;</td>
	<td>This Month</td>
	<td>Last Month</td>
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
	<td>£<?php echo $mntData->ad_Cost; ?></td>
	<td>£<?php echo $lmntData->ad_Cost; ?></td>
</tr>
<tr bgcolor ="<?php echo $color_4 ;  ?>">
	<td><?php echo $type[1]; ?>&nbsp;</td>
	<td>&nbsp;<?php echo $mntConv[$type[1]]; ?></td>
	<td>&nbsp;<?php echo $lmntConv[$type[1]]; ?></td>
	<td>&nbsp;</td><td><?php echo CONVERSION_VALUE; ?></td>
	<td><?php echo $mntData->ad_ConversionValue; ?></td>
	<td><?php echo $lmntData->ad_ConversionValue; ?></td>
	<td>CPC</td>
	<td>£<?php echo $mntData->ad_AverageCpc; ?></td>
	<td>£<?php echo $lmntData->ad_AverageCpc; ?></td>
</tr>
<tr bgcolor ="<?php echo $color_4 ;  ?>">
	<td><?php echo $type[2]; ?>&nbsp;</td>
	<td>&nbsp;<?php echo $mntConv[$type[2]]; ?></td>
	<td>&nbsp;<?php echo $lmntConv[$type[2]]; ?></td>
	<td>&nbsp;</td>
	<td><?php echo COST_PER_CONVERSION_EURO; ?></td>
	<td>£<?php echo $mntData->ad_CostPerConversion; ?></td>
	<td>£<?php echo $lmntData->ad_CostPerConversion; ?></td>
	<td><?php echo CLICKS; ?></td>
	<td><?php echo number_format($mntData->ad_Clicks); ?></td>
	<td><?php echo number_format($lmntData->ad_Clicks); ?></td>
</tr>
<tr bgcolor ="<?php echo $color_4 ;  ?>">
	<td><?php echo $type[3]; ?>&nbsp;</td>
	<td><?php echo $mntConv[$type[3]]; ?>&nbsp;</td>
	<td><?php echo $lmntConv[$type[3]]; ?>&nbsp;</td>
	<td>&nbsp;</td><td><?php echo ESTIMATED_CONVERSIONS; ?></td>
	<td><?php echo $mntData->ad_EstimatedTotalConversions; ?></td>
	<td><?php echo $lmntData->ad_EstimatedTotalConversions; ?></td>
	<td><?php echo CONVERSION_RATE_PERCENTAGE; ?></td>
	<td><?php echo $mntData->ad_ConversionRate; ?>%</td>
	<td><?php echo $lmntData->ad_ConversionRate; ?>%</td>
</tr>
<tr bgcolor ="<?php echo $color_4 ;  ?>">
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td><?php echo COST_PER_ESTIMATED_CONVERSIONS_EURO ; ?></td>
	<td>£<?php echo $mntData->ad_CostPerEstConv; ?></td>
	<td>£<?php echo $lmntData->ad_CostPerEstConv; ?></td>
	<td>Impressions</td>
	<td><?php echo number_format($mntData->ad_Impressions);?></td>
	<td><?php echo number_format($lmntData->ad_Impressions); ?></td>
</tr>
<tr bgcolor ="<?php echo $color_4 ;  ?>">
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>CTR</td>
	<td><?php echo $mntData->ad_Ctr; ?>%</td>
	<td><?php echo $lmntData->ad_Ctr; ?>% </td>
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
</table>

<!--


/* 

 AD LABEL REPORT 

 */

-->
<table bgcolor ="<?php echo $color_3 ;  ?>" cellpadding=1 cellspacing=1 border=1 width="98%" align="center" style="margin:10px auto;border-collapse:collapse;">
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>
<tr bgcolor ="<?php echo $color_6 ;  ?>">
<td   width="20%" colspan=2>Ad Label Report</td>
<td colspan=8>Using labels is the best way to monitor ad copy tests and see what ads are working best. Use the best ad lables to build new tests. </td>
</tr>
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>
<tr bgcolor ="<?php echo $color_1 ;  ?>" style="color:<?php echo $color_2 ;  ?>;" >
<td  colspan=2 ><?php echo REPORT_NOTES_BY_ACCOUNT_MANAGER; ?></td>
<td colspan=8 >&nbsp;</td></tr>
<tr bgcolor ="<?php echo $color_1 ;  ?>"  style="color:<?php echo $color_2 ;  ?>;" ><td colspan=10 >&nbsp;</td></tr>
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>

</table>
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

$sql  = "SELECT max(ad_report_id) id ,ad_Labels, ad_AdGroupId , ad_AdType ,`ad_Headline`,`ad_Description1`, `ad_Description2`,`ad_DisplayUrl`, SUM(ad_Clicks) clicks , SUM(ad_Impressions) impressions ,  ROUND(((SUM(ad_Clicks)/SUM(ad_Impressions)) * 100),2) ctr ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Clicks`))/1000000),2) as ad_avgCpc ,SUM(ad_Conversions) convrns  , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2) convrate ,ROUND(((SUM(`ad_Cost`)/ROUND((SUM(ad_Conversions)/SUM(ad_Clicks)*100),2))/1000000),2) as ad_CstPConvR, ROUND((SUM(ad_Cost)/1000000),2) cost FROM `adword_ad_reports` A WHERE ad_account_id ='$id' AND `ad_Date` BETWEEN '$startDate' AND '$endDate' AND (ad_Labels <>'' AND ad_Labels NOT LIKE '%--%') AND ad_Status='ENABLED' GROUP BY ad_Labels having clicks > 0 ; " ;

	$results = $main -> getResults($sql);
	
	foreach($results as $key => $value){
	
	
	?>
<tr  bgcolor ="<?php echo $color_2 ;  ?>">
	<td style='width:16%; text-align:left;'><?php echo $value->ad_Labels ; ?></td>
	<td style='width:10%'><?php echo $value->clicks ; ?></td>
	<td style='width:10%'><?php echo $value->impressions ; ?> </td>
	<td style='width:7%'><?php echo $value->ctr ; ?></td>
	<td style='width:10%'><?php echo $value->ad_avgCpc ; ?></td>
	<td style='width:7%'><?php echo $value->cost ; ?></td>
	<td style='width:10%'><?php echo $value->convrns ; ?></td>
	<td style='width:10%'><?php echo $value->ad_CostPerConversion ; ?></td>
	<td style='width:10%'><?php echo $value->ad_CstPConvR ; ?></td>
	<td style='width:10%'><?php echo $value->convrate ; ?></td>
</tr>
<?php } ?>
 
 </table>
<table bgcolor ="<?php echo $color_3 ;  ?>" cellpadding=1 cellspacing=1 border=1 width="98%" align="center" style="margin:10px auto; border-collapse:collapse;">
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>

<tr bgcolor ="<?php echo $color_6 ;  ?>">
<td  width="20%" colspan=2>Device Performance Report</td>
<td colspan=8>Mobile and Tablet usage is changing everyday. See how clicks, conversions and cost per conversion have changed over the past 30 days compared to 90 days and whole year. Mobile usage could be up to 30% before the year end.  </td>
</tr>
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>

<tr bgcolor ="<?php echo $color_1 ;  ?>"  style="color:<?php echo $color_2 ;  ?>;"><td  colspan=2 >Report Notes By Account Manager</td><td colspan=8 >&nbsp;</td></tr>
<tr bgcolor ="<?php echo $color_1 ;  ?>" style="color:<?php echo $color_2 ;  ?>;" ><td colspan=10 >&nbsp;</td></tr>
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>

</table>
<table width="98%"  border="1" bgcolor ="<?php echo $color_3 ;  ?>" cellpadding=1 cellspacing=1  width="98%" align="center" style="margin:10px auto; border-collapse:collapse;">
 <tr bgcolor ="<?php echo $color_4 ;  ?>">
	<td style='width:19%'>Device</td>
	<td style='width:9%'>Impr</td>
	<td style='width:9%'>Clicks</td>
	<td style='width:9%'>CTR</td>
	<td style='width:9%'>Cost</td>
	<td style='widtd:9%'>Cost/Click</td>
	<td style='width:9%'>Conv</td>
	<td style='width:9%'>Conv Rate</td>
	<td style='width:9%'>Cost / Conv</td>
	<td style='width:9%'>Avg Position</td>
	</tr>
 <?php

$sql = "SELECT ad_Device , SUM(ad_Impressions) ad_Impressions ,SUM(ad_Clicks) ad_Clicks , ROUND((SUM(ad_Cost)/1000000),2) ad_Cost , SUM(ad_Conversions) ad_Conversions , ROUND(((SUM(`ad_Cost`)/SUM(`ad_Clicks`))/1000000),2) as ad_CostPerClick ,ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion  , ROUND(SUM(ad_Clicks)/SUM(ad_Impressions)*100,2) ad_Ctr , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks))*100,2) ad_ConversionRate , ROUND(SUM(ad_Impressions * ad_AveragePosition)/SUM(ad_Impressions),2) as ad_AveragePosition  FROM adword_keyword_report WHERE ad_Date BETWEEN '$startDate' and '$endDate' and ad_account_id='$id' AND ad_Device <> '' AND  ad_Device in ('Computers','Mobile devices with full browsers','Other',
'Tablets with full browsers')  GROUP BY ad_Device   ";
//echo $sql ;
$results = $main -> getResults($sql);

foreach($results as $result){
    $total_sales += $result -> ad_Conversions ;
}

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

} ?>

 
<tr bgcolor="<?php echo $color_2 ;  ?>">
	<td style='width:15%'><b>Total</b></td>
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
 
 
<table bgcolor ="<?php echo $color_3 ;  ?>" cellpadding=1 cellspacing=1 border=1 width="98%" align="center" style="margin:10px auto;border-collapse:collapse;">
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>

<tr bgcolor ="<?php echo $color_6 ;  ?>"><td  width="20%"  colspan=2 >Wastage Analysis</td><td colspan=8>The column called query is the actual keyword and this is not in the account as a keywords or negative. Be careful even though they have no conversions many keywords will be relevant and should be added into the account. Build a list and choose relevant campaigns and ad groups or make new ones.</td></tr>
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>

<tr bgcolor ="<?php echo $color_1 ;  ?>"  style="color:<?php echo $color_2 ;  ?>;"><td  colspan=2 >Report Notes By Account Manager</td><td colspan=8>&nbsp;</td></tr>
<tr bgcolor ="<?php echo $color_1 ;  ?>"  style="color:<?php echo $color_2 ;  ?>;"><td colspan=10 >&nbsp;</td></tr>
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>
</table>
<table width="98%"  border="1" bgcolor ="<?php echo $color_3 ;  ?>" cellpadding=1 cellspacing=1 width="98%" align="center" style="margin:10px auto; border-collapse:collapse;">
 <tr bgcolor ="<?php echo $color_4 ;  ?>">
	<td style='width:19%'>Query</td>
	<td style='width:18%'>Campaign Name</td>
	<td style='width:18%'>Keyword Text</td>
	<td style='width:10%'>Match Type</td>
	<td style='width:5%'>Clicks</td>
	<td style='widtd:5%'>Conv</td>
	<td style='width:5%'>Cost</td>
	<td style='width:5%'>Cost/ Conv</td>
	<td style='width:5%'>Impr</td>
	<td style='width:10%'>Avg Position</td>
	</tr>
	<?php

	$sql = "SELECT `ad_Query`,`ad_MatchType`,`ad_KeywordTextMatchingQuery`,`ad_CampaignName`,`ad_AdGroupName`,SUM(`ad_Clicks`) ad_Clicks ,SUM(`ad_Impressions`) ad_Impressions, SUM(`ad_Conversions`) ad_Conversions , SUM(`ad_Cost`) ad_Cost ,SUM(`ad_Cost`)/ SUM(`ad_Conversions`)  as ad_CostPerConversion ,SUM(`ad_ConversionValue`) ad_ConversionValue,`ad_AveragePosition` FROM `adword_search_query_reports` WHERE `ad_Date` BETWEEN '$startDate' AND '$endDate' AND `ad_account_id` ='$id' AND ad_Query <>ad_KeywordTextMatchingQuery GROUP BY `ad_Query`,`ad_CampaignName`,`ad_AdGroupName` HAVING `ad_Clicks` >0 and ad_Conversions=0 ORDER BY  ad_Clicks DESC ,`ad_CampaignName` DESC LIMIT 25";
	
	
	$results = $main->getResults($sql);

	
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
	<td style='width:5%'><?php echo $value->ad_AveragePosition ; ?></td>	

</tr>
<?php } ?>
 
 </table>
<table bgcolor ="<?php echo $color_3 ;  ?>" cellpadding=1 cellspacing=1 border=1 width="98%" align="center" style="margin:10px auto;border-collapse:collapse;">
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>

<tr bgcolor ="<?php echo $color_6 ;  ?>"><td  colspan=2  width="20%" >Keyword Discovery</td><td colspan=8>The column  called query is the actual keyword and this is not in the account as a keyword. Be careful where you add these in the account. Build a list and choose relevant campaigns and ad groups or make new ones.  </td></tr>
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>

<tr bgcolor ="<?php echo $color_1 ;  ?>"  style="color:<?php echo $color_2 ;  ?>;"><td  colspan=2 >Report Notes By Account Manager</td><td colspan=8 >&nbsp;</td></tr>
<tr bgcolor ="<?php echo $color_1 ;  ?>"  style="color:<?php echo $color_2 ;  ?>;"><td colspan=10 >&nbsp;</td></tr>
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>
</table>
 <table width="98%"  border="1" bgcolor ="<?php echo $color_3 ;  ?>" cellpadding=1 cellspacing=1 width="98%" align="center" style="margin:10px auto;  border-collapse:collapse;">
 <tr bgcolor ="<?php echo $color_4 ;  ?>">
	<td style='width:19%'>Query</td>
	<td style='width:18%'>Campaign Name</td>
	<td style='width:18%'>Keyword Text</td>
	<td style='width:10%'>Match Type</td>
	<td style='width:10%'>Device</td>
	<td style='width:5%'>Clicks</td>
	<td style='widtd:5%'>Conv</td>
	<td style='width:5%'>Cost</td>
	<td style='width:5%'>Cost/ Conv</td>
	<td style='width:5%'>Impr</td>	
	</tr>
 
<?php

	
	$sql = "SELECT `ad_Query`,`ad_MatchType`,`ad_KeywordTextMatchingQuery`,`ad_CampaignName`,`ad_AdGroupName`,SUM(`ad_Clicks`) ad_Clicks ,SUM(`ad_Impressions`) ad_Impressions, SUM(`ad_Conversions`) ad_Conversions , SUM(`ad_Cost`) ad_Cost ,SUM(`ad_Cost`)/ SUM(`ad_Conversions`)  as ad_CostPerConversion ,ad_Device FROM `adword_search_query_reports` WHERE `ad_Date` BETWEEN '$startDate' AND '$endDate' AND `ad_account_id` ='$id' AND ad_Query <>ad_KeywordTextMatchingQuery GROUP BY `ad_Query`,`ad_Device`,`ad_CampaignName`,`ad_AdGroupName` HAVING `ad_Conversions` >0 ORDER BY  ad_Conversions DESC ,`ad_CampaignName` DESC ,ad_Device ASC  LIMIT 25";
	

	
	$results = $main -> getResults($sql);
	
	
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
<table bgcolor ="<?php echo $color_3 ;  ?>" cellpadding=1 cellspacing=1 border=1 width="98%" align="center" style="margin:10px auto;border-collapse:collapse;">
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>

<tr bgcolor ="<?php echo $color_6 ;  ?>"><td  colspan=2  width="20%" >Conversion Booster Reports</td><td colspan=8>These keywords are converting and a higher CTR will lead to more conversions. Focus on keywords with higher conversions and lower Cost per conversion. </td></tr>
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>

<tr bgcolor ="<?php echo $color_1 ;  ?>"  style="color:<?php echo $color_2 ;  ?>;"><td  colspan=2>Report Notes By Account Manager</td><td colspan=8>&nbsp;</td></tr>
<tr bgcolor ="<?php echo $color_1 ;  ?>"  style="color:<?php echo $color_2 ;  ?>;" ><td colspan=10 >&nbsp;</td></tr>
<tr bgcolor ="<?php echo $color_2 ;  ?>"><td colspan=10 >&nbsp;</td></tr>

</table>


  <table width="98%"  border="1" bgcolor ="<?php echo $color_3 ;  ?>" cellpadding=1 cellspacing=1 width="98%" align="center" style="margin:10px auto; border-collapse:collapse; ">
    <tr bgcolor ="<?php echo $color_4 ;  ?>">
	<td style='width:12%' style="color:<?php echo $color_5 ;  ?>;">Campaign Name</td>
	<td style='width:12%' style="color:<?php echo $color_5 ;  ?>;">AdGroup Name</td>
	<td style='width:11%'>Keyword Text</td>
	<td style='width:10%' style="color:<?php echo $color_5 ;  ?>;">Match Type</td>
	<td style='width:5%' style="color:<?php echo $color_5 ;  ?>;">Status</td>
	<td style='width:5%'>Q S</td>
	<td style='width:5%'>Clicks</td>
	<td style='width:5%'>Impr</td>
	
	<td style='width:5%'>Cost</td>		
	<td style='width:5%'>Conv</td>
	<td style='width:5%'>Conv Rate</td>
	<td style='width:5%'>Cost / Conv</td>
	<td style='width:4%'>Ctr (%)</td>
	<td style='width:6%'>Avg Position</td>
	<td style='width:5%'>Top Of Page Cpc</td>

</tr>
<?php
    
	$sql = "SELECT `ad_CampaignName`,`ad_AdGroupName`,`ad_KeywordText`,ROUND((SUM(ad_Clicks)/SUM(ad_Impressions)*100),2) Ctr, SUM(`ad_Clicks`) ad_Clicks,SUM(`ad_Impressions`) ad_Impressions ,ROUND(SUM(`ad_Cost`)/1000000,2) ad_Cost , SUM(`ad_Conversions`) Conversions_sum , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks))*100,2) ad_ConversionRate , ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion ,ROUND(AVG(ad_AveragePosition),2) as ad_AveragePosition , MAX(ad_FirstPageCpc) as ad_FirstPageCpc , MAX(ad_TopOfPageCpc) ad_TopOfPageCpc ,SUM(ad_ConversionValue) as ad_ConversionValue  ,`ad_Keyword_Id`,`ad_CampaignId`,`ad_AdGroupId`,ad_KeywordMatchType
	
	FROM `adword_keyword_report` 
	WHERE `ad_Date` BETWEEN '$startDate' AND '$endDate' AND ad_account_id='$id'  GROUP BY adword_keyword_report.`ad_Keyword_Id`,`ad_CampaignId`,`ad_AdGroupId` HAVING Ctr < 2 AND Ctr >0 AND Conversions_sum <> 0 order by `ad_AdGroupName` desc
	";

	$results = $main ->getResults($sql);
			

    foreach($results as $result){

	$sel = "select ad_QualityScore,ad_keyword_adword_status,adword_keywords.ad_QualityScore,ad_CpcBid FROM adword_keywords where adword_keywords.ad_keyword_adword_id = '".$result->ad_Keyword_Id."' AND adword_keywords.ad_adgroup_adword_id = '".$result->ad_AdGroupId."' AND adword_keywords.ad_campaign_adword_id = '".$result->ad_CampaignId."' and ad_keyword_adword_status='ENABLED'";
	
	$sel_res = $main->getRow($sel);
	
	if(count($sel_res)>0){
				
    $ad_FirstPageCpc = round($result -> ad_FirstPageCpc / 1000000 , 2);
    $ad_TopOfPageCpc = round($result -> ad_TopOfPageCpc /1000000 , 2);
    $ad_CpcBid = round($sel_res -> ad_CpcBid /1000000 , 2);

    if($ad_FirstPageCpc > $ad_CpcBid) {$style = "color : red;";} else {$style ="";}

?>

<tr bgcolor="<?php echo $color_2 ;  ?>" style="">
    <td style='width:10%; text-align:left;'><?php echo $result -> ad_CampaignName ;?> </td>
    <td style='width:15%; text-align:left;'><?php echo $result -> ad_AdGroupName ;?> </td>
    <td style='width:15%; text-align:left;'><?php echo $result -> ad_KeywordText ;?> </td>
    <td style='width:5%'><?php echo $result -> ad_KeywordMatchType ;?> </td>
    <td style='width:5%'><?php echo $sel_res -> ad_keyword_adword_status; ?> </td>
    <td style='width:5%'><?php echo $sel_res -> ad_QualityScore ;?> </td>	
    <td style='width:5%'><?php echo $result -> ad_Clicks ;?> </td>		
    <td style='width:5%'><?php echo $result -> ad_Impressions ;?> </td>		
    <td style='width:5%'><?php echo $result ->ad_Cost ;?> </td>		
    <td style='width:5%'><?php echo $result -> Conversions_sum ;?> </td>		
    <td style='width:5%'><?php echo $result ->ad_ConversionRate ;?> </td>		
    <td style='width:5%'><?php echo $result ->ad_CostPerConversion ;?> </td>		
    <td style='width:5%'><?php echo $result ->Ctr;?> </td>	
    <td style='width:5%'><?php echo $result -> ad_AveragePosition ;?> </td>

    <td style='width:5%'><?php echo $ad_TopOfPageCpc ;?> </td>

</tr> 

<?php } } ?>

</table>

