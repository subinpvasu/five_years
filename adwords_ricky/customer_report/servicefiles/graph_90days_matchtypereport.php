<?php
include('includes/includes.php');

$date = date("Y-m-d", strtotime("-3 months"));  
$startDate = date("Y-m-d",strtotime('first day of this month', strtotime($date)));
$endDate = date("Y-m-d");
$id = $_SESSION['ad_account_adword_id'];
$sql = "SELECT ad_KeywordMatchType ,  SUM(ad_Conversions) ad_Conversions FROM adword_keyword_report1 WHERE ad_Date BETWEEN '$startDate' and '$endDate' and ad_account_id='$id' GROUP BY ad_KeywordMatchType   ";
 
$results = $main -> getResults($sql);
//print_r($results); exit;
	
foreach($results as $result){
	
	//$device = explode(" ",$result->ad_KeywordMatchType);

	$dataArray[$result->ad_KeywordMatchType] = $result->ad_Conversions ;

}

//print_r($dataArray); exit;

$graph = new PHPGraphLib(500, 350);
$graph->addData($dataArray);
$graph->setTitle('Conversions For each keyword type');
$graph->setGradient('blue', 'blue');
$graph->createGraph();
?>