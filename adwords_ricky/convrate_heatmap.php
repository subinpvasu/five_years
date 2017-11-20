<?php
include('includes/includes.php');
require_once ('includes/classes/jpgraph/jpgraph.php');
require_once ('includes/classes/jpgraph/jpgraph_bar.php');

$id = $_SESSION['ad_account_adword_id'];

$endDate = date("Y-m-d", strtotime("-1 days"));

$startDate = date("Y-m-d", strtotime("-30 days")); 

$sql = "SELECT ROUND( (
SUM( ad_Conversions ) *100 ) / SUM( ad_Clicks ) , 2
) AS convrate, ad_DayOfWeek,  `ad_HourOfDay` HOUR , 
CASE 
WHEN ad_DayOfWeek =  'Monday'
THEN 0 
WHEN ad_DayOfWeek =  'Tuesday'
THEN 1 
WHEN ad_DayOfWeek =  'Wednesday'
THEN 2 
WHEN ad_DayOfWeek =  'Thursday'
THEN 3 
WHEN ad_DayOfWeek =  'Friday'
THEN 4 
WHEN ad_DayOfWeek =  'Saturday'
THEN 5 
WHEN ad_DayOfWeek =  'Sunday'
THEN 6 
END AS 
DAY 
FROM adword_campaign_reports
WHERE ad_Date BETWEEN '$startDate' AND '$endDate' and ad_account_id='$id' and ad_account_id='$id' and ad_Clicks >0 and ad_Conversions > 0
GROUP BY  `ad_HourOfDay` , ad_DayOfWeek
ORDER BY HOUR , 
DAY ;";


$results = $main->getResults($sql);

$data = array();

$j = 0 ;

for($l=0;$l<24;$l++)
{
	for($k=0;$k<7;$k++)
	{
		
		$data[$j] = array($l,$k,0.00);
		$j++;
	}
}

if (count($results) > 0) {
	
    foreach ($results as $result) {

		$j = 0 ;
		for($l=0;$l<24;$l++)
		{
			for($k=0;$k<7;$k++)
			{
				if($k ==$result -> DAY && $l == $result -> HOUR ){$data[$j] = array($l,$k,$result ->convrate );}
				
				$j++;
			}
		}

    }
$rows = array(
        'convrate' => $data,
        'error' => 0
    );
    
} else {
    $rows = array('error' => 'No results found');

}
//echo count($data);
//exit();



print json_encode($rows, JSON_NUMERIC_CHECK);
exit;


?>