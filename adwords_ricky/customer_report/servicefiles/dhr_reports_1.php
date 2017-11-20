<?php
require_once ('../../includes/includes.php');
require_once ('../../includes/classes/jpgraph/jpgraph.php');
require_once ('../../includes/classes/jpgraph/jpgraph_bar.php');

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

$dataArray = $dataArray1 = $datax =array();

foreach($results as $result){

	if($result->day <>0 )
	{
	$date = $result->ad_DayOfWeek ;

	$dataArray[] = $result->ad_Clicks ;
	$dataArray1[] = $result->ad_Conversions ;
	$datax[] = $date ;
	}
}


if(count($dataArray)<1){$dataArray = $dataArray1 = $datax =array(0);}

$datazero=array(0,0,0,0);

$graph = new Graph(500,400);
$graph->title->Set('Avg. by Day of Week');
$graph->img->SetMargin(40,40,30,50);
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
//$graph->Stroke();
$gdImgHandler = $graph->Stroke(_IMG_HANDLER);
$dailyFileName = "daily_graph_".$id."_".$startDate."_".$endDate.".png";
$graph->img->Stream("../img/".$dailyFileName);


?>