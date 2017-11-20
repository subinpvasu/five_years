<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once dirname(__FILE__) . '/../includes/includes.php';
require_once dirname(__FILE__) . '/smtp/PHPMailerAutoload.php';

$last_friday =  date('Y-m-d',strtotime("-10 days")); // Assuming mail is to be sent on Friday 
$last_thursday =  date('Y-m-d',strtotime("-4 days"));

$last_friday_text =  date('d-M-Y',strtotime("-10 days")); // Assuming mail is to be sent on Friday 
$last_thursday_text =  date('d-M-Y',strtotime("-4 days"));

$this_month = date('Y-m');
    
$body = ""; 

$name = 'Monique';//trim($_REQUEST['email_to_name']) ; 

$email_to = trim($_REQUEST['email_to']) ;

$email_to_cc = trim($_REQUEST['email_to_cc']) ;

$covering_writeup = trim($_REQUEST['$covering_writeup']) ;

$covering_writeup = "Push Analyser is working good. There are no issues we are aware of. Please see the last week report for downloading reports and entities below:";


//echo "$last_friday && $last_thursday" ;

$covering .= "<table border=0 width=\"90%\">";

$covering .= "<tr><td>Hi ".$name." , </td></tr><tr><td>&nbsp;</td></tr>";

$covering .= "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ".$covering_writeup."</td></tr></table>";

$closure .= "<table border=0 width=\"90%\"><tr><td>Thank you</td></tr><tr><td>Push Analyser App Development Team</td></tr></table>";

$res = $main -> getResults("SELECT customerId,prospect_account,descriptiveName FROM adword_mcc_accounts WHERE prospect_account <> 10;",'ARRAY_A');

