<?php

require_once ('../../includes/includes.php');
require_once ('../../includes/classes/jpgraph/jpgraph.php');
require_once ('../../includes/classes/jpgraph/jpgraph_bar.php');

$id = $_SESSION['account_id'];
$startDate = $_SESSION['startDate'];
$endDate = $_SESSION['endDate'];




$data = array();




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
WHERE ad_Date BETWEEN '$startDate' AND '$endDate' and ad_account_id='$id' and ad_Clicks >0 and ad_Conversions > 0
GROUP BY  `ad_HourOfDay` , ad_DayOfWeek
ORDER BY HOUR , 
DAY ;";


$results = $main->getResults($sql);

$data = array();

<<<<<<< .mine
$temp = array();
||||||| .r149
=======
$j = 0 ;
>>>>>>> .r154

<<<<<<< .mine
$khour = array();
$kday  = array();

for($l=0;$l<24;$l++)
{
    for($k=0;$k<7;$k++)
    {
        $temp[] = array($l,$k,0.00);
    }
}
$z = 0;
$lasth = 0;
$lastd = 0;
||||||| .r149
=======
for($l=0;$l<24;$l++)
{
	for($k=0;$k<7;$k++)
	{
		
		$data[$j] = array($l,$k,0.00);
		$j++;
	}
}

>>>>>>> .r154
if (count($results) > 0) {
	
    foreach ($results as $result) {
<<<<<<< .mine
        
           
                  
                  
                  if($temp[$z][0]==$result->HOUR && $temp[$z][1]==$result->DAY)
                  {
                      $data[]= array($result ->HOUR , $result ->DAY ,  $result ->convrate) ;
                      $lastd = $result->DAY;
                      $lasth = $result->HOUR;
                      $z++;
                  }
                  else
                  {
                      //add extra
                      for($m=$lastd+1;$m<$result->DAY;$m++)
                      {
                          $data[]= array($result ->HOUR , $m ,  '0.00') ;
                          $z++;
                      }
                      
                      
                       $data[]= array($result ->HOUR , $result ->DAY ,  $result ->convrate) ;
                       $lastd = $result ->DAY;
                       $z++;
                       
                  }
                  
                  
                 
||||||| .r149

        $data[]= array($result ->HOUR , $result ->DAY ,  $result ->convrate) ;
=======

		$j = 0 ;
		for($l=0;$l<24;$l++)
		{
			for($k=0;$k<7;$k++)
			{
				if($k ==$result -> DAY && $l == $result -> HOUR ){$data[$j] = array($l,$k,$result ->convrate );}
				
				$j++;
			}
		}

>>>>>>> .r154
    }
<<<<<<< .mine

    
} else {
    $rows = array('error' => 'No results found');
}
//echo count($data);
//exit();
$rows = array(
||||||| .r149

    $rows = array(
=======
$rows = array(
>>>>>>> .r154
        'convrate' => $data,
        'error' => 0
    );
<<<<<<< .mine
||||||| .r149
} else {
    $rows = array('error' => 'No results found');
}
=======
    
} else {
    $rows = array('error' => 'No results found');

}
>>>>>>> .r154
//echo count($data);
//exit();

<<<<<<< .mine

||||||| .r149
=======


>>>>>>> .r154
print json_encode($rows, JSON_NUMERIC_CHECK);
exit;
