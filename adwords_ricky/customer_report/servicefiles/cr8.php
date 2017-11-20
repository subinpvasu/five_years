<?php
require_once ('../../includes/includes.php');

$id = $_SESSION['account_id'];
$startDate = $_SESSION['startDate'] ;
$endDate = $_SESSION['endDate'] ;

$sql = "SELECT ad_Date , SUM(ad_Clicks) ad_Clicks, SUM(ad_Conversions) ad_Conversions,ad_DayOfWeek , 
 
 case when ad_DayOfWeek='Sunday' then 1 
 when ad_DayOfWeek='Monday' then 2 
 when ad_DayOfWeek='Tuesday' then 3 
 when ad_DayOfWeek='Wednesday' then 4 
 when ad_DayOfWeek='Thursday' then 5 
 when ad_DayOfWeek='Friday' then 6 
 when ad_DayOfWeek='Saturday' then 7
 else 0 
 end as day
 FROM adword_campaign_reports where ad_Date BETWEEN '$startDate' AND '$endDate' and ad_account_id='$id' group by ad_DayOfWeek order by day; ";


$results = $main -> getResults($sql);

$dataArray =  array_fill(0,6,0);
$dataArray1 =  array_fill(0,6,0);



if (count($results) > 0) {
    foreach($results as $result){

		$d = $result -> day - 1 ;
		
		$dataArray[$d] = $result->ad_Clicks ;
		$dataArray1[$d] = $result->ad_Conversions ;

		
    }

    $rows = array(

    'clicks' => array_values($dataArray),
    'conversions' => array_values($dataArray1),
    'error' => 0
    );
}
else{
    $rows = array('error' => 'No results found') ;
}

print json_encode($rows, JSON_NUMERIC_CHECK); exit;