foreach($res as $r){		
	
    if($r['prospect_account'] ==0) { $dbName = DB_DATABASE ; }
    
    else{ $dbName = DB_DATABASE_PROSPECT ; }

    $main -> Select($dbName) ;
        
    $subject = "Push Analyser : Weekly report for ".$r['descriptiveName']."(".$r['customerId'].") from ".$last_friday_text." to ".$last_thursday_text.".";
    
    $html = "<h3>MCC Account</h3>";
    
    $html .= "<table border=1 style=\"border-collapse : collapse ; border:1px #CCC solid;\" width=\"90%\">";
    
    $html .= "<tr><th width='30%'>MCC ID</th><th width='40%'>Name of MCC</th><th  width='30%'>Total Number of Enabled Accounts</th></tr>";
    
    $res1 = $main->getResults("SELECT COUNT(`ad_account_id`) cnt FROM `adword_accounts` WHERE `adword_accounts`.ad_mcc_id = '".$r['customerId']."' AND ad_account_status=1 and ad_delete_status =0  ",'ARRAY_A');
    
    $html .= "<tr bgcolor ='#DDD' ><td>".$r['customerId']."</td><td>".$r['descriptiveName']."</td><td>".$res1[0]['cnt']."</td></tr>";
    
    $html .="</table>";
    
    $html .= "<h3>Overview of reports downloaded</h3>";
    
    $html .= "<table border=1 style=\"border-collapse : collapse ; border:1px #CCC solid;\" width=\"90%\">";
    
    $html .= "<tr><th width='30%'>Report name</th><th width='15%'>No. of accounts having reports</th><th  width='15%'>No. of accounts not having reports</th><th width='10%'>No. of records</th><th width='10%'>No. of clicks</th><th  width='10%'>No. of impressions</th><th width='10%'>No. of duplicate entries</th></tr>";
    
    $res1 = $main->getRow("SELECT COUNT(`ad_account_id`) cnt FROM `adword_accounts` WHERE `adword_accounts`.ad_mcc_id = '".$r['customerId']."' AND ad_account_status=1 and ad_delete_status =0  ");
    
    $res2 = $main->getRow("SELECT `adword_monthly_report`.`ad_Month`,COUNT(ad_report_id) records,SUM(`ad_Clicks`) clicks,SUM(`ad_Impressions`) impressions ,COUNT(DISTINCT(`adword_monthly_report`.`ad_account_adword_id`)) sum FROM `adword_accounts` LEFT JOIN `adword_monthly_report` on `adword_monthly_report`.`ad_account_adword_id`= `adword_accounts`.`ad_account_adword_id` WHERE `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."' and `adword_monthly_report`.`ad_month` ='".$this_month."' GROUP BY `adword_accounts`.`ad_mcc_id` ;");
    
    //echo "<pre>"; print_r($res2);
    
    $having = $res2-> sum ? $res2-> sum : 0 ;
    
    $nothaving = $res1 -> cnt - $res2-> sum  ? $res1 -> cnt - $res2-> sum : 0 ;
    
    $records = $res2-> records ? $res2-> records : 0;
    
    $clicks = $res2-> clicks ? $res2-> clicks : 0;
    
    $impressions = $res2-> impressions ? $res2-> impressions : 0;
    
    $duplicates =  getDuplicateNo(5);
    
    $html .= "<tr bgcolor ='#DDD'><td>ACCOUNT REPORT</td><td>".$having."</td><td>".$nothaving."</td><td>".$records."</td><td>".$clicks."</td><td>".$impressions."</td><td>".$duplicates."</td></tr>";
        
    $res2 = $main->getRow("SELECT `ad_Date`,COUNT(ad_report_id) records,SUM(`ad_Clicks`) clicks,SUM(`ad_Impressions`) impressions ,COUNT(DISTINCT(`adword_campaign_reports`.ad_account_id)) sum FROM `adword_accounts` LEFT JOIN `adword_campaign_reports` on `adword_campaign_reports`.`ad_account_id`= `adword_accounts`.`ad_account_adword_id` WHERE `adword_campaign_reports`.`ad_Date` BETWEEN '".$last_friday."' AND '".$last_thursday."' and  `adword_accounts`.`ad_mcc_id` = '".$r['customerId']."' GROUP BY  `ad_mcc_id` ;");
    
    //echo "<pre>"; print_r($res2);
    
    $having = $res2-> sum ? $res2-> sum : 0 ;
    
    $nothaving = $res1 -> cnt - $res2-> sum  ? $res1 -> cnt - $res2-> sum : 0 ;
    
    $records = $res2-> records ? $res2-> records : 0;
    
    $clicks = $res2-> clicks ? $res2-> clicks : 0;
    
    $impressions = $res2-> impressions ? $res2-> impressions : 0;
    
    $duplicates =  getDuplicateNo(2);    
    
    $html .= "<tr><td>CAMPAIGN REPORT</td><td>".$having."</td><td>".$nothaving."</td><td>".$records."</td><td>".$clicks."</td><td>".$impressions."</td><td>".$duplicates."</td></tr>";
    
    $res2 = $main->getRow("SELECT `ad_Date`,COUNT(ad_report_id) records,SUM(`ad_Clicks`) clicks,SUM(`ad_Impressions`) impressions ,COUNT(DISTINCT(`adword_campaign_reports`.ad_account_id)) sum FROM `adword_accounts` LEFT JOIN `adword_campaign_reports` on `adword_campaign_reports`.`ad_account_id`= `adword_accounts`.`ad_account_adword_id` WHERE `adword_campaign_reports`.`ad_Date` BETWEEN '".$last_friday."' AND '".$last_thursday."' and  `adword_accounts`.`ad_mcc_id` = '".$r['customerId']."' GROUP BY  `ad_mcc_id` ;");
    
    //echo "<pre>"; print_r($res2);
    
    $having = $res2-> sum ? $res2-> sum : 0 ;
    
    $nothaving = $res1 -> cnt - $res2-> sum  ? $res1 -> cnt - $res2-> sum : 0 ;
    
    $records = $res2-> records ? $res2-> records : 0;
    
    $clicks = $res2-> clicks ? $res2-> clicks : 0;
    
    $impressions = $res2-> impressions ? $res2-> impressions : 0;
    
    $duplicates =  getDuplicateNo(1);
    
    $html .= "<tr bgcolor ='#DDD'><td>KEYWORD REPORT</td><td>".$having."</td><td>".$nothaving."</td><td>".$records."</td><td>".$clicks."</td><td>".$impressions."</td><td>".$duplicates."</td></tr>";
    
    $res2 = $main->getRow("SELECT `ad_Date`,COUNT(ad_report_id) records,SUM(`ad_Clicks`) clicks,SUM(`ad_Impressions`) impressions ,COUNT(DISTINCT(`adword_ad_reports`.ad_account_id)) sum FROM `adword_accounts` LEFT JOIN `adword_ad_reports` on `adword_ad_reports`.`ad_account_id`= `adword_accounts`.`ad_account_adword_id` WHERE `adword_ad_reports`.`ad_Date`  BETWEEN '".$last_friday."' AND '".$last_thursday."' and `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."' GROUP BY  `adword_accounts`.`ad_mcc_id` ;");
    
    //echo "<pre>"; print_r($res2);
    
    $having = $res2-> sum ? $res2-> sum : 0 ;
    
    $nothaving = $res1 -> cnt - $res2-> sum  ? $res1 -> cnt - $res2-> sum : 0 ;
    
    $records = $res2-> records ? $res2-> records : 0;
    
    $clicks = $res2-> clicks ? $res2-> clicks : 0;
    
    $impressions = $res2-> impressions ? $res2-> impressions : 0;
    
    $duplicates =  getDuplicateNo(3);   
    
    $html .= "<tr><td>AD REPORT</td><td>".$having."</td><td>".$nothaving."</td><td>".$records."</td><td>".$clicks."</td><td>".$impressions."</td><td>".$duplicates."</td></tr>";
    
    $res2 = $main->getRow("SELECT `ad_Date`,COUNT(ad_report_id) records,SUM(`ad_clicks`) clicks,SUM(`ad_impressions`) impressions ,COUNT(DISTINCT(`adword_display_reports`.ad_account_id)) sum FROM `adword_accounts` LEFT JOIN `adword_display_reports` on `adword_display_reports`.`ad_account_id`= `adword_accounts`.`ad_account_adword_id` WHERE `adword_display_reports`.`ad_Date` BETWEEN '".$last_friday."' AND '".$last_thursday."' and `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."' GROUP BY `adword_accounts`.`ad_mcc_id` ;");
    
    //echo "<pre>"; print_r($res2);
    
    $having = $res2-> sum ? $res2-> sum : 0 ;
    
    $nothaving = $res1 -> cnt - $res2-> sum  ? $res1 -> cnt - $res2-> sum : 0 ;
    
    $records = $res2-> records ? $res2-> records : 0;
    
    $clicks = $res2-> clicks ? $res2-> clicks : 0;
    
    $impressions = $res2-> impressions ? $res2-> impressions : 0;
    
    $duplicates =  getDuplicateNo(6); 
    
    $html .= "<tr bgcolor ='#DDD'><td>DISPLAY REPORT</td><td>".$having."</td><td>".$nothaving."</td><td>".$records."</td><td>".$clicks."</td><td>".$impressions."</td><td>".$duplicates."</td></tr>";
    
    $res2 = $main->getRow("SELECT `ad_Date`,COUNT(ad_report_id) records,SUM(`ad_Clicks`) clicks,SUM(`ad_Impressions`) impressions ,COUNT(DISTINCT(`adword_search_query_reports`.ad_account_id)) sum FROM `adword_accounts` LEFT JOIN `adword_search_query_reports` on `adword_search_query_reports`.`ad_account_id`= `adword_accounts`.`ad_account_adword_id` WHERE `adword_search_query_reports`.`ad_Date` BETWEEN '".$last_friday."' AND '".$last_thursday."' and `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."' GROUP BY `adword_accounts`.`ad_mcc_id`; ");
    
    //echo "<pre>"; print_r($res2);
    
    $having = $res2-> sum ? $res2-> sum : 0 ;
    
    $nothaving = $res1 -> cnt - $res2-> sum  ? $res1 -> cnt - $res2-> sum : 0 ;
    
    $records = $res2-> records ? $res2-> records : 0;
    
    $clicks = $res2-> clicks ? $res2-> clicks : 0;
    
    $impressions = $res2-> impressions ? $res2-> impressions : 0;
    
    $duplicates =  getDuplicateNo(4); 
    
    
    $html .= "<tr><td>SEARCH QUERY REPORT</td><td>".$having."</td><td>".$nothaving."</td><td>".$records."</td><td>".$clicks."</td><td>".$impressions."</td><td>".$duplicates."</td></tr>";
      
    $html .="</table>";
    
    $startDate = date("Y-m-d", strtotime("-30 days"));  
    
    $endDate =  date("Y-m-d", strtotime("-1 days"));
    
    $html .= "<h3>Overview of reports in UI</h3>";
    
    $html .= "<table border=1 style=\"border-collapse : collapse ; border:1px #CCC solid;\" width=\"90%\">";
    
    $html .= "<tr><th width='40%'>Report name</th><th width='30%'>No. of accounts having report</th><th  width='30%'>No. of accounts not having report</th></tr>";
    
    $res2 = $main->getRow("select COUNT(B.ad_account_id) as hasreports  FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_adword_id`) ad_account_id FROM `adword_monthly_report` WHERE `ad_month` = '".$this_month."' GROUP BY ad_account_adword_id ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND  `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."' ;");
    
    $hasreports = $res2 -> hasreports ; $hasnoreports = $res1 -> cnt - $res2 -> hasreports ;
    
    $html .= "<tr bgcolor ='#DDD' ><td>MONTHLY REPORT</td><td>".$hasreports."</td><td>".$hasnoreports."</td></tr>";
    
    $res2 = $main->getRow("SELECT COUNT(B.ad_account_id) as hasreports  FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT( `ad_account_id`) `ad_account_id` FROM (SELECT `ad_account_id` , AVG(ad_SearchImpressionShare) as ad_SIS1 ,SUM(`ad_Impressions`) ad_Imprs FROM `adword_campaign_reports` WHERE `ad_Date` BETWEEN '$startDate' AND '$endDate' AND ad_SearchImpressionShare NOT LIKE '%--%' and ad_SearchImpressionShare NOT LIKE '%< 10%' group by `ad_CampaignId` HAVING ad_SIS1 < 80 and ad_SIS1 <> 0 AND ad_Imprs > 10 ) C ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1  AND  `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."';");
    
    $hasreports = $res2 -> hasreports ; $hasnoreports = $res1 -> cnt - $res2 -> hasreports ;
    
    $html .= "<tr><td>AD SHAREGAP IDENTIFIER</td><td>".$hasreports."</td><td>".$hasnoreports."</td></tr>";
    
    $res2 = $main->getRow("SELECT COUNT(B.ad_account_id) as hasreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."';");
    
    $hasreports = $res2 -> hasreports ; $hasnoreports = $res1 -> cnt - $res2 -> hasreports ;
    
    $html .= "<tr bgcolor ='#DDD' ><td>CONVERSION BOOSTER REPORTS</td><td>".$hasreports."</td><td>".$hasnoreports."</td></tr>";
    
    $res2 = $main->getRow("SELECT COUNT(B.ad_account_id) as hasreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."';");
    
    $hasreports = $res2 -> hasreports ; $hasnoreports = $res1 -> cnt - $res2 -> hasreports ;
    
    $html .= "<tr><td>80/20 CONVERSIONS</td><td>".$hasreports."</td><td>".$hasnoreports."</td></tr>";
    
    $res2 = $main->getRow("SELECT COUNT(B.ad_account_id) as hasreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."';");
    
    $hasreports = $res2 -> hasreports ; $hasnoreports = $res1 -> cnt - $res2 -> hasreports ;
        
    $html .= "<tr bgcolor ='#DDD' ><td>1 ADVERT ALERT</td><td>".$hasreports."</td><td>".$hasnoreports."</td></tr>";
    
    $res2 = $main->getRow("SELECT COUNT(B.ad_account_id) as hasreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."';");
    
    $hasreports = $res2 -> hasreports ; $hasnoreports = $res1 -> cnt - $res2 -> hasreports ;
    
    $html .= "<tr><td>AD LABEL REPORT</td><td>".$hasreports."</td><td>".$hasnoreports."</td></tr>";
    
    $res2 = $main->getRow("SELECT COUNT(B.ad_account_id) as hasreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."'  order by ad_account_adword_id asc;");
    
    $hasreports = $res2 -> hasreports ; $hasnoreports = $res1 -> cnt - $res2 -> hasreports ;
    
    $html .= "<tr bgcolor ='#DDD' ><td>AD PERFORMANCE ALERT</td><td>".$hasreports."</td><td>".$hasnoreports."</td></tr>";
    
    $res2 = $main->getRow("SELECT COUNT(B.ad_account_id) as hasreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."'  order by ad_account_adword_id desc;");
    
    $hasreports = $res2 -> hasreports ; $hasnoreports = $res1 -> cnt - $res2 -> hasreports ;
    
    $html .= "<tr><td>LOW AD EXTENSION</td><td>".$hasreports."</td><td>".$hasnoreports."</td></tr>";
    
    $res2 = $main->getRow("SELECT COUNT(B.ad_account_id) as hasreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."';");
    
    $hasreports = $res2 -> hasreports ; $hasnoreports = $res1 -> cnt - $res2 -> hasreports ;
    
    $html .= "<tr bgcolor ='#DDD' ><td>WASTAGE ANALYSIS</td><td>".$hasreports."</td><td>".$hasnoreports."</td></tr>";
    
    $res2 = $main->getRow("SELECT COUNT(B.ad_account_id) as hasreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."';");
    
    $hasreports = $res2 -> hasreports ; $hasnoreports = $res1 -> cnt - $res2 -> hasreports ;
    
    $html .= "<tr><td>KEYWORD DISCOVERY</td><td>".$hasreports."</td><td>".$hasnoreports."</td></tr>";
    
    $res2 = $main->getRow("SELECT COUNT(B.ad_account_id) as hasreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."'  order by ad_account_adword_id asc ;");
    
    $hasreports = $res2 -> hasreports ; $hasnoreports = $res1 -> cnt - $res2 -> hasreports ;
    
    $html .= "<tr bgcolor ='#DDD' ><td>QUALITY SCORE MANAGEMENT</td><td>".$hasreports."</td><td>".$hasnoreports."</td></tr>";
    
    $res2 = $main->getRow("SELECT COUNT(B.ad_account_id) as hasreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."'");
    
    $hasreports = $res2 -> hasreports ; $hasnoreports = $res1 -> cnt - $res2 -> hasreports ;
    
    $html .= "<tr><td>MATCH TYPE OVERVIEW</td><td>".$hasreports."</td><td>".$hasnoreports."</td></tr>";
    
    $res2 = $main->getRow("SELECT COUNT(B.ad_account_id) as hasreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."'");
    
    $hasreports = $res2 -> hasreports ; $hasnoreports = $res1 -> cnt - $res2 -> hasreports ;
    
    $html .= "<tr bgcolor ='#DDD' ><td>DEVICE PERFORMANCE</td><td>".$hasreports."</td><td>".$hasnoreports."</td></tr>";
    
    $res2 = $main->getRow("SELECT COUNT(B.ad_account_id) as hasreports FROM `adword_accounts` LEFT JOIN (SELECT DISTINCT(`ad_account_id`) ad_account_id FROM adword_ConversionBoosterReport WHERE ad_CBreport_type='1' and ad_Month LIKE '".date('Y-m')."%' ) B ON `ad_account_adword_id` = B.ad_account_id WHERE `adword_accounts`.`ad_delete_status`=0 AND `adword_accounts`.`ad_account_status`=1 AND `adword_accounts`.`ad_mcc_id` ='".$r['customerId']."'  order by ad_account_adword_id desc ;");
    
    $hasreports = $res2 -> hasreports ; $hasnoreports = $res1 -> cnt - $res2 -> hasreports ;
    
    $html .= "<tr><td>KEYWORD MATCH TYPE PERFORMANCE</td><td>".$hasreports."</td><td>".$hasnoreports."</td></tr>";
    
    $html .="</table>";
    
    $html .= "<h3>Entities downloaded</h3>";
    
    $html .= "<table border=1 style=\"border-collapse : collapse ; border:1px #CCC solid;\" width=\"90%\">";
    
    $html .= "<tr><th width='50%'>Entities</th><th width='50%'>No. of new entries</th></tr>";
    
    $res2 = $main->getRow("SELECT count(*) 'new_entries' FROM `adword_accounts` WHERE `ad_mcc_id` ='".$r['customerId']."' AND `created_time` BETWEEN '".$last_friday."' AND '".$last_thursday."';");
    
    $new_entries = $res2 -> new_entries ;     
    
    $html .= "<tr bgcolor ='#DDD' ><td>Accounts</td><td>".$new_entries."</td></tr>";
    
    $res2 = $main->getRow("SELECT count(*) 'new_entries' FROM `adword_campaigns` left join adword_accounts on `adword_campaigns`.`ad_account_id` = adword_accounts.ad_account_adword_id where `adword_campaigns`. `created_time` between '".$last_friday."' and '".$last_thursday."' AND adword_accounts.ad_mcc_id ='".$r['customerId']."'");
    
    $new_entries = $res2 -> new_entries ; 
    
    $html .= "<tr><td>Campaigns</td><td>".$new_entries."</td></tr>";
    
    $res2 = $main->getRow("SELECT count(*) 'new_entries' FROM `adword_adgroups` left join `adword_accounts` on `adword_adgroups`.`ad_account_id` = `adword_accounts`.ad_account_adword_id where `adword_adgroups`. `created_time` between '".$last_friday."' and '".$last_thursday."' AND `adword_accounts`.ad_mcc_id ='".$r['customerId']."';");
    
    $new_entries = $res2 -> new_entries ; 
    
    $html .= "<tr bgcolor ='#DDD' ><td>Adgroups</td><td>".$new_entries."</td></tr>";
    
    $res2 = $main->getRow("SELECT count(*) 'new_entries' FROM `adword_keywords` left join `adword_accounts` on `adword_keywords`.`ad_account_id` = `adword_accounts`.ad_account_adword_id where `adword_keywords`. `created_time` between '".$last_friday."' and '".$last_thursday."' AND `adword_accounts`.ad_mcc_id ='".$r['customerId']."';");
    
    $new_entries = $res2 -> new_entries ; 
    
    $html .= "<tr><td>Keywords</td><td>".$new_entries."</td></tr>";
    
    $res2 = $main->getRow("
SELECT count(*) 'new_entries' FROM `adword_ads` left join `adword_accounts` on `adword_ads`.`ad_account_id` = `adword_accounts`.ad_account_adword_id where `adword_ads`. `created_time` between '".$last_friday."' and '".$last_thursday."' AND `adword_accounts`.ad_mcc_id ='".$r['customerId']."';");
    
    $new_entries = $res2 -> new_entries ; 
    
    $html .= "<tr bgcolor ='#DDD'><td>Ads</td><td>".$new_entries."</td></tr>";
    
    $html .="</table>";    
    
    
    
    $email_body = $covering . $html .$closure ;
        
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
    $mail->addAddress('rdvarmaa@gmail.com','Deepa Varma');
   // $mail->addAddress('muralihere@gmail.com', 'Murali Mohan');

    $mail->AddCC('geojose1990@gmail.com');
    
    //Set the subject line
    $mail->Subject = $subject;

    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    $mail->msgHTML($email_body, dirname(__FILE__));

    //Replace the plain text body with one created manually
    $mail->AltBody = 'This is weekly report for report downloading and entities downloading in Push Analyser';

    //Attach an image file
    //$mail->addAttachment('images/phpmailer_mini.png');

    //send the message, check for errors
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message sent!";
    }
    
    
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
		
		$sql = "SELECT count(*) cnt , count(distinct(CONCAT(`ad_account_id`,`ad_CampaignId`,`ad_AdGroupId`,`ad_KeywordId`,`ad_CreativeId`,`ad_Query`,`ad_Clicks`,`ad_Impressions`,`ad_Cost`,`ad_Ctr`,`ad_Conversions`,`ad_CostPerConversion`,`ad_AveragePosition`,`ad_ConversionValue`,`ad_MatchType`,`ad_Device`,`ad_KeywordTextMatchingQuery`))) dist , ad_Date FROM `adword_search_query_reports` WHERE `ad_Date` > '".$date."' group by `ad_Date` having cnt <> dist order by ad_Date desc";
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