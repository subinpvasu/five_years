<?php

require_once ('../../includes/includes.php');
require_once ('../../includes/classes/jpgraph/jpgraph.php');
require_once ('../../includes/classes/jpgraph/jpgraph_bar.php');

$id = $_SESSION['account_id'];
$startDate = $_SESSION['startDate'];
$endDate = $_SESSION['endDate'];


$sql = "SELECT ad_Date , SUM(ad_Clicks) ad_Clicks, SUM(ad_Conversions) ad_Conversions,ad_HourOfDay FROM adword_campaign_reports where ad_Date BETWEEN '$startDate' AND '$endDate' and ad_account_id='$id'  group by ad_HourOfDay order by ad_HourOfDay ";

$results = $main->getResults($sql);

$dataY1 = $dataY2 = array_fill(0,23,0);
if (count($results) > 0) {
    foreach ($results as $result) {

        $date = $result->ad_HourOfDay;

        $dataY1[$date] = $result->ad_Clicks;
        $dataY2[$date] = $result->ad_Conversions;
    }

    $rows = array(
        'clicks' => array_values($dataY1),
        'conversions' => array_values($dataY2),
        'error' => 0
    );
} else {
    $rows = array('error' => 'No results found');
}

print json_encode($rows, JSON_NUMERIC_CHECK);
exit;
