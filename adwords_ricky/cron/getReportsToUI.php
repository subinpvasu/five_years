<?php
require_once dirname(__FILE__) . '/../includes/init.php';
require_once dirname(__FILE__) . '/../includes/includes.php';

try{

	$sql_mcc_select = "SELECT customerId,prospect_account FROM adword_mcc_accounts WHERE prospect_account <> '10' order by mcc_id desc ";

	$res_mcc_selects = $main -> getResults($sql_mcc_select);

	foreach($res_mcc_selects as $res_mcc_select){

		if($res_mcc_select->prospect_account ==0):

			$dbName = DB_DATABASE ;

		else :

			$dbName = DB_DATABASE_PROSPECT ;

		endif;

	$main -> Select($dbName) ;

	$customerId = $res_mcc_select ->customerId ;



	$sql = " select ad_account_adword_id from adword_accounts where ad_account_status=1 and ad_mcc_id='$customerId'";

	$results = $main->getResults($sql);

	foreach($results as $result){

		$ad_account_adword_id = $result->ad_account_adword_id;

	//	echo "Start ".date("Y-m-d H:i:s")." \t \n" ;

	/*

	CONVERSION BOOSTER REPORT FOR LAST 3 MONTHS

	*/

		$startDate = date("Y-m-d", strtotime("-3 months"));
		$endDate = date("Y-m-d");
		$type =1 ;
		$month = date("Y-m-d");
		$cbr = $main->getConversionBoosterReport($ad_account_adword_id,$type,$month,$startDate,$endDate);

		if($cbr){

			$yesterday = date("Y-m-d", strtotime("-1 day"));
			$main->deleteReport("adword_ConversionBoosterReport","ad_CBreport_type",$type,$yesterday,$ad_account_adword_id);
		}
		else{
			echo "Not Executed \t \n" ;
		}

	/*

	CONVERSION BOOSTER REPORT FOR CURRENT MONTH

	*/

		$startDate = date("Y-m-d",strtotime('first day of this month', strtotime("-1 month")));
		$endDate = date("Y-m-d");
		$type =2 ;
		$month = date("Y-m-d");
		$cbr = $main->getConversionBoosterReport($ad_account_adword_id,$type,$month,$startDate,$endDate);

		if($cbr){

			$yesterday = date("Y-m-d", strtotime("-1 day"));
			$main->deleteReport("adword_ConversionBoosterReport","ad_CBreport_type",$type,$yesterday,$ad_account_adword_id);
		}
		else{
			echo "Not Executed \t \n" ;
		}
	/*

	CONVERSION BOOSTER REPORT FOR LAST MONTH

	*/

		if(date('j')> 1){

			$startDate = date("Y-m-d",strtotime('first day of this month', strtotime("-1 month")));
			$endDate = date("Y-m-d",strtotime('last day of this month', strtotime("-1 month")));;
			$type =3 ;
			$month = date("Y-m",strtotime("-1 month"));

			$duplicate = $main->checkDuplicate("adword_ConversionBoosterReport","ad_CBreport_type",$type,$month,$ad_account_adword_id);
			if(!$duplicate){

				$cbr = $main->getConversionBoosterReport($ad_account_adword_id,$type,$month,$startDate,$endDate);
			}

		}


	/*************************************************************************************/
	/*

	AD LABEL REPORT FOR LAST 30 Days

	*/

		$startDate = date("Y-m-d", strtotime("-30 days"));
		$endDate = date("Y-m-d");
		$type =1 ;
		$month = date("Y-m-d");
		$cbr = $main->getAdLabelReport($ad_account_adword_id,$type,$month,$startDate,$endDate);

		if($cbr){

			$yesterday = date("Y-m-d", strtotime("-1 day"));
			$main->deleteReport("ad_AdLabelReport","ad_ALreport_type",$type,$yesterday,$ad_account_adword_id);
		}
		else{
			echo "Not Executed \t \n" ;
		}



	/*

	AD LABEL REPORT FOR CURRENT MONTH

	*/
		$startDate = date("Y-m-d",strtotime('first day of this month', time()));
		$endDate = date("Y-m-d");
		$type =2 ;
		$month = date("Y-m-d");
		$cbr = $main->getAdLabelReport($ad_account_adword_id,$type,$month,$startDate,$endDate);

		if($cbr){

			$yesterday = date("Y-m-d", strtotime("-1 day"));
			$main->deleteReport("ad_AdLabelReport","ad_ALreport_type",$type,$yesterday,$ad_account_adword_id);
		}
		else{
			echo "Not Executed \t \n" ;
		}
	/*

	AD LABEL REPORT FOR LAST MONTH

	*/

		if(date('j')> 1){

			$startDate = date("Y-m-d",strtotime('first day of this month', strtotime("-1 month")));
			$endDate = date("Y-m-d",strtotime('last day of this month', strtotime("-1 month")));;
			$type =3 ;
			$month = date("Y-m",strtotime("-1 month"));
                        $main->deleteReport("ad_AdLabelReport","ad_ALreport_type",$type,$month,$ad_account_adword_id);
			$duplicate = $main->checkDuplicate("ad_AdLabelReport","ad_ALreport_type",$type,$month,$ad_account_adword_id);
			if(!$duplicate){

				$cbr = $main->getAdLabelReport($ad_account_adword_id,$type,$month,$startDate,$endDate);
			}

		}


	/*************************************************************************************/


	/*

	WASTAGE ANALYSIS FOR LAST 30 Days

	*/


		$startDate = date("Y-m-d", strtotime("-30 days"));
		$endDate = date("Y-m-d");
		$type =1 ;
		$month = date("Y-m-d");
		$cbr = $main->getWastageAnalysisReport($ad_account_adword_id,$type,$month,$startDate,$endDate);

		if($cbr){

			$yesterday = date("Y-m-d", strtotime("-1 day"));
			$main->deleteReport("adword_WastageAnalysis","ad_WAReport_type",$type,$yesterday,$ad_account_adword_id);
		}
		else{
			echo "Not Executed \t \n" ;
		}



	/*

	WASTAGE ANALYSIS  FOR CURRENT MONTH

	*/
		$startDate = date("Y-m-d",strtotime('first day of this month', time()));
		$endDate = date("Y-m-d");
		$type =2 ;
		$month = date("Y-m-d");
		$cbr = $main->getWastageAnalysisReport($ad_account_adword_id,$type,$month,$startDate,$endDate);

		if($cbr){

			$yesterday = date("Y-m-d", strtotime("-1 day"));
			$main->deleteReport("adword_WastageAnalysis","ad_WAReport_type",$type,$yesterday,$ad_account_adword_id);
		}
		else{
			echo "Not Executed \t \n" ;
		}
	/*

	WASTAGE ANALYSIS FOR LAST MONTH

	*/

		if(date('j')> 1){

			$startDate = date("Y-m-d",strtotime('first day of this month', strtotime("-1 month")));
			$endDate = date("Y-m-d",strtotime('last day of this month', strtotime("-1 month")));;
			$type =3 ;
			$month = date("Y-m",strtotime("-1 month"));

			$duplicate = $main->checkDuplicate("adword_WastageAnalysis","ad_WAReport_type",$type,$month,$ad_account_adword_id);
			if(!$duplicate){

				$cbr = $main->getWastageAnalysisReport($ad_account_adword_id,$type,$month,$startDate,$endDate);
			}

		}


	/*************************************************************************************/
		/*

	KEYWORD DISCOVERY FOR LAST 30 Days

	*/
		$startDate = date("Y-m-d", strtotime("-30 days"));
		$endDate = date("Y-m-d");
		$type =1 ;
		$month = date("Y-m-d");
		$cbr = $main->getKeywordDiscoveryReport($ad_account_adword_id,$type,$month,$startDate,$endDate);

		if($cbr){

			$yesterday = date("Y-m-d", strtotime("-1 day"));
			$main->deleteReport("adword_KeywordDiscovery","ad_KDReport_type",$type,$yesterday,$ad_account_adword_id);
		}
		else{
			echo "Not Executed \t \n" ;
		}


	/*

	KEYWORD DISCOVERY  FOR CURRENT MONTH

	*/
		$startDate = date("Y-m-d",strtotime('first day of this month', time()));
		$endDate = date("Y-m-d");
		$type =2 ;
		$month = date("Y-m-d");
		$cbr = $main->getKeywordDiscoveryReport($ad_account_adword_id,$type,$month,$startDate,$endDate);

		if($cbr){

			$yesterday = date("Y-m-d", strtotime("-1 day"));
			$main->deleteReport("adword_KeywordDiscovery","ad_KDReport_type",$type,$yesterday,$ad_account_adword_id);
		}
		else{
			echo "Not Executed \t \n" ;
		}

		/*

	WASTAGE ANALYSIS  FOR CURRENT MONTH

	*/
		$startDate = date("Y-m-d",strtotime('first day of this month', time()));
		$endDate = date("Y-m-d");
		$type =2 ;
		$month = date("Y-m-d");
		$cbr = $main->getKeywordDiscoveryReport($ad_account_adword_id,$type,$month,$startDate,$endDate);

		if($cbr){

			$yesterday = date("Y-m-d", strtotime("-1 day"));
			$main->deleteReport("adword_KeywordDiscovery","ad_KDReport_type",$type,$yesterday,$ad_account_adword_id);
		}
		else{
			echo "Not Executed \t \n" ;
		}
	/*

	KEYWORD DISCOVERY FOR LAST MONTH

	*/

		if(date('j')> 1){

			$startDate = date("Y-m-d",strtotime('first day of this month', strtotime("-1 month")));
			$endDate = date("Y-m-d",strtotime('last day of this month', strtotime("-1 month")));;
			$type =3 ;
			$month = date("Y-m",strtotime("-1 month"));

			$duplicate = $main->checkDuplicate("adword_KeywordDiscovery","ad_KDReport_type",$type,$month,$ad_account_adword_id);
			if(!$duplicate){

				$cbr = $main->getKeywordDiscoveryReport($ad_account_adword_id,$type,$month,$startDate,$endDate);
			}

		}



	/*************************************************************************************/


	$id = $ad_account_adword_id;
    $startDate = date("Y-m-d", strtotime("-3 months"));
    $endDate = date("Y-m-d",strtotime("-1 days"));
	$count = $main->getRow("SELECT SUM(ad_Conversions) as sum FROM adword_keyword_report1 WHERE ad_account_id='".$id."' and ad_Date BETWEEN '".$startDate."' AND '".$endDate."' and ad_Conversions <> 0") ;
	$count=$count->sum ;
	$sql = "SELECT `ad_CampaignName`,`ad_AdGroupName`,`ad_KeywordText`,ad_KeywordMatchType,ROUND((SUM(ad_Clicks)/SUM(ad_Impressions)*100),2) Ctr, SUM(`ad_Clicks`) ad_Clicks,SUM(`ad_Impressions`) ad_Impressions ,ROUND(SUM(`ad_Cost`)/1000000,2) ad_Cost , SUM(`ad_Conversions`) ad_convers , ROUND((SUM(ad_Conversions)/SUM(ad_Clicks))*100,2) ad_ConversionRate , ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion ,ROUND(AVG(ad_AveragePosition),2) as ad_AveragePosition , SUM(ad_FirstPageCpc) as ad_FirstPageCpc,SUM(ad_TopOfPageCpc) ad_TopOfPageCpc  ,SUM(ad_ConversionValue) as ad_ConversionValue ,ad_Keyword_Id,ad_AdGroupId,ad_CampaignId
	FROM `adword_keyword_report1`
	WHERE `ad_Date` BETWEEN '$startDate' AND '$endDate' AND ad_account_id='$id'  GROUP BY adword_keyword_report1.`ad_Keyword_Id`,`ad_CampaignId`,`ad_AdGroupId`  order by `ad_convers` desc LIMIT 25
	";
	$results = $main->getResults($sql);
	$ad_Conversions=0;
    foreach($results as $result){
		$sel = "select ad_QualityScore,ad_keyword_adword_status FROM adword_keywords where adword_keywords.ad_keyword_adword_id = '".$result->ad_Keyword_Id."' AND adword_keywords.ad_adgroup_adword_id = '".$result->ad_AdGroupId."' AND adword_keywords.ad_campaign_adword_id = '".$result->ad_CampaignId."' and ad_keyword_adword_status='ENABLED'";
		$sel_res = $main->getRow($sel);

		if(count($sel_res)>0){
			$ad_FirstPageCpc = round($result -> ad_FirstPageCpc / 100000000, 2);
			$ad_TopOfPageCpc = round($result -> ad_TopOfPageCpc / 100000000, 2);
			if($ad_Conversions > ($count * .8) ) { break ;}
			$ad_Conversions += $result -> ad_convers ;
			$ad_AveragePosition = $result -> ad_AveragePosition;
			$query = "INSERT INTO reports_80_20 (`added_date`, `ad_account_id`, `ad_CampaignName`, `ad_AdGroupName`, `ad_KeywordText`, `ad_KeywordMatchType`, `ad_Clicks`, `ad_Impressions`, `Ctr`, `ad_AveragePosition`, `ad_Cost`, `ad_convers`, `ad_ConversionRate`, `ad_CostPerConversion`, `ad_QualityScore`, `ad_FirstPageCpc`, `ad_TopOfPageCpc`)
			VALUES ('".$current_day." ', '".$id."','".$result -> ad_CampaignName."', '".$result -> ad_AdGroupName."', '".$result -> ad_KeywordText."',
			'".$result -> ad_KeywordMatchType."', '".$result -> ad_Clicks."', '".$result -> ad_Impressions."', '".$result -> Ctr."',
			'".$ad_AveragePosition."', '".$result -> ad_Cost."', '".$result -> ad_convers."', '".$result -> ad_ConversionRate."',
			'".$result ->ad_CostPerConversion."', '".$sel_res -> ad_QualityScore."', '".$ad_FirstPageCpc."', '".$ad_TopOfPageCpc."')";
		}
	}
	/*************************************************************************************/
	
		

	echo "Stop ".date("Y-m-d H:i:s")." \t \n" ;


	}

	}
	/*
	 * ADD 80/20 REPORT STO TABLE AND DISPLAY FROM THERE ACCORDING TO EACH ACCOUNT.
	 */
$mysql = "TRUNCATE TABLE conversions_eight_two";
        $main->getResults($mysql);

        $nosql = "SELECT ad_account_adword_id FROM `adword_accounts` ORDER BY ad_account_adword_id ASC";
        $result =  $main->getResults($nosql);

        foreach($result as $key)
        {



	    $startDate = date("Y-m-d", strtotime("-3 months"));
        $endDate = date("Y-m-d",strtotime("-1 days"));

        $sql = "SELECT `ad_CampaignName`,`ad_AdGroupName`,`ad_KeywordText`,ad_KeywordMatchType,ROUND((SUM(ad_Clicks)/SUM(ad_Impressions)*100),2) Ctr,
        SUM(`ad_Clicks`) ad_Clicks,SUM(`ad_Impressions`) ad_Impressions ,ROUND(SUM(`ad_Cost`)/1000000,2) ad_Cost , SUM(`ad_Conversions`) ad_convers ,
        ROUND((SUM(ad_Conversions)/SUM(ad_Clicks))*100,2) ad_ConversionRate , ROUND(((SUM(`ad_Cost`)/SUM(`ad_Conversions`))/1000000),2) as ad_CostPerConversion,
        ROUND(AVG(ad_AveragePosition),2) as ad_AveragePosition , SUM(ad_FirstPageCpc) as ad_FirstPageCpc,SUM(ad_TopOfPageCpc) ad_TopOfPageCpc  ,
        SUM(ad_ConversionValue) as ad_ConversionValue ,ad_Keyword_Id,ad_AdGroupId,ad_CampaignId,ad_account_id
        FROM `adword_keyword_report1`
        WHERE `ad_Date` BETWEEN '$startDate' AND '$endDate' AND ad_account_id='$key->ad_account_adword_id' GROUP BY adword_keyword_report1.`ad_Keyword_Id`,`ad_CampaignId`,
        `ad_AdGroupId`  order by `ad_convers` ";

        $results = $main->getResults($sql);

        $ad_Conversions=0;
$i=0;
        foreach($results as $result){



            $sel = "select ad_QualityScore,ad_keyword_adword_status FROM adword_keywords where adword_keywords.ad_keyword_adword_id = '".$result->ad_Keyword_Id."'
	    AND ad_keyword_adword_status='ENABLED'";
         $sel_res = $main->getRow($sel);
		//print_r($sel_res);
         if(count($sel_res)>0){

                $ad_FirstPageCpc = round($result -> ad_FirstPageCpc / 100000000, 2);
                $ad_TopOfPageCpc = round($result -> ad_TopOfPageCpc / 100000000, 2);
                if($ad_Conversions > ($count * .8) ) {echo 'heres'; break ;}
                $ad_Conversions += $result -> ad_convers ;

        //        print_r($result);

$ksql = "INSERT INTO conversions_eight_two( ad_account_id, campaign_name, adgroup_name, keyword_text, match_type, clicks, impr, ctr, avg_position, cost,
    conv, conv_rate, cost_conv, qs, first_page_cpc, top_page_cpc) VALUES($key->ad_account_adword_id,'$result->ad_CampaignName','$result->ad_AdGroupName',
    '$result->ad_KeywordText','$result->ad_KeywordMatchType','$result->ad_Clicks','$result->ad_Impressions','$result->Ctr','round($result->ad_AveragePosition, 2)',
'$result->ad_Cost','$result->ad_convers','$result->ad_ConversionRate','$result->ad_CostPerConversion','$sel_res->ad_QualityScore','$ad_FirstPageCpc','$ad_TopOfPageCpc')";
  $main->getResults($ksql);
  // mysql_query($ksql) or die(mysql_error());
         $i++;
if($i>24){break;}

            }



      }


        }


        /**
         * campaign analysis reprt is storing data from here.
         * subinpvasu
         */
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

$thesql = "SELECT ad_account_adword_id,ad_account_currencyCode FROM adword_accounts  ORDER BY ad_account_adword_id ASC  ";//limit 10
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
endif;

endforeach;
endforeach;
}
catch(Exception $e){

	echo "ERROR,".$e->getCode().",".$e->getMessage()."\t \n" ;
	//exit;

}

?>