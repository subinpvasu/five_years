<?php
 require_once dirname(__FILE__) . '/includes/init.php';
 require_once dirname(__FILE__) . '/includes/includes.php';
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
try {

    $ysql = "TRUNCATE TABLE campaign_analysis_report";
    $main->getResults($ysql);
//7Vs7
    $firstdays = date('Y-m-d');
    $firstends = date('Y-m-d', strtotime($firstdays."-7 days"));
    $lastdays = date('Y-m-d', strtotime($firstdays."-8 days"));
    $lastends = date('Y-m-d', strtotime($firstdays."-15 days"));
//14Vs14
    $firstdayf = date('Y-m-d');
    $firstendf = date('Y-m-d', strtotime($firstdayf."-14 days"));
    $lastdayf = date('Y-m-d', strtotime($firstdayf."-15 days"));
$lastendf = date('Y-m-d', strtotime($firstdayf."-29 days"));
//30Vs30
    $firstdayt = date('Y-m-d');
    $firstendt = date('Y-m-d', strtotime($firstdayt."-30 days"));
    $lastdayt = date('Y-m-d', strtotime($firstdayt."-31 days"));
    $lastendt = date('Y-m-d', strtotime($firstdayt."-61 days"));
//7vs7
$condition01 = " WHERE created_time BETWEEN '$firstends' AND '$firstdays' AND  ad_CampaignId=a.ad_CampaignId GROUP BY ad_CampaignId ";
$condition02 = " WHERE created_time BETWEEN '$lastends'  AND '$lastdays'  AND  ad_CampaignId=a.ad_CampaignId GROUP BY ad_CampaignId ";
//14vs14
$condition11 = " WHERE created_time BETWEEN '$firstendf' AND '$firstdayf' AND  ad_CampaignId=a.ad_CampaignId GROUP BY ad_CampaignId ";
$condition12 = " WHERE created_time BETWEEN '$lastendf'  AND '$lastdayf'  AND  ad_CampaignId=a.ad_CampaignId GROUP BY ad_CampaignId ";
//30vs30
$condition21 = " WHERE created_time BETWEEN '$firstendt' AND '$firstdayt' AND  ad_CampaignId=a.ad_CampaignId GROUP BY ad_CampaignId ";
$condition22 = " WHERE created_time BETWEEN '$lastendt'  AND '$lastdayt'  AND  ad_CampaignId=a.ad_CampaignId GROUP BY ad_CampaignId ";
//Now
 $conditiona = $condition01;
 $conditionb = $condition02;
 $date_range = 7;

$thesql = "SELECT ad_account_adword_id,ad_account_currencyCode FROM adword_accounts  ORDER BY ad_account_adword_id ASC ";//limit 10
$acc_res = $main->getResults($thesql);
foreach ($acc_res as $account):
$sql = "SELECT * FROM adword_campaigns WHERE  ad_account_id=$account->ad_account_adword_id ";//limit 10
$sel_res = $main->getResults($sql);
$currency_code = $account->ad_account_currencyCode;
$oldstring = $account->ad_account_adword_id;
//$oldstring = '2987819900';
$newstr = substr_replace($oldstring, '-', 3, 0);
$string = substr_replace($newstr, '-', 7, 0);
$ksql  = "SELECT user_id_fk, user_name, client_name, report_status, Budget,remaining_budget_at_ppc_spend,
avg_daily_spends_mtd,yesterday_spends FROM management_daily_report WHERE client_id='$string' ";
$details = $main->getResults($ksql);
foreach ($sel_res as $r):

$conditiona = $condition01;
$conditionb = $condition02;
$date_range = 7;
$mysql = "SELECT ad_CampaignId,ad_CampaignName,
(SELECT SUM(ad_Clicks) FROM adword_campaign_reports $conditiona) 'visitors_current',
(SELECT SUM(ad_Clicks) FROM adword_campaign_reports $conditionb) 'visitors_last',
(SELECT SUM(ad_Cost)/SUM(ad_Clicks) FROM adword_campaign_reports $conditiona)'cpc_current',
(SELECT SUM(ad_Cost)/SUM(ad_Clicks) FROM adword_campaign_reports $conditionb)'cpc_last',
(SELECT SUM(ad_Cost) FROM adword_campaign_reports $conditiona)'spend_current',
(SELECT SUM(ad_Cost) FROM adword_campaign_reports $conditionb)'spend_last',
(SELECT SUM(ad_Conversions) FROM adword_campaign_reports $conditiona)'conversion_current',
(SELECT SUM(ad_Conversions) FROM adword_campaign_reports $conditionb)'conversion_last',
(SELECT SUM(ad_Cost)/SUM(ad_Conversions) FROM adword_campaign_reports $conditiona)'cpa_current',
(SELECT SUM(ad_Cost)/SUM(ad_Conversions) FROM adword_campaign_reports $conditionb)'cpa_last'
FROM adword_campaign_reports a WHERE ad_CampaignId=$r->ad_campaign_adword_id AND ad_Clicks>0 LIMIT 1";
$result = $main->getResults($mysql);
$now = date('Y-m-d H:i:s');
$cpc_current = $result[0]->cpc_current/1000000;
$cpc_last = $result[0]->cpc_last/1000000;
$spend_last = $result[0]->spend_last/1000000;
$spend_current = $result[0]->spend_current/1000000;
$change_in_cpc = $cpc_current-$cpc_last;
$cpa_last = $result[0]->cpa_last/1000000;
$cpa_current = $result[0]->cpa_current/1000000;
$change_in_cpa = $cpa_current-$cpa_last;
$cpc_percent = $result[0]->visitors_current/$result[0]->visitors_last*100;
$cpa_percent = $result[0]->conversion_current/$result[0]->conversion_last*100;
$budgets = $r->ad_budget/1000000;
$budget = number_format($budgets,2);
if($result[0]->visitors_current>0):
$nosql = "INSERT INTO campaign_analysis_report(user_id_fk, user_name, client_name, report_status,Budget,ppc_visitors_last_month,
                                            ppc_visitors_current_month, cpc_last_month, cpc_current_month,change_in_cpc,  ppc_spend_last_month,
                                            ppc_spend_current_month,  adwords_conversions_last_month, adwords_conversions_current_month,
                                            ppc_cpa_last_month, ppc_cpa_current_month,
                                            last_updated,client_id,remaining_budget_at_ppc_spend,avg_daily_spends_mtd,yesterday_spends,change_in_cpa,
                                            date_range,percent_at_this_point_last_month,percent_on_last_month_at_current_rate,currency_code)VALUES(".$details[0]->user_id_fk.",
                                            '".$result[0]->ad_CampaignName."','".$details[0]->client_name."','".$details[0]->report_status."','".$budget."','".$result[0]->visitors_last."','".$result[0]->visitors_current."',
                                            '".$cpc_last."','".$cpc_current."','".$change_in_cpc."','".$spend_last."','".$spend_current."',
                                            '".$result[0]->conversion_last."','".$result[0]->conversion_current."','".$cpa_last."','".$cpa_current."',
                                            '".$now."','".$string."','".$details[0]->remaining_budget_at_ppc_spend."','".$details[0]->avg_daily_spends_mtd."',
                                            '".$details[0]->yesterday_spends."','".$change_in_cpa."',".$date_range.",'".$cpc_percent."','".$cpa_percent."','".$currency_code."')";
