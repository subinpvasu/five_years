<?php

/*

 *
 * Service file for showing customer report

 * Conversion Share.current month
 *

 */




require_once dirname(__FILE__) . '/../../includes/includes.php';
$id = $_SESSION['account_id'];
$startDate = $_SESSION['startDate'];
$endDate = $_SESSION['endDate'];


$sql = "select sum(ad_Conversions) sum from adword_campaign_reports where ad_account_id='$id' and ad_Date BETWEEN '$startDate' and '$endDate'";

$result = $main->getRow($sql);

$total = $result->sum;


$sql1 = "select sum(ad_Conversions) sum ,`ad_CampaignName`  from adword_campaign_reports where ad_account_id='$id' and ad_Date BETWEEN '$startDate' and '$endDate' AND ad_Conversions > 0 GROUP BY ad_CampaignName ORDER BY sum desc LIMIT 9";


$results = $main->getResults($sql1);

//print_r($results);

$per = 0;

$rows = array();

if (count($results) > 0) {

    foreach ($results as $res) {

        $percentage = round(($res->sum / $total ) * 100, 2);

        //$rows[] = array($res->ad_CampaignName,$percentage);
        $rows[] = array($res->ad_CampaignName . ": $percentage%", $percentage);



        $per = $per + $percentage;
    }



    $bal = 100 - $per;

    if ($bal > 0) 
        $rows[] = array("Others: $bal%", $bal);
    
}
else{ $rows = array('error'=>1);}

print json_encode($rows, JSON_NUMERIC_CHECK);
exit;
