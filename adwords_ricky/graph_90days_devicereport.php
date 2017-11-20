<?php
include('includes/includes.php');

$date = date("Y-m-d", strtotime("-3 months"));  
$startDate = date("Y-m-d",strtotime('first day of this month', strtotime($date)));
$endDate = date("Y-m-d");
$id = $_SESSION['ad_account_adword_id'];
$sql = "SELECT ad_Device ,  SUM(ad_Conversions) ad_Conversions FROM adword_keyword_report1 WHERE ad_Date BETWEEN '$startDate' and '$endDate' and ad_account_id='$id' AND  ad_Device in ('Computers','Mobile devices with full browsers','Other',
'Tablets with full browsers') GROUP BY ad_Device   ";
 
$results = $main -> getResults($sql);
//print_r($results); exit;
	
$dataArray = array();

if(count($results)<1){$dataArray = array(""=>0);}
	
foreach($results as $result){
	
	$device = explode(" ",$result->ad_Device);

	$dataArray[$device[0]] = $result->ad_Conversions ;

}

//print_r($dataArray); exit;

$graph = new PHPGraphLib(500, 350);
$graph->addData($dataArray);
$graph->setTitle('Conversions For each Device');
$graph->setGradient('blue', 'blue');
$graph->createGraph();
?>