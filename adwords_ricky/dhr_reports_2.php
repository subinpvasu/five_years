<?php
include('includes/includes.php');
require_once ('includes/classes/jpgraph/jpgraph.php');
require_once ('includes/classes/jpgraph/jpgraph_bar.php');

$endDate = date("Y-m-d", strtotime("-1 days"));

$startDate = date("Y-m-d", strtotime("-30 days"));
 
$id = $_SESSION['ad_account_adword_id'];


$sql = "SELECT ad_Date , SUM(ad_Clicks) ad_Clicks, SUM(ad_Conversions) ad_Conversions,ad_HourOfDay FROM adword_campaign_reports where ad_Date BETWEEN '$startDate' AND '$endDate' and ad_account_id='$id'  group by ad_HourOfDay order by ad_HourOfDay ";

$results = $main -> getResults($sql);

$dataY1 = $dataY2 = array_fill(0,23,0);

foreach($results as $result){

	$date = $result->ad_HourOfDay ;

	$dataY1[$date] = $result->ad_Clicks ;
	$dataY2[$date] = $result->ad_Conversions ;
	
}

$rows = array(

'clicks' => $dataY1,
'conversions' => $dataY2

);

print json_encode($rows, JSON_NUMERIC_CHECK); exit;

$sql = "SELECT ad_Date , SUM(ad_Clicks) ad_Clicks, SUM(ad_Conversions) ad_Conversions,ad_HourOfDay FROM adword_campaign_reports where ad_Date BETWEEN '$startDate' AND '$endDate' and ad_account_id='$id'  group by ad_HourOfDay order by ad_HourOfDay ";

$results = $main -> getResults($sql);

$dataArray = $dataArray1 = $datax =array();


foreach($results as $result){

	$date = $result->ad_HourOfDay ;

	$dataArray[] = $result->ad_Clicks ;
	$dataArray1[] = $result->ad_Conversions ;
	$datax[] = $date ;
}

if(count($dataArray)<1){$dataArray = $dataArray1 = $datax =array(0);}
/* echo "<pre>";print_r($dataArray); echo "</pre>"; 
echo "<pre>";print_r($dataArray1); echo "</pre>"; 
echo "<pre>";print_r($datax); echo "</pre>"; 


exit; */

/* $graph = new PHPGraphLib(500, 350);
$graph->addData($dataArray,$dataArray1);
$graph->setTitle('Avg. by Day of Week');
$graph->setBarColor('green', 'blue');
$graph->setLegendTitle('Clicks', 'Conv.');
$graph->setupYAxis(12, 'blue');
$graph->setupXAxis(20);
$graph->setGrid(false);
$graph->setLegend(true);
$graph->setXValuesHorizontal(true);
$graph->createGraph(); */

$datazero=array(0,0,0,0);

$graph = new Graph(500,400);
$graph->title->Set('Avg. by Day of Week');
$graph->img->SetMargin(40,30,30,40);
// Setup Y and Y2 scales with some "grace"	
$graph->SetScale("textlin");
$graph->SetY2Scale("lin");
$graph->yaxis->scale->SetGrace(30);
$graph->y2axis->scale->SetGrace(30);

//$graph->ygrid->Show(true,true);
$graph->ygrid->SetColor('#0000ff','lightgray@0.5');

// Setup graph colors
$graph->SetMarginColor('gray');
$graph->y2axis->SetColor('#0000ff');
$graph->yaxis->SetColor('green');
	

// Create the "dummy" 0 bplot
$bplotzero = new BarPlot($datazero);

// Create the "Y" axis group
$ybplot1 = new BarPlot($dataArray);
//$ybplot1->value->Show();
$ybplot1->value->SetColor('green');
$ybplot1->SetFillColor('green');
$ybplot1->SetWidth(0.6);
$ybplot1->SetLegend("Clicks","green");
$ybplot = new GroupBarPlot(array($ybplot1,$bplotzero));

// Create the "Y2" axis group
$ybplot2 = new BarPlot($dataArray1);
//$ybplot2->value->Show();
$ybplot2->value->SetColor('#0000ff');
$ybplot2->SetFillColor('#0000ff');
$ybplot2->SetWidth(0.6);
$ybplot2->SetLegend("Conversions","#0000ff");
$y2bplot = new GroupBarPlot(array($bplotzero,$ybplot2));

// Setup X-axis labels
$graph->xaxis->SetTickLabels($datax);
//$graph->xaxis->SetLabelAngle(50);


// Add the grouped bar plots to the graph
$graph->Add($ybplot);
$graph->AddY2($y2bplot);

// .. and finally stroke the image back to browser
$graph->Stroke();



?>