$main->getResults($nosql);
//echo $nosql;
endif;


$conditiona = $condition11;
$conditionb = $condition12;
$date_range = 14;
$mysql = "SELECT ad_CampaignId,ad_CampaignName,
(SELECT SUM(ad_Clicks) FROM adword_campaign_reports $conditiona) 'visitors_current',
(SELECT SUM(ad_Clicks) FROM adword_campaign_reports $conditionb) 'visitors_last',
(SELECT SUM(ad_Cost)/SUM(ad_Clicks) FROM adword_campaign_reports $conditiona)'cpc_current',
(SELECT SUM(ad_Cost)/SUM(ad_Clicks) FROM adword_campaign_reports $conditionb)'cpc_last',
(SELECT SUM(ad_Cost) FROM adword_campaign_reports $conditiona)'spend_current',
(SELECT SUM(ad_Cost) FROM adword_campaign_reports $conditionb)'spend_last',
(SELECT SUM(ad_Conversions) FROM adword_campaign_reports $conditiona)'conversion_current',
(SELECT SUM(ad_Conversions) FROM adword_campaign_reports $conditionb)'conversion_last',
(SELECT SUM(ad_Cost)/SUM(ad_Conversions) FROM adword_campaign_reports $conditiona)'cpa_current',
(SELECT SUM(ad_Cost)/SUM(ad_Conversions) FROM adword_campaign_reports $conditionb)'cpa_last'
FROM adword_campaign_reports a WHERE ad_CampaignId=$r->ad_campaign_adword_id AND ad_Clicks>0 LIMIT 1";
$result = $main->getResults($mysql);
$now = date('Y-m-d H:i:s');
$cpc_current = $result[0]->cpc_current/1000000;
$cpc_last = $result[0]->cpc_last/1000000;
$spend_last = $result[0]->spend_last/1000000;
$spend_current = $result[0]->spend_current/1000000;
$change_in_cpc = $cpc_current-$cpc_last;
$cpa_last = $result[0]->cpa_last/1000000;
$cpa_current = $result[0]->cpa_current/1000000;
$change_in_cpa = $cpa_current-$cpa_last;
$cpc_percent = $result[0]->visitors_current/$result[0]->visitors_last*100;
$cpa_percent = $result[0]->conversion_current/$result[0]->conversion_last*100;
if($result[0]->visitors_current>0):
$nosql = "INSERT INTO campaign_analysis_report(user_id_fk, user_name, client_name, report_status,Budget,ppc_visitors_last_month,
                                            ppc_visitors_current_month, cpc_last_month, cpc_current_month,change_in_cpc,  ppc_spend_last_month,
                                            ppc_spend_current_month,  adwords_conversions_last_month, adwords_conversions_current_month,
                                            ppc_cpa_last_month, ppc_cpa_current_month,
                                            last_updated,client_id,remaining_budget_at_ppc_spend,avg_daily_spends_mtd,yesterday_spends,change_in_cpa,
    date_range,percent_at_this_point_last_month,percent_on_last_month_at_current_rate,currency_code)VALUES(".$details[0]->user_id_fk.",
                                            '".$result[0]->ad_CampaignName."','".$details[0]->client_name."','".$details[0]->report_status."','".$budget."','".$result[0]->visitors_last."','".$result[0]->visitors_current."',
                                            '".$cpc_last."','".$cpc_current."','".$change_in_cpc."','".$spend_last."','".$spend_current."',
                                            '".$result[0]->conversion_last."','".$result[0]->conversion_current."','".$cpa_last."','".$cpa_current."',
                                            '".$now."','".$string."','".$details[0]->remaining_budget_at_ppc_spend."','".$details[0]->avg_daily_spends_mtd."',
                                            '".$details[0]->yesterday_spends."','".$change_in_cpa."',".$date_range.",'".$cpc_percent."','".$cpa_percent."','".$currency_code."')";
