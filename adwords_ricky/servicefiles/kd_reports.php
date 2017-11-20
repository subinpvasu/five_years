<?php
require_once dirname(__FILE__) . '/../includes/includes.php';

$devices       =	$main->FormatString($_POST['devices'],1);

$error = array();


$deviceResults = $_SESSION['deviceResults'];

$str = '<table width="100%"  border="0"> ';
foreach($deviceResults as $key => $value){   
   
    if($devices == 'Select' || $value->ad_Device==$devices){
    $str .="<tr>
            <td style='width:20%; text-align:left;'>".$value->ad_Query."</td>
            <td style='width:15%; text-align:left;'>".$value->ad_CampaignName."</td>
            <td style='width:15%; text-align:left;'>".$value->ad_KeywordTextMatchingQuery."</td>
            <td style='width:5%'>".$value->ad_MatchType."</td>
            <td style='width:10%'>".$value->ad_Device."</td>
            <td style='width:5%'>".$value->ad_Clicks."</td>
            <td style='width:5%'>".$value->ad_Conversions ."</td>
            <td style='width:5%'>".round($value->ad_Cost /1000000,2)."</td>
            <td style='width:5%'>".round($value->ad_CostPerConversion  /1000000,2)."</td>
            <td style='width:5%'>".$value->ad_Impressions."</td>	
    </tr>";
    }
 } 
$str .= '</table>';
$array= array();
$array['str'] =$str ;
print json_encode($array);

?>