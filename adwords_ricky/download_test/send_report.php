<?php
require_once dirname(__FILE__) . '/../includes/includes.php';
require_once dirname(__FILE__) . '/smtp/PHPMailerAutoload.php';

$oldday = date('Y-m-d',strtotime("-7 days"));

shell_exec("rm /var/www/html/app/cron/log/getReports.log") ;

$sql = "delete from csvreports where col1 < '$oldday'" ;

$main -> query($sql);

$html = "";


$res = $main -> getResults("SELECT customerId,prospect_account,descriptiveName FROM adword_mcc_accounts WHERE prospect_account <> 10;",'ARRAY_A');

foreach($res as $r){
		
	
	if($r['prospect_account'] ==0):
		
			$dbName = DB_DATABASE ;
		
	else :
	
		$dbName = DB_DATABASE_PROSPECT ;
		
	endif;
	
	$main -> Select($dbName) ;
		
	$res1 = $main->getResults("SELECT COUNT(`ad_account_id`) cnt FROM `adword_accounts` WHERE `adword_accounts`.ad_mcc_id = '".$r['customerId']."' AND ad_account_status=1 and ad_delete_status =0  ",'ARRAY_A');
	
	
	$html .="<h3>MCC ACCOUNT </h3>";
	
	$html .= "<table border=1 style=\"border-collapse : collapse ; border:1px #CCC solid;\" width=\"90%\">";
	
	$html .= "<tr><th>MCC ID</th><th>Name of MCC</th><th>Total Number of Enabled Accounts</th></tr>";
	$html .= "<tr><td>".$r['customerId']."</td><td>".$r['descriptiveName']."</td><td>".$res1[0]['cnt']."</td></tr>";
	
	$html.="</table>";
	
	$res2 = $main->getResults("SELECT `adword_monthly_report`.`ad_Month`,COUNT(ad_report_id) rcords,SUM(`ad_Clicks`) ad_Clicks,SUM(`ad_Impressions`) ad_Impressions ,COUNT(DISTINCT(`adword_monthly_report`.`ad_account_adword_id`)) sum FROM `adword_accounts` LEFT JOIN `adword_monthly_report` on `adword_monthly_report`.`ad_account_adword_id`= `adword_accounts`.`ad_account_adword_id` WHERE `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."' GROUP BY `adword_monthly_report`.`ad_month`,`adword_accounts`.`ad_mcc_id` ORDER BY `ad_month` DESC limit 2",'ARRAY_A');

	$html .= "<h3>Overview Last 7 Days report download for MCC Account </h3>";
	
	$html .= "<table border=1 style=\"border-collapse : collapse ; border:1px #CCC solid;\" width=\"90%\">";
	
	$html .= "<tr><th width=10%>Date of Download</th>

<th  width=40%>Report Name</th>
<th  width=10%>Count Of accounts that has no reports to be inserted</th>
<th  width=10%>Count Of accounts that has reports to be inserted</th>
<th width=10%>Number of records inserted</th>
<th width=10%>No. of clicks on the date</th>
<th width=10%>No. of impressions on the date</th>
</tr>";
	
	
	if(count($res2)<1){
		
		$html .= "<tr>
		<td>".date("Y-m")."</td>
		
		<td>ACCOUNT REPORT</td>
		<td>".$res1[0]['cnt']."</td>
		<td>0</td>
		
		<td>0</td>
		<td>0</td>
		<td>0</td>
		</tr>";
		
		
	}
	
	
	foreach($res2 as $r2){
		
		
		$zerocount = $res1[0]['cnt'] - $r2['sum'] ;
		$nozerocount = $r2['sum'] ;
		
		
		$html .= "<tr>
		<td>".$r2['ad_Month']."</td>
		
		<td>ACCOUNT REPORT</td>
		<td>".$zerocount."</td>
		<td>".$nozerocount."</td>
		
		<td>".$r2['rcords']."</td>
		<td>".$r2['ad_Clicks']."</td>
		<td>".$r2['ad_Impressions']."</td>
		</tr>";	
	}
	
	
	
	$res2 = $main->getResults("SELECT `adword_campaign_reports`.`ad_Date`,COUNT(ad_report_id) rcords,SUM(`ad_Clicks`) ad_Clicks,SUM(`ad_Impressions`) ad_Impressions ,COUNT(DISTINCT(`adword_campaign_reports`.ad_account_id)) sum FROM `adword_accounts` LEFT JOIN `adword_campaign_reports` on `adword_campaign_reports`.`ad_account_id`= `adword_accounts`.`ad_account_adword_id` WHERE `adword_campaign_reports`.`ad_Date` > '".$oldday."' and `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."' GROUP BY `adword_campaign_reports`.`ad_Date`,`adword_accounts`.`ad_mcc_id` ORDER BY `ad_Date` DESC",'ARRAY_A');

	
	if(count($res2)<1){
		
		$html .= "<tr bgcolor=red >
		<td>NO RECORD FOUND</td>
		
		<td>CAMPAIGN REPORT</td>
		<td>".$res1[0]['cnt']."</td>
		<td>0</td>
		
		<td>0</td>
		<td>0</td>
		<td>0</td>
		</tr>";
		
		
	}
	
	foreach($res2 as $r2){
		
		
		$zerocount = $res1[0]['cnt'] - $r2['sum'] ;
		$nozerocount = $r2['sum'] ;
		
		
		$html .= "<tr>
		<td>".$r2['ad_Date']."</td>
		
		<td>CAMPAIGN REPORT</td>
		<td>".$zerocount."</td>
		<td>".$nozerocount."</td>
		
		<td>".$r2['rcords']."</td>
		<td>".$r2['ad_Clicks']."</td>
		<td>".$r2['ad_Impressions']."</td>
		</tr>";	
	}
	
		
	$res2 = $main->getResults("SELECT `adword_keyword_report1`.`ad_Date`,COUNT(ad_report_id) rcords,SUM(`ad_Clicks`) ad_Clicks,SUM(`ad_Impressions`) ad_Impressions ,COUNT(DISTINCT(`adword_keyword_report1`.ad_account_id)) sum FROM `adword_accounts` LEFT JOIN `adword_keyword_report1` on `adword_keyword_report1`.`ad_account_id`= `adword_accounts`.`ad_account_adword_id` WHERE `adword_keyword_report1`.`ad_Date` > '".$oldday."' and `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."' GROUP BY `adword_keyword_report1`.`ad_Date`,`adword_accounts`.`ad_mcc_id` ORDER BY `ad_Date` DESC",'ARRAY_A');

	if(count($res2)<1){
		
		$html .= "<tr bgcolor=red >
		<td>NO RECORD FOUND</td>
		
		<td>KEYWORD REPORT</td>
		<td>".$res1[0]['cnt']."</td>
		<td>0</td>
		
		<td>0</td>
		<td>0</td>
		<td>0</td>
		</tr>";
		
		
	}
	
	foreach($res2 as $r2){
		
		
		$zerocount = $res1[0]['cnt'] - $r2['sum'] ;
		$nozerocount = $r2['sum'] ;
		
		
		$html .= "<tr>
		<td>".$r2['ad_Date']."</td>
		
		<td>KEYWORD REPORT</td>
		<td>".$zerocount."</td>
		<td>".$nozerocount."</td>
		
		<td>".$r2['rcords']."</td>
		<td>".$r2['ad_Clicks']."</td>
		<td>".$r2['ad_Impressions']."</td>
		</tr>";	
	}
	
	
			
	$res2 = $main->getResults("SELECT `adword_ad_reports`.`ad_Date`,COUNT(ad_report_id) rcords,SUM(`ad_Clicks`) ad_Clicks,SUM(`ad_Impressions`) ad_Impressions ,COUNT(DISTINCT(`adword_ad_reports`.ad_account_id)) sum FROM `adword_accounts` LEFT JOIN `adword_ad_reports` on `adword_ad_reports`.`ad_account_id`= `adword_accounts`.`ad_account_adword_id` WHERE `adword_ad_reports`.`ad_Date` > '".$oldday."' and `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."' GROUP BY `adword_ad_reports`.`ad_Date`,`adword_accounts`.`ad_mcc_id` ORDER BY `ad_Date` DESC",'ARRAY_A');

	
	if(count($res2)<1){
		
		$html .= "<tr bgcolor=red >
		<td>NO RECORD FOUND</td>
		
		<td>AD REPORT</td>
		<td>".$res1[0]['cnt']."</td>
		<td>0</td>
		
		<td>0</td>
		<td>0</td>
		<td>0</td>
		</tr>";
		
		
	}
	
	foreach($res2 as $r2){
		
		
		$zerocount = $res1[0]['cnt'] - $r2['sum'] ;
		$nozerocount = $r2['sum'] ;
		
		
		$html .= "<tr>
		<td>".$r2['ad_Date']."</td>
		
		<td>AD REPORT</td>
		<td>".$zerocount."</td>
		<td>".$nozerocount."</td>
		
		<td>".$r2['rcords']."</td>
		<td>".$r2['ad_Clicks']."</td>
		<td>".$r2['ad_Impressions']."</td>
		</tr>";	
	}
	
	$res2 = $main->getResults("SELECT `adword_search_query_reports`.`ad_Date`,COUNT(ad_report_id) rcords,SUM(`ad_Clicks`) ad_Clicks,SUM(`ad_Impressions`) ad_Impressions ,COUNT(DISTINCT(`adword_search_query_reports`.ad_account_id)) sum FROM `adword_accounts` LEFT JOIN `adword_search_query_reports` on `adword_search_query_reports`.`ad_account_id`= `adword_accounts`.`ad_account_adword_id` WHERE `adword_search_query_reports`.`ad_Date` > '".$oldday."' and `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."' GROUP BY `adword_search_query_reports`.`ad_Date`,`adword_accounts`.`ad_mcc_id` ORDER BY `ad_Date` DESC",'ARRAY_A');

	if(count($res2)<1){
		
		$html .= "<tr bgcolor=red >
		<td>NO RECORD FOUND</td>
		
		<td>SEARCH QUERY REPORT</td>
		<td>".$res1[0]['cnt']."</td>
		<td>0</td>
		
		<td>0</td>
		<td>0</td>
		<td>0</td>
		</tr>";
		
		
	}
	
	foreach($res2 as $r2){
		
		
		$zerocount = $res1[0]['cnt'] - $r2['sum'] ;
		$nozerocount = $r2['sum'] ;
		
		
		$html .= "<tr>
		<td>".$r2['ad_Date']."</td>
		
		<td>SEARCH QUERY REPORT</td>
		<td>".$zerocount."</td>
		<td>".$nozerocount."</td>
		
		<td>".$r2['rcords']."</td>
		<td>".$r2['ad_Clicks']."</td>
		<td>".$r2['ad_Impressions']."</td>
		</tr>";	
	}
	
	
	$res2 = $main->getResults("SELECT `adword_display_reports`.`ad_Date`,COUNT(ad_report_id) rcords,SUM(`ad_clicks`) ad_Clicks,SUM(`ad_impressions`) ad_Impressions ,COUNT(DISTINCT(`adword_display_reports`.ad_account_id)) sum FROM `adword_accounts` LEFT JOIN `adword_display_reports` on `adword_display_reports`.`ad_account_id`= `adword_accounts`.`ad_account_adword_id` WHERE `adword_display_reports`.`ad_Date` > '".$oldday."' and `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."' GROUP BY `adword_display_reports`.`ad_Date`,`adword_accounts`.`ad_mcc_id` ORDER BY `ad_Date` DESC",'ARRAY_A');

	if(count($res2)<1){
		
		$html .= "<tr bgcolor=red >
		<td>NO RECORD FOUND</td>
		
		<td>DISPLAY REPORT</td>
		<td>".$res1[0]['cnt']."</td>
		<td>0</td>
		
		<td>0</td>
		<td>0</td>
		<td>0</td>
		</tr>";
		
		
	}
	
	foreach($res2 as $r2){
		
		
		$zerocount = $res1[0]['cnt'] - $r2['sum'] ;
		$nozerocount = $r2['sum'] ;
		
		
		$html .= "<tr>
		<td>".$r2['ad_Date']."</td>
		
		<td>DISPLAY REPORT</td>
		<td>".$zerocount."</td>
		<td>".$nozerocount."</td>
		
		<td>".$r2['rcords']."</td>
		<td>".$r2['ad_Clicks']."</td>
		<td>".$r2['ad_Impressions']."</td>
		</tr>";	
	}

	$html.="</table>"; 

	$html .="<h3>Duplicate Entry Report </h3>";


	$html .= "<br/><table border=1 style=\"border-collapse : collapse ; border:1px #CCC solid;\">";

	$html .= "<tr><th>REPORT NAME</th><th>No Of DUPLICATE ENTRIES</th><th>Time Period</th></tr>";

	$d_acr = getDuplicateNo(5); if($d_acr) $color = "red" ; else $color = "white" ;
	$d_cr = getDuplicateNo(2); if($d_cr) $color1 = "red" ; else $color1 = "white" ;
	$d_kr = getDuplicateNo(1); if($d_kr) $color2 = "red" ; else $color2 = "white" ;
	$d_ar = getDuplicateNo(3); if($d_ar) $color3 = "red" ; else $color3 = "white" ;
	$d_sr = getDuplicateNo(4); if($d_sr) $color4 = "red" ; else $color4 = "white" ;
	$d_dr = getDuplicateNo(6); if($d_dr) $color5 = "red" ; else $color5 = "white" ;

	$html .= "<tr bgcolor='".$color."'><td>ACCOUNT REPORT</td><td>".$d_acr."</td><td>Last 6 months</td></tr>";
	$html .= "<tr bgcolor='".$color1."'><td>CAMPAIGN REPORT</td><td>".$d_cr."</td><td>Last 7 days</td></tr>";
	$html .= "<tr bgcolor='".$color2."'><td>KEYWORD REPORT</td><td>".$d_kr."</td><td>Last 7 days</td></tr>";
	$html .= "<tr bgcolor='".$color3."'><td>AD REPORT</td><td>".$d_ar."</td><td>Last 7 days</td></tr>";
	$html .= "<tr bgcolor='".$color4."'><td>SEARCH QUERY REPORT</td><td>".$d_sr."</td><td>Last 7 days</td></tr>";
	$html .= "<tr bgcolor='".$color5."'><td>DISPLAY REPORT</td><td>".$d_dr."</td><td>Last 7 days</td></tr>";

	$html.="</table>";


	$html .="<h3>Flag reports in UI with no values</h3>";

	$html .= "<br/><table border=1 style=\"border-collapse : collapse ; border:1px #CCC solid;\">";

	$html .= "<tr><th width='15%'>REPORT NAME</th><th width='15%'>No of accounts Having Report</th><th  width='60%'>Accounts not having report</th></tr>";
	
	//MONTHLY REPORT
	
	$sql = "select COUNT(B.ad_account_id) as hasreports , group_concat(if(B.ad_account_id IS NULL, `ad_account_adword_id`, null) separator ', ') hasnoreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_adword_id`) ad_account_id FROM `adword_monthly_report` WHERE `ad_month` > '2015-12' GROUP BY ad_account_adword_id ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND  `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."' ";
	
	$res = $main -> getRow($sql,'ARRAY_A') ;
	
	$html .= "<tr><td>MONTHLY REPORT</td><td>".$res['hasreports']."</td><td>".$res['hasnoreports']."</td></tr>";
	
	 $startDate = date("Y-m-d", strtotime("-30 days"));  
    $endDate =  date("Y-m-d", strtotime("-1 days"));

	//AD SHAREGAP IDENTIFIER
	
	$sql = "SELECT COUNT(B.ad_account_id) as hasreports ,group_concat(if(B.ad_account_id IS NULL, `ad_account_adword_id`, null) separator ', ') hasnoreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT( `ad_account_id`) `ad_account_id` FROM (SELECT `ad_account_id` , AVG(ad_SearchImpressionShare) as ad_SIS1 ,SUM(`ad_Impressions`) ad_Imprs FROM `adword_campaign_reports` WHERE `ad_Date` BETWEEN '$startDate' AND '$endDate' AND ad_SearchImpressionShare NOT LIKE '%--%' and ad_SearchImpressionShare NOT LIKE '%< 10%' group by `ad_CampaignId` HAVING ad_SIS1 < 80 and ad_SIS1 <> 0 AND ad_Imprs > 10 ) C ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1  AND  `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."' ";
		
	$res = $main -> getRow($sql,'ARRAY_A') ;
	
	
	$html .= "<tr><td>AD SHAREGAP IDENTIFIER</td><td>".$res['hasreports']."</td><td>".$r['hasnoreports']."</td></tr>";
	
	//CONVERSION BOOSTER REPORTS
	
	$sql = "SELECT COUNT(B.ad_account_id) as hasreports ,group_concat(if(B.ad_account_id IS NULL, `ad_account_adword_id`, null) separator ', ') hasnoreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."' ";
 
	$res = $main -> getRow($sql,'ARRAY_A') ;
	
	$html .= "<tr><td>CONVERSION BOOSTER REPORTS</td><td>".$res['hasreports']."</td><td>".$res['hasnoreports']."</td></tr>";  
	
	//80/20 CONVERSIONS

	$sql = "SELECT COUNT(B.ad_account_id) as hasreports ,group_concat(if(B.ad_account_id IS NULL, `ad_account_adword_id`, null) separator ', ') hasnoreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."' order by ad_account_adword_id asc";
	
 
	$res = $main -> getRow($sql,'ARRAY_A') ;
	
	$html .= "<tr><td>80/20 CONVERSIONS</td><td>".$res['hasreports']."</td><td>".$res['hasnoreports']."</td></tr>";  
	
	// 1 ADVERT ALERT
	
	$sql = "SELECT COUNT(B.ad_account_id) as hasreports ,group_concat(if(B.ad_account_id IS NULL, `ad_account_adword_id`, null) separator ', ') hasnoreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."'  order by ad_account_adword_id desc ";
	 
	$res = $main -> getRow($sql,'ARRAY_A') ;
	
	$html .= "<tr><td>1 ADVERT ALERT</td><td>".$res['hasreports']."</td><td>".$res['hasnoreports']."</td></tr>";  
	
	
	// 1 AD LABEL REPORT
	
	$sql = "SELECT COUNT(B.ad_account_id) as hasreports ,group_concat(if(B.ad_account_id IS NULL, `ad_account_adword_id`, null) separator ', ') hasnoreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."' ";
	 
	$res = $main -> getRow($sql,'ARRAY_A') ;
	
	$html .= "<tr><td>AD LABEL REPORT</td><td>".$res['hasreports']."</td><td>".$res['hasnoreports']."</td></tr>";  
	
	//AD PERFORMANCE ALERT
	
	$sql = "SELECT COUNT(B.ad_account_id) as hasreports ,group_concat(if(B.ad_account_id IS NULL, `ad_account_adword_id`, null) separator ', ') hasnoreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."'  order by ad_account_adword_id asc";
	 
	$res = $main -> getRow($sql,'ARRAY_A') ;
	
	$html .= "<tr><td>AD PERFORMANCE ALERT</td><td>".$res['hasreports']."</td><td>".$res['hasnoreports']."</td></tr>";  
	
	//LOW AD EXTENSION
	
	$sql = "SELECT COUNT(B.ad_account_id) as hasreports ,group_concat(if(B.ad_account_id IS NULL, `ad_account_adword_id`, null) separator ', ') hasnoreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."'  order by ad_account_adword_id desc ";
	 
	$res = $main -> getRow($sql,'ARRAY_A') ;
	
	$html .= "<tr><td>LOW AD EXTENSION</td><td>".$res['hasreports']."</td><td>".$res['hasnoreports']."</td></tr>";  
	
	//WASTAGE ANALYSIS
	
	$sql = "SELECT COUNT(B.ad_account_id) as hasreports ,group_concat(if(B.ad_account_id IS NULL, `ad_account_adword_id`, null) separator ', ') hasnoreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."' ";
	 
	$res = $main -> getRow($sql,'ARRAY_A') ;
	
	$html .= "<tr><td>WASTAGE ANALYSIS</td><td>".$res['hasreports']."</td><td>".$res['hasnoreports']."</td></tr>";  
	
	
	//KEYWORD DISCOVERY
	
	$sql = "SELECT COUNT(B.ad_account_id) as hasreports ,group_concat(if(B.ad_account_id IS NULL, `ad_account_adword_id`, null) separator ', ') hasnoreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."' ";
	 
	$res = $main -> getRow($sql,'ARRAY_A') ;
	
	$html .= "<tr><td>KEYWORD DISCOVERY</td><td>".$res['hasreports']."</td><td>".$res['hasnoreports']."</td></tr>";  
	
	
	//QUALITY SCORE MANAGEMENT
	
	$sql = "SELECT COUNT(B.ad_account_id) as hasreports ,group_concat(if(B.ad_account_id IS NULL, `ad_account_adword_id`, null) separator ', ') hasnoreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."'  order by ad_account_adword_id asc ";
	 
	$res = $main -> getRow($sql,'ARRAY_A') ;
	
	$html .= "<tr><td>QUALITY SCORE MANAGEMENT</td><td>".$res['hasreports']."</td><td>".$res['hasnoreports']."</td></tr>";  
	
	
	//MATCH TYPE OVERVIEW
	
	$sql = "SELECT COUNT(B.ad_account_id) as hasreports ,group_concat(if(B.ad_account_id IS NULL, `ad_account_adword_id`, null) separator ', ') hasnoreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."'  order by ad_account_adword_id desc";
	 
	$res = $main -> getRow($sql,'ARRAY_A') ;
	
	$html .= "<tr><td>MATCH TYPE OVERVIEW</td><td>".$res['hasreports']."</td><td>".$res['hasnoreports']."</td></tr>";  
	
	
	//DEVICE PERFORMANCE
	
	$sql = "SELECT COUNT(B.ad_account_id) as hasreports ,group_concat(if(B.ad_account_id IS NULL, `ad_account_adword_id`, null) separator ', ') hasnoreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."' ";
	 
	$res = $main -> getRow($sql,'ARRAY_A') ;
	
	$html .= "<tr><td>DEVICE PERFORMANCE</td><td>".$res['hasreports']."</td><td>".$res['hasnoreports']."</td></tr>";  
	
	
	
	//KEYWORD MATCH TYPE PERFORMANCE
	
	$sql = "SELECT COUNT(B.ad_account_id) as hasreports ,group_concat(if(B.ad_account_id IS NULL, `ad_account_adword_id`, null) separator ', ') hasnoreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."'  order by ad_account_adword_id desc";
	 
	$res = $main -> getRow($sql,'ARRAY_A') ;
	
	$html .= "<tr><td>KEYWORD MATCH TYPE PERFORMANCE</td><td>".$res['hasreports']."</td><td>".$res['hasnoreports']."</td></tr>";  
	
	$html .="</table>";

}


// Daily Projections Report

$html .="<h3>Daily Projections</h3>";

$html .= "<br/><table border=1 style=\"border-collapse : collapse ; border:1px #CCC solid;\">";

$html .= "<tr><th>REPORT NAME</th><th>Last Updated</th></tr>";

$sql = "SELECT CASE WHEN DATE(`datentime`) = DATE(NOW()) THEN 1 ELSE 0 END report , `datentime` from ".DB_DATABASE.".management_daily_report order by datentime desc limit 1";

$res = $main -> getRow($sql,'ARRAY_A');

if($res['report']==1){$html .= "<tr><td>Daily Report</td><td>".$res['datentime']."</td></tr>";}
else{$html .= "<tr bgcolor='#D00'><td>Daily Report</td><td>".$res['datentime']."</td></tr>";}

$sql = "SELECT CASE WHEN DATE(`datentime`) = DATE(NOW()) THEN 1 ELSE 0 END report ,`datentime` from ".DB_DATABASE.".management_summery_report order by datentime desc limit 1";

$res = $main -> getRow($sql,'ARRAY_A');

if($res['report']==1){$html .= "<tr><td>Summery Report</td><td>".$res['datentime']."</td></tr>";}
else{$html .= "<tr bgcolor='#D00'><td>Summery Report</td><td>".$res['datentime']."</td></tr>";}

$html.="</table>";

$output = shell_exec("df -H") ;

$output = explode("\n",$output);
$output = explode(" ",$output[1]);

$used = $output[count($output)-2];


$html .= "<h3>Alert : disk space usage $used <h3>";


//Create a new PHPMailer instance
$mail = new PHPMailer;

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;

//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "anruthathilakan@gmail.com";

//Password to use for SMTP authentication
$mail->Password = "vBridge1";

//Set who the message is to be sent from
$mail->setFrom('anruthathilakan@gmail.com', 'Vbridge Info');

//Set an alternative reply-to address
$mail->addReplyTo('anruthathilakan@gmail.com', 'Vbridge Info');

//Set who the message is to be sent to
$mail->addAddress('rdvarmaa@gmail.com', 'Deepa Varma');
$mail->addAddress('muralihere@gmail.com', 'Murali Mohan');

//Set the subject line
$mail->Subject = 'Report / Entity downloading Test Results ';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML($html, dirname(__FILE__));

//Replace the plain text body with one created manually
$mail->AltBody = 'This is the Report / Entity downloading Test Results';

//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}









function getDuplicateNo($type){
	
	global $main ;
	
	$date = date("Y-m-d",strtotime("-7 days"));
	
	if($type==1){
	
		// keyword report
		
		$sql = "SELECT count(*) cnt , count(distinct(CONCAT(`ad_account_id`,`ad_CampaignId`,`ad_AdGroupId`,`ad_Keyword_Id`,`ad_Clicks`,`ad_Impressions`,`ad_Cost`,`ad_Conversions`,`ad_ConversionRate`,`ad_CostPerConversion`,`ad_Ctr`,`ad_AveragePosition`,`ad_FirstPageCpc`,`ad_TopOfPageCpc`,`ad_Device`,`ad_KeywordMatchType`))) dist , ad_Date FROM `adword_keyword_report1` WHERE `ad_Date` > '".$date."' group by `ad_Date` having cnt <> dist order by ad_Date desc";
		
	}
	elseif($type==2){
	
		//campaign
		
		$sql = "SELECT count(*) cnt , COUNT(DISTINCT(CONCAT(`ad_account_id`,`ad_CampaignId`,`ad_Clicks`,`ad_Impressions`,`ad_ExpImpressions`,`ad_Cost`,`ad_Conversions`,`ad_ConversionRate`,`ad_CostPerConversion`,`ad_Ctr`,`ad_AveragePosition`,`ad_ConversionValue`,`ad_AverageCpc`,`ad_DayOfWeek`,`ad_HourOfDay`,`ad_SearchImpressionShare`))) dist , `ad_Date` FROM `adword_campaign_reports` WHERE `ad_Date` >'".$date."' GROUP BY `ad_Date` HAVING cnt <> dist order by ad_Date desc";
	}
	
	elseif($type==3){
	
		//ad
		
		$sql = "SELECT count(*) cnt , count(distinct(CONCAT(`ad_account_id`,`ad_CampaignId`,`ad_AdGroupId`,`ad_Id`,`ad_AdType`,`ad_Clicks`,`ad_Impressions`,`ad_Cost`,`ad_Conversions`,`ad_ConversionRate`,`ad_Ctr`,`ad_ConversionValue`,`ad_Device`))) dist , ad_Date FROM `adword_ad_reports` WHERE `ad_Date` > '".$date."' group by `ad_Date` having cnt <> dist order by ad_Date desc";
	}
	
	elseif($type==4){
		
		$sql = "SELECT count(*) cnt , count(distinct(CONCAT(`ad_account_id`,`ad_CampaignId`,`ad_AdGroupId`,`ad_KeywordId`,`ad_CreativeId`,`ad_Query`,`ad_Clicks`,`ad_Impressions`,`ad_Cost`,`ad_Ctr`,`ad_Conversions`,`ad_CostPerConversion`,`ad_AveragePosition`,`ad_ConversionValue`,`ad_MatchType`,`ad_Device`,`ad_KeywordTextMatchingQuery`))) dist , ad_Date FROM `adword_search_query_reports` WHERE `ad_Date` > '".$date."' group by `ad_Date` having cnt <> dist  order by ad_Date desc";
	}
	elseif($type==6){
		
		$sql = "SELECT count(*) cnt , count(distinct(CONCAT(`ad_account_id`, `ad_campaign_id`, `ad_adgroup_id`, `ad_clicks`, `ad_impressions`, `ad_cost`, `ad_conversions`, `ad_campaign_name`, `ad_adgroup_name`, `ad_domain`, `ad_url`, `ad_criteria_parameters`,`ad_formats`))) dist , ad_Date FROM `adword_display_reports` WHERE `ad_Date` > '".$date."' group by `ad_Date` having cnt <> dist order by ad_Date desc";
	}
	
	elseif($type==5){
		//account
		
		$sql = "SELECT count(*) cnt , count(distinct(CONCAT(`ad_account_adword_id`,`ad_Clicks`,`ad_Impressions`,`ad_Cost`,`ad_Ctr`,`ad_AverageCpc`,`ad_ConversionRate`,`ad_Conversions`,`ad_CostPerConversion`,`ad_ConversionValue`,`ad_EstimatedTotalConversions`,`ad_SearchImpressionShare`))) dist , `ad_month` FROM `adword_monthly_report`  group by `ad_month` having cnt <> dist order by `ad_month` desc limit 6";
	}
	
	$res = $main->getResults($sql);

	if(count($res)){return 1;}
	else{return 0 ;}
	
	
}

?>