$main->getResults($nosql);
//echo $nosql;//try again
endif;

$conditiona = $condition21;
$conditionb = $condition22;
$date_range = 30;
$mysql = "SELECT ad_CampaignId,ad_CampaignName,
(SELECT SUM(ad_Clicks) FROM adword_campaign_reports $conditiona) 'visitors_current',
(SELECT SUM(ad_Clicks) FROM adword_campaign_reports $conditionb) 'visitors_last',
(SELECT SUM(ad_Cost)/SUM(ad_Clicks) FROM adword_campaign_reports $conditiona)'cpc_current',
(SELECT SUM(ad_Cost)/SUM(ad_Clicks) FROM adword_campaign_reports $conditionb)'cpc_last',
(SELECT SUM(ad_Cost) FROM adword_campaign_reports $conditiona)'spend_current',
(SELECT SUM(ad_Cost) FROM adword_campaign_reports $conditionb)'spend_last',
(SELECT SUM(ad_Conversions) FROM adword_campaign_reports $conditiona)'conversion_current',
(SELECT SUM(ad_Conversions) FROM adword_campaign_reports $conditionb)'conversion_last',
(SELECT SUM(ad_Cost)/SUM(ad_Conversions) FROM adword_campaign_reports $conditiona)'cpa_current',
(SELECT SUM(ad_Cost)/SUM(ad_Conversions) FROM adword_campaign_reports $conditionb)'cpa_last'
FROM adword_campaign_reports a WHERE ad_CampaignId=$r->ad_campaign_adword_id AND ad_Clicks>0 LIMIT 1";
$result = $main->getResults($mysql);
$now = date('Y-m-d H:i:s');
$cpc_current = $result[0]->cpc_current/1000000;
$cpc_last = $result[0]->cpc_last/1000000;
$spend_last = $result[0]->spend_last/1000000;
$spend_current = $result[0]->spend_current/1000000;
$change_in_cpc = $cpc_current-$cpc_last;
$cpa_last = $result[0]->cpa_last/1000000;
$cpa_current = $result[0]->cpa_current/1000000;
$change_in_cpa = $cpa_current-$cpa_last;
$cpc_percent = $result[0]->visitors_current/$result[0]->visitors_last*100;
$cpa_percent = $result[0]->conversion_current/$result[0]->conversion_last*100;
if($result[0]->visitors_current>0):
$nosql = "INSERT INTO campaign_analysis_report(user_id_fk, user_name, client_name, report_status,Budget,ppc_visitors_last_month,
                                            ppc_visitors_current_month, cpc_last_month, cpc_current_month,change_in_cpc,  ppc_spend_last_month,
                                            ppc_spend_current_month,  adwords_conversions_last_month, adwords_conversions_current_month,
                                            ppc_cpa_last_month, ppc_cpa_current_month,
                                            last_updated,client_id,remaining_budget_at_ppc_spend,avg_daily_spends_mtd,yesterday_spends,change_in_cpa,
    date_range,percent_at_this_point_last_month,percent_on_last_month_at_current_rate,currency_code)VALUES(".$details[0]->user_id_fk.",
                                            '".$result[0]->ad_CampaignName."','".$details[0]->client_name."','".$details[0]->report_status."','".$budget."','".$result[0]->visitors_last."','".$result[0]->visitors_current."',
                                            '".$cpc_last."','".$cpc_current."','".$change_in_cpc."','".$spend_last."','".$spend_current."',
                                            '".$result[0]->conversion_last."','".$result[0]->conversion_current."','".$cpa_last."','".$cpa_current."',
                                            '".$now."','".$string."','".$details[0]->remaining_budget_at_ppc_spend."','".$details[0]->avg_daily_spends_mtd."',
                                            '".$details[0]->yesterday_spends."','".$change_in_cpa."',".$date_range.",'".$cpc_percent."','".$cpa_percent."','".$currency_code."')";
$main->getResults($nosql);
//echo $nosql;
endif;

endforeach;
endforeach;
}
catch(Exception $e)
{
    echo $e->getMessage();
}





